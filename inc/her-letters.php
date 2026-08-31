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
 * **Her own address, confirmed by her in writing on 23 August 2026** —
 * lilly@localilly.com.au, Lilly with a Y, matching her own line on the site.
 *
 * A mailbox she has named is a mailbox she intends. **Whether it exists and
 * receives is a separate fact**, and only a letter arriving proves it. Until
 * one has, treat every send from here as unproven rather than working.
 */
add_filter( 'lamoureux_touchpoints_from', static fn(): string => 'lilly@localilly.com.au' );
add_filter( 'lamoureux_touchpoints_from_name', static fn(): string => 'LocaLilly' );

/**
 * The house a LocaLilly letter is written on.
 *
 * Her palette, with one rule from the module obeyed rather than argued with:
 * **ink is always dark and paper is always pale**, so every word survives a
 * mail client that drops the backgrounds. Her deep purple on her enamel does
 * exactly that, and her mint is the accent rather than the ink — mint on pale
 * paper would fail the module's own contrast refusal, and it would be right to.
 */
add_filter(
	'lamoureux_touchpoints_house',
	static function ( array $house ): array {
		return array_merge(
			$house,
			array(
				'name'   => 'LocaLilly',
				'paper'  => '#F6F1F8',
				'outer'  => '#EDE4F2',
				'panel'  => '#FFFFFF',
				'ink'    => '#3F1B66',
				'accent' => '#792DA0',
				'crest'  => '🌿',
				'foot'   => 'LocaLilly · find your local Lilly, Jack, Mia or Mac',
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
