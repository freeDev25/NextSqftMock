<?php

// Register custom post type 'subscription'
add_action('init', 'rzpay_register_subscription_post_type');

// Function to register the custom post type
function rzpay_register_subscription_post_type()
{
    $labels = [
        'name' => 'Subscriptions',
        'singular_name' => 'Subscription',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New',
        'edit_item' => 'Edit Subscription',
        'new_item' => 'New Subscription',
        'view_item' => 'View Subscription',
        'search_items' => 'Search Subscriptions',
        'not_found' => 'No subscriptions found',
        'not_found_in_trash' => 'No subscriptions found in Trash',
    ];
    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor'],
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest' => true, // Enable REST API access
    ];
    register_post_type('subscription', $args);
}

// Add meta boxes for price and validity days
add_action('add_meta_boxes', 'rzpay_add_subscription_meta_boxes');
function rzpay_add_subscription_meta_boxes()
{
    add_meta_box(
        'rzpay_subscription_meta',
        'Subscription Details',
        'rzpay_subscription_meta_callback',
        'subscription',
        'normal',
        'default'
    );
}

// Meta box callback function
function rzpay_subscription_meta_callback($post)
{
    $price = get_post_meta($post->ID, 'price', true);
    $validity_days = get_post_meta($post->ID, 'validity_days', true);
    echo '<label for="rzpay_price">Price (₹):</label> ';
    echo '<input type="number" id="rzpay_price" name="rzpay_price" value="' . esc_attr($price) . '" step="0.01" min="0" style="width:100px;" />';
    echo '<br><br>';
    echo '<label for="rzpay_validity_days">Validity (days):</label> ';
    echo '<input type="number" id="rzpay_validity_days" name="rzpay_validity_days" value="' . esc_attr($validity_days) . '" min="1" style="width:100px;" />';
}

// Save meta fields
add_action('save_post', 'rzpay_save_subscription_meta');
// Save the subscription meta fields
function rzpay_save_subscription_meta($post_id)
{
    if (isset($_POST['rzpay_price'])) {
        update_post_meta($post_id, 'price', sanitize_text_field($_POST['rzpay_price']));
    }
    if (isset($_POST['rzpay_validity_days'])) {
        update_post_meta($post_id, 'validity_days', intval($_POST['rzpay_validity_days']));
    }
}


add_filter('theme_page_templates', 'rzpay_add_plugin_template');

// Register custom page templates
function rzpay_add_plugin_template($templates)
{
    $templates['user-subscription.php'] = 'User Subscription';
    $templates['subscription-details-template.php'] = 'Subscription Details'; // Renamed template
    return $templates;
}

add_filter('template_include', 'rzpay_load_plugin_template');

// Load the plugin template for user subscriptions and details
function rzpay_load_plugin_template($template)
{
    if (is_page()) {
        $selected_template = get_page_template_slug(get_queried_object_id());
        if ($selected_template === 'user-subscription.php') {
            $plugin_template = WP_PLUGIN_DIR . '/rzpay/subscription/templates/subscription-template.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
        if ($selected_template === 'subscription-details-template.php') {
            $plugin_template = WP_PLUGIN_DIR . '/rzpay/subscription/templates/subscription-details-template.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
    }
    return $template;
}


// Add custom fields to REST API response
add_action('rest_api_init', function () {
    register_rest_field('subscription', 'meta', [
        'get_callback' => function ($object) {
            return [
                'price' => get_post_meta($object['id'], 'price', true),
                'validity_days' => get_post_meta($object['id'], 'validity_days', true),
                'features' => get_post_meta($object['id'], 'features', true),
            ];
        },
        'schema' => null,
    ]);
});


// Add custom column for active users count in subscription list view
add_filter('manage_subscription_posts_columns', 'rzpay_subscription_active_users_column');
function rzpay_subscription_active_users_column($columns) {
    $columns['active_users'] = 'Active Users';
    return $columns;
}

add_action('manage_subscription_posts_custom_column', 'rzpay_subscription_active_users_column_content', 10, 2);
function rzpay_subscription_active_users_column_content($column, $post_id) {
    if ($column === 'active_users') {
        global $wpdb;
        $table = $wpdb->prefix . 'rzpay_user_subscriptions';
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE subscription_id = %d AND status = 'active'",
            $post_id
        ));
        echo intval($count);
    }
}