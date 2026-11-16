/* AgriVoice AI — motion.js
   Peningkatan progresif: bila JS gagal, halaman tetap tampil normal. */
(function () {
  'use strict';
  window.__moPublic = true;
  var doc = document, root = doc.documentElement;
  var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = window.matchMedia && matchMedia('(hover:hover) and (pointer:fine)').matches;
  var $ = function (s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); };

  /* ---------- Bilah progres gulir + navbar + tombol ke atas ---------- */
  var bar = doc.createElement('div'); bar.className = 'scroll-progress'; bar.setAttribute('aria-hidden', 'true');
  doc.body.appendChild(bar);
  var nav = doc.querySelector('.navbar');
  var top = doc.createElement('button');
  top.className = 'to-top'; top.type = 'button'; top.setAttribute('aria-label', 'Kembali ke atas');
  top.innerHTML = '<svg viewBox="0 0 24 24"><path d="M12 19V5M6 11l6-6 6 6"/></svg>';
  top.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' }); });
  doc.body.appendChild(top);

  var lastY = 0, ticking = false, hero = doc.querySelector('.hero,.page-hero');
  function onScroll() {
    var y = window.pageYOffset, h = doc.documentElement.scrollHeight - window.innerHeight;
    bar.style.transform = 'scaleX(' + (h > 0 ? Math.min(y / h, 1) : 0) + ')';
    if (nav) {
      nav.classList.toggle('scrolled', y > 24);
      var open = doc.querySelector('.nav-links.open');
      nav.classList.toggle('hide', y > lastY + 6 && y > 420 && !open);
      if (y < lastY - 6 || y < 420) nav.classList.remove('hide');
    }
    top.classList.toggle('show', y > 700);
    if (hero && !reduce && window.innerWidth > 650 && y < window.innerHeight * 1.2) {
      hero.style.backgroundPosition = 'center,center,center,center ' + (42 + y * 0.012) + '%,center bottom,center';
    }
    lastY = y; ticking = false;
  }
  window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
  onScroll();

  if (reduce) return; // sisanya khusus gerak

  /* ---------- Judul hero: kata demi kata ---------- */
  var h1 = doc.querySelector('.hero h1');
  if (h1 && !h1.querySelector('*')) {
    var words = h1.textContent.trim().split(/\s+/);
    h1.setAttribute('aria-label', h1.textContent.trim());
    h1.innerHTML = words.map(function (w, i) {
      return '<span class="w" aria-hidden="true" style="--i:' + i + '">' + w + '</span>';
    }).join(' ');
    h1.classList.add('split');
  }

  /* ---------- Partikel cahaya di hero ---------- */
  if (hero) {
    var motes = doc.createElement('div'); motes.className = 'motes'; motes.setAttribute('aria-hidden', 'true');
    var n = window.innerWidth < 650 ? 12 : 22, out = '';
    for (var i = 0; i < n; i++) {
      out += '<i style="--x:' + (Math.random() * 100).toFixed(1) + '%;--s:' + (4 + Math.random() * 9).toFixed(1) +
        'px;--d:' + (9 + Math.random() * 10).toFixed(1) + 's;--dl:' + (-Math.random() * 14).toFixed(1) +
        's;--dx:' + ((Math.random() - .5) * 140).toFixed(0) + 'px"></i>';
    }
    motes.innerHTML = out; hero.insertBefore(motes, hero.firstChild);
  }

  /* ---------- Muncul saat digulir (reveal + stagger) ---------- */
  var groups = [
    ['.section-head', 0, ''], ['.demo-copy', 0, 'rv-left'], ['.demo-card', 0, 'rv-right'],
    ['.about-image', 0, 'rv-left'], ['.about-copy', 0, 'rv-right'], ['.detail-media', 0, 'rv-left'], ['.detail-copy', 0, 'rv-right'],
    ['.contact-copy', 0, 'rv-left'], ['.cta', 0, 'rv-zoom'], ['.subnav', 0, ''],
    ['.cards .card', 1, ''], ['.cards-link .card', 1, ''], ['.support-title', 0, ''], ['.support>*:not(.support-title)', 1, ''],
    ['.why-grid>*', 1, ''], ['.news-card', 1, ''], ['.materi-card', 1, ''], ['.contact-item', 1, 'rv-right'],
    ['.shot', 1, 'rv-zoom'], ['.shot-note', 0, ''], ['.index>li', 1, 'rv-left'], ['.check-list', 0, ''],
    ['.steps-phone', 0, 'rv-right'], ['.note,.section-foot', 0, '']
  ];
  var targets = [];
  groups.forEach(function (g) {
    $(g[0]).forEach(function (el, idx) {
      if (el.classList.contains('rv')) return;
      el.classList.add('rv'); if (g[2]) el.classList.add(g[2]);
      if (g[1]) el.style.setProperty('--rd', Math.min(idx % 4, 3));
      targets.push(el);
    });
  });
  $('.step').forEach(function (el, i) { el.classList.add('rv'); el.style.setProperty('--rd', 0); targets.push(el); });

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    targets.forEach(function (el) { io.observe(el); });
  } else { targets.forEach(function (el) { el.classList.add('in'); }); }

  /* ---------- Kartu: miring 3D + sorot kursor ---------- */
  if (fine) {
    $('.card,.materi-card,.news-card,.contact-item').forEach(function (c) {
      c.classList.add('spot');
      if (c.matches('.cards .card,.cards-link .card,.materi-card,.news-card')) c.classList.add('tilt');
      c.addEventListener('pointermove', function (e) {
        var r = c.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top;
        c.style.setProperty('--mx', x + 'px'); c.style.setProperty('--my', y + 'px');
        if (c.classList.contains('tilt')) {
          var rx = ((y / r.height) - .5) * -7, ry = ((x / r.width) - .5) * 9;
          c.style.transform = 'perspective(900px) rotateX(' + rx.toFixed(2) + 'deg) rotateY(' + ry.toFixed(2) + 'deg) translateY(-8px)';
          c.classList.add('tilting');
        }
      });
      c.addEventListener('pointerleave', function () {
        c.style.transform = ''; c.classList.remove('tilting');
      });
    });
  }

  /* ---------- Tombol: riak + magnet halus ---------- */
  $('.btn').forEach(function (b) {
    b.addEventListener('pointerdown', function (e) {
      var r = b.getBoundingClientRect(), s = Math.max(r.width, r.height), d = doc.createElement('span');
      d.className = 'ripple'; d.style.width = d.style.height = s + 'px';
      d.style.left = (e.clientX - r.left - s / 2) + 'px'; d.style.top = (e.clientY - r.top - s / 2) + 'px';
      b.appendChild(d); setTimeout(function () { d.remove(); }, 700);
    });
    if (fine && b.matches('.btn-pill,.nav-cta,.cta .btn')) {
      b.addEventListener('pointermove', function (e) {
        var r = b.getBoundingClientRect();
        b.style.translate = ((e.clientX - r.left - r.width / 2) * .14).toFixed(1) + 'px ' + ((e.clientY - r.top - r.height / 2) * .22).toFixed(1) + 'px';
      });
      b.addEventListener('pointerleave', function () { b.style.translate = ''; });
    }
  });

  /* ---------- Transisi halus saat pindah halaman ---------- */
  $('a[href]').forEach(function (a) {
    var href = a.getAttribute('href');
    if (!href || href.charAt(0) === '#' || /^(https?:|mailto:|tel:)/.test(href) || a.target === '_blank' || a.hasAttribute('download')) return;
    a.addEventListener('click', function (e) {
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.button) return;
      e.preventDefault(); doc.body.classList.add('leaving');
      setTimeout(function () { location.href = a.href; }, 260);
    });
  });
  window.addEventListener('pageshow', function (e) { if (e.persisted) doc.body.classList.remove('leaving'); });
})();
