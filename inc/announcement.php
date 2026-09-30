<?php
/**
 * トップページの告知
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array{enabled:bool,title:string,body:string,image_id:int}
 */
function shonan_announcement_defaults() {
	return array(
		'enabled'  => false,
		'title'    => '',
		'body'     => '',
		'image_id' => 0,
		'pdf_id'   => 0,
		'hide_at'  => '',
	);
}

/**
 * @return array{enabled:bool,title:string,body:string,image_id:int}
 */
function shonan_get_announcement() {
	$saved = get_option( 'shonan_announcement', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$settings = wp_parse_args( $saved, shonan_announcement_defaults() );
	$settings['enabled']  = ! empty( $settings['enabled'] );
	$settings['title']    = (string) $settings['title'];
	$settings['body']     = (string) $settings['body'];
	$settings['image_id'] = absint( $settings['image_id'] );
	$settings['pdf_id']   = absint( $settings['pdf_id'] );
	$settings['hide_at']  = (string) $settings['hide_at'];
	return $settings;
}

/**
 * 内容が変わると別の値になる
 *
 * @return string
 */
function shonan_announcement_revision() {
	$settings = shonan_get_announcement();
	return substr(
		md5( $settings['title'] . '|' . $settings['body'] . '|' . $settings['image_id'] . '|' . $settings['pdf_id'] ),
		0,
		12
	);
}

/**
 * 表示する内容があるか
 *
 * @return bool
 */
function shonan_announcement_is_active() {
	if ( ! is_front_page() ) {
		return false;
	}
	$settings = shonan_get_announcement();
	if ( ! $settings['enabled'] ) {
		return false;
	}
	if ( shonan_announcement_is_expired( $settings ) ) {
		return false;
	}
	return '' !== trim( wp_strip_all_tags( $settings['title'] . $settings['body'] ) ) || $settings['image_id'] > 0 || $settings['pdf_id'] > 0;
}

/**
 * 非表示にする日時を過ぎているか
 *
 * @param array|null $settings 設定.
 * @return bool
 */
function shonan_announcement_is_expired( $settings = null ) {
	if ( null === $settings ) {
		$settings = shonan_get_announcement();
	}
	$hide_at = isset( $settings['hide_at'] ) ? trim( (string) $settings['hide_at'] ) : '';
	if ( '' === $hide_at ) {
		return false;
	}

	$end = date_create_immutable( $hide_at, wp_timezone() );
	if ( ! $end ) {
		return false;
	}

	$now = new DateTimeImmutable( 'now', wp_timezone() );
	return $now >= $end;
}
