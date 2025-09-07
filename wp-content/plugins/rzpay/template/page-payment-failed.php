<?php
/**
 * Template Name: Payment Failed
 * 
 * Template for displaying payment failure information.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

// Enqueue the payment failed specific stylesheet
wp_enqueue_style(
    'rzpay-payment-failed-style',
    plugin_dir_url(dirname(__FILE__)) . 'assets/failed-style.css',
    array(),
    '1.0.0'
);

// Get error message if available
$error_message = isset($_GET['error']) ? urldecode(sanitize_text_field($_GET['error'])) : 'Your payment could not be processed.';
$order_id = isset($_GET['order_id']) ? sanitize_text_field($_GET['order_id']) : '';

// Get subscription page ID from options
$subscription_page_id = get_option('rzpay_subscription_page', 0);
$subscription_page_url = $subscription_page_id > 0 ? get_permalink($subscription_page_id) : home_url();
?>

<div class="failed-container">
    <div class="failed-header">
        <div class="failed-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h1 class="failed-title">Payment Failed</h1>
    </div>

    <div class="failed-content">
        <div class="failed-message">
            <p class="failed-text"><?php echo esc_html($error_message); ?></p>
            
            <?php if (!empty($order_id)): ?>
                <p class="order-reference">Reference ID: <strong><?php echo esc_html($order_id); ?></strong></p>
            <?php endif; ?>
            
            <div class="failure-reasons">
                <h3>Common reasons for payment failure:</h3>
                <ul>
                    <li><i class="fas fa-times-circle"></i> Insufficient funds in your account</li>
                    <li><i class="fas fa-times-circle"></i> Card transaction limit exceeded</li>
                    <li><i class="fas fa-times-circle"></i> Bank server timeout or connectivity issues</li>
                    <li><i class="fas fa-times-circle"></i> Incorrect card information</li>
                    <li><i class="fas fa-times-circle"></i> Transaction blocked by bank for security reasons</li>
                </ul>
            </div>
        </div>
        
        <div class="action-suggestions">
            <h3>What you can do now:</h3>
            <div class="suggestion-item">
                <i class="fas fa-redo"></i>
                <div>
                    <h4>Try Again</h4>
                    <p>Attempt the payment again with the same or a different payment method.</p>
                </div>
            </div>
            
            <div class="suggestion-item">
                <i class="fas fa-credit-card"></i>
                <div>
                    <h4>Check Your Card</h4>
                    <p>Ensure your card is active and has sufficient balance.</p>
                </div>
            </div>
            
            <div class="suggestion-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <h4>Contact Your Bank</h4>
                    <p>If the issue persists, check with your bank for any restrictions on your account.</p>
                </div>
            </div>
            
            <div class="suggestion-item">
                <i class="fas fa-headset"></i>
                <div>
                    <h4>Contact Support</h4>
                    <p>Need assistance? Our support team is here to help.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="failed-actions">
        <a href="<?php echo esc_url($subscription_page_url); ?>" class="action-button primary">
            <i class="fas fa-arrow-circle-right"></i> Try Again
        </a>
        <a href="<?php echo esc_url(home_url()); ?>" class="action-button secondary">
            <i class="fas fa-home"></i> Back to Home
        </a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="action-button secondary">
            <i class="fas fa-envelope"></i> Contact Support
        </a>
    </div>
</div>

<?php get_footer(); ?>
