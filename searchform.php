<?php
/**
 * 検索フォーム
 *
 * @package Shonan_Kodomoen
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s"><?php echo esc_html_x( '検索', 'label', 'shonan-kodomoen' ); ?></label>
	<input type="search" id="s" class="search-field" placeholder="キーワードを入力" value="<?php echo get_search_query(); ?>" name="s">
	<button type="submit" class="btn btn--solid btn--small">検索</button>
</form>
