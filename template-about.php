<?php
/**
 * Template Name: About Us
 *
 * Content first: whatever the page itself says is the body of the page, run
 * through easylot_the_clean_content() so markup written for the old theme
 * loses its dead utility classes and picks up this theme's typography.
 *
 * The written sections below are a fallback, not a layer on top — they only
 * render when the page has no content of its own, so nothing is ever said
 * twice. The structural blocks (figures, developments, video, CTA) always
 * render, because those are the page's furniture rather than its copy.
 *
 * @package EasyLotCayman
 */

$c        = easylot_contact();
$devs     = array_slice( easylot_developments(), 0, 3 );
$featured = easylot_videos( array( 'featured' => true ) );
$has_body = easylot_has_content();

$GLOBALS['easylot_seo_title']       = 'About Easy Lot — Owner-Financed Land in the Cayman Islands';
$GLOBALS['easylot_seo_description'] = 'Easy Lot owns and finances land in Grand Cayman and Little Cayman, so buyers can own a lot without a bank. Who we are, how the financing works, and why we do it this way.';

$trail = array(
	'Home'  => home_url( '/' ),
	'About' => easylot_url( 'about' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $featured ) {
	$graph[] = easylot_breadcrumbs( $trail );
	$graph[] = array(
		'@type' => 'AboutPage',
		'@id'   => easylot_url( 'about' ) . '#aboutpage',
		'about' => array( '@id' => home_url( '/' ) . '#organization' ),
	);
	return array_merge( $graph, easylot_video_schema_nodes( $featured ) );
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Who we are</span>
		<h1>We own the land, so we can <span class="accent">finance it ourselves</span></h1>
		<p class="lede">
			Easy Lot exists because the ordinary route to owning land in the Cayman Islands —
			find a lot, then ask a bank — stops most people at the second step. We removed the
			second step.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">
				Get pre-approved free <?php easylot_the_icon( 'arrow' ); ?>
			</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">How it works</a>
		</div>
	</div>
</header>

<!-- ============================================================ THE FIGURES -->
<section class="trust">
	<div class="wrap">
		<div class="trust__grid">
			<div class="trust__cell"><b>0</b><span>Banks involved</span></div>
			<div class="trust__cell"><b>5<span class="u">%</span></b><span>Minimum down</span></div>
			<div class="trust__cell"><b>4</b><span>Documents needed</span></div>
			<div class="trust__cell"><b>3</b><span>Islands served</span></div>
		</div>
	</div>
</section>

<?php /* The page has its own words for this; only fall back to
         ours when it does not. */ ?>
<?php if ( ! $has_body ) : ?>
<!-- ============================================================ THE STORY -->
<section class="section section--paper">
	<div class="wrap hero__grid">
		<div>
			<span class="eyebrow">Why we do it this way</span>
			<h2>The problem was never the price</h2>
			<p>
				Land in the Cayman Islands is not, on the whole, unaffordable. A lot at $40,000 is
				within reach of a great many people living and working here. What is out of reach
				is the way it is normally financed.
			</p>
			<p>
				Raw, undeveloped land is the hardest thing on these islands to get a mortgage
				against. Lenders treat it as the riskiest category of property: no building, no
				rental income, nothing to repossess but the ground itself. So they ask for 30 to
				40% down, a local credit history, and a full underwriting file — and most people
				who wanted a lot here stop right there.
			</p>
			<p>
				We hold the title to the land we sell. That means we are free to set the terms
				ourselves: a deposit that starts at 5%, a payment that is fixed for the life of
				the agreement, and an answer that arrives the same day rather than in six weeks.
			</p>
		</div>

		<div>
			<?php
			$v = easylot_video_by_file( '2.-About-Direct-Owner-Financing' );
			if ( $v ) {
				easylot_video_card( $v, array( 'tag' => 'Watch: 2 min' ) );
			}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php /* The page has its own words for this; only fall back to
         ours when it does not. */ ?>
<?php if ( ! $has_body ) : ?>
<!-- ============================================================ HOW WE WORK -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">How we work</span>
			<h2>Three things we do differently</h2>
		</div>
		<div class="grid grid-3">
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'bank' ); ?></span>
				<h3>We are the lender</h3>
				<p>No bank sits between you and the title. That is what lets the deposit start at 5% and the decision arrive the same business day.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'doc' ); ?></span>
				<h3>Four documents, not forty</h3>
				<p>Passport, ID, job letter, utility bill. We look at whether the monthly payment fits your life, not at a credit score assembled by somebody else.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'shield' ); ?></span>
				<h3>Fixed, and written down</h3>
				<p>The payment does not move with rates, there is no penalty for settling early, and every figure is in the agreement before you sign it.</p>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php /* The page has its own words for this; only fall back to
         ours when it does not. */ ?>
<?php if ( ! $has_body ) : ?>
<!-- ============================================================ WHAT WE ARE NOT -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Straight about it</span>
			<h2>What we are not</h2>
			<p class="lede">
				Owner financing suits a lot of people, and it does not suit everybody. Being clear
				about that up front saves everyone time.
			</p>
		</div>

		<div class="grid grid-2">
			<div class="card reveal">
				<h3>We are not a bank</h3>
				<p>We finance the lots we own. We cannot lend against a property somebody else is selling, and we do not do construction finance — building starts once the title is in your name.</p>
			</div>
			<div class="card reveal">
				<h3>We are not a brokerage</h3>
				<p>We sell our own developments rather than listing other people&rsquo;s property, which is exactly why we can set the terms. If you want a house on the market today, an agent is the right call.</p>
			</div>
			<div class="card reveal">
				<h3>We are not free money</h3>
				<p>Financing has a cost, and ours is written into the agreement in plain figures. Paying cash is cheaper — it is just out of reach for most people, which is the whole point.</p>
			</div>
			<div class="card reveal">
				<h3>We are not lawyers or tax advisers</h3>
				<p>We explain our process, not your legal or tax position. Stamp duty is payable to the government on transfer, and you are free to instruct your own attorney at any stage.</p>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

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

<!-- ============================================================ WHERE -->
<section class="section section--paper">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Where we sell</span>
			<h2>Our developments</h2>
			<p class="lede">Across Grand Cayman and Little Cayman, each with a live lot map showing what is still available.</p>
		</div>

		<div class="grid grid-3">
			<?php foreach ( $devs as $d ) : ?>
				<article class="lot reveal">
					<div class="lot__img">
						<img src="<?php echo esc_url( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['name'] . ' — ' . $d['island'] ); ?>" width="640" height="427" loading="lazy">
						<span class="lot__flag<?php echo ! empty( $d['flag_alt'] ) ? ' lot__flag--olive' : ''; ?>"><?php echo esc_html( $d['flag'] ); ?></span>
					</div>
					<div class="lot__body">
						<div class="lot__where"><?php easylot_the_icon( 'pin' ); ?> <?php echo esc_html( $d['island'] ); ?></div>
						<h3><?php echo esc_html( $d['name'] ); ?></h3>
						<p><?php echo esc_html( $d['blurb'] ); ?></p>
						<?php if ( ! empty( $d['from'] ) ) : ?>
							<div class="lot__price"><b><?php echo esc_html( $d['from'] ); ?></b><span>starting price</span></div>
						<?php endif; ?>
						<a class="btn btn--ink btn--wide" href="<?php echo esc_url( $d['link'] ); ?>">
							View lots &amp; map <?php easylot_the_icon( 'arrow' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ VIDEO -->
<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">In our own words</span>
			<h2>The short version, on video</h2>
		</div>
		<?php easylot_video_grid( $featured, array( 'cols' => 4 ) ); ?>
		<div class="btn-row btn-row--center" style="margin-top:40px;">
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">All video guides</a>
		</div>
	</div>
</section>

<!-- ============================================================ CTA -->
<section class="section section--tight section--paper">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Come and see the land</h2>
			<p>Book a site visit, or start with a free pre-approval so you know your range before you walk a lot.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get pre-approved</a>
				<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'directions' ) ); ?>">Find our office</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
