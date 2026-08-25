<?php
/**
 * First-run page provisioning.
 *
 * Activating the theme creates the pages it expects and assigns each one its
 * template. Nothing is ever overwritten: a page that already exists is left
 * exactly as it is, and an existing template assignment is never replaced —
 * the only thing the theme will change on an existing page is attaching a
 * template where the page currently has none.
 *
 * Safe to run repeatedly. A "Set up theme pages" button on the Themes and
 * Pages screens re-runs it on demand.
 *
 * @package EasyLotCayman
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The pages the theme expects, in menu order.
 *
 * 'aliases' are older slugs this site has used. If one of them exists we treat
 * the page as already present rather than creating a duplicate — which is how
 * /faq/ and /frequently-asked-questions/ are kept from both existing.
 *
 * 'content' is only used by templates that print the_content(); the rest build
 * their own page and are created empty on purpose.
 */
function easylot_page_blueprint() {
	return array(
		array(
			'slug'     => 'how-to-buy-land-in-cayman',
			'aliases'  => array( 'how-it-works' ),
			'title'    => 'How to Buy Land in the Cayman Islands',
			'template' => 'template-how-to-buy.php',
			'excerpt'  => 'The whole owner-financing purchase, start to registered title.',
			'content'  => '',
		),
		array(
			'slug'     => 'all-our-developments',
			'aliases'  => array( 'developments', 'all-our-developments-2' ),
			'title'    => 'Land for Sale',
			'template' => 'template-developments.php',
			'excerpt'  => 'Owner-financed land in Grand Cayman and Little Cayman.',
			'content'  => '',
		),
		array(
			'slug'     => 'video-guides',
			'aliases'  => array(),
			'title'    => 'Video Guides',
			'template' => 'template-video-guides.php',
			'excerpt'  => 'Short videos answering the questions we get asked most.',
			'content'  => '',
		),
		array(
			'slug'     => 'faq',
			'aliases'  => array( 'frequently-asked-questions' ),
			'title'    => 'Frequently Asked Questions',
			'template' => 'template-faq.php',
			'excerpt'  => 'Straight answers on buying land here without a bank.',
			'content'  => '',
		),
		array(
			'slug'     => 'contact-us',
			'aliases'  => array( 'contact' ),
			'title'    => 'Get Pre-Approved',
			'template' => 'template-contact.php',
			'excerpt'  => 'Free 5-minute pre-approval. Four documents, no obligation.',
			'content'  => "<h2>Start your pre-approval</h2>\n<p>Tell us a little about yourself and we will come back with the price range and the monthly payment you qualify for &mdash; usually the same business day.</p>\n<!-- Drop the pre-approval form here (Elementor, Contact Form 7, Gravity Forms - whatever the site uses). -->",
		),
		array(
			'slug'     => 'about-us',
			'aliases'  => array( 'about' ),
			'title'    => 'About Easy Lot',
			'template' => 'template-about.php',
			'excerpt'  => 'We own the land, so we can finance it ourselves.',
			'content'  => "<p>Easy Lot owns land across Grand Cayman and Little Cayman and finances it directly to the people who buy it. No bank sits between you and the title, which is what lets a purchase start at 5% down instead of the 30&ndash;40% a lender wants on undeveloped land.</p>\n<p>Replace this paragraph with the company&rsquo;s own story.</p>",
		),
		array(
			'slug'     => 'team-members',
			'aliases'  => array( 'meet-the-team', 'team' ),
			'title'    => 'Meet the Team',
			'template' => 'template-team.php',
			'excerpt'  => 'The people who handle your pre-approval, site visit and closing.',
			'content'  => '<p>Add the team here &mdash; a photo, a name and a role for each person.</p>',
		),
		array(
			'slug'     => 'directions',
			'aliases'  => array( 'find-us' ),
			'title'    => 'Directions',
			'template' => 'template-directions.php',
			'excerpt'  => 'How to find the Easy Lot office in George Town.',
			'content'  => '<p>Parking is available on site. Call ahead so somebody is free when you arrive.</p>',
		),
	);
}

/**
 * Find an existing page for a blueprint entry, by slug or by any of its older
 * slugs. Returns a WP_Post or null. Trashed pages do not count — recreating a
 * page the admin deliberately trashed would resurrect it under their feet, so
 * the trashed copy is simply left in the bin alongside the fresh one.
 */
function easylot_find_blueprint_page( $entry ) {
	$slugs = array_merge( array( $entry['slug'] ), $entry['aliases'] );

	foreach ( $slugs as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page && in_array( $page->post_status, array( 'publish', 'draft', 'private', 'pending' ), true ) ) {
			return $page;
		}
	}

	return null;
}

/**
 * Create the missing pages and report what happened.
 *
 * @return array{created:array,attached:array,skipped:array}
 */
function easylot_provision_pages() {

	$report = array( 'created' => array(), 'attached' => array(), 'skipped' => array() );
	$order  = 1;

	foreach ( easylot_page_blueprint() as $entry ) {

		$existing = easylot_find_blueprint_page( $entry );

		if ( $existing ) {
			/*
			 * The page is already here. Never touch its title, content or
			 * status. The one thing worth doing is attaching our template when
			 * the page has none — replacing a template somebody deliberately
			 * chose would be a change they did not ask for.
			 */
			$current = get_post_meta( $existing->ID, '_wp_page_template', true );

			if ( '' === $current || 'default' === $current ) {
				update_post_meta( $existing->ID, '_wp_page_template', $entry['template'] );
				$report['attached'][] = array(
					'title'    => get_the_title( $existing ),
					'url'      => get_permalink( $existing ),
					'template' => $entry['template'],
				);
			} else {
				$report['skipped'][] = array(
					'title'    => get_the_title( $existing ),
					'url'      => get_permalink( $existing ),
					'template' => $current,
					'wanted'   => $entry['template'],
				);
			}

			$order++;
			continue;
		}

		$id = wp_insert_post( array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'post_title'     => $entry['title'],
			'post_name'      => $entry['slug'],
			'post_content'   => $entry['content'],
			'post_excerpt'   => $entry['excerpt'],
			'menu_order'     => $order++,
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
		), true );

		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}

		update_post_meta( $id, '_wp_page_template', $entry['template'] );

		$report['created'][] = array(
			'title'    => $entry['title'],
			'url'      => get_permalink( $id ),
			'template' => $entry['template'],
		);
	}

	set_transient( 'easylot_provision_report', $report, 5 * MINUTE_IN_SECONDS );

	return $report;
}

/**
 * Run once when the theme is activated.
 *
 * No capability check here: after_switch_theme fires for whoever activated the
 * theme, which already requires switch_themes.
 */
function easylot_on_activate() {
	easylot_provision_pages();

	// A fresh install shows "Hello world!"-era settings; make the front page
	// our homepage template rather than the blog feed. Only when the admin has
	// not already chosen a static front page.
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		$front = get_page_by_path( 'home' );
		if ( ! $front ) {
			$front_id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Home',
				'post_name'    => 'home',
				'post_content' => '',
			) );
			$front = $front_id && ! is_wp_error( $front_id ) ? get_post( $front_id ) : null;
		}
		if ( $front ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front->ID );
		}
	}
}
add_action( 'after_switch_theme', 'easylot_on_activate' );

/**
 * Manual re-run, for when a page is added later.
 */
function easylot_handle_provision_request() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( esc_html__( 'You do not have permission to do that.', 'easylot' ) );
	}
	check_admin_referer( 'easylot_provision' );

	easylot_provision_pages();

	$back = wp_get_referer();
	wp_safe_redirect( $back ? $back : admin_url( 'themes.php' ) );
	exit;
}
add_action( 'admin_post_easylot_provision', 'easylot_handle_provision_request' );

/**
 * Tell the admin what was created, what was wired up and what was left alone.
 */
function easylot_provision_notice() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$report = get_transient( 'easylot_provision_report' );

	$button = '<p><a class="button" href="'
		. esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=easylot_provision' ), 'easylot_provision' ) )
		. '">' . esc_html__( 'Set up theme pages', 'easylot' ) . '</a></p>';

	if ( ! $report ) {
		// Only offer the button on the Themes and Pages screens; no nagging elsewhere.
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || ! in_array( $screen->id, array( 'themes', 'edit-page' ), true ) ) {
			return;
		}
		echo '<div class="notice notice-info"><p><strong>Easy Lot:</strong> ' .
			esc_html__( 'create any missing theme pages and attach their templates. Existing pages are never modified.', 'easylot' ) .
			'</p>' . $button . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}

	delete_transient( 'easylot_provision_report' );

	$sections = array(
		'created'  => __( 'Created', 'easylot' ),
		'attached' => __( 'Already existed — template attached', 'easylot' ),
		'skipped'  => __( 'Already existed — left alone (it already has a template)', 'easylot' ),
	);

	$html     = '<div class="notice notice-success is-dismissible"><p><strong>Easy Lot pages</strong></p>';
	$anything = false;

	foreach ( $sections as $key => $label ) {
		if ( empty( $report[ $key ] ) ) {
			continue;
		}
		$anything = true;
		$html    .= '<p style="margin-bottom:4px"><em>' . esc_html( $label ) . '</em></p><ul style="margin:0 0 10px 18px;list-style:disc">';
		foreach ( $report[ $key ] as $row ) {
			$line = '<a href="' . esc_url( $row['url'] ) . '">' . esc_html( $row['title'] ) . '</a> <code>' . esc_html( $row['template'] ) . '</code>';
			if ( 'skipped' === $key ) {
				$line .= ' — ' . sprintf(
					/* translators: %s: template file name */
					esc_html__( 'switch it to %s by hand if you want the new layout', 'easylot' ),
					'<code>' . esc_html( $row['wanted'] ) . '</code>'
				);
			}
			$html .= '<li>' . $line . '</li>';
		}
		$html .= '</ul>';
	}

	if ( ! $anything ) {
		$html .= '<p>' . esc_html__( 'Everything was already in place — nothing to do.', 'easylot' ) . '</p>';
	}

	$html .= $button . '</div>';

	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'admin_notices', 'easylot_provision_notice' );
