<?php
/**
 * Plugin Name: Recent Posts Widget Designer
 * Plugin URI: https://www.wponlinesupport.com/plugins/
 * Text Domain: recent-posts-widget-designer
 * Domain Path: /languages/
 * Description: Easy to add and display Recent Posts Widget with 3 Designs
 * Author: WP OnlineSupport
 * Version: 1.0.1
 * Author URI: https://www.wponlinesupport.com/
 *
 * @package WordPress
 * @author WP OnlineSupport
 */

/**
 * Basic plugin definitions
 * 
 * @package Recent Posts Widget Designer
 * @since 1.0.0
 */
if( !defined( 'RPWD_VERSION' ) ) {
    define( 'RPWD_VERSION', '1.0.1' ); // Version of plugin
}
if( !defined( 'RPWD_DIR' ) ) {
    define( 'RPWD_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( !defined( 'RPWD_URL' ) ) {
    define( 'RPWD_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( !defined( 'RPWD_POST_TYPE' ) ) {
    define( 'RPWD_POST_TYPE', 'post' ); // Plugin post type
}


add_action('plugins_loaded', 'rpwd_load_textdomain');
function rpwd_load_textdomain() {
	load_plugin_textdomain( 'recent-posts-widget-designer', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 

// Function file
require_once( RPWD_DIR . '/includes/rpwd-function.php' );

// Script Fils
require_once( RPWD_DIR . '/includes/class-rpwd-script.php' );

// Widget
require_once( RPWD_DIR . '/includes/class-rpwd-recent-posts-widget.php' );
