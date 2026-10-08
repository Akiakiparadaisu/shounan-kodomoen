<?php
/**
 * 閲覧記録の管理画面
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * メニュー
 */
function shonan_stats_admin_menu() {
	add_menu_page(
		'アクセス',
		'アクセス',
		'manage_options',
		'shonan-stats',
		'shonan_stats_admin_page',
		'dashicons-chart-bar',
		58
	);
}
add_action( 'admin_menu', 'shonan_stats_admin_menu' );

/**
 * 画面
 */
function shonan_stats_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	shonan_stats_install();
	shonan_stats_drop_orphans();

	$filters    = shonan_stats_admin_filters();
	$visitor_id = isset( $_GET['visitor'] ) ? absint( $_GET['visitor'] ) : 0;

	echo '<div class="wrap shonan-stats">';
	echo '<h1>アクセス</h1>';
	echo '<p>同じブラウザを一人の訪問者として数えています。公開サイトでは氏名は分かりません。ログインしている利用者だけ名前を表示します。管理者の閲覧は記録しません。各アクセスは日本時間の「何時何分」まで残しています。</p>';

	if ( $visitor_id ) {
		shonan_stats_admin_visitor( $visitor_id, $filters );
	} else {
		shonan_stats_admin_filters_form( $filters );
		shonan_stats_admin_chart( $filters );
		shonan_stats_admin_summary( $filters['from_gmt'], $filters['until_gmt'] );
		shonan_stats_admin_recent( $filters['from_gmt'], $filters['until_gmt'] );
		shonan_stats_admin_pages( $filters['from_gmt'], $filters['until_gmt'] );
		shonan_stats_admin_sections( $filters );
		shonan_stats_admin_notices( $filters['from_gmt'], $filters['until_gmt'] );
		shonan_stats_admin_visitors( $filters );
	}
	echo '</div>';
}

/**
 * 画面の絞り込み
 *
 * @return array<string,mixed>
 */
function shonan_stats_admin_filters() {
	$tz    = shonan_stats_timezone();
	$today = new DateTimeImmutable( 'today', $tz );
	$from  = isset( $_GET['from'] ) ? sanitize_text_field( wp_unslash( $_GET['from'] ) ) : $today->modify( '-6 days' )->format( 'Y-m-d' );
	$to    = isset( $_GET['to'] ) ? sanitize_text_field( wp_unslash( $_GET['to'] ) ) : $today->format( 'Y-m-d' );
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $from ) ) {
		$from = $today->modify( '-6 days' )->format( 'Y-m-d' );
	}
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $to ) ) {
		$to = $today->format( 'Y-m-d' );
	}
	if ( $from > $to ) {
		$swap = $from;
		$from = $to;
		$to   = $swap;
	}

	$unit = isset( $_GET['unit'] ) && 'day' === $_GET['unit'] ? 'day' : 'hour';
	$span = (int) ( new DateTimeImmutable( $from ) )->diff( new DateTimeImmutable( $to ) )->days;
	if ( 'hour' === $unit && $span > 14 ) {
		$unit = 'day';
	}

	$path = isset( $_GET['view'] ) ? sanitize_text_field( wp_unslash( $_GET['view'] ) ) : '';
	if ( strlen( $path ) > 191 || ( '' !== $path && '/' !== substr( $path, 0, 1 ) ) ) {
		$path = '';
	}

	$src = isset( $_GET['src'] ) ? strtolower( sanitize_text_field( wp_unslash( $_GET['src'] ) ) ) : '';
	if ( ! shonan_stats_source_key_ok( $src ) ) {
		$src = '';
	}

	$device = isset( $_GET['device'] ) ? sanitize_key( wp_unslash( $_GET['device'] ) ) : '';
	if ( ! array_key_exists( $device, shonan_stats_device_choices() ) ) {
		$device = '';
	}

	$stay = isset( $_GET['stay'] ) ? sanitize_key( wp_unslash( $_GET['stay'] ) ) : '';
	if ( ! array_key_exists( $stay, shonan_stats_stay_choices() ) ) {
		$stay = '';
	}

	$range = shonan_stats_range_gmt( $from, $to );
	return array(
		'from'      => $from,
		'to'        => $to,
		'unit'      => $unit,
		'path'      => $path,
		'src'       => $src,
		'device'    => $device,
		'stay'      => $stay,
		'from_gmt'  => $range[0],
		'until_gmt' => $range[1],
	);
}

/**
 * 期間とページの指定
 *
 * @param array<string,mixed> $filters 絞り込み.
 */
function shonan_stats_admin_filters_form( $filters ) {
	global $wpdb;
	$paths = $wpdb->get_col(
		$wpdb->prepare(
			'SELECT DISTINCT path FROM ' . $wpdb->prefix . 'shonan_views WHERE started >= %s AND started < %s ORDER BY path ASC LIMIT 80',
			$filters['from_gmt'],
			$filters['until_gmt']
		)
	);
	$referrers = $wpdb->get_col(
		$wpdb->prepare(
			'SELECT DISTINCT referrer FROM ' . $wpdb->prefix . 'shonan_views WHERE started >= %s AND started < %s LIMIT 200',
			$filters['from_gmt'],
			$filters['until_gmt']
		)
	);
	$sources = array(
		'direct' => '直接',
		'site'   => '園のサイト内',
	);
	foreach ( $referrers as $referrer ) {
		$key = shonan_stats_source_key( $referrer );
		if ( isset( $sources[ $key ] ) ) {
			continue;
		}
		$sources[ $key ] = shonan_stats_source_label( $key );
	}
	if ( '' !== $filters['src'] && ! isset( $sources[ $filters['src'] ] ) ) {
		$sources[ $filters['src'] ] = shonan_stats_source_label( $filters['src'] );
	}

	echo '<form method="get" class="shonan-stats__form">';
	echo '<input type="hidden" name="page" value="shonan-stats">';
	echo '<label>開始 <input type="date" name="from" value="' . esc_attr( $filters['from'] ) . '"></label> ';
	echo '<label>終了 <input type="date" name="to" value="' . esc_attr( $filters['to'] ) . '"></label> ';
	echo '<label>横軸 <select name="unit">';
	echo '<option value="hour"' . selected( $filters['unit'], 'hour', false ) . '>1時間ごと</option>';
	echo '<option value="day"' . selected( $filters['unit'], 'day', false ) . '>1日ごと</option>';
	echo '</select></label> ';
	echo '<label>ページ <select name="view">';
	echo '<option value="">合計</option>';
	foreach ( $paths as $path ) {
		echo '<option value="' . esc_attr( $path ) . '"' . selected( $filters['path'], $path, false ) . '>' . esc_html( $path ) . '</option>';
	}
	echo '</select></label> ';
	echo '<label>どこから <select name="src">';
	echo '<option value="">すべて</option>';
	foreach ( $sources as $key => $label ) {
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $filters['src'], $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></label> ';
	echo '<label>端末 <select name="device">';
	foreach ( shonan_stats_device_choices() as $key => $label ) {
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $filters['device'], $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></label> ';
	echo '<label>滞在 <select name="stay">';
	foreach ( shonan_stats_stay_choices() as $key => $label ) {
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $filters['stay'], $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></label> ';
	submit_button( '表示', 'secondary', '', false );
	echo '<p class="description">1時間ごとの表示は、14日以内の期間で使えます。どこからは、そのページを開く直前のサイトです。滞在は、その人がページを見ていた時間の合計です。</p>';
	echo '</form>';
}

/**
 * 時間ごとのグラフ
 *
 * @param array<string,mixed> $filters 絞り込み.
 */
function shonan_stats_admin_chart( $filters ) {
	global $wpdb;
	$sql  = 'SELECT p.started, p.visitor_id, p.referrer, p.seconds, v.device
		FROM ' . $wpdb->prefix . 'shonan_views p
		INNER JOIN ' . $wpdb->prefix . 'shonan_visitors v ON v.id = p.visitor_id
		WHERE p.started >= %s AND p.started < %s';
	$args = array( $filters['from_gmt'], $filters['until_gmt'] );
	if ( '' !== $filters['path'] ) {
		$sql   .= ' AND p.path = %s';
		$args[] = $filters['path'];
	}
	$rows = $wpdb->get_results( $wpdb->prepare( $sql, $args ) );
	$rows = array_values(
		array_filter(
			$rows,
			static function ( $row ) use ( $filters ) {
				if ( '' !== $filters['src'] && shonan_stats_source_key( $row->referrer ) !== $filters['src'] ) {
					return false;
				}
				return shonan_stats_device_matches( $filters['device'], (string) $row->device );
			}
		)
	);
	$stay_counts = shonan_stats_stay_counts( $rows );
	$rows        = shonan_stats_filter_by_stay( $rows, $filters['stay'] );

	$buckets = array();
	$cursor  = new DateTimeImmutable( $filters['from'] . ' 00:00:00', shonan_stats_timezone() );
	$end     = new DateTimeImmutable( $filters['to'] . ' 00:00:00', shonan_stats_timezone() );
	$step    = 'hour' === $filters['unit'] ? '+1 hour' : '+1 day';
	$format  = 'hour' === $filters['unit'] ? 'Y-m-d H' : 'Y-m-d';
	$last    = 'hour' === $filters['unit'] ? $end->modify( '+1 day' ) : $end->modify( '+1 day' );
	while ( $cursor < $last ) {
		$buckets[ $cursor->format( $format ) ] = array(
			'label'    => 'hour' === $filters['unit'] ? $cursor->format( 'n/j G時' ) : $cursor->format( 'n/j' ),
			'views'    => 0,
			'visitors' => array(),
		);
		$cursor = $cursor->modify( $step );
		if ( count( $buckets ) > 400 ) {
			break;
		}
	}

	foreach ( $rows as $row ) {
		$stamp = strtotime( $row->started . ' UTC' );
		if ( ! $stamp ) {
			continue;
		}
		$key = wp_date( 'hour' === $filters['unit'] ? 'Y-m-d H' : 'Y-m-d', $stamp, shonan_stats_timezone() );
		if ( ! isset( $buckets[ $key ] ) ) {
			continue;
		}
		$buckets[ $key ]['views']++;
		$buckets[ $key ]['visitors'][ (int) $row->visitor_id ] = true;
	}

	$points = array_values( $buckets );
	$max    = 1;
	foreach ( $points as $point ) {
		$max = max( $max, $point['views'], count( $point['visitors'] ) );
	}

	$caption = array( '' === $filters['path'] ? '全部のページの合計' : 'ページ ' . $filters['path'] );
	if ( '' !== $filters['src'] ) {
		$caption[] = 'どこから ' . shonan_stats_source_label( $filters['src'] );
	}
	if ( '' !== $filters['device'] ) {
		$choices   = shonan_stats_device_choices();
		$caption[] = '端末 ' . $choices[ $filters['device'] ];
	}
	if ( '' !== $filters['stay'] ) {
		$stays     = shonan_stats_stay_choices();
		$caption[] = '滞在 ' . $stays[ $filters['stay'] ];
	}
	echo '<h2>グラフ</h2>';
	echo '<p>' . esc_html( implode( ' / ', $caption ) ) . '</p>';
	echo '<p class="shonan-stats__people">5分以上滞在した人 <strong>' . esc_html( number_format_i18n( $stay_counts['over5'] ) ) . '人</strong>';
	echo '<span>1分未満 ' . esc_html( number_format_i18n( $stay_counts['under1'] ) ) . '人、1分〜5分 ' . esc_html( number_format_i18n( $stay_counts['1to5'] ) ) . '人</span></p>';
	if ( ! $rows ) {
		echo '<p>この条件のアクセスはまだありません。</p>';
		return;
	}

	$width  = 960;
	$height = 300;
	$left   = 46;
	$right  = 16;
	$top    = 16;
	$bottom = 48;
	$plot_w = $width - $left - $right;
	$plot_h = $height - $top - $bottom;
	$slots = max( 1, count( $points ) - 1 );
	$view_pts = array();
	$people_pts = array();
	foreach ( $points as $i => $point ) {
		$x = $left + ( 1 === count( $points ) ? $plot_w / 2 : $plot_w * $i / $slots );
		$view_pts[] = round( $x, 1 ) . ',' . round( $top + $plot_h - ( $plot_h * $point['views'] / $max ), 1 );
		$people_pts[] = round( $x, 1 ) . ',' . round( $top + $plot_h - ( $plot_h * count( $point['visitors'] ) / $max ), 1 );
	}

	echo '<svg class="shonan-stats__chart" viewBox="0 0 ' . $width . ' ' . $height . '" role="img" aria-label="開いた回数と訪問者のグラフ">';
	for ( $tick = 0; $tick <= 4; $tick++ ) {
		$y = $top + ( $plot_h * $tick / 4 );
		$value = (int) round( $max * ( 4 - $tick ) / 4 );
		echo '<line x1="' . $left . '" y1="' . $y . '" x2="' . ( $width - $right ) . '" y2="' . $y . '" stroke="#dcdcde"/>';
		echo '<text x="' . ( $left - 8 ) . '" y="' . ( $y + 4 ) . '" text-anchor="end" font-size="12" fill="#646970">' . $value . '</text>';
	}
	echo '<polyline fill="none" stroke="#4aa8c9" stroke-width="3" points="' . esc_attr( implode( ' ', $view_pts ) ) . '"/>';
	echo '<polyline fill="none" stroke="#c45b73" stroke-width="3" points="' . esc_attr( implode( ' ', $people_pts ) ) . '"/>';
	$step_label = max( 1, (int) ceil( count( $points ) / 8 ) );
	foreach ( $points as $i => $point ) {
		if ( 0 !== $i % $step_label && $i !== count( $points ) - 1 ) {
			continue;
		}
		$x = $left + ( 1 === count( $points ) ? $plot_w / 2 : $plot_w * $i / $slots );
		echo '<text x="' . $x . '" y="' . ( $height - 16 ) . '" text-anchor="middle" font-size="12" fill="#646970">' . esc_html( $point['label'] ) . '</text>';
	}
	echo '</svg>';
	echo '<p class="shonan-stats__legend"><span class="is-views">開いた回数</span><span class="is-people">訪問者</span></p>';
}

/**
 * 概要の数字
 *
 * @param string $since 開始日時（GMT）.
 */
function shonan_stats_admin_summary( $from_gmt, $until_gmt ) {
	global $wpdb;
	$views   = $wpdb->prefix . 'shonan_views';
	$notices = $wpdb->prefix . 'shonan_notice_views';

	$page_views = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$views} p INNER JOIN {$wpdb->prefix}shonan_visitors v ON v.id = p.visitor_id WHERE p.started >= %s AND p.started < %s", $from_gmt, $until_gmt ) );
	$people     = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT p.visitor_id) FROM {$views} p INNER JOIN {$wpdb->prefix}shonan_visitors v ON v.id = p.visitor_id WHERE p.started >= %s AND p.started < %s", $from_gmt, $until_gmt ) );
	$avg_page   = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ROUND(AVG(seconds)) FROM {$views} WHERE started >= %s AND started < %s AND seconds > 0", $from_gmt, $until_gmt ) );
	$notice_people = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT visitor_id) FROM {$notices} WHERE started >= %s AND started < %s", $from_gmt, $until_gmt ) );
	$avg_notice = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ROUND(AVG(seconds)) FROM {$notices} WHERE started >= %s AND started < %s AND seconds > 0", $from_gmt, $until_gmt ) );

	echo '<div class="shonan-stats__cards">';
	shonan_stats_card( 'ページを開いた回数', number_format_i18n( $page_views ) );
	shonan_stats_card( '訪問者', number_format_i18n( $people ) );
	shonan_stats_card( 'ページの平均滞在', shonan_stats_duration( $avg_page ) );
	shonan_stats_card( '告知を見た人', number_format_i18n( $notice_people ) );
	shonan_stats_card( '告知の平均表示', shonan_stats_duration( $avg_notice ) );
	echo '</div>';
}

/**
 * 数字カード
 *
 * @param string $label 見出し.
 * @param string $value 値.
 */
function shonan_stats_card( $label, $value ) {
	echo '<div class="shonan-stats__card"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>';
}

/**
 * ページ別
 *
 * @param string $since 開始日時（GMT）.
 */
function shonan_stats_admin_recent( $from_gmt, $until_gmt ) {
	global $wpdb;
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT p.started, p.path, p.title, p.seconds, v.token, v.user_id, v.device
			FROM ' . $wpdb->prefix . 'shonan_views p
			INNER JOIN ' . $wpdb->prefix . 'shonan_visitors v ON v.id = p.visitor_id
			WHERE p.started >= %s AND p.started < %s
			ORDER BY p.started DESC
			LIMIT 40',
			$from_gmt,
			$until_gmt
		)
	);

	echo '<h2>アクセスした時刻</h2>';
	if ( ! $rows ) {
		echo '<p>この期間の記録はありません。</p>';
		return;
	}
	echo '<table class="widefat striped"><thead><tr><th>何時何分</th><th>だれ</th><th>端末</th><th>ページ</th><th>見ていた時間</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		echo '<tr>';
		echo '<td>' . esc_html( shonan_stats_local_time( $row->started ) ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_visitor_name( $row ) ) . '</td>';
		echo '<td>' . esc_html( $row->device ) . '</td>';
		echo '<td>' . esc_html( $row->title ? $row->title : $row->path ) . '<br><code>' . esc_html( $row->path ) . '</code></td>';
		echo '<td>' . esc_html( shonan_stats_duration( (int) $row->seconds ) ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

/**
 * ページ別
 *
 * @param string $from_gmt 開始.
 * @param string $until_gmt 終了.
 */
function shonan_stats_admin_pages( $from_gmt, $until_gmt ) {
	global $wpdb;
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT path, MAX(title) AS title, COUNT(*) AS views, COUNT(DISTINCT visitor_id) AS people, ROUND(AVG(NULLIF(seconds, 0))) AS avg_sec
			FROM ' . $wpdb->prefix . 'shonan_views
			WHERE started >= %s AND started < %s
			GROUP BY path
			ORDER BY views DESC
			LIMIT 40',
			$from_gmt,
			$until_gmt
		)
	);

	echo '<h2>ページ</h2>';
	if ( ! $rows ) {
		echo '<p>まだ記録がありません。公開ページを開くと、ここにたまります。</p>';
		return;
	}

	echo '<table class="widefat striped"><thead><tr><th>ページ</th><th>開いた回数</th><th>訪問者</th><th>平均滞在</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		$label = $row->title ? $row->title : $row->path;
		echo '<tr>';
		echo '<td><a href="' . esc_url( home_url( $row->path ) ) . '">' . esc_html( $label ) . '</a><br><code>' . esc_html( $row->path ) . '</code></td>';
		echo '<td>' . esc_html( number_format_i18n( (int) $row->views ) ) . '</td>';
		echo '<td>' . esc_html( number_format_i18n( (int) $row->people ) ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_duration( (int) $row->avg_sec ) ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

/**
 * 告知
 *
 * @param string $since 開始日時（GMT）.
 */
function shonan_stats_admin_sections( $filters ) {
	global $wpdb;
	$sql  = 'SELECT path, label, COUNT(*) AS views, COUNT(DISTINCT visitor_id) AS people
		FROM ' . $wpdb->prefix . 'shonan_sections
		WHERE started >= %s AND started < %s';
	$args = array( $filters['from_gmt'], $filters['until_gmt'] );
	if ( '' !== $filters['path'] ) {
		$sql   .= ' AND path = %s';
		$args[] = $filters['path'];
	}
	$sql  .= ' GROUP BY path, label ORDER BY people DESC, views DESC LIMIT 40';
	$rows  = $wpdb->get_results( $wpdb->prepare( $sql, $args ) );

	echo '<h2>ページ内でよく見られた内容</h2>';
	echo '<p>各ページの見出しまでスクロールして、画面に入った回数です。グラフでページを選ぶと、そのページだけに絞れます。</p>';
	if ( ! $rows ) {
		echo '<p>まだありません。ページを開いて見出しまで進むと記録されます。</p>';
		return;
	}
	echo '<table class="widefat striped"><thead><tr><th>内容</th><th>ページ</th><th>見た人</th><th>見た回数</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		echo '<tr>';
		echo '<td>' . esc_html( $row->label ) . '</td>';
		echo '<td><code>' . esc_html( $row->path ) . '</code></td>';
		echo '<td>' . esc_html( number_format_i18n( (int) $row->people ) ) . '</td>';
		echo '<td>' . esc_html( number_format_i18n( (int) $row->views ) ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

/**
 * 告知
 *
 * @param string $from_gmt 開始.
 * @param string $until_gmt 終了.
 */
function shonan_stats_admin_notices( $from_gmt, $until_gmt ) {
	global $wpdb;
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT n.*, v.token, v.user_id, v.device
			FROM ' . $wpdb->prefix . 'shonan_notice_views n
			INNER JOIN ' . $wpdb->prefix . 'shonan_visitors v ON v.id = n.visitor_id
			WHERE n.started >= %s AND n.started < %s
			ORDER BY n.started DESC
			LIMIT 80',
			$from_gmt,
			$until_gmt
		)
	);

	echo '<h2>トップの告知</h2>';
	if ( ! $rows ) {
		echo '<p>この期間に告知を見た記録はありません。</p>';
		return;
	}

	echo '<table class="widefat striped"><thead><tr><th>見た日時</th><th>だれ</th><th>端末</th><th>告知</th><th>見ていた時間</th><th>閉じた</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		$detail = admin_url( 'admin.php?page=shonan-stats&visitor=' . (int) $row->visitor_id );
		echo '<tr>';
		echo '<td>' . esc_html( shonan_stats_local_time( $row->started ) ) . '</td>';
		echo '<td><a href="' . esc_url( $detail ) . '">' . esc_html( shonan_stats_visitor_name( $row ) ) . '</a></td>';
		echo '<td>' . esc_html( $row->device ) . '</td>';
		echo '<td>' . esc_html( $row->title ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_duration( (int) $row->seconds ) ) . '</td>';
		echo '<td>' . ( $row->closed ? '閉じた' : '開いたまま' ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

/**
 * 訪問者一覧
 *
 * @param string $since 開始日時（GMT）.
 * @param int    $days 日数.
 */
function shonan_stats_admin_visitors( $filters ) {
	global $wpdb;
	$views   = $wpdb->prefix . 'shonan_views';
	$notices = $wpdb->prefix . 'shonan_notice_views';
	$from    = $filters['from_gmt'];
	$until   = $filters['until_gmt'];
	$rows    = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT v.*,
				(SELECT COUNT(*) FROM {$views} p WHERE p.visitor_id = v.id AND p.started >= %s AND p.started < %s) AS page_count,
				(SELECT COALESCE(SUM(seconds), 0) FROM {$views} p WHERE p.visitor_id = v.id AND p.started >= %s AND p.started < %s) AS page_seconds,
				(SELECT COALESCE(SUM(seconds), 0) FROM {$notices} n WHERE n.visitor_id = v.id AND n.started >= %s AND n.started < %s) AS notice_seconds
			FROM {$wpdb->prefix}shonan_visitors v
			WHERE v.last_seen >= %s
			ORDER BY v.last_seen DESC
			LIMIT 80",
			$from,
			$until,
			$from,
			$until,
			$from,
			$until,
			$from
		)
	);

	echo '<h2>訪問者</h2>';
	if ( ! $rows ) {
		echo '<p>この期間の訪問者はまだいません。</p>';
		return;
	}

	echo '<table class="widefat striped"><thead><tr><th>だれ</th><th>端末</th><th>最後に来たとき</th><th>開いたページ</th><th>ページを見ていた時間</th><th>告知を見ていた時間</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		$url = add_query_arg(
			array(
				'page'    => 'shonan-stats',
				'from'    => $filters['from'],
				'to'      => $filters['to'],
				'unit'    => $filters['unit'],
				'view'    => $filters['path'],
				'src'     => $filters['src'],
				'device'  => $filters['device'],
				'stay'    => $filters['stay'],
				'visitor' => (int) $row->id,
			),
			admin_url( 'admin.php' )
		);
		echo '<tr>';
		echo '<td><a href="' . esc_url( $url ) . '">' . esc_html( shonan_stats_visitor_name( $row ) ) . '</a></td>';
		echo '<td>' . esc_html( $row->device ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_local_time( $row->last_seen ) ) . '</td>';
		echo '<td>' . esc_html( number_format_i18n( (int) $row->page_count ) ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_duration( (int) $row->page_seconds ) ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_duration( (int) $row->notice_seconds ) ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

/**
 * 一人の履歴
 *
 * @param int $visitor_id 訪問者ID.
 */
function shonan_stats_admin_visitor( $visitor_id, $filters ) {
	global $wpdb;
	$visitor = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'shonan_visitors WHERE id = %d', $visitor_id ) );
	if ( ! $visitor ) {
		echo '<p>この訪問者は見つかりません。</p>';
		return;
	}

	$back = add_query_arg(
		array(
			'page' => 'shonan-stats',
			'from' => $filters['from'],
			'to'   => $filters['to'],
			'unit' => $filters['unit'],
			'view'   => $filters['path'],
			'src'    => $filters['src'],
			'device' => $filters['device'],
			'stay'   => $filters['stay'],
		),
		admin_url( 'admin.php' )
	);
	echo '<p><a href="' . esc_url( $back ) . '">一覧へ戻る</a></p>';
	echo '<h2>' . esc_html( shonan_stats_visitor_name( $visitor ) ) . '</h2>';
	echo '<p>' . esc_html( $visitor->device ) . ' / 最初 ' . esc_html( shonan_stats_local_time( $visitor->first_seen ) ) . ' / 最後 ' . esc_html( shonan_stats_local_time( $visitor->last_seen ) ) . '</p>';

	$pages = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'shonan_views WHERE visitor_id = %d ORDER BY started DESC LIMIT 100', $visitor_id ) );
	echo '<h3>見たページ</h3>';
	if ( ! $pages ) {
		echo '<p>ページの記録はありません。</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>日時</th><th>ページ</th><th>見ていた時間</th><th>どこから</th></tr></thead><tbody>';
		foreach ( $pages as $row ) {
			echo '<tr>';
			echo '<td>' . esc_html( shonan_stats_local_time( $row->started ) ) . '</td>';
			echo '<td>' . esc_html( $row->title ? $row->title : $row->path ) . '<br><code>' . esc_html( $row->path ) . '</code></td>';
			echo '<td>' . esc_html( shonan_stats_duration( (int) $row->seconds ) ) . '</td>';
			echo '<td>' . esc_html( $row->referrer ? $row->referrer : '直接' ) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}

	$notices = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'shonan_notice_views WHERE visitor_id = %d ORDER BY started DESC LIMIT 50', $visitor_id ) );
	echo '<h3>トップの告知</h3>';
	if ( ! $notices ) {
		echo '<p>告知を見た記録はありません。</p>';
		return;
	}
	echo '<table class="widefat striped"><thead><tr><th>日時</th><th>告知</th><th>見ていた時間</th><th>閉じた</th></tr></thead><tbody>';
	foreach ( $notices as $row ) {
		echo '<tr>';
		echo '<td>' . esc_html( shonan_stats_local_time( $row->started ) ) . '</td>';
		echo '<td>' . esc_html( $row->title ) . '</td>';
		echo '<td>' . esc_html( shonan_stats_duration( (int) $row->seconds ) ) . '</td>';
		echo '<td>' . ( $row->closed ? '閉じた' : '開いたまま' ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

/**
 * 管理画面の見た目
 */
function shonan_stats_admin_css() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'toplevel_page_shonan-stats' !== $screen->id ) {
		return;
	}
	echo '<style>
		.shonan-stats__cards{display:flex;flex-wrap:wrap;gap:12px;margin:16px 0 24px}
		.shonan-stats__card{min-width:160px;padding:14px 16px;background:#fff;border:1px solid #dcdcde;border-radius:8px}
		.shonan-stats__card span{display:block;color:#646970;font-size:12px}
		.shonan-stats__card strong{display:block;margin-top:4px;font-size:22px}
		.shonan-stats__form{display:flex;flex-wrap:wrap;gap:12px;align-items:end;margin:12px 0}
		.shonan-stats__form label{display:flex;flex-direction:column;gap:4px;font-weight:600}
		.shonan-stats__form select[name="src"]{max-width:220px}
		.shonan-stats__people{margin:8px 0 12px;font-size:16px}
		.shonan-stats__people strong{margin:0 6px;font-size:28px;line-height:1}
		.shonan-stats__people span{display:block;margin-top:4px;color:#646970;font-size:13px}
		.shonan-stats__chart{width:100%;max-width:960px;height:auto;background:#fff;border:1px solid #dcdcde;border-radius:8px}
		.shonan-stats__legend{display:flex;gap:16px}
		.shonan-stats__legend span::before{content:"";display:inline-block;width:18px;height:3px;margin-right:6px;vertical-align:middle}
		.shonan-stats__legend .is-views::before{background:#4aa8c9}
		.shonan-stats__legend .is-people::before{background:#c45b73}
		.shonan-stats table code{color:#646970}
	</style>';
}
add_action( 'admin_head', 'shonan_stats_admin_css' );
