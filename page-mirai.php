<?php
/**
 * 固定ページ: 将来の幼児教育（スラッグ: mirai）
 *
 * @package Shonan_Kodomoen
 */

get_header();

$katsudo_pdf = shonan_document( 'history/katsudo/item_31.pdf' );

$pillars = array(
	array(
		'num'        => '01',
		'title'      => '脳の発達に合わせた保育',
		'sub'        => '内側からの保育',
		'paragraphs' => array(
			'子どもたちが言葉をどのように理解しているのか。その仕組みを科学的に明らかにするため、脳波を測定し、言葉の理解度を数値で表す研究に取り組んでいます。',
			'これまで目に見えなかった脳の働きを客観的に捉えることで、子ども一人ひとりの発達や理解の特徴をより深く知ることを目指しています。',
			'こうした研究を通じて、子どもの脳の発達に合った、科学的根拠に基づく保育の実現を目指しています。',
		),
	),
	array(
		'num'        => '02',
		'title'      => 'メタバースを活用した保育活動',
		'sub'        => '技術との上手な付き合い方',
		'paragraphs' => array(
			'メタバースやVR（仮想現実）を活用し、<strong>普段の生活では体験できない世界や、実際には経験することが難しい場面を疑似体験できる保育</strong>に取り組んでいます。',
			'例えば、地震や火災などの災害を想定した避難シミュレーションや、未知の環境での体験を通じて、子どもたちが自ら考え、判断し、行動する力を育むことを目指しています。',
			'また、子どもの視覚や脳の発達への影響にも十分配慮し、安全性を確保しながら、新しい技術を保育に取り入れていきます。',
		),
	),
	array(
		'num'    => '03',
		'title'  => 'レジリエンスを育む幼児教育',
		'sub'    => '折れない心、立ち直る力',
		'text'   => '激しく変わる社会でも柔軟に生き、失敗しても再挑戦できる人になるために、幼児期からレジリエンスを育む経験が大切です。意図的な活動と関わりで、その土台をつくります。',
		'source' => '(重点保育項目平成１１年)',
	),
);
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article mirai-page">
		<header class="page-header">
			<h1 class="page-title">将来の幼児教育</h1>
			<p class="mirai-lead">より良い保育を創るため、関連事業として（株）湘南保育に幼児教育研究部をつくりました。これまでの良さは守りながら、新しい知と技術を活かす挑戦を続けています。</p>
		</header>

		<section class="mirai-intro" id="kenkyu">
			<div class="mirai-intro__panel">
				<p class="mirai-intro__eyebrow">幼児教育研究部の構想</p>
				<h2 class="mirai-intro__title">（株）湘南保育 幼児教育研究部が目指す新しい幼児教育</h2>
				<ul class="mirai-intro__keywords" aria-label="3つの柱">
					<?php foreach ( $pillars as $pillar ) : ?>
						<li><?php echo esc_html( $pillar['title'] ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p>幼児教育研究部は、社会犯罪を減少させるための幼児教育の開発を目的に日々研究をしています。そのために、VR、AI、脳科学、犯罪心理学といった新たな技術や知見を活用しています。</p>
				<p>これまでの幼児教育の良い部分は守り、新しい研究成果や新技術をうまく活かして、新しい幼児教育づくりにチャレンジしていきます。</p>
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
							<h3 class="mirai-pillar__title">
								<?php echo esc_html( $pillar['title'] ); ?>
								<?php if ( ! empty( $pillar['source'] ) && $katsudo_pdf ) : ?>
									<a class="mirai-pillar__source" href="<?php echo esc_url( $katsudo_pdf ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $pillar['source'] ); ?></a>
								<?php endif; ?>
							</h3>
							<?php if ( ! empty( $pillar['paragraphs'] ) ) : ?>
								<?php foreach ( $pillar['paragraphs'] as $paragraph ) : ?>
									<p class="mirai-pillar__text"><?php echo wp_kses( $paragraph, array( 'strong' => array() ) ); ?></p>
								<?php endforeach; ?>
							<?php else : ?>
								<p class="mirai-pillar__text"><?php echo esc_html( $pillar['text'] ); ?></p>
							<?php endif; ?>
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
