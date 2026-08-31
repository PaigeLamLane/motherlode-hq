<?php
/**
 * What a neighbour has written about themselves, kept and shown.
 *
 * Her ruling, 30 August: **the neighbour, as well as the young person, should
 * be setting a beautiful profile. It tells them about themselves.**
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * The script, only where somebody is writing their own page.
 */
function localilly_about_you_script(): void {
	if ( ! is_page_template( 'page-about-you.php' ) ) {
		return;
	}

	$where = get_stylesheet_directory_uri() . '/assets/js/about-you.js';
	$when  = (string) @filemtime( get_stylesheet_directory() . '/assets/js/about-you.js' );

	wp_enqueue_script( 'localilly-about-you', $where, array( 'lamoureux-moments', 'localilly-atelier' ), $when ?: '1', true );
	wp_localize_script( 'localilly-about-you', 'localillyAbout', array( 'where' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'localilly_about_you_script', 20 );

/**
 * She keeps what she wrote about herself.
 *
 * **Exactly as she left it.** The box is hers to rewrite from nothing, so what
 * is stored is whatever is in it — never a reassembled version of it.
 */
function localilly_keep_about_you(): void {
	if ( ! isset( $_POST['localilly_about_you'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['localilly_about_you'] ) ), 'localilly_about_you' ) ) {
		wp_send_json_error();
	}

	$place = localilly_their_place();

	if ( ! $place ) {
		wp_send_json_error();
	}

	update_post_meta(
		$place->ID,
		'_ll_about',
		localilly_safe_but_untidied( (string) wp_unslash( $_POST['about'] ?? '' ) )
	);

	wp_send_json_success();
}
add_action( 'wp_ajax_localilly_about_you', 'localilly_keep_about_you' );
add_action( 'wp_ajax_nopriv_localilly_about_you', 'localilly_keep_about_you' );

/**
 * Who wrote to a young person, as that young person reads it.
 *
 * **Their first name, their suburb, and their own words.** Never a surname,
 * never a street, never an email — those are held for her records alone, and
 * a young person needs a person rather than a file.
 *
 * @param string $from Who wrote, as the engine names them.
 */
function localilly_who_is_this( string $from ): void {
	if ( 0 !== strpos( $from, 'neighbour:' ) ) {
		return;
	}

	$id = localilly_whose_key( $from );

	if ( ! $id ) {
		return;
	}

	$name  = (string) get_post_meta( $id, '_ll_name', true );
	$where = (string) get_post_meta( $id, '_ll_suburb', true );
	$said  = (string) get_post_meta( $id, '_ll_about', true );

	if ( '' === $name && '' === $said ) {
		return;
	}
	?>
	<details class="whois">
		<summary class="whois-open"><?php
			echo esc_html( '' !== $name ? 'Who ' . $name . ' Is' : 'Who Wrote To You' );
		?></summary>
		<div class="whois-said">
			<?php if ( '' !== $where ) : ?>
				<p class="whois-where"><?php echo esc_html( $where ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $said ) : ?>
				<?php echo wp_kses_post( wpautop( esc_html( $said ) ) ); ?>
			<?php else : ?>
				<p class="room-empty"><?php echo esc_html( $name ); ?> has yet to write their own page. Their dollar is on a card in their own name.</p>
			<?php endif; ?>
		</div>
	</details>
	<?php
}
