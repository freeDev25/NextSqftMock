<?php
/*
Template Name: Favourite Properties
*/

/**
 * @package WordPress
 * @subpackage Reales
 */


$current_user = wp_get_current_user();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

global $post;
get_header();

$reales_appearance_settings = get_option('reales_appearance_settings','');
$show_bc                    = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';
$map_position               = isset($reales_appearance_settings['reales_map_position_field']) ? $reales_appearance_settings['reales_map_position_field'] : '';
$mobile_first               = isset($reales_appearance_settings['reales_mobile_first_field']) ? $reales_appearance_settings['reales_mobile_first_field'] : '';
$leftside_menu              = isset($reales_appearance_settings['reales_leftside_menu_field']) ? $reales_appearance_settings['reales_leftside_menu_field'] : '';

$cards_design_settings = get_option('reales_prop_cards_design_settings', '');
$card_type             = isset($cards_design_settings['card_type']) ? $cards_design_settings['card_type'] : '';

$content_white_class = '';
if($card_type == 'd2') {
    $content_white_class = 'has-white-bg';
}

$map_class = '';
$content_class = '';
if($map_position == 'right') {
    $map_class = 'map-is-right';

    if($leftside_menu == '1') {
        $content_class = 'content-is-left has-left-menu';
    } else {
        $content_class = 'content-is-left';
    }
}

$map_mobile_class = '';
$content_mobile_class = '';
if($mobile_first == 'list') {
    $map_mobile_class = 'mob-min';
    $content_mobile_class = 'mob-max';
}

$reales_colors_settings = get_option('reales_colors_settings');
$prop_type_badge_bg     = isset($reales_colors_settings['reales_prop_type_badge_bg_field']) ? $reales_colors_settings['reales_prop_type_badge_bg_field'] : '';

$searched_posts = reales_search_fav_properties($current_user->ID);
if($searched_posts) {
    $total_p = $searched_posts->found_posts;
} else {
    $total_p = 0;
}
$users = get_users();
?>

<div id="wrapper">

    <div id="mapFavView" class="<?php echo esc_attr($map_class); ?> <?php echo esc_attr($map_mobile_class); ?>">
        <div class="mapPlaceholder"><span class="fa fa-spin fa-spinner"></span> <?php esc_html_e('Loading map...', 'realeswp'); ?></div>
    </div>
    <?php wp_nonce_field('app_map_ajax_nonce', 'securityAppMap', true); ?>
    <div id="content" class="<?php echo esc_attr($content_class); ?> <?php echo esc_attr($content_mobile_class); ?> <?php echo esc_attr($content_white_class); ?>">
        <?php get_template_part('templates/city_form'); ?>
        <div class="resultsList">
            <?php if($show_bc != '') {
                reales_breadcrumbs();
            } ?>
            <h1 class="pull-left"><?php echo esc_html($post->post_title); ?></h1>
            <input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>">
            <div class="pull-right search_prop_calc_top"><?php echo esc_html($total_p . __(' Properties found', 'realeswp')); ?></div>
            <div class="clearfix"></div>
            <div class="row">
            <?php
            if($searched_posts) {
                while ( $searched_posts->have_posts() ) {
                    $searched_posts->the_post();
                    $prop_id = get_the_ID();

                    $gallery                 = get_post_meta($prop_id, 'property_gallery', true);
                    $images                  = explode("~~~", $gallery);
                    $reales_general_settings = get_option('reales_general_settings');
                    $currency                = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
                    $currency_pos            = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
                    $price_label             = get_post_meta($prop_id, 'property_price_label', true);
                    $address                 = get_post_meta($prop_id, 'property_address', true);
                    $city                    = get_post_meta($prop_id, 'property_city', true);
                    $state                   = get_post_meta($prop_id, 'property_state', true);
                    $neighborhood            = get_post_meta($prop_id, 'property_neighborhood', true);
                    $zip                     = get_post_meta($prop_id, 'property_zip', true);
                    $country                 = get_post_meta($prop_id, 'property_country', true);
                    $category                = wp_get_post_terms($prop_id, 'property_category');
                    $type                    = wp_get_post_terms($prop_id, 'property_type_category');
                    $bedrooms                = get_post_meta($prop_id, 'property_bedrooms', true);
                    $bathrooms               = get_post_meta($prop_id, 'property_bathrooms', true);
                    $area                    = get_post_meta($prop_id, 'property_area', true);
                    $unit                    = isset($reales_general_settings['reales_unit_field']) ? $reales_general_settings['reales_unit_field'] : '';
                    $featured                = get_post_meta($prop_id, 'property_featured', true);

                    $locale = isset($reales_general_settings['reales_locale_field']) ? $reales_general_settings['reales_locale_field'] : '';
                    $decimals = isset($reales_general_settings['reales_decimals_field']) ? $reales_general_settings['reales_decimals_field'] : '';
                    $price = get_post_meta($prop_id, 'property_price', true);
                    setlocale(LC_MONETARY, $locale);
                    if(is_numeric($price)) {
                        if($decimals == 1) {
                            $price = money_format('%!i', $price);
                        } else {
                            $price = money_format('%!.0i', $price);
                        }
                    } else {
                        $price_label = '';
                        $currency = '';
                    }

                    if(isset($images[1])) {
                        if(function_exists('aq_resize')) {
                            $thumb = aq_resize($images[1], 600, 400, true);
                            if($thumb == false) {
                                $thumb = $images[1];
                            }
                        } else {
                            $thumb = $images[1];
                        }
                    } else {
                        $thumb = get_template_directory_uri() . '/images/default-image-600x400.jpg';
                    }
                ?>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <?php if($card_type == 'd2') { ?>
                            <a href="<?php echo esc_url(get_permalink($prop_id)); ?>" class="card-2" id="card-<?php echo esc_attr($prop_id); ?>" data-prop="<?php echo esc_attr($prop_id); ?>">
                                <div id="card-carousel-<?php echo esc_attr($prop_id); ?>" class="carousel slide" data-ride="carousel" data-interval="false">
                                    <ol class="carousel-indicators">
                                        <?php if(count($images) > 2) {
                                            for($i = 1; $i < count($images); $i++) { 
                                                $active_class = '';
                                                if($i == 1) {
                                                    $active_class = 'active';
                                                }

                                                if($i <= 5) { ?>
                                                    <li data-target="#card-carousel-<?php echo esc_attr($prop_id); ?>" data-slide-to="<?php echo esc_attr($i - 1); ?>" class="<?php echo esc_attr($active_class); ?>"></li>
                                                <?php }
                                            }
                                        } ?>
                                    </ol>

                                    <div class="carousel-inner" role="listbox">
                                        <?php if(count($images) > 1) {
                                            for($i = 1; $i < count($images); $i++) { 

                                                $active_slide_class = '';
                                                if($i == 1) {
                                                    $active_slide_class = 'active';
                                                }

                                                if(function_exists('aq_resize')) {
                                                    $slide_img = aq_resize($images[$i], 600, 400, true);
                                                    if($slide_img == false) {
                                                        $slide_img = $images[$i];
                                                    }
                                                } else {
                                                    $slide_img = $images[$i];
                                                }

                                                if($i <= 5) { ?>
                                                    <div class="item <?php echo esc_attr($active_slide_class); ?>" style="background-image: url(<?php echo esc_url($slide_img); ?>)"></div>
                                                <?php }
                                            } 
                                        } else { ?>
                                            <div class="item active" style="background-image: url(<?php echo esc_url(get_template_directory_uri() . '/images/default-image-600x400.jpg'); ?>)"></div>
                                        <?php } ?>
                                    </div>

                                    <?php if(count($images) > 2) { ?>
                                        <span class="left carousel-control" href="#card-carousel-<?php echo esc_attr($prop_id); ?>" role="button" data-slide="prev">
                                            <span class="fa fa-angle-left" aria-hidden="true"></span>
                                        </span>
                                        <span class="right carousel-control" href="#card-carousel-<?php echo esc_attr($prop_id); ?>" role="button" data-slide="next">
                                            <span class="fa fa-angle-right" aria-hidden="true"></span>
                                        </span>
                                    <?php } ?>

                                    <?php if($featured == 1) { ?>
                                        <div class="featured-label"><?php esc_html_e('Featured', 'realeswp'); ?></div>
                                    <?php } ?>
                                </div>

                                <div class="property-labels">
                                    <?php if($type) {
                                        $type_color = get_term_meta($type[0]->term_id, 'property_type_category_color', true);

                                        if($type_color == '') {
                                            if($prop_type_badge_bg != '') {
                                                $p_type_color = $prop_type_badge_bg;
                                            } else {
                                                $p_type_color = '#eab134';
                                            }
                                        } else {
                                            $p_type_color = $type_color;
                                        } ?>

                                        <div class="property-labels-type" style="background-color: <?php echo esc_attr($p_type_color); ?>"><?php echo esc_html($type[0]->name); ?></div>
                                    <?php } ?>
                                    <?php if($category) { ?>
                                        <div class="property-labels-category"><?php echo esc_html($category[0]->name); ?></div>
                                    <?php } ?>
                                </div>
                                <h3><?php the_title(); ?></h3>
                                <div class="property-address">
                                    <?php  if($address != '') {
                                        echo esc_html($address) . ', ';
                                    }

                                    if($neighborhood != '') {
                                        echo esc_html($neighborhood) . ', ';
                                    }

                                    $p_city_t = isset($reales_prop_fields_settings['reales_p_city_t_field']) ? $reales_prop_fields_settings['reales_p_city_t_field'] : '';

                                    if($city != '') {
                                        if($p_city_t == 'list') {
                                            $reales_cities_settings = get_option('reales_cities_settings');
                                            if(is_array($reales_cities_settings) && count($reales_cities_settings) > 0) {
                                                uasort($reales_cities_settings, "reales_compare_position");
                                                foreach ($reales_cities_settings as $key => $value) {
                                                    if ($city == $key) {
                                                        $city = $value['name'];
                                                    }
                                                }
                                            }
                                        }

                                        echo esc_html($city);
                                    } ?>
                                </div>
                                <div class="property-price">
                                    <?php if($currency_pos == 'before') { ?>
                                        <?php echo esc_html($currency) . esc_html($price); ?>&nbsp;<span><?php echo esc_html($price_label); ?></span>
                                    <?php } else { ?>
                                        <?php echo esc_html($price) . esc_html($currency); ?>&nbsp;<span><?php echo esc_html($price_label); ?></span>
                                    <?php } ?>
                                </div>
                                <ul class="property-features">
                                    <?php if($bedrooms !== '') { ?>
                                        <li><span class="fa fa-bed"></span> <?php echo esc_html($bedrooms); ?></li>
                                    <?php } ?>
                                    <?php if($bathrooms !== '') { ?>
                                        <li><span class="fa fa-bath"></span> <?php echo esc_html($bathrooms); ?></li>
                                    <?php } ?>
                                    <?php if($area !== '') { ?>
                                        <li><span class="fa fa-th"></span> <?php echo esc_html($area) . ' ' . esc_html($unit); ?></li>
                                    <?php } ?>
                                </ul>
                                <div class="clearfix"></div>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(get_permalink($prop_id)); ?>" class="card" id="card-<?php echo esc_attr($prop_id); ?>" data-prop="<?php echo esc_attr($prop_id); ?>">
                                <div class="figure">
                                    <?php if($featured == 1) { ?>
                                        <div class="featured-label">
                                            <div class="featured-label-left"></div>
                                            <div class="featured-label-content"><span class="fa fa-star"></span></div>
                                            <div class="featured-label-right"></div>
                                            <div class="clearfix"></div>
                                        </div>
                                    <?php } ?>
                                    <div class="img" style="background-image:url(<?php echo esc_url($thumb); ?>);"></div>
                                    <div class="figCaption">
                                        <?php if($currency_pos == 'before') { ?>
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

                                    <?php if($type) {
                                        $type_color = get_term_meta($type[0]->term_id, 'property_type_category_color', true);

                                        if($type_color == '') {
                                            if($prop_type_badge_bg != '') {
                                                $p_type_color = $prop_type_badge_bg;
                                            } else {
                                                $p_type_color = '#eab134';
                                            }
                                        } else {
                                            $p_type_color = $type_color;
                                        } ?>

                                        <div class="figType" style="background-color: <?php echo esc_attr($p_type_color); ?>"><?php echo esc_html($type[0]->name); ?></div>
                                    <?php } ?>
                                </div>
                                <h2><?php the_title(); ?></h2>
                                <?php
                                $reales_prop_fields_settings = get_option('reales_prop_fields_settings');
                                $p_city_t = isset($reales_prop_fields_settings['reales_p_city_t_field']) ? $reales_prop_fields_settings['reales_p_city_t_field'] : '';

                                if($p_city_t == 'list') {
                                    $reales_cities_settings = get_option('reales_cities_settings');
                                    if(is_array($reales_cities_settings) && count($reales_cities_settings) > 0) {
                                        uasort($reales_cities_settings, "reales_compare_position");
                                        foreach ($reales_cities_settings as $key => $value) {
                                            if ($city == $key) {
                                                $city = $value['name'];
                                            }
                                        }
                                    }
                                }
                                ?>
                                <div class="cardAddress"><?php echo esc_html($address) . ', ' . esc_html($neighborhood) . ', ' . esc_html($city) . '<br />' . esc_html($state) . ' ' . esc_html($zip) . ', ' . esc_html($country); ?></div>
                                <ul class="cardFeat">
                                    <?php if($bedrooms != '') { ?>
                                        <li><span class="fa fa-moon-o"></span> <?php echo esc_html($bedrooms); ?></li>
                                    <?php } ?>
                                    <?php if($bathrooms != '') { ?>
                                        <li><span class="icon-drop"></span> <?php echo esc_html($bathrooms); ?></li>
                                    <?php } ?>
                                    <?php if($area != '') { ?>
                                        <li><span class="icon-frame"></span> <?php echo esc_html($area) . ' ' . esc_html($unit); ?></li>
                                    <?php } ?>
                                </ul>
                                <div class="clearfix"></div>
                            </a>
                        <?php } ?>
                    </div>
                <?php }
            } ?>
            </div>
            <div class="pull-left">
                <?php if($searched_posts) { reales_pagination($searched_posts->max_num_pages); } ?>
            </div>
            <div class="pull-right search_prop_calc">
                <?php
                $reales_appearance_settings = get_option('reales_appearance_settings');
                $per_p_setting = isset($reales_appearance_settings['reales_properties_per_page_field']) ? $reales_appearance_settings['reales_properties_per_page_field'] : '';
                $per_p = $per_p_setting != '' ? intval($per_p_setting) : 10;
                $page_no = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $from_p = ($page_no == 1) ? 1 : $per_p * ($page_no - 1) + 1;
                $to_p = ($total_p - ($page_no - 1) * $per_p > $per_p) ? $per_p * $page_no : $total_p;
                echo esc_html($from_p) . ' - ' . esc_html($to_p) . __(' of ', 'realeswp') . esc_html($total_p) . __(' Properties found', 'realeswp');
                ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <?php get_template_part('templates/mapview_footer'); ?>
    </div>

</div>

<?php
get_template_part('templates/app_footer');
?>