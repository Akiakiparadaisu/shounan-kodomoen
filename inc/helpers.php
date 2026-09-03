<?php
/**
 * ヘルパー関数
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * プレースホルダー画像のURLを返す
 *
 * @param string $name 画像ファイル名（拡張子なし可）.
 * @return string
 */
function shonan_placeholder( $name = 'hero' ) {
	$map = array(
		'hero'      => 'placeholder-hero.svg',
		'life'      => 'placeholder-life.svg',
		'facility'  => 'placeholder-facility.svg',
		'admission' => 'placeholder-admission.svg',
		'career'    => 'placeholder-career.svg',
		'history'   => 'placeholder-history.svg',
		'about'     => 'placeholder-about.svg',
		'news'      => 'placeholder-news.svg',
	);

	$file = isset( $map[ $name ] ) ? $map[ $name ] : 'placeholder-hero.svg';
	return SHONAN_THEME_URI . '/assets/images/' . $file;
}

/**
 * デフォルトのグローバルナビ項目
 *
 * @return array
 */
function shonan_default_nav_items() {
	return array(
		array(
			'label' => 'トップ',
			'url'   => home_url( '/' ),
		),
		array(
			'label' => '園の方針と特長',
			'url'   => home_url( '/houshin/' ),
		),
		array(
			'label' => '園生活のようす',
			'url'   => home_url( '/enseikatsu/' ),
		),
		array(
			'label' => '園の施設',
			'url'   => home_url( '/shisetsu/' ),
		),
		array(
			'label' => '入園のご希望',
			'url'   => home_url( '/nyuen/' ),
		),
		array(
			'label' => '求職中の方へ',
			'url'   => home_url( '/kyujin/' ),
		),
		array(
			'label' => '50年の実績',
			'url'   => home_url( '/history/' ),
		),
		array(
			'label' => '将来の幼児教育',
			'url'   => home_url( '/mirai/' ),
		),
	);
}

/**
 * ナビ未設定時のフォールバック
 */
function shonan_fallback_menu() {
	$items = shonan_default_nav_items();
	echo '<ul class="nav-list">';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * パンくず
 */
function shonan_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumb" aria-label="パンくずリスト"><ol class="breadcrumb-list">';
	printf(
		'<li><a href="%s">トップ</a></li>',
		esc_url( home_url( '/' ) )
	);

	if ( is_singular() ) {
		printf( '<li aria-current="page">%s</li>', esc_html( get_the_title() ) );
	} elseif ( is_search() ) {
		printf(
			'<li aria-current="page">「%s」の検索結果</li>',
			esc_html( get_search_query() )
		);
	} elseif ( is_404() ) {
		echo '<li aria-current="page">ページが見つかりません</li>';
	}

	echo '</ol></nav>';
}
