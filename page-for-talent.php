<?php
/**
 * Template Name: For Talent
 *
 * 1 September 2026 — her words, direct: "I said I have a mother lode of
 * experience, and you're taking me to a fucking stupid page. Take them
 * to a page that tells them about the new business." The fork's own
 * button promised this exact page and had nowhere real to send anyone —
 * "For talent" in the topbar was an anchor link to a section that didn't
 * exist, and the only real destination anywhere on the site was
 * page-join.php, which is still LocaLilly's own teen-job-board template
 * under a MotherLode label. This is a real page, written for the actual
 * audience: a parent with real expertise, deciding whether this is
 * worth an hour of her evening to set up.
 *
 * 7 September 2026 — her words: "the fractional workforce... focusing
 * on the benefits, explain the fractional workforce, do some research."
 * She has since taken the real word for it — fractional@motherlodehq.com.au
 * now exists. Real 2026 market research underneath this new section: 25%
 * of US businesses already hire fractionally (35% projected by year end),
 * a full-time executive costs $290,000+ once salary, benefits and payroll
 * tax are counted, and the fractional equivalent runs 50-80% less with no
 * onboarding, no equity, no benefits package — and the people choosing to
 * work this way are disproportionately senior operators picking it on
 * purpose, for autonomy and income spread across more than one client,
 * not settling for less than a full-time role. Sources: gofractional.com,
 * ancorepartners.com, hirefraction.com, 80twenty.com — kept out of the
 * page itself, per her own law that we search literary craft rather than
 * hand her a statistic wearing a slogan.
 *
 * Ends in the one thing this page is actually for — a clear way into
 * the real join flow, with the fork's own query preserved.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="lode-hero" style="min-height:auto;">
	<div class="in lode-hero-stack" style="padding-top:clamp(3rem,8vw,5rem);">
		<p class="eyebrow" style="text-align:center;">For The Parent Carrying A Lode</p>
		<h1 class="lode-hero-choose" style="font-size:clamp(2.1rem,5.5vw,3.6rem);">You Are Not Starting Over. <strong>You're Cashing In What You Already Know.</strong></h1>
		<p class="body body--wide" style="text-align:center;max-width:38rem;">
			Every year you spent good at something — bookkeeping, design, teaching,
			the law, the ten years you actually know cold — is still yours. MotherLode HQ
			doesn't ask you to reinvent it. It asks you to say what it is, and it goes to
			work finding the people who need exactly that, in the hours that are actually yours.
		</p>
		<div class="lode-paths" style="max-width:40rem;">
			<a class="lode-path lode-path--b" href="<?php echo esc_url( home_url( '/build-your-profile/' ) ); ?>">
				<span class="lode-path-text">Build <strong>your profile</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>

<section class="sec sec--fractional">
	<div class="in" style="max-width:46rem;margin:0 auto;text-align:center;">
		<p class="eyebrow">The Real Word For This</p>
		<h2 class="head lift" style="text-align:center;">A Business Two Suburbs Over Needs A CFO's Eye On Its Numbers Before Thursday's Board Meeting. Not A CFO. An Hour Of One.</h2>
		<p class="body body--wide" style="text-align:center;margin:1.2rem auto 0;">
			That's not a favour, and it's not gig work. It's called fractional, and it's how a
			growing number of the most senior people in the country are choosing to work — on
			purpose, not as a step down from something bigger. A business gets exactly the
			expertise it needs, for exactly the hours it needs it, without carrying a full-time
			desk it was never going to fill. You get paid like the professional you already are,
			for the hours that are actually yours.
		</p>
	</div>
</section>

<section class="sec sec--voices">
	<div class="in" style="max-width:52rem;margin:0 auto;text-align:center;">
		<p class="eyebrow">What Actually Changes</p>
		<h2 class="voices-head" style="text-align:center;">Three Honest Answers, Before You Give Us A Single Detail.</h2>
	</div>
	<div class="in steps-track" aria-hidden="true" style="max-width:64rem;"><span></span></div>
	<ol class="steps" style="max-width:64rem;margin-left:auto;margin-right:auto;">
		<li class="step float">
			<span class="step-num">01</span>
			<h3 class="head step-head">What Do You Actually Keep?</h3>
			<p class="body">Every dollar a client pays you for the work itself. MotherLode HQ takes zero commission on what you earn — the platform fee is $29 a month, full stop, and your first month is free.</p>
		</li>
		<li class="step float">
			<span class="step-num">02</span>
			<h3 class="head step-head">Who Chases The Money?</h3>
			<p class="body">Nobody, including you. A client pays up front, MotherLode HQ holds it, and it releases to you the moment the work is marked done. No invoices sitting unpaid for six weeks.</p>
		</li>
		<li class="step float">
			<span class="step-num">03</span>
			<h3 class="head step-head">How Much Of Yourself Do You Have To Give Away?</h3>
			<p class="body">Exactly as much as you choose. Two hours a day while she naps. Every afternoon once he's at school. Full days, if that's what this becomes for you. You set the hours; the work fits around them, never the other way round.</p>
		</li>
	</ol>
</section>

<section class="sec lode-fields" style="background:var(--lode-cream);">
	<div class="in">
		<p class="eyebrow float" style="text-align:center;">Every Field, In Full</p>
		<h2 class="head lift float" style="text-align:center;">Whatever You're Brilliant At, There's Already A Place For It.</h2>
		<p class="body" style="text-align:center;max-width:34rem;margin:0 auto 1rem;">Admin. Strategy. Design. Marketing. Finance. Education. Technology. Health. Legal. HR. Project management. Copywriting. Home. If it isn't on this list, tell us anyway — the list is still growing.</p>
	</div>
</section>

<section class="sec sec--close">
	<div class="in">
		<p class="eyebrow" style="text-align:center;">MotherLode HQ's Own Name For It: The Strike</p>
		<h2 class="close-head">Your Portrait. Everything That Makes You, You.</h2>
		<p class="body body--wide" style="margin:0 auto 1.6rem;text-align:center;">
			Not a résumé. Not a form. A handful of honest questions that pull the real shape
			of what you do out into the open — the way a strike reveals what was already sitting
			in the seam. Ten minutes, and your first month costs nothing.
		</p>
		<div class="lode-hero-ctas" style="justify-content:center;">
			<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/build-your-profile/' ) ); ?>">Have Your Strike <span aria-hidden="true">&rarr;</span></a>
			<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">I'm Looking To Hire Instead <span aria-hidden="true">&rarr;</span></a>
		</div>
	</div>
</section>

<?php
get_footer();
