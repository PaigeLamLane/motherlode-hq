<?php
/**
 * A site being built is never cached.
 *
 * Her standing law: plain addresses only, nothing appended. She should never
 * have to add a version tag to look at her own work — that is a workaround
 * wearing the costume of a fix.
 *
 * The method was proven by the Aunt Tea session and written up by LOIS. This
 * is LocaLilly's own copy, in its own child theme, since the parent serves all
 * forty and a change there clears through the Lane first.
 *
 * MEASURED HERE, 22 AUGUST 2026, AND IT IS WHY THIS FILE EXISTS.
 *
 * The build site served Twenty Twenty-Five for forty-eight seconds after the
 * LocaLilly theme was live, with x-litespeed-cache: hit and
 * x-hcdn-cache-status: HIT. A cache-busted request returned the real page at
 * once. Deactivating the LiteSpeed plugin changed nothing, because the
 * LiteSpeed cache runs in the server in front of PHP and the plugin is only
 * how WordPress speaks to it.
 *
 * So the headers matter most here. X-LiteSpeed-Cache-Control is read by the
 * server itself and is heard whether or not any plugin is active.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Tell every cache in the stack to keep nothing.
 *
 * Three moments, because they are heard at different points — LiteSpeed reads
 * its own action, other plugins read the constant, and headers are the last
 * word for anything sitting in front of PHP.
 *
 * Gated on `localilly_is_build_site()`, which denies by default: an unknown
 * host counts as live and keeps its cache. Wrong that way costs one stale page
 * while somebody looks. Wrong the other way makes a live site slow for every
 * visitor.
 */
function localilly_never_cache_build(): void {
	if ( ! localilly_is_build_site() ) {
		return;
	}

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	do_action( 'litespeed_control_set_nocache', 'LocaLilly build site — never cached' );
}
add_action( 'init', 'localilly_never_cache_build' );
add_action( 'send_headers', 'localilly_never_cache_build', 1 );
add_action( 'wp', 'localilly_never_cache_build' );

/**
 * And say it in the headers, which the server hears without any plugin.
 */
function localilly_never_cache_headers(): void {
	if ( ! localilly_is_build_site() || headers_sent() ) {
		return;
	}

	header( 'X-LiteSpeed-Cache-Control: no-cache' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
}
add_action( 'send_headers', 'localilly_never_cache_headers', 99 );

/**
 * Clear what was stored before — and the moment she changes anything.
 *
 * Switching caching off stops new pages being kept and clears none of what is
 * already held — a cached page answers without running PHP, so none of the
 * above ever executes for it.
 *
 * ── THREE FAULTS FOUND HERE ON 25 AUGUST, ALL IN ONE FUNCTION ─────────
 *
 * **One: it was gated to a build site, so her live world had no purge of any
 * kind, ever.** The gate and the purge want opposite answers — holding pages
 * uncached is a build behaviour, and clearing what is held is a live one. A
 * build site nobody caches has nothing to purge. LOIS learned this exact
 * shape; LocaLilly still carried the old version.
 *
 * **Two: it was keyed on the modification time of this one file**, so a deploy
 * touching the stylesheet, a template and the front door left the stamp
 * unchanged and cleared nothing.
 *
 * **Three, and it is the one that reaches her hands: nothing purged when she
 * saved.** Matri Pair found it first, on her behalf — she changes a word,
 * loads her own site at the plain address the way she types it, sees the old
 * word, and reasonably decides her panel is broken.
 *
 * **Invisible to every session, because we all test with a cache-buster.** A
 * random number on the address is a different URL and misses the cache by
 * definition. Measured here rather than assumed:
 *
 *     plain address           x-litespeed-cache: hit
 *     with a cache-buster     x-litespeed-cache: miss
 *
 * **Her law, from Nan Made: a cache-buster proves a file, a plain address
 * proves a cache.** Matri Pair's sentence for the rest: a perfect panel behind
 * a cache is indistinguishable from no panel at all.
 */

/**
 * What deployment this is — read off the files that actually move.
 */
function localilly_this_deployment(): string {
	$stamp = (string) wp_get_theme()->get( 'Version' );

	foreach ( array( 'style.css', 'functions.php', 'assets/css/localilly.css' ) as $file ) {
		$path = get_stylesheet_directory() . '/' . $file;

		if ( file_exists( $path ) ) {
			$stamp .= '-' . filemtime( $path );
		}
	}

	return trim( $stamp, '-' );
}

/**
 * Clear what was stored, once per deployment, on every site including hers.
 */
function localilly_purge_after_deploy(): void {
	$stamp = localilly_this_deployment();

	if ( '' === $stamp || get_option( 'localilly_cache_cleared_for' ) === $stamp ) {
		return;
	}

	/* Written before the purge, so two requests arriving together purge once. */
	update_option( 'localilly_cache_cleared_for', $stamp, false );

	do_action( 'litespeed_purge_all' );
}
add_action( 'init', 'localilly_purge_after_deploy', 1 );
add_action( 'admin_init', 'localilly_purge_after_deploy', 1 );

/**
 * And the moment she changes anything at all.
 *
 * **This is the one that decides whether her panel exists.** Every control she
 * has is a theme modification, and a theme modification changes no file — so
 * nothing above would ever fire for it.
 *
 * `admin_init` is the hook that always runs, because the back end is never
 * cached and she is signed in when she saves.
 */
function localilly_purge_when_she_saves(): void {
	do_action( 'litespeed_purge_all' );
}
add_action( 'customize_save_after', 'localilly_purge_when_she_saves' );
add_action( 'update_option_theme_mods_' . get_option( 'stylesheet' ), 'localilly_purge_when_she_saves' );
add_action( 'switch_theme', 'localilly_purge_when_she_saves' );
