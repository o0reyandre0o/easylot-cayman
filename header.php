<?php
/**
 * Header: document head only.
 *
 * The navigation lives in nav.php, hooked to wp_body_open, so it also renders
 * on Elementor templates that never load this file. See nav.php.
 *
 * @package EasyLotCayman
 */

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

<main class="site-main" id="content">
