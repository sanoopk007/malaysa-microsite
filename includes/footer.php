<?php
$base = $base ?? '';
if (!isset($destinations)) {
    require_once __DIR__ . '/destination-data.php';
}
$footerDestinations = array_slice($destinations, 0, 6);
?>
<footer class="site-footer">
  <div class="container-fluid">
    <div class="site-footer__top">
      <div class="site-footer__brand">
        <img src="<?= $base ?>assets/logos/visit-malaysia-white.png" alt="Visit Malaysia 2026–2027">
        <a href="<?= htmlspecialchars($config['khimji_site']) ?>" target="_blank" rel="noopener" class="site-footer__partner">
          <img src="<?= $base ?>assets/logos/khimji-logo-white.png" alt="Khimji's House of Travel">
        </a>
        <p class="site-footer__tagline"><?= t($config['tagline_en'], $config['tagline_ar']) ?></p>
        <div class="site-footer__social">
          <a href="<?= htmlspecialchars($config['instagram']) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="<?= htmlspecialchars($config['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        </div>
      </div>

      <div class="site-footer__col">
        <h6><?= t('Explore', 'استكشف') ?></h6>
        <a href="<?= $base ?>experiences.php"><?= t('Experiences', 'التجارب') ?></a>
        <a href="<?= $base ?>packages/index.php"><?= t('Packages', 'الباقات') ?></a>
        <a href="<?= htmlspecialchars($config['ebrochure_url']) ?>" target="_blank" rel="noopener"><?= t('E-Brochures', 'الكتيبات الإلكترونية') ?></a>
        <a href="<?= $base ?>contact.php"><?= t('Contact Us', 'اتصل بنا') ?></a>
      </div>

      <div class="site-footer__col">
        <h6><?= t('Popular Destinations', 'أشهر الوجهات') ?></h6>
        <?php foreach ($footerDestinations as $d): ?>
        <a href="<?= $base ?>attractions/<?= $d['slug'] ?>.php"><?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></a>
        <?php endforeach; ?>
      </div>

      <div class="site-footer__col">
        <h6><?= t('Contact', 'تواصل') ?></h6>
        <a href="mailto:<?= htmlspecialchars($config['contact_email']) ?>"><?= htmlspecialchars($config['contact_email']) ?></a>
        <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $config['contact_phone'])) ?>"><?= htmlspecialchars($config['contact_phone']) ?></a>
        <span class="site-footer__organizer"><?= htmlspecialchars($config['organizer']) ?></span>
      </div>
    </div>

    <div class="site-footer__bottom">
      <p>Visit Malaysia 2026–2027 — <?= t('Malaysia, Truly Asia', 'ماليزيا، آسيا الحقيقية') ?></p>
      <p>&copy; <?= date('Y') ?> <?= t('In association with Khimji\'s House of Travel. All rights reserved.', ar_pending()) ?></p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script src="<?= $base ?>assets/js/main.js" defer></script>
