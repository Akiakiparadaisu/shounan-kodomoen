<?php
/**
 * ホームページ：保育目標・理念
 *
 * @package Shonan_Kodomoen
 */
?>
<section class="section mission" id="mission">
	<div class="section__inner">
		<div class="mission__grid">
			<div class="mission__copy reveal" data-reveal>
				<p class="section-eyebrow">モットー</p>
				<h2 class="section-title">園児はわが子</h2>
				<p class="mission__text">
					多くの職員の目で、園児一人ひとりの個性や発達を丁寧に把握し、チームで教育と保育にあたります。
				</p>
				<ul class="mission__points">
					<li>正しいしつけ</li>
					<li>自立</li>
					<li>体力づくり</li>
				</ul>
				<a class="text-link" href="<?php echo esc_url( home_url( '/houshin/' ) ); ?>">園の方針と特長を見る</a>
			</div>
			<figure class="mission__visual reveal" data-reveal>
				<img
					src="<?php echo esc_url( SHONAN_THEME_URI . '/assets/images/photos/top/enjoy-hoiku.jpg' ); ?>"
					alt="保育の様子"
					width="800"
					height="960"
					loading="lazy"
				>
			</figure>
		</div>
	</div>
</section>
