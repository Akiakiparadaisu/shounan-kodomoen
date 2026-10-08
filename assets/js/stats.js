(function () {
  'use strict';

  if (!window.shonanStats) return;

  var cfg = window.shonanStats;
  var maxSeconds = 1800;

  function visitorToken() {
    var match = document.cookie.match(/(?:^|; )shonan_vid=([a-f0-9]{32})/);
    if (match) return match[1];
    var bytes = new Uint8Array(16);
    if (window.crypto && crypto.getRandomValues) {
      crypto.getRandomValues(bytes);
    } else {
      for (var i = 0; i < bytes.length; i += 1) bytes[i] = Math.floor(Math.random() * 256);
    }
    var token = Array.prototype.map.call(bytes, function (b) {
      return ('0' + b.toString(16)).slice(-2);
    }).join('');
    document.cookie = 'shonan_vid=' + token + '; path=/; max-age=31536000; SameSite=Lax';
    return token;
  }

  function post(fields, beacon) {
    var body = new URLSearchParams();
    body.set('action', 'shonan_stats');
    body.set('nonce', cfg.nonce);
    body.set('token', visitorToken());
    Object.keys(fields).forEach(function (key) {
      body.set(key, String(fields[key]));
    });
    if (beacon && navigator.sendBeacon) {
      navigator.sendBeacon(cfg.ajax, body);
      return Promise.resolve(null);
    }
    return fetch(cfg.ajax, {
      method: 'POST',
      body: body,
      credentials: 'same-origin',
      keepalive: true
    }).then(function (response) {
      return response.json();
    }).catch(function () {
      return null;
    });
  }

  var pageStarted = Date.now();
  var pagePaused = document.visibilityState === 'visible' ? 0 : Date.now();
  var pageId = 0;
  var pageSent = 0;

  function pageSeconds() {
    var paused = pagePaused ? Date.now() - pagePaused : 0;
    return Math.min(maxSeconds, Math.max(0, Math.round((Date.now() - pageStarted - paused) / 1000)));
  }

  function flushPage(beacon) {
    var seconds = pageSeconds();
    if (!pageId || seconds === pageSent) return;
    pageSent = seconds;
    post({ type: 'dwell', id: pageId, seconds: seconds }, beacon);
  }

  post({
    type: 'page',
    path: location.pathname + location.search,
    title: document.title,
    referrer: document.referrer || ''
  }, false).then(function (data) {
    if (data && data.id) pageId = data.id;
  });

  var notice = document.getElementById('shonan-notice');
  var noticeId = 0;
  var noticePending = false;
  var noticeOpen = 0;
  var noticeAccum = 0;
  var noticeSent = 0;
  var noticeClosed = 0;

  function noticeSeconds() {
    var live = noticeOpen ? Date.now() - noticeOpen : 0;
    return Math.min(maxSeconds, Math.round((noticeAccum + live) / 1000));
  }

  function flushNotice(beacon) {
    if (!noticeId) return;
    var seconds = noticeSeconds();
    if (seconds === noticeSent && !noticeClosed) return;
    noticeSent = seconds;
    post({
      type: 'notice_dwell',
      id: noticeId,
      seconds: seconds,
      closed: noticeClosed
    }, beacon);
  }

  function watchNotice() {
    if (!notice || notice.hidden) {
      if (noticeOpen) {
        noticeAccum += Date.now() - noticeOpen;
        noticeOpen = 0;
      }
      return;
    }
    if (!noticeOpen) noticeOpen = Date.now();
    if (noticeId || noticePending) return;
    noticePending = true;
    post({
      type: 'notice',
      title: notice.getAttribute('data-title') || 'お知らせ',
      revision: notice.getAttribute('data-rev') || ''
    }, false).then(function (data) {
      noticePending = false;
      if (data && data.id) noticeId = data.id;
    });
  }

  if (notice) {
    notice.querySelectorAll('[data-notice-close]').forEach(function (el) {
      el.addEventListener('click', function () {
        noticeClosed = 1;
        if (noticeOpen) {
          noticeAccum += Date.now() - noticeOpen;
          noticeOpen = 0;
        }
        flushNotice(true);
      });
    });
    watchNotice();
    window.setInterval(watchNotice, 1000);
  }

  document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'hidden') {
      if (!pagePaused) pagePaused = Date.now();
      if (noticeOpen) {
        noticeAccum += Date.now() - noticeOpen;
        noticeOpen = 0;
      }
      flushPage(true);
      flushNotice(true);
      return;
    }
    if (pagePaused) {
      pageStarted += Date.now() - pagePaused;
      pagePaused = 0;
    }
    if (notice && !notice.hidden) noticeOpen = Date.now();
  });

  window.setInterval(function () {
    flushPage(false);
    flushNotice(false);
  }, 15000);

  window.addEventListener('pagehide', function () {
    flushPage(true);
    flushNotice(true);
  });

  var seenSections = {};
  var sectionNodes = document.querySelectorAll('main h2');
  if (sectionNodes.length && 'IntersectionObserver' in window) {
    var sectionObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var label = (entry.target.textContent || '').replace(/\s+/g, ' ').trim();
        if (!label || seenSections[label]) return;
        seenSections[label] = true;
        sectionObserver.unobserve(entry.target);
        post({
          type: 'section',
          path: location.pathname + location.search,
          label: label.slice(0, 80)
        }, true);
      });
    }, { threshold: 0.5 });
    Array.prototype.forEach.call(sectionNodes, function (node) {
      sectionObserver.observe(node);
    });
  }
})();
