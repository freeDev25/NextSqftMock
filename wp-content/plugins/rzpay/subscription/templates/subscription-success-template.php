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

// Get features for this subscription
$features_table = $wpdb->prefix . 'subscription_features';
$features = $wpdb->get_results("SELECT * FROM $features_table ORDER BY feature_name ASC", ARRAY_A);
$subscription_features = [];

if ($subscription && !empty($features)) {
    $subscription_id = $subscription['subscription_id'];
    $subscription_post = get_post($subscription_id);
    
    foreach ($features as $feature) {
        $enabled_key = 'feature_enabled_' . $feature['feature_slug'];
        $limit_key = 'feature_limit_' . $feature['feature_slug'];
        $is_enabled = get_post_meta($subscription_id, $enabled_key, true);
        $limit_value = get_post_meta($subscription_id, $limit_key, true);
        
        if ($is_enabled) {
            $feature_text = esc_html($feature['feature_name']);
            if (is_numeric($limit_value) && $limit_value > 0) {
                $feature_text .= ' (' . $limit_value . ')';
            }
            $subscription_features[] = $feature_text;
        }
    }
}
?>

<div class="success-container">
    <div class="success-header">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="success-title">Subscription Activated!</h1>
        <div class="success-confetti"></div>
    </div>
    
    <?php if ($subscription): ?>
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
                    <p class="order-id">Order ID: <strong><?php echo esc_html($subscription['order_id']); ?></strong></p>
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