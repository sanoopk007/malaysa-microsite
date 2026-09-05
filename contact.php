<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/destination-data.php';
require_once __DIR__ . '/includes/package-data.php';

$base = '';
$siteRoot = site_root_url($base);

$pageTitle = t('Contact Khimji\'s House of Travel | Plan Your Malaysia Trip', 'اتصل بخيمجي للسفر | خطط لرحلتك إلى ماليزيا');
$pageDescription = t(
    'Get in touch with Khimji\'s House of Travel to plan your Malaysia 2026–2027 trip — ask about destinations, tour packages and special hotel offers.',
    'تواصل مع خيمجي للسفر لتخطيط رحلتك إلى ماليزيا 2026–2027 — استفسر عن الوجهات وباقات الرحلات والعروض الخاصة.'
);
$pageCanonical = $siteRoot . 'contact.php';
$pageImage = $siteRoot . 'assets/images/optimized/misc-contact-hero.jpg';

$pageSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => t('Home', 'الرئيسية'), 'item' => $siteRoot],
                ['@type' => 'ListItem', 'position' => 2, 'name' => t('Contact Us', 'اتصل بنا'), 'item' => $pageCanonical],
            ],
        ],
        [
            '@type' => 'ContactPage',
            'name' => $pageTitle,
            'url' => $pageCanonical,
            'about' => [
                '@type' => 'TravelAgency',
                'name' => "Khimji's House of Travel",
                'url' => $config['khimji_site'],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => $config['contact_phone'],
                    'email' => $config['contact_email'],
                    'contactType' => 'customer service',
                ],
            ],
        ],
    ],
];

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$formStatus = $_SESSION['enquiry_status'] ?? null;
unset($_SESSION['enquiry_status']);
$selectedPackage = $_GET['package'] ?? '';
$selectedDestination = $_GET['destination'] ?? '';
$offerRef = $_GET['offer'] ?? '';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<?php require __DIR__ . '/includes/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<section class="hero" style="min-height:max(45vh, 420px);">
  <div class="hero__media"><?= picture('assets/images/optimized/misc-contact-hero', '', 'width="1920" height="800" fetchpriority="high"') ?></div>
  <div class="hero__overlay"></div>
  <div class="container-fluid hero__content">
    <p class="hero__eyebrow"><?= t('Get In Touch', 'تواصل معنا') ?></p>
    <h1 class="hero__title" style="font-size:clamp(2.4rem,5vw,4.5rem);"><?= t('Plan your trip', 'خطط لرحلتك') ?></h1>
    <p class="hero__sub"><?= t('Tell us what you have in mind — a Khimji\'s House of Travel consultant will take it from there.', ar_pending()) ?></p>
  </div>
</section>

<section class="section-pad">
  <div class="container-fluid contact-layout">

    <div>
      <?php if ($formStatus === 'success'): ?>
        <div class="reveal is-visible" style="background:var(--color-rainforest); color:#fff; border-radius:var(--radius-md); padding:2rem; margin-bottom:2rem; text-align:center;">
          <i class="bi bi-check-circle" style="font-size:2rem; color:var(--color-gold);"></i>
          <h2 style="margin-top:0.6rem; font-size:1.4rem; color:#fff;"><?= t('Thank you — your enquiry has been sent.', ar_pending()) ?></h2>
          <p style="margin:0.5rem 0 0; opacity:0.9;"><?= t('A Khimji\'s House of Travel consultant will be in touch shortly.', ar_pending()) ?></p>
        </div>
      <?php elseif ($formStatus === 'error'): ?>
        <div class="reveal is-visible" style="background:var(--color-hibiscus); color:#fff; border-radius:var(--radius-md); padding:1.5rem 2rem; margin-bottom:2rem;">
          <?= t('Something went wrong. Please check the form and try again.', ar_pending()) ?>
        </div>
      <?php endif; ?>

      <div class="contact-card reveal is-visible">
        <h2><?= t('Send an Enquiry', 'أرسل استفسارك') ?></h2>
        <p class="contact-card__note"><?= t('Fields marked with', ar_pending()) ?> <span class="contact-required">*</span> <?= t('are required.', ar_pending()) ?></p>

        <form action="includes/send-enquiry.php" method="post" novalidate>
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <!-- Honeypot field — hidden from real users, bots tend to fill it -->
          <div style="position:absolute; width:1px; height:1px; margin:-1px; padding:0; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;" aria-hidden="true">
            <label>Leave this field empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
          </div>

          <div class="row g-3">
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Name', 'الاسم') ?> <span class="contact-required">*</span></label>
              <div class="input-icon"><i class="bi bi-person"></i><input type="text" name="name" class="form-control" required></div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Email', 'البريد الإلكتروني') ?> <span class="contact-required">*</span></label>
              <div class="input-icon"><i class="bi bi-envelope"></i><input type="email" name="email" class="form-control" required></div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Mobile', 'رقم الجوال') ?> <span class="contact-required">*</span></label>
              <div class="input-icon"><i class="bi bi-telephone"></i><input type="tel" name="mobile" class="form-control" required></div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Nationality / Country', 'الجنسية / الدولة') ?></label>
              <div class="input-icon"><i class="bi bi-flag"></i><input type="text" name="country" class="form-control"></div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Travel Date', 'تاريخ السفر') ?></label>
              <div class="input-icon"><i class="bi bi-calendar3"></i><input type="date" name="travel_date" class="form-control"></div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Number of Travellers', 'عدد المسافرين') ?></label>
              <div class="input-icon"><i class="bi bi-people"></i><input type="number" name="travellers" min="1" max="30" class="form-control"></div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Interested Destination', 'الوجهة المهتم بها') ?></label>
              <div class="input-icon"><i class="bi bi-geo-alt"></i>
                <select name="destination" class="form-select">
                  <option value=""><?= t('Select a destination', 'اختر وجهة') ?></option>
                  <?php foreach ($destinations as $d): ?>
                  <option value="<?= htmlspecialchars($d['title_en']) ?>" <?= $selectedDestination === $d['title_en'] ? 'selected' : '' ?>><?= htmlspecialchars(t($d['title_en'], $d['title_ar'])) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label"><?= t('Package', 'الباقة') ?></label>
              <div class="input-icon"><i class="bi bi-suitcase"></i>
                <select name="package" class="form-select">
                  <option value=""><?= t('None / not sure yet', 'لا شيء / لست متأكدًا بعد') ?></option>
                  <?php foreach ($packages as $p): ?>
                  <option value="<?= htmlspecialchars($p['slug']) ?>" <?= $selectedPackage === $p['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($p['title_en']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label"><?= t('Message', 'الرسالة') ?></label>
              <textarea name="message" rows="4" class="form-control" placeholder="<?= t('Tell us about your ideal trip — dates, interests, budget, anything that helps.', ar_pending()) ?>"><?= $offerRef !== '' ? htmlspecialchars(t('I\'m interested in this offer: ', 'أنا مهتم بهذا العرض: ') . $offerRef) : '' ?></textarea>
            </div>
          </div>

          <button type="submit" class="btn-premium btn-premium--dark" style="margin-top:1.75rem; width:100%; justify-content:center;"><?= t('Send Enquiry', 'إرسال الاستفسار') ?> <i class="bi bi-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></button>
        </form>
      </div>
    </div>

    <aside class="contact-sidebar reveal is-visible">
      <h3><?= t('Prefer to talk?', 'تفضل التحدث معنا؟') ?></h3>
      <p><?= t('Our travel consultants are ready to help you plan the perfect Malaysia itinerary.', ar_pending()) ?></p>

      <div class="contact-sidebar__item">
        <i class="bi bi-envelope"></i>
        <div>
          <span><?= t('Email', 'البريد الإلكتروني') ?></span>
          <a href="mailto:<?= htmlspecialchars($config['contact_email']) ?>"><?= htmlspecialchars($config['contact_email']) ?></a>
        </div>
      </div>
      <div class="contact-sidebar__item">
        <i class="bi bi-telephone"></i>
        <div>
          <span><?= t('Phone', 'الهاتف') ?></span>
          <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $config['contact_phone'])) ?>"><?= htmlspecialchars($config['contact_phone']) ?></a>
        </div>
      </div>
      <div class="contact-sidebar__item">
        <i class="bi bi-building"></i>
        <div>
          <span><?= t('Organized By', 'تنظيم') ?></span>
          <strong><?= htmlspecialchars($config['organizer']) ?></strong>
        </div>
      </div>

      <div class="contact-sidebar__divider"></div>

      <span style="font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; opacity:0.65; display:block; margin-bottom:0.9rem;"><?= t('Follow Us', 'تابعنا') ?></span>
      <div class="contact-sidebar__social">
        <a href="<?= htmlspecialchars($config['instagram']) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="<?= htmlspecialchars($config['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
      </div>
    </aside>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
