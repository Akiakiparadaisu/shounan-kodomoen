<?php
/**
 * 入園募集設定 — 管理画面
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * メニュー登録
 */
function shonan_admission_admin_menu() {
	add_theme_page(
		'入園募集の設定',
		'入園募集の設定',
		'edit_theme_options',
		'shonan-admission',
		'shonan_admission_admin_page'
	);
}
add_action( 'admin_menu', 'shonan_admission_admin_menu' );

/**
 * 設定の保存処理
 */
function shonan_admission_admin_save() {
	if ( ! isset( $_POST['shonan_admission_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shonan_admission_nonce'] ) ), 'shonan_admission_save' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$defaults = shonan_admission_defaults();
	$raw      = isset( $_POST['shonan_admission'] ) && is_array( $_POST['shonan_admission'] )
		? wp_unslash( $_POST['shonan_admission'] )
		: array();

	$sessions = array();
	for ( $i = 0; $i < 3; $i++ ) {
		$session_in = isset( $raw['sessions'][ $i ] ) && is_array( $raw['sessions'][ $i ] )
			? $raw['sessions'][ $i ]
			: array();

		$sessions[] = array(
			'label' => sanitize_text_field( $session_in['label'] ?? $defaults['sessions'][ $i ]['label'] ),
			'date'  => shonan_admission_sanitize_ymd( $session_in['date'] ?? '' ),
			'time'  => sanitize_text_field( $session_in['time'] ?? '' ),
		);
	}

	$settings = array(
		'year_mode'         => ( isset( $raw['year_mode'] ) && 'manual' === $raw['year_mode'] ) ? 'manual' : 'auto',
		'admission_year'    => absint( $raw['admission_year'] ?? $defaults['admission_year'] ),
		'quota_3'           => sanitize_text_field( $raw['quota_3'] ?? '' ),
		'quota_2'           => sanitize_text_field( $raw['quota_2'] ?? '' ),
		'sessions'          => $sessions,
		'session_place'     => sanitize_text_field( $raw['session_place'] ?? '' ),
		'session_bring'     => sanitize_text_field( $raw['session_bring'] ?? '' ),
		'session_note'      => sanitize_textarea_field( $raw['session_note'] ?? '' ),
		'gansho_distribute' => shonan_admission_sanitize_ymd( $raw['gansho_distribute'] ?? '' ),
		'gansho_accept'     => shonan_admission_sanitize_ymd( $raw['gansho_accept'] ?? '' ),
		'visit_lead'        => sanitize_textarea_field( $raw['visit_lead'] ?? '' ),
		'session_pdf_id'    => absint( $raw['session_pdf_id'] ?? 0 ),
	);

	if ( $settings['admission_year'] < 2019 || $settings['admission_year'] > 2100 ) {
		$settings['admission_year'] = shonan_admission_year_auto();
	}

	update_option( 'shonan_admission_settings', $settings, false );

	add_settings_error(
		'shonan_admission',
		'shonan_admission_saved',
		'入園募集の設定を保存しました。',
		'success'
	);
}
add_action( 'admin_init', 'shonan_admission_admin_save' );

/**
 * Y-m-d の簡易サニタイズ
 *
 * @param string $ymd 日付文字列.
 * @return string
 */
function shonan_admission_sanitize_ymd( $ymd ) {
	$ymd = sanitize_text_field( $ymd );
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $ymd ) ) {
		return $ymd;
	}
	return '';
}

/**
 * 管理画面用スタイル
 */
function shonan_admission_admin_assets( $hook ) {
	if ( 'appearance_page_shonan-admission' !== $hook ) {
		return;
	}

	wp_enqueue_media();

	wp_add_inline_style(
		'wp-admin',
		'
		.shonan-adm { max-width: 920px; }
		.shonan-adm__hero {
			margin: 1.25rem 0 1.5rem;
			padding: 1.1rem 1.25rem;
			border-left: 4px solid #7ec8e3;
			background: #f7fcff;
			border-radius: 0 8px 8px 0;
		}
		.shonan-adm__hero p { margin: 0.35rem 0 0; color: #50575e; }
		.shonan-adm .postbox { margin-bottom: 1.25rem; }
		.shonan-adm .postbox .inside { padding: 1rem 1.25rem 1.25rem; }
		.shonan-adm__grid {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1rem 1.5rem;
		}
		.shonan-adm__grid--3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
		.shonan-adm label.block { display: block; font-weight: 600; margin-bottom: 0.35rem; }
		.shonan-adm .hint { color: #646970; font-size: 12px; margin: 0.35rem 0 0; }
		.shonan-adm input[type="text"],
		.shonan-adm input[type="number"],
		.shonan-adm input[type="date"],
		.shonan-adm textarea,
		.shonan-adm select { width: 100%; max-width: 100%; }
		.shonan-adm textarea { min-height: 5rem; }
		.shonan-adm__preview {
			margin-top: 1rem;
			padding: 0.9rem 1rem;
			background: #fff8f0;
			border: 1px solid #f0d7b8;
			border-radius: 8px;
		}
		.shonan-adm__preview h4 { margin: 0 0 0.5rem; }
		.shonan-adm__preview ul { margin: 0; padding-left: 1.2rem; }
		.shonan-adm__session {
			padding: 0.85rem 1rem;
			margin-bottom: 0.75rem;
			background: #f6f7f7;
			border-radius: 8px;
		}
		.shonan-adm__session h4 { margin: 0 0 0.75rem; }
		@media (max-width: 782px) {
			.shonan-adm__grid,
			.shonan-adm__grid--3 { grid-template-columns: 1fr; }
		}
		'
	);
}
add_action( 'admin_enqueue_scripts', 'shonan_admission_admin_assets' );

/**
 * 設定画面本体
 */
function shonan_admission_admin_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$settings = shonan_get_admission_settings();
	$year     = shonan_admission_year( $settings );
	$targets  = shonan_admission_targets( $settings );
	$nyuen    = get_page_by_path( 'nyuen' );
	?>
	<div class="wrap shonan-adm">
		<h1>入園募集の設定</h1>

		<div class="shonan-adm__hero">
			<strong>毎年変える項目だけを、ここで更新します。</strong>
			<p>
				対象児の生年月日（令和〇年4月2日〜翌年4月1日）は募集年度から<strong>自動計算</strong>されます。日付を入力すると曜日も自動で表示されます。
				<?php if ( $nyuen ) : ?>
					／ <a href="<?php echo esc_url( get_permalink( $nyuen ) ); ?>" target="_blank" rel="noopener">公開ページを見る</a>
				<?php endif; ?>
			</p>
		</div>

		<?php settings_errors( 'shonan_admission' ); ?>

		<form method="post" action="">
			<?php wp_nonce_field( 'shonan_admission_save', 'shonan_admission_nonce' ); ?>

			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle">募集年度</h2></div>
				<div class="inside">
					<div class="shonan-adm__grid">
						<div>
							<label class="block" for="shonan-year-mode">年度の決め方</label>
							<select name="shonan_admission[year_mode]" id="shonan-year-mode">
								<option value="auto" <?php selected( $settings['year_mode'], 'auto' ); ?>>自動（おすすめ）</option>
								<option value="manual" <?php selected( $settings['year_mode'], 'manual' ); ?>>手動で指定</option>
							</select>
							<p class="hint">自動：4月以降は翌年4月入園、1〜3月は同年4月入園として扱います。いまの自動判定は <strong><?php echo esc_html( shonan_admission_year_label( shonan_admission_year_auto() ) ); ?></strong>（西暦<?php echo esc_html( (string) shonan_admission_year_auto() ); ?>年4月）です。</p>
						</div>
						<div>
							<label class="block" for="shonan-admission-year">手動指定（西暦・4月入園の年）</label>
							<input type="number" name="shonan_admission[admission_year]" id="shonan-admission-year" min="2019" max="2100" value="<?php echo esc_attr( (string) $settings['admission_year'] ); ?>">
							<p class="hint">例：令和9年度 → <code>2027</code>。「手動で指定」のときだけ使います。</p>
						</div>
					</div>

					<div class="shonan-adm__preview">
						<h4>いまサイトに出る対象児（自動計算プレビュー）— <?php echo esc_html( shonan_admission_year_label( $year ) ); ?></h4>
						<ul>
							<?php foreach ( $targets as $target ) : ?>
								<li>
									<?php
									echo esc_html(
										$target['title'] . '：' . $target['birth']['text'] . '（定員 ' . $target['quota'] . '）'
									);
									?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>

			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle">対象児／定員</h2></div>
				<div class="inside">
					<p class="hint" style="margin-top:0;">生年月日の文言は自動です。ここは<strong>定員の文言</strong>だけ毎年更新してください。</p>
					<div class="shonan-adm__grid">
						<div>
							<label class="block" for="quota_3">3年保育の定員</label>
							<input type="text" name="shonan_admission[quota_3]" id="quota_3" value="<?php echo esc_attr( $settings['quota_3'] ); ?>" placeholder="例：54名">
						</div>
						<div>
							<label class="block" for="quota_2">2年保育の定員</label>
							<input type="text" name="shonan_admission[quota_2]" id="quota_2" value="<?php echo esc_attr( $settings['quota_2'] ); ?>" placeholder="例：若干名">
						</div>
					</div>
				</div>
			</div>

			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle">園見学のご案内文</h2></div>
				<div class="inside">
					<label class="block" for="visit_lead">案内テキスト</label>
					<textarea name="shonan_admission[visit_lead]" id="visit_lead"><?php echo esc_textarea( $settings['visit_lead'] ); ?></textarea>
				</div>
			</div>

			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle">入園説明会</h2></div>
				<div class="inside">
					<?php foreach ( $settings['sessions'] as $i => $session ) : ?>
						<div class="shonan-adm__session">
							<h4><?php echo esc_html( $session['label'] ?: ( '第' . ( $i + 1 ) . '回' ) ); ?></h4>
							<div class="shonan-adm__grid--3 shonan-adm__grid">
								<div>
									<label class="block" for="session_label_<?php echo esc_attr( (string) $i ); ?>">見出し</label>
									<input type="text" name="shonan_admission[sessions][<?php echo esc_attr( (string) $i ); ?>][label]" id="session_label_<?php echo esc_attr( (string) $i ); ?>" value="<?php echo esc_attr( $session['label'] ); ?>">
								</div>
								<div>
									<label class="block" for="session_date_<?php echo esc_attr( (string) $i ); ?>">開催日</label>
									<input type="date" name="shonan_admission[sessions][<?php echo esc_attr( (string) $i ); ?>][date]" id="session_date_<?php echo esc_attr( (string) $i ); ?>" value="<?php echo esc_attr( $session['date'] ); ?>">
									<?php if ( ! empty( $session['date'] ) ) : ?>
										<p class="hint">表示：<?php echo esc_html( shonan_format_reiwa_date_label( $session['date'] ) ); ?></p>
									<?php endif; ?>
								</div>
								<div>
									<label class="block" for="session_time_<?php echo esc_attr( (string) $i ); ?>">時間</label>
									<input type="text" name="shonan_admission[sessions][<?php echo esc_attr( (string) $i ); ?>][time]" id="session_time_<?php echo esc_attr( (string) $i ); ?>" value="<?php echo esc_attr( $session['time'] ); ?>" placeholder="例：10:00～11:00">
								</div>
							</div>
						</div>
					<?php endforeach; ?>

					<div class="shonan-adm__grid">
						<div>
							<label class="block" for="session_place">開催場所</label>
							<input type="text" name="shonan_admission[session_place]" id="session_place" value="<?php echo esc_attr( $settings['session_place'] ); ?>">
						</div>
						<div>
							<label class="block" for="session_bring">持ち物</label>
							<input type="text" name="shonan_admission[session_bring]" id="session_bring" value="<?php echo esc_attr( $settings['session_bring'] ); ?>">
						</div>
					</div>
					<p style="margin-top:1rem;">
						<label class="block" for="session_note">補足説明</label>
						<textarea name="shonan_admission[session_note]" id="session_note"><?php echo esc_textarea( $settings['session_note'] ); ?></textarea>
					</p>
					<?php
					$pdf_id   = absint( $settings['session_pdf_id'] ?? 0 );
					$pdf_name = $pdf_id ? get_the_title( $pdf_id ) : 'いまのPDFを表示中';
					?>
					<div style="margin-top:1.25rem;">
						<label class="block" for="session_pdf_id">入園説明会資料（PDF）</label>
						<input type="hidden" name="shonan_admission[session_pdf_id]" id="session_pdf_id" value="<?php echo esc_attr( (string) $pdf_id ); ?>">
						<p class="hint" id="shonan-pdf-name" style="margin:0.35rem 0 0.7rem;"><?php echo esc_html( $pdf_name ); ?></p>
						<button type="button" class="button" id="shonan-pdf-pick">資料を選ぶ</button>
						<button type="button" class="button" id="shonan-pdf-clear">差し替えをやめる</button>
						<p class="hint">新しいPDFを選んで保存すると、サイトの表示が入れ替わります。「差し替えをやめる」は、選んだPDFを取り消してもともとのPDFに戻すボタンです。</p>
					</div>
					<script>
					jQuery(function ($) {
						var frame;
						$('#shonan-pdf-pick').on('click', function (e) {
							e.preventDefault();
							if (frame) {
								frame.open();
								return;
							}
							frame = wp.media({
								title: '入園説明会資料',
								button: { text: 'この資料を使う' },
								library: { type: 'application/pdf' },
								multiple: false
							});
							frame.on('select', function () {
								var file = frame.state().get('selection').first().toJSON();
								$('#session_pdf_id').val(file.id);
								$('#shonan-pdf-name').text(file.filename || file.title);
							});
							frame.open();
						});
						$('#shonan-pdf-clear').on('click', function (e) {
							e.preventDefault();
							$('#session_pdf_id').val('0');
							$('#shonan-pdf-name').text('いまのPDFを表示中');
						});
					});
					</script>
				</div>
			</div>

			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle">願書の配布・受付</h2></div>
				<div class="inside">
					<div class="shonan-adm__grid">
						<div>
							<label class="block" for="gansho_distribute">願書配布開始日</label>
							<input type="date" name="shonan_admission[gansho_distribute]" id="gansho_distribute" value="<?php echo esc_attr( $settings['gansho_distribute'] ); ?>">
							<?php if ( ! empty( $settings['gansho_distribute'] ) ) : ?>
								<p class="hint">表示：<?php echo esc_html( shonan_format_reiwa_date_label( $settings['gansho_distribute'] ) ); ?>より配布</p>
							<?php endif; ?>
						</div>
						<div>
							<label class="block" for="gansho_accept">願書受付開始日</label>
							<input type="date" name="shonan_admission[gansho_accept]" id="gansho_accept" value="<?php echo esc_attr( $settings['gansho_accept'] ); ?>">
							<?php if ( ! empty( $settings['gansho_accept'] ) ) : ?>
								<p class="hint">表示：<?php echo esc_html( shonan_format_reiwa_date_label( $settings['gansho_accept'] ) ); ?>より受付</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<?php submit_button( '設定を保存する' ); ?>
		</form>
	</div>
	<?php
}

/**
 * 入園ページ編集画面への案内
 */
function shonan_admission_edit_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type || 'post' !== $screen->base ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id ) {
		return;
	}

	$page = get_post( $post_id );
	if ( ! $page || 'nyuen' !== $page->post_name ) {
		return;
	}

	$url = admin_url( 'themes.php?page=shonan-admission' );
	echo '<div class="notice notice-info"><p>';
	echo '<strong>入園ページの表示内容はテーマテンプレートで管理しています。</strong> ';
	echo '説明会の日程・定員など毎年変わる項目は、';
	printf(
		'<a href="%s"><strong>外観 → 入園募集の設定</strong></a>',
		esc_url( $url )
	);
	echo ' から編集してください。';
	echo '</p></div>';
}
add_action( 'admin_notices', 'shonan_admission_edit_notice' );
