<?php
/**
 * A neighbour writes to a young person.
 *
 * **Built 30 August 2026, because the road did not exist.** She walked her own
 * world wanting to message somebody and there was nothing to press — the dollar
 * screen was complete, the profile was complete, and **the dollar gated nothing
 * because there was no door behind it.**
 *
 * The engine is `lamoureux-messages` and it was already whole: threads, a table
 * of its own, a guard that knows one side is a child. **This theme set one
 * filter on it and never called it once.**
 *
 * HER DESIGN, AND THE ORDER MATTERS
 *
 * Searching is free. **A dollar on a real card comes before a first word**, so a
 * young person knows exactly who is asking. That is the whole safety argument
 * and it is load-bearing rather than a fee.
 *
 * SO THE GATE IS THE DOLLAR AND NOTHING ELSE
 *
 * A neighbour who has paid may write. One who has not meets the dollar first and
 * comes back to the same young person afterwards.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Has this neighbour put their name to a card.
 */
function localilly_they_are_verified(): bool {
	$who = localilly_who_is_writing();

	if ( '' === $who ) {
		return false;
	}

	/*
	 * ── ASKED OF THE BILLING MODULE, NEVER OF A MARKER OF MY OWN ──────
	 *
	 * My first version read a `_ll_verified` meta field that **nothing on
	 * this world has ever written.** The dollar screen was complete, the
	 * payment reached her account, and the gate would have stayed shut
	 * forever — a neighbour paying and still finding no way to write.
	 *
	 * `her-money.php` already declares what the dollar buys —
	 * `motherlode-verified` (renamed 8 September 2026, off The Shipper's
	 * finding) — and the billing module records it when the payment
	 * lands. **The entitlement is the fact. A second copy of it in
	 * post meta is a second thing to keep true.**
	 */
	/*
	 * Her own record first, because it is written the moment Stripe confirms
	 * the payment rather than whenever a webhook decides to arrive.
	 */
	$place = localilly_their_place();

	if ( $place && '' !== (string) get_post_meta( $place->ID, '_ll_verified', true ) ) {
		return true;
	}

	if ( ! class_exists( 'Lamoureux_Billing_Entitlements' ) ) {
		return false;
	}

	return Lamoureux_Billing_Entitlements::holds(
		Lamoureux_Billing_Entitlements::owner_key(),
		'localilly',
		'motherlode-verified'
	);
}

/**
 * Who this neighbour is, to the messages module.
 */
function localilly_who_is_writing(): string {
	$place = localilly_their_place();

	if ( ! $place ) {
		return '';
	}

	$key = (string) get_post_meta( $place->ID, '_ll_key', true );

	return '' === $key ? '' : 'neighbour:' . $key;
}

/**
 * A line they typed, worn the way a name is worn.
 *
 * Her ruling, 30 August: **it keeps what they type, and it should be a capital
 * L and a capital M.** The lawn man is a title on a plate rather than a
 * sentence, so it is worn as one.
 *
 * Small words stay small — the lawn man reads better than The Lawn Man does
 * with every word shouting.
 *
 * @param string $said Their own line.
 */
function localilly_as_a_title( string $said ): string {
	$small = array( 'a', 'an', 'and', 'the', 'of', 'or', 'for', 'to', 'in', 'on', 'at', 'with' );
	$words = preg_split( '/\s+/', trim( $said ) );

	if ( ! $words ) {
		return $said;
	}

	foreach ( $words as $i => $word ) {
		$low = function_exists( 'mb_strtolower' ) ? mb_strtolower( $word ) : strtolower( $word );

		if ( 0 !== $i && in_array( $low, $small, true ) ) {
			$words[ $i ] = $low;
			continue;
		}

		$words[ $i ] = function_exists( 'mb_convert_case' )
			? mb_convert_case( $low, MB_CASE_TITLE, 'UTF-8' )
			: ucfirst( $low );
	}

	return implode( ' ', $words );
}

/**
 * LocaLilly answers who a neighbour is, because billing only ever asks.
 *
 * **Without this the dollar would be recorded against nobody, and every
 * neighbour on the site would share one entitlement.**
 *
 * `Lamoureux_Billing_Entitlements::owner_key()` falls back to
 * `get_current_user_id()`, which is **zero for every neighbour here** — they
 * carry a key in a browser rather than a WordPress account, which is her own
 * design so a person never invents a password.
 *
 * So the entitlement was going to be written against `0`, and the first
 * neighbour to pay a dollar would have opened the door for all of them.
 *
 * The module names the seam itself: *identity answers, billing only ever asks.*
 * This is LocaLilly answering.
 */
function localilly_who_billing_means( $who ) {
	$mine = localilly_who_is_writing();

	return '' !== $mine ? $mine : $who;
}
add_filter( 'll_identity_current_owner_id', 'localilly_who_billing_means' );


/**
 * A neighbour gets a key the moment they choose to pay, not before.
 *
 * **Her words, 30 August: I've already paid my dollar, but I don't have an
 * account. What the fuck is going on.**
 *
 * She was right and the fault is exact. **A dollar has to belong to somebody**,
 * and a neighbour only had a key after walking through Your Place. She went
 * straight to Zac, pressed to pay, and **her dollar was recorded against
 * nobody** — so the gate could never find it and asked her again.
 *
 * **No account and no sign-in**, which is her law. A key is made in her browser
 * at the one moment it becomes necessary, silently, and she is never asked to
 * invent anything.
 *
 * @return string Their key, made if they had none.
 */
function localilly_make_sure_they_have_a_place(): string {
	$place = localilly_their_place();

	if ( $place ) {
		return (string) get_post_meta( $place->ID, '_ll_key', true );
	}

	$id = wp_insert_post(
		array(
			'post_type'   => LOCALILLY_NEIGHBOUR,
			'post_status' => 'draft',
			'post_title'  => 'A neighbour — ' . current_time( 'j M Y' ),
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		return '';
	}

	$key = wp_generate_password( 24, false, false );
	update_post_meta( $id, '_ll_key', $key );

	if ( ! headers_sent() ) {
		setcookie( LOCALILLY_THEIRJAR, $key, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true );
	}

	$_COOKIE[ LOCALILLY_THEIRJAR ] = $key;

	return $key;
}

/**
 * What a neighbour has written and has yet to send.
 *
 * @param int $young Who it is for.
 * @return string Their own words, exactly as typed.
 */
function localilly_words_waiting( int $young ): string {
	$place = localilly_their_place();

	if ( ! $place ) {
		return '';
	}

	return (string) get_post_meta( $place->ID, '_ll_held_' . $young, true );
}

/**
 * Hold what they wrote, the moment they write it.
 *
 * @param int    $young Who it is for.
 * @param string $said  Their own words.
 */
function localilly_hold_their_words( int $young, string $said ): void {
	localilly_make_sure_they_have_a_place();

	$place = localilly_their_place();

	if ( $place ) {
		update_post_meta( $place->ID, '_ll_held_' . $young, $said );
	}
}

/**
 * The one moment on a young person's page.
 *
 * ── HER DESIGN, AND SHE FOUND THE HOLE IN IT HERSELF ──────────────────────
 *
 * Somebody has just read Zac and wants to say could you mow the lawn on
 * Saturday. **The urge is to write.** Anything asked before that loses a person
 * who would have been a good customer, so the writing comes first and there is
 * no sign-up anywhere on this road.
 *
 * Then her own words stay on the screen while she pays. Her correction, and it
 * is the whole reason this is built the way it is: *they might think they're
 * going to lose what they've written.* **A sentence promising her words are safe
 * would name the fear in order to soothe it.** Showing them removes the fear
 * without ever mentioning it, and it makes the dollar make sense — she is
 * looking at what she wrote and paying to send it.
 *
 * And the send happens on the way back from the dollar, so she never meets a
 * button that could fail after her money has moved.
 *
 * @param int    $young Their record.
 * @param string $name  Their first name.
 */
function localilly_the_first_word( int $young, string $name ): void {
	if ( ! class_exists( 'Lamoureux_Messages' ) ) {
		return;
	}

	$verified = localilly_they_are_verified();
	$waiting  = localilly_words_waiting( $young );

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$again = isset( $_GET['rewrite'] );

	/* Her words are in front of her, and the dollar sits beside them. */
	if ( ! $verified && ! $again && '' !== trim( $waiting ) ) {
		localilly_the_dollar_beside_their_words( $young, $name, $waiting );
		return;
	}

	?>
	<section class="firstword">
		<?php localilly_the_word_on_screen(); ?>

		<p class="them-eyebrow">Write Your Letter To <?php echo esc_html( $name ); ?></p>
		<p class="firstword-why">Tell <?php echo esc_html( $name ); ?> the work, when suits you, and where. The more you say, the better <?php echo esc_html( $name ); ?> can answer in one go.</p>
		<?php
		/*
		 * ── HER RULING, 30 AUGUST: THE DOLLAR IS NAMED BEFORE THEY WRITE ──
		 *
		 * Her words: say write your letter, and when you press send you'll be
		 * taken to the screen.
		 *
		 * **A person who writes something careful and then meets a payment they
		 * had no warning of feels caught.** Naming it here costs the road
		 * nothing — the writing still comes first, the urge is still answered
		 * first, and the dollar arrives as expected rather than as a toll.
		 *
		 * And it earns the dollar its meaning twice: said here, and then said
		 * again beside their own words while they pay.
		 */
		if ( ! $verified ) :
			?>
			<p class="firstword-ahead">Press send and your letter travels with you to the dollar &mdash; one, on a card in your own name, once and never again, so <?php echo esc_html( $name ); ?> knows exactly who is asking.</p>
		<?php endif; ?>

		<form class="firstword-form" method="post" action="">
			<?php wp_nonce_field( 'localilly_first_word', 'localilly_first_word_nonce' ); ?>
			<input type="hidden" name="localilly_wrote" value="<?php echo esc_attr( (string) $young ); ?>">

			<label class="askback-label" for="firstword-said">In Your Own Words</label>
			<textarea class="askback-said" id="firstword-said" name="said" rows="6" required
				data-holds="localilly-<?php echo esc_attr( (string) $young ); ?>"
				placeholder="Our front lawn needs doing before Sunday, and there is a mower in the shed you are welcome to."><?php echo esc_textarea( $waiting ); ?></textarea>

			<button class="askback-go press" type="submit">Send It To <?php echo esc_html( $name ); ?></button>
		</form>
	</section>
	<?php
}

/**
 * Their letter, whole, with the dollar beside it.
 *
 * The two questions are the two a letter needs — who it is from and where the
 * answer goes. **A person meets those rather than a sign-up**, and their account
 * is made out of what they have already given.
 *
 * @param int    $young Their record.
 * @param string $name  Their first name.
 * @param string $said  What the neighbour wrote.
 */
function localilly_the_dollar_beside_their_words( int $young, string $name, string $said ): void {
	$place = localilly_their_place();
	$mine  = $place ? (string) get_post_meta( $place->ID, '_ll_name', true ) : '';
	$mail  = $place ? (string) get_post_meta( $place->ID, '_ll_email', true ) : '';
	?>
	<section class="firstword firstword--sending">
		<?php localilly_the_word_on_screen(); ?>

		<p class="them-eyebrow">Your Letter To <?php echo esc_html( $name ); ?></p>

		<blockquote class="firstword-letter"><?php echo nl2br( esc_html( $said ) ); ?></blockquote>

		<p class="firstword-edit">
			<a href="<?php echo esc_url( add_query_arg( 'rewrite', '1', (string) get_permalink( $young ) ) ); ?>">Say It Differently</a>
		</p>

		<form class="firstword-form" method="post" action="">
			<?php wp_nonce_field( 'localilly_dollar', 'localilly_dollar' ); ?>
			<input type="hidden" name="localilly_back" value="<?php echo esc_url( (string) get_permalink( $young ) ); ?>">
			<input type="hidden" name="localilly_sending" value="<?php echo esc_attr( (string) $young ); ?>">

			<label class="askback-label" for="fw-name">Your Name</label>
			<input class="seek-in" id="fw-name" name="whoami" type="text" required
				value="<?php echo esc_attr( $mine ); ?>" placeholder="The name <?php echo esc_attr( $name ); ?> will read">

			<label class="askback-label" for="fw-last">Your Family Name</label>
			<input class="seek-in" id="fw-last" name="lastname" type="text" required
				autocomplete="family-name" placeholder="So <?php echo esc_attr( $name ); ?> knows exactly who is asking">

			<label class="askback-label" for="fw-where">Your Address</label>
			<input class="seek-in" id="fw-where" name="address" type="text" required
				autocomplete="street-address" placeholder="Number and street, held by us alone">

			<label class="askback-label" for="fw-mail">Where We Reach You</label>
			<input class="seek-in" id="fw-mail" name="reachme" type="email" required
				value="<?php echo esc_attr( $mail ); ?>" placeholder="Your email">

			<label class="askback-label" for="fw-word">Choose A Password</label>
			<input class="seek-in" id="fw-word" name="myword" type="password" required
				autocomplete="new-password" placeholder="Whatever you will remember">

			<button class="askback-go press" type="submit">Send It To <?php echo esc_html( $name ); ?></button>
			<p class="firstword-dollar">One dollar, on a card in your own name, once and never again &mdash; so <?php echo esc_html( $name ); ?> knows exactly who is asking.</p>
		</form>
	</section>
	<?php
}

/**
 * Take a first word and hold it, or hand it straight to the engine.
 */
function localilly_take_the_first_word(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_wrote'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_first_word_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_first_word_nonce'] ) ), 'localilly_first_word' ) ) {
		localilly_say_back( 'cold' );
		return;
	}

	if ( ! class_exists( 'Lamoureux_Messages' ) ) {
		localilly_say_back( 'held' );
		return;
	}

	$young = absint( wp_unslash( $_POST['localilly_wrote'] ) );

	/* Kept exactly as written, by the road a young person's own words take. */
	$said = localilly_safe_but_untidied( (string) wp_unslash( $_POST['said'] ?? '' ) );

	if ( '' === trim( $said ) ) {
		localilly_say_back( 'empty' );
		return;
	}

	/*
	 * Held before anything else can go wrong. **Her law: if she can write it,
	 * it is already saved.** A person who closes the page here, or pays and
	 * comes back tomorrow, finds their own words waiting.
	 */
	localilly_hold_their_words( $young, $said );

	if ( ! localilly_they_are_verified() ) {
		wp_safe_redirect( (string) get_permalink( $young ) );
		exit;
	}

	localilly_send_what_is_waiting( $young );

	wp_safe_redirect( (string) get_permalink( $young ) );
	exit;
}
add_action( 'template_redirect', 'localilly_take_the_first_word', 4 );

/**
 * Send what a neighbour has already written, and let go of it.
 *
 * @param int $young Who it is for.
 * @return bool Whether it has reached them.
 */
function localilly_send_what_is_waiting( int $young ): bool {
	$said = localilly_words_waiting( $young );
	$from = localilly_who_is_writing();

	if ( '' === trim( $said ) || '' === $from ) {
		return false;
	}

	$key = (string) get_post_meta( $young, '_ll_key', true );

	if ( '' === $key ) {
		localilly_say_back( 'held' );
		return false;
	}

	$sent = Lamoureux_Messages::write(
		$from,
		'young:' . $key,
		$said,
		array(
			'business' => 'localilly',
			'about'    => $young,
		)
	);

	if ( is_wp_error( $sent ) ) {
		localilly_say_back( 'held' );
		return false;
	}

	/* It has gone, so the copy waiting to be sent lets go. */
	$place = localilly_their_place();

	if ( $place ) {
		delete_post_meta( $place->ID, '_ll_held_' . $young );
	}

	localilly_say_back( 'written' );

	return true;
}

/**
 * Coming back from the dollar, the letter goes on its own.
 *
 * **She never meets a send button after her money has moved.** The dollar lands
 * at priority 3, this runs at 5, and by the time the page draws her letter has
 * reached them.
 */
function localilly_the_letter_goes_home(): void {
	if ( ! is_singular( LOCALILLY_YOUNG ) || ! localilly_they_are_verified() ) {
		return;
	}

	$young = (int) get_queried_object_id();

	if ( '' === trim( localilly_words_waiting( $young ) ) ) {
		return;
	}

	localilly_send_what_is_waiting( $young );
}
add_action( 'template_redirect', 'localilly_the_letter_goes_home', 5 );

/**
 * The two questions a letter needs, answered on the way to the dollar.
 *
 * **This is the whole account.** Who it is from and where the answer goes, made
 * out of what they have already given rather than asked for again on a screen
 * of its own. Her moments law: there are no sign-ups in this ecosystem.
 */
function localilly_who_is_sending_this(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_sending'] ) ) {
		return;
	}

	if ( ! isset( $_POST['localilly_dollar'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_dollar'] ) ), 'localilly_dollar' ) ) {
		return;
	}

	localilly_make_sure_they_have_a_place();

	$place = localilly_their_place();

	if ( ! $place ) {
		return;
	}

	$mine = sanitize_text_field( (string) wp_unslash( $_POST['whoami'] ?? '' ) );
	$mail = sanitize_email( (string) wp_unslash( $_POST['reachme'] ?? '' ) );

	if ( '' !== $mine ) {
		update_post_meta( $place->ID, '_ll_name', $mine );
		wp_update_post( array( 'ID' => $place->ID, 'post_title' => $mine ) );
	}

	if ( is_email( $mail ) ) {
		update_post_meta( $place->ID, '_ll_email', $mail );
	}

	/*
	 * Her ruling of 30 August. **A fifteen-year-old gives her full name, her
	 * street and her house number before anybody can find her, and the adult
	 * walking toward her was giving a first name.** Held for her records
	 * alone; a young person reads a first name and a suburb.
	 */
	$last = sanitize_text_field( (string) wp_unslash( $_POST['lastname'] ?? '' ) );
	$addr = sanitize_text_field( (string) wp_unslash( $_POST['address'] ?? '' ) );

	if ( '' !== $last ) {
		update_post_meta( $place->ID, '_ll_last_name', $last );
	}

	if ( '' !== $addr ) {
		update_post_meta( $place->ID, '_ll_address', $addr );
	}

	/*
	 * And their password, chosen here rather than on a screen of its own.
	 * **Her ruling, and I had it backwards** — she chooses a password, and
	 * nothing is asked of what she chooses.
	 */
	localilly_keep_their_word( $place->ID, (string) wp_unslash( $_POST['myword'] ?? '' ) );
}
add_action( 'template_redirect', 'localilly_who_is_sending_this', 2 );
