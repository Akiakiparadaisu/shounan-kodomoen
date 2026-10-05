/**
 * 湘南こども園 フロントスクリプト
 */
(function () {
  'use strict';

  document.documentElement.classList.add('js-reveal');

  var header = document.getElementById('site-header');
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('primary-nav');

  function onScroll() {
    if (!header) return;
    header.classList.toggle('is-scrolled', window.scrollY > 12);
  }

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!open));
      toggle.setAttribute('aria-label', open ? 'メニューを開く' : 'メニューを閉じる');
      nav.classList.toggle('is-open', !open);
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'メニューを開く');
        nav.classList.remove('is-open');
      });
    });
  }

  function markReveal(el) {
    if (!el || el.classList.contains('reveal') || el.hasAttribute('data-reveal')) {
      return;
    }
    if (el.closest('.hero') || el.closest('.site-header') || el.closest('.site-footer')) {
      return;
    }
    el.classList.add('reveal');
    el.setAttribute('data-reveal', '');
  }

  // 全ページ共通：スクロールで出す対象
  var autoRevealSelectors = [
    '.page-shell .page-header',
    '.page-shell .policy-visual',
    '.page-shell .history-visual',
    '.page-shell .enseikatsu-visual',
    '.page-shell .shisetsu-visual',
    '.page-article > section',
    '.page-article > nav',
    '.page-article section',
    '.facility-gallery__header',
    '.facility-card',
    '.access-panel',
    '.nyuen-appeal__card',
    '.nyuen-target-card',
    '.nyuen-visit__inner',
    '.nyuen-session-card',
    '.nyuen-gansho__card',
    '.hours-panel',
    '.outfit-block',
    '.nyuen-junior__inner',
    '.nyuen-contact__inner',
    '.kyujin-message__panel',
    '.kyujin-work-card',
    '.kyujin-link-card',
    '.kyujin-access__panel',
    '.mirai-intro__panel',
    '.mirai-pillar',
    '.mirai-wish__inner',
    '.mirai-contact__inner',
    '.history-chapter',
    '.history-compare__item',
    '.history-story',
    '.history-pillar',
    '.history-guidance__card',
    '.history-growth__grid',
    '.history-chart',
    '.history-support__card',
    '.history-achi',
    '.history-founder',
    '.history-npo__item',
    '.history-media__card',
    '.history-contact__inner',
    '.special-card',
    '.special-block',
    '.pre-card',
    '.pre-block',
    '.policy-pillar',
    '.policy-card',
    '.bus-panel',
    '.safety-panel',
    '.food-panel',
    '.section-header',
    'main .section',
    'main .section__inner'
  ];

  document.querySelectorAll(autoRevealSelectors.join(',')).forEach(markReveal);

  // トップページの主要ブロックも漏れなく
  document.querySelectorAll(
    '.mission__copy, .mission__visual, .guide-block, .news-list, .news-aside, .section-header'
  ).forEach(markReveal);

  // カード群は順番に遅延
  document.querySelectorAll(
    '.facility-gallery__grid, .nyuen-appeal__grid, .nyuen-targets__grid, .nyuen-sessions__grid, .nyuen-gansho__grid, .kyujin-workplace__grid, .kyujin-links__grid, .history-pillars, .history-guidance, .history-support__grid, .history-founders__grid, .history-npo__grid, .history-media__grid, .history-compare, .mirai-pillars__list, .policy-pillars, .policy-guidance__list, .mission__grid, .news__layout'
  ).forEach(function (group) {
    var items = group.querySelectorAll('.reveal');
    items.forEach(function (item, index) {
      if (index > 0 && index < 10) {
        item.style.transitionDelay = (index * 0.07) + 's';
      }
    });
  });

  var reveals = Array.prototype.slice.call(
    document.querySelectorAll('.reveal, [data-reveal]')
  );

  function showEl(el) {
    if (!el || el.classList.contains('is-visible')) {
      return;
    }
    el.classList.add('is-visible');
  }

  // 画面に入った・通り過ぎた要素を表示（大きなブロックでも確実に）
  function revealInView() {
    var vh = window.innerHeight || document.documentElement.clientHeight;
    var line = vh * 0.92;
    reveals.forEach(function (el) {
      if (el.classList.contains('is-visible') || el.closest('.hero')) {
        return;
      }
      var rect = el.getBoundingClientRect();
      if (rect.top < line) {
        showEl(el);
      }
    });
  }

  if ('IntersectionObserver' in window && reveals.length) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting || entry.intersectionRatio > 0) {
            showEl(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0, rootMargin: '0px 0px -6% 0px' }
    );

    reveals.forEach(function (el) {
      observer.observe(el);
    });
  }

  // ヒーローは即表示
  document.querySelectorAll('.hero .reveal, .hero [data-reveal]').forEach(showEl);

  var scrollQueued = false;
  function onScrollFrame() {
    scrollQueued = false;
    onScroll();
    revealInView();
    revealFlowSteps();
  }
  function queueScrollWork() {
    if (scrollQueued) return;
    scrollQueued = true;
    window.requestAnimationFrame(onScrollFrame);
  }

  window.requestAnimationFrame(function () {
    window.setTimeout(revealInView, 60);
  });

  window.addEventListener('scroll', queueScrollWork, { passive: true });
  window.addEventListener('resize', queueScrollWork, { passive: true });
  onScroll();
  revealInView();

  // 一日の流れは、各時刻が画面に入った順に出す
  function revealFlowSteps() {
    var vh = window.innerHeight || document.documentElement.clientHeight;
    document.querySelectorAll('.flow-step').forEach(function (step) {
      if (step.classList.contains('is-in') || step.closest('[hidden]')) {
        return;
      }
      var rect = step.getBoundingClientRect();
      if (rect.top < vh * 0.78 && rect.bottom > 40) {
        step.classList.add('is-in');
      }
    });
  }

  window.setTimeout(revealFlowSteps, 200);

  // 一日の流れタブ
  var dailyTabs = document.querySelectorAll('[data-daily-tab]');
  if (dailyTabs.length) {
    dailyTabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var key = tab.getAttribute('data-daily-tab');
        dailyTabs.forEach(function (btn) {
          var active = btn === tab;
          btn.classList.toggle('is-active', active);
          btn.setAttribute('aria-selected', String(active));
        });
        document.querySelectorAll('[data-daily-panel]').forEach(function (panel) {
          var show = panel.getAttribute('data-daily-panel') === key;
          if (show) {
            panel.removeAttribute('hidden');
            panel.classList.remove('is-active');
            void panel.offsetWidth;
            panel.classList.add('is-active');
            panel.querySelectorAll('.flow-step').forEach(function (step) {
              step.classList.remove('is-in');
            });
            window.setTimeout(revealFlowSteps, 40);
          } else {
            panel.classList.remove('is-active');
            panel.setAttribute('hidden', '');
          }
        });
      });
    });
  }

  function eventGrid(panel) {
    return panel ? panel.querySelector('.year-events__grid') : null;
  }

  function pileEventCards(grid, animate) {
    if (!grid) return;
    grid.classList.add('is-ready');
    var cards = grid.querySelectorAll('.event-card');
    cards.forEach(function (card, i) {
      var dx = grid.clientWidth / 2 - (card.offsetLeft + card.offsetWidth / 2);
      var dy = grid.clientHeight / 2 - (card.offsetTop + card.offsetHeight / 2);
      var rot = (i % 2 === 0 ? -1 : 1) * (7 + (i % 4) * 3);
      card.style.zIndex = String(20 + i);
      card.style.transition = animate ? 'transform 0.6s cubic-bezier(0.22, 1, 0.36, 1)' : 'none';
      card.classList.add('is-back');
      card.style.transform = 'translate(' + dx + 'px,' + dy + 'px) rotate(' + rot + 'deg)';
    });
  }

  function dealEventCards(grid) {
    if (!grid) return;
    var cards = grid.querySelectorAll('.event-card');
    cards.forEach(function (card, i) {
      window.setTimeout(function () {
        card.style.zIndex = String(40 + cards.length - i);
        card.style.transition = 'transform 0.75s cubic-bezier(0.22, 1, 0.36, 1)';
        card.style.transform = 'translate(0px, 0px) rotate(0deg)';
        card.classList.remove('is-back');
        window.setTimeout(function () {
          card.style.zIndex = '';
        }, 780);
      }, 180 + i * 130);
    });
  }

  var eventTabs = document.querySelectorAll('[data-events-tab]');
  if (eventTabs.length) {
    var eventKey = '1';
    var eventBusy = false;

    function showEventPanel(key) {
      document.querySelectorAll('[data-events-panel]').forEach(function (panel) {
        var show = panel.getAttribute('data-events-panel') === key;
        panel.classList.toggle('is-active', show);
        if (show) {
          panel.removeAttribute('hidden');
        } else {
          panel.setAttribute('hidden', '');
        }
      });
    }

    function activateEventTab(key, instant) {
      eventTabs.forEach(function (btn) {
        var active = btn.getAttribute('data-events-tab') === key;
        btn.classList.toggle('is-active', active);
        btn.setAttribute('aria-selected', String(active));
      });

      if (instant || key === eventKey) {
        showEventPanel(key);
        eventKey = key;
        return;
      }

      if (eventBusy) return;
      eventBusy = true;
      var currentPanel = document.querySelector('[data-events-panel="' + eventKey + '"]');
      var nextPanel = document.querySelector('[data-events-panel="' + key + '"]');
      pileEventCards(eventGrid(currentPanel), true);

      window.setTimeout(function () {
        showEventPanel(key);
        var grid = eventGrid(nextPanel);
        pileEventCards(grid, false);
        window.requestAnimationFrame(function () {
          dealEventCards(grid);
          eventKey = key;
          eventBusy = false;
        });
      }, 640);
    }

    eventTabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        activateEventTab(tab.getAttribute('data-events-tab'), false);
      });
    });

    activateEventTab('1', true);
    var firstGrid = eventGrid(document.querySelector('[data-events-panel="1"]'));
    pileEventCards(firstGrid, false);

    function dealWhenSeen() {
      if (!firstGrid) return;
      var rect = firstGrid.getBoundingClientRect();
      var vh = window.innerHeight || document.documentElement.clientHeight;
      if (rect.top < vh * 0.72 && rect.bottom > 80 && eventKey === '1' && !firstGrid.dataset.dealt) {
        firstGrid.dataset.dealt = '1';
        dealEventCards(firstGrid);
        window.removeEventListener('scroll', dealWhenSeen);
      }
    }

    window.addEventListener('scroll', dealWhenSeen, { passive: true });
    window.setTimeout(dealWhenSeen, 240);
  }

  var busRoads = Array.prototype.slice.call(document.querySelectorAll('[data-bus-road]'));
  if (busRoads.length) {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var busDriveMs = reduceMotion ? 3200 : 14000;

    function finishBus(road) {
      if (road.classList.contains('is-passed')) return;
      road.classList.remove('is-driving');
      road.classList.add('is-passed');
    }

    function runBus(road) {
      if (road.dataset.busStarted === '1') return;
      road.dataset.busStarted = '1';

      var track = road.querySelector('.bus-road__track');
      var runner = road.querySelector('.bus-road__runner');
      if (!track || !runner) {
        finishBus(road);
        return;
      }

      /* 初期は必ず車線を出し、最終状態クラスを付けない */
      road.classList.remove('is-passed');
      road.classList.add('is-driving');
      runner.style.transform = 'translate3d(-120%, 0, 0)';

      var distance = track.clientWidth + runner.offsetWidth * 1.2;
      var start = null;

      function frame(now) {
        if (start === null) start = now;
        var t = Math.min(1, (now - start) / busDriveMs);
        var x = -runner.offsetWidth * 1.05 + distance * t;
        runner.style.transform = 'translate3d(' + x + 'px, 0, 0)';
        if (t < 1) {
          window.requestAnimationFrame(frame);
          return;
        }
        finishBus(road);
      }

      window.requestAnimationFrame(frame);
    }

    if ('IntersectionObserver' in window) {
      var busObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting || entry.intersectionRatio > 0) {
              runBus(entry.target);
              busObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.2, rootMargin: '0px 0px -10% 0px' }
      );
      busRoads.forEach(function (road) {
        busObserver.observe(road);
      });
    } else {
      window.setTimeout(function () {
        busRoads.forEach(runBus);
      }, 400);
    }
  }

  window.shonanUnrollHistoryScroll = window.shonanUnrollHistoryScroll || function () {
    var el = document.querySelector('[data-scroll-unroll]');
    if (!el || el.classList.contains('is-unrolled')) {
      return;
    }
    el.classList.add('is-unrolled');
  };
})();
