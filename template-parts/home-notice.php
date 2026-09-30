<?php
/**
 * トップページの告知
 *
 * @package Shonan_Kodomoen
 */

if ( ! shonan_announcement_is_active() ) {
	return;
}

$settings = shonan_get_announcement();
$image    = $settings['image_id'] ? wp_get_attachment_image_url( $settings['image_id'], 'large' ) : '';
$alt      = $settings['image_id'] ? (string) get_post_meta( $settings['image_id'], '_wp_attachment_image_alt', true ) : '';
?>
<div class="site-notice" id="shonan-notice" data-rev="<?php echo esc_attr( shonan_announcement_revision() ); ?>" hidden>
	<div class="site-notice__backdrop" data-notice-close></div>
	<div class="site-notice__dialog" role="dialog" aria-modal="true" aria-labelledby="shonan-notice-title">
		<button class="site-notice__close" type="button" data-notice-close aria-label="閉じる">×</button>
		<?php if ( $image ) : ?>
			<figure class="site-notice__photo">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
			</figure>
		<?php endif; ?>
		<div class="site-notice__body">
			<?php if ( '' !== $settings['title'] ) : ?>
				<h2 class="site-notice__title" id="shonan-notice-title"><?php echo esc_html( $settings['title'] ); ?></h2>
			<?php else : ?>
				<h2 class="screen-reader-text" id="shonan-notice-title">お知らせ</h2>
			<?php endif; ?>
			<?php if ( '' !== trim( $settings['body'] ) ) : ?>
				<div class="site-notice__text">
					<?php echo wp_kses_post( wpautop( $settings['body'] ) ); ?>
				</div>
			<?php endif; ?>
			<?php
			$pdf_url = $settings['pdf_id'] ? wp_get_attachment_url( $settings['pdf_id'] ) : '';
			?>
			<?php if ( $pdf_url ) : ?>
				<p class="site-notice__file">
					<a class="btn btn--outline" href="<?php echo esc_url( $pdf_url ); ?>" target="_blank" rel="noopener noreferrer">PDFを開く</a>
				</p>
			<?php endif; ?>
			<label class="site-notice__dismiss">
				<input type="checkbox" id="shonan-notice-dismiss">
				次回以降表示しない
			</label>
			<button class="btn btn--solid" type="button" data-notice-close>閉じる</button>
		</div>
	</div>
</div>
<script>
(function () {
  var modal = document.getElementById('shonan-notice');
  if (!modal) return;
  var key = 'shonan-notice';
  var rev = modal.getAttribute('data-rev') || '';
  try {
    if (window.localStorage.getItem(key) === rev) return;
  } catch (e) {}
  modal.hidden = false;
  var box = document.getElementById('shonan-notice-dismiss');
  function closeNotice() {
    if (box && box.checked) {
      try { window.localStorage.setItem(key, rev); } catch (e) {}
    }
    modal.hidden = true;
  }
  modal.querySelectorAll('[data-notice-close]').forEach(function (el) {
    el.addEventListener('click', closeNotice);
  });
})();
</script>
