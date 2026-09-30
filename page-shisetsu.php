<?php
/**
 * 固定ページ: 園の施設（スラッグ: shisetsu）
 *
 * @package Shonan_Kodomoen
 */

get_header();

$base = 'shisetsu/ensha/';

$facilities = array(
	array(
		'title' => '園庭',
		'text'  => 'さまざまな遊具がそろい、自分の遊びも友だちとの遊びも思う存分楽しめる広さです。園庭開放も行っており、地域の方々にもご利用いただいています。',
		'image' => $base . 'entei.jpg',
	),
	array(
		'title' => 'こどもトイレ',
		'text'  => '外で遊んでいても、すぐにトイレに行けるように配慮しています。',
		'image' => $base . 'toilet.jpg',
	),
	array(
		'title' => 'ホール（講堂）',
		'text'  => '入園式・卒園式などの式典だけでなく、巧技台を使った体操や英語などの教育プログラム、雨天時の遊びなど、さまざまに利用しています。',
		'image' => $base . 'houle.jpg',
	),
	array(
		'title' => '駐輪場',
		'text'  => '玄関前に広い駐輪場をご用意しています。自転車を降りてすぐに園舎へ入れます。令和7年3月に舗装整備をしました。',
		'image' => $base . 'tyurijyou.jpg',
	),
	array(
		'title' => '駐車場',
		'text'  => '園舎のすぐそばに広い駐車場があります。登園やお迎えのときも、待たずに駐車していただけます。',
		'image' => $base . 'parking_car.jpg',
	),
	array(
		'title' => 'ソーラーパネル',
		'text'  => '屋上にソーラーパネルを設置し、太陽光で発電した電力を園舎の照明等に用いています。自然エネルギーの取り組みが、子どもたちの環境への関心につながることを願っています。',
		'image' => $base . 'solar_panel.jpg',
	),
	array(
		'title' => 'エレベーター',
		'text'  => '入園式や卒園式などで保護者の方にご不便のないよう、エレベーターを設置しています。',
		'image' => $base . 'elevator.jpg',
	),
	array(
		'title' => '教室（保育）',
		'text'  => '机と椅子は子どもに適したサイズで、黄色を基調とした親しみやすいデザインです。',
		'image' => $base . 'classroom1.jpg',
	),
	array(
		'title' => '教室（年少〜年長）',
		'text'  => '壁には子どもたちの絵がたくさん展示されています。多様なテーマで描かれた作品が、創造力や表現力を育む環境をつくっています。',
		'image' => $base . 'classroom2.jpg',
	),
);
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article shisetsu-page">
		<header class="page-header">
			<h1 class="page-title">園の施設</h1>
		</header>

		<figure class="policy-visual shisetsu-visual">
			<img
				src="<?php echo esc_url( shonan_photo( 'shisetsu/shisetsu.png' ) ); ?>"
				alt="施設紹介 — 保育室・ホール・エレベーター・駐車場"
				width="1600"
				height="1000"
				fetchpriority="high"
			>
		</figure>

		<section class="facility-intro">
			<p class="facility-intro__text">
				子どもたちがのびのび過ごせる園庭や教室、式典や体操にも使えるホールなど、
				安心とたのしさがつまった園舎をご紹介します。
			</p>
		</section>

		<section class="facility-gallery" id="ensha" aria-labelledby="facility-gallery-title">
			<header class="section-header facility-gallery__header">
				<p class="section-eyebrow">園舎紹介</p>
				<h2 class="section-title" id="facility-gallery-title">なかよしの場所がいっぱい</h2>
			</header>

			<div class="facility-gallery__grid">
				<?php foreach ( $facilities as $i => $item ) : ?>
					<article class="facility-card facility-card--<?php echo esc_attr( (string) ( ( $i % 3 ) + 1 ) ); ?>">
						<figure class="facility-card__media">
							<img
								src="<?php echo esc_url( shonan_photo( $item['image'] ) ); ?>"
								alt="<?php echo esc_attr( $item['title'] ); ?>"
								width="800"
								height="560"
								loading="lazy"
							>
						</figure>
						<div class="facility-card__body">
							<h3 class="facility-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
							<p class="facility-card__text"><?php echo esc_html( $item['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="facility-access" id="access" aria-labelledby="access-title">
			<header class="section-header facility-access__header">
				<p class="section-eyebrow">アクセス</p>
				<h2 class="section-title" id="access-title">お越しの際はこちら</h2>
			</header>

			<div class="access-panel">
				<div class="access-panel__main">
					<p class="access-panel__org">学校法人 正栄学園</p>
					<h3 class="access-panel__name">湘南こども園</h3>
					<p class="access-panel__address">
						〒253-0113<br>
						神奈川県高座郡寒川町大曲1-1-6
					</p>
					<p class="access-panel__tel">
						TEL：<a href="tel:0467849229">0467-84-9229</a>
					</p>
					<ul class="access-panel__stations">
						<li>
							<span class="access-panel__label">寒川駅</span>
							<span class="access-panel__value">徒歩14分</span>
						</li>
						<li>
							<span class="access-panel__label">香川駅</span>
							<span class="access-panel__value">徒歩12分</span>
						</li>
					</ul>
				</div>
				<div class="access-panel__map">
					<iframe
						title="湘南こども園の地図"
						src="https://maps.google.com/maps?q=神奈川県高座郡寒川町大曲1-1-6+湘南こども園&hl=ja&z=16&output=embed"
						width="600"
						height="450"
						style="border:0;"
						allowfullscreen=""
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
					></iframe>
				</div>
			</div>
		</section>
	</article>
</div>

<?php
get_footer();
