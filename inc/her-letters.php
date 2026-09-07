<?php
/**
 * Every letter LocaLilly sends is hers.
 *
 * WHY THIS IS URGENT ON THIS BUSINESS PARTICULARLY. Aunt Tea measured every
 * site and LocaLilly scored nought of three — every letter it could send came
 * from WordPress, at a mailbox nobody reads, signed WordPress. **And its
 * letters go to fourteen-year-olds and their parents, on a site whose entire
 * argument is that a child is looked after here.** A parent receiving that
 * would be right to distrust the rest of it.
 *
 * lamoureux-touchpoints is hers and it is Aunt Tea's build. Nothing here writes
 * a letter engine; this sets the house and writes the words.
 *
 * THE THREE THE MODULE INSISTS ON, and it refuses to seal a welcome missing
 * any of them: congratulate them on what they have done, tell them what happens
 * and when, and welcome them in. Her law, given after reading a welcome that
 * opened on three blunt words — **these are not confirmations.**
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * Who a letter comes from.
 *
 * 1 September 2026 — real bug, found on a sweep for leftover LocaLilly
 * branding: this theme was cloned from LocaLilly's, and every letter
 * MotherLode HQ sends was still going out as LocaLilly, from LocaLilly's
 * own confirmed mailbox — lilly@localilly.com.au. Left the sender
 * address alone rather than guess a replacement: her rule on a
 * credential or a confirmed fact is the same rule as a password — I
 * don't invent one. MotherLode HQ needs its own sending address
 * confirmed by her (and set up with Postmark, per this business's own
 * CLAUDE.md) before this filter can point at it correctly. Until then
 * this is flagged, not fixed, and outgoing mail should be treated as
 * unproven for this business the same way it was for LocaLilly.
 */
add_filter( 'lamoureux_touchpoints_from_name', static fn(): string => 'MotherLode HQ' );

/**
 * The house a MotherLode HQ letter is written on.
 *
 * Her actual confirmed palette for this business (the same tokens used
 * throughout style.css), not LocaLilly's purple — ink always dark, paper
 * always pale, so every word survives a mail client that drops the
 * background, same rule the module insists on either way.
 */
add_filter(
	'lamoureux_touchpoints_house',
	static function ( array $house ): array {
		return array_merge(
			$house,
			array(
				'name'   => 'MotherLode HQ',
				'paper'  => '#FDF2F5',
				'outer'  => '#F6E3E9',
				'panel'  => '#FFFFFF',
				'ink'    => '#3D0836',
				'accent' => '#EF1763',
				'crest'  => '🌿',
				'foot'   => 'MotherLode HQ · You Should Never Have To Choose.',
			)
		);
	}
);

/**
 * The welcome to the grown-up, the moment a young person finishes.
 *
 * WRITTEN TO THEM RATHER THAN ABOUT THE CHILD. A parent reading this has just
 * been named by a fourteen-year-old as the person who looks after them, and
 * the letter's whole job is to make that feel like being trusted rather than
 * being enrolled.
 *
 * IT CARRIES THEIR KEY. Her ruling that an adult is on the account arrives here
 * rather than as a password a child invents at nine at night.
 *
 * AND IT PROMISES EXACTLY WHAT IS TRUE. Nothing is live yet, so the letter says
 * so plainly. A welcome that overstates is the one a parent remembers.
 *
 * @param int $id The young person's record.
 * @return bool|WP_Error
 */
function localilly_welcome_the_grown_up( int $id ) {
	if ( ! function_exists( 'lam_welcome' ) ) {
		return new WP_Error( 'localilly_no_touchpoints', 'The letters module is absent, so no letter was sent rather than a plain one.' );
	}

	if ( get_post_meta( $id, '_ll_welcomed', true ) ) {
		return true;
	}

	$name   = (string) get_post_meta( $id, '_ll_name', true );
	$suburb = (string) get_post_meta( $id, '_ll_suburb', true );
	$grown  = (string) get_post_meta( $id, '_ll_grown', true );
	$to     = sanitize_email( (string) get_post_meta( $id, '_ll_grown_email', true ) );
	$key    = (string) get_post_meta( $id, '_ll_key', true );

	if ( ! is_email( $to ) || '' === $name ) {
		return new WP_Error( 'localilly_nowhere_to_send', 'A letter needs somebody to reach.' );
	}

	$doing = (array) get_post_meta( $id, '_ll_doing', true );
	$doing = array_values( array_filter( $doing ) );

	$letter = lam_welcome()
		->to( $grown )
		->congratulate(
			sprintf(
				'%s has just started a business. They wrote every word of it themselves — what they are good at, what they will charge, and when they are free — and they put your name down as the person who looks after them.',
				$name
			)
		)
		->what_happens(
			'Here is what happens from here, and when.',
			array_filter(
				array(
					sprintf( 'Their words and their prices are saved, and stay exactly as %s wrote them.', $name ),
					$doing ? sprintf( 'They have offered: %s.', implode( ', ', $doing ) ) : '',
					sprintf( 'The day LocaLilly opens in %s, theirs is first in line.', $suburb ? $suburb : 'your suburb' ),
					'Every neighbour who can message them will have paid a dollar on a card in their own name first.',
					sprintf( 'Messages reach %s, and they answer for themselves. They can show you any of it whenever they choose.', $name ),
				)
			)
		)
		->line( 'Their email and the password they chose open their business on any phone, and yours opens it beside them.' )
		->line( sprintf( 'Key: %s', $key ) )
		->come_in(
			sprintf(
				'Welcome, %s. A young person doing real work for the people a few doors away is how a street starts looking after its own again, and you have just made that possible for one of them.',
				$grown ? $grown : 'and thank you'
			),
			'See What They Made',
			home_url( '/create-your-business/' )
		)
		->finish( sprintf( '%s has started a business', $name ) );

	if ( is_wp_error( $letter ) ) {
		return $letter;
	}

	$sent = lam_letter_send( $to, sprintf( '%s has started a business', $name ), $letter );

	update_post_meta( $id, '_ll_welcomed', current_time( 'mysql' ) );

	return $sent;
}
