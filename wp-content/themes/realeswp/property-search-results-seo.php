<?php
/*
  Template Name: Property Search Results SEO
 */

/**
 * @package WordPress
 * @subpackage Reales
 */
global $post;
$page_id = $post->ID;
get_header();

//Set the GET params
set_the_seo_data_to_get();

$reales_appearance_settings = get_option('reales_appearance_settings', '');
$show_bc = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';
$nomap = isset($reales_appearance_settings['reales_nomap_field']) ? $reales_appearance_settings['reales_nomap_field'] : '';
$sidebar_position = isset($reales_appearance_settings['reales_sidebar_field']) ? $reales_appearance_settings['reales_sidebar_field'] : '';
$map_position = isset($reales_appearance_settings['reales_map_position_field']) ? $reales_appearance_settings['reales_map_position_field'] : '';
$mobile_first = isset($reales_appearance_settings['reales_mobile_first_field']) ? $reales_appearance_settings['reales_mobile_first_field'] : '';
$leftside_menu = isset($reales_appearance_settings['reales_leftside_menu_field']) ? $reales_appearance_settings['reales_leftside_menu_field'] : '';

$cards_design_settings = get_option('reales_prop_cards_design_settings', '');
$card_type = isset($cards_design_settings['card_type']) ? $cards_design_settings['card_type'] : '';

$content_white_class = '';
if ($card_type == 'd2') {
    $content_white_class = 'has-white-bg';
    $sort_btn_class = 'btn-o btn-default';
} else {
    $sort_btn_class = 'btn-white';
}

$map_class = '';
$content_class = '';
if ($map_position == 'right') {
    $map_class = 'map-is-right';

    if ($leftside_menu == '1') {
        $content_class = 'content-is-left has-left-menu';
    } else {
        $content_class = 'content-is-left';
    }
}

$map_mobile_class = '';
$content_mobile_class = '';
if ($mobile_first == 'list') {
    $map_mobile_class = 'mob-min';
    $content_mobile_class = 'mob-max';
}

$reales_colors_settings = get_option('reales_colors_settings');
$prop_type_badge_bg = isset($reales_colors_settings['reales_prop_type_badge_bg_field']) ? $reales_colors_settings['reales_prop_type_badge_bg_field'] : '';

$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';
$searched_posts = reales_search_properties();
$total_p = $searched_posts->found_posts;
$users = get_users();
?>

<?php if ($nomap != '1') { ?>
    <div id="wrapper">
    <?php } else { ?>
        <style>
            body.page-template-property-search-results {
                overflow: auto !important;
            }
        </style>
        <div>
        <?php } ?>

        <?php if ($nomap != '1') { ?>
            <div id="mapView" class="<?php echo esc_attr($map_class); ?> <?php echo esc_attr($map_mobile_class); ?>">
                <div class="mapPlaceholder"><span class="fa fa-spin fa-spinner"></span> <?php esc_html_e('Loading map...', 'realeswp'); ?></div>
            </div>
            <?php wp_nonce_field('app_map_ajax_nonce', 'securityAppMap', true); ?>
            <div id="content" class="<?php echo esc_attr($content_class); ?> <?php echo esc_attr($content_mobile_class); ?> <?php echo esc_attr($content_white_class); ?>">
            <?php } else { ?>
                <div class="page-wrapper no-map">
                    <div class="page-content">
                    <?php } ?>

                    <?php get_template_part('templates/filter_properties'); ?>

                    <div class="resultsList">
                        <?php
                        if ($show_bc != '') {
                            reales_breadcrumbs();
                        }
                        ?>

                        <div class="row pb10">
                            <div class="col-xs-12 col-sm-6">
                                <h1><?php echo esc_html($post->post_title); ?></h1>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="text-right">
                                    <div class="sorter-wrapper pb10">
                                        <div class="form-group">
                                            <?php esc_html_e('Sort by:', 'realeswp'); ?>&nbsp;&nbsp;
                                            <a href="javascript:void(0);" data-toggle="dropdown" class="btn <?php echo esc_attr($sort_btn_class); ?> dropdown-toggle">
                                                <span class="dropdown-label"><?php esc_html_e('Newest', 'realeswp'); ?></span>&nbsp;&nbsp;&nbsp;<span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-select sorter">
                                                <?php
                                                $reales_prop_fields_settings = get_option('reales_prop_fields_settings');
                                                $p_price = isset($reales_prop_fields_settings['reales_p_price_field']) ? $reales_prop_fields_settings['reales_p_price_field'] : '';
                                                $p_bedrooms = isset($reales_prop_fields_settings['reales_p_bedrooms_field']) ? $reales_prop_fields_settings['reales_p_bedrooms_field'] : '';
                                                $p_bathrooms = isset($reales_prop_fields_settings['reales_p_bathrooms_field']) ? $reales_prop_fields_settings['reales_p_bathrooms_field'] : '';
                                                $p_area = isset($reales_prop_fields_settings['reales_p_area_field']) ? $reales_prop_fields_settings['reales_p_area_field'] : '';
                                                ?>
                                                <li class="active"><input type="radio" name="sort" value="newest" <?php
                                                                                                                    if (!$sort || $sort == '' || $sort == 'newest') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    }
                                                                                                                    ?>><a href="javascript:void(0);"><?php esc_html_e('Newest', 'realeswp'); ?></a></li>
                                                <?php if ($p_price != '' && $p_price == 'enabled') { ?>
                                                    <li><input type="radio" name="sort" value="price_lo" <?php
                                                                                                            if ($sort && $sort != '' && $sort == 'price_lo') {
                                                                                                                echo 'checked="checked"';
                                                                                                            }
                                                                                                            ?>><a href="javascript:void(0);"><?php esc_html_e('Price (Lo-Hi)', 'realeswp'); ?></a></li>
                                                    <li><input type="radio" name="sort" value="price_hi" <?php
                                                                                                            if ($sort && $sort != '' && $sort == 'price_hi') {
                                                                                                                echo 'checked="checked"';
                                                                                                            }
                                                                                                            ?>><a href="javascript:void(0);"><?php esc_html_e('Price (Hi-Lo)', 'realeswp'); ?></a></li>
                                                <?php } ?>
                                                <?php if ($p_bedrooms != '' && $p_bedrooms == 'enabled') { ?>
                                                    <li><input type="radio" name="sort" value="bedrooms" <?php
                                                                                                            if ($sort && $sort != '' && $sort == 'bedrooms') {
                                                                                                                echo 'checked="checked"';
                                                                                                            }
                                                                                                            ?>><a href="javascript:void(0);"><?php esc_html_e('Bedrooms', 'realeswp'); ?></a></li>
                                                <?php } ?>
                                                <?php if ($p_bathrooms != '' && $p_bathrooms == 'enabled') { ?>
                                                    <li><input type="radio" name="sort" value="bathrooms" <?php
                                                                                                            if ($sort && $sort != '' && $sort == 'bathrooms') {
                                                                                                                echo 'checked="checked"';
                                                                                                            }
                                                                                                            ?>><a href="javascript:void(0);"><?php esc_html_e('Bathrooms', 'realeswp'); ?></a></li>
                                                <?php } ?>
                                                <?php if ($p_area != '' && $p_area == 'enabled') { ?>
                                                    <li><input type="radio" name="sort" value="area" <?php
                                                                                                        if ($sort && $sort != '' && $sort == 'area') {
                                                                                                            echo 'checked="checked"';
                                                                                                        }
                                                                                                        ?>><a href="javascript:void(0);"><?php esc_html_e('Area', 'realeswp'); ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <?php if (is_user_logged_in()) { ?>
                                        <div class="seave-search-wrapper pb10">
                                            <a href="#" class="btn btn-green" id="save-search" data-toggle="modal" data-target="#save-search-modal"><?php echo esc_html_e('Save Search', 'realeswp'); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            if ($searched_posts->have_posts()) {
                                while ($searched_posts->have_posts()) {
                                    $searched_posts->the_post();

                                    $prop_id = get_the_ID();
                                    $gallery = get_post_meta($prop_id, 'property_gallery', true);
                                    $images = explode("~~~", $gallery);
                                    $reales_general_settings = get_option('reales_general_settings');
                                    $currency = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
                                    $currency_pos = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
                                    $price_label = get_post_meta($prop_id, 'property_price_label', true);
                                    $address = get_post_meta($prop_id, 'property_address', true);
                                    $city = get_post_meta($prop_id, 'property_city', true);
                                    $state = get_post_meta($prop_id, 'property_state', true);
                                    $neighborhood = get_post_meta($prop_id, 'property_neighborhood', true);
                                    $zip = get_post_meta($prop_id, 'property_zip', true);
                                    $country = get_post_meta($prop_id, 'property_country', true);
                                    $category = wp_get_post_terms($prop_id, 'property_category');
                                    $type = wp_get_post_terms($prop_id, 'property_type_category');
                                    $bedrooms = get_post_meta($prop_id, 'property_bedrooms', true);
                                    $bathrooms = get_post_meta($prop_id, 'property_bathrooms', true);
                                    $area = get_post_meta($prop_id, 'property_area', true);
                                    $unit = isset($reales_general_settings['reales_unit_field']) ? $reales_general_settings['reales_unit_field'] : '';
                                    $featured = get_post_meta($prop_id, 'property_featured', true);

                                    $locale = isset($reales_general_settings['reales_locale_field']) ? $reales_general_settings['reales_locale_field'] : '';
                                    $decimals = isset($reales_general_settings['reales_decimals_field']) ? $reales_general_settings['reales_decimals_field'] : '';
                                    $price = get_post_meta($prop_id, 'property_price', true);
                                    setlocale(LC_MONETARY, $locale);
                                    if (is_numeric($price)) {
                                        if ($decimals == 1) {
                                            $price = money_format('%!i', $price);
                                        } else {
                                            $price = money_format('%!.0i', $price);
                                        }
                                    } else {
                                        $price_label = '';
                                        $currency = '';
                                    }

                                    if (isset($images[1])) {
                                        if (function_exists('aq_resize')) {
                                            $thumb = aq_resize($images[1], 600, 400, true);
                                            if ($thumb == false) {
                                                $thumb = $images[1];
                                            }
                                        } else {
                                            $thumb = $images[1];
                                        }
                                    } else {
                                        $thumb = get_template_directory_uri() . '/images/default-image-600x400.jpg';
                                    }
                            ?>

                                    <?php if ($nomap != '1') { ?>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <?php } else { ?>
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                            <?php } ?>
                                            <?php if ($card_type == 'd2') { ?>
                                                <a href="<?php echo esc_url(get_permalink($prop_id)); ?>" class="card-2" id="card-<?php echo esc_attr($prop_id); ?>" data-prop="<?php echo esc_attr($prop_id); ?>">
                                                    <div id="card-carousel-<?php echo esc_attr($prop_id); ?>" class="carousel slide" data-ride="carousel" data-interval="false">
                                                        <ol class="carousel-indicators">
                                                            <?php
                                                            if (count($images) > 2) {
                                                                for ($i = 1; $i < count($images); $i++) {
                                                                    $active_class = '';
                                                                    if ($i == 1) {
                                                                        $active_class = 'active';
                                                                    }

                                                                    if ($i <= 5) {
                                                            ?>
                                                                        <li data-target="#card-carousel-<?php echo esc_attr($prop_id); ?>" data-slide-to="<?php echo esc_attr($i - 1); ?>" class="<?php echo esc_attr($active_class); ?>"></li>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </ol>

                                                        <div class="carousel-inner" role="listbox">
                                                            <?php
                                                            if (count($images) > 1) {
                                                                for ($i = 1; $i < count($images); $i++) {

                                                                    $active_slide_class = '';
                                                                    if ($i == 1) {
                                                                        $active_slide_class = 'active';
                                                                    }

                                                                    if (function_exists('aq_resize')) {
                                                                        $slide_img = aq_resize($images[$i], 600, 400, true);
                                                                        if ($slide_img == false) {
                                                                            $slide_img = $images[$i];
                                                                        }
                                                                    } else {
                                                                        $slide_img = $images[$i];
                                                                    }

                                                                    if ($i <= 5) {
                                                            ?>
                                                                        <div class="item <?php echo esc_attr($active_slide_class); ?>" style="background-image: url(<?php echo esc_url($slide_img); ?>)"></div>
                                                                <?php
                                                                    }
                                                                }
                                                            } else {
                                                                ?>
                                                                <div class="item active" style="background-image: url(<?php echo esc_url(get_template_directory_uri() . '/images/default-image-600x400.jpg'); ?>)"></div>
                                                            <?php } ?>
                                                        </div>

                                                        <?php if (count($images) > 2) { ?>
                                                            <span class="left carousel-control" href="#card-carousel-<?php echo esc_attr($prop_id); ?>" role="button" data-slide="prev">
                                                                <span class="fa fa-angle-left" aria-hidden="true"></span>
                                                            </span>
                                                            <span class="right carousel-control" href="#card-carousel-<?php echo esc_attr($prop_id); ?>" role="button" data-slide="next">
                                                                <span class="fa fa-angle-right" aria-hidden="true"></span>
                                                            </span>
                                                        <?php } ?>

                                                        <?php if ($featured == 1) { ?>
                                                            <div class="featured-label"><?php esc_html_e('Featured', 'realeswp'); ?></div>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="property-labels">
                                                        <?php
                                                        if ($type) {
                                                            $type_color = get_term_meta($type[0]->term_id, 'property_type_category_color', true);

                                                            if ($type_color == '') {
                                                                if ($prop_type_badge_bg != '') {
                                                                    $p_type_color = $prop_type_badge_bg;
                                                                } else {
                                                                    $p_type_color = '#eab134';
                                                                }
                                                            } else {
                                                                $p_type_color = $type_color;
                                                            }
                                                        ?>

                                                            <div class="property-labels-type" style="background-color: <?php echo esc_attr($p_type_color); ?>"><?php echo esc_html($type[0]->name); ?></div>
                                                        <?php } ?>
                                                        <?php if ($category) { ?>
                                                            <div class="property-labels-category"><?php echo esc_html($category[0]->name); ?></div>
                                                        <?php } ?>
                                                    </div>
                                                    <h3><?php the_title(); ?></h3>
                                                    <div class="property-address">
                                                        <?php
                                                        if ($address != '') {
                                                            echo esc_html($address) . ', ';
                                                        }

                                                        if ($neighborhood != '') {
                                                            echo esc_html($neighborhood) . ', ';
                                                        }

                                                        $p_city_t = isset($reales_prop_fields_settings['reales_p_city_t_field']) ? $reales_prop_fields_settings['reales_p_city_t_field'] : '';

                                                        if ($city != '') {
                                                            if ($p_city_t == 'list') {
                                                                $reales_cities_settings = get_option('reales_cities_settings');
                                                                if (is_array($reales_cities_settings) && count($reales_cities_settings) > 0) {
                                                                    uasort($reales_cities_settings, "reales_compare_position");
                                                                    foreach ($reales_cities_settings as $key => $value) {
                                                                        if ($city == $key) {
                                                                            $city = $value['name'];
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            echo esc_html($city);
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="property-price">
                                                        <?php if ($currency_pos == 'before') { ?>
                                                            <?php echo esc_html($currency) . esc_html($price); ?>&nbsp;<span><?php echo esc_html($price_label); ?></span>
                                                        <?php } else { ?>
                                                            <?php echo esc_html($price) . esc_html($currency); ?>&nbsp;<span><?php echo esc_html($price_label); ?></span>
                                                        <?php } ?>
                                                    </div>
                                                    <ul class="property-features">
                                                        <?php if ($bedrooms !== '') { ?>
                                                            <li><span class="fa fa-bed"></span> <?php echo esc_html($bedrooms); ?></li>
                                                        <?php } ?>
                                                        <?php if ($bathrooms !== '') { ?>
                                                            <li><span class="fa fa-bath"></span> <?php echo esc_html($bathrooms); ?></li>
                                                        <?php } ?>
                                                        <?php if ($area !== '') { ?>
                                                            <li><span class="fa fa-th"></span> <?php echo esc_html($area) . ' ' . esc_html($unit); ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo esc_url(get_permalink($prop_id)); ?>" class="card" id="card-<?php echo esc_attr($prop_id); ?>" data-prop="<?php echo esc_attr($prop_id); ?>">
                                                    <div class="figure">
                                                        <?php if ($featured == 1) { ?>
                                                            <div class="featured-label">
                                                                <div class="featured-label-left"></div>
                                                                <div class="featured-label-content"><span class="fa fa-star"></span></div>
                                                                <div class="featured-label-right"></div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="img" style="background-image:url(<?php echo esc_url($thumb); ?>);"></div>
                                                        <div class="figCaption">
                                                            <?php if ($currency_pos == 'before') { ?>
                                                                <div><?php echo esc_html($currency) . esc_html($price) . ' ' . esc_html($price_label); ?></div>
                                                            <?php } else { ?>
                                                                <div><?php echo esc_html($price) . esc_html($currency) . ' ' . esc_html($price_label); ?></div>
                                                            <?php } ?>
                                                            <span><span class="icon-eye"></span> <?php echo esc_html(reales_get_post_views($prop_id, '')); ?></span>
                                                            <?php
                                                            $favs = reales_get_favourites_count($prop_id);
                                                            ?>
                                                            <span><span class="icon-heart"></span> <?php echo esc_html($favs); ?></span>
                                                            <span><span class="icon-bubble"></span> <?php comments_number('0', '1', '%'); ?></span>
                                                        </div>
                                                        <div class="figView"><span class="icon-eye"></span></div>

                                                        <?php
                                                        if ($type) {
                                                            $type_color = get_term_meta($type[0]->term_id, 'property_type_category_color', true);

                                                            if ($type_color == '') {
                                                                if ($prop_type_badge_bg != '') {
                                                                    $p_type_color = $prop_type_badge_bg;
                                                                } else {
                                                                    $p_type_color = '#eab134';
                                                                }
                                                            } else {
                                                                $p_type_color = $type_color;
                                                            }
                                                        ?>

                                                            <div class="figType" style="background-color: <?php echo esc_attr($p_type_color); ?>"><?php echo esc_html($type[0]->name); ?></div>
                                                        <?php } ?>
                                                    </div>
                                                    <h2><?php the_title(); ?></h2>
                                                    <div class="cardAddress">
                                                        <?php
                                                        if ($address != '') {
                                                            echo esc_html($address) . ', ';
                                                        }
                                                        if ($neighborhood != '') {
                                                            echo esc_html($neighborhood) . ', ';
                                                        }
                                                        $p_city_t = isset($reales_prop_fields_settings['reales_p_city_t_field']) ? $reales_prop_fields_settings['reales_p_city_t_field'] : '';
                                                        if ($city != '') {
                                                            if ($p_city_t == 'list') {
                                                                $reales_cities_settings = get_option('reales_cities_settings');
                                                                if (is_array($reales_cities_settings) && count($reales_cities_settings) > 0) {
                                                                    uasort($reales_cities_settings, "reales_compare_position");
                                                                    foreach ($reales_cities_settings as $key => $value) {
                                                                        if ($city == $key) {
                                                                            $city = $value['name'];
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            echo esc_html($city);
                                                        }
                                                        if ($address != '' || $neighborhood != '' || $city != '') {
                                                            echo '<br />';
                                                        }
                                                        if ($state != '') {
                                                            echo esc_html($state) . ', ';
                                                        }
                                                        if ($zip != '') {
                                                            echo esc_html($zip) . ', ';
                                                        }
                                                        echo esc_html($country);
                                                        ?>
                                                    </div>
                                                    <ul class="cardFeat">
                                                        <?php if ($bedrooms !== '') { ?>
                                                            <li><span class="fa fa-moon-o"></span> <?php echo esc_html($bedrooms); ?></li>
                                                        <?php } ?>
                                                        <?php if ($bathrooms !== '') { ?>
                                                            <li><span class="icon-drop"></span> <?php echo esc_html($bathrooms); ?></li>
                                                        <?php } ?>
                                                        <?php if ($area !== '') { ?>
                                                            <li><span class="icon-frame"></span> <?php echo esc_html($area) . ' ' . esc_html($unit); ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </a>
                                            <?php } ?>
                                            </div>
                                        <?php
                                    }
                                } else {
                                        ?>
                                        <div style="height: 300px; text-align: center;">
                                            <h1>
                                                Sorry for the inconvenience
                                            </h1><?php echo do_shortcode('[popup_anything id="1090"]'); ?>
                                        </div>
                                    <?php } ?>
                                        </div>
                                        <div class="pull-left">
                                            <?php reales_pagination($searched_posts->max_num_pages); ?>
                                        </div>
                                        <div class="pull-right search_prop_calc">
                                            <?php
                                            $reales_appearance_settings = get_option('reales_appearance_settings');
                                            $per_p_field = isset($reales_appearance_settings['reales_properties_per_page_field']) ? $reales_appearance_settings['reales_properties_per_page_field'] : '';
                                            $per_p = $per_p_field != '' ? intval($per_p_field) : 10;
                                            $page_no = (get_query_var('paged')) ? get_query_var('paged') : 1;

                                            $from_p = ($page_no == 1) ? 1 : $per_p * ($page_no - 1) + 1;
                                            $to_p = ($total_p - ($page_no - 1) * $per_p > $per_p) ? $per_p * $page_no : $total_p;
                                            echo esc_html($from_p) . ' - ' . esc_html($to_p) . __(' of ', 'realeswp') . esc_html($total_p) . __(' Properties found', 'realeswp');
                                            ?>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                        <div class="page-bottom-content">
                                            <?php 
                                                echo do_shortcode(get_the_content(null, false, $page_id)); 
                                            ?>
                                            <?php
                                            $args = array(
                                                'post_type' => 'post',
                                                'post_status' => 'publish',
                                                'ID' => $page_id,   // id of the post you want to query
                                            );
                                            $my_posts = new WP_Query($args);
                                            while( have_posts( )) : 
                                                the_post();
                                                if(comments_open() || get_comments_number()) {
                                                    print '<div class="comments">';
                                                    comments_template();
                                                    print '</div>';
                                                } 
                                            endwhile;
                                            wp_reset_query();
                                            ?>
                                        </div>
                                        
                        </div>

                        <?php
                        if ($nomap != '1') {
                            get_template_part('templates/mapview_footer');
                        ?>
                    </div>
                <?php } else { ?>
                    </div>
                </div>
            <?php } ?>

            </div>

            <div class="modal fade" id="save-search-modal" role="dialog" aria-labelledby="save-search-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-close"></span></button>
                            <h4 class="modal-title" id="save-search-label"><?php esc_html_e('Save Search', 'realeswp') ?></h4>
                        </div>
                        <div class="modal-body">
                            <form id="save-search-form">
                                <div class="save-search-message" id="save-search-message"></div>
                                <div class="form-group">
                                    <label for="save-search-name"><?php esc_html_e('Name', 'realeswp'); ?></label>
                                    <input type="text" id="save-search-name" name="save-search-name" placeholder="<?php esc_html_e('Enter a name for your search', 'realeswp'); ?>" class="form-control">
                                    <?php $current_user = wp_get_current_user(); ?>
                                    <input type="hidden" id="save-search-user" name="save-search-user" value="<?php echo esc_attr($current_user->ID); ?>">
                                </div>
                                <?php wp_nonce_field('savesearch_ajax_nonce', 'securitySaveSearch', true); ?>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-gray"><?php esc_html_e('Cancel', 'realeswp'); ?></a>
                            <a href="javascript:void(0);" class="btn btn-green" id="save-search-btn"><?php esc_html_e('Save', 'realeswp'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($nomap != '1') {
                get_template_part('templates/app_footer');
            } else {
                get_footer();
            }
            ?>