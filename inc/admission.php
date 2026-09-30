<?php
/**
 * 入園募集設定（フロント表示用ヘルパー）
 *
 * 毎年変わる項目は管理画面「外観 → 入園募集の設定」で編集します。
 * 対象児の生年月日範囲は募集年度から自動計算します。
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 設定のデフォルト値
 *
 * @return array
 */
function shonan_admission_defaults() {
	return array(
		'year_mode'         => 'auto',
		'admission_year'    => (int) gmdate( 'Y' ) + 1,
		'quota_3'           => '54名',
		'quota_2'           => '若干名',
		'sessions'          => array(
			array(
				'label' => '第1回説明会',
				'date'  => '2026-09-03',
				'time'  => '10:00～11:00',
			),
			array(
				'label' => '第2回説明会',
				'date'  => '2026-09-14',
				'time'  => '10:00～11:00',
			),
			array(
				'label' => '第3回説明会',
				'date'  => '2026-10-08',
				'time'  => '10:00～11:00',
			),
		),
		'session_place'     => '園内2階の講堂',
		'session_bring'     => '上ばきをご持参ください。',
		'session_note'      => '園の1日の生活、課外活動等についてご説明します。',
		'gansho_distribute' => '2026-10-15',
		'gansho_accept'     => '2026-11-01',
		'visit_lead'        => '入園説明会の前に、ぜひ園見学にお越しください。園の環境や設備、方針・特徴をご案内します。見学のご予約は随時受け付けております。',
		'session_pdf_id'    => 0,
	);
}

/**
 * 保存済み設定をデフォルトとマージして返す
 *
 * @return array
 */
function shonan_get_admission_settings() {
	$saved    = get_option( 'shonan_admission_settings', array() );
	$defaults = shonan_admission_defaults();

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	$settings = wp_parse_args( $saved, $defaults );

	if ( empty( $settings['sessions'] ) || ! is_array( $settings['sessions'] ) ) {
		$settings['sessions'] = $defaults['sessions'];
	} else {
		$merged_sessions = array();
		foreach ( $defaults['sessions'] as $i => $default_session ) {
			$merged_sessions[ $i ] = wp_parse_args(
				isset( $settings['sessions'][ $i ] ) && is_array( $settings['sessions'][ $i ] )
					? $settings['sessions'][ $i ]
					: array(),
				$default_session
			);
		}
		$settings['sessions'] = $merged_sessions;
	}

	$settings['admission_year'] = absint( $settings['admission_year'] );
	$settings['year_mode']      = ( 'manual' === $settings['year_mode'] ) ? 'manual' : 'auto';

	return $settings;
}

/**
 * 自動判定の募集年度（西暦・4月始まり）
 *
 * 4月以降 → 翌年4月入園、1〜3月 → 同年4月入園
 *
 * @return int
 */
function shonan_admission_year_auto() {
	$now   = current_time( 'timestamp' );
	$year  = (int) wp_date( 'Y', $now );
	$month = (int) wp_date( 'n', $now );

	return ( $month >= 4 ) ? $year + 1 : $year;
}

/**
 * 表示に使う募集年度（西暦）
 *
 * @param array|null $settings 設定配列.
 * @return int
 */
function shonan_admission_year( $settings = null ) {
	if ( null === $settings ) {
		$settings = shonan_get_admission_settings();
	}

	if ( 'manual' === $settings['year_mode'] && ! empty( $settings['admission_year'] ) ) {
		return (int) $settings['admission_year'];
	}

	return shonan_admission_year_auto();
}

/**
 * 西暦 → 令和年
 *
 * @param int $western 西暦年.
 * @return int
 */
function shonan_western_to_reiwa( $western ) {
	return (int) $western - 2018;
}

/**
 * 令和表記の年月日
 *
 * @param int $year  西暦.
 * @param int $month 月.
 * @param int $day   日.
 * @return string
 */
function shonan_format_reiwa_ymd( $year, $month, $day ) {
	return sprintf(
		'令和%d年%d月%d日',
		shonan_western_to_reiwa( (int) $year ),
		(int) $month,
		(int) $day
	);
}

/**
 * Y-m-d を令和表記＋曜日付きにする
 *
 * @param string $ymd Y-m-d.
 * @return string
 */
function shonan_format_reiwa_date_label( $ymd ) {
	$ymd = trim( (string) $ymd );
	if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $ymd, $m ) ) {
		return $ymd;
	}

	$ts      = strtotime( $ymd . ' 12:00:00' );
	$weekdays = array( '日', '月', '火', '水', '木', '金', '土' );
	$w        = $weekdays[ (int) wp_date( 'w', $ts ) ];

	return sprintf(
		'%s（%s）',
		shonan_format_reiwa_ymd( (int) $m[1], (int) $m[2], (int) $m[3] ),
		$w
	);
}

/**
 * 募集年度ラベル（例: 令和9年度）
 *
 * @param int|null $year 西暦の年度開始年.
 * @return string
 */
function shonan_admission_year_label( $year = null ) {
	if ( null === $year ) {
		$year = shonan_admission_year();
	}

	return sprintf( '令和%d年度', shonan_western_to_reiwa( (int) $year ) );
}

/**
 * 学年ごとの生年月日範囲（4/2〜翌4/1）
 *
 * @param int $admission_year 入園する年の西暦（4月）.
 * @param int $age_in_april   4月1日時点の年齢（3年保育=3、2年保育=4）.
 * @return array{start:string,end:string,text:string}
 */
function shonan_birth_range_for_age( $admission_year, $age_in_april ) {
	$admission_year = (int) $admission_year;
	$age_in_april   = (int) $age_in_april;
	$start_year     = $admission_year - $age_in_april - 1;
	$end_year       = $admission_year - $age_in_april;

	$start = shonan_format_reiwa_ymd( $start_year, 4, 2 );
	$end   = shonan_format_reiwa_ymd( $end_year, 4, 1 );

	return array(
		'start' => $start,
		'end'   => $end,
		'text'  => $start . '～' . $end . '生まれ',
	);
}

/**
 * 対象児カード用データ
 *
 * @param array|null $settings 設定.
 * @return array
 */
function shonan_admission_targets( $settings = null ) {
	if ( null === $settings ) {
		$settings = shonan_get_admission_settings();
	}

	$year = shonan_admission_year( $settings );

	return array(
		array(
			'key'   => '3year',
			'title' => '3年保育',
			'age'   => 3,
			'birth' => shonan_birth_range_for_age( $year, 3 ),
			'quota' => $settings['quota_3'],
			'note'  => '1号認定',
		),
		array(
			'key'   => '2year',
			'title' => '2年保育',
			'age'   => 4,
			'birth' => shonan_birth_range_for_age( $year, 4 ),
			'quota' => $settings['quota_2'],
			'note'  => '1号認定',
		),
	);
}

/**
 * 制服・体操服の画像グループ
 *
 * seifuku* → 制服 / taisou* → 体操服
 *
 * @return array<string, array{title:string,lead:string,images:array<int,array{url:string,file:string}>}>
 */
function shonan_nyuen_outfit_groups() {
	$dir = SHONAN_THEME_DIR . '/assets/images/photos/nyuen/seifuku';
	$uri = SHONAN_THEME_URI . '/assets/images/photos/nyuen/seifuku';

	$groups = array(
		'seifuku' => array(
			'title'  => '制服',
			'lead'   => '通園時に着用する制服です。注文は入園面接後にご案内します。',
			'images' => array(),
		),
		'taisou'  => array(
			'title'  => '体操服',
			'lead'   => '園での活動で着用する体操服です。動きやすく、元気いっぱい遊べます。',
			'images' => array(),
		),
	);

	if ( ! is_dir( $dir ) ) {
		return $groups;
	}

	$files = array();
	foreach ( array( 'jpg', 'jpeg', 'png', 'webp' ) as $ext ) {
		foreach ( array( $ext, strtoupper( $ext ) ) as $variant ) {
			$matched = glob( $dir . '/*.' . $variant );
			if ( ! empty( $matched ) ) {
				$files = array_merge( $files, $matched );
			}
		}
	}

	$files = array_values( array_unique( $files ) );
	natsort( $files );

	foreach ( $files as $file ) {
		$basename = basename( $file );
		$lower    = strtolower( $basename );
		$item     = array(
			'url'  => $uri . '/' . $basename,
			'file' => $basename,
		);

		if ( false !== strpos( $lower, 'taisou' ) ) {
			$groups['taisou']['images'][] = $item;
		} elseif ( false !== strpos( $lower, 'seifuku' ) ) {
			$groups['seifuku']['images'][] = $item;
		}
	}

	return $groups;
}

/**
 * @deprecated Use shonan_nyuen_outfit_groups().
 * @return array<int, array{url:string,file:string}>
 */
function shonan_nyuen_uniform_images() {
	$groups = shonan_nyuen_outfit_groups();
	return array_merge( $groups['seifuku']['images'], $groups['taisou']['images'] );
}

/**
 * 入園説明会資料のURL
 *
 * 管理画面でPDFを選んでいる場合はそれを、未設定なら同梱の資料を返す。
 *
 * @return string
 */
function shonan_session_material_url() {
	$settings = shonan_get_admission_settings();
	$id       = absint( $settings['session_pdf_id'] ?? 0 );

	if ( $id ) {
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			return $url;
		}
	}

	$bundled = shonan_document( 'nyuen/setsumeikai.pdf' );
	return $bundled ? $bundled : '';
}

/**
 * 管理画面から差し替えできる資料
 *
 * @return array<string, array{label:string,fallback:string,group:string}>
 */
function shonan_managed_documents() {
	return array(
		'setsumeikai' => array(
			'label'    => '入園説明会資料',
			'fallback' => 'nyuen/setsumeikai.pdf',
			'group'    => '入園のご希望',
		),
		'youkou'      => array(
			'label'    => '令和8年度 募集要項',
			'fallback' => 'nyuen/boshu-youkou-r8.pdf',
			'group'    => '入園のご希望',
		),
		'junior'      => array(
			'label'    => '湘南ジュニアのご案内',
			'fallback' => 'houshin/pre-hoiku/junior-poster.pdf',
			'group'    => '湘南ジュニア',
		),
		'kyujin'      => array(
			'label'    => '求人案内',
			'fallback' => 'kyujin/kyujin-poster.pdf',
			'group'    => '求職中の方へ',
		),
		'yoyaku' => array(
			'label'    => '与薬依頼書',
			'fallback' => 'shorui/yoyaku.pdf',
			'group'    => '在園の保護者へ',
		),
		'chiyu'  => array(
			'label'    => '治療証明書',
			'fallback' => 'shorui/chiyu.pdf',
			'group'    => '在園の保護者へ',
		),
		'toen'   => array(
			'label'    => '登園許可基準',
			'fallback' => 'shorui/toen-kijun.pdf',
			'group'    => '在園の保護者へ',
		),
	);
}

/**
 * 差し替え資料のURL。未設定なら同梱PDF。
 *
 * @param string $key 資料キー.
 * @return string
 */
function shonan_managed_document_url( $key ) {
	$docs = shonan_managed_documents();
	if ( ! isset( $docs[ $key ] ) ) {
		return '';
	}

	$saved = get_option( 'shonan_managed_documents', array() );
	$id    = ( is_array( $saved ) && isset( $saved[ $key ] ) ) ? absint( $saved[ $key ] ) : 0;

	if ( ! $id && 'setsumeikai' === $key ) {
		$settings = shonan_get_admission_settings();
		$id       = absint( $settings['session_pdf_id'] ?? 0 );
	}

	if ( $id ) {
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			return $url;
		}
	}

	$bundled = shonan_document( $docs[ $key ]['fallback'] );
	return $bundled ? $bundled : '';
}
