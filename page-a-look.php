<?php
/**
 * Template Name: A Look — The New Front (bench)
 *
 * 15 September 2026 — Nan's bench for the front page, built the day she handed
 * MotherLode HQ over. Her words: the entrance is loved; under it the page loses
 * her; the entrance IS the hero (no Threshold, no Skip, no repeat); the card
 * turns on its own like a flag in the wind; a proud section for the men at
 * home. Hidden from search, in no menu, nothing on the live front changes
 * until she has looked at this whole page and said go.
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', static function (): void {
	echo '<meta name="robots" content="noindex, nofollow">' . "\n";
}, 0 );
add_action( 'wp_enqueue_scripts', static function (): void {
	$f = get_stylesheet_directory() . '/assets/css/a-look.css';
	wp_enqueue_style( 'lode-a-look', get_stylesheet_directory_uri() . '/assets/css/a-look.css', array(), file_exists( $f ) ? (string) filemtime( $f ) : '1' );
}, 99 );

get_header();

$lode_fields = array(
	array( 'name' => 'Admin',              'said' => 'The steady hand behind a business that runs on time — invoicing, scheduling, the calm nobody else sees.' ),
	array( 'name' => 'Strategy',           'said' => 'A clear head, brought in for two hours a week, that changes the next two years.' ),
	array( 'name' => 'Design',             'said' => 'An eye trained over a decade, given exactly the room a Tuesday afternoon allows.' ),
	array( 'name' => 'Marketing',          'said' => 'The campaign, the launch, the whole plan behind getting found — run by someone who has actually run one.' ),
	array( 'name' => 'Finance',            'said' => 'Numbers held with the same care they hold everything else — bookkeeping, BAS, the whole ledger.' ),
	array( 'name' => 'Education',          'said' => 'What they already know how to teach, offered to the one child — or the twenty — who need exactly that.' ),
	array( 'name' => 'Technology',         'said' => 'The quiet architecture of things that work, built in the hours that are actually theirs.' ),
	array( 'name' => 'Health',             'said' => 'A qualification that used to sit inside someone else\'s roster — physio, OT, nutrition — now working on their own terms.' ),
	array( 'name' => 'Legal',              'said' => 'Real qualifications — contracts, compliance, advice — without a whole firm\'s overhead attached.' ),
	array( 'name' => 'HR & People',        'said' => 'The people expertise a growing business needs long before it can justify a whole department.' ),
	array( 'name' => 'Project Management', 'said' => 'The one person who makes six moving parts read like a single calm plan.' ),
	array( 'name' => 'Copywriting',        'said' => 'Words that actually sound like the business, written by someone who has done it professionally.' ),
	array( 'name' => 'Home',               'said' => 'The organising, the styling, the making-beautiful — real skill, paid properly at last.' ),
);
$find = home_url( '/find-a-profile/' );
?>

<!-- THE ENTRANCE IS THE HERO. Her beautiful arrival, once, at the top of the page. No Skip, no repeat. -->
<section class="lk-hero" id="top">
	<div class="lk-hero-glow" aria-hidden="true"></div>
	<div class="lk-hero-ring" aria-hidden="true"></div>
	<div class="lk-hero-inner">
		<h1 class="lk-hero-mark"><span class="screen-reader-text">MotherLode HQ — </span><?php get_template_part( 'template-parts/lode-mark' ); ?></h1>
		<p class="lk-hero-choose">You Should Never <strong>Have To Choose.</strong></p>
		<div class="lk-hero-paths">
			<a class="lode-path lode-path--a lk-path" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">
				<span class="lode-path-text">I need <strong>exceptional help</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
			<a class="lode-path lode-path--b lk-path" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">
				<span class="lode-path-text">I'm carrying <strong>a mother lode of expertise</strong></span>
				<span class="lode-path-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>

<!-- THE FLAG. Two people, one answer — hung from a rod, swaying, turning on its own, round and round. -->
<section class="lk-sec lk-flagsec">
	<div class="in">
		<p class="eyebrow lk-center">Two People. One Answer.</p>
		<div class="lk-flag-rig">
			<div class="lk-flag-rod" aria-hidden="true"></div>
			<div class="lk-flag" id="lk-flag">
				<div class="lk-flag-wind">
					<div class="lk-face lk-face--parent">
						<p class="eyebrow">For The Parent At Home</p>
						<h2 class="lk-face-head">Your Career Didn't End. It Moved Home.</h2>
						<p class="lk-face-body">Say what you're brilliant at. Businesses find you, book you, and pay you properly — in the hours that are actually yours. Every dollar of the work itself is yours.</p>
						<a class="lode-btn lode-btn--light" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Create Your Portrait <span aria-hidden="true">&rarr;</span></a>
					</div>
					<div class="lk-face lk-face--business">
						<p class="eyebrow">For The Business</p>
						<h2 class="lk-face-head">The Skill You Need, By Tuesday.</h2>
						<p class="lk-face-body">Real expertise — strategy, design, finance, admin, the lot — from people doing genuinely skilled work. Search by what you need, book directly, pay safely. Held until the work's done, released the moment it is.</p>
						<a class="lode-btn lode-btn--light" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">Find Exceptional Help <span aria-hidden="true">&rarr;</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- THE SEAM. The constellation keeps going: one vein down the page, every field hung off it, the lines finally showing. -->
<section class="lk-sec lk-seam" id="fields">
	<div class="in">
		<p class="eyebrow lk-center">Every Field, In Full</p>
		<h2 class="lk-h2 lk-center">A Lode In Every Field.</h2>
		<p class="lk-lede lk-center">Touch one. Every name on it is somebody who has done this for years — and has two hours on a Tuesday.</p>
		<ol class="lk-vein">
			<?php foreach ( $lode_fields as $i => $f ) : ?>
			<li class="lk-ore <?php echo $i % 2 ? 'lk-ore--r' : 'lk-ore--l'; ?>">
				<span class="lk-node" aria-hidden="true"></span>
				<a class="lk-ore-card" href="<?php echo esc_url( add_query_arg( 'dokan_seller_search', $f['name'], $find ) ); ?>">
					<span class="lk-ore-name"><?php echo esc_html( $f['name'] ); ?></span>
					<span class="lk-ore-said"><?php echo esc_html( $f['said'] ); ?></span>
				</a>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- HOW IT WORKS — spoken to you, never about "them". -->
<section class="lk-sec lk-steps" id="how-it-works">
	<div class="in">
		<p class="eyebrow lk-center">How It Works</p>
		<ol class="lk-steplist">
			<li><span class="lk-stepnum">01</span><h3 class="lk-h3">You Create Your Portrait, Your Way</h3><p class="lk-body">A few honest questions about what you're brilliant at — never a form, never a résumé upload.</p></li>
			<li><span class="lk-stepnum">02</span><h3 class="lk-h3">The Right Person Finds You</h3><p class="lk-body">Businesses and households search by what they need and where they are, then book you directly.</p></li>
			<li><span class="lk-stepnum">03</span><h3 class="lk-h3">The Work Happens. Your Career Keeps Going.</h3><p class="lk-body">Paid properly, held safely until the job's done, released the moment it is.</p></li>
		</ol>
	</div>
</section>

<!-- SHE'S CARRYING A LODE. One moment, a person standing somewhere, in her imagine shape. -->
<section class="lk-sec lk-hers">
	<div class="in lk-two">
		<div class="lk-photo lk-photo--hers" aria-hidden="true"><span class="lk-photo-note">A real photograph goes here — a woman at her own kitchen table, half past nine, once they're down.</span></div>
		<div class="lk-copy">
			<p class="eyebrow">Hers First</p>
			<h2 class="lk-h2">She's Carrying A Lode.</h2>
			<p class="lk-imagine">Imagine the two hours after drop-off being paid at what you're actually worth.</p>
			<p class="lk-body">Too many mothers have felt they had to choose between a career and being the one who's there. This is the answer to that feeling — money that's genuinely yours, earned in the hours you actually have, on terms nobody else set for you.</p>
			<p class="lk-body">For some, it stays two hours a day, and that's enough. For others, it's the first thread of something that becomes entirely your own — a business, a name, a life you built yourself.</p>
			<a class="lk-word" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Say What You're Brilliant At</a>
		</div>
	</div>
</section>

<!-- HE'S CARRYING A LODE TOO. Proud, never a footnote. Her line is the thesis. -->
<section class="lk-sec lk-his">
	<div class="in lk-two lk-two--flip">
		<div class="lk-copy">
			<p class="eyebrow">And The Fathers At Home</p>
			<h2 class="lk-h2">He's Carrying A Lode Too.</h2>
			<p class="lk-thesis">&ldquo;We only change the world by doing things better — not by excluding men.&rdquo;</p>
			<p class="lk-body">He's often the only father in the pick-up line, and somebody has usually assumed he's minding his own children for the afternoon. He isn't. He's raising them, full stop, the same as she is — and the men who stay home are helping change the world too.</p>
			<p class="lk-body">Whatever he built before — the trade, the spreadsheet, the design work, the ten years he's actually good at — doesn't stop mattering because he's the one home now. It needs exactly what hers does: hours that fit around nap time and school pick-up, paid properly, never treated as a favour.</p>
			<p class="lk-proud">Not only welcome here. <strong>Encouraged.</strong></p>
			<a class="lk-word" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">Offer Your Expertise</a>
		</div>
		<div class="lk-photo lk-photo--his" aria-hidden="true"><span class="lk-photo-note">A real photograph goes here — a father in the pick-up line, laptop under his arm.</span></div>
	</div>
</section>

<!-- HER WORDS, WITHOUT A DICTIONARY. MERAKI whole or not at all. -->
<section class="lk-sec lk-words">
	<div class="in lk-center">
		<p class="lk-four"><span>Purpose</span><i>·</i><span>Passion</span><i>·</i><span>Potential</span><i>·</i><span>Possibility</span></p>
		<p class="lk-four lk-four--six"><span>Meraki</span><i>·</i><span>Entelechy</span><i>·</i><span>Inochi</span><i>·</i><span>Kagayaki</span></p>
		<p class="lk-meraki">To do something with MERAKI is to do it with soul, creativity, and love — to leave a piece of yourself in everything you do. It is your essence made visible.</p>
	</div>
</section>

<!-- THE DOOR. -->
<section class="lk-sec lk-close">
	<div class="in lk-center">
		<h2 class="lk-h2">Whichever One You Are, Start Here.</h2>
		<div class="lk-hero-paths lk-hero-paths--close">
			<a class="lode-path lode-path--a" href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>"><span class="lode-path-text">Find <strong>exceptional help</strong></span><span class="lode-path-arrow" aria-hidden="true">&rarr;</span></a>
			<a class="lode-path lode-path--b" href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>"><span class="lode-path-text">Create <strong>your Portrait</strong></span><span class="lode-path-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</div>
</section>

<?php get_footer();
