<?php

add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/test', array(
        'methods' => 'GET',
        'callback' => function ($request) {
            $validity_days = get_post_meta(9, 'validity_days', true);
            $validity_days = $validity_days ? intval($validity_days) : 0;

            // Update user-subscription status to 'active' and set end date
            rzpay_update_user_subscription_status("order_RBS9rnyMbWo0XL", 'active', $validity_days);

            return rest_ensure_response(array('message' => 'Test endpoint working', 'validity_days' => $validity_days));
        },
        'permission_callback' => '__return_true',
    ));
});
