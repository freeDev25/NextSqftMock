<?php

// Create user-subscription table on plugin activation
function rzpay_create_user_subscription_table()
{
    global $wpdb;
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        subscription_id BIGINT(20) UNSIGNED NOT NULL,
        order_id VARCHAR(100) NOT NULL,
        receipt_id VARCHAR(100) DEFAULT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'active', -- e.g., active, expired, cancelled, draft
        created_at DATETIME NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        subscription_end_date DATETIME DEFAULT NULL,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY subscription_id (subscription_id),
        KEY order_id (order_id),
        KEY receipt_id (receipt_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function rzpay_create_draft_user_subscription($request)
{
    $subscription_id = $request['subscription_id'];
    $order_id = $request['order_id'];

    global $wpdb;
    $user_id = get_current_user_id();

    try {
        $table = $wpdb->prefix . 'rzpay_user_subscriptions';
        $wpdb->insert($table, array(
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
            'order_id' => $order_id,
            'receipt_id' => isset($request['receipt_id']) ? $request['receipt_id'] : null,
            'status' => 'draft',
            'created_at' => current_time('mysql')
        ));

        return array(
            'id' => $wpdb->insert_id,
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
            'order_id' => $order_id,
            'status' => 'draft'
        );
    } catch (Exception $e) {
        error_log('Error creating user subscription: ' . $e->getMessage());
        return false;
    }
}

// Update user-subscription status by order_id
function rzpay_update_user_subscription_status($order_id, $new_status, $days_extension = 0)
{
    global $wpdb;
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';

    $updated = $wpdb->update(
        $table,
        array(
            'status' => $new_status,
            'updated_at' => current_time('mysql'),
            'subscription_end_date' => $new_status === 'active' ? date('Y-m-d H:i:s', strtotime("+" . $days_extension . " days")) : null
        ),
        array('order_id' => $order_id),
        array('%s', '%s'),
        array('%d')
    );

    return $updated !== false;
}

// Update user-subscription status by order_id
function rzpay_update_user_subscription_status_by_id($user_subscription_id, $new_status, $days_extension = 0)
{
    global $wpdb;
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';

    $updated = $wpdb->update(
        $table,
        array(
            'status' => $new_status,
            'updated_at' => current_time('mysql'),
            'subscription_end_date' => $new_status === 'active' ? date('Y-m-d H:i:s', strtotime("+" . $days_extension . " days")) : null
        ),
        array('id' => $user_subscription_id),
        array('%s', '%s', ($new_status === 'active' ? '%s' : 'NULL')),
        array('%d')
    );

    return $updated !== false;
}

// Get subscription by order_id
function rzpay_get_subscription_by_order_id($order_id)
{
    global $wpdb;
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';

    $subscription = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE order_id = %d", $order_id), ARRAY_A);
    return $subscription;
}

// Get all active subscriptions for a user
function rzpay_get_active_subscriptions_by_user($user_id)
{
    global $wpdb;
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';

    $subscriptions = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table WHERE user_id = %d AND status = 'active'",
        $user_id
    ), ARRAY_A);

    return $subscriptions;
}

// Check if user has a specific active subscription
function rzpay_user_has_subscription($user_id, $subscription_id)
{
    $subscriptions = rzpay_get_active_subscriptions_by_user($user_id);
    foreach ($subscriptions as $sub) {
        if ($sub['subscription_id'] == $subscription_id) {
            return true;
        }
    }

    return false;
}

/**
 * Get the latest active subscription for a user
 * 
 * @param int $user_id The user ID to check
 * @return array|null The subscription data or null if none found
 */
function rzpay_get_latest_active_subscription($user_id)
{
    global $wpdb;
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';
    
    $subscription = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table WHERE user_id = %d AND status = 'active' ORDER BY created_at DESC LIMIT 1",
            $user_id
        ),
        ARRAY_A
    );
    
    return $subscription;
}
