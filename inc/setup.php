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
 * 寒川町の園なので、初期値の UTC は日本時間に直す。
 * 管理画面で別のタイムゾーンを選んでいる場合はそのままにする。
 */
function shonan_ensure_tokyo_timezone() {
	if ( 'Asia/Tokyo' === get_option( 'timezone_string' ) ) {
		return;
	}
	if ( '' !== (string) get_option( 'timezone_string' ) ) {
		return;
	}
	if ( 0.0 !== (float) get_option( 'gmt_offset' ) ) {
		return;
	}
	update_option( 'timezone_string', 'Asia/Tokyo' );
	update_option( 'gmt_offset', '9' );
}
add_action( 'init', 'shonan_ensure_tokyo_timezone' );

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

/**
 * 検索結果に出るタイトル。画面上の見出しとは別に、園名と地域の言葉を入れる。
 *
 * @param string $title 既存タイトル.
 * @return string
 */
function shonan_document_title( $title ) {
	$brand = '湘南こども園';
	$pages = array(
		'houshin'             => '園の方針｜寒川町の認定こども園 ' . $brand,
		'enseikatsu'          => '園生活・園バス・給食｜寒川町 ' . $brand,
		'shisetsu'            => '園の施設｜寒川町の認定こども園 ' . $brand,
		'nyuen'               => '入園案内・説明会｜寒川町の認定こども園 ' . $brand,
		'kyujin'              => '保育士求人｜寒川町 ' . $brand,
		'history'             => '50年の幼児教育実績｜寒川町 ' . $brand,
		'mirai'               => 'これからの幼児教育｜寒川町 ' . $brand,
		'shorui'              => '在園の保護者へ｜' . $brand,
		'pre-hoiku'           => '湘南ジュニア｜寒川町の未就園児・誰でも通園',
		'tokubetsu-hoiku'     => '特別保育｜寒川町の認定こども園 ' . $brand,
		'ichinichi-no-nagare' => '一日の流れ｜寒川町 ' . $brand,
		'nenkan-gyoji'        => '年間行事｜寒川町 ' . $brand,
	);

	if ( is_front_page() ) {
		return $brand . '｜寒川町の認定こども園、誰でも通園実施中';
	}

	if ( is_home() ) {
		return 'おしらせ｜寒川町 ' . $brand;
	}

	if ( is_404() ) {
		return 'ページが見つかりません｜' . $brand;
	}

	if ( is_search() ) {
		return '検索結果｜' . $brand;
	}

	if ( is_singular( 'post' ) ) {
		return get_the_title() . '｜' . $brand;
	}

	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $pages[ $slug ] ) ) {
			return $pages[ $slug ];
		}
		return get_the_title() . '｜' . $brand;
	}

	return $title;
}
add_filter( 'pre_get_document_title', 'shonan_document_title' );

/**
 * 検索結果とブラウザタブ用のサイトアイコン
 */
function shonan_site_icon() {
	$file = SHONAN_THEME_DIR . '/assets/images/site-icon.png';
	if ( ! is_file( $file ) ) {
		return;
	}

	$url = SHONAN_THEME_URI . '/assets/images/site-icon.png?v=' . rawurlencode( (string) filemtime( $file ) );
	printf(
		'<link rel="icon" href="%1$s" type="image/png" sizes="192x192">' . "\n",
		esc_url( $url )
	);
	printf(
		'<link rel="apple-touch-icon" href="%1$s">' . "\n",
		esc_url( $url )
	);
}
add_action( 'wp_head', 'shonan_site_icon', 2 );
