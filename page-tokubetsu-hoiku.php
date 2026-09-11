<?php
/**
 * 固定ページ: 特別保育（スラッグ: tokubetsu-hoiku）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article">
		<header class="page-header">
			<h1 class="page-title">特別保育</h1>
		</header>

		<figure class="page-featured">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large' ); ?>
			<?php else : ?>
				<img
					src="<?php echo esc_url( shonan_photo( 'houshin/tokubetsu-hoiku/rikazikken.jpg' ) ); ?>"
					alt="特別保育"
					width="1200"
					height="560"
					loading="lazy"
				>
			<?php endif; ?>
		</figure>

		<?php get_template_part( 'template-parts/houshin', 'tokubetsu', array( 'standalone' => true ) ); ?>
	</article>
</div>

<?php
get_footer();
