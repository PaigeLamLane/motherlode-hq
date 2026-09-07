<?php
/**
 * The door — where every path on the site leads before there is anybody to find.
 *
 * WHY IT EXISTS, AND IT CAME OUT OF WALKING THE SITE AS A PERSON.
 *
 * The eight category plates were never pressable and the search ran a plain
 * WordPress search over three posts. Every component existed and worked, and
 * nothing joined up — invisible to any list, obvious the moment somebody
 * pressed one. LOIS found the same shape on its own site and the method is its.
 *
 * WHAT HAPPENS ON SUNDAY, WHEN THERE IS NOBODY TO FIND YET.
 *
 * A search that worked would return an empty page. So every path leads here and
 * says so warmly — her own Empty Search That Answers, arriving at the front of
 * the site rather than at the end of it. It never says no results. It says what
 * is being looked for and offers the way in.
 *
 * AND NO CHILD LEAVES THEIR DETAILS.
 *
 * STRUCK 30 AUGUST. This read: the adult who pays opens the account and the young person
 * is invited into it. So a young person reads this and shows a parent, and the
 * parent leaves the details. **A minor's contact details are never collected**,
 * which costs nothing because it is what she already ruled.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Where a name is kept.
 *
 * A private post type rather than a plugin, so Sunday needs nothing that does
 * not exist. Never public, never in REST, never in a search, never an archive.
 */
function localilly_register_the_book(): void {
	register_post_type(
		'localilly_name',
		array(
			'labels'              => array(
				'name'          => __( 'Names Left', 'localilly' ),
				'singular_name' => __( 'Name Left', 'localilly' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'menu_icon'           => 'dashicons-book',
			'menu_position'       => 21,
			/*
			 * ── custom-fields RENDERED A PERSON IN A TABLE ────────────
			 *
			 * Her ruling, given to Love Always on 29 August: **we don't read
			 * people's private letters.** And the standard beneath it: while
			 * it is hers, nobody may read it.
			 *
			 * `custom-fields` puts every stored value on the edit screen in
			 * an editable plain-text table. On this record that is a young
			 * person's first name, family name, email, suburb, street and
			 * house number — **the full address held under a child-safety
			 * reason, sitting in a box anybody with the back office can read,
			 * change or empty.**
			 *
			 * Held for the one night it is needed is not the same as browsable
			 * on an ordinary afternoon.
			 *
			 * Nothing here was ever edited by hand, so nothing is lost. The
			 * title still names who left their details and when.
			 */
			'supports'            => array( 'title' ),
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'localilly_register_the_book' );

/**
 * Real bug, found on a self-audit, 3 September 2026: this returned
 * LocaLilly's own categories — Lawn Mowing, Babysitting, Car Washing —
 * on MotherLode's own live /join/ page, the one page in this whole
 * cluster of leftover LocaLilly templates that's actually published
 * and linked from the main nav. Anyone typing a real category into a
 * search here (Design, Finance, Admin) would never match, because
 * nothing on this list was ever MotherLode's. Replaced with the same
 * nine categories already live in the LODE mark's own constellation.
 * Kept the function's old name (still called from several other,
 * unpublished LocaLilly templates in this theme that nothing links to)
 * rather than rename it everywhere for a set of pages nobody can reach.
 *
 * @return array<string, string>
 */
function localilly_the_eight(): array {
	return array(
		'strategy'   => 'Strategy',
		'design'     => 'Design',
		'finance'    => 'Finance',
		'marketing'  => 'Marketing',
		'admin'      => 'Admin',
		'wellbeing'  => 'Wellbeing',
		'home'       => 'Home',
		'education'  => 'Education',
		'technology' => 'Technology',
	);
}

/**
 * Which of the eight somebody pressed, if any.
 */
function localilly_pressed(): string {
	$doing = isset( $_GET['doing'] ) ? sanitize_key( wp_unslash( $_GET['doing'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	return array_key_exists( $doing, localilly_the_eight() ) ? $doing : '';
}

/**
 * Take a name.
 *
 * Nonce on the form, everything escaped and sanitised, and the record is kept
 * where nothing public can reach it.
 */
function localilly_take_a_name(): void {
	if ( ! isset( $_POST['localilly_door'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_nonce'] ) ), 'localilly_door' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	$side   = 'young' === ( $_POST['side'] ?? '' ) ? 'young' : 'neighbour';
	$name   = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email  = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$suburb = sanitize_text_field( wp_unslash( $_POST['suburb'] ?? '' ) );
	$doing  = sanitize_key( wp_unslash( $_POST['doing'] ?? '' ) );

	/*
	 * ── HER RULING, 25 AUGUST: HOLD ALL OF IT, SHOW THE STREET ────────
	 *
	 * Her words: **in the backend, when setting up their account, we should
	 * have their address, because if something ever happens we need to know
	 * where to go. But on the front end, this needs to be made very clear.**
	 *
	 * This line used to strip the number off and throw it away, so a promise
	 * on the page could be kept by holding less. **Her reason outranks that
	 * one: a child in trouble is somebody you have to be able to reach.**
	 *
	 * So the whole address is kept, and the number is guarded rather than
	 * destroyed — held here, shown nowhere, and said plainly under the box
	 * at the moment it is typed.
	 *
	 * The same ruling on a name: her full name is held, and only her first
	 * name is ever shown.
	 */
	$street = sanitize_text_field( wp_unslash( $_POST['street'] ?? '' ) );
	$number = sanitize_text_field( wp_unslash( $_POST['number'] ?? '' ) );
	$last   = sanitize_text_field( wp_unslash( $_POST['last_name'] ?? '' ) );

	if ( '' === $name ) {
		localilly_say_back( 'begin' );
		return;
	}

	if ( ! is_email( $email ) ) {
		localilly_say_back( 'address' );
		return;
	}

	$id = wp_insert_post(
		array(
			'post_type'   => 'localilly_name',
			'post_status' => 'private',
			'post_title'  => $name . ' — ' . ( 'young' === $side ? 'for a young person' : 'a neighbour' ),
		)
	);

	if ( ! $id || is_wp_error( $id ) ) {
		localilly_say_back( 'held' );
		return;
	}

	update_post_meta( $id, '_ll_side', $side );
	update_post_meta( $id, '_ll_email', $email );
	update_post_meta( $id, '_ll_suburb', $suburb );
	update_post_meta( $id, '_ll_doing', $doing );

	if ( '' !== $street ) {
		update_post_meta( $id, '_ll_street', $street );
	}

	/* Held for her records, shown nowhere. Her ruling of 25 August. */
	if ( '' !== $number ) {
		update_post_meta( $id, '_ll_number', $number );
	}

	if ( '' !== $last ) {
		update_post_meta( $id, '_ll_last_name', $last );
	}

	wp_safe_redirect( add_query_arg( 'thankyou', '1', wp_get_referer() ?: home_url( '/join/' ) ) );
	exit;
}
add_action( 'template_redirect', 'localilly_take_a_name', 5 );
