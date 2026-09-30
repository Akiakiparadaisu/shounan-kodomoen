<?php
/**
 * フロントページ
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<?php get_template_part( 'template-parts/home', 'hero' ); ?>
<?php get_template_part( 'template-parts/home', 'mission' ); ?>
<?php get_template_part( 'template-parts/home', 'guides' ); ?>
<?php get_template_part( 'template-parts/home', 'news' ); ?>

<?php
get_footer();
