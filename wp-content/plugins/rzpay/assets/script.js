// Subscription scripts
jQuery(document).ready(function($) {
    // Initialize Bootstrap components
    if (typeof $.fn.modal !== 'undefined') {
        // Set up choose buttons
        $('.choose-btn').on('click', function() {
            const planId = $(this).data('plan');
            $('#chosenPlanId').val(planId);
            
            // Find the plan data
            let planName = '';
            let planPrice = '';
            let planValidity = '';
            let planFeaturesList = '';
            
            // Get the plan details from the parent container
            const $planContainer = $(this).closest('.subscription-plan');
            planName = $planContainer.find('.subscription-plan-title').text();
            planPrice = $planContainer.find('.subscription-plan-price strong').text();
            planValidity = $planContainer.find('.subscription-plan-validity em').text();
            
            // Get features if they exist
            const $features = $planContainer.find('.subscription-plan-features li');
            if ($features.length > 0) {
                planFeaturesList = '<ul class="list-group list-group-flush mb-3">';
                $features.each(function() {
                    planFeaturesList += '<li class="list-group-item">' + $(this).text() + '</li>';
                });
                planFeaturesList += '</ul>';
            } else {
                planFeaturesList = '<p class="text-muted">No features listed for this plan.</p>';
            }
            
            // Build the modal content
            let modalContent = `
                <div class="plan-details">
                    <h5>${planName}</h5>
                    <p class="lead">${planPrice}</p>
                    <p>${planValidity}</p>
                    <h6>Features:</h6>
                    ${planFeaturesList}
                    <div class="alert alert-info mt-3">
                        <strong>You will be charged ${planPrice} for this subscription.</strong>
                    </div>
                </div>
            `;
            
            // Update the modal and show it
            $('#planDetailsContent').html(modalContent);
            $('#confirmChooseModal').modal('show');
        });
        
        // Handle the confirm button in the modal
        $('#confirmChooseBtn').on('click', function() {
            $('#subscriptionForm').submit();
        });
    }
    
    // Handle the payment button
    $('#proceed_to_subscription_payment').on('click', function() {
        const planId = $(this).data('id');
        // Here you would typically integrate with a payment gateway
        // For now, just redirect to a payment page
        window.location.href = '/payment?plan=' + planId;
    });
});
