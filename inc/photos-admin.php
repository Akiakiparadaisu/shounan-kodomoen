<?php
/**
 * 写真の差し替え — 管理画面
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * メニュー
 */
function shonan_photos_admin_menu() {
	add_theme_page(
		'写真の差し替え',
		'写真の差し替え',
		'edit_theme_options',
		'shonan-photos',
		'shonan_photos_admin_page'
	);
}
add_action( 'admin_menu', 'shonan_photos_admin_menu' );

/**
 * 保存
 */
function shonan_photos_admin_save() {
	if ( ! isset( $_POST['shonan_photos_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shonan_photos_nonce'] ) ), 'shonan_photos_save' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$raw   = isset( $_POST['shonan_photos'] ) && is_array( $_POST['shonan_photos'] ) ? wp_unslash( $_POST['shonan_photos'] ) : array();
	$saved = array();

	foreach ( shonan_content_photo_catalog() as $items ) {
		foreach ( $items as $item ) {
			$path = $item['path'];
			$id   = isset( $raw[ $path ] ) ? absint( $raw[ $path ] ) : 0;
			if ( $id && wp_attachment_is_image( $id ) ) {
				$saved[ $path ] = $id;
			}
		}
	}

	update_option( 'shonan_content_photos', $saved, false );

	add_settings_error(
		'shonan_photos',
		'shonan_photos_saved',
		'写真の設定を保存しました。',
		'success'
	);
}
add_action( 'admin_init', 'shonan_photos_admin_save' );

/**
 * メディアライブラリ
 *
 * @param string $hook 画面フック.
 */
function shonan_photos_admin_assets( $hook ) {
	if ( 'appearance_page_shonan-photos' !== $hook ) {
		return;
	}

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'shonan_photos_admin_assets' );

/**
 * 設定画面
 */
function shonan_photos_admin_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$saved = shonan_content_photo_overrides();
	?>
	<div class="wrap shonan-photos">
		<h1>写真の差し替え</h1>
		<?php settings_errors( 'shonan_photos' ); ?>
		<p>各ページに出ている写真です。新しい写真を選んで、最後に「設定を保存する」を押すと、サイトの表示が入れ替わります。「もともとの写真に戻す」は、選んだ写真を取り消すボタンです。押したあとも保存してください。</p>
		<form method="post">
			<?php wp_nonce_field( 'shonan_photos_save', 'shonan_photos_nonce' ); ?>
			<?php foreach ( shonan_content_photo_catalog() as $group => $items ) : ?>
				<div class="postbox">
					<div class="postbox-header"><h2 class="hndle"><?php echo esc_html( $group ); ?></h2></div>
					<div class="inside">
						<div class="shonan-photos__grid">
							<?php foreach ( $items as $item ) : ?>
								<?php
								$path     = $item['path'];
								$id       = isset( $saved[ $path ] ) ? absint( $saved[ $path ] ) : 0;
								$fallback = shonan_photo_file_url( $path );
								$current  = $id ? wp_get_attachment_image_url( $id, 'medium' ) : '';
								if ( ! $current ) {
									$current = $fallback;
									$id      = 0;
								}
								?>
								<div class="shonan-photo" data-fallback="<?php echo esc_url( $fallback ); ?>">
									<p class="shonan-photo__label"><?php echo esc_html( $item['label'] ); ?></p>
									<img class="shonan-photo__preview" src="<?php echo esc_url( $current ); ?>" alt="">
									<input type="hidden" name="shonan_photos[<?php echo esc_attr( $path ); ?>]" value="<?php echo esc_attr( (string) $id ); ?>">
									<p class="shonan-photo__state"><?php echo $id ? '差し替え中' : 'もともとの写真'; ?></p>
									<button type="button" class="button shonan-photo__pick">写真を選ぶ</button>
									<button type="button" class="button shonan-photo__clear">もともとの写真に戻す</button>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<?php submit_button( '設定を保存する' ); ?>
		</form>
	</div>
	<style>
		.shonan-photos .postbox{max-width:1100px;margin-top:1.25rem}
		.shonan-photos .inside{padding:1rem 1.25rem 1.25rem}
		.shonan-photos__grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px}
		.shonan-photo{padding:12px;background:#fff;border:1px solid #dcdcde;border-radius:8px}
		.shonan-photo__label{margin:0 0 8px;font-weight:600}
		.shonan-photo__preview{display:block;width:100%;height:140px;object-fit:contain;background:#f6f7f7;border-radius:6px}
		.shonan-photo__state{margin:8px 0;color:#50575e;font-size:12px}
		.shonan-photo .button{margin:0 6px 6px 0}
	</style>
	<script>
	jQuery(function ($) {
		var frame;
		var box;
		$('.shonan-photo__pick').on('click', function (e) {
			e.preventDefault();
			box = $(this).closest('.shonan-photo');
			if (!frame) {
				frame = wp.media({
					title: '写真を選ぶ',
					button: { text: 'この写真を使う' },
					library: { type: 'image' },
					multiple: false
				});
				frame.on('select', function () {
					var file = frame.state().get('selection').first().toJSON();
					var url = (file.sizes && file.sizes.medium && file.sizes.medium.url) ? file.sizes.medium.url : file.url;
					box.find('input[type="hidden"]').val(file.id);
					box.find('.shonan-photo__preview').attr('src', url);
					box.find('.shonan-photo__state').text('差し替え中');
				});
			}
			frame.open();
		});
		$('.shonan-photo__clear').on('click', function (e) {
			e.preventDefault();
			var card = $(this).closest('.shonan-photo');
			card.find('input[type="hidden"]').val('0');
			card.find('.shonan-photo__preview').attr('src', card.attr('data-fallback'));
			card.find('.shonan-photo__state').text('もともとの写真');
		});
	});
	</script>
	<?php
}
