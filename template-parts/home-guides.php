<?php
/**
 * ホームページ：導線ガイド
 *
 * @package Shonan_Kodomoen
 */

$guides = array(
	array(
		'title' => '保護者の方へ',
		'lead'  => '方針・園生活・入園案内',
		'image' => 'enseikatsu',
		'links' => array(
			array( 'label' => '園の方針と特徴', 'url' => '/houshin/' ),
			array( 'label' => '園生活のようす', 'url' => '/enseikatsu/' ),
			array( 'label' => '入園のご希望', 'url' => '/nyuen/' ),
		),
	),
	array(
		'title' => '就職希望の方へ',
		'lead'  => '50年の実績と職場環境',
		'image' => 'kyujin',
		'links' => array(
			array( 'label' => '50年の幼児教育実績', 'url' => '/history/' ),
			array( 'label' => '園の方針と特徴', 'url' => '/houshin/' ),
			array( 'label' => '園で働きたい方へ', 'url' => '/kyujin/' ),
		),
	),
	array(
		'title' => '園について詳しく',
		'lead'  => '歴史とこれからの幼児教育',
		'image' => 'history',
		'links' => array(
			array( 'label' => '50年の幼児教育実績', 'url' => '/history/' ),
			array( 'label' => '園の施設・アクセス', 'url' => '/shisetsu/' ),
			array( 'label' => '将来の幼児教育', 'url' => '/mirai/' ),
		),
	),
);
?>
<section class="section guides" id="guides">
	<div class="section__inner">
		<header class="section-header reveal" data-reveal>
			<p class="section-eyebrow">ご案内</p>
			<h2 class="section-title">なにを知りたい？</h2>
			<p class="section-lead">保護者さん・就職希望の方・園のことをもっと知りたい方へ。</p>
		</header>

		<div class="guides__list">
			<?php foreach ( $guides as $guide ) : ?>
				<article class="guide-block reveal" data-reveal>
					<figure class="guide-block__media">
						<img
							src="<?php echo esc_url( shonan_placeholder( $guide['image'] ) ); ?>"
							alt="<?php echo esc_attr( $guide['title'] . '（仮画像）' ); ?>"
							width="800"
							height="500"
							loading="lazy"
						>
					</figure>
					<div class="guide-block__body">
						<h3 class="guide-block__title"><?php echo esc_html( $guide['title'] ); ?></h3>
						<p class="guide-block__lead"><?php echo esc_html( $guide['lead'] ); ?></p>
						<ul class="guide-block__links">
							<?php foreach ( $guide['links'] as $link ) : ?>
								<li>
									<a href="<?php echo esc_url( home_url( $link['url'] ) ); ?>">
										<?php echo esc_html( $link['label'] ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
