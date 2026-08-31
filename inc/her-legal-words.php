<?php
/**
 * The Legal Set.
 *
 * **Her ruling of 25 August settled the last blocker:** *the registered business
 * name goes on the terms and conditions and the ABN.* She holds a registered
 * name for each business, so these pages name **LocaLilly** as the entity.
 *
 * **Her own name appears nowhere.** And the ABN is left out entirely — the
 * register lists her as an Individual, Sole Trader, under her own legal name,
 * so publishing the number publishes her. That half stays with her.
 *
 * WRITTEN FOR THIS BUSINESS RATHER THAN COPIED
 *
 * Madame Monet's four are the family's register and this set answers to it.
 * **They are written to a woman who holds her own account; these are written
 * around a fifteen-year-old who cannot consent alone**, so the words are
 * LocaLilly's own rather than the same four with the nouns changed.
 *
 * AND NOBODY WRITES TO HER
 *
 * Her ruling of the same morning. **Every write-to-us is a control the person
 * presses** — the removal ask lives in `ask-for-it-back.php` and the pages
 * point at it rather than at an address.
 *
 * LOCALILLY'S BANNED LIST IS LONGER THAN THE FAMILY'S. It carries `nothing`
 * alongside the usual seven, so two lines that are clean on Madame Monet are
 * written differently here.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/** The registered business name, and the whole of what is published. */
const LOCALILLY_ENTITY = 'LocaLilly';

/**
 * The set, in the order a person meets them.
 *
 * @return array<string, array{title:string, under:string, parts:array<int, array{head:string, said:string}>}>
 */
function localilly_the_legal_set(): array {
	return array(
		'terms' => array(
			'title' => 'The Terms',
			'under' => 'Short on purpose, and written so you can read them in a minute.',
			'parts' => array(
				array(
					'head' => 'Who You Are Dealing With',
					'said' => LOCALILLY_ENTITY . ' runs this site. One person answers the letters and she reads all of them.',
				),
				array(
					'head' => 'Who This Is For',
					'said' => 'Young people aged fifteen to eighteen, and the neighbours who hire them. Fifteen is where the law lands for work like this, and a grown-up says yes before any young person opens a business here.',
				),
				array(
					'head' => 'What We Promise A Young Person',
					'said' => 'Your place costs what we said it costs. Your words stay yours, shown where you told us to show them, in the words you wrote. You keep every dollar you earn. You can stop whenever you like, and all of it comes with you.',
				),
				array(
					'head' => 'What We Promise A Neighbour',
					'said' => 'The young people here wrote their own pages, and an adult stands beside each of them, named. We hold the standard, and where somebody falls below it repeatedly, they go.',
				),
				array(
					'head' => 'What We Ask Of You',
					'said' => 'Write as yourself. Pay a young person what you said you would, on the day you said it. Speak to them the way you would want a first employer to speak to yours.',
				),
				array(
					'head' => 'Where Our Part Ends',
					'said' => 'We introduce you. The job you agree on belongs to you and to the person you are meeting, and the money is paid directly to them — it passes through us at no point.',
				),
				array(
					'head' => 'If We Get It Wrong',
					'said' => 'Tell us and we will put it right, and we will say what we did. A mistake of ours is ours to carry.',
				),
				array(
					'head' => 'When These Terms Change',
					'said' => 'We write to you before they do, in words you can read, and we say what changed and why.',
				),
				array(
					'head' => 'The Law That Holds Them',
					'said' => 'These terms sit under the law of Victoria, Australia. The rights the Australian Consumer Law gives you stand above anything written here.',
				),
			),
		),

		'privacy' => array(
			'title' => 'Your Privacy',
			'under' => 'What we hold, why we hold it, and how to have it back.',
			'parts' => array(
				array(
					'head' => 'What We Hold',
					'said' => 'Your name, your email address, your suburb and your street. For a young person we also hold their birthday, their house number, and the adult who looks after them.',
				),
				array(
					'head' => 'Why We Ask',
					'said' => 'Your name goes on your page. Your email is how a letter reaches you. Your suburb and street are how the work stays walking distance. We ask for each one at the moment we need it, and we say why while we are asking.',
				),
				array(
					'head' => 'What Is Public',
					'said' => 'A first name, a suburb and a street. That is the whole of it. A full name, a house number, a birthday and a grown-up stay here.',
				),
				array(
					'head' => 'What We Do With It',
					'said' => 'We introduce you to somebody nearby, and we write to you. It stays with us — never sold, never rented, never handed to anybody who wants to advertise at you.',
				),
				array(
					'head' => 'Your Words Belong To You',
					'said' => 'Anything you write about yourself is yours. We show it exactly where you told us to show it, in the words you wrote, and we correct none of it.',
				),
				array(
					'head' => 'How Long We Keep It',
					'said' => 'For as long as you want a place here. When you close it, your details go within thirty days.',
				),
				array(
					'head' => 'Ask For It Back',
					'said' => 'Press the control on the page written for a grown-up and it reaches us marked as yours. You hear back within the day, and we write again the day it is done.',
				),
				array(
					'head' => 'If Anything Slips',
					'said' => 'Where anything of yours is ever exposed, you hear it from us first, in plain words, on the day we know — along with what we have already done about it.',
				),
			),
		),

		'refunds' => array(
			'title' => 'If You Change Your Mind',
			'under' => 'Your money, and how to have it back.',
			'parts' => array(
				array(
					'head' => 'A Young Person&rsquo;s First Month',
					'said' => 'Free, and it always was. Ask within thirty days of your first payment and the whole of it comes back. One line to us is enough.',
				),
				array(
					'head' => 'After That',
					'said' => 'Ask any time and we stop the next payment. You keep your place until the month you have paid for runs out.',
				),
				array(
					'head' => 'The Neighbour&rsquo;s Dollar',
					'said' => 'Ask within thirty days and it comes back. It buys a verified name rather than a subscription, so it is asked for once and never again.',
				),
				array(
					'head' => 'If We Got It Wrong',
					'said' => 'Where it did not work, or was not what we said it was, tell us and we refund it whether or not thirty days have passed. That one is simply right.',
				),
				array(
					'head' => 'What A Young Person Has Earned Is Theirs',
					'said' => 'Money a neighbour paid them is theirs and it never comes back to us. It passed through us at no point.',
				),
				array(
					'head' => 'How Long It Takes',
					'said' => 'Back on your card within five working days, and a letter from us the moment it leaves.',
				),
				array(
					'head' => 'The Law, Again',
					'said' => 'Australian Consumer Law gives you rights that no policy can shorten, and ours sits on top of them rather than in front of them.',
				),
			),
		),

		'contact' => array(
			'title' => 'We Write Back',
			'under' => 'A person reads it, and a person answers.',
			'parts' => array(
				array(
					'head' => 'How To Reach Us',
					'said' => 'Every page here carries a control that reaches us — the grown-up&rsquo;s page for anything about a young person, and the atelier for anything about a business being built. Press it and it arrives marked as yours.',
				),
				array(
					'head' => 'When You Hear Back',
					'said' => 'Within the day. A person reads it and a person answers, and you are told what happened rather than that it was received.',
				),
				array(
					'head' => 'If It Is About A Young Person',
					'said' => 'Say so and it goes first. Anything about a person under eighteen is read the hour it arrives.',
				),
			),
		),
	);
}
