<?php
/**
 * Template Name: A Young Person
 *
 * What a neighbour meets before they write.
 *
 * HER RULING, 23 AUGUST 2026: the nameplate, their age, their suburb, their own
 * words, what they do and what they charge. Chosen from three, and she took the
 * one where every word on the page came from the young person.
 *
 * NO PHOTOGRAPH OF A YOUNG PERSON, EVER. Settled earlier and never reopened. A
 * site introducing adults to children shows a nameplate instead, and the
 * nameplate turned out to be the better design as well as the safer one — it
 * gives every young person the same beautiful frame, so the confident one and
 * the shy one arrive looking equal.
 *
 * THE TRUTH LAW GOVERNS THIS SCREEN ABSOLUTELY. Never write a claim about a
 * person that was never given. So there is no rating, no badge earned by
 * behaviour, no sentence beginning Zac is — only what Zac wrote and what Zac
 * priced. **Invented character is a false statement, and it reads as one.**
 *
 * AND NOBODY IS RANKED. Her ruling. This page carries no score, no stars, no
 * jobs-completed count, and no comparison to another young person.
 *
 * WHAT HE ASKS COMES THROUGH ONE FUNCTION OF OUR OWN, at Aunt Tea's ruling,
 * so the listings module can be swapped in underneath without this template
 * changing a character. And it never handles a bare number — a quote is its own
 * answer rather than a price of nothing. See inc/what-they-ask.php.
 *
 * NOBODY ON THIS PAGE IS A PERSON, AND THE PAGE SAYS SO. Her ruling: make it
 * just an example if someone wanted to see what it would look like, and remove
 * Zac as an actual.
 *
 * So the texture stays — real sentences, real rates, a real Saturday — because
 * an example stripped of all of that shows her nothing about how it will look.
 * **What goes is the identity.** A role rather than a name, a suburb that is
 * plainly a placeholder, and a ribbon above it written for somebody who arrived
 * from a search result with no context at all.
 *
 * A named example is still a person to a stranger. That is why there is no
 * second name standing where Zac stood.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

/*
 * Everything here arrives from one array so the day it becomes a record, only
 * this block changes and the screen below stays untouched.
 */
$localilly_them = array(
	/*
	 * The badge on the example reads LocaYours rather than Loca and an invented
	 * first name. Her ruling stands — a named example is still a person to a
	 * stranger — and LocaA Young Person, which is what a role gave, read as a
	 * fault rather than as an example.
	 *
	 * LocaYours says the shape and names nobody.
	 */
	'name'   => 'Yours',
	'who'    => 'A Young Person',
	'line'   => 'and your own line goes here',
	'their'  => 'their',
	'them'   => 'them',
	'age'    => 16,
	'suburb' => 'Your Own Suburb',
	'says'   => "Their own words go here — written by them, and never by us. This one might read: I've mowed our lawn since I was young and I'm good at it. I have my own mower, I bring my own petrol, and I turn up when I say I will.",
	'does'   => array( 'Lawn Mowing', 'Yard Work', 'Car Washing' ),
	'when'   => 'Saturday and Sunday mornings, and after school on Thursdays.',
);
?>

<main class="them">

	<?php get_template_part( 'example-ribbon', null, array( 'says' => 'This is how a young person\'s page will look.' ) ); ?>

	<article class="them-in">

		<?php /* The nameplate. Every young person gets the identical frame. */ ?>
		<div class="them-plate plate">
			<p class="them-name them-name--role">Local <span class="say"><?php echo esc_html( $localilly_them['name'] ); ?></span></p>
			<p class="them-line"><?php echo esc_html( $localilly_them['line'] ); ?></p>
			<p class="them-where"><?php echo esc_html( $localilly_them['age'] ); ?> · <?php echo esc_html( $localilly_them['suburb'] ); ?></p>
		</div>

		<?php /* His own words, and only ever his. */ ?>
		<blockquote class="them-says">
			<p><?php echo esc_html( $localilly_them['says'] ); ?></p>
		</blockquote>

		<h2 class="them-head">What They Do</h2>
		<ul class="them-does">
			<?php foreach ( $localilly_them['does'] as $localilly_doing ) : ?>
				<li class="plate"><?php echo esc_html( $localilly_doing ); ?></li>
			<?php endforeach; ?>
		</ul>

		<h2 class="them-head">What They Ask</h2>
		<ul class="them-rates">
			<?php foreach ( localilly_rate_for( $localilly_them['name'] ) as $localilly_rate ) : ?>
				<li>
					<span class="rate-what"><?php echo esc_html( $localilly_rate['what'] ); ?></span>
					<span class="rate-much rate-much--<?php echo esc_attr( $localilly_rate['kind'] ); ?>"><?php echo esc_html( $localilly_rate['says'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		<p class="them-note">They set these themselves.</p>

		<h2 class="them-head">When They Are Free</h2>
		<p class="them-free"><?php echo esc_html( $localilly_them['when'] ); ?></p>

		<a class="them-go press"
			href="<?php echo esc_url( home_url( '/locazac/' ) ); ?>">
			Write To Them
		</a>
		<p class="them-after">The atelier helps you say it well, so they can answer you properly. On a real page it carries their own name, the way this business does.</p>

	</article>

</main>

<?php
get_footer();
