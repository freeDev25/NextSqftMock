<?php
/*
 * Template Name: User Subscription 
 * Description: Displays available subscription plans and allows user selection.
 */

$selected_plan = null;

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
    while ($query->have_posts()) {
        $query->the_post();
        $plan_id = get_the_ID();
        $plan_name = get_the_title();
        $plan_price = get_post_meta(get_the_ID(), 'price', true);
        $plan_validity = get_post_meta(get_the_ID(), 'validity_days', true);
        $plan_features = get_post_meta(get_the_ID(), 'features', true);
        if (!is_array($plan_features)) {
            $plan_features = explode("\n", $plan_features);
        }
        $plans[] = [
            'id'       => $plan_id,
            'name'     => $plan_name,
            'price'    => $plan_price,
            'validity' => $plan_validity,
            'features' => $plan_features,
        ];
    }
    wp_reset_postdata();
}
?>

<?php if ($selected_plan): ?>
    <div class='notice notice-success'>
        <p>You selected the <strong><?php echo esc_html($selected_plan); ?></strong> plan.
            <button data-id="<?php echo esc_attr($selected_plan); ?>" id="proceed_to_subscription_payment">Proceed to payment</button>
        </p>
    </div>
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
                            <ul class="subscription-plan-features">
                                <?php foreach ($plan['features'] as $feature): ?>
                                    <li><?php echo esc_html($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
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