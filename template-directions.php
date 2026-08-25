<?php
/**
 * Template Name: Directions
 *
 * The route is Easy Lot's own, carried over from the previous theme's
 * template-directions.php: Health City is the landmark, then High Rock Drive.
 * Edit it in easylot_route() in functions.php, not here.
 *
 * @package EasyLotCayman
 */

$c     = easylot_contact();
$route = easylot_route();

$GLOBALS['easylot_seo_title']       = 'Visit Easy Lot Cayman | Directions to Our Developments';
$GLOBALS['easylot_seo_description'] = 'Get precise directions to our land developments in Grand Cayman and Little Cayman. Located near landmarks like Health City for easy access.';

$trail = array(
	'Home'       => home_url( '/' ),
	'Directions' => easylot_url( 'directions' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $route ) {
	$graph[] = easylot_breadcrumbs( $trail );

	$steps = array();
	$i     = 1;
	foreach ( $route as $step ) {
		$steps[] = array(
			'@type'    => 'HowToStep',
			'position' => $i++,
			'name'     => $step['name'],
			'text'     => $step['text'],
		);
	}
	$graph[] = array(
		'@type'       => 'HowTo',
		'@id'         => easylot_url( 'directions' ) . '#howto',
		'name'        => 'How to find Easy Lot developments',
		'description' => 'Driving directions to the Easy Lot developments on High Rock Drive, East End, Grand Cayman, using Health City as the landmark.',
		'step'        => $steps,
	);

	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">On the way to paradise</span>
		<h1>Directions to <span class="accent">paradise</span></h1>
		<p class="lede">
			Finding Easy Lot is the first step toward your investment. Below are the directions to
			our main developments, strategically located near landmarks like Health City.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="https://www.google.com/maps/search/?api=1&amp;query=High+Rock+Drive+East+End+Grand+Cayman" target="_blank" rel="noopener">
				<?php easylot_the_icon( 'pin' ); ?> Open in Google Maps
			</a>
			<a class="btn btn--ghost btn--lg" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
				<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
			</a>
		</div>
	</div>
</header>

<!-- ============================================================ THE ROUTE -->
<section class="section section--paper">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">The route</span>
			<h2>Three turns from Health City</h2>
		</div>

		<div class="rail">
			<?php foreach ( $route as $step ) : ?>
				<div class="rail__step reveal">
					<span class="rail__n"><?php echo esc_html( $step['n'] ); ?></span>
					<h3><?php echo esc_html( $step['name'] ); ?></h3>
					<p><?php echo esc_html( $step['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="map-embed" style="margin-top:36px;aspect-ratio:16/9;">
			<iframe
				title="Map showing High Rock Drive, East End, Grand Cayman"
				src="https://www.google.com/maps?q=High+Rock+Drive,+East+End,+Grand+Cayman&amp;output=embed"
				loading="lazy"
				referrerpolicy="no-referrer-when-downgrade"
				allowfullscreen></iframe>
		</div>
	</div>
</section>

<!-- ============================================================ THE OFFICE -->
<section class="section section--ink">
	<div class="wrap">
		<div class="grid grid-2" style="align-items:start;gap:clamp(30px,5vw,56px);">
			<div>
				<span class="eyebrow">The office</span>
				<h2 style="font-size:clamp(1.7rem,3.2vw,2.4rem);">Or come and see us in George&nbsp;Town</h2>
				<p class="lede" style="margin-bottom:28px;">
					Call ahead so somebody is free when you arrive. If you would rather see the land
					than the office, say so and we will drive out with you.
				</p>

				<div class="info-list">
					<div class="info-list__row">
						<div class="info-list__k">Address</div>
						<div class="info-list__v">
							<?php echo esc_html( $c['street'] ); ?><br>
							<?php echo esc_html( $c['locality'] ); ?>, <?php echo esc_html( $c['region'] ); ?><br>
							<?php echo esc_html( $c['postcode'] ); ?>, Cayman Islands
						</div>
					</div>
					<div class="info-list__row">
						<div class="info-list__k">Phone</div>
						<div class="info-list__v"><a href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a></div>
					</div>
					<div class="info-list__row">
						<div class="info-list__k">Email</div>
						<div class="info-list__v"><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></div>
					</div>
					<div class="info-list__row">
						<div class="info-list__k">Visits</div>
						<div class="info-list__v">By appointment, so you are not waiting. Call or message and we will find a time.</div>
					</div>
				</div>
			</div>

			<div class="map-embed">
				<iframe
					title="Map showing the Easy Lot office in George Town, Grand Cayman"
					src="https://www.google.com/maps?q=207+Sparky+Drive,+George+Town,+Grand+Cayman&amp;output=embed"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ PAGE BODY -->
<?php
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
			<h2>Lost along the way?</h2>
			<p>Give us a call or send a WhatsApp message, and our team will guide you in.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
					<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
				</a>
				<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
					<?php easylot_the_icon( 'whatsapp' ); ?> WhatsApp us
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
