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
			$relative = implode( '/', $parts ) . '/' . $leaf . '.' . $ext;
			if ( function_exists( 'shonan_content_photo_url' ) ) {
				$override = shonan_content_photo_url( $relative );
				if ( $override ) {
					return $override;
				}
			}
			return shonan_photo_file_url( $relative );
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
function shonan_photo_key( $relative ) {
	$relative = ltrim( str_replace( '\\', '/', (string) $relative ), '/' );
	$relative = preg_replace( '#^photos/#', '', $relative );
	return $relative;
}

/**
 * テーマに同梱している写真のURL
 *
 * @param string $relative photos/ からの相対パス.
 * @return string
 */
function shonan_photo_file_url( $relative ) {
	$relative = shonan_photo_key( $relative );
	$parts    = array_map( 'rawurlencode', explode( '/', $relative ) );
	return SHONAN_THEME_URI . '/assets/images/photos/' . implode( '/', $parts );
}

/**
 * photos/ 配下の実ファイルURLを返す。管理画面で差し替えていればその画像。
 *
 * @param string $relative photos/ からの相対パス（例: houshin/tokubetsu-hoiku/kokusai.jpg）.
 * @return string
 */
function shonan_photo( $relative ) {
	$relative = shonan_photo_key( $relative );

	if ( function_exists( 'shonan_content_photo_url' ) ) {
		$override = shonan_content_photo_url( $relative );
		if ( $override ) {
			return $override;
		}
	}

	$full = SHONAN_THEME_DIR . '/assets/images/photos/' . $relative;
	if ( file_exists( $full ) ) {
		return shonan_photo_file_url( $relative );
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
			'label' => '半世紀の幼児教育実績',
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
 * メニュー項目が属する色分けグループ
 *
 * @param string $title メニュー名.
 * @return array{0:string,1:int}|null
 */
function shonan_nav_group_for_title( $title ) {
	$title = trim( wp_strip_all_tags( html_entity_decode( (string) $title, ENT_QUOTES, 'UTF-8' ) ) );
	$map   = array(
		'入園のご希望'         => array( 'people', 0 ),
		'入園のご希望の方へ'   => array( 'people', 0 ),
		'求職中の方へ'         => array( 'people', 1 ),
		'在園の保護者へ'       => array( 'people', 2 ),
		'在園の保護者の方へ'   => array( 'people', 2 ),
		'園の方針と特長'       => array( 'garden', 0 ),
		'園の方針と特徴'       => array( 'garden', 0 ),
		'園生活のようす'       => array( 'garden', 1 ),
		'園の施設'             => array( 'garden', 2 ),
		'園の施設・アクセス'   => array( 'garden', 2 ),
		'半世紀の幼児教育実績' => array( 'future', 0 ),
		'50年の幼児教育実績'   => array( 'future', 0 ),
		'５０年の幼児教育実績' => array( 'future', 0 ),
		'50年の実績'           => array( 'future', 0 ),
		'５０年の実績'         => array( 'future', 0 ),
		'将来の幼児教育'       => array( 'future', 1 ),
	);

	return isset( $map[ $title ] ) ? $map[ $title ] : null;
}

/**
 * メインメニューの項目
 *
 * @return array<int, array{label:string,url:string,current:bool}>
 */
function shonan_primary_menu_items() {
	$locations = get_nav_menu_locations();
	$menu_id   = isset( $locations['primary'] ) ? (int) $locations['primary'] : 0;
	$items     = $menu_id ? wp_get_nav_menu_items( $menu_id ) : array();

	if ( $items && function_exists( '_wp_menu_item_classes_by_context' ) ) {
		_wp_menu_item_classes_by_context( $items );
	}

	$out = array();
	if ( $items ) {
		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent !== 0 ) {
				continue;
			}
			$classes = array_filter( (array) $item->classes );
			$out[]   = array(
				'label'   => shonan_nav_menu_item_title( (string) $item->title, $item ),
				'url'     => (string) $item->url,
				'current' => in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ),
			);
		}
	}

	if ( $out ) {
		return $out;
	}

	foreach ( shonan_default_nav_items() as $item ) {
		$target = untrailingslashit( (string) wp_parse_url( $item['url'], PHP_URL_PATH ) );
		$here   = untrailingslashit( (string) wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH ) );
		$out[]  = array(
			'label'   => $item['label'],
			'url'     => $item['url'],
			'current' => ( '' === $target || '/' === $target ) ? is_front_page() : $target === $here,
		);
	}

	return $out;
}

/**
 * メニュー項目を1件出力する
 *
 * @param array{label:string,url:string,current:bool} $item 項目.
 */
function shonan_render_nav_item( $item ) {
	printf(
		'<li class="menu-item%s"><a href="%s"%s>%s</a></li>',
		$item['current'] ? ' current-menu-item' : '',
		esc_url( $item['url'] ),
		$item['current'] ? ' aria-current="page"' : '',
		esc_html( wp_strip_all_tags( $item['label'] ) )
	);
}

/**
 * メインメニューを3つの色グループに分けて出力する
 */
function shonan_render_grouped_nav() {
	$groups = array(
		'people' => array(),
		'garden' => array(),
		'future' => array(),
	);
	$loose  = array();

	foreach ( shonan_primary_menu_items() as $item ) {
		$group = shonan_nav_group_for_title( $item['label'] );
		if ( ! $group ) {
			$loose[] = $item;
			continue;
		}
		$groups[ $group[0] ][ $group[1] ] = $item;
	}

	if ( $loose ) {
		echo '<ul class="nav-list">';
		foreach ( $loose as $item ) {
			shonan_render_nav_item( $item );
		}
		echo '</ul>';
	}

	$labels = array(
		'people' => '入園のご希望、求職中の方へ、在園の保護者へ',
		'garden' => '園の方針と特徴、園生活のようす、園の施設',
		'future' => '半世紀の幼児教育実績、将来の幼児教育',
	);

	foreach ( $groups as $key => $items ) {
		if ( ! $items ) {
			continue;
		}
		ksort( $items );
		printf(
			'<ul class="nav-group nav-group--%1$s" aria-label="%2$s">',
			esc_attr( $key ),
			esc_attr( $labels[ $key ] )
		);
		foreach ( $items as $item ) {
			shonan_render_nav_item( $item );
		}
		echo '</ul>';
	}
}

/**
 * 各ページの中身へ直接飛べる構成図
 *
 * @return array<int, array{key:string,label:string,pages:array<int, array{label:string,url:string,sections:array<int, array{label:string,url:string}>}>}>
 */
function shonan_site_map_groups() {
	return array(
		array(
			'key'   => 'people',
			'label' => '入園・採用・保護者',
			'pages' => array(
				array(
					'label'    => '入園のご希望',
					'url'      => home_url( '/nyuen/' ),
					'sections' => array(
						array( 'label' => '対象児・定員', 'url' => home_url( '/nyuen/#taishoji-teiin' ) ),
						array( 'label' => '園見学', 'url' => home_url( '/nyuen/#kengaku' ) ),
						array( 'label' => '入園説明会', 'url' => home_url( '/nyuen/#nyuen-setsumeikai' ) ),
						array( 'label' => '入園願書', 'url' => home_url( '/nyuen/#gansho' ) ),
						array( 'label' => '保育時間', 'url' => home_url( '/nyuen/#hoiku-jikan' ) ),
						array( 'label' => '制服と体操服', 'url' => home_url( '/nyuen/#seifuku' ) ),
						array( 'label' => '湘南ジュニア', 'url' => home_url( '/nyuen/#shonan-junior' ) ),
					),
				),
				array(
					'label'    => '求職中の方へ',
					'url'      => home_url( '/kyujin/' ),
					'sections' => array(
						array( 'label' => '園長メッセージ', 'url' => home_url( '/kyujin/#message' ) ),
						array( 'label' => '職場環境', 'url' => home_url( '/kyujin/#shokuba' ) ),
						array( 'label' => 'アクセス', 'url' => home_url( '/kyujin/#access' ) ),
					),
				),
				array(
					'label'    => '在園の保護者へ',
					'url'      => home_url( '/shorui/' ),
					'sections' => array(
						array( 'label' => '保護者向け資料', 'url' => home_url( '/shorui/#hogosha-shiryo' ) ),
					),
				),
			),
		),
		array(
			'key'   => 'garden',
			'label' => '園のこと',
			'pages' => array(
				array(
					'label'    => '園の方針と特長',
					'url'      => home_url( '/houshin/' ),
					'sections' => array(
						array( 'label' => '方針', 'url' => home_url( '/houshin/#en-no-houshin' ) ),
						array( 'label' => '特別保育', 'url' => home_url( '/houshin/#tokubetsu-hoiku' ) ),
						array( 'label' => '理科教室', 'url' => home_url( '/houshin/#rika' ) ),
						array( 'label' => '国際感覚', 'url' => home_url( '/houshin/#kokusai' ) ),
						array( 'label' => '伝統文化', 'url' => home_url( '/houshin/#bunka' ) ),
						array( 'label' => 'むし歯０活動', 'url' => home_url( '/houshin/#mushiba' ) ),
						array( 'label' => '湘南ジュニア', 'url' => home_url( '/houshin/#pre-hoiku' ) ),
						array( 'label' => '誰でも通園', 'url' => home_url( '/houshin/#daredemo-tsuen' ) ),
					),
				),
				array(
					'label'    => '園生活のようす',
					'url'      => home_url( '/enseikatsu/' ),
					'sections' => array(
						array( 'label' => '一日の流れ', 'url' => home_url( '/enseikatsu/#ichinichi-no-nagare' ) ),
						array( 'label' => '年間行事', 'url' => home_url( '/enseikatsu/#nenkan-gyoji' ) ),
						array( 'label' => '安全・衛生管理', 'url' => home_url( '/enseikatsu/#anzen-eisei' ) ),
						array( 'label' => '食育', 'url' => home_url( '/enseikatsu/#shokuiku' ) ),
						array( 'label' => '園バス', 'url' => home_url( '/enseikatsu/#en-bus' ) ),
					),
				),
				array(
					'label'    => '園の施設',
					'url'      => home_url( '/shisetsu/' ),
					'sections' => array(
						array( 'label' => '園庭', 'url' => home_url( '/shisetsu/#entei' ) ),
						array( 'label' => 'こどもトイレ', 'url' => home_url( '/shisetsu/#kodomo-toilet' ) ),
						array( 'label' => 'ホール', 'url' => home_url( '/shisetsu/#hall' ) ),
						array( 'label' => '駐車場', 'url' => home_url( '/shisetsu/#parking' ) ),
						array( 'label' => 'ソーラーパネル', 'url' => home_url( '/shisetsu/#solar' ) ),
						array( 'label' => 'エレベーター', 'url' => home_url( '/shisetsu/#elevator' ) ),
						array( 'label' => '教室（保育）', 'url' => home_url( '/shisetsu/#kyoshitsu' ) ),
						array( 'label' => '教室（年少〜年長）', 'url' => home_url( '/shisetsu/#kyoshitsu-nencho' ) ),
						array( 'label' => '湘南ジュニア＆<br>誰でも通園の建物', 'url' => home_url( '/shisetsu/#jr-building' ) ),
						array( 'label' => 'アクセス', 'url' => home_url( '/shisetsu/#access' ) ),
					),
				),
			),
		),
		array(
			'key'   => 'future',
			'label' => '歩みとこれから',
			'pages' => array(
				array(
					'label'    => '半世紀の幼児教育実績',
					'url'      => home_url( '/history/' ),
					'sections' => array(
						array( 'label' => 'なぜ始めたのか', 'url' => home_url( '/history/#why-started' ) ),
						array( 'label' => '各種方針', 'url' => home_url( '/history/#fuji-houshin' ) ),
						array( 'label' => '園児確保', 'url' => home_url( '/history/#enji-kakuho' ) ),
						array( 'label' => '支えた活動', 'url' => home_url( '/history/#katsudo' ) ),
						array( 'label' => '園の実績', 'url' => home_url( '/history/#jisseki' ) ),
						array( 'label' => '運営者', 'url' => home_url( '/history/#unei' ) ),
						array( 'label' => '科学探検隊', 'url' => home_url( '/history/#kagaku' ) ),
						array( 'label' => 'メディア', 'url' => home_url( '/history/#media' ) ),
					),
				),
				array(
					'label'    => '将来の幼児教育',
					'url'      => home_url( '/mirai/' ),
					'sections' => array(
						array( 'label' => '研究の構想', 'url' => home_url( '/mirai/#kenkyu' ) ),
						array( 'label' => '脳の発達に合わせた保育', 'url' => home_url( '/mirai/#nou' ) ),
						array( 'label' => 'メタバース', 'url' => home_url( '/mirai/#metaverse' ) ),
						array( 'label' => 'レジリエンス', 'url' => home_url( '/mirai/#resilience' ) ),
					),
				),
			),
		),
	);
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
	$old = array( '50年の実績', '５０年の実績', '50年の幼児教育実績', '５０年の幼児教育実績' );
	if ( in_array( $title, $old, true ) ) {
		return '半世紀の幼児教育実績';
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'shonan_nav_menu_item_title', 10, 2 );

/**
 * メニューと固定ページの見出しを「半世紀の幼児教育実績」にそろえる
 */
function shonan_rename_history_label() {
	if ( 'hanseiki' === get_option( 'shonan_history_label' ) ) {
		return;
	}

	$old = array( '50年の実績', '５０年の実績', '50年の幼児教育実績', '５０年の幼児教育実績' );
	$new = '半世紀の幼児教育実績';

	$page = get_page_by_path( 'history' );
	if ( $page && in_array( $page->post_title, $old, true ) ) {
		wp_update_post(
			array(
				'ID'         => $page->ID,
				'post_title' => $new,
			)
		);
	}

	$menus = wp_get_nav_menus();
	if ( $menus ) {
		foreach ( $menus as $menu ) {
			$items = wp_get_nav_menu_items( $menu->term_id );
			if ( ! $items ) {
				continue;
			}
			foreach ( $items as $item ) {
				if ( ! in_array( $item->title, $old, true ) ) {
					continue;
				}
				wp_update_post(
					array(
						'ID'         => $item->ID,
						'post_title' => $new,
					)
				);
			}
		}
	}

	update_option( 'shonan_history_label', 'hanseiki' );
}
add_action( 'init', 'shonan_rename_history_label' );

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
