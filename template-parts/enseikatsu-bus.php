<?php
/**
 * 園バス
 *
 * @package Shonan_Kodomoen
 */

$bus_image = shonan_photo( 'enseikatsu/en-bus/en-bus-image.png' );
$bus_photo = shonan_photo( 'enseikatsu/en-bus/en_bus.jpg' );
$bus_route = shonan_document( 'enseikatsu/en-bus/バスルート.pdf' );

if ( ! $bus_route ) {
	$bus_dir = SHONAN_THEME_DIR . '/assets/documents/enseikatsu/en-bus';
	$entries = is_dir( $bus_dir ) ? scandir( $bus_dir ) : false;
	if ( is_array( $entries ) ) {
		foreach ( $entries as $entry ) {
			if ( preg_match( '/\.pdf$/i', $entry ) ) {
				$bus_route = shonan_document( 'enseikatsu/en-bus/' . $entry );
				if ( $bus_route ) {
					break;
				}
			}
		}
	}
}

$bus_stops = array(
	array(
		'title' => '声をかけあって',
		'text'  => 'バスの中では、異年齢の子どもたち同士が声をかけ合いながら過ごしています。',
	),
	array(
		'title' => 'ご挨拶して降車',
		'text'  => '帰りは降りる順番がくると、みんなに「ご挨拶」をして気持ちよく帰宅します。',
	),
);
?>
<section class="life-block life-block--bus" id="en-bus" aria-labelledby="bus-title">
	<header class="section-header life-block__header">
		<p class="section-eyebrow">あんしんの通園</p>
		<h2 class="section-title" id="bus-title">園バス</h2>
		<p class="section-lead">バスの時間も、もうひとつの園時間。友だちとのふれあいを大切にしています。</p>
	</header>

	<div class="bus-road" data-bus-road>
		<div class="bus-road__track">
			<span class="bus-road__lane" aria-hidden="true"></span>
			<span class="bus-road__runner" aria-hidden="true">
				<img
					class="bus-road__bus"
					src="<?php echo esc_url( $bus_image ); ?>"
					alt=""
					width="640"
					height="280"
				>
			</span>
		</div>
		<ol class="bus-road__stops">
				<li class="bus-stop bus-stop--photo">
					<figure class="bus-stop__photo">
						<img
							src="<?php echo esc_url( $bus_photo ); ?>"
							alt="園バスに乗り込む子どもたち"
							width="900"
							height="700"
						>
					</figure>
				</li>
				<li class="bus-stop">
					<p class="bus-stop__focus">バスの中も保育</p>
					<?php foreach ( $bus_stops as $stop ) : ?>
						<div class="bus-stop__block">
							<h3 class="bus-stop__title"><?php echo esc_html( $stop['title'] ); ?></h3>
							<p class="bus-stop__text"><?php echo esc_html( $stop['text'] ); ?></p>
						</div>
					<?php endforeach; ?>
					<div class="bus-stop__block">
						<h3 class="bus-stop__title">ルートのご案内</h3>
						<?php if ( $bus_route ) : ?>
							<p class="bus-stop__text">園バスの通り道は、ルート表でご確認ください。</p>
							<a class="btn btn--solid" href="<?php echo esc_url( $bus_route ); ?>" target="_blank" rel="noopener noreferrer">バスルートを見る（PDF）</a>
						<?php else : ?>
							<p class="bus-stop__text">ルート表は準備中です。</p>
						<?php endif; ?>
					</div>
				</li>
		</ol>
	</div>
</section>
