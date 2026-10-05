<?php
/**
 * スタイル・スクリプト読み込み
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ファイル更新時刻をバージョンに使う（手動のバージョン上げ不要）
 *
 * @param string $relative_path テーマ内の相対パス.
 * @return string|bool
 */
function shonan_asset_version( $relative_path ) {
	$path = SHONAN_THEME_DIR . '/' . ltrim( $relative_path, '/' );
	return file_exists( $path ) ? (string) filemtime( $path ) : false;
}

/**
 * フォントの事前接続
 */
function shonan_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.googleapis.com',
			'crossorigin' => false,
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'shonan_resource_hints', 10, 2 );

/**
 * フロント用アセット
 */
function shonan_enqueue_assets() {
	$font_url = 'https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500;700;800&family=Zen+Maru+Gothic:wght@400;500;700&display=swap';

	if ( is_page( 'history' ) ) {
		$font_url = 'https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500;700;800&family=Shippori+Mincho:wght@500;600;700&family=Zen+Maru+Gothic:wght@400;500;700&display=swap';
	}

	wp_enqueue_style(
		'shonan-fonts',
		$font_url,
		array(),
		null
	);

	wp_enqueue_style(
		'shonan-main',
		SHONAN_THEME_URI . '/assets/css/main.css',
		array( 'shonan-fonts' ),
		shonan_asset_version( 'assets/css/main.css' )
	);

	wp_enqueue_script(
		'shonan-main',
		SHONAN_THEME_URI . '/assets/js/main.js',
		array(),
		shonan_asset_version( 'assets/js/main.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'shonan_enqueue_assets' );

/**
 * 絵文字スクリプトなど、このサイトで使わない読み込みを外す
 */
function shonan_trim_front_assets() {
	if ( is_admin() ) {
		return;
	}
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'shonan_trim_front_assets', 100 );
