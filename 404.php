<?php
require_once __DIR__ . '/includes/config.php';
$base = '';
$siteRoot = site_root_url($base);

$pageTitle = t('Page Not Found | Khimji Travel', 'الصفحة غير موجودة | خيمجي للسفر');
$pageDescription = t(
    'The page you are looking for could not be found. Return to Visit Malaysia 2026–2027 to keep exploring.',
    'الصفحة التي تبحث عنها غير موجودة. عد إلى زوروا ماليزيا 2026–2027 لمتابعة الاستكشاف.'
);
$pageCanonical = $siteRoot . '404.php';
$pageImage = $siteRoot . 'assets/images/optimized/misc-why-malaysia.jpg';
$pageRobots = 'noindex, follow';
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<?php require __DIR__ . '/includes/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<section class="hero" style="min-height:max(80vh, 420px);">
  <div class="hero__media"><?= picture('assets/images/optimized/misc-why-malaysia', '', 'width="1920" height="1000" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content" style="text-align:center; margin:0 auto;">
    <p class="hero__eyebrow" style="justify-content:center; display:flex;">404</p>
    <h1 class="hero__title" style="font-size:clamp(2rem,4.5vw,3.6rem);"><?= t('Looks like you\'ve wandered off the map.', ar_pending()) ?></h1>
    <p class="hero__sub" style="margin:0 auto;"><?= t('The page you\'re looking for doesn\'t exist — but Malaysia still does.', ar_pending()) ?></p>
    <div class="hero__ctas" style="justify-content:center;">
      <a href="index.php" class="btn-premium btn-premium--solid"><?= t('Return to Malaysia', 'العودة إلى ماليزيا') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
