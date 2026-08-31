<?php
/**
 * A site holding young people never publishes who they are.
 *
 * FOUND 22 AUGUST 2026, AND IT WAS FOUND BY LOOKING RATHER THAN BY THINKING.
 *
 * Know Where measured that a WooCommerce coming-soon curtain hides the shop
 * template while the Store API hands out every product and price to anybody who
 * asks. Its line: the curtain is not the door.
 *
 * So the same question was put to this build site, which is closed to search
 * engines twice over — meta tag and header, both confirmed from outside:
 *
 *   /wp-json/wp/v2/media   200   every photograph, with paths
 *   /wp-json/wp/v2/pages   200
 *   /wp-json/wp/v2/users   200   {"name":"paigelamoureux@me.com", ...}
 *
 * **Her own email address, published as a display name, to anybody at all.**
 * noindex asks a crawler not to list a page. It asks nothing of a request.
 *
 * WHY THIS MATTERS MORE HERE THAN ANYWHERE
 *
 * Today that endpoint names Paige. The day LocaLilly has young people on it,
 * that endpoint names children — every account, with a slug and an author
 * archive, before anybody has paid a dollar or shown a card in their own name.
 *
 * Her whole safety design rests on identity arriving last. A public user list
 * hands it over first, by a road that never touches a page.
 *
 * So this closes the road rather than each traveller: the user endpoint answers
 * only somebody signed in with a reason to ask, and an author archive stops
 * existing. Both are WordPress defaults that suit a magazine and suit a site
 * introducing adults to children very badly.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/*
 * THIS FILE CARRIES NO GUARD OF ITS OWN, AND THAT IS DELIBERATE.
 *
 * It ships in the theme and as an mu-plugin, so it can be handed to PHP twice.
 * The guard against that lives at the require in functions.php, and it has to.
 *
 * A guard written at the top of THIS file destroyed the site twice on 23 August
 * 2026, in two different ways, and the second one is the lesson. **PHP declares
 * an unconditional top-level function when it compiles a file, before the first
 * line of that file runs.** So a file holding a function_exists check about its
 * own function finds the function already there — declared a moment earlier by
 * its own compilation — and returns. Every add_filter below it goes unread.
 *
 * The result reads as success and measures as failure: the function existed,
 * the site loaded, and every door this file exists to shut stood open. Only
 * asking has_filter rather than function_exists found it.
 *
 * **A file cannot ask whether it has already loaded. Whatever loads it can.**
 */

/**
 * A list of people is refused. A person's own record is not.
 *
 * RAISED BY ASK GIGI, AND THEN CORRECTED BY ASK GIGI.
 *
 * The first version refused everything under /wp/v2/users without `list_users`.
 * Gigi asked whether that broke a signed-in member reading their own record. I
 * loosened it and wrote that it would have broken Ask Gigi's account screens.
 *
 * **That was an inference written as a measurement.** Gigi checked its own site
 * rather than accepting the credit: Ask Gigi never touches /wp/v2/users, and all
 * eight of its account routes read the person server-side. The strict version
 * would have measured perfectly there too.
 *
 * So it is a risk rather than an incident. **A business whose account screens
 * are built on core's user endpoints would have found the strict version
 * breaking them silently, at a bad moment**, and that is a normal way to build.
 *
 * And the reason to loosen it stands without anybody's site as evidence:
 * **a rule refusing a whole route is broader than the harm it prevents, and the
 * harm is a list rather than a route.** Gigi's sentence.
 *
 * So the rule is about a list rather than about the route:
 *
 *   /wp/v2/users            a roll call        refused unless you can list users
 *   /wp/v2/users/me         your own record    allowed to anybody signed in
 *   /wp/v2/users/<you>      your own record    allowed
 *   /wp/v2/users/<somebody> somebody else      refused
 *
 * @param mixed           $result  Response to replace the requested version with.
 * @param mixed           $server  Server instance.
 * @param WP_REST_Request $request Request used to generate the response.
 * @return mixed
 */
function localilly_close_the_user_list( $result, $server, $request ) {
	if ( ! empty( $result ) ) {
		return $result;
	}

	$route = (string) $request->get_route();

	if ( ! str_starts_with( $route, '/wp/v2/users' ) ) {
		return $result;
	}

	// Somebody whose job is to see the list keeps seeing it.
	if ( current_user_can( 'list_users' ) ) {
		return $result;
	}

	$me = get_current_user_id();

	if ( $me ) {
		// Their own record, by either name for it.
		if ( preg_match( '#^/wp/v2/users/(me|' . $me . ')(/|$)#', $route ) ) {
			return $result;
		}
	}

	return new WP_Error(
		'localilly_users_are_not_a_list',
		__( 'The people here are met rather than listed.', 'localilly' ),
		array( 'status' => rest_authorization_required_code() )
	);
}
/*
 * PHP_INT_MAX, AND PRIORITY 10 WAS A SILENT FAILURE. FOUND BY AUNT TEA.
 *
 * On a live site with plugins, three callbacks sat on rest_pre_dispatch at 10 —
 * this one, ACF's, and a closure. Same priority means registration order, so
 * this one spoke first and one of the two after it handed back null on its way
 * past and wiped the refusal.
 *
 * Measured on aunttea.com.au: the function existed, the filter was attached,
 * the capability check failed correctly — **and the route still answered 200
 * with the full user record.** Every reading said the guard was working.
 *
 * **A filter that refuses has to be the last one to speak.** At 10 it is not.
 *
 * It would never have shown on a site with nothing else on that hook, which is
 * why it took a plugin-heavy live site to surface it — and why a guard that
 * measures clean on a quiet site proves nothing about a busy one. That is the
 * second time today the same shape has caught this file.
 */
add_filter( 'rest_pre_dispatch', 'localilly_close_the_user_list', PHP_INT_MAX, 3 );

/**
 * An author archive publishes a person by their own slug. Stop having one.
 *
 * WordPress builds /author/<slug>/ for every account whether anybody wanted it
 * or not, and the slug is derived from the login. On a site holding young
 * people that is a page per child.
 *
 * TWO DOORS, AND THE SECOND IS THE ONE THAT LEAKS. FOUND BY NAN MADE.
 *
 * Nan measured /?author=1 answering 301 on its own site and named it the
 * enumeration door standing open. It is: WordPress canonicalises ?author=1 to
 * /author/<slug>/, so the redirect itself hands over the slug — a person's name,
 * or on some of her sites her email with the punctuation swapped — before any
 * page is rendered and whatever the archive then does.
 *
 * **A redirect that reveals the thing it redirects away from protects nothing.**
 *
 * So this runs at priority 0, ahead of `redirect_canonical`, and it refuses the
 * numbered form outright rather than translating it.
 *
 * WHAT IT DOES NOT TOUCH, WHICH MATTERS TO EVERY BUSINESS SELLING SOMETHING.
 *
 * A Dokan store page is its own rewrite at /store/<slug>/ and is not an author
 * archive, so `is_author()` is false there and this never fires. A seller's
 * shopfront is public on purpose and stays exactly as it is. **Anybody landing
 * this on a selling site should still open a store page and look, rather than
 * take that from me** — I have no Dokan here to prove it on.
 */
function localilly_no_author_archives(): void {
	if ( is_user_logged_in() ) {
		return;
	}

	// The numbered form, refused before canonicalisation can translate it.
	if ( isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}

	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'localilly_no_author_archives', 0 );

/**
 * And stop WordPress canonicalising its way to a slug on any other route.
 *
 * @param string|false $redirect The redirect URL, or false to stop.
 * @return string|false
 */
function localilly_no_canonical_to_an_author( $redirect ) {
	return is_author() ? false : $redirect;
}
add_filter( 'redirect_canonical', 'localilly_no_canonical_to_an_author' );

/**
 * oEmbed advertises an author on every post. The REST link stays.
 *
 * OVERRULED BY NAN MADE, WHO WAS RIGHT AND MEASURED IT ON A REAL SHOP.
 *
 * My first version also removed `rest_output_link_wp_head`, which prints
 * <link rel="https://api.w.org/"> in the head. Nan kept it, on a site with a
 * live cart, because WooCommerce and its blocks discover the REST root through
 * that link and it could not measure the far end of removing it.
 *
 * **Nan is right and the removal was wrong on every site rather than only on a
 * shop.** That link hides where the API is; it closes nothing. The endpoint
 * answers identically whether the link is printed or not, so removing it buys
 * obscurity and risks anything that discovers the root properly — a shop, the
 * block editor, an app.
 *
 * **A guard that trades a real breakage for a hidden signpost is the wrong
 * trade.** The door is closed; the sign above it can stay.
 *
 * The oEmbed half is different and stays removed. oEmbed genuinely returns
 * `author_name` and `author_url` in its payload, so it hands over a person
 * rather than pointing at a route.
 */
function localilly_stop_advertising_authors(): void {
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
}
add_action( 'init', 'localilly_stop_advertising_authors' );

/**
 * Strip the author fields from an oEmbed response.
 *
 * @param array<string, mixed> $data The response data.
 * @return array<string, mixed>
 */
function localilly_oembed_without_the_author( $data ): array {
	unset( $data['author_name'], $data['author_url'] );

	return (array) $data;
}
add_filter( 'oembed_response_data', 'localilly_oembed_without_the_author' );

/**
 * A person's route is never cached, at the origin or at the edge.
 *
 * FOUND BY ESMERALDA, AND IT IS THE THIRD FAILURE MODE OF THIS GUARD.
 *
 * Its guard was correct at the origin — the function existed, the filter was
 * attached, and `apply_filters` handed back the WP_Error by hand. **And the
 * bare route still answered 200 with her email address**, served from
 * Hostinger's CDN with `max-age=604800` and an age of 584 seconds.
 *
 * Every server-side reading was true and the edge was serving a copy taken
 * before the guard existed. **A stale cached response is a permission that
 * outlives the fault it came from** — and none of us can purge that CDN from
 * the server.
 *
 * It is Aunt Tea's trap one layer further out: turning caching off never clears
 * what is already held, and a guard installed afterwards never reaches the copy
 * at the edge.
 *
 * So the route refuses to be cached on its way out, which stops it recurring.
 * `CDN-Cache-Control` is the half WordPress does not send on its own.
 *
 * **There is no server-side way to clear what the edge already holds.**
 * Esmeralda first reported that `Cache-Control: no-cache` makes it revalidate,
 * then withdrew it after measuring properly: Hostinger's CDN appears to key on
 * the request's cache headers, so **each header reaches a different stored
 * copy** rather than forcing a fresh one. The same URL in the same second
 * returned the corrected name to one header and her actual email address to
 * another, cache status HIT, age 1432 — it never reached the origin at all.
 *
 * **So a stale copy can hide behind a request header nobody thinks to send**,
 * and a CDN holding anything from before a fix is unproven until it is purged
 * at the panel. No number of readings substitutes for that.
 *
 * @param bool             $served  Whether the request has already been served.
 * @param mixed            $result  Result to send to the client.
 * @param WP_REST_Request  $request The request.
 * @param mixed            $server  Server instance.
 * @return bool
 */
function localilly_never_cache_a_person( $served, $result, $request, $server ) {
	if ( str_starts_with( (string) $request->get_route(), '/wp/v2/users' ) && ! headers_sent() ) {
		header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0', true );
		header( 'CDN-Cache-Control: no-store', true );
		header( 'Pragma: no-cache', true );
	}

	return $served;
}
add_filter( 'rest_pre_serve_request', 'localilly_never_cache_a_person', PHP_INT_MAX, 4 );

/**
 * And the sitemap stops naming the account at the doorbell.
 *
 * Found on her live domain, 23 August 2026, with every other door already shut:
 * the users REST route answered 401, the author archive redirected home — and
 * wp-sitemap-users-1.xml went on publishing /author/localilly/ to anybody who
 * asked. The page it points at redirects, so a crawler lands nowhere. **The
 * account name travels regardless**, and a login name handed out for free is
 * the first half of a password attempt.
 *
 * It is the same shape as everything else in this file, and the shape worth
 * naming: a door can be shut while the sign above it still reads out who lives
 * there.
 *
 * @param WP_Sitemaps_Provider $provider Sitemap provider.
 * @param string               $name     Provider name.
 * @return WP_Sitemaps_Provider|false
 */
function localilly_no_sitemap_of_people( $provider, $name ) {
	return ( 'users' === $name ) ? false : $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'localilly_no_sitemap_of_people', PHP_INT_MAX, 2 );
