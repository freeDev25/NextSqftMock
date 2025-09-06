<?php
/**
 * Rzpay Configuration File
 * 
 * Handles Razorpay API configuration and helper functions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Razorpay Key ID from WordPress options
 * Falls back to test credentials if not set
 * 
 * @return string Razorpay Key ID
 */
function rzpay_get_key_id() {
    $key_id = get_option('rzpay_razorpay_key_id', '');
    return !empty($key_id) ? $key_id : ''; // Fallback to test key
}

/**
 * Get Razorpay Key Secret from WordPress options
 * Falls back to test credentials if not set
 * 
 * @return string Razorpay Key Secret
 */
function rzpay_get_key_secret() {
    $key_secret = get_option('rzpay_razorpay_key_secret', '');
    return !empty($key_secret) ? $key_secret : ''; // Fallback to test key
}

/**
 * Get configured currency code
 * 
 * @return string Currency code (INR, USD, etc.)
 */
function rzpay_get_currency() {
    return get_option('rzpay_currency', 'INR');
}

/**
 * Generate a unique receipt ID for Razorpay order
 * 
 * @return string Unique receipt ID
 */
function generate_unique_receipt_id() {
    return 'NXSQFT_' . uniqid() . '_' . time();
}
