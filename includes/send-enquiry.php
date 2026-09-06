<?php
/**
 * Contact Us enquiry form handler.
 * Validates and sanitizes the POST, then sends the enquiry via Brevo's
 * Transactional Email API (see sendemail.php). Always finishes with a
 * redirect back to contact.php (POST -> Redirect -> GET) so a page refresh
 * can never resubmit the form.
 */

define('KHOT_APP_ENTRY', true);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/package-data.php';
require_once __DIR__ . '/sendemail.php';
require_once __DIR__ . '/recaptcha.php';

function reject(string $reason, string $status = 'validation_error'): void
{
    error_log('Enquiry rejected: ' . $reason);
    $_SESSION['enquiry_status'] = $status;
    header('Location: ../contact.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact.php');
    exit;
}

// CSRF check
if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    reject('csrf_mismatch');
}

// Honeypot — bots tend to fill hidden fields
if (!empty($_POST['website'])) {
    reject('honeypot_triggered');
}

// Google reCAPTCHA v2
$recaptchaToken = (string) filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_UNSAFE_RAW);
if (!verify_recaptcha($recaptchaToken, $_SERVER['REMOTE_ADDR'] ?? '')) {
    reject('recaptcha_failed');
}

// Simple session-based rate limiting: max 5 submissions per 10 minutes
$now = time();
$_SESSION['enquiry_log'] = array_filter($_SESSION['enquiry_log'] ?? [], fn($t) => $t > $now - 600);
if (count($_SESSION['enquiry_log']) >= 5) {
    reject('rate_limited');
}

/** Trims a posted field and strips control characters (CR/LF etc.) that have no business in a single-line value. */
function clean_line(string $key): string
{
    $value = trim((string) filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW) ?? '');
    return preg_replace('/[\r\n\x00-\x1F]+/', ' ', $value);
}

/** Like clean_line() but preserves newlines, for the free-text message field. */
function clean_text(string $key): string
{
    $value = trim((string) filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW) ?? '');
    return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]+/', '', $value);
}

$name        = clean_line('name');
$email       = clean_line('email');
$mobile      = clean_line('mobile');
$country     = clean_line('country');
$travelDate  = clean_line('travel_date');
$travellers  = clean_line('travellers');
$destination = clean_line('destination');
$packageSlug = clean_line('package');
$message     = clean_text('message');

if ($name === '' || $mobile === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    reject('validation_failed');
}

// The package field is a <select> of slugs — resolve it to its human title
// for the subject line and email body.
$packageLabel = '';
foreach ($packages as $p) {
    if ($p['slug'] === $packageSlug) {
        $packageLabel = $p['title_en'];
        break;
    }
}

$fields = [
    'Name'                    => $name,
    'Email'                   => $email,
    'Mobile / Phone'          => $mobile,
    'Country'                 => $country,
    'Travel Date'             => $travelDate,
    'Number of Travellers'    => $travellers,
    'Interested Destination'  => $destination,
    'Package / Tour'          => $packageLabel,
    'Message'                 => $message,
];

$sent = send_enquiry_via_brevo([
    'name'          => $name,
    'email'         => $email,
    'subject_label' => $packageLabel,
    'fields'        => $fields,
]);

$_SESSION['enquiry_log'][] = $now;

if (!$sent) {
    reject('brevo_send_failed', 'send_error');
}

$_SESSION['enquiry_status'] = 'success';
header('Location: ../contact.php');
exit;
