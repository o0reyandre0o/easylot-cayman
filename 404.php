<?php
/**
 * 404.
 *
 * @package EasyLotCayman
 */

get_header();
?>
<section class="section section--paper">
	<div class="wrap-narrow center">
		<span class="eyebrow eyebrow--center">Error 404</span>
		<h1>That page is not here</h1>
		<p class="lede" style="margin-inline:auto;">
			The link may be old, or the page may have moved. These are the places most people are heading.
		</p>
		<div class="btn-row btn-row--center" style="margin-top:34px;">
			<a class="btn btn--primary" href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">Land for sale</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">How it works</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">Video guides</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
		</div>
	</div>
</section>
<?php get_footer(); ?>
