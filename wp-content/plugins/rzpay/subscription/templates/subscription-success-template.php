<?php

/**
 * Subscription Success Template
 * Displayed after successful subscription payment.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<div class="rzpay-subscription-success">
    <h2 class="rzpay-success-title">Subscription Successful!</h2>
    <p>Thank you for subscribing. Your payment has been received and your subscription is now active.</p>
    <p>If you have any questions, please contact support.</p>
    <a href="<?php echo esc_url(home_url()); ?>" class="rzpay-success-home-btn">Go to Homepage</a>
</div>

<?php
get_footer();
?>