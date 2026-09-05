<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/destination-data.php';
require_once __DIR__ . '/includes/experience-data.php';

$base = '';
$siteRoot = site_root_url($base);

$pageTitle = t('Malaysia Travel Experiences | Khimji\'s House of Travel', 'تجارب السفر في ماليزيا | خيمجي للسفر');
$pageDescription = t(
    'Explore Malaysia through nature, culture, food, adventure and more — eleven ways to experience the country, curated with Khimji\'s House of Travel.',
    'استكشف ماليزيا عبر الطبيعة والثقافة والطعام والمغامرة والمزيد — أحد عشر أسلوبًا لتجربة البلاد مع خيمجي للسفر.'
);
$pageCanonical = $siteRoot . 'experiences.php';
$pageImage = $siteRoot . 'assets/images/optimized/misc-experiences-hero.jpg';

$destBySlug = [];
foreach ($destinations as $d) { $destBySlug[$d['slug']] = $d; }

$experienceListItems = [];
foreach ($experiences as $i => $e) {
    $experienceListItems[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'item' => [
            '@type' => 'Thing',
            'name' => $e['title_en'],
            'description' => $e['desc_en'],
            'url' => $pageCanonical . '#' . $e['slug'],
            'image' => $siteRoot . $e['image'] . '.jpg',
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
                ['@type' => 'ListItem', 'position' => 2, 'name' => t('Experiences', 'التجارب'), 'item' => $pageCanonical],
            ],
        ],
        [
            '@type' => 'ItemList',
            'name' => 'Malaysia travel experiences featured on Visit Malaysia 2026–2027',
            'itemListElement' => $experienceListItems,
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

<section class="hero" style="min-height:max(65vh, 420px);">
  <div class="hero__media"><?= picture('assets/images/optimized/misc-experiences-hero', '', 'width="1920" height="800" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <p class="hero__eyebrow"><?= t('Experience Malaysia', 'جرّب ماليزيا') ?></p>
    <h1 class="hero__title" style="font-size:clamp(2.4rem,5.5vw,5rem);"><?= t('Stories, not just sights', 'قصص، لا مجرد مشاهد') ?></h1>
    <p class="hero__sub"><?= t('Eleven ways to experience Malaysia — from ancient rainforest to island sunsets.', ar_pending()) ?></p>
  </div>
</section>

<section class="section-pad" style="padding-bottom:0;">
  <div class="container-fluid">
    <?php foreach ($experiences as $i => $e): ?>
    <div class="exp-row reveal" id="<?= $e['slug'] ?>">
      <div class="exp-row__media">
        <span class="exp-row__num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?> / <?= count($experiences) ?></span>
        <?= picture($e['image'], t($e['title_en'], $e['title_ar']), 'loading="lazy" decoding="async" width="1200" height="900"') ?>
      </div>
      <div class="exp-row__text">
        <p class="eyebrow"><?= t('Experience', 'تجربة') ?> <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></p>
        <h2><?= htmlspecialchars(t($e['title_en'], $e['title_ar'])) ?></h2>
        <p><?= htmlspecialchars(t($e['desc_en'], ar_pending())) ?></p>
        <?php if (!empty($e['destinations'])): ?>
        <div class="exp-row__tags">
          <?php foreach ($e['destinations'] as $slug): if (!isset($destBySlug[$slug])) continue; $d = $destBySlug[$slug]; ?>
          <a href="attractions/<?= $d['slug'] ?>.php"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="final-cta">
  <div class="final-cta__bg"><?= picture('assets/images/optimized/misc-final-cta', '', 'loading="lazy" decoding="async" width="1920" height="1000"') ?></div>
  <div class="container-fluid final-cta__content reveal">
    <h2><?= t('Ready to choose your Malaysia?', 'هل أنت مستعد لاختيار ماليزيا الخاصة بك؟') ?></h2>
    <p><?= t('Browse curated packages or talk to Khimji\'s House of Travel about building your own.', ar_pending()) ?></p>
    <div class="final-cta__ctas">
      <a href="packages/index.php" class="btn-premium btn-premium--solid"><?= t('Explore Packages', 'استكشف الباقات') ?></a>
      <a href="contact.php" class="btn-premium btn-premium--outline"><?= t('Contact Us', 'اتصل بنا') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
