<?php
/*
  Template Name: Test Payment Page
 */

/**
 * @package WordPress
 * @subpackage Reales
 */

global $post;
get_header();
?>

<div id="" class="page-wrapper">
    <div class="page-content">
        <button id="payBtn">Pay ₹500</button>
        <!-- <script src="https://checkout.razorpay.com/v2/checkout.js"></script>
        <script>
            document.getElementById('payBtn').onclick = function() {
                const create_order_url = cpm_object.ajax_url + "?action=create_order";
                let orderId, signature, paymentId;
                // Create order via backend
                fetch(create_order_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'amount=100'
                    })
                    .then(response => response.json())
                    .then((repsonse) => {
                        console.log(repsonse.data);
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
                            "handler": function(response) {
                                console.log(response)
                                // response.razorpay_payment_id
                                // response.razorpay_order_id
                                // response.razorpay_signature
                                const verify_payment_url = cpm_object.ajax_url + "?action=verify_payment";
                                fetch(verify_payment_url, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: 'razorpay_payment_id=' + response.razorpay_payment_id +
                                            '&razorpay_order_id=' + response.razorpay_order_id +
                                            '&razorpay_signature=' + response.razorpay_signature
                                    })
                                    .then(res => res.text())
                                    .then(msg => alert(msg));
                            },
                            "prefill": {
                                "name": "Test User",
                                "email": "test@example.com",
                                "contact": "9999999999"
                            },
                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    });
            };
        </script> -->
    </div>
</div>

<?php get_footer(); ?>