<?php

function rzpay_enqueue_styles()
{
    // Register (optional – often you can enqueue directly)
    wp_register_style(
        'rzpay-subscription-main-style',                   // Handle
        plugin_dir_url(__FILE__) . 'assets/style.css',  // File URL
        array(),                                // Dependencies
        '1.0.0',                                // Version
        'all'                                   // Media
    );

    // Enqueue
    wp_enqueue_style('rzpay-subscription-main-style');

    // Enqueue Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css',
        array(),
        '4.6.2'
    );

    // Subscription details page styles
    wp_enqueue_style(
        'subscription-details-styles', 
        plugin_dir_url(__FILE__) . 'assets/details-style.css',
        array(),
        '1.0.0'
    );
    
    // Main frontend styles for subscription functionality
    wp_enqueue_style(
        'rzpay-frontend-styles',
        plugin_dir_url(dirname(__FILE__)) . 'assets/frontend.css',
        array(),
        '1.0.0'
    );
    
    // Font Awesome for icons
    wp_enqueue_style(
        'font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        array(),
        '5.15.4'
    );
    
    // Google Fonts - Inter font family
    wp_enqueue_style(
        'google-fonts-inter',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
}

add_action('wp_enqueue_scripts', 'rzpay_enqueue_styles');

function rzpay_enqueue_scripts()
{

    // Register (optional – often you can enqueue directly)
    wp_register_script(
        'rzpay-subscription-script',
        plugin_dir_url(__FILE__) . 'assets/subscription.handle.js',
        array('jquery', 'rzpay-script'),
        '1.0.0',
        true
    );
    wp_enqueue_script('rzpay-subscription-script');

    // Register (optional – often you can enqueue directly)
    wp_register_script(
        'rzpay-subscription-page-script',
        plugin_dir_url(__FILE__) . 'assets/subscription.page.js',
        array('jquery', 'rzpay-subscription-script', 'rzpay-script'),
        '1.0.0',
        true
    );
    wp_enqueue_script('rzpay-subscription-page-script');

    // Enqueue Bootstrap JS (with jQuery dependency)
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '4.6.2',
        true
    );

    // Localize script with nonce
    wp_localize_script('rzpay-subscription-script', 'WP_API', array(
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts', 'rzpay_enqueue_scripts');
