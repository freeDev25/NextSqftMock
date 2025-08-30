<?php

wp_enqueue_script('rzpay-checkout', 'https://checkout.razorpay.com/v2/checkout.js', [], null, true);

wp_enqueue_script('rzpay-script', plugin_dir_url(__FILE__) . 'js/script.js', ['rzpay-checkout'], null, true);

wp_add_inline_script('rzpay-script', 'var rzpayBaseUrl = "' . site_url() . '";');
