<?php
/**
 * 現在の shonan_junior.glb を返す。
 * 中身が同じなら 304 / ブラウザキャッシュで再取得を避け、差し替えたら必ず新しいファイルを出す。
 */
$file = __DIR__ . '/shonan_junior.glb';

if ( ! is_file( $file ) || filesize( $file ) < 1 ) {
	http_response_code( 404 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'Cache-Control: no-store' );
	echo 'shonan_junior.glb がありません';
	exit;
}

$size  = filesize( $file );
$mtime = filemtime( $file );
$etag  = '"' . dechex( (int) $mtime ) . '-' . dechex( (int) $size ) . '"';

header( 'Content-Type: model/gltf-binary' );
header( 'Cache-Control: private, max-age=0, must-revalidate' );
header( 'ETag: ' . $etag );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $mtime ) . ' GMT' );
header( 'Vary: Accept-Encoding' );

$if_none_match = isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) ? trim( $_SERVER['HTTP_IF_NONE_MATCH'] ) : '';
if ( $if_none_match === $etag ) {
	http_response_code( 304 );
	exit;
}

if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) ) {
	$since = strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] );
	if ( $since && $since >= $mtime ) {
		http_response_code( 304 );
		exit;
	}
}

header( 'Content-Length: ' . $size );
readfile( $file );
