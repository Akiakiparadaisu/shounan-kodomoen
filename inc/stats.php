<?php
/**
 * サイト内の閲覧記録
 *
 * 公開ページでは氏名は分からないため、同じブラウザを一人の訪問者として残す。
 * 管理者の閲覧は記録しない。
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * テーブルを用意する
 */
function shonan_stats_install() {
	if ( '2' === get_option( 'shonan_stats_db' ) ) {
		return;
	}

	global $wpdb;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$charset = $wpdb->get_charset_collate();
	$visitors = $wpdb->prefix . 'shonan_visitors';
	$views    = $wpdb->prefix . 'shonan_views';
	$notices  = $wpdb->prefix . 'shonan_notice_views';
	$sections = $wpdb->prefix . 'shonan_sections';

	dbDelta(
		"CREATE TABLE {$visitors} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			token char(32) NOT NULL,
			user_id bigint(20) unsigned NOT NULL DEFAULT 0,
			device varchar(20) NOT NULL DEFAULT '',
			first_seen datetime NOT NULL,
			last_seen datetime NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY token (token)
		) {$charset};"
	);

	dbDelta(
		"CREATE TABLE {$views} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			visitor_id bigint(20) unsigned NOT NULL,
			path varchar(191) NOT NULL DEFAULT '',
			title varchar(191) NOT NULL DEFAULT '',
			referrer varchar(191) NOT NULL DEFAULT '',
			started datetime NOT NULL,
			seconds int(10) unsigned NOT NULL DEFAULT 0,
			PRIMARY KEY  (id),
			KEY visitor_id (visitor_id),
			KEY started (started),
			KEY path (path)
		) {$charset};"
	);

	dbDelta(
		"CREATE TABLE {$notices} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			visitor_id bigint(20) unsigned NOT NULL,
			revision varchar(20) NOT NULL DEFAULT '',
			title varchar(191) NOT NULL DEFAULT '',
			started datetime NOT NULL,
			seconds int(10) unsigned NOT NULL DEFAULT 0,
			closed tinyint(1) NOT NULL DEFAULT 0,
			PRIMARY KEY  (id),
			KEY visitor_id (visitor_id),
			KEY started (started)
		) {$charset};"
	);

	dbDelta(
		"CREATE TABLE {$sections} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			visitor_id bigint(20) unsigned NOT NULL,
			path varchar(191) NOT NULL DEFAULT '',
			label varchar(80) NOT NULL DEFAULT '',
			started datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY visitor_id (visitor_id),
			KEY path_label (path, label),
			KEY started (started)
		) {$charset};"
	);

	update_option( 'shonan_stats_db', '2', false );
}
add_action( 'init', 'shonan_stats_install', 5 );

/**
 * 古い記録を消す
 */
function shonan_stats_prune() {
	global $wpdb;
	$cutoff = gmdate( 'Y-m-d H:i:s', time() - 180 * DAY_IN_SECONDS );
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'shonan_views WHERE started < %s', $cutoff ) );
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'shonan_notice_views WHERE started < %s', $cutoff ) );
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'shonan_sections WHERE started < %s', $cutoff ) );
	shonan_stats_drop_orphans();
	$wpdb->query(
		'DELETE v FROM ' . $wpdb->prefix . 'shonan_visitors v
		LEFT JOIN ' . $wpdb->prefix . 'shonan_views p ON p.visitor_id = v.id
		LEFT JOIN ' . $wpdb->prefix . 'shonan_notice_views n ON n.visitor_id = v.id
		LEFT JOIN ' . $wpdb->prefix . 'shonan_sections s ON s.visitor_id = v.id
		WHERE p.id IS NULL AND n.id IS NULL AND s.id IS NULL'
	);
}
add_action( 'shonan_stats_prune', 'shonan_stats_prune' );

/**
 * 訪問者と結び付いていない記録を消す
 */
function shonan_stats_drop_orphans() {
	global $wpdb;
	foreach ( array( 'shonan_views', 'shonan_notice_views', 'shonan_sections' ) as $name ) {
		$table = $wpdb->prefix . $name;
		$wpdb->query( "DELETE t FROM {$table} t LEFT JOIN {$wpdb->prefix}shonan_visitors v ON v.id = t.visitor_id WHERE v.id IS NULL" );
	}
}

/**
 * 日次の掃除を予約する
 */
function shonan_stats_schedule() {
	if ( ! wp_next_scheduled( 'shonan_stats_prune' ) ) {
		wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'shonan_stats_prune' );
	}
}
add_action( 'init', 'shonan_stats_schedule', 6 );

/**
 * 記録用スクリプト
 */
function shonan_stats_enqueue() {
	if ( is_admin() || is_preview() || is_customize_preview() ) {
		return;
	}
	if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	wp_enqueue_script(
		'shonan-stats',
		SHONAN_THEME_URI . '/assets/js/stats.js',
		array(),
		shonan_asset_version( 'assets/js/stats.js' ),
		true
	);
	wp_localize_script(
		'shonan-stats',
		'shonanStats',
		array(
			'ajax'  => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'shonan_stats' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'shonan_stats_enqueue' );

/**
 * 記録を受け取る
 */
function shonan_stats_collect() {
	check_ajax_referer( 'shonan_stats', 'nonce' );

	if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
		wp_die( '0' );
	}
	if ( shonan_stats_is_bot() ) {
		wp_die( '0' );
	}

	$token = isset( $_POST['token'] ) ? strtolower( sanitize_text_field( wp_unslash( $_POST['token'] ) ) ) : '';
	if ( ! preg_match( '/^[a-f0-9]{32}$/', $token ) ) {
		wp_die( '0' );
	}
	if ( ! shonan_stats_rate_ok( $token ) ) {
		wp_die( '0' );
	}

	$visitor_id = shonan_stats_touch_visitor( $token );
	$type       = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';

	if ( 'page' === $type ) {
		wp_send_json( array( 'id' => shonan_stats_insert_view( $visitor_id ) ) );
	}
	if ( 'dwell' === $type ) {
		shonan_stats_update_seconds( 'views', $visitor_id );
		wp_die( '1' );
	}
	if ( 'notice' === $type ) {
		wp_send_json( array( 'id' => shonan_stats_insert_notice( $visitor_id ) ) );
	}
	if ( 'notice_dwell' === $type ) {
		shonan_stats_update_seconds( 'notices', $visitor_id );
		wp_die( '1' );
	}
	if ( 'section' === $type ) {
		shonan_stats_insert_section( $visitor_id );
		wp_die( '1' );
	}

	wp_die( '0' );
}
add_action( 'wp_ajax_nopriv_shonan_stats', 'shonan_stats_collect' );
add_action( 'wp_ajax_shonan_stats', 'shonan_stats_collect' );

/**
 * クローラを除く
 *
 * @return bool
 */
function shonan_stats_is_bot() {
	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? (string) wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) : '';
	if ( '' === trim( $ua ) ) {
		return true;
	}
	return (bool) preg_match( '/bot|crawl|spider|slurp|preview|lighthouse|headless|wget|curl/i', $ua );
}

/**
 * 短時間の連打を止める
 *
 * @param string $token 訪問者トークン.
 * @return bool
 */
function shonan_stats_rate_ok( $token ) {
	$key = 'shonan_st_' . substr( md5( $token ), 0, 16 );
	$n   = (int) get_transient( $key );
	if ( $n > 180 ) {
		return false;
	}
	set_transient( $key, $n + 1, MINUTE_IN_SECONDS );
	return true;
}

/**
 * 端末の種類
 *
 * @return string
 */
function shonan_stats_device() {
	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? (string) wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) : '';
	if ( preg_match( '/iPad|Tablet/i', $ua ) ) {
		return 'タブレット';
	}
	if ( preg_match( '/Mobile|iPhone|Android/i', $ua ) ) {
		return 'スマホ';
	}
	return 'パソコン';
}

/**
 * グラフで選ぶ端末
 *
 * @return array<string,string>
 */
function shonan_stats_device_choices() {
	return array(
		''        => 'すべて',
		'pc'      => 'パソコン',
		'phone'   => '携帯',
		'tablet'  => 'タブレット',
	);
}

/**
 * 選んだ端末と、記録にある端末が同じか
 *
 * @param string $choice グラフの選択.
 * @param string $stored 記録の端末.
 * @return bool
 */
function shonan_stats_device_matches( $choice, $stored ) {
	$map = array(
		'pc'     => 'パソコン',
		'phone'  => 'スマホ',
		'tablet' => 'タブレット',
	);
	if ( '' === $choice ) {
		return true;
	}
	return isset( $map[ $choice ] ) && $map[ $choice ] === $stored;
}

/**
 * グラフで選ぶ滞在時間
 *
 * @return array<string,string>
 */
function shonan_stats_stay_choices() {
	return array(
		''       => 'すべて',
		'under1' => '1分未満',
		'1to5'   => '1分〜5分',
		'over5'  => '5分以上',
	);
}

/**
 * 滞在秒数が選んだ区分に入るか
 *
 * @param string $choice 区分.
 * @param int    $seconds 合計秒数.
 * @return bool
 */
function shonan_stats_stay_matches( $choice, $seconds ) {
	$seconds = max( 0, (int) $seconds );
	if ( '' === $choice ) {
		return true;
	}
	if ( 'under1' === $choice ) {
		return $seconds < 60;
	}
	if ( '1to5' === $choice ) {
		return $seconds >= 60 && $seconds < 300;
	}
	if ( 'over5' === $choice ) {
		return $seconds >= 300;
	}
	return false;
}

/**
 * 訪問者ごとの滞在時間の合計
 *
 * @param array<int,object> $rows ページ閲覧.
 * @return array<int,int>
 */
function shonan_stats_stay_totals( $rows ) {
	$totals = array();
	foreach ( $rows as $row ) {
		$id = (int) $row->visitor_id;
		if ( ! isset( $totals[ $id ] ) ) {
			$totals[ $id ] = 0;
		}
		$totals[ $id ] += max( 0, (int) $row->seconds );
	}
	return $totals;
}

/**
 * 滞在時間ごとの人数
 *
 * @param array<int,object> $rows ページ閲覧.
 * @return array<string,int>
 */
function shonan_stats_stay_counts( $rows ) {
	$counts = array(
		'under1' => 0,
		'1to5'   => 0,
		'over5'  => 0,
	);
	foreach ( shonan_stats_stay_totals( $rows ) as $seconds ) {
		if ( $seconds >= 300 ) {
			$counts['over5']++;
		} elseif ( $seconds >= 60 ) {
			$counts['1to5']++;
		} else {
			$counts['under1']++;
		}
	}
	return $counts;
}

/**
 * 訪問者ごとの滞在時間の合計で行を残す
 *
 * @param array<int,object> $rows ページ閲覧.
 * @param string            $choice 区分.
 * @return array<int,object>
 */
function shonan_stats_filter_by_stay( $rows, $choice ) {
	if ( '' === $choice || ! $rows ) {
		return $rows;
	}
	$keep = array();
	foreach ( shonan_stats_stay_totals( $rows ) as $id => $seconds ) {
		if ( shonan_stats_stay_matches( $choice, $seconds ) ) {
			$keep[ $id ] = true;
		}
	}
	return array_values(
		array_filter(
			$rows,
			static function ( $row ) use ( $keep ) {
				return isset( $keep[ (int) $row->visitor_id ] );
			}
		)
	);
}

/**
 * 直前のページを、グラフで選ぶ区分にする
 *
 * @param string $referrer 直前のURL.
 * @return string
 */
function shonan_stats_source_key( $referrer ) {
	$referrer = trim( (string) $referrer );
	if ( '' === $referrer ) {
		return 'direct';
	}
	$host = wp_parse_url( $referrer, PHP_URL_HOST );
	if ( ! is_string( $host ) || '' === $host ) {
		return 'direct';
	}
	$host = strtolower( $host );
	if ( 0 === strpos( $host, 'www.' ) ) {
		$host = substr( $host, 4 );
	}

	$site = wp_parse_url( home_url(), PHP_URL_HOST );
	$site = is_string( $site ) ? strtolower( $site ) : '';
	if ( 0 === strpos( $site, 'www.' ) ) {
		$site = substr( $site, 4 );
	}
	if ( '' !== $site && $host === $site ) {
		return 'site';
	}
	if ( false !== strpos( $host, 'google.' ) ) {
		return 'google';
	}
	if ( false !== strpos( $host, 'yahoo.' ) ) {
		return 'yahoo';
	}
	if ( 'bing.com' === $host ) {
		return 'bing';
	}
	if ( 'instagram.com' === $host ) {
		return 'instagram';
	}
	if ( false !== strpos( $host, 'facebook.com' ) || 'fb.com' === $host ) {
		return 'facebook';
	}
	if ( in_array( $host, array( 't.co', 'twitter.com', 'x.com' ), true ) ) {
		return 'x';
	}
	if ( false !== strpos( $host, 'line.me' ) ) {
		return 'line';
	}
	if ( 'youtube.com' === $host || 'youtu.be' === $host ) {
		return 'youtube';
	}
	return $host;
}

/**
 * どこからの表示名
 *
 * @param string $key 区分.
 * @return string
 */
function shonan_stats_source_label( $key ) {
	$labels = array(
		'direct'    => '直接',
		'site'      => '園のサイト内',
		'google'    => 'Google',
		'yahoo'     => 'Yahoo',
		'bing'      => 'Bing',
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'x'         => 'X',
		'line'      => 'LINE',
		'youtube'   => 'YouTube',
	);
	if ( isset( $labels[ $key ] ) ) {
		return $labels[ $key ];
	}
	return $key;
}

/**
 * グラフの「どこから」として受け取ってよいか
 *
 * @param string $key 区分.
 * @return bool
 */
function shonan_stats_source_key_ok( $key ) {
	if ( '' === $key ) {
		return true;
	}
	$named = array( 'direct', 'site', 'google', 'yahoo', 'bing', 'instagram', 'facebook', 'x', 'line', 'youtube' );
	if ( in_array( $key, $named, true ) ) {
		return true;
	}
	return (bool) preg_match( '/^(?:[a-z0-9](?:[a-z0-9-]{0,40}[a-z0-9])?\.)+[a-z]{2,24}$/', $key );
}

/**
 * 訪問者を作成または更新する
 *
 * @param string $token トークン.
 * @return int
 */
function shonan_stats_touch_visitor( $token ) {
	global $wpdb;
	$table = $wpdb->prefix . 'shonan_visitors';
	$now   = current_time( 'mysql', true );
	$id    = (int) $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$table} WHERE token = %s", $token ) );

	if ( $id ) {
		$wpdb->update(
			$table,
			array(
				'last_seen' => $now,
				'device'    => shonan_stats_device(),
			),
			array( 'id' => $id ),
			array( '%s', '%s' ),
			array( '%d' )
		);
		return $id;
	}

	$wpdb->insert(
		$table,
		array(
			'token'      => $token,
			'user_id'    => get_current_user_id(),
			'device'     => shonan_stats_device(),
			'first_seen' => $now,
			'last_seen'  => $now,
		),
		array( '%s', '%d', '%s', '%s', '%s' )
	);

	$id = (int) $wpdb->insert_id;
	if ( $id ) {
		return $id;
	}

	// 同時に届いた記録で作成に失敗したときは、できた方のIDを使う
	return (int) $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$table} WHERE token = %s", $token ) );
}

/**
 * 送られてきたパスを整える
 *
 * @return string
 */
function shonan_stats_path() {
	$raw = isset( $_POST['path'] ) ? sanitize_text_field( wp_unslash( $_POST['path'] ) ) : '';
	$raw = strtok( $raw, '#' );
	if ( ! is_string( $raw ) || '' === $raw ) {
		return '/';
	}
	if ( 0 !== strpos( $raw, '/' ) ) {
		$parts = wp_parse_url( $raw );
		$raw   = isset( $parts['path'] ) ? $parts['path'] : '/';
		if ( ! empty( $parts['query'] ) ) {
			$raw .= '?' . $parts['query'];
		}
	}
	if ( 0 === strpos( $raw, '/wp-admin' ) || 0 === strpos( $raw, '/wp-login' ) ) {
		return '';
	}
	return mb_substr( $raw, 0, 191 );
}

/**
 * ページ閲覧を追加する
 *
 * @param int $visitor_id 訪問者ID.
 * @return int
 */
function shonan_stats_insert_view( $visitor_id ) {
	global $wpdb;
	$path = shonan_stats_path();
	if ( ! $visitor_id || '' === $path ) {
		return 0;
	}
	$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
	$ref   = isset( $_POST['referrer'] ) ? esc_url_raw( wp_unslash( $_POST['referrer'] ) ) : '';

	$wpdb->insert(
		$wpdb->prefix . 'shonan_views',
		array(
			'visitor_id' => $visitor_id,
			'path'       => $path,
			'title'      => mb_substr( $title, 0, 191 ),
			'referrer'   => mb_substr( (string) $ref, 0, 191 ),
			'started'    => current_time( 'mysql', true ),
			'seconds'    => 0,
		),
		array( '%d', '%s', '%s', '%s', '%s', '%d' )
	);

	return (int) $wpdb->insert_id;
}

/**
 * 告知の表示を追加する
 *
 * @param int $visitor_id 訪問者ID.
 * @return int
 */
function shonan_stats_insert_notice( $visitor_id ) {
	global $wpdb;
	if ( ! $visitor_id ) {
		return 0;
	}
	$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
	$rev   = isset( $_POST['revision'] ) ? sanitize_text_field( wp_unslash( $_POST['revision'] ) ) : '';
	if ( '' === $title ) {
		$title = 'お知らせ';
	}

	$wpdb->insert(
		$wpdb->prefix . 'shonan_notice_views',
		array(
			'visitor_id' => $visitor_id,
			'revision'   => mb_substr( $rev, 0, 20 ),
			'title'      => mb_substr( $title, 0, 191 ),
			'started'    => current_time( 'mysql', true ),
			'seconds'    => 0,
			'closed'     => 0,
		),
		array( '%d', '%s', '%s', '%s', '%d', '%d' )
	);

	return (int) $wpdb->insert_id;
}

/**
 * ページ内の見出しが画面に入ったことを残す
 *
 * @param int $visitor_id 訪問者ID.
 */
function shonan_stats_insert_section( $visitor_id ) {
	global $wpdb;
	if ( ! $visitor_id ) {
		return;
	}
	$path  = shonan_stats_path();
	$label = isset( $_POST['label'] ) ? sanitize_text_field( wp_unslash( $_POST['label'] ) ) : '';
	$label = trim( preg_replace( '/\s+/u', ' ', $label ) );
	if ( '' === $path || '' === $label ) {
		return;
	}

	$wpdb->insert(
		$wpdb->prefix . 'shonan_sections',
		array(
			'visitor_id' => $visitor_id,
			'path'       => $path,
			'label'      => mb_substr( $label, 0, 80 ),
			'started'    => current_time( 'mysql', true ),
		),
		array( '%d', '%s', '%s', '%s' )
	);
}

/**
 * 見ていた秒数を更新する
 *
 * @param string $kind views または notices.
 * @param int    $visitor_id 訪問者ID.
 */
function shonan_stats_update_seconds( $kind, $visitor_id ) {
	global $wpdb;
	$id      = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
	$seconds = isset( $_POST['seconds'] ) ? min( 1800, absint( $_POST['seconds'] ) ) : 0;
	if ( ! $id ) {
		return;
	}

	if ( 'notices' === $kind ) {
		$closed = empty( $_POST['closed'] ) ? 0 : 1;
		$wpdb->query(
			$wpdb->prepare(
				'UPDATE ' . $wpdb->prefix . 'shonan_notice_views SET seconds = GREATEST(seconds, %d), closed = GREATEST(closed, %d) WHERE id = %d AND visitor_id = %d',
				$seconds,
				$closed,
				$id,
				$visitor_id
			)
		);
		return;
	}

	$wpdb->query(
		$wpdb->prepare(
			'UPDATE ' . $wpdb->prefix . 'shonan_views SET seconds = GREATEST(seconds, %d) WHERE id = %d AND visitor_id = %d',
			$seconds,
			$id,
			$visitor_id
		)
	);
}

/**
 * 秒数を読みやすくする
 *
 * @param int $seconds 秒.
 * @return string
 */
function shonan_stats_duration( $seconds ) {
	$seconds = (int) $seconds;
	if ( $seconds < 1 ) {
		return '1秒未満';
	}
	if ( $seconds < 60 ) {
		return $seconds . '秒';
	}
	$minutes = intdiv( $seconds, 60 );
	$remain  = $seconds % 60;
	if ( $minutes < 60 ) {
		return $remain ? $minutes . '分' . $remain . '秒' : $minutes . '分';
	}
	$hours = intdiv( $minutes, 60 );
	$mins  = $minutes % 60;
	return $mins ? $hours . '時間' . $mins . '分' : $hours . '時間';
}

/**
 * 園のある寒川町のタイムゾーン。
 * サイト設定が UTC のままでも、記録は日本時間で読む。
 *
 * @return DateTimeZone
 */
function shonan_stats_timezone() {
	static $zone = null;
	if ( null === $zone ) {
		$zone = new DateTimeZone( 'Asia/Tokyo' );
	}
	return $zone;
}

/**
 * 記録日時を日本時間で表示する
 *
 * @param string $gmt GMT日時.
 * @return string
 */
function shonan_stats_local_time( $gmt ) {
	$stamp = strtotime( $gmt . ' UTC' );
	if ( ! $stamp ) {
		return '';
	}
	return wp_date( 'Y年n月j日 G時i分', $stamp, shonan_stats_timezone() );
}

/**
 * 期間の開始（GMT）
 *
 * @param int $days 日数.
 * @return string
 */
function shonan_stats_since( $days ) {
	$days  = max( 1, (int) $days );
	$start = new DateTimeImmutable( 'today', shonan_stats_timezone() );
	if ( $days > 1 ) {
		$start = $start->modify( '-' . ( $days - 1 ) . ' days' );
	}
	return $start->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'Y-m-d H:i:s' );
}

/**
 * 日付の範囲をGMTの開始・終了にする。終了はその日の終わり。
 *
 * @param string $from Y-m-d.
 * @param string $to Y-m-d.
 * @return array{0:string,1:string}
 */
function shonan_stats_range_gmt( $from, $to ) {
	$tz    = shonan_stats_timezone();
	$start = new DateTimeImmutable( $from . ' 00:00:00', $tz );
	$end   = new DateTimeImmutable( $to . ' 00:00:00', $tz );
	$end   = $end->modify( '+1 day' );
	return array(
		$start->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'Y-m-d H:i:s' ),
		$end->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'Y-m-d H:i:s' ),
	);
}

/**
 * 訪問者の表示名
 *
 * @param object $visitor 行.
 * @return string
 */
function shonan_stats_visitor_name( $visitor ) {
	if ( ! empty( $visitor->user_id ) ) {
		$user = get_userdata( (int) $visitor->user_id );
		if ( $user ) {
			return $user->display_name;
		}
	}
	return '訪問者 ' . strtoupper( substr( (string) $visitor->token, 0, 4 ) );
}
