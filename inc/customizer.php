<?php
/**
 * Appearance, then Customize.
 *
 * Her instruction, 22 August 2026: a section for every single page, and every
 * image field carrying a description telling her where on the site that photo
 * appears.
 *
 * The pattern comes from Nan Made, which has run it across several of the
 * businesses. The panel is the page. The section is a band she can point at on
 * screen. The control is one picture. **If she cannot say the section name
 * while scrolling past it, the section is wrong.**
 *
 * THE LABEL CARRIES EVERYTHING, AND HERE IS WHY.
 *
 * A Customizer description renders small and grey beneath the field, which is
 * exactly the type she has told us she cannot read on a phone. The label is the
 * only text guaranteed to be legible, so all of it lives there:
 *
 *   THE KIND, in capitals, first — a phone truncates, and a cut-off label has
 *     still told her HERO or TILE, which is the half that says what she is
 *     looking at
 *   WHERE IT LANDS, in her words
 *   WHAT THE PICTURE SHOULD BE, ending in its shape as a plain word rather
 *     than pixels, since she is choosing from a folder of hundreds and the
 *     shape decides whether a picture fits before she opens it
 *
 * A number never stands alone. Picture 3 of 8 says where she is in a set;
 * picture 3 says nothing.
 *
 * THE MEDIA CHOOSER THROUGHOUT, NEVER A URL.
 *
 * Her law, and there is a second gain beyond her comfort: an attachment id
 * survives a domain change and a URL does not. Nan Made moved a whole site
 * from a build address to a live one without a single photograph breaking.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Every picture on the site, in one list.
 *
 * One place to read, so a section can never drift from what the page renders.
 *
 * @return array<string, array<string, mixed>>
 */
function localilly_pictures(): array {
	$categories = array(
		'lawn-mowing'          => 'Lawn Mowing',
		'elder-companions'     => 'Elder Companions',
		'party-help'           => 'Party Help',
		'yard-work'            => 'Yard Work',
		'car-washing'          => 'Car Washing',
		'cleaning-organising'  => 'Cleaning & Organising',
		'tutoring'             => 'Tutoring',
		'babysitting'          => 'Babysitting',
	);

	$pictures = array(
		'home' => array(
			'title'    => 'LocaLilly — Homepage',
			'sections' => array(
				'hero' => array(
					'title'    => 'Hero',
					'controls' => array(
						'home_hero' => 'HERO — the big picture behind Find Your Local Lilly, Jack, Mia Or Mac. A young person at work in a front garden, wide',
					),
				),
				'posts' => array(
					'title'    => 'The Eight On The Corner Post',
					'controls' => array(),
				),
				'why' => array(
					'title'    => 'Why LocaLilly Exists',
					'controls' => array(
						'home_why' => 'IMAGE SLOT — beside Why LocaLilly Exists. A young person and a neighbour together, wide',
					),
				),
			),
		),
	);

	$i = 0;
	foreach ( $categories as $slug => $name ) {
		++$i;
		$pictures['home']['sections']['posts']['controls'][ 'post_' . str_replace( '-', '_', $slug ) ] = sprintf(
			/* translators: 1: category name, 2: which of the eight, 3: how many. */
			'TILE — %1$s, plate %2$d of %3$d on the corner post. A young person doing exactly this, wide',
			$name,
			$i,
			count( $categories )
		);
	}

	return $pictures;
}

/**
 * Register the panels, sections and pictures.
 *
 * @param WP_Customize_Manager $wp_customize The manager.
 */
function localilly_customize( WP_Customize_Manager $wp_customize ): void {
	$priority = 20;

	foreach ( localilly_pictures() as $page_key => $page ) {
		$panel_id = 'localilly_' . $page_key;

		$wp_customize->add_panel(
			$panel_id,
			array(
				'title'    => $page['title'],
				'priority' => $priority,
			)
		);

		$section_priority = 10;

		foreach ( $page['sections'] as $section_key => $section ) {
			$section_id = $panel_id . '_' . $section_key;

			$wp_customize->add_section(
				$section_id,
				array(
					'title'    => $section['title'],
					'panel'    => $panel_id,
					'priority' => $section_priority,
				)
			);

			$control_priority = 10;

			foreach ( $section['controls'] as $key => $label ) {
				$setting = 'localilly_' . $key;

				$wp_customize->add_setting(
					$setting,
					array(
						'default'           => 0,
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Media_Control(
						$wp_customize,
						$setting,
						array(
							'label'     => $label,
							'section'   => $section_id,
							'mime_type' => 'image',
							'priority'  => $control_priority,
						)
					)
				);

				$control_priority += 10;
			}

			$section_priority += 10;
		}

		$priority += 10;
	}
}
add_action( 'customize_register', 'localilly_customize' );

/**
 * One picture, rendered, or an honest absence.
 *
 * A slot she has yet to fill renders no markup at all rather than a grey box.
 * An empty frame on a page reads as a fault; an absent one reads as a page
 * that is still being written.
 *
 * @param string $key   Picture key, without the prefix.
 * @param string $size  Image size.
 * @param string $class Class for the img.
 */
/**
 * Which picture she has chosen for a slot, from her panel or from before it.
 *
 * One door for both, so no template has to know which panel a value came from.
 *
 * @param string $key Picture key, without the prefix.
 */
function localilly_picture_id( string $key ): int {
	/*
	 * ── TWO PANELS STORE A PICTURE TWO DIFFERENT WAYS ─────────────────
	 *
	 * This theme has always stored an attachment id, because an id survives a
	 * domain change and a URL does not. **lamoureux-words stores a URL**, and
	 * it returns whatever it holds without minding which.
	 *
	 * So a value arriving from either panel is read for what it actually is
	 * rather than for what it was expected to be. Assuming one shape would
	 * have rendered her hero as a broken image on the day she first touched
	 * the new panel — and it would have looked like her edit that broke it.
	 */
	if ( function_exists( 'lam_picture' ) ) {
		$hers = trim( (string) lam_picture( 'pic_' . $key ) );

		if ( '' !== $hers ) {
			if ( ctype_digit( $hers ) ) {
				return (int) $hers;
			}

			$found = attachment_url_to_postid( $hers );

			if ( $found ) {
				return (int) $found;
			}
		}
	}

	return absint( get_theme_mod( 'localilly_' . $key, 0 ) );
}

function localilly_picture( string $key, string $size = 'large', string $class = '', bool $first = false ): void {
	$id = localilly_picture_id( $key );

	if ( ! $id ) {
		return;
	}

	/*
	 * ── A PICTURE AT THE TOP IS NEVER LAZY ────────────────────────────
	 *
	 * Her words, 25 August 2026: **the hero image loads last and pops in
	 * weirdly.**
	 *
	 * Every picture here carried `loading="lazy"`, the hero included. Lazy
	 * tells the browser to leave an image until it is nearly needed — which is
	 * right for the eight on the corner post, and **wrong for the one filling
	 * the top of the page.** The words painted, the ground painted, and the
	 * picture arrived afterwards on its own.
	 *
	 * So the first picture on a screen is fetched eagerly and at high
	 * priority, and everything below the fold keeps the behaviour that was
	 * always right for it.
	 *
	 * `fetchpriority` is what moves it ahead of the fonts and the stylesheet
	 * in the queue. Eager alone only stops the deferral; it does not ask for
	 * the picture early.
	 */
	$how = $first
		? array(
			'loading'       => 'eager',
			'fetchpriority' => 'high',
			'decoding'      => 'sync',
		)
		: array(
			'loading'  => 'lazy',
			'decoding' => 'async',
		);

	echo wp_get_attachment_image(
		$id,
		$size,
		false,
		array_merge( array( 'class' => $class ), $how )
	);
}

/**
 * Tell the browser about the hero before it has read the page.
 *
 * A preload in the head starts the download in the first moments of the
 * request rather than when the parser reaches the tag. **On her narrow pane,
 * on a phone, that is the difference between a picture that is simply there
 * and one that arrives.**
 *
 * It carries the same responsive sources the tag does, so a phone still
 * fetches the phone-sized picture rather than the full one.
 */
function localilly_hero_first(): void {
	if ( ! is_front_page() ) {
		return;
	}

	$id = localilly_picture_id( 'home_hero' );

	if ( ! $id ) {
		return;
	}

	$src = wp_get_attachment_image_src( $id, 'full' );

	if ( ! $src ) {
		return;
	}

	$srcset = wp_get_attachment_image_srcset( $id, 'full' );
	$sizes  = wp_get_attachment_image_sizes( $id, 'full' );

	printf(
		'<link rel="preload" as="image" href="%s"%s%s fetchpriority="high">' . "\n",
		esc_url( $src[0] ),
		$srcset ? ' imagesrcset="' . esc_attr( $srcset ) . '"' : '',
		$sizes ? ' imagesizes="' . esc_attr( $sizes ) . '"' : ''
	);
}
add_action( 'wp_head', 'localilly_hero_first', 1 );

/**
 * Has she chosen a picture for this slot yet.
 *
 * @param string $key Picture key, without the prefix.
 */
function localilly_has_picture( string $key ): bool {
	return (bool) localilly_picture_id( $key );
}

/**
 * Every word she wrote, hers to change without a session.
 *
 * HER LAW, AND I HAD BROKEN IT ON THE ONE PAGE SHE REWROTE FOUR TIMES.
 *
 * Her standing rule is that she can change everything herself. Her front page
 * copy was in the template, so she could rewrite a heading four times in an
 * evening by telling me, and could not alter a comma without me. Found by
 * walking the site as somebody running it rather than as somebody visiting it.
 *
 * The labels follow the same rule as the pictures: the kind in capitals first,
 * then where it lands, in her words. A Customizer description renders in the
 * small grey type she cannot read on a phone, so the label carries all of it.
 *
 * @return array<string, array<string, mixed>>
 */
function localilly_words(): array {
	return array(
		/*
		 * ── THE ROAD A YOUNG PERSON WALKS ─────────────────────────────
		 *
		 * Added 25 August 2026. Every question on it was frozen in a
		 * template — **the seven moments a fifteen-year-old actually walks
		 * were the one part of this world she could not change a word of.**
		 *
		 * She is alone with these sites for five days, and this is the road
		 * she will most want to move.
		 */
		'the_road' => array(
			'title'    => 'Creating A Business — The Seven Moments',
			'controls' => array(
				'w_m_name_ask'   => array( 'MOMENT 1 — the question', 'What Should Your Neighbours Call You?', 'text' ),
				'w_m_name_why'   => array( 'MOMENT 1 — the line under it', 'Your first name is plenty, and your badge wears it — Local and then you. Your business begins the moment you tell me.', 'textarea' ),
				'w_m_doing_ask'  => array( 'MOMENT 2 — the question', 'What Are You Good At?', 'text' ),
				'w_m_doing_why'  => array( 'MOMENT 2 — the line under it', 'Pick as many as you like. You can change these whenever you want.', 'textarea' ),
				'w_m_words_ask'  => array( 'MOMENT 3 — the question', 'Tell Them About You', 'text' ),
				'w_m_words_why'  => array( 'MOMENT 3 — the line under it', 'A few sentences in your own words. This is the part neighbours read first, and it stays yours — nobody rewrites it.', 'textarea' ),
				'w_m_rates_ask'  => array( 'MOMENT 4 — the question', 'What Will You Charge?', 'text' ),
				'w_m_rates_why'  => array( 'MOMENT 4 — the line under it', 'Yours to decide. Where you would rather look at a job first, say so, and that is an answer too.', 'textarea' ),
				'w_m_free_ask'   => array( 'MOMENT 5 — the question', 'When Are You Free?', 'text' ),
				'w_m_free_why'   => array( 'MOMENT 5 — the line under it', 'School comes first. Tell them when suits and a neighbour can ask at the right time.', 'textarea' ),
				'w_m_shots_ask'  => array( 'MOMENT 6 — the question', 'Show What You Have Done', 'text' ),
				'w_m_shots_why'  => array( 'MOMENT 6 — the line under it', 'Up to ten pictures of the work itself — a lawn you cut, a car you washed, a shed you sorted out. Skip it and your words do the work on their own.', 'textarea' ),
				'w_m_grown_ask'  => array( 'MOMENT 7 — the question', 'Who Is Your Grown-Up?', 'text' ),
				'w_m_grown_why'  => array( 'MOMENT 7 — the line under it', 'Your business is yours and you open it yourself. A grown-up says yes before it goes live, and they are the one who tells us your birthday rather than you. They sign in beside you from then on.', 'textarea' ),
			),
		),
		'home_hero' => array(
			'title'    => 'Homepage — The Top',
			'controls' => array(
				'w_hero_head' => array( 'HEADING — the big line over the photograph', 'Find Your Local Lilly, Jack, Mia Or Mac', 'text' ),
				'w_hero_lede' => array( 'THE LINE UNDER IT — on the grass, at the foot of the photograph', 'A website for 15- to 18-year-olds to list their services to support their neighbours.', 'textarea' ),
				'w_seek_first' => array( 'THE SAFETY LINE — above the search, read before anybody looks', 'We are committed to community safety, so there is a real person behind every account here. A neighbour puts one dollar on their own card before they can reach a young person.', 'textarea' ),
				'w_seek_what' => array( 'SEARCH — the words inside the first box', 'What needs doing?', 'text' ),
				'w_seek_where' => array( 'SEARCH — the words inside the second box', 'Your suburb', 'text' ),
				'w_seek_go'   => array( 'SEARCH — the words on the button', 'Find Someone Close', 'text' ),
			),
		),
		'home_eight' => array(
			'title'    => 'Homepage — The Eight',
			'controls' => array(
				'w_eight_eyebrow' => array( 'SMALL LINE — in mint, above the eight', 'Ways To Be Helpful', 'text' ),
			),
		),
		'home_shine' => array(
			'title'    => 'Homepage — A Place To Shine',
			'controls' => array(
				'w_shine_head' => array( 'HEADING — the band under the eight', 'LocaLilly Gives Teens A Place To Shine', 'text' ),
				'w_shine_body' => array( 'THE PARAGRAPH — under that heading', 'Young people list their skills, neighbours find local help, and everyone benefits.', 'textarea' ),
			),
		),
		'home_steps' => array(
			'title'    => 'Homepage — The Three Steps',
			'controls' => array(
				'w_step1_head' => array( 'STEP 1 — the heading', 'Industrious Teens Create Their Profile', 'text' ),
				'w_step1_body' => array( 'STEP 1 — the words under it', 'Young people aged 15 to 18 list what they can help with. $10 a month, with the first month free.', 'textarea' ),
				'w_step2_head' => array( 'STEP 2 — the heading', 'Neighbours Verify Their Identity', 'text' ),
				'w_step2_body' => array( 'STEP 2 — the words under it', 'A $1 verification confirms your identity with a real card in your own name, before you can search or message anyone.', 'textarea' ),
				'w_step3_head' => array( 'STEP 3 — the heading', 'Find Local Help, Support Young People', 'text' ),
				'w_step3_body' => array( 'STEP 3 — the words under it', 'Connect with trusted young people close to home. Real support, real opportunity, right where you live.', 'textarea' ),
			),
		),
		'home_why' => array(
			'title'    => 'Homepage — Why LocaLilly Exists',
			'controls' => array(
				'w_why_head'  => array( 'HEADING — near the foot of the page', 'Why LocaLilly Exists', 'text' ),
				'w_why_one'   => array( 'THE FIRST PARAGRAPH — under that heading', 'Affordable help right when you need it most, and real opportunity for the young people who provide it. Instead of a shift stacking shelves, told exactly what to do and how to do it, LocaLilly gives young adults real responsibility, real trust, and the chance to build reputation on their own terms in their own neighbourhood.', 'textarea' ),
				'w_why_two'   => array( 'THE SECOND PARAGRAPH — the last words on the page', 'This is how initiative gets built. This is how a community looks after its own again.', 'textarea' ),
			),
		),
		'home_layers' => array(
			'title'    => 'Homepage — The Door To Layers Of Safety',
			'controls' => array(
				'w_layers_name' => array( 'THE NAME — in mint, on the door at the foot of the page', 'Layers Of Safety', 'text' ),
				'w_layers_line' => array( 'THE LINE — under that name', 'A dollar in a real name. An adult on every account. Every message through us. Read every layer we built, in plain words.', 'textarea' ),
			),
		),
	);
}

/**
 * One line of hers, or the words that stand in until she changes them.
 *
 * @param string $key Word key, without the prefix.
 */
function localilly_say( string $key ): string {
	/*
	 * ── HER PANEL FIRST, ALWAYS ───────────────────────────────────────
	 *
	 * Every call site in every template already runs through here, so pointing
	 * this one function at lamoureux-words hands her the whole site at once
	 * rather than template by template. **The old Customizer stays as the
	 * floor**, so a value she has never touched in the new panel still reads
	 * exactly as it did.
	 */
	if ( function_exists( 'lam_words' ) ) {
		$hers = (string) lam_words( $key );

		if ( '' !== trim( $hers ) ) {
			return $hers;
		}
	}

	foreach ( localilly_words() as $section ) {
		if ( isset( $section['controls'][ $key ] ) ) {
			$default = (string) $section['controls'][ $key ][1];

			return (string) get_theme_mod( 'localilly_' . $key, $default );
		}
	}

	return '';
}

/**
 * Register her words beside her pictures.
 *
 * @param WP_Customize_Manager $wp_customize The manager.
 */
function localilly_customize_words( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_panel(
		'localilly_words',
		array(
			'title'    => 'LocaLilly — Every Word On The Page',
			'priority' => 15,
		)
	);

	$section_priority = 10;

	foreach ( localilly_words() as $key => $section ) {
		$section_id = 'localilly_words_' . $key;

		$wp_customize->add_section(
			$section_id,
			array(
				'title'    => $section['title'],
				'panel'    => 'localilly_words',
				'priority' => $section_priority,
			)
		);

		$control_priority = 10;

		foreach ( $section['controls'] as $name => $spec ) {
			list( $label, $default, $kind ) = $spec;
			$setting = 'localilly_' . $name;

			$wp_customize->add_setting(
				$setting,
				array(
					'default'           => $default,
					'sanitize_callback' => 'textarea' === $kind ? 'wp_kses_post' : 'sanitize_text_field',
					'transport'         => 'refresh',
				)
			);

			$wp_customize->add_control(
				$setting,
				array(
					'label'    => $label,
					'section'  => $section_id,
					'type'     => 'textarea' === $kind ? 'textarea' : 'text',
					'priority' => $control_priority,
				)
			);

			$control_priority += 10;
		}

		$section_priority += 10;
	}
}
add_action( 'customize_register', 'localilly_customize_words' );
