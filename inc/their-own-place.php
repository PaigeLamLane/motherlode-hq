<?php
/**
 * What a young person has, and what a neighbour has.
 *
 * **Her ruling, 30 August: the dashboards have to be gorgeous and fabulous.**
 *
 * And the honest finding that made them necessary: **a young person had the end
 * of a form.** She finished the road and the screen simply stopped being the
 * road. A neighbour had a place called Your Place; the girl whose business it
 * is had nowhere.
 *
 * **Neither of these is called a dashboard.** Her ruling on words: we never use
 * words that don't matter, they matter in the way you experience the world we
 * have made for you. **A girl who has made a business has a business** — she is
 * standing in it rather than visiting a screen about it.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Every conversation a young person is holding.
 *
 * @param string $key Their key.
 * @return array<int, array<string, mixed>>
 */
function localilly_their_conversations( string $key ): array {
	if ( '' === $key || ! class_exists( 'Lamoureux_Messages' ) ) {
		return array();
	}

	/*
	 * The letters themselves, rather than the list of doors they arrived
	 * through. **A conversation summary carries no words and no date**, so
	 * this screen drew a blank line for every neighbour who had written to her
	 * — silence over real letters, on the screen where a first business lives.
	 */
	return localilly_letters_for( 'young:' . $key );
}

/**
 * What a young person's business is worth so far, in her own terms.
 *
 * **Never a score and never a rating.** Her law: a count of jobs done is a
 * record of what somebody did; a rating out of five is a judgement of what they
 * are. This counts and never judges.
 *
 * @param int $id Their record.
 * @return array<string, string>
 */
function localilly_how_it_is_going( int $id ): array {
	$said  = localilly_what_they_said( get_post( $id ) );
	$since = get_post_field( 'post_date', $id );
	$open  = localilly_is_open( get_post( $id ) );

	$words = array_filter( (array) get_post_meta( $id, '_ll_said_of_them', true ) );
	$jobs  = array_filter( (array) get_post_meta( $id, '_ll_jobs_done', true ) );

	return array(
		'open'   => $open ? 'Open' : 'Closed for now',
		'since'  => $since ? date_i18n( 'j F', strtotime( $since ) ) : '',
		'doing'  => (string) count( array_filter( (array) ( $said['doing'] ?? array() ) ) ),
		'jobs'   => (string) count( $jobs ),
		'words'  => (string) count( $words ),
	);
}
