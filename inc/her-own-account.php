<?php
/**
 * Parent Onboarding's own missing half — 2 September 2026.
 *
 * Her words, direct: "you're holding payments, so I think they need to
 * use Stripe Express... what used to be called the vendor onboarding is
 * going to need to be our parent onboarding, and they have to link a new
 * Stripe account through this. That's really, really important."
 *
 * The Stripe Connect engine itself is not built here — it already exists,
 * live, in the shared lamoureux-billing plugin (Lamoureux_Billing_Market),
 * settled directly with Aunt Tea on 2 September 2026 after finding a real
 * gap in how it hands off from Dokan. See functions.php for the two
 * filters that tell Market it — not Dokan's own stripe-express module —
 * is the one that pays a professional on this site, and that MotherLode
 * takes no commission on the work itself.
 *
 * This file is the places a professional actually meets that engine and
 * meets the dashboard itself: the moment her account is opened, the
 * gate that keeps her off a business's search until Stripe says she can
 * really be paid, and the dashboard's own greeting, benefit panel and
 * business-builder call.
 *
 * BUILT ON DOKAN'S OWN DASHBOARD, NEVER OVER IT — Nan Made's own hard
 * lesson, relayed directly, 2 September 2026: overriding Dokan's
 * dashboard.php template means every future Dokan update has to be
 * checked against a forked copy by hand, forever. Nan Made overrides
 * exactly one Dokan template in her whole build and says she'd take
 * even that one back. Everything below is injected on
 * dokan_dashboard_content_before instead — the same hook Dokan's own
 * side navigation uses — and themed with CSS over Dokan's own classes.
 * Dokan's actual dashboard.php is untouched.
 *
 * UNVERIFIED AGAINST A REAL STRIPE ACCOUNT. MotherLode has no key yet —
 * Lamoureux_Billing_Keys::which_money() reads 'none' as of tonight.
 * Every guard below is written to fail toward "not yet bookable" rather
 * than toward "bookable by default", so an absent key hides a
 * professional rather than ever risking a buyer paying into nowhere.
 * Nan Made's own warning stands: configured is not proven. This needs a
 * real connection, watched end to end, the moment a key exists.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * The moment a professional finishes the Dokan registration form, she
 * has somewhere waiting for her money before she's asked for a single
 * banking detail — Market's own account-opening is idempotent, so this
 * can run again on every login with no risk of a second account.
 *
 * @param int $user_id The new professional.
 */
function motherlode_open_her_account( int $user_id ): void {
	if ( ! class_exists( 'Lamoureux_Billing_Market' ) ) {
		return;
	}

	$user = get_userdata( $user_id );

	if ( ! $user ) {
		return;
	}

	$made = Lamoureux_Billing_Market::open_an_account( $user_id, $user->user_email );

	/*
	 * A NEW ACCOUNT STARTS HIDDEN, ALWAYS. Never assume ready — that is
	 * exactly the fault Market's own file names as the one that reaches
	 * a buyer. She becomes visible only once motherlode_watch_her_standing()
	 * below hears Stripe actually say so.
	 */
	update_user_meta( $user_id, '_motherlode_bookable', '0' );

	if ( is_wp_error( $made ) ) {
		do_action( 'lamoureux_billing_something_needs_a_person', 'motherlode.account_not_opened', array(
			'user' => $user_id,
			'why'  => $made->get_error_message(),
		) );
	}
}
add_action( 'dokan_new_seller_created', 'motherlode_open_her_account', 10, 1 );

/**
 * Kept current the moment Stripe actually says something has changed,
 * rather than asked fresh on every page a business might be searching
 * from. Market fires this only when her standing genuinely moves, so
 * this stays cheap.
 *
 * @param int    $who Which professional.
 * @param string $now Her new standing.
 */
function motherlode_watch_her_standing( int $who, string $now ): void {
	update_user_meta( $who, '_motherlode_bookable', Lamoureux_Billing_Market::READY === $now ? '1' : '0' );
}
add_action( 'lamoureux_market_she_moved', 'motherlode_watch_her_standing', 10, 2 );

/**
 * Whether the person now looking at the dashboard is one of her actual
 * professionals, rather than her — Nan Made's own real bug, relayed
 * directly: dokan_is_user_seller() answers true for an administrator,
 * because an admin holds every capability a seller does. Without this,
 * Paige opening her own dashboard would be told to go and connect a
 * Stripe account. She is not one of her own professionals.
 *
 * @param int $who Which person.
 * @return bool
 */
function motherlode_is_a_real_professional( int $who ): bool {
	if ( user_can( $who, 'manage_options' ) ) {
		return false;
	}

	return dokan_is_user_seller( $who );
}

/**
 * The gate. A business searching MotherLode never sees a professional
 * who cannot yet be paid — Market's own words: "a listing going live for
 * a seller who cannot be paid... everything below exists to make that
 * impossible rather than unlikely."
 *
 * Reads the cached flag above rather than asking Stripe inside a search
 * query, so a search page never waits on a network call. A professional
 * who has never been checked even once (the meta key is simply absent —
 * covers every account opened before this shipped) is excluded until
 * she has, which is the same fail-hidden shape as everywhere else here.
 *
 * @param array $args The seller query Dokan is about to run.
 * @return array
 */
function motherlode_only_show_who_can_be_paid( array $args ): array {
	$args['meta_query'] = $args['meta_query'] ?? array();

	$args['meta_query'][] = array(
		'key'   => '_motherlode_bookable',
		'value' => '1',
	);

	return $args;
}
add_filter( 'dokan_seller_listing_args', 'motherlode_only_show_who_can_be_paid' );

/* ============================================================
 * THE DASHBOARD ITSELF — all four panels on the same hook Dokan's
 * own side navigation uses, ordered by priority ahead of it (10),
 * every one full-width in the flex-wrap wrapper so they stack in
 * their own row above the side-nav-and-content row beneath them.
 * ============================================================ */

/**
 * The greeting. Her name, first, before anything Dokan would show her.
 */
function motherlode_dashboard_greeting(): void {
	$who = get_current_user_id();

	if ( ! motherlode_is_a_real_professional( $who ) ) {
		return;
	}

	$user  = wp_get_current_user();
	$first = $user->first_name ? $user->first_name : strtok( $user->display_name, ' ' );

	?>
	<section class="motherlode-dash-panel motherlode-welcome">
		<p class="motherlode-welcome-eyebrow">Your MotherLode</p>
		<h1 class="motherlode-welcome-head">Welcome Back, <?php echo esc_html( $first ); ?>.</h1>
		<p class="motherlode-welcome-body">Every hour you give here is yours first — set around the school run, the nap, the nights that are actually yours. Here's where it all lives.</p>
	</section>
	<?php
}
add_action( 'dokan_dashboard_content_before', 'motherlode_dashboard_greeting', 4 );

/**
 * The benefit, said plainly. Her words: "you should show the benefit —
 * we are doing everything, including the payments for them."
 *
 * LEFT RAIL — Nan Made's own test, relayed directly: does she need
 * this today, or does she need it once? An explainer is read once and
 * remembered; it never changes between Tuesday and Wednesday, so it
 * belongs beside the main column rather than inside it.
 */
function motherlode_dashboard_benefit(): void {
	if ( ! motherlode_is_a_real_professional( get_current_user_id() ) ) {
		return;
	}

	?>
	<section class="motherlode-dash-panel motherlode-dash-rail motherlode-benefit">
		<div class="motherlode-benefit-mark" aria-hidden="true">&#10022;</div>
		<div class="motherlode-benefit-text">
			<h2 class="motherlode-benefit-head">We Hold The Money, So You Never Have To Chase It.</h2>
			<p class="motherlode-benefit-body">A client pays before the work starts. We hold it, and the moment your booking is marked done, it releases straight to you — no invoice, no follow-up email, no six-week wait. You keep everything you earn; the only thing that ever comes off is Stripe's own small processing fee.</p>
		</div>
	</section>
	<?php
}
add_action( 'dokan_dashboard_content_before', 'motherlode_dashboard_benefit', 6 );

/**
 * The business builder. Points at the same atelier already live on
 * page-for-talent.php — one real flow, met twice, never duplicated.
 *
 * MAIN COLUMN — an empty or half-said profile is, in Nan Made's own
 * words about her equivalent, "the fault she is most likely to have
 * and least likely to notice." Ongoing rather than one-time, so it
 * stays in the wide column with the rest of today's work.
 */
function motherlode_dashboard_builder(): void {
	$who = get_current_user_id();

	if ( ! motherlode_is_a_real_professional( $who ) ) {
		return;
	}

	$bookable = '1' === get_user_meta( $who, '_motherlode_bookable', true );

	?>
	<section class="motherlode-dash-panel motherlode-dash-main motherlode-builder">
		<div class="motherlode-builder-text">
			<h2 class="motherlode-builder-head"><?php echo $bookable ? 'Your Profile Is Live.' : "Say What You're Brilliant At."; ?></h2>
			<p class="motherlode-builder-body">
				<?php if ( $bookable ) : ?>
					Businesses can find and book you right now. Come back any time to refine what you've said — the more exactly it sounds like you, the more the right person recognises herself in it.
				<?php else : ?>
					A few honest questions, never a form. Ten minutes, and it becomes the exact line a business searching for someone like you will read first.
				<?php endif; ?>
			</p>
		</div>
		<a class="motherlode-builder-btn" href="<?php echo esc_url( home_url( '/build-your-profile/' ) ); ?>"><?php echo $bookable ? 'Refine Your Profile' : 'Build Your Profile'; ?> <span aria-hidden="true">&rarr;</span></a>
	</section>
	<?php
}
add_action( 'dokan_dashboard_content_before', 'motherlode_dashboard_builder', 7 );

/**
 * The Stripe-connect step itself.
 *
 * MAIN COLUMN, FIRST — 2 September 2026, reordered after Paige asked
 * for real columns and Nan Made's own test came with it: does she need
 * this today, or once? This is the single most time-critical thing on
 * the whole screen while it's unresolved — nothing else here can
 * matter to her until it's done — so it leads the wide column rather
 * than trailing after the explainer and the profile prompt.
 *
 * Real gap closed rather than papered over: `she_may_list()` calls
 * Stripe at most every six hours (Market's own TRUST_FOR), so this can
 * genuinely be slow the first time a page loads after connecting.
 * That is Market's own design, not something to fight here.
 */
function motherlode_connect_stripe_banner(): void {
	$who = get_current_user_id();

	if ( ! class_exists( 'Lamoureux_Billing_Market' ) || ! motherlode_is_a_real_professional( $who ) ) {
		return;
	}

	if ( Lamoureux_Billing_Market::she_may_list( $who ) ) {
		return;
	}

	$here = dokan_get_navigation_url( 'dashboard' );
	$link = Lamoureux_Billing_Market::where_she_finishes( $who, $here, $here );

	if ( is_wp_error( $link ) ) {
		/*
		 * SHE IS TOLD THE TRUTH RATHER THAN GIVEN A DEAD BUTTON. If
		 * Market has no account for her yet (a very old account, from
		 * before this shipped), open_an_account is tried once here,
		 * live, rather than leaving her stuck looking at an error she
		 * can do nothing about.
		 */
		$user = get_userdata( $who );
		$made = $user ? Lamoureux_Billing_Market::open_an_account( $who, $user->user_email ) : $link;
		$link = is_wp_error( $made ) ? $made : Lamoureux_Billing_Market::where_she_finishes( $who, $here, $here );
	}

	?>
	<section class="motherlode-dash-panel motherlode-dash-main motherlode-connect-banner">
		<p class="motherlode-connect-head">One Thing Left Before Businesses Can Find You.</p>
		<?php if ( is_wp_error( $link ) ) : ?>
			<p class="motherlode-connect-body">We're setting up your account this moment — refresh this page shortly and the button below will be ready.</p>
		<?php else : ?>
			<p class="motherlode-connect-body">Link your bank details through Stripe, so the moment someone books you, there's somewhere for the money to land. Takes about two minutes, and nothing about it is visible to anyone but you.</p>
			<a class="motherlode-connect-btn" href="<?php echo esc_url( $link ); ?>">Connect Your Stripe Account <span aria-hidden="true">&rarr;</span></a>
		<?php endif; ?>
	</section>
	<?php
}
add_action( 'dokan_dashboard_content_before', 'motherlode_connect_stripe_banner', 5 );

/**
 * Dokan's own dashboard menu starts shut on a phone, every time — 2
 * September 2026, found by testing the real behaviour after Paige
 * asked about a menu Nan Made had trouble with. Confirmed first: this
 * theme adds no competing toggle of its own, so this is Dokan's own
 * shipped default rather than anything either of us built. A
 * professional opening her dashboard for the first time on her phone
 * sees a bare toggle button and nothing telling her there's a menu
 * behind it at all.
 *
 * Nan Made hit the same fault building hers, the hard way — hers
 * started shut after a fix that was meant to solve something else,
 * and a woman's first visit had no menu she could find. Her final
 * answer was the simplest one: it starts open, at every width, no
 * persistence to get wrong. Same fix here, own implementation rather
 * than copied code — Dokan's checkbox drives visibility purely through
 * CSS `:checked`, so setting it checked on load is enough; there is no
 * second control here for it to fight, unlike Nan Made's site.
 *
 * `change` is dispatched too, in case any other plugin script is
 * listening for it rather than just reading the checkbox state.
 */
function motherlode_dashboard_menu_starts_open(): void {
	if ( ! function_exists( 'dokan_is_seller_dashboard' ) || ! dokan_is_seller_dashboard() ) {
		return;
	}

	?>
	<script>
	(function () {
		var box = document.getElementById( 'toggle-mobile-menu' );

		if ( box && ! box.checked ) {
			box.checked = true;
			box.dispatchEvent( new Event( 'change', { bubbles: true } ) );
		}
	})();
	</script>
	<?php
}
add_action( 'dokan_dashboard_content_after', 'motherlode_dashboard_menu_starts_open' );

/**
 * The dashboard menu itself matches a shop, not this business — 2
 * September 2026, her words: "we don't have a withdraw option because
 * they'll get paid," and Coupons has no place here at all against her
 * own standing law: "no discount codes, anywhere, ever."
 *
 * Withdraw is switched off through Dokan Pro's own real setting
 * (dokan_withdraw → hide_withdraw_option), not hidden here — the
 * professional gets paid automatically through Market the moment a
 * booking is marked done, so there is nothing to withdraw and no
 * screen asking her to. Coupons has no equivalent native toggle, so
 * it's removed from the menu directly, here.
 *
 * REAL OPEN QUESTION, NOT RESOLVED HERE: "Products" is left exactly
 * as it is, on purpose, rather than guessed at. Dokan Pro's own
 * Booking module — the one that would let a professional set real
 * hours and a real rate, rather than a plain WooCommerce product — is
 * confirmed NOT active on this site (dokan_active_modules reads
 * empty). Right now "Products" is the only place at all a
 * professional could describe what she does, and "Bookings" in the
 * sidebar is actually WooCommerce Orders wearing Market's relabelled
 * name — not a real booking system. Removing Products before that's
 * settled would take away the one working path without putting
 * anything real in its place. Flagged back to her rather than guessed.
 */
function motherlode_dashboard_menu_matches_the_business( array $menus ): array {
	unset( $menus['coupons'] );

	return $menus;
}
add_filter( 'dokan_get_dashboard_nav', 'motherlode_dashboard_menu_matches_the_business', 20 );
