<?php
/**
 * A single development ("project" post type).
 *
 * These pages carry an interactive lot map supplied by a third party, embedded
 * in the page content. The template therefore prints the_content() verbatim and
 * only adds the header, breadcrumbs and a financing footer around it — nothing
 * here rewrites, wraps or constrains the embed.
 *
 * @package EasyLotCayman
 */

// Registered before get_header(), which is when wp_head prints the @graph.
$queried = get_queried_object();
$trail   = array(
	'Home'          => home_url( '/' ),
	'Land for Sale' => easylot_url( 'developments' ),
);
if ( $queried instanceof WP_Post ) {
	$trail[ get_the_title( $queried ) ] = get_permalink( $queried );
}

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail ) {
	$graph[] = easylot_breadcrumbs( $trail );
	return $graph;
} );

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<header class="page-hero">
		<div class="wrap">
			<?php easylot_the_crumbs( $trail ); ?>
			<span class="eyebrow">Development · Cayman Islands</span>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<div class="btn-row" style="margin-top:26px;">
				<a class="btn btn--primary" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get pre-approved for this development</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">How the financing works</a>
			</div>
		</div>
	</header>

	<article class="section section--paper">
		<div class="wrap">
			<!-- Third-party lot map and Elementor content: printed as authored. -->
			<div class="entry-content entry-content--full"><?php the_content(); ?></div>
		</div>
	</article>

	<?php
endwhile;
?>

<section class="section section--tight section--paper-2">
	<div class="wrap">
		<div class="cta-band">
			<h2>Like a lot on the map?</h2>
			<p>Get pre-approved first so you know your price range and monthly payment, then reserve it. Five minutes, four documents, no obligation.</p>
			<div class="btn-row btn-row--center" style="margin-top:28px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Start my pre-approval</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
