<?php
/**
 * 現在の shonan_junior.glb を、保存し直すたびに再取得させる。
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
$etag  = '"' . $mtime . '-' . $size . '"';

header( 'Content-Type: model/gltf-binary' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );
header( 'ETag: ' . $etag );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $mtime ) . ' GMT' );
header( 'Content-Length: ' . $size );

$if_none_match = isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) ? trim( $_SERVER['HTTP_IF_NONE_MATCH'] ) : '';
if ( $if_none_match === $etag ) {
	http_response_code( 304 );
	exit;
}

readfile( $file );
