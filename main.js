/**
 * Easy Lot Cayman — front-end behaviour.
 *
 * Everything is progressive: without JS the page still reads, the videos are
 * still linked and the FAQ answers are still in the HTML (and in the FAQPage
 * schema), they just do not animate.
 */
function easylotBoot() {
	'use strict';

	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function $(sel, root) { return (root || document).querySelector(sel); }
	function $$(sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); }

	/* Treat Enter/Space on a role="button" like a click. */
	function clickable(el, fn) {
		if (!el) return;
		el.addEventListener('click', fn);
		el.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
				e.preventDefault();
				fn(e);
			}
		});
	}

	/* ------------------------------------------------------------------
	 * Sticky nav shadow + read progress bar
	 * ------------------------------------------------------------------ */
	(function nav() {
		var bar = $('#site-nav');
		var progress = $('#read-progress');
		if (!bar) return;

		var ticking = false;
		function update() {
			var y = window.scrollY || window.pageYOffset;
			bar.classList.toggle('is-stuck', y > 12);

			if (progress) {
				var h = document.documentElement.scrollHeight - window.innerHeight;
				progress.style.width = (h > 0 ? Math.min(100, (y / h) * 100) : 0) + '%';
			}
			ticking = false;
		}
		window.addEventListener('scroll', function () {
			if (!ticking) { ticking = true; window.requestAnimationFrame(update); }
		}, { passive: true });
		update();
	}());

	/* ------------------------------------------------------------------
	 * Mobile drawer
	 * ------------------------------------------------------------------ */
	(function drawer() {
		var burger = $('#burger');
		var panel = $('#drawer');
		var close = $('#drawer-close');
		if (!burger || !panel) return;

		function open() {
			panel.classList.add('is-open');
			panel.setAttribute('aria-hidden', 'false');
			burger.setAttribute('aria-expanded', 'true');
			document.body.classList.add('is-locked');
		}
		function shut() {
			panel.classList.remove('is-open');
			panel.setAttribute('aria-hidden', 'true');
			burger.setAttribute('aria-expanded', 'false');
			document.body.classList.remove('is-locked');
		}

		clickable(burger, open);
		clickable(close, shut);
		$$('a', panel).forEach(function (a) { a.addEventListener('click', shut); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && panel.classList.contains('is-open')) shut();
		});
	}());

	/* ------------------------------------------------------------------
	 * Scroll reveal
	 * ------------------------------------------------------------------ */
	(function reveal() {
		var items = $$('.reveal');
		if (!items.length) return;

		if (reduceMotion || !('IntersectionObserver' in window)) {
			items.forEach(function (el) { el.classList.add('is-in'); });
			return;
		}

		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				// Stagger siblings slightly so a grid arrives as a wave.
				var siblings = Array.prototype.indexOf.call(entry.target.parentNode.children, entry.target);
				entry.target.style.transitionDelay = Math.min(siblings, 6) * 70 + 'ms';
				entry.target.classList.add('is-in');
				io.unobserve(entry.target);
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

		items.forEach(function (el) { io.observe(el); });
	}());

	/* ------------------------------------------------------------------
	 * FAQ accordion
	 * ------------------------------------------------------------------ */
	(function faq() {
		$$('.faq__item').forEach(function (item) {
			var q = $('.faq__q', item);
			var a = $('.faq__a', item);
			if (!q || !a) return;

			clickable(q, function () {
				var isOpen = item.classList.contains('is-open');

				// One open at a time inside the same list.
				$$('.faq__item.is-open', item.parentNode).forEach(function (other) {
					if (other === item) return;
					other.classList.remove('is-open');
					$('.faq__q', other).setAttribute('aria-expanded', 'false');
					$('.faq__a', other).style.maxHeight = null;
				});

				item.classList.toggle('is-open', !isOpen);
				q.setAttribute('aria-expanded', String(!isOpen));
				a.style.maxHeight = isOpen ? null : a.scrollHeight + 'px';
			});
		});

		// Keep an open answer the right height when the window is resized.
		window.addEventListener('resize', function () {
			$$('.faq__item.is-open .faq__a').forEach(function (a) {
				a.style.maxHeight = a.scrollHeight + 'px';
			});
		});
	}());

	/* ------------------------------------------------------------------
	 * Video lightbox — shared by the cards and the floating player
	 * ------------------------------------------------------------------ */
	var lightbox = (function () {
		var box = $('#vbox');
		var inner = $('#vbox-inner');
		var slot = $('#vbox-slot');
		var cap = $('#vbox-cap');
		var closeBtn = $('#vbox-close');
		var lastFocus = null;

		if (!box) return { open: function () {}, close: function () {} };

		function close() {
			box.classList.remove('is-open');
			document.body.classList.remove('is-locked');
			window.setTimeout(function () {
				slot.innerHTML = '';
				box.hidden = true;
			}, 300);
			if (lastFocus && lastFocus.focus) lastFocus.focus();
		}

		function open(src, caption, orientation) {
			lastFocus = document.activeElement;
			slot.innerHTML = '';

			var video = document.createElement('video');
			video.src = src;
			video.controls = true;
			video.autoplay = true;
			video.playsInline = true;
			video.setAttribute('playsinline', '');
			video.preload = 'auto';
			slot.appendChild(video);

			inner.classList.toggle('vbox__inner--landscape', orientation === 'landscape');
			cap.textContent = caption || '';
			cap.style.display = caption ? '' : 'none';

			box.hidden = false;
			document.body.classList.add('is-locked');
			// Next frame, so the transition actually runs.
			window.requestAnimationFrame(function () {
				box.classList.add('is-open');
				closeBtn.focus();
				var p = video.play();
				if (p && p.catch) p.catch(function () { /* autoplay refused: controls are there */ });
			});
		}

		clickable(closeBtn, close);
		box.addEventListener('click', function (e) { if (e.target === box) close(); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && box.classList.contains('is-open')) close();
		});

		return { open: open, close: close };
	}());

	/* Video cards — and anything tagged .video-open — open the lightbox. */
	$$('.vcard, .video-open').forEach(function (card) {
		clickable(card, function () {
			lightbox.open(
				card.getAttribute('data-video'),
				card.getAttribute('data-caption'),
				card.getAttribute('data-orientation')
			);
		});
	});

	/* ------------------------------------------------------------------
	 * Video category filter
	 * ------------------------------------------------------------------ */
	(function filters() {
		var pills = $$('[data-filter]');
		var grid = $('#video-grid');
		var empty = $('#video-empty');
		if (!pills.length || !grid) return;

		pills.forEach(function (pill) {
			clickable(pill, function () {
				var want = pill.getAttribute('data-filter');
				pills.forEach(function (p) { p.classList.toggle('is-active', p === pill); });

				var shown = 0;
				$$('.vcard', grid).forEach(function (card) {
					var match = want === 'all' || card.getAttribute('data-category') === want;
					card.style.display = match ? '' : 'none';
					if (match) shown++;
				});
				if (empty) empty.style.display = shown ? 'none' : '';
			});
		});
	}());

	/* ------------------------------------------------------------------
	 * Floating mini player (bottom-left)
	 *
	 * Appears after a short scroll, loops a silent teaser, and hands the full
	 * clip with sound to the lightbox when pressed. Dismissal is remembered
	 * for the session so it does not nag on every page.
	 * ------------------------------------------------------------------ */
	(function miniplayer() {
		var mp = $('#miniplayer');
		if (!mp) return;

		var video = $('#miniplayer-video', mp);
		var closeBtn = $('#miniplayer-close', mp);
		var dismissedKey = 'easylot_intro_dismissed';

		var dismissed = false;
		try { dismissed = window.sessionStorage.getItem(dismissedKey) === '1'; } catch (e) {}
		if (dismissed) { mp.classList.add('is-dismissed'); return; }

		function show() {
			if (mp.classList.contains('is-visible')) return;
			mp.classList.add('is-visible');
			if (video) {
				video.preload = 'auto';
				video.load();
				var p = video.play();
				if (p && p.catch) p.catch(function () { /* the poster stands in */ });
			}
		}

		// Show once the visitor has actually started reading, or after 4s.
		var shown = false;
		function maybeShow() {
			if (shown) return;
			if ((window.scrollY || window.pageYOffset) > 320) { shown = true; show(); }
		}
		window.addEventListener('scroll', maybeShow, { passive: true });
		window.setTimeout(function () { if (!shown) { shown = true; show(); } }, 4000);
		maybeShow();

		clickable(mp, function (e) {
			if (closeBtn && closeBtn.contains(e.target)) return;
			if (video) video.pause();
			lightbox.open(mp.getAttribute('data-full'), mp.getAttribute('data-caption'), 'vertical');
		});

		clickable(closeBtn, function (e) {
			e.stopPropagation();
			mp.classList.add('is-dismissed');
			if (video) video.pause();
			try { window.sessionStorage.setItem(dismissedKey, '1'); } catch (err) {}
		});

		// Do not keep decoding frames on a tab nobody is looking at.
		document.addEventListener('visibilitychange', function () {
			if (!video) return;
			if (document.hidden) {
				video.pause();
			} else if (mp.classList.contains('is-visible') && !mp.classList.contains('is-dismissed')) {
				var p = video.play();
				if (p && p.catch) p.catch(function () {});
			}
		});
	}());

	/* ------------------------------------------------------------------
	 * Payment calculator
	 *
	 * Straight amortisation: the rate is a display default and the figure is
	 * an estimate, which the note under the result says out loud.
	 * ------------------------------------------------------------------ */
	(function calculator() {
		var root = $('#calc');
		if (!root) return;

		var price = $('#calc-price', root);
		var down = $('#calc-down', root);
		var term = $('#calc-term', root);

		var priceOut = $('#calc-price-val', root);
		var downOut = $('#calc-down-val', root);
		var termOut = $('#calc-term-val', root);

		var monthly = $('#calc-monthly-val', root) || $('#calc-monthly', root);
		var depositOut = $('#calc-deposit', root);
		var financedOut = $('#calc-financed', root);

		var RATE = parseFloat(root.getAttribute('data-rate') || '7.5') / 100;

		function money(n) {
			return '$' + Math.round(n).toLocaleString('en-US');
		}

		function run() {
			var p = parseFloat(price.value);
			var d = parseFloat(down.value);
			var years = parseFloat(term.value);

			var deposit = p * (d / 100);
			var financed = p - deposit;
			var n = years * 12;
			var r = RATE / 12;

			var payment = r > 0
				? financed * r / (1 - Math.pow(1 + r, -n))
				: financed / n;

			priceOut.textContent = money(p);
			downOut.textContent = d + '% · ' + money(deposit);
			termOut.textContent = years + ' years';

			monthly.textContent = money(payment);
			depositOut.textContent = money(deposit);
			financedOut.textContent = money(financed);
		}

		[price, down, term].forEach(function (input) {
			if (input) input.addEventListener('input', run);
		});
		run();
	}());
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', easylotBoot);
} else {
	easylotBoot();
}
