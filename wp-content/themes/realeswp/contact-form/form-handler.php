<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $pagenow;

require_once TEMPLATEPATH . '/contact-form/table-generator.php';

function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text_visible = substr($text, 0, $pos[$limit]);
        $text_more = substr($text, $pos[$limit + 1], $pos[count($pos) - 1]);
        return "<span class='limited-text'>" . $text_visible . '<span class="text-more">' . $text_more . '</span> <a class="show-more">show more</a><a class="show-less">show less</a></span>';
    }
    return "<span class='limited-text'>" . $text . "</span>";
}

function get_tf_meta_data($metas, $meta_key, $un_serialize = false)
{
    $data = $metas[$meta_key][0];
    if ($un_serialize) {
        $data = unserialize($data);
    }
    return $data;
}

if (!is_admin() && 'wp-login.php' != $pagenow) {
    add_action('init', 'contact_form_Scripting');
    add_action('init', 'ajax_form_styles');
}

function contact_form_Scripting()
{
    add_action('wp_enqueue_scripts', 'ajax_form_scripts');
}

function ajax_form_styles()
{
    //Styles
    wp_enqueue_style('leads-style', get_template_directory_uri() . '/contact-form/leads-style.css');
}

function ajax_form_scripts()
{
    $translation_array = array(
        'ajax_url' => admin_url('admin-ajax.php')
    );
    wp_enqueue_script('jq-multi-select', get_template_directory_uri() . '/contact-form/jquery.multi-select.min.js');
    wp_enqueue_script('frontend-ajax', get_template_directory_uri() . '/contact-form/contact-form.js', array('jq-multi-select'));
    wp_localize_script('frontend-ajax', 'cpm_object', $translation_array);
}

add_action('wp_ajax_set_form', 'set_form');    //execute when wp logged in
add_action('wp_ajax_nopriv_set_form', 'set_form'); //execute when logged out

function search_query_generate_lead($metas, $price_range_value)
{
    $lead = array(
        'name' => '',
        'email' => '',
        'phone' => '',
        'category' => '',
        'type' => '',
        'status' => '',
        'bedroom' => '',
        'bathroom' => '',
        'floor' => '',
        'facing' => '',
        'size' => '',
        'amenities' => ''
    );

    foreach ($lead as $key => $value) {
        if (is_array($value)) {
            $value = implode(',', $metas[METABOX_PREFIX . $key]);
        }
        $lead[$key] = $value;
    }

    $lead['budget'] = $price_range_value . ' lakhs';

    return $lead;
}

function set_form()
{
    if (isset($_POST['action']) && $_POST['action'] === 'set_form') {
        // Create post object
        $my_post = array(
            'post_title' => $_POST['subject'],
            'post_content' => $_POST['message'],
            'post_status' => 'publish',
            'post_type' => 'leads'
        );

        $postID = wp_insert_post($my_post);

        if ($postID) {
            $metas = $_POST['meta'];
            $price_range_value = $metas[METABOX_PREFIX . 'price_range'];
            if (isset($metas[METABOX_PREFIX . 'price_range']) && $metas[METABOX_PREFIX . 'price_range']) {
                $price_range = explode('-', $metas[METABOX_PREFIX . 'price_range']);
                $metas[METABOX_PREFIX . 'price_form'] = $price_range[0];
                $metas[METABOX_PREFIX . 'price_to'] = $price_range[1];
                unset($metas[METABOX_PREFIX . 'price_range']);
            }
            add_metas($metas, $postID);

            $admin_email = get_option('admin_email');
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: NEXT SQFT <' . $admin_email . '>';

            $lead = search_query_generate_lead($metas, $price_range_value);

            // $lead = array(
            //     'name' => $metas[METABOX_PREFIX . 'name'],
            //     'email' => $metas[METABOX_PREFIX . 'email'],
            //     'phone' => $metas[METABOX_PREFIX . 'phone'],
            //     'category' => implode(',', $metas[METABOX_PREFIX . 'category']),
            //     'type' => implode(',', $metas[METABOX_PREFIX . 'type']),
            //     'status' => implode(',', $metas[METABOX_PREFIX . 'status']),
            //     'bedroom' => implode(',', $metas[METABOX_PREFIX . 'bedroom']),
            //     'bathroom' => implode(',', $metas[METABOX_PREFIX . 'bathroom']),
            //     'floor' => implode(',', $metas[METABOX_PREFIX . 'floor_no']),
            //     'facing' => implode(',', $metas[METABOX_PREFIX . 'facing']),
            //     'size' => implode(',', $metas[METABOX_PREFIX . 'size']),
            //     'amenities' => implode(',', $metas[METABOX_PREFIX . 'amenities']),
            //     'budget' => $price_range_value . ' lakhs',
            // );
            $lead_post_title = $_POST['subject'];
            $lead_url = "<a href='" . get_permalink($postID) . "'> <strong>" . $lead_post_title . "</strong></a>";
            $items = "<p>Name - " . $lead['name'] . "</p>"
                . "<p>Email - " . $lead['email'] . "</p>"
                . "<p>Phone - " . $lead['phone'] . "</p>"
                . "<p>Bedroom - " . $lead['bedroom'] . "</p>"
                . "<p>Bathroom - " . $lead['bathroom'] . "</p>"
                . "<p>Floor - " . $lead['floor'] . "</p>"
                . "<p>Facing - " . $lead['facing'] . "</p>"
                . "<p>Size - " . $lead['size'] . "</p>"
                . "<p>Status - " . $lead['status'] . "</p>"
                . "<p>Category - " . $lead['category'] . "</p>"
                . "<p>Type - " . $lead['type'] . "</p>"
                . "<p>Size - " . $lead['size'] . "</p>"
                . "<p>Amenities - " . $lead['amenities'] . "</p>"
                . "<p>Budget - " . $lead['budget'] . "</p>";
            //Admin email
            $information = "Hi Admin, "
                . "<p>An new Lead has been generated: " . $lead_url . "</p>";
            $message = $information . $items;

            $admin_mail_status = wp_mail($admin_email, "Notification: New Lead generated - " . $lead_post_title, $message, $headers);
            wp_send_json(array(
                'message' => 'Lead added successfully.',
                'status' => "success",
                'statusCode' => '200',
                'metas' => $metas,
                'lead' => $lead
            ));
            wp_die(); //use wp_die() once you have completed your execution.
        }
    }
}

//add_action('init', set_form);

add_action('wp_ajax_lead_contact', 'lead_contact');    //execute when wp logged in
add_action('wp_ajax_nopriv_lead_contact', 'lead_contact'); //execute when logged out

function lead_contact()
{
    //    wp_send_json($_POST);
    //    wp_die();
    if (isset($_POST['action']) && $_POST['action'] === 'lead_contact' && $_POST['meta'][METABOX_PREFIX . 'post_id'] !== '') {
        $subject = $_POST['subject'];
        // Create post object
        $my_post = array(
            'post_title' => $_POST['subject'],
            //            'post_content' => $_POST['message'],
            'post_status' => 'publish',
            'post_type' => 'lead_contact'
        );
        $lead_post_id = $_POST['meta'][METABOX_PREFIX . 'post_id'];
        $postID = wp_insert_post($my_post);
        if ($postID) {
            $metas = $_POST['meta'];
            add_metas($metas, $postID);

            $admin_email = get_option('admin_email');
            //            $user_email = get_post_meta($postID, METABOX_PREFIX . 'email', true);
            //            $to = array($admin_email, $user_email);

            $lead_post_user = get_post_meta($lead_post_id, METABOX_PREFIX . 'name', true);
            $lead_post_email = get_post_meta($lead_post_id, METABOX_PREFIX . 'email', true);
            $lead_post_phone = get_post_meta($lead_post_id, METABOX_PREFIX . 'phone', true);
            $lead_post_title = get_the_title($lead_post_id);

            $saller = array(
                'name' => $metas[METABOX_PREFIX . 'name'],
                'email' => $metas[METABOX_PREFIX . 'email'],
                'phone' => $metas[METABOX_PREFIX . 'phone'],
                'bedroom' => $metas[METABOX_PREFIX . 'bedroom'],
                'bathroom' => $metas[METABOX_PREFIX . 'bathroom'],
                'floor' => $metas[METABOX_PREFIX . 'floor'],
                'size' => $metas[METABOX_PREFIX . 'size'],
                'price' => $metas[METABOX_PREFIX . 'price']
            );

            $user_post_date = get_the_date(get_option('date_format'), $postID);
            //            $subject = "TEST: Ignore! " . $subject;
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: NEXT SQFT <' . $admin_email . '>';
            //            $headers[] = 'Cc: John Q Codex <jqc@wordpress.org>';
            //            $headers[] = 'Bcc: iluvwp@wordpress.org'; // note you can just use a simple email address


            $lead_url = "<a href='" . get_permalink($lead_post_id) . "'> <strong>" . $lead_post_title . "</strong></a>";
            $greeting = "<h3>Greetings From Next Sqft,</h3>";
            $information = "<p>Hi " . $lead_post_user . ",</p>"
                . "<p>Property dealer/saller/owner  <b>" . $saller['name'] . "</b> responded to " . $lead_url . " posted on " . $user_post_date . "</p>";

            $items = "<p>Bedroom - " . $saller['bedroom'] . "</p>"
                . "<p>Bathroom - " . $saller['bathroom'] . "</p>"
                . "<p>Floor - " . $saller['floor'] . "</p>"
                . "<p>Size - " . $saller['size'] . "</p>"
                . "<p>Price - " . $saller['price'] . " lakh</p>";

            //User Email
            $message = $greeting . $information . $items;
            $user_mail_status = wp_mail($lead_post_email, "New Offer: " . $subject, $message, $headers);

            //Saler Email
            $information = "Hi " . $saller['name'] . ", "
                . "<p>An new offer sent by you for lead " . $lead_url . "</p>";
            $message = $information . $items;
            $saler_mail_status = wp_mail($saller['email'], "Notification: offer sent to " . $lead_post_title, $message, $headers);

            //Admin email
            $information = "Hi Admin, "
                . "<p>An new offer sent for " . $lead_url . "</p>";
            $message = $information . $items;
            $message = $message
                . "<p>Offer sent by - " . $saller['name'] . "(Email: " . $saller['email'] . ", Phone: " . $saller['phone'] . ")</p>"
                . "<p>Offer received by - " . $lead_post_user . "(Email: " . $lead_post_email . ", Phone: " . $lead_post_phone . ")</p>";
            $admin_mail_status = wp_mail($admin_email, "Notification: offer sent for " . $lead_post_title, $message, $headers);



            wp_send_json(array(
                'message' => 'Lead contact added successfully.',
                'status' => "success",
                'statusCode' => '200',
                'isMailSent' => $mail ? true : false,
                'message' => $message,
                'admin_email' => $admin_email,
                'user_email' => $lead_post_email,
                'saler_email' => $saller['email'],
            ));
            wp_die(); //use wp_die() once you have completed your execution.
        }
    }
}

//add_action('init', lead_contact);

function add_metas($metas, $post_id)
{
    //    _p($metas);
    if ($metas) {
        foreach ($metas as $meta_key => $meta_value) {
            if ($meta_value !== '') {
                update_post_meta($post_id, $meta_key, $meta_value);
            }
        }
    }
}

function ash_post_type_leads()
{

    register_post_type(
        'leads',
        array(
            'label' => __('Leads'),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'rewrite' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-schedule',
            'menu_position' => 7,
            'supports' => array(
                'title',
                'editor',
                'comments',
            )
        )
    );
    register_post_type(
        'lead_contact',
        array(
            'label' => __('Sallers'),
            'menu_position' => 7,
            'public' => false,
            'show_ui' => false,
            'show_in_nav_menus' => false,
            'capabilities' => array(
                'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
            ),
        )
    );

    add_post_type_support('leads', 'wps_subtitle');
}

add_action('init', 'ash_post_type_leads');

function my_admin_menu()
{
    add_submenu_page('edit.php?post_type=leads', 'Sallers', 'Sallers', 'manage_options', 'lead-sallers-page', 'my_leads_admin_page_contents', 2);
}

add_action('admin_menu', 'my_admin_menu');

//add_filter('post_row_actions', 'my_plugin_modify_action_links', 15, 2); // If your CPT is of type page, hook your function to 'page_row_actions' instead.

function my_plugin_modify_action_links($actions, $post)
{

    // This function will be called for all post types. Target our custom post type so that our custom action link is not added to other post types.
    if ($post->post_type == 'leads') {

        $action_url = admin_url('edit.php'); // Note that I'm linking to post.php and not edit.php.
        $action_url = add_query_arg(array(
            'post_type' => 'leads',
            'pid' => $post->ID,
            'page' => 'lead-sallers-page'
        ), $action_url);
        $args = array(
            'post_type' => 'lead_contact',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => METABOX_PREFIX . 'post_id',
                    'compare' => 'IN',
                    // With dynamic values, be sure to properly escape the "IS" or whatever
                    // is the actual value. E.g. '(^|,)' . preg_quote( $value ) . '(,|$)'
                    'value' => $post->ID,
                )
            )
        );

        $query = new WP_Query($args);
        $total = $query->found_posts;

        $actions['lead_contact_page'] = '<a href="' . esc_url($action_url) . '"> See Salers (' . $total . ')</a>';
    }

    return $actions;
}

/**
 * This function is responsible for render the drafts table
 */
function my_leads_admin_page_contents()
{
    $drafts_table = new Drafts_List_Table();
?>
    <div class="wrap">
        <h2><?php esc_html_e('All Salers List', 'admin-table-tut'); ?></h2>
        <form id="all-sallers" method="get">
            <input type="hidden" name="page" value="lead-sallers-page" />
            <input type="hidden" name="post_type" value="leads" />

            <?php
            $drafts_table->prepare_items();
            $drafts_table->search_box('Search', 'search');
            $drafts_table->display();
            ?>
        </form>
    </div>
<?php
}

//add_filter('posts_join', 'segnalazioni_search_join');
//
//function segnalazioni_search_join($join) {
//    global $pagenow, $wpdb;
//
//    // I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni".
//    if (is_admin() && 'edit.php' === $pagenow && 'leads' === $_GET['post_type']) {
//        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
//    }
//    return $join;
//}
//
//add_filter('posts_where', 'segnalazioni_search_where');
//
//function segnalazioni_search_where($where) {
//    global $pagenow, $wpdb;
//
//    // I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni".
//    if (is_admin() && 'edit.php' === $pagenow && 'leads' === $_GET['post_type']) {
//        $where = preg_replace(
//                "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
//                "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where);
//        $where .= " GROUP BY {$wpdb->posts}.id"; // Solves duplicated results
//    }
//    return $where;
//}
//
//function custom_search_query($query) {
//    $custom_fields = array(
//        // put all the meta fields you want to search for here
//        "rg_first_name",
//        "rg_1job_designation"
//    );
//    $searchterm = $query->query_vars['s'];
//
//    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
//    $query->query_vars['s'] = "";
//
//    if ($searchterm != "") {
//        $meta_query = array('relation' => 'OR');
//        foreach ($custom_fields as $cf) {
//            array_push($meta_query, array(
//                'key' => $cf,
//                'value' => $searchterm,
//                'compare' => 'LIKE'
//            ));
//        }
//        $query->set("meta_query", $meta_query);
//    };
//}
//
//add_filter("pre_get_posts", "custom_search_query");
// Add the custom columns to the book post type:

add_filter('manage_leads_posts_columns', 'set_custom_edit_leads_columns');

function set_custom_edit_leads_columns($columns)
{
    unset($columns['author']);
    $columns['name'] = __('Name', 'realswp');
    $columns['email'] = __('Email', 'realswp');
    $columns['phone'] = __('Phone', 'realswp');
    $columns['salers'] = __('Salers', 'realswp');

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action('manage_leads_posts_custom_column', 'custom_leads_column', 10, 2);

function custom_leads_column($column, $post_id)
{
    switch ($column) {
        case 'name':
            echo get_post_meta($post_id, METABOX_PREFIX . 'name', true);
            break;
        case 'email':
            echo get_post_meta($post_id, METABOX_PREFIX . 'email', true);
            break;
        case 'phone':
            echo get_post_meta($post_id, METABOX_PREFIX . 'phone', true);
            break;
        case 'salers':
            $args = array(
                'post_type' => 'lead_contact',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => METABOX_PREFIX . 'post_id',
                        'compare' => 'IN',
                        // With dynamic values, be sure to properly escape the "IS" or whatever
                        // is the actual value. E.g. '(^|,)' . preg_quote( $value ) . '(,|$)'
                        'value' => $post_id,
                    )
                )
            );

            $query = new WP_Query($args);
            $total = $query->found_posts;
            $action_url = admin_url('edit.php'); // Note that I'm linking to post.php and not edit.php.
            $action_url = add_query_arg(array(
                'post_type' => 'leads',
                'pid' => $post_id,
                'page' => 'lead-sallers-page'
            ), $action_url);
            echo '<a href="' . esc_url($action_url) . '">' . $total . '</a>';
            break;
    }
}

//function add_admin_column($column_title, $post_type, $cb) {
//
//    // Column Header
//    add_filter('manage_' . $post_type . '_posts_columns', function($columns) use ($column_title) {
//        $columns[sanitize_title($column_title)] = $column_title;
//        return $columns;
//    });
//
//    // Column Content
//    add_action('manage_' . $post_type . '_posts_custom_column', function( $column, $post_id ) use ($column_title, $cb) {
//
//        if (sanitize_title($column_title) === $column) {
//            $cb($post_id);
//        }
//    }, 10, 2);
//}


add_filter('register_post_type_args', 'customize_service_post_type_labels', 10, 2);

function customize_service_post_type_labels($args, $post_type)
{
    // Let's make sure that we're customizing the post type we really need
    if ($post_type !== 'agent') {
        return $args;
    }

    // Now, we have access to the $args variable
    // If you want to modify just one label, you can do something like this
    $args['rewrite'] = array('slug' => 'seller', 'with_front' => true);

    //    // But let's imagine that I want to change all Service substring occurrencies to the new one
    //    $new_labels = array();
    //
    //    foreach ($args['labels'] as $key => $value) {
    //        if (strpos($value, 'Service') !== false) {
    //            $new_value = str_replace('Service', 'Offering', $value);
    //            $new_labels[$key] = $new_value;
    //        } else {
    //            $new_labels[$key] = $value;
    //        }
    //    }
    //
    //    $args['labels'] = $new_labels;

    return $args;
}

add_action('wp_ajax_get_mobile_number', 'get_mobile_number');    //execute when wp logged in
add_action('wp_ajax_nopriv_get_mobile_number', 'get_mobile_number'); //execute when logged out

function get_mobile_number()
{
    $logged_in_user = wp_get_current_user();
    $user = get_userdata($logged_in_user->ID);
    $is_logged_in = is_user_logged_in();
    $is_saller = reales_check_user_agent($user->ID) === true;
    $is_mobile_numbr_showable = $is_logged_in && $is_saller;

    if (!$is_mobile_numbr_showable) {
        wp_send_json(array(
            'message' => 'Mobile no can not be shown..',
            'status' => "failure",
            'statusCode' => '401',
            'loggedIn' => false
        ));
        wp_die();
    }
    if (isset($_GET['action']) && $_GET['action'] === 'get_mobile_number') {
        $post_id = $_GET['post_id'];
        $mobile_nuber = get_post_meta($post_id, METABOX_PREFIX . 'phone', true);

        if ($post_id) {

            global $current_user;

            $args = array(
                'post_type' => 'agent',
                'author' => $current_user->ID,
                'orderby' => 'post_date',
                'post_status' => 'publish',
                'order' => 'ASC',
                'posts_per_page' => -1 // no limit
            );


            $current_user_posts = get_posts($args);
            $total = count($current_user_posts);
            $saller_url = "https://nextsqft.com";

            if ($total > 0) {
                $saler_post =  $current_user_posts[0];
                $saller_url = get_the_permalink($saler_post->ID);
            }

            $lead_post_id = $post_id;

            $admin_email = get_option('admin_email');
            //            $admin_email = "suchandan.developer@gmail.com";

            $lead_post_user = get_post_meta($lead_post_id, METABOX_PREFIX . 'name', true);
            $lead_post_email = get_post_meta($lead_post_id, METABOX_PREFIX . 'email', true);
            //            $lead_post_email = "suchandan.developer@gmail.com";

            $lead_post_phone = get_post_meta($lead_post_id, METABOX_PREFIX . 'phone', true);
            $lead_post_title = get_the_title($lead_post_id);

            $saller = array(
                'name' => $user->display_name,
                'email' => $user->user_email,
                //                'email' => "suchandan.developer@gmail.com",
                'url' => '<a herf="' . $saller_url . '" target=\'_blank\'>' . $saller_url . '</a>'
            );


            //adding lead_contact
            $subject = '[UGM] Myself, ' . $saller['name'] . ', want to fulfil the request.';
            $my_post = array(
                'post_title' => $subject,
                'post_status' => 'publish',
                'post_type' => 'lead_contact'
            );

            $lead_contact_post_id = wp_insert_post($my_post);
            update_post_meta($lead_contact_post_id, METABOX_PREFIX . 'post_id', $post_id);
            update_post_meta($lead_contact_post_id, METABOX_PREFIX . 'name', $saller['name']);
            update_post_meta($lead_contact_post_id, METABOX_PREFIX . 'email', $saller['email']);
            update_post_meta($lead_contact_post_id, METABOX_PREFIX . 'saller_url', $saller_url);
            update_post_meta($lead_contact_post_id, METABOX_PREFIX . 'contact_type', "UGM");
            //adding lead_contact

            $user_post_date = get_the_date(get_option('date_format'), $post_id);
            //            $subject = "TEST: Ignore! " . $subject;
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: NEXT SQFT <' . $admin_email . '>';
            //            $headers[] = 'Cc: John Q Codex <jqc@wordpress.org>';
            //            $headers[] = 'Bcc: iluvwp@wordpress.org'; // note you can just use a simple email address


            $lead_url = "<a href='" . get_permalink($lead_post_id) . "'> <strong>" . $lead_post_title . "</strong></a>";
            $greeting = "<h3>Greetings From Next Sqft,</h3>";
            $information = "<p>Hi " . $lead_post_user . ",</p>"
                . "<p>Property dealer/saller/owner  <b>" . $saller['name'] . "</b> responded to " . $lead_url . " posted on " . $user_post_date . "</p>"
                . "<p>Please checkout the saller profile " . $saller_url . " </p>"
                . "<p>You might receive a call from our sallers.</p>";

            $items = "";
            //                    "<p>Bedroom - " . $saller['bedroom'] . "</p>"
            //                    . "<p>Bathroom - " . $saller['bathroom'] . "</p>"
            //                    . "<p>Floor - " . $saller['floor'] . "</p>"
            //                    . "<p>Size - " . $saller['size'] . "</p>"
            //                    . "<p>Price - " . $saller['price'] . " lakh</p>";
            //User Email
            $message = $greeting . $information . $items;
            $user_mail_status = wp_mail($lead_post_email, "New Offer: " . $subject, $message, $headers);

            //Saler Email
            $information = "Hi " . $saller['name'] . ", "
                . "<p>You have sown interest for lead " . $lead_url . "</p>";
            $message = $information . $items;
            $saler_mail_status = wp_mail($saller['email'], "Notification: Thank you for your interest for lead: " . $lead_post_title, $message, $headers);

            //Admin email
            $information = "Hi Admin, "
                . "<p>An new offer sent for " . $lead_url . "</p>";
            $message = $information . $items;
            $message = $message
                . "<p>Saller - " . $saller['name'] . "(Email: " . $saller['email'] . ")</p>"
                . "<p>Saller Profile - " . $saller_url . "</p>"
                . "<p>Offer received by - " . $lead_post_user . "(Email: " . $lead_post_email . ", Phone: " . $lead_post_phone . ")</p>";
            $admin_mail_status = wp_mail($admin_email, "Notification: Saller " . $saller['name'] . " has shown interest for " . $lead_post_title, $message, $headers);
        }

        wp_send_json(array(
            'message' => 'Lead added successfully.',
            'status' => "success",
            'statusCode' => '200',
            'loggedIn' => false,
            'mobile' => $mobile_nuber
        ));
        wp_die(); //use wp_die() once you have completed your execution.
    }
}

add_action('phpmailer_init', 'send_smtp_email');
function send_smtp_email($phpmailer)
{
    //    echo "2";
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.hostinger.com';
    $phpmailer->Port       = '587';
    $phpmailer->SMTPSecure = 'TLS';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Username   = 'admin@nextsqft.com';
    $phpmailer->Password   = 'Ql:*uoaZ4';
    $phpmailer->From       = 'admin@nextsqft.com';
    $phpmailer->FromName   = 'Next Sqft';
    //    $phpmailer->addReplyTo('info@example.com', 'Information');
}

add_action('wp_ajax_get_test_mail', 'test_mail_function');    //execute when wp logged in
add_action('wp_ajax_nopriv_get_test_mail', 'test_mail_function'); //execute when logged out

function test_mail_function()
{
    $to = 'freelancing.dev25@gmail.com';
    $subject = 'Test Mail';
    $body = 'The email body content';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    $result = wp_mail($to, $subject, $body, $headers);

    echo "TEST MAIL";
    wp_die($result);
}

add_action('wp_mail_failed', 'log_mailer_errors', 10, 1);
function log_mailer_errors($wp_error)
{
    $fn = ABSPATH . '/mail.log'; // say you've got a mail.log file in your server root
    $fp = fopen($fn, 'a');
    fputs($fp, "[" . date("F j, Y, g:i a") . "] Mailer Error: " . $wp_error->get_error_message() . "\n");
    fclose($fp);
}
