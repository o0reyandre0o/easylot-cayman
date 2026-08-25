<?php
/**
 * Template Name: Directions
 *
 * @package EasyLotCayman
 */

$c = easylot_contact();

$GLOBALS['easylot_seo_title']       = 'Find the Easy Lot Office in George Town, Grand Cayman';
$GLOBALS['easylot_seo_description'] = 'Directions to the Easy Lot office at 207 Sparky Dr. Suite 6, George Town, Grand Cayman. Call or WhatsApp us to arrange a site visit to any of our developments.';

$trail = array(
	'Home'       => home_url( '/' ),
	'Directions' => easylot_url( 'directions' ),
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
		<span class="eyebrow">Come and see us</span>
		<h1>Find our office</h1>
		<p class="lede">
			We are in George Town, and we are happy to drive out to any of the developments with
			you. Call ahead so somebody is free when you arrive.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">
		<div class="grid grid-2" style="align-items:start;gap:44px;">
			<div>
				<div class="info-list">
					<div class="info-list__row">
						<div class="info-list__k">Address</div>
						<div class="info-list__v">
							<?php echo esc_html( $c['street'] ); ?><br>
							<?php echo esc_html( $c['locality'] ); ?>, <?php echo esc_html( $c['region'] ); ?><br>
							Cayman Islands
						</div>
					</div>
					<div class="info-list__row">
						<div class="info-list__k">Phone</div>
						<div class="info-list__v"><a href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a></div>
					</div>
					<div class="info-list__row">
						<div class="info-list__k">WhatsApp</div>
						<div class="info-list__v"><a href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">Message us</a></div>
					</div>
					<div class="info-list__row">
						<div class="info-list__k">Email</div>
						<div class="info-list__v"><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></div>
					</div>
				</div>

				<div class="btn-row" style="margin-top:30px;">
					<a class="btn btn--primary" href="https://www.google.com/maps/search/?api=1&amp;query=Easy+Lot+207+Sparky+Drive+George+Town+Grand+Cayman" target="_blank" rel="noopener">
						<?php easylot_the_icon( 'pin' ); ?> Open in Google Maps
					</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Book a site visit</a>
				</div>

				<div class="entry-content entry-content--full" style="margin-top:40px;">
					<?php
					while ( have_posts() ) {
						the_post();
						the_content();
					}
					?>
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

<?php get_footer(); ?>
