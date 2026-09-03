<?php
/**
 * 404
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>
	<section class="empty-state">
		<h1 class="page-title">ページが見つかりません</h1>
		<p>お探しのページは移動または削除された可能性があります。</p>
		<a class="btn btn--solid" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップへ戻る</a>
	</section>
</div>

<?php
get_footer();
