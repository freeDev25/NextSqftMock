<?php

/**
 * Plugin Name: Razorpay Integration (rzpay)
 * Description: Integrates Razorpay payment gateway with WordPress.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// filepath: /wp-content/mu-plugins/razorpay-loader.php
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__)  . '/vendor/autoload.php';
}

// Example: Add your hooks or includes here
require_once plugin_dir_path(__FILE__) . 'admin/index.php';
require_once plugin_dir_path(__FILE__) . 'includes/index.php';
require_once plugin_dir_path(__FILE__) . 'orders/index.php';
require_once plugin_dir_path(__FILE__) . 'subscription/index.php';
require_once plugin_dir_path(__FILE__) . 'load-scripts.php';
require_once plugin_dir_path(__FILE__) . 'test-api.php';

// Database table creation for orders
function rzpay_create_orders_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';
    $charset_collate = $wpdb->get_charset_collate();

    // Add payment_for field to orders table
    // Allowed values: 'subscription', 'one_time', 'default'
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        order_id VARCHAR(100) NOT NULL,
        user_id BIGINT UNSIGNED NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        currency VARCHAR(10) NOT NULL,
        receipt VARCHAR(255) DEFAULT NULL,
        status VARCHAR(50) NOT NULL,
        failed_reason TEXT DEFAULT NULL,
        payment_id VARCHAR(100) DEFAULT NULL,
        payment_for VARCHAR(20) NOT NULL DEFAULT 'default',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY order_id (order_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
// Create orders table on plugin activation
register_activation_hook(__FILE__, 'rzpay_create_orders_table');


/* Create user-subscription table on plugin activation */
register_activation_hook(__FILE__, 'rzpay_create_user_subscription_table');

/* Create rzpay_subscription_features table */
register_activation_hook(__FILE__, 'create_subscription_features_table');
