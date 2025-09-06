<?php
// payment-api.php
use Razorpay\Api\Api;

// Register REST API routes
add_action('rest_api_init', function () {
    register_rest_route('rzpay/v1', '/create-order', [
        'methods' => 'POST',
        'callback' => 'rzpay_create_order',
        'permission_callback' => function () {
            return is_user_logged_in();
        }
    ]);
    register_rest_route('rzpay/v1', '/verify-payment', [
        'methods' => 'POST',
        'callback' => 'rzpay_verify_payment',
        'permission_callback' => function () {
            return is_user_logged_in();
        }
    ]);
});

/**
 * Create Razorpay Order via REST API.
 *
 * This endpoint receives order details (amount, currency, receipt, etc.)
 * and creates a new order using the Razorpay API. It also stores the order
 * in the plugin's custom database table for tracking and reconciliation.
 *
 * Endpoint: POST /wp-json/rzpay/v1/create-order
 * Required fields: amount, currency
 * Optional fields: receipt
 *
 * Returns: Razorpay order details (id, key, amount, currency, status, receipt)
 */
function rzpay_create_order($request)
{
    $input = json_decode($request->get_body(), true);

    if (empty($input['amount'])) {
        return new WP_REST_Response(['error' => 'Missing amount or currency'], 400);
    }

    try {
        $response = initiate_razorpay_order($input['amount']);
        return new WP_REST_Response(['data' => $response], 200);
    } catch (Exception $e) {
        return new WP_REST_Response(['error' => $e->getMessage()], 500);
    }
}

/**
 * Verify Razorpay Payment Signature.
 *
 * This function validates the authenticity of a payment by checking the signature
 * sent by Razorpay after a successful payment. It ensures that the payment details
 * have not been tampered with and are genuine. Typically, this is done by using
 * Razorpay's utility method to verify the signature using the order ID, payment ID,
 * and the signature itself.
 *
 * Usage:
 * - Called during payment verification, usually after a payment is completed.
 * - Throws an exception if the signature is invalid.
 *
 * @param array $attributes Array containing 'razorpay_order_id', 'razorpay_payment_id', and 'razorpay_signature'.
 * @throws Exception If the signature verification fails.
 */

function rzpay_verify_signature($attributes)
{
    if (
        empty($attributes['razorpay_order_id']) ||
        empty($attributes['razorpay_payment_id']) ||
        empty($attributes['razorpay_signature'])
    ) {
        throw new Exception('Missing required parameters for signature verification.');
    }

    $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());
    $api->utility->verifyPaymentSignature($attributes);
}

function rzpay_verify_payment($request)
{
    $input = json_decode($request->get_body(), true);

    if (empty($input['razorpay_order_id']) || empty($input['razorpay_payment_id']) || empty($input['razorpay_signature'])) {
        return new WP_REST_Response(['error' => 'Missing required parameters'], 400);
    }

    try {
        $attributes = [
            'razorpay_order_id' => $input['razorpay_order_id'],
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature' => $input['razorpay_signature']
        ];

        $api = new Api(rzpay_get_key_id(), rzpay_get_key_secret());
        $api->utility->verifyPaymentSignature($attributes);

        /**
         * Updates the status of an order in the database.
         *
         * This process typically involves modifying the order record to reflect the latest payment status,
         * such as 'pending', 'completed', 'failed', or 'refunded'. The update ensures that the order's
         * current state is accurately stored and can be referenced for future operations, such as
         * displaying order history, processing refunds, or generating reports.
         *
         * The implementation may include:
         * - Validating the order ID and payment status.
         * - Executing a database query to update the relevant fields.
         * - Handling potential errors during the update process.
         * - Logging the status change for auditing purposes.
         */

        rzpay_verify_order($input['razorpay_order_id'], $input['razorpay_payment_id'], 'paid');

        return new WP_REST_Response(['success' => true], 200);
    } catch (Exception $e) {
        return new WP_REST_Response(['success' => false, 'error' => $e->getMessage()], 400);
    }
}
