<?php
/**
 * メインインデックス
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<header class="page-header">
		<h1 class="page-title">
			<?php
			if ( is_home() && ! is_front_page() ) {
				echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ?: 'これまでの活動' );
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				echo esc_html__( 'これまでの活動', 'shonan-kodomoen' );
			}
			?>
		</h1>
	</header>

	<div class="page-layout">
		<div class="page-content">
			<?php if ( have_posts() ) : ?>
				<div class="post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
