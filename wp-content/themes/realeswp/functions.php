<?php

/**
 * @package WordPress
 * @subpackage Reales
 */
require_once 'admin/settings.php';
require_once 'libs/property_search.php';
require_once 'libs/search_my_properties.php';
require_once 'libs/search_fav_properties.php';
require_once 'libs/manage_favourites.php';
require_once 'libs/post_views.php';
require_once 'libs/ajax_upload.php';
require_once 'libs/plans_ajax_upload.php';
require_once 'libs/class-tgm-plugin-activation.php';
require_once 'libs/migrate_amenities.php';

define('METABOX_PREFIX', '_next_');

require_once 'batch-script/xcel-reader.php';
require_once 'metaboxes/metabox-management.php';
require_once 'contact-form/form-handler.php';
require_once 'custom/custom-functions.php';

/**
 * Register required plugins
 */
add_action('tgmpa_register', 'reales_register_required_plugins');
if (!function_exists('reales_register_required_plugins')):

    function reales_register_required_plugins()
    {
        $plugins = array(
            array(
                'name' => 'Reales WP STPT', // The plugin name.
                'slug' => 'short-tax-post', // The plugin slug (typically the folder name).
                'source' => 'http://mariusn.com/plugins/reales-wp-stpt-2-1/short-tax-post.zip', // The plugin source.
                'required' => true, // If false, the plugin is only 'recommended' instead of required.
                'version' => '2.1',
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
            ),
        );

        $config = array(
            'default_path' => '', // Default absolute path to pre-packaged plugins.
            'menu' => 'tgmpa-install-plugins', // Menu slug.
            'has_notices' => true, // Show admin notices or not.
            'dismissable' => false, // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => true, // Automatically activate plugins after installation or not.
            'message' => '', // Message to output right before the plugins table.
            'strings' => array(
                'page_title' => __('Install Required Plugins', 'realeswp'),
                'menu_title' => __('Install Plugins', 'realeswp'),
                'installing' => __('Installing Plugin: %s', 'realeswp'), // %s = plugin name.
                'oops' => __('Something went wrong with the plugin API.', 'realeswp'),
                'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'realeswp'), // %1$s = plugin name(s).
                'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'realeswp'), // %1$s = plugin name(s).
                'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'realeswp'), // %1$s = plugin name(s).
                'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'realeswp'), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'realeswp'), // %1$s = plugin name(s).
                'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'realeswp'), // %1$s = plugin name(s).
                'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'realeswp'), // %1$s = plugin name(s).
                'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'realeswp'), // %1$s = plugin name(s).
                'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'realeswp'),
                'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins', 'realeswp'),
                'return' => __('Return to Required Plugins Installer', 'realeswp'),
                'plugin_activated' => __('Plugin activated successfully.', 'realeswp'),
                'complete' => __('All plugins installed and activated successfully. %s', 'realeswp'), // %s = dashboard link.
                'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );

        tgmpa($plugins, $config);
    }

endif;

/**
 * Reales setup
 */
if (!function_exists('reales_setup')):

    function reales_setup()
    {

        load_theme_textdomain('realeswp', get_template_directory() . '/languages');

        if (function_exists('add_theme_support')) {
            add_theme_support('title-tag');
            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(1920, 1080, true);
            add_image_size('tile', 800, 600, true);
        }

        if (!isset($content_width))
            $content_width = 1140;

        load_theme_textdomain('realeswp', get_template_directory() . '/languages/');

        register_nav_menus(array(
            'primary' => __('Top primary menu', 'realeswp'),
            'leftside' => __('Left side secondary menu', 'realeswp')
        ));

        // general settings default values
        $reales_general_settings = get_option('reales_general_settings');
        if (!isset($reales_general_settings['reales_currency_symbol_field']) || (isset($reales_general_settings['reales_currency_symbol_field']) && $reales_general_settings['reales_currency_symbol_field'] == '')) {
            $reales_general_settings['reales_currency_symbol_field'] = '$';
        }
        if (!isset($reales_general_settings['reales_currency_symbol_pos_field']) || (isset($reales_general_settings['reales_currency_symbol_pos_field']) && $reales_general_settings['reales_currency_symbol_pos_field'] == '')) {
            $reales_general_settings['reales_currency_symbol_pos_field'] = 'before';
        }
        if (!isset($reales_general_settings['reales_unit_field']) || (isset($reales_general_settings['reales_unit_field']) && $reales_general_settings['reales_unit_field'] == '')) {
            $reales_general_settings['reales_unit_field'] = 'sq ft';
        }
        if (!isset($reales_general_settings['reales_max_price_field']) || (isset($reales_general_settings['reales_max_price_field']) && $reales_general_settings['reales_max_price_field'] == '')) {
            $reales_general_settings['reales_max_price_field'] = '25000000';
        }
        if (!isset($reales_general_settings['reales_max_area_field']) || (isset($reales_general_settings['reales_max_area_field']) && $reales_general_settings['reales_max_area_field'] == '')) {
            $reales_general_settings['reales_max_area_field'] = '25000';
        }
        update_option('reales_general_settings', $reales_general_settings);

        // appearance settings default values
        $reales_appearance_settings = get_option('reales_appearance_settings');
        if (!isset($reales_appearance_settings['reales_home_header_field']) || (isset($reales_appearance_settings['reales_home_header_field']) && $reales_appearance_settings['reales_home_header_field'] == '')) {
            $reales_appearance_settings['reales_home_header_field'] = 'slideshow';
        }
        if (!isset($reales_appearance_settings['reales_sidebar_field']) || (isset($reales_appearance_settings['reales_sidebar_field']) && $reales_appearance_settings['reales_sidebar_field'] == '')) {
            $reales_appearance_settings['reales_sidebar_field'] = 'right';
        }
        if (!isset($reales_appearance_settings['reales_properties_per_page_field']) || (isset($reales_appearance_settings['reales_properties_per_page_field']) && $reales_appearance_settings['reales_properties_per_page_field'] == '')) {
            $reales_appearance_settings['reales_properties_per_page_field'] = '10';
        }
        update_option('reales_appearance_settings', $reales_appearance_settings);

        // colors settings default values
        $reales_colors_settings = get_option('reales_colors_settings');
        $default_colors = array(
            'reales_main_color_field' => '#0eaaa6',
            'reales_main_color_dark_field' => '#068b85',
            'reales_app_side_bg_field' => '#213837',
            'reales_app_side_item_active_bg_field' => '#067670',
            'reales_app_side_sub_bg_field' => '#132120',
            'reales_app_side_sub_item_active_bg_field' => '#05635e',
            'reales_app_side_text_color_field' => '#adc8c7',
            'reales_app_side_sub_text_color_field' => '#96adac',
            'reales_app_top_item_active_color_field' => '#c6e4e3',
            'reales_footer_bg_field' => '#333333',
            'reales_footer_header_color_field' => '#c6e4e3',
            'reales_prop_type_badge_bg_field' => '#eab134',
            'reales_prop_featured_badge_bg_field' => '#ea3d36',
            'reales_fav_icon_color_field' => '#ea3d36',
            'reales_marker_color_field' => '#0eaaa6',
            'reales_prop_pending_label_bg_field' => '#ea3d36'
        );
        if (
            $reales_colors_settings['reales_main_color_field'] == '' &&
            $reales_colors_settings['reales_main_color_dark_field'] == '' &&
            $reales_colors_settings['reales_app_side_bg_field'] == '' &&
            $reales_colors_settings['reales_app_side_item_active_bg_field'] == '' &&
            $reales_colors_settings['reales_app_side_sub_bg_field'] == '' &&
            $reales_colors_settings['reales_app_side_sub_item_active_bg_field'] == '' &&
            $reales_colors_settings['reales_app_side_text_color_field'] == '' &&
            $reales_colors_settings['reales_app_side_sub_text_color_field'] == '' &&
            $reales_colors_settings['reales_app_top_item_active_color_field'] == '' &&
            $reales_colors_settings['reales_footer_bg_field'] == '' &&
            $reales_colors_settings['reales_footer_header_color_field'] == '' &&
            $reales_colors_settings['reales_prop_type_badge_bg_field'] == '' &&
            $reales_colors_settings['reales_prop_featured_badge_bg_field'] == '' &&
            $reales_colors_settings['reales_fav_icon_color_field'] == '' &&
            $reales_colors_settings['reales_prop_pending_label_bg_field'] == '' &&
            $reales_colors_settings['reales_marker_color_field'] == ''
        ) {
            update_option('reales_colors_settings', $default_colors);
        }
    }

endif;
add_action('after_setup_theme', 'reales_setup');

/**
 * Enqueue scripts and styles for the front end
 */
if (!function_exists('reales_scripts')):

    function reales_scripts()
    {
        global $paged;
        global $post;
        // Load stylesheets
        wp_enqueue_style('open_sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic', array(), '1.0', 'all');
        wp_enqueue_style('font_awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '1.0', 'all');
        wp_enqueue_style('simple_line_icons', get_template_directory_uri() . '/css/simple-line-icons.css', array(), '1.0', 'all');
        wp_enqueue_style('jquery_ui', get_template_directory_uri() . '/css/jquery-ui.css', array(), '1.0', 'all');
        wp_enqueue_style('file_input', get_template_directory_uri() . '/css/fileinput.min.css', array(), '1.0', 'all');
        wp_enqueue_style('bootstrap_style', get_template_directory_uri() . '/css/bootstrap.css', array(), '1.0', 'all');
        wp_enqueue_style('datepicker', get_template_directory_uri() . '/css/datepicker.css', array(), '1.0', 'all');
        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '1.3.3', 'all');
        wp_enqueue_style('owl-theme', get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), '1.3.3', 'all');
        wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', array(), '1.0', 'all');
        wp_enqueue_style('fancybox_buttons', get_template_directory_uri() . '/css/jquery.fancybox-buttons.css', array(), '1.0', 'all');
        wp_enqueue_style('reales_style', get_stylesheet_uri(), array(), '1.0', 'all');
        wp_enqueue_style('idx_style', get_template_directory_uri() . '/css/idx.css', array(), '1.0', 'all');

        // Load scripts
        wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('jquery.placeholder', get_template_directory_uri() . '/js/jquery.placeholder.js', array('jquery'), '1.0', true);
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array(), '1.0', true);
        wp_enqueue_script('jquery.touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('jquery-ui-touch', get_template_directory_uri() . '/js/jquery-ui-touch-punch.js', array('jquery'), '1.0', true);
        wp_enqueue_script('jquery.slimscroll', get_template_directory_uri() . '/js/jquery.slimscroll.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('markerclusterer', get_template_directory_uri() . '/js/markerclusterer.js', array(), '1.0', true);
        wp_enqueue_script('bootstrap-datepicker', get_template_directory_uri() . '/js/bootstrap-datepicker.js', array(), '1.0', true);
        wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', array(), '1.0', true);

        $reales_gmaps_settings = get_option('reales_gmaps_settings', '');
        $gmaps_key = isset($reales_gmaps_settings['reales_gmaps_key_field']) ? $reales_gmaps_settings['reales_gmaps_key_field'] : '';
        $gmaps_zoom = isset($reales_gmaps_settings['reales_gmaps_zoom_field']) ? $reales_gmaps_settings['reales_gmaps_zoom_field'] : '14';
        $gmaps_style = isset($reales_gmaps_settings['reales_gmaps_style_field']) ? $reales_gmaps_settings['reales_gmaps_style_field'] : '';
        wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_key . '&amp;libraries=geometry&amp;libraries=places', array('jquery'), '1.0', true);
        wp_enqueue_script('spiderfier', get_template_directory_uri() . '/js/spiderfier.js', array('gmaps'), '1.0', true);

        wp_enqueue_script('google', 'https://plus.google.com/js/client:platform.js', array(), '1.0', true);
        wp_enqueue_script('infobox', get_template_directory_uri() . '/js/infobox.js', array(), '1.0', true);
        wp_enqueue_script('jquery.fileinput', get_template_directory_uri() . '/js/fileinput.min.js', array(), '1.0', true);
        wp_enqueue_script('imagescale', get_template_directory_uri() . '/js/image-scale.min.js', array(), '1.0', true);
        wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.js', array('jquery'), '2.1.5', true);
        wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox-buttons.js', array('jquery'), '1.0', true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '1.3.3', true);
        wp_enqueue_script('numeral', get_template_directory_uri() . '/js/numeral.min.js', array(), '2.0.6', true);
        wp_enqueue_script('services', get_template_directory_uri() . '/js/services.js', array(), '1.0', true);
        wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array(), '1.0', true);

        $reales_appearance_settings = get_option('reales_appearance_settings');
        $map_marker = isset($reales_appearance_settings['reales_map_marker_field']) ? $reales_appearance_settings['reales_map_marker_field'] : 'pin';

        if (is_page_template('property-search-results-seo.php')) {
            set_the_seo_data_to_get();
        }


        $reales_general_settings = get_option('reales_general_settings');
        $search_id = isset($_GET['search_id']) ? sanitize_text_field($_GET['search_id']) : '';
        $search_keywords = isset($_GET['search_keywords']) ? sanitize_text_field($_GET['search_keywords']) : '';
        $search_country = isset($_GET['search_country']) ? sanitize_text_field($_GET['search_country']) : '';
        $search_state = isset($_GET['search_state']) ? sanitize_text_field($_GET['search_state']) : '';
        $search_city = isset($_GET['search_city']) ? stripslashes(sanitize_text_field($_GET['search_city'])) : '';
        $search_category = isset($_GET['search_category']) ? sanitize_text_field($_GET['search_category']) : '0';
        $search_type = isset($_GET['search_type']) ? sanitize_text_field($_GET['search_type']) : '0';
        $search_min_price = isset($_GET['search_min_price']) ? sanitize_text_field($_GET['search_min_price']) : '';
        $search_max_price = isset($_GET['search_max_price']) ? sanitize_text_field($_GET['search_max_price']) : '';
        $search_lat = isset($_GET['search_lat']) ? sanitize_text_field($_GET['search_lat']) : '';
        $search_lng = isset($_GET['search_lng']) ? sanitize_text_field($_GET['search_lng']) : '';
        $search_bedrooms = isset($_GET['search_bedrooms']) ? sanitize_text_field($_GET['search_bedrooms']) : '';
        $search_bathrooms = isset($_GET['search_bathrooms']) ? sanitize_text_field($_GET['search_bathrooms']) : '';
        $search_neighborhood = isset($_GET['search_neighborhood']) ? stripslashes(sanitize_text_field($_GET['search_neighborhood'])) : '';
        $search_min_area = isset($_GET['search_min_area']) ? sanitize_text_field($_GET['search_min_area']) : '';
        $search_max_area = isset($_GET['search_max_area']) ? sanitize_text_field($_GET['search_max_area']) : '';
        $featured = isset($_GET['featured']) ? sanitize_text_field($_GET['featured']) : '';
        $search_unit = isset($reales_general_settings['reales_unit_field']) ? $reales_general_settings['reales_unit_field'] : '';
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

        $reales_amenity_settings = get_option('reales_amenity_settings');
        $search_amenities = array();

        if (is_array($reales_amenity_settings) && count($reales_amenity_settings) > 0) {
            uasort($reales_amenity_settings, "reales_compare_position");
            foreach ($reales_amenity_settings as $key => $value) {
                if (isset($_GET[$key]) && esc_html($_GET[$key]) == 1) {
                    array_push($search_amenities, $key);
                }
            }
        }

        // Custom fields search
        $reales_fields_settings = get_option('reales_fields_settings');
        $search_custom_fields = array();
        if (is_array($reales_fields_settings)) {
            uasort($reales_fields_settings, "reales_compare_position");
            foreach ($reales_fields_settings as $key => $value) {
                if ($value['search'] == 'yes') {
                    $field_data = array();
                    if ($value['type'] == 'interval_field') {
                        $search_field_min = isset($_GET[$key . '_min']) ? sanitize_text_field($_GET[$key . '_min']) : '';
                        $search_field_max = isset($_GET[$key . '_max']) ? sanitize_text_field($_GET[$key . '_max']) : '';
                    } else {
                        $search_field = isset($_GET[$key]) ? sanitize_text_field($_GET[$key]) : '';
                    }
                    $comparison = $key . '_comparison';
                    $comparison_value = isset($_GET[$comparison]) ? sanitize_text_field($_GET[$comparison]) : '';
                    $field_data['name'] = $key;
                    if ($value['type'] == 'interval_field') {
                        $field_data['value'] = array($search_field_min, $search_field_max);
                    } else {
                        $field_data['value'] = $search_field;
                    }
                    $field_data['compare'] = $comparison_value;
                    $field_data['type'] = $value['type'];
                    array_push($search_custom_fields, $field_data);
                }
            }
        }

        $user = wp_get_current_user();

        $reales_colors_settings = get_option('reales_colors_settings');
        if (isset($reales_colors_settings['reales_marker_color_field']) && $reales_colors_settings['reales_marker_color_field'] != '') {
            $marker_color = $reales_colors_settings['reales_marker_color_field'];
        } else {
            $marker_color = '#0eaaa6';
        }

        $default_lat = isset($reales_gmaps_settings['reales_gmaps_lat_field']) ? $reales_gmaps_settings['reales_gmaps_lat_field'] : '';
        $default_lng = isset($reales_gmaps_settings['reales_gmaps_lng_field']) ? $reales_gmaps_settings['reales_gmaps_lng_field'] : '';

        if ($search_lat == '' && $search_lng == '') {
            $search_lat = $default_lat;
            $search_lng = $default_lng;
        }


        $reales_captcha_settings = get_option('reales_captcha_settings');
        $show_captcha = isset($reales_captcha_settings['reales_captcha_contact_field']) ? $reales_captcha_settings['reales_captcha_contact_field'] : false;
        $show_submit_captcha = isset($reales_captcha_settings['reales_captcha_submit_field']) ? $reales_captcha_settings['reales_captcha_submit_field'] : false;
        $site_key = isset($reales_captcha_settings['reales_captcha_site_key_field']) ? $reales_captcha_settings['reales_captcha_site_key_field'] : '';
        $secret_key = isset($reales_captcha_settings['reales_captcha_secret_key_field']) ? $reales_captcha_settings['reales_captcha_secret_key_field'] : '';

        if ($show_captcha && $site_key != '' && $secret_key != '') {
            $use_captcha = true;
        } else {
            $use_captcha = false;
        }

        if ($show_submit_captcha && $site_key != '' && $secret_key != '') {
            $use_submit_captcha = true;
        } else {
            $use_submit_captcha = false;
        }

        $user_logged_in = 0;
        $user_is_agent = 0;
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $user_logged_in = 1;
            if (reales_check_user_agent($current_user->ID) === true) {
                $user_is_agent = 1;
            } else {
                $user_is_agent = 0;
            }
        } else {
            $user_logged_in = 0;
        }

        $cards_design_settings = get_option('reales_prop_cards_design_settings', '');
        $card_type = isset($cards_design_settings['card_type']) ? $cards_design_settings['card_type'] : '';

        wp_localize_script(
            'services',
            'services_vars',
            array(
                'admin_url' => get_admin_url(),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'signin_redirect' => home_url(),
                'theme_url' => get_template_directory_uri(),
                'signup_loading' => __('Sending...', 'realeswp'),
                'signup_text' => __('Sign Up', 'realeswp'),
                'signin_loading' => __('Sending...', 'realeswp'),
                'signin_text' => __('Sign In', 'realeswp'),
                'forgot_loading' => __('Sending...', 'realeswp'),
                'forgot_text' => __('Get New Password', 'realeswp'),
                'reset_pass_loading' => __('Sending...', 'realeswp'),
                'reset_pass_text' => __('Reset Password', 'realeswp'),
                'fb_login_loading' => __('Sending...', 'realeswp'),
                'fb_login_text' => __('Sign In with Facebook', 'realeswp'),
                'fb_login_error' => __('Login cancelled or not fully authorized!', 'realeswp'),
                'google_signin_loading' => __('Sending...', 'realeswp'),
                'google_signin_text' => __('Sign In with Google', 'realeswp'),
                'google_signin_error' => __('Signin cancelled or not fully authorized!', 'realeswp'),
                'search_id' => $search_id,
                'search_keywords' => $search_keywords,
                'search_country' => $search_country,
                'search_state' => $search_state,
                'search_city' => $search_city,
                'search_category' => $search_category,
                'search_type' => $search_type,
                'search_min_price' => $search_min_price,
                'search_max_price' => $search_max_price,
                'search_lat' => $search_lat,
                'search_lng' => $search_lng,
                'search_bedrooms' => $search_bedrooms,
                'search_bathrooms' => $search_bathrooms,
                'search_neighborhood' => $search_neighborhood,
                'search_min_area' => $search_min_area,
                'search_max_area' => $search_max_area,
                'featured' => $featured,
                'search_unit' => $search_unit,
                'search_amenities' => $search_amenities,
                'search_custom_fields' => $search_custom_fields,
                'sort' => $sort,
                'default_lat' => $default_lat,
                'default_lng' => $default_lng,
                'zoom' => $gmaps_zoom,
                'infobox_close_btn' => __('Close', 'realeswp'),
                'infobox_view_btn' => __('View', 'realeswp'),
                'page' => $paged,
                'post_id' => $post ? $post->ID : NULL,
                'user_id' => $user->ID,
                'update_property' => __('Update Property', 'realeswp'),
                'marker_color' => $marker_color,
                'saving_property' => __('Saving Property...', 'realeswp'),
                'deleting_property' => __('Deleting Property...', 'realeswp'),
                'please_wait' => __('Please wait...', 'realeswp'),
                'featuring_property' => __('Setting Property as Featured...', 'realeswp'),
                'home_redirect' => home_url(),
                'list_redirect' => reales_get_my_properties_link(),
                'send_message' => __('Send Message', 'realeswp'),
                'sending_message' => __('Sending Message...', 'realeswp'),
                'submit' => __('Submit', 'realeswp'),
                'sending_report' => __('Sending Report...', 'realeswp'),
                'save' => __('Save', 'realeswp'),
                'saving' => __('Saving...', 'realeswp'),
                'updating_profile' => __('Updating Profile...', 'realeswp'),
                'use_captcha' => $use_captcha,
                'use_submit_captcha' => $use_submit_captcha,
                'gmaps_style' => $gmaps_style,
                'loading_searches' => __('Loading Searches List...', 'realeswp'),
                'no_searches' => __('Searches list empty.', 'realeswp'),
                'transportations_title' => __('Click to view the transportation stations', 'realeswp'),
                'supermarkets_title' => __('Click to view the supermarkets', 'realeswp'),
                'schools_title' => __('Click to view the schools', 'realeswp'),
                'libraries_title' => __('Click to view the libraries', 'realeswp'),
                'pharmacies_title' => __('Click to view the pharmacies', 'realeswp'),
                'hospitals_title' => __('Click to view the hospitals', 'realeswp'),
                'account_redirect' => reales_get_my_account_link(),
                'user_logged_in' => $user_logged_in,
                'user_is_agent' => $user_is_agent,
                'card_type' => $card_type,
                'map_marker' => $map_marker,
            )
        );

        $mv_max_price = isset($reales_general_settings['reales_max_price_field']) ? $reales_general_settings['reales_max_price_field'] : '';
        $mv_max_area = isset($reales_general_settings['reales_max_area_field']) ? $reales_general_settings['reales_max_area_field'] : '';
        $mv_currency = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
        $mv_currency_pos = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
        $mv_unit = isset($reales_general_settings['reales_unit_field']) ? $reales_general_settings['reales_unit_field'] : '';

        if (current_user_can('manage_options')) {
            $top_admin_menu = true;
        } else {
            $top_admin_menu = false;
        }

        wp_localize_script(
            'main',
            'main_vars',
            array(
                'no_city' => __('Please set location', 'realeswp'),
                'max_price' => $mv_max_price,
                'max_area' => $mv_max_area,
                'currency' => $mv_currency,
                'currency_pos' => $mv_currency_pos,
                'unit' => $mv_unit,
                'search_placeholder' => __('Search for...', 'realeswp'),
                'top_admin_menu' => $top_admin_menu,
                'idx_search_location' => __('Location', 'realeswp'),
                'idx_search_category' => __('Category', 'realeswp'),
                'idx_search_price_min' => __('Min price', 'realeswp'),
                'idx_search_price_max' => __('Max price', 'realeswp'),
                'idx_search_beds' => __('Bedrooms', 'realeswp'),
                'idx_search_baths' => __('Bathrooms', 'realeswp'),
                'idx_advanced_search' => __('Advanced Search', 'realeswp'),
                'idx_advanced_filter' => __('Show advanced search options', 'realeswp'),
                'idx_advanced_filter_hide' => __('Hide advanced search options', 'realeswp'),
            )
        );

        $max_file_size = 100 * 1000 * 1000;
        $max_files = isset($reales_general_settings['reales_max_files_field']) ? $reales_general_settings['reales_max_files_field'] : 10;
        wp_enqueue_script('ajax-upload', get_template_directory_uri() . '/js/ajax-upload.js', array('jquery', 'plupload-handlers'), '1.0', true);
        wp_localize_script(
            'ajax-upload',
            'ajax_vars',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('reales_upload'),
                'remove' => wp_create_nonce('reales_remove'),
                'number' => 1,
                'upload_enabled' => true,
                'confirmMsg' => __('Are you sure you want to delete this?', 'realeswp'),
                'plupload' => array(
                    'runtimes' => 'html5,flash,html4',
                    'browse_button' => 'aaiu-uploader',
                    'container' => 'aaiu-upload-container',
                    'file_data_name' => 'aaiu_upload_file',
                    'max_file_size' => $max_file_size . 'b',
                    'max_files' => $max_files,
                    'url' => admin_url('admin-ajax.php') . '?action=reales_upload&nonce=' . wp_create_nonce('reales_allow'),
                    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                    'filters' => array(array('title' => __('Allowed Files', 'realeswp'), 'extensions' => "jpg,jpeg,gif,png")),
                    'multipart' => true,
                    'urlstream_upload' => true
                )
            )
        );

        wp_enqueue_script('plans-ajax-upload', get_template_directory_uri() . '/js/plans-ajax-upload.js', array('jquery', 'plupload-handlers'), '1.0', true);
        wp_localize_script(
            'plans-ajax-upload',
            'ajax_vars',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('reales_upload_plans'),
                'remove' => wp_create_nonce('reales_remove_plans'),
                'number' => 1,
                'upload_enabled' => true,
                'confirmMsg' => __('Are you sure you want to delete this?', 'realeswp'),
                'plupload' => array(
                    'runtimes' => 'html5,flash,html4',
                    'browse_button' => 'aaiu-uploader-plans',
                    'container' => 'aaiu-upload-container-plans',
                    'file_data_name' => 'aaiu_upload_file_plans',
                    'max_file_size' => $max_file_size . 'b',
                    'max_files' => $max_files,
                    'url' => admin_url('admin-ajax.php') . '?action=reales_upload_plans&nonce=' . wp_create_nonce('reales_allow'),
                    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                    'filters' => array(array('title' => __('Allowed Files', 'realeswp'), 'extensions' => "jpg,jpeg,gif,png")),
                    'multipart' => true,
                    'urlstream_upload' => true
                )
            )
        );

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

endif;
add_action('wp_enqueue_scripts', 'reales_scripts');

/**
 * Disable Admin Bar for everyone but administrators
 */
if (!function_exists('reales_disable_admin_bar')):

    function reales_disable_admin_bar()
    {
        if (!current_user_can('manage_options')) {
            // for the admin page
            remove_action('admin_footer', 'wp_admin_bar_render', 1000);
            // for the front-end
            remove_action('wp_footer', 'wp_admin_bar_render', 1000);

            // css override for the admin page
            function reales_remove_admin_bar_style_backend()
            {
                echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
            }

            add_filter('admin_head', 'reales_remove_admin_bar_style_backend');

            // css override for the frontend
            function reales_remove_admin_bar_style_frontend()
            {
                echo '<style type="text/css" media="screen">
                html { margin-top: 0px !important; }
                * html body { margin-top: 0px !important; }
                </style>';
            }

            add_filter('wp_head', 'reales_remove_admin_bar_style_frontend', 99);
        } else {

            function reales_add_admin_bar_style_frontend()
            {
                echo '<style type="text/css" media="screen">
                #header { top: 32px; }
                #leftSide { top: 92px; }
                #carouselBlog + .home-header { top: 32px; }
                @media screen and (max-width: 782px) {
                    #header { top: 46px; }
                    #leftSide { top: 96px; }
                    #carouselBlog + .home-header { top: 46px; }
                }
                @media screen and (max-width: 767px) {
                    #leftSide { top: 96px; }
                    .modal-dialog { margin: 120px 20px 20px 20px; }
                }
                </style>';
            }

            add_filter('wp_head', 'reales_add_admin_bar_style_frontend', 99);
        }
    }

endif;
add_action('init', 'reales_disable_admin_bar');

/**
 * Custom colors
 */
if (!function_exists('reales_add_custom_colors')):

    function reales_add_custom_colors()
    {
        echo "<style type='text/css'>";
        require_once('libs/colors.php');
        echo "</style>";
    }

endif;
add_action('wp_head', 'reales_add_custom_colors');

/**
 * Custom css
 */
if (!function_exists('reales_add_custom_css')):

    function reales_add_custom_css()
    {
        echo "<style type='text/css'>";
        require_once('libs/custom_css.php');
        echo "</style>";
    }

endif;
add_action('wp_head', 'reales_add_custom_css');

/**
 * Add custom field to media library items
 */
if (!function_exists('reales_image_add_custom_fields')):

    function reales_image_add_custom_fields($form_fields, $post)
    {
        $value = get_post_meta($post->ID, "show-in-slideshow", true);
        if ($value) {
            $checked = "checked";
        } else {
            $checked = "";
        }


        $form_fields["show-in-slideshow"] = array(
            "label" => __("Show in Slideshow", "realeswp"),
            "input" => "html",
            "html" => "<input type='checkbox' name='attachments[{$post->ID}][show-in-slideshow]' id='attachments[{$post->ID}][show-in-slideshow]' $checked />"
        );
        return $form_fields;
    }

endif;
add_filter("attachment_fields_to_edit", "reales_image_add_custom_fields", null, 2);

/**
 * Save custom field value
 */
if (!function_exists('reales_image_save_custom_fields')):

    function reales_image_save_custom_fields($post, $attachment)
    {
        if (isset($attachment['show-in-slideshow'])) {
            update_post_meta($post['ID'], 'show-in-slideshow', $attachment['show-in-slideshow']);
        } else {
            delete_post_meta($post['ID'], 'show-in-slideshow');
        }
        return $post;
    }

endif;
add_filter("attachment_fields_to_save", "reales_image_save_custom_fields", null, 2);

/**
 * Add Show in Slideshow column in media library
 */
if (!function_exists('reales_image_attachment_columns')):

    function reales_image_attachment_columns($columns)
    {
        $columns['show-in-slideshow'] = __("Show in Slideshow", "realeswp");
        return $columns;
    }

endif;
add_filter("manage_media_columns", "reales_image_attachment_columns", null, 2);

/**
 * Add Show in Slideshow column data in media library
 */
if (!function_exists('reales_image_attachment_show_column')):

    function reales_image_attachment_show_column($name)
    {
        global $post;
        switch ($name) {
            case 'show-in-slideshow':
                $value = get_post_meta($post->ID, "show-in-slideshow", true);
                if ($value) {
                    esc_html_e("yes", "realeswp");
                } else {
                    esc_html_e("no", "realeswp");
                }
                break;
        }
    }

endif;
add_action('manage_media_custom_column', 'reales_image_attachment_show_column', null, 2);

/**
 * Get slideshow images
 */
if (!function_exists('reales_get_slideshow_images')):

    function reales_get_slideshow_images()
    {
        $media_query = new WP_Query(
            array(
                'post_type' => 'attachment',
                'post_status' => 'inherit',
                'posts_per_page' => -1,
            )
        );
        $list = array();
        foreach ($media_query->posts as $post) {
            if (get_post_meta($post->ID, "show-in-slideshow", true)) {
                $list[] = wp_get_attachment_url($post->ID);
            }
        }
        return $list;
    }

endif;
add_action('wp_loaded', 'reales_get_slideshow_images');

/**
 * Register sidebars
 */
if (!function_exists('reales_widgets_init')):

    function reales_widgets_init()
    {
        register_sidebar(array(
            'name' => __('Main Widget Area', 'realeswp'),
            'id' => 'main-widget-area',
            'description' => __('The main widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight sidebar-header">',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('IDX Homepage Search Widget Area', 'realeswp'),
            'id' => 'idx-homepage-search-widget-area',
            'description' => __('IDX homepage search form widget area', 'realeswp'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3>',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('IDX Properties Page Search Widget Area', 'realeswp'),
            'id' => 'idx-properties-search-widget-area',
            'description' => __('IDX properties page search form widget area', 'realeswp'),
            'before_widget' => '<div class="idx-filter">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="osLight sidebar-header">',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('1st Footer Widget Area', 'realeswp'),
            'id' => 'first-footer-widget-area',
            'description' => __('The first footer widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight footer-header">',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('2nd Footer Widget Area', 'realeswp'),
            'id' => 'second-footer-widget-area',
            'description' => __('The second footer widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight footer-header">',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('3rd Footer Widget Area', 'realeswp'),
            'id' => 'third-footer-widget-area',
            'description' => __('The third footer widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight footer-header">',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('4th Footer Widget Area', 'realeswp'),
            'id' => 'fourth-footer-widget-area',
            'description' => __('The fourth footer widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight footer-header">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => __('1st Map View Footer Widget Area', 'realeswp'),
            'id' => 'first-mapview-footer-widget-area',
            'description' => __('The first map view footer widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight footer-header">',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('2nd Map View Footer Widget Area', 'realeswp'),
            'id' => 'second-mapview-footer-widget-area',
            'description' => __('The second map view footer widget area', 'realeswp'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="osLight footer-header">',
            'after_title' => '</h3>'
        ));
    }

endif;
add_action('widgets_init', 'reales_widgets_init');

/**
 * Custom excerpt lenght
 */
if (!function_exists('reales_custom_excerpt_length')):

    function reales_custom_excerpt_length($length)
    {
        return 30;
    }

endif;
add_filter('excerpt_length', 'reales_custom_excerpt_length', 999);

if (!function_exists('reales_get_excerpt_by_id')):

    function reales_get_excerpt_by_id($post_id)
    {
        $the_post = get_post($post_id);
        $the_excerpt = $the_post->post_content;
        $excerpt_length = 30;
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
        $words = explode(' ', $the_excerpt, $excerpt_length + 1);

        if (count($words) > $excerpt_length) :
            array_pop($words);
            array_push($words, '...');
            $the_excerpt = implode(' ', $words);
        endif;

        wp_reset_postdata();
        wp_reset_query();

        return $the_excerpt;
    }

endif;

/**
 * Add pagination
 */
if (!function_exists('reales_pagination')):

    function reales_pagination($pages = '', $range = 2)
    {
        $showitems = ($range * 2) + 1;

        global $paged;
        if (empty($paged))
            $paged = 1;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            echo '<ul class="pagination">';
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                echo '<li><a href="' . esc_url(get_pagenum_link(1)) . '"><span class="fa fa-angle-double-left"></span></a></li>';
            if ($paged > 1 && $showitems < $pages)
                echo '<li><a href="' . esc_url(get_pagenum_link($paged - 1)) . '"><span class="fa fa-angle-left"></span></a></li>';

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                    echo ($paged == $i) ? '<li class="active"><a href="#">' . esc_html($i) . '</a></li>' : '<li><a href="' . esc_url(get_pagenum_link($i)) . '">' . esc_html($i) . '</a></li>';
                }
            }

            if ($paged < $pages && $showitems < $pages)
                echo '<li><a href="' . esc_url(get_pagenum_link($paged + 1)) . '"><span class="fa fa-angle-right"></span></a></li>';
            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                echo '<li><a href="' . esc_url(get_pagenum_link($pages)) . '"><span class="fa fa-angle-double-right"></span></a></li>';
            echo '</ul>';
        }
    }

endif;

if (!function_exists('reales_new_country_list')):

    function reales_new_country_list($selected)
    {
        $countries = array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Republic of the", "Congo, Democratic Republic of the", "Costa Rica", "Cote d Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Romania", "Russia", "Rwanda", "St. Kitts and Nevis", "St. Lucia", "St. Vincent and The Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe");
        $country_select = '<select id="new_country" name="new_country" class="form-control">';

        if ($selected == '') {
            $reales_general_settings = get_option('reales_general_settings');
            $selected = isset($reales_general_settings['reales_country_field']) ? $reales_general_settings['reales_country_field'] : '';
        }

        foreach ($countries as $country) {
            $country_select .= '<option value="' . esc_attr($country) . '"';
            if ($selected == $country) {
                $country_select .= 'selected="selected"';
            }
            $country_select .= '>' . esc_html($country) . '</option>';
        }
        $country_select .= '</select>';

        return $country_select;
    }

endif;

if (!function_exists('reales_search_country_list')):

    function reales_search_country_list($selected)
    {
        $countries = array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Republic of the", "Congo, Democratic Republic of the", "Costa Rica", "Cote d Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Romania", "Russia", "Rwanda", "St. Kitts and Nevis", "St. Lucia", "St. Vincent and The Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe");
        $country_select = '<select id="search_country" name="search_country" class="form-control">';
        $country_select .= '<option value="">' . __('All Countries', 'realeswp') . '</option>';
        if ($selected == '') {
            $reales_general_settings = get_option('reales_general_settings');
            $selected = isset($reales_general_settings['reales_country_field']) ? $reales_general_settings['reales_country_field'] : '';
        }

        foreach ($countries as $country) {
            $country_select .= '<option value="' . esc_attr($country) . '"';
            if ($selected == $country) {
                $country_select .= 'selected="selected"';
            }
            $country_select .= '>' . esc_html($country) . '</option>';
        }
        $country_select .= '</select>';

        return $country_select;
    }

endif;

if (!function_exists('reales_wp_title')) :

    function reales_wp_title($title, $sep)
    {

        global $page, $paged;

        $title .= get_bloginfo('name', 'display');

        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page() || is_archive() || is_search())) {
            $title .= " $sep $site_description";
        }

        return $title;
    }

endif;
add_filter('wp_title', 'reales_wp_title', 10, 2);

if (!function_exists('reales_sanitize_item')) :

    function reales_sanitize_item($item)
    {
        return sanitize_text_field($item);
    }

endif;

if (!function_exists('reales_sanitize_multi_array')) :

    function reales_sanitize_multi_array(&$item, $key)
    {
        $item = sanitize_text_field($item);
    }

endif;

if (!function_exists('reales_breadcrumbs')) :

    function reales_breadcrumbs()
    {
        global $post;
        if (!is_front_page()) {
            echo '<div class="page_bc">';
            echo '<a href="' . esc_url(home_url()) . '">' . '<span class="icon-home"></span>&nbsp;' . esc_html(__('Home', 'realeswp')) . '</a>';
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                echo '&nbsp;&nbsp;<span class="fa fa-angle-right"></span>&nbsp;&nbsp;' . $crumb;
            }
            echo '&nbsp;&nbsp;<span class="fa fa-angle-right"></span>&nbsp;&nbsp;';
            the_title();
            echo '</div>';
        }
    }

endif;

if (!function_exists('money_format')) :

    function money_format($format, $number)
    {
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

endif;

if (!function_exists('reales_compare_position')) :

    function reales_compare_position($a, $b)
    {
        return  doubleval($a["position"]) - doubleval($b["position"]);
    }

endif;

if (!function_exists('reales_custom_avatar')) :

    function reales_custom_avatar($avatar, $id_or_email, $size, $default, $alt)
    {
        $user = false;

        if (is_numeric($id_or_email)) {
            $id = (int) $id_or_email;
            $user = get_user_by('id', $id);
        } elseif (is_object($id_or_email)) {
            if (!empty($id_or_email->user_id)) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by('id', $id);
            }
        } else {
            $user = get_user_by('email', $id_or_email);
        }
        if ($user && is_object($user)) {
            $user_avatar = get_the_author_meta('avatar', $user->data->ID);

            if ($user_avatar) {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri() . '/images/avatar.png';
            }

            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }

        return $avatar;
    }

    add_filter('get_avatar', 'reales_custom_avatar', 10, 5);
endif;

if (!function_exists('reales_get_my_account_link')):

    function reales_get_my_account_link()
    {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user-account.php'
        ));

        if ($pages) {
            $my_account_link = get_permalink($pages[0]->ID);
        } else {
            $my_account_link = home_url();
        }

        return $my_account_link;
    }

endif;

if (!function_exists('reales_check_general_settings')):

    function reales_check_general_settings($old_value, $new_value)
    {
        $old_rating = isset($old_value['reales_agents_rating_field']) ? true : false;
        $new_rating = isset($new_value['reales_agents_rating_field']) ? true : false;

        if ($old_rating != $new_rating && $new_rating === true) {
            reales_set_agents_reviews_status('open');
        } else if ($old_rating != $new_rating && $new_rating === false) {
            reales_set_agents_reviews_status('close');
        }
    }

endif;
add_action('update_option_reales_general_settings', 'reales_check_general_settings', 10, 2);

if (!function_exists('reales_set_agents_reviews_status')):

    function reales_set_agents_reviews_status($status)
    {
        if ($status == 'close') {
            global $wpdb;
            $wpdb->query(" UPDATE $wpdb->posts SET comment_status = 'close' WHERE post_type = 'agent' ");
        } else {
            global $wpdb;
            $wpdb->query(" UPDATE $wpdb->posts SET comment_status = 'open' WHERE post_type = 'agent' ");
        }
    }

endif;

add_filter('wp_image_editors', 'change_graphic_lib');

function change_graphic_lib($array)
{
    return array('WP_Image_Editor_GD', 'WP_Image_Editor_Imagick');
}

// Add number of properties in agents list
if (!function_exists('reales_posts_column_p')):

    function reales_posts_column_p($defaults)
    {
        $defaults['post_number'] = __('Properties', 'realeswp');
        return $defaults;
    }

endif;
add_filter('manage_agent_posts_columns', 'reales_posts_column_p');

if (!function_exists('reales_posts_custom_column_p')):

    function reales_posts_custom_column_p($column_name, $id)
    {
        if ($column_name === 'post_number') {
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'property',
                'post_status' => 'publish',
            );

            $args['meta_query'] = array(
                array(
                    'key' => 'property_agent',
                    'value' => $id
                )
            );

            $my_query = new wp_query($args);
            $my_query_arr = get_object_vars($my_query);
            wp_reset_postdata();
            echo count($my_query_arr['posts']);
        }
    }

endif;
add_action('manage_agent_posts_custom_column', 'reales_posts_custom_column_p', 5, 2);

/**
 * Check if user is an agent function
 */
if (!function_exists('reales_check_user_agent')):

    function reales_check_user_agent($user_id)
    {
        $args = array(
            'post_type' => 'agent',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'agent_user',
                    'value' => $user_id,
                )
            )
        );

        $query = new WP_Query($args);

        wp_reset_postdata();
        if ($query->have_posts()) {
            wp_reset_query();
            return true;
        } else {
            return false;
        }
    }

endif;

/**
 * Get agent by user id
 */
if (!function_exists('reales_get_agent_by_userid')):

    function reales_get_agent_by_userid($user_id)
    {
        $args = array(
            'post_type' => 'agent',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'agent_user',
                    'value' => $user_id,
                )
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $agent_id = get_the_ID();
            }
            wp_reset_postdata();
            wp_reset_query();
            return $agent_id;
        } else {
            return false;
        }
    }

endif;

/**
 * Get user account link
 */
if (!function_exists('reales_get_user_account_link')):

    function reales_get_user_account_link()
    {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user-account.php'
        ));

        if ($pages) {
            $account_link = get_permalink($pages[0]->ID);
        } else {
            $account_link = home_url();
        }

        return $account_link;
    }

endif;

/**
 * Get my properties link
 */
if (!function_exists('reales_get_my_properties_link')):

    function reales_get_my_properties_link()
    {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'my-properties.php'
        ));

        if ($pages) {
            $my_properties_link = get_permalink($pages[0]->ID);
        } else {
            $my_properties_link = home_url();
        }

        return $my_properties_link;
    }

endif;

/**
 * Custom comments design
 */
if (!function_exists('reales_comment')):

    function reales_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);

        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
?>

        <<?php echo esc_html($tag); ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">


            <div class="comment-author vcard commentAvatar">
                <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>
                <div class="commentArrow bg-w"><span class="fa fa-caret-left"></span></div>
            </div>

            <?php if ('div' != $args['style']) : ?>
                <div id="div-comment-<?php comment_ID() ?>" class="comment-body commentContent bg-w">
                <?php endif; ?>

                <div class="commentName"><?php printf(__('<cite class="fn">%s</cite>', 'realeswp'), get_comment_author_link()); ?></div>

                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'realeswp'); ?></em>
                    <br />
                <?php endif; ?>

                <div class="commentBody">
                    <?php comment_text(); ?>
                </div>

                <div class="commentActions">
                    <div class="commentTime">
                        <div class="comment-meta commentmetadata">
                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                <span class="icon-clock"></span> <?php printf(__('%1$s at %2$s', 'realeswp'), get_comment_date(), get_comment_time()); ?></a>
                        </div>
                    </div>
                    <ul>
                        <li>
                            <div class="reply">
                                <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'before' => '<span class="icon-action-undo"></span> ', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                            </div>
                        </li>
                        <li>
                            <?php edit_comment_link(__('Edit', 'realeswp'), '<span class="icon-pencil"></span> ', ''); ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <?php if ('div' != $args['style']) : ?>
                </div>
            <?php endif; ?>

            <div class="clearfix"></div>
    <?php
    }

endif;

function floating_button($text = 'Links', $buttons = array())
{
    $buttons = array(
        array(
            'text' => 'Sell',
            'url' => 'https://nextsqft.com/current-leads/',
        ),
        array(
            'text' => 'Buy',
            'url' => 'https://nextsqft.com/search-results/?search_lat=&search_lng=&sort=newest&search_keywords=&search_min_price=&search_max_price=&search_category=0&search_type=9&search_bedrooms=-1&search_bathrooms=0&search_min_area=&search_max_area=&search_neighborhood=&local_location=&local_location_comparison=equal&status=&status_comparison=equal&facing=&facing_comparison=equal',
        ),
        array(
            'text' => 'Rent',
            'url' => 'https://nextsqft.com/search-results/?search_lat=&search_lng=&sort=newest&search_keywords=&search_min_price=&search_max_price=&search_category=0&search_type=8&search_bedrooms=-1&search_bathrooms=0&search_min_area=&search_max_area=&search_neighborhood=&local_location=&local_location_comparison=equal&status=&status_comparison=equal&facing=&facing_comparison=equal',
        ),
    );
    get_template_part('contact-form/floating', 'button', array(
        'buttonText' => $text,
        'buttons' => $buttons
    ));
}
