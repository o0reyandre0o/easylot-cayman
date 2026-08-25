<?php
/**
 * Template Name: All Developments
 *
 * The index of our developments. Each card links to that development's own
 * page, which carries the third-party interactive lot map — this template
 * never tries to reproduce the map itself.
 *
 * @package EasyLotCayman
 */

$devs = easylot_developments();
$c    = easylot_contact();

$GLOBALS['easylot_seo_title']       = 'Land for Sale in the Cayman Islands — All Developments | Easy Lot';
$GLOBALS['easylot_seo_description'] = 'Owner-financed land for sale in Grand Cayman and Little Cayman: Elena Estates, High Rock Estates, Northshore Estates and Ocean Breeze. Interactive lot maps, starting prices and 5% down payments.';

$trail = array(
	'Home'          => home_url( '/' ),
	'Land for Sale' => easylot_url( 'developments' ),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $devs ) {
	$graph[] = easylot_breadcrumbs( $trail );

	$list = array();
	$i    = 1;
	foreach ( $devs as $d ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $i++,
			'item'     => array(
				'@type'       => 'Place',
				'name'        => $d['name'],
				'url'         => $d['link'],
				'image'       => $d['image'],
				'description' => $d['blurb'],
				'address'     => array(
					'@type'          => 'PostalAddress',
					'addressRegion'  => $d['island'],
					'addressCountry' => 'KY',
				),
			),
		);
	}
	$graph[] = array(
		'@type'           => 'ItemList',
		'@id'             => easylot_url( 'developments' ) . '#list',
		'name'            => 'Easy Lot developments in the Cayman Islands',
		'numberOfItems'   => count( $devs ),
		'itemListElement' => $list,
	);
	return $graph;
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Land for sale</span>
		<h1>Owner-financed land in <span class="accent">Grand Cayman &amp; Little Cayman</span></h1>
		<p class="lede">
			Every one of our developments is sold with direct owner financing — 5% down, fixed
			monthly payments and no bank. Open one to see its live lot map and what is still
			available.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">
		<div class="grid grid-2">
			<?php foreach ( $devs as $d ) : ?>
				<article class="lot reveal">
					<div class="lot__img">
						<img src="<?php echo esc_url( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['name'] . ' — ' . $d['island'] ); ?>" width="640" height="480" loading="lazy">
						<span class="lot__flag<?php echo ! empty( $d['flag_alt'] ) ? ' lot__flag--olive' : ''; ?>"><?php echo esc_html( $d['flag'] ); ?></span>
					</div>
					<div class="lot__body">
						<div class="lot__where"><?php easylot_the_icon( 'pin' ); ?> <?php echo esc_html( $d['island'] ); ?></div>
						<h2 style="font-size:1.45rem;"><?php echo esc_html( $d['name'] ); ?></h2>
						<p><?php echo esc_html( $d['blurb'] ); ?></p>
						<div class="lot__facts">
							<?php foreach ( $d['facts'] as $f ) : ?>
								<span class="lot__fact"><?php echo esc_html( $f ); ?></span>
							<?php endforeach; ?>
						</div>
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

		<p style="margin-top:28px;font-size:.9rem;color:var(--ink-55);max-width:70ch;">
			Starting prices are the lowest currently available in each development and change as
			lots sell. The live map on each development page is the authority on what is still open.
		</p>
	</div>
</section>

<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Take the tour</span>
			<h2>What each development is actually like</h2>
			<p class="lede">We walked them with a camera, so you can see the terrain, the roads and the surroundings before you drive out.</p>
		</div>
		<?php easylot_video_grid( easylot_videos( array( 'category' => 'developments' ) ), array( 'cols' => 3 ) ); ?>
	</div>
</section>

<section class="section section--tight section--paper">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Get pre-approved before you choose</h2>
			<p>Five minutes tells you your price range and monthly payment, so you look at the map already knowing which lots are yours to take.</p>
			<div class="btn-row btn-row--center" style="margin-top:28px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Start my pre-approval</a>
				<a class="btn btn--ghost btn--lg" style="color:#fff;border-color:rgba(255,255,255,.5)" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">Ask on WhatsApp</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
