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
 * フロント用アセット
 */
function shonan_enqueue_assets() {
	wp_enqueue_style(
		'shonan-fonts',
		'https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500;700;800&family=Zen+Maru+Gothic:wght@400;500;700&display=swap',
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
		true
	);
}
add_action( 'wp_enqueue_scripts', 'shonan_enqueue_assets' );
