<?php
/**
 * 投稿リスト用コンテンツ
 *
 * @package Shonan_Kodomoen
 */
?>
<article <?php post_class( 'post-item' ); ?>>
	<a class="post-item__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="post-item__thumb">
				<?php the_post_thumbnail( 'shonan-thumb' ); ?>
			</figure>
		<?php else : ?>
			<figure class="post-item__thumb post-item__thumb--placeholder">
				<img src="<?php echo esc_url( shonan_placeholder( 'top' ) ); ?>" alt="" width="640" height="480" loading="lazy">
			</figure>
		<?php endif; ?>
		<div class="post-item__body">
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<h2 class="post-item__title"><?php the_title(); ?></h2>
			<p class="post-item__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40, '…' ) ); ?></p>
		</div>
	</a>
</article>
