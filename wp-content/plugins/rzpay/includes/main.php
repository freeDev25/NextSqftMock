<?php

use Razorpay\Api\Api;

/**
 * Initiate a Razorpay Order.
 *
 * This function takes two integer parameters and returns their sum.
 *
 * @param int $a The first number to add.
 * @param int $b The second number to add.
 * @return int The sum of the two numbers.
 */
function initiate_razorpay_order($amount, $payment_for = 'default', $currency = 'INR')
{
    // Generate a unique receipt id
    $receipt_id = generate_unique_receipt_id();

    try {
        $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());
        $order = $api->order->create([
            'amount' => floatval($amount) * 100, // Amount in paise
            'currency' => strtoupper(rzpay_get_currency()),
            'receipt' => $receipt_id,
            'payment_capture' => 1
        ]);
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

        try {
            /**
             * This code will add an entry to the database.
             * The entry will be added to the custom table used by the plugin,
             * typically named 'wp_rzpay_orders' (or with your WordPress table prefix).
             * The table stores order details such as order_id, amount, currency, status, and receipt.
             * Make sure the table exists and its structure matches the data being inserted.
             */
            rzpay_create_order_entry($order, $payment_for);
            return $response;
        } catch (Exception $e) {
            error_log('Order entry creation failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()]; // Return error message
        }
    } catch (Exception $e) {
        return ['error' => $e->getMessage()]; // Return error message
    }
}

/**
 * Verify Razorpay payment signature.
 *
 * @param string $order_id The Razorpay order ID.
 * @param string $payment_id The Razorpay payment ID.
 * @param string $signature The signature to verify.
 * @return bool True if signature is valid, false otherwise.
 */
function verify_razorpay_payment($order_id, $payment_id, $signature)
{
    try {
        $attributes = [
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        ];

        $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());
        $api->utility->verifyPaymentSignature($attributes);
        return true;
    } catch (Exception $e) {
        error_log('Razorpay payment verification failed: ' . $e->getMessage());
        return false;
    }
}
