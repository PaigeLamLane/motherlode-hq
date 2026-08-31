<?php
/**
 * A young person creates their own business, one moment at a time.
 *
 * HER CORRECTION: create your business, never build your page. A page is
 * something you own; **a business is something you run**, and the second is
 * what she has been building this whole company to hand a fifteen-year-old.
 *
 * ── THE BADGE, AND WHAT GOES UNDER IT ─────────────────────────────────
 *
 * Her ruling, 23 August 2026, and it is better than either option I offered
 * her: **their name is Loca and then their own** — LocaDan, LocaStella. The
 * brand becomes the person, exactly as it did when she named the atelier
 * LocaZac, and it was already on her own front page on a boy's shirt.
 *
 * And underneath it, **one line they write themselves** and never have to:
 * the dog whisperer, the Jill of all trades. Her words — they don't have to
 * use it, it's an option, but it would be good if they did.
 *
 * This came out of five rows rescued from the old database, where her July
 * self had labelled a field Your LocaLilly Name and typed Dan The Dog
 * Whisperer into it as the example. She had the idea a month before any of
 * this, and she improved on it when it came back to her.
 *
 * HER RULING, ASKED TWICE, AND SHE SHOULD HAVE HAD TO ASK ONCE. What existed
 * before this was a page telling a young person what LocaLilly is and a door
 * that took their name for a list. **A young person could read about it and
 * could never start.**
 *
 * THE ONE DECISION THAT SHAPES EVERYTHING HERE. Their page exists after the
 * first moment rather than after the last. A name and a suburb, and it is
 * already theirs — saved, keyed, and waiting whenever they come back. Every
 * moment after that adds to something real.
 *
 * **An all-or-nothing sign-up asks a fifteen-year-old to trust a form with
 * twelve questions before they have anything to show for it.** Saving as they
 * go means walking away costs them nothing and coming back costs them nothing.
 *
 * THE KEY RATHER THAN A PASSWORD. A young person is never asked to invent a
 * password on a phone at nine at night. A long random key is made for them,
 * held in a cookie so the road simply continues, and shown once so they can
 * keep it. Their grown-up gets it as well, which is the account arriving the
 * way she ruled it — an adult on it, without a fourteen-year-old managing
 * credentials.
 *
 * NOTHING IS PUBLIC UNTIL SHE OPENS IT. A record is a draft until an adult has
 * said yes and the young person has pressed to open it, and a draft answers a
 * stranger with a 404 — proved on the bench rather than assumed. It is absent
 * from WordPress's own search and from the REST API either way.
 *
 * **This paragraph read NOTHING HERE IS PUBLIC until 29 August**, and it had
 * been false since the morning of the 25th, when `publicly_queryable` was turned
 * on so a neighbour could reach a young person at all. The substance held the
 * whole time — only an opened business is reachable — **and the sentence above
 * it did not.**
 *
 * A law written in a comment is not a law the machine obeys, and a comment left
 * behind by a change is the same fault facing the other way: **it tells the next
 * reader the code does something it stopped doing.**
 *
 * BUILT BEHIND A SEAM ON PURPOSE. Aunt Tea's accounts and listings modules are
 * coming and this deliberately does not compete with them — every read goes
 * through localilly_their_page() and every write through localilly_keep(), so
 * the inside swaps and the screens above never change. Waiting for the module
 * would have cost her the weekend, and she has waited long enough.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

const LOCALILLY_YOUNG  = 'localilly_young';
const LOCALILLY_KEYJAR = 'localilly_key';

/**
 * Where a young person's page lives while they build it.
 */
function localilly_their_page_type(): void {
	register_post_type(
		LOCALILLY_YOUNG,
		array(
			'labels'              => array(
				'name'          => 'Young People',
				'singular_name' => 'Young Person',
			),
			/*
			 * ── IT OPENS ONLY ONCE THEY OPEN IT ───────────────────────
			 *
			 * `publicly_queryable` is what lets a neighbour reach a young
			 * person at all, and it was false — which is why no template
			 * anywhere could show one.
			 *
			 * **A record still only appears once it is published**, and
			 * publishing takes a grown-up's yes and the young person's own
			 * press. A draft answers a stranger with a 404, proved on the
			 * bench rather than assumed.
			 *
			 * `public` stays false and `exclude_from_search` stays true, so
			 * WordPress's own search never carries them and the archive
			 * never exists. **Finding somebody goes through her own search,
			 * which asks by suburb and by work rather than by name.**
			 */
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => array( 'slug' => 'young', 'with_front' => false ),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'supports'            => array( 'title' ),
			'menu_icon'           => 'dashicons-star-filled',
		)
	);
}
add_action( 'init', 'localilly_their_page_type' );

/**
 * The moments of the road, in order.
 *
 * Each one is answerable on its own and each one saves as it is taken. The
 * order is chosen so the easiest and warmest comes first — a name — and the
 * one needing a grown-up comes last, when there is already something to show
 * them.
 *
 * @return array<string, array{ask:string, why:string}>
 */
function localilly_the_moments(): array {
	/*
	 * ── HER WORDS, ON THE ROAD SHE MOST WANTS TO MOVE ─────────────────
	 *
	 * These were frozen in this file until 25 August 2026 — **the seven
	 * questions a fifteen-year-old actually walks were the one part of this
	 * world she could not change a word of.**
	 *
	 * Each now reads her panel with the sentence below as its floor, so a
	 * value she has never touched reads exactly as it always did.
	 */
	$moments = array(
		'name'  => 'name',
		'doing' => 'doing',
		'words' => 'words',
		'rates' => 'rates',
		'free'  => 'free',
		'shots' => 'shots',
		'grown' => 'grown',
	);

	$road = array();

	foreach ( $moments as $key ) {
		$road[ $key ] = array(
			'ask' => localilly_say( 'w_m_' . $key . '_ask' ),
			'why' => localilly_say( 'w_m_' . $key . '_why' ),
		);
	}

	return $road;
}


/**
 * The key a young person carries instead of a password.
 */
function localilly_make_key(): string {
	return wp_generate_password( 24, false, false );
}

/**
 * Their page, if this browser is carrying a key that matches one.
 *
 * @return WP_Post|null
 */
function localilly_their_page(): ?WP_Post {
	$key = isset( $_COOKIE[ LOCALILLY_KEYJAR ] ) ? sanitize_key( wp_unslash( $_COOKIE[ LOCALILLY_KEYJAR ] ) ) : '';

	if ( ! $key ) {
		return null;
	}

	$found = get_posts(
		array(
			'post_type'        => LOCALILLY_YOUNG,
			'post_status'      => array( 'draft', 'pending', 'publish' ),
			'numberposts'      => 1,
			'meta_key'         => '_ll_key',
			'meta_value'       => $key,
			'suppress_filters' => false,
		)
	);

	return $found ? $found[0] : null;
}

/**
 * Everything they have told us so far.
 *
 * @param WP_Post|null $page Their page.
 * @return array<string, mixed>
 */
function localilly_what_they_said( ?WP_Post $page ): array {
	if ( ! $page ) {
		return array();
	}

	return array(
		'name'   => (string) get_post_meta( $page->ID, '_ll_name', true ),
		'line'   => (string) get_post_meta( $page->ID, '_ll_line', true ),
		'suburb' => (string) get_post_meta( $page->ID, '_ll_suburb', true ),
		'street' => (string) get_post_meta( $page->ID, '_ll_street', true ),
		/* Held for her records, shown nowhere. Her ruling of 25 August. */
		'number'    => (string) get_post_meta( $page->ID, '_ll_number', true ),
		'last_name' => (string) get_post_meta( $page->ID, '_ll_last_name', true ),
		/*
		 * ── AN EMPTY VALUE CAST TO AN ARRAY IS NOT EMPTY ─────────────
		 *
		 * get_post_meta returns '' where nothing was ever stored, and (array)
		 * '' is array( '' ) — one element, so empty() says false and the
		 * moment reads as answered. **A young person was walked straight past
		 * deciding what to charge**, which is the single most important moment
		 * on the road and the one her whole autonomy law rests on.
		 *
		 * It reported success the entire way. Six redirects, every one a 302,
		 * and the record looked healthy — with pricing never asked.
		 */
		'doing'  => array_filter( (array) ( get_post_meta( $page->ID, '_ll_doing', true ) ?: array() ) ),
		'words'  => (string) get_post_meta( $page->ID, '_ll_words', true ),
		'rates'  => array_filter( (array) ( get_post_meta( $page->ID, '_ll_rates', true ) ?: array() ) ),
		'free'   => (string) get_post_meta( $page->ID, '_ll_free', true ),
		'shots'  => array_values( array_filter( (array) ( get_post_meta( $page->ID, '_ll_shots', true ) ?: array() ) ) ),
		/*
		 * Whether they have walked past the pictures, carried here rather than
		 * read from the post — **localilly_moments_done() only ever receives
		 * what they said**, and reaching for $page inside it was a variable
		 * that had never been passed. It warned, it read as false, and the
		 * road stopped at the pictures for ever.
		 */
		'shots_seen' => (bool) get_post_meta( $page->ID, '_ll_shots_seen', true ),
		'grown'  => (string) get_post_meta( $page->ID, '_ll_grown', true ),
		'born'   => (string) get_post_meta( $page->ID, '_ll_born', true ),
		'grownm' => (string) get_post_meta( $page->ID, '_ll_grown_email', true ),
	);
}

/**
 * Which moments are behind them.
 *
 * @param array $said What they have said.
 * @return array<string, bool>
 */
function localilly_moments_done( array $said ): array {
	return array(
		'name'  => ! empty( $said['name'] ) && ! empty( $said['suburb'] ),
		'doing' => ! empty( $said['doing'] ),
		'words' => ! empty( $said['words'] ),
		'rates' => ! empty( $said['rates'] ),
		'free'  => ! empty( $said['free'] ),
		/*
		 * Pictures are hers to skip. A moment nobody has to answer still needs
		 * to be answerable, so it counts as done once they have walked past it
		 * — the visit is recorded rather than the pictures required.
		 */
		'shots' => ! empty( $said['shots'] ) || ! empty( $said['shots_seen'] ),
		'grown' => ! empty( $said['grown'] ) && ! empty( $said['grownm'] ) && ! empty( $said['born'] ),
	);
}

/**
 * The next moment waiting for them.
 *
 * @param array $said What they have said.
 * @return string
 */
function localilly_next_moment( array $said ): string {
	foreach ( localilly_moments_done( $said ) as $step => $done ) {
		if ( ! $done ) {
			return $step;
		}
	}

	return 'ready';
}

/**
 * Keep what they have just told us.
 *
 * One moment at a time, saved the instant it is given. A young person who
 * closes the tab here has lost none of it.
 */
function localilly_keep(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_moment'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_keep'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_keep'] ) ), 'localilly_build' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	$moment = sanitize_key( wp_unslash( $_POST['localilly_moment'] ) );
	$page   = localilly_their_page();

	/* The first moment brings the page into being. */
	if ( ! $page && 'name' === $moment ) {
		$name   = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
		$suburb = sanitize_text_field( wp_unslash( $_POST['suburb'] ?? '' ) );

		if ( '' === $name || '' === $suburb ) {
			localilly_say_back( 'begin' );
			return;
		}

		$id = wp_insert_post(
			array(
				'post_type'   => LOCALILLY_YOUNG,
				'post_status' => 'draft',
				'post_title'  => $name . ' — ' . $suburb,
			),
			true
		);

		if ( is_wp_error( $id ) ) {
			localilly_say_back( 'held' );
			return;
		}

		$key = localilly_make_key();
		update_post_meta( $id, '_ll_key', $key );
		update_post_meta( $id, '_ll_name', $name );
		update_post_meta( $id, '_ll_suburb', $suburb );
		update_post_meta( $id, '_ll_line', sanitize_text_field( wp_unslash( $_POST['line'] ?? '' ) ) );

		/* A year, so a young person who comes back next month simply carries on. */
		setcookie( LOCALILLY_KEYJAR, $key, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true );
		$_COOKIE[ LOCALILLY_KEYJAR ] = $key;

		wp_safe_redirect( add_query_arg( 'moment', 'doing', get_permalink() ) );
		exit;
	}

	if ( ! $page ) {
		localilly_say_back( 'away' );
		return;
	}

	switch ( $moment ) {
		case 'name':
			update_post_meta( $page->ID, '_ll_name', sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ) );
			update_post_meta( $page->ID, '_ll_suburb', sanitize_text_field( wp_unslash( $_POST['suburb'] ?? '' ) ) );
			update_post_meta( $page->ID, '_ll_line', localilly_safe_but_untidied( (string) wp_unslash( $_POST['line'] ?? '' ) ) );
			break;

		case 'doing':
			$doing = array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['doing'] ?? array() ) );
			update_post_meta( $page->ID, '_ll_doing', array_values( array_filter( $doing ) ) );
			break;

		case 'words':
			/*
			 * **Their own words, made safe without being tidied.**
			 * sanitize_textarea_field trims, and a young person who began a
			 * line with a space meant it. See localilly_safe_but_untidied().
			 */
			update_post_meta( $page->ID, '_ll_words', localilly_safe_but_untidied( (string) wp_unslash( $_POST['words'] ?? '' ) ) );
			break;

		case 'rates':
			$kept = array();
			$what = (array) wp_unslash( $_POST['rate_what'] ?? array() );
			$kind = (array) wp_unslash( $_POST['rate_kind'] ?? array() );
			$much = (array) wp_unslash( $_POST['rate_much'] ?? array() );

			foreach ( $what as $i => $label ) {
				$label = sanitize_text_field( $label );
				if ( '' === $label ) {
					continue;
				}

				$this_kind = sanitize_key( $kind[ $i ] ?? LOCALILLY_ASKED );
				$kept[]    = array(
					'what'   => $label,
					'kind'   => in_array( $this_kind, array( LOCALILLY_ASKED, LOCALILLY_QUOTE, LOCALILLY_GIFT ), true ) ? $this_kind : LOCALILLY_ASKED,
					'amount' => LOCALILLY_ASKED === $this_kind ? absint( $much[ $i ] ?? 0 ) : null,
				);
			}

			update_post_meta( $page->ID, '_ll_rates', $kept );
			break;

		case 'shots':
			/*
			 * ── TEN PICTURES, AND A REAL LIMIT ON EACH ────────────────
			 *
			 * Her ruling: up to ten images per profile, and **make sure there
			 * is a size limit on them.** Both halves matter — ten photographs
			 * off a modern phone is forty megabytes, which is a young person's
			 * data and a neighbour's patience.
			 *
			 * Every picture is already redrawn in their own browser before it
			 * travels. **This is the floor under that**, because a browser
			 * that fails, or somebody posting directly, must meet a limit that
			 * does not depend on the page behaving.
			 *
			 * AND THEY ARE PICTURES OF THE WORK RATHER THAN OF THE PERSON.
			 * Her settled ruling is a nameplate rather than a face, so a lawn,
			 * a car, a sorted shed. Said plainly on the screen so nobody has
			 * to infer it.
			 */
			update_post_meta( $page->ID, '_ll_shots_seen', 1 );

			$sent  = (array) wp_unslash( $_POST['shots'] ?? array() );
			$kept  = array();
			$limit = 400 * 1024;

			foreach ( array_slice( $sent, 0, 10 ) as $one ) {
				$one = (string) $one;

				if ( 0 !== strpos( $one, 'data:image/jpeg;base64,' ) ) {
					continue;
				}

				/* Base64 is four characters for every three bytes. */
				if ( ( strlen( $one ) * 3 / 4 ) > $limit ) {
					continue;
				}

				$kept[] = $one;
			}

			update_post_meta( $page->ID, '_ll_shots', $kept );
			break;

		case 'free':
			update_post_meta( $page->ID, '_ll_free', sanitize_text_field( wp_unslash( $_POST['free'] ?? '' ) ) );
			break;

		case 'grown':
			update_post_meta( $page->ID, '_ll_grown', sanitize_text_field( wp_unslash( $_POST['grown'] ?? '' ) ) );
			update_post_meta( $page->ID, '_ll_grown_email', sanitize_email( wp_unslash( $_POST['grown_email'] ?? '' ) ) );
			update_post_meta( $page->ID, '_ll_street', sanitize_text_field( wp_unslash( $_POST['street'] ?? '' ) ) );

			/*
			 * The whole address, and the family name, held for her records and
			 * shown nowhere. Her ruling of 25 August: **if something ever
			 * happens we need to know where to go.**
			 *
			 * Asked in the grown-up's moment rather than of a young person, the
			 * same way the birthday is, and said plainly under each box.
			 */
			update_post_meta( $page->ID, '_ll_number', sanitize_text_field( wp_unslash( $_POST['number'] ?? '' ) ) );
			update_post_meta( $page->ID, '_ll_last_name', sanitize_text_field( wp_unslash( $_POST['last_name'] ?? '' ) ) );

			/*
			 * Her ruling: a person under eighteen never proves their own age.
			 * An adult attests by enrolling them, and that adult is the one
			 * verified — so the date is asked here, in the grown-up's moment,
			 * rather than of a young person about themselves.
			 *
			 * And the crossover at eighteen runs entirely on this one field.
			 */
			$born = sanitize_text_field( wp_unslash( $_POST['born'] ?? '' ) );

			if ( '' !== $born && preg_match( '/^\d{4}-\d{2}-\d{2}$/', $born ) ) {
				update_post_meta( $page->ID, '_ll_born', $born );
			}

			if ( function_exists( 'localilly_their_own_id' ) ) {
				localilly_their_own_id( $page->ID );
			}
			break;
	}

	$said = localilly_what_they_said( get_post( $page->ID ) );
	$next = localilly_next_moment( $said );

	/*
	 * ── NO LETTER GOES TO A GROWN-UP, AND THAT IS HERS ────────────────
	 *
	 * She asked *need a letter to his grown-up, does he?* and I read a question
	 * as agreement and built one. She has since said plainly that a parent does
	 * not need a letter. **A question is not a ruling**, and treating one as a
	 * ruling is how a session builds something nobody asked for.
	 *
	 * What she did rule, on a card, stands untouched: a first word reaches the
	 * young person alone, and they answer for themselves. **The weekly note is
	 * struck** — she has ruled against it more than once. A parent sees what
	 * their young person chooses to show them, which is her whole philosophy:
	 * the person running it decides who reads it.
	 *
	 * The welcome itself stays written, behind a filter that is off. Turning it
	 * on is one line the day she wants it, and nothing sends meanwhile.
	 */
	/*
	 * The road is walked, a grown-up is holding them, and now they become a
	 * person in the family's accounts rather than a row on this site alone.
	 * Nothing here is moved or deleted — the road's record stays exactly where
	 * it is, because a migration that empties the old place before the new one
	 * is proven is how somebody's first business disappears.
	 */
	if ( 'ready' === $next && function_exists( 'localilly_into_accounts' ) ) {
		localilly_into_accounts( $page->ID );
	}

	wp_safe_redirect( add_query_arg( 'moment', $next, get_permalink() ) );
	exit;
}
add_action( 'template_redirect', 'localilly_keep', 5 );

/**
 * The eight, as a young person chooses among them.
 *
 * @return string[]
 */
function localilly_rate_shapes(): array {
	return array(
		LOCALILLY_ASKED => 'I charge',
		LOCALILLY_QUOTE => 'Let us look together',
		LOCALILLY_GIFT  => 'This one is a gift',
	);
}
