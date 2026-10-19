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
							src="<?php echo esc_url( shonan_photo( 'en_icon.png' ) ); ?>"
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
				<p class="site-motto"><span class="site-motto__wave" aria-hidden="true">〜</span>園児はわが子<sup class="site-motto__r">®</sup><span class="site-motto__wave" aria-hidden="true">〜</span></p>
			</div>
			<div class="site-header__actions">
				<div class="site-map-launch">
					<button
						class="site-map-open"
						type="button"
						aria-haspopup="dialog"
						aria-controls="site-map"
						aria-label="園の構成図を開く"
					>構成図</button>
					<p class="site-map-launch__note">（ワンタッチで目的の情報へ）</p>
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
		</div>

		<nav class="primary-nav" id="primary-nav" aria-label="メインメニュー">
			<?php shonan_render_grouped_nav(); ?>
			<div class="primary-nav__cta">
				<a class="btn btn--small btn--outline" href="<?php echo esc_url( home_url( '/nyuen/' ) ); ?>">入園案内</a>
				<a class="btn btn--small btn--solid" href="tel:0467849229">TEL 0467-84-9229</a>
			</div>
		</nav>
	</div>
	<?php get_template_part( 'template-parts/site-map' ); ?>
</header>

<main id="main-content" class="site-main">
