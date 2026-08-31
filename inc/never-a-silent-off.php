<?php
/**
 * Never A Silent Off.
 *
 * Her standard, 25 August 2026, marked urgent to every business:
 *
 *   People aren't thinking through; they're waiting for me to tell them to do
 *   everything. I need an active person making sure they've got the whole plan,
 *   every pathway — every possible button or way perfectly handled so no one
 *   gets stuck anywhere.
 *
 * **She walked Ask Gigi as an ordinary person, pressed a price box, and was
 * carried silently on to the next screen as though she had never asked.** The
 * payment was built and it worked. Every failure state walked her past it
 * without a word.
 *
 * LocaLilly carried twelve of the same shape, counted rather than guessed: a
 * bare `return;` inside a form handler, on a road a fifteen-year-old walks.
 * A young person types their name, leaves a suburb empty, presses the button
 * that starts their business — and the page reloads exactly as it was. No word,
 * no mark, and no business.
 *
 * **A press that does nothing has to say so.**
 *
 * WHY A CODE RATHER THAN A SENTENCE
 *
 * The word travels in a cookie, and a cookie is written by whoever holds the
 * browser. So a cookie carries a key into the list below and never a sentence —
 * her words live here, on the server, and a person can put no word of their own
 * on her site. An unknown key says nothing at all.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

const LOCALILLY_WORDJAR = 'localilly_word';

/**
 * Her words for every press that could fail.
 *
 * Her joy law reaches all of them: a save that held out is written with the same
 * warmth as a save that worked. Each one says what happened, and what to press.
 *
 * @return array<string, string>
 */
function localilly_the_words_back(): array {
	return array(
		'begin'    => 'Your name and your suburb start it. Add the one that is missing and you are through.',
		'cold'     => 'This page has been open a while and lost its place. Press once more and it saves.',
		'away'     => 'This browser has forgotten you. Your business is safe exactly as you left it — your email and your password open it again.',
		'held'     => 'That saved nowhere just now, so every word of yours is still here. Press it once more.',
		'address'  => 'That address looks a letter short. Give it another look and we will write to you.',
		'empty'    => 'That one came through empty. Fill it in and it keeps.',
		'twice'    => 'Kept already — you pressed it twice, and once was enough.',
		'open'     => 'Your business is open. Neighbours nearby can find you from this moment.',
		'closed'   => 'Closed for now, and every word of yours is exactly where you left it.',
		'paid'     => 'Thank you. Your name is on it, and you can write to any young person here from now on.',
		'written'  => 'That has reached them. They answer for themselves, in their own time.',
		/*
		 * Her way back in. The same words whether a place was found or not,
		 * so nobody can learn which emails belong to people on a site built
		 * around children.
		 */
		'written-to-you' => 'Check your email. Your way back in is waiting there, and it stays open for three days.',
		'about-kept'     => 'Kept. A young person reads your first name and your suburb, and the rest stays with us.',
		'who-kept'       => 'Kept, and held by us alone. A young person reads your first name and your suburb.',
		'word-kept'      => 'Kept. Your email and that password bring you straight in from any device you pick up.',
		'welcome-back'   => 'Welcome back. Your conversations and the people you have kept are exactly as you left them.',
		'comeback'       => 'That address looks a letter short. Give it another look and we will send your way back in.',
		'dollar'   => 'A dollar on a card in your own name comes first, so they know exactly who is asking.',
		'asked'    => 'That has reached us, in your own words, and a person is reading it. You hear back the same day.',
	);
}

/**
 * Say a word back to whoever just pressed.
 *
 * Sixty seconds is long enough to survive a redirect and short enough that a
 * word never greets somebody who has moved on.
 *
 * @param string $key One of localilly_the_words_back().
 */
function localilly_say_back( string $key ): void {
	if ( ! array_key_exists( $key, localilly_the_words_back() ) || headers_sent() ) {
		return;
	}

	setcookie( LOCALILLY_WORDJAR, $key, time() + MINUTE_IN_SECONDS, '/', '', is_ssl(), true );
	$_COOKIE[ LOCALILLY_WORDJAR ] = $key;
}

/**
 * The word waiting for this person, read once and then let go.
 */
function localilly_a_word_back(): string {
	$key = isset( $_COOKIE[ LOCALILLY_WORDJAR ] ) ? sanitize_key( wp_unslash( $_COOKIE[ LOCALILLY_WORDJAR ] ) ) : '';

	if ( '' === $key ) {
		return '';
	}

	if ( ! headers_sent() ) {
		setcookie( LOCALILLY_WORDJAR, '', time() - HOUR_IN_SECONDS, '/', '', is_ssl(), true );
	}

	unset( $_COOKIE[ LOCALILLY_WORDJAR ] );

	return localilly_the_words_back()[ $key ] ?? '';
}

/**
 * Put it on the screen, above the moment they are standing in.
 */
function localilly_the_word_on_screen(): void {
	$word = localilly_a_word_back();

	if ( '' === $word ) {
		return;
	}

	printf(
		'<p class="ll-word" role="status">%s</p>',
		esc_html( $word )
	);
}

/**
 * A door with nowhere to go refuses to be drawn.
 *
 * Madame Monet's guard, carried credited. It found two dead buttons on its own
 * live page, fixed them, and then made the template refuse to render a button
 * whose destination is empty — so the law lives in the template rather than in
 * the memory of whoever builds the sixth page.
 *
 * Her own instinct reached this first on the dollar screen, which draws no
 * button at all where a payment cannot complete.
 *
 * @param string $label Where it says it goes.
 * @param string $to    Where it actually goes.
 * @param string $class Its own class.
 */
function localilly_a_way_on( string $label, string $to, string $class = 'll-on' ): void {
	$to    = trim( $to );
	$label = trim( $label );

	if ( '' === $to || '' === $label || '#' === $to ) {
		return;
	}

	printf(
		'<a class="%s" href="%s">%s</a>',
		esc_attr( $class ),
		esc_url( $to ),
		esc_html( $label )
	);
}
