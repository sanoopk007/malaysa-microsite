<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/destination-data.php';
require_once __DIR__ . '/includes/package-data.php';
require_once __DIR__ . '/includes/experience-data.php';
require_once __DIR__ . '/includes/offer-data.php';

$base = '';
$pageTitle = t('Visit Malaysia 2026–2027 | Khimji Travel', 'زوروا ماليزيا 2026–2027 | خيمجي للسفر');
$pageDescription = t(
    'Discover Malaysia\'s cities, islands, rainforests and culture with Visit Malaysia 2026–2027, in association with Khimji Travel. Explore destinations, curated packages and special offers.',
    ar_pending()
);
$pageSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'WebSite',
            'name' => 'Visit Malaysia 2026–2027',
            'url' => $pageCanonical ?? '',
        ],
        [
            '@type' => 'Organization',
            'name' => "Khimji's House of Travel",
            'url' => $config['khimji_site'],
            'logo' => $config['khimji_site'] . '/img/logo.png',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<?php require __DIR__ . '/includes/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<!-- ================= HERO ================= -->
<section class="hero">
  <div class="hero__media">
    <picture>
      <source media="(max-width: 768px)" srcset="assets/images/optimized/misc-hero-poster-mobile.webp" type="image/webp">
      <source media="(max-width: 768px)" srcset="assets/images/optimized/misc-hero-poster-mobile.jpg">
      <source srcset="assets/images/optimized/misc-hero-poster.webp" type="image/webp">
      <img src="assets/images/optimized/misc-hero-poster.jpg" alt="" width="1920" height="1080" fetchpriority="high">
    </picture>
    <video id="heroVideo" class="hero__video" muted loop playsinline aria-hidden="true" data-src="assets/video/malaysia-hero.mp4"></video>
  </div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <p class="hero__eyebrow"><?= t('Visit Malaysia 2026 – 2027', 'زوروا ماليزيا 2026 – 2027') ?></p>
    <h1 class="hero__title"><?= t('Truly <em>Asia</em>', 'آسيا <em>الحقيقية</em>') ?></h1>
    <p class="hero__sub"><?= t(
        'Discover a world of culture, nature and unforgettable experiences — curated with Khimji Travel.',
        ar_pending()
    ) ?></p>
    <div class="hero__ctas">
      <a href="#destinations" class="btn-premium btn-premium--solid"><?= t('Explore Malaysia', 'استكشف ماليزيا') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
      <a href="#packages" class="btn-premium btn-premium--outline"><?= t('View Packages', 'عرض الباقات') ?></a>
    </div>
  </div>
  <div class="hero__scroll" aria-hidden="true">
    <span><?= t('Scroll', 'مرر') ?></span>
    <span class="hero__scroll-line"></span>
  </div>
</section>

<!-- ================= INTRO ================= -->
<section class="intro section-pad">
  <div class="container-fluid intro__grid">
    <div class="intro__collage reveal">
      <?= picture('assets/images/optimized/misc-intro-collage-1', t('Mossy Forest boardwalk, Cameron Highlands', ar_pending()), 'class="intro__collage-tall" loading="lazy" decoding="async" width="900" height="1100"') ?>
      <?= picture('assets/images/optimized/misc-intro-collage-2', t('Petronas Twin Towers and the Kuala Lumpur skyline', ar_pending()), 'class="intro__collage-small" loading="lazy" decoding="async" width="900" height="700"') ?>
      <?= picture('assets/images/optimized/misc-intro-collage-3', t('Turquoise waters of the Perhentian Islands', ar_pending()), 'class="intro__collage-small" loading="lazy" decoding="async" width="700" height="900"') ?>
      <div class="intro__collage-badge"><i class="bi bi-geo-alt"></i> <?= t('10 destinations to explore', '10 وجهات لاستكشافها') ?></div>
    </div>
    <div class="reveal">
      <p class="eyebrow"><?= t('Welcome to Malaysia', 'مرحبًا بكم في ماليزيا') ?></p>
      <h2 class="intro__headline"><?= t('One destination.<br>Endless discoveries.', 'وجهة واحدة.<br>اكتشافات لا تنتهي.') ?></h2>
      <p class="intro__text"><?= t(
          'Visit Malaysia 2026–2027 marks a special chapter for the nation — a celebration of its culture, heritage and unity brought to life for travellers everywhere. From the modern skyline of Kuala Lumpur to the ancient trails of Taman Negara, every corner tells a different story, brought closer with Khimji Travel.',
          ar_pending()
      ) ?></p>
      <a href="experiences.php" class="btn-premium btn-premium--dark" style="margin-top:1.5rem;"><?= t('Discover Experiences', 'اكتشف التجارب') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
    </div>
  </div>
</section>

<!-- ================= DESTINATIONS ================= -->
<section class="destinations section-pad" id="destinations">
  <div class="container-fluid">
    <div class="section-head reveal">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Explore Malaysia', 'استكشف ماليزيا') ?></p>
        <h2><?= t('Destinations worth discovering', 'وجهات تستحق الاكتشاف') ?></h2>
      </div>
      <div style="display:flex; align-items:center; gap:1.25rem;">
        <a href="attractions/index.php" class="btn-premium btn-premium--dark"><?= t('View All Attractions', 'عرض جميع المعالم') ?></a>
        <div class="swiper-nav-group">
          <button class="swiper-nav-btn dest-prev" aria-label="<?= t('Previous', 'السابق') ?>"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i></button>
          <button class="swiper-nav-btn dest-next" aria-label="<?= t('Next', 'التالي') ?>"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></button>
        </div>
      </div>
    </div>

    <div class="swiper dest-swiper reveal">
      <div class="swiper-wrapper">
        <?php foreach ($destinations as $d): ?>
        <div class="swiper-slide">
          <a href="attractions/<?= $d['slug'] ?>.php" class="dest-card">
            <?= picture($d['image'], t($d['title_en'], $d['title_ar']), 'loading="lazy" decoding="async" width="1600" height="1000"') ?>
            <span class="dest-card__arrow"><i class="bi bi-arrow-<?= $dir === 'rtl' ? 'down-left' : 'down-right' ?>"></i></span>
            <div class="dest-card__body">
              <h3><?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></h3>
              <p><?= htmlspecialchars(t($d['tagline_en'], $d['tagline_ar'])) ?></p>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ================= PACKAGES ================= -->
<section class="packages section-pad" id="packages">
  <div class="container-fluid">
    <div class="section-head reveal">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Curated Journeys', 'رحلات منسّقة') ?></p>
        <h2><?= t('Popular Packages', 'الباقات الأكثر طلبًا') ?></h2>
      </div>
      <a href="packages/index.php" class="btn-premium btn-premium--dark"><?= t('View All Packages', 'عرض جميع الباقات') ?></a>
    </div>

    <div class="row g-4 reveal reveal-stagger">
      <?php foreach ($packages as $i => $p): ?>
      <div class="col-12 col-sm-6 col-lg-4" style="--stagger-i: <?= $i ?>;">
        <a href="packages/<?= $p['slug'] ?>.php" class="package-card">
          <div class="package-card__media">
            <?= picture($p['image'], $p['title_en'], 'loading="lazy" decoding="async" width="1600" height="1000"') ?>
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

<!-- ================= EXPERIENCES TEASER ================= -->
<section class="experiences-teaser section-pad">
  <div class="container-fluid">
    <div class="section-head reveal">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Experience Malaysia', 'جرّب ماليزيا') ?></p>
        <h2><?= t('More than a destination', 'أكثر من مجرد وجهة') ?></h2>
      </div>
      <a href="experiences.php" class="btn-premium btn-premium--dark"><?= t('All Experiences', 'جميع التجارب') ?></a>
    </div>

    <div class="mosaic reveal">
      <?php foreach ($experiences as $slug => $e): if (!in_array($e['slug'], $experience_teasers, true)) continue; ?>
      <a href="experiences.php#<?= $e['slug'] ?>" class="mosaic-item">
        <?= picture($e['image'], t($e['title_en'], $e['title_ar']), 'loading="lazy" decoding="async" width="1200" height="900"') ?>
        <span class="mosaic-item__label"><?= htmlspecialchars(t($e['title_en'], $e['title_ar'])) ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'down-left' : 'down-right' ?>"></i></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ================= SPECIAL OFFERS ================= -->
<section class="offers section-pad">
  <div class="container-fluid">
    <div class="section-head reveal">
      <div class="section-head__text">
        <p class="eyebrow"><?= t('Special Offers', 'عروض خاصة') ?></p>
        <h2><?= t('Hotel offers worth planning around', 'عروض فنادق تستحق التخطيط لها') ?></h2>
      </div>
    </div>

    <div class="row g-4 reveal reveal-stagger">
      <?php foreach ($offers as $i => $o): ?>
      <div class="col-12 col-sm-6 col-lg-3" style="--stagger-i: <?= $i ?>;">
        <div class="offer-card">
          <div class="offer-card__media">
            <?= picture($o['image'], t($o['hotel_en'], $o['hotel_ar']), 'loading="lazy" decoding="async" width="1000" height="700"') ?>
            <span class="offer-card__tag"><?= htmlspecialchars(t($o['offer_en'], $o['offer_ar'])) ?></span>
          </div>
          <div class="offer-card__body">
            <h3><?= htmlspecialchars(t($o['hotel_en'], $o['hotel_ar'])) ?></h3>
            <p class="offer-card__loc"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars(t($o['location_en'], $o['location_ar'])) ?></p>
            <p class="offer-card__rate"><?= htmlspecialchars(t($o['rate_en'], $o['rate_ar'])) ?></p>
            <p class="offer-card__period"><?= htmlspecialchars(t($o['period_en'], $o['period_ar'])) ?></p>
            <a href="contact.php?destination=<?= urlencode($o['location_en']) ?>&offer=<?= urlencode($o['hotel_en'] . ' — ' . $o['offer_en']) ?>" class="btn-premium btn-premium--dark" style="padding:0.7em 1.4em; font-size:0.85rem;"><?= t('Enquire Now', 'استفسر الآن') ?></a>
            <p class="offer-card__terms"><?= t('Terms and conditions apply.', 'تطبّق الشروط والأحكام.') ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ================= WHY MALAYSIA ================= -->
<section class="why-malaysia section-pad">
  <div class="why-malaysia__bg">
    <?= picture('assets/images/optimized/misc-why-malaysia', '', 'loading="lazy" decoding="async" width="1920" height="1000"') ?>
  </div>
  <div class="container-fluid">
    <div class="why-malaysia__content reveal">
      <p class="eyebrow"><?= t('Why Malaysia', 'لماذا ماليزيا') ?></p>
      <h2 style="font-size:clamp(2rem,3.6vw,3.2rem); margin-top:0.4em;"><?= t('A destination that rewards every kind of traveller', 'وجهة تكافئ كل نوع من المسافرين') ?></h2>
      <ul class="why-malaysia__list">
        <li><i class="bi bi-tsunami"></i> <span><?= t('Tropical islands and coastlines, from Langkawi to the Perhentians', ar_pending()) ?></span></li>
        <li><i class="bi bi-cup-hot"></i> <span><?= t('World-class, multicultural cuisine in every city', ar_pending()) ?></span></li>
        <li><i class="bi bi-tree"></i> <span><?= t('Some of the world\'s oldest rainforests, home to remarkable wildlife', ar_pending()) ?></span></li>
        <li><i class="bi bi-buildings"></i> <span><?= t('Modern, connected cities alongside centuries of heritage', ar_pending()) ?></span></li>
        <li><i class="bi bi-people"></i> <span><?= t('A multicultural spirit that welcomes every visitor', ar_pending()) ?></span></li>
      </ul>
      <a href="contact.php" class="btn-premium btn-premium--outline" style="margin-top:0.5rem;"><?= t('Start Planning Your Trip', 'ابدأ التخطيط لرحلتك') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
    </div>
  </div>
</section>

<!-- ================= FINAL CTA ================= -->
<section class="final-cta">
  <div class="final-cta__bg"><?= picture('assets/images/optimized/misc-final-cta', '', 'loading="lazy" decoding="async" width="1920" height="1000"') ?></div>
  <div class="container-fluid final-cta__content reveal">
    <h2><?= t('Malaysia is calling.', 'ماليزيا تناديك.') ?></h2>
    <p><?= t('Start your Malaysian journey with Khimji Travel.', ar_pending()) ?></p>
    <div class="final-cta__ctas">
      <a href="packages/index.php" class="btn-premium btn-premium--solid"><?= t('Explore Packages', 'استكشف الباقات') ?></a>
      <a href="contact.php" class="btn-premium btn-premium--outline"><?= t('Contact Us', 'اتصل بنا') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
