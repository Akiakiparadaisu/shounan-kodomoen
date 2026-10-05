<?php
/**
 * 湘南ジュニア 3D建物
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$viewer = SHONAN_THEME_URI . '/shonan_junior_3d/view.php?embed=1';
?>
<dialog class="junior-3d" id="junior-3d">
	<div class="junior-3d__panel">
		<div class="junior-3d__bar">
			<p class="junior-3d__title">湘南ジュニア＆誰でも通園の建物</p>
			<button type="button" class="junior-3d__close" data-junior-3d-close>閉じる</button>
		</div>
		<iframe class="junior-3d__frame" title="湘南ジュニアの3D建物" data-src="<?php echo esc_url( $viewer ); ?>" loading="lazy"></iframe>
	</div>
</dialog>
<script>
(function () {
	var dialog = document.getElementById('junior-3d');
	if (!dialog || dialog.dataset.ready) return;
	dialog.dataset.ready = '1';
	var frame = dialog.querySelector('iframe');
	var unloadTimer = 0;

	function postToViewer(action) {
		try {
			if (frame && frame.contentWindow) {
				frame.contentWindow.postMessage({ type: 'junior-3d', action: action }, '*');
			}
		} catch (error) {}
	}

	function clearFrame() {
		if (!frame) return;
		postToViewer('pause');
		frame.removeAttribute('src');
	}

	function openViewer() {
		if (unloadTimer) {
			clearTimeout(unloadTimer);
			unloadTimer = 0;
		}
		document.documentElement.classList.add('is-junior-3d-open');
		if (frame) {
			var base = frame.getAttribute('data-src');
			if (!frame.getAttribute('src')) {
				frame.setAttribute('src', base);
			} else {
				postToViewer('resume');
			}
		}
		if (dialog.showModal) dialog.showModal();
	}

	function closeViewer() {
		postToViewer('pause');
		document.documentElement.classList.remove('is-junior-3d-open');
		dialog.close();
		/* 閉じたあともGPUを使い続けない。少し待ってから破棄し、すぐ開き直したときは残す */
		unloadTimer = setTimeout(clearFrame, 1200);
	}

	document.addEventListener('click', function (event) {
		var button = event.target.closest('[data-junior-3d-open]');
		if (!button) return;
		openViewer();
	});
	dialog.querySelector('[data-junior-3d-close]').addEventListener('click', closeViewer);
	dialog.addEventListener('click', function (event) {
		if (event.target === dialog) closeViewer();
	});
	dialog.addEventListener('close', function () {
		postToViewer('pause');
		document.documentElement.classList.remove('is-junior-3d-open');
		if (!unloadTimer) unloadTimer = setTimeout(clearFrame, 1200);
	});
	if (new URLSearchParams(location.search).get('building') === '1') openViewer();
})();
</script>
