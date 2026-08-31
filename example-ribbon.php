<?php
/**
 * The ribbon that says what this is.
 *
 * HER RULING, 23 AUGUST 2026: check that so it's just an example if someone
 * wanted to see what it would look like, and remove Zac as an actual.
 *
 * Better than the version I built, which held both screens back from search.
 * Hers keeps them open and makes them honest instead — a page saying openly
 * that it is an example is true, where an invented young person presented as a
 * real listing is a false statement and reads as one.
 *
 * **THE READER THIS IS WRITTEN FOR ARRIVED FROM A SEARCH RESULT WITH NO
 * CONTEXT.** They did not read a heading above it, they did not come through
 * the front page, and they have no reason to assume anything. Whatever tells
 * them has to work for that person or it works for nobody.
 *
 * So the ribbon sits above the screen rather than beneath it, it says what the
 * screen is rather than what it lacks, and the person on the page is a role
 * rather than a name. **A named example is still a person to a stranger.**
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

$localilly_says = isset( $args['says'] ) ? $args['says'] : 'This is how a page here will look.';
?>
<p class="example-ribbon">
	<span class="example-word">An Example</span>
	<span class="example-says"><?php echo esc_html( $localilly_says ); ?></span>
</p>
