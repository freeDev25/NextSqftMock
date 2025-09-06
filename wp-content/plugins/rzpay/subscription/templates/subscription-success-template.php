<?php

/**
 * Subscription Success Template
 * Displayed after successful subscription payment.
 * 
 * Scripts and styles are loaded from the parent folder's load-scripts.php file.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

// Get the user's latest active subscription
global $wpdb;
$user_id = get_current_user_id();
$table_name = $wpdb->prefix . 'rzpay_user_subscriptions';
$subscription = $wpdb->get_row(
    $wpdb->prepare(
        "SELECT * FROM $table_name WHERE user_id = %d AND status = 'active' ORDER BY created_at DESC LIMIT 1",
        $user_id
    ),
    ARRAY_A
);

// Get features for this subscription using the reusable function
$subscription_features = [];
if ($subscription) {
    $subscription_id = $subscription['subscription_id'];
    $subscription_features = rzpay_get_subscription_features($subscription_id);
}
?>

<div class="success-container"> ̰
    <?php if ($subscription): ?>
        <div class="success-header">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="success-title">Subscription Activated!</h1>
            <div class="success-confetti"></div>
        </div>
        <div class="subscription-details">
            <div class="subscription-plan-successfull">
                <h2><?php echo esc_html(get_the_title($subscription['subscription_id'])); ?></h2>

                <div class="subscription-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <span>Activated on</span>
                            <strong><?php echo esc_html(date('F j, Y', strtotime($subscription['created_at']))); ?></strong>
                        </div>
                    </div>

                    <div class="meta-item">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <span>Valid until</span>
                            <strong><?php echo esc_html(date('F j, Y', strtotime($subscription['subscription_end_date']))); ?></strong>
                        </div>
                    </div>

                    <div class="meta-item">
                        <i class="fas fa-tag"></i>
                        <div>
                            <span>Subscription Price</span>
                            <strong>₹<?php echo esc_html(get_post_meta($subscription['subscription_id'], 'price', true)); ?></strong>
                        </div>
                    </div>
                </div>

                <?php if (!empty($subscription_features)): ?>
                    <div class="features-section">
                        <h3>Features Included</h3>
                        <ul class="feature-list">
                            <?php foreach ($subscription_features as $feature): ?>
                                <li><i class="fas fa-check"></i> <?php echo $feature; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="order-details">
                    <p class="order-id">Receipt ID: <strong><?php echo esc_html($subscription['receipt_id']); ?></strong></p>
                    <p>Keep this order ID for your reference.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="no-subscription">
            <p>We couldn't find any active subscription for your account. If you believe this is an error, please contact our support team.</p>
        </div>
    <?php endif; ?>

    <div class="success-actions">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="action-button primary">
            <i class="fas fa-home"></i> Go to Homepage
        </a>
        <a href="<?php echo esc_url(home_url('/my-account')); ?>" class="action-button secondary">
            <i class="fas fa-user"></i> My Account
        </a>
    </div>
</div>

<?php get_footer(); ?>