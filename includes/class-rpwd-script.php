<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package Recent Posts Widget Designer
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Rpwd_Script {
	
	function __construct() {
		
		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'rpwd_front_style') );	
		
	}

	/**
	 * Function to add style at front side
	 * 
	 * @package Recent Posts Widget Designer
	 * @since 1.0.0
	 */
	function rpwd_front_style() {		
		
		// Registring and enqueing public css
		wp_register_style( 'rpwd-public-style', RPWD_URL.'assets/css/recent-post-widget-style.css', array(), RPWD_VERSION );
		wp_enqueue_style( 'rpwd-public-style' );
	}
	
}

$rpwd_Script = new Rpwd_Script();