<?php
/*
Plugin Name: Filter Admin Published Default
Version: 1.1
Plugin URI: https://wordpress.org/plugins/filter-admin-published-default/
Description: Enables the Pages and Posts links in admin to show the Published filter by default
Author: Pigs Eating Hotdogs
Author URI: https://github.com/chuckreynolds/wp-filter-admin-published-default
Requires at least: 3.8
Tested up to: 4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2014 Internet

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
add_action ( 'admin_menu', 'rkv_filter_admin_published_default', 20 );
/**
 * change the default URL for post types
 * to only show published items
 *
 * @return [mixed]  updated URLs in the $submenu items
 */
function rkv_filter_admin_published_default() {
	// get our types
	$types = rkv_fetch_post_types();

	// bail if nothing comes back
	if ( empty( $types ) ) {
		return;
	}

	// ensure our types is indeed an array
	$types	= ! is_array( $types ) ? (array) $types : $types;

	// call global submenu item
	global $submenu;

	// loop our types and adjust the URL
	foreach( $types as $type ) {
		// handle post on its own since the type is
		// not declared in the $submenu string
		if ( $type == 'post' ) {
			// edit main link for posts
			$submenu['edit.php'][5][2] = 'edit.php?post_status=publish';
		} else {
			// edit main link for all other types
			$submenu['edit.php?post_type=' . esc_attr( $type ) ][5][2] = 'edit.php?post_type=' . esc_attr( $type ) . '&post_status=publish';
		}
	}

}

/**
 * fetch all public post types and filter
 *
 * @return [array]  post types for inclusion
 */
function rkv_fetch_post_types() {
	// set array of our default to include posts and pages
	$types = array( 'post', 'page' );

	// set args for looking up custom post types
	$args = array(
		'public'    => true,
		'_builtin'  => false
	);

	// call our types
	$custom = get_post_types( $args, 'names', 'and' );

	// if no custom types exist, just return our defaults
	if ( empty( $custom ) ) {
		return $types;
	}

	// merge our CPTs with the normal
	$types = array_merge( $types, $custom );

	// return it filtered
	return apply_filters( 'rkv_admin_publish_link_types', $types );
}
