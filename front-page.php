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

/*
 * 1 September 2026 — the mark stopped being an image entirely. Checked
 * the actual served lode-mark-*.webp file directly and found her
 * constellation pattern (the nine dots, the web of lines, the category
 * labels) baked flat into the same file as the LODE letters — frozen,
 * un-animatable, and about to be doubled if a live version were laid on
 * top of it. Her words: "turn my constellation pattern into something
 * that is absolutely stunningly beautiful. That's hugely important."
 * Retired the raster file from both places it appeared (the hero and
 * the threshold) in favour of template-parts/lode-mark.php — one real,
 * live SVG: gradient letters plus genuine animated nodes and lines,
 * shared by both so they can never quietly drift apart from each other.
 * The old lode-mark-*.webp files are untouched on the server, not
 * deleted, in case anything else still points at them.
 */
?>

<?php
/*
 * ── THE THRESHOLD ────────────────────────────────────────────────────
 * 1 September 2026, second pass — her words the first time round: "that
 * is not a moment... make them like they're 3D, they're coming out...
 * don't give me flat, don't give me boring... you put my magnificent
 * image tiny." Rebuilt bigger in every dimension that matters: each word
 * now fills real width of the screen, arrives with actual depth (layered
 * colour, not a flat fade), the mark is the dominant thing on the screen
 * rather than an icon, and the two paths are the moment's own resolution
 * — real buttons, right here, not a preview of something further down.
 * Never a dark ground — her standing word on that — the same soft pink
 * the rest of the site stands on, with her own gradient breathing behind
 * the words instead.
 *
 * Second pass, same day — her words: "I told you to get rid of the
 * words. I don't want your first part of the intro — fucking ugly. I
 * just want my logo at the top, then the LODE." The whole breath-paced
 * phrase reveal (the "MotherLode HQ" title card, "You / should never /
 * have to choose") is gone. What's left is simpler and calmer: her real
 * logo, then the mark — and the movement she actually wants lives in the
 * mark's own floating category words now, not in text beats or bouncing
 * buttons.
 *
 * Shown on every single visit, for everyone — her ruling, given
 * directly: "the welcome should be so beautiful that everyone wants to
 * see it all the time." Skipped outright only for anyone whose browser
 * has asked for reduced motion, and never able to trap anyone: the two
 * paths are real links the moment CSS reveals them, whether or not
 * JavaScript ever runs at all.
 */
?>
<div class="lode-threshold" id="lode-threshold">
	<div class="lode-threshold-glow" aria-hidden="true"></div>
	<div class="lode-threshold-ring" aria-hidden="true"></div>
	<div class="lode-threshold-inner">
		<img class="lode-threshold-logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/motherlode-logo.png' ); ?>" alt="MotherLode HQ" width="450" height="300">
		<div class="lode-threshold-finale">
			<div class="lode-threshold-mark">
				<?php get_template_part( 'template-parts/lode-mark' ); ?>
			</div>

			<?php
			/*
			 * 1 September 2026, third pass — her words: "let's play. You
			 * should never have to choose; it needs to come in under
			 * [the] Lode, but give it some space before you bring it in
			 * and before the buttons come in." Back as one clean line —
			 * not broken into the word-by-word beats she called ugly
			 * earlier — sitting between the mark and the fork, each with
			 * real space held before it arrives.
			 */
			?>
			<p class="lode-threshold-choose">You Should Never <strong>Have To Choose.</strong></p>

			<?php
			/*
			 * Real bug, found and named precisely: "a visible double gap
			 * inside both button labels." The label text sat as bare text
			 * nodes directly inside a flex container with `gap` — gap
			 * inserts space between every child box, including the
			 * anonymous boxes browsers wrap bare text in, so it opened a
			 * second, unwanted gap mid-sentence. One span around the
			 * whole label, same fix as the strip's own paths already had.
			 */
			?>
			<div class="lode-threshold-paths">
				<a class="lode-path lode-threshold-path lode-path--a" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">
					<span class="lode-path-text">I need <strong>exceptional help</strong></span>
					<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
				</a>
				<a class="lode-path lode-threshold-path lode-path--b" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">
					<span class="lode-path-text">I'm carrying <strong>a mother lode of expertise</strong></span>
					<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
				</a>
			</div>
		</div>
	</div>
	<button type="button" class="lode-threshold-skip" id="lode-threshold-skip">Skip <span aria-hidden="true">&rarr;</span></button>
</div>
<noscript><style>.lode-threshold{display:none!important;}</style></noscript>
<script>
(function(){
	/*
	 * 1 September 2026 — her ruling, final: "I don't want one per
	 * browser tab. Get rid of that. The welcome should be so beautiful
	 * that everyone wants to see it all the time." Not a dev-mode
	 * toggle — a real decision about what this moment is. It plays in
	 * full on every single visit, for everyone, permanently. The only
	 * two ways it doesn't: a browser that asks for reduced motion
	 * (skipped outright, below), and the Skip control for anyone who
	 * wants past it right now.
	 */
	var el = document.getElementById('lode-threshold');
	if (!el) return;
	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if ( reduced ) { el.parentNode.removeChild(el); return; }
	document.documentElement.classList.add('lode-threshold-active');
	var auto = null;
	function dismiss() {
		if (!el.parentNode) return;
		if (auto) { window.clearTimeout(auto); auto = null; }
		document.documentElement.classList.remove('lode-threshold-active');
		el.classList.add('is-leaving');
		window.setTimeout(function(){ if (el.parentNode) { el.parentNode.removeChild(el); } }, 900);
	}
	var skip = document.getElementById('lode-threshold-skip');
	if (skip) { skip.addEventListener('click', dismiss); }

	/*
	 * 4 September 2026 — her words: "I don't want to skip or take the
	 * skip out. Just have the entry and then it goes into the website."
	 * Skip stays, unchanged, for anyone who wants past it sooner. But
	 * until now the entry had no ending of its own — it played out and
	 * then simply sat there, fully finished, going nowhere until
	 * somebody clicked something. It now carries itself into the site:
	 * once the last thing on screen (the two paths, arriving at 3400ms
	 * + their own 700ms fade) has had a real few seconds to be read,
	 * it lifts away on its own — the same graceful exit Skip already
	 * triggers, never a different, lesser one for whoever waits.
	 */
	auto = window.setTimeout(dismiss, 7800);
})();
</script>

<?php
/*
 * ── THE HERO, REBUILT AGAIN — 1 September 2026 ──────────────────────────
 * Her exact words, given directly, in order: "my logo, then put the logo
 * up in the corner, then a massive L-O-D-E. Do it better — much better.
 * And then underneath that, you should never have to choose, and then
 * the buttons." The logo is already the corner of the topbar above this
 * — nothing else on the page needed a second copy of it. Everything else
 * here is new: one centred column, the mark itself now the entire hero
 * (no heading competing with it, no lede paragraph beside it), the
 * choose-line underneath it, the fork underneath that.
 *
 * The two paths are rebuilt too, not just moved — Aunt Tea's measured
 * critique of the old ones stands: heavy gradient-filled pills read as
 * "the default button of every product made since 2015," fighting the
 * mark's fine-lined, airy quality rather than serving it. Outlined,
 * single-colour, quieter — closer to what the mark itself is doing.
 */
?>
<section class="lode-hero">
	<div class="in lode-hero-stack">
		<div class="lode-hero-mark lode-hero-mark--big">
			<?php get_template_part( 'template-parts/lode-mark' ); ?>
		</div>

		<p class="lode-hero-choose">You Should Never <strong>Have To Choose.</strong></p>

		<div class="lode-paths">
			<a class="lode-path lode-path--a" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">
				<span class="lode-path-text">I need <strong>exceptional help</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
			<a class="lode-path lode-path--b" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">
				<span class="lode-path-text">I'm carrying <strong>a mother lode of expertise</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
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
 * ── THE THREE FACTS — removed, 3 September 2026 ──────────────────────
 * Built 2 September, struck the next day — her words, direct: "I don't
 * want the three facts. Remember, I told you to get rid of the three
 * facts." Taken out rather than hidden, so a later pass doesn't find
 * a commented-out block and wonder if it was meant to come back.
 */
?>

<?php
/*
 * ── THE SIGNPOST — 2 September 2026, made real on the homepage ──────
 * Built and iterated on a separate practice page first (three real
 * passes on her feedback — "a flag? That's just a fucking box," then
 * "I don't want it to look like a flag," each one a genuine change,
 * not a restyle) before she confirmed she wanted it here. History and
 * the real Chromium bug found building it are kept in full at
 * template-parts/signpost.php's own header comment, not repeated here.
 */
get_template_part( 'template-parts/signpost' );
?>

<?php
/*
 * ── THE LODE MAP ───────────────────────────────────────────────────────
 * 1 September 2026 — removed outright, her ruling: LocaLilly's own
 * scrolling rail component, carrying a real scroll bug (something sitting
 * ~2 inches from the left edge that wouldn't scroll with the rest), and
 * redundant anyway — "A Lode In Every Field" below already shows all 13
 * categories properly, in the page's own voice rather than a borrowed
 * carousel. Not replaced with anything; that section does this job now.
 */
?>

<?php
/*
 * ── A LODE IN EVERY FIELD — PARKED, 1 September 2026 ─────────────────
 * Her words: "we don't want a category list — get rid of it... it's
 * going to go, but keep it and park it somewhere for me." This was the
 * "wall of ten cards" straight after the hero that she called boring and
 * a choice overload. The two-gateway fork in the strip above does that
 * job now. Full markup, copy and the gradient-card styling are kept —
 * not deleted — in template-parts/archived-lode-fields.php, ready to be
 * called back in wherever it belongs next (my instinct: inside the
 * business-facing path, once that page exists).
 */
?>

<?php
/*
 * ── BE THE FIRST NAME HERE — rebuilt 14 September 2026, replacing
 * "You'd Be Among The First" ────────────────────────────────────────
 * Her words, direct, walking the live site: the hero is amazing and
 * then we lose it. Found exactly where: this section, immediately
 * after the signpost, opened on absence — "Nobody's live here yet" —
 * sitting on plain cream behind a decorative mark so faint (three
 * small dots, hairline strokes) it read as empty space rather than
 * as a graphic. Two things dying in the same breath: the words and
 * the picture both went quiet at the exact point the hero's own
 * energy needed somewhere to land.
 *
 * The honesty underneath is right and stays — her own truth law
 * forbids a claim about a person that was never given, and this
 * business genuinely has no profiles live yet. What changes is the
 * order the sentence is said in. Leading on what she gets rather
 * than on what doesn't exist yet is the same fact, said as a door
 * rather than an apology — and it closes on a real line instead of
 * trailing off.
 *
 * The mark itself is rebuilt heavier — real weight, real colour,
 * genuinely visible — because a graphic nobody can see does the exact
 * same damage as a blank stretch of page.
 */
?>
<section class="sec sec--first">
	<div class="in first-grid">
		<div class="first-mark" aria-hidden="true">
			<span class="first-node first-node--a"></span>
			<span class="first-node first-node--b"></span>
			<span class="first-node first-node--c"></span>
			<svg class="first-lines" viewBox="0 0 200 200" preserveAspectRatio="none">
				<line x1="40" y1="150" x2="100" y2="50" />
				<line x1="100" y1="50" x2="165" y2="120" />
			</svg>
			<span class="first-mark-num">1st</span>
		</div>
		<div class="first-copy">
			<p class="eyebrow">The Ground Floor</p>
			<h2 class="head lift">Be The First Name Here.</h2>
			<p class="body body--wide">This early, a professional is found before the field crowds — and a business gets first pick of exactly who they need, before anyone else has noticed her either. Somebody has to be first. It might as well be you.</p>
			<div class="lode-hero-ctas">
				<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Build Your Profile <span aria-hidden="true">&rarr;</span></a>
				<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">Find Exceptional Help <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</div>
</section>

<?php
/*
 * ── HOW IT WORKS, REBUILT — 1 September 2026 ────────────────────────────
 * Her words: "the actual website looking much better because you're
 * very, very lazy on the website design." Fair, and specific here: this
 * was three identical columns with a small coloured square and a
 * number — the exact generic template pattern the mark itself is the
 * opposite of. Numerals now carry the mark's own gradient, and a real
 * connecting line (the same visual language as the constellation) runs
 * beneath them, so the page's two halves finally look like one thing.
 */
?>
<section class="sec sec--steps" id="how-it-works">
	<div class="in">
		<p class="eyebrow float" style="text-align:center;">How It Works</p>
		<div class="steps-track" aria-hidden="true"><span></span></div>
		<ol class="steps">

			<li class="step float">
				<span class="step-num">01</span>
				<h3 class="head step-head">They Build Their Profile, Their Way</h3>
				<p class="body">
					A few honest questions about what they're brilliant at — never a form, never a résumé upload. $29 a month, first month free.
				</p>
			</li>

			<li class="step float">
				<span class="step-num">02</span>
				<h3 class="head step-head">The Right Person Finds Them</h3>
				<p class="body">
					Households and businesses search by what they need and where they are, then book them directly.
				</p>
			</li>

			<li class="step float">
				<span class="step-num">03</span>
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
 * ── A LODE IN EVERY FIELD, BROUGHT BACK — 4 September 2026 ────────────
 * Struck 1 September for landing right after the hero as "a wall of ten
 * cards... boring, choice overload" — the placement was the fault, not
 * the content, which was real and specific the whole time (kept whole in
 * template-parts/archived-lode-fields.php rather than rewritten here).
 * Down here, past the hero and the signpost's own choosing moment, it
 * does a different job: proof of real breadth for someone who's already
 * leaning in, not a wall thrown at someone who just arrived.
 *
 * REBUILT AS AN OPENING CLOUD RATHER THAN THE OLD FIXED GRID — <details>
 * elements, one per field, native browser disclosure rather than any
 * custom JS. Closed, it reads as thirteen gradient words in one line
 * that wraps; opened, her actual one-line description shows beneath.
 * Keyboard and screen-reader accessible by default, because that's what
 * <details> already is.
 */
get_template_part( 'template-parts/archived-lode-fields' );
?>

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
			<?php
			/*
			 * "Discover the Lode" — real conversion problem, found while
			 * making this page actually convert: the exact same label sat
			 * on two different buttons meaning two different things here
			 * (build your own profile) and further down (a business
			 * finding someone). Same words as her own destination page
			 * (page-for-talent.php's real button), so the promise made
			 * here is the promise kept the moment she lands.
			 */
			?>
			<div class="lode-hero-ctas">
				<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Build Your Profile <span aria-hidden="true">&rarr;</span></a>
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
				<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Offer your expertise <span aria-hidden="true">&rarr;</span></a>
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
 * 1 September, third pass — her words: "let's weave it in a bit smaller
 * at the bottom." Same words, same place, deliberately quiet now — a
 * single slim line rather than a heading and a grid of cards, so it sits
 * under everything else instead of competing with it.
 *
 * ── MERAKI · ENTELECHY · INOCHI · KAGAYAKI ──────────────────────────────
 * 1 September, fourth pass — she asked for these four woven in here. Held
 * off until now: her own standing rule is that her words go in whole or
 * not at all, never a session's paraphrase of them, and a fragment isn't
 * enough to build from. Read The Path To Love in full to get the real
 * source rather than guess — each gloss below is her own exact wording
 * from that document, not a session's summary of it.
 */
?>
<section class="sec lode-four">
	<div class="in lode-four-slim">
		<p class="lode-four-slim-line">
			<span class="lode-four-word">Purpose</span><span class="lode-four-dot">·</span><span class="lode-four-word">Passion</span><span class="lode-four-dot">·</span><span class="lode-four-word">Potential</span><span class="lode-four-dot">·</span><span class="lode-four-word">Possibility</span>
		</p>
		<p class="lode-four-slim-cap">Every profile here carries all four.</p>

		<p class="lode-four-slim-line lode-four-slim-line--six">
			<span class="lode-four-word">Meraki</span><span class="lode-four-dot">·</span><span class="lode-four-word">Entelechy</span><span class="lode-four-dot">·</span><span class="lode-four-word">Inochi</span><span class="lode-four-dot">·</span><span class="lode-four-word">Kagayaki</span>
		</p>
		<ul class="lode-six-glosses">
			<li><strong>Meraki</strong> — to pour your soul into what you make.</li>
			<li><strong>Entelechy</strong> — the vehicle that turns potential into actuality.</li>
			<li><strong>Inochi</strong> — life force.</li>
			<li><strong>Kagayaki</strong> — radiance, the shining-out.</li>
		</ul>
	</div>
</section>

<section class="sec sec--close">
	<div class="in">
		<h2 class="close-head">Come And See What's Waiting.</h2>
		<div class="lode-hero-ctas" style="justify-content:center;">
			<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">Find Exceptional Help <span aria-hidden="true">&rarr;</span></a>
			<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Build Your Profile <span aria-hidden="true">&rarr;</span></a>
		</div>
	</div>
</section>

<?php
get_footer();
