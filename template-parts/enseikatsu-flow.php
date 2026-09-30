<?php
/**
 * 一日の流れ
 *
 * @package Shonan_Kodomoen
 *
 * @param array $args {
 *     @type bool $standalone 専用ページ表示時は見出しを簡略化.
 * }
 */

$standalone = ! empty( $args['standalone'] );
$base       = 'enseikatsu/ichinichi-no-nagare/';

$schedules = array(
	'02' => array(
		'label' => '0・1・2歳児',
		'lead'  => 'ゆったりとしたリズムで、あそび・ごはん・お昼寝を大切にします。',
		'items' => array(
			array(
				'time'  => '7:00',
				'title' => '開園・順次登園',
				'text'  => '順次登園し、自由遊びで一日がはじまります。',
				'image' => $base . '02flow-0700.jpg',
			),
			array(
				'time'  => '9:00',
				'title' => '朝の会',
				'text'  => 'みんなであいさつをして、気持ちを整えます。',
				'image' => $base . '02flow-0900.jpg',
			),
			array(
				'time'  => '9:40',
				'title' => '主活動',
				'text'  => 'お散歩や制作など、年齢に合わせた活動を行います。',
				'image' => $base . '02flow-0940.jpg',
			),
			array(
				'time'  => '11:00',
				'title' => '給食',
				'text'  => 'みんなで楽しくいただきます。',
				'image' => $base . '02flow-1100.jpg',
			),
			array(
				'time'  => '12:00',
				'title' => '午睡',
				'text'  => '安心できる場所で、ぐっすり休みます。',
				'image' => $base . '02flow-1200.jpg',
			),
			array(
				'time'  => '15:00',
				'title' => 'おやつ',
				'text'  => 'おやつの時間を楽しんで過ごします。',
				'image' => $base . '02flow-1500.jpg',
			),
			array(
				'time'  => '15:45',
				'title' => '帰りの会',
				'text'  => '一日の終わりにあいさつをします。',
				'image' => $base . '02flow-1545.jpg',
			),
			array(
				'time'  => '16:00〜19:00',
				'title' => '順次降園',
				'text'  => '遊びながらお迎えを待ち、順次降園します。',
				'image' => $base . '02flow-16001900.jpg',
			),
		),
	),
	'35' => array(
		'label' => '3・4・5歳児',
		'lead'  => '主活動や仲間とのあそびを通して、自立と社会性を育みます。',
		'note'  => '※1号認定児は 9:00〜9:30 登園です。',
		'items' => array(
			array(
				'time'  => '7:00',
				'title' => '開園・順次登園',
				'text'  => '順次登園し、自由遊びで一日がはじまります。',
				'image' => $base . '35flow-0700.jpg',
			),
			array(
				'time'  => '9:45',
				'title' => '朝の会',
				'text'  => '朝のあいさつや歌で、気持ちをひとつにします。',
				'image' => $base . '35flow-0945.jpg',
			),
			array(
				'time'  => '10:00',
				'title' => '主活動',
				'text'  => '制作や外遊びなど、豊かな体験を重ねます。',
				'image' => $base . '35flow-1000.jpg',
			),
			array(
				'time'  => '12:00',
				'title' => '給食',
				'text'  => 'みんなで楽しくいただきます。',
				'image' => $base . '35flow-1200.jpg',
			),
			array(
				'time'  => '13:00',
				'title' => '自由遊び',
				'text'  => '好きなあそびを通して、友だちとの関わりを深めます。',
				'image' => $base . '35flow-1300.jpg',
			),
			array(
				'time'  => '14:00',
				'title' => '1号園児降園・預かり保育',
				'text'  => '1号認定児は降園、その後は預かり保育があります。',
				'image' => $base . '35flow-1400.jpg',
			),
			array(
				'time'  => '15:00',
				'title' => 'おやつ',
				'text'  => 'おやつの時間を楽しんで過ごします。',
				'image' => $base . '35flow-1500.jpg',
			),
			array(
				'time'  => '16:00〜19:00',
				'title' => '順次降園',
				'text'  => '遊びながらお迎えを待ち、順次降園します。',
				'image' => $base . '35flow-16001900.jpg',
			),
		),
	),
);
?>
<section class="daily-flow" id="ichinichi-no-nagare" aria-labelledby="daily-flow-title">
	<header class="section-header daily-flow__header">
		<?php if ( ! $standalone ) : ?>
			<p class="section-eyebrow">園での一日</p>
			<h2 class="section-title" id="daily-flow-title">一日の流れ</h2>
			<p class="section-lead">年齢に合わせた、一日のリズムをご紹介します。</p>
		<?php else : ?>
			<h2 class="section-title screen-reader-text" id="daily-flow-title">一日の流れ</h2>
			<p class="section-lead">年齢に合わせた、すこやかな一日のリズムをご紹介します。</p>
		<?php endif; ?>
	</header>

	<div class="daily-flow__tabs" role="tablist" aria-label="年齢別の一日の流れ">
		<button
			type="button"
			class="daily-flow__tab is-active"
			role="tab"
			id="daily-tab-02"
			aria-selected="true"
			aria-controls="daily-panel-02"
			data-daily-tab="02"
		>
			0・1・2歳児
		</button>
		<button
			type="button"
			class="daily-flow__tab"
			role="tab"
			id="daily-tab-35"
			aria-selected="false"
			aria-controls="daily-panel-35"
			data-daily-tab="35"
		>
			3・4・5歳児
		</button>
	</div>

	<?php foreach ( $schedules as $key => $schedule ) : ?>
		<div
			class="daily-flow__panel<?php echo '02' === $key ? ' is-active' : ''; ?>"
			role="tabpanel"
			id="daily-panel-<?php echo esc_attr( $key ); ?>"
			aria-labelledby="daily-tab-<?php echo esc_attr( $key ); ?>"
			data-daily-panel="<?php echo esc_attr( $key ); ?>"
			<?php echo '02' !== $key ? ' hidden' : ''; ?>
		>
			<div class="daily-flow__intro daily-flow__intro--<?php echo esc_attr( $key ); ?>">
				<h3 class="daily-flow__label"><?php echo esc_html( $schedule['label'] ); ?></h3>
				<?php if ( ! empty( $schedule['note'] ) ) : ?>
					<p class="daily-flow__note"><?php echo esc_html( $schedule['note'] ); ?></p>
				<?php endif; ?>
			</div>

			<ol class="flow-line">
				<?php foreach ( $schedule['items'] as $i => $item ) : ?>
					<li class="flow-step" style="--i: <?php echo esc_attr( (string) $i ); ?>">
						<div class="flow-step__rail">
							<p class="flow-step__time"><?php echo esc_html( $item['time'] ); ?></p>
							<?php if ( $i < count( $schedule['items'] ) - 1 ) : ?>
								<span class="flow-step__arrow" aria-hidden="true"></span>
							<?php endif; ?>
						</div>
						<article class="flow-card">
							<figure class="flow-card__media">
								<img
									src="<?php echo esc_url( shonan_photo( $item['image'] ) ); ?>"
									alt="<?php echo esc_attr( $item['title'] ); ?>"
									width="640"
									height="480"
									loading="lazy"
								>
							</figure>
							<div class="flow-card__body">
								<h4 class="flow-card__title"><?php echo esc_html( $item['title'] ); ?></h4>
								<p class="flow-card__text"><?php echo esc_html( $item['text'] ); ?></p>
							</div>
						</article>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	<?php endforeach; ?>
</section>
