<?php
/**
 * The bar at the top of every page.
 *
 * 31 August 2026 — replaced entirely. This was LocaLilly's own burger-menu
 * bar (nameplate, weather plate, hamburger, "bar-mine" account link) wearing
 * MotherLode's logo — her words that night: "you now do the whole taking it
 * to Motherlode... make it yours." The home page already had its own clean
 * top bar (nav left, logo top-right, her instruction); this makes that the
 * one bar the whole site uses, so every page carries it, not just the home
 * page. Her important 30 August ruling — once someone is known here, her
 * own name sits on the bar as the door to her account, never buried in a
 * hidden menu — is carried forward, restyled to match.
 *
 * @package LocaLilly
 */

defined( 'ABSPATH' ) || exit;

$lode_verified = function_exists( 'localilly_they_are_verified' ) && localilly_they_are_verified();
$lode_account_label = 'Your MotherLode';
if ( $lode_verified ) {
	$lode_place = function_exists( 'localilly_their_place' ) ? localilly_their_place() : null;
	$lode_name  = $lode_place ? (string) get_post_meta( $lode_place->ID, '_ll_name', true ) : '';
	$lode_first = $lode_name ? strtok( $lode_name, ' ' ) : '';
	if ( $lode_first ) {
		$lode_account_label = $lode_first . '&rsquo;s MotherLode';
	}
}
?>
<div class="lode-topbar">
	<div class="in lode-topbar-in">
		<a class="lode-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="MotherLode HQ, home">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/motherlode-logo.png' ); ?>" alt="MotherLode HQ" width="900" height="600" fetchpriority="high" decoding="async">
		</a>
		<nav class="lode-nav" aria-label="Primary">
			<?php
			/*
			 * 1 September 2026 — real bug: these pointed at #for-business
			 * and #for-talent anchors that never existed anywhere on the
			 * page. Real pages now.
			 */
			?>
			<a href="<?php echo esc_url( home_url( '/for-business/' ) ); ?>">For business</a>
			<a href="<?php echo esc_url( home_url( '/for-talent/' ) ); ?>">For talent</a>
			<a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>">How it works</a>
			<?php if ( $lode_verified ) : ?>
				<a class="lode-nav-join" href="<?php echo esc_url( home_url( '/your-place/' ) ); ?>"><?php echo wp_kses_post( $lode_account_label ); ?></a>
			<?php else : ?>
				<a class="lode-nav-join" href="<?php echo esc_url( home_url( '/join/' ) ); ?>">Join</a>
			<?php endif; ?>
		</nav>
	</div>
</div>
