<?php
// Register admin subpage for subscription features
add_action('admin_menu', 'rzpay_add_subscription_features_subpage');
function rzpay_add_subscription_features_subpage() {
	add_submenu_page(
		'edit.php?post_type=subscription', // Parent slug
		'Subscription Features',           // Page title
		'Features',                        // Menu title
		'manage_options',                  // Capability
		'rzpay-subscription-features',     // Menu slug
		'rzpay_subscription_features_page_callback' // Callback function
	);
}

function rzpay_subscription_features_page_callback() {
	global $wpdb;
	// Handle form submission
	if (isset($_POST['add_feature'])) {
		$feature_name = sanitize_text_field($_POST['feature_name']);
		$feature_slug = sanitize_title($_POST['feature_slug']);
		$feature_description = sanitize_textarea_field($_POST['feature_description']);
		$table_name = $wpdb->prefix . 'subscription_features';

		if ($feature_name && $feature_slug) {
			$wpdb->insert(
				$table_name,
				[
					'feature_name' => $feature_name,
					'feature_slug' => $feature_slug,
					'feature_description' => $feature_description
				]
			);
			echo '<div class="notice notice-success is-dismissible"><p>Feature added successfully!</p></div>';
		} else {
			echo '<div class="notice notice-error is-dismissible"><p>Feature name and slug are required.</p></div>';
		}
	}
	?>
	<div class="wrap">
		<h1>Manage Subscription Features</h1>
		<div class="row">
			<div class="col-md-5">
				<h2>Add Feature</h2>
				<form method="post" action="">
					<table class="form-table">
						<tr>
							<th><label for="feature_name">Feature Name</label></th>
							<td><input type="text" name="feature_name" id="feature_name" class="regular-text" required></td>
						</tr>
						<tr>
							<th><label for="feature_slug">Feature Slug</label></th>
							<td><input type="text" name="feature_slug" id="feature_slug" class="regular-text" required></td>
						</tr>
						<tr>
							<th><label for="feature_description">Description</label></th>
							<td><textarea name="feature_description" id="feature_description" class="large-text" rows="3"></textarea></td>
						</tr>
					</table>
					<p class="submit">
						<input type="submit" name="add_feature" id="add_feature" class="button button-primary" value="Add Feature">
					</p>
				</form>
			</div>
			<div class="col-md-7">
				<h2>Added Features</h2>
				<?php
				$table_name = $wpdb->prefix . 'subscription_features';
				$features = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC", ARRAY_A);
				if (!empty($features)) {
					echo '<ul class="wp-list-table widefat fixed striped table-view-list posts" style="list-style:none; padding:0;">';
					foreach ($features as $feature) {
						echo '<li class="" style="margin-bottom:20px;">';
						echo '<div class="postbox" style="padding:15px;">';
						echo '<strong>' . esc_html($feature['feature_name']) . '</strong> <span class="description">(' . esc_html($feature['feature_slug']) . ')</span>';
						if (!empty($feature['feature_description'])) {
							echo '<div class="description" style="margin-top:8px;">' . esc_html($feature['feature_description']) . '</div>';
						}
						echo '<div class="description" style="margin-top:8px; color:#888;">Created: ' . esc_html($feature['created_at']) . '</div>';
						echo '</div>';
						echo '</li>';
					}
					echo '</ul>';
				} else {
					echo '<p>No features added yet.</p>';
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
