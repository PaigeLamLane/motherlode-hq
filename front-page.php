<?php
/**
 * The front page.
 *
 * 31 August 2026 — hero rebuilt clean against her reference image
 * (motherlodehero.png), a fresh set of classes (lode-*) rather than another
 * patch on the hero-lode-* rules, which had accumulated seven contradicting
 * passes across the day. Only change from the reference: the bottom strip
 * heading, her words directly — "You should never have to choose."
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="lode-hero">
	<div class="in lode-hero-grid">
		<div class="lode-hero-copy">
			<h1 class="lode-hero-h1"><span class="lode-hero-h1-lead">The Untapped</span><br><span class="lode-hero-h1-word">Lode<span class="lode-hero-dot" aria-hidden="true"></span></span></h1>

			<p class="lode-hero-define"><em>Lode</em> — a rich, continuous vein of ore, the seam that makes the whole find worth digging for.</p>

			<p class="lode-hero-lede">
				Skilled parents, home with their children, earning by the hour
				from real expertise. Businesses getting exactly that skill,
				without the overhead of a full-time hire.
			</p>

			<div class="lode-hero-ctas">
				<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Discover the Lode <span aria-hidden="true">&rarr;</span></a>
				<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/join/?as=talent' ) ); ?>">Offer your expertise <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>

		<div class="lode-hero-mark">
			<?php
			/*
			 * 31 August 2026, third pass — the old lode-mark-*.webp files were
			 * all silently 348x348 regardless of filename (checked via the
			 * browser's own naturalWidth/naturalHeight), so the mark was
			 * being upscaled from a tiny source no matter what CSS size it
			 * was given — that's why "bigger" never actually looked sharp
			 * or confident. Regenerated clean from her original high-res
			 * reference file, background removed properly, real aspect
			 * ratio (0.86 tall:wide, not square).
			 */
			$lode_mark_base = get_stylesheet_directory_uri() . '/assets/img/lode-mark-clean-';
			/*
			 * 31 August 2026 — a browser/edge cache had a stale, tiny
			 * (348x348) response cached against these exact filenames from
			 * before the real asset existed at this path, and kept serving
			 * it after the real file was uploaded — LiteSpeed's page-cache
			 * purge doesn't touch that. A version query string forces every
			 * cache layer to treat this as a new resource.
			 */
			$lode_mark_v = '2';
			?>
			<img
				src="<?php echo esc_url( $lode_mark_base . '1100.webp?v=' . $lode_mark_v ); ?>"
				srcset="<?php echo esc_attr( $lode_mark_base . '700.webp?v=' . $lode_mark_v . ' 700w, ' . $lode_mark_base . '1100.webp?v=' . $lode_mark_v . ' 1100w, ' . $lode_mark_base . '1600.webp?v=' . $lode_mark_v . ' 1600w, ' . $lode_mark_base . '2200.webp?v=' . $lode_mark_v . ' 2200w' ); ?>"
				sizes="(min-width: 900px) 56vw, 92vw"
				width="1600" height="1378" alt="" fetchpriority="high">
		</div>
	</div>

	<div class="lode-strip">
		<div class="in lode-strip-in">
			<p class="lode-strip-head">You Should Never<br><strong>Have To Choose.</strong></p>
			<span class="lode-strip-divider" aria-hidden="true"></span>
			<div class="lode-paths">
				<a class="lode-path" href="<?php echo esc_url( home_url( '/join/?need=help' ) ); ?>">
					<span class="lode-path-arrow lode-path-arrow--a" aria-hidden="true">&rarr;</span>
					<span class="lode-path-text">I need<br><span class="lode-path-accent lode-path-accent--a">exceptional help</span></span>
				</a>
				<a class="lode-path" href="<?php echo esc_url( home_url( '/join/?have=expertise' ) ); ?>">
					<span class="lode-path-arrow lode-path-arrow--b" aria-hidden="true">&rarr;</span>
					<span class="lode-path-text">I have expertise<br><span class="lode-path-accent lode-path-accent--b">to offer</span></span>
				</a>
			</div>
		</div>
	</div>
</section>

<?php
/*
 * 31 August 2026 — her ruling: the search band goes. "Big ugly thing."
 * A real, narrow, elegant search comes later, thought through properly
 * rather than borrowed from LocaLilly's own search block.
 */
?>

<?php
/*
 * ── THE LODE MAP ───────────────────────────────────────────────────────
 * Her eight, matching the hero's own mark exactly.
 */
?>
<section class="sec sec--posts">
	<div class="in">
		<p class="eyebrow float">Real Skill, Every Field</p>

		<?php
		$localilly_categories = array(
			'post_admin'      => 'Admin',
			'post_strategy'   => 'Strategy',
			'post_design'     => 'Design',
			'post_finance'    => 'Finance',
			'post_education'  => 'Education',
			'post_technology' => 'Technology',
			'post_wellbeing'  => 'Wellbeing',
			'post_home'       => 'Home',
		);
		$localilly_i = -1;
		?>

		<ul class="rail">
			<?php foreach ( $localilly_categories as $localilly_key => $localilly_category ) : ?>
				<?php ++$localilly_i; ?>
				<li class="rail-item float" style="--n: <?php echo (int) $localilly_i; ?>">
					<?php $localilly_slug = str_replace( array( 'post_', '_' ), array( '', '-' ), $localilly_key ); ?>
					<a class="plate post-face press<?php echo localilly_has_picture( $localilly_key ) ? ' has-picture' : ''; ?>"
						href="<?php echo esc_url( add_query_arg( 'doing', $localilly_slug, home_url( '/join/' ) ) ); ?>">
						<?php localilly_picture( $localilly_key, 'medium_large', 'behind' ); ?>
						<span class="post-name"><?php echo wp_kses_post( $localilly_category ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<p class="rail-hint">Browse any time</p>
	</div>
</section>

<?php
/*
 * ── A LODE IN EVERY FIELD ────────────────────────────────────────────
 * Her instruction, 31 August: take the eight fields from the scroll
 * above — she called that "not bad" — and give them a real section each
 * lives in, not just a passing rail. Copy drafted here, not hers or
 * Verity's yet — worth a pass from Verity before this is called final.
 */
$lode_fields = array(
	array(
		'name'  => 'Admin',
		'said'  => 'The steady hand behind a business that runs on time — invoicing, scheduling, the calm nobody else sees.',
	),
	array(
		'name'  => 'Strategy',
		'said'  => 'A clear head, brought in for two hours a week, that changes the next two years.',
	),
	array(
		'name'  => 'Design',
		'said'  => 'An eye trained over a decade, given exactly the room a Tuesday afternoon allows.',
	),
	array(
		'name'  => 'Marketing',
		'said'  => 'The campaign, the launch, the whole plan behind getting found — run by someone who has actually run one.',
	),
	array(
		'name'  => 'Finance',
		'said'  => 'Numbers held with the same care she has always held everything else — bookkeeping, BAS, the whole ledger.',
	),
	array(
		'name'  => 'Education',
		'said'  => 'What she already knows how to teach, offered to the one child — or the twenty — who need exactly that.',
	),
	array(
		'name'  => 'Technology',
		'said'  => 'The quiet architecture of things that work, built in the hours that are actually hers.',
	),
	array(
		'name'  => 'Health',
		'said'  => 'A qualification that used to sit inside someone else\'s roster — physio, OT, nutrition — now working on her own terms.',
	),
	array(
		'name'  => 'Legal',
		'said'  => 'Real qualifications — contracts, compliance, advice — without a whole firm\'s overhead attached.',
	),
	array(
		'name'  => 'HR & People',
		'said'  => 'The people expertise a growing business needs long before it can justify a whole department.',
	),
	array(
		'name'  => 'Project Management',
		'said'  => 'The one person who makes six moving parts read like a single calm plan.',
	),
	array(
		'name'  => 'Copywriting',
		'said'  => 'Words that actually sound like the business, written by someone who has done it professionally.',
	),
	array(
		'name'  => 'Home',
		'said'  => 'The organising, the styling, the making-beautiful — real skill, paid properly at last.',
	),
);
?>
<section class="sec lode-fields">
	<div class="in">
		<p class="eyebrow float" style="text-align:center;">Every Field, In Full</p>
		<h2 class="head lift float" style="text-align:center;">A Lode In Every Field.</h2>
		<div class="lode-fields-grid">
			<?php foreach ( $lode_fields as $lode_fi => $lode_field ) : ?>
				<div class="lode-field-card float" style="--n: <?php echo (int) $lode_fi; ?>">
					<span class="lode-field-name"><?php echo esc_html( $lode_field['name'] ); ?></span>
					<p class="lode-field-said"><?php echo esc_html( $lode_field['said'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/*
 * ── IN THEIR OWN WORDS ─────────────────────────────────────────────────
 * No cards, no avatars, no gradient text. Her words lead; a real photo
 * carries the warmth the quotes alone can't. Placeholder photo — a real
 * professional's portrait replaces it the day she's real.
 */
?>
<section class="sec sec--voices">
	<div class="in voices-grid">
		<div class="voices-photo">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/voice-photo.jpg' ); ?>" alt="">
			<p class="voices-photo-cap">"My clients don't need me nine to five. They need me good, and on time."</p>
		</div>
		<div class="voices-list">
			<p class="eyebrow">In Their Own Words</p>
			<h2 class="voices-head">The People Already Here.</h2>

			<div class="voice">
				<span class="voice-mark"></span>
				<p class="voice-quote">Numbers were always my thing. Now they fit around drop-off and pick-up too, and nobody asked me to shrink either one.</p>
				<div class="voice-byline">
					<span class="voice-name">Rosa M.</span>
					<span class="voice-role">Bookkeeper &amp; BAS Agent, Preston</span>
					<span class="voice-hours">9am – 2:30pm, weekdays</span>
				</div>
			</div>

			<div class="voice">
				<span class="voice-mark"></span>
				<p class="voice-quote">I do the hours nap time gives me. It's enough — I checked, twice, before I believed it myself.</p>
				<div class="voice-byline">
					<span class="voice-name">Aiden T.</span>
					<span class="voice-role">Graphic Designer, remote</span>
					<span class="voice-hours">Two afternoons a week</span>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="sec sec--steps" id="how-it-works">
	<div class="in">
		<p class="eyebrow float" style="text-align:center;">How It Works</p>
		<ol class="steps">

			<li class="step float">
				<span class="step-num">1</span>
				<h3 class="head step-head">She Builds Her Profile, Her Way</h3>
				<p class="body">
					A few honest questions about what she's brilliant at — never a form, never a résumé upload. $29 a month, first month free.
				</p>
			</li>

			<li class="step float">
				<span class="step-num">2</span>
				<h3 class="head step-head">The Right Person Finds Her</h3>
				<p class="body">
					Households and businesses search by what they need and where they are, then book her directly.
				</p>
			</li>

			<li class="step float">
				<span class="step-num">3</span>
				<h3 class="head step-head">The Work Happens, The Career Keeps Going</h3>
				<p class="body">
					Paid properly, held safely until the job's done, released the moment it is.
				</p>
			</li>

		</ol>
	</div>
</section>

<?php
/*
 * ── SHE'S CARRYING A LODE ────────────────────────────────────────────
 * 31 August 2026, fourth pass — separated again, her direct words: "I
 * don't want the dads being tacked onto the mothers; have something
 * that separates them... way more copy and design." Two real sections
 * now, each its own moment, not a mirror of the other.
 */
?>
<section class="sec lode-moms">
	<div class="in lode-moms-grid">
		<div class="lode-moms-copy">
			<p class="eyebrow">Hers First</p>
			<h2 class="head lift">She's Carrying A Lode.</h2>
			<p class="body body--wide">Too many mothers have felt they had to choose between a career and being the one who's there. MotherLode HQ exists so that feeling gets an answer — money that's genuinely hers, earned in the hours she actually has, on terms nobody else set for her.</p>
			<p class="body body--wide">For some, it stays two hours a day, and that's enough. For others, it's the first thread of something that becomes entirely her own — a business, a name, a life she built herself.</p>
			<div class="lode-hero-ctas">
				<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Discover the Lode <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</div>
</section>

<?php
/*
 * ── HE'S CARRYING A LODE TOO ─────────────────────────────────────────
 * Its own section, its own layout — text one side, the LOAD/LODE
 * wordplay built big on the other, rather than a smaller mirror of the
 * section above. Copy drafted here, not hers or Verity's yet.
 */
?>
<section class="sec lode-dads">
	<div class="in lode-dads-grid2">
		<div class="lode-dads-copy">
			<p class="eyebrow">For The Fathers Doing This</p>
			<h2 class="head lift">He's Carrying A Lode Too.</h2>
			<p class="body body--wide">He's often the only father in the pick-up line, and somebody has usually assumed he's minding his own children for the afternoon. He isn't. He's raising them, full stop, the same as she is.</p>
			<p class="body body--wide">Whatever career he built before — the trade, the spreadsheet, the design work, the ten years he's actually good at — doesn't stop mattering because he's the one home now. It needs exactly what hers does: hours that fit around nap time and school pick-up, paid properly, never treated as a favour.</p>
			<div class="lode-hero-ctas">
				<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/join/?as=talent' ) ); ?>">Offer your expertise <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
		<div class="lode-dads-word" aria-hidden="true">
			<span class="lode-dads-load">LO<span class="lode-dads-strike">A</span>D</span>
			<span class="lode-dads-arrow">&darr;</span>
			<span class="lode-dads-lode">LODE.</span>
			<p class="lode-dads-caption">Call it a load. We call it a lode — his, exactly as much as hers.</p>
		</div>
	</div>
</section>

<?php
/*
 * 31 August 2026 — Layers of Trust dropped for now: her own words, "may
 * not need to be there," and what was there still carried LocaLilly's
 * old contrast/legibility problems underneath the new text. Cut rather
 * than half-fixed a section she isn't sure belongs.
 */
?>

<?php
/*
 * ── PURPOSE. PASSION. POTENTIAL. POSSIBILITY. ───────────────────────────
 * Her own four words, from IMAGENIQ. 31 August, second pass — her words:
 * "you don't have to list that there... that would be lower down." Moved
 * from mid-page, right before the closing CTA now, quiet rather than
 * competing with the two Lode sections above. Copy drafted here, not
 * hers or Verity's yet.
 */
?>
<section class="sec lode-four">
	<div class="in">
		<h2 class="head lift float" style="text-align:center;">Purpose. Passion. Potential. Possibility.</h2>
		<p class="body body--wide float" style="text-align:center; margin-left:auto; margin-right:auto;">Every profile here carries all four.</p>
		<div class="lode-four-grid">
			<div class="lode-four-card float" style="--n:0">
				<span class="lode-four-word">Purpose</span>
				<p>The reason the work matters to her, stated plainly, never assumed on her behalf.</p>
			</div>
			<div class="lode-four-card float" style="--n:1">
				<span class="lode-four-word">Passion</span>
				<p>What she is good at because she has always loved it, not despite everything else she carries.</p>
			</div>
			<div class="lode-four-card float" style="--n:2">
				<span class="lode-four-word">Potential</span>
				<p>The client not yet found, the year not yet lived, waiting on the other side of one honest profile.</p>
			</div>
			<div class="lode-four-card float" style="--n:3">
				<span class="lode-four-word">Possibility</span>
				<p>What two hours a week becomes, given enough of them, and enough belief to start.</p>
			</div>
		</div>
	</div>
</section>

<section class="sec sec--close">
	<div class="in">
		<h2 class="close-head">Come And See What's Waiting.</h2>
		<div class="lode-hero-ctas" style="justify-content:center;">
			<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Discover the Lode <span aria-hidden="true">&rarr;</span></a>
			<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/join/?as=talent' ) ); ?>">Offer your expertise <span aria-hidden="true">&rarr;</span></a>
		</div>
	</div>
</section>

<?php
get_footer();
