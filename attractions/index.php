<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/destination-data.php';

$base = '../';
$pageTitle = t('Attractions | Visit Malaysia 2026–2027', 'المعالم السياحية | زوروا ماليزيا 2026–2027');
$pageDescription = t('The must-visit destinations across Malaysia, from Kuala Lumpur to Sabah.', ar_pending());
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
