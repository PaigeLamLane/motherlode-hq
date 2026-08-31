<?php
/**
 * Finding Somebody.
 *
 * **A neighbour's road broke at its first step.** The eight categories were
 * pressable and the door collected a name — and no query anywhere looked for a
 * young person, so there was never anybody to find.
 *
 * WHAT IT ASKS BY, AND WHAT IT REFUSES TO ASK BY
 *
 * **A suburb, and what somebody does.** Never a name. A search by name turns
 * this into a way of looking up a particular child, which is precisely what the
 * absent surname exists to prevent.
 *
 * AND IT ONLY EVER FINDS AN OPEN BUSINESS
 *
 * Published records alone. A draft belongs to the young person building it, and
 * a search is the wrong place to meet somebody who has not opened their doors.
 *
 * HER EMPTY SEARCH THAT ANSWERS
 *
 * Where nobody is found, this returns an empty list and the screen says what is
 * being looked for and offers the way in. **Naming a lack plants it**, so the
 * words above the results belong to the template rather than here.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Young people a neighbour can reach, nearest thing to hand first.
 *
 * @param string $suburb Where they are looking.
 * @param string $doing  Which of the eight, if any.
 * @return WP_Post[]
 */
function localilly_find( string $suburb = '', string $doing = '' ): array {
	$ask = array(
		'post_type'        => LOCALILLY_YOUNG,
		'post_status'      => 'publish',
		'numberposts'      => 24,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'suppress_filters' => false,
	);

	$and = array();

	if ( '' !== trim( $suburb ) ) {
		$and[] = array(
			'key'     => '_ll_suburb',
			'value'   => sanitize_text_field( $suburb ),
			'compare' => 'LIKE',
		);
	}

	if ( '' !== $doing && array_key_exists( $doing, localilly_the_eight() ) ) {
		/*
		 * ── IT IS STORED AS HER WORDS, NEVER AS THE SLUG ──────────────
		 *
		 * The atelier's checkboxes carry her own label as their value —
		 * `Lawn Mowing` rather than `lawn-mowing` — so that is what sits in
		 * `_ll_doing`. This matched the slug, **so a search by category
		 * would have found nobody at all.**
		 *
		 * It passed its first test because the record I searched against was
		 * seeded by hand with slugs. **Test data that differs from what the
		 * road produces will agree with whatever you wrote**, and it agreed
		 * with a bug.
		 *
		 * Found by reading the checkbox markup for another reason entirely.
		 *
		 * What they do is stored as an array, so it lands serialised. LIKE is
		 * how a member of it is found without a table of its own, and the
		 * value comes from her eight rather than from anything a person typed.
		 */
		$and[] = array(
			'key'     => '_ll_doing',
			'value'   => '"' . localilly_the_eight()[ $doing ] . '"',
			'compare' => 'LIKE',
		);
	}

	if ( $and ) {
		$and['relation'] = 'AND';
		$ask['meta_query'] = $and; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	}

	return (array) get_posts( $ask );
}

/**
 * What a neighbour asked for, taken from the address.
 *
 * **Never named `s`.** WordPress owns that one and redirects the whole request
 * away before a template ever runs — proved on her live site, where every
 * search vanished into a 301.
 *
 * @return array{suburb:string, doing:string, asked:bool}
 */
function localilly_what_they_asked(): array {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$suburb = isset( $_GET['near'] ) ? sanitize_text_field( wp_unslash( $_GET['near'] ) ) : '';
	$doing  = localilly_pressed();
	// phpcs:enable

	return array(
		'suburb' => $suburb,
		'doing'  => $doing,
		'asked'  => '' !== $suburb || '' !== $doing,
	);
}

/**
 * One young person, as a row in a list of them.
 */
function localilly_one_of_them( WP_Post $them ): void {
	/*
	 * ── A STREET SIGN, AND I OVERSHOT TWICE ───────────────────────────
	 *
	 * First it was a bare row — a name, a line, a suburb. Her word for it:
	 * pathetic. Then I put his whole profile on it, and her word for that was
	 * that his profile should not be there.
	 *
	 * **The listing IS the street sign.** His name large on her plate, the
	 * line he wrote under it, the street he is on, and what he does. A
	 * neighbour reads the sign and opens him to read the rest.
	 *
	 * Her mark is the shape of this whole world and it belongs on the thing
	 * a person meets first.
	 */
	$id    = $them->ID;
	$name  = (string) get_post_meta( $id, '_ll_name', true );
	$line  = (string) get_post_meta( $id, '_ll_line', true );
	$sub   = (string) get_post_meta( $id, '_ll_suburb', true );
	$st    = (string) get_post_meta( $id, '_ll_street', true );
	$does  = array_filter( (array) get_post_meta( $id, '_ll_doing', true ) );
	$eight = localilly_the_eight();
	?>
	<li class="found-one">
		<a class="found-go" href="<?php echo esc_url( (string) get_permalink( $them ) ); ?>"
			aria-label="<?php echo esc_attr( sprintf( 'Local%1$s, %2$s', $name, $sub ) ); ?>">
			<span class="found-plate">
				<span class="found-name">Local<span class="say"><?php echo esc_html( $name ); ?></span></span>
				<span class="found-where"><?php echo esc_html( $sub ); ?></span>

				<?php if ( $does ) : ?>
					<span class="found-does">
						<?php
						$says = array();
						foreach ( array_slice( $does, 0, 3 ) as $one ) {
							$says[] = $eight[ $one ] ?? $one;
						}
						echo esc_html( implode( ' &middot; ', $says ) );
						?>
					</span>
				<?php endif; ?>
			</span>
		</a>
	</li>
	<?php
}

/**
 * A young person she named, found by that name.
 *
 * **Her pinned favourites are typed rather than chosen from a list**, because
 * she pins somebody the moment she thinks of them rather than after a search.
 * So a name is matched back to a real page where one exists, and left as her
 * own words where it does not — a pin that leads nowhere is still hers to keep.
 *
 * @param string $name What she called them.
 * @return WP_Post|null Their page, or nothing.
 */
function localilly_by_that_name( string $name ): ?WP_Post {
	$name = trim( $name );

	if ( '' === $name ) {
		return null;
	}

	/* The first word, since she writes Zac, who mows rather than Zac. */
	$first = (string) strtok( $name, ' ,' );

	$found = get_posts(
		array(
			'post_type'      => LOCALILLY_YOUNG,
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => '_ll_name',
					'value' => $first,
				),
			),
		)
	);

	return $found ? $found[0] : null;
}
