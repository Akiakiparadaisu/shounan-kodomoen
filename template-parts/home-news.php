<?php
/**
 * ホームページ：これまでの活動
 *
 * @package Shonan_Kodomoen
 */

$activities_url = shonan_activities_archive_url();

$news_query = new WP_Query(
	array(
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$fallback_news = array(
	array(
		'date'  => '2026.03.20',
		'title' => '春の遠足で公園あそびを楽しみました',
	),
	array(
		'date'  => '2026.02.14',
		'title' => '節分豆まきと、鬼さんとのふれあい',
	),
	array(
		'date'  => '2026.01.24',
		'title' => 'むし歯０活動デーのようす',
	),
	array(
		'date'  => '2025.12.18',
		'title' => 'クリスマス会で歌とダンスを発表しました',
	),
);

$aside_image = shonan_placeholder( 'top' );
$aside_alt   = 'おしらせ';

if ( $news_query->have_posts() ) {
	$first = $news_query->posts[0];
	if ( has_post_thumbnail( $first ) ) {
		$aside_image = get_the_post_thumbnail_url( $first, 'shonan-card' ) ?: $aside_image;
		$aside_alt   = get_the_title( $first );
	}
}
?>
<section class="section news" id="activities">
	<div class="section__inner news__inner">
		<header class="section-header reveal" data-reveal>
			<h2 class="section-title">おしらせ</h2>
			<p class="section-lead">園での行事やイベント、園庭開放について告知します。</p>
		</header>

		<div class="news__layout">
			<ul class="news-list reveal" data-reveal>
				<?php if ( $news_query->have_posts() ) : ?>
					<?php
					while ( $news_query->have_posts() ) :
						$news_query->the_post();
						?>
						<li class="news-list__item">
							<a href="<?php the_permalink(); ?>">
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
								<span><?php the_title(); ?></span>
							</a>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				<?php else : ?>
					<?php foreach ( $fallback_news as $item ) : ?>
						<li class="news-list__item">
							<a href="<?php echo esc_url( $activities_url ); ?>">
								<time><?php echo esc_html( $item['date'] ); ?></time>
								<span><?php echo esc_html( $item['title'] ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>

			<aside class="news-aside reveal" data-reveal>
				<figure class="news-aside__media">
					<img
						src="<?php echo esc_url( $aside_image ); ?>"
						alt="<?php echo esc_attr( $aside_alt ); ?>"
						width="640"
						height="480"
						loading="lazy"
					>
				</figure>
				<div class="news-aside__actions">
					<a class="btn btn--solid" href="<?php echo esc_url( $activities_url ); ?>">おしらせ一覧を見る</a>
				</div>
			</aside>
		</div>
	</div>
</section>
