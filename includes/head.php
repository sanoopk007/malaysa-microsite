<?php
/**
 * Reusable SEO <head>. Each page sets $pageTitle, $pageDescription,
 * $pageImage, $pageCanonical (and optionally $pageSchema, a JSON-LD array)
 * before requiring this file.
 */

$base = $base ?? '';
$pageTitle       = $pageTitle       ?? $config['site_name'];
$pageDescription = $pageDescription ?? t(
    'Visit Malaysia 2026–2027 in association with Khimji Travel — discover destinations, curated packages and unforgettable experiences across Malaysia.',
    ar_pending()
);
$pageImage     = $pageImage ?? $base . 'assets/logos/visit-malaysia-colour.png';
$currentUrl    = site_origin() . ($_SERVER['REQUEST_URI'] ?? '/');
$pageCanonical = $pageCanonical ?? strtok($currentUrl, '?');
$pageRobots    = $pageRobots ?? null;
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
<?php if ($pageRobots): ?>
<meta name="robots" content="<?= htmlspecialchars($pageRobots) ?>">
<?php endif; ?>
<link rel="canonical" href="<?= htmlspecialchars($pageCanonical) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= htmlspecialchars($config['site_name']) ?>">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
<meta property="og:url" content="<?= htmlspecialchars($pageCanonical) ?>">
<meta property="og:locale" content="<?= $lang === 'ar' ? 'ar_AR' : 'en_US' ?>">
<meta property="og:locale:alternate" content="<?= $lang === 'ar' ? 'en_US' : 'ar_AR' ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

<link rel="icon" href="<?= $base ?>favicon.ico" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="<?= $base ?>favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= $base ?>favicon-16x16.png">
<link rel="apple-touch-icon" href="<?= $base ?>apple-touch-icon.png">
<link rel="alternate" hreflang="en" href="<?= htmlspecialchars(strtok($currentUrl, '?')) ?>?lang=en">
<link rel="alternate" hreflang="ar" href="<?= htmlspecialchars(strtok($currentUrl, '?')) ?>?lang=ar">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars(strtok($currentUrl, '?')) ?>?lang=en">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=DM+Sans:wght@400;500;700&family=Noto+Kufi+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
<link rel="stylesheet" href="<?= $base ?>assets/css/responsive.css">
<?php if ($lang === 'ar'): ?>
<link rel="stylesheet" href="<?= $base ?>assets/css/rtl.css">
<?php endif; ?>

<?php if (!empty($pageSchema)): ?>
<script type="application/ld+json"><?= json_encode($pageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php endif; ?>
