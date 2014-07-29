<?php
/*
 * Plugin Name: Filter Admin Published Default
 * Version: 1.0
 * Plugin URI: https://gist.github.com/chuckreynolds/0fa3af52462b5929e74d
 * Description: Enables the Pages and Posts links in admin to show the Published filter by default
 * Author: Pigs Eating Hotdogs
 * Author URI: https://github.com/chuckreynolds/wp-filter-admin-published-default
 * Requires at least: 3.8
 * Tested up to: 4.0
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