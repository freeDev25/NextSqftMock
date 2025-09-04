<?php
/**
 * Subscription Features Table Creation
 */
function create_subscription_features_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'subscription_features';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        feature_name varchar(255) NOT NULL,
        feature_slug varchar(255) NOT NULL UNIQUE,
        feature_description text DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}