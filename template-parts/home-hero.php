<?php
/**
 * ホームページ：ヒーロー
 *
 * @package Shonan_Kodomoen
 */

$hero_src = shonan_placeholder( 'top' );
?>
<section class="hero" aria-label="湘南こども園 トップビジュアル">
	<div class="hero__media">
		<svg class="hero__canvas" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" aria-hidden="true">
			<defs>
				<mask id="hero-brush-mask" maskUnits="userSpaceOnUse" maskContentUnits="userSpaceOnUse">
					<rect class="hero-paint__matte" fill="#000"></rect>
					<path class="hero-paint__stroke"></path>
					<path class="hero-paint__stroke"></path>
					<path class="hero-paint__stroke"></path>
					<path class="hero-paint__stroke"></path>
					<path class="hero-paint__stroke"></path>
					<path class="hero-paint__stroke"></path>
				</mask>
			</defs>
			<image class="hero__photo" href="<?php echo esc_url( $hero_src ); ?>" xlink:href="<?php echo esc_url( $hero_src ); ?>" preserveAspectRatio="xMidYMin slice" mask="url(#hero-brush-mask)"></image>
		</svg>
	</div>
	<div class="hero__veil" aria-hidden="true"></div>
	<div class="hero-paint" aria-hidden="true">
		<img
			class="hero-paint__brush"
			src="<?php echo esc_url( SHONAN_THEME_URI . '/assets/images/brush.png' ); ?>"
			alt=""
			width="793"
			height="1983"
			decoding="async"
		>
	</div>
	<div class="hero__content">
		<h1 class="hero__brand">湘南こども園</h1>
	</div>
	<div class="hero__wave" aria-hidden="true">
		<svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
			<path fill="currentColor" d="M0,64 C240,120 480,0 720,40 C960,80 1200,120 1440,48 L1440,120 L0,120 Z"></path>
		</svg>
	</div>
</section>
<script>
(function () {
	var hero = document.querySelector('.hero');
	if (!hero || hero.dataset.paintBound === '1') return;
	hero.dataset.paintBound = '1';

	var strokes = hero.querySelectorAll('.hero-paint__stroke');
	var brush = hero.querySelector('.hero-paint__brush');
	var photo = hero.querySelector('.hero__photo');
	if (!strokes.length || !brush || !photo) return;

	var rows = [
		{ delay: 360, duration: 820 },
		{ delay: 1320, duration: 1180 },
		{ delay: 2680, duration: 1180 },
		{ delay: 4020, duration: 1180 },
		{ delay: 5520, duration: 1180 },
		{ delay: 6860, duration: 1180 }
	];
	var plan = [
		{ x0: 0.5, y0: 0.48, x1: 1.05, y1: 0.46, bow: 1 },
		{ x0: 1.05, y0: 0.46, x1: -0.05, y1: 0.5, bow: -1 },
		{ x0: -0.05, y0: 0.32, x1: 1.05, y1: 0.26, bow: 1 },
		{ x0: 1.05, y0: 0.14, x1: -0.05, y1: 0.08, bow: -1 },
		{ x0: -0.05, y0: 0.66, x1: 1.05, y1: 0.7, bow: 1 },
		{ x0: 1.05, y0: 0.86, x1: -0.05, y1: 0.94, bow: -1 }
	];
	var lengths = [];
	var canvas = hero.querySelector('.hero__canvas');
	var matte = hero.querySelector('.hero-paint__matte');

	function ease(t) {
		if (t <= 0) return 0;
		if (t >= 1) return 1;
		return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
	}

	function layout() {
		var box = canvas.getBoundingClientRect();
		var w = Math.max(1, box.width);
		var h = Math.max(1, box.height);
		var sw = h * 0.26;
		var amp = h * 0.03;
		canvas.setAttribute('viewBox', '0 0 ' + w + ' ' + h);
		photo.setAttribute('x', '0');
		photo.setAttribute('y', '0');
		photo.setAttribute('width', String(w));
		photo.setAttribute('height', String(h));
		matte.setAttribute('x', String(-w));
		matte.setAttribute('y', String(-h));
		matte.setAttribute('width', String(w * 3));
		matte.setAttribute('height', String(h * 3));
		strokes.forEach(function (path, index) {
			var step = plan[index];
			var x0 = step.x0 * w;
			var x1 = step.x1 * w;
			var y0 = step.y0 * h;
			var y1 = step.y1 * h;
			var dx = x1 - x0;
			var d = 'M' + x0 + ',' + y0
				+ ' C' + (x0 + dx * 0.34) + ',' + (y0 - step.bow * amp)
				+ ' ' + (x0 + dx * 0.68) + ',' + (y1 + step.bow * amp)
				+ ' ' + x1 + ',' + y1;
			var shown = lengths[index] ? 1 - (parseFloat(path.style.strokeDashoffset) || 0) / lengths[index] : 0;
			if (shown < 0) shown = 0;
			if (shown > 1) shown = 1;
			path.setAttribute('d', d);
			path.style.strokeWidth = String(sw);
			var len = path.getTotalLength();
			lengths[index] = len;
			path.style.strokeDasharray = String(len);
			path.style.strokeDashoffset = String(len * (1 - shown));
		});
	}

	layout();

	var started = 0;

	function tip(path, len, amount) {
		var point = path.getPointAtLength(Math.max(0, Math.min(len, len * amount)));
		var sw = parseFloat(strokes[0].style.strokeWidth) || 0;
		return { x: point.x, y: point.y + sw * 0.5 };
	}

	function leanOf(path, len, amount) {
		var dist = Math.max(28, len * 0.02);
		var a = path.getPointAtLength(Math.max(0, len * amount - dist));
		var b = path.getPointAtLength(Math.min(len, len * amount + dist));
		var dx = b.x - a.x;
		var dy = b.y - a.y;
		var lean = dx >= 0 ? 8 : -8;
		lean += dy * 0.06;
		if (lean > 14) lean = 14;
		if (lean < -14) lean = -14;
		return lean;
	}

	function setBrush(x, y, tilt, opacity) {
		brush.style.left = x + 'px';
		brush.style.top = y + 'px';
		brush.style.transform = 'translate(-50%, -100%) rotate(' + tilt.toFixed(2) + 'deg)';
		brush.style.opacity = String(opacity);
	}

	function finish() {
		photo.removeAttribute('mask');
		hero.classList.add('is-painted');
		brush.style.opacity = '0';
	}

	function frame(now) {
		if (!started) started = now;
		var t = now - started;
		var active = -1;
		var last = rows[rows.length - 1];
		var end = last.delay + last.duration;

		strokes.forEach(function (path, index) {
			var row = rows[index];
			var progress = ease((t - row.delay) / row.duration);
			path.style.strokeDashoffset = String(lengths[index] * (1 - progress));
			if (t >= row.delay && t <= row.delay + row.duration) active = index;
		});

		if (t < rows[0].delay) {
			var origin = tip(strokes[0], lengths[0], 0);
			setBrush(origin.x, origin.y, 0, Math.max(0, t / rows[0].delay));
		} else if (active >= 0) {
			var row = rows[active];
			var amount = ease((t - row.delay) / row.duration);
			var point = tip(strokes[active], lengths[active], amount);
			setBrush(point.x, point.y, leanOf(strokes[active], lengths[active], amount), 1);
		} else if (t > end + 380) {
			finish();
			return;
		} else if (t > end) {
			var lift = (t - end) / 380;
			var done = tip(strokes[strokes.length - 1], lengths[lengths.length - 1], 1);
			setBrush(done.x, done.y - Math.sin(lift * Math.PI) * 46, leanOf(strokes[strokes.length - 1], lengths[lengths.length - 1], 1), 1 - lift);
		} else {
			var prev = 0;
			rows.forEach(function (row, index) {
				if (t > row.delay + row.duration) prev = index;
			});
			var next = prev + 1;
			var from = tip(strokes[prev], lengths[prev], 1);
			var to = tip(strokes[next], lengths[next], 0);
			var span = rows[next].delay - (rows[prev].delay + rows[prev].duration);
			var travel = ease(span > 0 ? (t - (rows[prev].delay + rows[prev].duration)) / span : 1);
			var rise = Math.sin(travel * Math.PI) * Math.min(42, Math.abs(to.y - from.y) * 0.28 + 16);
			var tilt = leanOf(strokes[prev], lengths[prev], 1) + (leanOf(strokes[next], lengths[next], 0) - leanOf(strokes[prev], lengths[prev], 1)) * travel;
			setBrush(from.x + (to.x - from.x) * travel, from.y + (to.y - from.y) * travel - rise, tilt, 1);
		}

		window.requestAnimationFrame(frame);
	}

	hero.classList.add('is-painting');
	window.requestAnimationFrame(frame);
	window.addEventListener('resize', layout);
})();
</script>
