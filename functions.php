<?php
/**
 * LocaLilly.
 *
 * Find your local Lilly, Jack, Mia or Mac.
 *
 * The child theme. It holds what LocaLilly looks like and what LocaLilly says.
 * Structure lives in the parent and is never copied out of it.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * The build site is closed to search engines by its own hostname.
 *
 * A checkbox in Settings is one careless click from being cleared, and a build
 * site carrying real photographs of children must never be one click from
 * Google. The hostname cannot be clicked off.
 *
 * The live host is named as the single allowed exception, so this stays closed
 * on every subdomain that has ever existed and every one that ever will.
 */
function localilly_is_build_site(): bool {
	$host = strtolower( (string) ( $_SERVER['HTTP_HOST'] ?? '' ) );
	$host = preg_replace( '/:\d+$/', '', $host );

	return ! in_array( $host, array( 'localilly.com.au', 'www.localilly.com.au' ), true );
}

/**
 * The robots meta and header moved out of this theme on 22 August 2026.
 *
 * They now live in a must-use plugin — wp-content/mu-plugins/
 * localilly-build-site-private.php — which loads before every theme and cannot
 * be carried off by one.
 *
 * **The reason is a thing that actually happened here.** Hostinger's own AI
 * website builder installed and activated a theme on this site that morning
 * without anybody asking. For that window this gate was not running at all, and
 * the only thing holding the site shut was WordPress's checkbox — which leaves
 * no trace when somebody unticks it, and which a rebuild resets.
 *
 * `localilly_is_build_site()` stays here, because the never-cached instrument
 * below asks it and a theme should be able to answer that about itself.
 */

/**
 * Appearance, then Customize — a section per page, and every picture labelled
 * with where it lands.
 */
require_once get_stylesheet_directory() . '/inc/customizer.php';

/**
 * The door, where every path leads until there is somebody to find.
 */
require_once get_stylesheet_directory() . '/inc/never-a-silent-off.php';
require_once get_stylesheet_directory() . '/inc/only-her-eyes.php';
require_once get_stylesheet_directory() . '/inc/her-legal-words.php';
require_once get_stylesheet_directory() . '/inc/her-own-size.php';
require_once get_stylesheet_directory() . '/inc/who-sees-this.php';
require_once get_stylesheet_directory() . '/inc/ask-for-it-back.php';
require_once get_stylesheet_directory() . '/inc/the-door.php';

/**
 * A site holding young people never publishes who they are.
 */
/*
 * The guard loads here only where it has not already loaded.
 *
 * It ships in the theme so a build carries its own, and as an mu-plugin so it
 * outlives a theme switch. Her live site received both at once on 23 August
 * 2026 and PHP stopped the site dead on a redeclared function.
 *
 * **The check has to sit at the require rather than inside the file**, and that
 * cost the site three attempts to learn. PHP binds an unconditional top-level
 * function when it COMPILES the file, so a runtime return at the top of that
 * file executes long after the declaration has already been made. A guard
 * inside the file reads perfectly and does precisely nothing. A file never
 * compiled cannot declare, so the only guard that works is one that decides
 * whether to load at all.
 */
require_once get_stylesheet_directory() . '/inc/what-they-ask.php';
require_once get_stylesheet_directory() . '/inc/their-page.php';
require_once get_stylesheet_directory() . '/inc/finding-somebody.php';
require_once get_stylesheet_directory() . '/inc/it-opens.php';
require_once get_stylesheet_directory() . '/inc/everything-travels.php';
require_once get_stylesheet_directory() . '/inc/into-accounts.php';
require_once get_stylesheet_directory() . '/inc/her-money.php';
require_once get_stylesheet_directory() . '/inc/the-onward-road.php';
require_once get_stylesheet_directory() . '/inc/their-place.php';
require_once get_stylesheet_directory() . '/inc/the-first-word.php';
require_once get_stylesheet_directory() . '/inc/the-dollar-lands.php';
require_once get_stylesheet_directory() . '/inc/the-dollar-is-kept.php';
require_once get_stylesheet_directory() . '/inc/what-became-of-it.php';
require_once get_stylesheet_directory() . '/inc/the-way-back-in.php';
require_once get_stylesheet_directory() . '/inc/what-the-work-looks-like.php';
require_once get_stylesheet_directory() . '/inc/her-own-face.php';
require_once get_stylesheet_directory() . '/inc/about-a-neighbour.php';
require_once get_stylesheet_directory() . '/inc/their-own-place.php';
require_once get_stylesheet_directory() . '/inc/her-back-end.php';
require_once get_stylesheet_directory() . '/inc/never-somebody-elses.php';
require_once get_stylesheet_directory() . '/inc/her-letters.php';
require_once get_stylesheet_directory() . '/inc/her-words.php';
require_once get_stylesheet_directory() . '/inc/how-it-arrives.php';

if ( ! function_exists( 'localilly_close_the_user_list' ) ) {
	require_once get_stylesheet_directory() . '/inc/nobody-is-listed.php';
}

/**
 * A site being built is never cached, so her plain addresses always tell the
 * truth. Loaded after the build-site test it depends on.
 */
require_once get_stylesheet_directory() . '/inc/never-cached-while-building.php';

/**
 * The three faces, each with one job.
 *
 * Abril Fatface is the plate — a heavy Didone that can carry a cast-letter
 * lift, where a hairline Didone cannot. Rubik is every word a person has to
 * read. Caveat is a neighbour's own hand, and it appears nowhere except in
 * words a neighbour actually wrote.
 */
function localilly_fonts(): void {
	wp_enqueue_style(
		'localilly-fonts',
		'https://fonts.googleapis.com/css2?family=Baloo+Bhai+2:wght@400..800&family=Fraunces:opsz,wght@9..144,300..600&family=Prosto+One&family=Caveat:wght@400;600&family=Rubik:wght@300;400;500;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'localilly_fonts', 4 );

/**
 * Tokens first, then the look assembled from them.
 */
function localilly_styles(): void {
	wp_enqueue_style(
		'localilly',
		get_stylesheet_uri(),
		array( 'lamoureux-base' ),
		lamoureux_asset_version( 'style.css', true )
	);

	$look = get_stylesheet_directory() . '/assets/css/localilly.css';

	if ( ! file_exists( $look ) ) {
		return;
	}

	/*
	 * ON A BUILD SITE THE LOOK IS INLINED, AND THIS IS NOT A SHORTCUT.
	 *
	 * Measured on build.localilly.com.au, 22 August 2026. Hostinger's CDN
	 * ignores the query string on an asset, so ?ver= buys nothing at all:
	 *
	 *   .../assets/css/localilly.css?x=<random>   the new file
	 *   .../assets/css/localilly.css              a copy three hours old
	 *
	 * The page linked to the plain URL, so three hours of stylesheet changes
	 * were on the server and invisible on the site — and every one of them
	 * read as a change that had failed. `wp litespeed-purge all` clears the
	 * pages and left this asset standing.
	 *
	 * Inlining removes the CDN from the question entirely: the HTML is
	 * no-store on a build site, so the look is always exactly what was
	 * deployed a moment ago. It costs one round trip and saves a whole
	 * category of ghost fault while she is watching.
	 *
	 * A live site keeps the linked file, which a browser can cache properly —
	 * and there the answer is a hash of the contents in the filename rather
	 * than in a query, since a query is what the CDN throws away.
	 */
	if ( localilly_is_build_site() ) {
		$css = file_get_contents( $look ); // phpcs:ignore WordPress.WP.AlternativeFunctions

		if ( false !== $css ) {
			wp_register_style( 'localilly-look', false, array( 'localilly' ), null );
			wp_enqueue_style( 'localilly-look' );
			wp_add_inline_style( 'localilly-look', $css );
			return;
		}
	}

	wp_enqueue_style(
		'localilly-look',
		get_stylesheet_directory_uri() . '/assets/css/localilly.css',
		array( 'localilly' ),
		lamoureux_asset_version( 'assets/css/localilly.css', true )
	);
}
add_action( 'wp_enqueue_scripts', 'localilly_styles', 10 );

/**
 * The mark, resolved absolutely and attached to the child stylesheet.
 *
 * A relative url() inside a CSS custom property resolves against the
 * stylesheet that USES the property, never the one that declares it. The
 * parent's base.css is what reads --mark-image, so a relative path in the
 * child's style.css resolves against themes/lamoureux/assets/css/ and returns
 * 404. It fails silently — the mark is simply absent.
 *
 * It rides on the child stylesheet rather than on wp_head, so it can never
 * print before the file it has to outrank. An earlier version hooked wp_head
 * at priority 5, which put it above the stylesheet at priority 8, and the
 * relative declaration won.
 *
 * Found by the Honour Her session, 21 August 2026, and measured here.
 */
function localilly_mark_url(): void {
	wp_add_inline_style(
		'localilly',
		sprintf(
			":root{--mark-image:url('%s');}",
			esc_url( get_stylesheet_directory_uri() . '/assets/img/localilly-plate.png' )
		)
	);
}
add_action( 'wp_enqueue_scripts', 'localilly_mark_url', 11 );

/**
 * The arrival line — the clock, and the weather in it.
 *
 * Deferred, and on the front page alone. It writes a line or it writes
 * nothing at all; the page never holds a space for it.
 */
function localilly_arrival(): void {
	if ( is_page_template( 'page-atelier.php' ) || is_page_template( 'page-build.php' ) || is_page_template( 'page-about-you.php' ) ) {
		wp_enqueue_script(
			'localilly-asit',
			get_stylesheet_directory_uri() . '/assets/js/asit.js',
			array( 'lamoureux-moments' ),
			lamoureux_asset_version( 'assets/js/asit.js', true ),
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'lamoureux-moments',
			get_stylesheet_directory_uri() . '/assets/js/moments.js',
			array(),
			lamoureux_asset_version( 'assets/js/moments.js', true ),
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);

		wp_enqueue_script(
			'localilly-atelier',
			get_stylesheet_directory_uri() . '/assets/js/atelier.js',
			array( 'lamoureux-moments' ),
			lamoureux_asset_version( 'assets/js/atelier.js', true ),
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);
	}

	wp_enqueue_script(
		'localilly-rail',
		get_stylesheet_directory_uri() . '/assets/js/rail.js',
		array(),
		lamoureux_asset_version( 'assets/js/rail.js', true ),
		array( 'in_footer' => false, 'strategy' => 'defer' )
	);

	wp_enqueue_script(
		'localilly-drift',
		get_stylesheet_directory_uri() . '/assets/js/drift.js',
		array(),
		lamoureux_asset_version( 'assets/js/drift.js', true ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);

	wp_enqueue_script(
		'localilly-arrival',
		get_stylesheet_directory_uri() . '/assets/js/arrival.js',
		array(),
		lamoureux_asset_version( 'assets/js/arrival.js', true ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'localilly_arrival', 12 );

/**
 * The mint on her own name, wherever she puts it.
 *
 * Her heading carries Lilly in mint. She can rewrite that whole line from the
 * Customizer, so the colour has to follow the word rather than sit in the
 * markup — otherwise changing her own heading would lose the one piece of her
 * palette that survived her redesign.
 *
 * @param string $line A line of hers.
 */
function localilly_lilly( string $line ): string {
	return (string) preg_replace(
		'/\b(Lilly|LocaLilly)\b/',
		'<span class="say">$1</span>',
		esc_html( $line ),
		1
	);
}

/**
 * The bar goes at the top of every page rather than only the front one.
 *
 * Her ruling: can we just have a burger menu everywhere.
 */
function localilly_bar(): void {
	get_template_part( 'header-bar' );
}
add_action( 'wp_body_open', 'localilly_bar', 5 );

/**
 * The arrival line and the burger belong on every page now, rather than only
 * where the weather used to be.
 */
function localilly_bar_scripts(): void {
	wp_enqueue_script(
		'localilly-bar',
		get_stylesheet_directory_uri() . '/assets/js/bar.js',
		array(),
		lamoureux_asset_version( 'assets/js/bar.js', true ),
		array( 'in_footer' => false, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'localilly_bar_scripts', 14 );

/**
 * Her emphasis, kept when her words travel through escaping.
 *
 * She writes weight into a sentence and it matters — the promise on the safety
 * page turns on **never asked for**. Escaping strips a tag; this survives it,
 * so she can lean on a phrase without knowing any markup.
 *
 * @param string $line Her line.
 * @return string Safe HTML.
 */
function localilly_strong( string $line ): string {
	$safe = esc_html( $line );

	return (string) preg_replace( '/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $safe );
}

/**
 * WordPress's emoji detector stops loading.
 *
 * Two reasons, and the second is the one that matters. It is a script and a
 * stylesheet on every page for a feature nothing here uses — **her joy law
 * says nothing adds to a person's load, and that reaches a phone on a slow
 * connection as much as it reaches a screen.**
 *
 * And it writes the word *everything* into the source of every page, which is
 * on her banned list — so every audit of her own words finds it and somebody
 * spends ten minutes proving it is not hers. That happened once already.
 */
function localilly_no_emoji_detector(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'localilly_no_emoji_detector' );

