<?php
// Add metabox to subscription post type for feature limits
add_action('add_meta_boxes', 'rzpay_add_subscription_features_metabox');
function rzpay_add_subscription_features_metabox() {
	add_meta_box(
		'rzpay_subscription_features',
		'Subscription Features & Limits',
		'rzpay_subscription_features_metabox_callback',
		'subscription',
		'normal',
		'default'
	);
}

function rzpay_subscription_features_metabox_callback($post) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'subscription_features';
	$features = $wpdb->get_results("SELECT * FROM $table_name ORDER BY feature_name ASC", ARRAY_A);
	echo '<table class="form-table">';
	if (!empty($features)) {
		foreach ($features as $feature) {
			$meta_key = 'feature_limit_' . esc_attr($feature['feature_slug']);
			$value = get_post_meta($post->ID, $meta_key, true);
			echo '<tr>';
			echo '<th><label for="' . $meta_key . '">' . esc_html($feature['feature_name']) . '</label></th>';
			echo '<td>';
			echo '<input type="number" min="0" name="' . $meta_key . '" id="' . $meta_key . '" value="' . esc_attr($value) . '" class="small-text" />';
			if (!empty($feature['feature_description'])) {
				echo '<p class="description">' . esc_html($feature['feature_description']) . '</p>';
			}
			echo '</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr><td colspan="2">No features found. Please add features first.</td></tr>';
	}
	echo '</table>';
}

// Save feature limits when subscription is saved
add_action('save_post', 'rzpay_save_subscription_features_limits');
function rzpay_save_subscription_features_limits($post_id) {
	if (get_post_type($post_id) !== 'subscription') return;
	global $wpdb;
	$table_name = $wpdb->prefix . 'subscription_features';
	$features = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
	if (!empty($features)) {
		foreach ($features as $feature) {
			$meta_key = 'feature_limit_' . esc_attr($feature['feature_slug']);
			if (isset($_POST[$meta_key])) {
				update_post_meta($post_id, $meta_key, intval($_POST[$meta_key]));
			}
		}
	}
}
