<?php
/**
 * Central configuration, language handling and small helpers.
 * Every page must require this file first, before any HTML output.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ar'], true)) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'en';
$dir  = $lang === 'ar' ? 'rtl' : 'ltr';

/** Returns the English or Arabic string depending on the active language. */
function t(string $en, string $ar): string
{
    global $lang;
    return $lang === 'ar' ? $ar : $en;
}

/** Standard placeholder shown wherever final Arabic copy has not been supplied yet. */
function ar_pending(): string
{
    return 'سيتم إضافة المحتوى العربي هنا قريبًا.';
}

/** Absolute origin (scheme + host) for the current request, e.g. "https://example.com". */
function site_origin(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    return $scheme . ($_SERVER['HTTP_HOST'] ?? 'localhost');
}

/**
 * Absolute URL of the site root (e.g. "https://example.com/" or, when
 * deployed in a subfolder, "https://example.com/subfolder/"), resolved
 * using the page's own $base prefix ('' at root, '../' one level deep, etc.)
 * so it works the same whether the site lives at a domain root or not.
 */
function site_root_url(string $base): string
{
    $dir = dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php');
    for ($i = substr_count($base, '../'); $i > 0; $i--) {
        $dir = dirname($dir);
    }
    return site_origin() . rtrim(str_replace('\\', '/', $dir), '/') . '/';
}

/** Builds the URL for the language switch links, preserving the current query string. */
function lang_url(string $targetLang): string
{
    $query = $_GET;
    $query['lang'] = $targetLang;
    return '?' . http_build_query($query);
}

/**
 * Renders a <picture> element serving WebP with a JPG fallback for a given
 * base path (no extension) under assets/images/optimized/. $attrs is raw
 * HTML attribute text (width, height, loading, decoding, class, etc.) —
 * only pass static, trusted strings.
 */
function picture(string $basePath, string $alt, string $attrs = ''): string
{
    $webp = htmlspecialchars($basePath . '.webp');
    $jpg  = htmlspecialchars($basePath . '.jpg');
    $alt  = htmlspecialchars($alt);
    return '<picture><source srcset="' . $webp . '" type="image/webp">'
         . '<img src="' . $jpg . '" alt="' . $alt . '" ' . $attrs . '></picture>';
}

$config = [
    'site_name'        => 'Visit Malaysia 2026–2027',
    'site_name_ar'      => 'زوروا ماليزيا 2026–2027',
    'organizer'        => "Khimji's House of Travel",
    'tagline_en'       => 'Malaysia, Truly Asia',
    'tagline_ar'       => 'ماليزيا، آسيا الحقيقية',
    'instagram'        => '#',
    'facebook'         => '#',
    'ebrochure_url'    => 'https://ebrochures.malaysia.travel/',
    'contact_email'    => 'khot.holidays@kr.om',
    'contact_phone'    => '+968 9928 0907',
    'khimji_site'      => 'https://www.khimjistravel.com',

    // Enquiry form delivery (via Brevo Transactional Email API — see
    // includes/sendemail.php). The API key itself is NOT stored here; it
    // lives server-side only in includes/brevo-secret.php or the
    // BREVO_API_KEY environment variable.
    'brevo_sender_email' => 'sanoop@adventz.net',
    'brevo_sender_name'  => "Khimji's House of Travel - Malaysia",
    'brevo_to_email'     => 'khot.holidays@kr.om',
    'brevo_cc_email'     => 'reshma@tripsnstay.com',

    // Google reCAPTCHA v2 ("I'm not a robot" checkbox) on the enquiry form.
    // The site key is public by design (Google sends it to every visitor's
    // browser to render the widget) — only the matching secret key (verified
    // server-side in includes/recaptcha.php) needs to stay confidential.
    'recaptcha_site_key' => '6LcQMq0tAAAAAOA5FEGR3cHDFix-kN3PCauJdA-E',
];
