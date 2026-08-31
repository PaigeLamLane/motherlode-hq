<?php
/**
 * A neighbour has an account too, and a place to keep people.
 *
 * HER RULING, 23 AUGUST 2026: set up an account for the community people who
 * will employ or use our people, and let them favourite somebody and save them
 * for later. **Her own example is the whole design brief** — I'd really like
 * your help with my daughter's birthday, but that's not for six months.
 *
 * SO SAVING CARRIES A REASON AND A WHEN. A list of names is a bookmark. A
 * neighbour who wrote *Amelia's birthday, March* has left themselves a note
 * from six months ago that still makes sense when it surfaces — and a young
 * person eventually receives a first word that already knows what it is for.
 *
 * THE SAME SHAPE AS A YOUNG PERSON'S SIDE, ON PURPOSE. A key rather than a
 * password, kept in a cookie, and their place exists from the first moment.
 * Two roads that behave the same way are one road a person learns once.
 *
 * WHAT THIS DELIBERATELY DOES NOT DO. It takes no money and verifies nobody.
 * **Her dollar on a real card comes before a neighbour may search or message**,
 * and that is a payment road nobody has built yet. So a neighbour can keep
 * their own list and can reach nobody, and the screens say exactly that rather
 * than implying a door that is shut.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

const LOCALILLY_NEIGHBOUR = 'localilly_neighbour';
const LOCALILLY_THEIRJAR  = 'localilly_place';

/**
 * Where a neighbour's own place lives.
 */
function localilly_their_place_type(): void {
	register_post_type(
		LOCALILLY_NEIGHBOUR,
		array(
			'labels'              => array(
				'name'          => 'Neighbours',
				'singular_name' => 'Neighbour',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => array( 'title' ),
			'menu_icon'           => 'dashicons-admin-home',
		)
	);
}
add_action( 'init', 'localilly_their_place_type' );

/**
 * This neighbour, if the browser carries a key that matches one.
 *
 * @return WP_Post|null
 */
function localilly_their_place(): ?WP_Post {
	$key = isset( $_COOKIE[ LOCALILLY_THEIRJAR ] ) ? sanitize_key( wp_unslash( $_COOKIE[ LOCALILLY_THEIRJAR ] ) ) : '';

	if ( ! $key ) {
		return null;
	}

	$found = get_posts(
		array(
			'post_type'   => LOCALILLY_NEIGHBOUR,
			'post_status' => array( 'draft', 'publish' ),
			'numberposts' => 1,
			'meta_key'    => '_ll_key',
			'meta_value'  => $key,
		)
	);

	return $found ? $found[0] : null;
}

/**
 * Everyone they have kept, newest first.
 *
 * @param WP_Post|null $place Their place.
 * @return array<int, array{who:string, why:string, when:string, kept:string}>
 */
function localilly_kept_by( ?WP_Post $place ): array {
	if ( ! $place ) {
		return array();
	}

	$kept = (array) get_post_meta( $place->ID, '_ll_kept', true );

	return array_values( array_filter( $kept ) );
}

/**
 * Keep what a neighbour has just told us.
 */
function localilly_keep_their_place(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_place_moment'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_place'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_place'] ) ), 'localilly_place' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	$moment = sanitize_key( wp_unslash( $_POST['localilly_place_moment'] ) );
	$place  = localilly_their_place();

	if ( ! $place && 'begin' === $moment ) {
		$name   = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
		$suburb = sanitize_text_field( wp_unslash( $_POST['suburb'] ?? '' ) );

		if ( '' === $name || '' === $suburb ) {
			localilly_say_back( 'begin' );
			return;
		}

		$id = wp_insert_post(
			array(
				'post_type'   => LOCALILLY_NEIGHBOUR,
				'post_status' => 'draft',
				'post_title'  => $name . ' — ' . $suburb,
			),
			true
		);

		if ( is_wp_error( $id ) ) {
			localilly_say_back( 'held' );
			return;
		}

		$key = wp_generate_password( 24, false, false );
		update_post_meta( $id, '_ll_key', $key );
		update_post_meta( $id, '_ll_name', $name );
		update_post_meta( $id, '_ll_suburb', $suburb );
		update_post_meta( $id, '_ll_email', sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ) );

		setcookie( LOCALILLY_THEIRJAR, $key, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true );
		$_COOKIE[ LOCALILLY_THEIRJAR ] = $key;

		wp_safe_redirect( get_permalink() );
		exit;
	}

	if ( ! $place ) {
		localilly_say_back( 'away' );
		return;
	}

	/*
	 * Keeping somebody carries a reason and a when, since her own example is a
	 * birthday six months away. A bare list of names would be useless by then.
	 */
	if ( 'keep' === $moment ) {
		$kept = localilly_kept_by( $place );

		$kept[] = array(
			'who'  => sanitize_text_field( wp_unslash( $_POST['who'] ?? '' ) ),
			'why'  => sanitize_text_field( wp_unslash( $_POST['why'] ?? '' ) ),
			'when' => sanitize_text_field( wp_unslash( $_POST['when'] ?? '' ) ),
			'kept' => current_time( 'mysql' ),
		);

		update_post_meta( $place->ID, '_ll_kept', $kept );
	}

	if ( 'let-go' === $moment ) {
		$kept  = localilly_kept_by( $place );
		$which = absint( $_POST['which'] ?? -1 );

		if ( isset( $kept[ $which ] ) ) {
			unset( $kept[ $which ] );
			update_post_meta( $place->ID, '_ll_kept', array_values( $kept ) );
		}
	}

	wp_safe_redirect( get_permalink() );
	exit;
}
add_action( 'template_redirect', 'localilly_keep_their_place', 6 );
