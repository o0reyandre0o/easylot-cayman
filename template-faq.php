<?php
/**
 * Template Name: FAQ
 *
 * @package EasyLotCayman
 */

$faqs = easylot_faqs();
$c    = easylot_contact();

$GLOBALS['easylot_seo_title']       = 'Owner Financing FAQ — Buying Land in the Cayman Islands | Easy Lot';
$GLOBALS['easylot_seo_description'] = 'Answers on buying land in the Cayman Islands without a bank: down payments from 5%, fixed monthly payments, the four documents you need, AML, stamp duty, foreign ownership and title transfer.';

$trail = array(
	'Home' => home_url( '/' ),
	'FAQ'  => easylot_url( 'faq' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $faqs ) {
	$graph[] = easylot_breadcrumbs( $trail );
	$graph[] = easylot_faq_schema_node( $faqs );
	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Straight answers</span>
		<h1>Financing &amp; land-buying <span class="accent">FAQ</span></h1>
		<p class="lede">
			The questions we are asked every week about buying land in the Cayman Islands with
			direct owner financing — answered in full, with nothing held back for a phone call.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap-narrow">
		<div class="faq">
			<?php foreach ( $faqs as $i => $f ) : ?>
				<div class="faq__item<?php echo 0 === $i ? ' is-open' : ''; ?>">
					<div class="faq__q" role="button" tabindex="0" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
						<span><?php echo esc_html( $f['q'] ); ?></span>
						<span class="faq__ic"><?php easylot_the_icon( 'plus' ); ?></span>
					</div>
					<div class="faq__a"<?php echo 0 === $i ? ' style="max-height:600px"' : ''; ?>>
						<div><?php echo esc_html( $f['a'] ); ?></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Rather watch?</span>
			<h2>The same answers, on video</h2>
		</div>
		<?php easylot_video_grid( easylot_videos( array( 'category' => 'financing' ) ), array( 'cols' => 4 ) ); ?>
		<div class="btn-row btn-row--center" style="margin-top:40px;">
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">All video guides</a>
		</div>
	</div>
</section>

<section class="section section--tight section--paper">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Question not answered here?</h2>
			<p>Message us on WhatsApp or call the office — a person answers, and there is no obligation attached to asking.</p>
			<div class="btn-row btn-row--center" style="margin-top:28px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">Ask on WhatsApp</a>
				<a class="btn btn--ghost btn--lg" style="color:#fff;border-color:rgba(255,255,255,.5)" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
