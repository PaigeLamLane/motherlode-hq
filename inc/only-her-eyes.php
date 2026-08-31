<?php
/**
 * Only Her Eyes.
 *
 * A young person's record holds their full name, their birthday, the street
 * they live on and the number of the house — held on her ruling of 25 August,
 * for one reason she gave herself: **if something ever happens we need to know
 * where to go.**
 *
 * It was registered on `capability_type => 'post'`, which means **every account
 * able to edit a post on this site could open it.** An Administrator, and an
 * Editor. Nothing narrowed it to her.
 *
 * That was survivable while the record held a first name and a street. **Her
 * ruling made it a full name and a front door**, and the same registration then
 * hands a child's address to anybody ever added to write copy.
 *
 * **Her ruling created the exposure and her ruling answers it.** She asked for
 * an address held so a young person can be reached. She never asked for it to
 * be readable by whoever writes a page.
 *
 * WHY A FILTER RATHER THAN THREE EDITS
 *
 * Three record types carry a person: a young person, a name given at the door,
 * and a parent asking for their child to be removed. **One filter holds all
 * three in one place**, so the next reader finds the rule rather than three
 * copies of it that can drift apart.
 *
 * WHAT THIS DOES NOT TOUCH
 *
 * The front-end road is unchanged and cannot be affected by it. A young person
 * is found by the key in their browser rather than by a capability, and that
 * query is not capability-gated — checked rather than assumed before this was
 * written.
 *
 * @package LocaLilly
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * The record types that hold a person.
 *
 * @return string[]
 */
function localilly_records_of_people(): array {
	return array( 'localilly_young', 'localilly_name', 'localilly_askback', 'localilly_neighbour' );
}

/**
 * Register them behind the family's own lock.
 *
 * ── AUNT TEA BUILT IT SHARED, AND PROVED IT FROM THE WRONG SIDE ──────
 *
 * `lamoureux-accounts` 0.2.3 carries `Lamoureux_Hands::READ_A_PERSON`, and a
 * real account in the new role was signed in and refused: it may write a page,
 * publish it, upload a photograph and change the theme colours, and it may not
 * open a person, list the users, change the settings or export the database.
 *
 * **One call across forty-three rather than forty-three guards**, so mine is
 * dropped in favour of it. My own capability proved nothing, having never
 * refused anybody.
 *
 * **And the naming is the part worth keeping.** Private screens across the
 * family were guarded with `manage_options`, which means *may change how this
 * site is configured*. **A record about a person is not a setting.** Two
 * different ideas sharing one word is what made this fault ordinary rather than
 * careless.
 *
 * A FALLBACK, BECAUSE A LOCK THAT DEPENDS ON A PLUGIN IS A LOCK WITH A
 * CONDITION ON IT
 *
 * Where the module is absent — a plugin deactivated, a theme moved to a site
 * that lacks it — these records fall back to a capability of this theme's own
 * that no role holds but hers. **A child's address is the wrong place to fail
 * open.**
 *
 * @param array  $args Registration arguments.
 * @param string $type The post type.
 * @return array
 */
function localilly_records_answer_to_her( array $args, string $type ): array {
	if ( ! in_array( $type, localilly_records_of_people(), true ) ) {
		return $args;
	}

	$cap = class_exists( 'Lamoureux_Hands' ) ? Lamoureux_Hands::READ_A_PERSON : 'localilly_read_a_person';

	/*
	 * Every capability points at the one word, meta and primitive alike, so
	 * there is no second road into these records for somebody who may edit an
	 * ordinary page.
	 */
	/*
	 * ── THE META CAPABILITIES ARE LEFT ALONE, AND THAT IS THE WHOLE TRICK ──
	 *
	 * My first version named `edit_post`, `read_post` and `delete_post` here
	 * as well, pointing all three at the same word as the primitive caps.
	 *
	 * **That locked her out of her own children's records**, and every symptom
	 * pointed away from the cause: the role held the capability, her `allcaps`
	 * held it, and `current_user_can` still said no.
	 *
	 * The reason is that `register_post_type` builds a reverse map from a
	 * custom meta-capability name back to the meta cap it stands for. Naming
	 * the meta caps `lamoureux_read_a_person` made **the word itself a meta
	 * capability** — and a meta capability asked without a post to ask about
	 * resolves to `do_not_allow`, for everybody, her included.
	 *
	 * So only the primitive capabilities are named, and WordPress maps its own
	 * meta caps onto them. Found on the bench in the first minute of asking
	 * from the wrong side, and it would have looked exactly like a working
	 * site.
	 */
	$args['capabilities'] = array(
		'edit_posts'             => $cap,
		'edit_others_posts'      => $cap,
		'delete_posts'           => $cap,
		'delete_others_posts'    => $cap,
		'delete_private_posts'   => $cap,
		'delete_published_posts' => $cap,
		'publish_posts'          => $cap,
		'read_private_posts'     => $cap,
		'edit_private_posts'     => $cap,
		'edit_published_posts'   => $cap,
		'create_posts'           => $cap,
	);

	$args['map_meta_cap'] = true;

	return $args;
}
add_filter( 'register_post_type_args', 'localilly_records_answer_to_her', 10, 2 );

/**
 * And make sure she holds it, on every load.
 *
 * **The half that matters more than the lock.** A capability change that
 * quietly hides a child's record from her is the same fault pointing the other
 * way, and it would look exactly like a working site.
 *
 * The shared module makes the role once and then only when its own shape moves.
 * **This checks on every load instead**, so a plugin that edits roles, a theme
 * reinstalled, or an activation that never ran cannot leave her locked out of
 * her own children's records. One role read, and a write only where a
 * capability is genuinely absent.
 */
function localilly_she_can_always_see(): void {
	$her = get_role( 'administrator' );

	if ( ! $her ) {
		return;
	}

	$caps = array( 'localilly_read_a_person' );

	if ( class_exists( 'Lamoureux_Hands' ) ) {
		$caps[] = Lamoureux_Hands::READ_A_PERSON;
	}

	foreach ( $caps as $cap ) {
		if ( ! $her->has_cap( $cap ) ) {
			$her->add_cap( $cap );
		}
	}
}
add_action( 'admin_init', 'localilly_she_can_always_see', 1 );
add_action( 'init', 'localilly_she_can_always_see', 1 );
