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
		SHONAN_THEME_VERSION
	);

	wp_enqueue_script(
		'shonan-main',
		SHONAN_THEME_URI . '/assets/js/main.js',
		array(),
		SHONAN_THEME_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'shonan_enqueue_assets' );
