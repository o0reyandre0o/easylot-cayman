<?php
/**
 * Homepage.
 *
 * Built as a lesson rather than a brochure: it answers "how do I actually buy
 * land here without a bank?" in order — the offer, the comparison, the five
 * steps, the four documents, the numbers, then the land itself. A published
 * video is pinned to each step so a visitor can watch instead of read.
 *
 * @package EasyLotCayman
 */

$c        = easylot_contact();
$devs     = array_slice( easylot_developments(), 0, 3 ); // the three we actively push
$faqs     = array_slice( easylot_faqs(), 0, 8 );
$featured = easylot_videos( array( 'featured' => true ) );
$why      = easylot_videos( array( 'category' => 'investment', 'limit' => 4 ) );
$hero_v   = easylot_video_by_file( '2.-About-Direct-Owner-Financing' );

$GLOBALS['easylot_seo_title']       = 'Land for Sale in the Cayman Islands — Owner Financed, No Banks | Easy Lot';
$GLOBALS['easylot_seo_description'] = 'Buy land in Grand Cayman and Little Cayman direct from the owner. No bank, no mortgage: 5% down, fixed monthly payments from about $400, and a 5-minute pre-approval with four documents.';

/**
 * Homepage schema: the FAQ answers, the developments as an ItemList, and every
 * video shown on the page.
 */
add_filter( 'easylot_schema_graph', function ( $graph ) use ( $faqs, $devs, $featured, $why, $hero_v ) {
	$graph[] = easylot_faq_schema_node( $faqs );

	$list = array();
	$i    = 1;
	foreach ( $devs as $d ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $i++,
			'name'     => $d['name'],
			'url'      => $d['link'],
		);
	}
	$graph[] = array(
		'@type'           => 'ItemList',
		'@id'             => home_url( '/' ) . '#developments',
		'name'            => 'Easy Lot developments in the Cayman Islands',
		'itemListElement' => $list,
	);

	$videos = array_merge( easylot_videos( array( 'step' => 1 ) ), $featured, $why );
	if ( $hero_v ) {
		$videos[] = $hero_v;
	}
	// One node per file, even though a clip can appear in more than one row.
	$seen = array();
	$uniq = array();
	foreach ( $videos as $v ) {
		if ( isset( $seen[ $v['src'] ] ) ) {
			continue;
		}
		$seen[ $v['src'] ] = true;
		$uniq[]            = $v;
	}
	return array_merge( $graph, easylot_video_schema_nodes( $uniq ) );
} );

get_header();
?>

<!-- ============================================================ HERO -->
<section class="hero">
	<div class="wrap hero__grid">
		<div>
			<span class="eyebrow">Direct owner financing · Cayman Islands</span>

			<h1>
				Land for sale in the Cayman&nbsp;Islands —
				<span class="accent">without a bank</span>
			</h1>

			<p class="lede">
				Easy Lot owns the lots and finances them to you directly. No mortgage application,
				no loan committee, no 40% deposit. Just a small down payment, a fixed monthly
				figure, and land in Grand Cayman or Little Cayman with your name going on the title.
			</p>

			<ul class="hero__points">
				<li><?php easylot_the_icon( 'check-c' ); ?> <span><strong>Down payments from 5%</strong> — about $2,000 on a $40,000 lot</span></li>
				<li><?php easylot_the_icon( 'check-c' ); ?> <span><strong>Fixed monthly payments</strong> that typically start near $400</span></li>
				<li><?php easylot_the_icon( 'check-c' ); ?> <span><strong>Pre-approval in 5 minutes</strong> with four everyday documents</span></li>
				<li><?php easylot_the_icon( 'check-c' ); ?> <span><strong>Open to overseas buyers</strong> — no restriction on foreign ownership</span></li>
			</ul>

			<div class="btn-row">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">
					Get pre-approved free <?php easylot_the_icon( 'arrow' ); ?>
				</a>
				<a class="btn btn--ghost btn--lg" href="#how">
					See the 5 steps
				</a>
			</div>
		</div>

		<div style="position:relative;">
			<?php if ( $hero_v ) : ?>
				<div class="vcard vcard--hero"
				     role="button" tabindex="0"
				     data-video="<?php echo esc_url( $hero_v['src'] ); ?>"
				     data-orientation="vertical"
				     data-caption="<?php echo esc_attr( $hero_v['question'] ); ?>"
				     aria-label="Play video: How does Direct Owner Financing work?">
					<video src="<?php echo esc_url( $hero_v['src'] ); ?>#t=0.6" preload="metadata" muted playsinline
					       poster="<?php echo esc_url( $c['og_image'] ); ?>" tabindex="-1" aria-hidden="true"></video>
					<span class="vcard__veil"></span>
					<span class="vcard__tag">Watch first</span>
					<span class="vcard__play"><?php easylot_the_icon( 'play' ); ?></span>
					<div class="vcard__body">
						<h2 class="vcard__q">How Direct Owner Financing works</h2>
						<p class="vcard__a">Two minutes on why there is no bank in this transaction — and what that changes for you.</p>
					</div>
				</div>
			<?php else : ?>
				<div class="hero__media">
					<img src="<?php echo esc_url( $c['og_image'] ); ?>" alt="Aerial view of land in Grand Cayman" width="900" height="1125">
				</div>
			<?php endif; ?>

			<div class="hero__badge">
				<b>5% down</b>
				<span>To start owning</span>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ TRUST STRIP -->
<section class="trust">
	<div class="wrap">
		<?php /* Units go in a .u span so "5%" and "5 min" keep the same numeral
		         weight as the bare "0" and "4" instead of crowding their cell. */ ?>
		<div class="trust__grid">
			<div class="trust__cell"><b>0</b><span>Banks involved</span></div>
			<div class="trust__cell"><b>5<span class="u">%</span></b><span>Minimum down</span></div>
			<div class="trust__cell"><b>4</b><span>Documents needed</span></div>
			<div class="trust__cell"><b>5<span class="u">min</span></b><span>To pre-approval</span></div>
		</div>
	</div>
</section>

<!-- ============================================================ THE COMPARISON -->
<section class="section section--paper">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">The difference</span>
			<h2>What a bank asks for, and what we ask for</h2>
			<p class="lede">
				Most people who give up on buying land in the Cayman Islands give up at the bank,
				not at the price. Raw land is the hardest thing here to get a mortgage on. Here is
				the same purchase, seen from both sides of the counter.
			</p>
		</div>

		<div class="compare reveal">
			<div class="compare__scroll">
				<table>
					<caption class="sr-only">Buying land in the Cayman Islands: a traditional bank mortgage compared with Easy Lot direct owner financing</caption>
					<thead>
						<tr>
							<th scope="col">&nbsp;</th>
							<th scope="col">Traditional bank mortgage</th>
							<th scope="col">Easy Lot owner financing</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Down payment on raw land</td>
							<td>Typically 30–40%</td>
							<td>From 5%</td>
						</tr>
						<tr>
							<td>Who approves you</td>
							<td>A credit committee you never meet</td>
							<td>Us — we own the land</td>
						</tr>
						<tr>
							<td>Paperwork</td>
							<td>Full underwriting file, credit history, valuations</td>
							<td>Passport, ID, job letter, utility bill</td>
						</tr>
						<tr>
							<td>Time to an answer</td>
							<td>Weeks</td>
							<td>Usually the same business day</td>
						</tr>
						<tr>
							<td>Rate movement</td>
							<td><span class="no"><?php easylot_the_icon( 'x-c' ); ?> Variable — your payment can rise</span></td>
							<td><span class="yes"><?php easylot_the_icon( 'check-c' ); ?> Fixed for the whole term</span></td>
						</tr>
						<tr>
							<td>Early settlement penalty</td>
							<td><span class="no"><?php easylot_the_icon( 'x-c' ); ?> Common</span></td>
							<td><span class="yes"><?php easylot_the_icon( 'check-c' ); ?> None</span></td>
						</tr>
						<tr>
							<td>Overseas buyers</td>
							<td>Difficult without local banking history</td>
							<td><span class="yes"><?php easylot_the_icon( 'check-c' ); ?> Handled remotely, start to finish</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<p style="margin-top:22px;font-size:.86rem;color:var(--ink-55);max-width:70ch;">
			Bank figures are typical of Cayman Islands lenders for undeveloped land and vary by
			institution. Easy Lot terms depend on the lot, the deposit and the term you choose.
		</p>
	</div>
</section>

<!-- ============================================================ THE 5 STEPS -->
<section class="section section--paper-3" id="how">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">How to buy land in Cayman</span>
			<h2>Five steps, start to title</h2>
			<p class="lede">
				This is the whole process. Nothing is hidden behind a phone call — and each step
				has a short video if you would rather watch than read.
			</p>
		</div>

		<?php
		$steps = array(
			array(
				'n'     => '01',
				'title' => 'Get pre-approved — before you pick a lot',
				'text'  => 'Fill in the online form and we tell you the price range and the monthly payment you qualify for. It takes about five minutes, it costs nothing, and it is not a credit application, so it leaves no mark. Knowing the number first means you shop for a lot you can actually finish paying for.',
				'meta'  => 'About 5 minutes · free · no obligation',
				'icon'  => 'clock',
			),
			array(
				'n'     => '02',
				'title' => 'Send four documents',
				'text'  => 'Passport, driver’s licence or second photo ID, a job letter confirming your income, and a recent utility bill for proof of address. Photograph all four on your phone. If you are buying with a partner or relative, they send the same four and both incomes count towards the approval.',
				'meta'  => 'Passport · ID · job letter · utility bill',
				'icon'  => 'doc',
			),
			array(
				'n'     => '03',
				'title' => 'Choose your lot on the interactive map',
				'text'  => 'Each development page carries a live lot map: browse what is still available, compare sizes and prices, and see exactly where a parcel sits before you commit. Reserve the one you want and we hold it while the agreement is drawn up.',
				'meta'  => 'Elena Estates · High Rock · Northshore',
				'icon'  => 'map',
			),
			array(
				'n'     => '04',
				'title' => 'Sign, pay the deposit, clear AML',
				'text'  => 'You sign the purchase agreement and pay the down payment — from 5% of the price. Like every land purchase in the Cayman Islands, the transaction has to satisfy anti-money-laundering rules, which is what the identity and address documents are for. Overseas buyers complete this remotely.',
				'meta'  => 'Deposit from 5% · AML verification',
				'icon'  => 'shield',
			),
			array(
				'n'     => '05',
				'title' => 'Pay monthly, then take the title',
				'text'  => 'A fixed amount leaves your account each month for the agreed term — no rate changes, no penalty if you clear the balance early. When the balance reaches zero the transfer is registered with the Lands and Survey Department and the title is issued in your name.',
				'meta'  => 'Fixed payments · registered title',
				'icon'  => 'key',
			),
		);

		foreach ( $steps as $i => $s ) :
			$video = easylot_videos( array( 'step' => $i + 1, 'limit' => 1 ) );
			$video = $video ? $video[0] : null;
			?>
			<div class="steprow reveal<?php echo ( $i % 2 ) ? ' steprow--flip' : ''; ?>">
				<div class="steprow__text">
					<span class="steprow__n"><?php echo esc_html( $s['n'] ); ?></span>
					<h3><?php echo esc_html( $s['title'] ); ?></h3>
					<p><?php echo esc_html( $s['text'] ); ?></p>
					<div class="step__meta"><?php easylot_the_icon( $s['icon'] ); ?> <?php echo esc_html( $s['meta'] ); ?></div>
				</div>
				<div class="steprow__media">
					<?php if ( $video ) : ?>
						<?php easylot_video_card( $video, array( 'tag' => 'Step ' . ( $i + 1 ) ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="btn-row btn-row--center" style="margin-top:48px;">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Start step one <?php easylot_the_icon( 'arrow' ); ?></a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">Read the full walkthrough</a>
		</div>
	</div>
</section>

<!-- ============================================================ THE 4 DOCUMENTS -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">The whole file</span>
			<h2>Four documents. That is the application.</h2>
			<p class="lede">
				No tax returns, no bank statements going back two years, no valuation report.
				If you can photograph these four things, you can apply today.
			</p>
		</div>

		<div class="grid grid-4">
			<div class="doc reveal">
				<span class="doc__ic"><?php easylot_the_icon( 'passport' ); ?></span>
				<span><b>Passport</b><span>Proof of identity</span></span>
			</div>
			<div class="doc reveal">
				<span class="doc__ic"><?php easylot_the_icon( 'id' ); ?></span>
				<span><b>Driver’s licence</b><span>Or a second photo ID</span></span>
			</div>
			<div class="doc reveal">
				<span class="doc__ic"><?php easylot_the_icon( 'doc' ); ?></span>
				<span><b>Job letter</b><span>Employer, role and income</span></span>
			</div>
			<div class="doc reveal">
				<span class="doc__ic"><?php easylot_the_icon( 'bill' ); ?></span>
				<span><b>Utility bill</b><span>Recent, for proof of address</span></span>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ CALCULATOR -->
<section class="section section--paper-2" id="calculator">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Run your own numbers</span>
			<h2>What would <span class="accent">your</span> monthly payment be?</h2>
			<p class="lede">
				Move the sliders. The figure updates as you go, so you can see exactly what a
				bigger deposit or a shorter term does to the monthly cost.
			</p>
		</div>

		<div class="calc reveal" id="calc" data-rate="7.5">
			<div class="calc__inputs">
				<div class="field">
					<div class="field__top">
						<label class="field__label" for="calc-price">Lot price</label>
						<span class="field__val" id="calc-price-val">$60,000</span>
					</div>
					<input type="range" id="calc-price" min="25000" max="250000" step="1000" value="60000">
					<div class="field__scale"><span>$25,000</span><span>$250,000</span></div>
				</div>

				<div class="field">
					<div class="field__top">
						<label class="field__label" for="calc-down">Down payment</label>
						<span class="field__val" id="calc-down-val">10% · $6,000</span>
					</div>
					<input type="range" id="calc-down" min="5" max="50" step="1" value="10">
					<div class="field__scale"><span>5%</span><span>50%</span></div>
				</div>

				<div class="field">
					<div class="field__top">
						<label class="field__label" for="calc-term">Term</label>
						<span class="field__val" id="calc-term-val">10 years</span>
					</div>
					<input type="range" id="calc-term" min="3" max="15" step="1" value="10">
					<div class="field__scale"><span>3 years</span><span>15 years</span></div>
				</div>
			</div>

			<div class="calc__out">
				<span class="eyebrow">Estimated monthly payment</span>
				<div class="calc__figure" id="calc-monthly"><span id="calc-monthly-val">$0</span><small>/mo</small></div>

				<div class="calc__rows">
					<div class="calc__row"><span>Down payment today</span><b id="calc-deposit">$0</b></div>
					<div class="calc__row"><span>Amount financed</span><b id="calc-financed">$0</b></div>
					<div class="calc__row"><span>Total paid over the term</span><b id="calc-total">$0</b></div>
				</div>

				<a class="btn btn--primary btn--wide" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">
					Get this in writing <?php easylot_the_icon( 'arrow' ); ?>
				</a>

				<p class="calc__note">
					Estimate only, based on a 7.5% fixed annual rate for illustration. Your actual
					rate, term and payment are set in your agreement and confirmed at pre-approval.
					Stamp duty and legal fees are not included.
				</p>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================ DEVELOPMENTS -->
<section class="section section--paper">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Where the land is</span>
			<h2>Three developments, three very different islands</h2>
			<p class="lede">
				Every one of these pages carries a live interactive map of the development, so you
				can see which lots are still available and exactly where each parcel sits before
				you talk to anybody.
			</p>
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

						<div class="lot__facts">
							<?php foreach ( $d['facts'] as $f ) : ?>
								<span class="lot__fact"><?php echo esc_html( $f ); ?></span>
							<?php endforeach; ?>
						</div>

						<div class="lot__price">
							<b><?php echo esc_html( $d['from'] ); ?></b>
							<span>starting price</span>
						</div>

						<a class="btn btn--ink btn--wide" href="<?php echo esc_url( $d['link'] ); ?>">
							View lots &amp; map <?php easylot_the_icon( 'arrow' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ VIDEO LIBRARY -->
<section class="section section--ink">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Watch &amp; learn</span>
			<h2>The questions we get asked most — answered on video</h2>
			<p class="lede">
				Short, plain-English answers with no sales pitch. Tap any one to play it.
			</p>
		</div>

		<?php easylot_video_grid( $featured, array( 'cols' => 4 ) ); ?>

		<div class="btn-row btn-row--center" style="margin-top:44px;">
			<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">
				<?php easylot_the_icon( 'play' ); ?> Watch all 20 guides
			</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">Prefer to read? Full FAQ</a>
		</div>
	</div>
</section>

<!-- ============================================================ WHY LAND -->
<section class="section section--white">
	<div class="wrap">
		<div class="section-head">
			<span class="eyebrow">Before the how, the why</span>
			<h2>Why land, and why here</h2>
			<p class="lede">
				Nobody is making more Cayman Islands. Land needs no maintenance, produces no
				midnight phone calls, and has been quietly appreciating while the islands build
				out around it.
			</p>
		</div>

		<div class="grid grid--media grid-4">
			<?php foreach ( $why as $v ) : ?>
				<?php easylot_video_card( $v ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ TESTIMONIALS -->
<section class="section section--paper-3">
	<div class="wrap">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">From people who bought</span>
			<h2>What it is actually like</h2>
		</div>

		<div class="quotes">
			<?php foreach ( easylot_testimonials() as $t ) : ?>
				<figure class="quote reveal" style="margin:0;">
					<div class="quote__stars" aria-label="5 out of 5">
						<?php for ( $s = 0; $s < 5; $s++ ) { easylot_the_icon( 'star' ); } ?>
					</div>
					<blockquote style="margin:0;padding:0;border:0;font-style:normal;">
						<p>“<?php echo esc_html( $t['quote'] ); ?>”</p>
					</blockquote>
					<figcaption class="quote__who">
						<b><?php echo esc_html( $t['name'] ); ?></b>
						<span><?php echo esc_html( $t['where'] ); ?></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============================================================ FAQ -->
<section class="section section--paper">
	<div class="wrap-narrow">
		<div class="section-head section-head--center">
			<span class="eyebrow eyebrow--center">Straight answers</span>
			<h2>Frequently asked questions</h2>
		</div>

		<div class="faq">
			<?php foreach ( $faqs as $i => $f ) : ?>
				<div class="faq__item<?php echo 0 === $i ? ' is-open' : ''; ?>">
					<div class="faq__q" role="button" tabindex="0" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
						<span><?php echo esc_html( $f['q'] ); ?></span>
						<span class="faq__ic"><?php easylot_the_icon( 'plus' ); ?></span>
					</div>
					<div class="faq__a"<?php echo 0 === $i ? ' style="max-height:600px"' : ''; ?>>
						<div><?php echo esc_html( $f['a'] ); ?></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="btn-row btn-row--center" style="margin-top:40px;">
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">Read all <?php echo count( easylot_faqs() ); ?> answers</a>
		</div>
	</div>
</section>

<!-- ============================================================ CTA -->
<section class="section section--tight section--paper-2">
	<div class="wrap">
		<div class="cta-band reveal">
			<span class="eyebrow eyebrow--center" style="color:rgba(255,255,255,.85)">No cost, no obligation</span>
			<h2>Find out what you qualify for in five minutes</h2>
			<p>
				Pre-approval tells you your price range and monthly payment before you fall in love
				with a lot. It is free, it leaves no mark on your credit, and most people hear back
				the same day.
			</p>
			<div class="btn-row btn-row--center" style="margin-top:30px;">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Start my pre-approval</a>
				<a class="btn btn--ghost btn--lg" style="color:#fff;border-color:rgba(255,255,255,.5)" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">
					<?php easylot_the_icon( 'whatsapp' ); ?> Ask on WhatsApp
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
