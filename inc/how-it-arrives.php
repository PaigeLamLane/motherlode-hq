<?php
/**
 * How a link to this site arrives in somebody's hands.
 *
 * MEASURED TONIGHT AND IT WAS NOTHING AT ALL. A link to localilly.com.au sent
 * to anybody showed a blank rectangle — no image, no description, and a title
 * WordPress had assembled. Eight of her thirteen live sites were the same. Her
 * own word for meeting it was disgraceful, and she is right: **a link is the
 * first thing most people ever see of a business, and it was the one screen
 * nobody had ever looked at.**
 *
 * FOUR RULES, ALL HERS, GATHERED TONIGHT.
 *
 * Her real logo, rather than a recoloured or shrunk version of it. The card
 * below carries the plate exactly as it sits on her site.
 *
 * Her own ground rather than white. She has said it three times in a day.
 *
 * A big mark and few words, since it is met as a thumbnail beside twenty other
 * links, so nothing fine survives.
 *
 * And never a stock icon standing in. A missing card is honest; a borrowed one
 * is a small lie about who made this.
 *
 * ONE-TWO-HUNDRED BY SIX-THIRTY, WHICH IS THE SIZE A SHARED LINK ACTUALLY
 * DISPLAYS. Nan Made's card has been portrait for months and cropped in half
 * everywhere it has ever been shared, and nobody knew until somebody measured
 * it rather than looking at it.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * Which card this site sends.
 *
 * Two were built for her and she chooses. Filterable so the choice is one line
 * rather than an edit here.
 *
 * @return string
 */
function localilly_the_card(): string {
	/*
	 * ── THE FILENAME CARRIES THE CONTENTS, AND IT HAS TO ─────────────
	 *
	 * She asked for the fine type off the card. The new card reached the
	 * server correctly — same checksum as the file on the Mac — and **the CDN
	 * went on serving the old one to the outside world.** Her own law, proven
	 * again: a cache reports a file present long after it changed, and on this
	 * host a query string buys nothing at all on an asset.
	 *
	 * A version in the query is a request the CDN is free to ignore. **A
	 * version in the filename is a different file, and nothing can ignore
	 * that.** So the card is named by a hash of its own contents, and any edit
	 * to it produces a name no cache has ever held.
	 *
	 * Found only because the served bytes were compared against the built
	 * ones. A 200 and the right dimensions were both true while the wrong
	 * picture was being served.
	 */
	$found = glob( get_stylesheet_directory() . '/assets/img/share-one.*.jpg' );
	$file  = $found ? basename( $found[0] ) : 'share-one.jpg';

	/**
	 * Filters the share card file name.
	 *
	 * @param string $file File within assets/img.
	 */
	$file = (string) apply_filters( 'localilly_share_card', $file );

	return get_stylesheet_directory_uri() . '/assets/img/' . $file;
}

/**
 * The line a search result reads, and the words a shared link carries.
 *
 * Her standard, in her words: if people find us in a search, make sure whatever
 * they read makes them want to be part of what we're doing. So this is an
 * invitation rather than a summary.
 *
 * **Drafted by this session rather than written by her**, and marked as such
 * until she has been through it.
 *
 * @return string
 */
function localilly_the_line(): string {
	if ( is_page() ) {
		$page = get_queried_object();

		$lines = array(
			'for-a-young-person' => 'You are fifteen to eighteen and your street already needs what you can do. Set your own price, keep every dollar, and build a reputation a few doors from your own front gate.',
			'layers-of-safety'   => 'Why this site is built the way it is. Eight layers, each one written out plainly, and an honest account of what we ask of you as well.',
			'join'               => 'Put your name down, whether you are fifteen and ready to work or a neighbour who needs a hand. It takes a minute.',
		);

		if ( isset( $lines[ $page->post_name ] ) ) {
			return $lines[ $page->post_name ];
		}
	}

	return (string) apply_filters(
		'localilly_share_line',
		'A concentrated resource of expertise, experience and possibility — made visible for the people and businesses ready to use it.'
	);
}

/**
 * And put it in the head, where every reader of a link looks.
 *
 * Written by hand rather than left to a plugin, since the site now carries only
 * her own code and the shared parent.
 */
function localilly_how_it_arrives(): void {
	$card  = localilly_the_card();
	$line  = localilly_the_line();
	$title = is_front_page()
		? 'MotherLode HQ — The Untapped Lode'
		: wp_get_document_title();

	printf(
		'<meta name="description" content="%s">' . "\n"
		. '<meta property="og:type" content="website">' . "\n"
		. '<meta property="og:site_name" content="MotherLode HQ">' . "\n"
		. '<meta property="og:title" content="%s">' . "\n"
		. '<meta property="og:description" content="%s">' . "\n"
		. '<meta property="og:url" content="%s">' . "\n"
		. '<meta property="og:image" content="%s">' . "\n"
		. '<meta property="og:image:width" content="1200">' . "\n"
		. '<meta property="og:image:height" content="630">' . "\n"
		. '<meta property="og:image:alt" content="%s">' . "\n"
		. '<meta name="twitter:card" content="summary_large_image">' . "\n"
		. '<meta name="twitter:title" content="%s">' . "\n"
		. '<meta name="twitter:description" content="%s">' . "\n"
		. '<meta name="twitter:image" content="%s">' . "\n",
		esc_attr( $line ),
		esc_attr( $title ),
		esc_attr( $line ),
		/*
		 * The canonical address, never the one in the address bar. My first
		 * version used add_query_arg( array() ), which carries whatever query
		 * string the visitor arrived with — so my own cache-buster ended up
		 * published as the canonical URL of her front page. **Anything that
		 * reflects the request back into the head will eventually publish
		 * somebody's tracking parameters as the address of the site.**
		 */
		esc_url( is_front_page() ? home_url( '/' ) : get_permalink() ),
		esc_url( $card ),
		esc_attr( 'The LocaLilly nameplate over a young person walking a dog down a front path' ),
		esc_attr( $title ),
		esc_attr( $line ),
		esc_url( $card )
	);
}
add_action( 'wp_head', 'localilly_how_it_arrives', 4 );

/**
 * The icon somebody keeps on their home screen.
 *
 * MEASURED BY EAGLE EYE AND IT IS A REAL FAULT. The icon WordPress was handing
 * out is transparent, and **iOS paints black behind a transparent icon** — so
 * anybody adding LocaLilly to their home screen got her mark on a black square.
 * Black belongs to nobody's brand and least of all to hers.
 *
 * So the mark is flattened onto her own purple, opaque, at the three sizes a
 * phone actually asks for. Her ruling about never putting her mark on white
 * has the same root: **a mark with no ground of its own inherits whatever the
 * device decides**, and the device decides badly.
 *
 * The links are printed at priority 3 so they stand above WordPress's own, and
 * WordPress's transparent set is removed rather than left to compete.
 */
function localilly_home_screen(): void {
	$img = get_stylesheet_directory_uri() . '/assets/img/';

	printf(
		'<link rel="apple-touch-icon" sizes="180x180" href="%1$stouch-180.png">' . "\n"
		. '<link rel="icon" type="image/png" sizes="192x192" href="%1$sicon-192.png">' . "\n"
		. '<link rel="icon" type="image/png" sizes="512x512" href="%1$sicon-512.png">' . "\n"
		. '<link rel="manifest" href="%2$s">' . "\n"
		. '<meta name="theme-color" content="#E85387">' . "\n"
		. '<meta name="apple-mobile-web-app-title" content="MotherLode HQ">' . "\n",
		esc_url( $img ),
		esc_url( home_url( '/motherlodehq.webmanifest' ) )
	);
}
add_action( 'wp_head', 'localilly_home_screen', 3 );

/**
 * WordPress's own transparent set stands down.
 */
remove_action( 'wp_head', 'wp_site_icon', 99 );

/*
 * ── THE MANIFEST, SERVED WITHOUT A REWRITE RULE ───────────────────────
 *
 * The first version added a rewrite rule and answered on template_redirect. It
 * returned a 404 page with a 404 status, and **the link in the head pointed
 * confidently at it the whole time** — which is the same shape as everything
 * else found today: a mechanism reporting success while doing nothing.
 *
 * A rewrite rule depends on the rules being flushed after the rule is
 * registered, on nothing else claiming the path, and on the request reaching
 * WordPress's routing at all. Three things that can each be true and still
 * leave a 404.
 *
 * Reading the path on `init` depends on none of them. Fewer moving parts is
 * the fix rather than a better rule.
 */
function localilly_manifest(): void {
	$path = wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH );

	if ( '/motherlodehq.webmanifest' !== untrailingslashit( (string) $path ) ) {
		return;
	}

	$img = get_stylesheet_directory_uri() . '/assets/img/';

	header( 'Content-Type: application/manifest+json; charset=utf-8' );
	header( 'Cache-Control: public, max-age=3600' );

	echo wp_json_encode(
		array(
			'name'             => 'MotherLode HQ',
			'short_name'       => 'MotherLode',
			'description'      => localilly_the_line(),
			'start_url'        => home_url( '/' ),
			'scope'            => home_url( '/' ),
			'display'          => 'standalone',
			'background_color' => '#E85387',
			'theme_color'      => '#E85387',
			'icons'            => array(
				array(
					'src'     => $img . 'icon-192.png',
					'sizes'   => '192x192',
					'type'    => 'image/png',
					'purpose' => 'any',
				),
				array(
					'src'     => $img . 'icon-512.png',
					'sizes'   => '512x512',
					'type'    => 'image/png',
					'purpose' => 'any',
				),
			),
		),
		JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
	);
	exit;
}
add_action( 'init', 'localilly_manifest', 1 );
