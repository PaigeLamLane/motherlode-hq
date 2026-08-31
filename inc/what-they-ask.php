<?php
/**
 * What a young person asks, and the three answers that are all honest.
 *
 * BUILT SMALL ON PURPOSE, AT AUNT TEA'S RULING, 23 AUGUST 2026. A person with a
 * profile and several services at several prices belongs in the listings
 * module, and listings is held until she rules its repository — because every
 * copy shipped meanwhile makes the drift worse. So this is the smallest thing
 * LocaLilly needs, behind one function of its own. When the module lands, the
 * inside of `localilly_rate_for()` is swapped and every template above it
 * stays untouched.
 *
 * ── THE PART THAT DECIDES THE DATA ────────────────────────────────────
 *
 * Aunt Tea's warning, and it is the whole reason this file has a KIND rather
 * than a number: **a quote is never the poor relation of a price.**
 *
 * Money sanitisers floor at zero. So a service priced by quote and a service
 * given freely both arrive as 0 and become indistinguishable — and an honest
 * offer renders as an oversight. A young person who wrote "I'd rather look at
 * the yard first" has their care displayed as a blank.
 *
 * So the state is its own thing. A rate is one of three, and each is a full
 * answer rather than an absence of one:
 *
 *   ASKED    a number the young person set themselves
 *   QUOTE    they would rather see the job first, which is judgement
 *   GIFT     they are giving it, which is theirs to decide and never ours
 *
 * Her ruling underneath all three: the young person sets it. **A neighbour
 * never names a price.** This isn't AirTasker.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * The three honest answers to what does this cost.
 */
const LOCALILLY_ASKED = 'asked';
const LOCALILLY_QUOTE = 'quote';
const LOCALILLY_GIFT  = 'gift';

/**
 * What a young person asks, ready for a screen.
 *
 * Returns a list of rates, each carrying what it is for, which of the three
 * kinds it is, and the words to show. Never a bare number, so no template can
 * accidentally render a quote as nothing.
 *
 * @param int|string $person The young person. A placeholder until listings land.
 * @return array<int, array{what:string, kind:string, says:string, amount:?int}>
 */
function localilly_rate_for( $person ) {
	/**
	 * Filters what a young person asks.
	 *
	 * The seam the listings module will fill. Widening only — anything hooking
	 * here adds rates or corrects them, and never removes a young person's own.
	 *
	 * @param array      $rates  The rates.
	 * @param int|string $person The young person.
	 */
	$rates = (array) apply_filters( 'localilly_rates', array(), $person );

	if ( empty( $rates ) ) {
		$rates = array(
			array( 'what' => 'An hour',                  'kind' => LOCALILLY_ASKED, 'amount' => 25 ),
			array( 'what' => 'A lawn, front and back',   'kind' => LOCALILLY_ASKED, 'amount' => 40 ),
			array( 'what' => 'A car, washed and dried',  'kind' => LOCALILLY_ASKED, 'amount' => 30 ),
			array( 'what' => 'A whole yard',             'kind' => LOCALILLY_QUOTE, 'amount' => null ),
		);
	}

	foreach ( $rates as $i => $rate ) {
		$rates[ $i ]['says'] = localilly_rate_says( $rate );
	}

	return $rates;
}

/**
 * The words for one rate, in her voice rather than a formatter's.
 *
 * Each of the three says a whole sentence's worth in as few words as it can,
 * and none of them reads as a missing value.
 *
 * @param array $rate One rate.
 * @return string
 */
function localilly_rate_says( array $rate ) {
	$kind = isset( $rate['kind'] ) ? $rate['kind'] : LOCALILLY_ASKED;

	if ( LOCALILLY_GIFT === $kind ) {
		return 'A gift';
	}

	if ( LOCALILLY_QUOTE === $kind ) {
		return 'Have a look together';
	}

	$amount = isset( $rate['amount'] ) ? (int) $rate['amount'] : 0;

	return '$' . number_format_i18n( $amount );
}
