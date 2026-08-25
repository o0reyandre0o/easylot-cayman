<?php
/**
 * Template Name: About Us
 *
 * The copy here is Easy Lot's own, carried over from the previous theme's
 * template-about-us.php — the mission, the Cayman Development Group backing,
 * the vision, and the six core values. That is where it lived: the WordPress
 * pages themselves were empty, which is why the information looked lost when
 * the theme changed.
 *
 * @package EasyLotCayman
 */

$c        = easylot_contact();
$devs     = array_slice( easylot_developments(), 0, 3 );
$values   = easylot_values();
$featured = easylot_videos( array( 'featured' => true ) );

$GLOBALS['easylot_seo_title']       = 'About Easy Lot Cayman | Our Mission &amp; Financing Story';
$GLOBALS['easylot_seo_description'] = 'Easy Lot empowers individuals and families to achieve land ownership in the Cayman Islands with owner financing. Backed by Cayman Development Group and founded by Tommy Sofield.';

$trail = array(
	'Home'  => home_url( '/' ),
	'About' => easylot_url( 'about' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $featured ) {
	$graph[] = easylot_breadcrumbs( $trail );
	$graph[] = array(
		'@type'      => 'AboutPage',
		'@id'        => easylot_url( 'about' ) . '#aboutpage',
		'about'      => array( '@id' => home_url( '/' ) . '#organization' ),
		'mainEntity' => array(
			'@type'              => 'Organization',
			'name'               => 'Easy Lot',
			'foundingDate'       => '2023',
			'founder'            => array( '@type' => 'Person', 'name' => 'Tommy Sofield' ),
			'parentOrganization' => array( '@type' => 'Organization', 'name' => 'Cayman Development Group' ),
		),
	);
	return array_merge( $graph, easylot_video_schema_nodes( $featured ) );
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Our mission</span>
		<h1>Affordable land in Cayman, <span class="accent">by owner</span></h1>
		<p class="lede">
			Our mission is to empower individuals and families to achieve their dreams of land
			ownership within the Cayman Islands.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">
				Explore developments <?php easylot_the_icon( 'arrow' ); ?>
			</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">How the financing works</a>
		</div>
	</div>
</header>

<!-- ============================================================ FIGURES -->
<section class="trust">
	<div class="wrap">
		<div class="trust__grid">
			<div class="trust__cell"><b>2023</b><span>Founded</span></div>
			<div class="trust__cell"><b>100<span class="u">%</span></b><span>Owner financed</span></div>
			<div class="trust__cell"><b>Decades</b><span>Of local experience</span></div>
			<div class="trust__cell"><b>3</b><span>Islands served</span></div>
		</div>
	</div>
</section>

<!-- ============================================================ BACKING -->
<section class="section section--paper">
	<div class="wrap hero__grid">
		<div>
			<span class="eyebrow">Cayman expertise</span>
			<h2>Backed by Cayman Development&nbsp;Group</h2>
			<p class="lede" style="margin-bottom:24px;">
				Easy Lot is backed by Cayman Development Group, a leader in land development with
				decades of local experience.
			</p>
			<p>
				At Cayman Development Group we believe that every piece of land holds the potential
				for a brighter tomorrow. It is our hope that clients will not just find a piece of
				land, but a canvas on which they can create their future.
			</p>
			<p>
				Whether it is building a home or investing for the long term, our vision is to
				create a seamless, user-friendly environment driven by innovation. We aim to be a
				guiding light in the journey toward land ownership, providing a trustworthy partner
				that empowers clients to take bold steps toward their future.
			</p>
			<p>
				With transparency, integrity and professionalism as our cornerstones, we aim to
				build lasting relationships built on trust and mutual success.
			</p>

			<div class="step__meta" style="margin-top:26px;">
				<?php easylot_the_icon( 'check-c' ); ?> Founded 2023 by Tommy Sofield, Director
			</div>
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

<!-- ============================================================ CORE VALUES -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Our core values</span>
			<h2>The principles behind every project</h2>
			<p class="lede">The principles that guide every interaction and project at Easy Lot.</p>
		</div>

		<div class="grid grid-3">
			<?php foreach ( $values as $val ) : ?>
				<div class="card reveal">
					<span class="card__icon"><?php easylot_the_icon( $val['icon'] ); ?></span>
					<h3><?php echo esc_html( $val['name'] ); ?></h3>
					<p><?php echo esc_html( $val['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ HOW WE WORK -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">What that means in practice</span>
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

<!-- ============================================================ PAGE BODY -->
<?php
/*
 * The mission, the backing and the values above ARE the page's real content,
 * carried over from the old theme. A page body only prints when somebody has
 * deliberately built one in Elementor — otherwise it would repeat all of this
 * in markup whose stylesheet no longer exists.
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
<section class="section section--tight section--paper">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Ready to start your legacy?</h2>
			<p>Explore our developments and find the perfect canvas for your future home in paradise.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">Explore developments</a>
				<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get pre-approved</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
