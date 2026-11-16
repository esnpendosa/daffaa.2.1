/* AgriVoice AI — motion-admin.js : animasi & kenyamanan form (peningkatan progresif) */
(function () {
  'use strict';
  window.__moAdmin = true;
  var doc = document;
  var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); };

  /* ---------- Partikel di latar login/install ---------- */
  var wrap = doc.querySelector('.login-wrap');
  if (wrap && !reduce) {
    var m = doc.createElement('div'); m.className = 'motes'; m.setAttribute('aria-hidden', 'true');
    var out = '';
    for (var i = 0; i < 18; i++) {
      out += '<i style="--x:' + (Math.random() * 100).toFixed(1) + '%;--s:' + (4 + Math.random() * 8).toFixed(1) +
        'px;--d:' + (10 + Math.random() * 10).toFixed(1) + 's;--dl:' + (-Math.random() * 14).toFixed(1) +
        's;--dx:' + ((Math.random() - .5) * 120).toFixed(0) + 'px"></i>';
    }
    m.innerHTML = out; wrap.insertBefore(m, wrap.firstChild);
  }

  /* ---------- Urutan muncul kolom form ---------- */
  $('form .field, form .form-actions').forEach(function (el, i) { el.style.setProperty('--fi', Math.min(i, 14)); });
  $('tbody').forEach(function (tb) { $('tr', tb).forEach(function (tr, i) { tr.style.setProperty('--ri', Math.min(i, 12)); }); });

  /* ---------- Kartu & statistik muncul saat digulir ---------- */
  var items = $('.card, .stat');
  items.forEach(function (el, i) { el.style.setProperty('--ci', Math.min(i % 5, 4)); });
  if ('IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.08 });
    items.forEach(function (el) { io.observe(el); });
  } else { items.forEach(function (el) { el.classList.add('in'); }); }

  /* ---------- Hitung naik pada angka statistik ---------- */
  if (!reduce) {
    $('.stat b').forEach(function (b) {
      var end = parseInt(b.textContent, 10);
      if (isNaN(end) || end <= 0) return;
      var t0 = null, dur = 1100;
      b.textContent = '0';
      function step(t) {
        if (!t0) t0 = t;
        var p = Math.min((t - t0) / dur, 1), eased = 1 - Math.pow(1 - p, 3);
        b.textContent = Math.round(end * eased);
        if (p < 1) requestAnimationFrame(step);
      }
      setTimeout(function () { requestAnimationFrame(step); }, 350);
    });
  }

  /* ---------- Tombol: riak + keadaan memuat saat kirim ---------- */
  $('.btn').forEach(function (b) {
    b.addEventListener('pointerdown', function (e) {
      if (reduce) return;
      var r = b.getBoundingClientRect(), s = Math.max(r.width, r.height), d = doc.createElement('span');
      d.className = 'ripple'; d.style.width = d.style.height = s + 'px';
      d.style.left = (e.clientX - r.left - s / 2) + 'px'; d.style.top = (e.clientY - r.top - s / 2) + 'px';
      b.appendChild(d); setTimeout(function () { d.remove(); }, 650);
    });
  });
  $('form').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      if (e.defaultPrevented) return;
      var btn = f.querySelector('button[type=submit].btn:not(.btn-sm), button.btn[type=submit]');
      if (!btn || btn.classList.contains('btn-sm')) return;
      if (f.checkValidity && !f.checkValidity()) return;
      // tunda sedikit agar nilai tombol tetap terkirim, lalu tampilkan putaran
      setTimeout(function () { btn.classList.add('loading'); }, 0);
    });
    // tandai kolom tidak valid dengan goyangan
    f.addEventListener('invalid', function (e) {
      var fld = e.target.closest && e.target.closest('.field');
      if (fld) { fld.classList.remove('is-invalid'); void fld.offsetWidth; fld.classList.add('is-invalid'); }
    }, true);
    f.addEventListener('input', function (e) {
      var fld = e.target.closest && e.target.closest('.field');
      if (fld) fld.classList.remove('is-invalid');
    });
  });
  window.addEventListener('pageshow', function () { $('.btn.loading').forEach(function (b) { b.classList.remove('loading'); }); });

  /* ---------- Tombol mata + meter kekuatan kata sandi ---------- */
  var eyeOn = '<svg viewBox="0 0 24 24" class="ono"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>' +
              '<svg viewBox="0 0 24 24" class="off"><path d="M17.9 17.9A10.9 10.9 0 0 1 12 20C5 20 1 12 1 12a18.5 18.5 0 0 1 5.1-5.9M9.9 4.2A9.8 9.8 0 0 1 12 4c7 0 11 8 11 8a18.6 18.6 0 0 1-2.2 3.2M1 1l22 22"/></svg>';
  $('input[type=password]').forEach(function (inp) {
    var w = doc.createElement('div'); w.className = 'pw-wrap';
    inp.parentNode.insertBefore(w, inp); w.appendChild(inp);
    var b = doc.createElement('button'); b.type = 'button'; b.className = 'pw-eye';
    b.setAttribute('aria-label', 'Tampilkan kata sandi'); b.innerHTML = eyeOn;
    b.addEventListener('click', function () {
      var show = inp.type === 'password'; inp.type = show ? 'text' : 'password';
      b.classList.toggle('on', show);
      b.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });
    w.appendChild(b);
    if (inp.autocomplete === 'new-password' && /^(password|new_password)$/.test(inp.name)) {
      var meter = doc.createElement('div'); meter.className = 'pw-meter'; meter.setAttribute('aria-hidden', 'true');
      meter.innerHTML = '<i></i>'; w.parentNode.insertBefore(meter, w.nextSibling);
      inp.addEventListener('input', function () {
        var v = inp.value, s = 0;
        if (v.length >= 8) s++; if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s++; if (/\d/.test(v)) s++; if (/[^A-Za-z0-9]/.test(v) || v.length >= 14) s++;
        meter.dataset.l = v ? s : 0; meter.firstChild.style.width = (v ? Math.max(s, 1) * 25 : 0) + '%';
      });
    }
  });

  /* ---------- Peringatan sukses hilang sendiri ---------- */
  $('.alert-ok').forEach(function (a) {
    if (a.closest('.login-card')) return;
    setTimeout(function () { a.classList.add('out'); setTimeout(function () { a.remove(); }, 600); }, 5000);
  });
})();
