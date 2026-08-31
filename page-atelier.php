<?php
/**
 * Template Name: LocaZac
 *
 * The first word a neighbour ever writes to a young person.
 *
 * HER RULING, 23 AUGUST 2026, AND IT NAMED ITSELF. Use Loca — we have
 * LocaLilly, so put LocaZac. The brand becomes the person, and it was already
 * on her own front page: the young man raking leaves wears a shirt reading
 * LocalZac. She remembered the shirt before she remembered the site.
 *
 * WHY IT EXISTS, IN HER WORDS. The more accurate the neighbour is, the better
 * the young person can answer. So this is here to get real information out of
 * an adult who would otherwise type hi are you free — and to make doing that
 * feel like a pleasure rather than a form.
 *
 * FOUR OF HER LAWS DECIDE EVERY LINE BELOW.
 *
 * The moments law. Six moments, one at a time, never a page of fields.
 *
 * The autonomy law. The letter is assembled from what she typed and then handed
 * over to be changed. Language is offered; she chooses, edits, approves or
 * rejects.
 *
 * The truth law. The letter carries what the neighbour actually gave and never
 * a word more. An invented sentence about a person is a false statement.
 *
 * And her ruling that this is no auction. **A neighbour never names a price.**
 * The young person sets their own rate and it sits on their profile, read
 * before the first word is written. Her words: this isn't AirTasker.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/*
 * A REAL PAGE ARRIVES CARRYING SOMEBODY'S NAME. THIS ONE DOES NOT, ON PURPOSE.
 *
 * Her ruling, 23 August 2026: remove Zac as an actual. Until a young person is
 * a real record there is nobody to name, and **a named example is still a
 * person to a stranger** who arrived here from a search result.
 *
 * The name is accepted and sanitised so the day listings land this template
 * changes not at all. With none given, every line falls back to a role.
 */
$localilly_to = isset( $_GET['to'] ) ? sanitize_text_field( wp_unslash( $_GET['to'] ) ) : '';
$localilly_to = $localilly_to ? ucfirst( strtolower( preg_replace( '/[^a-z]/i', '', $localilly_to ) ) ) : '';

$localilly_real = '' !== $localilly_to;
$localilly_them = $localilly_real ? $localilly_to : 'them';
$localilly_they = $localilly_real ? 'he' : 'they';
$localilly_mark = $localilly_real ? 'Local <span class="say">' . esc_html( $localilly_to ) . '</span>' : 'The First Word';

get_header();
?>

<main class="atelier" id="atelier"
	data-name="<?php echo esc_attr( $localilly_them ); ?>"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'localilly_first_word' ) ); ?>">

	<?php if ( ! $localilly_real ) : ?>
		<?php get_template_part( 'example-ribbon', null, array( 'says' => 'This is how a neighbour writes their first word.' ) ); ?>
	<?php endif; ?>

	<p class="atelier-mark"><?php echo wp_kses_post( $localilly_mark ); ?></p>

	<?php
	/*
	 * The rate, read before a word is written. Her ruling: the young person
	 * decides what they charge and their profile carries the guide. A neighbour
	 * arriving already knowing it never has to ask, and never gets to haggle.
	 */
	?>
	<p class="atelier-rate"><?php echo esc_html( ucfirst( $localilly_them ) ); ?> ask<?php echo $localilly_real ? 's' : ''; ?> <strong>$25 an hour</strong>, and $40 for a lawn. Read before you write, so the price is never a conversation.</p>

	<?php localilly_the_word_on_screen(); ?>
	<form class="atelier-steps" id="steps" novalidate>

		<section class="moment is-here" data-moment="1">
			<h1 class="moment-ask">What Needs Doing?</h1>
			<p class="moment-why">Tell <?php echo esc_html( $localilly_them ); ?> the work, and he can answer you in one go.</p>
			<div class="moment-plates" id="doing">
				<?php foreach ( localilly_the_eight() as $localilly_slug => $localilly_label ) : ?>
					<button type="button" class="plate press pick" data-name="doing" aria-pressed="false" data-value="<?php echo esc_attr( $localilly_label ); ?>"><?php echo esc_html( $localilly_label ); ?></button>
				<?php endforeach; ?>
			</div>
			<label class="moment-own">
				<span>Or Say It Your Own Way</span>
				<input type="text" id="doing-own" data-name="doingOwn" maxlength="90" placeholder="The front hedge, gone wild">
			</label>
			<button type="button" class="press go" data-next>Next</button>
		</section>

		<section class="moment" data-moment="2">
			<h1 class="moment-ask">Where Is It?</h1>
			<p class="moment-why">Your street and suburb show on your page, so <?php echo esc_html( $localilly_them ); ?> knows how close you are before he asks.</p>
			<?php localilly_who_sees( 'street' ); ?>
			<label class="moment-own">
				<span>Your Street</span>
				<input type="text" id="street" data-name="street" maxlength="60" placeholder="Wilson Street" autocomplete="off">
			</label>
			<label class="moment-own">
				<span>Your Suburb</span>
				<input type="text" id="suburb" data-name="suburb" maxlength="60" placeholder="Preston" autocomplete="off">
			</label>
			<button type="button" class="press go" data-next>Next</button>
		</section>

		<section class="moment" data-moment="3">
			<h1 class="moment-ask">When Suits You?</h1>
			<p class="moment-why">A young person has school, and telling him when makes a yes far more likely.</p>
			<div class="moment-plates" id="when">
				<button type="button" class="plate press pick" data-name="when" aria-pressed="false" data-value="Saturday morning">Saturday Morning</button>
				<button type="button" class="plate press pick" data-name="when" aria-pressed="false" data-value="Sunday morning">Sunday Morning</button>
				<button type="button" class="plate press pick" data-name="when" aria-pressed="false" data-value="a weekday after school">After School</button>
				<button type="button" class="plate press pick" data-name="when" aria-pressed="false" data-value="the school holidays">School Holidays</button>
			</div>
			<label class="moment-own">
				<span>Or Your Own Words</span>
				<input type="text" id="when-own" data-name="whenOwn" maxlength="70" placeholder="Every second Saturday, if that suits">
			</label>
			<button type="button" class="press go" data-next>Next</button>
		</section>

		<section class="moment" data-moment="4">
			<h1 class="moment-ask">Show <?php echo esc_html( $localilly_them ); ?> The Job</h1>
			<p class="moment-why">One picture and he knows whether it is twenty minutes or a whole morning. Skip it whenever you like.</p>
			<div class="shot" id="shot">
				<input type="file" id="picture" accept="image/*" hidden>
				<button type="button" class="plate press" id="pick-picture">Add A Picture</button>
				<figure class="shot-held" id="held" hidden>
					<img id="held-img" alt="The job, as you photographed it">
					<figcaption id="held-size"></figcaption>
					<button type="button" class="press small" id="drop-picture">Take It Off</button>
				</figure>
			</div>
			<button type="button" class="press go" data-next>Next</button>
		</section>

		<section class="moment" data-moment="5">
			<h1 class="moment-ask">Anything Else He Should Know?</h1>
			<p class="moment-why">A gate that sticks, a dog who is friendly, a mower in the shed. Leave it empty if there is little to add.</p>
			<label class="moment-own">
				<span>In Your Words</span>
				<textarea id="extra" data-name="extra" maxlength="300" rows="4" placeholder="The mower is in the shed and the side gate sticks a little."></textarea>
			</label>
			<button type="button" class="press go" data-next>Next</button>
		</section>

		<section class="moment" data-moment="6">
			<h1 class="moment-ask">Your First Word To <?php echo esc_html( $localilly_them ); ?></h1>
			<p class="moment-why">Written from what you told me. Change every word of it if you like — it goes as you leave it.</p>
			<label class="moment-own">
				<span>Your Name, So They Know Who Is Writing</span>
				<input type="text" id="from" data-name="from" maxlength="40" placeholder="Margaret" autocomplete="off">
			</label>
			<textarea class="letter" id="letter" rows="12"></textarea>
			<button type="button" class="press go send" id="send">Send It To <?php echo esc_html( $localilly_them ); ?></button>
		</section>

	</form>

	<p class="atelier-where" id="where" aria-live="polite"></p>
</main>

<?php
get_footer();
