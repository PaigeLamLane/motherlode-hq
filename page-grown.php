<?php
/**
 * Template Name: For A Grown-Up
 *
 * The one person here with responsibility and no room of their own.
 *
 * HER RULING: a page written to a parent. **The weekly note is struck** — she
 * has said so three or four times and I built a page promising it anyway, which
 * is worse than never having built it. A page that promises a thing nobody will
 * receive is a small lie sitting on her live site.
 *
 * And her second correction, which changes the tone rather than a line: **a
 * parent reading the messages does not have to be impossible.** The young person
 * runs this account, and if they want to show their parent they can. Her reason
 * is the whole philosophy — **somebody who runs something decides who reads
 * it.**
 * **And the sentence that decides its whole tone** — this is about the young
 * person, fifteen to eighteen, *they're old enough and mature enough to work
 * for themselves. That's fine. Absolutely.*
 *
 * So this reassures a parent **without turning them into a gatekeeper.** A page
 * that hands an adult the controls would quietly undo the thing she is
 * building, which is a young person running something of their own. A parent
 * gets to see that it is safe rather than to approve each step of it.
 *
 * WRITTEN TO THEM, NEVER ABOUT THEIR CHILD. They have just been named by a
 * fifteen-year-old as the person who looks after them, and every line here is
 * built on that being an honour rather than an obligation.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="grown">

	<header class="grown-top">
		<p class="grown-eyebrow"><?php echo esc_html( localilly_say( 'g_eyebrow' ) ?: 'For The Grown-Up' ); ?></p>
		<h1 class="grown-title"><?php echo esc_html( localilly_say( 'g_title' ) ?: 'Somebody Has Put Your Name Down' ); ?></h1>
		<p class="grown-open"><?php echo esc_html( localilly_say( 'g_open_one' ) ?: 'A young person you look after has started a small business, and they named you as the adult beside them. That is worth knowing before anything else: they chose you.' ); ?></p>
		<p class="grown-open"><?php echo esc_html( localilly_say( 'g_open_two' ) ?: 'They are old enough to do this, and old enough to run it themselves. Here is what that looks like from where you are standing.' ); ?></p>
	</header>

	<section class="grown-set">
		<h2 class="grown-head">What You Will See</h2>

		<article class="grown-one plate">
			<h3>Their Page, Whenever You Like</h3>
			<p>Their words, their prices and their hours, exactly as they wrote them. You sign in with your own email beside theirs, so all of their work stays open to you.</p>
		</article>

		<article class="grown-one plate">
			<h3>A Human, The Same Day</h3>
			<p>Anything at all about a person on this site reaches somebody who reads it and answers. That is a person rather than a form.</p>
		</article>
	</section>

	<section class="grown-set">
		<h2 class="grown-head">What Stays Theirs</h2>

		<article class="grown-one plate">
			<h3>Their Messages, And Theirs To Share</h3>
			<p>A neighbour writes to them and they answer for themselves. They can show you any of it whenever they like, and that is their choice to make rather than ours to make for them.</p>
			<p class="grown-why">They are running this. The person running it decides who reads it, and a fifteen-year-old is old enough to make that call.</p>
		</article>

		<article class="grown-one plate">
			<h3>Their Prices</h3>
			<p>They decide what they charge, and they keep every dollar of it. LocaLilly asks them for ten dollars a month to be here and takes none of what they earn.</p>
			<p class="grown-why">A young person who set their own price holds it when somebody asks them to drop it. One handed to them goes at the first push.</p>
		</article>

		<article class="grown-one plate">
			<h3>Their Words</h3>
			<p>Every sentence on their page was written by them, and nobody edits it — including us.</p>
		</article>
	</section>

	<section class="grown-law plate">
		<h2 class="grown-law-head">Fifteen, And That Is The Law</h2>
		<p>Young people here are fifteen to eighteen. <strong>Fifteen is the age a young person can work without their employer holding a permit</strong>, and it is the law rather than a rule of ours.</p>
		<p>Their birthday comes from you rather than from them, which is how we keep that true. Their full name and your address come from you as well, and both stay here with us.</p>
	</section>

	<a class="grown-go press" href="<?php echo esc_url( home_url( '/layers-of-safety/' ) ); ?>">Read The Layers Of Safety</a>
	<p class="grown-after">Ten of them, each written out plainly, including what we ask of you.</p>

	<section class="sees-hold">
		<h2 class="sees-ask">What Shows, And What Stays Here</h2>
		<p class="sees-why">Every piece of your young person we hold, and who sees it. They are told the same at the moment they type it.</p>
		<?php localilly_the_parent_table(); ?>
	</section>

	<section class="askback-hold">
		<?php localilly_the_word_on_screen(); ?>
		<?php localilly_ask_for_it_back(); ?>
	</section>

</main>

<?php
get_footer();
