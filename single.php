<?php
/**
 * 投稿単体
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<div class="page-layout">
		<div class="page-content">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'single-article' ); ?>>
					<header class="page-header">
						<p class="post-meta">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</p>
						<h1 class="page-title"><?php the_title(); ?></h1>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="page-featured">
							<?php the_post_thumbnail( 'large' ); ?>
						</figure>
					<?php endif; ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
