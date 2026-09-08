<?php
/**
 * Template Name: For Business
 *
 * 1 September 2026 — her words: "take them to a page that tells them
 * about the new business." Companion to page-for-talent.php — see that
 * file's own note for the fuller story of why this didn't exist yet.
 * Written for the actual audience here: a business or household weighing
 * this against the cost of a full-time hire.
 *
 * @package MotherLodeHQ
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="lode-hero" style="min-height:auto;">
	<div class="in lode-hero-stack" style="padding-top:clamp(3rem,8vw,5rem);">
		<p class="eyebrow" style="text-align:center;">For The Business Getting Smarter About Hiring</p>
		<h1 class="lode-hero-choose" style="font-size:clamp(2.1rem,5.5vw,3.6rem);">The Skill You Need Doesn't Need A Full-Time Desk. <strong>It Needs An Hour On Tuesday.</strong></h1>
		<p class="body body--wide" style="text-align:center;max-width:38rem;">
			Real expertise — strategy, design, finance, admin, the lot — from people
			doing genuinely skilled work, on hours that actually fit their lives.
			You get exactly the hours you need. They get real, properly paid work that
			fits around the children they're raising.
		</p>
		<div class="lode-paths" style="max-width:40rem;">
			<a class="lode-path lode-path--a" href="<?php echo esc_url( home_url( '/store-listing/' ) ); ?>">
				<span class="lode-path-text">Find <strong>exceptional help</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>

<section class="sec sec--voices">
	<div class="in" style="max-width:52rem;margin:0 auto;text-align:center;">
		<p class="eyebrow">What Actually Changes</p>
		<h2 class="voices-head" style="text-align:center;">Three Honest Answers, Before You Book A Single Hour.</h2>
	</div>
	<div class="in steps-track" aria-hidden="true" style="max-width:64rem;"><span></span></div>
	<ol class="steps" style="max-width:64rem;margin-left:auto;margin-right:auto;">
		<li class="step float">
			<span class="step-num">01</span>
			<h3 class="head step-head">What Does It Actually Cost?</h3>
			<p class="body">Whatever you agree with them directly — their rate, their terms. MotherLode HQ takes no commission on the work itself. You're paying for the skill, not for us standing in the middle of it.</p>
		</li>
		<li class="step float">
			<span class="step-num">02</span>
			<h3 class="head step-head">What If The Work Isn't Right?</h3>
			<p class="body">Your payment is held until the booking is marked done, not handed over the moment it starts. Nobody's chasing a refund after the fact, because nobody's paid anything until the work is actually there.</p>
		</li>
		<li class="step float">
			<span class="step-num">03</span>
			<h3 class="head step-head">Do I Need To Manage Someone New?</h3>
			<p class="body">No handbook, no onboarding week. They already run their own business — you're booking a professional, not training an employee.</p>
		</li>
	</ol>
</section>

<section class="sec lode-fields" style="background:var(--lode-cream);">
	<div class="in">
		<p class="eyebrow float" style="text-align:center;">Every Field, In Full</p>
		<h2 class="head lift float" style="text-align:center;">Whatever The Gap Is, There's Already Someone For It.</h2>
		<p class="body" style="text-align:center;max-width:34rem;margin:0 auto 1rem;">Admin. Strategy. Design. Marketing. Finance. Education. Technology. Health. Legal. HR. Project management. Copywriting. Home. If it isn't on this list, ask us anyway.</p>
	</div>
</section>

<section class="sec sec--close">
	<div class="in">
		<!--
			8 September 2026 — her law, direct: "We invite. We welcome. We
			talk with kindness always... Tell Her What You Need — that's
			horrible." This heading was the exact shape she named as the
			failure — found walking the site rather than told to fix it.
			Reworked to her own approved pattern: a question rather than an
			instruction ("What are you hoping for?", not "What are you
			after?"), and the subhead no longer repeats "what you need" a
			second time in the same section.
		-->
		<h2 class="close-head">What Are You Hoping To Find? We'll Show You Who's Already There.</h2>
		<p class="body body--wide" style="margin:0 auto 1.6rem;text-align:center;">No job board to trawl, no agency fee — just the person already doing exactly this, found in a minute.</p>
		<div class="lode-hero-ctas" style="justify-content:center;">
			<a class="lode-btn lode-btn--dark" href="<?php echo esc_url( home_url( '/store-listing/' ) ); ?>">Find Exceptional Help <span aria-hidden="true">&rarr;</span></a>
			<a class="lode-btn lode-btn--outline" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">I'm Looking To Offer Expertise Instead <span aria-hidden="true">&rarr;</span></a>
		</div>
	</div>
</section>

<?php
get_footer();
