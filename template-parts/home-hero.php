<?php
/**
 * ホームページ：ヒーロー
 *
 * @package Shonan_Kodomoen
 */
?>
<section class="hero" aria-label="湘南こども園 トップビジュアル">
	<div class="hero__media">
		<img
			src="<?php echo esc_url( shonan_placeholder( 'hero' ) ); ?>"
			alt="園庭で遊ぶ子どもたちの様子（仮画像・差し替え予定）"
			width="1920"
			height="1080"
			fetchpriority="high"
		>
	</div>
	<div class="hero__veil" aria-hidden="true"></div>
	<div class="hero__deco" aria-hidden="true">
		<span class="hero__sun"></span>
		<span class="hero__cloud hero__cloud--1"></span>
		<span class="hero__cloud hero__cloud--2"></span>
		<span class="hero__bubble hero__bubble--1"></span>
		<span class="hero__bubble hero__bubble--2"></span>
		<span class="hero__bubble hero__bubble--3"></span>
		<span class="hero__bubble hero__bubble--4"></span>
	</div>
	<div class="hero__content">
		<p class="hero__brand reveal" data-reveal>湘南こども園</p>
		<h1 class="hero__headline reveal" data-reveal>
			自分を大切に　周りも大切に
		</h1>
		<p class="hero__lead reveal" data-reveal>
			「やりたい」気持ちを大切に、のびのび育つ毎日を。
		</p>
		<div class="hero__actions reveal" data-reveal>
			<a class="btn btn--solid" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">入園案内を見る</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/enseikatsu/' ) ); ?>">園生活をのぞく</a>
		</div>
	</div>
	<div class="hero__scroll" aria-hidden="true">
		<span>Scroll</span>
	</div>
	<div class="hero__wave" aria-hidden="true">
		<svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
			<path fill="currentColor" d="M0,64 C240,120 480,0 720,40 C960,80 1200,120 1440,48 L1440,120 L0,120 Z"></path>
		</svg>
	</div>
</section>
