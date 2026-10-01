<?php
/**
 * ヘッダー
 *
 * @package Shonan_Kodomoen
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.add('js-reveal');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">コンテンツへスキップ</a>

<header class="site-header" id="site-header">
	<div class="site-header__inner">
		<div class="site-header__bar">
			<div class="site-branding">
				<a class="site-logo-text" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="site-logo-text__mark" aria-hidden="true">
						<img
							src="<?php echo esc_url( SHONAN_THEME_URI . '/assets/images/photos/en_icon.png' ); ?>"
							alt=""
							width="44"
							height="44"
							decoding="async"
						>
					</span>
					<span class="site-logo-text__names">
						<span class="site-logo-text__corp">学校法人 正栄学園</span>
						<span class="site-logo-text__name"><?php bloginfo( 'name' ); ?></span>
					</span>
				</a>
			</div>
			<div class="site-header__tools">
				<a class="btn btn--small btn--outline" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">入園案内</a>
				<a class="btn btn--small btn--solid" href="tel:0467849229">TEL 0467-84-9229</a>
			</div>
			<button
				class="nav-toggle"
				type="button"
				aria-controls="primary-nav"
				aria-expanded="false"
				aria-label="メニューを開く"
			>
				<span class="nav-toggle__bar"></span>
				<span class="nav-toggle__bar"></span>
				<span class="nav-toggle__bar"></span>
			</button>
		</div>

		<nav class="primary-nav" id="primary-nav" aria-label="メインメニュー">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-list',
					'fallback_cb'    => 'shonan_fallback_menu',
					'depth'          => 2,
				)
			);
			?>
			<div class="primary-nav__cta">
				<a class="btn btn--small btn--outline" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">入園案内</a>
				<a class="btn btn--small btn--solid" href="tel:0467849229">TEL 0467-84-9229</a>
			</div>
		</nav>
	</div>
</header>

<main id="main-content" class="site-main">
