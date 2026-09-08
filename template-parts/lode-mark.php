<?php
/**
 * The LODE Mark — rebuilt to match her actual reference image, 1 September 2026.
 *
 * Her words, direct: "what I want is the exact thing. Do you see? I've
 * given you the fucking image to work from. Just animate that." Every
 * earlier pass here was this session's own invented composition — a
 * simple ring of dots and straight lines, not what she actually gave me
 * at the very start (assets/hero/motherlodehero.png). Went back and
 * looked at that file properly, cropped in close, and rebuilt this to
 * match its real structure: several large overlapping circles arcing
 * through the letters, a soft diagonal ribbon of colour crossing the
 * whole mark, and a denser woven web of fine lines — not a simple
 * network. The nine words are the actual words in her image (Strategy,
 * Design, Finance, Wellbeing, Home, Technology, Education, Admin, Food),
 * not a curated substitute list.
 *
 * The letters are still live gradient SVG text rather than a flat
 * raster, and the whole pattern still genuinely animates — the circles
 * hold, the ribbon breathes very slowly, the lines draw themselves in
 * and the labels float — because the image itself is frozen and her
 * actual ask across this whole build has been to make it alive without
 * losing what it actually looked like.
 *
 * One definition, included wherever the mark appears (the hero, and the
 * threshold), so they can never quietly drift apart from each other.
 *
 * @package MotherLodeHQ
 */

defined( 'ABSPATH' ) || exit;

/*
 * Her words: "use different colours so we know they're distinct." Nine
 * real, harmonious steps across her own palette — orange through to
 * plum — rather than one ink colour repeated nine times.
 */
$lode_mark_nodes = array(
	array(
		'label' => 'Strategy',
		'x'     => 156,
		'y'     => 64,
		'align' => 'start',
		'color' => '#FE8743',
	),
	array(
		'label' => 'Design',
		'x'     => 500,
		'y'     => 70,
		'align' => 'end',
		'color' => '#FC5E1D',
	),
	array(
		'label' => 'Finance',
		'x'     => 545,
		'y'     => 190,
		'align' => 'end',
		'color' => '#FC0E1D',
	),
	array(
		/*
		 * 8 September 2026 -- real bug, found by actually looking at
		 * the live mark on a phone: at (215, 225) the word sat
		 * straight across the O, unreadable against it. Moved into
		 * the real gap between the L and the O -- the dot barely
		 * moves, the web of lines is untouched, only where the word
		 * itself lands has changed.
		 */
		'label' => 'Marketing',
		'x'     => 145,
		'y'     => 165,
		'align' => 'start',
		'color' => '#F43775',
	),
	array(
		'label' => 'Admin',
		'x'     => 40,
		'y'     => 282,
		'align' => 'start',
		'color' => '#EF1763',
	),
	array(
		'label' => 'Wellbeing',
		'x'     => 540,
		'y'     => 350,
		'align' => 'end',
		'color' => '#D81856',
	),
	array(
		'label' => 'Home',
		'x'     => 500,
		'y'     => 445,
		'align' => 'end',
		'color' => '#C5156A',
	),
	array(
		'label' => 'Education',
		'x'     => 170,
		'y'     => 445,
		'align' => 'start',
		'color' => '#A01268',
	),
	array(
		'label' => 'Technology',
		'x'     => 300,
		'y'     => 545,
		'align' => 'middle',
		'color' => '#7A0862',
	),
);

/*
 * A denser woven web — a perimeter ring plus real cross-connections —
 * matching how thick with lines her actual reference is, not a sparse
 * point-to-point network.
 */
$lode_mark_lines = array(
	array( 0, 1 ), array( 1, 2 ), array( 2, 5 ), array( 5, 6 ),
	array( 6, 8 ), array( 8, 7 ), array( 7, 4 ), array( 4, 0 ),
	array( 0, 2 ), array( 0, 5 ), array( 0, 6 ), array( 0, 8 ),
	array( 1, 3 ), array( 1, 5 ), array( 1, 8 ),
	array( 3, 5 ), array( 3, 6 ), array( 3, 7 ),
	array( 2, 6 ), array( 4, 3 ), array( 7, 1 ),
);

/*
 * The large overlapping circles arcing through and behind the letters —
 * the single biggest thing the earlier, invented version was missing.
 */
$lode_mark_circles = array(
	array( 'cx' => 370, 'cy' => 150, 'r' => 158 ),
	array( 'cx' => 462, 'cy' => 262, 'r' => 142 ),
	array( 'cx' => 328, 'cy' => 382, 'r' => 158 ),
	array( 'cx' => 228, 'cy' => 218, 'r' => 146 ),
	array( 'cx' => 430, 'cy' => 480, 'r' => 122 ),
);
?>
<svg
	class="lode-mark-svg"
	viewBox="0 0 580 560"
	width="580" height="560"
	preserveAspectRatio="xMidYMid meet"
	role="img"
	aria-label="MotherLode HQ"
>
	<defs>
		<linearGradient id="lode-mark-letter-grad" x1="20" y1="20" x2="560" y2="540" gradientUnits="userSpaceOnUse">
			<stop offset="0%"   stop-color="#FE8743" />
			<stop offset="38%"  stop-color="#FC0E1D" />
			<stop offset="68%"  stop-color="#EF1763" />
			<stop offset="100%" stop-color="#7A0862" />
		</linearGradient>
		<radialGradient id="lode-mark-node-glow" cx="38%" cy="32%" r="72%">
			<stop offset="0%"  stop-color="#FFC2D6" />
			<stop offset="52%" stop-color="#F43775" />
			<stop offset="100%" stop-color="#B01259" />
		</radialGradient>
		<?php
		/*
		 * 2 September 2026 — real bug, her words exactly: "it looks cut
		 * off, like it's been cut from a picture... just at the left
		 * edge." Found it: the ribbon's own path closes with a straight
		 * vertical line at its far left (and far right), and the
		 * gradient filling it was fully opaque end to end — a hard
		 * geometric edge with no fade to soften it, reading exactly like
		 * a cropped photograph rather than a ribbon. Fixed at the
		 * gradient rather than the path: both ends now fade to nothing
		 * over their first and last 12%, so the ribbon dissolves into
		 * the page instead of stopping dead.
		 */
		?>
		<linearGradient id="lode-mark-ribbon-grad" x1="0" y1="230" x2="520" y2="330" gradientUnits="userSpaceOnUse">
			<stop offset="0%"   stop-color="#FE8743" stop-opacity="0" />
			<stop offset="14%"  stop-color="#FE8743" stop-opacity="1" />
			<stop offset="45%"  stop-color="#FC0E1D" />
			<stop offset="86%"  stop-color="#EF1763" stop-opacity="1" />
			<stop offset="100%" stop-color="#EF1763" stop-opacity="0" />
		</linearGradient>
	</defs>

	<g class="lode-mark-scene">
		<!-- The overlapping rings and the ribbon sit behind everything
		     else, the way they do in her own reference. -->
		<g class="lode-mark-circles">
			<?php foreach ( $lode_mark_circles as $lm_ci => $lm_circle ) : ?>
				<circle
					class="lm-circle"
					style="--n: <?php echo (int) $lm_ci; ?>"
					cx="<?php echo (int) $lm_circle['cx']; ?>" cy="<?php echo (int) $lm_circle['cy']; ?>" r="<?php echo (int) $lm_circle['r']; ?>"
				/>
			<?php endforeach; ?>
		</g>

		<?php
		/*
		 * Her words: "you don't have my beautiful wave... you've got to
		 * get it exactly right." Her reference isn't a simple wave — it's
		 * a real ribbon twist, two sails pinching to a single point in
		 * the middle, the way a length of ribbon looks when it crosses
		 * over itself.
		 */
		?>
		<path
			class="lm-ribbon"
			d="M 15,208 C 130,224 218,272 300,308 C 380,268 458,252 522,264 L 522,332 C 458,320 380,336 300,308 C 218,344 130,394 15,408 Z"
		/>

		<g class="lode-mark-lines">
			<?php foreach ( $lode_mark_lines as $lm_li => $lm_pair ) :
				$lm_a = $lode_mark_nodes[ $lm_pair[0] ];
				$lm_b = $lode_mark_nodes[ $lm_pair[1] ];
				?>
				<line
					class="lm-line"
					style="--n: <?php echo (int) $lm_li; ?>"
					x1="<?php echo (int) $lm_a['x']; ?>" y1="<?php echo (int) $lm_a['y']; ?>"
					x2="<?php echo (int) $lm_b['x']; ?>" y2="<?php echo (int) $lm_b['y']; ?>"
				/>
			<?php endforeach; ?>
		</g>

		<?php
		/*
		 * Her words: "the L, O, D and E need to be bigger and closer
		 * together — more intentional." Bigger size, tighter columns and
		 * rows than the first pass.
		 */
		?>
		<text class="lm-letter" x="6"   y="264" style="--n:0">L</text>
		<text class="lm-letter" x="255" y="264" style="--n:1">O</text>
		<text class="lm-letter" x="6"   y="525" style="--n:2">D</text>
		<text class="lm-letter" x="255" y="525" style="--n:3">E</text>

		<g class="lode-mark-nodes">
			<?php foreach ( $lode_mark_nodes as $lm_ni => $lm_node ) : ?>
				<g class="lm-node" style="--n: <?php echo (int) $lm_ni; ?>; --node-color: <?php echo esc_attr( $lm_node['color'] ); ?>;" transform="translate(<?php echo (int) $lm_node['x']; ?>, <?php echo (int) $lm_node['y']; ?>)">
					<circle class="lm-node-halo" r="11" />
					<circle class="lm-node-dot" r="3.6" />
					<text
						class="lm-node-label"
						text-anchor="<?php echo esc_attr( $lm_node['align'] ); ?>"
						x="<?php echo 'start' === $lm_node['align'] ? '13' : ( 'end' === $lm_node['align'] ? '-13' : '0' ); ?>"
						y="<?php echo 'middle' === $lm_node['align'] ? '-15' : '4'; ?>"
					><?php echo esc_html( strtoupper( $lm_node['label'] ) ); ?></text>
				</g>
			<?php endforeach; ?>
		</g>
	</g>
</svg>
<noscript>
	<style>
		/*
		 * Every animated piece of this mark (letters, nodes, lines)
		 * waits on this SVG's own JavaScript — the letters fade in
		 * regardless, but the node halos, dots, labels and the lines'
		 * own draw-in all wait for .is-ready, which only JS ever adds.
		 * Without this block, anyone with JavaScript off would see an
		 * empty mark forever, which is a real regression from the plain
		 * image this replaced. Full, static, fully visible instead.
		 */
		.lode-mark-svg { opacity: 1 !important; }
		.lode-mark-svg .lm-letter,
		.lode-mark-svg .lm-node-halo,
		.lode-mark-svg .lm-node-dot,
		.lode-mark-svg .lm-node-label,
		.lode-mark-svg .lm-circle,
		.lode-mark-svg .lm-ribbon { opacity: 1 !important; transform: none !important; }
		.lode-mark-svg .lm-line { stroke-dashoffset: 0 !important; opacity: .38 !important; }
	</style>
</noscript>
<script>
(function(){
	var svgs = document.querySelectorAll('.lode-mark-svg');
	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	svgs.forEach(function(svg){
		/* This runs once per get_template_part() call, and the mark is
		   included twice on this page (hero, threshold) — by the second
		   run, querySelectorAll sees both. Guard so neither is ever
		   wired up twice. */
		if (svg.classList.contains('is-ready')) return;

		/* Real stroke length per line, not a guessed dasharray — each
		   line draws itself in exactly once, at its own true length.
		   Wrapped in try/catch so a failure here (an unsupported method,
		   anything) still leaves .is-ready added below rather than
		   leaving the whole mark permanently blank. */
		try {
			var lines = svg.querySelectorAll('.lm-line');
			lines.forEach(function(line){
				var len = Math.ceil(line.getTotalLength());
				line.style.setProperty('--len', len);
			});
		} catch (e) {}
		svg.classList.add('is-ready');

		if (reduced) return;

		/* A very slight drift toward the cursor — smoothed, never
		   snapping straight to the pointer. */
		var scene = svg.querySelector('.lode-mark-scene');
		if (!scene || matchMedia('(pointer: coarse)').matches) return;
		var container = svg.closest('.lode-hero-mark, .lode-threshold-mark') || svg.parentElement;
		var targetX = 0, targetY = 0, curX = 0, curY = 0, raf = null;

		function tick(){
			curX += (targetX - curX) * 0.08;
			curY += (targetY - curY) * 0.08;
			scene.style.transform = 'translate(' + curX.toFixed(2) + 'px,' + curY.toFixed(2) + 'px)';
			if (Math.abs(targetX - curX) > 0.05 || Math.abs(targetY - curY) > 0.05) {
				raf = requestAnimationFrame(tick);
			} else {
				raf = null;
			}
		}
		function onMove(e){
			var r = container.getBoundingClientRect();
			var px = ((e.clientX - r.left) / r.width) - 0.5;
			var py = ((e.clientY - r.top) / r.height) - 0.5;
			targetX = px * 10;
			targetY = py * 8;
			if (!raf) raf = requestAnimationFrame(tick);
		}
		function onLeave(){
			targetX = 0; targetY = 0;
			if (!raf) raf = requestAnimationFrame(tick);
		}
		container.addEventListener('pointermove', onMove);
		container.addEventListener('pointerleave', onLeave);
	});
})();
</script>
