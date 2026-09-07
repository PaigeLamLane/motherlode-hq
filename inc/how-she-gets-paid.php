<?php
/**
 * Two ways a booking gets paid — 3 September 2026.
 *
 * Her words, direct: some of what a professional offers is a big
 * bookkeeping job for a real business, held and released properly through
 * Stripe. Some of it is cleaning down the road for cash. "How do we give
 * them the ability to handle their own money if that's what they want, or
 * we can do it for them?"
 *
 * THE SHAPE: a real choice, set per listing rather than once on a whole
 * profile — the same professional can hold one booking through MotherLode
 * HQ and arrange another one directly, because that's genuinely how the
 * work she described splits.
 *
 * WHY THIS NEVER TOUCHES lamoureux-billing. Market — the shared plugin's
 * own Stripe Connect engine — already does exactly one thing, held and
 * released, and does it well. A "direct" booking isn't a second payment
 * path through Market; it's a booking where MotherLode HQ has no payment
 * role at all. So this file never calls Market for a direct listing. It
 * only ever decides, per listing, whether the ordinary "held" checkout
 * Market already runs applies, or whether the client and professional are
 * simply put in touch instead — using Dokan's own real, working Contact
 * Seller form rather than anything invented here.
 *
 * FAILS TOWARD HELD, NEVER TOWARD DIRECT. The same shape as
 * her-own-account.php's own bookability gate: an unrecognised or missing
 * value defaults to 'held', because a booking silently skipping the
 * payment protection she built would be the wrong failure to have by
 * accident.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

const MOTHERLODE_PAYMENT_META = '_motherlode_payment_mode';

/**
 * Which way a listing is paid. Always one of two real values.
 *
 * @param int $product_id The listing.
 * @return string 'held' or 'direct'.
 */
function motherlode_payment_mode( int $product_id ): string {
	$mode = get_post_meta( $product_id, MOTHERLODE_PAYMENT_META, true );

	return 'direct' === $mode ? 'direct' : 'held';
}

/**
 * The choice itself, on Dokan's own product form — new listing and edit
 * both call this same hook (`dokan_new_product_form`), the new-listing
 * screen with no arguments at all, so both parameters default away.
 *
 * @param WP_Post|null $post    The product post, on the edit screen only.
 * @param int          $post_id The product ID, on the edit screen only.
 */
function motherlode_payment_mode_field( $post = null, int $post_id = 0 ): void {
	$current = $post_id ? motherlode_payment_mode( $post_id ) : 'held';
	?>
	<div class="dokan-form-group motherlode-payment-mode">
		<label class="dokan-w12 control-label"><?php esc_html_e( 'How Is This Paid?', 'motherlodehq' ); ?></label>
		<div class="dokan-w12">
			<label style="display:block;font-weight:normal;margin-bottom:.5rem;">
				<input type="radio" name="motherlode_payment_mode" value="held" <?php checked( 'held', $current ); ?>>
				<?php esc_html_e( 'Held & Released Through MotherLode HQ — recommended. A client pays through the site; it releases to you the moment the booking is marked done.', 'motherlodehq' ); ?>
			</label>
			<label style="display:block;font-weight:normal;">
				<input type="radio" name="motherlode_payment_mode" value="direct" <?php checked( 'direct', $current ); ?>>
				<?php esc_html_e( "Arranged Directly — cash, bank transfer, whatever suits you both. MotherLode HQ isn't involved in this payment at all.", 'motherlodehq' ); ?>
			</label>
		</div>
	</div>
	<?php wp_nonce_field( 'motherlode_payment_mode', 'motherlode_payment_mode_nonce' ); ?>
	<?php
}
add_action( 'dokan_new_product_form', 'motherlode_payment_mode_field', 20, 2 );

/**
 * Saved on Dokan's own product-save action, which fires for a new listing
 * and an edited one alike. Missing or tampered input fails toward 'held',
 * never toward 'direct' — see the file note above.
 *
 * @param int $post_id The listing just saved.
 */
function motherlode_save_payment_mode( int $post_id ): void {
	if ( ! isset( $_POST['motherlode_payment_mode_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['motherlode_payment_mode_nonce'] ) ), 'motherlode_payment_mode' ) ) {
		return;
	}

	$chosen = sanitize_key( wp_unslash( $_POST['motherlode_payment_mode'] ?? 'held' ) );

	update_post_meta( $post_id, MOTHERLODE_PAYMENT_META, 'direct' === $chosen ? 'direct' : 'held' );
}
add_action( 'dokan_process_product_meta', 'motherlode_save_payment_mode' );

/**
 * The honest badge, wherever a price shows — a search card and the
 * listing page both carry it, because a business choosing who to book
 * should never learn which kind of payment this is only after clicking
 * in.
 */
function motherlode_payment_mode_badge(): void {
	global $product;

	if ( ! $product ) {
		return;
	}

	$direct = 'direct' === motherlode_payment_mode( $product->get_id() );
	?>
	<p class="motherlode-payment-badge motherlode-payment-badge--<?php echo esc_attr( $direct ? 'direct' : 'held' ); ?>">
		<?php echo $direct
			? esc_html__( 'Paid directly, between you two', 'motherlodehq' )
			: esc_html__( 'Held & released through MotherLode HQ', 'motherlodehq' ); ?>
	</p>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'motherlode_payment_mode_badge', 11 );

/**
 * The single-listing page for a directly-paid booking. Add to Cart never
 * runs — there's no Stripe charge to collect, because MotherLode HQ was
 * never going to hold this money in the first place. In its place: the
 * same honest badge, and a real enquiry that lands in the shared
 * lamoureux-messages system — see inc/discussions.php — rather than a
 * payment button implying a protection this booking was never going to
 * have.
 *
 * SWAPPED FROM DOKAN'S OWN CONTACT-SELLER WIDGET, 3 September 2026 — her
 * words, direct: a real "Discussions" area in the dashboard, every thread
 * in one place. Dokan's widget only ever fires a one-off email with no
 * stored record, so nothing it sent could ever show up there. This uses
 * the same shared, already-active messaging plugin her dashboard panel
 * now reads from, so a direct-pay enquiry is a real, ongoing discussion
 * rather than a message that vanishes into an inbox.
 */
function motherlode_swap_direct_checkout_for_contact(): void {
	global $product;

	if ( ! $product || 'direct' !== motherlode_payment_mode( $product->get_id() ) ) {
		return;
	}

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_single_product_summary', 'motherlode_direct_enquiry_form', 30 );
}
add_action( 'woocommerce_before_single_product_summary', 'motherlode_swap_direct_checkout_for_contact' );

/**
 * A real enquiry, written into a real thread.
 */
function motherlode_direct_enquiry_form(): void {
	global $post;

	if ( ! class_exists( 'Lamoureux_Messages' ) ) {
		return;
	}

	$seller_id = (int) get_post_field( 'post_author', $post->ID );

	if ( ! $seller_id ) {
		return;
	}

	$sent = isset( $_GET['enquiry'] ) && '1' === $_GET['enquiry']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	?>
	<div class="motherlode-direct-arrange">
		<?php if ( $sent ) : ?>
			<p class="motherlode-direct-arrange-lede">Sent. She'll be in touch to arrange the rest directly.</p>
		<?php else : ?>
			<p class="motherlode-direct-arrange-lede"><?php esc_html_e( "This one's arranged directly with them — cash, bank transfer, whatever suits you both. Send them what you need and they'll come back to you.", 'motherlodehq' ); ?></p>
			<form class="motherlode-direct-enquiry" method="post">
				<?php wp_nonce_field( 'motherlode_direct_enquiry' ); ?>
				<input type="hidden" name="motherlode_enquiry_seller" value="<?php echo esc_attr( (string) $seller_id ); ?>">
				<?php if ( ! is_user_logged_in() ) : ?>
					<input type="email" name="motherlode_enquiry_email" placeholder="Your email" required>
				<?php endif; ?>
				<textarea name="motherlode_enquiry_words" placeholder="What do you need?" rows="3" required></textarea>
				<button type="submit" name="motherlode_send_enquiry" value="1" class="lode-btn lode-btn--dark">Send</button>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * The enquiry above, written to a real thread. Same shape as
 * motherlode_send_discussion_reply() in inc/discussions.php.
 */
function motherlode_send_direct_enquiry(): void {
	if ( ! isset( $_POST['motherlode_send_enquiry'] ) ) {
		return;
	}

	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'motherlode_direct_enquiry' ) ) {
		return;
	}

	if ( ! class_exists( 'Lamoureux_Messages' ) ) {
		return;
	}

	$seller_id = absint( $_POST['motherlode_enquiry_seller'] ?? 0 );
	$words     = sanitize_textarea_field( wp_unslash( $_POST['motherlode_enquiry_words'] ?? '' ) );

	if ( ! $seller_id || '' === $words ) {
		return;
	}

	$from = motherlode_who_am_i();

	if ( '' === $from ) {
		$email = sanitize_email( wp_unslash( $_POST['motherlode_enquiry_email'] ?? '' ) );

		if ( ! is_email( $email ) ) {
			return;
		}

		$from = $email;
	}

	Lamoureux_Messages::write( $from, 'user:' . $seller_id, $words, array( 'business' => 'motherlodehq' ) );

	wp_safe_redirect( add_query_arg( 'enquiry', '1', wp_get_referer() ?: home_url( '/' ) ) );
	exit;
}
add_action( 'template_redirect', 'motherlode_send_direct_enquiry', 6 );
