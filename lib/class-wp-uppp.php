<?php

/*
 * Main User Posts Per Page class
 * @author Samer Bechara <sam@thoughtengineer.com>
 */
class WP_UPPP {
    
    public function __construct() {

	// Register our widget
	add_action( 'widgets_init', function(){
	     register_widget( 'UPPP_Widget' );
	});	
	
	// Register our shortcode
	add_shortcode('user_posts_per_page', array($this,'insert_shortcode') );
	
	// Register  options page on site admin and network admin
	add_action('admin_menu', array($this, 'register_site_options_pages'));
	add_action('network_admin_menu', array($this, 'register_network_options_pages'));
    }
    
    /*
     * Inserts a shortcode into our website
     * @param $atts The shortcode attributes
     * 
     */
    public function insert_shortcode($atts) {
	
	// Default attributes for shortcode
	$default = array('title' => 'Posts Per Page', 'shortcode' => true);
	
	// Merge user attributes with our default attributes	
	$atts = shortcode_atts($default, $atts, 'user_posts_per_page');
	
	// Send back our widget
	return the_widget('UPPP_Widget',$atts);
    }
    
    /*
     * Registers site options page
     */
    public function register_site_options_pages(){
	
	// Add site settings page
	add_submenu_page( 'options-general.php', 'Posts Per Page', 'User Posts Per Page Options', 'manage_options', 'uppp_site_options', array($this, 'display_site_options_page') );	
	// Register individual site options
	register_setting( 'uppp-site-options', 'uppp_site_num_results', 'intval' );
	register_setting( 'uppp-site-options', 'uppp_site_automatic_insertion');
		
    }
    
    /*
     * Registers network options page
     */
    public function register_network_options_pages(){
		
	// Add network settings page
	add_submenu_page( 'settings.php', 'Posts Per Page', 'User Posts Per Page Options', 'manage_network_options', 'uppp_network_options', array($this, 'display_network_options_page') );
	
	// Register network options
	register_setting( 'uppp-network-options', 'uppp_network_num_results', 'intval' );
	register_setting( 'uppp-network-options', 'uppp_network_automatic_insertion');
	
	
    }
    
    
    /*
     * Saves network admin options
     */
    public function save_network_options(){

	// Save default number of results per page
	update_option('uppp_network_num_results', $_POST['num_results']);
	
	// Check if automatically insert option has been set
	$automatic_insertion = isset($_POST['automatic_insertion'])?true:false;
	
	// Update option in database
	update_option('uppp_network_automatic_insertion', $automatic_insertion);	
    }
    
    /*
     * Saves site-specific options
     */
    public function save_site_options(){
	
	// Save default number of results per page
	update_option('uppp_site_num_results', $_POST['num_results']);
	
	// Check if automatically insert option has been set
	$automatic_insertion = isset($_POST['automatic_insertion'])?true:false;
	
	// Update option in database
	update_option('uppp_site_automatic_insertion', $automatic_insertion);
	
    }
    
    /*
     * Displays site options page
     */
      
    public function display_site_options_page(){
	require (UPPP_PATH.'/inc/site-options.php'); 
    }
    
    /*
     * Display network options page
     */
          
    public function display_network_options_page(){
	require (UPPP_PATH.'/inc/network-options.php'); 
    }
}