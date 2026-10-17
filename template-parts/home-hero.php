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
			src="<?php echo esc_url( shonan_placeholder( 'top' ) ); ?>"
			alt="湘南こども園（あの頃から、ずっと子どもたちのそばに）"
			width="1920"
			height="1080"
			fetchpriority="high"
			decoding="async"
		>
	</div>
	<div class="hero__veil" aria-hidden="true"></div>
	<div class="hero__content">
		<h1 class="hero__brand reveal" data-reveal>湘南こども園</h1>
	</div>
	<div class="hero__wave" aria-hidden="true">
		<svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
			<path fill="currentColor" d="M0,64 C240,120 480,0 720,40 C960,80 1200,120 1440,48 L1440,120 L0,120 Z"></path>
		</svg>
	</div>
</section>
