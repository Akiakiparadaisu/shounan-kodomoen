<?php
/**
 * ホームページ：お知らせ
 *
 * @package Shonan_Kodomoen
 */

$news_query = new WP_Query(
	array(
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$fallback_news = array(
	array(
		'date'  => '2026.04.01',
		'title' => '令和8年度 募集要項を公開しました（仮）',
	),
	array(
		'date'  => '2026.03.15',
		'title' => '入園説明会・園見学の予約を受け付けています（仮）',
	),
	array(
		'date'  => '2026.02.20',
		'title' => '湘南ジュニア（プレ保育）のご案内（仮）',
	),
	array(
		'date'  => '2026.01.10',
		'title' => 'ホームページをリニューアルしました（仮）',
	),
);
?>
<section class="section news" id="news">
	<div class="section__inner news__inner">
		<header class="section-header reveal" data-reveal>
			<p class="section-eyebrow">おしらせ</p>
			<h2 class="section-title">きょうのおしらせ</h2>
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
							<a href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">
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
						src="<?php echo esc_url( shonan_placeholder( 'top' ) ); ?>"
						alt="お知らせビジュアル（仮画像）"
						width="640"
						height="480"
						loading="lazy"
					>
				</figure>
				<div class="news-aside__actions">
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">書類ダウンロード</a>
					<a class="btn btn--solid" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">入園説明会</a>
				</div>
			</aside>
		</div>
	</div>
</section>
