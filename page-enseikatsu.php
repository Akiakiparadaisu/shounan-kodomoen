<?php
/**
 * 固定ページ: 園生活のようす（スラッグ: enseikatsu）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article enseikatsu-page">
		<header class="page-header">
			<h1 class="page-title">園生活のようす</h1>
		</header>

		<figure class="policy-visual enseikatsu-visual">
			<img
				src="<?php echo esc_url( shonan_photo( 'enseikatsu/enseikatu.png' ) ); ?>"
				alt="あそび、まなび、すこやかな まいにち。子どもたちの「今」と「これから」を大切に、豊かな育ちを支えます。"
				width="1600"
				height="1000"
				fetchpriority="high"
			>
		</figure>

		<?php get_template_part( 'template-parts/enseikatsu', 'flow' ); ?>
		<?php get_template_part( 'template-parts/enseikatsu', 'events' ); ?>
		<?php get_template_part( 'template-parts/enseikatsu', 'safety' ); ?>
		<?php get_template_part( 'template-parts/enseikatsu', 'food' ); ?>
		<?php get_template_part( 'template-parts/enseikatsu', 'bus' ); ?>
	</article>
</div>

<?php
get_footer();
