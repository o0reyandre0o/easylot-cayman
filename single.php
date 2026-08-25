<?php
/**
 * Single blog post.
 *
 * @package EasyLotCayman
 */

get_header();

while ( have_posts() ) :
	the_post();

	$trail = array(
		'Home'          => home_url( '/' ),
		'Blog'          => get_permalink( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' ),
		get_the_title() => get_permalink(),
	);
	add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail ) {
		$graph[] = easylot_breadcrumbs( $trail );
		$graph[] = array(
			'@type'         => 'Article',
			'@id'           => get_permalink() . '#article',
			'headline'      => get_the_title(),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'author'        => array( '@id' => home_url( '/' ) . '#organization' ),
			'publisher'     => array( '@id' => home_url( '/' ) . '#organization' ),
			'mainEntityOfPage' => array( '@id' => get_permalink() . '#webpage' ),
		);
		return $graph;
	} );
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
