<?php
/**
 * Google reCAPTCHA v2 server-side verification for the Contact Us enquiry
 * form. Only ever required by includes/send-enquiry.php — never loaded on
 * a normal page request, and never reachable directly from the browser.
 */

if (!defined('KHOT_APP_ENTRY')) {
    http_response_code(403);
    exit;
}

$__recaptchaSecretFile = __DIR__ . '/recaptcha-secret.php';
if (is_file($__recaptchaSecretFile)) {
    require_once $__recaptchaSecretFile;
}

/** Resolves the reCAPTCHA secret key from the environment first, then the local fallback file. */
function recaptcha_secret_key(): string
{
    $fromEnv = getenv('RECAPTCHA_SECRET_KEY');
    if ($fromEnv !== false && $fromEnv !== '') {
        return $fromEnv;
    }
    return defined('RECAPTCHA_SECRET_KEY_FALLBACK') ? RECAPTCHA_SECRET_KEY_FALLBACK : '';
}

/**
 * Verifies a solved reCAPTCHA challenge with Google's siteverify endpoint.
 * Returns false for a missing token, a misconfigured secret, a failed
 * verification, or any network/cURL problem (fails closed). Never throws
 * and never logs the secret key or the visitor's token.
 */
function verify_recaptcha(string $token, string $remoteIp): bool
{
    if ($token === '') {
        return false;
    }

    $secret = recaptcha_secret_key();
    if ($secret === '') {
        error_log('Enquiry recaptcha: secret key is not configured');
        return false;
    }

    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    if ($ch === false) {
        error_log('Enquiry recaptcha: failed to initialise cURL');
        return false;
    }

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query([
            'secret'   => $secret,
            'response' => $token,
            'remoteip' => $remoteIp,
        ]),
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErrno = curl_errno($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlErrno !== 0) {
        error_log('Enquiry recaptcha: verification request failed (cURL error ' . $curlErrno . ': ' . $curlError . ')');
        return false;
    }

    if ($httpCode < 200 || $httpCode >= 300 || $response === false) {
        error_log('Enquiry recaptcha: unexpected HTTP status ' . $httpCode);
        return false;
    }

    $result = json_decode($response, true);
    if (!is_array($result) || empty($result['success'])) {
        return false;
    }

    return true;
}
