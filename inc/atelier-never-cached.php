<?php
/**
 * Any page carrying the Atelier is never cached — MotherLode's own cover
 * while the shared `lamoureux-atelier` plugin (still v0.3.4 on this world)
 * does not yet exclude itself.
 *
 * 8 September 2026 — found live, testing the Atelier against her own
 * capstone ruling that sitting for it must be "the most joyful experience"
 * and never behave like a form. It doesn't behave like a form — it behaves
 * like nobody heard the last answer at all.
 *
 * PROVEN, NOT REASONED: `/build-your-profile/` is served
 * `x-litespeed-cache: hit`. Posted a real answer to question one with the
 * page's own real nonce (accepted — the server's own progress cookie moved
 * on to the next question). Read the page straight back with that same
 * cookie: still the cached first question, "What are you brilliant at?" —
 * her real answer, gone from what she sees, though it was kept. Read the
 * identical request with a cache-busting query so LiteSpeed had to run PHP:
 * the true next question, correct and current. Same cookie, same moment,
 * two different answers — the gap is the cache, not the mechanism.
 *
 * This is her own already-standing law (LamoureuxLane CLAUDE.md, "Any
 * shared instrument that renders per-visitor state into a page refuses
 * caching on that page automatically") — the shared plugin doesn't do this
 * on the copy running here yet, so this world covers itself from its own
 * theme rather than waiting on a shared-code change. Raised to Darling for
 * `lamoureux-atelier` itself; not changed here.
 *
 * Computed from whether the current page actually renders the shortcode,
 * never a hardcoded page slug — so a second atelier placed anywhere else on
 * this world is covered the moment it exists, with nothing to remember.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * True the moment the page being served actually carries an [atelier] sitting.
 */
function motherlode_page_has_atelier(): bool {
	if ( ! is_singular() ) {
		return false;
	}

	$post = get_queried_object();

	return $post instanceof WP_Post && has_shortcode( (string) $post->post_content, 'atelier' );
}

/**
 * Tell every layer of the cache to keep nothing, the same three moments the
 * build-site guard already uses — LiteSpeed hears its own action, other
 * plugins read the constant, headers are the last word for anything sitting
 * in front of PHP.
 */
function motherlode_never_cache_atelier(): void {
	if ( ! motherlode_page_has_atelier() ) {
		return;
	}

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	do_action( 'litespeed_control_set_nocache', 'MotherLode Atelier sitting in progress — never cached' );
}
add_action( 'wp', 'motherlode_never_cache_atelier' );
add_action( 'send_headers', 'motherlode_never_cache_atelier', 1 );

/**
 * And say it in the headers themselves, which the server hears without any
 * plugin standing between it and PHP.
 */
function motherlode_never_cache_atelier_headers(): void {
	if ( ! motherlode_page_has_atelier() || headers_sent() ) {
		return;
	}

	header( 'X-LiteSpeed-Cache-Control: no-cache' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
	header( 'Pragma: no-cache' );
}
add_action( 'send_headers', 'motherlode_never_cache_atelier_headers', 99 );
