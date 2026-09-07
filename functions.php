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
 *
 * REAL BUG, FOUND 6 September 2026, and a severe one: this theme was cloned
 * from LocaLilly's own, and the live host named here was never updated to
 * MotherLode HQ's — only 'localilly.com.au' was ever excluded, so this has
 * returned true (**"this is a build site"**) on every single MotherLode HQ
 * page load since the theme first went live. The direct, visible cost:
 * localilly_styles() below reads that flag and, on a "build site", inlines
 * a raw copy of assets/css/localilly.css straight into every page — a
 * physical file last touched 2 September, frozen ever since, silently
 * overriding every real style.css fix shipped after that date on every
 * real visitor's screen. Found chasing a colour fix that measured correct
 * in the deployed stylesheet and wrong on the live page — the inline
 * override, not the linked file, was what a visitor actually saw.
 */
function localilly_is_build_site(): bool {
	$host = strtolower( (string) ( $_SERVER['HTTP_HOST'] ?? '' ) );
	$host = preg_replace( '/:\d+$/', '', $host );

	return ! in_array(
		$host,
		array( 'localilly.com.au', 'www.localilly.com.au', 'motherlodehq.com.au', 'www.motherlodehq.com.au' ),
		true
	);
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
		'https://fonts.googleapis.com/css2?family=Baloo+Bhai+2:wght@400..800&family=Fraunces:opsz,wght@9..144,300..600&family=Prosto+One&family=Caveat:wght@400;600&family=Rubik:wght@300;400;500;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Italiana&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'localilly_fonts', 4 );

/**
 * The one real stylesheet.
 *
 * REAL BUG, FOUND AND REMOVED 6 September 2026. This used to also load a
 * second, separate stylesheet — assets/css/localilly.css, a "look" file
 * apparently meant to be a compiled twin of this one — either inlined
 * whole (on what localilly_is_build_site() judged a build site, which
 * was every MotherLode HQ page load until tonight's fix to that
 * function) or linked as a second file. Neither branch ever kept it in
 * sync with real edits to style.css: it sat frozen at 2 September while
 * style.css was corrected repeatedly afterwards, and — loading after
 * style.css, at equal specificity — its stale rules silently won on
 * every real visitor's screen. A colour fix could be verified correct in
 * the deployed style.css and still render wrong live, because the wrong
 * file was the one actually deciding it.
 *
 * Two sources of truth for the same look is what caused that, not either
 * file individually — so rather than keep the twin file in sync forever,
 * it's gone from the enqueue entirely. style.css is now the only place
 * MotherLode HQ's appearance is ever decided.
 */
function localilly_styles(): void {
	wp_enqueue_style(
		'localilly',
		get_stylesheet_uri(),
		array( 'lamoureux-base' ),
		lamoureux_asset_version( 'style.css', true )
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

/**
 * MotherLode HQ's own atelier — 2 September 2026.
 *
 * Her words: "mothers... being able to build their profiles." The theme's
 * own page-atelier.php is not this — read closely, it's LocaLilly's tool
 * for a client writing their first message to a teenager (fixed $25/hour,
 * school-hours scheduling, lawn-mowing categories). The real, current,
 * cross-business engine is the active lamoureux-atelier plugin (v0.3.4) —
 * LOIS's own build, generalised: one question a screen, no form, every
 * business writes its own questions. These are MotherLode's drafts —
 * her own words in the WP desk (Lamoureux_Atelier_Desk, for anyone
 * logged in as admin) always override these the moment she writes any.
 *
 * Embedded wherever `[atelier name="motherlode-profile"]` appears —
 * see page-for-talent.php's 'Build your profile' link.
 */
function motherlode_atelier_drafts( array $drafts, string $atelier ): array {
	if ( 'motherlode-profile' !== $atelier ) {
		return $drafts;
	}

	return array(
		'brilliant'  => array(
			'key'     => 'brilliant',
			'asks'    => "What are you brilliant at?",
			'because' => 'This is the one line a business or household searching for exactly you will read first.',
			'order'   => 10,
		),
		'rate'       => array(
			'key'     => 'rate',
			'asks'    => 'What do you charge?',
			'because' => "Read on your profile before the first message arrives, so nobody has to ask and nobody haggles.",
			'order'   => 20,
		),
		'hours'      => array(
			'key'     => 'hours',
			'asks'    => 'What hours are actually yours?',
			'because' => "The ones that fit around drop-off, nap time, school pick-up — whatever's real for you, not a nine-to-five you don't have.",
			'order'   => 30,
		),
		'where'      => array(
			'key'     => 'where',
			'asks'    => 'Where are you working from?',
			'because' => "Your suburb, or simply remote, if that's how you work.",
			'order'   => 40,
		),
		/*
		 * Real gap, found and closed: nothing in this engine captures who
		 * a new person actually is — 'whose' names somebody the business
		 * already knows. Without a name and an email there was no way to
		 * ever reach her again once she finished. Placed before the
		 * closing question, not after it, so 'struggling' stays the true
		 * last beat per the engine's own design law.
		 */
		'name'       => array(
			'key'     => 'name',
			'asks'    => "What's your name?",
			'because' => 'So the businesses reading your profile know who they\'re about to write to.',
			'order'   => 42,
		),
		'email'      => array(
			'key'     => 'email',
			'asks'    => "What's the best email for you?",
			'because' => "We'll send you a copy of everything you've told us, and this is how the right people reach you.",
			'order'   => 44,
		),
		'struggling' => array(
			'key'     => 'struggling',
			'asks'    => "What's the one thing making this feel hard to start?",
			'because' => 'Answer this one honestly. It usually turns out to be the exact thing that makes the right person recognise herself in you.',
			'order'   => 50,
			'the_one' => true,
		),
	);
}
add_filter( 'lamoureux_atelier_drafts', 'motherlode_atelier_drafts', 10, 2 );

/**
 * What happens when she finishes — 2 September 2026.
 *
 * Real gap closed, not the deeper one: this does not yet turn her
 * answers into a live, searchable Dokan vendor profile — building that
 * under real time pressure, without a chance to test it against a real
 * account, risks leaving broken or duplicate accounts behind, which is
 * worse than an honest gap. What this does do: send her a real,
 * immediate, branded confirmation carrying her own words back to her
 * exactly as she gave them (her truth law — never paraphrased), so
 * finishing the atelier feels like landing somewhere rather than
 * shouting into a form that goes nowhere.
 */
function motherlode_atelier_finished( string $atelier, array $said ): void {
	if ( 'motherlode-profile' !== $atelier ) {
		return;
	}

	$to = isset( $said['email'] ) ? sanitize_email( (string) $said['email'] ) : '';

	if ( ! is_email( $to ) || ! function_exists( 'lam_letter_send' ) ) {
		return;
	}

	$name = isset( $said['name'] ) ? sanitize_text_field( (string) $said['name'] ) : '';

	$letter  = $name ? sprintf( "Hello %s,\n\n", $name ) : "Hello,\n\n";
	$letter .= "Thank you for building your profile on MotherLode HQ. Here's exactly what you told us:\n\n";

	$labels = array(
		'brilliant'  => "What you're brilliant at",
		'rate'       => 'What you charge',
		'hours'      => 'Your hours',
		'where'      => 'Where you work from',
		'struggling' => "What's been hard to start",
	);

	foreach ( $labels as $key => $label ) {
		if ( ! empty( $said[ $key ] ) ) {
			$letter .= $label . ': ' . sanitize_textarea_field( (string) $said[ $key ] ) . "\n\n";
		}
	}

	$letter .= "We're setting up your profile now, and we'll write again the moment it's live and ready for people to find you.\n\nMotherLode HQ";

	lam_letter_send( $to, 'Your MotherLode HQ Profile', $letter );
}
add_action( 'lamoureux_atelier_finished', 'motherlode_atelier_finished', 10, 2 );

/**
 * "You can't call it a store. These are people; these are their
 * businesses." — 2 September 2026.
 *
 * Dokan and WooCommerce's own language throughout — frontend AND the
 * vendor dashboard, since gettext runs everywhere either plugin calls
 * __() or _e() — is marketplace vocabulary: Store, Vendor, Seller. Real
 * word-boundary matching so this can't mangle an unrelated word like
 * "restore" or "storefront" in passing.
 */
function motherlode_relabel_profiles_not_stores( string $translated, string $text, string $domain ): string {
	if ( ! in_array( $domain, array( 'dokan', 'dokan-lite', 'woocommerce' ), true ) ) {
		return $translated;
	}

	/*
	 * "No professional found!" — real bug, found on a self-audit, 3
	 * September 2026. Her own standing law: "a failed payment and an
	 * empty search are written with warmth too," and the shape of the
	 * fix is already proven elsewhere in this theme (her-back-end.php's
	 * own empty-state overrides) — an empty result waits with the
	 * person rather than apologising, and never once says the word
	 * found in the negative. Word-boundary substitution alone can't fix
	 * a whole sentence's tone, so this checks the exact string first,
	 * before the general word map below ever runs.
	 */
	$exact = array(
		'No vendor found!' => "Nobody's Live Here Yet. You'll Meet Them The Moment They Join.",
	);

	if ( isset( $exact[ $text ] ) ) {
		return $exact[ $text ];
	}

	$map = array(
		'/\bStore Listing\b/' => 'Find A Profile',
		'/\bStore List\b/'    => 'Find A Profile',
		'/\bStorefront\b/'    => 'Profile',
		'/\bStores\b/'        => 'Profiles',
		'/\bStore\b/'         => 'Profile',
		'/\bstorefront\b/'    => 'profile',
		'/\bstores\b/'        => 'profiles',
		'/\bstore\b/'         => 'profile',
		'/\bVendors\b/'       => 'Professionals',
		'/\bVendor\b/'        => 'Professional',
		'/\bvendors\b/'       => 'professionals',
		'/\bvendor\b/'        => 'professional',
		'/\bSellers\b/'       => 'Professionals',
		'/\bSeller\b/'        => 'Professional',
		'/\bsellers\b/'       => 'professionals',
		'/\bseller\b/'        => 'professional',
		/*
		 * "Shop Name," "Shop URL" — found on the registration form,
		 * 2 September 2026, after she called the customer-facing login
		 * page "absolutely fucking terrible" and it turned out to be
		 * more than a styling gap. Same reasoning as Store→Profile:
		 * scoped to dokan/dokan-lite/woocommerce only, so "shop" in an
		 * unrelated context elsewhere is never touched.
		 */
		'/\bShop Name\b/'     => 'Profile Name',
		'/\bShop URL\b/'      => 'Profile URL',
		'/\bShop Phone\b/'    => 'Profile Phone',
		'/\bShops\b/'         => 'Profiles',
		'/\bShop\b/'          => 'Profile',
		'/\bshops\b/'         => 'profiles',
		'/\bshop\b/'          => 'profile',
		/*
		 * Her words: "you should be able to change things on your end
		 * that won't change everything in the estate." This filter is
		 * MotherLode's own theme, not a shared plugin — the display word
		 * changes here, on this site alone; the wc-processing etc.
		 * status keys and the shop_order post type every gateway, report
		 * and plugin in the shared estate reads are completely
		 * untouched, on MotherLode or anywhere else.
		 *
		 * 2 September 2026 — "Job" was my first pass and she was right to
		 * stop it before it shipped further: it reads tradesperson (an
		 * odd job, a handyman's job), and half of what's on MotherLode's
		 * own category list — strategy, design, the law — doesn't sit
		 * naturally under that word. Her own call, direct: "Booking."
		 * It's already her word — "then book her directly" is in the
		 * site's own How It Works copy — and it reads as a person, not a
		 * task queue.
		 */
		/*
		 * Excludes "order to" / "order for" — plain English ("in order
		 * to continue…") turning up as "in booking to continue" would be
		 * a real, visible new fault traded for the one just fixed.
		 */
		'/\bOrders\b/'                      => 'Bookings',
		'/\bOrder\b(?!\s+(?:to|for)\b)/'    => 'Booking',
		'/\borders\b/'                      => 'bookings',
		'/\border\b(?!\s+(?:to|for)\b)/'    => 'booking',
	);

	$result = preg_replace( array_keys( $map ), array_values( $map ), $translated );

	return null === $result ? $translated : $result;
}
add_filter( 'gettext', 'motherlode_relabel_profiles_not_stores', 10, 3 );

/**
 * The plural form of the same fix — real bug, found by checking the
 * actual template rather than assuming the first filter caught
 * everything: "Total stores showing: %s" uses _n(), which fires
 * ngettext, a separate filter with its own five-argument signature.
 * gettext alone silently missed it.
 */
function motherlode_relabel_profiles_not_stores_plural( string $translated, string $single, string $plural, int $number, string $domain ): string {
	return motherlode_relabel_profiles_not_stores( $translated, $translated, $domain );
}
add_filter( 'ngettext', 'motherlode_relabel_profiles_not_stores_plural', 10, 5 );

/**
 * The context-aware form of the same fix — real gap, named by Nan Made
 * before it bit us: Dokan and WooCommerce use _x() in a lot of places,
 * which fires gettext_with_context, a fourth filter with a different
 * argument order again. Without this one, some screens keep the old
 * word no matter how the other two are set.
 */
function motherlode_relabel_profiles_not_stores_context( string $translated, string $text, string $context, string $domain ): string {
	return motherlode_relabel_profiles_not_stores( $translated, $text, $domain );
}
add_filter( 'gettext_with_context', 'motherlode_relabel_profiles_not_stores_context', 10, 4 );

/**
 * "Vendor" also lived in one place gettext can never reach: the seller
 * role's own display name is a database value, not translated text.
 * Fixed once, directly (see the git log — updated the wp_user_roles
 * option), not something to repeat on every load.
 *
 * She's not "orders" and "products," she's real people taking real
 * bookings — her words. Nan Made hit the identical mismatch first and
 * found the real fault wasn't the noun "Order" (a Nan already knows
 * what an order is — it's the word for somebody asking her to bake
 * something). It was the system-sounding status words underneath it:
 * nobody says "processing" about a cake, or about a booking. Same fix
 * here — the status labels only, not the noun, and not the status keys
 * underneath (wc-processing etc.) that every payment gateway and
 * report in the shared estate still reads.
 */
function motherlode_booking_statuses( array $statuses ): array {
	$map = array(
		'wc-pending'    => _x( 'Waiting To Begin', 'Order status', 'woocommerce' ),
		'wc-processing' => _x( 'Under Way', 'Order status', 'woocommerce' ),
		'wc-on-hold'    => _x( 'On Hold', 'Order status', 'woocommerce' ),
		'wc-completed'  => _x( 'Done, And Paid', 'Order status', 'woocommerce' ),
		'wc-cancelled'  => _x( 'Called Off', 'Order status', 'woocommerce' ),
		'wc-refunded'   => _x( 'Refunded', 'Order status', 'woocommerce' ),
		'wc-failed'     => _x( "Didn't Go Through", 'Order status', 'woocommerce' ),
	);

	foreach ( $map as $key => $label ) {
		if ( isset( $statuses[ $key ] ) ) {
			$statuses[ $key ] = $label;
		}
	}

	return $statuses;
}

/**
 * Real finding, from actually logging in and looking rather than
 * assuming the dashboard build was finished — 2 September 2026. Dokan's
 * newer Analytics report was switched on for this dashboard, and it
 * shows straight WooCommerce vocabulary that fits nobody here:
 * "Marketplace Commission," "Marketplace Discount," "Variations Sold,"
 * on a business with no products, no variations, and zero commission
 * on the work itself. Worse, its React app tried to mount on the plain
 * dashboard page (where it has no matching route) and printed a bare
 * "Not allowed — Sorry, you are not allowed to access this page." in
 * the middle of the screen a professional was meant to feel welcomed
 * by.
 *
 * This filter alone did NOT fix it. Dokan's own asset-registration
 * class (WeDevs\Dokan\Analytics\Assets::register_hooks()) reads
 * ReportUtil::is_analytics_enabled() while plugins are still loading —
 * before a theme's functions.php has run at all — so a filter added
 * here arrives too late for that one decision, even though it IS in
 * time for the widget choice made later, per request, in Dashboard's
 * own constructor (proven: the classic counters rendered correctly
 * underneath the broken React block). The real, reliable fix is the
 * option itself, set once at the database: `wp option update
 * woocommerce_analytics_enabled no`. Kept here anyway, harmless and
 * documents the intent for whoever reads this file next.
 */
add_filter( 'dokan_is_analytics_enabled', '__return_false' );

/**
 * MotherLode's own two answers to the shared Market engine — 2 September
 * 2026, settled directly with Aunt Tea after finding a real gap (see the
 * commit history and the cross-session record): Market::move_it() checks
 * 'lamoureux_billing_is_dokan' before deciding who actually pays the
 * professional.
 *
 * Her ruling, relayed through Aunt Tea: Market — not Dokan's own
 * stripe-express module — is the marketplace engine here. Dokan's module
 * stays switched off. So this site answers 'false' explicitly, rather
 * than leaving it to the filter's own default, so the next person reading
 * this never has to go and find that out again.
 */
add_filter( 'lamoureux_billing_is_dokan', '__return_false' );

/**
 * Zero commission on the work itself — ruled 30 August 2026. The $29 a
 * month platform fee is the only income from a professional; every dollar
 * a client pays for the work goes to her, in full, once Stripe's own fee
 * (which she carries, per Market's own rule) is taken out.
 */
add_filter( 'lamoureux_market_keeps', '__return_zero' );

/**
 * Parent Onboarding — the actual Stripe connection, the dashboard
 * banner, and the gate keeping an unconnected professional off a
 * business's search. See the file itself for what it does and does not
 * yet prove.
 */
require_once get_stylesheet_directory() . '/inc/her-own-account.php';
add_filter( 'wc_order_statuses', 'motherlode_booking_statuses' );

/**
 * Two ways a booking gets paid — held through MotherLode HQ, or arranged
 * directly between a professional and a client. See the file itself.
 */
require_once get_stylesheet_directory() . '/inc/how-she-gets-paid.php';

/**
 * Every discussion, in one place — the dashboard panel and the shared
 * lamoureux-messages plumbing underneath it. See the file itself.
 */
require_once get_stylesheet_directory() . '/inc/discussions.php';

