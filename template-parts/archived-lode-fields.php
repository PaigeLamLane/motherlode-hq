<?php
/**
 * A Lode In Every Field — brought back and rebuilt, 4 September 2026.
 *
 * Struck 1 September for landing right after the hero as "a wall of ten
 * cards... boring, choice overload." The placement was the fault, not
 * the content — real, specific one-line descriptions, not a generic
 * category list. Kept whole rather than deleted, exactly as parked.
 *
 * Brought back the night she called the homepage's lower half "no good
 * at all... there's just nothing" — this is real, scannable substance
 * where there was a fabricated testimonial instead (see front-page.php's
 * own note on that). Rebuilt as an opening cloud: native <details>
 * elements, closed by default as thirteen gradient words that wrap in
 * one flowing line, each opening to its real description on its own —
 * no JavaScript, fully keyboard and screen-reader accessible because
 * that's what <details> already is, and nothing here can render broken
 * without it.
 *
 * Also fixed here: three of the descriptions defaulted the generic
 * professional to "she/her" (Education, Finance, Health) — the same
 * sitewide bug found and fixed elsewhere on 3 September, missed here
 * because this file wasn't wired into any live template that night.
 *
 * @package MotherLodeHQ
 */

defined( 'ABSPATH' ) || exit;

$lode_fields = array(
	array(
		'name' => 'Admin',
		'said' => 'The steady hand behind a business that runs on time — invoicing, scheduling, the calm nobody else sees.',
	),
	array(
		'name' => 'Strategy',
		'said' => 'A clear head, brought in for two hours a week, that changes the next two years.',
	),
	array(
		'name' => 'Design',
		'said' => 'An eye trained over a decade, given exactly the room a Tuesday afternoon allows.',
	),
	array(
		'name' => 'Marketing',
		'said' => 'The campaign, the launch, the whole plan behind getting found — run by someone who has actually run one.',
	),
	array(
		'name' => 'Finance',
		'said' => 'Numbers held with the same care they hold everything else — bookkeeping, BAS, the whole ledger.',
	),
	array(
		'name' => 'Education',
		'said' => 'What they already know how to teach, offered to the one child — or the twenty — who need exactly that.',
	),
	array(
		'name' => 'Technology',
		'said' => 'The quiet architecture of things that work, built in the hours that are actually theirs.',
	),
	array(
		'name' => 'Health',
		'said' => 'A qualification that used to sit inside someone else\'s roster — physio, OT, nutrition — now working on their own terms.',
	),
	array(
		'name' => 'Legal',
		'said' => 'Real qualifications — contracts, compliance, advice — without a whole firm\'s overhead attached.',
	),
	array(
		'name' => 'HR & People',
		'said' => 'The people expertise a growing business needs long before it can justify a whole department.',
	),
	array(
		'name' => 'Project Management',
		'said' => 'The one person who makes six moving parts read like a single calm plan.',
	),
	array(
		'name' => 'Copywriting',
		'said' => 'Words that actually sound like the business, written by someone who has done it professionally.',
	),
	array(
		'name' => 'Home',
		'said' => 'The organising, the styling, the making-beautiful — real skill, paid properly at last.',
	),
);
?>
<section class="sec lode-fields">
	<div class="in">
		<p class="eyebrow float" style="text-align:center;">Every Field, In Full</p>
		<h2 class="head lift float" style="text-align:center;">A Lode In Every Field.</h2>
		<div class="lode-fields-cloud">
			<?php foreach ( $lode_fields as $lode_fi => $lode_field ) : ?>
				<details class="lode-field-pill" style="--n: <?php echo (int) $lode_fi; ?>">
					<summary class="lode-field-name"><?php echo esc_html( $lode_field['name'] ); ?></summary>
					<p class="lode-field-said"><?php echo esc_html( $lode_field['said'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
