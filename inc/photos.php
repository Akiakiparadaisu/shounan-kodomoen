<?php
/**
 * ページ内の写真を管理画面から差し替える
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 差し替えできる写真。キーは photos/ からの相対パス。
 *
 * @return array<string, array<int, array{path:string,label:string}>>
 */
function shonan_content_photo_catalog() {
	$flow = 'enseikatsu/ichinichi-no-nagare/';
	$year = 'enseikatsu/nenkan-gyoji/';
	$room = 'shisetsu/ensha/';
	$pre  = 'houshin/pre-hoiku/';
	$care = 'houshin/tokubetsu-hoiku/';

	return array(
		'共通' => array(
			array(
				'path'  => 'en_icon.png',
				'label' => '園のマーク（画面の上と下）',
			),
		),
		'トップ' => array(
			array(
				'path'  => 'top/top.png',
				'label' => 'いちばん上の大きな写真',
			),
			array(
				'path'  => 'top/enjoy-hoiku.jpg',
				'label' => '園児はわが子',
			),
			array(
				'path'  => 'top/35flow-16001900.jpg',
				'label' => 'ご案内：保護者の方へ',
			),
			array(
				'path'  => 'top/1_ev-2.jpg',
				'label' => 'ご案内：就職希望の方へ',
			),
			array(
				'path'  => 'top/history1.jpg',
				'label' => 'ご案内：園に興味のある方へ',
			),
			array(
				'path'  => 'top/kanrensosiki/湘南保育(1)_R.PNG',
				'label' => '関連：(株)湘南保育',
			),
			array(
				'path'  => 'top/kanrensosiki/samukawa.png',
				'label' => '関連：寒川湘南保育園',
			),
			array(
				'path'  => 'top/kanrensosiki/daiho.png',
				'label' => '関連：大和湘南保育園',
			),
			array(
				'path'  => 'top/kanrensosiki/shuho.png',
				'label' => '関連：首里湘南保育園',
			),
			array(
				'path'  => 'top/kanrensosiki/tukiho.png',
				'label' => '関連：つきみ野湘南保育園',
			),
		),
		'園の方針' => array(
			array(
				'path'  => 'houshin/en-no-houshin/en-no-houshin.png',
				'label' => 'ページ上部',
			),
		),
		'特別保育' => array(
			array(
				'path'  => $care . 'rikazikken.jpg',
				'label' => '理科教室',
			),
			array(
				'path'  => $care . 'kokusai.jpg',
				'label' => '国際感覚の向上',
			),
			array(
				'path'  => $care . 'otya.jpg',
				'label' => '茶道',
			),
			array(
				'path'  => $care . 'soroban.jpg',
				'label' => 'そろばん',
			),
			array(
				'path'  => $care . 'musiba0.jpg',
				'label' => 'むし歯０活動',
			),
		),
		'湘南ジュニア' => array(
			array(
				'path'  => $pre . 'jr.jpg',
				'label' => '紹介の写真',
			),
			array(
				'path'  => $pre . 'building-outdoor.jpg',
				'label' => '建物の外',
			),
			array(
				'path'  => $pre . 'building_indoor.jpg',
				'label' => '建物の中',
			),
			array(
				'path'  => $pre . 'jr-1.jpg',
				'label' => '順次登園',
			),
			array(
				'path'  => $pre . 'jr-2.jpg',
				'label' => '朝の会',
			),
			array(
				'path'  => $pre . 'ju-3.jpg',
				'label' => 'たのしい活動',
			),
			array(
				'path'  => $pre . 'ju-4.jpg',
				'label' => 'おやつ',
			),
			array(
				'path'  => $pre . 'ju-5.jpg',
				'label' => '帰りの会',
			),
			array(
				'path'  => $pre . 'ju-6.jpg',
				'label' => '降園',
			),
		),
		'園生活' => array(
			array(
				'path'  => 'enseikatsu/enseikatu.png',
				'label' => 'ページ上部',
			),
			array(
				'path'  => 'enseikatsu/en-bus/en-bus-image.png',
				'label' => '走るバスの絵',
			),
			array(
				'path'  => 'enseikatsu/en-bus/en_bus.jpg',
				'label' => '園バスの写真',
			),
		),
		'一日の流れ' => array(
			array( 'path' => $flow . '02flow-0700.jpg', 'label' => '0・1・2歳 7:00 開園' ),
			array( 'path' => $flow . '02flow-0900.jpg', 'label' => '0・1・2歳 9:00 朝の会' ),
			array( 'path' => $flow . '02flow-0940.jpg', 'label' => '0・1・2歳 9:40 主活動' ),
			array( 'path' => $flow . '02flow-1100.jpg', 'label' => '0・1・2歳 11:00 給食' ),
			array( 'path' => $flow . '02flow-1200.jpg', 'label' => '0・1・2歳 12:00 午睡' ),
			array( 'path' => $flow . '02flow-1500.jpg', 'label' => '0・1・2歳 15:00 おやつ' ),
			array( 'path' => $flow . '02flow-1545.jpg', 'label' => '0・1・2歳 15:45 帰りの会' ),
			array( 'path' => $flow . '02flow-16001900.jpg', 'label' => '0・1・2歳 16:00 降園' ),
			array( 'path' => $flow . '35flow-0700.jpg', 'label' => '3・4・5歳 7:00 開園' ),
			array( 'path' => $flow . '35flow-0945.jpg', 'label' => '3・4・5歳 9:45 朝の会' ),
			array( 'path' => $flow . '35flow-1000.jpg', 'label' => '3・4・5歳 10:00 主活動' ),
			array( 'path' => $flow . '35flow-1200.jpg', 'label' => '3・4・5歳 12:00 給食' ),
			array( 'path' => $flow . '35flow-1300.jpg', 'label' => '3・4・5歳 13:00 自由遊び' ),
			array( 'path' => $flow . '35flow-1400.jpg', 'label' => '3・4・5歳 14:00 降園・預かり' ),
			array( 'path' => $flow . '35flow-1500.jpg', 'label' => '3・4・5歳 15:00 おやつ' ),
			array( 'path' => $flow . '35flow-16001900.jpg', 'label' => '3・4・5歳 16:00 降園' ),
		),
		'年間行事' => array(
			array( 'path' => $year . '1_ev-1.jpg', 'label' => '入園式' ),
			array( 'path' => $year . '1_ev-2.jpg', 'label' => '遠足（年少・年長）' ),
			array( 'path' => $year . '1_ev-3.jpg', 'label' => 'じゃがいも掘り（年長）' ),
			array( 'path' => $year . '1_ev-4.jpg', 'label' => '交通安全指導' ),
			array( 'path' => $year . '1_ev-5.jpg', 'label' => 'ファミリーデー' ),
			array( 'path' => $year . '1_ev-6.jpg', 'label' => 'お泊り保育（年長）' ),
			array( 'path' => $year . '1_ev-7.jpg', 'label' => 'プール遊び' ),
			array( 'path' => $year . '1_ev-8.jpg', 'label' => '湘南こどもまつり' ),
			array( 'path' => $year . '2_ev-9.jpg', 'label' => '稲刈り体験（年長）' ),
			array( 'path' => $year . '2_ev-10.jpg', 'label' => '運動会' ),
			array( 'path' => $year . '2_ev-11.jpg', 'label' => '親子遠足（年中）' ),
			array( 'path' => $year . '2_ev-12.jpg', 'label' => 'さつまいも掘り（年少・年中）' ),
			array( 'path' => $year . '2_ev-13.jpg', 'label' => 'クリスマス会' ),
			array( 'path' => $year . '2_ev-14.jpg', 'label' => 'クリスマス発表会' ),
			array( 'path' => $year . '2_ev-15.jpg', 'label' => 'お餅つき（年長）' ),
			array( 'path' => $year . '3_ev-16.jpg', 'label' => '節分' ),
			array( 'path' => $year . '3_ev-17.jpg', 'label' => 'ありがとうの会' ),
			array( 'path' => $year . '3_ev-18.jpg', 'label' => '卒園式' ),
		),
		'園の施設' => array(
			array( 'path' => 'shisetsu/shisetsu.png', 'label' => 'ページ上部' ),
			array( 'path' => $room . 'entei.jpg', 'label' => '園庭' ),
			array( 'path' => $room . 'toilet.jpg', 'label' => 'こどもトイレ' ),
			array( 'path' => $room . 'houle.jpg', 'label' => 'ホール（講堂）' ),
			array( 'path' => $room . 'parking_car.jpg', 'label' => '駐車場' ),
			array( 'path' => $room . 'solar_panel.jpg', 'label' => 'ソーラーパネル' ),
			array( 'path' => $room . 'elevator.jpg', 'label' => 'エレベーター' ),
			array( 'path' => $room . 'classroom1.jpg', 'label' => '教室（保育）' ),
			array( 'path' => $room . 'classroom2.jpg', 'label' => '教室（年少〜年長）' ),
		),
		'入園のご希望' => array(
			array( 'path' => 'nyuen/seifuku/seifuku01.jpg', 'label' => '制服 1' ),
			array( 'path' => 'nyuen/seifuku/seifuku02.jpg', 'label' => '制服 2' ),
			array( 'path' => 'nyuen/seifuku/taisouhuku01.png', 'label' => '体操服 1' ),
			array( 'path' => 'nyuen/seifuku/taisouhuku02.png', 'label' => '体操服 2' ),
		),
		'半世紀の幼児教育実績' => array(
			array( 'path' => 'history/history_top.png', 'label' => 'ページ上部' ),
			array( 'path' => 'history/why-started/history1.jpg', 'label' => '創設時のふじ幼児園' ),
			array( 'path' => 'history/why-started/history2.jpg', 'label' => '現在のこども園' ),
			array( 'path' => 'history/enji-kakuho/history3.jpg', 'label' => '園児確保の取り組み' ),
			array( 'path' => 'history/history4_otya.jpg', 'label' => '日本の伝統文化を体験' ),
			array( 'path' => 'history/myanma.jpg', 'label' => 'ミャンマーでの理科教室' ),
			array( 'path' => 'history/saharin.jpg', 'label' => 'ロシア（サハリン）での説明' ),
		),
	);
}

/**
 * 保存されている差し替え
 *
 * @return array<string,int>
 */
function shonan_content_photo_overrides() {
	$saved = get_option( 'shonan_content_photos', array() );
	return is_array( $saved ) ? $saved : array();
}

/**
 * 差し替え画像のURL。未設定なら空。
 *
 * @param string $relative photos/ からの相対パス.
 * @return string
 */
function shonan_content_photo_url( $relative ) {
	$relative = shonan_photo_key( $relative );
	$saved    = shonan_content_photo_overrides();
	$id       = isset( $saved[ $relative ] ) ? absint( $saved[ $relative ] ) : 0;
	if ( ! $id ) {
		return '';
	}
	$url = wp_get_attachment_image_url( $id, 'full' );
	return $url ? $url : '';
}
