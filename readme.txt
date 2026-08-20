=== Filter Admin Published Default ===
Contributors: ryno267, norcross
Donate link:
Tags: admin, published, edit link, posts edit, pages edit
Requires at least: 5.2
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enables all public post types (posts, pages, and any CPT with a public URL) in wp-admin to show the Published filter by default.

== Description ==

Enables all public post types in wp-admin to show the Published filter by default: posts, pages, and any custom post type with a public URL. Those are the post types where the distinction actually matters, the ones with a front end, where you want to see at a glance what is live and what is not.

This came out of a real need. Some clients of mine had so many drafts and pre-scheduled posts that the published ones were pushed off the first page entirely, and finding a live post meant paginating through drafts to get to it. I got tired of the extra click to filter by published every single time. I tweeted out for ideas and @Norcross answered and quickly whipped up this; which we turned into a plugin for public release and here you go!

== Usage ==

Once activated you don't need to do anything.

== Installation ==

Installing "Filter Admin Published Default" can be done either by searching for "Filter Admin Published Default" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via https://wordpress.org/plugins/filter-admin-published-default/
1. Upload the ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
1. How does it work? Just install, activate, and you're good!

== Changelog ==

= 2.1.0 =
* Fixed a fatal error. The `chuck_admin_publish_link_types` filter is public, and a callback returning a non-string post type reached `rawurlencode()`, which throws a TypeError on PHP 8 and took down every admin page with a white screen. Filter output is now validated before use.
* The "All items" link is now located by matching its URL instead of assuming submenu index 5. Index 5 is core's convention, not a contract, so a plugin that reorders the submenu could previously cause the wrong link to be rewritten.
* A link another plugin has already repointed is now left alone instead of being overwritten.
* Added the Requires PHP header to the plugin and readme.

= 2.0.2 =
* Tested up to WordPress 7.1
* Fixed: post types that are public but hidden from the admin menu no longer get a malformed submenu entry fabricated for them. Writing to a menu key WordPress never registered created an item with no title and no capability, which polluted the global admin menu for anything that walks it.

= 2.0.1 =
* Fix URL escaping to use rawurlencode() instead of esc_attr()
* Strengthen direct access guard with ABSPATH check
* Remove redundant empty check

= 2.0.0 =
* 2026-03-09
* Tested and compatible with WordPress 6.9.1
* Requires WordPress 5.2+
* Fixed: `chuck_admin_publish_link_types` filter now applies even when no custom post types are registered
* Removed redundant type-casting code
* Code cleanup and modernization

= 1.3 =
* 2017-11-14
* tested to wp 4.9

= 1.2 =
* 2017-09-02
* tested to wp 4.8.1
* clarify plugin descriptions
* secured against any direct plugin file access

= 1.1 =
* 2015-04-25
* tested to wp 4.2

= 1.0.1 =
* 2014-09-25
* Expanded to include all public post types excluding attachments (media)
* Adds `chuck_admin_publish_link_types` filter to add / remove types

= 1.0 =
* 2014-07-28
* Initial release after twitter conversation: https://twitter.com/ChuckReynolds/status/493933761851965443

== Upgrade Notice ==

= 2.1.0 =
* Fixes a fatal error that could white-screen wp-admin when another plugin uses the chuck_admin_publish_link_types filter. Recommended for everyone.

= 2.0.2 =
* Tested on WordPress 7.1. Fixes malformed admin menu entries for public post types that are hidden from the menu.

= 2.0.1 =
* Security and code quality fixes.

= 2.0.0 =
* 2026-03-09
* Compatibility update for modern WordPress (5.0+). Filter fix for default post types.
