<?php
/**
 * 固定ページ: 将来の幼児教育（スラッグ: mirai）
 *
 * @package Shonan_Kodomoen
 */

get_header();

$pillars = array(
	array(
		'num'   => '01',
		'title' => '脳の発達に合わせた保育',
		'sub'   => '内側からの保育',
		'text'  => '近年、脳科学が進歩し、乳幼児期の発達段階への理解も深まっています。臨界期を考慮した活動や、感覚と運動のつながりを意識した遊び・遊具など、一人ひとりの力を最大限に引き出す保育を探ります。',
	),
	array(
		'num'   => '02',
		'title' => 'メタバースを活用した保育活動',
		'sub'   => '技術との上手な付き合い方',
		'text'  => '生成AI、メタバース、VR、IT機器などは、園での学びや家庭の子育て負担の軽減に役立つ可能性があります。一方で、立体視の発達などへの影響も考え、子どもの成長を第一に利用のあり方を見極めます。',
	),
	array(
		'num'   => '03',
		'title' => 'レジリエンスを育む幼児教育',
		'sub'   => '折れない心、立ち直る力',
		'text'  => '激しく変わる社会でも柔軟に生き、失敗しても再挑戦できる人になるために、幼児期からレジリエンスを育む経験が大切です。意図的な活動と関わりで、その土台をつくります。',
	),
);
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article mirai-page">
		<header class="page-header">
			<h1 class="page-title">将来の幼児教育</h1>
			<p class="mirai-lead">より良い保育を創るため、（株）湘南保育に幼児教育研究部をつくりました。これまでの良さは守りながら、新しい知と技術を活かす挑戦を続けています。</p>
		</header>

		<section class="mirai-intro" id="kenkyu">
			<div class="mirai-intro__panel">
				<p class="mirai-intro__eyebrow">幼児教育研究部の構想</p>
				<h2 class="mirai-intro__title">（株）湘南保育 幼児教育研究部が目指す新しい幼児教育</h2>
				<p>現代は変化の激しい時代です。生成AI、メタバース、VR、量子コンピューターといった新技術、気候変動など地球規模の課題も顕在化しています。今の子どもたちは、これまでの大人が経験してこなかった時代を生きていきます。</p>
				<p>私たちは、子どもたち一人ひとりが自分の強みを見つけ、自信を持って生きていけるように育つことを願っています。幼児教育研究部は、これまでの幼児教育の良い部分は守り、新しい研究成果や新技術をうまく活かして、新しい幼児教育づくりにチャレンジしていきます。</p>
				<p class="mirai-intro__note">令和6年4月より、湘南こども園と湘南保育社の4つの保育園の協力を得て研究を開始しています。</p>
			</div>
		</section>

		<section class="mirai-pillars" id="hashira">
			<header class="section-header">
				<p class="section-eyebrow">研究の柱</p>
				<h2 class="section-title">新しい幼児教育の3つの柱</h2>
				<p class="section-lead">子どもたちの将来のために、大切にしたい3つの視点です。</p>
			</header>

			<div class="mirai-pillars__list">
				<?php foreach ( $pillars as $i => $pillar ) : ?>
					<article class="mirai-pillar mirai-pillar--<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
						<div class="mirai-pillar__label">
							<span class="mirai-pillar__num"><?php echo esc_html( $pillar['num'] ); ?></span>
							<p class="mirai-pillar__sub"><?php echo esc_html( $pillar['sub'] ); ?></p>
						</div>
						<div class="mirai-pillar__body">
							<h3 class="mirai-pillar__title"><?php echo esc_html( $pillar['title'] ); ?></h3>
							<p class="mirai-pillar__text"><?php echo esc_html( $pillar['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="mirai-wish">
			<div class="mirai-wish__inner">
				<h2 class="mirai-wish__title">守るものと、創るもの</h2>
				<p>ふじ幼児園から続くしつけ・自立・体力づくりなどの土台は大切にしながら、脳科学や新しい技術、レジリエンスの視点を重ねていきます。子どもたちの「やりたい」気持ちと、未来を生きる力を、両方とも大切にする幼児教育を目指します。</p>
				<div class="mirai-wish__actions">
					<a class="btn btn--solid" href="<?php echo esc_url( home_url( '/houshin/' ) ); ?>">園の方針を見る</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/history/' ) ); ?>">50年の実績を見る</a>
				</div>
			</div>
		</section>

		<section class="mirai-contact">
			<div class="mirai-contact__inner">
				<h2 class="mirai-contact__title">お問い合わせ</h2>
				<p>研究や園の取り組みについて、ご質問がありましたらお気軽にご連絡ください。</p>
				<ul class="mirai-contact__list">
					<li>TEL：<a href="tel:0467849229">0467-84-9229</a></li>
					<li>〒253-0113 神奈川県高座郡寒川町大曲1-1-6</li>
				</ul>
			</div>
		</section>
	</article>
</div>

<?php
get_footer();
