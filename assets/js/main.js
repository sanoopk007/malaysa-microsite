(function () {
  'use strict';

  var header = document.getElementById('siteHeader');
  var isRtl = document.documentElement.getAttribute('dir') === 'rtl';

  /* ---- Sticky header colour transition ---- */
  function onScroll() {
    if (!header) return;
    if (window.scrollY > 40) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---- Logo swap on scroll (Visit Malaysia + Khimji lockups) ---- */
  var swapLogos = document.querySelectorAll('.logo-scroll-swap');
  if (swapLogos.length && header) {
    var swap = function () {
      var wantLight = header.classList.contains('is-scrolled');
      swapLogos.forEach(function (logo) {
        var target = wantLight ? logo.dataset.light : logo.dataset.dark;
        if (target && logo.getAttribute('src') !== target) logo.setAttribute('src', target);
      });
    };
    window.addEventListener('scroll', swap, { passive: true });
    swap();
  }

  /* ---- Desktop mega menu (hover + click for touch/keyboard) ---- */
  var megaParent = document.querySelector('.has-mega');
  var megaToggle = document.getElementById('attractionsToggle');
  if (megaParent && megaToggle) {
    var closeMega = function () {
      megaParent.classList.remove('is-open');
      megaToggle.setAttribute('aria-expanded', 'false');
    };
    var openMega = function () {
      megaParent.classList.add('is-open');
      megaToggle.setAttribute('aria-expanded', 'true');
    };
    megaToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      megaParent.classList.contains('is-open') ? closeMega() : openMega();
    });
    megaParent.addEventListener('mouseenter', openMega);
    megaParent.addEventListener('mouseleave', closeMega);
    document.addEventListener('click', closeMega);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMega(); });
  }

  /* ---- Mobile drawer ---- */
  var menuToggle = document.getElementById('menuToggle');
  var drawer = document.getElementById('mobileDrawer');
  var drawerClose = document.getElementById('drawerClose');
  var backdrop = document.getElementById('drawerBackdrop');

  function openDrawer() {
    drawer.classList.add('is-open');
    backdrop.classList.add('is-open');
    drawer.setAttribute('aria-hidden', 'false');
    menuToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }
  function closeDrawer() {
    drawer.classList.remove('is-open');
    backdrop.classList.remove('is-open');
    drawer.setAttribute('aria-hidden', 'true');
    menuToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }
  if (menuToggle && drawer) {
    menuToggle.addEventListener('click', openDrawer);
    drawerClose.addEventListener('click', closeDrawer);
    backdrop.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeDrawer(); });
  }

  var drawerAttractionsToggle = document.getElementById('drawerAttractionsToggle');
  if (drawerAttractionsToggle) {
    drawerAttractionsToggle.addEventListener('click', function () {
      this.closest('.mobile-drawer__item').classList.toggle('is-open');
    });
  }

  /* ---- Hero entrance ---- */
  var hero = document.querySelector('.hero');
  if (hero) {
    requestAnimationFrame(function () {
      setTimeout(function () { hero.classList.add('is-ready'); }, 150);
    });
  }

  /* ---- Hero video: only ever requested on desktop/tablet viewports.
     No <source> is written into the markup until the media query matches,
     so mobile visitors never trigger a network request for the video. ---- */
  var heroVideo = document.getElementById('heroVideo');
  if (heroVideo && heroVideo.dataset.src) {
    var heroVideoActivated = false;
    var activateHeroVideo = function () {
      if (heroVideoActivated) return;
      heroVideoActivated = true;
      var source = document.createElement('source');
      source.setAttribute('src', heroVideo.dataset.src);
      source.setAttribute('type', 'video/mp4');
      heroVideo.appendChild(source);
      heroVideo.load();
      heroVideo.addEventListener('playing', function () {
        heroVideo.classList.add('is-active');
      }, { once: true });
      heroVideo.play().catch(function () {});
    };
    var heroVideoMq = window.matchMedia('(min-width: 769px)');
    if (heroVideoMq.matches) activateHeroVideo();
    if (heroVideoMq.addEventListener) {
      heroVideoMq.addEventListener('change', function (e) { if (e.matches) activateHeroVideo(); });
    } else if (heroVideoMq.addListener) {
      heroVideoMq.addListener(function (e) { if (e.matches) activateHeroVideo(); });
    }
  }

  /* ---- Scroll reveal ---- */
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* ---- Premium cursor-aware interactions ----
     Only attached on devices with a real pointer and no reduced-motion
     preference, so touch/mobile and motion-sensitive users never pay the
     (tiny) per-frame cost and never get a stuck "hover" from a tap. */
  var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var supportsFinePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  if (supportsFinePointer && !prefersReduced) {
    document.querySelectorAll('.package-card').forEach(function (card) {
      var media = card.querySelector('.package-card__media');
      var raf = null;
      var lastEvent = null;
      function applyTilt() {
        var rect = card.getBoundingClientRect();
        var px = (lastEvent.clientX - rect.left) / rect.width;
        var py = (lastEvent.clientY - rect.top) / rect.height;
        card.style.setProperty('--tilt-y', ((px - 0.5) * 5).toFixed(2) + 'deg');
        card.style.setProperty('--tilt-x', ((0.5 - py) * 5).toFixed(2) + 'deg');
        if (media) {
          var mrect = media.getBoundingClientRect();
          var mx = (lastEvent.clientX - mrect.left) / mrect.width;
          var my = (lastEvent.clientY - mrect.top) / mrect.height;
          media.style.setProperty('--mx', (mx * 100).toFixed(1) + '%');
          media.style.setProperty('--my', (my * 100).toFixed(1) + '%');
        }
        var img = card.querySelector('.package-card__media img');
        if (img) {
          img.style.setProperty('--img-x', ((0.5 - px) * 8).toFixed(1) + 'px');
          img.style.setProperty('--img-y', ((0.5 - py) * 8).toFixed(1) + 'px');
        }
        raf = null;
      }
      card.addEventListener('mousemove', function (e) {
        lastEvent = e;
        if (!raf) raf = requestAnimationFrame(applyTilt);
      });
      card.addEventListener('mouseleave', function () {
        card.style.setProperty('--tilt-x', '0deg');
        card.style.setProperty('--tilt-y', '0deg');
        var img = card.querySelector('.package-card__media img');
        if (img) { img.style.setProperty('--img-x', '0px'); img.style.setProperty('--img-y', '0px'); }
      });
    });

    document.querySelectorAll('.btn-premium--outline').forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var rect = btn.getBoundingClientRect();
        btn.style.setProperty('--spot-x', (((e.clientX - rect.left) / rect.width) * 100).toFixed(1) + '%');
        btn.style.setProperty('--spot-y', (((e.clientY - rect.top) / rect.height) * 100).toFixed(1) + '%');
      });
    });
  }

  /* ---- Final CTA subtle parallax (skipped for reduced motion) ---- */
  var ctaBg = document.querySelector('.final-cta__bg');
  if (ctaBg && !prefersReduced) {
    window.addEventListener('scroll', function () {
      var rect = ctaBg.parentElement.getBoundingClientRect();
      if (rect.bottom > 0 && rect.top < window.innerHeight) {
        var offset = (rect.top) * -0.08;
        ctaBg.style.transform = 'translateY(' + offset + 'px)';
      }
    }, { passive: true });
  }

  /* ---- Swiper sliders ---- */
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper === 'undefined') return;

    document.querySelectorAll('.gallery-swiper').forEach(function (el) {
      var gallerySwiper = new Swiper(el, {
        slidesPerView: 1.1,
        spaceBetween: 14,
        rtl: isRtl,
        observer: true,
        observeParents: true,
        resizeObserver: true,
        breakpoints: { 768: { slidesPerView: 2.3 }, 1200: { slidesPerView: 3.2 } },
        navigation: {
          nextEl: el.parentElement.querySelector('.gallery-next'),
          prevEl: el.parentElement.querySelector('.gallery-prev')
        }
      });
      window.addEventListener('load', function () { gallerySwiper.update(); });
    });

    /* ---- Gallery lightbox ---- */
    var lightbox = document.getElementById('galleryLightbox');
    if (lightbox) {
      var lightboxImg = document.getElementById('lightboxImg');
      var lightboxCaption = document.getElementById('lightboxCaption');
      var lightboxClose = document.getElementById('lightboxClose');
      var lastFocused = null;

      function openLightbox(src, caption) {
        lastFocused = document.activeElement;
        lightboxImg.setAttribute('src', src);
        lightboxImg.setAttribute('alt', caption);
        lightboxCaption.textContent = caption;
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        lightboxClose.focus();
      }
      function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (lastFocused) lastFocused.focus();
      }

      document.querySelectorAll('.gallery-thumb').forEach(function (btn) {
        btn.addEventListener('click', function () {
          openLightbox(btn.dataset.src, btn.dataset.caption);
        });
      });
      lightboxClose.addEventListener('click', closeLightbox);
      lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
      });
    }
  });

  /* ---- Enquiry form: loading state, prevents double-submit ---- */
  var enquiryForm = document.querySelector('form[action="includes/send-enquiry.php"]');
  if (enquiryForm) {
    var recaptchaSiteKey = enquiryForm.dataset.recaptchaSitekey;
    var recaptchaTokenInput = document.getElementById('recaptchaToken');
    var enquirySubmitting = false;

    var showSendingState = function (submitBtn) {
      if (submitBtn.dataset.originalHtml === undefined) {
        submitBtn.dataset.originalHtml = submitBtn.innerHTML;
      }
      submitBtn.disabled = true;
      submitBtn.setAttribute('aria-busy', 'true');
      submitBtn.innerHTML = isRtl ? 'جاري الإرسال…' : 'Sending…';
    };

    enquiryForm.addEventListener('submit', function (e) {
      var submitBtn = enquiryForm.querySelector('button[type="submit"]');
      if (enquirySubmitting) {
        e.preventDefault();
        return;
      }

      // reCAPTCHA v3 is invisible and generates its token asynchronously, so
      // the real submit is deferred until the token is ready.
      if (typeof grecaptcha === 'undefined' || !recaptchaSiteKey || !recaptchaTokenInput) {
        if (submitBtn) showSendingState(submitBtn);
        return; // let it submit without a token; the server handles that gracefully
      }

      e.preventDefault();
      enquirySubmitting = true;
      if (submitBtn) showSendingState(submitBtn);

      grecaptcha.ready(function () {
        grecaptcha.execute(recaptchaSiteKey, { action: 'contact_form' }).then(function (token) {
          recaptchaTokenInput.value = token;
          enquiryForm.submit();
        }).catch(function () {
          enquiryForm.submit();
        });
      });
    });
  }
})();
