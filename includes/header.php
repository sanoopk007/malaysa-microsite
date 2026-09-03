<?php
/** Sticky header: transparent-over-hero, mega-menu Attractions, lang switch, mobile drawer. */
$base = $base ?? '';
if (!isset($destinations)) {
    require_once __DIR__ . '/destination-data.php';
}
?>
<header class="site-header" id="siteHeader">
  <div class="site-header__inner container-fluid">
    <a href="<?= $base ?>index.php" class="site-header__logo" aria-label="<?= t('Visit Malaysia 2026–2027 — Home', 'الصفحة الرئيسية — زوروا ماليزيا 2026–2027') ?>">
      <img src="<?= $base ?>assets/logos/visit-malaysia-white.png" class="logo-scroll-swap" data-light="<?= $base ?>assets/logos/visit-malaysia-colour.png" data-dark="<?= $base ?>assets/logos/visit-malaysia-white.png" alt="Visit Malaysia 2026–2027">
    </a>

    <nav class="site-nav" id="siteNav" aria-label="<?= t('Primary navigation', 'التنقل الرئيسي') ?>">
      <ul class="site-nav__list">
        <li class="has-mega">
          <button class="site-nav__link site-nav__link--btn" aria-haspopup="true" aria-expanded="false" id="attractionsToggle">
            <?= t('Attractions', 'المعالم السياحية') ?> <i class="bi bi-chevron-down"></i>
          </button>
          <div class="mega-menu" id="attractionsMega">
            <div class="mega-menu__grid">
              <?php foreach ($destinations as $d): ?>
              <a href="<?= $base ?>attractions/<?= $d['slug'] ?>.php" class="mega-menu__item">
                <span class="mega-menu__item-name"><?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></span>
                <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
        </li>
        <li><a href="<?= $base ?>experiences.php" class="site-nav__link"><?= t('Experiences', 'التجارب') ?></a></li>
        <li><a href="<?= $base ?>packages/index.php" class="site-nav__link"><?= t('Packages', 'الباقات') ?></a></li>
        <li><a href="<?= htmlspecialchars($config['ebrochure_url']) ?>" class="site-nav__link" target="_blank" rel="noopener"><?= t('E-Brochures', 'الكتيبات الإلكترونية') ?></a></li>
        <li><a href="<?= $base ?>contact.php" class="site-nav__link"><?= t('Contact Us', 'اتصل بنا') ?></a></li>
      </ul>
    </nav>

    <div class="site-header__right">
      <div class="lang-switch">
        <a href="<?= lang_url('en') ?>" class="<?= $lang === 'en' ? 'is-active' : '' ?>">EN</a>
        <span>|</span>
        <a href="<?= lang_url('ar') ?>" class="<?= $lang === 'ar' ? 'is-active' : '' ?>">العربية</a>
      </div>
      <div class="site-header__social">
        <a href="<?= htmlspecialchars($config['instagram']) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="<?= htmlspecialchars($config['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
      </div>
      <a href="<?= htmlspecialchars($config['khimji_site']) ?>" class="site-header__partner" target="_blank" rel="noopener" aria-label="Khimji's House of Travel">
        <img src="<?= $base ?>assets/logos/khimji-logo-white.png" class="logo-scroll-swap" data-light="<?= $base ?>assets/logos/khimji-logo-colour.png" data-dark="<?= $base ?>assets/logos/khimji-logo-white.png" alt="Khimji's House of Travel">
      </a>
      <button class="menu-toggle" id="menuToggle" aria-label="<?= t('Open menu', 'افتح القائمة') ?>" aria-expanded="false" aria-controls="mobileDrawer">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<div class="mobile-drawer" id="mobileDrawer" aria-hidden="true">
  <div class="mobile-drawer__head">
    <img src="<?= $base ?>assets/logos/visit-malaysia-white.png" alt="Visit Malaysia 2026–2027">
    <button class="mobile-drawer__close" id="drawerClose" aria-label="<?= t('Close menu', 'إغلاق القائمة') ?>">&times;</button>
  </div>
  <nav class="mobile-drawer__nav">
    <div class="mobile-drawer__item">
      <button class="mobile-drawer__link mobile-drawer__link--expand" id="drawerAttractionsToggle">
        <?= t('Attractions', 'المعالم السياحية') ?> <span>+</span>
      </button>
      <ul class="mobile-drawer__sub" id="drawerAttractionsSub">
        <?php foreach ($destinations as $d): ?>
        <li><a href="<?= $base ?>attractions/<?= $d['slug'] ?>.php"><?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <a href="<?= $base ?>experiences.php" class="mobile-drawer__link"><?= t('Experiences', 'التجارب') ?></a>
    <a href="<?= $base ?>packages/index.php" class="mobile-drawer__link"><?= t('Packages', 'الباقات') ?></a>
    <a href="<?= htmlspecialchars($config['ebrochure_url']) ?>" class="mobile-drawer__link" target="_blank" rel="noopener"><?= t('E-Brochures', 'الكتيبات الإلكترونية') ?></a>
    <a href="<?= $base ?>contact.php" class="mobile-drawer__link"><?= t('Contact Us', 'اتصل بنا') ?></a>
  </nav>
  <div class="mobile-drawer__lang">
    <a href="<?= lang_url('en') ?>" class="<?= $lang === 'en' ? 'is-active' : '' ?>">English</a>
    <span>|</span>
    <a href="<?= lang_url('ar') ?>" class="<?= $lang === 'ar' ? 'is-active' : '' ?>">العربية</a>
  </div>
  <div class="mobile-drawer__social">
    <a href="<?= htmlspecialchars($config['instagram']) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
    <a href="<?= htmlspecialchars($config['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
  </div>
</div>
<div class="drawer-backdrop" id="drawerBackdrop"></div>
