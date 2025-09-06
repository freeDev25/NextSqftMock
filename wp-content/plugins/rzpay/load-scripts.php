<?php
/**
 * Rzpay Scripts & Styles
 * 
 * Handles registration and enqueuing of all general scripts and styles
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue main Rzpay styles
 */
function rzpay_main_styles() {
    // Enqueue Font Awesome if not already enqueued
    if (!wp_style_is('font-awesome', 'enqueued')) {
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
            [],
            '5.15.4'
        );
    }
    
    // Enqueue modal CSS
    wp_enqueue_style(
        'rzpay-modal-styles',
        plugin_dir_url(__FILE__) . 'assets/modal.css',
        [],
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'rzpay_main_styles');

/**
 * Enqueue main Rzpay scripts
 */
function rzpay_main_scripts() {
    // Enqueue Razorpay checkout script
    wp_enqueue_script('rzpay-checkout', 'https://checkout.razorpay.com/v2/checkout.js', [], null, true);
    
    // Enqueue custom modal script
    wp_enqueue_script('rzpay-modal', plugin_dir_url(__FILE__) . 'assets/modal.js', [], '1.0.0', true);
    
    // Enqueue main script
    wp_enqueue_script('rzpay-script', plugin_dir_url(__FILE__) . 'js/script.js', ['rzpay-checkout', 'rzpay-modal'], null, true);
    
    // Add base URL as inline script
    wp_add_inline_script('rzpay-script', 'var rzpayBaseUrl = "' . site_url() . '";');
}
add_action('wp_enqueue_scripts', 'rzpay_main_scripts');
