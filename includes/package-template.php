<?php
/**
 * Shared renderer for every /packages/{slug}.php page.
 * Each thin page file sets $packageSlug and requires this template.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/package-data.php';

$base = '../';
$current = null;
foreach ($packages as $p) {
    if ($p['slug'] === $packageSlug) { $current = $p; break; }
}
if (!$current) {
    http_response_code(404);
    require __DIR__ . '/../404.php';
    exit;
}

$siteRoot = site_root_url($base);

preg_match('/[\d,.]+/', $current['price_from'], $priceMatch);
$priceValue = $priceMatch[0] ?? null;

$pageTitle = t($current['title_en'] . ' Tour Package | Khimji\'s House of Travel', 'باقة ' . $current['cities_ar'] . ' – ' . $current['duration_ar'] . ' | خيمجي للسفر');
$pageDescription = t(
    trim($current['intro_en']) . ' Book with Khimji\'s House of Travel.',
    'باقة سياحية إلى ' . $current['cities_ar'] . ' لمدة ' . $current['duration_ar'] . ' من خيمجي للسفر. خطط لرحلتك إلى ماليزيا 2026–2027 اليوم.'
);
$pageCanonical = $siteRoot . 'packages/' . $current['slug'] . '.php';
$pageImage = $siteRoot . $current['image'] . '.jpg';

$pageSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => t('Home', 'الرئيسية'), 'item' => $siteRoot],
                ['@type' => 'ListItem', 'position' => 2, 'name' => t('Packages', 'الباقات'), 'item' => $siteRoot . 'packages/index.php'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $current['title_en'], 'item' => $pageCanonical],
            ],
        ],
        [
            '@type' => 'TouristTrip',
            'name' => $current['title_en'],
            'description' => $current['intro_en'],
            'touristType' => 'Leisure',
            'url' => $pageCanonical,
            'image' => $pageImage,
            'provider' => [
                '@type' => 'TravelAgency',
                'name' => "Khimji's House of Travel",
                'url' => $config['khimji_site'],
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $priceValue,
                'priceCurrency' => 'OMR',
                'availability' => 'https://schema.org/InStock',
                'url' => $pageCanonical,
            ],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<?php require __DIR__ . '/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/header.php'; ?>

<section class="hero" style="min-height:max(70vh, 420px);">
  <div class="hero__media"><?= picture($base . $current['image'], $current['title_en'], 'width="1600" height="1000" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <nav aria-label="Breadcrumb" style="margin-bottom:1rem; font-size:0.85rem; opacity:0.85;">
      <a href="<?= $base ?>index.php" style="color:#fff;"><?= t('Home', 'الرئيسية') ?></a>
      <span> / </span>
      <a href="index.php" style="color:#fff;"><?= t('Packages', 'الباقات') ?></a>
      <span> / </span>
      <span><?= htmlspecialchars($current['title_en']) ?></span>
    </nav>
    <p class="hero__eyebrow"><?= htmlspecialchars(t($current['duration_en'], $current['duration_ar'])) ?></p>
    <h1 class="hero__title" style="font-size:clamp(2.2rem,5vw,4.5rem);"><?= htmlspecialchars($current['title_en']) ?></h1>
    <div class="pkg-meta">
      <div><span><?= t('Duration', 'المدة') ?></span><strong><?= htmlspecialchars(t($current['duration_en'], $current['duration_ar'])) ?></strong></div>
      <div><span><?= t('Destinations', 'الوجهات') ?></span><strong><?= htmlspecialchars(t($current['cities_en'], $current['cities_ar'])) ?></strong></div>
      <div><span><?= t('Starting from', 'ابتداءً من') ?></span><strong><?= htmlspecialchars($current['price_from']) ?></strong></div>
    </div>
  </div>
</section>

<section class="section-pad">
  <div class="container-fluid pkg-two-col">
    <div>
      <p class="eyebrow"><?= t('Overview', 'نظرة عامة') ?></p>
      <h2 style="font-size:clamp(1.7rem,2.6vw,2.2rem); margin:0.4em 0 1rem;"><?= t('About this journey', 'عن هذه الرحلة') ?></h2>
      <p style="color:var(--color-ink-soft); max-width:65ch;"><?= htmlspecialchars(t($current['intro_en'], ar_pending())) ?></p>

      <h3 style="font-size:1.15rem; margin:2.5rem 0 1.5rem; color:var(--color-rainforest-dark);"><?= t('Day-by-day itinerary', 'برنامج الرحلة يومًا بيوم') ?></h3>
      <ol class="timeline">
        <?php foreach ($current['itinerary_en'] as $i => $day): ?>
        <li>
          <span class="timeline__marker"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h4><?= t('Day ' . str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT), 'اليوم ' . ($i + 1)) ?> — <?= htmlspecialchars($day['title']) ?></h4>
          <p><?= htmlspecialchars($day['desc']) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>

      <?php if (!empty($current['gallery'])): ?>
      <h3 style="font-size:1.15rem; margin:3rem 0 1.5rem; color:var(--color-rainforest-dark);"><?= t('Gallery', 'معرض الصور') ?></h3>
      <div class="pkg-gallery-nav">
        <button class="swiper-nav-btn gallery-prev" aria-label="<?= t('Previous', 'السابق') ?>"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i></button>
        <button class="swiper-nav-btn gallery-next" aria-label="<?= t('Next', 'التالي') ?>"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></button>
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

      <div class="lightbox" id="galleryLightbox" aria-hidden="true">
        <button type="button" class="lightbox__close" id="lightboxClose" aria-label="<?= t('Close', 'إغلاق') ?>">&times;</button>
        <figure class="lightbox__figure">
          <img src="" alt="" id="lightboxImg">
          <figcaption id="lightboxCaption"></figcaption>
        </figure>
      </div>
      <?php endif; ?>

      <div style="background:var(--color-sand); border-radius:var(--radius-md); padding:1.5rem; margin-top:3rem; font-size:0.9rem; color:var(--color-ink-soft);">
        <strong style="display:block; color:var(--color-rainforest-dark); margin-bottom:0.4em;"><?= t('Important Information', 'معلومات هامة') ?></strong>
        <?= t('Prices are per person, subject to availability and travel dates. Final itinerary and pricing will be confirmed by Khimji\'s House of Travel at the time of booking.', ar_pending()) ?>
      </div>
    </div>

    <aside class="pkg-sidebar">
      <h4><?= t('What\'s Included', 'يشمل السعر') ?></h4>
      <ul class="pkg-list pkg-list--included">
        <?php foreach ($current['included_en'] as $inc): ?>
        <li><i class="bi bi-check-circle-fill"></i> <span><?= htmlspecialchars($inc) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <h4><?= t('What\'s Excluded', 'لا يشمل السعر') ?></h4>
      <ul class="pkg-list pkg-list--excluded">
        <?php foreach ($current['excluded_en'] as $exc): ?>
        <li><i class="bi bi-x-circle-fill"></i> <span><?= htmlspecialchars($exc) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?= $base ?>contact.php?package=<?= urlencode($current['slug']) ?>" class="btn-premium btn-premium--dark" style="width:100%; justify-content:center;"><?= t('Enquire Now', 'استفسر الآن') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
    </aside>
  </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
</body>
</html>
