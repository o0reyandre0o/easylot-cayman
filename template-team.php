<?php
/**
 * Template Name: Meet the Team
 *
 * The page stands on its own. easylot_team() is empty by default — the theme
 * will not invent names or photographs — so the page leads with what a buyer
 * actually wants to know (who handles what, and who they will be dealing with
 * at each stage) and renders the card grid only once real people are added.
 *
 * @package EasyLotCayman
 */

$c    = easylot_contact();
$team = easylot_team();

$GLOBALS['easylot_seo_title']       = 'Meet the Easy Lot Team | Owner-Financed Land in the Cayman Islands';
$GLOBALS['easylot_seo_description'] = 'The people behind Easy Lot: who handles your pre-approval, your documents, your site visit and your closing when you buy owner-financed land in the Cayman Islands.';

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
		$graph[] = array(
			'@type'      => 'Person',
			'name'       => $person['name'],
			'jobTitle'   => isset( $person['role'] ) ? $person['role'] : '',
			'worksFor'   => array( '@id' => home_url( '/' ) . '#organization' ),
		);
	}

	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">The people</span>
		<h1>You will deal with the <span class="accent">same people</span> throughout</h1>
		<p class="lede">
			We are small on purpose. The person who answers your first question is the person who
			walks the lot with you and the person who sees your closing through — not a queue, not
			a ticket number, and never a call centre.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">
				Talk to us <?php easylot_the_icon( 'arrow' ); ?>
			</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
				<?php easylot_the_icon( 'whatsapp' ); ?> WhatsApp
			</a>
		</div>
	</div>
</header>

<!-- ============================================================ WHO DOES WHAT -->
<section class="section section--paper">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Who handles what</span>
			<h2>Four moments, and who you speak to at each</h2>
			<p class="lede">
				Buying land involves a handful of people. Here is who they are and what they are
				responsible for, so nothing about the process is a surprise.
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
				<h3>Documents &amp; AML</h3>
				<p>Checks your four documents and handles the anti-money-laundering verification every Cayman land purchase is required to complete.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'key' ); ?></span>
				<h3>Closing</h3>
				<p>Takes the agreement through to transfer and registration with the Lands and Survey Department, and confirms when the title is in your name.</p>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ THE PEOPLE -->
<?php if ( $team ) : ?>
	<section class="section section--white">
		<div class="wrap">
			<div class="section-head">
				<span class="eyebrow">Faces</span>
				<h2>The team</h2>
			</div>
			<div class="grid grid-4">
				<?php foreach ( $team as $person ) : ?>
					<div class="person reveal">
						<?php if ( ! empty( $person['photo'] ) ) : ?>
							<img src="<?php echo esc_url( $person['photo'] ); ?>" alt="<?php echo esc_attr( $person['name'] ); ?>" width="92" height="92" loading="lazy">
						<?php endif; ?>
						<h3><?php echo esc_html( $person['name'] ); ?></h3>
						<?php if ( ! empty( $person['role'] ) ) : ?>
							<span><?php echo esc_html( $person['role'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $person['bio'] ) ) : ?>
							<p style="margin-top:14px;color:var(--ink-72);font-size:.93rem;"><?php echo esc_html( $person['bio'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============================================================ HOW WE WORK -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">How we work</span>
			<h2>What you can hold us to</h2>
		</div>

		<div class="grid grid-3">
			<div class="card reveal">
				<h3>An answer the same day</h3>
				<p>Pre-approval decisions come back within the business day in almost every case. If something is going to take longer, we tell you why rather than going quiet.</p>
			</div>
			<div class="card reveal">
				<h3>Every figure in writing</h3>
				<p>Price, deposit, monthly payment and term are written into the agreement before you sign anything. No number appears later that was not there at the start.</p>
			</div>
			<div class="card reveal">
				<h3>No pressure to decide</h3>
				<p>Pre-approval costs nothing and commits you to nothing. Plenty of people get approved, think about it for months, and come back. That is fine.</p>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ PAGE BODY -->
<?php if ( easylot_has_content() ) : ?>
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
<?php endif; ?>

<!-- ============================================================ CTA -->
<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Ask any of us anything</h2>
			<p>A person answers, and there is nothing attached to asking. Call the office, message us on WhatsApp, or start with a free pre-approval.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Contact the team</a>
				<a class="btn btn--ghost btn--lg" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
					<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
