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

	$parts = array_map( 'rawurlencode', explode( '/', $relative ) );
	return SHONAN_THEME_URI . '/assets/documents/' . implode( '/', $parts );
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
			'label' => '50年の幼児教育実績',
			'url'   => home_url( '/history/' ),
		),
		array(
			'label' => '将来の幼児教育',
			'url'   => home_url( '/mirai/' ),
		),
		array(
			'label' => '在園の保護者へ',
			'url'   => home_url( '/shorui/' ),
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
 * 「これまでの活動」投稿一覧ページのURL
 *
 * @return string
 */
function shonan_activities_archive_url() {
	$page_id = shonan_ensure_activities_page();
	if ( $page_id ) {
		return get_permalink( $page_id );
	}
	return home_url( '/katsudo/' );
}

/**
 * 投稿一覧用固定ページを用意し page_for_posts に設定
 *
 * @return int ページID（失敗時は 0）
 */
function shonan_ensure_activities_page() {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id && get_post( $posts_page_id ) ) {
		return $posts_page_id;
	}

	$existing = get_page_by_path( 'katsudo' );
	if ( $existing ) {
		update_option( 'page_for_posts', (int) $existing->ID );
		return (int) $existing->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'これまでの活動',
			'post_name'    => 'katsudo',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => 1,
		),
		true
	);

	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}

	update_option( 'page_for_posts', (int) $page_id );
	return (int) $page_id;
}

/**
 * 在園の保護者向けページを用意する
 *
 * @return int
 */
function shonan_ensure_shorui_page() {
	$existing = get_page_by_path( 'shorui' );
	if ( $existing ) {
		if ( '在園の保護者へ' !== $existing->post_title ) {
			wp_update_post(
				array(
					'ID'         => $existing->ID,
					'post_title' => '在園の保護者へ',
				)
			);
		}
		return (int) $existing->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'  => '在園の保護者へ',
			'post_name'   => 'shorui',
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_author' => 1,
		),
		true
	);

	return is_wp_error( $page_id ) ? 0 : (int) $page_id;
}

/**
 * 不要なメニューを外し、在園の保護者へを追加する
 */
function shonan_ensure_nav_extras() {
	if ( 'parents' === get_option( 'shonan_nav_extras' ) ) {
		return;
	}

	$page_id = shonan_ensure_shorui_page();
	$url     = $page_id ? get_permalink( $page_id ) : home_url( '/shorui/' );

	$remove    = array( '湘南ジュニア', '書類ダウンロード', 'これまでの活動', '在園の保護者の方へ' );
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menu_ids  = array_values( array_unique( array_filter( array_map( 'intval', (array) $locations ) ) ) );

	if ( ! $menu_ids ) {
		$menus = wp_get_nav_menus();
		if ( $menus ) {
			$menu_ids[] = (int) $menus[0]->term_id;
		}
	}

	foreach ( $menu_ids as $menu_id ) {
		$items = wp_get_nav_menu_items( $menu_id );
		$has   = false;
		$pos   = 1;
		if ( $items ) {
			$pos = count( $items ) + 1;
			foreach ( $items as $item ) {
				if ( in_array( $item->title, $remove, true ) ) {
					wp_delete_post( $item->ID, true );
					continue;
				}
				if ( '在園の保護者へ' === $item->title ) {
					$has = true;
				}
				if ( '求職中の方へ' === $item->title ) {
					$pos = (int) $item->menu_order + 1;
				}
			}
		}
		if ( $has ) {
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'    => '在園の保護者へ',
				'menu-item-url'      => $url,
				'menu-item-status'   => 'publish',
				'menu-item-type'     => 'custom',
				'menu-item-position' => $pos,
			)
		);
	}

	update_option( 'shonan_nav_extras', 'parents' );
}
add_action( 'init', 'shonan_ensure_nav_extras' );
add_action( 'init', 'shonan_swap_parents_nav_order', 20 );

/**
 * 「在園の保護者へ」と「将来の幼児教育」の表示順を入れ替える
 */
function shonan_swap_parents_nav_order() {
	if ( 'swapped' === get_option( 'shonan_nav_parents_order' ) ) {
		return;
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menu_ids  = array_values( array_unique( array_filter( array_map( 'intval', (array) $locations ) ) ) );

	foreach ( $menu_ids as $menu_id ) {
		$items   = wp_get_nav_menu_items( $menu_id );
		$parents = null;
		$future  = null;
		if ( ! $items ) {
			continue;
		}
		foreach ( $items as $item ) {
			if ( '在園の保護者へ' === $item->title ) {
				$parents = $item;
			}
			if ( '将来の幼児教育' === $item->title ) {
				$future = $item;
			}
		}
		if ( ! $parents || ! $future ) {
			continue;
		}
		$parents_order = (int) $parents->menu_order;
		$future_order  = (int) $future->menu_order;
		wp_update_post(
			array(
				'ID'         => $parents->ID,
				'menu_order' => $future_order,
			)
		);
		wp_update_post(
			array(
				'ID'         => $future->ID,
				'menu_order' => $parents_order,
			)
		);
	}

	update_option( 'shonan_nav_parents_order', 'swapped' );
}

/**
 * 既存メニューの旧表記を新表記へ
 *
 * @param string  $title メニュータイトル.
 * @param WP_Post $item  メニュー項目.
 * @return string
 */
function shonan_nav_menu_item_title( $title, $item ) {
	$old = array( '50年の実績', '５０年の実績' );
	if ( in_array( $title, $old, true ) ) {
		return '50年の幼児教育実績';
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'shonan_nav_menu_item_title', 10, 2 );

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
