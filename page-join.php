<?php
/**
 * Template Name: The Door
 *
 * Where every path leads on Sunday, when there is nobody to find yet.
 *
 * It never says no results. It names what was being looked for and offers the
 * way in — her own Empty Search That Answers, at the front of the site.
 *
 * **No child leaves their details here.** This is the neighbour's road.
 *
 * IT ONCE SAID THE ADULT WHO PAYS OPENS THE ACCOUNT AND CALLED THAT HER SETTLED
 * DESIGN. She struck it on 30 August — a young person's business is her own and
 * she holds it — and the strike reached one file while the claim stood in four
 * others. **A ruling applied in one place is not applied.**
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

$localilly_doing = localilly_pressed();
$localilly_eight = localilly_the_eight();
$localilly_named = $localilly_doing ? $localilly_eight[ $localilly_doing ] : '';
$localilly_thanks = isset( $_GET['thankyou'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

/*
 * ── WHAT SHE TYPED COMES WITH HER ─────────────────────────────────────
 *
 * The search on the front page sends what a neighbour typed, and this page read
 * neither field. **And the field was named `s`, which is WordPress's own search
 * parameter, so every search 301'd away before it ever arrived here.** Two
 * faults stacked: the words were dropped, and they never reached the page that
 * dropped them. **A neighbour typed lawn mowing and Preston, pressed the button, and
 * met a page that said neither word back to her** — her own two words thrown
 * away between one screen and the next.
 *
 * Know Where hit the same shape an hour ago and named it: an answer sitting on
 * the page while the person's own words were dropped on the way to it.
 *
 * So the heading is built from what she gave. **Anything she typed is used and
 * nothing she typed is trusted** — the suburb is escaped and never queried, and
 * the work is matched against the eight rather than echoed raw, so a search box
 * can put a word on her screen and never a sentence of somebody else's.
 */
$localilly_typed  = isset( $_GET['needs'] ) ? sanitize_text_field( wp_unslash( $_GET['needs'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$localilly_suburb = isset( $_GET['where'] ) ? sanitize_text_field( wp_unslash( $_GET['where'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

/* A typed search matched to one of her eight, so the heading names her work. */
if ( ! $localilly_named && $localilly_typed ) {
	foreach ( $localilly_eight as $localilly_label ) {
		if ( false !== stripos( $localilly_label, $localilly_typed ) || false !== stripos( $localilly_typed, $localilly_label ) ) {
			$localilly_named = $localilly_label;
			break;
		}
	}
}

/* Where she said, in her own words, trimmed to a suburb's length. */
$localilly_where = $localilly_suburb ? mb_substr( $localilly_suburb, 0, 40 ) : '';

get_header();
?>

<section class="sec sec--door">
	<div class="in">

		<?php if ( $localilly_thanks ) : ?>

			<h1 class="head lift float">Thank you. We have you.</h1>
			<p class="body body--wide float">
				You will hear from us the moment LocaLilly opens near you.
				One letter, from us alone, about this alone.
			</p>
			<p class="body body--wide float">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Back To The Front</a>
			</p>

		<?php else : ?>

			<?php if ( $localilly_named ) : ?>
				<?php
				/*
				 * ── AN EMPTY STATE WAITS RATHER THAN APOLOGISES ───────────
				 *
				 * This read *Nobody is doing Lawn Mowing in your street yet.*
				 * It opens on a negative and names the absence, and both are
				 * hers to forbid — **naming a lack plants it**, and a person
				 * arriving keen reads it as a reason to leave.
				 *
				 * The information is identical. The direction is opposite:
				 * the work is waiting for its first young person rather than
				 * missing one.
				 *
				 * HER SECOND CORRECTION, AND IT IS ABOUT SCOPE RATHER THAN
				 * TONE: **we don't just offer them the street.** A young
				 * person works the neighbourhood around them, so promising
				 * one street is both smaller than the truth and smaller than
				 * the business. Near you, rather than in your street.
				 *
				 * The word street keeps every other job it has here — the
				 * street a young person gives, the street a neighbour's first
				 * word carries, the street on the map. **Those are about
				 * where somebody is. This one was about what is offered**,
				 * and only that one was wrong.
				 *
				 * Her shape for these, from Nan Made's dashboard: it waits
				 * with the person rather than apologising, and it never once
				 * says the word empty.
				 */
				printf(
					'<h1 class="head lift float">%s</h1>',
					esc_html(
						sprintf(
							/* translators: %s: one of her eight, in her words. */
							$localilly_where
								/* translators: 1: one of her eight, 2: their suburb. */
								? __( '%1$s Is Waiting For Its First Professional In %2$s.', 'localilly' )
								/* translators: %s: one of her eight, in her words. */
								: __( '%1$s Is Waiting For Its First Professional Near You.', 'localilly' ),
							wp_strip_all_tags( $localilly_named ),
							$localilly_where
						)
					)
				);
				?>
				<p class="body body--wide float">
					Which is exactly why we are here.
				</p>
			<?php else : ?>
				<?php if ( $localilly_where ) : ?>
					<h1 class="head lift float"><?php
						printf(
							/* translators: %s: their suburb, as they typed it. */
							esc_html__( 'LocaLilly Is On Its Way To %s.', 'localilly' ),
							esc_html( $localilly_where )
						);
					?></h1>
				<?php else : ?>
					<h1 class="head lift float">Find Somebody Close To You.</h1>
				<?php endif; ?>
				<p class="body body--wide float">
					Search your suburb and read real professionals nearby, in their
					own words.
				</p>
			<?php endif; ?>

			<?php
			/*
			 * ── SOMEBODY TO FIND, AT LAST ─────────────────────────────
			 *
			 * Until 25 August this page could only ever answer with her
			 * Empty Search That Answers, because no query for a young
			 * person existed anywhere in the theme. **The warm empty state
			 * was the only state.**
			 *
			 * Her words above stay exactly as they are and now belong to
			 * the case they were written for.
			 */
			$localilly_found = localilly_find( (string) $localilly_where, (string) $localilly_doing );
			?>
			<?php if ( $localilly_found ) : ?>
				<section class="found">
					<h2 class="found-head">
						<?php
						echo esc_html(
							$localilly_named
								? sprintf( '%s, Close To You', wp_strip_all_tags( $localilly_named ) )
								: 'Close To You'
						);
						?>
					</h2>
					<ul class="found-list">
						<?php foreach ( $localilly_found as $localilly_them ) : ?>
							<?php localilly_one_of_them( $localilly_them ); ?>
						<?php endforeach; ?>
					</ul>
					<p class="found-after">Every professional here is verified before she's ever listed, so who you're reaching out to is never a guess.</p>
				</section>
			<?php endif; ?>

			<?php
			/*
			 * ── THE DOORS CLOSE ONCE THERE IS SOMEBODY TO FIND ────────
			 *
			 * Her words, 30 August: **why those two screens? I never told you
			 * to put those there under Zac.**
			 *
			 * These are the two forms from the days when a search could only
			 * ever find nobody — leave your details and we will write when
			 * somebody is near you. **Now there is somebody near her, and she
			 * met a young person and then two sign-up forms underneath him.**
			 *
			 * A person who has found what they came for is finished. So the
			 * doors show only where the search found nobody, which is the one
			 * case they were written for.
			 */
			?>
			<?php if ( ! $localilly_found ) : ?>
			<div class="doors">

				<?php localilly_the_word_on_screen(); ?>
				<form class="door plate float" method="post">
					<?php wp_nonce_field( 'localilly_door', 'localilly_nonce' ); ?>
					<input type="hidden" name="localilly_door" value="1">
					<input type="hidden" name="side" value="young">
					<input type="hidden" name="doing" value="<?php echo esc_attr( $localilly_doing ); ?>">

					<?php
					/*
					 * ── STRUCK BY HER, 30 AUGUST ──────────────────────────
					 *
					 * This read: **a parent or the adult who will hold the
					 * account leaves their details**, and the young person is
					 * invited in from there.
					 *
					 * Her words: *what's this for a young person, 15? No, it's
					 * not. Get that off there.*
					 *
					 * **LocaLilly is a young person's own business, in her own
					 * name, and she holds it.** An adult owning the account
					 * with the young person underneath is a different world
					 * and it was never hers.
					 *
					 * And it had quietly answered her open age question by
					 * putting a parent on the account. **That question is
					 * still open and it is hers.**
					 */
					?>

					<label class="vh" for="y-name">Your First Name</label>
					<input class="seek-in" id="y-name" name="name" type="text" required
						placeholder="Your first name">
					<label class="vh" for="y-last">Your Family Name</label>
					<input class="seek-in" id="y-last" name="last_name" type="text"
						placeholder="Your family name">
					<?php localilly_who_sees( 'name' ); ?>
					<label class="vh" for="y-email">Your Email</label>
					<input class="seek-in" id="y-email" name="email" type="email" required
						placeholder="Your email">
					<label class="vh" for="y-suburb">Your Suburb</label>
					<input class="seek-in" id="y-suburb" name="suburb" type="text"
						placeholder="Your suburb">

					<?php
					/*
					 * 31 August 2026 — dropped the house-number/street fields
					 * entirely. Those existed for LocaLilly's child-safety
					 * model (being able to reach a minor in person); nothing
					 * about that reasoning applies to an adult professional
					 * marketplace, and asking for it here would read as
					 * intrusive rather than caring.
					 */
					?>

					<button class="press" type="submit">Start My Profile</button>
					<p class="door-small">
						$29 a month. First month free.
					</p>
				</form>

				<form class="door plate float" method="post">
					<?php wp_nonce_field( 'localilly_door', 'localilly_nonce' ); ?>
					<input type="hidden" name="localilly_door" value="1">
					<input type="hidden" name="side" value="neighbour">
					<input type="hidden" name="doing" value="<?php echo esc_attr( $localilly_doing ); ?>">


					<label class="vh" for="n-name">Your Name</label>
					<input class="seek-in" id="n-name" name="name" type="text" required
						placeholder="Your name">
					<label class="vh" for="n-email">Your Email</label>
					<input class="seek-in" id="n-email" name="email" type="email" required
						placeholder="Your email">
					<label class="vh" for="n-suburb">Your Suburb</label>
					<input class="seek-in" id="n-suburb" name="suburb" type="text"
						placeholder="Your suburb">
					<button class="press" type="submit">Find Someone Close</button>
					<p class="door-small">
						Every professional here is verified before you can message her.
						<a href="<?php echo esc_url( home_url( '/layers-of-safety/' ) ); ?>">Here Is Why</a>.
					</p>
				</form>

			</div>
			<?php endif; ?>

			<?php
			/*
			 * 31 August 2026 — "Or another kind of work" pulled from
			 * localilly_the_eight(), which is still Lawn Mowing / Elder
			 * Companions / Babysitting under the hood. Dropped rather than
			 * shown wrong twice in one page; the real eight (Admin,
			 * Strategy, Design...) can come back here once that shared
			 * function is repointed properly.
			 */
			?>

		<?php endif; ?>

	</div>
</section>

<?php
get_footer();
