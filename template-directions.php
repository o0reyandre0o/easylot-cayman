<?php
/**
 * Template Name: Directions
 *
 * Content first: the page's own words are the body, cleaned of the old theme's
 * dead utility classes. The office details, the map and the developments always
 * render; the written advice below is a fallback for when the page is empty.
 *
 * @package EasyLotCayman
 */

$c    = easylot_contact();
$devs = array_slice( easylot_developments(), 0, 3 );
$has_body = easylot_has_content();

$GLOBALS['easylot_seo_title']       = 'Find the Easy Lot Office in George Town, Grand Cayman';
$GLOBALS['easylot_seo_description'] = 'Directions to the Easy Lot office at 207 Sparky Dr. Suite 6, George Town, Grand Cayman. Call or WhatsApp us to arrange a site visit to any of our owner-financed developments.';

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
		<h1>Find our office in <span class="accent">George Town</span></h1>
		<p class="lede">
			We are on Sparky Drive in George Town, Grand Cayman. Call ahead so somebody is free
			when you arrive — and if you would rather see the land than the office, say so and we
			will drive out with you.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="https://www.google.com/maps/search/?api=1&amp;query=Easy+Lot+207+Sparky+Drive+George+Town+Grand+Cayman" target="_blank" rel="noopener">
				<?php easylot_the_icon( 'pin' ); ?> Open in Google Maps
			</a>
			<a class="btn btn--ghost btn--lg" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
				<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
			</a>
		</div>
	</div>
</header>

<!-- ============================================================ DETAILS + MAP -->
<section class="section section--paper">
	<div class="wrap">
		<div class="grid grid-2" style="align-items:start;gap:clamp(30px,5vw,56px);">

			<div>
				<div class="section-head" style="margin-bottom:28px;padding-bottom:22px;">
					<span class="eyebrow">The office</span>
					<h2 style="font-size:clamp(1.6rem,3vw,2.2rem);">How to reach us</h2>
				</div>

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
					<div class="info-list__row">
						<div class="info-list__k">Visits</div>
						<div class="info-list__v">By appointment, so you are not waiting. Call or message and we will find a time.</div>
					</div>
				</div>

				<div class="btn-row" style="margin-top:30px;">
					<a class="btn btn--ink" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Book a site visit</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
						<?php easylot_the_icon( 'whatsapp' ); ?> WhatsApp
					</a>
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
<?php if ( $has_body ) : ?>
	<section class="section section--paper">
		<div class="wrap">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<div class="entry-content"><?php easylot_the_clean_content(); ?></div>
				<?php
			}
			?>
		</div>
	</section>
<?php endif; ?>

<!-- ============================================================ SEEING THE LAND -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Better than the office</span>
			<h2>Come and stand on the land</h2>
			<p class="lede">
				A lot map tells you the size and the price. Standing on the parcel tells you
				everything else. We will meet you at the development, or collect you from the
				office and drive out together.
			</p>
		</div>

		<div class="grid grid-3">
			<?php foreach ( $devs as $d ) : ?>
				<div class="card reveal">
					<span class="card__icon"><?php easylot_the_icon( 'pin' ); ?></span>
					<h3><?php echo esc_html( $d['name'] ); ?></h3>
					<p><?php echo esc_html( $d['island'] ); ?>. <?php echo esc_html( $d['blurb'] ); ?></p>
					<a class="btn btn--ghost" style="margin-top:20px;" href="<?php echo esc_url( $d['link'] ); ?>">
						See the lots <?php easylot_the_icon( 'arrow' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="lede" style="margin-top:32px;font-size:.95rem;">
			Elena Estates is on Little Cayman, so that one takes a short flight — tell us and we
			will help you plan the trip around it.
		</p>
	</div>
</section>

<?php /* The page has its own words for this; only fall back to
         ours when it does not. */ ?>
<?php if ( ! $has_body ) : ?>
<!-- ============================================================ BEFORE YOU COME -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Worth doing first</span>
			<h2>Two things that make the visit useful</h2>
		</div>

		<div class="grid grid-2">
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'clock' ); ?></span>
				<h3>Get pre-approved before you come</h3>
				<p>Five minutes online tells you your price range and monthly payment. Walking a development already knowing which lots are within reach is a completely different visit — and it costs nothing.</p>
				<a class="btn btn--ghost" style="margin-top:20px;" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Start pre-approval</a>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'doc' ); ?></span>
				<h3>Bring the four documents</h3>
				<p>Passport, driver&rsquo;s licence or second photo ID, a job letter, and a recent utility bill. Photos on your phone are fine. With those in hand we can move straight from the visit to an offer.</p>
				<a class="btn btn--ghost" style="margin-top:20px;" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">The full process</a>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- ============================================================ CTA -->
<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Let us know you are coming</h2>
			<p>A quick message means the right person is free when you arrive, and we can have the lots you are interested in ready to walk.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
					<?php easylot_the_icon( 'whatsapp' ); ?> Message us on WhatsApp
				</a>
				<a class="btn btn--ghost btn--lg" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
					<?php echo esc_html( $c['phone'] ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
