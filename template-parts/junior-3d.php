<?php
/**
 * 湘南ジュニア 3D建物
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$viewer = SHONAN_THEME_URI . '/shonan_junior_3d/index.html?embed=1&v=27';
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
	function openViewer() {
		if (frame && !frame.getAttribute('src')) frame.setAttribute('src', frame.getAttribute('data-src'));
		if (dialog.showModal) dialog.showModal();
	}
	document.addEventListener('click', function (event) {
		var button = event.target.closest('[data-junior-3d-open]');
		if (!button) return;
		openViewer();
	});
	dialog.querySelector('[data-junior-3d-close]').addEventListener('click', function () {
		dialog.close();
	});
	dialog.addEventListener('click', function (event) {
		if (event.target === dialog) dialog.close();
	});
	if (new URLSearchParams(location.search).get('building') === '1') openViewer();
})();
</script>
