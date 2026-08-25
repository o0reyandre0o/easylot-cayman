<?php
/**
 * Template Name: How to Buy Land (Guide)
 *
 * The cornerstone educational page: the whole owner-financing purchase
 * explained end to end, with the matching video pinned to each step.
 *
 * Assign it to a page at /how-to-buy-land-in-cayman/ — easylot_url('how')
 * looks for that slug first and falls back to /how-it-works/.
 *
 * @package EasyLotCayman
 */

$c    = easylot_contact();
$devs = easylot_developments();
$faqs = easylot_faqs();

$GLOBALS['easylot_seo_title']       = 'How to Buy Land in the Cayman Islands Without a Bank | Easy Lot';
$GLOBALS['easylot_seo_description'] = 'A step-by-step guide to buying land in the Cayman Islands with direct owner financing: what you need, what it costs, how long it takes, and how the title ends up in your name.';

$trail = array(
	'Home'                => home_url( '/' ),
	'How to Buy Land'     => easylot_url( 'how' ),
);

/**
 * The steps are data rather than markup because they are rendered twice: once
 * as the table of contents, once as the body.
 */
$steps = array(
	array(
		'id'    => 'step-1',
		'n'     => '01',
		'short' => 'Get pre-approved',
		'title' => 'Get pre-approved before you choose anything',
		'time'  => '5 minutes',
		'body'  => array(
			'Almost everybody does this in the wrong order — they find a lot they love, then discover what they can borrow. Pre-approval flips it. You tell us your income and your circumstances, and we tell you the price range and the monthly payment you qualify for.',
			'It is free, it takes about five minutes online, and it is not a credit application, so nothing is recorded against you. Most applicants get an answer the same business day.',
		),
		'points' => array(
			'No cost and no obligation to buy',
			'Leaves no mark on your credit file',
			'Tells you your ceiling before you fall in love with a lot',
		),
		'icon'  => 'clock',
	),
	array(
		'id'    => 'step-2',
		'n'     => '02',
		'short' => 'Send four documents',
		'title' => 'Send the four documents',
		'time'  => 'Same day',
		'body'  => array(
			'This is the entire application file. A passport, a driver’s licence or second photo ID, a job letter confirming your employer, role and income, and a recent utility bill in your name for proof of address.',
			'Phone photographs are fine as long as all four corners are visible and the text is readable. Buying with a partner, a relative or a friend? Each applicant sends the same four, and both incomes count towards the approval — which usually means a bigger lot than either of you would reach alone.',
		),
		'points' => array(
			'Passport',
			'Driver’s licence or second photo ID',
			'Job letter with role and income',
			'Recent utility bill for proof of address',
		),
		'icon'  => 'doc',
	),
	array(
		'id'    => 'step-3',
		'n'     => '03',
		'short' => 'Choose your lot',
		'title' => 'Choose your lot on the interactive map',
		'time'  => 'Take your time',
		'body'  => array(
			'Each development page carries a live interactive map of the site. You can see which parcels are still available, compare sizes and prices, and understand exactly where a lot sits — how far from the road, how far from the water, what is next to it.',
			'When you find the one, we hold it for you while the agreement is prepared. If you are overseas, we will walk the map with you on a video call and send photographs and drone footage of the specific parcel.',
		),
		'points' => array(
			'Availability updated on the map itself',
			'Compare size, price and position side by side',
			'Reserve the parcel while paperwork is drawn up',
		),
		'icon'  => 'map',
	),
	array(
		'id'    => 'step-4',
		'n'     => '04',
		'short' => 'Sign & pay the deposit',
		'title' => 'Sign, pay the down payment, clear AML',
		'time'  => 'A few days',
		'body'  => array(
			'You sign the purchase agreement, which states the price, the deposit, the monthly payment and the term in plain figures, and you pay the down payment — from 5% of the price.',
			'Every land transaction in the Cayman Islands has to satisfy anti-money-laundering rules. That is what the identity and address documents are for: we are required to verify who you are and where your funds come from. Overseas buyers complete this remotely by email and video call.',
		),
		'points' => array(
			'Down payment from 5% of the purchase price',
			'Fixed monthly figure written into the agreement',
			'AML and identity verification, as the law requires',
		),
		'icon'  => 'shield',
	),
	array(
		'id'    => 'step-5',
		'n'     => '05',
		'short' => 'Pay monthly, take title',
		'title' => 'Pay monthly, then take the title',
		'time'  => 'Your chosen term',
		'body'  => array(
			'A fixed amount leaves your account each month for the agreed term. It does not move when rates move, and there is no penalty if you clear the balance early — a lot of buyers settle sooner than planned when a bonus or a property sale comes through.',
			'When the balance reaches zero, the transfer is registered with the Cayman Islands Lands and Survey Department and the title is issued in your name. You can search the register yourself at caymanlandinfo.ky at any point.',
		),
		'points' => array(
			'Fixed payment for the life of the agreement',
			'No early-settlement penalty',
			'Title registered with Lands &amp; Survey in your name',
		),
		'icon'  => 'key',
	),
);

add_filter( 'easylot_schema_graph', function ( $graph ) use ( $trail, $faqs, $steps ) {
	$graph[] = easylot_breadcrumbs( $trail );
	$graph[] = easylot_faq_schema_node( array_slice( $faqs, 0, 8 ) );

	// HowTo: the five steps, machine-readable, so an assistant can quote the
	// sequence without having to infer it from prose.
	$how_steps = array();
	$i         = 1;
	foreach ( $steps as $s ) {
		$how_steps[] = array(
			'@type'    => 'HowToStep',
			'position' => $i++,
			'name'     => $s['short'],
			'text'     => wp_strip_all_tags( $s['body'][0] ),
			'url'      => easylot_url( 'how' ) . '#' . $s['id'],
		);
	}
	$graph[] = array(
		'@type'       => 'HowTo',
		'@id'         => easylot_url( 'how' ) . '#howto',
		'name'        => 'How to buy land in the Cayman Islands with owner financing',
		'description' => 'The five steps from pre-approval to registered title when you buy land direct from the owner, without a bank.',
		'totalTime'   => 'P30D',
		'step'        => $how_steps,
	);

	$videos = array();
	for ( $s = 1; $s <= 5; $s++ ) {
		$videos = array_merge( $videos, easylot_videos( array( 'step' => $s ) ) );
	}
	return array_merge( $graph, easylot_video_schema_nodes( $videos ) );
} );

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php easylot_the_crumbs( $trail ); ?>
		<span class="eyebrow">The complete guide</span>
		<h1>How to buy land in the Cayman&nbsp;Islands <span class="accent">without a bank</span></h1>
		<p class="lede">
			Raw land is the hardest thing in the Cayman Islands to get a mortgage on — which is
			why most people who want a lot here never get one. This page is the whole alternative,
			written out: what direct owner financing is, who can use it, what it costs, and the
			five steps between reading this and having a title in your name.
		</p>
		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get pre-approved free <?php easylot_the_icon( 'arrow' ); ?></a>
			<a class="btn btn--ghost btn--lg" href="#step-1">Jump to step one</a>
		</div>
	</div>
</header>

<!-- ============================================================ WHAT IT IS -->
<section class="section section--paper">
	<div class="wrap hero__grid">
		<div>
			<span class="eyebrow">Start here</span>
			<h2>What “direct owner financing” actually means</h2>
			<p class="lede" style="margin-bottom:22px;">
				Easy Lot owns the land. When you buy a lot from us, we also finance it — so the
				agreement is between you and the person who holds the title, with nobody in the
				middle.
			</p>
			<p>
				That single fact is what changes everything downstream. There is no mortgage
				application, because there is no mortgage. There is no credit committee, because
				we make the decision. And the deposit is set by us rather than by a lender's risk
				policy, which is why it starts at 5% instead of the 30–40% a Cayman bank typically
				wants on undeveloped land.
			</p>
			<p>
				What you take on instead is straightforward: a down payment, then a fixed monthly
				payment for an agreed term. When the balance is cleared, the title transfers into
				your name and is registered with the government.
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

<!-- ============================================================ WHO CAN BUY -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Eligibility</span>
			<h2>Who is allowed to buy land in the Cayman Islands?</h2>
			<p class="lede">
				Short answer: almost anyone. The Cayman Islands place no restriction on foreign
				ownership of land, and there is no annual property tax to pay once you own it.
			</p>
		</div>

		<div class="grid grid-3">
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'pin' ); ?></span>
				<h3>Caymanians &amp; residents</h3>
				<p>The most common case. You apply, you send the four documents, and if the monthly payment fits your income, you are approved.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'globe' ); ?></span>
				<h3>Overseas buyers</h3>
				<p>No restriction on foreign ownership, no need for a local bank account or credit history, and the entire process can be completed remotely.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'coins' ); ?></span>
				<h3>Two people together</h3>
				<p>Co-applications are common. Both incomes count towards the approval, which usually puts a larger lot within reach than either could take on alone.</p>
			</div>
		</div>

		<div style="margin-top:34px;max-width:70ch;">
			<p style="font-size:.9rem;color:var(--ink-55);">
				This page explains our process, not your personal tax or legal position. Stamp duty
				is payable to the Cayman Islands Government on transfer, and you are free to
				instruct your own attorney at any point.
			</p>
		</div>
	</div>
</section>

<!-- ============================================================ TABLE OF CONTENTS -->
<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center" style="margin-bottom:34px;">
			<span class="eyebrow eyebrow--center">The process</span>
			<h2>Five steps, start to title</h2>
		</div>
		<div class="grid grid-5-toc">
			<?php foreach ( $steps as $s ) : ?>
				<a class="toc-chip reveal" href="#<?php echo esc_attr( $s['id'] ); ?>">
					<span class="toc-chip__n"><?php echo esc_html( $s['n'] ); ?></span>
					<span class="toc-chip__t"><?php echo esc_html( $s['short'] ); ?></span>
					<span class="toc-chip__d"><?php echo esc_html( $s['time'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ THE STEPS -->
<section class="section section--paper">
	<div class="wrap">
		<?php
		foreach ( $steps as $i => $s ) :
			$video = easylot_videos( array( 'step' => $i + 1, 'limit' => 1 ) );
			$video = $video ? $video[0] : null;
			?>
			<div class="steprow reveal<?php echo ( $i % 2 ) ? ' steprow--flip' : ''; ?>" id="<?php echo esc_attr( $s['id'] ); ?>">
				<div class="steprow__text">
					<span class="steprow__n"><?php echo esc_html( $s['n'] ); ?></span>
					<h2 style="font-size:clamp(1.5rem,2.8vw,2.1rem);"><?php echo esc_html( $s['title'] ); ?></h2>
					<?php foreach ( $s['body'] as $para ) : ?>
						<p><?php echo esc_html( $para ); ?></p>
					<?php endforeach; ?>

					<ul class="ticks">
						<?php foreach ( $s['points'] as $p ) : ?>
							<li><?php easylot_the_icon( 'check' ); ?> <span><?php echo wp_kses_post( $p ); ?></span></li>
						<?php endforeach; ?>
					</ul>

					<div class="step__meta"><?php easylot_the_icon( $s['icon'] ); ?> <?php echo esc_html( $s['time'] ); ?></div>
				</div>

				<div class="steprow__media">
					<?php if ( $video ) : ?>
						<?php easylot_video_card( $video, array( 'tag' => 'Step ' . ( $i + 1 ) ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- ============================================================ COSTS -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">The money, plainly</span>
			<h2>What it costs — all of it</h2>
			<p class="lede">
				Four numbers matter. Two are ours, two are the government's, and none of them
				appear later as a surprise.
			</p>
		</div>

		<div class="grid grid-4">
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'coins' ); ?></span>
				<h3>Down payment</h3>
				<p>From 5% of the lot price. On a $40,000 lot that is $2,000. More down means a lower monthly payment and a shorter term.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'chart' ); ?></span>
				<h3>Monthly payment</h3>
				<p>Fixed for the whole term. Most of our buyers land between roughly $400 and $700 a month depending on the lot, the deposit and the term.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'bank' ); ?></span>
				<h3>Stamp duty</h3>
				<p>Payable to the Cayman Islands Government on the transfer, as a percentage of the purchase price. This is the main closing cost.</p>
			</div>
			<div class="card reveal">
				<span class="card__icon"><?php easylot_the_icon( 'shield' ); ?></span>
				<h3>Holding costs</h3>
				<p>There is no annual property tax in the Cayman Islands and raw land needs no maintenance, so the cost of simply owning it is effectively nil.</p>
			</div>
		</div>

		<div class="btn-row" style="margin-top:44px;">
			<a class="btn btn--light btn--lg" href="<?php echo esc_url( home_url( '/#calculator' ) ); ?>">Run the numbers on a specific lot</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get an exact figure in writing</a>
		</div>
	</div>
</section>

<!-- ============================================================ MISTAKES -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Learn from other buyers</span>
			<h2>Four mistakes that cost people a lot</h2>
		</div>

		<div class="grid grid-2">
			<div class="card reveal">
				<h3>Shopping before you know your number</h3>
				<p>People fall for a parcel, then discover the payment does not fit. Pre-approval takes five minutes and reverses the order — you shop inside a range you can actually finish paying.</p>
			</div>
			<div class="card reveal">
				<h3>Assuming a bank is the only route</h3>
				<p>Two rejections on raw land is where most Cayman land dreams end. It is not a verdict on you; it is a lending policy about undeveloped property. Owner financing is a different product entirely.</p>
			</div>
			<div class="card reveal">
				<h3>Waiting for “the right moment”</h3>
				<p>Land here is finite and the islands keep building outwards. The parcel you are looking at now is the cheapest it will be — waiting is itself the expense.</p>
			</div>
			<div class="card reveal">
				<h3>Not looking at the parcel’s position</h3>
				<p>Two lots at the same price can be very different: distance from the road, elevation, what sits next door. The interactive map on each development page exists for exactly this.</p>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ WHERE -->
<section class="section section--paper-2">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Then pick a place</span>
			<h2>Where you can buy right now</h2>
		</div>

		<div class="grid grid-3">
			<?php foreach ( $devs as $d ) : ?>
				<article class="lot reveal">
					<div class="lot__img">
						<img src="<?php echo esc_url( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['name'] . ' — ' . $d['island'] ); ?>" width="640" height="480" loading="lazy">
						<span class="lot__flag<?php echo ! empty( $d['flag_alt'] ) ? ' lot__flag--olive' : ''; ?>"><?php echo esc_html( $d['flag'] ); ?></span>
					</div>
					<div class="lot__body">
						<div class="lot__where"><?php easylot_the_icon( 'pin' ); ?> <?php echo esc_html( $d['island'] ); ?></div>
						<h3><?php echo esc_html( $d['name'] ); ?></h3>
						<p><?php echo esc_html( $d['blurb'] ); ?></p>
						<div class="lot__price"><b><?php echo esc_html( $d['from'] ); ?></b><span>starting price</span></div>
						<a class="btn btn--ink btn--wide" href="<?php echo esc_url( $d['link'] ); ?>">View lots &amp; map <?php easylot_the_icon( 'arrow' ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ FAQ -->
<section class="section section--paper">
	<div class="wrap-narrow">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Still wondering</span>
			<h2>Questions people ask at this point</h2>
		</div>

		<div class="faq">
			<?php foreach ( array_slice( $faqs, 0, 8 ) as $i => $f ) : ?>
				<div class="faq__item">
					<div class="faq__q" role="button" tabindex="0" aria-expanded="false">
						<span><?php echo esc_html( $f['q'] ); ?></span>
						<span class="faq__ic"><?php easylot_the_icon( 'plus' ); ?></span>
					</div>
					<div class="faq__a"><div><?php echo esc_html( $f['a'] ); ?></div></div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="btn-row btn-row--center" style="margin-top:40px;">
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">All <?php echo count( $faqs ); ?> answers</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">Watch instead</a>
		</div>
	</div>
</section>

<!-- ============================================================ CTA -->
<section class="section section--tight section--paper-3">
	<div class="wrap">
		<div class="cta-band reveal">
			<h2>Step one takes five minutes</h2>
			<p>Find out your price range and monthly payment before you choose a lot. Free, no obligation, and no mark on your credit file.</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Start my pre-approval</a>
				<a class="btn btn--ghost btn--lg" style="color:#fff;border-color:rgba(255,255,255,.5)" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
					<?php easylot_the_icon( 'whatsapp' ); ?> Ask a question first
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
