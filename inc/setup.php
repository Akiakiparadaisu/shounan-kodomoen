<?php
/**
 * テーマセットアップ
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * テーマサポート・メニュー登録
 */
function shonan_theme_setup() {
	load_theme_textdomain( 'shonan-kodomoen', SHONAN_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary'   => __( 'グローバルナビ', 'shonan-kodomoen' ),
			'footer'    => __( 'フッターナビ', 'shonan-kodomoen' ),
			'mobile'    => __( 'モバイルナビ', 'shonan-kodomoen' ),
		)
	);

	add_image_size( 'shonan-hero', 1920, 1080, true );
	add_image_size( 'shonan-card', 800, 560, true );
	add_image_size( 'shonan-thumb', 640, 480, true );
}
add_action( 'after_setup_theme', 'shonan_theme_setup' );

/**
 * ウィジェットエリア
 */
function shonan_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'サイドバー', 'shonan-kodomoen' ),
			'id'            => 'sidebar-1',
			'description'   => __( '下層ページ用サイドバー', 'shonan-kodomoen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'フッターお知らせ', 'shonan-kodomoen' ),
			'id'            => 'footer-notice',
			'description'   => __( 'フッター上部のお知らせエリア', 'shonan-kodomoen' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'shonan_widgets_init' );

/**
 * body_class にページスラッグを追加
 */
function shonan_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}
	return $classes;
}
add_filter( 'body_class', 'shonan_body_classes' );
