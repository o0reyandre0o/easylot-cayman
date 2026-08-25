<?php
/**
 * Header: document head, fixed navigation and mobile drawer.
 *
 * @package EasyLotCayman
 */

$c    = easylot_contact();
$devs = easylot_developments();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#content">Skip to content</a>

<header class="site-nav" id="site-nav">
	<div class="wrap site-nav__bar">

		<a class="site-nav__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home">
			<?php easylot_logo_img( 34 ); ?>
		</a>

		<nav class="site-nav__links" aria-label="Primary">

			<a class="navlink" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>"<?php echo is_page_template( 'template-how-to-buy.php' ) ? ' aria-current="page"' : ''; ?>>How It Works</a>

			<!-- Developments: each of these pages carries the third-party lot map,
			     which single-project.php renders untouched. -->
			<div class="has-menu">
				<span class="navlink" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
					Land for Sale
					<?php easylot_the_icon( 'chevron', 'navlink__chev' ); ?>
				</span>
				<div class="dropdown dropdown--wide">
					<?php foreach ( $devs as $d ) : ?>
						<a class="dropitem" href="<?php echo esc_url( $d['link'] ); ?>">
							<span class="dropitem__thumb">
								<img src="<?php echo esc_url( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['name'] ); ?>" width="46" height="46" loading="lazy">
							</span>
							<span>
								<span class="dropitem__t"><?php echo esc_html( $d['name'] ); ?></span>
								<span class="dropitem__d">
									<?php echo esc_html( $d['island'] ); ?><?php
									// Ocean Breeze has no confirmed starting price yet — show the
									// island alone rather than a dangling "from".
									if ( ! empty( $d['from'] ) ) {
										echo ' — from ' . esc_html( $d['from'] );
									}
									?>
								</span>
							</span>
						</a>
					<?php endforeach; ?>
					<a class="dropdown__foot" href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">
						View all developments <?php easylot_the_icon( 'arrow' ); ?>
					</a>
				</div>
			</div>

			<div class="has-menu">
				<span class="navlink" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
					Learn
					<?php easylot_the_icon( 'chevron', 'navlink__chev' ); ?>
				</span>
				<div class="dropdown">
					<a class="dropitem" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">
						<span class="dropitem__thumb"><?php easylot_the_icon( 'play' ); ?></span>
						<span>
							<span class="dropitem__t">Video Guides</span>
							<span class="dropitem__d">20 short answers, on video</span>
						</span>
					</a>
					<a class="dropitem" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">
						<span class="dropitem__thumb"><?php easylot_the_icon( 'doc' ); ?></span>
						<span>
							<span class="dropitem__t">Financing FAQ</span>
							<span class="dropitem__d">Every answer, written out</span>
						</span>
					</a>
					<a class="dropitem" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">
						<span class="dropitem__thumb"><?php easylot_the_icon( 'map' ); ?></span>
						<span>
							<span class="dropitem__t">The 5 Steps</span>
							<span class="dropitem__d">From pre-approval to title</span>
						</span>
					</a>
				</div>
			</div>

			<div class="has-menu">
				<span class="navlink" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
					About
					<?php easylot_the_icon( 'chevron', 'navlink__chev' ); ?>
				</span>
				<div class="dropdown">
					<a class="dropitem" href="<?php echo esc_url( easylot_url( 'about' ) ); ?>"><span><span class="dropitem__t">About Easy Lot</span></span></a>
					<a class="dropitem" href="<?php echo esc_url( easylot_url( 'team' ) ); ?>"><span><span class="dropitem__t">Meet the Team</span></span></a>
					<a class="dropitem" href="<?php echo esc_url( easylot_url( 'directions' ) ); ?>"><span><span class="dropitem__t">Find Our Office</span></span></a>
				</div>
			</div>

			<a class="navlink" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Contact</a>
		</nav>

		<div class="site-nav__cta">
			<a class="btn btn--primary" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">
				Get pre-approved
			</a>
			<span class="burger" id="burger" role="button" tabindex="0" aria-label="Open menu" aria-controls="drawer" aria-expanded="false">
				<?php easylot_the_icon( 'menu' ); ?>
			</span>
		</div>
	</div>

	<span class="read-progress" id="read-progress" aria-hidden="true"></span>
</header>

<!-- Mobile drawer -->
<div class="drawer" id="drawer" aria-hidden="true">
	<div class="drawer__head">
		<?php easylot_logo_img( 30 ); ?>
		<span class="burger" id="drawer-close" role="button" tabindex="0" aria-label="Close menu">
			<?php easylot_the_icon( 'x' ); ?>
		</span>
	</div>
	<div class="drawer__body">
		<a class="drawer__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
		<a class="drawer__link" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">How It Works</a>

		<div class="drawer__group">
			<div class="drawer__label">Land for sale</div>
			<?php foreach ( $devs as $d ) : ?>
				<a class="drawer__sub" href="<?php echo esc_url( $d['link'] ); ?>"><?php echo esc_html( $d['name'] ); ?> — <?php echo esc_html( $d['island'] ); ?></a>
			<?php endforeach; ?>
			<a class="drawer__sub" href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">All developments</a>
		</div>

		<div class="drawer__group">
			<div class="drawer__label">Learn</div>
			<a class="drawer__sub" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">Video Guides</a>
			<a class="drawer__sub" href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">Financing FAQ</a>
		</div>

		<div class="drawer__group">
			<div class="drawer__label">About</div>
			<a class="drawer__sub" href="<?php echo esc_url( easylot_url( 'about' ) ); ?>">About Easy Lot</a>
			<a class="drawer__sub" href="<?php echo esc_url( easylot_url( 'team' ) ); ?>">Meet the Team</a>
			<a class="drawer__sub" href="<?php echo esc_url( easylot_url( 'directions' ) ); ?>">Find Our Office</a>
		</div>

		<a class="drawer__link" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Contact</a>

		<div class="btn-row" style="margin-top:28px;">
			<a class="btn btn--primary btn--wide" href="<?php echo esc_url( easylot_url( 'contact' ) ); ?>">Get pre-approved</a>
			<a class="btn btn--ghost btn--wide" href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>">
				<?php easylot_the_icon( 'phone' ); ?> <?php echo esc_html( $c['phone'] ); ?>
			</a>
		</div>
	</div>
</div>

<main class="site-main" id="content">
