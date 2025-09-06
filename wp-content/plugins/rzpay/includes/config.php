<?php
define('RAZORPAY_KEY_ID', 'rzp_test_y2gQnU8lPwd64Y');
define('RAZORPAY_KEY_SECRET', 'lghkPki6PVOYZtJQns3lxNyh');

// Generate a unique receipt id for Razorpay order
function generate_unique_receipt_id()
{
    return 'NXSQFT_' . uniqid() . '_' . time();
}
