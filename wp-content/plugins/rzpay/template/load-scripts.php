<?php
/**
 * Load scripts and styles for RZPay templates
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Enqueue scripts and styles for the frontend templates
 */
function rzpay_template_enqueue_scripts() {
    // Register Font Awesome for all template pages
    wp_enqueue_style(
        'rzpay-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        array(),
        '5.15.4'
    );

}
add_action('wp_enqueue_scripts', 'rzpay_template_enqueue_scripts');

/**
 * Register a shortcode for the payment failed content
 */
function rzpay_payment_failed_shortcode($atts) {
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
    
    // Start output buffering to capture the HTML
    ob_start();
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
    <?php
    
    // Return the buffered content
    return ob_get_clean();
}
add_shortcode('rzpay_payment_failed', 'rzpay_payment_failed_shortcode');

/**
 * Add page templates from plugin
 */
function rzpay_add_page_templates($templates) {
    $templates[plugin_dir_path(__FILE__) . 'page-payment-failed.php'] = 'Payment Failed';
    return $templates;
}
add_filter('theme_page_templates', 'rzpay_add_page_templates');

/**
 * Redirect to the payment failed template
 * @param string $template
 * @return string
 */
function rzpay_redirect_page_template($template) {
    if (is_page_template('page-payment-failed.php')) {
        $template = plugin_dir_path(__FILE__) . 'page-payment-failed.php';
    }
    return $template;
}
add_filter('template_include', 'rzpay_redirect_page_template');

/**
 * Create the payment failed page on plugin activation
 */
function rzpay_create_payment_failed_page() {
    // Check if the page already exists
    $page = get_page_by_path('payment-failed');
    
    if (!$page) {
        // Create the page
        $page_id = wp_insert_post([
            'post_title'    => 'Payment Failed',
            'post_content'  => '[rzpay_payment_failed]', // We'll use a shortcode
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'payment-failed',
            'page_template' => 'page-payment-failed.php'
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            // Save the page ID for later use
            update_option('rzpay_payment_failed_page_id', $page_id);
            
            // Set the template
            update_post_meta($page_id, '_wp_page_template', 'page-payment-failed.php');
        }
    }
}
// Register the function to be called on plugin activation
add_action('init', 'rzpay_create_payment_failed_page');
