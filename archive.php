<?php
/**
 * Archive listing (category, tag, date, custom post type).
 *
 * @package EasyLotCayman
 */

get_header();
?>
<header class="page-hero">
	<div class="wrap">
		<span class="eyebrow">Archive</span>
		<h1><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
		<?php
		$desc = get_the_archive_description();
		if ( $desc ) :
			?>
			<div class="lede"><?php echo wp_kses_post( $desc ); ?></div>
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
							<h2 style="font-size:1.3rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
