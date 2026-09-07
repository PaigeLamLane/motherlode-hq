<?php
/**
 * Template Name: Join
 *
 * REBUILT WHOLE, 3 September 2026. Her words, direct, after actually
 * looking at what was here: "I hate that page." She was right to.
 *
 * WHAT WAS HERE BEFORE, for the record: LocaLilly's own "empty search
 * that answers" — a page built for a neighbour searching for a young
 * person to mow a lawn within walking distance, matched against
 * Lawn Mowing / Babysitting / Car Washing (found on a self-audit, that
 * exact wrong category list was still live), with two generic silver-
 * gradient forms bolted underneath for whenever the search found
 * nobody — which, with zero professionals in the system yet, was
 * every single time. None of that machinery has anything to do with
 * MotherLode HQ: professionals here aren't found by walking distance,
 * and the real search that exists (Dokan's own Store Listing) already
 * works and lives at /store-listing/. This page was duplicating a
 * search system, badly, rather than using the one that's real.
 *
 * THE FIX: retire all of it. "Join" only ever needs to ask one
 * question — which side is she on — and this site already asks it
 * beautifully, on the homepage's own hero. Same mark, same line, same
 * two paths, same destinations. Nobody who clicks "Join" from
 * anywhere on the site meets a different design language or a form
 * that doesn't match what they just saw.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="lode-hero">
	<div class="in lode-hero-stack">
		<div class="lode-hero-mark lode-hero-mark--big">
			<?php get_template_part( 'template-parts/lode-mark' ); ?>
		</div>

		<p class="lode-hero-choose">Which One's <strong>You?</strong></p>

		<div class="lode-paths">
			<a class="lode-path lode-path--a" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">
				<span class="lode-path-text">I need <strong>exceptional help</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
			<a class="lode-path lode-path--b" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">
				<span class="lode-path-text">I'm carrying <strong>a mother lode of expertise</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
