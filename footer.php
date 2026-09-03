<?php
/**
 * フッター
 *
 * @package Shonan_Kodomoen
 */
?>
</main>

<footer class="site-footer">
	<div class="site-footer__wave" aria-hidden="true"></div>

	<div class="site-footer__inner">
		<div class="site-footer__brand">
			<p class="site-footer__name">湘南こども園</p>
			<p class="site-footer__address">
				〒253-0113<br>
				神奈川県高座郡寒川町大曲1-1-6<br>
				TEL：<a href="tel:0467849229">0467-84-9229</a>
			</p>
			<p class="site-footer__access">最寄り駅：寒川駅（徒歩14分）／香川駅（徒歩12分）</p>
		</div>

		<nav class="site-footer__nav" aria-label="フッターメニュー">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-nav-list',
					'fallback_cb'    => 'shonan_fallback_menu',
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<div class="site-footer__links">
			<a class="btn btn--outline btn--light" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">入園説明会・見学</a>
			<a class="btn btn--solid btn--light" href="<?php echo esc_url( home_url( '/kyujin/' ) ); ?>">求人案内</a>
		</div>
	</div>

	<div class="site-footer__bottom">
		<p class="copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> 湘南こども園 All Rights Reserved.</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
