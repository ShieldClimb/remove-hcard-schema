<?php

/**
 * Plugin Name: ShieldClimb – Remove hCard Schema
 * Plugin URI: https://shieldclimb.com/free-woocommerce-plugins/remove-hcard-schema/
 * Description: Boost WordPress SEO by removing outdated hCard microformat and optimizing schema, fixing conflicts for better search rankings and performance.
 * Version: 1.0.1
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
    $buffer = preg_replace('/<span class="author vcard">(.*?)(<\/a>)/s', '$1$2', $buffer);
    return $buffer;
}

function shieldclimb_start_output_buffering() {
    ob_start('shieldclimb_remove_author_hcard_from_output_buffer');
}

function shieldclimb_end_output_buffering() {
    ob_end_flush();
}

// Start buffering the output
add_action('template_redirect', 'shieldclimb_start_output_buffering');

// End buffering on the wp_footer action
add_action('wp_footer', 'shieldclimb_end_output_buffering', 999);

?>