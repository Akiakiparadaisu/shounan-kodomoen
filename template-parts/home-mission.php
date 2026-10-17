<?php
/**
 * ホームページ：保育目標・理念
 *
 * @package Shonan_Kodomoen
 */
?>
<section class="section mission" id="mission">
	<div class="section__inner">
		<div class="mission-board">
			<article class="policy-pillar reveal" data-reveal>
				<p class="policy-pillar__label">モットー</p>
				<h2 class="policy-pillar__value">園児はわが子</h2>
				<p class="mission__text">
					多くの職員の目で、園児一人ひとりの個性や発達を丁寧に把握し、チームで教育と保育にあたります。
				</p>
			</article>
			<article class="policy-pillar reveal" data-reveal>
				<p class="policy-pillar__label">スローガン</p>
				<p class="policy-pillar__value">入ってよかったといわれる園にする</p>
			</article>
			<article class="policy-pillar reveal" data-reveal>
				<p class="policy-pillar__label">経営方針</p>
				<p class="policy-pillar__value">保護者に必要以上の時間的・金銭的負担をかけない</p>
			</article>
			<figure class="mission__visual reveal" data-reveal>
				<img
					src="<?php echo esc_url( shonan_photo( 'top/enjoy-hoiku.jpg' ) ); ?>"
					alt="保育の様子"
					width="800"
					height="960"
					loading="lazy"
				>
			</figure>
			<article class="policy-pillar policy-pillar--guide reveal" data-reveal>
				<p class="policy-pillar__label">指導方針</p>
				<div class="policy-guide">
					<article class="policy-guide__item">
						<h3 class="policy-guide__title">正しいしつけ</h3>
						<p class="policy-guide__text">普遍的なふるまいを自然に身につけます。</p>
					</article>
					<article class="policy-guide__item">
						<h3 class="policy-guide__title">自立</h3>
						<p class="policy-guide__text">「主体」「積極性」「機転」など、生きる力をつけます。</p>
					</article>
					<article class="policy-guide__item">
						<h3 class="policy-guide__title">体力づくり</h3>
						<p class="policy-guide__text">湘南体操を基本に、楽しく体を動かします。</p>
					</article>
				</div>
			</article>
		</div>
		<p class="mission-board__more">
			<a class="text-link" href="<?php echo esc_url( home_url( '/houshin/' ) ); ?>">園の方針と特長を見る</a>
		</p>
	</div>
</section>
