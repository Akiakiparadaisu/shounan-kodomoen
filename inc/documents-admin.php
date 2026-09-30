<?php
/**
 * 資料PDFの差し替え — 管理画面
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * メニュー登録
 */
function shonan_documents_admin_menu() {
	add_theme_page(
		'資料の差し替え',
		'資料の差し替え',
		'edit_theme_options',
		'shonan-documents',
		'shonan_documents_admin_page'
	);
}
add_action( 'admin_menu', 'shonan_documents_admin_menu' );

/**
 * 保存
 */
function shonan_documents_admin_save() {
	if ( ! isset( $_POST['shonan_documents_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shonan_documents_nonce'] ) ), 'shonan_documents_save' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$raw   = isset( $_POST['shonan_docs'] ) && is_array( $_POST['shonan_docs'] ) ? wp_unslash( $_POST['shonan_docs'] ) : array();
	$saved = array();

	foreach ( shonan_managed_documents() as $key => $doc ) {
		$saved[ $key ] = absint( $raw[ $key ] ?? 0 );
	}

	update_option( 'shonan_managed_documents', $saved, false );

	$admission = get_option( 'shonan_admission_settings', array() );
	if ( ! is_array( $admission ) ) {
		$admission = array();
	}
	$admission['session_pdf_id'] = absint( $saved['setsumeikai'] ?? 0 );
	update_option( 'shonan_admission_settings', $admission, false );

	add_settings_error(
		'shonan_documents',
		'shonan_documents_saved',
		'資料の設定を保存しました。',
		'success'
	);
}
add_action( 'admin_init', 'shonan_documents_admin_save' );

/**
 * メディアライブラリ
 *
 * @param string $hook 画面フック.
 */
function shonan_documents_admin_assets( $hook ) {
	if ( 'appearance_page_shonan-documents' !== $hook ) {
		return;
	}

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'shonan_documents_admin_assets' );

/**
 * 設定画面
 */
function shonan_documents_admin_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$saved  = get_option( 'shonan_managed_documents', array() );
	$groups = array();
	foreach ( shonan_managed_documents() as $key => $doc ) {
		$groups[ $doc['group'] ][ $key ] = $doc;
	}
	?>
	<div class="wrap">
		<h1>資料の差し替え</h1>
		<?php settings_errors( 'shonan_documents' ); ?>
		<p>PDFを選んで保存すると、サイトの表示が入れ替わります。「差し替えをやめる」は、選んだPDFを取り消してもともとのPDFに戻すボタンです。押したあとも、保存してください。</p>
		<form method="post">
			<?php wp_nonce_field( 'shonan_documents_save', 'shonan_documents_nonce' ); ?>
			<?php foreach ( $groups as $group => $docs ) : ?>
				<div class="postbox" style="max-width:920px;margin-top:1.25rem;">
					<div class="postbox-header"><h2 class="hndle"><?php echo esc_html( $group ); ?></h2></div>
					<div class="inside" style="padding:1rem 1.25rem 1.25rem;">
						<?php foreach ( $docs as $key => $doc ) : ?>
							<?php
							$id = ( is_array( $saved ) && isset( $saved[ $key ] ) ) ? absint( $saved[ $key ] ) : 0;
							if ( ! $id && 'setsumeikai' === $key ) {
								$admission = shonan_get_admission_settings();
								$id        = absint( $admission['session_pdf_id'] ?? 0 );
							}
							$name = $id ? get_the_title( $id ) : 'いまのPDFを表示中';
							?>
							<div class="shonan-doc" data-doc="<?php echo esc_attr( $key ); ?>" style="margin:0 0 1.25rem;padding-bottom:1.1rem;border-bottom:1px solid #dcdcde;">
								<strong><?php echo esc_html( $doc['label'] ); ?></strong>
								<input type="hidden" name="shonan_docs[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( (string) $id ); ?>">
								<p class="shonan-doc__name" style="margin:0.35rem 0 0.7rem;color:#50575e;"><?php echo esc_html( $name ); ?></p>
								<button type="button" class="button shonan-doc__pick">資料を選ぶ</button>
								<button type="button" class="button shonan-doc__clear">差し替えをやめる</button>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
			<?php submit_button( '設定を保存する' ); ?>
		</form>
	</div>
	<script>
	jQuery(function ($) {
		$('.shonan-doc__pick').on('click', function (e) {
			e.preventDefault();
			var box = $(this).closest('.shonan-doc');
			var frame = wp.media({
				title: '資料を選ぶ',
				button: { text: 'この資料を使う' },
				library: { type: 'application/pdf' },
				multiple: false
			});
			frame.on('select', function () {
				var file = frame.state().get('selection').first().toJSON();
				box.find('input[type="hidden"]').val(file.id);
				box.find('.shonan-doc__name').text(file.filename || file.title);
			});
			frame.open();
		});
		$('.shonan-doc__clear').on('click', function (e) {
			e.preventDefault();
			var box = $(this).closest('.shonan-doc');
			box.find('input[type="hidden"]').val('0');
			box.find('.shonan-doc__name').text('いまのPDFを表示中');
		});
	});
	</script>
	<?php
}
