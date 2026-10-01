<?php
/**
 * プレ保育（湘南ジュニア）コンテンツ
 *
 * @package Shonan_Kodomoen
 *
 * @param array $args {
 *     @type bool $standalone 専用ページ表示時は見出しを簡略化.
 * }
 */

$standalone = ! empty( $args['standalone'] );
$base       = 'houshin/pre-hoiku/';

$merits = array(
	'お友だちや先生との関わりや、おやつを一緒に食べる時間を通じて、お子さまが成長する機会となります。',
	'いつも会える子どもどうし、保護者どうしで親しくなり、子どもの発達や幼児教育について情報交換や学び合うことができます。',
	'園に通っている各年齢の子どもたちの様子を見ることで、各年齢になった時のお子さまのイメージを持つことができます。',
);

$overview = array(
	array( 'label' => '対象', 'value' => '未就園の２歳児' ),
	array( 'label' => '定員', 'value' => '月・木クラス 20名 ／ 火・金クラス 20名' ),
	array( 'label' => '活動時間', 'value' => '9:30〜11:30（活動日は事前に通知）' ),
	array( 'label' => '入会金', 'value' => '10,000円' ),
	array( 'label' => '月額', 'value' => '10,000円' ),
);

$activities = array(
	array(
		'time'  => '9:20',
		'title' => '順次登園',
		'text'  => '出席シールを貼り、荷物を決められた場所に置きます。',
		'image' => $base . 'jr-1.jpg',
	),
	array(
		'time'  => '9:30',
		'title' => '朝の会',
		'text'  => '朝のあいさつ、「おはようの歌」、季節の歌を歌います。',
		'image' => $base . 'jr-2.jpg',
	),
	array(
		'time'  => '主活動',
		'title' => 'たのしい活動',
		'text'  => '季節の制作、外遊び、誕生日会などを行います。',
		'image' => $base . 'ju-3.jpg',
	),
	array(
		'time'  => '10:50',
		'title' => 'おやつ',
		'text'  => '園の厨房でつくった小さなおにぎりを、みんなで食べます。',
		'image' => $base . 'ju-4.jpg',
	),
	array(
		'time'  => '11:15',
		'title' => '帰りの会',
		'text'  => '読み聞かせ、「さよならのうた」、帰りのあいさつをします。',
		'image' => $base . 'ju-5.jpg',
	),
	array(
		'time'  => '11:30',
		'title' => '降園',
		'text'  => '先生にあいさつをして、降園します。',
		'image' => $base . 'ju-6.jpg',
	),
);

$moushikomi = shonan_document( 'houshin/pre-hoiku/shonan-junior-moushikomi.pdf' );
?>
<section class="pre-care" id="pre-hoiku" aria-labelledby="pre-hoiku-title">
	<header class="section-header pre-care__header">
		<?php if ( ! $standalone ) : ?>
			<p class="section-eyebrow">プレ保育</p>
			<h2 class="section-title" id="pre-hoiku-title">プレ保育（湘南ジュニア）とは？</h2>
		<?php else : ?>
			<h2 class="section-title screen-reader-text" id="pre-hoiku-title">プレ保育（湘南ジュニア）</h2>
		<?php endif; ?>
	</header>

	<div class="pre-care__hero">
		<figure class="pre-care__hero-media">
			<img
				src="<?php echo esc_url( shonan_photo( $base . 'jr.jpg' ) ); ?>"
				alt="湘南ジュニアの様子"
				width="900"
				height="700"
				loading="lazy"
			>
		</figure>
		<div class="pre-care__hero-copy">
			<div class="pre-bubble">
				<h3 class="pre-bubble__title">プレ保育の目的</h3>
				<p class="pre-bubble__text">
					プレ保育は、未就園児に対して、保育・教育的な環境を提供し、集団生活を通じて自己の成長と社会性を促すことを目的としたプログラムです。
				</p>
			</div>
			<div class="pre-bubble pre-bubble--mint">
				<h3 class="pre-bubble__title">プレ保育のメリット</h3>
				<ul class="pre-merit-list">
					<?php foreach ( $merits as $merit ) : ?>
						<li><?php echo esc_html( $merit ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

	<section class="pre-building" aria-labelledby="pre-building-title">
		<header class="section-header pre-building__header">
			<p class="section-eyebrow">専用の建物</p>
			<h3 class="section-title" id="pre-building-title">湘南ジュニア＆誰でも通園の建物</h3>
			<p class="section-lead">未就園児が過ごすための、専用の建物です。</p>
		</header>
		<div class="pre-building__grid">
			<figure class="pre-building__card">
				<img
					src="<?php echo esc_url( shonan_photo( $base . 'building-outdoor.jpg' ) ); ?>"
					alt="湘南ジュニアの建物の外観。淡いピンクの外壁と正面の入口"
					loading="lazy"
				>
				<figcaption>
					<span>外観</span>
					建物の正面です。淡いピンクの外壁に「湘南ジュニア」の文字があり、すりガラスの入口から入ります。
				</figcaption>
			</figure>
			<figure class="pre-building__card">
				<img
					src="<?php echo esc_url( shonan_photo( $base . 'building_indoor.jpg' ) ); ?>"
					alt="湘南ジュニアの室内。木の床と棚、机と椅子"
					loading="lazy"
				>
				<figcaption>
					<span>室内</span>
					木の床の部屋に、絵本やおもちゃの棚、幼児用の机と椅子があります。
				</figcaption>
			</figure>
		</div>
		<p class="pre-building__cta">
			<button type="button" class="btn btn--solid" data-junior-3d-open>湘南ジュニアの建物を見る</button>
		</p>
	</section>

	<section class="pre-overview" aria-labelledby="pre-overview-title">
		<header class="pre-overview__head">
			<p class="section-eyebrow">ご案内</p>
			<h3 class="section-title" id="pre-overview-title">概要</h3>
		</header>
		<ul class="pre-overview__list">
			<?php foreach ( $overview as $row ) : ?>
				<li class="pre-overview__item">
					<span class="pre-overview__label"><?php echo esc_html( $row['label'] ); ?></span>
					<span class="pre-overview__value"><?php echo esc_html( $row['value'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php if ( $moushikomi ) : ?>
			<div class="pre-overview__cta">
				<a
					class="btn btn--solid"
					href="<?php echo esc_url( $moushikomi ); ?>"
					download
					target="_blank"
					rel="noopener noreferrer"
				>
					申込書をダウンロード（PDF）
				</a>
				<p class="pre-overview__cta-note">湘南ジュニア入会申込書（PDF）</p>
				<?php $junior_poster = shonan_managed_document_url( 'junior' ); ?>
				<?php if ( $junior_poster ) : ?>
					<a
						class="btn btn--outline"
						href="<?php echo esc_url( $junior_poster ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>湘南ジュニアのご案内（PDF）</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</section>

	<section class="pre-activities" aria-labelledby="pre-activities-title">
		<header class="section-header pre-activities__header">
			<p class="section-eyebrow">一日の流れ</p>
			<h3 class="section-title" id="pre-activities-title">湘南ジュニアの活動</h3>
		</header>
		<div class="pre-activities__grid">
			<?php foreach ( $activities as $i => $activity ) : ?>
				<article class="pre-step pre-step--<?php echo esc_attr( (string) ( ( $i % 3 ) + 1 ) ); ?>">
					<figure class="pre-step__media">
						<img
							src="<?php echo esc_url( shonan_photo( $activity['image'] ) ); ?>"
							alt="<?php echo esc_attr( $activity['title'] ); ?>"
							width="640"
							height="480"
							loading="lazy"
						>
					</figure>
					<div class="pre-step__body">
						<p class="pre-step__time"><?php echo esc_html( $activity['time'] ); ?></p>
						<h4 class="pre-step__title"><?php echo esc_html( $activity['title'] ); ?></h4>
						<p class="pre-step__text"><?php echo esc_html( $activity['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
</section>
<?php get_template_part( 'template-parts/junior-3d' ); ?>
