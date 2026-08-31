<?php
/**
 * How Big Her Words Are.
 *
 * **Her question, by name, 25 August 2026:** *I need to be able to change things
 * on the website. Can I change the font size on things?*
 *
 * **She could not.** No control on LocaLilly changed the size of any word
 * anywhere, and she reads on a large iMac and in a pane 379 wide.
 *
 * WHY IT IS A PAGE SCALE RATHER THAN A FONT SIZE
 *
 * Every size in this theme is `clamp(px, vw, px)`. A root font-size does nothing
 * to a px, so the ordinary answer — set `html { font-size }` — moves not one
 * word. **Measured before building rather than assumed.**
 *
 * The alternative is converting every clamp in the stylesheet to a scaled unit.
 * That is a sweep across a working design, and a blind sweep already turned this
 * stylesheet into `border-width: 15.5px` once today.
 *
 * **So the whole page is scaled instead.** One declaration, nothing else
 * touched, and it moves type, spacing and plates together — which is what she
 * actually means by bigger.
 *
 * IT IS HERS RATHER THAN A VISITOR'S
 *
 * A person's own browser already does this and does it better. This is the
 * control she asked for on her own site, so it sets what everybody arrives to.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * The three she can choose between.
 *
 * @return array<string, array{says:string, scale:string}>
 */
function localilly_her_sizes(): array {
	return array(
		'comfortable' => array(
			'says'  => 'Comfortable — the size it was designed at',
			'scale' => '1',
		),
		'larger'      => array(
			'says'  => 'Larger — a tenth bigger, everywhere',
			'scale' => '1.1',
		),
		'largest'     => array(
			'says'  => 'Largest — a fifth bigger, everywhere',
			'scale' => '1.2',
		),
	);
}

/**
 * Her choice, or the size it was designed at.
 */
function localilly_her_size(): string {
	$picked = (string) get_theme_mod( 'localilly_size', 'comfortable' );
	$sizes  = localilly_her_sizes();

	return isset( $sizes[ $picked ] ) ? $sizes[ $picked ]['scale'] : '1';
}

/**
 * Put it in her panel, where she already changes her words.
 *
 * @param WP_Customize_Manager $wp_customize The panel.
 */
function localilly_size_control( $wp_customize ): void {
	$wp_customize->add_section(
		'localilly_size',
		array(
			'title'       => 'How Big The Words Are',
			'description' => 'Every word on the site moves together, and the pictures and plates move with them.',
			'priority'    => 5,
		)
	);

	$wp_customize->add_setting(
		'localilly_size',
		array(
			'default'           => 'comfortable',
			'sanitize_callback' => static function ( $given ): string {
				return array_key_exists( (string) $given, localilly_her_sizes() ) ? (string) $given : 'comfortable';
			},
			'transport'         => 'refresh',
		)
	);

	$choices = array();

	foreach ( localilly_her_sizes() as $key => $one ) {
		$choices[ $key ] = $one['says'];
	}

	$wp_customize->add_control(
		'localilly_size',
		array(
			'section' => 'localilly_size',
			'label'   => 'The Size Of Everything',
			'type'    => 'radio',
			'choices' => $choices,
		)
	);
}
add_action( 'customize_register', 'localilly_size_control' );

/**
 * And say it in the page.
 *
 * Printed last so it wins, and skipped entirely at the size it was designed at
 * — a declaration that changes nothing is a declaration that can still surprise
 * somebody, and every browser handles zoom slightly differently.
 */
function localilly_her_size_on_the_page(): void {
	$scale = localilly_her_size();

	if ( '1' === $scale ) {
		return;
	}

	printf(
		'<style id="localilly-size">body{zoom:%s}</style>' . "\n",
		esc_html( $scale )
	);
}
add_action( 'wp_head', 'localilly_her_size_on_the_page', 99 );
