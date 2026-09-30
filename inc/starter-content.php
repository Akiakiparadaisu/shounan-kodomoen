<?php
/**
 * テーマ有効化時の初期ページ作成（任意）
 * 管理画面で「外観 → テーマ」から有効化後、
 * 設定 → 表示設定で「固定ページ」をフロントに指定してください。
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * テーマ切替時にサンプル固定ページを用意
 */
function shonan_theme_create_starter_pages() {
	$pages = array(
		'houshin'    => array(
			'title'   => '園の方針と特長',
			'content' => '',
		),
		'enseikatsu' => array(
			'title'   => '園生活のようす',
			'content' => '',
		),
		'shisetsu'   => array(
			'title'   => '園の施設',
			'content' => '',
		),
		'nyuen'      => array(
			'title'   => '入園のご希望の方へ',
			'content' => '',
		),
		'kyujin'     => array(
			'title'   => '求職中の方へ',
			'content' => '',
		),
		'history'    => array(
			'title'   => '50年の幼児教育実績',
			'content' => '',
		),
		'mirai'      => array(
			'title'   => '将来の幼児教育',
			'content' => '',
		),
	);

	$created = array();

	foreach ( $pages as $slug => $page ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$created[ $slug ] = $existing->ID;
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $page['content'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
			),
			true
		);

		if ( ! is_wp_error( $id ) ) {
			$created[ $slug ] = $id;
		}
	}

	// フロントページ用の固定ページ
	$front = get_page_by_path( 'home-shonan' );
	if ( ! $front ) {
		$front_id = wp_insert_post(
			array(
				'post_title'   => 'トップページ',
				'post_name'    => 'home-shonan',
				'post_content' => '',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
			),
			true
		);
	} else {
		$front_id = $front->ID;
	}

	if ( ! is_wp_error( $front_id ) && $front_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $front_id );
	}

	// 投稿一覧（これまでの活動）
	$posts_page = get_page_by_path( 'katsudo' );
	if ( ! $posts_page ) {
		$posts_page_id = wp_insert_post(
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
	} else {
		$posts_page_id = $posts_page->ID;
	}

	if ( ! is_wp_error( $posts_page_id ) && $posts_page_id ) {
		update_option( 'page_for_posts', (int) $posts_page_id );
	}

	// メニュー自動作成
	$menu_name = '湘南こども園 メインメニュー';
	$menu      = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		$order   = 1;

		$items = array(
			array( 'title' => 'トップ', 'url' => home_url( '/' ) ),
			array( 'title' => '園の方針と特長', 'slug' => 'houshin' ),
			array( 'title' => '園生活のようす', 'slug' => 'enseikatsu' ),
			array( 'title' => '園の施設', 'slug' => 'shisetsu' ),
			array( 'title' => '入園のご希望', 'slug' => 'nyuen' ),
			array( 'title' => '求職中の方へ', 'slug' => 'kyujin' ),
			array( 'title' => '50年の幼児教育実績', 'slug' => 'history' ),
			array( 'title' => '将来の幼児教育', 'slug' => 'mirai' ),
			array( 'title' => '在園の保護者へ', 'url' => home_url( '/shorui/' ) ),
		);

		foreach ( $items as $item ) {
			$args = array(
				'menu-item-title'  => $item['title'],
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
				'menu-item-url'    => isset( $item['url'] ) ? $item['url'] : home_url( '/' . $item['slug'] . '/' ),
				'menu-item-position' => $order++,
			);

			if ( isset( $item['slug'] ) && isset( $created[ $item['slug'] ] ) ) {
				$args['menu-item-type']      = 'post_type';
				$args['menu-item-object']    = 'page';
				$args['menu-item-object-id'] = $created[ $item['slug'] ];
				unset( $args['menu-item-url'] );
			}

			wp_update_nav_menu_item( $menu_id, 0, $args );
		}

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = (int) $menu_id;
		$locations['footer']  = (int) $menu_id;
		$locations['mobile']  = (int) $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'blogname', '湘南こども園' );
}
add_action( 'after_switch_theme', 'shonan_theme_create_starter_pages' );
