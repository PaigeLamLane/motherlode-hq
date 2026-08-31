<?php
/**
 * A page carrying one person's own words is never cached.
 *
 * FOUND WALKING HER LIVE SITE, 23 AUGUST 2026. The first moment of the road
 * saved correctly and the page that came back was a stored copy of the empty
 * version. That alone is only confusing — **the danger is the other direction.**
 *
 * A full-page cache keyed on the address alone will happily store the version
 * built for one person and hand it to the next. On this business that means a
 * young person's own words, their prices and their suburb, shown to somebody
 * else entirely. **On a site whose whole argument is that a child is looked
 * after here, that is the worst fault available.**
 *
 * It had not happened. It was one popular page away from happening.
 *
 * SO THREE THINGS, SAID AT THE THREE POINTS EACH IS HEARD. LiteSpeed reads its
 * own action, other caches read the constant, and the headers are the last word
 * for anything sitting in front of PHP — including a CDN that never runs a line
 * of it.
 *
 * ANY PAGE THAT COULD CARRY SOMEBODY, RATHER THAN THE ONES THAT DO TODAY. The
 * list is by template, so a road added next week is covered by adding it here
 * rather than by remembering this file exists.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is this a screen built for one particular person.
 *
 * ── TWO QUESTIONS, AND THE SECOND ONE IS THE DURABLE ONE ──────────────
 *
 * The first version asked only *is this one of my personal templates*. That
 * covers what exists today and covers nothing added tomorrow — The Shipper
 * measured /dashboard/ answering from store on this very site, a route no
 * template of mine has ever owned. **A list of known doors protects the doors
 * you remembered.**
 *
 * So the real question is asked first: **is this browser carrying somebody?**
 * A request holding a young person's key or a neighbour's key is personal
 * whatever route it arrived on — a template, a plugin's page, a dashboard
 * somebody builds next month, an endpoint nobody has thought of.
 *
 * MEASURED AFTERWARDS RATHER THAN ASSUMED, and one line of it is worth
 * writing down because it looks like a leak and is not:
 *
 *     /                       hit         still stored, and correctly
 *     /create-your-business/  no-cache
 *     /your-place/            no-cache
 *     /dashboard/             no-cache    the route this fix was for
 *
 * **The front page is still served from store to somebody carrying a key, and
 * that is right.** It holds nothing of theirs. A stored copy of it can be
 * handed to anybody, because everybody sees the same page. Making it private
 * would cost every visitor the site's speed to protect nothing at all.
 *
 * The line worth keeping: **a page is dangerous to store when it differs by
 * person, rather than when the person is identifiable.**
 *
 * The template list stays underneath it, because **the very first view is
 * anonymous and still must not be stored** — that is the request that hands
 * out a key, and a stored copy of it would hand the same key to everybody.
 */
function localilly_is_somebodys(): bool {
	/* Whoever is carrying a key is a person rather than a page. */
	foreach ( array( LOCALILLY_KEYJAR, LOCALILLY_THEIRJAR ) as $jar ) {
		if ( defined( $jar ) || isset( $_COOKIE[ $jar ] ) ) {
			if ( ! empty( $_COOKIE[ $jar ] ) ) {
				return true;
			}
		}
	}

	/*
	 * ── A YOUNG PERSON'S PAGE DIFFERS BY WHO IS READING IT ────────────
	 *
	 * It offers the dollar to a stranger and a box to write in to somebody
	 * who has paid. **That makes it personal, and it was not a page**, so this
	 * returned false and LiteSpeed cached it.
	 *
	 * Her own dollar was confirmed, the server agreed she was verified, and
	 * she was handed a stranger's copy telling her to pay again. **The page
	 * was right and the cache was old** — which is the exact shape she has
	 * been fighting all morning, one template to the left.
	 */
	if ( is_singular( LOCALILLY_YOUNG ) ) {
		return true;
	}

	if ( ! is_page() ) {
		return false;
	}

	$mine = (string) get_page_template_slug( get_queried_object_id() );

	/**
	 * Filters the templates that are personal to a visitor.
	 *
	 * @param string[] $templates Template files.
	 */
	$personal = (array) apply_filters(
		'localilly_personal_templates',
		array( 'page-build.php', 'page-place.php', 'page-join.php', 'page-atelier.php' )
	);

	return in_array( $mine, $personal, true );
}

/**
 * And tell LiteSpeed the two keys make a request private, at its own level.
 *
 * A rule inside PHP only helps a request that reaches PHP. **A stored copy is
 * served before PHP runs at all**, which is the whole reason the first version
 * could be true and the page still come back from store. Naming the cookies to
 * LiteSpeed keeps them out of the store rather than getting them out of it.
 */
function localilly_keys_are_private( $list ) {
	$list   = is_array( $list ) ? $list : array();
	$list[] = LOCALILLY_KEYJAR;
	$list[] = LOCALILLY_THEIRJAR;

	return array_values( array_unique( $list ) );
}
add_filter( 'litespeed_vary_cookies', 'localilly_keys_are_private' );
add_filter( 'litespeed_cache_vary_cookies', 'localilly_keys_are_private' );

/**
 * Tell every cache in the stack to keep none of it.
 */
function localilly_keep_nobody(): void {
	if ( ! localilly_is_somebodys() ) {
		return;
	}

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	do_action( 'litespeed_control_set_nocache', 'LocaLilly — this page belongs to one person' );

	if ( ! headers_sent() ) {
		header( 'Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0', true );
		header( 'CDN-Cache-Control: no-store', true );
		header( 'Vary: Cookie', true );
		header( 'Pragma: no-cache', true );
	}
}
add_action( 'template_redirect', 'localilly_keep_nobody', 0 );
add_action( 'send_headers', 'localilly_keep_nobody', 1 );
