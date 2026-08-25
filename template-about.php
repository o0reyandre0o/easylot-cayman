<?php
/**
 * Template Name: About Us
 *
 * @package EasyLotCayman
 */

$c = easylot_contact();

$GLOBALS['easylot_seo_title']       = 'About Easy Lot &mdash; Owner-Financed Land in the Cayman Islands';
$GLOBALS['easylot_seo_description'] = 'Easy Lot owns and finances land in Grand Cayman and Little Cayman, so buyers can own a lot without a bank. Here is who we are and how we work.';

$trail = array(
	'Home'  => home_url( '/' ),
	'About' => easylot_url( 'about' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail ) {
	$graph[] = easylot_breadcrumbs( $trail );
	$graph[] = array(
		'@type' => 'AboutPage',
		'@id'   => easylot_url( 'about' ) . '#aboutpage',
		'about' => array( '@id' => home_url( '/' ) . '#organization' ),
	);
	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Who we are</span>
		<h1>We own the land, so we can <span class="accent">finance it ourselves</span></h1>
		<p class="lede">
			Easy Lot exists because the ordinary route to owning land in the Cayman Islands
			&mdash; find a lot, ask a bank &mdash; stops most people at the second step. We removed
			the second step.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">
		<div class="entry-content">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
			?>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">How we work</span>
			<h2>Three things we do differently</h2>
		</div>
		<div class="grid grid-3">
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'bank' ); ?></span>
				<h3>We are the lender</h3>
				<p>No bank sits between you and the title. That is what lets the deposit start at 5% and the answer arrive the same day.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'doc' ); ?></span>
				<h3>Four documents, not forty</h3>
				<p>Passport, ID, job letter, utility bill. We look at whether the monthly payment fits your life, not at a credit score.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'shield' ); ?></span>
				<h3>Fixed, and written down</h3>
				<p>The payment does not move with rates, there is no early-settlement penalty, and every figure is in the agreement before you sign.</p>
			</div>
		</div>
	</div>
</section>

<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">In our own words</span>
			<h2>The short version, on video</h2>
		</div>
		<?php easylot_video_grid( easylot_videos( array( 'featured' => true ) ), array( 'cols' => 4 ) ); ?>
	</div>
</section>

<section class="section section--tight section--paper">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Come and see the land</h2>
			<p>Book a site visit, or start with a free pre-approval so you know your range before you walk a lot.</p>
			<div class="btn-row btn-row--center" style="margin-top:28px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get pre-approved</a>
				<a class="btn btn--ghost btn--lg" style="color:#fff;border-color:rgba(255,255,255,.5)" href="<?php echo esc_url( easylot_url( 'directions' ) ); ?>">Find our office</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
