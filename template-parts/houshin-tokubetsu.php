<?php
/**
 * 特別保育コンテンツ
 *
 * @package Shonan_Kodomoen
 *
 * @param array $args {
 *     @type bool $standalone 専用ページ表示時は見出しを簡略化.
 * }
 */

$standalone = ! empty( $args['standalone'] );
$base       = 'houshin/tokubetsu-hoiku/';

$programs = array(
	array(
		'id'    => 'rika',
		'title' => '理科教室',
		'text'  => '磁石や豆電球などを使った簡単な実験を行い、幼児期から理科の面白さを感じられるようなカリキュラムを組んでいます。子どもたちは、毎回、目を輝かせて実験しています。「小学校へいったら、もっと理科の勉強をしたい。」という声が聞かれています。卒園後も、さらに学びを深めていくきっかけとなっています。',
		'image' => $base . 'rikazikken.jpg',
	),
	array(
		'id'    => 'kokusai',
		'title' => '国際感覚の向上',
		'text'  => '世界各国の文化や生活を学び、国際感覚を養う教育を行っています。７カ国を対象にし、今年は、日本との比較も行っています。写真や地図、クイズなどを通じて、楽しく学ぶ機会を提供し、子どもたちが外国の言語や風習、文化を理解し、世界の多様性に興味を持つように促しています。帰宅後に、子どもが保護者に学んだことを説明してくれたという複数の保護者からの嬉しい感想がありました。',
		'image' => $base . 'kokusai.jpg',
	),
	array(
		'id'    => 'bunka',
		'title' => '日本の伝統文化を学ぶ',
		'text'  => '素晴らしい日本の伝統文化に幼児期から触れ、日本を理解する保育を行います。',
		'image' => $base . 'otya.jpg',
		'items' => array(
			array(
				'title' => '茶道',
				'text'  => 'お茶の味わいや礼儀作法を学び、集中力や礼儀を育む機会を提供します。子どもたちは、お茶の香りや味わいを体験し、緊張感を楽しみながら、手を動かすことで集中力や礼節を養います。お菓子をつまむ箸も慎重になり、日常とは異なったしぐさができるようになっていきます。',
				'image' => $base . 'otya.jpg',
			),
			array(
				'title' => 'そろばん',
				'text'  => '初めて触れるそろばんに興味を持ちながら、数の概念や計算能力を身につける機会を提供します。月に１回の教室で、合成や分解を学び、年度末には十までの計算ができるようになります。数字への興味が沸いてくる子が増えています。',
				'image' => $base . 'soroban.jpg',
			),
		),
	),
	array(
		'id'    => 'mushiba',
		'title' => 'むし歯０活動',
		'text'  => '人生100年時代を健康に生きるために重要な歯。乳幼児期から『自分の歯は自分で守る』の土台作りをすることが大切です。むし歯０カリキュラムでは、予防の知識・歯ブラシの使い方・習慣化、３つのポイントを楽しみながら体験的に学んでいます。「歯磨きを嫌がらなくなった」「お菓子の食べ方に気を付けるようになった」と保護者の方々からご好評をいただいています。お子さんの歯や口の心配事のご相談も受け付けています。',
		'image' => $base . 'musiba0.jpg',
	),
);
?>
<section class="special-care" id="tokubetsu-hoiku" aria-labelledby="tokubetsu-hoiku-title">
	<header class="section-header special-care__header">
		<?php if ( ! $standalone ) : ?>
			<p class="section-eyebrow">特別保育</p>
			<h2 class="section-title" id="tokubetsu-hoiku-title">幼児期に必要な感覚・習慣の基盤を育む</h2>
		<?php else : ?>
			<h2 class="section-title screen-reader-text" id="tokubetsu-hoiku-title">特別保育の内容</h2>
		<?php endif; ?>
		<p class="section-lead">
			幼児期に必要と思われる感覚・習慣の基盤を育むために、特別教育として「理科教室」「国際感覚の向上」「日本の伝統文化を学ぶ」「むし歯０活動」を行っています。
		</p>
	</header>

	<div class="special-care__list">
		<?php foreach ( $programs as $index => $program ) : ?>
			<article class="special-block<?php echo 1 === ( $index % 2 ) ? ' special-block--alt' : ''; ?>" id="<?php echo esc_attr( $program['id'] ); ?>">
				<?php if ( empty( $program['items'] ) ) : ?>
					<figure class="special-block__media">
						<img
							src="<?php echo esc_url( shonan_photo( $program['image'] ) ); ?>"
							alt="<?php echo esc_attr( $program['title'] ); ?>"
							width="800"
							height="560"
							loading="lazy"
						>
					</figure>
				<?php endif; ?>
				<div class="special-block__body<?php echo ! empty( $program['items'] ) ? ' special-block__body--full' : ''; ?>">
					<h3 class="special-block__title"><?php echo esc_html( $program['title'] ); ?></h3>
					<p class="special-block__text"><?php echo esc_html( $program['text'] ); ?></p>
					<?php if ( ! empty( $program['items'] ) ) : ?>
						<div class="special-block__items">
							<?php foreach ( $program['items'] as $item ) : ?>
								<div class="special-item<?php echo ! empty( $item['image'] ) ? ' special-item--with-media' : ''; ?>">
									<?php if ( ! empty( $item['image'] ) ) : ?>
										<figure class="special-item__media">
											<img
												src="<?php echo esc_url( shonan_photo( $item['image'] ) ); ?>"
												alt="<?php echo esc_attr( $item['title'] ); ?>"
												width="640"
												height="480"
												loading="lazy"
											>
										</figure>
									<?php endif; ?>
									<div class="special-item__copy">
										<h4 class="special-item__title"><?php echo esc_html( $item['title'] ); ?></h4>
										<p class="special-item__text"><?php echo esc_html( $item['text'] ); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
