<?php
/**
 * Template Name: Contact / Pre-Approval
 *
 * The page content — which is where the pre-approval form lives — is printed
 * untouched. This template only builds the frame around it.
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
		<span class="eyebrow">Step one · free · no obligation</span>
		<h1>Find out what you <span class="accent">qualify for</span></h1>
		<p class="lede">
			Pre-approval takes about five minutes and needs four documents. It is not a credit
			application, so it leaves no mark, and most people hear back the same business day.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">
		<div class="grid grid-2" style="align-items:start;gap:48px;">

			<div>
				<div class="entry-content entry-content--full" style="font-size:1rem;">
					<?php
					while ( have_posts() ) {
						the_post();
						the_content();
					}
					?>
				</div>
			</div>

			<aside>
				<div class="card" style="margin-bottom:24px;">
					<h2 style="font-size:1.32rem;">Talk to a person instead</h2>
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

				<div class="card" style="margin-bottom:24px;">
					<h2 style="font-size:1.32rem;">What to have ready</h2>
					<ul class="ticks">
						<li><?php easylot_the_icon( 'check' ); ?> <span>Passport</span></li>
						<li><?php easylot_the_icon( 'check' ); ?> <span>Driver&rsquo;s licence or second photo ID</span></li>
						<li><?php easylot_the_icon( 'check' ); ?> <span>Job letter with your role and income</span></li>
						<li><?php easylot_the_icon( 'check' ); ?> <span>Recent utility bill for proof of address</span></li>
					</ul>
					<p style="margin-top:20px;font-size:.88rem;color:var(--ink-55);">
						Phone photos are fine. Buying with someone else? Each applicant sends the same four.
					</p>
				</div>

				<div class="card">
					<h2 style="font-size:1.32rem;">Our office</h2>
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

<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Before you apply</span>
			<h2>What happens after you press send</h2>
		</div>
		<?php easylot_video_grid( easylot_videos( array( 'category' => 'process' ) ), array( 'cols' => 3 ) ); ?>
	</div>
</section>

<?php get_footer(); ?>
