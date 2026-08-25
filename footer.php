<?php
/**
 * Footer.
 *
 * @package EasyLotCayman
 */

$c    = easylot_contact();
$devs = easylot_developments();
?>
</main>

<footer class="site-footer">
	<div class="wrap site-footer__grid">

		<div>
			<span class="site-footer__logo"><?php easylot_logo_img( 32 ); ?></span>
			<p>Land ownership in the Cayman Islands without a bank. We own the lots, we finance them directly, and we walk you through every step.</p>
			<div class="socials">
				<a href="<?php echo esc_url( $c['social']['facebook'] ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php easylot_the_icon( 'facebook' ); ?></a>
				<a href="<?php echo esc_url( $c['social']['instagram'] ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php easylot_the_icon( 'instagram' ); ?></a>
				<a href="<?php echo esc_url( $c['social']['youtube'] ); ?>" target="_blank" rel="noopener" aria-label="YouTube"><?php easylot_the_icon( 'youtube' ); ?></a>
				<a href="<?php echo esc_url( $c['social']['tiktok'] ); ?>" target="_blank" rel="noopener" aria-label="TikTok"><?php easylot_the_icon( 'tiktok' ); ?></a>
			</div>
		</div>

		<div>
			<div class="foot-label">Land for Sale</div>
			<div class="foot-links">
				<?php foreach ( $devs as $d ) : ?>
					<a href="<?php echo esc_url( $d['link'] ); ?>"><?php echo esc_html( $d['name'] ); ?></a>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( easylot_url( 'developments' ) ); ?>">All Developments</a>
			</div>
		</div>

		<div>
			<div class="foot-label">Learn</div>
			<div class="foot-links">
				<a href="<?php echo esc_url( easylot_url( 'how' ) ); ?>">How to Buy Land in Cayman</a>
				<a href="<?php echo esc_url( easylot_url( 'faq' ) ); ?>">Financing FAQ</a>
				<a href="<?php echo esc_url( easylot_url( 'videos' ) ); ?>">Video Guides</a>
				<a href="<?php echo esc_url( easylot_url( 'about' ) ); ?>">About Easy Lot</a>
				<a href="https://www.caymanlandinfo.ky/" target="_blank" rel="noopener">Cayman Land Registry</a>
			</div>
		</div>

		<div>
			<div class="foot-label">Our Office</div>
			<p style="margin-bottom:22px;">
				<?php echo esc_html( $c['street'] ); ?><br>
				<?php echo esc_html( $c['locality'] ); ?><br>
				<?php echo esc_html( $c['region'] ); ?>, Cayman Islands
			</p>
			<div class="foot-label">Talk to us</div>
			<div class="foot-links">
				<a href="tel:<?php echo esc_attr( $c['phone_link'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a>
				<a href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener">WhatsApp us</a>
				<a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a>
				<a href="<?php echo esc_url( easylot_url( 'directions' ) ); ?>">Directions</a>
			</div>
		</div>
	</div>

	<div class="wrap">
		<div class="site-footer__bar">
			<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. All rights reserved.</span>
			<span>
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy</a> ·
				<a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms</a>
			</span>
			<span>Created by <a href="https://toctoc.ky/" target="_blank" rel="noopener">Toc Toc Marketing</a></span>
		</div>
	</div>
</footer>

<a class="wa" href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
	<?php easylot_the_icon( 'whatsapp' ); ?>
</a>

<?php wp_footer(); ?>
</body>
</html>
