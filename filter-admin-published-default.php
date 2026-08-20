<?php
/**
 * Filter Admin Published Default
 *
 * @package           Filter_Admin_Published_Default
 * @author            Chuck Reynolds
 * @link              https://chuckreynolds.com
 * @copyright         2013 Rynoweb LLC
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       Filter Admin Published Default
 * Plugin URI:        https://github.com/chuckreynolds/wp-filter-admin-published-default
 * Description:       Enables all public post types (posts, pages, etc) in wp-admin to show the Published filter by default.
 * Version:           2.0.3
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Chuck Reynolds
 * Author URI:        https://chuckreynolds.com
 * Text Domain:       filter-admin-published-default
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) || ! defined( 'ABSPATH' ) ) {
	die;
}

// Only run plugin in the admin
if ( ! is_admin() ) {
	return;
}

/**
 * Change the default URL for post types to only show published items.
 *
 * @return void
 */
function chuck_filter_admin_published_default() {
	$types = chuck_fetch_post_types();

	// chuck_admin_publish_link_types is public, so a third-party callback can
	// hand back anything. Bad input used to reach rawurlencode() and take the
	// whole admin down with a TypeError on PHP 8.
	if ( ! is_array( $types ) ) {
		return;
	}

	global $submenu;

	foreach ( $types as $type ) {
		if ( ! is_string( $type ) || '' === $type ) {
			continue;
		}

		// Posts use a different submenu key than other post types.
		$menu_key = ( 'post' === $type )
			? 'edit.php'
			: 'edit.php?post_type=' . rawurlencode( $type );

		// Post types that are public but hidden from the admin menu have no
		// submenu at all. Writing to one fabricates a malformed item with no
		// title and no capability, so leave those alone.
		if ( empty( $submenu[ $menu_key ] ) || ! is_array( $submenu[ $menu_key ] ) ) {
			continue;
		}

		// Rewrite the item that points at the unfiltered list, wherever it sits.
		// Core puts it at index 5, but that is its convention rather than a
		// contract. Matching on the slug also means a link another plugin has
		// already repointed is left as they set it.
		foreach ( $submenu[ $menu_key ] as $index => $item ) {
			if ( ! isset( $item[2] ) || $menu_key !== $item[2] ) {
				continue;
			}

			$submenu[ $menu_key ][ $index ][2] = add_query_arg( 'post_status', 'publish', $menu_key );
			break;
		}
	}
}
add_action( 'admin_menu', 'chuck_filter_admin_published_default', 20 );

/**
 * Fetch all public post types.
 *
 * @return array Post type names.
 */
function chuck_fetch_post_types() {
	$types = array( 'post', 'page' );

	$custom = get_post_types(
		array(
			'public'   => true,
			'_builtin' => false,
		),
		'names',
		'and'
	);

	if ( ! empty( $custom ) ) {
		$types = array_merge( $types, $custom );
	}

	/**
	 * Filter the post types that get the published default in wp-admin.
	 *
	 * @param array $types Post type names.
	 */
	return apply_filters( 'chuck_admin_publish_link_types', $types );
}
