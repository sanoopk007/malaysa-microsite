<?php
/**
 * Shared renderer for every /attractions/{slug}.php page.
 * Each thin page file sets $attractionSlug and requires this template.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/destination-data.php';
require_once __DIR__ . '/package-data.php';

$base = '../';
$current = null;
foreach ($destinations as $d) {
    if ($d['slug'] === $attractionSlug) { $current = $d; break; }
}
if (!$current) {
    http_response_code(404);
    require __DIR__ . '/../404.php';
    exit;
}

$siteRoot = site_root_url($base);

$attractionNames = array_column($current['attractions'] ?? [], 'name');
$attractionsPhrase = count($attractionNames) >= 2 ? $attractionNames[0] . ' and ' . $attractionNames[1] : ($attractionNames[0] ?? '');

$pageTitle = t($current['title_en'] . ' Travel Guide | Khimji\'s House of Travel', 'دليل السفر إلى ' . $current['title_ar'] . ' | خيمجي للسفر');
$pageDescription = t(
    trim($current['tagline_en'] . ($attractionsPhrase !== '' ? ' — discover ' . $attractionsPhrase . ' in ' . $current['title_en'] : ' in ' . $current['title_en']) . ' with Khimji\'s House of Travel. Plan your Malaysia 2026–2027 trip today.'),
    $current['tagline_ar'] . ' — خطط لرحلتك إلى ' . $current['title_ar'] . ' في ماليزيا 2026–2027 مع خيمجي للسفر.'
);
$pageCanonical = $siteRoot . 'attractions/' . $current['slug'] . '.php';
$pageImage = $siteRoot . $current['image'] . '.jpg';

$pageSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => t('Home', 'الرئيسية'), 'item' => $siteRoot],
                ['@type' => 'ListItem', 'position' => 2, 'name' => t('Attractions', 'المعالم السياحية'), 'item' => $siteRoot . 'attractions/index.php'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => t($current['title_en'], $current['title_ar']), 'item' => $pageCanonical],
            ],
        ],
        [
            '@type' => 'TouristDestination',
            'name' => $current['title_en'],
            'description' => $current['tagline_en'],
            'url' => $pageCanonical,
            'image' => $pageImage,
            'containedInPlace' => ['@type' => 'Country', 'name' => 'Malaysia'],
        ],
    ],
];

// Suggest 2 related packages that mention this destination by name.
$relatedPackages = array_values(array_filter($packages, function ($p) use ($current) {
    return stripos($p['cities_en'], $current['title_en']) !== false;
}));
if (count($relatedPackages) < 2) {
    $relatedPackages = array_slice($packages, 0, 2);
}
$otherDestinations = array_values(array_filter($destinations, function ($d) use ($current) {
    return $d['slug'] !== $current['slug'];
}));
shuffle($otherDestinations);
$otherDestinations = array_slice($otherDestinations, 0, 3);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<?php require __DIR__ . '/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/header.php'; ?>

<section class="hero" style="min-height:max(70vh, 420px);">
  <div class="hero__media"><?= picture($base . $current['image'], t($current['title_en'], $current['title_ar']), 'width="1600" height="1000" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <nav aria-label="Breadcrumb" style="margin-bottom:1rem; font-size:0.85rem; opacity:0.85;">
      <a href="<?= $base ?>index.php" style="color:#fff;"><?= t('Home', 'الرئيسية') ?></a>
      <span> / </span>
      <a href="index.php" style="color:#fff;"><?= t('Attractions', 'المعالم السياحية') ?></a>
      <span> / </span>
      <span><?= htmlspecialchars(t($current['title_en'], $current['title_ar'])) ?></span>
    </nav>
    <p class="hero__eyebrow"><?= t('Attractions', 'المعالم السياحية') ?></p>
    <h1 class="hero__title" style="font-size:clamp(2.4rem,5.5vw,5rem);"><?= htmlspecialchars(t($current['title_en'], $current['title_ar'])) ?></h1>
    <p class="hero__sub"><?= htmlspecialchars(t($current['tagline_en'], $current['tagline_ar'])) ?></p>
    <div class="hero__ctas">
      <a href="#packages-for-destination" class="btn-premium btn-premium--solid"><?= t('View Packages', 'عرض الباقات') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
      <a href="<?= $base ?>contact.php?destination=<?= urlencode($current['title_en']) ?>" class="btn-premium btn-premium--outline"><?= t('Enquire Now', 'استفسر الآن') ?></a>
    </div>
  </div>
</section>

<section class="intro section-pad">
  <div class="container-fluid">
    <p class="eyebrow"><?= t('Overview', 'نظرة عامة') ?></p>
    <h2 class="intro__headline" style="font-size:clamp(1.8rem,3vw,2.6rem);"><?= t('Why visit ' . $current['title_en'], ar_pending()) ?></h2>
    <p class="intro__text" style="max-width:65ch;"><?= t(
        $current['title_en'] . ' is one of Malaysia\'s most rewarding destinations — ' . strtolower($current['tagline_en']) . '. Here\'s where to start, curated with Khimji\'s House of Travel.',
        ar_pending()
    ) ?></p>
  </div>
</section>

<?php if (!empty($current['attractions'])): ?>
<section class="section-pad" style="padding-top:0;">
  <div class="container-fluid">
    <div class="section-head reveal is-visible">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Top Attractions', 'أبرز المعالم') ?></p>
        <h2><?= t('What to see in ' . $current['title_en'], ar_pending()) ?></h2>
      </div>
    </div>
    <div class="attraction-list">
      <?php foreach ($current['attractions'] as $i => $a): ?>
      <div class="attraction-list__item">
        <span class="attraction-list__num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
        <div>
          <h3><?= htmlspecialchars(t($a['name'], $a['name'])) ?></h3>
          <p><?= htmlspecialchars(t($a['desc'], ar_pending())) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($current['visitor_info_en'])): ?>
<section class="section-pad" style="padding-top:0; padding-bottom:0;">
  <div class="container-fluid">
    <div style="background:var(--color-sand); border-radius:var(--radius-md); padding:1.5rem; font-size:0.95rem; color:var(--color-ink-soft); max-width:65ch;">
      <strong style="display:block; color:var(--color-rainforest-dark); margin-bottom:0.4em;"><?= t('Visitor Information', 'معلومات للزوار') ?></strong>
      <?= htmlspecialchars(t($current['visitor_info_en'], ar_pending())) ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($current['gallery'])): ?>
<section class="section-pad" style="padding-top:0;">
  <div class="container-fluid">
    <div class="section-head reveal is-visible">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Gallery', 'معرض الصور') ?></p>
        <h2><?= t('Scenes from ' . $current['title_en'], ar_pending()) ?></h2>
      </div>
      <?php if (count($current['gallery']) > 1): ?>
      <div class="pkg-gallery-nav">
        <button class="swiper-nav-btn gallery-prev" aria-label="<?= t('Previous', 'السابق') ?>"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i></button>
        <button class="swiper-nav-btn gallery-next" aria-label="<?= t('Next', 'التالي') ?>"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></button>
      </div>
      <?php endif; ?>
    </div>
    <div class="swiper gallery-swiper">
      <div class="swiper-wrapper">
        <?php foreach ($current['gallery'] as $g): $caption = t($g['caption_en'], ar_pending()); ?>
        <div class="swiper-slide">
          <button type="button" class="gallery-thumb" data-src="<?= htmlspecialchars($base . $g['image'] . '.jpg') ?>" data-caption="<?= htmlspecialchars($caption) ?>" aria-label="<?= t('Enlarge photo', 'تكبير الصورة') ?>: <?= htmlspecialchars($caption) ?>">
            <?= picture($base . $g['image'], $caption, 'loading="lazy" decoding="async" width="900" height="675"') ?>
            <span class="gallery-thumb__zoom"><i class="bi bi-arrows-fullscreen"></i></span>
            <span class="gallery-thumb__caption"><?= htmlspecialchars($caption) ?></span>
          </button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<div class="lightbox" id="galleryLightbox" aria-hidden="true">
  <button type="button" class="lightbox__close" id="lightboxClose" aria-label="<?= t('Close', 'إغلاق') ?>">&times;</button>
  <figure class="lightbox__figure">
    <img src="" alt="" id="lightboxImg">
    <figcaption id="lightboxCaption"></figcaption>
  </figure>
</div>
<?php endif; ?>

<?php if (!empty($relatedPackages)): ?>
<section class="packages section-pad" id="packages-for-destination" style="scroll-margin-top: calc(var(--header-h) + 1rem);">
  <div class="container-fluid">
    <div class="section-head reveal is-visible">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Plan Your Visit', 'خطط لزيارتك') ?></p>
        <h2><?= t('Packages featuring ' . $current['title_en'], ar_pending()) ?></h2>
      </div>
    </div>
    <div class="row g-4">
      <?php foreach ($relatedPackages as $p): ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <a href="<?= $base ?>packages/<?= $p['slug'] ?>.php" class="package-card">
          <div class="package-card__media">
            <?= picture($base . $p['image'], $p['title_en'], 'loading="lazy" decoding="async" width="1600" height="1000"') ?>
            <span class="package-card__duration"><?= htmlspecialchars(t($p['duration_en'], $p['duration_ar'])) ?></span>
          </div>
          <div class="package-card__body">
            <h3><?= htmlspecialchars($p['title_en']) ?></h3>
            <span class="package-card__cities"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars(t($p['cities_en'], $p['cities_ar'])) ?></span>
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
<?php endif; ?>

<section class="destinations section-pad">
  <div class="container-fluid">
    <div class="section-head reveal is-visible">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Keep Exploring', 'تابع الاستكشاف') ?></p>
        <h2><?= t('Other destinations', 'وجهات أخرى') ?></h2>
      </div>
    </div>
    <div class="row g-4">
      <?php foreach ($otherDestinations as $d): ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <a href="<?= $d['slug'] ?>.php" class="dest-card" style="aspect-ratio:4/3;">
          <?= picture($base . $d['image'], t($d['title_en'], $d['title_ar']), 'loading="lazy" decoding="async" width="1600" height="1000"') ?>
          <div class="dest-card__body"><h3><?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></h3></div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
</body>
</html>
