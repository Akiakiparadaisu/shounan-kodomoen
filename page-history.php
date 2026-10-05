<?php
/**
 * 固定ページ: 50年の幼児教育実績（スラッグ: history）
 *
 * @package Shonan_Kodomoen
 */

get_header();

$guidance = array(
	array(
		'title' => '正しいしつけ',
		'text'  => '生活習慣は人間の基本です。幼児期に身につけるべきしつけを習得し、豊かな人間形成を目指しました。',
	),
	array(
		'title' => '自立',
		'text'  => '「自分のことは自分で」「自分の考えをはっきり言う」を毎日繰り返し、ひとり立ちの力を育てました。',
	),
	array(
		'title' => '体力づくり',
		'text'  => '体育指導やはだし遊びを通して、健康で忍耐強い心と体づくりを大切にしました。',
	),
);

$activities = array(
	array(
		'title' => '重点保育項目',
		'text'  => '毎年テーマを決め、自己研修・発表・実践・成果発表までを一連で行う取り組みです。保育内容と保育者の力を高め、35年間続く園の軸となりました。',
	),
	array(
		'title' => '親睦会',
		'text'  => '旅行や交流を通して職員同士の絆を深めました。名古屋・福岡・韓国など、さまざまな場所へ出かけた経験もあります。',
	),
	array(
		'title' => '永年勤続',
		'text'  => '該当者には、当時としては珍しい海外旅行（ハワイやグアムなど）を贈るなど、長く働く職員を大切にしてきました。',
	),
);

$achievements = array(
	array(
		'title' => '親への配慮の心を育てる',
		'lead'  => '保育士の取り組みが、子どもの行動に変化をもたらす',
		'text'  => '親への配慮の心を育てるため、子どもたちに親の話を毎日するように伝えました。3か月後、「最近、子どもが親を気遣ってくれるようになった」との声をいただきました。',
	),
	array(
		'title' => '虫歯予防で健康的な歯に',
		'lead'  => '幼少期から適切な歯磨き習慣を',
		'text'  => '当時はボランティアによる歯磨き指導から始まりました。継続は難しい面もありましたが、現在の湘南こども園では「むし歯０活動」として取り組みを続けています。',
	),
	array(
		'title' => '科学への興味を引き出す',
		'lead'  => '食い入るような子どもの視線に驚愕',
		'text'  => '磁石や豆電球などを使った簡単な実験を行い、担当の先生から毎年レポートが出されました。幼児期から理科の面白さに触れた子どもたちの目は、とても輝いていました。',
	),
	array(
		'title' => '日本の伝統文化を体験',
		'lead'  => '茶道とそろばん指導を通じた保育',
		'text'  => '専門の先生をお招きし、茶道・そろばんを通じて日本の伝統文化を体験する機会をつくりました。',
		'image' => 'history/history4_otya.jpg',
	),
);

$media = array(
	array(
		'title'    => '科学探検隊',
		'sections' => array(
			array(
				'label' => 'テレビ',
				'items' => array(
					array(
						'text' => '8ch【2005年10月】長野放送（子ども理科教室）',
						'url'  => 'https://youtu.be/6ZF-5Rfudfo',
					),
					array(
						'text' => '11ch【2005年12月】飯田ケーブルテレビ（カイトプレーンの紹介・こども科学工作教室）',
						'url'  => '',
					),
				),
			),
			array(
				'label' => '新聞',
				'items' => array(
					array(
						'text' => '【2002年12月】信州日報（公民館子ども理科教室）',
						'file' => 'history/katsudo/kagakutankentai/200212信州日報.pdf',
					),
					array(
						'text' => '【2003年6月】読売新聞（科学教室）',
						'file' => 'history/katsudo/kagakutankentai/200206読売新聞.pdf',
					),
					array(
						'text' => '【2003年6月】相模経済新聞（大和小の科学教室）',
						'file' => 'history/katsudo/kagakutankentai/200306相模経済新聞.pdf',
					),
					array(
						'text' => '【2006年1月】龍江新聞（子供理科教室でカイトプレーン作り）',
						'file' => 'history/katsudo/kagakutankentai/200601龍江.pdf',
					),
				),
			),
		),
	),
	array(
		'title'    => '自社開発製品',
		'sections' => array(
			array(
				'label' => 'テレビ',
				'items' => array(
					array(
						'text' => '1ch【2009年5月】NHKニュース（プラネタリウムの紹介）',
						'url'  => 'https://youtu.be/XhtHv5EIeto',
					),
					array(
						'text' => '4ch【2007年7月】日本テレビ（プラネタリウムの紹介）',
						'url'  => '',
					),
					array(
						'text' => '7ch【2008年12月】テレビ東京（Talking Photo）',
						'url'  => '',
					),
					array(
						'text' => '8ch【2005年10月】テレビ西日本（ホバークラフトの紹介）',
						'url'  => '',
					),
				),
			),
			array(
				'label' => 'ラジオ',
				'items' => array(
					array(
						'text' => '【2011年1月】FM大和（プラネタリウムの紹介）',
						'url'  => '',
					),
				),
			),
			array(
				'label' => '新聞',
				'items' => array(
					array(
						'text' => '【2008年12月】日経MJ（プラネタリウムの紹介）',
						'file' => 'history/katsudo/zibura/200812日経MJ.pdf',
					),
					array(
						'text' => '【2008年8月】北海道新聞（プラネタリウムの紹介）',
						'file' => 'history/katsudo/zibura/200808北海道新聞.pdf',
					),
				),
			),
		),
	),
);

$katsudo_pdf = shonan_document( 'history/katsudo/item_31.pdf' );
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article history-page">
		<header class="page-header history-header">
			<p class="history-era">ふじ幼児園から 湘南こども園へ</p>
			<h1 class="page-title">50年の幼児教育実績</h1>
		</header>

		<figure class="policy-visual history-visual">
			<img
				src="<?php echo esc_url( shonan_photo( 'history/history_top.png' ) ); ?>"
				alt="50年の幼児教育実績"
				width="1600"
				height="1000"
				fetchpriority="high"
			>
		</figure>

		<nav class="history-timeline" aria-label="沿革のあらまし" data-scroll-unroll>
			<div class="history-scroll">
				<span class="history-scroll__rod history-scroll__rod--start" aria-hidden="true"></span>
				<div class="history-scroll__stage">
					<div class="history-scroll__sheet">
						<p class="history-scroll__title">歩み</p>
						<ol class="history-timeline__list">
							<li>
								<span class="history-timeline__mark">始まり</span>
								<strong>創設の想い</strong>
								<em>幼児教育への決意</em>
							</li>
							<li>
								<span class="history-timeline__mark">開園直後</span>
								<strong>園児 13名</strong>
								<em>公園での説明から</em>
							</li>
							<li>
								<span class="history-timeline__mark">成長</span>
								<strong>週２日クラス・重点保育項目の導入</strong>
								<em>当時としては珍しい試み</em>
							</li>
							<li>
								<span class="history-timeline__mark">35年目</span>
								<strong>園児 217名</strong>
								<em>大きな実り</em>
							</li>
							<li>
								<span class="history-timeline__mark">いま</span>
								<strong>こども園へ</strong>
								<em>50年の実績</em>
							</li>
						</ol>
					</div>
				</div>
				<span class="history-scroll__rod history-scroll__rod--end" aria-hidden="true"></span>
			</div>
		</nav>

		<section class="history-origin history-chapter" id="why-started">
			<header class="section-header history-section-head">
				<h2 class="section-title">なぜ幼児教育を始めたのか？</h2>
			</header>

			<div class="history-compare">
				<figure class="history-compare__item history-compare__item--past">
					<div class="history-compare__frame history-photo history-photo--vintage">
						<img src="<?php echo esc_url( shonan_photo( 'history/why-started/history1.jpg' ) ); ?>" alt="当時のふじ幼児園" loading="lazy">
					</div>
					<figcaption><span>当時</span>ふじ幼児園</figcaption>
				</figure>
				<figure class="history-compare__item history-compare__item--now">
					<div class="history-compare__frame history-photo">
						<img src="<?php echo esc_url( shonan_photo( 'history/why-started/history2.jpg' ) ); ?>" alt="現在のこども園" loading="lazy">
					</div>
					<figcaption><span>現在</span>湘南こども園</figcaption>
				</figure>
			</div>

			<div class="history-story">
				<p class="history-story__quote">30年抱き続けた夢が、幼児教育への一歩になりました。</p>
				<p>技術者である創設者が20歳のとき、社会の犯罪率の高さに危機感を抱き、将来の凶悪犯罪の増加を予想しました。また、社会に出た際には、成績優秀な人々が成果を上げられない状況に疑問を抱きました。</p>
				<p>これらの経験から、幼児期の教育の重要性を強く感じ、幼児教育に取り組む決心をしました。その後、30年の間夢を持ち続け、チャンスが訪れました。</p>
			</div>
		</section>

		<section class="history-policy history-chapter" id="fuji-houshin">
			<header class="section-header history-section-head">
				<h2 class="section-title">ふじ幼児園の各種方針</h2>
			</header>

			<div class="history-pillars">
				<article class="history-pillar">
					<p class="history-pillar__label">モットー</p>
					<h3 class="history-pillar__value">「入ってよかった」と言われる園にする</h3>
				</article>
				<article class="history-pillar">
					<p class="history-pillar__label">スローガン</p>
					<h3 class="history-pillar__value">園児はわが子</h3>
				</article>
				<article class="history-pillar">
					<p class="history-pillar__label">経営方針</p>
					<h3 class="history-pillar__value">極力保護者に必要以上の時間的・金銭的負担をかけない</h3>
				</article>
			</div>

			<div class="history-guidance">
				<?php foreach ( $guidance as $i => $item ) : ?>
					<article class="history-guidance__card history-guidance__card--<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="history-growth history-chapter" id="enji-kakuho">
			<header class="section-header history-section-head">
				<h2 class="section-title">園児確保の取り組み</h2>
			</header>

			<div class="history-growth__grid">
				<div class="history-growth__text">
					<p>園を引き受けた当初、園児はわずか13名でした。毎週土曜日に公園で保育内容の説明を行い、幼児教育に熱心な人の評判が広がり、興味を持った保護者が来園するようになりました。</p>
					<p>当時では珍しい3年保育クラスや、日本初と思われる週2日クラスを開設し、重点保育項目を取り入れた保育を行いました。園舎は掘っ立て小屋に等しい状態から、何度も増築・改修を重ねました。</p>
					<p>指導者の計画と園長・職員の努力、ご理解いただいた保護者のおかげで、他園が教室を縮小していく時期にも、当園は毎年教室を増やすことができました。体育館は2回の移転増築を行い、個人の持ち出しとテクノシステムズ（現：湘南保育）の繰り入れで支えました。</p>
					<p class="history-growth__highlight">これらの努力により、園児数は当初の13名から200名を超える規模へ成長しました。</p>
				</div>
				<figure class="history-growth__media history-photo history-photo--vintage">
					<img src="<?php echo esc_url( shonan_photo( 'history/enji-kakuho/history3.jpg' ) ); ?>" alt="園児確保の取り組み" loading="lazy">
				</figure>
			</div>

			<figure class="history-chart" data-enji-chart>
				<svg class="history-chart__svg" viewBox="0 0 720 420" role="img" aria-label="園児数の推移。13人、43人、47人、80人、35年目に217人">
					<defs>
						<linearGradient id="enjiFill" x1="0" y1="0" x2="0" y2="1">
							<stop offset="0%" stop-color="#2f8fd4" stop-opacity="0.42" />
							<stop offset="72%" stop-color="#7ec8e3" stop-opacity="0.08" />
							<stop offset="100%" stop-color="#7ec8e3" stop-opacity="0" />
						</linearGradient>
						<linearGradient id="enjiStroke" x1="0" y1="1" x2="1" y2="0">
							<stop offset="0%" stop-color="#8fd4ef" />
							<stop offset="45%" stop-color="#2f86cf" />
							<stop offset="100%" stop-color="#163e78" />
						</linearGradient>
						<filter id="enjiGlow" x="-20%" y="-40%" width="140%" height="180%">
							<feGaussianBlur stdDeviation="4" result="blur" />
							<feMerge>
								<feMergeNode in="blur" />
								<feMergeNode in="SourceGraphic" />
							</feMerge>
						</filter>
						<clipPath id="enjiReveal">
							<rect class="enji-reveal" x="70" y="0" width="0" height="420" />
						</clipPath>
					</defs>

					<g class="enji-grid" aria-hidden="true">
						<line x1="96" y1="268" x2="650" y2="268" />
						<line x1="96" y1="198" x2="650" y2="198" />
						<line x1="96" y1="128" x2="650" y2="128" />
					</g>

					<line class="enji-axis" x1="96" y1="46" x2="96" y2="336" />
					<line class="enji-axis" x1="96" y1="336" x2="668" y2="336" />
					<polyline class="enji-axis" points="90,60 96,46 102,60" />
					<polyline class="enji-axis" points="654,330 668,336 654,342" />
					<text class="enji-axis-label" x="40" y="196" transform="rotate(-90 40 196)">園児数</text>

					<g clip-path="url(#enjiReveal)">
						<path class="enji-area" d="M132 312 C171 301 208 285 248 278 C288 271 333 279 372 272 C411 265 446 264 482 234 C518 204 554 139 590 92 L590 336 L132 336 Z" />
						<path class="enji-line-glow" d="M132 312 C171 301 208 285 248 278 C288 271 333 279 372 272 C411 265 446 264 482 234 C518 204 554 139 590 92" />
						<path class="enji-line" d="M132 312 C171 301 208 285 248 278 C288 271 333 279 372 272 C411 265 446 264 482 234 C518 204 554 139 590 92" />
					</g>

					<path class="enji-sheen" d="M132 312 C171 301 208 285 248 278 C288 271 333 279 372 272 C411 265 446 264 482 234 C518 204 554 139 590 92" />
					<line class="enji-drop" x1="590" y1="92" x2="590" y2="336" />

					<g class="enji-point" style="--d:0.18s">
						<circle class="enji-dot" cx="132" cy="312" r="7" />
						<text class="enji-label" x="118" y="296" text-anchor="end"><tspan class="enji-num" data-n="13" data-delay="0.18">13</tspan>人</text>
					</g>
					<g class="enji-point" style="--d:0.55s">
						<circle class="enji-dot" cx="248" cy="278" r="7" />
						<text class="enji-label" x="214" y="308"><tspan class="enji-num" data-n="43" data-delay="0.55">43</tspan>人</text>
					</g>
					<g class="enji-point" style="--d:0.95s">
						<circle class="enji-dot" cx="372" cy="272" r="7" />
						<text class="enji-label" x="388" y="258"><tspan class="enji-num" data-n="47" data-delay="0.95">47</tspan>人</text>
					</g>
					<g class="enji-point" style="--d:1.3s">
						<circle class="enji-dot" cx="482" cy="234" r="7" />
						<text class="enji-label" x="496" y="220"><tspan class="enji-num" data-n="80" data-delay="1.3">80</tspan>人</text>
					</g>
					<g class="enji-point enji-point--peak" style="--d:1.72s">
						<circle class="enji-ring" cx="590" cy="92" r="16" />
						<circle class="enji-dot enji-dot--peak" cx="590" cy="92" r="8" />
						<g class="enji-badge">
							<rect x="522" y="40" width="108" height="36" rx="18" />
							<text x="576" y="64" text-anchor="middle"><tspan class="enji-num" data-n="217" data-delay="1.72">217</tspan>人</text>
						</g>
					</g>
					<text class="enji-year" x="590" y="368">35年目</text>
				</svg>
				<figcaption>園児数の推移（開始時13人 → 35年目217人）</figcaption>
			</figure>
		</section>

		<section class="history-support history-chapter" id="katsudo">
			<header class="section-header history-section-head">
				<h2 class="section-title">園を支えた活動</h2>
			</header>

			<div class="history-support__grid">
				<?php foreach ( $activities as $i => $item ) : ?>
					<article class="history-support__card history-support__card--<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
						<p class="history-support__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></p>
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>

			<?php if ( $katsudo_pdf ) : ?>
				<p class="history-download">
					<a class="btn btn--solid" href="<?php echo esc_url( $katsudo_pdf ); ?>" target="_blank" rel="noopener">重点保育項目を見る</a>
				</p>
			<?php endif; ?>
		</section>

		<section class="history-achievements history-chapter" id="jisseki">
			<header class="section-header history-section-head">
				<h2 class="section-title">園の実績 — 子どもたちの変化と体験</h2>
			</header>

			<div class="history-achievements__list">
				<?php foreach ( $achievements as $i => $item ) : ?>
					<article class="history-achi history-achi--<?php echo esc_attr( (string) ( ( $i % 4 ) + 1 ) ); ?>">
						<div class="history-achi__body">
							<h3 class="history-achi__title"><?php echo esc_html( $item['title'] ); ?></h3>
							<p class="history-achi__lead"><?php echo esc_html( $item['lead'] ); ?></p>
							<p class="history-achi__text"><?php echo esc_html( $item['text'] ); ?></p>
						</div>
						<?php if ( ! empty( $item['image'] ) ) : ?>
							<figure class="history-achi__media">
								<img src="<?php echo esc_url( shonan_photo( $item['image'] ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
							</figure>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="history-founders history-chapter" id="unei">
			<header class="section-header history-section-head">
				<h2 class="section-title">ふじ幼児園50年の幼児教育運営者</h2>
			</header>

			<div class="history-founders__intro">
				<p>林正幸（元ふじ幼児園経営者、現学校法人正栄学園理事長）と林 榮（元ふじ幼児園園長、現学校法人正栄学園名誉理事長）の2人3脚で歩んできました。経営者が企画立案し、園長が実践。先を見た企画と現場の保育をつなぎ、スムーズな運営と新しいアイデアの実践に力を注いできました。</p>
			</div>

			<div class="history-founders__grid">
				<article class="history-founder">
					<p class="history-founder__role">経営</p>
					<h3 class="history-founder__name">林 正幸</h3>
					<p>電子工学技術者。大手電機メーカーで防衛システム開発に携わりながら幼児教育を始め、53歳で退職後、テクノシステムズ（現：湘南保育）を創立。技術開発事業と幼児教育を推進してきました。</p>
					<ul>
						<li>4保育園・こども園の経営</li>
						<li>技術会社 代表取締役</li>
						<li>NPO法人科学探検隊 理事長（日本ほか7か国・延べ5,500名の小学生へ理科教室）</li>
						<li>林財団を設立し、地域・教育支援を実施</li>
					</ul>
				</article>
				<article class="history-founder">
					<p class="history-founder__role">実践</p>
					<h3 class="history-founder__name">林 榮</h3>
					<p>現場の保育と新しい企画をつなぐ役割を担い、職員と子どもたちに寄り添いながら園を育ててきました。</p>
					<ul>
						<li>ふじ幼児園 園長</li>
						<li>寒川湘南保育園 園長</li>
						<li>つきみ野湘南保育園 園長</li>
					</ul>
				</article>
			</div>
		</section>

		<section class="history-npo history-chapter" id="kagaku">
			<header class="section-header history-section-head">
				<h2 class="section-title">NPO法人科学探検隊 — 海外での活動</h2>
			</header>

			<div class="history-npo__grid">
				<figure class="history-npo__item">
					<div class="history-npo__frame history-photo">
						<img src="<?php echo esc_url( shonan_photo( 'history/myanma.jpg' ) ); ?>" alt="ミャンマーでの理科教室" loading="lazy">
					</div>
					<figcaption><time datetime="2016-07-26">2016.07.26</time> ミャンマーで理科教室を開催したときの教育省幹部・学校職員</figcaption>
				</figure>
				<figure class="history-npo__item">
					<div class="history-npo__frame history-photo">
						<img src="<?php echo esc_url( shonan_photo( 'history/saharin.jpg' ) ); ?>" alt="ロシア（サハリン）での説明" loading="lazy">
					</div>
					<figcaption><time datetime="2013-10-08">2013.10.08</time> ロシア（サハリン）で園長先生への日本教育の説明</figcaption>
				</figure>
			</div>
		</section>

		<section class="history-media history-chapter" id="media">
			<header class="section-header history-section-head">
				<h2 class="section-title">メディアで取り上げられた活動</h2>
				<p class="section-lead">科学探検隊や自社開発製品（プラネタリウム等）が、さまざまなメディアで紹介されました。</p>
			</header>

			<div class="history-media__grid">
				<?php foreach ( $media as $i => $block ) : ?>
					<article class="history-media__card history-media__card--<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
						<h3 class="history-media__title"><?php echo esc_html( $block['title'] ); ?></h3>

						<?php foreach ( $block['sections'] as $section ) : ?>
							<div class="history-media__section">
								<p class="history-media__label"><?php echo esc_html( $section['label'] ); ?></p>
								<ul>
									<?php foreach ( $section['items'] as $row ) : ?>
										<?php
										$clip = '';
										if ( ! empty( $row['file'] ) ) {
											$rel  = ltrim( str_replace( '\\', '/', $row['file'] ), '/' );
											$full = SHONAN_THEME_DIR . '/assets/images/photos/' . $rel;
											if ( file_exists( $full ) ) {
												$parts = array_map( 'rawurlencode', explode( '/', $rel ) );
												$clip  = SHONAN_THEME_URI . '/assets/images/photos/' . implode( '/', $parts );
											}
										}
										?>
										<li>
											<span><?php echo esc_html( $row['text'] ); ?></span>
											<?php if ( ! empty( $row['url'] ) ) : ?>
												<a
													class="history-media__video"
													href="<?php echo esc_url( $row['url'] ); ?>"
													target="_blank"
													rel="noopener noreferrer"
												>動画を見る</a>
											<?php endif; ?>
											<?php if ( $clip ) : ?>
												<a
													class="history-media__clip"
													href="<?php echo esc_url( $clip ); ?>"
													target="_blank"
													rel="noopener noreferrer"
												>記事を見る</a>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endforeach; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="history-contact">
			<div class="history-contact__inner">
				<h2 class="history-contact__title">お問い合わせ</h2>
				<p>園の歩みや取り組みについて、ご質問がありましたらお気軽にご連絡ください。</p>
				<ul class="history-contact__list">
					<li>TEL：<a href="tel:0467849229">0467-84-9229</a></li>
					<li>〒253-0113 神奈川県高座郡寒川町大曲1-1-6</li>
				</ul>
			</div>
		</section>
	</article>
</div>

<script>
(function () {
  var el = document.querySelector('[data-scroll-unroll]');
  if (!el || el.dataset.unrollBound === '1') return;
  el.dataset.unrollBound = '1';

  var started = false;
  function openScroll() {
    if (started) return;
    started = true;
    // 閉じた巻物を見せてから開く
    window.requestAnimationFrame(function () {
      window.setTimeout(function () {
        el.classList.add('is-unrolled');
      }, 180);
    });
  }

  function isInView() {
    var r = el.getBoundingClientRect();
    var vh = window.innerHeight || document.documentElement.clientHeight;
    // 画面の中ほど付近に入ったら開く（画面外で先に開かない）
    return r.top < vh * 0.72 && r.bottom > vh * 0.18;
  }

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting && entry.intersectionRatio >= 0.2) {
            openScroll();
            io.disconnect();
          }
        });
      },
      { threshold: [0.2, 0.35, 0.5] }
    );
    io.observe(el);
  }

  function onScrollCheck() {
    if (isInView()) {
      openScroll();
      window.removeEventListener('scroll', onScrollCheck);
      window.removeEventListener('resize', onScrollCheck);
    }
  }

  window.addEventListener('scroll', onScrollCheck, { passive: true });
  window.addEventListener('resize', onScrollCheck);
  window.setTimeout(onScrollCheck, 50);
})();

(function () {
  var fig = document.querySelector('[data-enji-chart]');
  if (!fig) return;

  function play() {
    if (fig.getAttribute('data-counted') === '1') return;
    fig.setAttribute('data-counted', '1');
    fig.querySelectorAll('[data-n]').forEach(function (el) {
      var target = parseInt(el.getAttribute('data-n'), 10) || 0;
      var delay = (parseFloat(el.getAttribute('data-delay')) || 0) * 1000;
      var dur = 700;
      var start = performance.now();
      el.textContent = '0';
      function tick(now) {
        var t = (now - start - delay) / dur;
        if (t < 0) {
          window.requestAnimationFrame(tick);
          return;
        }
        if (t > 1) t = 1;
        var eased = 1 - Math.pow(1 - t, 3);
        el.textContent = String(Math.round(target * eased));
        if (t < 1) window.requestAnimationFrame(tick);
      }
      window.requestAnimationFrame(tick);
    });
  }

  function watch() {
    if (fig.classList.contains('is-visible')) {
      play();
      return;
    }
    var mo = new MutationObserver(function () {
      if (fig.classList.contains('is-visible')) {
        play();
        mo.disconnect();
      }
    });
    mo.observe(fig, { attributes: true, attributeFilter: ['class'] });
    window.setTimeout(function () {
      if (!fig.classList.contains('reveal')) play();
    }, 1500);
  }

  watch();
})();
</script>

<?php
get_footer();
