<?php
/**
 * トップの告知 — 管理画面
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * メニュー登録
 */
function shonan_announcement_admin_menu() {
	add_theme_page(
		'トップの告知',
		'トップの告知',
		'edit_theme_options',
		'shonan-announcement',
		'shonan_announcement_admin_page'
	);
}
add_action( 'admin_menu', 'shonan_announcement_admin_menu' );

/**
 * 文字色と文字サイズをエディタに出す
 *
 * @param array $buttons ツールバー.
 * @return array
 */
function shonan_announcement_mce_buttons( $buttons ) {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'appearance_page_shonan-announcement' !== $screen->id ) {
		return $buttons;
	}
	if ( ! in_array( 'fontsizeselect', $buttons, true ) ) {
		$buttons[] = 'fontsizeselect';
	}
	if ( ! in_array( 'forecolor', $buttons, true ) ) {
		$buttons[] = 'forecolor';
	}
	return $buttons;
}
add_filter( 'mce_buttons_2', 'shonan_announcement_mce_buttons' );

/**
 * 保存
 */
function shonan_announcement_admin_save() {
	if ( ! isset( $_POST['shonan_announcement_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shonan_announcement_nonce'] ) ), 'shonan_announcement_save' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$raw  = isset( $_POST['shonan_announcement'] ) && is_array( $_POST['shonan_announcement'] ) ? wp_unslash( $_POST['shonan_announcement'] ) : array();
	$body    = isset( $raw['body'] ) ? wp_kses_post( $raw['body'] ) : '';
	$hide_at = isset( $raw['hide_at'] ) ? sanitize_text_field( $raw['hide_at'] ) : '';
	$hide_at = str_replace( 'T', ' ', $hide_at );
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $hide_at ) ) {
		$hide_at = '';
	}

	$image_id = absint( $raw['image_id'] ?? 0 );
	$pdf_id   = absint( $raw['pdf_id'] ?? 0 );
	if ( $pdf_id && 'application/pdf' !== get_post_mime_type( $pdf_id ) ) {
		$pdf_id = 0;
	}

	update_option(
		'shonan_announcement',
		array(
			'enabled'  => ! empty( $raw['enabled'] ),
			'title'    => sanitize_text_field( $raw['title'] ?? '' ),
			'body'     => $body,
			'image_id' => $image_id,
			'pdf_id'   => $pdf_id,
			'hide_at'  => $hide_at,
		),
		false
	);

	add_settings_error(
		'shonan_announcement',
		'shonan_announcement_saved',
		'トップの告知を保存しました。内容を変えると、以前に「表示しない」を選んだ人にも再び表示されます。',
		'success'
	);
}
add_action( 'admin_init', 'shonan_announcement_admin_save' );

/**
 * メディア
 *
 * @param string $hook 画面フック.
 */
function shonan_announcement_admin_assets( $hook ) {
	if ( 'appearance_page_shonan-announcement' !== $hook ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'shonan_announcement_admin_assets' );

/**
 * 設定画面
 */
function shonan_announcement_admin_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$settings  = shonan_get_announcement();
	$image     = $settings['image_id'] ? wp_get_attachment_image_url( $settings['image_id'], 'medium' ) : '';
	$hide_attr = '' !== $settings['hide_at'] ? str_replace( ' ', 'T', $settings['hide_at'] ) : '';
	$expired   = shonan_announcement_is_expired( $settings );
	?>
	<div class="wrap">
		<h1>トップの告知</h1>
		<?php settings_errors( 'shonan_announcement' ); ?>
		<p>トップページを開いたときに表示します。文章では文字の色と大きさを変えられます。「次回以降表示しない」にチェックした人には、内容を変えて保存するまで再表示しません。</p>
		<form method="post">
			<?php wp_nonce_field( 'shonan_announcement_save', 'shonan_announcement_nonce' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">表示</th>
					<td>
						<label>
							<input type="checkbox" name="shonan_announcement[enabled]" value="1" <?php checked( $settings['enabled'] ); ?>>
							トップページで告知を表示する
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="shonan-announce-hide">非表示にする日時</label></th>
					<td>
						<input type="datetime-local" id="shonan-announce-hide" name="shonan_announcement[hide_at]" value="<?php echo esc_attr( $hide_attr ); ?>">
						<?php if ( $expired ) : ?>
							<p class="description">この日時を過ぎているため、いまは表示されていません。</p>
						<?php else : ?>
							<p class="description">この日時になると、自動で表示されなくなります。空欄のままにすると、表示のチェックを外すまで出続けます。</p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="shonan-announce-title">タイトル</label></th>
					<td>
						<input type="text" class="large-text" id="shonan-announce-title" name="shonan_announcement[title]" value="<?php echo esc_attr( $settings['title'] ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">文章</th>
					<td>
						<?php
						wp_editor(
							$settings['body'],
							'shonan_announcement_body',
							array(
								'textarea_name' => 'shonan_announcement[body]',
								'textarea_rows' => 10,
								'media_buttons' => false,
								'teeny'         => false,
							)
						);
						?>
						<p class="description">2段目のツールバーで、文字サイズと文字色を選べます。</p>
					</td>
				</tr>
				<tr>
					<th scope="row">写真</th>
					<td>
						<input type="hidden" name="shonan_announcement[image_id]" id="shonan-announce-image" value="<?php echo esc_attr( (string) $settings['image_id'] ); ?>">
						<div id="shonan-announce-preview" style="margin-bottom:0.6rem;">
							<?php if ( $image ) : ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="" style="max-width:280px;height:auto;border-radius:8px;">
							<?php endif; ?>
						</div>
						<button type="button" class="button" id="shonan-announce-pick">写真を選ぶ</button>
						<button type="button" class="button" id="shonan-announce-clear">写真を外す</button>
					</td>
				</tr>
				<tr>
					<th scope="row">PDF</th>
					<td>
						<?php
						$pdf_name = $settings['pdf_id'] ? get_the_title( $settings['pdf_id'] ) : '';
						?>
						<input type="hidden" name="shonan_announcement[pdf_id]" id="shonan-announce-pdf" value="<?php echo esc_attr( (string) $settings['pdf_id'] ); ?>">
						<p id="shonan-announce-pdf-name" style="margin-top:0;"><?php echo esc_html( $pdf_name ? $pdf_name : '未設定' ); ?></p>
						<button type="button" class="button" id="shonan-announce-pdf-pick">PDFを選ぶ</button>
						<button type="button" class="button" id="shonan-announce-pdf-clear">PDFを外す</button>
					</td>
				</tr>
			</table>
			<?php submit_button( '設定を保存する' ); ?>
		</form>
	</div>
	<script>
	jQuery(function ($) {
		var frame;
		$('#shonan-announce-pick').on('click', function (e) {
			e.preventDefault();
			if (frame) {
				frame.open();
				return;
			}
			frame = wp.media({
				title: '告知の写真',
				button: { text: 'この写真を使う' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var file = frame.state().get('selection').first().toJSON();
				var url = (file.sizes && file.sizes.medium) ? file.sizes.medium.url : file.url;
				$('#shonan-announce-image').val(file.id);
				$('#shonan-announce-preview').html('<img src="' + url + '" alt="" style="max-width:280px;height:auto;border-radius:8px;">');
			});
			frame.open();
		});
		$('#shonan-announce-clear').on('click', function (e) {
			e.preventDefault();
			$('#shonan-announce-image').val('0');
			$('#shonan-announce-preview').empty();
		});
		var pdfFrame;
		$('#shonan-announce-pdf-pick').on('click', function (e) {
			e.preventDefault();
			if (pdfFrame) {
				pdfFrame.open();
				return;
			}
			pdfFrame = wp.media({
				title: '告知のPDF',
				button: { text: 'このPDFを使う' },
				library: { type: 'application/pdf' },
				multiple: false
			});
			pdfFrame.on('select', function () {
				var file = pdfFrame.state().get('selection').first().toJSON();
				$('#shonan-announce-pdf').val(file.id);
				$('#shonan-announce-pdf-name').text(file.filename || file.title);
			});
			pdfFrame.open();
		});
		$('#shonan-announce-pdf-clear').on('click', function (e) {
			e.preventDefault();
			$('#shonan-announce-pdf').val('0');
			$('#shonan-announce-pdf-name').text('未設定');
		});
	});
	</script>
	<?php
}
