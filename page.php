<?php
/**
 * 固定ページ
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'page-article' ); ?>>
			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="page-featured">
					<?php the_post_thumbnail( 'large' ); ?>
				</figure>
			<?php else : ?>
				<figure class="page-featured page-featured--placeholder">
					<img src="<?php echo esc_url( shonan_placeholder( is_page() ? get_post_field( 'post_name', get_the_ID() ) : 'top' ) ); ?>" alt="写真準備中（仮画像）" width="1200" height="560" loading="lazy">
					<figcaption>※写真は後ほど差し替え予定です</figcaption>
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

<?php
get_footer();
