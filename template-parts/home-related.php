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
	array(
		'name'  => '（株）テクノシステムズ',
		'image' => 'top/kanrensosiki/テクノシステムズ.png',
		'url'   => 'https://www.techno-tk.co.jp/wp/',
		'logo'  => true,
	),
	array(
		'name'  => '一般財団法人林財団',
		'image' => 'top/kanrensosiki/林財団.jpg',
		'logo'  => true,
	),
	array(
		'name'  => 'NPO法人科学探検隊',
		'image' => 'top/kanrensosiki/科学探検隊ロゴマーク.png',
		'url'   => home_url( '/history/#kagaku' ),
		'logo'  => true,
	),
);
?>
<section class="section related" id="related">
	<div class="section__inner">
		<header class="section-header reveal" data-reveal>
			<h2 class="section-title">関連組織</h2>
		</header>
		<ul class="related__list">
			<?php foreach ( $related as $item ) : ?>
				<?php
				$src      = shonan_photo( $item['image'] );
				$classes  = 'related__card' . ( ! empty( $item['logo'] ) ? ' related__card--logo' : '' );
				$has_url  = ! empty( $item['url'] );
				$external = $has_url && 0 === strpos( $item['url'], 'http' );
				?>
				<li class="related__item reveal" data-reveal>
					<?php if ( $has_url ) : ?>
						<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $item['url'] ); ?>"<?php echo $external ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
					<?php else : ?>
						<div class="<?php echo esc_attr( $classes ); ?>">
					<?php endif; ?>
						<img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy">
						<span class="related__name"><?php echo esc_html( $item['name'] ); ?></span>
					<?php if ( $has_url ) : ?>
						</a>
					<?php else : ?>
						</div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
