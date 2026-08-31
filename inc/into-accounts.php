<?php
/**
 * A young person becomes a person, rather than a row on this site.
 *
 * lamoureux-accounts is Aunt Tea's and it holds the shape LocaLilly asked for:
 * **somebody written down who has no way of being reached at all, and a
 * custodian who performs an act to give them one.** That is her consent triple
 * built into the object rather than sitting on top of it.
 *
 * WHY THIS HAPPENS AT THE LAST MOMENT RATHER THAN THE FIRST. Their business
 * exists from the first answer, saved on this site, because a fifteen-year-old
 * closing a tab must lose none of it. **A person is written into the family's
 * accounts once there is a custodian to hold them**, which is the last moment
 * of the road and the first moment consent exists.
 *
 * NOTHING IS MOVED AND NOTHING IS DELETED. The road's own record stays exactly
 * where it is. **A migration that empties the old place before the new one is
 * proven is how work disappears**, and every young person here is somebody's
 * first business.
 *
 * AND EVERY FIELD ARRIVES CLOSED. The module's default is closed and a closed
 * field never appears in what comes back, so a template cannot render a young
 * person's detail by accident. **Each one is opened deliberately, by name, with
 * the reason written beside it.**
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * LocaLilly names itself to the family's accounts.
 *
 * Every business keeps its own separate idea of a person, so this name is what
 * keeps a young person here from being visible as the same person anywhere
 * else. **Her creepy ruling, enforced by the module rather than remembered.**
 */
add_filter( 'lamoureux_accounts_business', static fn(): string => 'localilly' );

/**
 * One side of this is a child, and the messaging module is told so.
 *
 * **It defaults to false, which fails open on the one rule where open is the
 * wrong way to fail.** A shared module cannot know which businesses have
 * children on them, so the default has to be somebody's choice rather than a
 * guess — and the business that knows must say so before anything sends.
 *
 * Turned on here while messaging is still switched off entirely, so it can
 * never be true that the road opened first and the guard arrived after.
 * **A guard set after a door opens has already failed once.**
 */
/*
 * ── HER RULING, 30 AUGUST, AND WHY THIS TURNS OFF ─────────────────────
 *
 * This switched on the shared module's child guard, whose one rule is that a
 * provider may never open a conversation — **a conversation begins when a
 * young person begins it.**
 *
 * That guard is written for a world with no gate in front of it, where any
 * adult may arrive and write to a child. **LocaLilly has a stronger one and it
 * is hers: an adult puts their own name on a real card before a single word
 * reaches a young person.** A bank has checked them, the name is theirs, and
 * the dollar is asked once.
 *
 * Her design has the neighbour writing first, and it is the whole product —
 * a young person who must open every conversation has to know a stranger
 * wants her before he can ask.
 *
 * **The half of that guard worth keeping is kept below, by hand:** one
 * unanswered message. An adult may say one thing and must then wait, so
 * nobody can be flooded by somebody she has not answered.
 */
add_filter( 'lamoureux_messages_one_side_is_a_child', '__return_false' );

/**
 * One unanswered word, and then he waits.
 *
 * Taken from the shared guard rather than invented, because it is the half
 * that still applies once a card stands behind every stranger.
 *
 * @param mixed  $allowed Whether they may.
 * @param string $from    Who is writing.
 * @param string $to      Who it is for.
 * @param array  $with    Everything else.
 * @return mixed
 */
function localilly_one_unanswered_word( $allowed, string $from, string $to, array $with ) {
	if ( is_wp_error( $allowed ) || ! class_exists( 'Lamoureux_Messages' ) ) {
		return $allowed;
	}

	/* A young person may always write, and as often as she likes. */
	if ( 0 === strpos( $from, 'young:' ) ) {
		return $allowed;
	}

	$thread = Lamoureux_Messages::thread(
		$from,
		$to,
		sanitize_key( (string) ( $with['business'] ?? 'localilly' ) ),
		absint( (string) ( $with['about'] ?? 0 ) )
	);

	$already = Lamoureux_Messages::conversation( $thread, 200 );

	if ( array() === $already ) {
		return $allowed;
	}

	$last = end( $already );

	if ( is_array( $last ) && strtolower( (string) $last['sender'] ) === strtolower( $from ) ) {
		return new WP_Error(
			'localilly_one_only',
			__( 'You have written to them. They answer in their own time.', 'localilly' )
		);
	}

	return $allowed;
}
add_filter( 'lamoureux_messages_may_write', 'localilly_one_unanswered_word', 20, 4 );

/**
 * Write a young person down, once there is a grown-up holding them.
 *
 * @param int $id Their record on this site.
 * @return string|WP_Error Their owner key, or why not.
 */
function localilly_into_accounts( int $id ) {
	if ( ! class_exists( 'Lamoureux_Person' ) || ! class_exists( 'Lamoureux_Profile' ) ) {
		return new WP_Error( 'localilly_no_accounts', 'The accounts module is absent, so nobody was written down rather than half of one.' );
	}

	$already = (string) get_post_meta( $id, '_ll_owner_key', true );

	if ( '' !== $already ) {
		return $already;
	}

	$said  = localilly_what_they_said( get_post( $id ) );
	$grown = sanitize_email( (string) get_post_meta( $id, '_ll_grown_email', true ) );

	if ( empty( $said['name'] ) || empty( $said['born'] ) || ! is_email( $grown ) ) {
		return new WP_Error( 'localilly_not_yet', 'A young person is written down once a grown-up is holding them.' );
	}

	/*
	 * The custodian first, since a young person may not exist without one. The
	 * adult is the one with a way of being reached; the young person has none
	 * until the adult gives them one.
	 */
	$holder = Lamoureux_Person::write_down(
		(string) get_post_meta( $id, '_ll_grown', true ),
		'',
		''
	);

	if ( is_wp_error( $holder ) ) {
		return $holder;
	}

	$theirs = Lamoureux_Person::write_down( $said['name'], $said['born'], $holder );

	if ( is_wp_error( $theirs ) ) {
		return $theirs;
	}

	update_post_meta( $id, '_ll_owner_key', $theirs );
	update_post_meta( $id, '_ll_holder_key', $holder );

	if ( class_exists( 'Lamoureux_Belongs' ) ) {
		Lamoureux_Belongs::she_joins( $theirs, 'young-person' );
		Lamoureux_Belongs::she_joins( $holder, 'grown-up' );
	}

	/*
	 * ── WHAT IS OPEN, AND WHY EACH ONE ────────────────────────────────
	 *
	 * Everything defaults to closed. These are opened one at a time, and the
	 * test for each is **would a neighbour standing at a gate be entitled to
	 * this before the young person has said a word to them.**
	 */
	$open = Lamoureux_Profile::OPEN;
	$shut = Lamoureux_Profile::CLOSED;

	/* Their own words, which are the whole point of the page. */
	Lamoureux_Profile::she_wrote( $theirs, 'their_line', (string) ( $said['line'] ?? '' ), $open );
	Lamoureux_Profile::she_wrote( $theirs, 'in_their_words', (string) ( $said['words'] ?? '' ), $open );
	Lamoureux_Profile::she_wrote( $theirs, 'what_i_can_do', implode( ', ', (array) ( $said['doing'] ?? array() ) ), $open );
	Lamoureux_Profile::she_wrote( $theirs, 'when_i_am_free', (string) ( $said['free'] ?? '' ), $open );
	Lamoureux_Profile::she_wrote( $theirs, 'what_i_ask', wp_json_encode( (array) ( $said['rates'] ?? array() ) ), $open );

	/*
	 * ── HER RULING, 25 AUGUST: THE STREET SHOWS ───────────────────────
	 *
	 * Her words: **yeah, the street does, but not the house number.**
	 *
	 * It was shut here while the atelier told a young person their street
	 * travels, so the site held two answers to one question about a child.
	 * Hers settles it, and both screens now say what this line does.
	 *
	 * **The house number is the guard, and it is enforced at the door** —
	 * a leading number is stripped before the street is ever stored, so a
	 * street name is all there is to open.
	 *
	 * Said once, plainly, and then built as she ruled: a first name, an age
	 * and a street narrow a young person to a block. **That is the trade she
	 * has chosen** — the work is walking distance, and a neighbour has put a
	 * dollar on a card in their own name before a word reaches them.
	 * Returning `$shut` on the line below reverts it whole.
	 */
	Lamoureux_Profile::she_wrote( $theirs, 'suburb', (string) ( $said['suburb'] ?? '' ), $open );
	Lamoureux_Profile::she_wrote( $theirs, 'street', (string) ( $said['street'] ?? '' ), $open );

	/*
	 * ── HELD FOR HER RECORDS, OPENED TO NOBODY ────────────────────────
	 *
	 * Her ruling of 25 August: **we get their full name and their age, and
	 * in the backend their address, because if something ever happens we
	 * need to know where to go.**
	 *
	 * Written in by name and shut by name, rather than left out. A field
	 * left out of this list is a field the profile never learns about, and
	 * a record she cannot reach on the one night it matters.
	 */
	Lamoureux_Profile::she_wrote( $theirs, 'family_name', (string) ( $said['last_name'] ?? '' ), $shut );
	Lamoureux_Profile::she_wrote( $theirs, 'house_number', (string) ( $said['number'] ?? '' ), $shut );

	/* And the grown-up is nobody's business but theirs. */
	Lamoureux_Profile::she_wrote( $theirs, 'held_by_name', (string) get_post_meta( $id, '_ll_grown', true ), $shut );
	Lamoureux_Profile::she_wrote( $theirs, 'held_by_email', $grown, $shut );

	return $theirs;
}

/**
 * The rate shape, which the shared modules do not yet hold.
 *
 * **Reported rather than assumed.** ASKED, QUOTE and GIFT are three whole
 * answers, and lamoureux-billing's `BY_GIFT` is a different idea entirely — it
 * records how an entitlement was acquired rather than what a young person asks
 * for a job.
 *
 * So it travels as JSON on the profile for now and stays readable by anything.
 * **A quote is never a price of nothing**, and the day the listings module holds
 * it properly this is one line.
 */
function localilly_rates_are_still_ours(): bool {
	return true;
}
