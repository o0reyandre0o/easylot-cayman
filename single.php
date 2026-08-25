<?php
/**
 * Single blog post.
 *
 * @package EasyLotCayman
 */

// Registered before get_header(), which is when wp_head prints the @graph.
$queried   = get_queried_object();
$blog_page = get_option( 'page_for_posts' );
$blog_url  = $blog_page ? get_permalink( $blog_page ) : home_url( '/blog/' );

$trail = array(
	'Home' => home_url( '/' ),
	'Blog' => $blog_url,
);
if ( $queried instanceof WP_Post ) {
	$trail[ get_the_title( $queried ) ] = get_permalink( $queried );
}

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $queried ) {
	$graph[] = easylot_breadcrumbs( $trail );

	if ( $queried instanceof WP_Post ) {
		$graph[] = array(
			'@type'            => 'Article',
			'@id'              => get_permalink( $queried ) . '#article',
			'headline'         => get_the_title( $queried ),
			'datePublished'    => get_the_date( 'c', $queried ),
			'dateModified'     => get_the_modified_date( 'c', $queried ),
			'author'           => array( '@id' => home_url( '/' ) . '#organization' ),
			'publisher'        => array( '@id' => home_url( '/' ) . '#organization' ),
			'mainEntityOfPage' => array( '@id' => get_permalink( $queried ) . '#webpage' ),
		);
	}

	return $graph;
} );

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<header class="page-hero">
		<div class="wrap-narrow">
			<?php easylot_the_crumbs( $trail ); ?>
			<h1><?php the_title(); ?></h1>
			<p style="color:var(--ink-55);font-size:.9rem;font-weight:600;">
				<?php echo esc_html( get_the_date() ); ?>
			</p>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="wrap" style="margin-top:36px;">
			<div style="border-radius:var(--radius-l);overflow:hidden;">
				<?php the_post_thumbnail( 'full', array( 'loading' => 'eager' ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<article class="section section--paper">
		<div class="wrap">
			<div class="entry-content"><?php the_content(); ?></div>
		</div>
	</article>

	<?php
endwhile;

get_footer();
