<?php
/**
 * 固定ページ: プレ保育（湘南ジュニア）（スラッグ: pre-hoiku）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article">
		<header class="page-header">
			<h1 class="page-title">プレ保育（湘南ジュニア）とは？</h1>
		</header>

		<?php get_template_part( 'template-parts/houshin', 'pre', array( 'standalone' => true ) ); ?>
	</article>
</div>

<?php
get_footer();
