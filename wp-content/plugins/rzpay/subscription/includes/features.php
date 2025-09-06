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

/**
 * Get all subscription features ordered by name
 * 
 * @return array Array of features from the database
 */
function rzpay_get_all_features() {
    global $wpdb;
    $features_table = $wpdb->prefix . 'subscription_features';
    return $wpdb->get_results("SELECT * FROM $features_table ORDER BY feature_name ASC", ARRAY_A);
}

/**
 * Get features enabled for a specific subscription
 * 
 * @param int $subscription_id The subscription post ID
 * @param array $all_features Optional array of all features (to avoid duplicate queries)
 * @return array Array of enabled features with their names and limits
 */
function rzpay_get_subscription_features($subscription_id, $all_features = null) {
    if ($all_features === null) {
        $all_features = rzpay_get_all_features();
    }
    
    $subscription_features = [];
    
    if (!empty($all_features)) {
        foreach ($all_features as $feature) {
            $enabled_key = 'feature_enabled_' . $feature['feature_slug'];
            $limit_key = 'feature_limit_' . $feature['feature_slug'];
            $is_enabled = get_post_meta($subscription_id, $enabled_key, true);
            $limit_value = get_post_meta($subscription_id, $limit_key, true);
            
            if ($is_enabled) {
                $feature_text = esc_html($feature['feature_name']);
                if (is_numeric($limit_value) && $limit_value > 0) {
                    $feature_text .= ' (' . $limit_value . ')';
                }
                $subscription_features[] = $feature_text;
            }
        }
    }
    
    return $subscription_features;
}