<?php
// Create a new order
function rzpay_create_order_entry($order, $payment_for = 'default')
{
    $user_id = get_current_user_id();

    // Store order details in custom table
    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';
    $wpdb->insert(
        $table_name,
        [
            'user_id'       => $user_id,
            'order_id'      => $order['id'],
            'amount'        => $order['amount'] / 100, // Convert back to original amount
            'currency'      => $order['currency'],
            'status'        => $order['status'],
            'receipt'       => $order['receipt'],
            'payment_for'   => $payment_for,
            'created_at' => current_time('mysql'),
        ],
        ['%d', '%s', '%f', '%s', '%s',  '%s', '%s']
    );

    if ($wpdb->last_error) {
        $error = 'Database error: ' . $wpdb->last_error;
        // wp_send_json_error($error, 500);
        error_log($error);
        return false;
    }

    return true;
}

// Verify and update order status
function rzpay_verify_order($order_id, $payment_id, $status = 'paid')
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';

    $result = $wpdb->update(
        $table_name,
        [
            'status' => $status,
            'payment_id' => $payment_id,
            'updated_at' => current_time('mysql')
        ],
        ['order_id' => $order_id],
        ['%s', '%s', '%s'],
        ['%s']
    );

    return $result !== false;
}

// Get order details
function rzpay_get_order($order_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';

    return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE order_id = %s", $order_id),
        ARRAY_A
    );
}

function update_order_status($order_id, $new_status, $payment_id = null, $failed_reason = '')
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';

    $result = $wpdb->update(
        $table_name,
        [
            'status' => $new_status,
            'updated_at' => current_time('mysql'),
            'payment_id' => $payment_id,
            'failed_reason' => $failed_reason
        ],
        ['order_id' => $order_id],
        ['%s', '%s'],
        ['%s']
    );

    return $result !== false;
}
