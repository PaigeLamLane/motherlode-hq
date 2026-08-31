<?php
/**
 * What became of a letter, told to both people.
 *
 * ── HER RULING, 30 AUGUST, AND IT REVERSES AN OLDER ONE ───────────────────
 *
 * Her words: *yes, the young person needs to know that the sender knows they've
 * read it, because that shows them that if they don't get back, they'll move on
 * to somebody else. Yes, the young person needs to know that the person has read
 * it and when it was sent. It's transparency.*
 *
 * **Both sides see the same facts.** When it was sent, and when it was read.
 * Nobody is told one story while the other reads a different one.
 *
 * AND IT IS TEACHING RATHER THAN PRESSURE. This is a young person's first
 * business. A customer who is waiting is a customer who can go elsewhere, and
 * learning that from a plain date is the gentlest way anybody ever learns it.
 * **Her instruction is that it belongs in the business builder**, so it is
 * written here as a fact both people can read and never as a nudge, a countdown,
 * a badge or a warning.
 *
 * WHY IT LIVES HERE RATHER THAN IN THE SHARED MODULE. lamoureux-messages has no
 * column for a reading, deliberately, under an older law of hers that forbade
 * read receipts outright. **A shared module is not turned around from a child
 * theme**, so LocaLilly keeps its own record and her new ruling goes to the
 * family through her rather than through a quiet edit.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Mark a letter read, the first time its reader reads it.
 *
 * Only ever the person it was written to, and only ever once — a second look
 * never moves the date, so nobody can be shown a person returning to a message
 * again and again.
 *
 * @param array<string,mixed> $one Their letter, as the engine holds it.
 * @param string              $me  Who is reading right now.
 */
function localilly_it_has_been_read( array $one, string $me ): void {
	$id = absint( (string) ( $one['id'] ?? 0 ) );

	if ( 0 === $id || '' === $me ) {
		return;
	}

	if ( strtolower( (string) ( $one['recipient'] ?? '' ) ) !== strtolower( $me ) ) {
		return;
	}

	if ( '' !== (string) get_option( 'localilly_read_' . $id, '' ) ) {
		return;
	}

	update_option( 'localilly_read_' . $id, current_time( 'mysql' ), false );
}

/**
 * When a letter was read, or an empty string while it waits.
 *
 * @param array<string,mixed> $one Their letter.
 * @return string A date, in her words.
 */
function localilly_when_it_was_read( array $one ): string {
	$id = absint( (string) ( $one['id'] ?? 0 ) );

	return 0 === $id ? '' : (string) get_option( 'localilly_read_' . $id, '' );
}

/**
 * The plain line under a letter, the same for whoever is reading it.
 *
 * **Sent on 30 August. Read on 30 August.** Two facts and no adjectives. A
 * letter still waiting says when it was sent and stops there, so an unanswered
 * message never carries a word that could sound like impatience.
 *
 * @param array<string,mixed> $one Their letter.
 * @param bool                $mine Whether the person reading wrote it.
 */
function localilly_what_became_of_it( array $one, bool $mine ): void {
	$sent = (string) ( $one['written'] ?? '' );
	$read = localilly_when_it_was_read( $one );

	if ( '' === $sent ) {
		return;
	}

	$line = sprintf(
		/* translators: %s: the day it was sent, in her words. */
		__( 'Sent %s', 'localilly' ),
		mysql2date( 'j F', $sent )
	);

	if ( '' !== $read ) {
		$line .= sprintf(
			/* translators: %s: the day it was read. */
			__( ' &middot; Read %s', 'localilly' ),
			mysql2date( 'j F', $read )
		);
	}

	printf(
		'<p class="mine-talk-became"%s>%s</p>',
		$mine ? '' : ' data-theirs="1"',
		wp_kses_post( $line )
	);
}

/**
 * Every letter a person actually holds, newest conversation first.
 *
 * ── THE FAULT THIS EXISTS FOR ─────────────────────────────────────────────
 *
 * Both screens asked the engine for a person's conversations and then drew
 * `words` and `when` from what came back. **A conversation summary carries
 * neither.** It holds a thread, a business, what it is about, the time of the
 * latest letter and how many there are — by design, because a summary is a list
 * of doors rather than a pile of letters.
 *
 * So every conversation on both screens drew a blank line with a blank date, and
 * it looked exactly like having no messages. **Her place and a young person's
 * business have both been reporting silence over real letters.**
 *
 * The same shape as her three payments, and it is the shape worth naming: every
 * step succeeded. The query ran. The loop ran. The markup drew. **Nothing failed,
 * and nothing was there**, because the only question nobody asked was whether a
 * word ever reached the screen.
 *
 * @param string $me       Who is asking, as the engine knows them.
 * @param int    $how_many How many letters at most.
 * @return array<int,array<string,mixed>> Real letters, newest first.
 */
function localilly_letters_for( string $me, int $how_many = 12 ): array {
	if ( '' === $me || ! class_exists( 'Lamoureux_Messages' ) ) {
		return array();
	}

	$doors   = (array) Lamoureux_Messages::her_conversations( $me, 'localilly' );
	$letters = array();

	foreach ( $doors as $door ) {
		$thread = (string) ( $door['thread'] ?? '' );

		if ( '' === $thread ) {
			continue;
		}

		foreach ( (array) Lamoureux_Messages::conversation( $thread, 50 ) as $one ) {
			$letters[] = $one;
		}
	}

	usort(
		$letters,
		static fn( array $a, array $b ): int => strcmp( (string) ( $b['written'] ?? '' ), (string) ( $a['written'] ?? '' ) )
	);

	return array_slice( $letters, 0, max( 1, $how_many ) );
}

/**
 * A reading that is allowed to fail, on the one question worth asking.
 *
 * **Has a person with real letters been shown an empty screen.** Nothing else
 * about a conversation list can be checked honestly.
 *
 * ── TWO EDGES EAGLE EYE FOUND, AND BOTH WERE REAL ─────────────────────────
 *
 * **ABSENCE READ AS HEALTH.** With the messages module deactivated this
 * returned an empty string, which is the same answer it gives for a healthy
 * world. Switch the module off and every reading in the family goes quiet and
 * calls the estate well. **A reading that cannot tell silence from health is
 * the fault it was written to catch.**
 *
 * **AND THE PARTIAL CASE WAS INVISIBLE.** It fired only when letters came back
 * completely empty, so nine threads drawing and one blank passed green — and
 * the fault that prompted it is one deactivation away from being partial.
 *
 * @param string $me Who is asking.
 * @return string What is wrong, or an empty string when the screen is honest.
 */
function localilly_is_the_screen_honest( string $me ): string {
	if ( ! class_exists( 'Lamoureux_Messages' ) ) {
		return 'The messages module is absent, so no screen on this site can be checked. This reading proves nothing either way.';
	}

	$doors = (array) Lamoureux_Messages::her_conversations( $me, 'localilly' );

	if ( array() === $doors ) {
		return '';
	}

	/*
	 * Counted door by door rather than in one pile. **A pile only ever answers
	 * whether anything at all came through**, and one silent thread among nine
	 * is exactly what a person notices and a total hides.
	 */
	$silent = array();

	foreach ( $doors as $door ) {
		$thread = (string) ( $door['thread'] ?? '' );

		if ( '' === $thread ) {
			$silent[] = 'a conversation with no thread on it';
			continue;
		}

		$letters = (array) Lamoureux_Messages::conversation( $thread, 50 );

		if ( array() === $letters ) {
			$silent[] = $thread;
			continue;
		}

		/*
		 * A letter with no words drew a blank line on her screen for two days
		 * and looked exactly like having no messages, so an empty word is a
		 * fault here rather than an oddity.
		 */
		foreach ( $letters as $one ) {
			if ( '' === trim( (string) ( $one['words'] ?? '' ) ) ) {
				$silent[] = $thread . ' holds a letter with no words in it';
				break;
			}

			if ( '' === trim( (string) ( $one['written'] ?? '' ) ) ) {
				$silent[] = $thread . ' holds a letter with no date on it';
				break;
			}
		}
	}

	if ( array() === $silent ) {
		return '';
	}

	return sprintf(
		'%s holds %d conversations and %d of them reach the screen with nothing on: %s',
		$me,
		count( $doors ),
		count( $silent ),
		implode( ', ', array_slice( $silent, 0, 5 ) )
	);
}
