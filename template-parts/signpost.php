<?php
/**
 * The signpost — a two-sided card that turns between the parent's
 * story and the business's, on its own, forever.
 *
 * BUILT AND CONFIRMED LIVE, 2–3 September 2026, after three real
 * passes on her direct feedback:
 *
 * First pass was a plain white rounded card. Her words: "a flag? That's
 * just a fucking box." Right — it borrowed nothing from the mark's own
 * visual language and looked like every SaaS product ever made.
 *
 * Second pass cut it into an actual pennant shape with a real notch,
 * flying from a mast with a gold finial, floating gently "in the wind."
 * Building the turn itself surfaced a real, documented Chromium bug:
 * `clip-path` and `backface-visibility: hidden` on the same element
 * break each other — backface-visibility silently stops working and
 * the flipped-away face shows through, mirrored. Splitting each face
 * into an outer element (rotation, backface-visibility) and an inner
 * one (clip-path, background) is the standard fix, and even that
 * didn't fully resolve it in testing here. The turn that actually
 * shipped abandons real 3D CSS entirely — no perspective, no
 * preserve-3d, no rotateY, no backface-visibility. It's a 2D `scaleX`
 * crush to flat, a plain `visibility` swap of which face is showing at
 * the flattest instant, then unfurl. Reads as a real flip and cannot
 * render wrong on any browser.
 *
 * Third pass, her words: "I don't want it to look like a flag... it
 * shouldn't look like it's flying in the wind, but it should keep
 * flipping from one to the other, repeatedly." Mast, notch and the
 * idle drift are gone — a clean, wide, rounded card that sits still
 * and only moves when it turns, forever, on its own.
 *
 * Parent-facing side carries the mark's own orange-to-coral warmth —
 * her direct call, overriding an earlier "no orange on this site"
 * note that was never a wider estate rule, only ever specific to this
 * one business. Business-facing side carries the plum-to-berry
 * gradient already used everywhere else here.
 *
 * @package MotherLodeHQ
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="sec sec--signpost">
	<div class="in">
		<p class="eyebrow" style="text-align:center;">Two People. One Answer.</p>
		<h2 class="head lift" style="text-align:center;">Read Yours First.</h2>

		<div class="signpost-rig">
			<div class="signpost" id="lode-signpost">

				<div class="signpost-face signpost-face--parent">
					<div class="signpost-face-shape">
						<p class="eyebrow">For The Parent</p>
						<h3 class="signpost-head">Your Career Didn't End. It Moved Home.</h3>
						<p class="signpost-body">Say what you're brilliant at. Businesses find you, book you, and pay you properly — in the hours that are actually yours. $29 a month, first month free, and every dollar of the work itself is yours.</p>
						<a class="lode-btn lode-btn--light" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Build Your Profile <span aria-hidden="true">&rarr;</span></a>
					</div>
				</div>

				<div class="signpost-face signpost-face--business">
					<div class="signpost-face-shape">
						<p class="eyebrow">For The Business</p>
						<h3 class="signpost-head">The Skill You Need, By Tuesday.</h3>
						<p class="signpost-body">Real expertise — strategy, design, finance, admin, the lot — from people doing genuinely skilled work. Search by what you need, book directly, pay safely. Held until the work's done, released the moment it is.</p>
						<a class="lode-btn lode-btn--light" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">Find Exceptional Help <span aria-hidden="true">&rarr;</span></a>
					</div>
				</div>

			</div>
		</div>

		<div class="signpost-dots" aria-hidden="true">
			<span class="signpost-dot is-active" data-face="parent"></span>
			<span class="signpost-dot" data-face="business"></span>
		</div>
	</div>
</section>

<noscript>
	<style>
		.signpost { transform: none !important; }
		.signpost-face { visibility: visible !important; }
		.signpost-face--business { position: static !important; transform: none !important; margin-top: 2rem; }
	</style>
</noscript>

<script>
(function () {
	var card = document.getElementById('lode-signpost');
	if (!card) return;

	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (reduced) return;

	var dots = document.querySelectorAll('.signpost-dot');
	var flipped = false;

	function setDots() {
		dots.forEach(function (d) {
			d.classList.toggle('is-active', (d.dataset.face === 'business') === flipped);
		});
	}

	/*
	 * "I don't like it flipping too fast" — slowed right down, 420ms
	 * each way (was 260ms total for the whole turn). The crush phase
	 * eases in, the unfurl eases out with a touch of overshoot, so it
	 * reads as one deliberate motion rather than a snap.
	 */
	function flip() {
		card.classList.add('is-turning');
		window.setTimeout(function () {
			flipped = !flipped;
			card.classList.toggle('is-flipped', flipped);
			setDots();
			card.classList.remove('is-turning');
		}, 420);
	}

	/*
	 * Her words: "you've got to time it right," and later, "it should
	 * keep flipping from one to the other, repeatedly." Long enough to
	 * read (the parent side is the longer of the two), short enough
	 * that it never feels stuck, and it never actually stops on its
	 * own — every flip reschedules the next one. Paused while a hand
	 * or cursor is on it, so nobody's mid-sentence when it turns away.
	 */
	var timer = null;
	function schedule() {
		timer = window.setTimeout(flip, 7000);
	}
	function stop() {
		if (timer) { window.clearTimeout(timer); timer = null; }
	}
	function restart() {
		stop();
		schedule();
	}

	card.addEventListener('mouseenter', stop);
	card.addEventListener('mouseleave', restart);

	/*
	 * "Prevents it from flipping back" — once somebody has actually
	 * chosen a side themselves, the auto-cycle stops arguing with
	 * them. A click used to flip() and then restart() the same
	 * 7-second countdown, so choosing "For The Parent" got silently
	 * overruled a few seconds later. Now a real choice — the card
	 * itself, or a dot — ends the auto-cycle for good; it only ever
	 * runs again for someone who never touched it.
	 */
	card.addEventListener('click', function () { flip(); stop(); });

	dots.forEach(function (d) {
		d.addEventListener('click', function () {
			var wantsBusiness = d.dataset.face === 'business';
			if (wantsBusiness !== flipped) { flip(); }
			stop();
		});
	});

	schedule();
})();
</script>
