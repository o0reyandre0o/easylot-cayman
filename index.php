<?php
/**
 * Fallback template / blog index.
 *
 * @package EasyLotCayman
 */

get_header();
?>
<header class="page-hero">
	<div class="wrap">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<span class="eyebrow">Journal</span>
			<h1><?php echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ? get_the_title( get_option( 'page_for_posts' ) ) : 'Latest from Easy Lot' ); ?></h1>
		<?php else : ?>
			<h1><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
		<?php endif; ?>
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
					<article class="lot reveal">
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="lot__img" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="lot__body">
							<div class="lot__where"><?php echo esc_html( get_the_date() ); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
							<a class="btn btn--ghost" style="margin-top:20px;" href="<?php the_permalink(); ?>">
								Read <?php easylot_the_icon( 'arrow' ); ?>
							</a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<div class="btn-row btn-row--center" style="margin-top:48px;">
				<?php
				the_posts_pagination( array(
					'mid_size'  => 1,
					'prev_text' => 'Previous',
					'next_text' => 'Next',
				) );
				?>
			</div>
		<?php else : ?>
			<p class="lede">Nothing published here yet.</p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
