<?php
/**
 * 年間行事
 *
 * @package Shonan_Kodomoen
 *
 * @param array $args {
 *     @type bool $standalone 専用ページ表示時は見出しを簡略化.
 * }
 */

$standalone = ! empty( $args['standalone'] );
$base       = 'enseikatsu/nenkan-gyoji/';

$terms = array(
	'1' => array(
		'label' => '1学期',
		'items' => array(
			array(
				'title' => '入園式',
				'text'  => '園児の未来に向けての新生活がスタートします！',
				'image' => $base . '1_ev-1.jpg',
			),
			array(
				'title' => '遠足（年少・年長）',
				'text'  => '園内とはちがった環境で新たな遊びやお友だちとの交流を体験します。',
				'image' => $base . '1_ev-2.jpg',
			),
			array(
				'title' => 'じゃがいも掘り（年長）',
				'text'  => 'どろんこになっていっぱい収穫します。',
				'image' => $base . '1_ev-3.jpg',
			),
			array(
				'title' => '交通安全指導',
				'text'  => '交通ルールを学ぶ第一歩です！',
				'image' => $base . '1_ev-4.jpg',
			),
			array(
				'title' => 'ファミリーデー',
				'text'  => '保護者といっしょに楽しい体操をします。園児の制作物も展示して観覧して頂きます。',
				'image' => $base . '1_ev-5.jpg',
			),
			array(
				'title' => 'お泊り保育（年長）',
				'text'  => '園に一泊のお泊りをします。夜はキャンプファイヤーもやります！',
				'image' => $base . '1_ev-6.jpg',
			),
			array(
				'title' => 'プール遊び',
				'text'  => 'みんなで楽しくプールで遊びます。大人気です！',
				'image' => $base . '1_ev-7.jpg',
			),
			array(
				'title' => '湘南こどもまつり',
				'text'  => 'ヨーヨー釣りやゲームコーナーをおうちの方とお友達と楽しみます。地域の方や未就園児も参加できます！大歓迎です！',
				'image' => $base . '1_ev-8.jpg',
			),
		),
	),
	'2' => array(
		'label' => '2学期',
		'items' => array(
			array(
				'title' => '稲刈り体験（年長）',
				'text'  => '毎日食べているお米を収穫体験します。近隣の農家の方にご協力を頂いています。',
				'image' => $base . '2_ev-9.jpg',
			),
			array(
				'title' => '運動会',
				'text'  => 'みんなで力を合わせて保護者に園生活の成果を発表します。',
				'image' => $base . '2_ev-10.jpg',
			),
			array(
				'title' => '親子遠足（年中）',
				'text'  => '園児と保護者にいっしょに食べるお弁当は格別です。',
				'image' => $base . '2_ev-11.jpg',
			),
			array(
				'title' => 'さつまいも掘り（年少・年中）',
				'text'  => '春はじゃが芋、秋はさつま芋掘りをします。近隣の農家さんのご協力で園児も喜んでいます。',
				'image' => $base . '2_ev-12.jpg',
			),
			array(
				'title' => 'クリスマス会',
				'text'  => '毎年、サンタクロースさんからのプレゼントが渡されます。',
				'image' => $base . '2_ev-13.jpg',
			),
			array(
				'title' => 'クリスマス発表会',
				'text'  => '練習を重ねた成果を発表します。',
				'image' => $base . '2_ev-14.jpg',
			),
			array(
				'title' => 'お餅つき（年長）',
				'text'  => '力をこめて「よいしょ」自分たちでついたお餅を食べます。',
				'image' => $base . '2_ev-15.jpg',
			),
		),
	),
	'3' => array(
		'label' => '3学期',
		'items' => array(
			array(
				'title' => '節分',
				'text'  => '赤鬼・青鬼が登場！「おにはそと、ふくはうち」',
				'image' => $base . '3_ev-16.jpg',
			),
			array(
				'title' => 'ありがとうの会',
				'text'  => '卒園生を送る会です。「いっしょに遊んでくれてありがとう！」',
				'image' => $base . '3_ev-17.jpg',
			),
			array(
				'title' => '卒園式',
				'text'  => '園児の成長した姿に感動します！',
				'image' => $base . '3_ev-18.jpg',
			),
		),
	),
);
?>
<section class="year-events" id="nenkan-gyoji" aria-labelledby="year-events-title">
	<header class="section-header year-events__header">
		<?php if ( ! $standalone ) : ?>
			<p class="section-eyebrow">一年の思い出</p>
			<h2 class="section-title" id="year-events-title">年間行事</h2>
			<p class="section-lead">四季折々の行事を通して、あそびと学びの思い出を重ねていきます。</p>
		<?php else : ?>
			<h2 class="section-title screen-reader-text" id="year-events-title">年間行事</h2>
			<p class="section-lead">四季折々の行事を通して、あそびと学びの思い出を重ねていきます。</p>
		<?php endif; ?>
	</header>

	<div class="year-events__tabs" role="tablist" aria-label="学期別の年間行事">
		<?php foreach ( $terms as $key => $term ) : ?>
			<?php
			$key     = (string) $key;
			$is_first = '1' === $key;
			?>
			<button
				type="button"
				class="year-events__tab<?php echo $is_first ? ' is-active' : ''; ?>"
				role="tab"
				id="events-tab-<?php echo esc_attr( $key ); ?>"
				aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>"
				aria-controls="events-panel-<?php echo esc_attr( $key ); ?>"
				data-events-tab="<?php echo esc_attr( $key ); ?>"
			>
				<?php echo esc_html( $term['label'] ); ?>
			</button>
		<?php endforeach; ?>
	</div>

	<?php foreach ( $terms as $key => $term ) : ?>
		<?php
		$key      = (string) $key;
		$is_first = '1' === $key;
		?>
		<div
			class="year-events__panel<?php echo $is_first ? ' is-active' : ''; ?>"
			role="tabpanel"
			id="events-panel-<?php echo esc_attr( $key ); ?>"
			aria-labelledby="events-tab-<?php echo esc_attr( $key ); ?>"
			data-events-panel="<?php echo esc_attr( $key ); ?>"
			<?php echo $is_first ? '' : ' hidden'; ?>
		>
			<div class="year-events__grid">
				<?php foreach ( $term['items'] as $i => $item ) : ?>
					<article class="event-card event-card--<?php echo esc_attr( (string) ( ( $i % 3 ) + 1 ) ); ?>">
						<div class="event-card__flip">
							<div class="event-card__face event-card__face--front">
								<figure class="event-card__media">
									<img
										src="<?php echo esc_url( shonan_photo( $item['image'] ) ); ?>"
										alt="<?php echo esc_attr( $item['title'] ); ?>"
										width="640"
										height="480"
										loading="lazy"
									>
								</figure>
								<div class="event-card__body">
									<h3 class="event-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
									<p class="event-card__text"><?php echo esc_html( $item['text'] ); ?></p>
								</div>
							</div>
							<div class="event-card__face event-card__face--back" aria-hidden="true"></div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</section>
