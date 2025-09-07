<?php
// File: subscription-api.php

// Ensure this file is being called via WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Register REST API endpoint
add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/initiate-subscription-payment', array(
        'methods'  => 'POST',
        'callback' => 'rzpay_initiate_subscription_payment',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));
});

/**
 * Initiate payment for a selected subscription ID.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function rzpay_initiate_subscription_payment(WP_REST_Request $request)
{

    $subscription_id = $request->get_param('subscription_id');
    $user_id = get_current_user_id();

    if (empty($subscription_id)) {
        return new WP_REST_Response(['error' => 'Subscription ID is required.'], 400);
    }

    if (!$subscription_id || get_post_type($subscription_id) !== 'subscription') {
        return new WP_Error('invalid_data', 'Valid subscription_id required', array('status' => 400));
    }

    $price = get_post_meta($subscription_id, 'price', true);
    if (!$price || !is_numeric($price)) {
        return new WP_Error('invalid_data', 'Price not found for subscription', array('status' => 400));
    }

    $user_subscriptions = rzpay_get_active_subscriptions_by_user($user_id);

    if (count($user_subscriptions) > 0) {
        foreach ($user_subscriptions as $sub) {
            if ($sub['subscription_id'] == $subscription_id) {
                return new WP_REST_Response([
                    'error' => 'You already have this plan as an active subscription.',
                    'user_id' => get_current_user_id(),
                    'subscriptions' => $user_subscriptions
                ], 400);
            }
        }
    }


    // Get price and validity days from post meta
    $validity_days = get_post_meta($subscription_id, 'validity_days', true);
    if (empty($validity_days)) {
        return new WP_REST_Response(['error' => 'Invalid subscription meta.'], 400);
    }

    // Prepare response body
    $subscription = [
        'subscription_id' => $subscription_id,
        'price' => floatval($price),
        'validity_days' => intval($validity_days),
    ];

    try {
        $response = initiate_razorpay_order($subscription['price'], 'subscription');
        // Create a draft user-subscription entry
        rzpay_create_draft_user_subscription([
            'subscription_id' => $subscription_id,
            'order_id' => $response['id'],
            'receipt_id' => $response['receipt']
        ]);
        return new WP_REST_Response(['data' => $response], 200);
    } catch (Exception $e) {
        return new WP_REST_Response(['error' => $e->getMessage()], 500);
    }
}

// Register REST API endpoint for payment verification
add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/verify-subscription-payment', array(
        'methods'  => 'POST',
        'callback' => 'rzpay_verify_subscription_payment',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));
});

/**
 * Verify Razorpay payment for a subscription.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function rzpay_verify_subscription_payment(WP_REST_Request $request)
{
    $razorpay_payment_id = $request->get_param('razorpay_payment_id');
    $razorpay_order_id = $request->get_param('razorpay_order_id');
    $razorpay_signature = $request->get_param('razorpay_signature');

    if (empty($razorpay_payment_id) || empty($razorpay_order_id) || empty($razorpay_signature)) {
        return new WP_REST_Response(['error' => 'Missing payment verification parameters.'], 400);
    }
    $is_valid = verify_razorpay_payment($razorpay_order_id, $razorpay_payment_id, $razorpay_signature);

    update_order_status($razorpay_order_id, $is_valid ? 'paid' : 'failed', $razorpay_payment_id);

    if (!$is_valid) {
        return new WP_REST_Response(['error' => 'Invalid payment signature.'], 400);
    }

    // On successful payment, update user-subscription status to 'active'
    $subscription = rzpay_get_subscription_by_order_id($razorpay_order_id);

    if (!$subscription) {
        return new WP_REST_Response(['error' => 'Subscription not found for the given order ID.'], 404);
    }
    // Get validity_days from subscription post meta
    $validity_days = get_post_meta($subscription['subscription_id'], 'validity_days', true);

    $validity_days = $validity_days ? intval($validity_days) : 0;

    // Update user-subscription status to 'active' and set end date
    rzpay_update_user_subscription_status($razorpay_order_id, 'active', $validity_days);

    // Get success page ID from options
    $success_page_id = get_option('rzpay_success_page', 0);
    
    // Get permalink if page ID exists, otherwise use home URL
    $redirect_url = ($success_page_id > 0) ? get_permalink($success_page_id) : home_url('/subscription-details');

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Payment verified successfully.',
        'redirect_url' => $redirect_url,
        'validity_days' => $validity_days,
        'subscription' => $subscription
    ], 200);
}

add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/update-failed-payment', array(
        'methods'  => 'POST',
        'callback' => 'rzpay_update_failed_payment',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));
});

/**
 * Update failed payment details for a subscription order.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function rzpay_update_failed_payment(WP_REST_Request $request)
{
    $razorpay_order_id = $request->get_param('razorpay_order_id');
    $failure_reason = $request->get_param('failure_reason');

    if (empty($razorpay_order_id) || empty($failure_reason)) {
        return new WP_REST_Response(['error' => 'Missing required parameters.'], 400);
    }

    // Update order status and failure reason (implement update_failed_payment_details as needed)
    $updated = update_order_status($razorpay_order_id, 'failed', null, $failure_reason);

    if (!$updated) {
        return new WP_REST_Response(['error' => 'Failed to update payment details.'], 500);
    }
    
    // Get the payment failed page URL
    $failed_page_url = home_url('payment-failed');
    
    // Include the URL in the response for frontend redirection
    return new WP_REST_Response([
        'success' => true,
        'message' => 'Payment failure recorded.',
        'redirect_url' => $failed_page_url,
        'order_id' => $razorpay_order_id
    ], 200);

    return new WP_REST_Response(['success' => true, 'message' => 'Failed payment details updated.'], 200);
}

add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/user-subscription', array(
        'methods' => 'POST',
        'callback' => 'rzpay_create_user_subscription',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));

    register_rest_route('rzpay/v1', '/user-subscription', array(
        'methods' => 'GET',
        'callback' => 'rzpay_get_user_subscriptions',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));
});

// Create a user-subscription entry
function rzpay_create_user_subscription($request)
{
    global $wpdb;
    $user_id = get_current_user_id();
    $params = $request->get_json_params();
    $subscription_id = intval($params['subscription_id'] ?? 0);
    $order_id = intval($params['order_id'] ?? 0);

    if (!$user_id || !$subscription_id || !$order_id || get_post_type($subscription_id) !== 'subscription') {
        return new WP_Error('invalid_data', 'Valid subscription_id and order_id required', array('status' => 400));
    }

    // Optionally, check if order_id exists in wp_rzpay_orders table
    $order_table = $wpdb->prefix . 'rzpay_orders';
    $order_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $order_table WHERE id = %d", $order_id));
    if (!$order_exists) {
        return new WP_Error('invalid_data', 'Order ID does not exist', array('status' => 400));
    }

    // Get validity_days from subscription post meta
    $validity_days = intval(get_post_meta($subscription_id, 'validity_days', true));
    if ($validity_days < 1) {
        return new WP_Error('invalid_data', 'Subscription validity_days not set', array('status' => 400));
    }

    $created_at = current_time('mysql');
    $subscription_end_date = date('Y-m-d H:i:s', strtotime("$created_at +$validity_days days"));

    $table = $wpdb->prefix . 'rzpay_user_subscriptions';
    $wpdb->insert($table, array(
        'user_id' => $user_id,
        'subscription_id' => $subscription_id,
        'order_id' => $order_id,
        'status' => 'active',
        'created_at' => $created_at,
        'updated_at' => null,
        'subscription_end_date' => $subscription_end_date
    ));

    return array(
        'id' => $wpdb->insert_id,
        'user_id' => $user_id,
        'subscription_id' => $subscription_id,
        'order_id' => $order_id,
        'status' => 'active',
        'subscription_end_date' => $subscription_end_date
    );
}

// Get all subscriptions for current user
function rzpay_get_user_subscriptions($request)
{
    global $wpdb;
    $user_id = get_current_user_id();
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE user_id = %d", $user_id), ARRAY_A);

    return $results;
}

add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/check-user-subscription', array(
        'methods' => 'GET',
        'callback' => 'rzpay_user_has_active_subscription',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));
});

/**
 * Check if the current user has an active subscription for a given subscription_id.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function rzpay_user_has_active_subscription($request)
{
    global $wpdb;
    $user_id = get_current_user_id();
    $subscription_id = intval($request->get_param('subscription_id'));
    $table = $wpdb->prefix . 'rzpay_user_subscriptions';
    $now = current_time('mysql');

    if (!$subscription_id) {
        return new WP_REST_Response(['error' => 'subscription_id is required'], 400);
    }

    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table WHERE user_id = %d AND status = %s AND subscription_end_date > %s",
        $user_id,
        'active',
        $now
    ), ARRAY_A);

    $has_active_subscription_same_plan = false;
    foreach ($results as $key => $sub) {
        if ($sub['subscription_id'] == $subscription_id) {
            $has_active_subscription_same_plan = true;
            break;
        }
    }

    return new WP_REST_Response([
        'active_subscriptions' => $results,
        'has_active_subscription_as_same_plan' => $has_active_subscription_same_plan
    ], 200);
}

// create an api to star the free subscription
add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/start-free-subscription', array(
        'methods' => 'POST',
        'callback' => 'rzpay_start_free_subscription',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ));
});

function rzpay_start_free_subscription($subscription_id)
{
    global $wpdb;
    $user_id = get_current_user_id();

    if (!$user_id || !$subscription_id || get_post_type($subscription_id) !== 'subscription') {
        return new WP_Error('invalid_data', 'Valid subscription_id required', array('status' => 400));
    }

    $user_subscriptions = rzpay_get_active_subscriptions_by_user($user_id);

    if (count($user_subscriptions) > 0) {
        foreach ($user_subscriptions as $sub) {
            if ($sub['subscription_id'] == $subscription_id) {
                return new WP_REST_Response([
                    'error' => 'You already have this plan as an active subscription.',
                    'user_id' => get_current_user_id()
                ], 400);
            }
        }
    }

    // Get validity_days from subscription post meta
    $validity_days = intval(get_post_meta($subscription_id, 'validity_days', true));
    if ($validity_days < 1) {
        return new WP_Error('invalid_data', 'Subscription validity_days not set', array('status' => 400));
    }

    $created_at = current_time('mysql');
    $subscription_end_date = date('Y-m-d H:i:s', strtotime("$created_at +$validity_days days"));

    $table = $wpdb->prefix . 'rzpay_user_subscriptions';
    $wpdb->insert($table, array(
        'user_id' => $user_id,
        'subscription_id' => $subscription_id,
        'order_id' => 0, // No order for free subscription
        'status' => 'active',
        'created_at' => $created_at,
        'updated_at' => null,
        'subscription_end_date' => $subscription_end_date
    ));

    return new WP_REST_Response(array(
        'id' => $wpdb->insert_id,
        'success' => true,
        'user_id' => $user_id,
        'subscription_id' => $subscription_id,
        'order_id' => 0,
        'status' => 'active',
        'subscription_end_date' => $subscription_end_date,
        'redirect_url' => ($success_page_id = get_option('rzpay_success_page', 0)) > 0 ? get_permalink($success_page_id) : home_url('/subscription-details')
    ), 200);
}
