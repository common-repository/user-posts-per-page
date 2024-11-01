<?php

/*
 * Implements our User Posts Per Page widget
 * @author Samer Bechara <sam@thoughtengineer.com>
 */
class UPPP_Widget extends WP_Widget {

    // Holds the widget instance array
    private $instance = false;

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {

	// Call parent constructior
	parent::__construct(
		'user_posts_per_page', // Base ID
		__('User Posts Per Page', 'user-posts-per-page'), // Name
		array( 'description' => __( 'Displays a form which allows you to limit the number of posts per page' ), ) // Args
	);
	
	// Modify the number of posts per page before query is sent
	add_action('pre_get_posts', array($this, 'set_number_of_posts'));
	
	// Add ajax action on the frontend for logged in and non-logged in users
	add_action( 'wp_ajax_uppp_get_posts', array($this,'ajax_get_posts') );
	add_action( 'wp_ajax_nopriv_uppp_get_posts', array($this,'ajax_get_posts') );
	
	// Include Ajax library on frontend
	add_action( 'wp_head', array( $this, 'add_ajax_library' ) );
	
    }
    
    /**
     * Adds the WordPress Ajax Library to the frontend.
     */
    public function add_ajax_library() {

	$html = '<script type="text/javascript">';
	    $html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
	$html .= '</script>';

	echo $html;

    } // end add_ajax_library    
    
    /*
     * Get posts via ajax
     */
    public function ajax_get_posts(){
	
	die();
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {		     	        	    

	global $wpdb; 
	
	// Hide for non-archive pages
	if (! is_archive() ){
	    return;
	}
	
	
	// Get posts per page
	$posts_per_page = $this->get_posts_per_page();
	
	// Initialize instance object
	$this->instance = $instance;
	
	// Enqueue our javascript file
	wp_enqueue_script( 'uppp-widget-js', UPPP_URL.'inc/uppp-widget.js', array('jquery') );	
	
	// Selectable posts per page
	$ppp_values = array( 5, 10, 20, 50, 100 );
	
	?>
	<form id='uppp_form' action="#" method="post" >
	    <label for="num_results"><?php echo $instance['title']?></label>
	    <select name="num_results" id="num_results">
	    <?php
		foreach($ppp_values as $num){
		    
		    // Check if this is selected
		    $selected = ($posts_per_page == $num)?"selected='selected'":"";
		    echo "<option value='$num' $selected>$num</option>";
		}
		
	    ?>
	    </select>
	</form>
	<?php
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

	// If title is set, use it
	if ( isset( $instance[ 'title' ] ) ) {
	    $title = $instance[ 'title' ];
	}
	// Use default title
	else {
	    $title = 'Posts Per Page';
	}
   
	?>
	<p>
	    <!-- Widget Title Field -->
	    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label> 
	    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	</p>

	<?php 

    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {

	// Initialize instance
	$instance = array();
	
	// Set widget title based on user entered option
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';	    

	// Return values to be saved
	return $instance;	    
    }
    
    /*
     * Sets the number of posts for the query
     * @param WP_Query $query	The current wordpress query
     */
    public function set_number_of_posts($query){
	
	// Don't apply to admin or to queries we don't want to paginate
	if ( ! $this->is_uppp_query($query) ){
	    return;
	}
	
	// Get posts per page for the current user
	$posts_per_page = $this->get_posts_per_page();
	
	// Alter the number of posts
	$query->set('posts_per_page', $posts_per_page);
	
	// Update user cookie - remember results per page for one month
	//setcookie('user_posts_per_page', $posts_per_page, time() + 30*24*60*60);
	
	// Update user meta field if user is logged in
	if(is_user_logged_in()){
	    update_user_meta(get_current_user_id(), 'uppp_user_num_results', $posts_per_page);
	}
    }
    
    /*
     * Get the number of posts to display
     */
    private function get_posts_per_page(){
	
	// If post variable is set, use it
	if(isset($_POST['num_results'])){
	    
	    // Convert posted value to integer
	    $posts_per_page = intval( $_POST['num_results'] );
	    
	    // This is a valid integer, set cookie and user meta then return it
	    if($posts_per_page != 0){		
	
		// return value
		return $posts_per_page;
	    }
	}
	
	// Post variable not set, check for custom user meta
	elseif(is_user_logged_in() && get_user_meta(get_current_user_id (), 'uppp_user_num_results', true) != '') {
		
	    $posts_per_page = get_user_meta(get_current_user_id (), 'uppp_user_num_results', true);
	    
	    return $posts_per_page;

	}
	
	// No custom user meta, check for user cookie
	elseif(isset($_COOKIE['user_posts_per_page'])){
	    $posts_per_page = $_COOKIE['user_posts_per_page'];
	    
	    return $posts_per_page;
	}
	
	// No cookie is set, check for site default
	elseif(get_option('uppp_site_num_results')){
	    $posts_per_page = get_option('uppp_site_num_results');
	    return $posts_per_page;
	}
	
	// No site value is set, check for network value
	elseif(get_option('uppp_network_num_results')){
	    $posts_per_page = get_option('uppp_network_num_results');
	    return $posts_per_page;
	}
	
	// No value is set, use default posts per page in wordpress
	else{
	    $posts_per_page = get_option('posts_per_page');
	    return $posts_per_page;
	}
	
	// Should never reach here
	return false;
	
    }
    
    /*
     * Check if this query should be filtered by our plugin or not
     * @param $query WP_Query The query to be filtered
     */
    private function is_uppp_query($query = false){
	
	// Only alter results for specific queries
	if( is_archive() ){
	    return true;
	}	
	
	return false;
    }

}