<?php
/**
 * Easy Lot Cayman — theme functions.
 *
 * Everything the theme needs lives in this file and the templates next to it:
 * there is no build step and no CSS framework CDN; the only subdirectory is
 * assets/, which carries the intro video for the floating player.
 *
 * The parts you are most likely to edit are grouped at the top under
 * "SITE DATA" — contact details, developments, videos, FAQs and testimonials.
 *
 * @package EasyLotCayman
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EASYLOT_VERSION', '1.3.0' );

require_once get_template_directory() . '/nav.php';
require_once get_template_directory() . '/site-footer.php';

require_once __DIR__ . '/setup-pages.php';

/* ==========================================================================
 * 1. Theme setup
 * ========================================================================== */

function easylot_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 280, 'flex-height' => true, 'flex-width' => true ) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'easylot' ),
		'footer'  => __( 'Footer Menu', 'easylot' ),
	) );
}
add_action( 'after_setup_theme', 'easylot_setup' );

function easylot_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'easylot_content_width', 0 );

/* ==========================================================================
 * 2. Assets
 *
 * Two Google Font families and one hand-written stylesheet — no Tailwind CDN,
 * no icon font. Icons are inline SVG (see easylot_icon), which is what lets
 * the page render on the first paint instead of after a framework has parsed
 * the DOM.
 * ========================================================================== */

function easylot_assets() {
	wp_enqueue_style(
		'easylot-fonts',
		'https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;0,800;1,700&family=Manrope:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'easylot', get_stylesheet_uri(), array( 'easylot-fonts' ), EASYLOT_VERSION );

	wp_enqueue_script( 'easylot', get_template_directory_uri() . '/main.js', array(), EASYLOT_VERSION, true );
	wp_localize_script( 'easylot', 'EASYLOT', array(
		'homeUrl' => home_url( '/' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'easylot_assets' );

/**
 * Preconnect to the font hosts so the first paint is not blocked on a DNS
 * round trip. Everything else the theme loads is same-origin.
 */
function easylot_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'easylot_resource_hints', 10, 2 );

/* ==========================================================================
 * 3. SITE DATA — edit these, not the templates
 * ========================================================================== */

/**
 * Contact details, used by the header, footer, contact page and schema.
 */
function easylot_contact() {
	return array(
		'phone'        => '+1 345 936 2660',
		'phone_link'   => '+13459362660',
		'whatsapp'     => 'https://wa.me/13459362660',
		'email'        => 'info@easylot.ky',
		'street'       => '207 Sparky Dr. Suite 6',
		'locality'     => 'George Town',
		'region'       => 'Grand Cayman',
		'country'      => 'KY',
		'logo'         => 'https://easylot.ky/wp-content/uploads/2023/08/Easy-Lot-Logo-1-1.svg',
		'og_image'     => 'https://easylot.ky/wp-content/uploads/2023/08/Grand-Cayman-Aerial.jpg',
		'social'       => array(
			'facebook'  => 'https://www.facebook.com/easylotky',
			'instagram' => 'https://www.instagram.com/easylotky/',
			'youtube'   => 'https://www.youtube.com/@EasyLotKy',
			'tiktok'    => 'https://www.tiktok.com/@easylot',
		),
	);
}

/**
 * The three developments we actively sell.
 *
 * 'link' points at the existing WordPress page for each one. Those pages carry
 * a third-party interactive lot map, so this theme never renders their body
 * itself — single-project.php prints the_content() untouched and the map keeps
 * working exactly as it does today.
 */
function easylot_developments() {
	return array(
		array(
			'name'    => 'Elena Estates',
			'island'  => 'Little Cayman',
			'link'    => 'https://easylot.ky/project/little-cayman/',
			'image'   => 'https://easylot.ky/wp-content/uploads/2023/08/elena-estates-little-cayman-sitemap-satellite.jpg',
			'flag'    => 'Now selling',
			'blurb'   => 'Quiet, low-density lots on the least-developed of the three islands. The buy for people who want space, water nearby and almost no neighbours.',
			'facts'   => array( 'Little Cayman', 'Residential lots', 'Owner financed' ),
			'from'    => '$39,900',
			'video'   => '8.-About-Elena-Estates-1.mp4',
		),
		array(
			'name'    => 'High Rock Estates',
			'island'  => 'East End, Grand Cayman',
			'link'    => 'https://easylot.ky/project/high-rock-estates/',
			'image'   => 'https://easylot.ky/wp-content/uploads/2023/08/High-Rock-Estates.jpg',
			'flag'    => 'Investment land',
			'flag_alt' => true,
			'blurb'   => 'Grand Cayman land at the price point most people assume no longer exists here. Roads in, power along the boundary, and the East End growing towards it.',
			'facts'   => array( 'Grand Cayman', 'Road access', 'Owner financed' ),
			'from'    => '$44,900',
			'video'   => '9.-About-High-Rock-Estates-1.mp4',
		),
		array(
			'name'    => 'Northshore Estates',
			'island'  => 'Rum Point, Grand Cayman',
			'link'    => 'https://easylot.ky/project/rum-point-land/',
			'image'   => 'https://easylot.ky/wp-content/uploads/2024/07/rum-point-cayman-islands-1.jpg',
			'flag'    => 'Premium',
			'blurb'   => 'Near-shore lots minutes from Rum Point and Starfish Point — the north side address people already drive across the island to visit at the weekend.',
			'facts'   => array( 'Grand Cayman', 'Near shore', 'Owner financed' ),
			'from'    => '$59,900',
			'video'   => '10.-About-Northshore-Estates-1.mp4',
		),
		/*
		 * Ocean Breeze already ranks (position ~4.9 in Search Console) but was
		 * missing from the old theme's development list. TODO: confirm its hero
		 * image and starting price — 'from' is left empty until then and the
		 * templates simply omit the price line rather than invent one.
		 */
		array(
			'name'   => 'Ocean Breeze',
			'island' => 'Grand Cayman',
			'link'   => 'https://easylot.ky/project/ocean-breeze/',
			'image'  => 'https://easylot.ky/wp-content/uploads/2023/08/Grand-Cayman-Aerial.jpg',
			'flag'   => 'Enquire',
			'blurb'  => 'Our Grand Cayman coastal development. Open the page for the current lot map and what is still available.',
			'facts'  => array( 'Grand Cayman', 'Owner financed' ),
			'from'   => '',
		),
	);
}

function easylot_video_categories() {
	return array(
		'getting-started' => 'Getting Started',
		'financing'       => 'Financing &amp; Payments',
		'investment'      => 'Why Land Is a Smart Buy',
		'process'         => 'After You Apply',
		'developments'    => 'Our Developments',
	);
}

/**
 * Every published video guide.
 *
 * 'src'         file name inside the uploads folder given by 'dir'
 * 'orientation' 'vertical' (9:16, the default) or 'landscape'
 * 'featured'    also appears on the homepage
 * 'step'        pins the video to a step of the how-to-buy walkthrough (1-5)
 */
function easylot_videos( $args = array() ) {

	$jul = 'https://easylot.ky/wp-content/uploads/2026/07/';
	$aug = 'https://easylot.ky/wp-content/uploads/2026/08/';

	$videos = array(
		array(
			'src'         => $jul . '1.-How-to-get-pre-approved-2-1.mp4',
			'question'    => 'How do I get pre-approved for a lot?',
			'answer'      => 'What pre-approval means, what we look at, and how quickly you get an answer — before you commit to anything.',
			'category'    => 'getting-started',
			'date'        => '2026-07-01',
			'orientation' => 'landscape',
			'step'        => 1,
		),
		array(
			'src'      => $jul . '2.-About-Direct-Owner-Financing-1-1.mp4',
			'question' => 'How does Direct Owner Financing work?',
			'answer'   => 'We act as the bank, so there is no traditional lender involved. You put money down, we finance the rest, and you pay us directly.',
			'category' => 'financing',
			'date'     => '2026-07-01',
			'featured' => true,
		),
		array(
			'src'      => $jul . '3.-About-the-Minimum-Requirements-1-1.mp4',
			'question' => 'What are the minimum requirements to qualify?',
			'answer'   => 'The short list of what you need to apply — income, documents and down payment — so you know before you start whether you qualify.',
			'category' => 'getting-started',
			'date'     => '2026-07-01',
			'featured' => true,
			'step'     => 2,
		),
		array(
			'src'      => $jul . '4.-How-to-Apply-with-a-Co-Applicant-2.mp4',
			'question' => 'How do I apply with a co-applicant?',
			'answer'   => 'Buying with a partner, a relative or a friend: how a joint application works and what each applicant needs to provide.',
			'category' => 'getting-started',
			'date'     => '2026-07-01',
			'featured' => true,
			'step'     => 2,
		),
		array(
			'src'      => $jul . '5.-About-AML-Anti-Money-Laundering-Requirements-1.mp4',
			'question' => 'What are the AML (Anti-Money Laundering) requirements?',
			'answer'   => 'Every land purchase in the Cayman Islands has to meet AML rules. Here is what we are required to verify and which documents that means for you.',
			'category' => 'process',
			'date'     => '2026-07-01',
			'step'     => 4,
		),
		array(
			'src'      => $jul . '6_What_Happens_After_Pre_Approval_The_Closing_Process_1.mp4',
			'question' => 'What happens after pre-approval — the closing process?',
			'answer'   => 'From pre-approval to keys in hand: the closing steps, who is involved, and what you sign along the way.',
			'category' => 'process',
			'date'     => '2026-07-01',
			'step'     => 5,
		),
		array(
			'src'      => $jul . '7.-How-to-Choose-a-Lot-Interactive-Map-Tutorial-1.mp4',
			'question' => 'How do I choose a lot on the interactive map?',
			'answer'   => 'A tutorial of our interactive map: how to browse available lots, compare sizes and prices, and pick the one that fits you.',
			'category' => 'getting-started',
			'date'     => '2026-07-01',
			'step'     => 3,
		),
		array(
			'src'      => $jul . '8.-About-Elena-Estates-1.mp4',
			'question' => 'What is Elena Estates like?',
			'answer'   => 'A look at Elena Estates in Little Cayman: where it is, what the land looks like, and who it suits best.',
			'category' => 'developments',
			'date'     => '2026-07-01',
		),
		array(
			'src'      => $jul . '9.-About-High-Rock-Estates-1.mp4',
			'question' => 'What is High Rock Estates like?',
			'answer'   => 'A tour of our East End development in Grand Cayman — the terrain, the location, and what is already in place.',
			'category' => 'developments',
			'date'     => '2026-07-01',
		),
		array(
			'src'      => $jul . '10.-About-Northshore-Estates-1.mp4',
			'question' => 'What is Northshore Estates like?',
			'answer'   => 'A look at Northshore Estates near Rum Point: the setting, the lot sizes, and what makes this one different.',
			'category' => 'developments',
			'date'     => '2026-07-01',
		),

		/*
		 * The "why land at all" batch, ordered as an argument rather than by
		 * file number: knock down the affordability objection first, then
		 * scarcity, then the reasons to hold, and close on the cost of waiting.
		 */
		array(
			'src'      => $aug . '16-The-1-Myth-About-Buying-Cayman-Real-Estate-web.mp4',
			'question' => 'Do I need a lot of cash to buy land in Cayman?',
			'answer'   => 'The biggest myth about Cayman real estate is that you need hundreds of thousands in cash. With direct owner financing there is no bank — just a small deposit and a few documents.',
			'category' => 'financing',
			'date'     => '2026-08-01',
			'featured' => true,
		),
		array(
			'src'      => $aug . '17-Think-You-Cant-Afford-Island-Real-Estate_-Think-Again-web.mp4',
			'question' => 'Can I really afford island real estate?',
			'answer'   => 'You do not need to be a millionaire to own land here. A deposit as low as 5% and low fixed monthly payments put a lot within reach of a normal budget.',
			'category' => 'financing',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '12-They-Are-Not-Making-Any-More-Cayman-Islands-web.mp4',
			'question' => 'Why is land in the Cayman Islands so limited?',
			'answer'   => 'Nobody is making more land, and Grand Cayman, Little Cayman and Cayman Brac have a finite amount of developable space. As the islands grow, the options left shrink.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '11-The-_Sleep-Well_-Investment-web.mp4',
			'question' => 'Is land a safer investment than the stock market?',
			'answer'   => 'Markets swing daily and savings barely beat inflation. Land is the "sleep well at night" asset — stable, steadily growing, and something you can physically stand on.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '13-Reasons-Land-is-the-Ultimate-Future-Proof-Investment-web.mp4',
			'question' => 'Why is land a future-proof investment?',
			'answer'   => 'Three reasons: it never degrades, it needs zero maintenance, and it appreciates over time. That combination is hard to find anywhere else.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '18-The-Zero-Headache-Asset-web.mp4',
			'question' => 'Is land easier to own than a rental property?',
			'answer'   => 'No leaking roofs, no broken air conditioners, no midnight calls from tenants. Raw land just sits there quietly and grows in value.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '15-How-Raw-Land-Becomes-Real-Wealth-web.mp4',
			'question' => 'How does raw land actually build wealth?',
			'answer'   => 'You lock in today\'s price, and as the island grows and infrastructure arrives around you, the land is worth more. You build equity simply by holding it.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '19-3-Things-You-Can-Do-With-Your-Cayman-Land-Today-web.mp4',
			'question' => 'What can I do with my Cayman land right now?',
			'answer'   => 'Hold it as an investment while it appreciates, start designing your future home, or keep it as a family asset to pass on. The first step is owning it.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '14-The-Ultimate-Generational-Wealth-web.mp4',
			'question' => 'How do I build generational wealth with land?',
			'answer'   => 'Land is a permanent legacy you can pass to your children and grandchildren — a foundation your family can build on long after you buy it.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
		array(
			'src'      => $aug . '20-The-Cost-of-Waiting-web.mp4',
			'question' => 'What does it cost me to wait before buying?',
			'answer'   => 'Waiting is the real expense. The lot you are looking at today costs more tomorrow, and as inventory shrinks across the islands, prices rise with it.',
			'category' => 'investment',
			'date'     => '2026-08-01',
		),
	);

	/**
	 * Let a child theme or plugin add videos without editing this file.
	 */
	$videos = apply_filters( 'easylot_videos', $videos );

	if ( ! empty( $args['featured'] ) ) {
		$videos = array_values( array_filter( $videos, function ( $v ) {
			return ! empty( $v['featured'] );
		} ) );
	}

	if ( ! empty( $args['category'] ) ) {
		$cat    = $args['category'];
		$videos = array_values( array_filter( $videos, function ( $v ) use ( $cat ) {
			return isset( $v['category'] ) && $cat === $v['category'];
		} ) );
	}

	if ( ! empty( $args['step'] ) ) {
		$step   = (int) $args['step'];
		$videos = array_values( array_filter( $videos, function ( $v ) use ( $step ) {
			return isset( $v['step'] ) && $step === (int) $v['step'];
		} ) );
	}

	if ( ! empty( $args['limit'] ) ) {
		$videos = array_slice( $videos, 0, (int) $args['limit'] );
	}

	return $videos;
}

/**
 * A single video by the tail of its file name, e.g. '2.-About-Direct-Owner'.
 */
function easylot_video_by_file( $needle ) {
	foreach ( easylot_videos() as $v ) {
		if ( false !== strpos( $v['src'], $needle ) ) {
			return $v;
		}
	}
	return null;
}


/**
 * The hero background video.
 *
 * Local-first: drop the clip at assets/hero-bg.mp4 (export it from the
 * easylot.ky media library — uploads/2026/05/WhatsApp-Video-2026-05-28) and
 * the theme serves it from the theme folder on any domain. Until that file
 * exists it falls back to the easylot.ky URL, which works once the theme is
 * live on easylot.ky itself; on staging the poster stands in.
 */
function easylot_hero_video() {
	if ( file_exists( get_template_directory() . '/assets/hero-bg.mp4' ) ) {
		return get_template_directory_uri() . '/assets/hero-bg.mp4';
	}
	return 'https://easylot.ky/wp-content/uploads/2026/05/WhatsApp-Video-2026-05-28-at-4.12.35-PM.mp4';
}

/**
 * The clip that plays in the floating bottom-left player.
 *
 * Two files on purpose: a small silent teaser that loops in the corner without
 * costing the visitor 10MB, and the full clip with sound that only downloads
 * once they press play.
 */
function easylot_intro_video() {
	$dir = get_template_directory_uri() . '/assets/';
	return array(
		'teaser' => $dir . 'intro-teaser.mp4',
		'full'   => $dir . 'intro-full.mp4',
		'poster' => $dir . 'intro-poster.jpg',
		'label'  => 'How buying land in Cayman actually works',
		'eyebrow' => 'Watch: 42 sec',
	);
}

/**
 * The FAQ set. Rendered as an accordion and published as FAQPage schema, so
 * the answers can be quoted directly by Google and by AI assistants.
 */
function easylot_faqs() {
	return array(
		array(
			'q' => 'What is Direct Owner Financing?',
			'a' => 'Easy Lot owns the land and finances it to you directly. There is no bank, no mortgage application and no loan committee — the agreement is between you and us. You pay a down payment, then a fixed monthly amount for an agreed term, and the title transfers to you when the balance is paid.',
		),
		array(
			'q' => 'Do I need a bank or a mortgage to buy land in the Cayman Islands?',
			'a' => 'Not with us. Traditional Cayman lenders usually want 30–40% down on raw land, a local credit history and a full underwriting file. Because we finance our own lots, none of that applies — we look at whether the monthly payment fits your income, not at a credit score.',
		),
		array(
			'q' => 'How much is the down payment?',
			'a' => 'Down payments start at 5% of the lot price. Putting more down lowers your monthly payment and shortens the term, but 5% is genuinely the floor — on a $40,000 lot that is $2,000 to get started.',
		),
		array(
			'q' => 'What will my monthly payment be?',
			'a' => 'Most of our buyers land between roughly $400 and $700 a month, depending on the lot, the deposit and the term. The payment is fixed for the life of the agreement, so it does not move if rates move. Use the calculator on this page for a figure on a specific price.',
		),
		array(
			'q' => 'What documents do I need to apply?',
			'a' => 'Four: a passport, a driver\'s licence (or second photo ID), a job letter confirming your employment and income, and a recent utility bill as proof of address. That is the whole file — you can photograph all four on your phone.',
		),
		array(
			'q' => 'How long does pre-approval take?',
			'a' => 'The online form takes about five minutes and most applicants hear back the same business day. Pre-approval tells you the price range and monthly payment you qualify for before you choose a lot, and it costs nothing.',
		),
		array(
			'q' => 'Can non-Caymanians and overseas buyers own land here?',
			'a' => 'Yes. The Cayman Islands place no restriction on foreign ownership of land, there is no annual property tax, and there are no capital gains taxes. Overseas buyers complete the whole process remotely — we handle documents by email and video call.',
		),
		array(
			'q' => 'Is there a penalty if I pay the balance off early?',
			'a' => 'No. You can settle the remaining balance at any point without an early-settlement penalty, and many buyers do exactly that once a bonus or a property sale comes through.',
		),
		array(
			'q' => 'What happens at closing, and who holds the title?',
			'a' => 'Once the balance is paid, the transfer is registered with the Cayman Islands Lands and Survey Department and the title is issued in your name. Everything is recorded on the government land register, which you can search yourself at caymanlandinfo.ky.',
		),
		array(
			'q' => 'Can I build on the lot while I am still paying?',
			'a' => 'Construction normally begins once the title is in your name. In the meantime you can survey the lot, get plans drawn and take them through planning, so you are ready to break ground the day the transfer completes.',
		),
		array(
			'q' => 'What are the closing costs on Cayman land?',
			'a' => 'The main one is government stamp duty on the transfer, which is a percentage of the purchase price, plus your own legal fees if you use an attorney. There is no annual property tax in the Cayman Islands, so the recurring cost of holding land is effectively nil.',
		),
		array(
			'q' => 'Can I buy with someone else?',
			'a' => 'Yes — co-applications are common. Both applicants supply the same four documents, and both incomes count towards the payment we approve, which usually means a larger lot than either could take on alone.',
		),
		array(
			'q' => 'Owner financing or a bridging loan — which is right for buying land in Cayman?',
			'a' => 'A bridging loan is short-term money, usually 6 to 24 months, priced accordingly and repaid in a lump sum when a property sells or long-term finance arrives. It is designed to cover a gap, not to buy and hold land. Owner financing is the opposite: a long fixed term, a small deposit, a predictable monthly payment and no balloon at the end. If you are buying a lot to keep, owner financing is the cheaper and far less stressful of the two.',
		),
		array(
			'q' => 'How much does it cost to buy land in the Cayman Islands?',
			'a' => 'Our lots start around $39,900, and the entry cost is the down payment rather than the full price — from 5%, so roughly $2,000 on a $40,000 lot. On top of the purchase price you should budget for government stamp duty on the transfer and your own legal fees if you use an attorney. After that there is nothing recurring: the Cayman Islands have no annual property tax.',
		),
	);
}

/**
 * Does this page have real content of its own?
 *
 * The About, Team, Directions and Contact templates print the_content() as an
 * optional extra rather than as the page. This is what lets them stay designed
 * when the page body is empty, which is the state most of them are in after a
 * theme change.
 */
function easylot_has_content( $post = null ) {
	$content = get_post_field( 'post_content', $post ? $post : get_the_ID() );
	return '' !== trim( wp_strip_all_tags( (string) $content ) );
}

/**
 * Strip presentation off content written for the previous theme.
 *
 * The old site was built on Tailwind utility classes and inline styles. That
 * stylesheet is gone, so the markup survives with no design behind it — which
 * is why pages carried over from it look unstyled next to the rest of the site.
 * Removing class and style attributes leaves the semantics (headings, lists,
 * links, images, tables) for .entry-content to style properly.
 *
 * Elementor content is left alone: its classes are how it renders at all.
 */
function easylot_clean_legacy_markup( $html ) {
	$html = preg_replace( '#<style[^>]*>.*?</style>#is', '', $html );
	$html = preg_replace( '#\s(?:class|style)="[^"]*"#i', '', $html );
	$html = preg_replace( "#\s(?:class|style)='[^']*'#i", '', $html );
	// Old layout wrappers with nothing left in them.
	$html = preg_replace( '#<(div|span|section)>\s*</\1>#i', '', $html );
	return $html;
}

/**
 * Print the page body, cleaned of dead legacy styling.
 */
function easylot_the_clean_content() {
	$html = apply_filters( 'the_content', get_the_content() );

	if ( ! easylot_is_built_with_elementor( get_the_ID() ) ) {
		$html = easylot_clean_legacy_markup( $html );
	}

	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * The team, for template-team.php.
 *
 * Deliberately empty: the theme will not invent names or photographs. Fill this
 * in and the page renders a card grid; leave it and the page renders the page's
 * own content, or its designed fallback if that is empty too.
 *
 * Each entry: array( 'name' => '', 'role' => '', 'photo' => '' )
 */
function easylot_team() {
	return apply_filters( 'easylot_team', array() );
}

function easylot_testimonials() {
	return array(
		array(
			'quote' => 'Two banks told me raw land was not something they finance. Easy Lot pre-approved me in an afternoon and I was paying towards my own lot the same month.',
			'name'  => 'Andrea M.',
			'where' => 'Bought in High Rock Estates',
		),
		array(
			'quote' => 'I am overseas and did the entire thing by email and WhatsApp. The four documents were exactly the four documents — nothing appeared later.',
			'name'  => 'Kevin R.',
			'where' => 'Bought in Elena Estates, Little Cayman',
		),
		array(
			'quote' => 'The payment has not changed once. I know what leaves my account every month and I know what I own at the end of it.',
			'name'  => 'Sheena B.',
			'where' => 'Bought in Northshore Estates',
		),
	);
}


/**
 * Print the site logo.
 *
 * Priority: the custom logo uploaded under Appearance > Customize > Site
 * Identity (local to whichever domain the theme runs on), then the remote SVG
 * from easylot.ky. easylot.ky sits behind a WAF that can refuse hotlinked
 * media, so if the image fails onerror swaps in a typographic mark rather than
 * leaving broken-image alt text in the nav.
 *
 * @param int $height Rendered height in px.
 */
function easylot_logo_img( $height = 34 ) {
	$c        = easylot_contact();
	$src      = $c['logo'];
	$logo_id  = (int) get_theme_mod( 'custom_logo' );

	if ( $logo_id ) {
		$local = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $local ) {
			$src = $local;
		}
	}

	$fallback = "this.outerHTML='<span class=&quot;logo-text&quot;>EASY<em>LOT</em></span>'";

	printf(
		'<img src="%s" alt="%s" style="height:%dpx" onerror="%s">',
		esc_url( $src ),
		esc_attr( get_bloginfo( 'name' ) ),
		(int) $height,
		$fallback // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static attribute above.
	);
}

/* ==========================================================================
 * 4. URL helpers
 *
 * Slugs on this site have changed before (/faq/ vs /frequently-asked-questions/),
 * so links are resolved once here rather than hardcoded across the templates.
 * ========================================================================== */

function easylot_find_url( $slugs, $fallback ) {
	foreach ( (array) $slugs as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return home_url( $fallback );
}

function easylot_url( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}

	$map = array(
		'faq'          => array( array( 'faq', 'frequently-asked-questions' ), '/frequently-asked-questions/' ),
		'videos'       => array( array( 'video-guides' ), '/video-guides/' ),
		'how'          => array( array( 'how-to-buy-land-in-cayman', 'how-it-works' ), '/how-to-buy-land-in-cayman/' ),
		'developments' => array( array( 'all-our-developments', 'developments' ), '/all-our-developments/' ),
		'about'        => array( array( 'about-us' ), '/about-us/' ),
		'team'         => array( array( 'team-members', 'meet-the-team' ), '/team-members/' ),
		'contact'      => array( array( 'contact-us', 'contact' ), '/contact-us/' ),
		'directions'   => array( array( 'directions' ), '/directions/' ),
	);

	if ( ! isset( $map[ $key ] ) ) {
		return home_url( '/' );
	}

	$cache[ $key ] = easylot_find_url( $map[ $key ][0], $map[ $key ][1] );
	return $cache[ $key ];
}

/* ==========================================================================
 * 5. Inline SVG icons
 *
 * A font just for icons would be a second render-blocking download, so the
 * handful of glyphs the theme uses are inlined instead.
 * ========================================================================== */

function easylot_icon( $name, $class = '' ) {
	$p = array(
		'check'     => '<path d="M20 6 9 17l-5-5"/>',
		'check-c'   => '<circle cx="12" cy="12" r="9"/><path d="m8.5 12.2 2.4 2.4 4.6-4.9"/>',
		'x'         => '<path d="M18 6 6 18M6 6l12 12"/>',
		'x-c'       => '<circle cx="12" cy="12" r="9"/><path d="m9.2 9.2 5.6 5.6M14.8 9.2l-5.6 5.6"/>',
		'plus'      => '<path d="M12 5v14M5 12h14"/>',
		'chevron'   => '<path d="m6 9 6 6 6-6"/>',
		'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'play'      => '<path d="M8 5.5v13l11-6.5z" fill="currentColor" stroke="none"/>',
		'menu'      => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'pin'       => '<path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/>',
		'phone'     => '<path d="M6.5 3h3l1.5 4-2 1.5a12 12 0 0 0 6.5 6.5L17 13l4 1.5v3a2 2 0 0 1-2.2 2A17 17 0 0 1 3.5 5.2 2 2 0 0 1 5.5 3Z"/>',
		'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6 8.5-6"/>',
		'doc'       => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/>',
		'id'        => '<rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M5.8 16.4a3.6 3.6 0 0 1 6.4 0M14.5 10h4M14.5 13.5h4"/>',
		'passport'  => '<rect x="5" y="3" width="14" height="18" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M9 16.5h6"/>',
		'bill'      => '<path d="M5 3h14v18l-3-1.7-2 1.7-2-1.7-2 1.7-2-1.7L5 21z"/><path d="M9 8h6M9 12h6"/>',
		'bank'      => '<path d="M3 10h18M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 21h18M12 3l9 5H3z"/>',
		'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.2l3.2 2"/>',
		'shield'    => '<path d="M12 3 5 6v5.5c0 4.3 3 8.2 7 9.5 4-1.3 7-5.2 7-9.5V6z"/><path d="m9.2 12 2 2 3.6-3.8"/>',
		'coins'     => '<ellipse cx="12" cy="6.5" rx="7" ry="3"/><path d="M5 6.5v5c0 1.7 3.1 3 7 3s7-1.3 7-3v-5M5 11.5v5c0 1.7 3.1 3 7 3s7-1.3 7-3v-5"/>',
		'map'       => '<path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3z"/><path d="M9 3v15M15 6v15"/>',
		'key'       => '<circle cx="8" cy="15" r="4"/><path d="m11 12 8-8 2 2-2 2 2 2-2 2-2-2-2 2"/>',
		'star'      => '<path d="m12 3.5 2.6 5.4 5.9.8-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9L3.5 9.7l5.9-.8z" fill="currentColor" stroke="none"/>',
		'spark'     => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.5 2.5M15.5 15.5 18 18M18 6l-2.5 2.5M8.5 15.5 6 18"/>',
		'chart'     => '<path d="M4 20V4M4 20h16"/><path d="m7.5 15 3.5-4 3 2.6L19 7"/>',
		'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3.5 9h17M3.5 15h17M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/>',
		'facebook'  => '<path d="M14 8.5V7a1.5 1.5 0 0 1 1.5-1.5H17V3h-2.2A4 4 0 0 0 11 7v1.5H9V11h2v10h3V11h2.2l.4-2.5z" fill="currentColor" stroke="none"/>',
		'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="3.8"/><circle cx="17" cy="7" r="1.1" fill="currentColor" stroke="none"/>',
		'youtube'   => '<rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="m10.5 9.5 5 2.5-5 2.5z" fill="currentColor" stroke="none"/>',
		'tiktok'    => '<path d="M14 3.5v10.8a3.3 3.3 0 1 1-2.8-3.3" /><path d="M14 3.5a5 5 0 0 0 5 4.4"/>',
		'whatsapp'  => '<path d="M12 2a10 10 0 0 0-8.5 15.2L2 22l4.9-1.4A10 10 0 1 0 12 2Z"/><path d="M8.6 7.7c.2-.4.4-.4.7-.4h.6c.2 0 .4 0 .6.5l.8 1.9c.1.2 0 .4-.1.6l-.5.6c-.2.2-.3.4-.1.7a7.3 7.3 0 0 0 3.4 3c.3.2.5.1.7-.1l.6-.7c.2-.2.4-.2.6-.1l1.9.9c.3.1.4.3.4.5v.7c0 .4-.3.9-.7 1.1-1 .5-2.2.4-3.4 0a11 11 0 0 1-6-5.6c-.5-1.2-.6-2.5-.1-3.4z" fill="currentColor" stroke="none"/>',
	);

	if ( ! isset( $p[ $name ] ) ) {
		return '';
	}

	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $p[ $name ] . '</svg>';
}

function easylot_the_icon( $name, $class = '' ) {
	echo easylot_icon( $name, $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/* ==========================================================================
 * 6. Video rendering
 * ========================================================================== */

function easylot_video_orientation( $v ) {
	return ( isset( $v['orientation'] ) && 'landscape' === $v['orientation'] ) ? 'landscape' : 'vertical';
}

function easylot_video_poster( $v ) {
	if ( ! empty( $v['poster'] ) ) {
		return $v['poster'];
	}
	// Local card, not the easylot.ky aerial: the staging domain cannot
	// hotlink easylot.ky media through its WAF.
	return get_template_directory_uri() . '/assets/og/og-videos.jpg';
}

/**
 * One video card.
 *
 * Deliberately a facade: preload="metadata" plus a #t= fragment fetches only
 * the first few KB so the poster frame shows, and the real player is only
 * opened — with sound — when the visitor clicks. Twenty autoplaying videos on
 * one page would otherwise be tens of megabytes.
 */
function easylot_video_card( $v, $args = array() ) {
	$args = wp_parse_args( $args, array( 'tag' => '' ) );

	$orientation = easylot_video_orientation( $v );
	$classes     = 'vcard' . ( 'landscape' === $orientation ? ' vcard--landscape' : '' );
	$cats        = easylot_video_categories();
	$cat_label   = isset( $cats[ $v['category'] ] ) ? $cats[ $v['category'] ] : '';
	$tag         = $args['tag'] ? $args['tag'] : $cat_label;
	?>
	<div class="<?php echo esc_attr( $classes ); ?> reveal"
	     role="button" tabindex="0"
	     data-video="<?php echo esc_url( $v['src'] ); ?>"
	     data-orientation="<?php echo esc_attr( $orientation ); ?>"
	     data-caption="<?php echo esc_attr( $v['question'] ); ?>"
	     data-category="<?php echo esc_attr( $v['category'] ); ?>"
	     aria-label="<?php echo esc_attr( 'Play video: ' . $v['question'] ); ?>">
		<video src="<?php echo esc_url( $v['src'] ); ?>#t=0.6"
		       preload="metadata" muted playsinline
		       poster="<?php echo esc_url( easylot_video_poster( $v ) ); ?>"
		       tabindex="-1" aria-hidden="true"></video>
		<span class="vcard__veil"></span>
		<?php if ( $tag ) : ?>
			<span class="vcard__tag"><?php echo wp_kses_post( $tag ); ?></span>
		<?php endif; ?>
		<span class="vcard__play"><?php easylot_the_icon( 'play' ); ?></span>
		<div class="vcard__body">
			<h3 class="vcard__q"><?php echo esc_html( $v['question'] ); ?></h3>
			<p class="vcard__a"><?php echo esc_html( $v['answer'] ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Grid of video cards.
 */
function easylot_video_grid( $videos, $args = array() ) {
	$args = wp_parse_args( $args, array( 'cols' => 4, 'id' => '' ) );
	if ( empty( $videos ) ) {
		return;
	}
	?>
	<div class="grid grid--media grid-<?php echo (int) $args['cols'] ; ?>"<?php echo $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
		<?php foreach ( $videos as $v ) : ?>
			<?php easylot_video_card( $v ); ?>
		<?php endforeach; ?>
	</div>
	<?php
}

/* ==========================================================================
 * 7. Floating mini player + shared lightbox
 * ========================================================================== */

function easylot_render_video_ui() {
	$intro = easylot_intro_video();
	?>
	<!-- Shared lightbox: video cards and the mini player both hand their file to this. -->
	<div class="vbox" id="vbox" role="dialog" aria-modal="true" aria-label="Video player" hidden>
		<div class="vbox__inner" id="vbox-inner">
			<div class="vbox__close" id="vbox-close" role="button" tabindex="0" aria-label="Close video">
				<?php easylot_the_icon( 'x' ); ?>
			</div>
			<div id="vbox-slot"></div>
			<div class="vbox__cap" id="vbox-cap"></div>
		</div>
	</div>

	<!-- Floating player, bottom-left: silent looping teaser until pressed. -->
	<div class="miniplayer" id="miniplayer"
	     role="button" tabindex="0"
	     data-full="<?php echo esc_url( $intro['full'] ); ?>"
	     data-caption="<?php echo esc_attr( $intro['label'] ); ?>"
	     aria-label="<?php echo esc_attr( 'Play video: ' . $intro['label'] ); ?>">
		<video id="miniplayer-video"
		       src="<?php echo esc_url( $intro['teaser'] ); ?>"
		       poster="<?php echo esc_url( $intro['poster'] ); ?>"
		       muted loop playsinline preload="none"
		       tabindex="-1" aria-hidden="true"></video>
		<span class="miniplayer__veil"></span>
		<span class="miniplayer__mute">Muted</span>
		<span class="miniplayer__x" id="miniplayer-close" role="button" tabindex="0" aria-label="Hide this video">
			<?php easylot_the_icon( 'x' ); ?>
		</span>
		<span class="miniplayer__play"><?php easylot_the_icon( 'play' ); ?></span>
		<span class="miniplayer__label">
			<span><?php echo esc_html( $intro['eyebrow'] ); ?></span>
			<?php echo esc_html( $intro['label'] ); ?>
		</span>
	</div>
	<?php
}
// Priority 5: the markup must be in the DOM before wp_print_footer_scripts
// (priority 20) runs main.js, or the player never finds #miniplayer.
add_action( 'wp_footer', 'easylot_render_video_ui', 5 );

/* ==========================================================================
 * 8. Structured data
 *
 * One @graph in the <head> covering the business, the site, the page and the
 * agency that built it. Nothing here renders visually.
 * ========================================================================== */

/**
 * The Toc Toc agency entity.
 *
 * These @id values are stable across every site Toc Toc builds — they are what
 * consolidates the agency into a single entity for search engines and AI
 * assistants, so they must never be rewritten per-site.
 */
function easylot_toctoc_nodes() {
	return array(
		array(
			'@type'      => array( 'Organization', 'ProfessionalService' ),
			'@id'        => 'https://toctoc.ky/#organization',
			'name'       => 'TocToc',
			'url'        => 'https://toctoc.ky/',
			'description' => 'Web design, development, and SEO agency based in the Cayman Islands.',
			'areaServed' => 'Cayman Islands',
			'knowsAbout' => array( 'Web Design', 'Web Development', 'Search Engine Optimization', 'WordPress', 'Brand Identity' ),
			'founder'    => array( '@id' => 'https://toctoc.ky/#daniel-garrido' ),
			'employee'   => array( '@id' => 'https://www.linkedin.com/in/andre-g-9b373a97/#person' ),
			'sameAs'     => array( 'https://toctoc.ky/' ),
		),
		array(
			'@type'      => 'Person',
			'@id'        => 'https://toctoc.ky/#daniel-garrido',
			'name'       => 'Daniel Garrido',
			'jobTitle'   => 'CEO',
			'worksFor'   => array( '@id' => 'https://toctoc.ky/#organization' ),
			'knowsAbout' => array( 'Web Design', 'Search Engine Optimization', 'Digital Marketing', 'Brand Strategy' ),
			'sameAs'     => array( 'https://www.linkedin.com/in/bydanielgarrido/' ),
		),
		array(
			'@type'      => 'Person',
			'@id'        => 'https://www.linkedin.com/in/andre-g-9b373a97/#person',
			'name'       => 'Andre Gutierrez',
			'jobTitle'   => 'Web Developer & Technical SEO Specialist',
			'worksFor'   => array(
				array( '@id' => 'https://toctoc.ky/#organization' ),
				array( '@type' => 'Organization', 'name' => 'Polimedios', 'url' => 'https://polimedios.com/' ),
			),
			'knowsAbout' => array( 'Web Development', 'WordPress', 'PHP', 'Front-End Development', 'Search Engine Optimization', 'Schema Markup', 'Vibe Coding' ),
			'sameAs'     => array( 'https://www.linkedin.com/in/andre-g-9b373a97/' ),
		),
	);
}

function easylot_schema_graph() {
	$c        = easylot_contact();
	$home     = home_url( '/' );
	$name     = get_bloginfo( 'name' );
	$page_url = easylot_current_url();

	$graph = array();

	// The business.
	$graph[] = array(
		'@type'       => array( 'RealEstateAgent', 'LocalBusiness' ),
		'@id'         => $home . '#organization',
		'name'        => $name,
		'url'         => $home,
		'description' => 'Land for sale in the Cayman Islands with Direct Owner Financing — no banks, down payments from 5% and fixed monthly payments.',
		'logo'        => array(
			'@type' => 'ImageObject',
			'@id'   => $home . '#logo',
			'url'   => $c['logo'],
		),
		'image'       => $c['og_image'],
		'telephone'   => $c['phone'],
		'email'       => $c['email'],
		'priceRange'  => '$$',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $c['street'],
			'addressLocality' => $c['locality'],
			'addressRegion'   => $c['region'],
			'addressCountry'  => $c['country'],
		),
		'areaServed'  => array(
			array( '@type' => 'Place', 'name' => 'Grand Cayman' ),
			array( '@type' => 'Place', 'name' => 'Little Cayman' ),
			array( '@type' => 'Place', 'name' => 'Cayman Brac' ),
		),
		'knowsAbout'  => array(
			'Land for sale in the Cayman Islands',
			'Owner financed land',
			'Seller financing',
			'Cayman Islands real estate',
			'Buying land without a bank',
		),
		'sameAs'      => array_values( $c['social'] ),
	);

	// The website — creator points at the agency entity above.
	$graph[] = array(
		'@type'           => 'WebSite',
		'@id'             => $home . '#website',
		'url'             => $home,
		'name'            => $name,
		'inLanguage'      => 'en-US',
		'publisher'       => array( '@id' => $home . '#organization' ),
		'creator'         => array( '@id' => 'https://toctoc.ky/#organization' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => $home . '?s={search_term_string}',
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	// This page.
	$graph[] = array(
		'@type'      => 'WebPage',
		'@id'        => $page_url . '#webpage',
		'url'        => $page_url,
		'name'       => easylot_seo_title(),
		'description' => easylot_seo_description(),
		'isPartOf'   => array( '@id' => $home . '#website' ),
		'about'      => array( '@id' => $home . '#organization' ),
		'creator'    => array( '@id' => 'https://toctoc.ky/#organization' ),
		'inLanguage' => 'en-US',
	);

	// The agency entity: invisible, code only.
	$graph = array_merge( $graph, easylot_toctoc_nodes() );

	/**
	 * Templates add FAQPage, ItemList, VideoObject and BreadcrumbList nodes
	 * through this filter rather than printing a second <script> block.
	 */
	$graph = apply_filters( 'easylot_schema_graph', $graph );

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => array_values( $graph ),
	);
}

function easylot_print_schema() {
	$json = wp_json_encode( easylot_schema_graph(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	echo "\n<script type=\"application/ld+json\">" . $json . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * FAQPage node — added by any template that sets $easylot_faqs before get_header().
 */
function easylot_faq_schema_node( $faqs ) {
	$items = array();
	foreach ( $faqs as $f ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $f['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( $f['a'] ),
			),
		);
	}
	return array(
		'@type'      => 'FAQPage',
		'@id'        => easylot_current_url() . '#faq',
		'mainEntity' => $items,
	);
}

/**
 * VideoObject nodes for a list of videos.
 */
function easylot_video_schema_nodes( $videos ) {
	$nodes = array();
	foreach ( $videos as $v ) {
		$nodes[] = array(
			'@type'        => 'VideoObject',
			'@id'          => $v['src'] . '#video',
			'name'         => $v['question'],
			'description'  => $v['answer'],
			'thumbnailUrl' => easylot_video_poster( $v ),
			'uploadDate'   => isset( $v['date'] ) ? $v['date'] : '2026-07-01',
			'contentUrl'   => $v['src'],
			'publisher'    => array( '@id' => home_url( '/' ) . '#organization' ),
		);
	}
	return $nodes;
}

/**
 * Breadcrumbs, both as schema and as the visible trail at the top of a page.
 */
function easylot_breadcrumbs( $trail ) {
	$items = array();
	$i     = 1;
	foreach ( $trail as $label => $url ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $i++,
			'name'     => $label,
			'item'     => $url,
		);
	}
	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => easylot_current_url() . '#breadcrumbs',
		'itemListElement' => $items,
	);
}

function easylot_the_crumbs( $trail ) {
	echo '<nav class="crumbs" aria-label="Breadcrumb">';
	$last = array_key_last( $trail );
	foreach ( $trail as $label => $url ) {
		if ( $label === $last ) {
			echo '<span aria-current="page">' . esc_html( $label ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
			echo easylot_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
	echo '</nav>';
}

/* ==========================================================================
 * 9. SEO head
 *
 * If Rank Math or Yoast is active they own the title and meta tags and this
 * steps aside — only the @graph above is always ours.
 * ========================================================================== */

function easylot_seo_plugin_active() {
	return defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

function easylot_current_url() {
	if ( is_singular() ) {
		$permalink = get_permalink();
		if ( $permalink ) {
			return $permalink;
		}
	}
	global $wp;
	return home_url( add_query_arg( array(), isset( $wp->request ) ? $wp->request : '' ) );
}

function easylot_seo_title() {
	global $easylot_seo_title;
	if ( ! empty( $easylot_seo_title ) ) {
		return $easylot_seo_title;
	}
	if ( is_front_page() ) {
		return 'Land for Sale in the Cayman Islands — Owner Financed, No Banks | ' . get_bloginfo( 'name' );
	}
	if ( is_singular() ) {
		return get_the_title() . ' | ' . get_bloginfo( 'name' );
	}
	return wp_get_document_title();
}

function easylot_seo_description() {
	global $easylot_seo_description;
	if ( ! empty( $easylot_seo_description ) ) {
		return $easylot_seo_description;
	}
	return 'Buy land in Grand Cayman and Little Cayman with Direct Owner Financing. No banks, no mortgage, down payments from 5%, fixed monthly payments and a 5-minute online pre-approval.';
}


/**
 * The Open Graph card for the current URL.
 *
 * One designed 1200x630 card per page, generated in the theme's "Ledger"
 * language and shipped in assets/og/ so they deploy with git and never depend
 * on the easylot.ky media library.
 */
function easylot_og_image() {
	$base = get_template_directory_uri() . '/assets/og/';

	if ( is_front_page() ) {
		return $base . 'og-home.jpg';
	}
	if ( is_singular( 'project' ) ) {
		return $base . 'og-developments.jpg';
	}
	if ( is_page() ) {
		$map = array(
			'template-how-to-buy.php'   => 'og-how.jpg',
			'template-developments.php' => 'og-developments.jpg',
			'template-video-guides.php' => 'og-videos.jpg',
			'template-faq.php'          => 'og-faq.jpg',
			'template-contact.php'      => 'og-contact.jpg',
			'template-about.php'        => 'og-about.jpg',
			'template-team.php'         => 'og-team.jpg',
			'template-directions.php'   => 'og-directions.jpg',
		);
		$tpl = get_page_template_slug();
		if ( isset( $map[ $tpl ] ) ) {
			return $base . $map[ $tpl ];
		}
	}
	return $base . 'og-default.jpg';
}

function easylot_head() {
	global $easylot_seo_image;
	$c = easylot_contact();

	if ( ! empty( $easylot_seo_image ) ) {
		$image = $easylot_seo_image; // a template asked for something specific
	} elseif ( is_singular( 'post' ) && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'full' ); // blog posts keep their own art
	} else {
		$image = easylot_og_image();
	}

	$url = easylot_current_url();

	if ( ! easylot_seo_plugin_active() ) {
		echo '<meta name="description" content="' . esc_attr( easylot_seo_description() ) . '" />' . "\n";
		echo '<link rel="canonical" href="' . esc_url( $url ) . '" />' . "\n";
		echo '<meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />' . "\n";
		echo '<meta property="og:type" content="website" />' . "\n";
		echo '<meta property="og:locale" content="en_US" />' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( easylot_seo_title() ) . '" />' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( easylot_seo_description() ) . '" />' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . "\n";
		echo '<meta property="og:image:width" content="1200" />' . "\n";
		echo '<meta property="og:image:height" content="630" />' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( easylot_seo_title() ) . '" />' . "\n";
		echo '<meta name="twitter:description" content="' . esc_attr( easylot_seo_description() ) . '" />' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '" />' . "\n";
	}

	echo '<meta name="theme-color" content="#fff8f5" />' . "\n";
	easylot_print_schema();
}
add_action( 'wp_head', 'easylot_head', 2 );

/**
 * Let a template override the document title without a plugin.
 */
function easylot_document_title( $title ) {
	global $easylot_seo_title;
	return ! empty( $easylot_seo_title ) && ! easylot_seo_plugin_active() ? $easylot_seo_title : $title;
}
add_filter( 'pre_get_document_title', 'easylot_document_title' );

/* ==========================================================================
 * 10. llms.txt
 *
 * Served from the theme root at /llms.txt so AI assistants get a plain-text
 * summary of what this site is and who built it.
 * ========================================================================== */

function easylot_llms_txt() {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}
	$path = wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	if ( '/llms.txt' !== untrailingslashit( $path ) && '/llms.txt' !== $path ) {
		return;
	}
	$file = get_template_directory() . '/llms.txt';
	if ( ! file_exists( $file ) ) {
		return;
	}
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: all' );
	echo file_get_contents( $file ); // phpcs:ignore
	exit;
}
add_action( 'template_redirect', 'easylot_llms_txt', 1 );

/* ==========================================================================
 * 11. Housekeeping
 * ========================================================================== */

// Emoji script and styles are dead weight on every page.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

/**
 * Excerpt length and ending, used by the blog archive.
 */
function easylot_excerpt_length() {
	return 28;
}
add_filter( 'excerpt_length', 'easylot_excerpt_length' );

function easylot_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'easylot_excerpt_more' );

/**
 * Body classes used by the stylesheet to switch a couple of layouts.
 */
function easylot_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'easylot_body_class' );
