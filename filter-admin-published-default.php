<?php
/*
Plugin Name: Filter Admin Published Default
Version: 1.0
Plugin URI: https://gist.github.com/chuckreynolds/0fa3af52462b5929e74d
Description: Enables the Pages and Posts links in admin to show the Published filter by default
Author: Pigs Eating Hotdogs
Author URI: https://github.com/chuckreynolds/wp-filter-admin-published-default
Requires at least: 3.8
Tested up to: 4.0
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
add_action ( 'admin_menu', 'rkv_filter_admin_published_default' );

function rkv_filter_admin_published_default() {
	// call global submenu item
	global $submenu;

	// edit main link for posts
	$submenu['edit.php'][5][2] = 'edit.php?post_status=publish';

	// edit main link for pages
	$submenu['edit.php?post_type=page'][5][2] = 'edit.php?post_type=page&post_status=publish';

}