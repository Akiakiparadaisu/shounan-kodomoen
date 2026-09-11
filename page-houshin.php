<?php
/**
 * 固定ページ: 園の方針と特長（スラッグ: houshin）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article houshin-page">
		<header class="page-header">
			<h1 class="page-title">園の方針と特長</h1>
		</header>

		<figure class="policy-visual">
			<img
				src="<?php echo esc_url( shonan_photo( 'houshin/en-no-houshin/en-no-houshin.png' ) ); ?>"
				alt="あしたをつくる やさしい まなび — 遊び・体験・仲間の中で子どもたちの未来が育っていく"
				width="1600"
				height="1000"
				fetchpriority="high"
			>
		</figure>

		<section class="policy-intro">
			<div class="policy-pillars">
				<article class="policy-pillar">
					<p class="policy-pillar__label">モットー</p>
					<h2 class="policy-pillar__value">園児はわが子</h2>
				</article>
				<article class="policy-pillar">
					<p class="policy-pillar__label">スローガン</p>
					<h2 class="policy-pillar__value">入ってよかったといわれる園にする</h2>
				</article>
				<article class="policy-pillar">
					<p class="policy-pillar__label">経営方針</p>
					<h2 class="policy-pillar__value">保護者に必要以上の時間的・金銭的負担をかけない</h2>
				</article>
			</div>
		</section>

		<section class="policy-guidance">
			<header class="section-header">
				<p class="section-eyebrow">指導方針</p>
				<h2 class="section-title">質の高い教育・保育を実現します</h2>
				<p class="section-lead">
					５０年の歴史ある、ふじ幼児園の良き文化を継承して、「質の高い教育・保育を実現」します。
				</p>
			</header>

			<div class="policy-guidance__list">
				<article class="policy-card">
					<h3 class="policy-card__title">正しいしつけ</h3>
					<p class="policy-card__text">普遍的なふるまいを自然に身につけます。</p>
				</article>
				<article class="policy-card">
					<h3 class="policy-card__title">自立</h3>
					<p class="policy-card__text">「主体」「積極性」「機転」など、生きる力をつけます。</p>
				</article>
				<article class="policy-card">
					<h3 class="policy-card__title">体力づくり</h3>
					<p class="policy-card__text">湘南体操を基本に、楽しく体を動かします。</p>
				</article>
			</div>
		</section>

		<?php get_template_part( 'template-parts/houshin', 'tokubetsu' ); ?>
		<?php get_template_part( 'template-parts/houshin', 'pre' ); ?>
	</article>
</div>

<?php
get_footer();
