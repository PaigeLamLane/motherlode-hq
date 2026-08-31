<?php
/**
 * A Business Opens.
 *
 * **Found 25 August 2026 by walking the road rather than reading the list.** A
 * young person could complete every moment, and their record stayed a draft
 * forever — `wp_update_post` appeared nowhere in the theme. **A finished
 * business was a saved record and never a published one.**
 *
 * Everything downstream was untestable because of it: a search would have found
 * a draft, and a profile would have rendered somebody nobody could reach.
 *
 * HER TWO CONDITIONS, BOTH ENFORCED HERE
 *
 * **A grown-up says yes, and the young person chooses to open it.** Neither one
 * alone is enough — an adult cannot publish a child, and a child cannot publish
 * without an adult beside them.
 *
 * AND IT CLOSES AS EASILY AS IT OPENS
 *
 * Her joy law and her autonomy law together. **Stopping is a decision rather
 * than a failure**, so closing is one press, keeps every word, and reopens the
 * same way.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Is this business ready to open.
 *
 * @param array<string, mixed> $said What they have told us.
 * @return bool
 */
function localilly_ready_to_open( array $said ): bool {
	$done = localilly_moments_done( $said );

	foreach ( $done as $one ) {
		if ( ! $one ) {
			return false;
		}
	}

	return true;
}

/**
 * Is it open to a neighbour right now.
 */
function localilly_is_open( ?WP_Post $page ): bool {
	return $page instanceof WP_Post && 'publish' === $page->post_status;
}

/**
 * Open it, or close it, on their own press.
 */
function localilly_open_or_close(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_open'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_open_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_open_nonce'] ) ), 'localilly_open' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	$page = localilly_their_page();

	if ( ! $page ) {
		localilly_say_back( 'away' );
		return;
	}

	$wants = sanitize_key( wp_unslash( $_POST['localilly_open'] ) );
	$said  = localilly_what_they_said( $page );

	if ( 'open' === $wants ) {
		/*
		 * The gate. **Her grown-up's yes is the one that cannot be skipped**,
		 * and the check is the same one the road already uses rather than a
		 * second opinion about what finished means.
		 */
		if ( ! localilly_ready_to_open( $said ) ) {
			localilly_say_back( 'begin' );
			return;
		}

		$done = wp_update_post(
			array(
				'ID'          => $page->ID,
				'post_status' => 'publish',
			),
			true
		);

		localilly_say_back( is_wp_error( $done ) ? 'held' : 'open' );

		if ( ! is_wp_error( $done ) ) {
			update_post_meta( $page->ID, '_ll_opened', current_time( 'mysql' ) );
		}

		wp_safe_redirect( get_permalink() );
		exit;
	}

	if ( 'close' === $wants ) {
		/*
		 * **Every word survives closing.** Their record moves back to draft and
		 * loses none of itself, so reopening is one press rather than the road
		 * again.
		 */
		$done = wp_update_post(
			array(
				'ID'          => $page->ID,
				'post_status' => 'draft',
			),
			true
		);

		localilly_say_back( is_wp_error( $done ) ? 'held' : 'closed' );

		wp_safe_redirect( get_permalink() );
		exit;
	}
}
add_action( 'template_redirect', 'localilly_open_or_close', 4 );

/**
 * The control itself, drawn only where it can honestly be pressed.
 *
 * **Her law that a road not built has its words taken down**, applied to a
 * business that is genuinely finished rather than nearly.
 */
function localilly_the_opening( ?WP_Post $page, array $said ): void {
	if ( ! $page || ! localilly_ready_to_open( $said ) ) {
		return;
	}

	$open = localilly_is_open( $page );
	?>
	<form class="opening" method="post" action="">
		<?php wp_nonce_field( 'localilly_open', 'localilly_open_nonce' ); ?>

		<?php if ( $open ) : ?>
			<p class="opening-word">Your business is open. Neighbours in <?php echo esc_html( (string) $said['suburb'] ); ?> can find you.</p>
			<button class="opening-go opening-go--close press" type="submit" name="localilly_open" value="close">Close It For Now</button>
			<p class="opening-why">Closing keeps every word exactly as you wrote it, and opening again is one press.</p>
		<?php else : ?>
			<p class="opening-word">You are ready, <?php echo esc_html( (string) $said['name'] ); ?>.</p>
			<button class="opening-go press" type="submit" name="localilly_open" value="open">Open My Business</button>
			<p class="opening-why">Neighbours nearby can find you the moment you press it, and you can close it again whenever you like.</p>
		<?php endif; ?>
	</form>
	<?php
}
