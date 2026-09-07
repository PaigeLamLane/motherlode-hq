<?php
/**
 * The back end is a screen she lives in.
 *
 * 2 September 2026 — real bug, found by actually logging in rather than
 * assuming the earlier "fixed" note meant this file was finished. It
 * changed the header link and the footer line and left everything
 * else — the login screen's entire palette, its fonts, and its
 * greeting — still LocaLilly's own: purple-and-mint, Prosto One and
 * Baloo Bhai 2, and "Welcome back. Your young people are just inside."
 * on a business with no young people in it at all. Her own words on
 * seeing it: "Can you change it?"
 *
 * Every colour and face below is now MotherLode's actual palette —
 * the same berry, plum, cream and ink, the same Fraunces and Rubik,
 * already live on the front of the site — rather than invented fresh.
 *
 * SEPARATE, WIDER FINDING, NOT FIXED HERE: this theme's clone from
 * LocaLilly also carried over two entire post types — "Young People"
 * and "Neighbours" — into MotherLode's own admin menu, real and
 * registered (confirmed live, not just named in a comment). They are
 * LocaLilly's actual business concept, not MotherLode's, and touching
 * them means checking every file that registers or reads them, not
 * just this one. Left alone on purpose rather than deleted unilaterally.
 *
 * HER LAWS REACH IN HERE UNCHANGED, and two of them do the heavy work.
 *
 * **A failed payment and an empty search are written with warmth too.**
 *
 * **Nothing adds to a person's load.** So this changes how the back end
 * looks and never what it does. No box moved, no button hidden, no
 * workflow invented.
 *
 * @package MotherLodeHQ
 */

defined( 'ABSPATH' ) || exit;

/**
 * Her palette, wherever WordPress paints its own.
 */
function motherlode_her_admin_look(): void {
	/*
	 * Her faces have to be loaded here or the heading falls back to a
	 * system serif and reads as somebody else's. The admin loads no
	 * theme stylesheet, so this is the only place it can arrive from.
	 */
	printf(
		'<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
		. '<link rel="stylesheet" href="%s">',
		esc_url( 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400..600&family=Rubik:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap' )
	);
	?>
<style id="motherlode-her-back-end">
	:root {
		--ml-plum:#7A0862; --ml-berry:#C5156A; --ml-ink:#3A1330;
		--ml-cream:#FBEFE9; --ml-enamel:#FFFFFF;
	}

	/* The rail she reads down the side of every screen. */
	#adminmenuback, #adminmenuwrap, #adminmenu,
	#adminmenu .wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu {
		background: var(--ml-ink);
	}
	#adminmenu a { color: var(--ml-cream); }
	#adminmenu div.wp-menu-image::before { color: var(--ml-berry); }
	#adminmenu li.menu-top:hover, #adminmenu li.opensub > a.menu-top { background: var(--ml-plum); }
	#adminmenu li.current a.menu-top,
	#adminmenu .wp-has-current-submenu a.wp-has-current-submenu {
		background: var(--ml-berry);
		color: #fff;
	}
	#adminmenu .wp-submenu a:hover { color: var(--ml-berry); }
	#wpadminbar { background: var(--ml-ink); }

	/* Anything WordPress paints blue is hers instead. */
	.wp-core-ui .button-primary {
		background: var(--ml-berry);
		border-color: var(--ml-plum);
		color: #fff;
		font-weight: 600;
		text-shadow: none;
		box-shadow: 0 3px 0 var(--ml-plum);
	}
	.wp-core-ui .button-primary:hover,
	.wp-core-ui .button-primary:focus {
		background: var(--ml-plum);
		border-color: var(--ml-plum);
		color: #fff;
		box-shadow: 0 3px 0 var(--ml-plum);
	}
	a, .wrap a { color: var(--ml-berry); }
	a:hover { color: var(--ml-plum); }

	/* Her heading, so a screen she lives in is recognisably her business. */
	.wrap > h1, .wrap > h1.wp-heading-inline {
		font-family: 'Fraunces', Georgia, serif;
		font-weight: 500;
		color: var(--ml-ink);
		letter-spacing: -.01em;
	}

	/* And nothing she reads sits under her reading size. */
	.wrap, .wrap p, .wrap li, .wrap td, .wrap label { font-size: 15.5px; }
</style>
		<?php
}
add_action( 'admin_head', 'motherlode_her_admin_look' );

/**
 * The door she and every professional come in through.
 *
 * A login screen is the first thing anybody sees of a back end, and
 * WordPress signs it with its own logo pointing at its own website.
 */
function motherlode_her_door(): void {
	?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400..600&family=Rubik:wght@400;500;600;700&display=swap">
<style>
	/*
	 * Her colours around somebody else's furniture is a costume rather
	 * than a room. The fields are the fields from her own site: cream,
	 * a keyline as an inset rather than a border, her radius, berry on
	 * focus. The button is her pressable, with plum standing under it.
	 * Anybody arriving here has just come off her pages and meets the
	 * same hand.
	 */
	:root {
		--ml-plum:#7A0862; --ml-berry:#C5156A; --ml-ink:#3A1330;
		--ml-cream:#FBEFE9; --ml-enamel:#FFFFFF;
		--ml-keyline:rgba(58,19,48,.16);
	}

	body.login {
		background: linear-gradient(180deg, var(--ml-plum) 0%, var(--ml-ink) 78%);
		font-family: 'Rubik', system-ui, sans-serif;
	}

	body.login h1 a {
		background-image: none;
		width: auto;
		height: auto;
		text-indent: 0;
		font: 500 clamp(28px, 8vw, 36px)/1.1 'Fraunces', Georgia, serif;
		color: #fff;
		letter-spacing: -.01em;
	}

	/* Her panel, rather than a white sheet of paper. */
	.login form {
		border: 0;
		border-radius: 20px;
		padding: 26px 22px 22px;
		background: linear-gradient(180deg, #fff, var(--ml-cream));
		box-shadow: 0 16px 40px rgba(58, 19, 48, .35);
	}

	.login form label {
		display: block;
		margin-bottom: 6px;
		font: 600 13px/1 'Rubik', system-ui, sans-serif;
		letter-spacing: .09em;
		text-transform: uppercase;
		color: var(--ml-berry);
	}

	/* The boxes, exactly as they are on her own pages. */
	.login input[type="text"],
	.login input[type="password"],
	.login input[type="email"] {
		padding: 13px 15px;
		font: 400 16px/1.5 'Rubik', system-ui, sans-serif;
		color: var(--ml-ink);
		background: var(--ml-enamel);
		border: 0;
		border-radius: 12px;
		box-shadow: inset 0 0 0 1.5px var(--ml-keyline);
	}

	.login input:focus {
		outline: 3px solid var(--ml-berry);
		outline-offset: 2px;
		box-shadow: inset 0 0 0 1.5px var(--ml-keyline);
		border: 0;
	}

	.login .button.wp-hide-pw { color: var(--ml-ink); }
	.login .button.wp-hide-pw:hover { color: var(--ml-berry); }

	.login .forgetmenot label {
		font: 400 15.5px/1.4 'Rubik', system-ui, sans-serif;
		text-transform: none;
		letter-spacing: 0;
		color: var(--ml-ink);
		display: inline;
	}

	.login input[type="checkbox"] {
		background: var(--ml-enamel);
		border: 0;
		box-shadow: inset 0 0 0 1.5px var(--ml-keyline);
		border-radius: 5px;
	}

	.login input[type="checkbox"]:checked::before { color: var(--ml-berry); }

	/* Her pressable, with plum standing under it. */
	.login .wp-core-ui .button-primary,
	.wp-core-ui .button-primary {
		background: var(--ml-berry);
		border: 0;
		border-radius: 999px;
		padding: 14px 26px;
		font: 600 16px/1 'Rubik', system-ui, sans-serif;
		color: #fff;
		text-shadow: none;
		box-shadow: 0 5px 0 var(--ml-plum);
		transition: transform .13s cubic-bezier(.3,.7,.4,1), box-shadow .13s cubic-bezier(.3,.7,.4,1);
	}

	.wp-core-ui .button-primary:active {
		transform: translateY(5px);
		box-shadow: 0 0 0 var(--ml-plum);
	}

	.login #backtoblog a, .login #nav a {
		color: #fff;
		font-size: 15.5px;
		text-decoration: none;
		border-bottom: 1px solid rgba(255, 255, 255, .4);
	}

	.login #backtoblog a:hover, .login #nav a:hover { color: var(--ml-cream); border-color: var(--ml-cream); }

	.login .message, .login .success { border-left-color: var(--ml-berry); border-radius: 10px; }
	.login #login_error { border-left-color: var(--ml-berry); border-radius: 10px; }

	/*
	 * One language, so the switcher is a decision nobody here has to
	 * make. Her joy law: nothing adds to a person's load.
	 */
	.login .language-switcher { display: none; }
</style>
		<?php
}
add_action( 'login_head', 'motherlode_her_door' );

/**
 * Her name on her own door, rather than a link to somebody else's website.
 */
add_filter( 'login_headertext', static fn(): string => 'MotherLode HQ' );
add_filter( 'login_headerurl', static fn(): string => home_url( '/' ) );

/**
 * And the line at the foot of every admin screen is hers.
 */
add_filter(
	'admin_footer_text',
	static fn(): string => 'MotherLode HQ &middot; You Should Never Have To Choose.'
);

/**
 * Her voice over WordPress's own, without forking a single template.
 *
 * Every string a plugin or core prints goes through `gettext`, so her
 * words reach somebody else's screens by interception rather than by
 * rebuilding — and they survive every update, because nothing was
 * ever forked.
 *
 * ONLY THE STRINGS SHE ACTUALLY MEETS. A blanket sweep over every
 * phrase WordPress owns would break plugins that match on their own
 * text, and would add to her load rather than lifting it.
 *
 * @param string $said   The line as it stands.
 * @param string $before The original, before any translation.
 * @param string $where  The text domain.
 * @return string
 */
function motherlode_her_voice( string $said, string $before, string $where ): string {
	if ( ! is_admin() && ! ( function_exists( 'is_login' ) && is_login() ) ) {
		return $said;
	}

	$hers = array(
		'No posts found.'          => 'This is where they will be.',
		'No posts found in Trash.' => 'All of it is still with you.',
		'Add New Post'             => 'Add One',
		'Published'                => 'Live',
		'Draft'                    => 'Being written',
		'Move to Trash'            => 'Put It Aside',
		'Lost your password?'     => 'Forgotten your way in?',
		'Remember Me'              => 'Keep me signed in',
		'Log In'                   => 'Come In',
		'Get New Password'         => 'Send Me A Way Back In',
		'&larr; Go to %s'         => '&larr; Back to %s',
		'Howdy, %s'                => 'Hello, %s',
		'Screen Options'           => 'What You See',
		'Search results'           => 'What we found',
		'Select All'               => 'All of them',
	);

	return $hers[ $before ] ?? $said;
}
add_filter( 'gettext', 'motherlode_her_voice', 20, 3 );

/**
 * The rest of the door, from The Shipper's pattern.
 */

/* The tab reads as hers rather than as somebody's installation. */
add_filter(
	'login_title',
	static fn( string $title ): string => str_replace( array( ' &#8212; WordPress', ' &lsaquo; ' ), array( '', ' · ' ), $title )
);

/* One language, so the switcher is a decision nobody here has to make. */
add_filter( 'login_display_language_dropdown', '__return_false' );

/**
 * A line in her register above the form, since a door may say hello.
 */
add_filter(
	'login_message',
	static function ( string $said ): string {
		if ( '' !== trim( $said ) ) {
			return $said;
		}

		return '<p style="margin:0 0 18px;text-align:center;font:400 15.5px/1.5 \'Rubik\',system-ui,sans-serif;color:#fff">'
			. 'Welcome back. Everything you\'re building is just inside.'
			. '</p>';
	}
);
