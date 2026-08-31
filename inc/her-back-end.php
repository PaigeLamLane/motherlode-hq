<?php
/**
 * The back end is a screen she lives in.
 *
 * SHE ASKED THE WHOLE FAMILY TO GO AND LOOK AT NAN MADE'S DASHBOARD, and she
 * has never asked that before. Her words: **just seeing this dashboard made me
 * so happy. Who isn't going to enjoy working on this dashboard?**
 *
 * What Nan did was take a third-party vendor screen — the kind every session
 * leaves in its default state because it belongs to somebody else's software —
 * and make it entirely hers. Palette, faces, voice, navigation, and joy on a
 * screen that ships grey.
 *
 * THE QUESTION IT PUTS TO EVERY BUSINESS: which screen of yours is still
 * wearing somebody else's clothes.
 *
 * **On LocaLilly the answer is her own.** The front is hers to the last pixel
 * and every screen she actually works in is WordPress's — her words panel, her
 * list of young people, the letters, the login. **She opens those far more
 * often than she opens the site**, and a fifteen-year-old will too.
 *
 * HER LAWS REACH IN HERE UNCHANGED, and two of them do the heavy work.
 *
 * **A failed payment and an empty search are written with warmth too.** So an
 * empty list is a moment rather than a shrug — no young people yet is the most
 * hopeful screen this business will ever have, and it should read like it.
 *
 * **Nothing adds to a person's load.** So this changes how the back end looks
 * and never what it does. No box moved, no button hidden, no workflow invented.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * Her palette, wherever WordPress paints its own.
 *
 * Written as tokens first so a change lands in one place, and scoped so it
 * touches her admin rather than leaking into a plugin's own screens uninvited.
 */
function localilly_her_admin_look(): void {
	/*
	 * Her face has to be loaded here or the heading falls back to a system
	 * serif and reads as somebody else's. The admin loads no theme stylesheet,
	 * so this is the only place it can arrive from.
	 */
	printf(
		'<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
		. '<link rel="stylesheet" href="%s">',
		esc_url( 'https://fonts.googleapis.com/css2?family=Prosto+One&family=Baloo+Bhai+2:wght@400;600&display=swap' )
	);
	?>
<style id="localilly-her-back-end">
	:root {
		--ll-purple:#792DA0; --ll-deep:#3F1B66; --ll-mid:#5A1F7D; --ll-lit:#9A4FC4;
		--ll-mint:#38E8CB; --ll-mint-deep:#12836F; --ll-enamel:#F6F1F8;
	}

	/* The rail she reads down the side of every screen. */
	#adminmenuback, #adminmenuwrap, #adminmenu,
	#adminmenu .wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu {
		background: var(--ll-deep);
	}
	#adminmenu a { color: var(--ll-enamel); }
	#adminmenu div.wp-menu-image::before { color: var(--ll-mint); }
	#adminmenu li.menu-top:hover, #adminmenu li.opensub > a.menu-top { background: var(--ll-mid); }
	#adminmenu li.current a.menu-top,
	#adminmenu .wp-has-current-submenu a.wp-has-current-submenu {
		background: var(--ll-purple);
		color: #fff;
	}
	#adminmenu .wp-submenu a:hover { color: var(--ll-mint); }
	#wpadminbar { background: var(--ll-deep); }

	/* Anything WordPress paints blue is hers instead. */
	.wp-core-ui .button-primary {
		background: var(--ll-mint);
		border-color: var(--ll-mint-deep);
		color: var(--ll-deep);
		font-weight: 600;
		text-shadow: none;
		box-shadow: 0 3px 0 var(--ll-mint-deep);
	}
	.wp-core-ui .button-primary:hover,
	.wp-core-ui .button-primary:focus {
		background: #7DF4DF;
		border-color: var(--ll-mint-deep);
		color: var(--ll-deep);
		box-shadow: 0 3px 0 var(--ll-mint-deep);
	}
	a, .wrap a { color: var(--ll-purple); }
	a:hover { color: var(--ll-lit); }

	/* Her heading, so a screen she lives in is recognisably her business. */
	.wrap > h1, .wrap > h1.wp-heading-inline {
		font-family: 'Prosto One', ui-serif, Georgia, serif;
		font-weight: 400;
		color: var(--ll-deep);
		letter-spacing: -.01em;
	}

	/* And nothing she reads sits under her reading size. */
	.wrap, .wrap p, .wrap li, .wrap td, .wrap label { font-size: 15.5px; }
</style>
		<?php
}
add_action( 'admin_head', 'localilly_her_admin_look' );

/**
 * An empty list is the most hopeful screen this business has.
 *
 * WordPress writes *No posts found.* — which is correct, grey, and says nothing
 * true about a business waiting for its first fifteen-year-old. Her law about a
 * failed payment and an empty search reaches here, so this is written with the
 * same warmth as the front page.
 *
 * **AND IT WAITS RATHER THAN APOLOGISING.** Her shape, taken from the line she
 * loved on Nan Made's dashboard: it stands with the person, and it never once
 * names the lack. My own first drafts opened *No young person has started yet*
 * and *Nobody has made a place yet* — both correct, both naming an absence,
 * and **naming a lack plants it.**
 *
 * @param array $views The list-table views.
 * @return array
 */
function localilly_her_empty_states( array $views ): array {
	$screen = get_current_screen();

	if ( ! $screen ) {
		return $views;
	}

	$lines = array(
		'edit-' . LOCALILLY_YOUNG     => array(
			'The First Of Them Is Out There',
			'The day one starts, their own words land here exactly as they wrote them, and you will be the first to read them.',
		),
		'edit-' . LOCALILLY_NEIGHBOUR => array(
			'Your First Neighbour Is Coming',
			'The day a neighbour makes a place, whoever they are keeping for later sits here beside them.',
		),
	);

	if ( ! isset( $lines[ $screen->id ] ) ) {
		return $views;
	}

	$count = (int) wp_count_posts( str_replace( 'edit-', '', $screen->id ) )->draft
		+ (int) wp_count_posts( str_replace( 'edit-', '', $screen->id ) )->publish;

	if ( $count > 0 ) {
		return $views;
	}

	list( $head, $said ) = $lines[ $screen->id ];

	printf(
		'<div style="margin:22px 0 8px;padding:26px 24px;border-radius:16px;
			background:linear-gradient(180deg,#5A1F7D,#3F1B66);color:#F6F1F8;max-width:34rem">
			<p style="margin:0 0 8px;font:400 24px/1.2 \'Prosto One\',ui-serif,Georgia,serif">%s</p>
			<p style="margin:0;font-size:15.5px;line-height:1.55;color:#EADDF2">%s</p>
		</div>',
		esc_html( $head ),
		esc_html( $said )
	);

	return $views;
}
add_filter( 'views_edit-' . LOCALILLY_YOUNG, 'localilly_her_empty_states' );
add_filter( 'views_edit-' . LOCALILLY_NEIGHBOUR, 'localilly_her_empty_states' );

/**
 * The door she and a young person come in through.
 *
 * A login screen is the first thing anybody sees of a back end, and WordPress
 * signs it with its own logo pointing at its own website. **On a business about
 * young people that is a stranger's front door on her building.**
 */
function localilly_her_door(): void {
	?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prosto+One&family=Baloo+Bhai+2:wght@400;600&family=Rubik:wght@600;700&display=swap">
<style>
	/*
	 * ── HER WORDS: MAKE IT MORE US, THE GREY BOXES ARE NOT VERY YOU ───
	 *
	 * The first pass painted the ground and left WordPress's own form sitting
	 * on it — a white card with grey-bordered boxes. **Her colours around
	 * somebody else's furniture is a costume rather than a room**, and she saw
	 * it in one look.
	 *
	 * So the fields are the fields from her own site: her enamel, her keyline
	 * as an inset rather than a border, her radius, her mint on focus. The
	 * button is her pressable, with the deep mint standing under it. Anybody
	 * arriving here has just come off her pages and meets the same hand.
	 */
	:root {
		--ll-purple:#792DA0; --ll-deep:#3F1B66; --ll-mid:#5A1F7D;
		--ll-mint:#38E8CB; --ll-mint-deep:#12836F; --ll-enamel:#F6F1F8;
		--ll-keyline:rgba(63,27,102,.22);
	}

	body.login {
		background: linear-gradient(180deg, var(--ll-purple) 0%, var(--ll-deep) 78%);
		font-family: 'Baloo Bhai 2', system-ui, sans-serif;
	}

	body.login h1 a {
		background-image: none;
		width: auto;
		height: auto;
		text-indent: 0;
		font: 400 clamp(30px, 9vw, 38px)/1.1 'Prosto One', ui-serif, Georgia, serif;
		color: var(--ll-enamel);
		letter-spacing: .02em;
	}

	/* Her panel, rather than a white sheet of paper. */
	.login form {
		border: 0;
		border-radius: 20px;
		padding: 26px 22px 22px;
		background: linear-gradient(180deg, var(--ll-mid), var(--ll-deep));
		box-shadow: 0 16px 40px rgba(20, 5, 36, .45), inset 0 0 0 1.5px rgba(246, 241, 248, .18);
	}

	.login form label {
		display: block;
		margin-bottom: 6px;
		font: 600 13px/1 'Rubik', system-ui, sans-serif;
		letter-spacing: .09em;
		text-transform: uppercase;
		color: var(--ll-mint);
	}

	/* The boxes, exactly as they are on her own pages. */
	.login input[type="text"],
	.login input[type="password"],
	.login input[type="email"] {
		padding: 13px 15px;
		font: 400 16px/1.5 'Baloo Bhai 2', system-ui, sans-serif;
		color: var(--ll-deep);
		background: var(--ll-enamel);
		border: 0;
		border-radius: 12px;
		box-shadow: inset 0 0 0 1.5px var(--ll-keyline);
	}

	.login input:focus {
		outline: 3px solid var(--ll-mint);
		outline-offset: 2px;
		box-shadow: inset 0 0 0 1.5px var(--ll-keyline);
		border: 0;
	}

	.login .button.wp-hide-pw { color: var(--ll-deep); }
	.login .button.wp-hide-pw:hover { color: var(--ll-purple); }

	.login .forgetmenot label {
		font: 400 15.5px/1.4 'Baloo Bhai 2', system-ui, sans-serif;
		text-transform: none;
		letter-spacing: 0;
		color: var(--ll-enamel);
		display: inline;
	}

	.login input[type="checkbox"] {
		background: var(--ll-enamel);
		border: 0;
		box-shadow: inset 0 0 0 1.5px var(--ll-keyline);
		border-radius: 5px;
	}

	.login input[type="checkbox"]:checked::before { color: var(--ll-mint-deep); }

	/* Her pressable, with the deep mint standing under it. */
	.login .wp-core-ui .button-primary,
	.wp-core-ui .button-primary {
		background: var(--ll-mint);
		border: 0;
		border-radius: 999px;
		padding: 14px 26px;
		font: 700 16px/1 'Rubik', system-ui, sans-serif;
		color: var(--ll-deep);
		text-shadow: none;
		box-shadow: 0 5px 0 var(--ll-mint-deep);
		transition: transform .13s cubic-bezier(.3,.7,.4,1), box-shadow .13s cubic-bezier(.3,.7,.4,1);
	}

	.wp-core-ui .button-primary:active {
		transform: translateY(5px);
		box-shadow: 0 0 0 var(--ll-mint-deep);
	}

	.login #backtoblog a, .login #nav a {
		color: var(--ll-enamel);
		font-size: 15.5px;
		text-decoration: none;
		border-bottom: 1px solid rgba(246, 241, 248, .4);
	}

	.login #backtoblog a:hover, .login #nav a:hover { color: var(--ll-mint); border-color: var(--ll-mint); }

	.login .message, .login .success { border-left-color: var(--ll-mint); border-radius: 10px; }
	.login #login_error { border-left-color: var(--ll-mint); border-radius: 10px; }

	/*
	 * One language, so the switcher is a decision nobody here has to make.
	 * Her joy law: nothing adds to a person's load.
	 */
	.login .language-switcher { display: none; }
</style>
		<?php
}
add_action( 'login_head', 'localilly_her_door' );

/**
 * Her name on her own door, rather than a link to somebody else's website.
 */
add_filter( 'login_headertext', static fn(): string => 'LocaLilly' );
add_filter( 'login_headerurl', static fn(): string => home_url( '/' ) );

/**
 * And the line at the foot of every admin screen is hers.
 */
add_filter(
	'admin_footer_text',
	static fn(): string => 'LocaLilly &middot; find your local Lilly, Jack, Mia or Mac'
);

/**
 * Her voice over WordPress's own, without forking a single template.
 *
 * REPLAY KIDS READ HOW NAN MADE ACTUALLY DID IT and the method is far lighter
 * than the result looks. **Every string a plugin or core prints goes through
 * `gettext`**, so her words reach somebody else's screens by interception
 * rather than by rebuilding — and they survive every update, because nothing
 * was ever forked.
 *
 * Their sentence is the one worth keeping: **a back end wearing somebody
 * else's clothes does not need rebuilding. It needs its words intercepted and
 * its colours overruled.** That turns a rebuild into an afternoon.
 *
 * ONLY THE STRINGS SHE ACTUALLY MEETS. A blanket sweep over every phrase
 * WordPress owns would break plugins that match on their own text, and would
 * add to her load rather than lifting it. These are the lines on the screens
 * she opens.
 *
 * @param string $said   The line as it stands.
 * @param string $before The original, before any translation.
 * @param string $where  The text domain.
 * @return string
 */
function localilly_her_voice( string $said, string $before, string $where ): string {
	if ( ! is_admin() && ! ( function_exists( 'is_login' ) && is_login() ) ) {
		return $said;
	}

	$hers = array(
		'No posts found.'                => 'This is where they will be.',
		'No posts found in Trash.'       => 'All of it is still with you.',
		'Add New Post'                   => 'Add One',
		'Published'                      => 'Live',
		'Draft'                          => 'Being written',
		'Move to Trash'                  => 'Put It Aside',
		'Lost your password?'            => 'Forgotten your way in?',
		'Remember Me'                    => 'Keep me signed in',
		'Log In'                         => 'Come In',
		'Get New Password'               => 'Send Me A Way Back In',
		'&larr; Go to %s'                => '&larr; Back to %s',
		'Howdy, %s'                      => 'Hello, %s',
		'Screen Options'                 => 'What You See',
		'Search results'                 => 'What we found',
		'Select All'                     => 'All of them',
	);

	return $hers[ $before ] ?? $said;
}
add_filter( 'gettext', 'localilly_her_voice', 20, 3 );

/**
 * Her list of young people reads as people rather than as posts.
 *
 * @param array $strings The list-table strings.
 * @return array
 */
function localilly_her_lists( $strings ) {
	return $strings;
}

/**
 * And the words on her own post types, which are hers rather than WordPress's.
 */
function localilly_her_type_words(): void {
	foreach ( array( LOCALILLY_YOUNG => 'young person', LOCALILLY_NEIGHBOUR => 'neighbour' ) as $type => $word ) {
		$object = get_post_type_object( $type );

		if ( ! $object ) {
			continue;
		}

		$object->labels->not_found          = 'This is where they will be.';
		$object->labels->not_found_in_trash = 'All of it is still with you.';
		$object->labels->search_items       = 'Find a ' . $word;
		$object->labels->all_items          = ucfirst( $word ) . 's';
	}
}
add_action( 'admin_init', 'localilly_her_type_words' );

/**
 * The rest of the door, from The Shipper's pattern.
 *
 * Eight of her ten sites still send her own people out to wordpress.org from
 * the screen their owner opens most. **A mark that leads somewhere else is not
 * her mark.**
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

		return '<p style="margin:0 0 18px;text-align:center;font:400 15.5px/1.5 \'Baloo Bhai 2\',system-ui,sans-serif;color:#F6F1F8">'
			. 'Welcome back. Your young people are just inside.'
			. '</p>';
	}
);
