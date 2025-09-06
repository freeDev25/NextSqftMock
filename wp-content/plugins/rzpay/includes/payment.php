<?php

use Razorpay\Api\Api;

/**
 * Helper function to create a Razorpay order
 *
 * @param float $amount The amount to be charged
 * @param string $currency The currency code (default: INR)
 * @return array|false Returns the order data on success, false on failure
 */

function rzpay_initiate_order($amount, $currency = 'INR', $user_id = null)
{

    if (!$user_id) {
        error_log('User not logged in');
        return ['error' => 'User not logged in']; // Invalid amount

    }

    if (!$amount || !is_numeric($amount) || $amount <= 0) {
        error_log('Invalid amount for Razorpay order');
        return ['error' => 'Invalid amount for Razorpay order']; // Invalid amount
    }

    try {
        // Initialize Razorpay API
        $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());

        // Generate a unique receipt id
        $receipt_id = generate_unique_receipt_id();


        // Create an order
        $orderData = [
            'amount' => $amount * 100, // Amount in paise
            'currency' => strtoupper($currency),
            'receipt' => $receipt_id,
            'payment_capture' => 1, // Auto capture payment
        ];

        $order = $api->order->create($orderData);

        // Add receipt to the returned data for convenience
        $order['receipt'] = $receipt_id;

        // Return only necessary fields
        $response = [
            'id' => $order['id'],
            'key' => rzpay_get_key_id(),
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'status' => $order['status'],
            'signature' => $order['signature'] ?? null,
            'receipt' => $receipt_id,
        ];

        rzpay_create_order_entry($order);

        // Store order details in custom table
        // global $wpdb;
        // $table_name = $wpdb->prefix . 'rzpay_orders';
        // $wpdb->insert(
        //     $table_name,
        //     [
        //         'user_id'   => $user_id,
        //         'order_id'  => $order['id'],
        //         'amount'    => $order['amount'] / 100, // Convert back to original amount
        //         'currency'  => $order['currency'],
        //         'status'    => $order['status'],
        //         'receipt'   => $$order['receipt'],
        //         'created_at' => current_time('mysql'),
        //     ],
        //     ['%d', '%s', '%f', '%s', '%s',  '%s', '%s']
        // );

        // if ($wpdb->last_error) {
        //     $error = 'Database error: ' . $wpdb->last_error;
        //     // wp_send_json_error($error, 500);
        //     error_log($error);
        //     return false;
        // }

        return $response;
    } catch (Exception $e) {
        error_log('Razorpay order creation failed: ' . $e->getMessage());
        return ['error' => $e->getMessage()]; // Return error message
    }
}

/**
 * Handle Razorpay payment creation
 *
 * This file handles the creation of a Razorpay order via AJAX.
 * It expects 'amount' and 'currency' to be sent via POST request.
 */

// want an wordpres ajax request for order creation
add_action('wp_ajax_create_order', 'create_order');
add_action('wp_ajax_nopriv_create_order', 'create_order');

function create_order()
{
    // Check if the request is valid
    if (!isset($_POST['amount'])) {
        wp_send_json_error('Invalid request parameters', 400);
        return;
    }

    $amount = sanitize_text_field($_POST['amount']);
    $currency = rzpay_get_currency();
    $user_id = get_current_user_id();

    // Initialize Razorpay API
    $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());

    try {
        // Generate a unique receipt id
        $receipt_id = generate_unique_receipt_id();
        // Create an order
        $orderData = [
            'amount' => $amount * 100, // Amount in paise
            'currency' => strtoupper($currency),
            'receipt' => $receipt_id,
            'payment_capture' => 1, // Auto capture payment
        ];

        $order = $api->order->create($orderData);

        // Store order details in custom table
        global $wpdb;
        $table_name = $wpdb->prefix . 'rzpay_orders';
        $wpdb->insert(
            $table_name,
            [
                'user_id'   => $user_id,
                'order_id'  => $order['id'],
                'amount'    => $order['amount'] / 100, // Convert back to original amount
                'currency'  => $order['currency'],
                'status'    => $order['status'],
                'receipt'   => $receipt_id,
                'created_at' => current_time('mysql'),
            ],
            ['%d', '%s', '%f', '%s', '%s',  '%s', '%s']
        );

        if ($wpdb->last_error) {
            $error = 'Database error: ' . $wpdb->last_error;
            wp_send_json_error($error, 500);
            return;
        }

        // $payment_id = $wpdb->insert_id;

        // Return only necessary fields
        $response = [
            'id' => $order['id'],
            'key' => rzpay_get_key_id(),
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'status' => $order['status'],
            'signature' => $order['signature'] ?? null,
            'receipt' => $receipt_id,
        ];

        wp_send_json_success($response);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage(), 500);
    }
}

//create a ajax for verify payment
add_action('wp_ajax_verify_payment', 'verify_payment');
add_action('wp_ajax_nopriv_verify_payment', 'verify_payment');

function verify_payment()
{
    // Check if the request is valid
    if (!isset($_POST['razorpay_payment_id']) || !isset($_POST['razorpay_order_id']) || !isset($_POST['razorpay_signature'])) {
        wp_send_json_error('Invalid request parameters', 400);
        return;
    }

    $paymentId = sanitize_text_field($_POST['razorpay_payment_id']);
    $orderId = sanitize_text_field($_POST['razorpay_order_id']);
    $signature = sanitize_text_field($_POST['razorpay_signature']);

    // Initialize Razorpay API
    $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());

    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';

    try {
        // Verify the payment signature
        $attributes = [
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature,
        ];

        $api->utility->verifyPaymentSignature($attributes);

        // Update payment status in custom table
        $wpdb->update(
            $table_name,
            [
                'status' => 'paid',
                'payment_id' => $paymentId,
                'updated_at' => current_time('mysql')
            ],
            [
                'order_id' => $orderId
            ]
        );

        wp_send_json_success('Payment verified successfully');
    } catch (Exception $e) {
        // Update payment status in custom table
        $wpdb->update(
            $table_name,
            [
                'status' => 'failed',
                'payment_id' => $paymentId,
                'updated_at' => current_time('mysql')
            ],
            [
                'order_id' => $orderId
            ]
        );
        wp_send_json_error($e->getMessage(), 500);
    }
}

add_action('wp_ajax_payment_failed', 'payment_failed');
add_action('wp_ajax_nopriv_payment_failed', 'payment_failed');

function payment_failed()
{
    if (!isset($_POST['razorpay_order_id'])) {
        wp_send_json_error('Invalid request parameters', 400);
        return;
    }

    $orderId = sanitize_text_field($_POST['razorpay_order_id']);

    global $wpdb;
    $table_name = $wpdb->prefix . 'rzpay_orders';
    $updated = $wpdb->update(
        $table_name,
        [
            'status' => 'failed',
            'updated_at' => current_time('mysql')
        ],
        [
            'order_id' => $orderId
        ]
    );

    if ($updated === false) {
        wp_send_json_error('Failed to update payment status', 500);
    } else {
        wp_send_json_success('Payment status updated to failed');
    }
}
