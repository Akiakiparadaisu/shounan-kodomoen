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
				<p class="section-eyebrow">保育目標</p>
				<h2 class="section-title">園児はわが子</h2>
				<p class="mission__text">
					ひとりひとりを、わが子のように大切に。あたたかい目で個性や育ちを見守り、
					チームで寄り添う教育・保育をめざしています。
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
					src="<?php echo esc_url( shonan_placeholder( 'about' ) ); ?>"
					alt="保育の様子（仮画像・差し替え予定）"
					width="800"
					height="960"
					loading="lazy"
				>
				<figcaption>※写真は後ほど差し替え予定です</figcaption>
			</figure>
		</div>
	</div>
</section>
