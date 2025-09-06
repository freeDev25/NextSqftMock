<?php
/**
 * Rzpay Admin Page
 * 
 * Handles the creation and rendering of the main Rzpay admin page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Rzpay top-level admin menu
 */
function rzpay_add_admin_menu() {
    // Add top level menu
    add_menu_page(
        'Rzpay Dashboard', // Page title
        'Rzpay',           // Menu title
        'manage_options',  // Capability required
        'rzpay-dashboard', // Menu slug
        'rzpay_dashboard_page', // Function to display the page
        'dashicons-money', // Icon (you can change to another dashicon)
        30                 // Position in menu
    );
    
    // Add submenu pages
    add_submenu_page(
        'rzpay-dashboard',    // Parent slug
        'Dashboard',          // Page title
        'Dashboard',          // Menu title
        'manage_options',     // Capability required
        'rzpay-dashboard',    // Menu slug (same as parent to make it the default page)
        'rzpay_dashboard_page' // Function to display the page
    );
    
    add_submenu_page(
        'rzpay-dashboard',   // Parent slug
        'Payments',          // Page title
        'Payments',          // Menu title
        'manage_options',    // Capability required
        'rzpay-payments',    // Menu slug
        'rzpay_payments_page' // Function to display the page
    );
    
    add_submenu_page(
        'rzpay-dashboard',    // Parent slug
        'Settings',           // Page title
        'Settings',           // Menu title
        'manage_options',     // Capability required
        'rzpay-settings',     // Menu slug
        'rzpay_settings_page' // Function to display the page
    );
}
add_action('admin_menu', 'rzpay_add_admin_menu');

/**
 * Render the dashboard page
 */
function rzpay_dashboard_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get counts for various entities
    global $wpdb;
    $subscriptions_count = wp_count_posts('subscription')->publish;
    $users_table = $wpdb->prefix . 'rzpay_user_subscriptions';
    $active_subscriptions = $wpdb->get_var("SELECT COUNT(*) FROM $users_table WHERE status = 'active'");
    $orders_table = $wpdb->prefix . 'rzpay_orders';
    $total_orders = $wpdb->get_var("SELECT COUNT(*) FROM $orders_table");
    $successful_orders = $wpdb->get_var("SELECT COUNT(*) FROM $orders_table WHERE status = 'completed'");
    
    // Calculate revenue
    $revenue = $wpdb->get_var("SELECT SUM(amount) FROM $orders_table WHERE status = 'completed'");
    $revenue = $revenue ? $revenue : 0;
    
    // Get recent orders
    $recent_orders = $wpdb->get_results(
        "SELECT * FROM $orders_table ORDER BY created_at DESC LIMIT 5",
        ARRAY_A
    );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="rzpay-dashboard-wrapper">
            <!-- Stats Overview -->
            <div class="rzpay-stats-cards">
                <div class="rzpay-stat-card">
                    <div class="stat-icon subscription-icon">
                        <span class="dashicons dashicons-list-view"></span>
                    </div>
                    <div class="stat-content">
                        <h3>Subscription Plans</h3>
                        <div class="stat-number"><?php echo esc_html($subscriptions_count); ?></div>
                    </div>
                </div>
                
                <div class="rzpay-stat-card">
                    <div class="stat-icon users-icon">
                        <span class="dashicons dashicons-groups"></span>
                    </div>
                    <div class="stat-content">
                        <h3>Active Subscribers</h3>
                        <div class="stat-number"><?php echo esc_html($active_subscriptions); ?></div>
                    </div>
                </div>
                
                <div class="rzpay-stat-card">
                    <div class="stat-icon orders-icon">
                        <span class="dashicons dashicons-cart"></span>
                    </div>
                    <div class="stat-content">
                        <h3>Total Orders</h3>
                        <div class="stat-number"><?php echo esc_html($total_orders); ?></div>
                        <div class="stat-subtext"><?php echo esc_html($successful_orders); ?> successful</div>
                    </div>
                </div>
                
                <div class="rzpay-stat-card">
                    <div class="stat-icon revenue-icon">
                        <span class="dashicons dashicons-money-alt"></span>
                    </div>
                    <div class="stat-content">
                        <h3>Total Revenue</h3>
                        <div class="stat-number">₹<?php echo esc_html(number_format($revenue, 2)); ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="rzpay-recent-orders">
                <h2>Recent Orders</h2>
                <?php if (!empty($recent_orders)): ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): 
                            $user_info = get_userdata($order['user_id']);
                            $username = $user_info ? $user_info->display_name : 'Unknown';
                        ?>
                        <tr>
                            <td><?php echo esc_html($order['order_id']); ?></td>
                            <td><?php echo esc_html($username); ?></td>
                            <td>₹<?php echo esc_html(number_format($order['amount'], 2)); ?></td>
                            <td>
                                <span class="order-status status-<?php echo esc_attr(strtolower($order['status'])); ?>">
                                    <?php echo esc_html(ucfirst($order['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(rzpay_format_date($order['updated_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="view-all-link">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=rzpay-payments')); ?>">View all orders</a>
                </p>
                <?php else: ?>
                <p>No orders found.</p>
                <?php endif; ?>
            </div>
            
            <!-- Quick Actions -->
            <div class="rzpay-quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="<?php echo esc_url(admin_url('post-new.php?post_type=subscription')); ?>" class="button button-primary">
                        <span class="dashicons dashicons-plus-alt"></span> Add Subscription Plan
                    </a>
                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=subscription')); ?>" class="button button-secondary">
                        <span class="dashicons dashicons-list-view"></span> Manage Plans
                    </a>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=rzpay-settings')); ?>" class="button button-secondary">
                        <span class="dashicons dashicons-admin-settings"></span> Settings
                    </a>
                    
                    <?php 
                    // Add links to frontend pages if they are set
                    $subscription_page_id = get_option('rzpay_subscription_page', 0);
                    $subscription_details_page_id = get_option('rzpay_subscription_details_page', 0);
                    
                    if ($subscription_page_id > 0): 
                    ?>
                    <a href="<?php echo esc_url(get_permalink($subscription_page_id)); ?>" class="button button-secondary" target="_blank">
                        <span class="dashicons dashicons-visibility"></span> View Subscription Page
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($subscription_details_page_id > 0): ?>
                    <a href="<?php echo esc_url(get_permalink($subscription_details_page_id)); ?>" class="button button-secondary" target="_blank">
                        <span class="dashicons dashicons-id"></span> View Details Page
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render the payments page
 */
function rzpay_payments_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Process filter and actions
    $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
    
    // Get orders with pagination
    global $wpdb;
    $orders_table = $wpdb->prefix . 'rzpay_orders';
    
    // Prepare WHERE clause based on filter
    $where = '';
    if (!empty($status_filter)) {
        $where = $wpdb->prepare("WHERE status = %s", $status_filter);
    }
    
    // Pagination
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($current_page - 1) * $per_page;
    
    // Get orders
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $orders_table $where");
    $orders = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $orders_table $where ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $per_page, $offset
        ),
        ARRAY_A
    );
    
    // Calculate total pages
    $total_pages = ceil($total_items / $per_page);
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <!-- Filters -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get">
                    <input type="hidden" name="page" value="rzpay-payments">
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php selected($status_filter, 'pending'); ?>>Pending</option>
                        <option value="completed" <?php selected($status_filter, 'completed'); ?>>Completed</option>
                        <option value="failed" <?php selected($status_filter, 'failed'); ?>>Failed</option>
                        <option value="refunded" <?php selected($status_filter, 'refunded'); ?>>Refunded</option>
                    </select>
                    <input type="submit" class="button" value="Filter">
                </form>
            </div>
            
            <?php
            // Pagination HTML
            $page_links = paginate_links([
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'total' => $total_pages,
                'current' => $current_page
            ]);
            
            if ($page_links) {
                echo '<div class="tablenav-pages">' . $page_links . '</div>';
            }
            ?>
        </div>
        
        <!-- Orders Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Subscription</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment ID</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): 
                        $user_info = get_userdata($order['user_id']);
                        $username = $user_info ? $user_info->display_name : 'Unknown';
                        $subscription_name = get_the_title($order['subscription_id']) ?: 'Unknown Plan';
                    ?>
                    <tr>
                        <td><?php echo esc_html($order['order_id']); ?></td>
                        <td><?php echo esc_html($username); ?></td>
                        <td><?php echo esc_html($subscription_name); ?></td>
                        <td>₹<?php echo esc_html(number_format($order['amount'], 2)); ?></td>
                        <td>
                            <span class="order-status status-<?php echo esc_attr(strtolower($order['status'])); ?>">
                                <?php echo esc_html(ucfirst($order['status'])); ?>
                            </span>
                        </td>
                        <td><?php echo esc_html($order['payment_id'] ?: '—'); ?></td>
                        <td><?php echo esc_html(rzpay_format_date($order['created_at'], 'M j, Y H:i')); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Bottom Pagination -->
        <div class="tablenav bottom">
            <?php if ($page_links) echo '<div class="tablenav-pages">' . $page_links . '</div>'; ?>
        </div>
    </div>
    <?php
}

/**
 * Render the settings page
 */
function rzpay_settings_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Save settings if form submitted
    if (isset($_POST['rzpay_settings_submit']) && check_admin_referer('rzpay_settings_nonce')) {
        $razorpay_key_id = sanitize_text_field($_POST['razorpay_key_id']);
        $razorpay_key_secret = sanitize_text_field($_POST['razorpay_key_secret']);
        $currency = sanitize_text_field($_POST['currency']);
        $success_page = absint($_POST['success_page']);
        $subscription_page = absint($_POST['subscription_page']);
        $subscription_details_page = absint($_POST['subscription_details_page']);
        
        update_option('rzpay_razorpay_key_id', $razorpay_key_id);
        update_option('rzpay_razorpay_key_secret', $razorpay_key_secret);
        update_option('rzpay_currency', $currency);
        update_option('rzpay_success_page', $success_page);
        update_option('rzpay_subscription_page', $subscription_page);
        update_option('rzpay_subscription_details_page', $subscription_details_page);
        
        echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully.</p></div>';
    }
    
    // Get current settings
    $razorpay_key_id = get_option('rzpay_razorpay_key_id', '');
    $razorpay_key_secret = get_option('rzpay_razorpay_key_secret', '');
    $currency = get_option('rzpay_currency', 'INR');
    $success_page = get_option('rzpay_success_page', 0);
    $subscription_page = get_option('rzpay_subscription_page', 0);
    $subscription_details_page = get_option('rzpay_subscription_details_page', 0);
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('rzpay_settings_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="razorpay_key_id">Razorpay Key ID</label></th>
                    <td>
                        <input type="text" id="razorpay_key_id" name="razorpay_key_id" 
                            value="<?php echo esc_attr($razorpay_key_id); ?>" class="regular-text">
                        <p class="description">Enter your Razorpay Key ID</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="razorpay_key_secret">Razorpay Key Secret</label></th>
                    <td>
                        <input type="password" id="razorpay_key_secret" name="razorpay_key_secret" 
                            value="<?php echo esc_attr($razorpay_key_secret); ?>" class="regular-text">
                        <p class="description">Enter your Razorpay Key Secret</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="currency">Currency</label></th>
                    <td>
                        <select id="currency" name="currency">
                            <option value="INR" <?php selected($currency, 'INR'); ?>>Indian Rupee (₹)</option>
                            <option value="USD" <?php selected($currency, 'USD'); ?>>US Dollar ($)</option>
                            <option value="EUR" <?php selected($currency, 'EUR'); ?>>Euro (€)</option>
                            <option value="GBP" <?php selected($currency, 'GBP'); ?>>British Pound (£)</option>
                        </select>
                        <p class="description">Select the currency for payments</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="success_page">Success Page</label></th>
                    <td>
                        <?php
                        wp_dropdown_pages([
                            'name' => 'success_page',
                            'echo' => 1,
                            'show_option_none' => '— Select —',
                            'option_none_value' => '0',
                            'selected' => $success_page,
                            'id' => 'success_page'
                        ]);
                        ?>
                        <p class="description">Select the page to redirect to after successful payment</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="subscription_page">Subscription Page</label></th>
                    <td>
                        <?php
                        wp_dropdown_pages([
                            'name' => 'subscription_page',
                            'echo' => 1,
                            'show_option_none' => '— Select —',
                            'option_none_value' => '0',
                            'selected' => $subscription_page,
                            'id' => 'subscription_page'
                        ]);
                        ?>
                        <p class="description">Select the page where users can view available subscription plans</p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="rzpay_settings_submit" class="button button-primary" value="Save Settings">
            </p>
        </form>
    </div>
    <?php
}
