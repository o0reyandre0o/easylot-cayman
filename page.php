<?php
/**
 * Generic page.
 *
 * Deliberately thin: it prints the editor's content untouched. Several pages on
 * this site (the developments, in particular) are built in Elementor and carry
 * a third-party interactive lot map, and anything this template did to that
 * markup would be something to undo later.
 *
 * @package EasyLotCayman
 */

/*
 * The breadcrumb schema has to be registered before get_header(), because that
 * is when wp_head — and with it easylot_print_schema — runs. get_queried_object()
 * gives us the page without touching the loop.
 */
$queried = get_queried_object();
$trail   = array( 'Home' => home_url( '/' ) );
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
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<article class="section section--paper">
		<div class="wrap">
			<div class="entry-content"><?php the_content(); ?></div>
		</div>
	</article>

	<?php
endwhile;

get_footer();
