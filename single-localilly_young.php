<?php
/**
 * A young person's own page, as a neighbour meets it.
 *
 * **The shopfront.** Until 25 August 2026 this did not exist — `page-profile.php`
 * was a hand-written example and no template anywhere queried a real record, so
 * a young person could finish the whole atelier and be reachable by nobody.
 *
 * WHAT A NEIGHBOUR SEES, AND WHAT THEY DO NOT
 *
 * A first name, a suburb, a street, their own words, what they do, what they
 * ask, and when they are free. **A full name, a house number, a birthday and a
 * grown-up stay behind**, and the template never reads them.
 *
 * Her nameplate ruling holds: the same beautiful frame for everybody, carrying
 * their name and their own words rather than their face.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$localilly_id   = get_the_ID();
	$localilly_name = (string) get_post_meta( $localilly_id, '_ll_name', true );
	$localilly_line = (string) get_post_meta( $localilly_id, '_ll_line', true );
	$localilly_sub  = (string) get_post_meta( $localilly_id, '_ll_suburb', true );
	$localilly_st   = (string) get_post_meta( $localilly_id, '_ll_street', true );
	$localilly_says = (string) get_post_meta( $localilly_id, '_ll_words', true );
	$localilly_does = array_filter( (array) get_post_meta( $localilly_id, '_ll_doing', true ) );
	$localilly_asks = array_filter( (array) get_post_meta( $localilly_id, '_ll_rates', true ) );
	$localilly_free = (string) get_post_meta( $localilly_id, '_ll_free', true );
	$localilly_pics = array_filter( (array) get_post_meta( $localilly_id, '_ll_shots', true ) );
	?>

	<main class="them">

		<div class="them-plate plate">
			<h1 class="them-name">Local<span class="say"><?php echo esc_html( $localilly_name ); ?></span></h1>
			<?php if ( '' !== $localilly_line ) : ?>
				<p class="them-line"><?php echo esc_html( localilly_as_a_title( $localilly_line ) ); ?></p>
			<?php endif; ?>
			<?php
			/*
			 * ── HER RULING, 30 AUGUST: THE SUBURB ALONE ───────────────
			 *
			 * Her words: don't put his street sign on there, just say
			 * Preston.
			 *
			 * The street was made public on her ruling of 25 August so a
			 * neighbour could tell how close somebody was. **Seeing it on
			 * a real young person she has ruled the other way**, and this
			 * is the one place a ruling about a child's location outranks
			 * a previous one without argument.
			 *
			 * It is still held, still shut in the profile, and still
			 * reachable if anything ever happens to him.
			 */
			?>
			<p class="them-where"><?php echo esc_html( $localilly_sub ); ?></p>
		</div>

		<?php if ( '' !== $localilly_says ) : ?>
			<blockquote class="them-says"><p><?php echo esc_html( $localilly_says ); ?></p></blockquote>
		<?php endif; ?>

		<?php if ( $localilly_does ) : ?>
			<p class="them-eyebrow">What <?php echo esc_html( $localilly_name ); ?> Does</p>
			<ul class="them-does">
				<?php foreach ( $localilly_does as $localilly_d ) : ?>
					<li><?php echo esc_html( localilly_the_eight()[ $localilly_d ] ?? $localilly_d ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $localilly_asks ) : ?>
			<p class="them-eyebrow">What <?php echo esc_html( $localilly_name ); ?> Asks</p>
			<ul class="them-asks">
				<?php foreach ( $localilly_asks as $localilly_r ) : ?>
					<li>
						<span><?php echo esc_html( (string) ( $localilly_r['what'] ?? '' ) ); ?></span>
						<strong><?php echo esc_html( localilly_rate_says( $localilly_r ) ); ?></strong>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( '' !== $localilly_free ) : ?>
			<p class="them-eyebrow"><?php echo esc_html( $localilly_name ); ?>&rsquo;s Availability</p>
			<p class="them-free"><?php echo esc_html( $localilly_free ); ?></p>
		<?php endif; ?>

		<?php if ( $localilly_pics ) : ?>
			<p class="them-eyebrow">Work <?php echo esc_html( $localilly_name ); ?> Has Done</p>
			<ul class="them-pics">
				<?php foreach ( array_slice( $localilly_pics, 0, 10 ) as $localilly_i => $localilly_pic ) : ?>
					<?php if ( 0 === strpos( (string) $localilly_pic, 'data:image/jpeg;base64,' ) ) : ?>
						<li>
							<img src="<?php echo esc_attr( (string) $localilly_pic ); ?>" alt="<?php
							/* translators: %s: the young person's first name. */
							echo esc_attr( sprintf( 'Work %s has done', $localilly_name ) ); ?>" loading="lazy">
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php
		/*
		 * The way to reach them.
		 *
		 * **Her law that a road not built has its words taken down.** The
		 * messaging module is present and uncalled, so this draws what is true
		 * today rather than a button that goes nowhere.
		 */
		?>
		<?php
		/*
		 * ── THE ROAD THAT DID NOT EXIST ───────────────────────────────
		 *
		 * This said the first word opens the day writing does, because it
		 * could not be written. **She walked her own world wanting to
		 * message somebody and found nothing to press.**
		 *
		 * The engine was whole the entire time and this theme never called
		 * it once.
		 */
		localilly_the_first_word( $localilly_id, $localilly_name );
		?>

		<?php
		/*
		 * ── ONE SECTION, NEVER TWO ────────────────────────────────────
		 *
		 * Her words: it has two options, writing to Zac and keeping Zac safe,
		 * which one are you using.
		 *
		 * Both. **The safety words and the write box were separate sections
		 * and both drew**, so an unverified neighbour met the same thing twice
		 * in two voices. They are one moment: the reason, then the act.
		 */
		?>

	</main>

	<?php
endwhile;

get_footer();
