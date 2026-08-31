<?php
/**
 * Nobody who arrives here is turned away for being the wrong age.
 *
 * HER RULING, 24 AUGUST 2026: if someone goes to LocaLilly and thinks *I don't
 * fit in here because I'm not 18*, straight away we have another option for
 * them, **and it goes on the homepage of LocaLilly at the bottom.** Her
 * placement rather than ours.
 *
 *     LocaLilly    a young person earns
 *     Universe     they carry it onward at eighteen
 *     Know Where   what a young person needs, at any age
 *
 * THE MOMENT IT ANSWERS is somebody reading and deciding they do not belong.
 * **That thought arrives before anybody has a chance to say otherwise**, so the
 * answer has to be already on the page rather than one tap away.
 *
 * HER LAWS BITE HARDEST HERE and they decide every word. Nothing defined by a
 * negation where the negation plants a fear, and no sentence opening on a
 * negative. **Never *you are too old for this*. Always *here is where you go
 * next*.** A door rather than a bouncer.
 *
 * ── AND THE LINE THAT HOLDS, SAID BACK PLAINLY ────────────────────────
 *
 * Three businesses working as a team is **a journey a person walks, never three
 * businesses sharing what they know about her.**
 *
 * So there is nothing in this file but links and words. **No visitor is
 * identified to anybody, no record is passed, no arrival is announced, and
 * nothing here learns that a person went.** The person carries her own record
 * and the businesses learn nothing about each other. Her creepy ruling, and a
 * team is exactly the argument that would bend it, so it is written here where
 * somebody would otherwise be tempted.
 *
 * ── UNIVERSE HAS NO NAME YET ──────────────────────────────────────────
 *
 * She is working around the word and has settled nothing, so it is **described
 * rather than linked**, and the name lives in one filter. The day she names it,
 * two lines change and no copy is rewritten.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

/**
 * The onward business, whenever she names it.
 *
 * @return array{name:string, where:string}
 */
function localilly_the_onward(): array {
	/**
	 * Filters the business a young person crosses into at eighteen.
	 *
	 * Both empty until she names it. An empty name renders as a description
	 * and an empty address renders no link at all, so the page is honest on
	 * the day before she decides and correct on the day after.
	 *
	 * @param array $onward Name and address.
	 */
	return (array) apply_filters(
		'localilly_the_onward',
		array(
			'name'  => '',
			'where' => '',
		)
	);
}

/**
 * The three doors, in the order a life passes through them.
 *
 * @return array<int, array<string, string>>
 */
function localilly_the_three(): array {
	$onward = localilly_the_onward();

	return array(
		array(
			'when'  => 'Fifteen To Eighteen',
			'name'  => 'LocaLilly',
			'says'  => 'You are in the right place. Set your own price, keep every dollar, and build a name a few doors from your own front gate.',
			'go'    => 'Create Your Business',
			'where' => home_url( '/create-your-business/' ),
			'here'  => true,
		),
		array(
			/*
			 * ── HER CORRECTION: PUT THE AGES ON IT ────────────────────
			 *
			 * She read my line and said it plainly: *grown up with you, that's
			 * very simple* — meaning it said nothing. **Her own shape is
			 * Universe is waiting for you, and Universe is perfect for you if
			 * you're 18 to 25.**
			 *
			 * So the range is stated rather than implied. **A person works out
			 * whether a door is theirs by reading a number rather than by
			 * reading a feeling**, and this passage exists for somebody
			 * deciding in one glance that they do not belong here.
			 *
			 * She used the words *too old for LocaLilly* while describing what
			 * one of us had written. I have taken the clarity she asked for and
			 * led on the invitation, since her standing law forbids a line
			 * that opens on what somebody has stopped being. **One word from
			 * her makes it more direct than this.**
			 */
			'when'  => 'Eighteen To Twenty-Five',
			'name'  => $onward['name'] ? $onward['name'] : 'Universe Is Waiting For You',
			'says'  => 'Your own business again, grown to your size. All of it comes with you — your name, your words, what people said about you, and every year of it. New there, and never new at the work.',
			'go'    => $onward['where'] ? 'Go To Universe' : '',
			'where' => $onward['where'],
			/*
			 * Opening shortly is a promise about a date, and there is no name
			 * and no domain yet. **Being built now is the same warmth and the
			 * same truth**, and the second half is the part that matters to a
			 * seventeen-year-old reading it.
			 */
			'soon'  => $onward['where'] ? '' : 'Being built now, and every month you work here is already counting toward it.',
		),
		array(
			'when'  => 'Whenever You Need It',
			'name'  => 'Know Where',
			/*
			 * ── I WROTE SOMEBODY ELSE'S DESCRIPTION ───────────────────
			 *
			 * This ended *at whatever age you are*, and Know Where is for
			 * thirteen to twenty-five. **My sentence overclaimed their reach**
			 * — generous in tone and wrong in fact, which is the worst kind on
			 * a page a young person trusts.
			 *
			 * The deeper fault is that I wrote it at all. The rule we are both
			 * working to is that **a provider's words are the provider's**:
			 * their listing of LocaLilly is mine to write, and my line about
			 * them is theirs. I asked them to respect it in one direction and
			 * broke it in the other in the same message.
			 *
			 * Corrected to make no age claim, and their own sentence is asked
			 * for and will replace this one.
			 */
			/*
			 * ── THEIR WORDS, NOT MINE ─────────────────────────────────
			 *
			 * Sent by Know Where after I asked, which is the rule working in
			 * the direction I had broken: **a provider's words are the
			 * provider's.** Mine claimed their reach and then made a joke of
			 * their name; theirs names a real woman two streets away who
			 * teaches drums, and claims nothing at all.
			 *
			 * They took the age clause out entirely rather than correcting it,
			 * and their reason is better than my fix was: **a range invites
			 * the same fault back in a different number.** What is true is
			 * that somebody near you does the thing, and the age sorts itself
			 * out at the listing.
			 */
			'says'  => 'A counsellor, a coach, a club, the woman two streets away who teaches drums. Whatever you are curious about, somebody near you does it.',
			'go'    => 'Find What You Need',
			'where' => 'https://knowwhere.net.au/',
		),
	);
}
