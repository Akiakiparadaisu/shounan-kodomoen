<?php
/**
 * 3D画面のHTML。viewer.js の更新時刻をその場で埋め、画面の保存を禁止する。
 */
$html = file_get_contents( __DIR__ . '/index.html' );
$js   = __DIR__ . '/viewer.js';
$version = is_file( $js ) ? (string) filemtime( $js ) : '1';
$html = str_replace( '__VIEWER__', rawurlencode( $version ), $html );

header( 'Content-Type: text/html; charset=utf-8' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );
echo $html;
