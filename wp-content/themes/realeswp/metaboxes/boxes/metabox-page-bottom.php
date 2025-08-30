<?php

global $url_path;
$prefix = METABOX_PREFIX;

$config3 = array(
    'id' => 'page_bottom_meta_box', // meta box id, unique per meta box
    'title' => 'Seo page options', // meta box title
    'pages' => array('page'), // post types, accept custom post types as well, default is array('post'); optional
    'context' => 'normal', // where the meta box appear: normal (default), advanced, side; optional
    'priority' => 'low', // order of meta box: high (default), low; optional
    'fields' => array(), // list of meta fields (can be added by field arrays)
    'local_images' => false, // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => $url_path          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);


/*
 * Initiate your 3rd meta box
 */
$page_bottom = new AT_Meta_Box($config3);
//first field of the group has 'group' => 'start' and last field has 'group' => 'end'

// $page_bottom->addCheckbox($prefix . 'show_catelog', array('name' => 'Show Catalogue'));
$page_bottom->addText($prefix . 'location', array('name' => 'Location'));
$page_bottom->addNumber($prefix . 'price_form', array('name' => 'Price Min'));
$page_bottom->addNumber($prefix . 'price_to', array('name' => 'Price Max'));
//$page_bottom->addText($prefix . 'category', array('name' => 'Category'));
//$page_bottom->addText($prefix . 'type', array('name' => 'Type'));
$page_bottom->addNumber($prefix . 'area_from', array('name' => 'Area MIn'));
$page_bottom->addNumber($prefix . 'area_to', array('name' => 'Area max'));
$page_bottom->addTextarea($prefix . 'amenities', array('name' => 'Amenities'));
$page_bottom->addText($prefix . 'bedroom', array('name' => 'Bedrooms'));
$page_bottom->addText($prefix . 'facing', array('name' => 'Facing'));
$page_bottom->addText($prefix . 'status', array('name' => 'Status'));
$page_bottom->addText($prefix . 'neighborhood', array('name' => 'Neighborhood'));
$page_bottom->addTextarea($prefix . 'search_keywords', array('name' => 'Search Keywords'));
// $page_bottom->addImage($prefix . 'catelog_image', array('name' => 'Catalogue Image'));

/*
 * Don't Forget to Close up the meta box Declaration 
 */
//Finish Meta Box Declaration 
$page_bottom->Finish();
?>