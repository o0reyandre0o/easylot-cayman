<?php
/**
 * Template Name: Meet the Team
 *
 * The people, their roles and their photographs are Easy Lot's own, carried
 * over from the previous theme's template-team.php. Edit them in easylot_team()
 * in functions.php, not here.
 *
 * @package EasyLotCayman
 */

$c    = easylot_contact();
$team = easylot_team();

$GLOBALS['easylot_seo_title']       = 'Meet the Easy Lot Team | Cayman Land Experts';
$GLOBALS['easylot_seo_description'] = 'Discover the team behind Easy Lot Cayman. Experts in real estate, accessible financing, and helping families secure their future in the islands.';
$GLOBALS['easylot_seo_image']       = 'https://easylot.ky/wp-content/uploads/2023/08/Tommy-Sofield.jpg';

$trail = array(
	'Home' => home_url( '/' ),
	'Team' => easylot_url( 'team' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $team ) {
	$graph[] = easylot_breadcrumbs( $trail );

	foreach ( $team as $person ) {
		if ( empty( $person['name'] ) ) {
			continue;
		}
		$node = array(
			'@type'    => 'Person',
			'name'     => wp_strip_all_tags( $person['name'] ),
			'jobTitle' => isset( $person['role'] ) ? wp_strip_all_tags( $person['role'] ) : '',
			'worksFor' => array( '@id' => home_url( '/' ) . '#organization' ),
		);
		if ( ! empty( $person['photo'] ) ) {
			$node['image'] = $person['photo'];
		}
		$graph[] = $node;
	}

	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">The heart of Easy Lot</span>
		<h1>Meet our <span class="accent">Cayman experts</span></h1>
		<p class="lede">
			Get acquainted with the exceptional individuals whose skills, dedication and passion
			propel us forward in making land ownership accessible in the Cayman Islands.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">
				Talk to the team <?php easylot_the_icon( 'arrow' ); ?>
			</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
				<?php easylot_the_icon( 'whatsapp' ); ?> WhatsApp
			</a>
		</div>
	</div>
</header>

<!-- ============================================================ THE PEOPLE -->
<section class="section section--paper">
	<div class="wrap">
		<div class="grid grid-4">
			<?php foreach ( $team as $person ) : ?>
				<div class="person reveal">
					<?php if ( ! empty( $person['photo'] ) ) : ?>
						<img src="<?php echo esc_url( $person['photo'] ); ?>"
						     alt="<?php echo esc_attr( wp_strip_all_tags( $person['name'] ) ); ?>"
						     width="120" height="120" loading="lazy">
					<?php endif; ?>
					<h2 class="person__name"><?php echo wp_kses_post( $person['name'] ); ?></h2>
					<?php if ( ! empty( $person['role'] ) ) : ?>
						<span><?php echo wp_kses_post( $person['role'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $person['bio'] ) ) : ?>
						<p><?php echo esc_html( $person['bio'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ WHO HANDLES WHAT -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Who handles what</span>
			<h2>Four moments, and who sees you through each</h2>
			<p class="lede">
				From the first inquiry to the final handover, we are with you every step of the way.
			</p>
		</div>

		<div class="grid grid-4">
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'clock' ); ?></span>
				<h3>Pre-approval</h3>
				<p>Reads your application, works out the price range and monthly payment you qualify for, and comes back to you — usually the same business day.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'map' ); ?></span>
				<h3>Choosing a lot</h3>
				<p>Walks the map with you, drives out to the development if you are on island, and sends photographs or video of a specific parcel if you are not.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'shield' ); ?></span>
				<h3>Documents &amp; closing</h3>
				<p>Oversees the financial side and the government closing process, including the anti-money-laundering checks every Cayman land purchase must complete.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'key' ); ?></span>
				<h3>On the ground</h3>
				<p>Keeps every phase of the development running on site, so the parcel you were shown is the parcel you receive.</p>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ PAGE BODY -->
<?php
/*
 * The people above are the page's real content, carried over from the old
 * theme. A page body only prints when somebody has deliberately built one in
 * Elementor.
 */
if ( easylot_has_content() && easylot_is_built_with_elementor( get_the_ID() ) ) :
	?>
	<section class="section section--white">
		<div class="wrap">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<div class="entry-content entry-content--full"><?php the_content(); ?></div>
				<?php
			}
			?>
		</div>
	</section>
	<?php
endif;
?>

<!-- ============================================================ CTA -->
<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Work with the best in Cayman</h2>
			<p>Our team is dedicated to your success. From the first inquiry to the final handover, we are with you every step of the way.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">Explore our properties</a>
				<a class="btn btn--ghost btn--lg" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
					<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
