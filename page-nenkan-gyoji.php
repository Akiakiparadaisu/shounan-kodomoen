<?php
/**
 * 固定ページ: 年間行事（スラッグ: nenkan-gyoji）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article">
		<header class="page-header">
			<h1 class="page-title">年間行事</h1>
		</header>

		<?php get_template_part( 'template-parts/enseikatsu', 'events', array( 'standalone' => true ) ); ?>
	</article>
</div>

<?php
get_footer();
