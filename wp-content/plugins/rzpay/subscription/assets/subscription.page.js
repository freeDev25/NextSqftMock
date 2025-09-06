// @ts-nocheck

document.addEventListener('DOMContentLoaded', function () {
    let chosenPlan = null;
    document.querySelectorAll('.choose-btn').forEach(function (btn) {
        btn.addEventListener('click', async function (e) {
            chosenPlan = btn.getAttribute('data-plan');
            // Show loading
            jQuery('#planDetailsLoading').show();
            console.log({ chosenPlan });
            if (chosenPlan) {
                const result = await userHasSubscription(chosenPlan);

                if (result !== false && result.has_active_subscription_as_same_plan) {
                    rzpayWarning('You already have an active subscription for this plan.', 'Duplicate Subscription');
                    jQuery('#planDetailsLoading').hide();
                    return;
                } else if (result !== false && result.active_subscriptions.length > 0) {
                    rzpayWarning('You already have an active subscription. Please cancel the existing subscription to choose a new plan.', 'Active Subscription');
                    jQuery('#planDetailsLoading').hide();
                    return;
                } else {

                    // Clear previous content   
                    jQuery('#planDetailsContent').hide();
                    jQuery('#planDetailsContent').html('');

                    jQuery('#confirmChooseModal').modal('show');

                    // Fetch plan details from WP REST API using post ID
                    jQuery('#confirmChooseModal').on('shown.bs.modal', function () {
                        jQuery.ajax({
                            url: rzpayBaseUrl + '/wp-json/wp/v2/subscription/' + chosenPlan,
                            method: 'GET',
                            success: function (plan) {
                                jQuery('#planDetailsLoading').hide();
                                if (plan) {
                                    let price = plan.meta && plan.meta.price ? plan.meta.price : '';
                                    let validity = plan.meta && plan.meta.validity_days ? plan.meta.validity_days : '';
                                    let features = plan.meta && plan.meta.features ? plan.meta.features : '';
                                    let featuresHtml = '';
                                    if (features) {
                                        if (Array.isArray(features)) {
                                            featuresHtml = '<ul>' + features.map(f => '<li>' + f + '</li>').join('') + '</ul>';
                                        } else {
                                            featuresHtml = '<ul>' + features.split('\n').map(f => '<li>' + f + '</li>').join('') + '</ul>';
                                        }
                                    }
                                    jQuery('#planDetailsContent').html(
                                        '<div><strong>' + plan.title.rendered + '</strong></div>' +
                                        '<div>Price: ₹' + price + '</div>' +
                                        '<div>Validity: ' + validity + ' days</div>' +
                                        featuresHtml
                                    ).show();
                                } else {
                                    jQuery('#planDetailsContent').html('<div>Plan details not found.</div>').show();
                                }
                            },
                            error: function () {
                                jQuery('#planDetailsLoading').hide();
                                jQuery('#planDetailsContent').html('<div>Error loading plan details.</div>').show();
                            }
                        });
                    });
                }
            }
        });
    });

    document.getElementById('confirmChooseBtn').addEventListener('click', function () {
        if (chosenPlan) {
            document.getElementById('chosenPlanId').value = chosenPlan;
            document.getElementById('subscriptionForm').submit();
        }
        jQuery('#confirmChooseModal').modal('hide');
    });

    document.querySelector('#subscriptionForm').addEventListener('submit', (e) => {
        e.preventDefault();
        rzpaySuccess('Form submitted with plan ID: ' + document.getElementById('chosenPlanId').value, 'Submission Complete');
        chosenPlan = null;
        jQuery('#chosenPlanId').val('');
    });
});