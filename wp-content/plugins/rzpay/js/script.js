const payBtn = document.getElementById('payBtn');
async function create_order(amount) {
    if (!amount) return false;
    const create_order_url = cpm_object.ajax_url + "?action=create_order";
    let orderId, signature, paymentId;
    // Create order via backend
    return fetch(create_order_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'amount=' + amount
    })
        .then(response => response.json())
}

function verify_payment({ razorpay_payment_id, razorpay_order_id, razorpay_signature }) {
    const verify_payment_url = cpm_object.ajax_url + "?action=verify_payment";
    return fetch(verify_payment_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'razorpay_payment_id=' + razorpay_payment_id +
            '&razorpay_order_id=' + razorpay_order_id +
            '&razorpay_signature=' + razorpay_signature
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                console.log('Payment successful!');
            } else {
                console.log('Payment verification failed. Please try again.');
            }
        })
}

function handlePaymentError(orderId) {
    // Optionally, update your backend order status to 'failed' here
    fetch(cpm_object.ajax_url + "?action=payment_failed", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'status=failed&razorpay_order_id=' + orderId
    })
        .then(response => response.text())
        .then(() => {
            rzpayError('Your payment was not completed. Please try again or contact support if the issue persists.', 'Payment Failed');
        })
}

if (payBtn) {
    payBtn.onclick = function () {
        // const create_order_url = cpm_object.ajax_url + "?action=create_order";
        let orderId, signature, paymentId;
        create_order(200)
            .then((repsonse) => {
                console.log(repsonse);
                const data = repsonse.data;
                orderId = data.id;
                // paymentId = data.payment_id;
                const options = {
                    "key": data.key,
                    "amount": data.amount,
                    "currency": data.currency,
                    "name": "Your Company",
                    "description": "Test Transaction",
                    "order_id": orderId,
                    "handler": verify_payment,
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
                            handlePaymentError(orderId)
                            // Optionally, update your backend order status to 'failed' here
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.on('payment.failed', function (response) {
                    // Payment failed due to error
                    console.log('Payment failed: ' + response.error.description);
                    handlePaymentError(orderId)
                    // Optionally, send failure info to your backend to update order status
                });
                rzp1.open();
            });
    };
}

const initiatePayment = (order, user) => {
    if (order && order.amount && order.key && order.id) {
        const orderId = order.id;

        const options = {
            "key": order.key,
            "amount": order.amount,
            "currency": order.currency,
            "name": "NextSqft",
            "description": "Subscription Payment",
            "order_id": orderId,
            "handler": verify_payment,
            "prefill": user,
            // "prefill": {
            //     "name": "Test User",
            //     "email": "",
            //     "contact": "9999999999"
            // },
            "theme": {
                "color": "#3399cc"
            },
            modal: {
                ondismiss: function () {
                    // User closed the payment popup without completing payment
                    console.log('Payment popup closed by user');
                    handlePaymentError(orderId)
                    // Optionally, update your backend order status to 'failed' here
                }
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response) {
            // Payment failed due to error
            console.log('Payment failed: ' + response.error.description);
            handlePaymentError(orderId)
            // Optionally, send failure info to your backend to update order status
        });
        rzp1.open();
    } else {
        console.error('Amount or user information is missing.');
    }
}

