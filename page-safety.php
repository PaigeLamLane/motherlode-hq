<?php
/**
 * Template Name: Layers Of Safety
 *
 * WHY, RATHER THAN WHAT. Her words, 23 August 2026: that should go to a page,
 * there's not much information, that's what I'm missing, we need a whole page
 * about this, why we're doing it.
 *
 * **A parent handing their fourteen-year-old to a neighbour wants to know that
 * somebody thought about this at all.** A list of measures answers a different
 * question than the one they are asking. So every layer below says what it is
 * for before it says what it does.
 *
 * HER LAWS SHAPE THE WRITING AS MUCH AS THE DESIGN.
 *
 * Nothing is defined by a negation that plants a fear. A safety page is where
 * that law is hardest and where it matters most — naming a danger to deny it
 * puts the danger in a parent's head, and it stays there. So each layer says
 * what stands rather than what is kept out.
 *
 * And the honest half belongs here, since a page claiming more than it can hold
 * is the one failure a parent would never forgive.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

/*
 * ── THE LAYERS ARE HERS TO EDIT ───────────────────────────────────────
 *
 * The words below are the floor rather than the text. Every one of them reads
 * her panel first, so the page a parent trusts is written by the person whose
 * business it is rather than by whoever last touched the file.
 *
 * She added the map layer herself on 23 August: **the map is drawn from the
 * street so somebody can see a young person is two streets away, and it never
 * shows which house.**
 *
 * ── AND HER RULING OF 25 AUGUST CHANGED WHAT STANDS BEHIND THAT ──────
 *
 * It used to rest on a fact never collected, which is the strongest promise
 * there is. **She has ruled the number is collected and held**, and gave the
 * reason: where anything ever happens to a young person, somebody has to know
 * exactly where to go.
 *
 * **So the map layer is unchanged and its guard is now a held one.** The number
 * is written into the profile shut by name, reaches no template, and is said
 * plainly under the box at the moment it is typed.
 *
 * **This passage is kept rather than deleted** — a promise that changed its
 * footing is worth the next reader knowing about.
 */
$localilly_layers = array(
	array(
		'name' => 'Fifteen Is The Age, And It Is The Law',
		'why'  => 'Young people here are fifteen to eighteen. **Fifteen is the age a young person can work without their employer holding a permit**, and it is the law rather than a rule of ours.',
		'so'   => 'Every young person you meet here is old enough to be doing this, and we hold what proves it.',
	),
	array(
		'name' => 'A Real Card Comes First',
		'why'  => 'A neighbour gives one dollar on a card in their own name before they can search, and long before they can write a word. One dollar is small enough to stand in nobody\'s way and large enough to require a bank, a name and an address that already agree with each other.',
		'so'   => 'Everybody who reaches a young person here has already told the truth about who they are, to somebody who checks.',
	),
	array(
		'name' => 'An Adult Opens The Account',
		'why'  => 'A young person\'s account begins with the adult who is responsible for them. They put their own name down, and they stay on it.',
		'so'   => 'A parent knows on the first day rather than the worst one.',
	),
	array(
		'name' => 'A Nameplate, Rather Than A Face',
		'why'  => 'Every young person here arrives inside the same beautiful frame, carrying their name and their own words. Photographs of young people stay where they belong, which is at home.',
		'so'   => 'A neighbour chooses somebody by what they wrote and what they can do. And the same frame for everybody means the confident one and the quiet one arrive looking equal.',
	),
	array(
		/*
		 * The heading her ruling of 25 August left behind. It read A Street,
		 * Never A Number while the paragraph beneath it already said the whole
		 * address is held — **a heading arguing with its own paragraph**, and
		 * the heading is the half she reads first.
		 */
		'name' => 'A Street They See, An Address We Hold',
		'why'  => 'A neighbour is shown a first name, a suburb and a street, and that is the whole of what is public. **We hold the full address here, under lock, for one reason: where anything ever happens to a young person, somebody has to know exactly where to go.** They are told so at the moment they type it, in the same words we are using now.',
		'so'   => 'A door stays a door until a young person opens it themselves.',
	),
	array(
		'name' => 'Close By, Rather Than Findable',
		/*
		 * ── THE SECOND ONE HER RULING LEFT BEHIND ─────────────────────
		 *
		 * This closed on *a fact we were never told is a fact nobody here
		 * can give away* — which was the strongest promise available, right
		 * up to the moment she ruled that the whole address is held.
		 *
		 * **Layer 05 was corrected the same afternoon and this survived**,
		 * because it phrases the same fact in words neither sweep searched
		 * for. Found by `scripts/promises-check.sh` on its first run.
		 *
		 * The map is unchanged. What changed is what stands behind it: a
		 * held fact under lock rather than an uncollected one. Said plainly,
		 * since a weaker guard described honestly is worth more than a
		 * stronger one described falsely.
		 */
		'why'  => 'The map shows a neighbour who is near them. It is drawn from the street, so somebody can see that a young person is two streets away, and the house itself is never on it. We ask for the full address and we say so at the moment we ask. It is held in the back end, and it is shown on no page of this site to anybody.',
		'so'   => 'A neighbour gets what they actually need, which is how far — and stops exactly there, at the edge of what they were owed.'
	),
	array(
		'name' => 'The First Word Is Written With Care',
		'why'  => 'A neighbour is walked through a moment that helps them say what they need properly — the work, the day, the place, and a picture if it helps.',
		'so'   => 'A young person can answer once and be right. And an adult who has to compose a real sentence to a real person behaves like one.',
	),
	array(
		'name' => 'Their Messages Belong To Them',
		'why'  => 'A first word reaches the young person, and they answer for themselves. **They can show any of it to the adult beside them whenever they choose** — that is their call rather than ours.',
		'so'   => 'The person running it decides who reads it, and they are old enough to make that call.',
	),
	array(
		'name' => 'Everybody Stands Level',
		'why'  => 'Young people here carry their own words and their own prices, in whatever order the page happens to hold them. A listing lifted for a month says so on its face.',
		'so'   => 'A young person is met rather than measured, and a neighbour always knows why somebody is where they are.',
	),
	array(
		'name' => 'The Money Goes Straight To Them',
		'why'  => 'A neighbour pays the young person directly, in whatever way the two of them agree. LocaLilly asks a young person for ten dollars a month to be here, and takes not a cent of what they earn.',
		'so'   => 'A young person keeps every dollar of their own work, and holds their own price when somebody asks them to drop it.',
	),
);
?>

<main class="layers-page">

	<header class="layers-top">
		<p class="layers-eyebrow">Why We Built It This Way</p>
		<h1 class="layers-title">Layers Of Safety</h1>
		<p class="layers-open">This site introduces adults to young people. Every screen here was drawn with that sentence in front of us, and each layer below answers the question a parent actually asks: did anybody think hard about this before my child arrived?</p>
		<p class="layers-open"><?php echo esc_html( localilly_say( 's_count' ) ?: 'Ten of them, and each one holds on its own.' ); ?></p>
	</header>

	<ol class="layers-list">
		<?php foreach ( $localilly_layers as $localilly_i => $localilly_layer ) : ?>
			<?php
			$localilly_n    = $localilly_i + 1;
			$localilly_name = localilly_say( 'sl' . $localilly_n . '_name' ) ?: $localilly_layer['name'];
			$localilly_why  = localilly_say( 'sl' . $localilly_n . '_why' ) ?: $localilly_layer['why'];
			$localilly_so   = localilly_say( 'sl' . $localilly_n . '_so' ) ?: $localilly_layer['so'];
			?>
			<li class="layer plate float" style="--n: <?php echo (int) $localilly_i; ?>">
				<p class="layer-count"><?php echo esc_html( str_pad( (string) $localilly_n, 2, '0', STR_PAD_LEFT ) ); ?></p>
				<h2 class="layer-name"><?php echo esc_html( $localilly_name ); ?></h2>
				<p class="layer-why"><?php echo wp_kses_post( localilly_strong( $localilly_why ) ); ?></p>
				<p class="layer-so"><?php echo esc_html( $localilly_so ); ?></p>
			</li>
		<?php endforeach; ?>
	</ol>

	<?php
	/*
	 * The honest half. Her ruling that the site says what is true rather than
	 * what is comfortable, and it is the section a parent will trust the rest
	 * of the page because of.
	 */
	?>
	<section class="layers-honest plate">
		<h2 class="layers-honest-head">And Here Is What We Ask Of You</h2>
		<p>Every layer above is real, and eight layers are still eight layers. A card tells us an adult is who they say they are, and it tells us little about who they are like. That part stays where it has always been, with the people who know a young person.</p>
		<p>So meet somebody the first time with a parent nearby. Talk about the work, the hours and the money before a young person starts. And where anybody here gives you pause, write to us — a message about a person on this site reaches a human being the same day.</p>
		<p class="layers-honest-last">A young person&rsquo;s first job should be the beginning of their working life, remembered warmly for the rest of it. That is the whole of what we are trying to build.</p>
	</section>

	<a class="layers-go press" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Join LocaLilly</a>

</main>

<?php
get_footer();
