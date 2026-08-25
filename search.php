<?php
/**
 * Search results.
 *
 * @package EasyLotCayman
 */

get_header();
?>
<header class="page-hero">
	<div class="wrap">
		<span class="eyebrow">Search</span>
		<h1>Results for “<?php echo esc_html( get_search_query() ); ?>”</h1>
		<p class="lede"><?php echo esc_html( sprintf( '%d result(s)', (int) $GLOBALS['wp_query']->found_posts ) ); ?></p>
		<div style="max-width:520px;margin-top:22px;"><?php get_search_form(); ?></div>
	</div>
</header>

<section class="section section--paper">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="card reveal">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
						<a class="btn btn--ghost" style="margin-top:18px;" href="<?php the_permalink(); ?>">Open <?php easylot_the_icon( 'arrow' ); ?></a>
					</article>
					<?php
				endwhile;
				?>
			</div>
		<?php else : ?>
			<p class="lede">
				Nothing matched that. Try the <a href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">FAQ</a>
				or the <a href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">video guides</a>.
			</p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
