<?php
/**
 * 固定ページ: 求職中の方へ（スラッグ: kyujin）
 *
 * @package Shonan_Kodomoen
 */

get_header();

$workplace = array(
	array(
		'title' => '明るい職場',
		'text'  => '子どもたちの元気な声や笑顔であふれています。職員も子どもたちから元気をもらい、毎日明るく働いています。',
	),
	array(
		'title' => '丁寧な指導',
		'text'  => '保育に不慣れな方も大丈夫。先輩保育者が、保育のやり方や子どもへの関わり方を丁寧に伝えます。',
	),
	array(
		'title' => '意見を大切に',
		'text'  => '子どもにとって良いと思うことがあれば、遠慮なく提案してください。みんなで考え、保育をより良くしていきます。',
	),
	array(
		'title' => '助け合うチーム',
		'text'  => '迷ったときは先輩や園長に相談を。職員がチームとして、より良い方法をいっしょに見つけます。',
	),
);
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article kyujin-page">
		<header class="page-header">
			<h1 class="page-title">求職中の方へ</h1>
			<p class="kyujin-lead">子どもたちのそばで、いっしょに育ち合う毎日を。湘南こども園で働くことを考えている方へ、メッセージと職場の雰囲気をお伝えします。</p>
		</header>

		<section class="kyujin-message" id="message">
			<header class="section-header">
				<p class="section-eyebrow">園長メッセージ</p>
				<h2 class="section-title">保育教諭を目指す方へ</h2>
			</header>

			<div class="kyujin-message__panel">
				<p>子どもと過ごす毎日は、驚きや発見、そしてたくさんの笑顔にあふれています。小さな手をつないで、一緒に笑ったり、ときには悩んだり…そんな一日一日が、大切な思い出になっていきます。</p>
				<p>保育の仕事は大変なこともありますが、それ以上に「やってよかった」と思える瞬間がたくさんあります。子どもたちの成長をそばで見守れること、それを一緒に喜べることは、この仕事ならではの魅力です。</p>
				<p>最初はわからないことや不安なこともあるかもしれません。でも大丈夫。まわりの先生たちも、みんなそうやって少しずつ成長してきました。あなたの「子どもが好き」という気持ちを大切に、一歩ずつ進んでいってくださいね。</p>
				<p>私たちと一緒に、子どもたちの笑顔に囲まれた毎日をつくっていきませんか？</p>
				<p class="kyujin-message__closing">あなたとお会いできる日を、心より楽しみにしています。</p>
			</div>
		</section>

		<section class="kyujin-workplace" id="shokuba">
			<header class="section-header">
				<p class="section-eyebrow">働く環境</p>
				<h2 class="section-title">湘南こども園の職場環境</h2>
				<p class="section-lead">明るく、学び合い、支え合うチームで保育にあたっています。</p>
			</header>

			<div class="kyujin-workplace__grid">
				<?php foreach ( $workplace as $i => $item ) : ?>
					<article class="kyujin-work-card kyujin-work-card--<?php echo esc_attr( (string) ( ( $i % 4 ) + 1 ) ); ?>">
						<p class="kyujin-work-card__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></p>
						<h3 class="kyujin-work-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="kyujin-work-card__text"><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="kyujin-links">
			<header class="section-header">
				<p class="section-eyebrow">園をもっと知る</p>
				<h2 class="section-title">あわせてご覧ください</h2>
			</header>
			<div class="kyujin-links__grid">
				<a class="kyujin-link-card" href="<?php echo esc_url( home_url( '/houshin/' ) ); ?>">
					<span class="kyujin-link-card__label">方針</span>
					<strong>園の方針と特長</strong>
					<span class="kyujin-link-card__more">詳しく見る</span>
				</a>
				<a class="kyujin-link-card" href="<?php echo esc_url( home_url( '/enseikatsu/' ) ); ?>">
					<span class="kyujin-link-card__label">園生活</span>
					<strong>園生活のようす</strong>
					<span class="kyujin-link-card__more">詳しく見る</span>
				</a>
				<a class="kyujin-link-card" href="<?php echo esc_url( home_url( '/history/' ) ); ?>">
					<span class="kyujin-link-card__label">歩み</span>
					<strong>50年の幼児教育実績</strong>
					<span class="kyujin-link-card__more">詳しく見る</span>
				</a>
			</div>
		</section>

		<section class="kyujin-access" id="access">
			<header class="section-header">
				<p class="section-eyebrow">アクセス</p>
				<h2 class="section-title">お越しの際はこちら</h2>
			</header>

			<div class="kyujin-access__panel">
				<div class="kyujin-access__main">
					<p class="kyujin-access__corp">学校法人 正栄学園</p>
					<h3 class="kyujin-access__name">湘南こども園</h3>
					<ul class="kyujin-access__list">
						<li>〒253-0113 神奈川県高座郡寒川町大曲1-1-6</li>
						<li>最寄り駅：寒川駅（徒歩約14分）／香川駅（徒歩約12分）</li>
						<li>TEL：<a href="tel:0467849229">0467-84-9229</a></li>
					</ul>
					<div class="kyujin-access__actions">
						<a class="btn btn--solid" href="tel:0467849229">お電話で問い合わせる</a>
						<?php $kyujin_poster = shonan_managed_document_url( 'kyujin' ); ?>
						<?php if ( $kyujin_poster ) : ?>
							<a class="btn btn--outline" href="<?php echo esc_url( $kyujin_poster ); ?>" target="_blank" rel="noopener noreferrer">求人案内（PDF）</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="kyujin-access__map">
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
