<?php
/**
 * Template Name: About You
 *
 * A neighbour writes their own profile, the way a young person writes theirs.
 *
 * ── HER RULING, 30 AUGUST ─────────────────────────────────────────────────
 *
 * Her words: **the neighbour, as well as the young person, should be setting a
 * beautiful profile in this. It tells them about themselves.**
 *
 * WHY IT MATTERS MORE HERE THAN ANYWHERE. A fifteen-year-old writes about
 * herself in her own words, names what she is good at, says when she is free
 * and puts her street on a page before anybody can find her. **The adult
 * walking toward her gave a first name and a card.**
 *
 * That is backwards on a world where adults meet children, and it is the third
 * time today the same imbalance has been found. Her surname and address closed
 * one half of it. **This closes the other: the young person gets to read a
 * person rather than a payment.**
 *
 * AND IT IS THE MOMENTS RATHER THAN A FORM. Six, one at a time, on the same
 * machinery her own atelier runs on. **The profile is assembled from what she
 * typed and then handed straight back to her to rewrite entirely** — her
 * autonomy law, and the reason nothing here can put a word in her mouth.
 *
 * HER TRUTH LAW GOVERNS THE ASSEMBLING. Every line is built only from an answer
 * she actually gave, and an empty answer produces an empty line rather than an
 * invented one. **A sentence nobody wrote is a false statement about the person
 * it is attributed to**, and a false warm sentence about an adult is exactly
 * the wrong thing to hand a child.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

$localilly_place = localilly_their_place();
$localilly_who   = $localilly_place ? (string) get_post_meta( $localilly_place->ID, '_ll_name', true ) : '';
$localilly_said  = $localilly_place ? (string) get_post_meta( $localilly_place->ID, '_ll_about', true ) : '';

get_header();
?>

<main class="atelier" id="about-you"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'localilly_about_you' ) ); ?>">

	<?php if ( ! $localilly_place ) : ?>

		<p class="atelier-mark">About You</p>
		<p class="room-empty">Your own page opens once you have written to somebody. Find a young person near you and it begins there.</p>
		<a class="room-go press" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Find Somebody Close</a>

	<?php else : ?>

		<p class="atelier-mark"><?php
			echo $localilly_who ? 'Local <span class="say">' . esc_html( $localilly_who ) . '</span>' : 'About You';
		?></p>

		<p class="atelier-rate">A young person reads this before they answer you. <strong>Your street stays with us</strong> &mdash; they see your first name, your suburb, and whatever you write here.</p>

		<?php localilly_the_word_on_screen(); ?>

		<form class="atelier-steps" id="about-steps" novalidate>

			<section class="moment is-here" data-moment="1">
				<h1 class="moment-ask">Who Is At Home?</h1>
				<p class="moment-why">A young person turning up at your gate likes knowing who opens the door.</p>
				<div class="moment-plates">
					<button type="button" class="plate press pick" data-name="who" aria-pressed="false" data-value="It is just me">Just Me</button>
					<button type="button" class="plate press pick" data-name="who" aria-pressed="false" data-value="There are two of us">The Two Of Us</button>
					<button type="button" class="plate press pick" data-name="who" aria-pressed="false" data-value="We are a family, and the little ones are usually about">A Family</button>
					<button type="button" class="plate press pick" data-name="who" aria-pressed="false" data-value="I look after my mum, and she is here too">Somebody I Care For</button>
				</div>
				<label class="moment-own">
					<span>Or Say It Your Own Way</span>
					<input type="text" data-name="whoOwn" maxlength="90" placeholder="Me, my husband, and a very old cat">
				</label>
				<button type="button" class="press go" data-next>Next</button>
			</section>

			<section class="moment" data-moment="2">
				<h1 class="moment-ask">What Is Your Place Like?</h1>
				<p class="moment-why">The kind of detail that turns a maybe into a yes, and lets somebody arrive ready.</p>
				<div class="moment-plates">
					<button type="button" class="plate press pick" data-name="place" aria-pressed="false" data-value="a good-sized garden, front and back">A Real Garden</button>
					<button type="button" class="plate press pick" data-name="place" aria-pressed="false" data-value="a small courtyard, so nothing takes long">Small And Easy</button>
					<button type="button" class="plate press pick" data-name="place" aria-pressed="false" data-value="a friendly dog who will follow you around">A Friendly Dog</button>
					<button type="button" class="plate press pick" data-name="place" aria-pressed="false" data-value="a mower and everything else in the shed, yours to use">Tools In The Shed</button>
				</div>
				<label class="moment-own">
					<span>Or Your Own Words</span>
					<input type="text" data-name="placeOwn" maxlength="90" placeholder="Steep out the back, so wear proper shoes">
				</label>
				<button type="button" class="press go" data-next>Next</button>
			</section>

			<section class="moment" data-moment="3">
				<h1 class="moment-ask">What Do You Usually Need?</h1>
				<p class="moment-why">Say it once here and you never have to explain it again.</p>
				<div class="moment-plates">
					<?php foreach ( localilly_the_eight() as $localilly_label ) : ?>
						<button type="button" class="plate press pick" data-name="need" aria-pressed="false" data-value="<?php echo esc_attr( wp_strip_all_tags( $localilly_label ) ); ?>"><?php echo wp_kses_post( $localilly_label ); ?></button>
					<?php endforeach; ?>
				</div>
				<label class="moment-own">
					<span>Or Another Kind Of Help</span>
					<input type="text" data-name="needOwn" maxlength="90" placeholder="An hour of company for my dad on a Thursday">
				</label>
				<button type="button" class="press go" data-next>Next</button>
			</section>

			<section class="moment" data-moment="4">
				<h1 class="moment-ask">How Do You Like To Pay?</h1>
				<p class="moment-why">Said plainly here, so a young person never has to raise it with you.</p>
				<div class="moment-plates">
					<button type="button" class="plate press pick" data-name="pay" aria-pressed="false" data-value="cash on the day, the moment you finish">Cash On The Day</button>
					<button type="button" class="plate press pick" data-name="pay" aria-pressed="false" data-value="a bank transfer the same evening">Transfer That Evening</button>
					<button type="button" class="plate press pick" data-name="pay" aria-pressed="false" data-value="whichever suits you best">Whichever Suits You</button>
				</div>
				<label class="moment-own">
					<span>Or Your Own Way</span>
					<input type="text" data-name="payOwn" maxlength="90" placeholder="Cash, and a cold drink while you are here">
				</label>
				<button type="button" class="press go" data-next>Next</button>
			</section>

			<section class="moment" data-moment="5">
				<h1 class="moment-ask">Anything You Would Like Them To Know?</h1>
				<p class="moment-why">A line in your own voice. This is the part a young person reads twice.</p>
				<label class="moment-own">
					<span>In Your Own Words</span>
					<textarea data-name="ownWords" rows="4" maxlength="320" placeholder="I have lived on this street thirty years and I still cannot keep on top of the hedge."></textarea>
				</label>
				<button type="button" class="press go" data-next>Next</button>
			</section>

			<section class="moment" data-moment="6">
				<h1 class="moment-ask">Here You Are</h1>
				<p class="moment-why">Written from what you gave, and only that. Change any word of it &mdash; it is yours.</p>
				<textarea class="letter" id="about-letter" rows="10"><?php echo esc_textarea( $localilly_said ); ?></textarea>
				<button type="button" class="press go" id="about-keep">Keep It</button>
				<p class="atelier-after">A young person reads this the moment your letter reaches them.</p>
			</section>

		</form>

	<?php endif; ?>

</main>

<?php
get_footer();
