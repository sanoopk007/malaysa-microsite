<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/destination-data.php';
require_once __DIR__ . '/../includes/package-data.php';

$base = '../';
$siteRoot = site_root_url($base);

$pageTitle = t('Malaysia Tour Packages | Khimji Travel', 'باقات السفر إلى ماليزيا | خيمجي للسفر');
$pageDescription = t(
    'Browse curated Malaysia tour packages for 2026–2027 — city escapes, island retreats and family holidays, all arranged by Khimji Travel.',
    'تصفح باقات السفر المنسقة إلى ماليزيا لعام 2026–2027 — من عطلات المدن إلى المنتجعات الجزرية والعطلات العائلية، مع خيمجي للسفر.'
);
$pageCanonical = $siteRoot . 'packages/index.php';
$pageImage = $siteRoot . 'assets/images/optimized/misc-packages-hero.jpg';

$packageListItems = [];
foreach ($packages as $i => $p) {
    preg_match('/[\d,.]+/', $p['price_from'], $priceMatch);
    $packageListItems[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'item' => [
            '@type' => 'TouristTrip',
            'name' => $p['title_en'],
            'description' => $p['intro_en'],
            'url' => $siteRoot . 'packages/' . $p['slug'] . '.php',
            'image' => $siteRoot . $p['image'] . '.jpg',
            'offers' => [
                '@type' => 'Offer',
                'price' => $priceMatch[0] ?? null,
                'priceCurrency' => 'OMR',
            ],
        ],
    ];
}

$pageSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => t('Home', 'الرئيسية'), 'item' => $siteRoot],
                ['@type' => 'ListItem', 'position' => 2, 'name' => t('Packages', 'الباقات'), 'item' => $pageCanonical],
            ],
        ],
        [
            '@type' => 'ItemList',
            'name' => 'Malaysia tour packages by Khimji Travel',
            'itemListElement' => $packageListItems,
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<?php require __DIR__ . '/../includes/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/../includes/header.php'; ?>

<section class="hero" style="min-height:max(60vh, 420px);">
  <div class="hero__media"><?= picture($base . 'assets/images/optimized/misc-packages-hero', '', 'width="1920" height="800" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <p class="hero__eyebrow"><?= t('Curated Journeys', 'رحلات منسّقة') ?></p>
    <h1 class="hero__title" style="font-size:clamp(2.4rem,5vw,4.5rem);"><?= t('Every itinerary, considered', 'كل برنامج رحلة، مدروس بعناية') ?></h1>
  </div>
</section>

<section class="packages section-pad">
  <div class="container-fluid">
    <div class="row g-4 reveal reveal-stagger">
      <?php foreach ($packages as $i => $p): ?>
      <div class="col-12 col-sm-6 col-lg-4" style="--stagger-i: <?= $i ?>;">
        <a href="<?= $p['slug'] ?>.php" class="package-card">
          <div class="package-card__media">
            <?= picture($base . $p['image'], $p['title_en'], 'loading="lazy" decoding="async" width="1600" height="1000"') ?>
            <span class="package-card__duration"><?= htmlspecialchars(t($p['duration_en'], $p['duration_ar'])) ?></span>
          </div>
          <div class="package-card__body">
            <h3><?= htmlspecialchars($p['title_en']) ?></h3>
            <span class="package-card__cities"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars(t($p['cities_en'], $p['cities_ar'])) ?></span>
            <ul class="package-card__highlights">
              <?php foreach (array_slice($p['highlights_en'], 0, 3) as $h): ?>
              <li><?= htmlspecialchars($h) ?></li>
              <?php endforeach; ?>
            </ul>
            <div class="package-card__footer">
              <span class="package-card__price"><?= t('Starting from', 'ابتداءً من') ?> <strong><?= htmlspecialchars($p['price_from']) ?></strong></span>
              <span class="package-card__link"><?= t('Explore', 'استكشف') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></span>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-pad" style="padding-top:0;">
  <div class="container-fluid">
    <div class="cta-banner reveal">
      <h2><?= t('Looking for something different?', 'تبحث عن شيء مختلف؟') ?></h2>
      <p><?= t('We can build a custom itinerary around your dates, budget and interests.', ar_pending()) ?></p>
      <a href="<?= $base ?>contact.php" class="btn-premium btn-premium--solid"><?= t('Contact Us', 'اتصل بنا') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
