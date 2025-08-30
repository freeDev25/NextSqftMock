<?php

global $metabox_path, $metabox_uri, $prefix, $url_path;
$metabox_uri = get_template_directory_uri() . "/metaboxes";

require_once($metabox_path . "meta-box-class/my-meta-box-class.php");
//require_once $metabox_path . 'usage.php';
//require_once $metabox_path . 'meta_box.php';

require_once $metabox_path . 'metabox-functions.php';

$url_path = $metabox_uri . "/meta-box-class";

//include the main class file
//Add Metaboxes
$boxes = array(
    // array(
    //     'folder' => 'boxes',
    //     'slug' => 'metabox',
    //     'name' => 'page'
    // ),
    array(
        'folder' => 'boxes',
        'slug' => 'metabox',
        'name' => 'page-bottom'
    ),
//     array(
//         'folder' => 'boxes',
//         'slug' => 'metabox',
//         'name' => 'leads'
//     )
);
add_my_meta_boxes($boxes);
