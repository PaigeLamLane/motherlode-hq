<?php
/**
 * Template Name: Your Place
 *
 * A neighbour's own account, and the people they are keeping for later.
 *
 * HER EXAMPLE IS THE DESIGN: I'd really like your help with my daughter's
 * birthday, but that's not for six months. **So keeping somebody carries a
 * reason and a when**, and six months later the note still makes sense to the
 * person who wrote it.
 *
 * AND IT SAYS WHAT IS TRUE ABOUT REACHING ANYBODY. Her dollar verification
 * comes before a neighbour may search or message, and nobody has built a
 * payment road yet. So this keeps their list and promises no more than that.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

$localilly_place = localilly_their_place();
$localilly_kept  = localilly_kept_by( $localilly_place );
$localilly_who   = $localilly_place ? (string) get_post_meta( $localilly_place->ID, '_ll_name', true ) : '';
$localilly_where = $localilly_place ? (string) get_post_meta( $localilly_place->ID, '_ll_suburb', true ) : '';
?>

<main class="place">

	<?php if ( ! $localilly_place ) : ?>

		<?php
		/*
		 * Her own door first. A person who already has a place must never be
		 * offered a second one before they have been offered their own —
		 * a second place holds no dollar, no letters and nobody they kept.
		 */
		localilly_offer_the_way_back();
		?>

		<p class="place-eyebrow">If You Live Nearby</p>
		<h1 class="build-ask">Keep The People You Like</h1>
		<p class="build-why">A young person who was brilliant in March is somebody you will want again in September. Keep them here, with a note saying what for, and it will still make sense when you come back to it.</p>

		<?php localilly_the_word_on_screen(); ?>
		<form class="build-form" method="post">
			<?php wp_nonce_field( 'localilly_place', 'localilly_place' ); ?>
			<input type="hidden" name="localilly_place_moment" value="begin">
			<label class="ask">
				<span>Your First Name</span>
				<input type="text" name="name" maxlength="40" required placeholder="Margaret" autocomplete="given-name">
			</label>
			<label class="ask">
				<span>Your Suburb</span>
				<input type="text" name="suburb" maxlength="60" required placeholder="Preston">
			</label>
			<label class="ask">
				<span>Your Email, If You Would Like Us To Write</span>
				<input type="email" name="email" maxlength="120" placeholder="so we can tell you when somebody nearby is listed">
			</label>
			<button type="submit" class="room-go press">Make My Place</button>
		</form>

	<?php else : ?>

		<?php
		/*
		 * ── A NEIGHBOUR'S OWN PLACE ───────────────────────────────────
		 *
		 * Her ruling, said many times before it was built: **a community
		 * person needs an account — to save it, to keep the people they
		 * like, to keep their messaging.**
		 *
		 * It held a name and a list of kept people. It never showed whether
		 * her dollar was in, and it never showed a single conversation.
		 *
		 * No sign-in and nothing to invent: the dollar makes the account,
		 * her name and email come from her own receipt, and a key in her
		 * browser brings her back.
		 */
		$localilly_verified = '' !== (string) get_post_meta( $localilly_place->ID, '_ll_verified', true );
		$localilly_key      = (string) get_post_meta( $localilly_place->ID, '_ll_key', true );
		$localilly_talk     = ( '' !== $localilly_key && class_exists( 'Lamoureux_Messages' ) )
			? localilly_letters_for( 'neighbour:' . $localilly_key )
			: array();
		?>

		<?php
		/*
		 * ── HER ROOM, REBUILT 30 AUGUST ───────────────────────────────────
		 *
		 * Her words: **it is not a dashboard. You have seen Nan Made.**
		 *
		 * I had. What Nan Made does and this did not: **it is a room named for
		 * the woman standing in it** — Margaret's Kitchen — and it is furnished
		 * with real work she can touch. Orders with names and amounts. Her
		 * hours, which she opens and closes. Her badges. The support waiting
		 * for her. Every card gives her something.
		 *
		 * This counted at her instead. Yes, your name is on it. One letter.
		 * Nought people. **A report about a person, handed to that person.**
		 *
		 * So: her name over the door, and cards holding what she actually came
		 * for — the young people she is talking to, the ones she would ask
		 * again, and who is near her now.
		 */
		?>
		<?php
		/*
		 * The suburb is the line above the door, and it draws only when she
		 * has given one. **A room whose title and eyebrow say the same words
		 * has said it twice**, which is her law about repetition breaking on
		 * the first screen a person meets.
		 */
		?>
		<?php if ( '' !== $localilly_where ) : ?>
			<p class="place-eyebrow"><?php echo esc_html( $localilly_where ); ?></p>
		<?php endif; ?>
		<h1 class="room-name"><?php
			echo esc_html( $localilly_who ? $localilly_who . '&rsquo;s Neighbourhood' : 'Your Neighbourhood' );
		?></h1>


		<?php
		/*
		 * ── HER LETTERS COME BEFORE HER CHORES ────────────────────────────
		 *
		 * The room opened on three cards asking her for a name, a password and
		 * an address, and her letters sat under all of it. **A room that opens
		 * on three tasks is asking for work rather than handing it over**, and
		 * her joy law is that nothing adds to a person's load.
		 *
		 * What she came for is first. The asking waits below it, and each one
		 * disappears the moment it is answered.
		 */
		?>
		<section class="room-card">
			<h2 class="room-head">Your Letters</h2>
			<?php if ( $localilly_talk ) : ?>
				<ul class="room-rows">
					<?php foreach ( array_slice( $localilly_talk, 0, 10 ) as $localilly_one ) : ?>
						<?php
						$localilly_me    = 'neighbour:' . $localilly_key;
						$localilly_about = absint( (string) ( $localilly_one['about'] ?? 0 ) );
						$localilly_them  = $localilly_about ? (string) get_post_meta( $localilly_about, '_ll_name', true ) : '';
						$localilly_mine  = strtolower( (string) ( $localilly_one['sender'] ?? '' ) ) === strtolower( $localilly_me );
						localilly_it_has_been_read( $localilly_one, $localilly_me );
						?>
						<li class="room-row">
							<p class="room-row-who"><?php
								echo esc_html( '' === $localilly_them ? 'A young person' : ( $localilly_mine ? 'To ' . $localilly_them : $localilly_them . ' wrote back' ) );
							?></p>
							<p class="room-row-words"><?php echo esc_html( wp_trim_words( (string) ( $localilly_one['words'] ?? '' ), 26 ) ); ?></p>
							<?php localilly_what_became_of_it( $localilly_one, $localilly_mine ); ?>
							<?php if ( $localilly_about ) : ?>
								<a class="room-row-go" href="<?php echo esc_url( (string) get_permalink( $localilly_about ) ); ?>">Write To <?php echo esc_html( $localilly_them ); ?> Again</a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="room-empty">Every young person you write to lands here, with what they said back, so you always know where you left off.</p>
			<?php endif; ?>
		</section>

		<?php
		/*
		 * STRUCK: this asked for a password, and the one moment below asks for
		 * it again. **Two cards on one screen wanting the same answer**, which
		 * is her law about repetition breaking in the worst place — a person
		 * cannot tell which one the site actually wants.
		 */
		?>

		<?php
		/*
		 * ── ONE MOMENT, RATHER THAN THREE CARDS SAYING THAT IS ME ─────────
		 *
		 * Her words: **get all this That Is Me off there. If they type their
		 * name in, you should just keep it. What a stupid thing.**
		 *
		 * She met three cards, each with its own button, each asking her to
		 * confirm she was herself. **And the first had no handler at all** —
		 * the form drew, the button worked, the page came back clean, and her
		 * name was never saved. She typed it and the site forgot her, every
		 * time, which is why nothing anywhere knew her name.
		 *
		 * A form that posts into the void looks exactly like a form that
		 * works. The same shape as her three payments: every part reporting
		 * success while nothing happened.
		 *
		 * One moment now, asking only what is missing, keeping all of it in a
		 * single act, and gone the moment it is answered.
		 */
		localilly_the_one_moment( $localilly_place->ID );
		?>

		<?php
		/*
		 * Her page about herself, offered where she can see the reason for it.
		 * **A young person reads it before answering her**, which is the only
		 * argument that matters and the one written on the card.
		 */
		$localilly_about = (string) get_post_meta( $localilly_place->ID, '_ll_about', true );
		?>
		<section class="room-card<?php echo '' === $localilly_about ? ' room-card--ask' : ''; ?>">
			<h2 class="room-head">Your Own Page</h2>
			<?php if ( '' !== $localilly_about ) : ?>
				<p class="room-row-words"><?php echo esc_html( wp_trim_words( $localilly_about, 34 ) ); ?></p>
				<a class="room-go press" href="<?php echo esc_url( home_url( '/about-you/' ) ); ?>">Change It</a>
			<?php else : ?>
				<p class="room-empty">A young person reads about you before they answer you. Six moments, in your own words, and every one of them yours to change.</p>
				<a class="room-go press" href="<?php echo esc_url( home_url( '/about-you/' ) ); ?>">Write Your Page</a>
			<?php endif; ?>
		</section>

		<?php localilly_offer_them_their_face(); ?>

		<?php
		/*
		 * ── HER SEARCH, FROM HER OWN ROOM ─────────────────────────────────
		 *
		 * Her ruling, 30 August: **they should have a search from there.**
		 *
		 * A neighbour standing in her own room wanting a gutter cleared had to
		 * leave it and go back to the front of the site. **Her room now finds
		 * people from inside itself**, and it carries her suburb already
		 * filled, so the common case is one word and a press.
		 */
		?>
		<section class="room-card room-card--find">
			<h2 class="room-head">Find Somebody</h2>
			<form class="room-find" method="get" action="<?php echo esc_url( home_url( '/join/' ) ); ?>">
				<label class="vh" for="room-needs">What you need</label>
				<input class="seek-in" id="room-needs" name="needs" type="search"
					placeholder="A lawn, a car, an afternoon with your mum">
				<label class="vh" for="room-where">Where</label>
				<input class="seek-in" id="room-where" name="where" type="text"
					value="<?php echo esc_attr( $localilly_where ); ?>" placeholder="Your suburb">
				<button class="room-go press" type="submit">Find Somebody Close</button>
			</form>
		</section>

		<?php
		/*
		 * ── HER FAVOURITES, PINNED ────────────────────────────────────────
		 *
		 * Her ruling, the same breath: **they should have their favourites
		 * pinned there.**
		 *
		 * The people she has chosen sit at the top of her room as her own
		 * plates, rather than in a list underneath the letters. **A person she
		 * would ask again is the reason she came back**, so it is the first
		 * warm thing she meets.
		 */
		?>
		<?php if ( $localilly_kept ) : ?>
			<section class="room-card room-card--pinned">
				<h2 class="room-head">Pinned</h2>
				<ul class="pinned">
					<?php foreach ( array_slice( $localilly_kept, 0, 8 ) as $localilly_one ) : ?>
						<?php
						$localilly_pin  = (string) ( $localilly_one['who'] ?? '' );
						$localilly_them = localilly_by_that_name( $localilly_pin );
						?>
						<li class="pinned-one">
							<?php if ( $localilly_them ) : ?>
								<a class="pinned-go" href="<?php echo esc_url( (string) get_permalink( $localilly_them ) ); ?>">
									<span class="pinned-name">Local<span class="say"><?php echo esc_html( $localilly_pin ); ?></span></span>
									<span class="pinned-why"><?php echo esc_html( (string) ( $localilly_one['why'] ?? '' ) ); ?></span>
									<span class="pinned-ask">Ask Them Again</span>
								</a>
							<?php else : ?>
								<span class="pinned-go pinned-go--flat">
									<span class="pinned-name"><?php echo esc_html( $localilly_pin ); ?></span>
									<span class="pinned-why"><?php echo esc_html( (string) ( $localilly_one['why'] ?? '' ) ); ?></span>
									<?php if ( ! empty( $localilly_one['when'] ) ) : ?>
										<span class="pinned-ask"><?php echo esc_html( (string) $localilly_one['when'] ); ?></span>
									<?php endif; ?>
								</span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		/*
		 * ── THE LETTERS, WHICH ARE WHY SHE CAME ───────────────────────────
		 *
		 * Nan Made puts real orders with real names on her screen. This puts
		 * real letters with the young person's name, her own words, what became
		 * of them, and the road straight back to writing again.
		 */
		?>

		<?php
		/*
		 * ── STRUCK BY HER, 30 AUGUST ──────────────────────────────────────
		 *
		 * A card here listed every young person near her suburb, so her own
		 * room filled with strangers she had never spoken to.
		 *
		 * Her words: **do not just keep people who are close to them; they
		 * have to have saved them. And anyway, when they've said something.**
		 *
		 * **Her room holds people she has a road to** — somebody she wrote to,
		 * somebody who answered her, somebody she chose to keep. Searching
		 * finds the rest, and that is the front of the site rather than her own
		 * account. A room filled by a postcode is a listing wearing her name.
		 */
		?>
		<?php
		/*
		 * The pinned plates above hold these now, so this says the invitation
		 * once and never the list twice. Her law about repetition.
		 */
		?>
		<?php if ( ! $localilly_kept ) : ?>
			<section class="room-card">
				<h2 class="room-head">Ask Again</h2>
				<p class="room-empty">A young person who was brilliant in March is somebody you will want again in September. Ask them again from here, and it takes one tap.</p>
			</section>
		<?php endif; ?>

		<form class="room-card room-card--ask place-keep" method="post">
			<?php wp_nonce_field( 'localilly_place', 'localilly_place' ); ?>
			<input type="hidden" name="localilly_place_moment" value="keep">
			<h2 class="room-head">Somebody To Ask Again</h2>
			<label class="ask">
				<span>Who</span>
				<input type="text" name="who" maxlength="60" required placeholder="Zac, who mows">
			</label>
			<label class="ask">
				<span>What For</span>
				<input type="text" name="why" maxlength="120" placeholder="Amelia&rsquo;s birthday — party help">
			</label>
			<label class="ask">
				<span>When</span>
				<input type="text" name="when" maxlength="60" placeholder="March, or whenever suits">
			</label>
			<button type="submit" class="room-go press">Ask Them Again</button>
		</form>

		<?php
		/*
		 * ── ASKED ONLY OF SOMEBODY WHO HAS YET TO PAY ─────────────────────
		 *
		 * Her words, over and over: **I've already paid my dollar. Why am I
		 * having to pay again.**
		 *
		 * This drew on every neighbour's own place regardless, so the screen
		 * that proves her name is on it sat two inches above a button asking
		 * her to put her name to it. **Her account itself was asking her to
		 * pay a fourth time.**
		 *
		 * AND IT OPENED ON A BANNED WORD. One Thing Before You Write — the
		 * first word on her laws, on her own account screen, for days.
		 */
		if ( ! $localilly_verified ) :
			$localilly_money = localilly_can_money_move();
			?>
			<div class="place-dollar plate">
				<p class="place-dollar-word">Before Your First Letter</p>
				<p>A dollar on your own card, once, so a young person arriving for your Saturday knows exactly who asked for them.</p>
				<a class="place-dollar-go press" href="<?php echo esc_url( home_url( '/the-dollar/' ) ); ?>"><?php echo $localilly_money['whole'] ? 'Put My Name To It' : 'Read Why We Ask'; ?></a>
			</div>
		<?php endif; ?>

	<?php endif; ?>

</main>

<?php
get_footer();
