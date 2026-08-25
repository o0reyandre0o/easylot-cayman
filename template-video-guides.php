<?php
/**
 * Template Name: Video Guides
 *
 * The full library. Everything comes from easylot_videos() in functions.php —
 * that array is the only place you edit to add, remove or reorder a video.
 *
 * @package EasyLotCayman
 */

$videos     = easylot_videos();
$categories = easylot_video_categories();

$GLOBALS['easylot_seo_title']       = 'Video Guides: Buying Land in the Cayman Islands | Easy Lot';
$GLOBALS['easylot_seo_description'] = 'Short videos answering the questions we get asked most about buying land in Grand Cayman and Little Cayman: how owner financing works, how to apply, and what happens after approval.';

$trail = array(
	'Home'         => home_url( '/' ),
	'Video Guides' => easylot_url( 'videos' ),
);

// Only show a filter pill for a category that actually has videos in it.
$used = array();
foreach ( $videos as $v ) {
	if ( isset( $categories[ $v['category'] ] ) ) {
		$used[ $v['category'] ] = $categories[ $v['category'] ];
	}
}

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $videos ) {
	$graph[] = easylot_breadcrumbs( $trail );

	$list = array();
	$i    = 1;
	foreach ( $videos as $v ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $i++,
			'name'     => $v['question'],
			'url'      => $v['src'],
		);
	}
	$graph[] = array(
		'@type'           => 'ItemList',
		'@id'             => easylot_url( 'videos' ) . '#list',
		'name'            => 'Easy Lot Video Guides',
		'numberOfItems'   => count( $videos ),
		'itemListElement' => $list,
	);

	return array_merge( $graph, easylot_video_schema_nodes( $videos ) );
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">Watch &amp; learn</span>
		<h1>Video guides: <span class="accent">buying land in Cayman</span></h1>
		<p class="lede">
			Buying land raises a lot of questions. We answered the ones we hear most in short
			videos — no jargon, no sales pitch, just straight answers you can watch in a couple
			of minutes. <?php echo count( $videos ); ?> in total.
		</p>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">

		<div class="pills" id="video-filters">
			<div class="pill is-active" role="button" tabindex="0" data-filter="all">All videos</div>
			<?php foreach ( $used as $slug => $label ) : ?>
				<div class="pill" role="button" tabindex="0" data-filter="<?php echo esc_attr( $slug ); ?>">
					<?php echo wp_kses_post( $label ); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="grid grid-4" id="video-grid">
			<?php foreach ( $videos as $v ) : ?>
				<?php easylot_video_card( $v ); ?>
			<?php endforeach; ?>
		</div>

		<p id="video-empty" style="display:none;text-align:center;padding:60px 0;color:var(--ink-55);">
			No videos in this category yet — more are on the way.
		</p>
	</div>
</section>

<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Prefer to read?</h2>
			<p>Every one of these answers — plus a lot more on zoning, titles, stamp duty and taxes — is written out on the FAQ page and in the full buying guide.</p>
			<div class="btn-row btn-row--center" style="margin-top:28px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">Read the FAQs</a>
				<a class="btn btn--ghost btn--lg" style="color:#fff;border-color:rgba(255,255,255,.5)" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">The full buying guide</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
