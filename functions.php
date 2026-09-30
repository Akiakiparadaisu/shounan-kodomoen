<?php
/**
 * 湘南こども園 テーマ関数
 *
 * @package Shonan_Kodomoen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SHONAN_THEME_VERSION', '1.1.4' );
define( 'SHONAN_THEME_DIR', get_template_directory() );
define( 'SHONAN_THEME_URI', get_template_directory_uri() );

require_once SHONAN_THEME_DIR . '/inc/setup.php';
require_once SHONAN_THEME_DIR . '/inc/enqueue.php';
require_once SHONAN_THEME_DIR . '/inc/helpers.php';
require_once SHONAN_THEME_DIR . '/inc/admission.php';
require_once SHONAN_THEME_DIR . '/inc/starter-content.php';

if ( is_admin() ) {
	require_once SHONAN_THEME_DIR . '/inc/admission-admin.php';
	require_once SHONAN_THEME_DIR . '/inc/documents-admin.php';
}
