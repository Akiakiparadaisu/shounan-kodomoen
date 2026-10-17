<?php
/**
 * 園の構成図
 *
 * @package Shonan_Kodomoen
 */

$groups = shonan_site_map_groups();
?>
<dialog class="site-map" id="site-map" aria-labelledby="site-map-title">
	<div class="site-map__sheet">
		<header class="site-map__head">
			<div>
				<p class="site-map__eyebrow">ワンクリックで移動</p>
				<h2 class="site-map__title" id="site-map-title">園の構成図</h2>
			</div>
			<button class="site-map__close" type="button" data-site-map-close aria-label="構成図を閉じる">×</button>
		</header>
		<p class="site-map__lead">見たい内容を押すと、その場所へ移動します。</p>

		<div class="site-map__branches">
			<?php foreach ( $groups as $group ) : ?>
				<section class="site-map__group site-map__group--<?php echo esc_attr( $group['key'] ); ?>">
					<h3 class="site-map__group-label"><?php echo esc_html( $group['label'] ); ?></h3>
					<?php foreach ( $group['pages'] as $page ) : ?>
						<div class="site-map__node">
							<a class="site-map__page" href="<?php echo esc_url( $page['url'] ); ?>"><?php echo esc_html( $page['label'] ); ?></a>
							<ul class="site-map__sections">
								<?php foreach ( $page['sections'] as $section ) : ?>
									<li><a href="<?php echo esc_url( $section['url'] ); ?>"><?php echo wp_kses( $section['label'], array( 'br' => array() ) ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</dialog>
