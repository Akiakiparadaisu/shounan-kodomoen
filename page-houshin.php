<?php
/**
 * 固定ページ: 園の方針と特長（スラッグ: houshin）
 *
 * @package Shonan_Kodomoen
 */

get_header();
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article houshin-page">
		<header class="page-header">
			<h1 class="page-title">園の方針と特長</h1>
		</header>

		<figure class="policy-visual">
			<img
				src="<?php echo esc_url( shonan_photo( 'houshin/en-no-houshin/en-no-houshin.png' ) ); ?>"
				alt="あしたをつくる やさしい まなび — 遊び・体験・仲間の中で子どもたちの未来が育っていく"
				width="1600"
				height="1000"
				fetchpriority="high"
			>
		</figure>

		<section class="policy-intro">
			<div class="policy-pillars">
				<article class="policy-pillar">
					<p class="policy-pillar__label">モットー</p>
					<h2 class="policy-pillar__value">園児はわが子</h2>
				</article>
				<article class="policy-pillar">
					<p class="policy-pillar__label">スローガン</p>
					<h2 class="policy-pillar__value">入ってよかったといわれる園にする</h2>
				</article>
				<article class="policy-pillar">
					<p class="policy-pillar__label">経営方針</p>
					<h2 class="policy-pillar__value">保護者に必要以上の時間的・金銭的負担をかけない</h2>
				</article>
			</div>
		</section>

		<section class="policy-guidance">
			<header class="section-header">
				<p class="section-eyebrow">指導方針</p>
				<h2 class="section-title">質の高い教育・保育を実現します</h2>
				<p class="section-lead">
					５０年の歴史ある、ふじ幼児園の良き文化を継承して、「質の高い教育・保育を実現」します。
				</p>
			</header>

			<div class="policy-guidance__list">
				<article class="policy-card">
					<h3 class="policy-card__title">正しいしつけ</h3>
					<p class="policy-card__text">普遍的なふるまいを自然に身につけます。</p>
				</article>
				<article class="policy-card">
					<h3 class="policy-card__title">自立</h3>
					<p class="policy-card__text">「主体」「積極性」「機転」など、生きる力をつけます。</p>
				</article>
				<article class="policy-card">
					<h3 class="policy-card__title">体力づくり</h3>
					<p class="policy-card__text">湘南体操を基本に、楽しく体を動かします。</p>
				</article>
			</div>
		</section>

		<?php get_template_part( 'template-parts/houshin', 'tokubetsu' ); ?>
		<?php get_template_part( 'template-parts/houshin', 'pre' ); ?>

		<section class="dare-tsuen" id="daredemo-tsuen">
			<header class="section-header">
				<p class="section-eyebrow">未就園児</p>
				<h2 class="section-title">誰でも通園</h2>
			</header>

			<ul class="dare-tsuen__list">
				<li>
					<span>利用定員</span>
					<p>５名</p>
				</li>
				<li>
					<span>受け入れ条件</span>
					<p>乳児等支援支給認定証の交付を受けていること（０歳６か月～満３歳の未就園児）</p>
				</li>
				<li>
					<span>利用方法</span>
					<div>
						<p>柔軟利用（都度予約し利用する）</p>
						<ul class="dare-tsuen__steps">
							<li>
								<strong>事前登録ならびに面談が必要です。</strong>
								<p>各自治体に利用申請をして、利用認定証を受け取りましたら、お電話で面談日を決めてください。</p>
								<ul>
									<li>面談は基本お子さんも同席してください。</li>
									<li>面談予約はお電話でお願いいたします。</li>
								</ul>
							</li>
							<li>
								<strong>利用の予約はお電話でお願いいたします。</strong>
								<p>（空き定員がない場合、お断りすることもございます）</p>
							</li>
							<li>
								<strong>変更・キャンセルされる場合は、お電話でご連絡をお願いいたします。</strong>
							</li>
							<li>
								<strong>利用の無断キャンセルや度重なる予約変更等をされた場合には、施設から利用をお断りすることがあります。</strong>
							</li>
						</ul>
					</div>
				</li>
				<li>
					<span>利用日</span>
					<p>月～金</p>
				</li>
				<li>
					<span>利用時間</span>
					<p>９時～１６時（食事提供はなしのため、１２時を超えてご利用の場合はお弁当をご持参ください）</p>
				</li>
				<li>
					<span>利用料</span>
					<p>１時間当たり３００円</p>
				</li>
			</ul>

			<div class="dare-tsuen__notes">
				<p class="dare-tsuen__note-title">特別な支援が必要な子どもの受入</p>
				<ul>
					<li>障がい児、医療的ケア児に関しては原則受け入れ不可とする。</li>
					<li>外国籍のこどもに関しては、保護者と園職員の意思疎通ができれば受け入れ可能とする。</li>
				</ul>
			</div>
			<ul class="dare-tsuen__aside">
				<li>おむつは各家庭にて持参してください。</li>
				<li>当園が臨時休園になった場合は、当事業も中止する。</li>
			</ul>
			<p class="dare-tsuen__cta">
				<button type="button" class="btn btn--solid" data-junior-3d-open>建物を見る</button>
			</p>
		</section>
	</article>
</div>

<?php
get_footer();
