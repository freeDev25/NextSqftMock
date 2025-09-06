<?php
/**
 * Rzpay Admin Scripts & Styles
 * 
 * Handles registration and enqueuing of all admin-side scripts and styles
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register and enqueue admin styles
 * Only loads on rzpay admin pages to prevent unnecessary loading
 */
function rzpay_admin_styles($hook) {
    // Only load on rzpay admin pages
    if (strpos($hook, 'rzpay') === false) {
        return;
    }
    
    wp_enqueue_style(
        'rzpay-admin-styles',
        plugin_dir_url(dirname(__FILE__)) . 'assets/admin.css',
        [],
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'rzpay_admin_styles');