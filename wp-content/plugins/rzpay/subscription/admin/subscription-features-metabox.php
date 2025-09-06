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
	$js_rows = [];
	if (!empty($features)) {
		foreach ($features as $feature) {
			$limit_key = 'feature_limit_' . esc_attr($feature['feature_slug']);
			$enabled_key = 'feature_enabled_' . esc_attr($feature['feature_slug']);
			$limit_value = get_post_meta($post->ID, $limit_key, true);
			$enabled_value = get_post_meta($post->ID, $enabled_key, true);
			$is_enabled = $enabled_value ? 'checked' : '';
			$is_disabled = $enabled_value ? '' : 'disabled';
			echo '<tr>';
			echo '<th><label for="' . $limit_key . '">' . esc_html($feature['feature_name']) . '</label></th>';
			echo '<td style="vertical-align:middle;">';
			echo '<label style="margin-right:15px;"><input type="checkbox" name="' . $enabled_key . '" id="' . $enabled_key . '" value="1" ' . $is_enabled . '> Enabled</label>';
			echo '<input type="number" min="0" name="' . $limit_key . '" id="' . $limit_key . '" value="' . esc_attr($limit_value) . '" class="small-text" style="margin-left:10px;" ' . $is_disabled . ' />';
			if (!empty($feature['feature_description'])) {
				echo '<p class="description">' . esc_html($feature['feature_description']) . '</p>';
			}
			echo '</td>';
			echo '</tr>';
			$js_rows[] = [ 'cb' => $enabled_key, 'input' => $limit_key ];
		}
	} else {
		echo '<tr><td colspan="2">No features found. Please add features first.</td></tr>';
	}
	echo '</table>';
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		<?php foreach ($js_rows as $row) { ?>
		(function() {
			var cb = document.getElementById('<?php echo $row['cb']; ?>');
			var input = document.getElementById('<?php echo $row['input']; ?>');
			if (cb && input) {
				cb.addEventListener('change', function() { input.disabled = !cb.checked; });
				input.disabled = !cb.checked;
			}
		})();
		<?php } ?>
	});
	</script>
	<?php
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
			$limit_key = 'feature_limit_' . esc_attr($feature['feature_slug']);
			$enabled_key = 'feature_enabled_' . esc_attr($feature['feature_slug']);
			if (isset($_POST[$limit_key])) {
				update_post_meta($post_id, $limit_key, intval($_POST[$limit_key]));
			}
			// Save enabled/disabled checkbox
			update_post_meta($post_id, $enabled_key, isset($_POST[$enabled_key]) ? 1 : 0);
		}
	}
}
