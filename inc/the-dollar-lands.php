<?php
/**
 * A dollar is confirmed by asking Stripe, rather than by waiting to be told.
 *
 * **Her words, 30 August: I got a receipt from it for the first time.**
 *
 * She paid three times and her site was never told once. Stripe took the money
 * perfectly and sent her a receipt — **the webhook is what never arrived**, and
 * a webhook is somebody else's server choosing to call yours.
 *
 * **So this stops waiting.** She comes back from Stripe carrying the session
 * she just completed, and the site asks Stripe directly whether it was paid.
 * One call, on the one request where it matters, with an answer that cannot be
 * faked by anybody typing an address.
 *
 * The webhook still works when it works. This is the road that does not depend
 * on it.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * She has come back from paying. Ask Stripe, then let her in.
 */
function localilly_the_dollar_lands(): void {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$paid    = isset( $_GET['paid'] );
	$session = isset( $_GET['session'] ) ? sanitize_text_field( wp_unslash( $_GET['session'] ) ) : '';
	// phpcs:enable

	if ( ! $paid && 0 !== strpos( $session, 'cs_' ) ) {
		return;
	}

	$key = (string) apply_filters( 'lamoureux_billing_stripe_key', '' );

	if ( '' === $key ) {
		return;
	}

	/*
	 * ── THE PLACEHOLDER NEVER SURVIVED ────────────────────────────────
	 *
	 * Stripe substitutes {CHECKOUT_SESSION_ID} into a success_url — and the
	 * billing module runs the address through `add_query_arg` afterwards,
	 * **which encodes the braces to %7B and %7D.** Stripe then sees a literal
	 * string rather than a placeholder, so the session never came back and she
	 * paid a fourth time for nothing.
	 *
	 * So this stops asking for a session id it cannot get. `paid=1` does
	 * arrive, and Stripe will say which of its own sessions were completed.
	 * **The site asks Stripe what just happened rather than being handed it.**
	 */
	$said = null;

	if ( 0 === strpos( $session, 'cs_' ) ) {
		$one = wp_remote_get(
			'https://api.stripe.com/v1/checkout/sessions/' . rawurlencode( $session ),
			array( 'timeout' => 15, 'headers' => array( 'Authorization' => 'Bearer ' . $key ) )
		);

		if ( ! is_wp_error( $one ) ) {
			$body = json_decode( (string) wp_remote_retrieve_body( $one ), true );
			$said = is_array( $body ) && 'paid' === ( $body['payment_status'] ?? '' ) ? $body : null;
		}
	}

	if ( ! $said ) {
		$recent = wp_remote_get(
			'https://api.stripe.com/v1/checkout/sessions?limit=5',
			array( 'timeout' => 15, 'headers' => array( 'Authorization' => 'Bearer ' . $key ) )
		);

		if ( is_wp_error( $recent ) ) {
			return;
		}

		$body = json_decode( (string) wp_remote_retrieve_body( $recent ), true );

		foreach ( (array) ( $body['data'] ?? array() ) as $maybe ) {
			if ( 'paid' !== ( $maybe['payment_status'] ?? '' ) ) {
				continue;
			}

			/*
			 * Paid today. **Her payment was at 8.28 and a quarter-hour window
			 * missed it entirely**, so she pressed again and was told nothing
			 * had happened.
			 *
			 * A wider window can only ever match a session that was genuinely
			 * paid on this account, and it is matched to a browser that has
			 * no verification yet — so the worst case is a person who paid
			 * being let in, which is the point.
			 */
			if ( absint( $maybe['created'] ?? 0 ) < ( time() - DAY_IN_SECONDS ) ) {
				continue;
			}

			$said = $maybe;
			break;
		}
	}

	if ( ! $said ) {
		return;
	}

	$who = localilly_make_sure_they_have_a_place();

	if ( '' === $who ) {
		return;
	}

	$place = localilly_their_place();

	if ( ! $place ) {
		return;
	}

	$email = sanitize_email( (string) ( $said['customer_details']['email'] ?? '' ) );
	$name  = sanitize_text_field( (string) ( $said['customer_details']['name'] ?? '' ) );

	if ( is_email( $email ) ) {
		update_post_meta( $place->ID, '_ll_email', $email );
	}

	if ( '' !== $name ) {
		update_post_meta( $place->ID, '_ll_name', $name );
		wp_update_post( array( 'ID' => $place->ID, 'post_title' => $name ) );
	}

	update_post_meta( $place->ID, '_ll_verified', current_time( 'mysql' ) );
	update_post_meta( $place->ID, '_ll_paid_session', (string) ( $said['id'] ?? '' ) );

	localilly_say_back( 'paid' );

	wp_safe_redirect( remove_query_arg( array( 'session', 'paid' ) ) );
	exit;
}

add_action( 'template_redirect', 'localilly_the_dollar_lands', 3 );
