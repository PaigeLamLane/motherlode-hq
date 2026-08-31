<?php
/**
 * LocaLilly answers the family's door about who is standing here.
 *
 * **The engine never guesses who somebody is.** It asks, and a world that has
 * not answered gets no face at all — which is the right way for it to fail,
 * because a door that guesses is worse than a door that stays shut.
 *
 * Both sides answer through the same road. A neighbour and a young person are
 * different people to this site and the same kind of person to the family's
 * accounts: somebody who is already in, and may open it with their face next
 * time.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Who LocaLilly says is standing here.
 *
 * @param string $who Whatever another world answered.
 * @return string Their owner key.
 */
function localilly_who_is_standing_here( string $who ): string {
	$page = function_exists( 'localilly_their_page' ) ? localilly_their_page() : null;

	if ( $page ) {
		$key = (string) get_post_meta( $page->ID, '_ll_key', true );

		if ( '' !== $key ) {
			return 'young:' . $key;
		}
	}

	$mine = localilly_who_is_writing();

	return '' !== $mine ? $mine : $who;
}
add_filter( 'lamoureux_accounts_who_is_here', 'localilly_who_is_standing_here' );

/**
 * What to call them, so the phone shows their own name rather than a key.
 *
 * @param string $called Whatever another world answered.
 * @param string $who    Their owner key.
 */
function localilly_what_the_phone_calls_them( string $called, string $who ): string {
	$id = 0 === strpos( $who, 'young:' )
		? ( function_exists( 'localilly_their_page' ) && localilly_their_page() ? localilly_their_page()->ID : 0 )
		: localilly_whose_key( $who );

	if ( ! $id ) {
		return $called;
	}

	$name = (string) get_post_meta( $id, '_ll_name', true );

	return '' !== $name ? $name : $called;
}
add_filter( 'lamoureux_accounts_person_called', 'localilly_what_the_phone_calls_them', 10, 2 );

/**
 * The script loads at the door as well, where nobody is signed in yet.
 *
 * **The engine holds it back on pages with nobody standing on them**, which is
 * right everywhere except the one screen where somebody is trying to arrive.
 */
function localilly_the_face_at_the_door( bool $yes ): bool {
	return is_page( 'your-place' ) ? true : $yes;
}
add_filter( 'lamoureux_accounts_face_at_the_door', 'localilly_the_face_at_the_door' );

/**
 * The gift, offered on their own screen once they are already in.
 *
 * **Her ruling: after somebody is in, once, and never again if they say no.**
 * A person meeting this at the door has been asked to trust a stranger.
 */
function localilly_offer_them_their_face(): void {
	if ( class_exists( 'Lamoureux_Face' ) ) {
		Lamoureux_Face::the_offer();
	}
}

/**
 * A device that has opened a door says who walked through it.
 *
 * The engine proves the maths and stops there, deliberately — **only the
 * business knows what being in means.** LocaLilly puts the right key in the
 * right browser and that is the whole of it.
 *
 * @param string $who Their owner key.
 */
function localilly_their_face_opened_it( string $who ): void {
	$jar = 0 === strpos( $who, 'young:' ) ? LOCALILLY_KEYJAR : LOCALILLY_THEIRJAR;
	$key = (string) substr( $who, (int) strpos( $who, ':' ) + 1 );

	if ( '' === $key ) {
		return;
	}

	if ( ! headers_sent() ) {
		setcookie( $jar, $key, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true );
	}

	$_COOKIE[ $jar ] = $key;
}
add_action( 'lamoureux_accounts_face_opened', 'localilly_their_face_opened_it' );
