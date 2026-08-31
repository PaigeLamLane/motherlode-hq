<?php
/**
 * Her eight, drawn.
 *
 * ── HER RULING, 30 AUGUST ─────────────────────────────────────────────────
 *
 * Her words: **what kinds of jobs can they do? Have some images on there, for
 * God's sake.**
 *
 * WHY DRAWINGS RATHER THAN PHOTOGRAPHS, AND IT IS HER LAW RATHER THAN TASTE.
 * Every photograph of a young person mowing a lawn is a stock photograph of a
 * child who never agreed to be on a site that introduces adults to children.
 * **Her truth law forbids a claim about a person that was never given**, and a
 * face on this page is the loudest claim there is.
 *
 * So it is the work drawn, never a child pictured doing it. A mower, a hose, a
 * kettle, a book. **The young people who appear on LocaLilly are the real ones,
 * on their own plates, in their own words.**
 *
 * Drawn in her own material — the purple, the mint, the silver of her
 * nameplate — so a page of them reads as one hand rather than a bought set.
 * They carry no text, so they need no translating, and they scale to any width
 * without a single kilobyte crossing the wire.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * One of her eight, drawn.
 *
 * @param string $which Its slug.
 */
function localilly_draw_the_work( string $which ): void {
	$open = '<svg class="work-art" viewBox="0 0 120 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">';
	$end  = '</svg>';

	$art = array(

		/* A mower, and the stripes it leaves behind. */
		'lawn-mowing' => '
			<path d="M6 78h108" class="ln" />
			<path d="M14 78c0-6 5-9 12-9M38 78c0-9 7-14 16-14M66 78c0-11 9-17 20-17" class="ln ln--soft" />
			<rect x="28" y="52" width="38" height="18" rx="4" class="fl" />
			<path d="M66 56l22-16" class="ln" />
			<circle cx="90" cy="38" r="4" class="fl" />
			<circle cx="36" cy="74" r="7" class="ln" />
			<circle cx="60" cy="74" r="5" class="ln" />
			<path d="M20 70c2-5 6-7 10-7" class="ln" />',

		/* Two cups, and the time between them. */
		'elder-companions' => '
			<path d="M6 82h108" class="ln" />
			<path d="M26 44h26v20a13 13 0 01-26 0z" class="fl" />
			<path d="M52 48h7a7 7 0 010 14h-7" class="ln" />
			<path d="M70 52h22v14a11 11 0 01-22 0z" class="fl fl--soft" />
			<path d="M34 32c0-5 4-6 4-10M44 32c0-5 4-6 4-10" class="ln ln--soft" />
			<path d="M26 78h64" class="ln" />',

		/* Bunting, which is a party before anybody arrives. */
		'party-help' => '
			<path d="M8 26c22 14 42 14 52 8s30-8 52 6" class="ln" />
			<path d="M18 32l7 12 8-9zM42 40l7 13 8-10zM68 40l7 13 8-10zM92 34l7 12 8-9z" class="fl" />
			<rect x="30" y="64" width="60" height="22" rx="5" class="ln" />
			<path d="M30 72h60" class="ln ln--soft" />
			<circle cx="60" cy="60" r="4" class="fl" />',

		/* A rake, and the leaves it has gathered. */
		'yard-work' => '
			<path d="M6 82h108" class="ln" />
			<path d="M78 20L48 66" class="ln" />
			<path d="M36 62h26l-4 12H40z" class="fl" />
			<path d="M42 62v12M50 62v12M58 62v12" class="ln ln--soft" />
			<circle cx="86" cy="72" r="6" class="fl fl--soft" />
			<circle cx="98" cy="76" r="4" class="fl fl--soft" />
			<circle cx="76" cy="78" r="4" class="fl fl--soft" />',

		/* A bucket, a sponge, and the suds. */
		'car-washing' => '
			<path d="M6 82h108" class="ln" />
			<path d="M34 50h32l-4 30H38z" class="fl" />
			<path d="M34 50c0-6 7-9 16-9s16 3 16 9" class="ln" />
			<rect x="76" y="56" width="24" height="14" rx="6" class="fl fl--soft" />
			<circle cx="82" cy="34" r="5" class="ln" />
			<circle cx="94" cy="24" r="4" class="ln" />
			<circle cx="72" cy="22" r="3" class="ln" />',

		/* A shelf put right. */
		'cleaning-organising' => '
			<rect x="18" y="24" width="84" height="14" rx="3" class="ln" />
			<rect x="18" y="52" width="84" height="14" rx="3" class="ln" />
			<rect x="24" y="14" width="10" height="10" rx="2" class="fl" />
			<rect x="38" y="10" width="10" height="14" rx="2" class="fl fl--soft" />
			<rect x="52" y="16" width="10" height="8" rx="2" class="fl" />
			<rect x="26" y="42" width="10" height="10" rx="2" class="fl fl--soft" />
			<rect x="40" y="40" width="10" height="12" rx="2" class="fl" />
			<path d="M18 80h84" class="ln ln--soft" />',

		/* A book open, and the working out beside it. */
		'tutoring' => '
			<path d="M60 30c-8-7-20-8-30-6v44c10-2 22-1 30 6 8-7 20-8 30-6V24c-10-2-22-1-30 6z" class="fl" />
			<path d="M60 30v44" class="ln" />
			<path d="M38 40h14M38 50h14M68 40h14M68 50h14" class="ln ln--soft" />
			<path d="M46 86h28" class="ln" />',

		/* A bear waiting up. */
		'babysitting' => '
			<circle cx="60" cy="46" r="22" class="fl" />
			<circle cx="42" cy="28" r="8" class="fl" />
			<circle cx="78" cy="28" r="8" class="fl" />
			<circle cx="52" cy="42" r="3" class="ln" />
			<circle cx="68" cy="42" r="3" class="ln" />
			<path d="M52 56c4 4 12 4 16 0" class="ln" />
			<path d="M38 80h44" class="ln ln--soft" />',
	);

	if ( ! isset( $art[ $which ] ) ) {
		return;
	}

	echo wp_kses(
		$open . $art[ $which ] . $end,
		array(
			'svg'    => array( 'class' => true, 'viewbox' => true, 'fill' => true, 'xmlns' => true, 'aria-hidden' => true, 'focusable' => true ),
			'path'   => array( 'd' => true, 'class' => true ),
			'circle' => array( 'cx' => true, 'cy' => true, 'r' => true, 'class' => true ),
			'rect'   => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'class' => true ),
		)
	);
}

/**
 * What each of her eight actually asks of a person, in one line.
 *
 * **Written to a fifteen-year-old reading it on a phone.** Every one names the
 * real work rather than a category, because a person choosing needs to picture
 * a Saturday rather than a job title.
 *
 * @return array<string,string>
 */
function localilly_what_the_work_is(): array {
	return array(
		'lawn-mowing'         => 'Front and back, edges done, clippings taken away. The one everybody asks for first.',
		'elder-companions'    => 'An hour of company. A cup of tea, a walk to the shops, a hand with a phone that has stopped making sense.',
		'party-help'          => 'Setting up before, running the games during, and the clearing away nobody else wants at the end.',
		'yard-work'           => 'Weeding, raking, hauling, planting. The jobs that got away over winter.',
		'car-washing'         => 'Inside and out, at their place, with their hose. Bring your own bucket and you are worth more.',
		'cleaning-organising' => 'A garage, a pantry, a wardrobe, a shed. Turning up and making one room make sense again.',
		'tutoring'            => 'Maths at a kitchen table, reading with somebody small, or the essay a Year Nine has been avoiding.',
		'babysitting'         => 'An evening with the little ones so their parents get an evening of their own.',
	);
}
