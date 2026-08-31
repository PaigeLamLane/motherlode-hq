<?php
/**
 * Template Name: A Legal Page
 *
 * One template for the whole set. Which part it draws comes from the page slug,
 * so adding a part is a page rather than a template.
 *
 * **Her privacy page carries the fifth part inside it** — the section written
 * around a fifteen-year-old, under its own heading, so a parent finds it
 * without reading the rest.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

get_header();

$localilly_set  = localilly_the_legal_set();
$localilly_slug = get_post_field( 'post_name', get_the_ID() );
$localilly_page = $localilly_set[ $localilly_slug ] ?? null;
?>

<main class="legal">
	<?php if ( ! $localilly_page ) : ?>

		<h1 class="legal-title">We Write Back</h1>
		<p class="legal-under">Every page here carries a control that reaches us, and a person answers within the day.</p>

	<?php else : ?>

		<h1 class="legal-title"><?php echo esc_html( $localilly_page['title'] ); ?></h1>
		<p class="legal-under"><?php echo esc_html( $localilly_page['under'] ); ?></p>

		<?php foreach ( $localilly_page['parts'] as $localilly_part ) : ?>
			<section class="legal-part">
				<h2 class="legal-head"><?php echo wp_kses_post( $localilly_part['head'] ); ?></h2>
				<p class="legal-said"><?php echo wp_kses_post( $localilly_part['said'] ); ?></p>
			</section>
		<?php endforeach; ?>

		<?php if ( 'privacy' === $localilly_slug ) : ?>
			<section class="legal-fifth">
				<h2 class="legal-fifth-head">Your Young Person, And What We Hold</h2>
				<p class="legal-fifth-open">A fifteen-year-old opened a business here, and you are the reason they could.</p>
				<?php localilly_the_parent_table(); ?>
				<p class="legal-said">They are told the same at the moment they type each piece, in words written for them rather than for you.</p>
			</section>
		<?php endif; ?>

		<p class="legal-who"><?php echo esc_html( LOCALILLY_ENTITY ); ?> &middot; Victoria, Australia</p>

	<?php endif; ?>
</main>

<?php
get_footer();
