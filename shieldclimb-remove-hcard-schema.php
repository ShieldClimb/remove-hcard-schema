<?php

/**
 * Plugin Name: ShieldClimb – Remove hCard Schema
 * Plugin URI: https://shieldclimb.com/free-woocommerce-plugins/remove-hcard-schema/
 * Description: Boost WordPress SEO by removing outdated hCard microformat and optimizing schema, fixing conflicts for better search rankings and performance.
 * Version: 1.0.2
 * Requires at least: 5.8
 * Tested up to: 6.8
 * Requires PHP: 7.2
 * Author: shieldclimb.com
 * Author URI: https://shieldclimb.com/about-us/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

 if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function shieldclimb_remove_author_hcard_from_output_buffer($buffer) {
    // Improved regex pattern to handle various HTML variations
    $buffer = preg_replace_callback(
        '/<(\w+)[^>]*\sclass\s*=\s*["\'][^"\']*?(?:\bauthor\b[^"\']*?\bvcard\b|\bvcard\b[^"\']*?\bauthor\b)[^"\']*?["\'][^>]*>(.*?)<\/\1>/is',
        function($matches) {
            // Return just the inner content of the matched element
            return $matches[2];
        },
        $buffer
    );
    
    return $buffer;
}

function shieldclimb_start_output_buffering() {
    // Only buffer on frontend pages
    if (!is_admin() && !wp_is_json_request() && !defined('XMLRPC_REQUEST')) {
        ob_start('shieldclimb_remove_author_hcard_from_output_buffer');
    }
}

function shieldclimb_end_output_buffering() {
    // Only flush if we started buffering
    if (ob_get_level() > 0 && !is_admin() && !wp_is_json_request() && !defined('XMLRPC_REQUEST')) {
        ob_end_flush();
    }
}

// Safer buffer handling with conditional checks
add_action('template_redirect', 'shieldclimb_start_output_buffering', 1);
add_action('wp_footer', 'shieldclimb_end_output_buffering', 999);

?>