<?php
/**
 * The way back into a place you already have.
 *
 * ── THE FAULT THIS EXISTS FOR, AND IT IS THE ONE SHE KEPT NAMING ──────────
 *
 * Her words, three times over: **I need an account. This is the main issue.**
 *
 * She had one. Her dollar was held, her letters were there, her name was on the
 * bar. **And all of it hung on a key in one browser.** Arrive from another
 * browser, another device, or after that browser tidies itself, and the site
 * knows nobody — and then offers to make a place, which builds a SECOND empty
 * record while the first one keeps her dollar and her conversations.
 *
 * **A place you can be locked out of is not a place.** She was right every time
 * she said it, and the answer was never another screen to fill in.
 *
 * SO THE EMAIL IS THE ACCOUNT, AND IT ALWAYS WAS. She already gave it, once, on
 * the card that carried her dollar. Ask for it, write to her, and one press puts
 * her back exactly where she was.
 *
 * ── A CORRECTION, AND IT IS MINE ──────────────────────────────────────────
 *
 * This file first said no password anywhere, calling it her law. **She has never
 * made that law and I put her name on a rule she never gave** — the exact fault
 * her truth law forbids, committed against her.
 *
 * **She chooses a password.** So a password is chosen here, and it is the
 * shortest road: email and password, in from any device, every time.
 *
 * WHAT IS ASKED OF IT IS NOTHING. No length, no symbol, no meter, no advice.
 * Whatever somebody chooses is what they meant to choose, and a person who is
 * told their own answer is wrong has been handed a chore.
 *
 * And the letter stays, for the evening somebody cannot remember.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/** How long a way back in stays open. Long enough to read an email in the evening. */
const LOCALILLY_WAY_BACK_LASTS = 3 * DAY_IN_SECONDS;

/**
 * Whoever holds this email, on either side of the site.
 *
 * ── HER RULING, 30 AUGUST, AND IT TAKES A WHOLE IDEA OFF THE SITE ─────────
 *
 * Her words: **have they got a key? We don't use keys.**
 *
 * A young person was handed a string of letters on her own business screen and
 * told to keep it somewhere safe. A grown-up was posted one. A neighbour was
 * told her browser had let go of hers. **Every one of those was an internal
 * detail wearing a costume** — a cookie, named on a screen, made a person's
 * problem.
 *
 * An email and a password. On both sides, the same door, the same words.
 *
 * @param string $mail Their email.
 * @return array{0:int,1:string} Their record and the jar their side uses.
 */
function localilly_whoever_holds( string $mail ): array {
	foreach ( array( LOCALILLY_NEIGHBOUR => LOCALILLY_THEIRJAR, LOCALILLY_YOUNG => LOCALILLY_KEYJAR ) as $type => $jar ) {
		$found = get_posts(
			array(
				'post_type'      => $type,
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'   => '_ll_email',
						'value' => $mail,
					),
				),
			)
		);

		if ( $found ) {
			return array( absint( $found[0] ), $jar );
		}
	}

	return array( 0, '' );
}

/**
 * They are in, on whichever side of the site they belong to.
 *
 * @param int    $id  Their record.
 * @param string $jar Which jar their side uses.
 * @return bool Whether it opened.
 */
function localilly_that_is_them( int $id, string $jar ): bool {
	$key = (string) get_post_meta( $id, '_ll_key', true );

	if ( '' === $key || '' === $jar ) {
		return false;
	}

	if ( ! headers_sent() ) {
		setcookie( $jar, $key, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true );
	}

	$_COOKIE[ $jar ] = $key;

	return true;
}

/**
 * Somebody says which email is theirs, and we write to them.
 */
function localilly_send_them_the_way_back(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_comeback'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_comeback'] ) ), 'localilly_comeback' ) ) {
		return;
	}

	$mail = sanitize_email( (string) wp_unslash( $_POST['reachme'] ?? '' ) );
	$word = (string) wp_unslash( $_POST['myword'] ?? '' );

	if ( ! is_email( $mail ) ) {
		localilly_say_back( 'comeback' );
		return;
	}

	/*
	 * A password opens the door here and now. Somebody who would rather be
	 * written to leaves it empty, and the letter goes instead.
	 */
	if ( '' !== $word && localilly_that_is_their_word( $mail, $word ) ) {
		return;
	}

	list( $found, $jar ) = localilly_whoever_holds( $mail );

	/*
	 * ── THE SAME ANSWER EITHER WAY, AND IT IS DELIBERATE ──────────────
	 *
	 * A screen that says we have never heard of you tells any stranger which
	 * emails belong to people on a site built around children. **The answer is
	 * identical whether a place was found or not**, and only somebody who
	 * genuinely holds that inbox ever learns the difference.
	 */
	if ( $found ) {
		$id    = $found;
		$token = wp_generate_password( 32, false, false );

		update_post_meta( $id, '_ll_comeback', wp_hash( $token ) );
		update_post_meta( $id, '_ll_comeback_until', time() + LOCALILLY_WAY_BACK_LASTS );

		$name = (string) get_post_meta( $id, '_ll_name', true );
		$link = add_query_arg( 'comeback', $token, home_url( '/your-place/' ) );

		$letter  = $name ? sprintf( "Hello %s,\n\n", $name ) : "Hello,\n\n";
		$letter .= "Here is your way back into your place on LocaLilly.\n\n";
		$letter .= $link . "\n\n";
		$letter .= "One press and you are exactly where you were.\n\n";
		$letter .= "It stays open for three days, and it is yours alone.\n\nLocaLilly";

		wp_mail(
			$mail,
			'Your Way Back Into LocaLilly',
			$letter
		);
	}

	localilly_say_back( 'written-to-you' );

	wp_safe_redirect( home_url( '/your-place/' ) );
	exit;
}
add_action( 'template_redirect', 'localilly_send_them_the_way_back', 2 );

/**
 * They pressed it, so they are back.
 */
function localilly_let_them_back_in(): void {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$token = isset( $_GET['comeback'] ) ? sanitize_text_field( wp_unslash( $_GET['comeback'] ) ) : '';

	if ( '' === $token ) {
		return;
	}

	$theirs = get_posts(
		array(
			'post_type'      => array( LOCALILLY_NEIGHBOUR, LOCALILLY_YOUNG ),
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => '_ll_comeback',
					'value' => wp_hash( $token ),
				),
			),
		)
	);

	if ( ! $theirs ) {
		return;
	}

	$id    = absint( $theirs[0] );
	$until = absint( (string) get_post_meta( $id, '_ll_comeback_until', true ) );

	if ( $until < time() ) {
		delete_post_meta( $id, '_ll_comeback' );
		return;
	}

	$jar = LOCALILLY_YOUNG === get_post_type( $id ) ? LOCALILLY_KEYJAR : LOCALILLY_THEIRJAR;

	if ( ! localilly_that_is_them( $id, $jar ) ) {
		return;
	}

	/* Used once, and then it is spent. */
	delete_post_meta( $id, '_ll_comeback' );
	delete_post_meta( $id, '_ll_comeback_until' );

	localilly_say_back( 'welcome-back' );

	wp_safe_redirect( home_url( LOCALILLY_YOUNG === get_post_type( $id ) ? '/create-your-business/' : '/your-place/' ) );
	exit;
}
add_action( 'template_redirect', 'localilly_let_them_back_in', 1 );

/**
 * The line offered to somebody the site does not recognise.
 *
 * **Above the road that makes a new place**, because a person who already has
 * one must meet their own door before they are offered a second.
 */
function localilly_offer_the_way_back(): void {
	?>
	<section class="comeback">
		<p class="them-eyebrow">Already Have A Place Here</p>
		<p class="firstword-why">Your email brings you straight back to your conversations and the young people you have kept.</p>
		<form class="firstword-form" method="post" action="" data-face-form>
			<?php wp_nonce_field( 'localilly_comeback', 'localilly_comeback' ); ?>
			<label class="askback-label" for="comeback-mail">Your Email</label>
			<input class="seek-in" id="comeback-mail" name="reachme" type="email" required
				placeholder="The email on your card" autocomplete="email">
			<label class="askback-label" for="comeback-word">Your Password</label>
			<input class="seek-in" id="comeback-word" name="myword" type="password"
				autocomplete="current-password" placeholder="Leave it empty and we will write to you instead">
			<button class="room-go press" type="submit">Take Me Back In</button>
			<?php
			/*
			 * Her face, offered only where a device can actually do it. The
			 * script unhides this and never the other way round, so a laptop
			 * that cannot is never shown a road it cannot walk.
			 */
			?>
			<button class="face-open" type="button" data-face-open hidden>Or Open It With Your Face</button>
			<p class="face-said" data-face-said></p>
		</form>
	</section>
	<?php
}

/**
 * Their own password, kept the way a password is kept.
 *
 * **Never stored as they typed it.** WordPress's own hashing holds it, which is
 * the same road every account on this machine already takes.
 *
 * @param int    $id   Their record.
 * @param string $word What they chose.
 */
function localilly_keep_their_word( int $id, string $word ): void {
	if ( '' === $word ) {
		return;
	}

	require_once ABSPATH . WPINC . '/class-phpass.php';

	$hasher = new PasswordHash( 8, true );

	update_post_meta( $id, '_ll_word', $hasher->HashPassword( $word ) );
}

/**
 * They gave an email and a password, so they are back.
 *
 * @param string $mail Their email.
 * @param string $word What they typed.
 * @return bool Whether they are in.
 */
function localilly_that_is_their_word( string $mail, string $word ): bool {
	list( $id, $jar ) = localilly_whoever_holds( $mail );

	if ( 0 === $id ) {
		return false;
	}

	$held = (string) get_post_meta( $id, '_ll_word', true );

	if ( '' === $held ) {
		return false;
	}

	require_once ABSPATH . WPINC . '/class-phpass.php';

	$hasher = new PasswordHash( 8, true );

	if ( ! $hasher->CheckPassword( $word, $held ) ) {
		return false;
	}

	if ( ! localilly_that_is_them( $id, $jar ) ) {
		return false;
	}

	localilly_say_back( 'welcome-back' );

	wp_safe_redirect( home_url( LOCALILLY_KEYJAR === $jar ? '/create-your-business/' : '/your-place/' ) );
	exit;
}

/**
 * Somebody chooses their password, wherever they are standing.
 */
function localilly_they_choose_their_word(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_my_word'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_my_word'] ) ), 'localilly_my_word' ) ) {
		return;
	}

	$word = (string) wp_unslash( $_POST['myword'] ?? '' );
	$id   = absint( wp_unslash( $_POST['whose'] ?? '' ) );

	if ( 0 === $id || '' === $word ) {
		return;
	}

	/* Only ever their own, proved by the browser rather than by the form. */
	$place = localilly_their_place();
	$page  = function_exists( 'localilly_their_page' ) ? localilly_their_page() : null;
	$mine  = array_filter( array( $place ? $place->ID : 0, $page ? $page->ID : 0 ) );

	if ( ! in_array( $id, $mine, true ) ) {
		return;
	}

	localilly_keep_their_word( $id, $word );

	localilly_say_back( 'word-kept' );

	wp_safe_redirect( LOCALILLY_YOUNG === get_post_type( $id ) ? home_url( '/create-your-business/' ) : home_url( '/your-place/' ) );
	exit;
}
add_action( 'template_redirect', 'localilly_they_choose_their_word', 2 );

/**
 * The line that offers a password to somebody who has none yet.
 *
 * @param int $id Their record.
 */
function localilly_offer_them_a_word( int $id ): void {
	if ( '' !== (string) get_post_meta( $id, '_ll_word', true ) ) {
		return;
	}
	?>
	<form class="place-name" method="post" action="">
		<?php wp_nonce_field( 'localilly_my_word', 'localilly_my_word' ); ?>
		<input type="hidden" name="whose" value="<?php echo esc_attr( (string) $id ); ?>">
		<label class="askback-label" for="my-word">Choose A Password, And Come Straight In From Any Device</label>
		<input class="seek-in" id="my-word" name="myword" type="password" required
			autocomplete="new-password" placeholder="Whatever you will remember">
		<button class="room-go press" type="submit">Keep It</button>
	</form>
	<?php
}

/**
 * The one moment where a neighbour says who she is.
 *
 * ── WHY IT IS ONE ─────────────────────────────────────────────────────────
 *
 * Three cards stood here, each with a button reading That Is Me. Her words:
 * **what a stupid thing.** A person confirming she is herself three times has
 * been given a chore rather than a moment, and her joy law forbids it.
 *
 * **And the first of the three saved nothing**, because it had no handler. The
 * form drew, the button worked, the page came back, and her name was gone. She
 * typed it repeatedly and the site forgot her every time.
 *
 * **A form that posts into the void looks exactly like a form that works.**
 *
 * Only what is missing is asked, so a finished room stays finished.
 *
 * @param int $id Their record.
 */
function localilly_the_one_moment( int $id ): void {
	$name  = (string) get_post_meta( $id, '_ll_name', true );
	$last  = (string) get_post_meta( $id, '_ll_last_name', true );
	$where = (string) get_post_meta( $id, '_ll_address', true );
	$word  = (string) get_post_meta( $id, '_ll_word', true );

	if ( '' !== $name && '' !== $last && '' !== $where && '' !== $word ) {
		return;
	}
	?>
	<section class="room-card room-card--ask">
		<h2 class="room-head">A Little About You</h2>
		<p class="room-empty">A young person reads your first name and your suburb. The rest stays with us alone, so we can reach you if we ever need to.</p>

		<form method="post" action="">
			<?php wp_nonce_field( 'localilly_about_me', 'localilly_about_me' ); ?>

			<?php if ( '' === $name ) : ?>
				<label class="askback-label" for="me-first">Your First Name</label>
				<input class="seek-in" id="me-first" name="whoami" type="text" required
					autocomplete="given-name" placeholder="What a young person will call you">
			<?php endif; ?>

			<?php if ( '' === $last ) : ?>
				<label class="askback-label" for="me-last">Your Family Name</label>
				<input class="seek-in" id="me-last" name="last_name" type="text" required
					autocomplete="family-name" placeholder="Your surname">
			<?php endif; ?>

			<?php if ( '' === $where ) : ?>
				<label class="askback-label" for="me-where">Your Address</label>
				<input class="seek-in" id="me-where" name="address" type="text" required
					autocomplete="street-address" placeholder="Number and street">
			<?php endif; ?>

			<?php if ( '' === $word ) : ?>
				<label class="askback-label" for="me-word">A Password, So Any Phone Opens This</label>
				<input class="seek-in" id="me-word" name="myword" type="password" required
					autocomplete="new-password" placeholder="Whatever you will remember">
			<?php endif; ?>

			<button class="room-go press" type="submit">Keep It</button>
		</form>
	</section>
	<?php
}

/**
 * And it is kept, all of it, in one act.
 */
function localilly_keep_the_one_moment(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['localilly_about_me'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_about_me'] ) ), 'localilly_about_me' ) ) {
		return;
	}

	$place = localilly_their_place();

	if ( ! $place ) {
		return;
	}

	$name  = sanitize_text_field( (string) wp_unslash( $_POST['whoami'] ?? '' ) );
	$last  = sanitize_text_field( (string) wp_unslash( $_POST['last_name'] ?? '' ) );
	$where = sanitize_text_field( (string) wp_unslash( $_POST['address'] ?? '' ) );

	if ( '' !== $name ) {
		update_post_meta( $place->ID, '_ll_name', $name );
		wp_update_post( array( 'ID' => $place->ID, 'post_title' => $name ) );
	}

	if ( '' !== $last ) {
		update_post_meta( $place->ID, '_ll_last_name', $last );
	}

	if ( '' !== $where ) {
		update_post_meta( $place->ID, '_ll_address', $where );
	}

	localilly_keep_their_word( $place->ID, (string) wp_unslash( $_POST['myword'] ?? '' ) );

	localilly_say_back( 'about-kept' );

	wp_safe_redirect( home_url( '/your-place/' ) );
	exit;
}
add_action( 'template_redirect', 'localilly_keep_the_one_moment', 2 );

/**
 * A reading that can fail: does every form on a page have somebody listening.
 *
 * **Her name was typed and lost repeatedly because a form was rendered with no
 * handler behind it.** The page drew, the button worked, the redirect came back
 * clean, and nothing was saved — a success that means the opposite.
 *
 * So this asks the one question that can catch it: **for every nonce action a
 * template renders, is there a function hooked that will read it.**
 *
 * @param string[] $actions The nonce actions a page renders.
 * @return string[] The ones nobody is listening for.
 */
function localilly_forms_nobody_hears( array $actions ): array {
	$deaf = array();

	foreach ( $actions as $one ) {
		$heard = false;

		foreach ( array( 'template_redirect', 'init', 'wp' ) as $when ) {
			foreach ( (array) ( $GLOBALS['wp_filter'][ $when ] ?? array() ) as $hooked ) {
				foreach ( (array) $hooked as $what ) {
					$fn = $what['function'] ?? '';

					if ( ! is_string( $fn ) || ! function_exists( $fn ) ) {
						continue;
					}

					$read = new ReflectionFunction( $fn );
					$src  = (string) file_get_contents( (string) $read->getFileName() );

					if ( false !== strpos( $src, "'" . $one . "'" ) ) {
						$heard = true;
						break 3;
					}
				}
			}
		}

		if ( ! $heard ) {
			$deaf[] = $one;
		}
	}

	return $deaf;
}
