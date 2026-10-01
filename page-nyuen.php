<?php
/**
 * 固定ページ: 入園のご希望の方へ（スラッグ: nyuen）
 *
 * 毎年変わる項目は「外観 → 入園募集の設定」で編集。
 * 対象児の生年月日は募集年度から自動計算。
 *
 * @package Shonan_Kodomoen
 */

get_header();

$settings = shonan_get_admission_settings();
$year     = shonan_admission_year( $settings );
$targets  = shonan_admission_targets( $settings );
$outfits  = shonan_nyuen_outfit_groups();
$pre_url  = get_page_by_path( 'pre-hoiku' )
	? home_url( '/pre-hoiku/' )
	: home_url( '/houshin/#pre-hoiku' );
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article nyuen-page">
		<header class="page-header">
			<h1 class="page-title">入園のご希望の方へ</h1>
			<p class="nyuen-lead">湘南こども園での新しい生活を、いっしょに始めませんか。見学・説明会・願書の流れをご案内します。</p>
		</header>

		<section class="nyuen-appeal" id="zehi-shounan">
			<header class="section-header">
				<p class="section-eyebrow">ぜひ、湘南こども園へ</p>
				<h2 class="section-title">大切にしていること</h2>
			</header>
			<div class="nyuen-appeal__grid">
				<article class="nyuen-appeal__card">
					<h3 class="nyuen-appeal__title">安心安全を基盤とした保育環境</h3>
					<p>子どもたちが安心して過ごせるよう、衛生管理と安全対策を徹底しています。防犯カメラの設置や定期的な避難訓練など、万全の体制でお子さまをお守りします。</p>
				</article>
				<article class="nyuen-appeal__card">
					<h3 class="nyuen-appeal__title">保護者と共に、子どもを真ん中に</h3>
					<p>家庭的な雰囲気の中で、一人ひとりに目が行き届く保育を実践しています。経験豊富な保育者が、親身になって成長をサポートします。</p>
				</article>
				<article class="nyuen-appeal__card">
					<h3 class="nyuen-appeal__title">園独自の特別保育と重点保育</h3>
					<p>音楽・文化・スポーツ・科学など、楽しみながら学べる多彩なプログラムで、創造力や社会性を育みます。</p>
				</article>
				<article class="nyuen-appeal__card">
					<h3 class="nyuen-appeal__title">アレルギーに配慮した給食</h3>
					<p>専任の栄養士が監修する給食は、旬の食材を取り入れた栄養バランスの良いメニューです。代替食やなかよし給食など、アレルギー対応にも細心の注意を払っています。</p>
				</article>
				<article class="nyuen-appeal__card nyuen-appeal__card--wide">
					<h3 class="nyuen-appeal__title">子どもに寄り添った保育</h3>
					<p>「園児はわが子」の理念のもと、子どもを慈しみ、保護者の思いに寄り添います。園と保護者が情報を共有し、地域に開かれた子育て支援の拠点としても役割を果たしていきます。</p>
				</article>
			</div>
		</section>

		<section class="nyuen-targets" id="taishoji-teiin">
			<header class="section-header">
				<p class="section-eyebrow">対象児／定員</p>
				<h2 class="section-title"><?php echo esc_html( shonan_admission_year_label( $year ) ); ?>の募集</h2>
				<p class="section-lead">次の生年月日のお子さまが対象です（1号認定）。</p>
			</header>
			<div class="nyuen-targets__grid">
				<?php foreach ( $targets as $i => $target ) : ?>
					<article class="nyuen-target-card nyuen-target-card--<?php echo esc_attr( (string) ( ( $i % 3 ) + 1 ) ); ?>">
						<p class="nyuen-target-card__label"><?php echo esc_html( $target['title'] ); ?></p>
						<p class="nyuen-target-card__birth"><?php echo esc_html( $target['birth']['text'] ); ?></p>
						<p class="nyuen-target-card__meta">
							<span><?php echo esc_html( $target['note'] ); ?></span>
							<strong><?php echo esc_html( $target['quota'] ); ?></strong>
						</p>
					</article>
				<?php endforeach; ?>
			</div>
			<?php $youkou = shonan_managed_document_url( 'youkou' ); ?>
			<?php if ( $youkou ) : ?>
				<p class="nyuen-targets__download">
					<a class="btn btn--outline" href="<?php echo esc_url( $youkou ); ?>" target="_blank" rel="noopener noreferrer">令和8年度 募集要項（PDF）</a>
				</p>
			<?php endif; ?>
		</section>

		<section class="nyuen-visit" id="kengaku">
			<div class="nyuen-visit__inner">
				<header class="section-header">
					<p class="section-eyebrow">園見学</p>
					<h2 class="section-title">まずは園の空気を感じてください</h2>
				</header>
				<p class="nyuen-visit__text"><?php echo esc_html( $settings['visit_lead'] ); ?></p>
				<div class="nyuen-visit__actions">
					<a class="btn btn--solid" href="tel:0467849229">TEL 0467-84-9229</a>
					<a class="btn btn--ghost" href="mailto:shounankodomoen2018@shounankodomoen.jp">メールで問い合わせる</a>
				</div>
			</div>
		</section>

		<section class="nyuen-sessions" id="nyuen-setsumeikai">
			<header class="section-header">
				<p class="section-eyebrow">入園説明会</p>
				<h2 class="section-title">日程のご案内</h2>
				<?php if ( ! empty( $settings['session_note'] ) ) : ?>
					<p class="section-lead"><?php echo esc_html( $settings['session_note'] ); ?></p>
				<?php endif; ?>
			</header>
			<div class="nyuen-sessions__grid">
				<?php foreach ( $settings['sessions'] as $i => $session ) : ?>
					<?php if ( empty( $session['date'] ) && empty( $session['time'] ) ) { continue; } ?>
					<article class="nyuen-session-card">
						<p class="nyuen-session-card__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></p>
						<h3 class="nyuen-session-card__title"><?php echo esc_html( $session['label'] ); ?></h3>
						<?php if ( ! empty( $session['date'] ) ) : ?>
							<p class="nyuen-session-card__date"><?php echo esc_html( shonan_format_reiwa_date_label( $session['date'] ) ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $session['time'] ) ) : ?>
							<p class="nyuen-session-card__time"><?php echo esc_html( $session['time'] ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
			<ul class="nyuen-sessions__meta">
				<?php if ( ! empty( $settings['session_place'] ) ) : ?>
					<li><span>開催場所</span><?php echo esc_html( $settings['session_place'] ); ?></li>
				<?php endif; ?>
				<?php if ( ! empty( $settings['session_bring'] ) ) : ?>
					<li><span>持ち物</span><?php echo esc_html( $settings['session_bring'] ); ?></li>
				<?php endif; ?>
				<li><span>お問い合わせ</span><span><a href="tel:0467849229">0467-84-9229</a>（担当事務まで）</span></li>
			</ul>
			<?php $setsumeikai = shonan_session_material_url(); ?>
			<?php if ( $setsumeikai ) : ?>
				<p class="nyuen-sessions__download">
					<a class="btn btn--solid" href="<?php echo esc_url( $setsumeikai ); ?>" target="_blank" rel="noopener noreferrer">入園説明会資料（PDF）</a>
				</p>
			<?php endif; ?>
		</section>

		<section class="nyuen-gansho" id="gansho">
			<header class="section-header">
				<p class="section-eyebrow">入園願書</p>
				<h2 class="section-title">配布・受付</h2>
			</header>
			<div class="nyuen-gansho__grid">
				<article class="nyuen-gansho__card">
					<p class="nyuen-gansho__label">願書配布</p>
					<p class="nyuen-gansho__value">
						<?php
						echo ! empty( $settings['gansho_distribute'] )
							? esc_html( shonan_format_reiwa_date_label( $settings['gansho_distribute'] ) . 'より配布' )
							: '準備中';
						?>
					</p>
				</article>
				<article class="nyuen-gansho__card">
					<p class="nyuen-gansho__label">願書受付</p>
					<p class="nyuen-gansho__value">
						<?php
						echo ! empty( $settings['gansho_accept'] )
							? esc_html( shonan_format_reiwa_date_label( $settings['gansho_accept'] ) . 'より受付' )
							: '準備中';
						?>
					</p>
				</article>
			</div>
		</section>

		<section class="nyuen-hours" id="hoiku-jikan">
			<header class="section-header">
				<p class="section-eyebrow">一日の目安</p>
				<h2 class="section-title">保育時間</h2>
			</header>

			<div class="hours-panel">
				<div class="hours-row">
					<p class="hours-row__label">登園時間</p>
					<div class="hours-row__body">
						<p class="hours-row__who">1号認定のお子さま</p>
						<p class="hours-time">9：00 ～ 9：30</p>
					</div>
				</div>

				<div class="hours-row">
					<p class="hours-row__label">降園時間</p>
					<div class="hours-row__body">
						<div class="hours-dismiss">
							<div class="hours-dismiss__block">
								<p class="hours-dismiss__title">1日保育</p>
								<ul class="hours-grade-list">
									<li><span>年少</span><strong>14：00</strong></li>
									<li><span>年中</span><strong>14：15</strong></li>
									<li><span>年長</span><strong>14：30</strong></li>
								</ul>
							</div>
							<div class="hours-dismiss__block">
								<p class="hours-dismiss__title">半日保育</p>
								<ul class="hours-grade-list">
									<li><span>年少</span><strong>11：00</strong></li>
									<li><span>年中</span><strong>11：15</strong></li>
									<li><span>年長</span><strong>11：30</strong></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="hours-row">
					<p class="hours-row__label">教育保育時間</p>
					<div class="hours-row__body">
						<div class="hours-cert">
							<p class="hours-cert__item">
								<span class="hours-cert__name">1号認定のお子さま</span>
								<span class="hours-time">9：00 ～ 14：00</span>
							</p>
							<div class="hours-cert__item hours-cert__item--stack">
								<span class="hours-cert__name">2号認定のお子さま</span>
								<ul class="hours-sublist">
									<li><span>標準</span><strong>7：00 ～ 18：00</strong><em>（19：00まで延長可）</em></li>
									<li><span>短時間</span><strong>8：00 ～ 16：00</strong></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="hours-row hours-row--last">
					<p class="hours-row__label">その他<br><span class="hours-row__label-sub">（預かり保育）</span></p>
					<div class="hours-row__body">
						<p class="hours-note">保育のある日は、19：00まで預かり保育をします。長期休業中も実施します。</p>
						<div class="hours-azukari">
							<p class="hours-azukari__title">1号認定</p>
							<ul class="hours-sublist">
								<li><span>保育時間前</span><strong>7：00 ～ 9：00</strong></li>
								<li><span>保育終了後</span><strong>14：00 ～ 19：00</strong><em>（半日保育の日は 11：00 ～ 19：00）</em></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="nyuen-outfit" id="seifuku">
			<header class="section-header">
				<p class="section-eyebrow">装いのご案内</p>
				<h2 class="section-title">制服と体操服</h2>
				<p class="section-lead">通園や活動で身につける服です。詳細・ご注文は入園面接後にご案内します。</p>
			</header>

			<?php foreach ( $outfits as $key => $group ) : ?>
				<div class="outfit-block outfit-block--<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>">
					<div class="outfit-block__head">
						<p class="outfit-block__eyebrow"><?php echo 'seifuku' === $key ? '通園のとき' : 'あそびのとき'; ?></p>
						<h3 class="outfit-block__title"><?php echo esc_html( $group['title'] ); ?></h3>
						<p class="outfit-block__lead"><?php echo esc_html( $group['lead'] ); ?></p>
					</div>

					<?php if ( ! empty( $group['images'] ) ) : ?>
						<div class="outfit-gallery">
							<?php foreach ( $group['images'] as $index => $image ) : ?>
								<figure class="outfit-gallery__item">
									<div class="outfit-gallery__frame">
										<img
											src="<?php echo esc_url( $image['url'] ); ?>"
											alt="<?php echo esc_attr( $group['title'] . 'の写真' . ( $index + 1 ) ); ?>"
											loading="lazy"
										>
									</div>
								</figure>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<p class="outfit-block__empty"><?php echo esc_html( $group['title'] ); ?>の写真は準備中です。</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</section>

		<section class="nyuen-junior" id="shonan-junior">
			<div class="nyuen-junior__inner">
				<header class="section-header">
					<p class="section-eyebrow">未就園児向け</p>
					<h2 class="section-title">湘南ジュニア</h2>
				</header>
				<p>未就園児に対して保育・教育的な環境を提供し、集団生活を通じて成長と社会性を促すプログラムです。詳しくは園の方針ページでもご紹介しています。</p>
				<p class="nyuen-junior__actions">
					<a class="btn btn--solid" href="<?php echo esc_url( $pre_url ); ?>">湘南ジュニアについて見る</a>
					<button type="button" class="btn btn--outline" data-junior-3d-open>湘南ジュニアの建物を見る</button>
					<?php $junior_poster = shonan_managed_document_url( 'junior' ); ?>
					<?php if ( $junior_poster ) : ?>
						<a class="btn btn--outline" href="<?php echo esc_url( $junior_poster ); ?>" target="_blank" rel="noopener noreferrer">湘南ジュニアのご案内（PDF）</a>
					<?php endif; ?>
				</p>
			</div>
		</section>

		<section class="nyuen-contact">
			<div class="nyuen-contact__inner">
				<h2 class="nyuen-contact__title">お気軽にお問い合わせください</h2>
				<p>入園・見学・説明会に関するご質問は、担当事務までどうぞ。</p>
				<ul class="nyuen-contact__list">
					<li>TEL：<a href="tel:0467849229">0467-84-9229</a></li>
					<li>メール：<a href="mailto:shounankodomoen2018@shounankodomoen.jp">shounankodomoen2018@shounankodomoen.jp</a></li>
					<li>〒253-0113 神奈川県高座郡寒川町大曲1-1-6</li>
				</ul>
			</div>
		</section>
	</article>
</div>
<?php get_template_part( 'template-parts/junior-3d' ); ?>

<?php
get_footer();
