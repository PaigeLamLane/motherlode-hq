<?php
/**
 * Template Name: The Dollar
 *
 * A neighbour's dollar, and it is a moment rather than a till.
 *
 * HER WORDS CARRY IT AND THEY ARE THE WHOLE REASON IT WORKS: we are committed
 * to community safety, and that starts with a real person behind every account.
 *
 * **It earns while it protects**, which is the cleverest piece of this business
 * and hers. So this screen leads on the young person rather than on the price —
 * a dollar is nothing, and what it buys is a fifteen-year-old knowing exactly
 * who asked for them.
 *
 * WHAT IT SAYS WHEN MONEY CANNOT MOVE YET. The road is honest about itself
 * rather than presenting a button that fails. **A button that cannot work is
 * worse than no button**, because a person who presses it learns the site is
 * broken rather than that it is not open.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

$localilly_asking = motherlode_what_we_ask_for()['the-dollar'];
$localilly_money  = localilly_can_money_move();
?>

<main class="dollar">

	<p class="dollar-eyebrow"><?php echo esc_html( localilly_say( 'm_dollar_eyebrow' ) ?: 'Before You Reach A Young Person' ); ?></p>
	<?php
	/*
	 * ── AUNT TEA'S FAULT, AND I HAD WRITTEN IT TWICE ──────────────────
	 *
	 * She struck a button reading **Send My Money Back** — clear, correct,
	 * polite, and struck in one line. **It passed all three of the wrong tests
	 * and failed the only one that counts: would Paige say this.**
	 *
	 * Mine were *One Dollar, Once, On Your Own Card* and *Verify Me For One
	 * Dollar*. Both are specifications. **A specification is what you write
	 * when you are describing a mechanism to somebody rather than speaking to
	 * them.**
	 *
	 * Her own sentence had the answer in it the whole time: a young person
	 * arriving for your shift **knows exactly who asked for them.** So the
	 * heading is about the young person rather than about the card, and the
	 * button is an idiom a person actually says — putting your name to
	 * something means standing behind it, which is precisely what a dollar on
	 * a real card does.
	 */
	?>
	<h1 class="dollar-title"><?php echo esc_html( localilly_say( 'm_dollar_head' ) ?: 'So They Know Exactly Who Asked' ); ?></h1>

	<?php
	/*
	 * ── CUT TO THE BONE, AT HER WORD ──────────────────────────────────
	 *
	 * She read this and said three things: too small, too wordy, and **a
	 * young person seeing a real name sits oddly right where we ask for a
	 * payment.** She is right about the third and it is the sharpest of them
	 * — a reason a child is safer, printed beside a card field, reads as a
	 * business explaining itself at the till.
	 *
	 * So the reason lives in the heading, where it belongs, and the payment
	 * point carries only what a person needs to press it. **Three benefits
	 * listed above a button is a brochure. One sentence is an answer.**
	 */
	?>
	<p class="dollar-says"><?php echo esc_html( localilly_say( 'm_dollar_short' ) ?: 'One dollar, once, on your own card. It takes seconds, and it means every account here belongs to a real person.' ); ?></p>

	<?php if ( $localilly_money['whole'] ) : ?>

		<?php localilly_the_word_on_screen(); ?>
		<form method="post" class="dollar-go-form">
			<?php wp_nonce_field( 'localilly_dollar', 'localilly_dollar' ); ?>
			<button type="submit" class="dollar-go press">Put My Name To It</button>
		</form>
		<p class="dollar-after">Your card stays with your bank. We never see a number.</p>

	<?php else : ?>

		<?php
		/*
		 * Nothing to press. **The screen says which half is missing** rather
		 * than offering a button that would fail — and it says it warmly,
		 * since her law reaches a screen nobody was meant to see.
		 */
		?>
		<p class="dollar-soon">Card payments open shortly, and this page is where they will be. Put your name down meanwhile and you will hear the day it does.</p>
		<a class="dollar-go press" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Put Your Name Down</a>

	<?php endif; ?>

	<p class="dollar-quiet"><?php echo esc_html( localilly_say( 'm_dollar_quiet' ) ?: 'The only dollar we ever ask you for.' ); ?></p>

</main>

<?php
get_footer();
