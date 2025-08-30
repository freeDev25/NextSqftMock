<?php

function _die($data)
{
    _p($data);
    die();
}

function _p($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// add_action('init', 'add_custom_shortcodes');

// function add_custom_shortcodes() {
add_shortcode('RelatedSearch', 'related_search_function');
// }

function related_search_function($atts, $content = "")
{
    return '<div class="related-search">' . $content . '</div>';
}

function create_page($title_of_the_page, $content, $parent_id = NULL)
{
    $objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
    if (!empty($objPage)) {
        // echo "Page already exists:" . $title_of_the_page . "<br/>";
        wp_update_post(array(
            'ID' => $objPage->ID,
            'comment_status' => 'open',
        ));
        return $objPage->ID;
    }

    $page_id = wp_insert_post(
        array(
            'comment_status' => 'close',
            'ping_status' => 'close',
            'post_author' => get_current_user_id(),
            'post_title' => ucwords($title_of_the_page),
            'post_name' => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
            'post_status' => 'publish',
            'post_content' => $content,
            'post_type' => 'page',
            'post_parent' => $parent_id, //'id_of_the_parent_page_if_it_available'
            'comment_status' => 'open'
        )
    );

    update_post_meta($page_id, '_wp_page_template', SEO_PAGE_TEMPLATE);
    update_post_meta($page_id, '_page_type', "seo");

    // echo "Created page_id=" . $page_id . " for page '" . $title_of_the_page . "'<br/>";
    return $page_id;
}

function filter_update($page_id, $filters = array(), $reales_fields_settings = array())
{
    // Get property custom fields
    $location_list = [];
    $status = [];
    $facing = [];
    $floor_no = [];

    if ($reales_fields_settings) {
        $location_list = $reales_fields_settings['local_location']['list'];
        $location_list = explode(',', $location_list);

        $status = $reales_fields_settings['status']['list'];
        $status = explode(',', $status);

        $facing = $reales_fields_settings['facing']['list'];
        $facing = explode(',', $facing);

        $floor_no = $reales_fields_settings['floor_no']['list'];
        $floor_no = explode(',', $floor_no);
    }

    foreach ($filters as $key => $value) {
        # code...
        $value = trim($value);
        if ($key == 'category') {
            $term = get_term_by('name', $value, 'property_category');
            $value = $term ? $term->term_id : "";
        } else if ($key == 'type') {
            $term = get_term_by('name', $value, 'property_type_category');
            $value = $term ? $term->term_id : "";
        } else if ($key == 'location' && $value != '') {
            $index = array_search($value, $location_list);
            $value = $index >= 0 ? $index : "";
        } else if ($key == 'facing' && $value != '') {
            $index = array_search($value, $facing);
            $value = $index >= 0 ? $index : "";
        } else if ($key == 'status' && $value != '') {
            $index = array_search($value, $status);
            $value = $index >= 0 ? $index : "";
        }

        update_post_meta($page_id, METABOX_PREFIX . $key, $value);
    }
}

function add_to_yoast_seo($post_id, $metatitle, $metadesc, $metakeywords)
{

    // $my_plugin = WP_PLUGIN_DIR . '/wordpress-seo';
    // if (is_dir($my_plugin)) {
    //     // plugin directory found!
    // }
    // echo "Updating the metadata";
    // $plugin_dir = ABSPATH . 'wp-content/plugins/wordpress-seo';

    $ret = false;

    /**
     * Detect plugin. For use on Front End only.
     */
    // include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    // echo $my_plugin . '/wp-seo.php';
    // check for plugin using plugin name
    // if (is_plugin_active($my_plugin . '/wp-seo.php')) {
    //plugin is activated
    $updated_title = update_post_meta($post_id, '_yoast_wpseo_title', $metatitle);
    $updated_desc = update_post_meta($post_id, '_yoast_wpseo_metadesc', $metadesc);
    $updated_kw = update_post_meta($post_id, '_yoast_wpseo_metakeywords', $metakeywords);

    if ($updated_title && $updated_desc && $updated_kw) {
        $ret = true;
    }
    // }
    // }
    // echo $ret ? " Updated" : "Not updated";

    return $ret;
}

if (!function_exists('sanitize_get_seo')) :

    function sanitize_get_seo($name, $default = '')
    {
        return isset($_GET[$name]) ? sanitize_text_field($_GET[$name]) : sanitize_text_field($default);
    }

endif;

if (!function_exists('set_the_seo_data_to_get')) :

    function set_the_seo_data_to_get()
    {

        $area_min = "0";
        $area_max = "5000";

        $price_form = "0";
        $price_to = "150000000";

        $filters = array(
            'search_keywords' => '',
            'location' => '',
            'price_form' => '',
            'price_to' => '',
            'category' => '',
            'type' => '',
            'area_from' => '',
            'area_to' => '',
            'amenities' => '',
            'status' => '',
            'bedroom' => '',
            'facing' => '',
            'neighborhood' => '',
        );

        foreach ($filters as $key => $value) {
            $filters[$key] = get_post_meta(get_the_ID(), METABOX_PREFIX . $key, true);
        }


        $_GET['sort'] = sanitize_get_seo('sort', 'newest');
        $_GET['local_location_comparison'] = sanitize_get_seo('local_location_comparison', 'equal');

        $_GET['search_keywords'] = sanitize_get_seo('search_keywords', $filters['search_keywords']);
        $_GET['search_category'] = sanitize_get_seo('search_category', !is_numeric($filters['category']) ? "0" : $filters['category']);
        $_GET['search_type'] = sanitize_get_seo('search_type', !is_numeric($filters['type']) ? "0" : $filters['type']);
        $_GET['search_min_price'] = sanitize_get_seo('search_min_price', $filters['price_form'] ? $filters['price_form'] : $price_form);
        $_GET['search_max_price'] = sanitize_get_seo('search_max_price', $filters['price_to'] ? $filters['price_to'] : $price_to);
        $_GET['search_min_area'] = sanitize_get_seo('search_min_area', $filters['area_from'] ? $filters['area_from'] : $area_min);
        $_GET['search_max_area'] = sanitize_get_seo('search_max_area', $filters['area_to'] ? $filters['area_to'] : $area_max);
        $_GET['local_location'] = sanitize_get_seo('local_location', !is_numeric($filters['location']) ? "" : $filters['location']);

        //Default fields
        $_GET['search_lat'] = sanitize_get_seo('search_lat', '');
        $_GET['search_lng'] = sanitize_get_seo('search_lng', '');;
        $_GET['search_bedrooms'] = sanitize_get_seo('search_bedrooms', $filters['bedroom'] ? $filters['bedroom'] : '-1');
        $_GET['search_bathrooms'] = sanitize_get_seo('search_bathrooms', '0');
        $_GET['search_neighborhood'] = sanitize_get_seo('search_neighborhood', $filters['neighborhood'] ? $filters['neighborhood'] : '');

        $_GET['status'] = sanitize_get_seo('status', $filters['status'] != '' ? $filters['status'] : '');
        $_GET['status_comparison'] = sanitize_get_seo('status_comparison', 'equal');
        $_GET['facing'] = sanitize_get_seo('facing', $filters['facing'] != '' ? $filters['facing'] : '');
        $_GET['facing_comparison'] = sanitize_get_seo('facing_comparison', 'equal');

        $amenities = explode(',', $filters['amenities']);
        // _p($amenities);
        foreach ($amenities as $value) {
            $s_key = str_replace(' ', '_', trim(strtolower($value)));
            if ($s_key) {
                $_GET[$s_key] = sanitize_get_seo($s_key, "1");
            }
        }
    }

endif;
