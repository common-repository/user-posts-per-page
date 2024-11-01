<?php
/**
 * Plugin Name: User Posts Per Page
 * Plugin URI: http://thoughtengineer.com/
 * Description:  Allows the user to dynamically set the number of posts to show per page. Works for custom post types and custom taxonomies too.
 * Version: 1.0.1
 * Author: Samer Bechara
 * Author URI: http://thoughtengineer.com/
 * Text Domain: user-posts-per-page
 * Domain Path: /languages
 * License: GPL2
 */

/*  Copyright 2014  Samer Bechara  (email : sam@thoughtengineer.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Define plugin path and URL constant - makes it easier to include files 
define( 'UPPP_PATH', plugin_dir_path( __FILE__ ) );
define( 'UPPP_URL', plugin_dir_url(__FILE__));

// Require our main plugin class
require_once (UPPP_PATH.'/lib/class-wp-uppp.php'); 

// Require our widget class
require_once (UPPP_PATH.'/lib/class-uppp-widget.php');

//Initialize our main plugin class
$uppp_object = new WP_UPPP();