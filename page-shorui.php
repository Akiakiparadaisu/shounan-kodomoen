<?php
/**
 * 固定ページ: 在園の保護者へ（スラッグ: shorui）
 *
 * @package Shonan_Kodomoen
 */

get_header();

$docs = array(
	array(
		'key'   => 'yoyaku',
		'title' => '与薬依頼書',
		'note'  => '園では原則として与薬は行いません。ただし、保育時間内の服用がどうしても必要な場合は医師の指示に基づいた薬に限定し、園で与薬を行います。',
		'alert' => '',
	),
	array(
		'key'   => 'chiyu',
		'title' => '治療証明書',
		'note'  => '登園初日の朝に職員に手渡してください。',
		'alert' => '保護者が記入する書類です。',
	),
	array(
		'key'   => 'toen',
		'title' => '登園許可基準',
		'note'  => '感染症にり患した場合「感染症の登園基準」をご参照ください。',
		'alert' => '治癒後に登園の際は治癒証明書（保護者記入のもの）の提出をお願いいたします。',
	),
);
?>

<div class="page-shell">
	<?php shonan_breadcrumb(); ?>

	<article class="page-article shorui-page">
		<header class="page-header">
			<h1 class="page-title">在園の保護者へ</h1>
			<p class="section-lead">在園中のご家庭向けのご案内です。</p>
		</header>

		<section class="shorui-docs">
			<header class="section-header">
				<h2 class="section-title">こども園の保護者の方に関する資料</h2>
			</header>

		<ul class="doc-list">
			<?php foreach ( $docs as $doc ) : ?>
				<?php $url = shonan_managed_document_url( $doc['key'] ); ?>
				<?php if ( ! $url ) { continue; } ?>
				<li class="doc-list__item">
					<h2 class="doc-list__title"><?php echo esc_html( $doc['title'] ); ?></h2>
					<p class="doc-list__note"><?php echo esc_html( $doc['note'] ); ?></p>
					<?php if ( ! empty( $doc['alert'] ) ) : ?>
						<p class="doc-list__alert">※<?php echo esc_html( $doc['alert'] ); ?></p>
					<?php endif; ?>
					<a class="btn doc-list__btn" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">PDFを表示する</a>
				</li>
			<?php endforeach; ?>
		</ul>
		</section>
	</article>
</div>

<?php
get_footer();
