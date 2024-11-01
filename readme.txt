=== User Posts Per Page ===
Contributors: arbet01
Tags: taxonomies, count, pagination, user, marketpress, woocommerce, network, archives, posts-per-page, paged, posts, count, number, custom-post-type, multisite, multi-site
Requires at least: 3.3
Tested up to: 4.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows the user to dynamically set the number of posts to show per page on category pages, tag pages, author pages and all other archive pages. Works for custom post types and taxonomies too.

== Description ==
This plugin allows your website visitors to set the number of posts they see per page. It will insert a form at the top of your posts page in order to allow your website visitors to quickly set the number of posts they want to see per page. 

*Detailed Features*

User Posts Per Page allows your website visitors to set the number of posts per page, and remembers that number everytime they reach your website. 

* Works with posts, pages and custom post types 
* Works on Category pages, tag pages, author pages, archive pages, and custom post type archive pages.
* Number of posts per page remembered for logged in users
* Cookie set for non-logged in users to remember settings
* On network installs, network administrator is able to set the default number of posts per page across the whole network

*Plugin Usage*

* Go to Appearance->Widgets and add your widget to any sidebar of any archive page
* Alternatively, you can use the shortcode [user_posts_per_page] to insert this in your theme using
the function <code>echo do_shortcode('[user_posts_per_page]');</code>
== Installation ==
1. Install your plugin as usual through the plugin installer inside wordpress admin or via manual upload
1. If this is a network install, go to Network Admin->User Posts Per Page and set default settings there
1. Go to Settings->User Posts Per Page and define your website settings there. 
1. Go to appearance->widgets and enable it on your sidebar, or use the shortcode found on the settings page

== Frequently Asked Questions ==
= Do I need a network install for this to work? =

No, it works on any website normally. However, if activated on a network installation, it adds some options that are specific to network websites.

= My widget is not showing, why? =

The widget only shows in the sidebar of your archive pages, e.g. is_archive() function is true
If you have no sidebar on your taxonomy pages, you will need to manually add the shortcode [user_posts_per_page] to your theme 

== Changelog ==
= 1.0 =
* Initial Release 