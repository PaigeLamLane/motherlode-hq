<?php
/**
 * Every discussion, in one place — 3 September 2026.
 *
 * Her words, direct: a dashboard area showing someone a professional is
 * "in discussions with" — every message thread, in one place, rather than
 * digging through email.
 *
 * BUILT ON THE SHARED lamoureux-messages PLUGIN, ALREADY LIVE AND ACTIVE
 * HERE, RATHER THAN INVENTED FRESH. It already holds threads, read
 * receipts, and a beautiful branded notification letter that never
 * carries the actual words (her own law, built into the shared plugin
 * itself). This file only ever calls its public API — nothing here
 * touches lamoureux-messages' own code.
 *
 * THE IDENTIFIER SCHEME. A logged-in person is 'user:{wp user id}',
 * resolved to a real email through the address filter below. A business
 * writing in without an account is simply their own email address — the
 * shared plugin already treats a bare email as an address, so nothing
 * extra is needed for that half.
 *
 * INJECTED ON THE SAME SAFE HOOK AS EVERYTHING ELSE ON THIS DASHBOARD
 * (dokan_dashboard_content_before) — Nan Made's own hard lesson, carried
 * forward from her-own-account.php: never fork Dokan's own dashboard
 * template. A dedicated Dokan endpoint (its own URL, its own nav item)
 * would need forking Dokan's endpoint-dispatch internals to build safely;
 * this reaches the same result — every thread, on the screen she already
 * lands on first — without it.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Who the current visitor is, in the shared plugin's own terms.
 *
 * @return string Empty for a guest with no way to be identified yet.
 */
function motherlode_who_am_i(): string {
	return is_user_logged_in() ? 'user:' . get_current_user_id() : '';
}

/**
 * A readable name for whoever is on the other side of a thread.
 *
 * @param string $who The person key.
 * @return string
 */
function motherlode_name_for( string $who ): string {
	if ( str_starts_with( $who, 'user:' ) ) {
		$user = get_userdata( (int) substr( $who, 5 ) );

		return $user ? $user->display_name : __( 'Somebody', 'motherlodehq' );
	}

	return is_email( $who ) ? $who : __( 'Somebody', 'motherlodehq' );
}

/**
 * A person key resolves to a real address — the one thing the shared
 * plugin's own letter-writer needs and cannot know on its own.
 *
 * @param string $address Empty until somebody answers.
 * @param string $who     The key.
 * @return string
 */
function motherlode_address_for( string $address, string $who ): string {
	if ( str_starts_with( $who, 'user:' ) ) {
		$user = get_userdata( (int) substr( $who, 5 ) );

		return $user ? $user->user_email : $address;
	}

	return $address;
}
add_filter( 'lamoureux_messages_address_for', 'motherlode_address_for', 10, 2 );

/**
 * Where the letter sends her to actually read it.
 *
 * @return string
 */
function motherlode_messages_where(): string {
	return home_url( '/dashboard/' );
}
add_filter( 'lamoureux_messages_where', 'motherlode_messages_where' );

/**
 * The panel itself — every thread a professional is part of, most recent
 * first, with the latest line and a reply box under each one.
 */
function motherlode_discussions_panel(): void {
	$who = get_current_user_id();

	if ( ! motherlode_is_a_real_professional( $who ) || ! class_exists( 'Lamoureux_Messages' ) ) {
		return;
	}

	$me     = motherlode_who_am_i();
	$sitting = Lamoureux_Messages::her_conversations( $me, 'motherlodehq' );

	?>
	<section class="motherlode-dash-panel motherlode-dash-main motherlode-discussions">
		<h2 class="motherlode-discussions-head">Every Discussion, In One Place.</h2>

		<?php if ( array() === $sitting ) : ?>
			<p class="motherlode-discussions-empty">Nobody's written to you yet. The moment somebody does, it lands here — never only in an inbox you have to go looking through.</p>
		<?php else : ?>
			<div class="motherlode-discussions-list">
				<?php foreach ( array_slice( $sitting, 0, 10 ) as $row ) : ?>
					<?php
					$thread = (string) $row['thread'];
					$said   = Lamoureux_Messages::conversation( $thread, 200 );

					if ( array() === $said ) {
						continue;
					}

					$last  = end( $said );
					$other = strtolower( trim( $last['sender'] ) ) === strtolower( trim( $me ) ) ? $last['recipient'] : $last['sender'];
					$name  = motherlode_name_for( (string) $other );
					$mine  = strtolower( trim( $last['sender'] ) ) === strtolower( trim( $me ) );
					?>
					<article class="motherlode-discussion">
						<header class="motherlode-discussion-head">
							<span class="motherlode-discussion-name"><?php echo esc_html( $name ); ?></span>
							<?php
						/*
						 * Real bug, caught testing this live: Lamoureux_Messages::write()
						 * stores 'written' via current_time('mysql') — site-local time,
						 * no timezone marker. Passing that straight to strtotime() reads
						 * it as UTC, and human_time_diff() compares it against real UTC
						 * time() — a message sent seconds ago read as "10 hours ago" on
						 * this site. get_gmt_from_date() converts the local string to its
						 * true UTC equivalent first, so both sides of the comparison
						 * agree on what time it actually is.
						 */
						$lam_when = strtotime( get_gmt_from_date( (string) $last['written'] ) );
						?>
						<time class="motherlode-discussion-when"><?php echo esc_html( human_time_diff( $lam_when ) . ' ago' ); ?></time>
						</header>
						<p class="motherlode-discussion-preview"><?php echo $mine ? '<strong>You:</strong> ' : ''; ?><?php echo esc_html( wp_trim_words( (string) $last['words'], 28 ) ); ?></p>

						<form class="motherlode-discussion-reply" method="post">
							<?php wp_nonce_field( 'motherlode_discussion_reply' ); ?>
							<input type="hidden" name="motherlode_reply_thread_to" value="<?php echo esc_attr( (string) $other ); ?>">
							<textarea name="motherlode_reply_words" placeholder="Write back…" rows="2" required></textarea>
							<button type="submit" name="motherlode_send_reply" value="1">Send</button>
						</form>
					</article>
				<?php endforeach; ?>
			</div>
			<?php if ( count( $sitting ) > 10 ) : ?>
				<p class="motherlode-discussions-more"><?php echo esc_html( count( $sitting ) - 10 ); ?> earlier discussions aren't shown here yet.</p>
			<?php endif; ?>
		<?php endif; ?>
	</section>
	<?php
}
add_action( 'dokan_dashboard_content_before', 'motherlode_discussions_panel', 8 );

/**
 * A reply, sent from the panel above.
 *
 * Same shape as every other real form on this theme — a hidden field and
 * a nonce, handled on template_redirect, nothing routed through AJAX that
 * doesn't need to be.
 */
function motherlode_send_discussion_reply(): void {
	if ( ! isset( $_POST['motherlode_send_reply'] ) ) {
		return;
	}

	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'motherlode_discussion_reply' ) ) {
		return;
	}

	$me = motherlode_who_am_i();

	if ( '' === $me || ! class_exists( 'Lamoureux_Messages' ) ) {
		return;
	}

	$to    = sanitize_text_field( wp_unslash( $_POST['motherlode_reply_thread_to'] ?? '' ) );
	$words = sanitize_textarea_field( wp_unslash( $_POST['motherlode_reply_words'] ?? '' ) );

	if ( '' === $to || '' === $words ) {
		wp_safe_redirect( wp_get_referer() ?: home_url( '/dashboard/' ) );
		exit;
	}

	Lamoureux_Messages::write( $me, $to, $words, array( 'business' => 'motherlodehq' ) );

	wp_safe_redirect( add_query_arg( 'said', '1', wp_get_referer() ?: home_url( '/dashboard/' ) ) );
	exit;
}
add_action( 'template_redirect', 'motherlode_send_discussion_reply', 6 );
