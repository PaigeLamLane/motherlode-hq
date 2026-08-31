<?php
/**
 * Template Name: Create Your Business
 *
 * The road a young person walks, one moment at a time, saving as they go.
 *
 * HER CORRECTION, AND IT IS THE WHOLE FRAME RATHER THAN A LABEL. Create your
 * business, never build your page. **A page is something you own. A business is
 * something you run**, and the difference is what a fifteen-year-old carries
 * out of here — the first is a profile on a website, the second is a thing that
 * is theirs, with prices they set and hours they choose and a grown-up beside
 * them.
 *
 * Her own words for this business months ago: a business building engine to
 * help the young people. Every moment below is written to that.
 *
 * AND YES, THIS IS THE ATELIER SHAPE. One question a screen, in their own
 * words, kept the instant it is given. What makes it an atelier rather than a
 * form is that it never asks for anything it can decide, never asks twice, and
 * hands back what they made rather than a receipt.
 *
 * Every screen below is a single question. Answer it and it is kept — and their
 * page exists from the very first one rather than the last, so walking away
 * costs them nothing at all.
 *
 * WRITTEN TO HIM AND TO HER, NEVER ABOUT THEM. And written kindly on every
 * screen rather than only on the welcoming ones, which is her language of love
 * taken as the standard it is: **the test is whether this honours the person
 * reading it**, including where nobody would notice if it did not.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

$localilly_page = localilly_their_page();
$localilly_said = localilly_what_they_said( $localilly_page );
$localilly_done = localilly_moments_done( $localilly_said );
$localilly_all  = localilly_the_moments();

$localilly_at = isset( $_GET['moment'] ) ? sanitize_key( wp_unslash( $_GET['moment'] ) ) : '';
if ( ! $localilly_at || ( ! isset( $localilly_all[ $localilly_at ] ) && 'ready' !== $localilly_at ) ) {
	$localilly_at = localilly_next_moment( $localilly_said );
}

$localilly_count = count( array_filter( $localilly_done ) );
$localilly_total = count( $localilly_all );
?>

<main class="build">

	<?php if ( $localilly_page ) : ?>
		<p class="build-held">
			<span class="build-tick">Kept</span>
			<?php echo esc_html( $localilly_count ); ?> of <?php echo esc_html( $localilly_total ); ?> moments, saved as you go. Close this whenever you like — your business waits for you.
		</p>
	<?php endif; ?>

	<?php if ( 'ready' === $localilly_at ) : ?>

		<?php
		/*
		 * Her name goes over the door on her sign below, so the heading says
		 * what the sign cannot: that it is open and it is hers.
		 */
		?>
		<h1 class="room-name"><?php echo esc_html( $localilly_said['name'] ); ?>&rsquo;s Business</h1>
		<p class="build-why">Every moment is behind you, and what you wrote is exactly as you wrote it. Your grown-up has a note from us, and the day this opens in <?php echo esc_html( $localilly_said['suburb'] ); ?> yours is first in line.</p>

		<?php
		/*
		 * ── STRUCK 30 AUGUST: A PAGE SAID HER PROFILE TWICE ───────────────
		 *
		 * A preview card sat here holding her name, her line, her suburb, her
		 * own words, her work, her prices and her hours — and the room below it
		 * now holds every one of those again.
		 *
		 * **Her law: never repeat an idea or a sentence structure twice on a
		 * page.** A young person scrolled her own business and met herself
		 * twice before reaching anything she could do.
		 *
		 * Her sign is the one that stays, because it is the one a neighbour
		 * sees. The rest lives in the room, once each, where she can change it.
		 */
		?>

		<?php
		/*
		 * Their way back belongs on their own screen rather than in a letter to
		 * somebody else. She has ruled that a grown-up gets no letter, and a
		 * young person still needs a way back in.
		 */
		$localilly_key = (string) get_post_meta( $localilly_page->ID, '_ll_key', true );
		?>
		<?php
		/*
		 * ── HER RULING, 30 AUGUST: WE DO NOT USE KEYS ─────────────────────
		 *
		 * A young person stood on her own business screen and was handed a
		 * string of letters called Your Key, told to keep it somewhere safe.
		 * **A cookie, named on a screen, made a fifteen-year-old's problem.**
		 *
		 * Her email and a password she chooses. The same door a neighbour
		 * walks through, in the same words.
		 */
		localilly_offer_them_a_word( $localilly_page->ID );
		localilly_offer_them_their_face();
		?>

		<?php
		/*
		 * Her ruling: they never write their own sign-off. It is shown here so
		 * they meet it once, on their own page, before a neighbour ever does.
		 */
		$localilly_off = localilly_their_signoff( $localilly_page->ID );
		?>
		<?php if ( $localilly_off['mark'] ) : ?>
			<div class="signoff plate">
				<p class="signoff-word">How You Sign Off</p>
				<p class="signoff-name"><?php echo esc_html( $localilly_off['name'] ); ?></p>
				<p class="signoff-mark">Local <span class="say"><?php echo esc_html( $localilly_off['name'] ); ?></span></p>
				<p class="signoff-why">Every letter you send ends this way, already written for you.</p>
			</div>
		<?php endif; ?>

		<?php localilly_the_opening( $localilly_page, $localilly_said ); ?>

		<?php
		/*
		 * ── HER BUSINESS, RATHER THAN THE END OF A FORM ───────────────
		 *
		 * Her ruling, 30 August. She finished the road and the screen simply
		 * stopped being the road — a neighbour had a place and the girl whose
		 * business it is had nowhere.
		 *
		 * Never called a dashboard. **A girl who has made a business has a
		 * business**, and she is standing in it.
		 */
		$localilly_going = localilly_how_it_is_going( $localilly_page->ID );
		$localilly_talk  = localilly_their_conversations( (string) get_post_meta( $localilly_page->ID, '_ll_key', true ) );
		?>

		<?php
		/*
		 * ── HER SIGN, AND IT IS THE DOOR ──────────────────────────────────
		 *
		 * Her question: **how can we make the profile great for them, really
		 * super duper.**
		 *
		 * The answer is the plate she made herself. A fifteen-year-old walking
		 * into her own business should meet HER OWN NAME ON A STREET SIGN,
		 * large, before a single figure or list. **That is the moment worth
		 * building** — the rest is bookkeeping and it can wait a scroll.
		 *
		 * Nan Made calls it Margaret's Kitchen and puts her work in front of
		 * her. This is the same idea in her own material.
		 */
		$localilly_sign = localilly_their_signoff( $localilly_page->ID );
		?>
		<section class="hers">
			<a class="found-go hers-plate" href="<?php echo esc_url( (string) get_permalink( $localilly_page ) ); ?>">
				<span class="found-plate">
					<span class="found-name">Local<span class="say"><?php echo esc_html( $localilly_said['name'] ); ?></span></span>
					<span class="found-where"><?php echo esc_html( (string) ( $localilly_said['suburb'] ?? '' ) ); ?></span>
					<?php if ( ! empty( $localilly_said['line'] ) ) : ?>
						<span class="found-does"><?php echo esc_html( localilly_as_a_title( (string) $localilly_said['line'] ) ); ?></span>
					<?php endif; ?>
				</span>
			</a>
			<p class="hers-under">This is what a neighbour sees when they find you.</p>
		</section>

		<?php
		/*
		 * ── WHAT A NEIGHBOUR HAS WRITTEN, AND IT COMES FIRST ──────────────
		 *
		 * Her ruling of 30 August put the counting off a neighbour's screen and
		 * it comes off this one too. **A girl opening her business wants to
		 * know who wants her**, and a figure saying three is a worse answer
		 * than three people's names.
		 */
		?>
		<section class="room-card">
			<h2 class="room-head">Letters For You</h2>
			<?php if ( $localilly_talk ) : ?>
				<ul class="room-rows">
					<?php foreach ( array_slice( $localilly_talk, 0, 10 ) as $localilly_one ) : ?>
						<?php
						$localilly_me   = 'young:' . (string) get_post_meta( $localilly_page->ID, '_ll_key', true );
						$localilly_mine = strtolower( (string) ( $localilly_one['sender'] ?? '' ) ) === strtolower( $localilly_me );
						localilly_it_has_been_read( $localilly_one, $localilly_me );
						?>
						<li class="room-row">
							<p class="room-row-who"><?php echo esc_html( $localilly_mine ? 'You wrote' : 'A neighbour wrote' ); ?></p>
							<p class="room-row-words"><?php echo esc_html( wp_trim_words( (string) ( $localilly_one['words'] ?? '' ), 30 ) ); ?></p>
							<?php localilly_what_became_of_it( $localilly_one, $localilly_mine ); ?>
							<?php
							/*
							 * Her ruling of 30 August: a neighbour writes their
							 * own page too, and **a young person reads a person
							 * rather than a payment** before answering.
							 */
							if ( ! $localilly_mine ) {
								localilly_who_is_this( (string) ( $localilly_one['sender'] ?? '' ) );
							}
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="room-empty">The first neighbour to write to you lands here, in their own words, and you answer in your own time.</p>
			<?php endif; ?>
		</section>

		<?php
		/*
		 * ── WHEN SHE IS FREE, WHICH IS HERS TO SAY ────────────────────────
		 *
		 * Nan Made lets Margaret open and close her own days, and her line for
		 * it is that closing one closes it for everybody. **A young person with
		 * exams, a game on Saturday, or a family week away says so here**, and
		 * her own words go on her page rather than a grid of tick boxes.
		 */
		?>
		<section class="room-card">
			<h2 class="room-head">When You Are Free</h2>
			<?php if ( ! empty( $localilly_said['free'] ) ) : ?>
				<p class="room-row-words"><?php echo esc_html( (string) $localilly_said['free'] ); ?></p>
			<?php else : ?>
				<p class="room-empty">Say the days that suit you and a neighbour asks around them, so nobody ever asks you to miss what matters.</p>
			<?php endif; ?>
			<?php localilly_a_way_on( 'Say When You Are Free', add_query_arg( 'moment', 'free', (string) get_permalink() ), 'room-go press' ); ?>
		</section>

		<?php
		/*
		 * ── WHAT SHE ASKS, IN HER OWN NUMBERS ─────────────────────────────
		 *
		 * Her ruling: several services, several prices, and a quote is a whole
		 * answer rather than a price of nothing.
		 */
		$localilly_eight = localilly_the_eight();
		?>
		<?php if ( ! empty( $localilly_said['rates'] ) ) : ?>
			<section class="room-card">
				<h2 class="room-head">What You Ask</h2>
				<?php
				/*
				 * A RATE CARRIES ITS OWN NAME. My first version read the array
				 * position as the work, so a young person's own prices drew as
				 * nought and one on her screen — **her words replaced by the
				 * order they happened to be saved in.**
				 */
				?>
				<ul class="room-rows">
					<?php foreach ( (array) $localilly_said['rates'] as $localilly_rate ) : ?>
						<?php $localilly_rate = (array) $localilly_rate; ?>
						<li class="room-row">
							<p class="room-row-who"><?php echo esc_html( (string) ( $localilly_rate['what'] ?? '' ) ); ?></p>
							<p class="room-row-words"><?php echo esc_html( localilly_rate_says( $localilly_rate ) ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		$localilly_jobs   = array_filter( (array) get_post_meta( $localilly_page->ID, '_ll_jobs_done', true ) );
		$localilly_saidof = array_filter( (array) get_post_meta( $localilly_page->ID, '_ll_said_of_them', true ) );
		?>
		<section class="room-card">
			<h2 class="room-head">What Neighbours Have Said</h2>
			<?php if ( $localilly_saidof ) : ?>
				<ul class="room-rows">
					<?php foreach ( array_slice( $localilly_saidof, 0, 6 ) as $localilly_word ) : ?>
						<li class="room-row">
							<p class="room-row-words"><?php echo esc_html( (string) ( $localilly_word['words'] ?? '' ) ); ?></p>
							<p class="room-row-who"><?php echo esc_html( (string) ( $localilly_word['about'] ?? '' ) ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="room-empty">What a neighbour says about your work is yours to keep, and it travels with you.</p>
			<?php endif; ?>
		</section>

		<section class="room-card">
			<h2 class="room-head">Work You Have Done</h2>
			<?php if ( $localilly_jobs ) : ?>
				<ul class="room-rows">
					<?php foreach ( array_slice( $localilly_jobs, 0, 10 ) as $localilly_job ) : ?>
						<li class="room-row">
							<p class="room-row-words"><?php echo esc_html( (string) ( $localilly_job['what'] ?? '' ) ); ?></p>
							<p class="mine-talk-became"><?php echo esc_html( (string) ( $localilly_job['when'] ?? '' ) ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="room-empty">Every job you finish is written down here, and it comes with you when you are older.</p>
			<?php endif; ?>
		</section>

		<?php
		/*
		 * ── HER SIGN, TO SHOW SOMEBODY ────────────────────────────────────
		 *
		 * A first business is worth being proud of, and the first person a
		 * fifteen-year-old wants to show is her nan. **Her own address, ready
		 * to send**, so the showing takes one tap rather than an explanation.
		 */
		?>
		<section class="room-card room-card--quiet">
			<h2 class="room-head">Show Somebody</h2>
			<p class="room-empty">Send your sign to whoever you would like to see it.</p>
			<?php localilly_a_way_on( 'Look At Your Page', (string) get_permalink( $localilly_page ), 'room-go press' ); ?>
		</section>

		<?php
		/*
		 * STRUCK: the seven moments were named here and again in the road just
		 * below, so a young person read the same seven lines twice on her own
		 * screen. **The road is the one that stays** — it shows which are done.
		 */
		?>

	<?php else : ?>

		<?php $localilly_m = $localilly_all[ $localilly_at ]; ?>

		<h1 class="build-ask"><?php echo esc_html( $localilly_m['ask'] ); ?></h1>
		<p class="build-why"><?php echo esc_html( $localilly_m['why'] ); ?></p>

		<?php
		/*
		 * ── SHE WATCHES IT BEING BUILT ────────────────────────────────
		 *
		 * Her ruling: show them the profile being built as they're going
		 * through the atelier. **Absolutely**, in her word.
		 *
		 * It answers the fault I had raised myself — a young person was
		 * writing into fields and finding out at the end what they had made.
		 * **A person who can see the thing appearing is building something.
		 * A person who cannot is filling in a form**, and her moments law is
		 * exactly the difference between those two sentences.
		 *
		 * It renders from what is already saved, so it is true rather than
		 * hopeful, and the script fills it in live as they type.
		 */
		?>
		<div class="asit" id="asit" aria-live="polite">
			<p class="asit-word">Your page, so far</p>
			<div class="asit-card plate">
				<p class="asit-name">Local <span class="say" data-asit="name"><?php echo esc_html( $localilly_said['name'] ?? '' ); ?></span></p>
				<p class="asit-line" data-asit="line"><?php echo esc_html( $localilly_said['line'] ?? '' ); ?></p>
				<p class="asit-where" data-asit="suburb"><?php echo esc_html( $localilly_said['suburb'] ?? '' ); ?></p>
				<blockquote class="asit-says" data-asit="words"><?php echo esc_html( $localilly_said['words'] ?? '' ); ?></blockquote>
				<ul class="asit-does" data-asit="doing">
					<?php foreach ( (array) ( $localilly_said['doing'] ?? array() ) as $localilly_d ) : ?>
						<li><?php echo esc_html( localilly_the_eight()[ $localilly_d ] ?? $localilly_d ); ?></li>
					<?php endforeach; ?>
				</ul>
				<ul class="asit-rates">
					<?php foreach ( (array) ( $localilly_said['rates'] ?? array() ) as $localilly_r ) : ?>
						<li><span><?php echo esc_html( $localilly_r['what'] ); ?></span> <strong><?php echo esc_html( localilly_rate_says( $localilly_r ) ); ?></strong></li>
					<?php endforeach; ?>
				</ul>
				<p class="asit-free" data-asit="free"><?php echo esc_html( $localilly_said['free'] ?? '' ); ?></p>
				<ul class="asit-shots">
					<?php foreach ( (array) ( $localilly_said['shots'] ?? array() ) as $localilly_shot ) : ?>
						<li><img src="<?php echo esc_attr( $localilly_shot ); ?>" alt="Work this young person has done"></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<?php localilly_the_word_on_screen(); ?>
		<form class="build-form" method="post">
			<?php wp_nonce_field( 'localilly_build', 'localilly_keep' ); ?>
			<input type="hidden" name="localilly_moment" value="<?php echo esc_attr( $localilly_at ); ?>">

			<?php if ( 'name' === $localilly_at ) : ?>
				<label class="ask">
					<span>Your First Name</span>
					<input type="text" name="name" maxlength="40" required value="<?php echo esc_attr( $localilly_said['name'] ?? '' ); ?>" placeholder="Zac" autocomplete="given-name">
				</label>
				<label class="ask">
					<span>Your Suburb</span>
					<input type="text" name="suburb" maxlength="60" required value="<?php echo esc_attr( $localilly_said['suburb'] ?? '' ); ?>" placeholder="Preston">
				</label>
				<label class="ask">
					<span>And One Line Of Your Own, If You Like</span>
					<input type="text" name="line" maxlength="60" value="<?php echo esc_attr( $localilly_said['line'] ?? '' ); ?>" placeholder="the dog whisperer">
				</label>
				<p class="ask-small">Your badge reads Loca and then your name. The line underneath is yours to write — the dog whisperer, the Jill of all trades, whatever suits you. Skip it and your name does the work on its own.</p>
				<p class="ask-small">Your first name is the one neighbours read. Your full name and your address are asked for later, by your grown-up, and they stay with us.</p>

			<?php elseif ( 'doing' === $localilly_at ) : ?>
				<div class="ask-picks">
					<?php foreach ( localilly_the_eight() as $localilly_label ) : ?>
						<label class="pick-box">
							<input type="checkbox" name="doing[]" value="<?php echo esc_attr( $localilly_label ); ?>"
								<?php checked( in_array( $localilly_label, (array) ( $localilly_said['doing'] ?? array() ), true ) ); ?>>
							<span><?php echo esc_html( $localilly_label ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>

			<?php elseif ( 'words' === $localilly_at ) : ?>
				<label class="ask">
					<span>In your own words</span>
					<textarea name="words" rows="6" maxlength="600" placeholder="I've mowed our lawn since I was young and I'm good at it. I have my own mower and I turn up when I say I will."><?php echo esc_textarea( $localilly_said['words'] ?? '' ); ?></textarea>
				</label>
				<p class="ask-small">Say what you like doing and what you are good at. Nobody edits this but you.</p>

			<?php elseif ( 'rates' === $localilly_at ) : ?>
				<?php
				$localilly_have = $localilly_said['rates'] ?: array();
				$localilly_rows = $localilly_said['doing'] ?: array( 'An hour' );
				?>
				<div class="ask-rates">
					<?php foreach ( $localilly_rows as $localilly_i => $localilly_row ) :
						$localilly_was = $localilly_have[ $localilly_i ] ?? array(); ?>
						<fieldset class="rate-row">
							<input type="hidden" name="rate_what[]" value="<?php echo esc_attr( $localilly_row ); ?>">
							<legend><?php echo esc_html( $localilly_row ); ?></legend>
							<div class="rate-shape">
								<?php foreach ( localilly_rate_shapes() as $localilly_k => $localilly_word ) : ?>
									<label>
										<input type="radio" name="rate_kind[<?php echo (int) $localilly_i; ?>]" value="<?php echo esc_attr( $localilly_k ); ?>"
											<?php checked( ( $localilly_was['kind'] ?? LOCALILLY_ASKED ), $localilly_k ); ?>>
										<span><?php echo esc_html( $localilly_word ); ?></span>
									</label>
								<?php endforeach; ?>
							</div>
							<label class="rate-much">
								<span>Your Price</span>
								<input type="number" name="rate_much[<?php echo (int) $localilly_i; ?>]" min="0" max="999" inputmode="numeric"
									value="<?php echo esc_attr( (string) ( $localilly_was['amount'] ?? '' ) ); ?>" placeholder="25">
							</label>
						</fieldset>
					<?php endforeach; ?>
				</div>
				<p class="ask-small">Most young people mowing a lawn ask between twenty and forty dollars. Yours is yours to set, and you can change it any time.</p>

			<?php elseif ( 'shots' === $localilly_at ) : ?>
				<div class="shots" id="shots" data-limit="10">
					<input type="file" id="shot-in" accept="image/*" multiple hidden>
					<button type="button" class="plate press" id="shot-add">Add A Picture</button>
					<ul class="shots-held" id="shots-held"></ul>
					<noscript><p class="ask-small">Pictures want a browser that runs scripts. Carry on without them and add some later.</p></noscript>
				</div>
				<?php foreach ( $localilly_said['shots'] ?? array() as $localilly_shot ) : ?>
					<input type="hidden" name="shots[]" value="<?php echo esc_attr( $localilly_shot ); ?>">
				<?php endforeach; ?>
				<p class="ask-small">Pictures of the work rather than of you — a lawn you cut, a car you washed, a shed you sorted. Ten at most, and each one is made small on your phone before it travels, so this costs you almost no data.</p>

			<?php elseif ( 'free' === $localilly_at ) : ?>
				<label class="ask">
					<span>When Suits You</span>
					<input type="text" name="free" maxlength="140" value="<?php echo esc_attr( $localilly_said['free'] ?? '' ); ?>" placeholder="Saturday and Sunday mornings, and after school on Thursdays">
				</label>

			<?php elseif ( 'grown' === $localilly_at ) : ?>
				<label class="ask">
					<span>Their Name</span>
					<input type="text" name="grown" maxlength="60" required value="<?php echo esc_attr( $localilly_said['grown'] ?? '' ); ?>" placeholder="Whoever that is for you">
				</label>
				<?php
				/*
				 * ── IT DOES NOT HAVE TO BE A PARENT, AND IT SAYS SO ───────
				 *
				 * Her ruling, 25 August 2026: **we can't assume a sixteen-year-old
				 * lives at home; a fifteen-year-old may have drunk or alcoholic
				 * parents. We can't assume the parent is a safe place.**
				 *
				 * The placeholder read *your mum, dad, nan or carer*, which is
				 * broad and still names a household first. **A young person
				 * whose household is the difficulty reads that and counts
				 * herself out**, and she is one of the readers rather than the
				 * exception.
				 *
				 * So the widest true answer is given plainly, and named as
				 * ordinary rather than as an allowance made for her.
				 */
				?>
				<p class="who-sees">Anybody over eighteen who is really there for you — a mum or dad, a nan, an aunt, an older brother or sister, a carer, a teacher, a friend&rsquo;s mum. You choose who it is.</p>
				<label class="ask">
					<span>Their Email</span>
					<input type="email" name="grown_email" maxlength="120" required value="<?php echo esc_attr( $localilly_said['grownm'] ?? '' ); ?>" placeholder="so we can say hello to them">
				</label>
				<label class="ask">
					<span>Your Birthday, From Them</span>
					<input type="date" name="born" required value="<?php echo esc_attr( $localilly_said['born'] ?? '' ); ?>"
						max="<?php echo esc_attr( gmdate( 'Y-m-d', strtotime( '-15 years' ) ) ); ?>"
						min="<?php echo esc_attr( gmdate( 'Y-m-d', strtotime( '-19 years' ) ) ); ?>">
				</label>
				<label class="ask">
					<span>Your Family Name</span>
						<input type="text" name="last_name" maxlength="60" value="<?php echo esc_attr( $localilly_said['last_name'] ?? '' ); ?>" placeholder="Your family name">
					</label>
					<?php localilly_who_sees( 'name' ); ?>
					<label class="ask">
						<span>Your House Number</span>
						<input type="text" name="number" maxlength="20" value="<?php echo esc_attr( $localilly_said['number'] ?? '' ); ?>" placeholder="14">
					</label>
					<?php localilly_who_sees( 'number' ); ?>
					<label class="ask">
						<span>Your Street</span>
					<input type="text" name="street" maxlength="80" value="<?php echo esc_attr( $localilly_said['street'] ?? '' ); ?>" placeholder="Wilson Street">
				</label>
				<?php localilly_who_sees( 'street' ); ?>
					<?php localilly_who_sees( 'born' ); ?>
				<p class="ask-small">Your grown-up gives your birthday rather than you, and all of it comes with you when you are older.</p>
			<?php endif; ?>

			<button type="submit" class="build-go press">Keep This And Carry On</button>
		</form>

	<?php endif; ?>

	<?php if ( $localilly_page ) : ?>
		<ol class="build-road">
			<?php foreach ( $localilly_all as $localilly_key => $localilly_m2 ) : ?>
				<li class="<?php echo $localilly_done[ $localilly_key ] ? 'is-kept' : ''; ?><?php echo $localilly_key === $localilly_at ? ' is-here' : ''; ?>">
					<a href="<?php echo esc_url( add_query_arg( 'moment', $localilly_key, get_permalink() ) ); ?>"><?php echo esc_html( $localilly_m2['ask'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ol>
	<?php endif; ?>

</main>

<?php
get_footer();
