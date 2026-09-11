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
 * メニュー対応の画像URLを返す
 *
 * 優先順:
 * 1. assets/images/photos/{menu}/{menu}.{jpg|png|webp|svg}
 * 2. assets/images/photos/{menu}/{submenu}/{submenu}.{ext}
 *
 * @param string $name メニュースラッグ（例: top, houshin, enseikatsu/en-bus）.
 * @return string
 */
function shonan_placeholder( $name = 'top' ) {
	$name = trim( str_replace( '\\', '/', $name ), '/' );
	$parts = array_values( array_filter( explode( '/', $name ) ) );

	if ( empty( $parts ) ) {
		$parts = array( 'top' );
	}

	$menu    = $parts[0];
	$leaf    = end( $parts );
	$rel_dir = 'photos/' . implode( '/', $parts );
	$base    = SHONAN_THEME_DIR . '/assets/images/' . $rel_dir;

	$extensions = array( 'jpg', 'jpeg', 'png', 'webp', 'svg' );
	foreach ( $extensions as $ext ) {
		$file = $base . '/' . $leaf . '.' . $ext;
		if ( file_exists( $file ) ) {
			return SHONAN_THEME_URI . '/assets/images/' . $rel_dir . '/' . $leaf . '.' . $ext;
		}
	}

	// フォールバック: 親メニュー画像
	$parent = SHONAN_THEME_DIR . '/assets/images/photos/' . $menu . '/' . $menu . '.svg';
	if ( file_exists( $parent ) ) {
		return SHONAN_THEME_URI . '/assets/images/photos/' . $menu . '/' . $menu . '.svg';
	}

	return SHONAN_THEME_URI . '/assets/images/photos/top/top.svg';
}

/**
 * photos/ 配下の実ファイルURLを返す
 *
 * @param string $relative photos/ からの相対パス（例: houshin/tokubetsu-hoiku/kokusai.jpg）.
 * @return string
 */
function shonan_photo( $relative ) {
	$relative = ltrim( str_replace( '\\', '/', $relative ), '/' );
	$relative = preg_replace( '#^photos/#', '', $relative );

	$full = SHONAN_THEME_DIR . '/assets/images/photos/' . $relative;
	if ( file_exists( $full ) ) {
		return SHONAN_THEME_URI . '/assets/images/photos/' . $relative;
	}

	$dir = dirname( $relative );
	return shonan_placeholder( '.' === $dir ? 'top' : $dir );
}

/**
 * documents/ 配下のファイルURLを返す
 *
 * @param string $relative documents/ からの相対パス.
 * @return string|false ファイルがなければ false.
 */
function shonan_document( $relative ) {
	$relative = ltrim( str_replace( '\\', '/', $relative ), '/' );
	$relative = preg_replace( '#^documents/#', '', $relative );

	$full = SHONAN_THEME_DIR . '/assets/documents/' . $relative;
	if ( ! file_exists( $full ) ) {
		return false;
	}

	return SHONAN_THEME_URI . '/assets/documents/' . $relative;
}

/**
 * 写真ディレクトリの相対パス（メニュー対応）
 *
 * @param string $name メニュースラッグ.
 * @return string
 */
function shonan_photo_dir( $name = 'top' ) {
	$name = trim( str_replace( '\\', '/', $name ), '/' );
	return 'assets/images/photos/' . $name;
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
