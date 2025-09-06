<?php
/*
 * Template Name: User Subscription 
 * Description: Displays available subscription plans and allows user selection.
 */

$selected_plan = null;
$user_id = get_current_user_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan_id'])) {

    $selected_plan = sanitize_text_field($_POST['plan_id']);

    $plan_post = get_post($selected_plan);
    $plan_price = get_post_meta($selected_plan, 'price', true);
    $plan_slug = $plan_post ? $plan_post->post_name : '';

    if ($plan_price == '0' && $plan_slug === 'free') {
        // Code to handle free plan selection
        // For example, assign the plan to the user or show a special message

        $result = rzpay_create_draft_user_subscription([
            'subscription_id' => $selected_plan,
            'order_id' => 0
        ]);

        rzpay_update_user_subscription_status_by_id($result['id'], 'active', intval(get_post_meta($selected_plan, 'validity_days', true)));

        wp_redirect(home_url('/subscription-success'));
    }
}

get_header();

$plans = [];
$args = [
    'post_type'      => 'subscription',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
];
$query = new WP_Query($args);

if ($query->have_posts()) {
    // Get all features from the database
    global $wpdb;
    $features_table = $wpdb->prefix . 'subscription_features';
    $all_features = $wpdb->get_results("SELECT * FROM $features_table ORDER BY feature_name ASC", ARRAY_A);
    
    while ($query->have_posts()) {
        $query->the_post();
        $plan_id = get_the_ID();
        $plan_name = get_the_title();
        $plan_price = get_post_meta(get_the_ID(), 'price', true);
        $plan_validity = get_post_meta(get_the_ID(), 'validity_days', true);
        
        // Get features with limits for this subscription
        $subscription_features = [];
        if (!empty($all_features)) {
            foreach ($all_features as $feature) {
                $enabled_key = 'feature_enabled_' . $feature['feature_slug'];
                $limit_key = 'feature_limit_' . $feature['feature_slug'];
                $is_enabled = get_post_meta($plan_id, $enabled_key, true);
                $limit_value = get_post_meta($plan_id, $limit_key, true);
                
                if ($is_enabled) {
                    $feature_text = $feature['feature_name'];
                    if (is_numeric($limit_value) && $limit_value > 0) {
                        $feature_text .= ' (' . $limit_value . ')';
                    }
                    $subscription_features[] = $feature_text;
                }
            }
        }
        
        $plans[] = [
            'id'       => $plan_id,
            'name'     => $plan_name,
            'price'    => $plan_price,
            'validity' => $plan_validity,
            'features' => $subscription_features,
        ];
    }
    wp_reset_postdata();
}
?>


<?php if ($selected_plan): ?>
    <?php
    $plan_post = get_post($selected_plan);
    $plan_name = $plan_post ? $plan_post->post_title : '';
    $plan_price = get_post_meta($selected_plan, 'price', true);
    $plan_validity = get_post_meta($selected_plan, 'validity_days', true);
    
    // Get all feature limits for this subscription
    global $wpdb;
    $features_table = $wpdb->prefix . 'subscription_features';
    $features = $wpdb->get_results("SELECT * FROM $features_table ORDER BY feature_name ASC", ARRAY_A);
    $subscription_features = [];
    
    if (!empty($features)) {
        foreach ($features as $feature) {
            $enabled_key = 'feature_enabled_' . $feature['feature_slug'];
            $limit_key = 'feature_limit_' . $feature['feature_slug'];
            $is_enabled = get_post_meta($selected_plan, $enabled_key, true);
            $limit_value = get_post_meta($selected_plan, $limit_key, true);
            
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
    <?php if ($user_id): ?>
        <div class="card border-success mb-3" style="max-width: 500px; margin: 30px auto 0; height: auto; cursor: default;">
            <div class="card-header bg-success text-white">Subscription Selected</div>
            <div class="card-body">
                <h2 class="mb-2"><?php echo esc_html($plan_name); ?></h2>
                
                <div class="alert alert-info">
                    <strong>Subscription Amount:</strong> ₹<?php echo esc_html($plan_price); ?>
                    <p class="mb-0 mt-1">You will be charged ₹<?php echo esc_html($plan_price); ?> for a subscription valid for <?php echo esc_html($plan_validity); ?> days.</p>
                </div>
                
                <h3 class="card-subtitle mb-2 mt-3">Features Included:</h3>
                <?php if (!empty($subscription_features)): ?>
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($subscription_features as $feature): ?>
                            <li class="list-group-item"><?php echo $feature; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No features available for this subscription.</p>
                <?php endif; ?>
                
                <button data-id="<?php echo esc_attr($selected_plan); ?>" id="proceed_to_subscription_payment" class="btn btn-primary btn-lg w-100 mt-3">Proceed to payment</button>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" style="max-width: 500px; margin: 30px auto 0;">
            <p>Please <a href="<?php echo wp_login_url(get_permalink()); ?>">log in</a> to proceed with the subscription.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>



<?php if (!$selected_plan): ?>
    <div class="subscription-page">
        <h2 class="subscription-title">Choose Your Subscription</h2>
        <form method="post" id="subscriptionForm">
            <div class="subscription-plans">
                <?php foreach ($plans as $plan): ?>
                    <div class="subscription-plan">
                        <h3 class="subscription-plan-title"><?php echo esc_html($plan['name']); ?></h3>
                        <p class="subscription-plan-price"><strong>₹<?php echo esc_html($plan['price']); ?></strong></p>
                        <p class="subscription-plan-validity"><em>Validity: <?php echo esc_html($plan['validity']); ?> days</em></p>
                        <?php if (!empty($plan['features'])): ?>
                            <h4 class="features-title">Features Included:</h4>
                            <ul class="subscription-plan-features">
                                <?php foreach ($plan['features'] as $feature): ?>
                                    <li><?php echo esc_html($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No features available</p>
                        <?php endif; ?>
                        <button type="button" class="choose-btn" data-plan="<?php echo esc_attr($plan['id']); ?>">
                            Choose
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="plan_id" id="chosenPlanId" value="">
            <input type="hidden" name="action" value="do_subscription">
        </form>
    </div>
<?php endif; ?>
<!-- Bootstrap Modal -->
<div class="modal fade" id="confirmChooseModal" tabindex="-1" role="dialog" aria-labelledby="confirmChooseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmChooseModalLabel">Confirm Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="planDetailsModalBody">
                <!-- Plan details will be loaded here -->
                <div id="planDetailsLoading" style="display:none;">Loading...</div>
                <div id="planDetailsContent"></div>
                <div id="planDetailsConfirmText" style="margin-top:16px;">
                    Are you sure you want to choose this subscription plan?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmChooseBtn">Yes, Choose</button>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>