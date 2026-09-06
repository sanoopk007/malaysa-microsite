<?php
/**
 * Brevo Transactional Email API mailer for the Contact Us enquiry form.
 * Only ever required by includes/send-enquiry.php — never loaded on a
 * normal page request, and never reachable directly from the browser.
 */

if (!defined('KHOT_APP_ENTRY')) {
    http_response_code(403);
    exit;
}

require_once __DIR__ . '/config.php';

$__brevoSecretFile = __DIR__ . '/brevo-secret.php';
if (is_file($__brevoSecretFile)) {
    require_once $__brevoSecretFile;
}

/** Resolves the Brevo API key from the environment first, then the local fallback file. */
function brevo_api_key(): string
{
    $fromEnv = getenv('BREVO_API_KEY');
    if ($fromEnv !== false && $fromEnv !== '') {
        return $fromEnv;
    }
    return defined('BREVO_API_KEY_FALLBACK') ? BREVO_API_KEY_FALLBACK : '';
}

function enquiry_html_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Builds the HTML body for the enquiry notification email. $fields is an
 * ordered [label => value] map; empty values are skipped so optional form
 * fields the visitor left blank don't render as empty rows.
 */
function build_enquiry_email_html(array $fields, string $submittedAt): string
{
    $rowsHtml = '';
    foreach ($fields as $label => $value) {
        $value = (string) $value;
        if ($value === '') {
            continue;
        }
        $safeLabel = enquiry_html_escape($label);
        $safeValue = nl2br(enquiry_html_escape($value));
        $rowsHtml .= '<tr>'
            . '<td style="padding:10px 14px;border:1px solid #e5e0d8;background:#faf7f2;font-weight:600;color:#1c3d2e;white-space:nowrap;vertical-align:top;">' . $safeLabel . '</td>'
            . '<td style="padding:10px 14px;border:1px solid #e5e0d8;color:#1c1c1c;">' . $safeValue . '</td>'
            . '</tr>';
    }

    $safeSubmittedAt = enquiry_html_escape($submittedAt);

    return '<div style="font-family:Arial,Helvetica,sans-serif;max-width:640px;margin:0 auto;color:#1c1c1c;">'
        . '<div style="background:#0f3d2e;padding:20px 24px;">'
        . '<h1 style="color:#ffffff;font-size:18px;margin:0;">New Malaysia Website Enquiry</h1>'
        . '</div>'
        . '<div style="padding:20px 24px;">'
        . '<table style="border-collapse:collapse;width:100%;font-size:14px;">' . $rowsHtml . '</table>'
        . '<p style="margin-top:24px;font-size:12px;color:#777777;line-height:1.6;">'
        . 'Source: Malaysia Tourism Microsite<br>'
        . 'Website: <a href="https://malaysia.khimjistravel.com/" style="color:#0f3d2e;">https://malaysia.khimjistravel.com/</a><br>'
        . 'Submitted: ' . $safeSubmittedAt
        . '</p>'
        . '</div>'
        . '</div>';
}

/**
 * Sends the enquiry via Brevo's Transactional Email API.
 *
 * $data must contain: name, email, subject_label (package/subject text, may
 * be ''), and fields (the ordered [label => value] map for the email body).
 *
 * Returns true only when Brevo accepts the request (HTTP 2xx). Never
 * throws and never includes the API key or response body in anything
 * returned to the caller; failures are written to the PHP error log only.
 */
function send_enquiry_via_brevo(array $data): bool
{
    global $config;

    $apiKey = brevo_api_key();
    if ($apiKey === '') {
        error_log('Enquiry mail: Brevo API key is not configured');
        return false;
    }

    $subject = $data['subject_label'] !== ''
        ? 'Malaysia Enquiry - ' . $data['subject_label'] . ' - ' . $data['name']
        : 'Malaysia Website Enquiry - ' . $data['name'];

    $submittedAt = date('d M Y, H:i T');

    $payload = [
        'sender' => [
            'email' => $config['brevo_sender_email'],
            'name'  => $config['brevo_sender_name'],
        ],
        'to' => [
            ['email' => $config['brevo_to_email']],
        ],
        'cc' => [
            ['email' => $config['brevo_cc_email']],
        ],
        'replyTo' => [
            'email' => $data['email'],
            'name'  => $data['name'] !== '' ? $data['name'] : $data['email'],
        ],
        'subject'     => $subject,
        'htmlContent' => build_enquiry_email_html($data['fields'], $submittedAt),
    ];

    $ch = curl_init('https://api.brevo.com/v3/smtp/email');
    if ($ch === false) {
        error_log('Enquiry mail: failed to initialise cURL');
        return false;
    }

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'accept: application/json',
            'api-key: ' . $apiKey,
            'content-type: application/json',
        ],
        CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_CONNECTTIMEOUT => 8,
    ]);

    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErrno = curl_errno($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlErrno !== 0) {
        error_log('Enquiry mail: Brevo request failed (cURL error ' . $curlErrno . ': ' . $curlError . ')');
        return false;
    }

    if ($httpCode < 200 || $httpCode >= 300) {
        error_log('Enquiry mail: Brevo rejected the request (HTTP ' . $httpCode . ')');
        return false;
    }

    return true;
}
