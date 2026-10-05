<?php
/**
 * 3D画面のHTML。viewer.js の更新時刻をその場で埋め込む。
 */
$html = file_get_contents( __DIR__ . '/index.html' );
$js   = __DIR__ . '/viewer.js';
$version = is_file( $js ) ? (string) filemtime( $js ) : '1';
$html = str_replace( '__VIEWER__', rawurlencode( $version ), $html );
$etag = '"view-' . $version . '-' . strlen( $html ) . '"';

header( 'Content-Type: text/html; charset=utf-8' );
header( 'Cache-Control: private, max-age=0, must-revalidate' );
header( 'ETag: ' . $etag );

$if_none_match = isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) ? trim( $_SERVER['HTTP_IF_NONE_MATCH'] ) : '';
if ( $if_none_match === $etag ) {
	http_response_code( 304 );
	exit;
}

echo $html;
