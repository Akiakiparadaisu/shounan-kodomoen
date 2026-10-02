<?php
/**
 * ホームページ：関連組織
 *
 * @package Shonan_Kodomoen
 */

$related = array(
	array(
		'name'  => '(株)湘南保育',
		'image' => 'top/kanrensosiki/湘南保育(1)_R.PNG',
		'url'   => 'https://www.techno-sys.co.jp/wp/',
		'logo'  => true,
	),
	array(
		'name'  => '寒川湘南保育園',
		'image' => 'top/kanrensosiki/samukawa.png',
		'url'   => 'https://www.samukawa-shounanhoikuen.jp/wp1/wp/',
	),
	array(
		'name'  => '大和湘南保育園',
		'image' => 'top/kanrensosiki/daiho.png',
		'url'   => 'https://www.yamato-shounanhoikuen.jp/wp1/wp/',
	),
	array(
		'name'  => '首里湘南保育園',
		'image' => 'top/kanrensosiki/shuho.png',
		'url'   => 'https://www.shuri-shounanhoikuen.jp/wp1/wp/',
	),
	array(
		'name'  => 'つきみ野湘南保育園',
		'image' => 'top/kanrensosiki/tukiho.png',
		'url'   => 'https://tsukimino-shounanhoikuen.jp/wp1/wp/',
	),
);
?>
<section class="section related" id="related">
	<div class="section__inner">
		<header class="section-header reveal" data-reveal>
			<p class="section-eyebrow">関連組織</p>
			<h2 class="section-title">関連会社・保育園</h2>
		</header>
		<ul class="related__list">
			<?php foreach ( $related as $item ) : ?>
				<?php
				$parts = array_map( 'rawurlencode', explode( '/', $item['image'] ) );
				$src   = SHONAN_THEME_URI . '/assets/images/photos/' . implode( '/', $parts );
				?>
				<li class="related__item reveal" data-reveal>
					<a class="related__card<?php echo ! empty( $item['logo'] ) ? ' related__card--logo' : ''; ?>" href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy">
						<span class="related__name"><?php echo esc_html( $item['name'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
