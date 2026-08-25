<?php
/**
 * Template Name: Contact / Pre-Approval
 *
 * The page content is where the pre-approval form lives, and it prints
 * untouched. Everything around it is built here, so the page still reads as a
 * designed page while the form is being wired up.
 *
 * @package EasyLotCayman
 */

$c = easylot_contact();

$GLOBALS['easylot_seo_title']       = 'Get Pre-Approved for Land in the Cayman Islands | Easy Lot';
$GLOBALS['easylot_seo_description'] = 'Free 5-minute pre-approval for owner-financed land in Grand Cayman and Little Cayman. Four documents, no bank, no obligation. Call, WhatsApp or apply online.';

$trail = array(
	'Home'    => home_url( '/' ),
	'Contact' => easylot_url( 'contact' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail ) {
	$graph[] = easylot_breadcrumbs( $trail );
	$graph[] = array(
		'@type' => 'ContactPage',
		'@id'   => easylot_url( 'contact' ) . '#contactpage',
		'about' => array( '@id' => home_url( '/' ) . '#organization' ),
	);
	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Free · no obligation · no credit mark</span>
		<h1>Find out what you <span class="accent">qualify for</span></h1>
		<p class="lede">
			Pre-approval takes about five minutes and needs four documents. It is not a credit
			application, so it leaves no mark, and most people hear back the same business day.
		</p>
	</div>
</header>

<!-- ============================================================ FORM + SIDEBAR -->
<section class="section section--paper">
	<div class="wrap">
		<div class="grid grid-2" style="align-items:start;gap:clamp(30px,5vw,52px);">

			<div>
				<?php if ( easylot_has_content() ) : ?>
					<div class="entry-content entry-content--full" style="font-size:1rem;">
						<?php
						while ( have_posts() ) {
							the_post();
							the_content();
						}
						?>
					</div>
				<?php else : ?>
					<?php /* No form on the page yet — say something useful rather than
					         leaving half the layout blank. */ ?>
					<div class="card">
						<span class="card__icon"><?php easylot_the_icon( 'mail' ); ?></span>
						<h2 style="font-size:1.5rem;">Start your pre-approval</h2>
						<p style="margin-bottom:24px;">
							Send us the four documents and a note about what you are looking for, and
							we will come back with the price range and monthly payment you qualify
							for — usually the same business day.
						</p>
						<div class="btn-row">
							<a class="btn btn--primary btn--wide" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
								<?php easylot_the_icon( 'whatsapp' ); ?> Send them on WhatsApp
							</a>
							<a class="btn btn--ghost btn--wide" href="mailto:<?php echo esc_attr( $c['email'] ); ?>">
								<?php easylot_the_icon( 'mail' ); ?> Email <?php echo esc_html( $c['email'] ); ?>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<aside>
				<div class="card" style="margin-bottom:22px;">
					<h2 style="font-size:1.3rem;">Talk to a person instead</h2>
					<p style="margin-bottom:22px;">Nothing here commits you to anything. If it is easier to ask first, ask first.</p>
					<div class="btn-row">
						<a class="btn btn--primary btn--wide" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
							<?php easylot_the_icon( 'whatsapp' ); ?> WhatsApp us
						</a>
						<a class="btn btn--ghost btn--wide" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
							<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
						</a>
						<a class="btn btn--ghost btn--wide" href="mailto:<?php echo esc_attr( $c['email'] ); ?>">
							<?php easylot_the_icon( 'mail' ); ?> <?php echo esc_html( $c['email'] ); ?>
						</a>
					</div>
				</div>

				<div class="card" style="margin-bottom:22px;">
					<h2 style="font-size:1.3rem;">What to have ready</h2>
					<ul class="ticks">
						<li><?php easylot_the_icon( 'check' ); ?> <span>Passport</span></li>
						<li><?php easylot_the_icon( 'check' ); ?> <span>Driver&rsquo;s licence or second photo ID</span></li>
						<li><?php easylot_the_icon( 'check' ); ?> <span>Job letter with your role and income</span></li>
						<li><?php easylot_the_icon( 'check' ); ?> <span>Recent utility bill for proof of address</span></li>
					</ul>
					<p style="margin-top:20px;font-size:.88rem;color:var(--ink-55);">
						Phone photos are fine. Buying with someone else? Each applicant sends the same four, and both incomes count.
					</p>
				</div>

				<div class="card">
					<h2 style="font-size:1.3rem;">Our office</h2>
					<p>
						<?php echo esc_html( $c['street'] ); ?><br>
						<?php echo esc_html( $c['locality'] ); ?>, <?php echo esc_html( $c['region'] ); ?><br>
						Cayman Islands
					</p>
					<a class="btn btn--ghost" style="margin-top:18px;" href="<?php echo esc_url( easylot_url( 'directions' ) ); ?>">
						<?php easylot_the_icon( 'pin' ); ?> Directions
					</a>
				</div>
			</aside>
		</div>
	</div>
</section>

<!-- ============================================================ WHAT HAPPENS NEXT -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">After you press send</span>
			<h2>What happens next</h2>
			<p class="lede">No black box. Here is the sequence, and roughly how long each part takes.</p>
		</div>

		<div class="rail">
			<div class="rail__step reveal">
				<span class="rail__n">01 · SAME DAY</span>
				<h3>We read it and come back</h3>
				<p>A person reviews your application and replies with the price range and the monthly payment you qualify for. Almost always within the business day.</p>
			</div>
			<div class="rail__step reveal">
				<span class="rail__n">02 · YOUR PACE</span>
				<h3>You choose a lot</h3>
				<p>Browse the live map on any development, or ask us to walk it with you. Nothing is reserved and nothing is owed until you say so.</p>
			</div>
			<div class="rail__step reveal">
				<span class="rail__n">03 · A FEW DAYS</span>
				<h3>Agreement and deposit</h3>
				<p>Price, deposit, monthly payment and term in plain figures. You sign, pay the down payment from 5%, and we complete the AML checks the law requires.</p>
			</div>
		</div>

		<div class="btn-row" style="margin-top:36px;">
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">The full five steps <?php easylot_the_icon( 'arrow' ); ?></a>
		</div>
	</div>
</section>

<!-- ============================================================ VIDEO -->
<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Before you apply</span>
			<h2>Questions people ask at this point</h2>
		</div>
		<?php easylot_video_grid( easylot_videos( array( 'category' => 'process' ) ), array( 'cols' => 3 ) ); ?>
		<div class="btn-row btn-row--center" style="margin-top:40px;">
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">Read the full FAQ</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
