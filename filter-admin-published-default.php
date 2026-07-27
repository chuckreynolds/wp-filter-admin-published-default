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
 * Version:           2.0.1
 * Requires at least: 5.2
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

	global $submenu;

	foreach ( $types as $type ) {
		// Posts use a different submenu key than other post types.
		if ( 'post' === $type ) {
			$submenu['edit.php'][5][2] = 'edit.php?post_status=publish';
		} else {
			$encoded = rawurlencode( $type );
			$submenu[ 'edit.php?post_type=' . $encoded ][5][2] = 'edit.php?post_type=' . $encoded . '&post_status=publish';
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
