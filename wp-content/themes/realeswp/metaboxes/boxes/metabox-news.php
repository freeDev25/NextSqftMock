<?php

global $url_path;
$prefix = "_ash_";

$config_news = array(
    'id' => 'page_bottom_meta_box', // meta box id, unique per meta box
    'title' => 'Page bottom contacts', // meta box title
    'pages' => array('news'), // post types, accept custom post types as well, default is array('post'); optional
    'context' => 'side', // where the meta box appear: normal (default), advanced, side; optional
    'priority' => 'low', // order of meta box: high (default), low; optional
    'fields' => array(), // list of meta fields (can be added by field arrays)
    'local_images' => false, // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => $url_path          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);


/*
 * Initiate your 3rd meta box
 */
$news_boxes = new AT_Meta_Box($config_news);
//first field of the group has 'group' => 'start' and last field has 'group' => 'end'

$news_boxes->addCheckbox($prefix . 'is_featured', array('name' => 'Featured'));

/*
 * Don't Forget to Close up the meta box Declaration 
 */
//Finish Meta Box Declaration 
$news_boxes->Finish();
?>