<?php
/**
 * Who Sees This.
 *
 * Her correction, 25 August 2026: **the street does show. The house number does
 * not.** And then the question underneath it, which is the larger one:
 *
 *   Is that all being put in the information for the young person as well as
 *   the parent?
 *
 * **It was written for a parent alone.** A fifteen-year-old typed their street
 * into a box, and where it goes afterwards was explained to somebody else, on a
 * page she will never open.
 *
 * **Her autonomy law forbids that.** A young person is the one whose street it
 * is, and the one entitled to know.
 *
 * THE HABIT RATHER THAN THE PATCH
 *
 * Her question is about a street and the answer is a habit. **Every piece of a
 * young person we hold says who sees it, at the moment it is given** — under the
 * box, in the moment of typing, rather than on a policy page.
 *
 * WHAT WAS FOUND WHILE MEASURING
 *
 * Three statements about the street already existed on the site and they
 * disagreed with each other: the atelier said it travels with a first word, the
 * build screen said the number is held nowhere, and the privacy draft said the
 * street is public nowhere. **One fact, three answers.** They are one answer now,
 * and it lives here rather than in three templates.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * What is seen, and by whom — one answer, in her voice.
 *
 * The test on each is the one already written into the profile: would a
 * neighbour standing at a gate be entitled to this before the young person has
 * said a word to them.
 *
 * @return array<string, string>
 */
function localilly_who_sees_what(): array {
	return array(
		'name'   => 'Your first name shows on your page. Your full name is for our records and stays with us.',
		'number' => 'This is for our records only and is never made public. Your location is only ever the street.',
		'line'   => 'This shows on your page, under your name.',
		'suburb' => 'Your suburb shows, so neighbours nearby can find you.',
		'street' => 'Your street shows, so a neighbour a few doors away knows you are close.',
		'born'   => 'Your birthday is given by your grown-up and shown to nobody. It is how this stays a place for fifteen to eighteen.',
		'words'  => 'These show on your page, exactly as you wrote them.',
		'doing'  => 'These show on your page.',
		'rates'  => 'Your prices show, and you change them whenever you like.',
		'free'   => 'Your hours show, so a neighbour asks at a time that suits you.',
		'shots'  => 'Your pictures show on your page. Pick ones of your work rather than of you.',
		'grown'  => 'Your grown-up is shown to nobody. Their name is here for us, and for you.',
		'email'  => 'Your address is shown to nobody. It is how a letter reaches you.',
	);
}

/**
 * Say it under the box they are typing into.
 *
 * @param string $field One of localilly_who_sees_what().
 */
function localilly_who_sees( string $field ): void {
	$said = localilly_who_sees_what()[ $field ] ?? '';

	if ( '' === $said ) {
		return;
	}

	printf( '<p class="who-sees">%s</p>', esc_html( $said ) );
}

/**
 * The same truth for a parent, who is deciding rather than typing.
 *
 * **Two readers, two pieces of writing, and never one copied into both.** A
 * parent is weighing whether to allow this at all; a young person is mid-sentence
 * with a box open. The facts match to the letter and the words share none.
 *
 * @return array<int, array{what:string, said:string}>
 */
function localilly_what_a_parent_sees(): array {
	return array(
		array(
			'what' => 'Their Full Name',
			'said' => 'Held here, and only their first name is ever shown. A neighbour reads a first name and a street rather than a person to look up.',
		),
		array(
			'what' => 'Their Suburb And Street',
			'said' => 'Both shown, so a neighbour a few doors away knows they are close. It is how the work stays walking distance.',
		),
		array(
			'what' => 'Their House Number',
			'said' => 'Held here for our records and shown nowhere. We hold a full address for one reason: where anything ever happens to your young person, somebody needs to know exactly where to go.',
		),
		array(
			'what' => 'Their Birthday',
			'said' => 'You give it rather than they do, and it is shown to nobody. It is how this stays a place for fifteen to eighteen.',
		),
		array(
			'what' => 'Their Own Words And Prices',
			'said' => 'Shown, exactly as they wrote them. We correct no spelling and tidy no sentence.',
		),
		array(
			'what' => 'Their Pictures',
			'said' => 'Shown on their page. They choose each one.',
		),
		array(
			'what' => 'Your Name And Your Address',
			'said' => 'Shown to nobody. You are here so a young person has an adult standing beside them, named, from the first moment.',
		),
	);
}

/**
 * Draw it for a parent.
 */
function localilly_the_parent_table(): void {
	echo '<dl class="sees">';

	foreach ( localilly_what_a_parent_sees() as $row ) {
		printf(
			'<dt class="sees-what">%s</dt><dd class="sees-said">%s</dd>',
			esc_html( $row['what'] ),
			esc_html( $row['said'] )
		);
	}

	echo '</dl>';
}
