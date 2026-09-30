<?php
/**
 * 固定ページ: 一日の流れ（スラッグ: ichinichi-no-nagare）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article">
		<header class="page-header">
			<h1 class="page-title">一日の流れ</h1>
		</header>

		<?php get_template_part( 'template-parts/enseikatsu', 'flow', array( 'standalone' => true ) ); ?>
	</article>
</div>

<?php
get_footer();
