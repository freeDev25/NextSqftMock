<?php
//page Post categoryFrom page
add_action('add_meta_boxes', 'add_page_menu_metaboxes');
add_action('save_post', 'wpt_save_page_menu_meta'); 

// Add the Events Meta Boxes
// Add the Events Meta Boxes

function add_page_menu_metaboxes() {
    add_meta_box('page_menu_metas_custom', 'Menu', 'page_menu_post_meta_info', 'page', 'side', 'high');
}

// The Event Location Metabox

function page_menu_post_meta_info() {
    global $post;
    echo '<input type="hidden" name="pagemeta_intro_noncename" id="pagemeta_intro_noncename" value="' .
    wp_create_nonce(plugin_basename(__FILE__)) . '" />';

//    $prefix = "_ash_";
    $menus = get_terms('nav_menu', array('hide_empty' => true));
//    print_r($menus);
    $page_menu_intro = get_post_meta($post->ID, '_page_menu_item', true);
    ?>
    <h3>Page Menu</h3>
    <select name="_ash_page_menu">
        <option>Select Page Menu</option>
        <?php foreach ($menus as $key => $value) { ?>
        <option <?php echo ($page_menu_intro == $value->term_id) ? 'selected' : '';?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
        <?php } ?>
    </select>
    <p class="description">This will display the menu at the left bar.</p>
    <?php
}

// Save the Metabox Data

function wpt_save_page_menu_meta($post_id) {
    global $wpdb;
    //print_r($_POST);exit;
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (( isset($_POST['pagemeta_noncename']) ) && (!wp_verify_nonce($_POST['pagemeta_noncename'], plugin_basename(__FILE__)) ))
        return;
    // Check permissions
    if (( isset($_POST['post_type']) ) && ( 'page' == $_POST['post_type'] )) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_meta_value = $_POST['_ash_page_menu'];


    /* Get the meta key. */
    $meta_key = '_page_menu_item';


    /* Get the meta value of the custom field key. */
    $meta_value = get_post_meta($post_id, $meta_key, true);

    /* If a new meta value was added and there was no previous value, add it. */
    if ($new_meta_value && '' == $meta_value)
        add_post_meta($post_id, $meta_key, $new_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_meta_value && $new_meta_value != $meta_value)
        update_post_meta($post_id, $meta_key, $new_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_meta_value && $meta_value)
        delete_post_meta($post_id, $meta_key, $meta_value);
}

// save the custom fields
?>
