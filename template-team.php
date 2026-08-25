<?php
/**
 * Template Name: Meet the Team
 *
 * The people are managed in the page content (Elementor or the block editor),
 * which is printed as authored; this template only frames it.
 *
 * @package EasyLotCayman
 */

$GLOBALS['easylot_seo_title']       = 'Meet the Easy Lot Team | Land in the Cayman Islands';
$GLOBALS['easylot_seo_description'] = 'The people behind Easy Lot: the team that handles pre-approvals, site visits and closings for owner-financed land in the Cayman Islands.';

$trail = array(
	'Home' => home_url( '/' ),
	'Team' => easylot_url( 'team' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail ) {
	$graph[] = easylot_breadcrumbs( $trail );
	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">The people</span>
		<h1>Meet the team</h1>
		<p class="lede">
			Small enough that you will speak to the same person from your first question through
			to the day the title is registered.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">
		<div class="entry-content entry-content--full">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
			?>
		</div>
	</div>
</section>

<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Ask any of us anything</h2>
			<p>A person answers, and there is nothing attached to asking.</p>
			<div class="btn-row btn-row--center" style="margin-top:28px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Contact the team</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
