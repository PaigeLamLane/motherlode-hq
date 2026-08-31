<?php
/**
 * Everything a young person makes here can leave with them, whole.
 *
 * HER RULING, 24 AUGUST 2026: they could transfer everything — all their sales,
 * reviews, social credit, everything they have built up on LocaLilly must be
 * transferable, and it will be beautiful and smooth. Eighteen is the crossover
 * point and they decide; nineteen is when it happens anyway, since many
 * eighteen-year-olds are still in year twelve.
 *
 * **THIS BUILDS NONE OF THE CROSSOVER.** She has said plainly to plan that once
 * LocaLilly is perfect, and the new business has no name yet. This builds only
 * the thing that gets far dearer every week it waits: **a shape that can leave.**
 *
 * WHY TODAY IS THE ONLY CHEAP DAY. Zero young people have signed up. Nothing to
 * migrate, remap or rescue. The same decision in six months is a rescue
 * operation across every account, and in two years it is somebody's whole year.
 *
 * ── WHAT TRAVELS, AND WHAT STOPS ──────────────────────────────────────
 *
 * The sharpest question in her ruling, and it is a safety question rather than
 * a data one. **LocaLilly protects children. The one they cross into holds
 * adults.** So some of what exists here exists *because* they were a child, and
 * carrying it across would take a child's protections into an adult's world
 * where they mean something different.
 *
 * TRAVELS — theirs, made by them, and theirs to keep:
 *
 *     their name and their own line          LocaDan, the dog whisperer
 *     the words they wrote                   never edited by us, never by them
 *     what they offer and what they charge   including a quote and a gift
 *     when they are free
 *     what they earned, and from whom
 *     their date of birth                    the crossover runs on it
 *     their goodwill                         her word, and her definition
 *
 * STOPS — and every one of these stops for a reason rather than for tidiness:
 *
 *     their grown-up's name and email        that relationship exists because
 *                                            they were a child. An adult does
 *                                            not arrive somewhere new with a
 *                                            parent attached to their account.
 *
 *     their street                           collected under a child-safety
 *                                            design, held for a map that shows
 *                                            two streets away. An adult gives
 *                                            their own address on their own
 *                                            terms, to a business that asked.
 *
 *     their key                              a new business issues its own. A
 *                                            key that opens two doors is a
 *                                            single failure with two costs.
 *
 * ── GOODWILL, WHICH IS HER WORD AND HER DEFINITION ────────────────────
 *
 * She called it social credit and then said it better herself: **all the
 * goodwill that they've set up in their LocaLilly account** — the sentences
 * neighbours actually wrote, how many jobs they have done, and how long they
 * have been doing them.
 *
 * **It never collides with her ranking law, and the reason is worth keeping.**
 * None of it compares one young person to another. **A count of jobs done is a
 * record of what somebody did. A rating out of five is a judgement of what they
 * are.** She has asked for the first and forbidden the second, and both of those
 * are the same law rather than two.
 *
 * HER SENTENCE IS THE PRODUCT AND THIS IS BUILT TO IT DIRECTLY:
 *
 *     They may be new in Universe, but they have got three years of experience
 *     that they've built up on LocaLilly.
 *
 * **New in one place, never new at the work.** So three years comes from the day
 * they began rather than from anything anybody scores, and the sentences travel
 * as sentences rather than as a total.
 *
 * ── AND A YOUNG PERSON CHOOSES WHAT TRAVELS ───────────────────────────
 *
 * Her autonomy law, and I have taken it one particular way — **saying so here
 * so she can overturn it.**
 *
 * Every sentence travels unless its own young person says otherwise, and each
 * one carries that choice with it. **The alternative — nothing travels until
 * somebody ticks it — loses the goodwill of every young person who never opens
 * that screen**, which punishes the quiet ones and hands the confident ones an
 * advantage. That is a ranking by another road.
 *
 * So it is offered at the moment of crossing, with every sentence shown and any
 * of them able to stay behind. **Offered at the right moment rather than
 * decided in advance either way.**
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * A name that survives leaving.
 *
 * A WordPress post id means nothing anywhere else, so every young person also
 * carries an id of their own from the first moment. **A thing that travels
 * needs a name that is not borrowed from the place it is leaving.**
 *
 * @param int $id Their record.
 * @return string
 */
function localilly_their_own_id( int $id ): string {
	$their = (string) get_post_meta( $id, '_ll_id', true );

	if ( '' === $their ) {
		$their = 'll_' . wp_generate_uuid4();
		update_post_meta( $id, '_ll_id', $their );
	}

	return $their;
}

/**
 * Everything they made, in a shape that can leave whole.
 *
 * Deliberately plain: arrays and strings, no WordPress object anywhere in it,
 * nothing that needs this site to be understood. **A record that can only be
 * read by the software that wrote it has not been made portable.**
 *
 * @param int $id Their record.
 * @return array<string, mixed>
 */
function localilly_everything_they_made( int $id ): array {
	$said = localilly_what_they_said( get_post( $id ) );

	$made = array(
		'who'   => array(
			'id'    => localilly_their_own_id( $id ),
			'name'  => $said['name'] ?? '',
			'line'  => $said['line'] ?? '',
			'born'  => (string) get_post_meta( $id, '_ll_born', true ),
			/*
			 * A draft carries no GMT date, so post_date_gmt reads as all
			 * zeroes — a date that is not a date, travelling as though it were
			 * one. The local date is real from the moment the record exists.
			 */
			'began' => get_post_field( 'post_date', $id ),
		),
		'words' => $said['words'] ?? '',
		'does'  => array_values( (array) ( $said['doing'] ?? array() ) ),
		'asks'  => array_values( (array) ( $said['rates'] ?? array() ) ),
		'free'  => $said['free'] ?? '',
		/*
		 * ── MY OWN LAW, BROKEN BY ME, HOURS AFTER WRITING IT ──────────
		 *
		 * get_post_meta returns an empty string where nothing was stored, and
		 * (array) '' is array( '' ) — one element that is not a thing. It
		 * skipped a young person past naming their own price this morning, I
		 * wrote it up as a law, and then wrote it again here.
		 *
		 * **A rule you have written down is not a habit you have.** The fix is
		 * the same both times: read it as empty rather than casting it.
		 */
		'earned' => array_values( array_filter( (array) ( get_post_meta( $id, '_ll_earned', true ) ?: array() ) ) ),

		'goodwill' => localilly_their_goodwill( $id ),

		'from' => array(
			'business' => 'LocaLilly',
			'site'     => home_url( '/' ),
			'shape'    => 1,
		),
	);

	/**
	 * Filters everything a young person made, before it leaves.
	 *
	 * Widening only. Anything hooking here adds what a young person made and
	 * never removes it — what a person made is theirs, and a filter that could
	 * take a piece away is a filter that will.
	 *
	 * @param array $made What they made.
	 * @param int   $id   Their record.
	 */
	return (array) apply_filters( 'localilly_everything_they_made', $made, $id );
}

/**
 * What stays behind, named rather than merely omitted.
 *
 * Written as a list on purpose. **A thing left out silently looks like an
 * oversight the first time somebody reads the export**, and somebody will build
 * the receiving end from this shape alone.
 *
 * @return array<string, string>
 */
function localilly_what_stays_here(): array {
	return array(
		'grown_up' => 'The adult on their account, and that relationship exists because they were a child.',
		'street'   => 'Collected under a child-safety design. An adult gives their own address, on their own terms.',
		'number'   => 'Held so somebody could reach a child. A grown adult is reached by asking them.',
		'last_name'=> 'Held so a child could be identified by an adult who had to. They introduce themselves from here.',
		'key'      => 'A new business issues its own. A key that opens two doors is one failure with two costs.',
	);
}

/**
 * How old they are, from a date an adult attested to.
 *
 * Her ruling: a person under eighteen never proves their own age — an adult
 * attests by enrolling them, and that adult is the one verified. So this is
 * asked of the grown-up rather than of the young person.
 *
 * @param int $id Their record.
 * @return int|null
 */
function localilly_how_old( int $id ): ?int {
	$born = (string) get_post_meta( $id, '_ll_born', true );

	if ( '' === $born ) {
		return null;
	}

	try {
		$then = new DateTimeImmutable( $born );
	} catch ( Exception $e ) {
		return null;
	}

	return (int) $then->diff( new DateTimeImmutable( 'now' ) )->y;
}

/**
 * Their goodwill, in her word and to her definition.
 *
 * Three things, none of which compares one young person to another:
 *
 *     the sentences   what neighbours actually wrote, attributed and dated
 *     the count       how many jobs they have done
 *     the years       how long they have been at it, from the day they began
 *
 * **A count of jobs done is a record of what somebody did. A rating out of five
 * is a judgement of what they are.** This holds the first and refuses the
 * second, and that is one law rather than two.
 *
 * @param int $id Their record.
 * @return array<string, mixed>
 */
function localilly_their_goodwill( int $id ): array {
	$said = array_values(
		array_filter( (array) ( get_post_meta( $id, '_ll_said_of_them', true ) ?: array() ) )
	);

	/* A sentence stays behind only where its own young person said so. */
	$travelling = array_values(
		array_filter(
			$said,
			static fn( $one ): bool => empty( $one['stays'] )
		)
	);

	$began = get_post_field( 'post_date', $id );
	$years = 0;

	if ( $began ) {
		try {
			$years = (int) ( new DateTimeImmutable( $began ) )->diff( new DateTimeImmutable( 'now' ) )->y;
		} catch ( Exception $e ) {
			$years = 0;
		}
	}

	return array(
		'sentences' => $travelling,
		'jobs_done' => (int) get_post_meta( $id, '_ll_jobs_done', true ),
		'began'     => $began,
		'years'     => $years,

		/*
		 * Her own sentence, assembled rather than described, so whoever builds
		 * the receiving end has the line she asked for rather than a number to
		 * invent one from.
		 */
		'in_a_line' => localilly_goodwill_in_a_line( $id, $years, (int) get_post_meta( $id, '_ll_jobs_done', true ) ),
	);
}

/**
 * The line somebody reads when a young person arrives somewhere new.
 *
 * Hers, and it is the whole point of the crossover in one sentence: **they may
 * be new in Universe, but they have got three years of experience that they've
 * built up on LocaLilly.**
 *
 * Written here rather than at the far end, because the business that receives
 * it will know nothing about where they came from. **New in one place, never
 * new at the work.**
 *
 * @param int $id    Their record.
 * @param int $years How long they have been at it.
 * @param int $jobs  How many jobs done.
 * @return string
 */
function localilly_goodwill_in_a_line( int $id, int $years, int $jobs ): string {
	$name = (string) get_post_meta( $id, '_ll_name', true );
	$bits = array();

	if ( $years >= 1 ) {
		$bits[] = sprintf(
			/* translators: %d: whole years. */
			_n( '%d year', '%d years', $years, 'localilly' ),
			$years
		);
	}

	if ( $jobs > 0 ) {
		$bits[] = sprintf(
			/* translators: %d: how many jobs. */
			_n( '%d job', '%d jobs', $jobs, 'localilly' ),
			$jobs
		);
	}

	if ( ! $bits ) {
		return '';
	}

	return sprintf(
		/* translators: 1: their name, 2: years and jobs. */
		__( '%1$s built this up on LocaLilly — %2$s, and every word below written by a neighbour.', 'localilly' ),
		$name,
		implode( ', ', $bits )
	);
}

/**
 * A neighbour's own words about a young person, kept as words.
 *
 * Attributed and dated, and never averaged. **The truth law reaches here
 * hardest of anywhere** — a sentence about a person that they never earned is
 * a false statement, so nothing is ever written into this but what somebody
 * actually said.
 *
 * @param int    $id    Their record.
 * @param string $who   Who said it.
 * @param string $words What they said.
 * @param string $about Which job.
 * @return bool
 */
function localilly_a_neighbour_said( int $id, string $who, string $words, string $about = '' ): bool {
	$words = localilly_safe_but_untidied( $words );

	if ( '' === trim( $words ) || '' === trim( $who ) ) {
		return false;
	}

	$said = array_values(
		array_filter( (array) ( get_post_meta( $id, '_ll_said_of_them', true ) ?: array() ) )
	);

	$said[] = array(
		'who'   => sanitize_text_field( $who ),
		/*
		 * Already made safe above, and **deliberately not sanitised again** —
		 * sanitize_textarea_field trims, so a second pass would undo the whole
		 * point of the first.
		 */
		'words' => $words,
		'about' => sanitize_text_field( $about ),
		'when'  => current_time( 'Y-m-d' ),
		'stays' => false,
	);

	update_post_meta( $id, '_ll_said_of_them', $said );

	return true;
}

/**
 * How a young person signs off, and they never write it themselves.
 *
 * HER RULING: **ever, just Dan. Ever, ever, ever.** Their own name, and beneath
 * it always the mark and their name together — LocaDan, LocaSally — the way it
 * sits on the boy's shirt on her own front page.
 *
 * **They never fill it in.** A fifteen-year-old writing to an adult for the
 * first time should not also have to invent how to end a letter, and a business
 * that signs itself the same way every time is a business rather than a person
 * texting.
 *
 * It is the smallest piece of branding in the ecosystem and the one a neighbour
 * sees most — **at the bottom of every letter they ever receive from a young
 * person.**
 *
 * @param int $id Their record.
 * @return array{name:string, mark:string}
 */
function localilly_their_signoff( int $id ): array {
	$name = trim( (string) get_post_meta( $id, '_ll_name', true ) );

	return array(
		'name' => $name,
		'mark' => '' === $name ? '' : 'Local ' . $name,
	);
}

/**
 * The same, as the two lines that end a letter.
 *
 * @param int $id Their record.
 * @return string
 */
function localilly_signoff_lines( int $id ): string {
	$off = localilly_their_signoff( $id );

	if ( '' === $off['name'] ) {
		return '';
	}

	return $off['name'] . "\n" . $off['mark'];
}

/**
 * Made safe without being tidied.
 *
 * ── THREE TRIMS BEFORE STORAGE, AND IT REACHED THE DATABASE ───────────
 *
 * A neighbour's words about a young person went through wp_strip_all_tags,
 * which trims as its last act, then trim() again, then
 * sanitize_textarea_field, which trims a third time on the way in. **Every one
 * of the three looks reasonable read on its own.**
 *
 * And it was stored rather than rendered, so an indent somebody chose was gone
 * for good rather than gone from one screen. **You cannot give it back to
 * anybody who has already written.**
 *
 * WHY IT MATTERS MOST HERE. Her truth law: words come back exactly as they were
 * written. **A young person who begins a line with a space meant it, and a
 * blank line between two thoughts is punctuation they chose.** A system that
 * quietly tidies a fifteen-year-old's sentence is telling them how to write.
 *
 * SO: SANITISE FOR SAFETY WITHOUT SANITISING FOR TIDINESS. Script and style
 * blocks removed whole, then tags stripped, and **not one character of
 * whitespace touched.** The third instance of this fault found in the family in
 * one night, and the only one that reached storage.
 *
 * @param string $said What somebody wrote.
 * @return string Safe, and exactly as they left it.
 */
function localilly_safe_but_untidied( string $said ): string {
	/* A script or style block goes whole, contents included. */
	$said = (string) preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $said );

	/* Then the tags themselves, and strip_tags never touches whitespace. */
	return strip_tags( $said );
}
