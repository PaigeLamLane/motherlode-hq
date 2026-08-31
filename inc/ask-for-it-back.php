<?php
/**
 * Write To Us.
 *
 * Her ruling, 25 August 2026: **nobody writes to her.** She is one person with
 * forty-three businesses, and every `mailto:` comes off.
 *
 * **And her correction the same afternoon, which is the reason this file reads
 * the way it does now:** *a parent must press a control rather than write to
 * her. Yeah, but come on, people.*
 *
 * **She was right.** Her ruling protects her inbox and her name. I had turned it
 * into a screen where a worried parent met two boxes and a button with nowhere
 * to put a single word of their own — **a form, on a site that has no forms**,
 * and on the one page a frightened parent lands.
 *
 * WHAT IT IS NOW
 *
 * A parent says whatever they want, in as many words or as few as they like.
 * **The letter lands whole in her back end**, kept exactly as written, rather
 * than in an inbox she cannot read. Asking for a young person's details to be
 * removed is one of the reasons people write rather than the only one.
 *
 * **A person reads every one and a person answers.** Nothing here decides what a
 * letter means.
 *
 * IT NEVER SAYS WHETHER A RECORD EXISTS
 *
 * The same warm word comes back either way. A form that answers differently for
 * a real address is a form that will tell a stranger whether a particular child
 * is listed here, one address at a time.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * The control itself.
 *
 * Her law that a road not built has its words taken down runs the other way too:
 * this draws only where the letters module can carry the ask onward.
 */
function localilly_ask_for_it_back(): void {
	?>
	<form class="askback" method="post" action="">
		<?php wp_nonce_field( 'localilly_askback', 'localilly_askback_nonce' ); ?>
		<input type="hidden" name="localilly_askback_sent" value="1">

		<h2 class="askback-ask">Write To Us</h2>
		<p class="askback-why">Say it however you like, in as many words or as few as you want. A person reads every one of these, and you hear back the same day.</p>

		<label class="askback-label" for="askback-said">What Would You Like To Say</label>
		<textarea class="askback-said" id="askback-said" name="said" rows="6" required></textarea>

		<label class="askback-label" for="askback-who">Your Name</label>
		<input class="askback-field" type="text" id="askback-who" name="who" autocomplete="name" required>

		<label class="askback-label" for="askback-email">Where We Write Back</label>
		<input class="askback-field" type="email" id="askback-email" name="grown_email" autocomplete="email" required>

		<button class="askback-go press" type="submit">Send It To Us</button>

		<p class="askback-also">Asking for your young person&rsquo;s details to be removed is one of the reasons people write. Say so here and it is done within thirty days.</p>
	</form>
	<?php
}

/**
 * Take the ask, mark it, and put it where she will see it.
 */
function localilly_take_the_ask(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_askback_sent'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_askback_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_askback_nonce'] ) ), 'localilly_askback' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	$who   = sanitize_text_field( wp_unslash( $_POST['who'] ?? '' ) );
	$email = sanitize_email( wp_unslash( $_POST['grown_email'] ?? '' ) );

	/*
	 * ── THEIR OWN WORDS, AND THIS WAS MISSING ─────────────────────────
	 *
	 * Her correction, 25 August: *a parent must press a control rather than
	 * write to her. Yeah, but come on, people.*
	 *
	 * **She was right and the fault was mine.** Her ruling that nobody writes
	 * to her is about her inbox and her name. I turned it into a screen where
	 * a worried parent had two boxes and a button and nowhere to put a single
	 * word of their own. **That is a form, and there are no forms here.**
	 *
	 * Kept exactly as written, by the same road a young person's own words
	 * take — no trimming, no tidying, no correcting.
	 */
	$said = localilly_safe_but_untidied( (string) wp_unslash( $_POST['said'] ?? '' ) );

	if ( '' === trim( $said ) ) {
		localilly_say_back( 'empty' );
		return;
	}

	if ( '' === $who ) {
		localilly_say_back( 'empty' );
		return;
	}

	if ( ! is_email( $email ) ) {
		localilly_say_back( 'address' );
		return;
	}

	$id = wp_insert_post(
		array(
			'post_type'    => 'localilly_askback',
			'post_status'  => 'private',
			/* The whole letter, where she reads it. */
			'post_content' => $said,
			'post_title'   => sprintf(
				'%s — %s',
				$who,
				mb_substr( trim( preg_replace( '/\s+/', ' ', $said ) ), 0, 60 )
			),
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		localilly_say_back( 'held' );
		return;
	}

	update_post_meta( $id, '_ll_grown_email', $email );
	update_post_meta( $id, '_ll_asked', current_time( 'mysql' ) );
	update_post_meta( $id, '_ll_said', $said );

	/*
	 * ── A LETTER IS NOT A REMOVAL ASK ─────────────────────────────────
	 *
	 * This used to mark the young person's record the moment anybody wrote,
	 * because the screen could only ever have been a removal ask. **Now that
	 * a parent writes whatever they like, marking a child for removal because
	 * their parent said hello would be a fault with real consequences.**
	 *
	 * So the letter is linked to their record and read by a person. **She
	 * decides what it is**, which is the same principle as everywhere else
	 * here: a person's words are never interpreted by a machine.
	 */
	$found = get_posts(
		array(
			'post_type'   => LOCALILLY_YOUNG,
			'post_status' => array( 'draft', 'publish', 'private' ),
			'numberposts' => 1,
			'meta_key'    => '_ll_grown_email',
			'meta_value'  => $email,
		)
	);

	if ( $found ) {
		update_post_meta( $id, '_ll_about', $found[0]->ID );
	}

	/*
	 * The same word either way, and deliberately so. See the note at the top:
	 * a form that answers differently for a real address will tell a stranger
	 * whether a particular child is listed here.
	 */
	localilly_say_back( 'asked' );
}
add_action( 'template_redirect', 'localilly_take_the_ask', 5 );

/**
 * Where the asks live, so she finds them without being told where to look.
 */
function localilly_askback_type(): void {
	register_post_type(
		'localilly_askback',
		array(
			'labels'          => array(
				'not_found'     => 'Every young person here is exactly where they want to be.',
				'name'          => 'Letters To Us',
				'singular_name' => 'A Letter',
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-heart',
			'menu_position'   => 27,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
			'supports'        => array( 'title', 'editor' ),
		)
	);
}
add_action( 'init', 'localilly_askback_type' );
