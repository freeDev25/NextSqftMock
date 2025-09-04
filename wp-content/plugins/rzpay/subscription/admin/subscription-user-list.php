<?php
require_once dirname(__FILE__) . '/class-subscription-user-list-table.php';

// Add custom admin subpage under Subscription post type
add_action('admin_menu', 'rzpay_add_subscription_custom_subpage');
function rzpay_add_subscription_custom_subpage() {
    add_submenu_page(
        'edit.php?post_type=subscription', // Parent slug
        'Subscription Users',        // Page title
        'Users',                 // Menu title
        'manage_options',                  // Capability
        'rzpay-subscription-custom',       // Menu slug
        'rzpay_subscription_custom_page_callback' // Callback function
    );
}

function rzpay_subscription_custom_page_callback() {
    $args = array(
        'post_type' => 'subscription',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $subscriptions = get_posts($args);
    // Set first subscription as selected by default on initial load
    if (isset($_POST['subscription_type'])) {
        $selected_subscription = intval($_POST['subscription_type']);
    } else {
        $selected_subscription = !empty($subscriptions) ? intval($subscriptions[0]->ID) : 0;
    }
?>
    <div class="wrap">
        <h1>Subscription Users</h1>
        <form method="post" action="">
            <div style="display: flex; gap: 30px; align-items: center; margin-bottom: 20px;">
            <?php if (!empty($subscriptions)) {
                foreach ($subscriptions as $sub) {
                $sub_id = esc_attr($sub->ID);
                $sub_title = esc_html($sub->post_title);
                ?>
                <label><input type="radio" name="subscription_type" value="<?php echo $sub_id; ?>" <?php checked($selected_subscription, $sub_id); ?>> <?php echo $sub_title; ?></label>
                <?php
                }
            } else { ?>
                <span>No subscriptions found.</span>
            <?php } ?>
            </div>
            <input type="submit" class="button button-primary" value="Search" />
        </form>
        <?php
        // Display users table if a subscription is selected
        if ($selected_subscription) {
            $userListTable = new Subscription_User_List_Table();
            $userListTable->subscription_id = $selected_subscription;
            $userListTable->prepare_items();
        ?>
            <h2>Users with Selected Subscription</h2>
            <form method="post">
                <?php $userListTable->display(); ?>
            </form>
        <?php } ?>
    </div>
<?php
}