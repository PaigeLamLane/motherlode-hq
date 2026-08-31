<?php
/**
 * Every line on this site, in her own hands.
 *
 * HER OWN SENTENCE, AND SHE WAS RIGHT TO BE CROSS: *that should have been there
 * for me in the back end, actually. Why wasn't that organised, people?*
 *
 * **She has never once asked for a feature before asking for control of her own
 * words**, and this business built five screens of copy she could not touch. The
 * module that ends it is Aunt Tea's, and LocaLilly is named in its own README as
 * the site that found the fault — her front page locked in a template after she
 * had rewritten it four times.
 *
 * SO NOTHING HERE IS A SECOND VERSION OF ANYTHING. lamoureux-words holds the
 * panel, the storage and the laws. This declares what LocaLilly's pages carry
 * and nothing more.
 *
 * AND HER EXISTING CHOICES CARRY ACROSS WITHOUT RETYPING. Every picture she
 * placed and every line she edited lives in the child theme's own settings, and
 * the adopt filter reads them straight through as defaults. **She loses nothing
 * and re-enters nothing.** The moment she edits one in the new panel it lives in
 * one place and the old name is never consulted again.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * What LocaLilly's pages hold.
 *
 * Grouped by the screen she is looking at rather than by the kind of field,
 * since she edits a page rather than a data type.
 *
 * @param array $map The map.
 * @return array
 */
function localilly_her_words( array $map ): array {
	$map['front'] = array(
		'title' => 'The Front Page',
		'note'  => 'What a neighbour meets first.',
		'bits'  => array(
			'w_hero_head'     => array( 'line', 'Hero · The Big Heading', 'Find Your Local Lilly, Jack, Mia Or Mac' ),
			'w_hero_lede'     => array( 'words', 'Hero · The Line Under It', 'A website for 15- to 18-year-olds to list their services to support their neighbours.' ),
			'pic_home_hero'   => array( 'picture', 'Hero · The Photograph Behind It', '', 'A young person outdoors in a neighbourhood. Landscape, and their face away from the middle so the heading sits clear.' ),
			'w_seek_go'       => array( 'line', 'Search · The Button', 'Find Someone Close' ),
			'w_eight_eyebrow' => array( 'line', 'The Eight · The Small Line Above', 'Ways To Be Helpful' ),
			'w_shine_head'    => array( 'line', 'Shine · The Heading', 'LocaLilly Gives Teens A Place To Shine' ),
			'w_shine_body'    => array( 'words', 'Shine · The Words Under It', 'Young people list their skills, neighbours find local help, and everyone benefits.' ),
			'w_why_head'      => array( 'line', 'Why · The Heading', 'Why LocaLilly Exists' ),
			'w_why_one'       => array( 'words', 'Why · The First Paragraph', '' ),
			'w_why_two'       => array( 'words', 'Why · The Second Paragraph', '' ),
			'w_layers_name'   => array( 'line', 'Safety · The Button At The Foot', 'Layers Of Safety' ),
			'w_layers_line'   => array( 'words', 'Safety · The Line Beside It', '' ),
			'pic_home_why'    => array( 'picture', 'Why · The Photograph', '', 'A young person at work in their own street. Landscape.' ),
			'w_onward_eyebrow'=> array( 'line', 'The Onward Road · The Small Line Above', 'Supporting Young People All The Way Across' ),
			'w_onward_head'   => array( 'line', 'The Onward Road · The Heading', 'There Is A Door For You At Every Age' ),
		),
	);

	$map['steps'] = array(
		'title' => 'How It Works',
		'note'  => 'The three steps on the front page.',
		'bits'  => array(
			'w_step1_head' => array( 'line', 'Step One · The Heading', '' ),
			'w_step1_body' => array( 'words', 'Step One · The Words', '' ),
			'w_step2_head' => array( 'line', 'Step Two · The Heading', '' ),
			'w_step2_body' => array( 'words', 'Step Two · The Words', '' ),
			'w_step3_head' => array( 'line', 'Step Three · The Heading', '' ),
			'w_step3_body' => array( 'words', 'Step Three · The Words', '' ),
		),
	);

	$map['eight'] = array(
		'title' => 'The Eight Kinds Of Work',
		'note'  => 'The pictures on the cards that travel across the front page.',
		'bits'  => array(
			'pic_post_lawn_mowing'         => array( 'picture', 'Lawn Mowing', '', 'Somebody mowing a lawn. Landscape, and their head well inside the frame.' ),
			'pic_post_elder_companions'    => array( 'picture', 'Elder Companions', '', 'A young person and an older neighbour together. Landscape.' ),
			'pic_post_party_help'          => array( 'picture', 'Party Help', '', 'A young person helping at a party. Landscape.' ),
			'pic_post_yard_work'           => array( 'picture', 'Yard Work', '', 'Somebody working in a garden. Landscape.' ),
			'pic_post_car_washing'         => array( 'picture', 'Car Washing', '', 'A car being washed in a driveway. Landscape.' ),
			'pic_post_cleaning_organising' => array( 'picture', 'Cleaning & Organising', '', 'A tidy room or somebody organising. Landscape.' ),
			'pic_post_tutoring'            => array( 'picture', 'Tutoring', '', 'Homework at a kitchen table. Landscape.' ),
			'pic_post_babysitting'         => array( 'picture', 'Babysitting', '', 'A young person with a small child. Landscape.' ),
		),
	);

	$map['young'] = array(
		'title' => 'If You Are 15 To 18',
		'note'  => 'The page written to a young person.',
		'bits'  => array(
			'y_eyebrow'  => array( 'line', 'The Small Line Above', 'If You Are Fifteen To Eighteen' ),
			'y_title'    => array( 'line', 'The Heading', 'This One Is For You' ),
			'y_open_one' => array( 'words', 'The First Paragraph', 'Your street already needs what you can do. Lawns that got away over winter, a dog nobody has walked today, a car, a shed, a kitchen table where somebody&rsquo;s little brother is stuck on his homework.' ),
			'y_open_two' => array( 'words', 'The Second Paragraph', 'Doing it for your neighbours means real responsibility, real trust, and a reputation you build on your own terms, a few doors from your own front gate.' ),
			'y_next_head'=> array( 'line', 'Starting · The Heading', 'Start Your Business Whenever You Like' ),
			'y_next_one' => array( 'words', 'Starting · The First Paragraph', 'It begins with your first name and your suburb, and it is yours from that moment. Each answer after it is saved as you go, so you can stop halfway through and pick it up next week exactly where you left it.' ),
			'y_next_two' => array( 'words', 'Starting · The Second Paragraph', 'Six moments in all, and the last one brings in a grown-up. Start now and you are in the first hundred — three months free rather than one, counted from the day you open.' ),
			'y_go'       => array( 'line', 'Starting · The Button', 'Create Your Business' ),
		),
	);

	$map['grown'] = array(
		'title' => 'For A Grown-Up',
		'note'  => 'The page written to a parent.',
		'bits'  => array(
			'g_eyebrow'  => array( 'line', 'The Small Line Above', 'For The Grown-Up' ),
			'g_title'    => array( 'line', 'The Heading', 'Somebody Has Put Your Name Down' ),
			'g_open_one' => array( 'words', 'The First Paragraph', 'A young person you look after has started a small business, and they named you as the adult beside them. That is worth knowing before anything else: they chose you.' ),
			'g_open_two' => array( 'words', 'The Second Paragraph', 'They are old enough to do this, and old enough to run it themselves. Here is what that looks like from where you are standing.' ),
		),
	);

	$map['money'] = array(
		'title' => 'What We Ask For',
		'note'  => 'The words beside each of the three prices.',
		'bits'  => array(
			'm_dollar_eyebrow' => array( 'line', 'The Dollar · The Small Line Above', 'Before You Reach A Young Person' ),
			'm_dollar_head' => array( 'line', 'The Dollar · The Heading', 'So They Know Exactly Who Asked' ),
			'm_dollar_quiet'=> array( 'words', 'The Dollar · The Line At The Foot', 'The only dollar we ever ask you for.' ),
			'm_dollar_short'=> array( 'words', 'The Dollar · The One Sentence', 'One dollar, once, on your own card. It takes seconds, and it means every account here belongs to a real person.' ),
			'm_dollar_why'  => array( 'words', 'The Dollar · Why We Ask', 'We are committed to community safety, and that starts with a real person behind every account. One dollar on your own card, once — it takes seconds, and it means a young person arriving for your shift knows exactly who asked for them.' ),
			'm_monthly_why' => array( 'words', 'Ten Dollars A Month · Why', 'Ten dollars a month keeps your business here, and your first month is free. Every dollar a neighbour pays you is yours — LocaLilly takes none of it.' ),
			'm_gift_why'    => array( 'words', 'The Gift · Why', 'A year of their own business, bought for them. Their page, their prices and their words are theirs from the first day — and when the year is up it is theirs to carry on.' ),
		),
	);

	$map['safety'] = array(
		'title' => 'Layers Of Safety',
		'note'  => 'Why this site is built the way it is.',
		'bits'  => array(
			's_eyebrow' => array( 'line', 'The Small Line Above', 'Why We Built It This Way' ),
			's_title'   => array( 'line', 'The Heading', 'Layers Of Safety' ),
			's_open'    => array( 'words', 'The Opening', 'This site introduces adults to young people. Every screen here was drawn with that sentence in front of us, and each layer below answers the question a parent actually asks: did anybody think hard about this before my child arrived?' ),
			's_honest_head' => array( 'line', 'The Honest Half · The Heading', 'And Here Is What We Ask Of You' ),
			's_honest'  => array( 'words', 'The Honest Half · The Words', '' ),
			's_count'   => array( 'line', 'The Line Saying How Many', 'Ten of them, and each one holds on its own.' ),
			's_go'      => array( 'line', 'The Button At The Foot', 'Join LocaLilly' ),
		),
	);

	$map['layers'] = array(
		'title' => 'The Ten Layers',
		'note'  => 'Each layer says what it is for before it says what it does. Wrap a phrase in two asterisks to lean on it.',
		'bits'  => array(),
	);

	$localilly_layer_names = array(
		1 => 'Fifteen Is The Age, And It Is The Law',
		2 => 'A Real Card Comes First',
		3 => 'An Adult Opens The Account',
		4 => 'A Nameplate, Rather Than A Face',
		5 => 'A Street, Never A Number',
		6 => 'Close By, Rather Than Findable',
		7 => 'The First Word Is Written With Care',
		8 => 'Their Messages Belong To Them',
		9 => 'Everybody Stands Level',
		10 => 'The Money Goes Straight To Them',
	);

	foreach ( $localilly_layer_names as $localilly_n => $localilly_title ) {
		$map['layers']['bits'][ 'sl' . $localilly_n . '_name' ] = array( 'line', sprintf( 'Layer %d · The Heading', $localilly_n ), $localilly_title );
		$map['layers']['bits'][ 'sl' . $localilly_n . '_why' ]  = array( 'words', sprintf( 'Layer %d · What It Is', $localilly_n ), '' );
		$map['layers']['bits'][ 'sl' . $localilly_n . '_so' ]   = array( 'words', sprintf( 'Layer %d · What It Is For', $localilly_n ), '' );
	}

	return $map;
}
add_filter( 'lamoureux_words_map', 'localilly_her_words' );

/**
 * Her existing choices, read straight through.
 *
 * Ten photographs and nineteen lines she has already placed. **None of it is
 * retyped and none of it is lost** — where a handle differs, it is named here
 * once and never again.
 *
 * @param array $old Old names.
 * @return array
 */
function localilly_adopt_her_words( array $old ): array {
	$old['pic_home_hero'] = 'localilly_home_hero';
	$old['pic_home_why']  = 'localilly_home_why';

	foreach ( array( 'lawn_mowing', 'elder_companions', 'party_help', 'yard_work', 'car_washing', 'cleaning_organising', 'tutoring', 'babysitting' ) as $slug ) {
		$old[ 'pic_post_' . $slug ] = 'localilly_post_' . $slug;
	}

	foreach ( array(
		'w_hero_head', 'w_hero_lede', 'w_seek_go', 'w_eight_eyebrow',
		'w_shine_head', 'w_shine_body', 'w_why_head', 'w_why_one', 'w_why_two',
		'w_layers_name', 'w_layers_line',
		'w_step1_head', 'w_step1_body', 'w_step2_head', 'w_step2_body', 'w_step3_head', 'w_step3_body',
	) as $key ) {
		$old[ $key ] = 'localilly_' . $key;
	}

	return $old;
}
add_filter( 'lamoureux_words_adopt', 'localilly_adopt_her_words' );
