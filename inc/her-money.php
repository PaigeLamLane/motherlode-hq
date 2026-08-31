<?php
/**
 * LocaLilly's three prices, and the one it will never charge.
 *
 * HER RULINGS, ALL SETTLED:
 *
 *     a neighbour       $1, once, on a real card
 *     a young person    $10 a month
 *     a parent's gift   $120 a year, or one, three, six or twelve months
 *
 * **AND NOTHING PER JOB, EVER.** Not a preference — LocaLilly sits outside
 * employment law under section 4(3)(e) only while nobody but the young person
 * takes a benefit *from an engagement*. A flat monthly fee is safe. **A cut of
 * each job would collapse the exemption**, and with it a fifteen-year-old's
 * right to do this at all without their neighbour holding a licence. Written
 * here because this is the file where somebody would one day propose it.
 *
 * THE DOLLAR IS A MOMENT RATHER THAN A FEE. Her own words carry it, and they
 * are the reason it works: **a real person behind every account.** It earns
 * while it protects, which is the cleverest piece of this business and hers.
 *
 * lamoureux-billing owns Stripe. Nothing here touches a key, a session or a
 * webhook — this names three prices and hands them over.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

const LOCALILLY_DOLLAR   = 100;    // one dollar, in cents
const LOCALILLY_MONTHLY  = 1000;   // ten dollars a month
const LOCALILLY_GIFT_YEAR = 12000; // a hundred and twenty for a year

/**
 * What LocaLilly sells, in her words.
 *
 * @return array<string, array<string, mixed>>
 */
function localilly_what_we_ask_for(): array {
	return array(
		'the-dollar' => array(
			'holds'    => 'localilly-verified',
			'describe' => 'LocaLilly · one dollar, once, so a young person knows who asked for them',
			'amount'   => LOCALILLY_DOLLAR,
			'mode'     => 'payment',
			'says'     => localilly_say( 'm_dollar_why' ) ?: 'We are committed to community safety, and that starts with a real person behind every account. One dollar on your own card, once — it takes seconds, and it means a young person arriving for your shift knows exactly who asked for them.',
		),
		'a-place'    => array(
			'holds'    => 'localilly-listed',
			'describe' => 'LocaLilly · your business, ten dollars a month',
			'amount'   => LOCALILLY_MONTHLY,
			'mode'     => 'subscription',
			'every'    => 'month',
			'says'     => localilly_say( 'm_monthly_why' ) ?: 'Ten dollars a month keeps your business here, and your first month is free. Every dollar a neighbour pays you is yours — LocaLilly takes none of it.',
		),
		'a-gift'     => array(
			'holds'    => 'localilly-listed',
			'describe' => 'LocaLilly · a year for somebody, given',
			'amount'   => LOCALILLY_GIFT_YEAR,
			'mode'     => 'payment',
			'says'     => localilly_say( 'm_gift_why' ) ?: 'A year of their own business, bought for them. Their page, their prices and their words are theirs from the first day — and when the year is up it is theirs to carry on.',
		),
	);
}

/**
 * Send somebody to pay, by the name of what they are buying.
 *
 * @param string $what  One of the three.
 * @param string $owner Whose it is, where that differs from who is paying.
 * @return string|WP_Error Somewhere to send them.
 */
function localilly_send_them_to_pay( string $what, string $owner = '', string $back = '' ) {
	if ( ! class_exists( 'Lamoureux_Billing_Checkout' ) ) {
		return new WP_Error( 'localilly_no_billing', 'The billing module is absent, so nobody was sent anywhere rather than sent nowhere.' );
	}

	$all = localilly_what_we_ask_for();

	if ( ! isset( $all[ $what ] ) ) {
		return new WP_Error( 'localilly_no_such_price', 'LocaLilly asks for three things and that is none of them.' );
	}

	$asking = $all[ $what ];

	return Lamoureux_Billing_Checkout::send_them_to_pay(
		array(
			'business' => 'localilly',
			'holds'    => $asking['holds'],
			'describe' => $asking['describe'],
			'amount'   => $asking['amount'],
			'mode'     => $asking['mode'],
			'every'    => $asking['every'] ?? 'month',
			'currency' => 'aud',
			'owner'    => $owner,
			'back_to'  => '' !== $back ? $back : home_url( '/thank-you/' ),
			'gave_up'  => home_url( '/' ),
		)
	);
}

/**
 * Whether money can actually complete here.
 *
 * **A key is not a capability.** A key present says a request could be signed;
 * it says nothing about whether a payment can finish, which needs the webhook
 * secret as well. This asks the question a person actually has.
 *
 * @return array{keys:bool, webhook:bool, whole:bool}
 */
function localilly_can_money_move(): array {
	$key  = '' !== (string) apply_filters( 'lamoureux_billing_stripe_key', '' );
	$hook = '' !== (string) apply_filters( 'lamoureux_billing_webhook_secret', '' );

	return array(
		'keys'    => $key,
		'webhook' => $hook,
		'whole'   => $key && $hook,
	);
}

/**
 * The dollar, pressed.
 *
 * Kept on `template_redirect` rather than in the template, so a page that
 * renders and a road that charges are never the same act.
 */
function localilly_take_the_dollar(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_dollar'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_dollar'] ) ), 'localilly_dollar' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	/*
	 * ── SHE COMES BACK WHERE SHE WAS ──────────────────────────────────
	 *
	 * Her ruling, 30 August: **why would you put another step, another
	 * barrier. Once they say yes, it goes to the screen to pay the dollar.**
	 *
	 * It sent everybody to a thank-you page, so a neighbour who pressed on
	 * Zac's page paid a dollar and landed nowhere near Zac. **The dollar
	 * exists so she can write to him; returning her anywhere else makes her
	 * find him again.**
	 */
	/*
	 * **A dollar has to belong to somebody.** She pressed on Zac's page with
	 * no key in her browser, so the payment was recorded against nobody and
	 * the gate asked her again. The key is made here, at the one moment it
	 * becomes necessary — no account, no sign-in, nothing to invent.
	 */
	if ( function_exists( 'localilly_make_sure_they_have_a_place' ) ) {
		localilly_make_sure_they_have_a_place();
	}

	/*
	 * The page names where she came from. A referer is what a browser
	 * happens to say and it landed her on a 404 after paying real money.
	 */
	$back = isset( $_POST['localilly_back'] ) ? esc_url_raw( wp_unslash( $_POST['localilly_back'] ) ) : '';

	if ( '' === $back || 0 !== strpos( $back, home_url() ) ) {
		$referred = wp_get_referer();
		$back     = is_string( $referred ) && 0 === strpos( $referred, home_url() ) ? $referred : home_url( '/' );
	}

	/*
	 * **Stripe substitutes the session id into the address it returns her to.**
	 * That is what lets the site ask Stripe whether she paid, rather than
	 * waiting for a webhook that has never once arrived.
	 */
	$back = add_query_arg( 'session', '{CHECKOUT_SESSION_ID}', $back );

	$where = localilly_send_them_to_pay( 'the-dollar', '', $back );

	if ( is_wp_error( $where ) ) {
		/*
		 * **Nothing is dressed up.** A neighbour meets what actually happened,
		 * in her register, on the page they were already on.
		 */
		wp_safe_redirect( add_query_arg( 'sorry', $where->get_error_code(), get_permalink() ) );
		exit;
	}

	wp_redirect( esc_url_raw( $where ) );
	exit;
}
add_action( 'template_redirect', 'localilly_take_the_dollar', 5 );
