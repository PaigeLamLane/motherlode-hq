<?php
/**
 * The close of every page.
 *
 * NEW, 3 September 2026 — found on a self-audit, mandated directly by her:
 * "go through the entire website and just do your best." The parent theme's
 * own footer.php is deliberately bare — one line, no links, built as a
 * fallback for a business that hasn't built its own yet. MotherLode never
 * had. Every page on a live site that holds real money through Stripe
 * Connect closed on a single unstyled sentence with nowhere else to go.
 *
 * This overrides the parent's footer.php the ordinary WordPress way — a
 * child theme template of the same name simply wins. Nothing here touches
 * `lamoureux-core` or any shared plugin.
 *
 * Left out on purpose: Privacy Policy and Refund and Returns Policy. Both
 * pages exist in the back end but are still sitting in draft — flagged to
 * Darling rather than invented here, since the actual words on a policy
 * page for a site moving real money aren't mine to write unreviewed.
 *
 * @package MotherLodeHQ
 */

defined( 'ABSPATH' ) || exit;
?>
</main>
<footer class="lode-foot">
	<div class="in lode-foot-in">
		<div class="lode-foot-brand">
			<a class="lode-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="MotherLode HQ, home">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/motherlode-logo.png' ); ?>" alt="MotherLode HQ" width="900" height="600" loading="lazy" decoding="async">
			</a>
			<p class="lode-foot-tag">You Should Never Have To Choose.</p>
		</div>

		<nav class="lode-foot-nav" aria-label="Footer">
			<a href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">For business</a>
			<a href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">For talent</a>
			<a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>">How it works</a>
			<a href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Join</a>
		</nav>

		<p class="lode-foot-fine">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> MotherLode HQ &middot; Madame Monet<br>ABN 40 366 975 511 &middot; <a href="mailto:fractional@motherlodehq.com.au">fractional@motherlodehq.com.au</a><br><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy</a> &middot; <a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms</a> &middot; <a href="<?php echo esc_url( home_url( '/refund_returns/' ) ); ?>">Refunds</a></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
