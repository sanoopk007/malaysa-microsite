<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/destination-data.php';

$base = '../';
$siteRoot = site_root_url($base);

$pageTitle = t('Malaysia Attractions & Destinations | Khimji Travel', 'معالم ووجهات ماليزيا السياحية | خيمجي للسفر');
$pageDescription = t(
    'Discover Malaysia\'s must-visit destinations, from the towers of Kuala Lumpur to the rainforests of Sabah — 10 places to explore with Khimji Travel.',
    'اكتشف أبرز الوجهات السياحية في ماليزيا، من أبراج كوالالمبور إلى غابات صباح المطيرة — 10 وجهات لاستكشافها مع خيمجي للسفر.'
);
$pageCanonical = $siteRoot . 'attractions/index.php';
$pageImage = $siteRoot . 'assets/images/optimized/misc-attractions-hero.jpg';

$destinationListItems = [];
foreach ($destinations as $i => $d) {
    $destinationListItems[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'item' => [
            '@type' => 'TouristDestination',
            'name' => $d['title_en'],
            'description' => $d['tagline_en'],
            'url' => $siteRoot . 'attractions/' . $d['slug'] . '.php',
            'image' => $siteRoot . $d['image'] . '.jpg',
            'containedInPlace' => ['@type' => 'Country', 'name' => 'Malaysia'],
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
                ['@type' => 'ListItem', 'position' => 2, 'name' => t('Attractions', 'المعالم السياحية'), 'item' => $pageCanonical],
            ],
        ],
        [
            '@type' => 'ItemList',
            'name' => 'Malaysia destinations featured on Visit Malaysia 2026–2027',
            'itemListElement' => $destinationListItems,
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
  <div class="hero__media"><?= picture($base . 'assets/images/optimized/misc-attractions-hero', '', 'width="1920" height="800" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <p class="hero__eyebrow"><?= t('Attractions', 'المعالم السياحية') ?></p>
    <h1 class="hero__title" style="font-size:clamp(2.4rem,5vw,4.5rem);"><?= t('10 destinations, one Malaysia', '10 وجهات، ماليزيا واحدة') ?></h1>
  </div>
</section>

<section class="destinations section-pad">
  <div class="container-fluid">
    <div class="row g-4 reveal reveal-stagger">
      <?php foreach ($destinations as $i => $d): ?>
      <div class="col-12 col-sm-6 col-lg-4" style="--stagger-i: <?= $i ?>;">
        <a href="<?= $d['slug'] ?>.php" class="dest-card" style="aspect-ratio:4/3;">
          <?= picture($base . $d['image'], t($d['title_en'], $d['title_ar']), 'loading="lazy" decoding="async" width="1600" height="1000"') ?>
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
</section>

<section class="section-pad" style="padding-top:0;">
  <div class="container-fluid">
    <div class="cta-banner reveal">
      <h2><?= t('Not sure where to start?', 'لست متأكدًا من أين تبدأ؟') ?></h2>
      <p><?= t('Talk to a Khimji Travel consultant and we\'ll help you build the right Malaysia itinerary.', ar_pending()) ?></p>
      <a href="<?= $base ?>contact.php" class="btn-premium btn-premium--solid"><?= t('Contact Us', 'اتصل بنا') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
