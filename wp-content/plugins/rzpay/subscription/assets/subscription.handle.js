// @ts-nocheck
/**
 * Initiates a subscription payment for the given subscription ID by calling the 'initiate-subscription-payment' API.
 *
 * @param {Object} payload - The payload containing the subscription ID, e.g. { subscription_id: number }.
 * @returns {Promise<Object>} - Resolves with the API response JSON.
 * @throws {Error} - Throws if the request fails or response is not ok.
 */

document.addEventListener('DOMContentLoaded', function () {
    const subscriptionPaymentButton = document.querySelector('#proceed_to_subscription_payment');

    if (subscriptionPaymentButton) {
        subscriptionPaymentButton.addEventListener('click', async function (event) {
            event.preventDefault();

            const subscriptionId = this.getAttribute('data-id');
            if (!subscriptionId) {
                rzpayError('Subscription ID not found.', 'Missing Information');
                return;
            }

            try {
                const result = await initiateSubscriptionPayment({ subscription_id: subscriptionId });

                load_razorpay_interface(result.data);

                console.log('Subscription payment initiated:', result);

            } catch (error) {
                rzpayError('An error occurred while processing your request. Please try again later.', 'Request Failed');
            }
        });
    }
});

// Base URL for Razorpay API
async function initiateSubscriptionPayment(payload) {
    console.log({ rzpayBaseUrl });
    var apiUrl = rzpayBaseUrl + '/wp-json/rzpay/v1/initiate-subscription-payment';
    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': WP_API.nonce
            },
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            throw new Error(`API error: ${response.status}`);
        }

        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Failed to initiate subscription payment:', error);
        throw error;
    }
}

// Load Razorpay payment interface
function load_razorpay_interface(data) {
    const orderId = data.id;
    // paymentId = data.payment_id;
    const options = {
        "key": data.key,
        "amount": data.amount,
        "currency": data.currency,
        "name": "Your Company",
        "description": "Test Transaction",
        "order_id": orderId,
        "handler": verify_razorpay_payment,
        "prefill": {
            "name": "Test User",
            "email": "test@example.com",
            "contact": "9999999999"
        },
        "theme": {
            "color": "#3399cc"
        },
        modal: {
            ondismiss: function () {
                // User closed the payment popup without completing payment
                console.log('Payment popup closed by user');
                handlePaymentError(orderId, 'Payment popup closed by user')
                // Optionally, update your backend order status to 'failed' here
            }
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function (response) {
        // Payment failed due to error
        console.log('Payment failed: ' + response.error.description);
        handlePaymentError(orderId, response.error.description);
        // Optionally, send failure info to your backend to update order status
    });
    rzp1.open();
}

// Verify the payment on the server side
function verify_razorpay_payment(data) {
    const { razorpay_payment_id, razorpay_order_id, razorpay_signature } = data;

    console.log('Verifying payment with:', data);
    if (razorpay_payment_id && razorpay_order_id && razorpay_signature) {

        const payload = {
            razorpay_payment_id,
            razorpay_order_id,
            razorpay_signature
        };

        var apiUrl = rzpayBaseUrl + '/wp-json/rzpay/v1/verify-subscription-payment';

        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': WP_API.nonce
            },
            body: JSON.stringify(payload)
        })
            .then(response => response.json())
            .then(data => {
                console.log('Payment verification response:', data);
                if (data.success) {
                    // Payment verified successfully
                    rzpaySuccess('Payment successful! Thank you for your purchase.', 'Payment Completed', function() {
                        window.location.href = data.redirect_url; // Redirect to the provided URL
                    });
                } else {
                    // Payment verification failed
                    rzpayError('Payment verification failed. Please contact support.', 'Verification Failed');
                }
            })
            .catch(error => {
                console.error('Error verifying payment:', error);
                rzpayError('An error occurred while verifying your payment. Please try again later.', 'Verification Error');
            });
    } else {
        console.error('Missing payment verification parameters.');
        rzpayError('Invalid payment details. Please try again.', 'Invalid Payment');
    }
}

// Handle payment errors and redirect to payment failed page
function handlePaymentError(orderId, reason) {
    var apiUrl = rzpayBaseUrl + '/wp-json/rzpay/v1/update-failed-payment';

    const payload = { razorpay_order_id: orderId, failure_reason: reason || 'User closed the payment popup' };

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': WP_API.nonce
        },
        body: JSON.stringify(payload)
    })
        .then(response => response.json())
        .then(data => {
            console.log('Payment error handled:', data);
            
            // Redirect to payment failed page with error information
            const failedPageUrl = rzpayBaseUrl + '/payment-failed/';
            const redirectUrl = new URL(failedPageUrl);
            
            // Add error and order ID as URL parameters
            redirectUrl.searchParams.append('error', encodeURIComponent(reason || 'Your payment could not be processed.'));
            redirectUrl.searchParams.append('order_id', orderId);
            
            // Redirect to the payment failed page
            window.location.href = redirectUrl.toString();
        })
        .catch(error => {
            console.error('Error handling payment error:', error);
            // Still redirect on error, but with generic message
            window.location.href = rzpayBaseUrl + '/payment-failed/?error=An unexpected error occurred with your payment';
        });
}

/**
 * Checks if the current user has the selected subscription.
 * @param {number|string} subscriptionId - The subscription ID to check.
 * @returns {Promise<boolean>} - Resolves to true if user has the subscription, false otherwise.
 */
async function userHasSubscription(subscriptionId) {
    if (!subscriptionId) {
        console.error('Subscription ID is required to check user subscription.');
        return false;
    }
    const apiUrl = rzpayBaseUrl + '/wp-json/rzpay/v1/check-user-subscription?subscription_id=' + subscriptionId;
    try {
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': WP_API.nonce
            }
        });

        if (!response.ok) {
            throw new Error(`API error: ${response.status}`);
        }

        const result = await response.json();

        return result;
    } catch (error) {
        console.error('Failed to check user subscription:', error);
        return false;
    }
}

//create a function to directly call the free subscription
async function chooseFreeSubscription(subscriptionId) {
    if (!subscriptionId) {
        console.error('Subscription ID is required to choose free subscription.');
        return false;
    }
    const apiUrl = rzpayBaseUrl + '/wp-json/rzpay/v1/start-free-subscription';
    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': WP_API.nonce
            },
            body: JSON.stringify({ subscription_id: subscriptionId })
        });

        if (!response.ok) {
            throw new Error(`API error: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            rzpaySuccess('You have successfully subscribed to the free plan.', 'Subscription Activated', function() {
                window.location.href = result.redirect_url; // Redirect to the provided URL
            });
        } else {
            rzpayError('Failed to subscribe to the free plan. Please try again later.', 'Subscription Failed');
        }

        return result;
    } catch (error) {
        console.error('Failed to choose free subscription:', error);
        rzpayError('An error occurred while processing your request. Please try again later.', 'Request Failed');
        return false;
    }
}
