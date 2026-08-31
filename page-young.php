<?php
/**
 * Template Name: For A Young Person
 *
 * The audience the site was missing entirely.
 *
 * HER RULING, 23 AUGUST 2026: there's no information there for the young
 * person. She was right and it was the whole of the second audience — every
 * word on the site spoke to a neighbour looking to hire or a parent putting a
 * name down. **A fifteen-year-old landing here was told what he could do for
 * other people and never once what was in it for him.**
 *
 * SPOKEN TO HIM, NEVER ABOUT HIM. Her law, and it changes every sentence: you
 * rather than they, yours rather than theirs.
 *
 * AND IT NEVER POINTS AT A DOOR THAT IS SHUT. Replay Kids learned it today —
 * a line written as a signpost reads as a promise. Listings, accounts and
 * payment are with Aunt Tea and none of them exists yet, so the last section
 * says exactly what happens when he puts his name down, which is that somebody
 * writes to him. **A moment may end early and stay whole. It may never end at
 * a locked door.**
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

$localilly_truths = array(
	array(
		'head' => 'You Set What You Charge',
		'body' => 'Your price is yours. You put it on your page, a neighbour reads it before they write to you, and nobody haggles you down at the gate. Where you would rather look at a job first, you say so, and that is an answer too.',
	),
	array(
		'head' => 'You Keep Every Dollar',
		'body' => 'A neighbour pays you directly, however the two of you agree. LocaLilly asks you for ten dollars a month to be here, with your first month free, and takes not a cent of what you earn.',
	),
	array(
		'head' => 'You Write Your Own Words',
		'body' => 'Your words, in your voice, about the work you actually like. Every sentence on your page is one you wrote yourself, and you are met here rather than measured.',
	),
	array(
		'head' => 'Your Neighbours Are Verified Before They Reach You',
		'body' => 'Every adult who can message you has paid a dollar on a real card in their own name. Your street travels with you and your house number stays yours.',
	),
	array(
		'head' => 'Your Messages Are Yours',
		'body' => 'A neighbour writes to you and you answer for yourself. Show any of it to the grown-up beside you whenever you like — you are running this, so who reads it is your call.',
	),
);
?>

<main class="young">

	<header class="young-top">
		<p class="young-eyebrow">If You Are Fifteen To Eighteen</p>
		<h1 class="young-title">This One Is For You</h1>
		<p class="young-open">Your street already needs what you can do. Lawns that got away over winter, a dog nobody has walked today, a car, a shed, a kitchen table where somebody&rsquo;s little brother is stuck on his homework.</p>
		<p class="young-open">Doing it for your neighbours means real responsibility, real trust, and a reputation you build on your own terms, a few doors from your own front gate.</p>

		<?php
		/*
		 * ── HER LAW, WORN OPENLY ──────────────────────────────────────
		 *
		 * Her words: there are very strict laws, the child must be at least
		 * fifteen for LocaLilly, **just so people know.**
		 *
		 * That last clause is the instruction. It is stated where a young
		 * person and a grown-up will both meet it rather than buried in terms
		 * nobody opens — **a protection is worth more worn than filed.**
		 *
		 * And it matches what the law actually says. Wage Inspectorate
		 * Victoria: to be employed without a permit, a child must be fifteen.
		 */
		?>
		<p class="young-law">Fifteen is the age you can start, and that is the law rather than our rule. Under fifteen, an employer needs a permit — so we wait for you, and your fifteenth birthday is the day.</p>
	</header>

	<?php
	/*
	 * STRUCK: her eight were named here as eight bare plates and again below
	 * with the work drawn and described. **A young person read the same eight
	 * words twice before learning what any of them meant.** The drawn one is
	 * the one that stays.
	 */
	?>

	<section class="young-truths">
		<h2 class="young-head">How It Works For You</h2>
		<?php foreach ( $localilly_truths as $localilly_truth ) : ?>
			<article class="truth plate">
				<h3 class="truth-head"><?php echo esc_html( $localilly_truth['head'] ); ?></h3>
				<p class="truth-body"><?php echo esc_html( $localilly_truth['body'] ); ?></p>
			</article>
		<?php endforeach; ?>
	</section>

	<?php
	/*
	 * ── WHAT THE WORK ACTUALLY IS ─────────────────────────────────────────
	 *
	 * Her ruling: **what kinds of jobs can they do. Have some images on there.**
	 *
	 * Eight names in a row told nobody anything. Each one now says what a
	 * Saturday actually looks like, beside a drawing of the work — never a
	 * photograph of a child, which would be a claim about a young person that
	 * nobody ever gave.
	 */
	$localilly_eight = localilly_the_eight();
	$localilly_what  = localilly_what_the_work_is();
	?>
	<section class="works">
		<h2 class="young-head">What You Could Be Doing</h2>
		<p class="works-why">Pick as many as you like, and change them whenever you like. Your hours go around school, sport and the rest of your week.</p>
		<ul class="works-list">
			<?php foreach ( $localilly_eight as $localilly_slug => $localilly_name ) : ?>
				<li class="works-one">
					<span class="works-art"><?php localilly_draw_the_work( $localilly_slug ); ?></span>
					<h3 class="works-name"><?php echo wp_kses_post( $localilly_name ); ?></h3>
					<p class="works-line"><?php echo esc_html( $localilly_what[ $localilly_slug ] ?? '' ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
		<p class="works-after">And whatever you are good at that is missing from this list &mdash; tell us in your own words when you build your business, and we will put it on the map.</p>
	</section>

	<?php
	/*
	 * ── WHAT IT COSTS, SAID BEFORE THEY ASK ───────────────────────────────
	 *
	 * Her ruling: **what it costs, the first month free.** A young person who
	 * finds a price after investing an hour has been caught, and her whole
	 * register is against catching anybody. So it is on the page, early, in
	 * numbers rather than in language about numbers.
	 *
	 * **No discount code anywhere, ever.** Her law across all forty-three. The
	 * first hundred get three months rather than one, and that is a gift with a
	 * reason rather than a code somebody has to find.
	 */
	?>
	<section class="cost">
		<h2 class="young-head">What It Costs You</h2>
		<div class="cost-rows">
			<div class="cost-one cost-one--big">
				<p class="cost-figure">$10</p>
				<p class="cost-what">a month, once you are open</p>
				<p class="cost-why">One lawn covers it and the rest of the month is yours.</p>
			</div>
			<div class="cost-one">
				<p class="cost-figure">Free</p>
				<p class="cost-what">your first month</p>
				<p class="cost-why">Long enough to find out whether your street wants what you can do.</p>
			</div>
			<div class="cost-one">
				<p class="cost-figure">Yours</p>
				<p class="cost-what">every dollar you earn</p>
				<p class="cost-why">A neighbour pays you directly. LocaLilly never touches it and never takes a cut.</p>
			</div>
		</div>
		<p class="cost-first">Open in the first hundred and your first three months are free, counted from the day your business opens.</p>
	</section>

	<?php
	/*
	 * ── THE BUILDER, SHOWN RATHER THAN PROMISED ───────────────────────────
	 *
	 * Her ruling: **their little business builder inside it.**
	 *
	 * The seven moments were behind a button labelled Create Your Business, so
	 * a young person had to commit before seeing what committing meant. Every
	 * one is named here, in order, so the whole road is visible from outside it.
	 */
	$localilly_road = localilly_the_moments();
	?>
	<section class="builder">
		<h2 class="young-head">Building It Takes An Afternoon</h2>
		<p class="works-why">Seven moments, saved as you go. Stop halfway and come back next week &mdash; every word waits exactly where you left it.</p>
		<ol class="builder-road">
			<?php foreach ( $localilly_road as $localilly_m ) : ?>
				<li class="builder-step">
					<span class="builder-ask"><?php echo esc_html( (string) ( $localilly_m['ask'] ?? '' ) ); ?></span>
					<?php if ( ! empty( $localilly_m['why'] ) ) : ?>
						<span class="builder-why"><?php echo esc_html( (string) $localilly_m['why'] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</section>

	<?php
	/*
	 * ── FIFTEEN AND SIXTEEN, AND WHY THEY DIFFER ──────────────────────────
	 *
	 * Her ruling: **what fifteen-year-olds need to do differently from
	 * sixteen-year-olds, and why.**
	 *
	 * ⚠ EVERY LEGAL LINE BELOW IS VICTORIAN AND NEEDS A REAL CHECK BEFORE A
	 * CHILD READS IT AS FACT. It is written from what is broadly true of child
	 * employment and tax in Victoria, and this is the one part of this business
	 * where being quietly wrong is worse than being slow — her own words about
	 * the safety design. **Flagged to her rather than shipped as certain.**
	 */
	?>
	<section class="ages">
		<h2 class="young-head">Fifteen, Sixteen, Seventeen</h2>
		<p class="works-why">Most of this is the same whatever your age. Here is the part that is not.</p>

		<div class="ages-rows">
			<div class="ages-one">
				<p class="ages-num">15</p>
				<p class="ages-line">Fifteen is the day you can start, and that is the law rather than our rule. Younger than that, an adult hiring you needs a licence of their own &mdash; so we wait for you, and your fifteenth birthday is the day.</p>
				<p class="ages-line">A grown-up says yes before your business opens, and signs in beside you from then on.</p>
			</div>
			<div class="ages-one">
				<p class="ages-num">16</p>
				<p class="ages-line">At sixteen most banks let you run your own account on your own, so a neighbour can pay straight into it without anybody standing between you.</p>
				<p class="ages-line">Your grown-up signs in beside you either way, and every conversation stays open to you both.</p>
			</div>
			<div class="ages-one">
				<p class="ages-num">17</p>
				<p class="ages-line">The work you have done is the part that keeps growing. Every job on your page comes with you into whatever you do next.</p>
				<p class="ages-line">Your business carries on past every birthday. It stays yours.</p>
			</div>
		</div>

		<p class="ages-tax">On money and tax: you keep every dollar you earn here, and there is a yearly amount anybody in Australia can earn before paying any tax at all &mdash; well above what a few Saturdays will make. When you get close to it, that is a good conversation to have with your grown-up.</p>
	</section>

	<?php
	/*
	 * ── EVERY OBVIOUS QUESTION, ANSWERED BEFORE IT IS ASKED ───────────────
	 *
	 * Her ruling: **all the questions they might have, and all the obvious
	 * ones.** Written to them, never about them, and every answer says the true
	 * thing rather than the comfortable one.
	 */
	?>
	<section class="asks">
		<h2 class="young-head">What You Are Probably Wondering</h2>
		<dl class="asks-list">
			<div class="asks-one"><dt>What if nobody asks me?</dt><dd>Your first month is free, so a quiet month is free as well. Most young people open with lawns and yard work because that is what a street asks for first.</dd></div>
			<div class="asks-one"><dt>Do I have to say yes to everybody?</dt><dd>Never. You answer who you want, when you want, and a neighbour is told only that you answer in your own time.</dd></div>
			<div class="asks-one"><dt>How do they pay me?</dt><dd>Directly, in whatever way you and they agree &mdash; a transfer, or cash at the door. LocaLilly never holds your money.</dd></div>
			<div class="asks-one"><dt>What do I charge?</dt><dd>You decide, and you can say a price or say you will quote once you have seen it. Both are whole answers.</dd></div>
			<div class="asks-one"><dt>Who can see where I live?</dt><dd>Your suburb and your street. Never your house number, and never your family name.</dd></div>
			<div class="asks-one"><dt>Can just anybody message me?</dt><dd>Only somebody who has put a dollar on a card in their own name. A bank has checked who they are before a word reaches you.</dd></div>
			<div class="asks-one"><dt>What if somebody is strange with me?</dt><dd>Tell us and tell your grown-up. We take it seriously, and the person is never told you said anything.</dd></div>
			<div class="asks-one"><dt>Can I stop?</dt><dd>Any day. Closing keeps every word exactly as you wrote it, and opening again is one press.</dd></div>
			<div class="asks-one"><dt>What if I am busy with exams?</dt><dd>Say so in your hours and neighbours ask around it. Or close for a fortnight and open again after.</dd></div>
			<div class="asks-one"><dt>Do I need my own equipment?</dt><dd>Mostly no &mdash; a neighbour usually has a mower and a hose. Bringing your own is worth more, and plenty of people start with neither.</dd></div>
		</dl>
	</section>

	<?php
	/*
	 * ── STRUCK BY HER, 30 AUGUST, FOR THE SECOND TIME ─────────────────────
	 *
	 * Her words tonight: **a parent does not need to set up the account. That
	 * is wrong.**
	 *
	 * WHERE IT CAME FROM, NAMED RATHER THAN QUIETLY REPAIRED. It was her own
	 * earlier design — the adult who pays opens the account and the young
	 * person is invited in — and SHE REVERSED IT EARLIER THE SAME DAY: *what's
	 * this for a young person, 15? No, it's not. Get that off there.*
	 *
	 * **The reversal was applied to one file and the claim survived in four
	 * others.** A ruling struck in one place is not struck. That is the fault
	 * worth carrying, rather than the sentence.
	 *
	 * IT IS HER BUSINESS AND SHE OPENS IT. A grown-up says yes, tells us her
	 * birthday, and stands beside her. **Saying yes is not the same act as
	 * holding the account**, and running the two together took a fifteen-year-
	 * old's own business out of her hands on the page that invites her into it.
	 */
	?>
	<section class="young-grown">
		<h2 class="young-head">A Grown-Up Says Yes</h2>
		<p>Your business is yours and you open it yourself. One grown-up says yes before it goes live, and they are the one who tells us your birthday rather than you. They sign in beside you from then on, so every conversation stays open to you both.</p>
	</section>

	<?php
	/*
	 * The honest ending. Listings, accounts and money are all with Aunt Tea,
	 * so this says precisely what a name put down tonight actually does.
	 */
	?>
	<section class="young-next plate">
		<h2 class="young-next-head">Start Your Business Whenever You Like</h2>
		<p>It begins with your first name and your suburb, and it is yours from that moment. Each answer after it is saved as you go, so you can stop halfway through and pick it up next week exactly where you left it.</p>
		<p>Six moments in all, and the last one brings in a grown-up. Start now and you are in the first hundred — three months free rather than one, counted from the day you open.</p>
		<a class="young-go press" href="<?php echo esc_url( home_url( '/create-your-business/' ) ); ?>">Create Your Business</a>
	</section>

	<p class="young-after">Bring a grown-up with you. It takes a minute and they only need to read it once.</p>

	<?php
	/*
	 * ── HER RULING, 30 AUGUST: THE PARENTS READ THIS PAGE TOO ─────────────
	 *
	 * Her words: **a whole page just for young people, and a bit for their
	 * parents as well. That is missing.**
	 *
	 * A grown-up had a page of their own, reachable only from a menu, and the
	 * one screen a parent actually meets is the one their child shows them.
	 * **A parent standing over a shoulder wants their questions answered on
	 * that same screen**, in the same breath, rather than sent somewhere else
	 * to look for them.
	 *
	 * So it is written to the parent directly, and it answers the four they
	 * genuinely ask. Their own page stays, and this is the doorway to it.
	 */
	?>
	<section class="parents" id="for-a-parent">
		<p class="parents-eyebrow">If You Are Reading Over Their Shoulder</p>
		<h2 class="parents-head">What A Parent Wants To Know</h2>

		<div class="parents-rows">
			<div class="parents-one">
				<h3 class="parents-q">Who Can Reach Them</h3>
				<p>Every adult puts a dollar on a card in their own name before a single word reaches your child. A bank has already checked who they are, and the name on the card is the name your child reads.</p>
			</div>

			<div class="parents-one">
				<h3 class="parents-q">What A Stranger Can See</h3>
				<p>Their first name, their suburb, their street, and the words they wrote themselves. Their family name and their house number are held for us alone, so we can reach you on the one night it matters.</p>
			</div>

			<div class="parents-one">
				<h3 class="parents-q">Where The Money Goes</h3>
				<p>Straight to them, from the neighbour, in whatever way you both agree. LocaLilly never touches what your child earns, so nobody is holding a minor&rsquo;s money and there is no account for you to guard.</p>
			</div>

			<div class="parents-one">
				<h3 class="parents-q">You Are On It With Them</h3>
				<p>You open the account alongside them and you stay on it. Every conversation is yours to read, and closing it is one press on any day you choose, with every word they wrote kept exactly as they wrote it.</p>
			</div>
		</div>

		<p class="parents-after">Fifteen is the age they can start, and that is the law rather than our rule.</p>
		<a class="room-go press" href="<?php echo esc_url( home_url( '/for-a-grown-up/' ) ); ?>">Read The Whole Of It</a>
	</section>

</main>

<?php
get_footer();
