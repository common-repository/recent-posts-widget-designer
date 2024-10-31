<?php
/**
 * Plugin generic functions file
 *
 * @package Recent Posts Widget Designer
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 *  @package Recent Posts Widget Designer
 * @since 1.0
 */
function rpwd_esc_attr($data) {
    return esc_attr( $data );
}