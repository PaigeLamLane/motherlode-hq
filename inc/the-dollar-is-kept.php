<?php
/**
 * The dollar is written down, once, and it stays written.
 *
 * ── THE FAULT THIS EXISTS FOR ─────────────────────────────────────────────
 *
 * She paid one dollar three times, at 08:16, 09:02 and 09:53 on 30 August, and
 * was asked for it again every time. Real money, taken three times, granting
 * her nothing.
 *
 * Stripe did everything right. The webhook was enabled, reachable, correctly
 * addressed, listening for the right events, holding the right signing secret,
 * and it delivered — Stripe's own record shows the deliveries accepted.
 *
 * lamoureux-billing did everything right too, and this is the part worth
 * reading. A ONE-OFF PAYMENT DOES NOT WRITE AN ENTITLEMENT. It announces the
 * purchase and leaves the ledger to the business, deliberately, because a
 * business that sells countable work reserves and releases its own rows and
 * billing must never learn that drafts exist. Only a subscription is written by
 * billing itself.
 *
 * **LocaLilly sells one thing and it is a one-off.** So the announcement was
 * made three times into a room with nobody in it.
 *
 * THE SHAPE OF IT, AND IT IS THE ONE THAT KEEPS COSTING HER: every part
 * reported success. Stripe: delivered. Billing: heard. The site: 200. Three
 * green lights over an empty ledger. **A check that cannot fail is not a check**
 * — the only honest question was whether anybody was ever granted anything, and
 * nobody had asked it.
 *
 * So this file is the room, and it listens.
 *
 * NOTHING HERE TOUCHES THE SHARED PLUGIN. Her law holds: billing is the
 * family's and it is not edited from a child theme. This hears what billing
 * already says out loud.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * What a verified neighbour holds, in one word, in one place.
 *
 * Renamed 8 September 2026 alongside her-money.php, off The Shipper's
 * finding — the two must move together or a real payment writes one
 * string while this checks for another.
 */
const MOTHERLODE_VERIFIED = 'motherlode-verified';

/**
 * A dollar landed, so the neighbour who paid it is kept.
 *
 * Written in two places on purpose, and each survives the other going missing.
 * **The entitlement is the family's record** and outlives this theme entirely.
 * **The flag on her own record is what the page reads**, so a screen never waits
 * on a table in another plugin to decide whether she can write.
 *
 * @param array<string,mixed> $bought owner, business, of, how_many, stripe_ref, source.
 */
function localilly_the_dollar_is_kept( array $bought ): void {
	if ( 'localilly' !== (string) ( $bought['business'] ?? '' ) ) {
		return;
	}

	if ( MOTHERLODE_VERIFIED !== (string) ( $bought['of'] ?? '' ) ) {
		return;
	}

	$owner = (string) ( $bought['owner'] ?? '' );

	if ( '' === $owner ) {
		return;
	}

	/*
	 * The family's record first, and it never ends. Her ruling is that the
	 * dollar is asked once in a person's life on this site, so an entitlement
	 * with a date on it would quietly become a yearly fee.
	 */
	if ( class_exists( 'Lamoureux_Billing_Entitlements' )
		&& ! Lamoureux_Billing_Entitlements::holds( $owner, 'localilly', MOTHERLODE_VERIFIED ) ) {

		Lamoureux_Billing_Entitlements::write(
			array(
				'owner'      => $owner,
				'business'   => 'localilly',
				'holds'      => MOTHERLODE_VERIFIED,
				'source'     => Lamoureux_Billing_Entitlements::BY_ONE_OFF,
				'ends_how'   => Lamoureux_Billing_Entitlements::ENDS_NEVER,
				'stripe_ref' => (string) ( $bought['stripe_ref'] ?? '' ),
			)
		);
	}

	/* And her own record, which is what every screen actually reads. */
	$her = localilly_whose_key( $owner );

	if ( $her ) {
		update_post_meta( $her, '_ll_verified', 1 );
		update_post_meta( $her, '_ll_paid_session', (string) ( $bought['stripe_ref'] ?? '' ) );
	}
}
add_action( 'lamoureux_billing_purchased', 'localilly_the_dollar_is_kept', 10, 1 );

/**
 * Find the neighbour a billing owner key belongs to.
 *
 * @param string $owner Their owner key, as billing knows them.
 * @return int Their record, or 0.
 */
function localilly_whose_key( string $owner ): int {
	$key = 0 === strpos( $owner, 'neighbour:' ) ? substr( $owner, 10 ) : $owner;

	$found = get_posts(
		array(
			'post_type'        => 'localilly_neighbour',
			'post_status'      => 'any',
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'no_found_rows'    => true,
			'suppress_filters' => false,
			'meta_query'       => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => '_ll_key',
					'value' => $key,
				),
			),
		)
	);

	return $found ? absint( $found[0] ) : 0;
}

/**
 * A reading that is allowed to fail, because its two sides can disagree.
 *
 * ── WHAT THIS REPLACES, AND WHY THE FIRST ONE WAS WORTHLESS ───────────────
 *
 * My first version hunted for a neighbour holding `_ll_paid_session` with no
 * `_ll_verified`. Eagle Eye proved it could never fire, in four lines:
 *
 * **Both writers write both fields, adjacently, verified first, with no branch
 * between them.** So the state it hunted is unreachable through this theme's own
 * code. And it was blind to the very morning it was written for — her three
 * payments announced into an empty room, so no code here ran, so those records
 * carry NEITHER field and read as clean.
 *
 * **I compared two fields written by two adjacent lines, which is a variable
 * compared with itself.** A reading can only fail when its two sides come from
 * two authorities that are capable of disagreeing.
 *
 * So this asks STRIPE who paid, and asks THIS SITE who was granted. Stripe
 * cannot be talked round by a bug in here, and a gap between the two is exactly
 * the shape of her morning.
 *
 * AND IT ANSWERS WITH THE PAYMENTS THEMSELVES rather than with a word like
 * fine. A person reading it sees the session, the amount and the email of
 * somebody whose money went nowhere.
 *
 * @param int $days How far back to look.
 * @return array<int,string> A line per payment that granted nothing.
 */
function localilly_who_paid_for_nothing( int $days = 30 ): array {
	$key = (string) apply_filters( 'lamoureux_billing_stripe_key', '' );

	if ( '' === $key ) {
		return array( 'Stripe cannot be asked from here, so nobody can say whether a payment granted anything.' );
	}

	$since = time() - ( max( 1, $days ) * DAY_IN_SECONDS );
	$lost  = array();
	$after = '';

	/*
	 * Every page of it. **A limit is how a reading goes quiet as a world
	 * grows** — the first version stopped at two hundred records and would
	 * have stayed green while the two hundred and first person lost a dollar.
	 */
	do {
		$where = 'https://api.stripe.com/v1/checkout/sessions?limit=100&created[gte]=' . $since;

		if ( '' !== $after ) {
			$where .= '&starting_after=' . rawurlencode( $after );
		}

		$said = wp_remote_get(
			$where,
			array(
				'timeout' => 25,
				'headers' => array( 'Authorization' => 'Bearer ' . $key ),
			)
		);

		if ( is_wp_error( $said ) ) {
			return array( 'Stripe did not answer, so this reading proves nothing. Run it again rather than believing it.' );
		}

		$body = json_decode( (string) wp_remote_retrieve_body( $said ), true );

		if ( ! is_array( $body ) || ! isset( $body['data'] ) ) {
			return array( 'Stripe answered in a shape this cannot read, so nothing here is proven.' );
		}

		foreach ( (array) $body['data'] as $one ) {
			if ( 'paid' !== ( $one['payment_status'] ?? '' ) ) {
				continue;
			}

			$owner = (string) ( $one['metadata']['lamoureux_owner'] ?? '' );
			$holds = (string) ( $one['metadata']['lamoureux_holds'] ?? '' );

			if ( 'localilly' !== (string) ( $one['metadata']['lamoureux_business'] ?? '' ) ) {
				continue;
			}

			$after = (string) ( $one['id'] ?? '' );

			/* A payment carrying no owner could never have granted anybody. */
			if ( '' === $owner ) {
				$lost[] = sprintf(
					'%s paid $%s and named nobody, so it could never have been granted.',
					(string) ( $one['id'] ?? '' ),
					number_format( absint( (string) ( $one['amount_total'] ?? 0 ) ) / 100, 2 )
				);
				continue;
			}

			if ( localilly_they_hold_it( $owner, $holds ) ) {
				continue;
			}

			$lost[] = sprintf(
				'%s paid $%s on %s and holds nothing. %s',
				(string) ( $one['id'] ?? '' ),
				number_format( absint( (string) ( $one['amount_total'] ?? 0 ) ) / 100, 2 ),
				gmdate( 'j M H:i', absint( (string) ( $one['created'] ?? 0 ) ) ),
				(string) ( $one['customer_details']['email'] ?? 'no email given' )
			);
		}

		$more = ! empty( $body['has_more'] );
	} while ( $more );

	return $lost;
}

/**
 * Whether this site says somebody holds what they paid for.
 *
 * Asked of both places it can be true, because either one alone would let a
 * half-written grant read as whole.
 *
 * @param string $owner Their owner key.
 * @param string $holds What they bought.
 */
function localilly_they_hold_it( string $owner, string $holds ): bool {
	if ( class_exists( 'Lamoureux_Billing_Entitlements' )
		&& Lamoureux_Billing_Entitlements::holds( $owner, 'localilly', $holds ) ) {
		return true;
	}

	$her = localilly_whose_key( $owner );

	return $her && '' !== (string) get_post_meta( $her, '_ll_verified', true );
}
