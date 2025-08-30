<?php

/**
 * @package WordPress
 * @subpackage Reales
 */

global $post;
get_header();
$reales_appearance_settings = get_option('reales_appearance_settings', '');
$show_bc                    = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';
$nomap                      = isset($reales_appearance_settings['reales_nomap_field']) ? $reales_appearance_settings['reales_nomap_field'] : '';
$sidebar_position           = isset($reales_appearance_settings['reales_sidebar_field']) ? $reales_appearance_settings['reales_sidebar_field'] : '';
$map_position               = isset($reales_appearance_settings['reales_map_position_field']) ? $reales_appearance_settings['reales_map_position_field'] : '';
$leftside_menu              = isset($reales_appearance_settings['reales_leftside_menu_field']) ? $reales_appearance_settings['reales_leftside_menu_field'] : '';

$cards_design_settings = get_option('reales_prop_cards_design_settings', '');
$card_type             = isset($cards_design_settings['card_type']) ? $cards_design_settings['card_type'] : '';

$reales_colors_settings = get_option('reales_colors_settings');
$prop_type_badge_bg = isset($reales_colors_settings['reales_prop_type_badge_bg_field']) ? $reales_colors_settings['reales_prop_type_badge_bg_field'] : '';

$map_class = '';
$content_class = '';
if ($map_position == 'right') {
    $map_class = 'map-is-right';

    if ($leftside_menu == '1') {
        $content_class = 'content-is-left has-left-menu';
    } else {
        $content_class = 'content-is-left';
    }
} ?>

<?php if ($nomap != '1') {  ?>
    <div id="wrapper">
    <?php } else { ?>
        <div class="single-no-map">
        <?php } ?>

        <?php while (have_posts()) : the_post();
            $prop_id                 = get_the_ID();
            $gallery                 = get_post_meta($prop_id, 'property_gallery', true);
            $images                  = explode("~~~", $gallery);
            $title                   = get_the_title();
            $reales_general_settings = get_option('reales_general_settings');
            $currency                = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
            $currency_pos            = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
            $report                  = isset($reales_general_settings['reales_report_field']) ? $reales_general_settings['reales_report_field'] : '';
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
            $p_info_link             = get_permalink($prop_id);
            $p_info_title            = $title;
            $video_source            = get_post_meta($prop_id, 'property_video_source', true);
            $video_id                = get_post_meta($prop_id, 'property_video_id', true);
            $plans                   = get_post_meta($prop_id, 'property_plans', true);
            $plans_images            = explode("~~~", $plans);
            $featured                = get_post_meta($prop_id, 'property_featured', true);
            $calc                    = get_post_meta($prop_id, 'property_calc', true);

            $locale   = isset($reales_general_settings['reales_locale_field']) ? $reales_general_settings['reales_locale_field'] : '';
            $decimals = isset($reales_general_settings['reales_decimals_field']) ? $reales_general_settings['reales_decimals_field'] : '';
            $price    = get_post_meta($prop_id, 'property_price', true);
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

            if (!isset($images[1])) {
                $images = array('', get_template_directory_uri() . '/images/default-image-800x600.jpg');
            }

            $calc_info                 = array();
            $calc_info['currency_pos'] = $currency_pos;
            $calc_info['currency']     = $currency;
            $calc_info['price']        = get_post_meta($prop_id, 'property_price', true);
            $calc_info['locale']       = $locale;

            reales_set_post_views($prop_id);
        ?>
            <input type="hidden" name="single_id" id="single_id" value="<?php echo esc_attr($prop_id); ?>" />
            <?php if ($nomap == '1') { ?>
                <div id="carouselFull" class="carousel slide gallery" data-ride="carousel" data-interval="false">
                    <?php
                    if ($video_source != '' && $video_id != '') {
                        $gallery_counter = count($images) + 1;
                    } else {
                        $gallery_counter = count($images);
                    }
                    if ($gallery_counter > 2) { ?>
                        <ol class="carousel-indicators">
                            <?php
                            for ($i = 1; $i < $gallery_counter; $i++) {
                                $j = $i - 1;
                                print '<li data-target="#carouselFull" data-slide-to="' . esc_attr($j) . '"';
                                if ($i == 1) print 'class="active"';
                                print ' ></li>';
                            }
                            ?>
                        </ol>
                    <?php } ?>
                    <div class="carousel-inner">
                        <?php
                        if ($video_source != '' && $video_id != '') {
                            print '<div class="item active">';
                            if ($video_source == 'youtube') {
                                print '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . esc_html($video_id) . '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
                            }
                            if ($video_source == 'vimeo') {
                                print '<iframe src="https://player.vimeo.com/video/' . esc_html($video_id) . '?title=0&byline=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                            }
                            print '</div>';
                        }
                        ?>
                        <?php
                        for ($i = 1; $i < count($images); $i++) {
                            print '<a href="' . esc_url($images[$i]) . '" data-fancybox-group="slideshow" class="galleryItem item';
                            if ($i == 1 && ($video_source == '' || $video_id == '')) print ' active';
                            print '" style="background-image: url(' . esc_url($images[$i]) . ')"';
                            print '></a>';
                        }
                        ?>
                    </div>
                    <?php if ($gallery_counter > 2) { ?>
                        <a class="left carousel-control" href="#carouselFull" role="button" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                        <a class="right carousel-control" href="#carouselFull" role="button" data-slide="next"><span class="fa fa-chevron-right"></span></a>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ($nomap != '1') { ?>
                <div id="mapSingleView" class="mob-min <?php echo esc_attr($map_class); ?>">
                    <div class="mapPlaceholder"><span class="fa fa-spin fa-spinner"></span> <?php esc_html_e('Loading map...', 'realeswp'); ?></div>
                </div>
            <?php } ?>
            <?php wp_nonce_field('app_map_ajax_nonce', 'securityAppMap', true); ?>

            <?php if ($nomap != '1') { ?>
                <div id="content" class="mob-max <?php echo esc_attr($content_class); ?>">
                    <?php get_template_part('templates/city_form'); ?>
                <?php } else { ?>
                    <div class="page-wrapper no-map">
                        <div class="page-content">
                        <?php } ?>

                        <?php if ($nomap == '1') { ?>
                            <div class="row">
                                <?php if ($sidebar_position == 'left') { ?>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div id="mapSingleView">
                                            <div class="mapPlaceholder"><span class="fa fa-spin fa-spinner"></span> <?php esc_html_e('Loading map...', 'realeswp'); ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                <?php } ?>

                                <div class="singleTop">
                                    <?php if ($nomap != '1') { ?>
                                        <div id="carouselFull" class="carousel slide gallery" data-ride="carousel" data-interval="false">
                                            <?php
                                            if ($video_source != '' && $video_id != '') {
                                                $gallery_counter = count($images) + 1;
                                            } else {
                                                $gallery_counter = count($images);
                                            }
                                            if ($gallery_counter > 2) { ?>
                                                <ol class="carousel-indicators">
                                                    <?php
                                                    for ($i = 1; $i < $gallery_counter; $i++) {
                                                        $j = $i - 1;
                                                        print '<li data-target="#carouselFull" data-slide-to="' . esc_attr($j) . '"';
                                                        if ($i == 1) print 'class="active"';
                                                        print ' ></li>';
                                                    }
                                                    ?>
                                                </ol>
                                            <?php } ?>
                                            <div class="carousel-inner">
                                                <?php
                                                if ($video_source != '' && $video_id != '') {
                                                    print '<div class="item active">';
                                                    if ($video_source == 'youtube') {
                                                        print '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . esc_html($video_id) . '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
                                                    }
                                                    if ($video_source == 'vimeo') {
                                                        print '<iframe src="https://player.vimeo.com/video/' . esc_html($video_id) . '?title=0&byline=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                                                    }
                                                    print '</div>';
                                                }
                                                ?>
                                                <?php
                                                for ($i = 1; $i < count($images); $i++) {
                                                    print '<a href="' . esc_url($images[$i]) . '" data-fancybox-group="slideshow" class="galleryItem item';
                                                    if ($i == 1 && ($video_source == '' || $video_id == '')) print ' active';
                                                    print '" style="background-image: url(' . esc_url($images[$i]) . ')"';
                                                    print '></a>';
                                                }
                                                ?>
                                            </div>
                                            <?php if ($gallery_counter > 2) { ?>
                                                <a class="left carousel-control" href="#carouselFull" role="button" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                                                <a class="right carousel-control" href="#carouselFull" role="button" data-slide="next"><span class="fa fa-chevron-right"></span></a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <div class="summary">
                                        <div class="row">
                                            <?php
                                            $agent_id = get_post_meta($prop_id, 'property_agent', true);
                                            $agent = get_post($agent_id);

                                            if ($agent_id != '' && isset($agent)) { ?>
                                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                                                <?php } else { ?>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <?php } ?>
                                                    <div class="summaryItem">
                                                        <?php if ($show_bc != '') {
                                                            reales_breadcrumbs();
                                                        } ?>
                                                        <?php if ($featured == 1) { ?>
                                                            <div class="single-featured"><span class="fa fa-star"></span> <?php echo __('Featured', 'realeswp'); ?></div>
                                                            <div class="clearfix"></div>
                                                        <?php } ?>
                                                        <h1 class="pageTitle"><?php echo esc_html($title); ?></h1>

                                                        <?php
                                                        $reales_prop_fields_settings = get_option('reales_prop_fields_settings');
                                                        $p_id = isset($reales_prop_fields_settings['reales_p_id_field']) ? $reales_prop_fields_settings['reales_p_id_field'] : '';
                                                        if ($p_id != '' && $p_id == 'enabled') { ?>
                                                            <div class="property-id"><?php esc_html_e('Property ID', 'realeswp'); ?>: <?php echo esc_html($prop_id); ?></div>
                                                        <?php } ?>

                                                        <div class="address">
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

                                                                echo esc_html($city) . ', ';
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
                                                            if ($country != '') {
                                                                echo esc_html($country);
                                                            }
                                                            ?>
                                                        </div>

                                                        <?php if ($calc == '1') { ?>
                                                            <div class="m-calc-btn"><a href="#modal-calculator" data-toggle="modal" role="button"><span class="fa fa-calculator"></span></a></div>
                                                        <?php } ?>

                                                        <div class="singlePrice">
                                                            <div class="listPrice">
                                                                <?php if ($currency_pos == 'before') {
                                                                    echo esc_html($currency) . esc_html($price) . ' ' . esc_html($price_label);
                                                                } else {
                                                                    echo esc_html($price) . esc_html($currency) . ' ' . esc_html($price_label);
                                                                } ?>

                                                                <?php if ($type) {
                                                                    $type_color = get_term_meta($type[0]->term_id, 'property_type_category_color', true);

                                                                    if ($type_color == '') {
                                                                        if ($prop_type_badge_bg != '') {
                                                                            $p_type_color = $prop_type_badge_bg;
                                                                        } else {
                                                                            $p_type_color = '#eab134';
                                                                        }
                                                                    } else {
                                                                        $p_type_color = $type_color;
                                                                    } ?>
                                                                    <span class="label label-yellow" style="background-color: <?php echo esc_attr($p_type_color); ?>"><?php echo esc_html($type[0]->name); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="listCategory">
                                                                <?php if ($category) {
                                                                    echo esc_html($category[0]->name);
                                                                } ?>
                                                            </div>
                                                        </div>

                                                        <ul class="stats">
                                                            <li><span class="icon-eye"></span> <?php echo esc_html(reales_get_post_views($prop_id, '')); ?></li>
                                                            <li><span class="icon-bubble"></span> <?php echo esc_html(number_format_i18n(get_comments_number())); ?></li>
                                                        </ul>
                                                        <?php if ($report == '1') { ?>
                                                            <div class="reportLink">
                                                                <a data-toggle="modal" href="#reportProperty" title="<?php esc_attr_e('Report this property listing', 'realeswp'); ?>"><span class="icon-flag"></span></a>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="printLink">
                                                            <a href="#" id="printProperty" data-id="<?php echo esc_attr($prop_id); ?>" title="<?php esc_html_e('Print the property page', 'realeswp') ?>"><span class="icon-printer"></span></a>
                                                            <?php wp_nonce_field('print_ajax_nonce', 'securityPrintProperty', true); ?>
                                                        </div>
                                                        <div class="favLink">
                                                            <?php
                                                            $user = wp_get_current_user();
                                                            $fav = get_user_meta($user->ID, 'property_fav', true);
                                                            $favs = reales_get_favourites_count($prop_id);

                                                            if ($fav != '') {
                                                                if (is_user_logged_in()) {
                                                                    if (in_array($prop_id, $fav) === false) {
                                                                        print '<a id="favBtn" href="javascript:void(0);" class="addFav"><span class="fa fa-heart-o"></span></a><span class="fav_no">' . esc_html($favs) . '</span>';
                                                                    } else {
                                                                        print '<a id="favBtn" href="javascript:void(0);" class="addedFav"><span class="fa fa-heart"></span></a><span class="fav_no">' . esc_html($favs) . '</span>';
                                                                    }
                                                                } else {
                                                                    print '<a id="favBtn" href="javascript:void(0);" data-toggle="modal" data-target="#signin" class="noSigned"><span class="fa fa-heart-o"></span></a><span class="fav_no">' . esc_html($favs) . '</span>';
                                                                }
                                                            } else {
                                                                if (is_user_logged_in()) {
                                                                    print '<a id="favBtn" href="javascript:void(0);" class="addFav"><span class="fa fa-heart-o"></span></a><span class="fav_no">' . esc_html($favs) . '</span>';
                                                                } else {
                                                                    print '<a id="favBtn" href="javascript:void(0);" data-toggle="modal" data-target="#signin" class="noSigned"><span class="fa fa-heart-o"></span></a><span class="fav_no">' . esc_html($favs) . '</span>';
                                                                }
                                                            }
                                                            wp_nonce_field('fav_ajax_nonce', 'securityFav', true);
                                                            ?>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                        <ul class="features">
                                                            <?php if ($bedrooms != '') {
                                                                $beds = floatval($bedrooms);
                                                                $beds_label = ($beds > 1) ? __('Bedrooms', 'realeswp') : __('Bedroom', 'realeswp');

                                                                if ($card_type == 'd2') { ?>
                                                                    <li><span class="fa fa-bed"></span>
                                                                        <div><?php echo esc_html($bedrooms) . ' ' . $beds_label; ?></div>
                                                                    </li>
                                                                <?php } else { ?>
                                                                    <li><span class="fa fa-moon-o"></span>
                                                                        <div><?php echo esc_html($bedrooms) . ' ' . $beds_label; ?></div>
                                                                    </li>
                                                            <?php }
                                                            } ?>

                                                            <?php if ($bathrooms != '') {
                                                                $baths = floatval($bathrooms);
                                                                $baths_label = ($baths > 1) ? __('Bathrooms', 'realeswp') : __('Bathroom', 'realeswp');

                                                                if ($card_type == 'd2') { ?>
                                                                    <li><span class="fa fa-bath"></span>
                                                                        <div><?php echo esc_html($bathrooms) . ' ' . $baths_label; ?></div>
                                                                    </li>
                                                                <?php } else { ?>
                                                                    <li><span class="icon-drop"></span>
                                                                        <div><?php echo esc_html($bathrooms) . ' ' . $baths_label; ?></div>
                                                                    </li>
                                                            <?php }
                                                            } ?>

                                                            <?php if ($area != '') {
                                                                if ($card_type == 'd2') { ?>
                                                                    <li><span class="fa fa-th"></span>
                                                                        <div><?php echo esc_html($area) . ' ' . esc_html($unit); ?></div>
                                                                    </li>
                                                                <?php } else { ?>
                                                                    <li><span class="icon-frame"></span>
                                                                        <div><?php echo esc_html($area) . ' ' . esc_html($unit); ?></div>
                                                                    </li>
                                                            <?php }
                                                            } ?>
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    </div>


                                                    <?php
                                                    if ($agent_id != '') {
                                                        $agent = get_post($agent_id);

                                                        if (isset($agent)) {

                                                            $agent_avatar = get_post_meta($agent_id, 'agent_avatar', true);
                                                            $agent_email = get_post_meta($agent_id, 'agent_email', true);
                                                            $agent_user = get_post_meta($agent_id, 'agent_user', true);

                                                            if ($agent_avatar != '') {
                                                                $avatar = $agent_avatar;
                                                            } else {
                                                                $avatar = get_template_directory_uri() . '/images/avatar.png';
                                                            } ?>

                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="agentAvatar summaryItem">
                                                                    <div class="clearfix"></div>
                                                                    <a href="#"><img class="avatar agentAvatarImg" src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($agent->post_title); ?>"></a>
                                                                    <div class="agentName"><?php echo esc_html($agent->post_title); ?></div>
                                                                    <?php if (is_user_logged_in()) {
                                                                        $current_user = wp_get_current_user();

                                                                        if ($agent_user == $current_user->ID) {
                                                                            $args = array(
                                                                                'post_type' => 'page',
                                                                                'post_status' => 'publish',
                                                                                'meta_key' => '_wp_page_template',
                                                                                'meta_value' => 'submit-property.php'
                                                                            );

                                                                            $query = new WP_Query($args);

                                                                            while ($query->have_posts()) {
                                                                                $query->the_post();
                                                                                $page_id = get_the_ID();
                                                                                $page_link = get_permalink($page_id);
                                                                            }
                                                                            wp_reset_postdata();
                                                                            wp_reset_query(); ?>
                                                                            <a href="<?php echo esc_url($page_link) . '?edit_id=' . esc_attr($prop_id); ?>" class="btn btn-green contactBtn"><span class="icon-pencil"></span> <?php esc_html_e('Edit Property', 'realeswp'); ?></a>
                                                                        <?php } else { ?>
                                                                            <a data-toggle="modal" href="#contactAgent" data-agent-id="<?php echo $agent->ID; ?>" data-post-id="<?php echo get_the_ID(); ?>" class="btn btn-green contactBtn"><?php esc_html_e('Contact Seller', 'realeswp'); ?></a>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <a data-toggle="modal" href="#contactAgent" data-agent-id="<?php echo $agent->ID; ?>" data-post-id="<?php echo get_the_ID(); ?>" class="btn btn-green contactBtn"><?php esc_html_e('Contact Seller', 'realeswp'); ?></a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                        </div>
                                    </div>

                                    <?php $description = get_the_content();
                                    if ($description != '') { ?>
                                        <div class="description">
                                            <h3><?php esc_html_e('Description', 'realeswp'); ?></h3>
                                            <div class="entry-content">
                                                <?php the_content(); ?>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="share">
                                        <h3><?php esc_html_e('Share property', 'realeswp'); ?></h3>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" title="<?php esc_html_e('Share on Facebook', 'realeswp'); ?>" class="btn btn-sm btn-o btn-facebook">
                                            <span class="fa fa-facebook"></span> <?php esc_html_e('Facebook', 'realeswp'); ?>
                                        </a>
                                        <a href="https://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" title="<?php esc_html_e('Share on Twitter', 'realeswp'); ?>" class="btn btn-sm btn-o btn-twitter">
                                            <span class="fa fa-twitter"></span> <?php esc_html_e('Twitter', 'realeswp'); ?>
                                        </a>
                                        <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
                                            target="_blank" title="<?php esc_html_e('Share on Google+', 'realeswp'); ?>" class="btn btn-sm btn-o btn-google">
                                            <span class="fa fa-google-plus"></span> <?php esc_html_e('Google+', 'realeswp'); ?>
                                        </a>
                                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                            title="<?php esc_html_e('Share on LinkedIn', 'realeswp'); ?>" class="btn btn-sm btn-o btn-linkedin" target="_blank">
                                            <span class="fa fa-linkedin"></span> <?php esc_html_e('LinkedIn', 'realeswp'); ?>
                                        </a>
                                    </div>

                                    <div class="amenities">
                                        <?php
                                        $reales_amenity_settings = get_option('reales_amenity_settings');

                                        if (is_array($reales_amenity_settings) && count($reales_amenity_settings) > 0) { ?>
                                            <h3><?php esc_html_e('Amenities', 'realeswp'); ?></h3>
                                        <?php
                                            uasort($reales_amenity_settings, "reales_compare_position");
                                            $amenities_count = 0;
                                            print '<div class="row">';
                                            foreach ($reales_amenity_settings as $key => $value) {
                                                $am_label = $value['label'];
                                                if (function_exists('icl_translate')) {
                                                    $am_label = icl_translate('realeswp', 'reales_property_amenity_' . $value['label'], $value['label']);
                                                }

                                                if (get_post_meta($prop_id, $key, true) == 1) {
                                                    print '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 amItem active">';
                                                    print '<span class="' . esc_html($value['icon']) . '"></span> ' . esc_html($am_label) . '</div>';
                                                    $amenities_count++;
                                                }
                                            }
                                            if ($amenities_count == 0) {
                                                print '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 amItem">';
                                                esc_html_e('No amenities.', 'realeswp');
                                                print '</div>';
                                            }
                                            print '</div>';
                                        }
                                        ?>
                                    </div>

                                    <?php if (count($plans_images) > 1) { ?>
                                        <div class="floorPlans">
                                            <h3><?php esc_html_e('Floor Plans', 'realeswp'); ?></h3>
                                            <div class="row">
                                                <?php
                                                for ($i = 1; $i < count($plans_images); $i++) {
                                                    print '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">';
                                                    print '<a class="plan" href="' . esc_url($plans_images[$i]) . '" data-fancybox-group="floorplans">';
                                                    print '<img src="' . esc_url($plans_images[$i]) . '">';
                                                    print '</a>';
                                                    print '</div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="additional">
                                        <?php
                                        $reales_fields_settings = get_option('reales_fields_settings');

                                        if (is_array($reales_fields_settings)) { ?>
                                            <h3><?php esc_html_e('Additional Information', 'realeswp'); ?></h3>
                                        <?php
                                            uasort($reales_fields_settings, "reales_compare_position");
                                            $fields_no = 0;
                                            print '<div class="row">';
                                            foreach ($reales_fields_settings as $key => $value) {
                                                $cf_label = $value['label'];
                                                if (function_exists('icl_translate')) {
                                                    $cf_label = icl_translate('realeswp', 'reales_property_field_' . $value['label'], $value['label']);
                                                }

                                                $field_value = get_post_meta($prop_id, $key, true);
                                                if ($field_value != '') {
                                                    print '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 amItem">';
                                                    if ($value['type'] == 'list_field') {
                                                        $list = explode(',', $value['list']);
                                                        print '<strong>' . esc_html($cf_label) . '</strong>:' . ' ' . esc_html($list[$field_value]);
                                                    } else {
                                                        print '<strong>' . esc_html($cf_label) . '</strong>:' . ' ' . esc_html($field_value);
                                                    }
                                                    print '</div>';
                                                    $fields_no++;
                                                }
                                            }
                                            if ($fields_no == 0) {
                                                print '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 amItem">';
                                                esc_html_e('No additional information.', 'realeswp');
                                                print '</div>';
                                            }
                                            print '</div>';
                                        } ?>
                                    </div>

                                    <?php
                                    $reales_appearance_settings = get_option('reales_appearance_settings');
                                    $similar = isset($reales_appearance_settings['reales_similar_field']) ? $reales_appearance_settings['reales_similar_field'] : false;
                                    if ($similar) {
                                        get_template_part('templates/similar_properties');
                                    }
                                    ?>

                                    <?php if (comments_open() || get_comments_number()) {
                                        print '<div class="comments">';
                                        comments_template();
                                        print '</div>';
                                    } ?>

                                    <?php if ($nomap == '1') { ?>
                                </div>
                                <?php if ($sidebar_position == 'right') { ?>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div id="mapSingleView">
                                            <div class="mapPlaceholder"><span class="fa fa-spin fa-spinner"></span> <?php esc_html_e('Loading map...', 'realeswp'); ?></div>
                                        </div>

                                    </div>
                                <?php } ?>
                                </div>
                            <?php } ?>

                            <?php if ($nomap == '1') { ?>
                            </div>
                        </div>
                    <?php } else {
                                get_template_part('templates/mapview_footer'); ?>
                    </div>
                <?php } ?>

                </div>

            <?php endwhile; ?>
        </div>

        <div class="modal fade" id="contactAgent" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-close"></span></button>
                        <h4 class="modal-title" id="contactLabel"><?php esc_html_e('Contact Seller', 'realeswp'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo do_shortcode('[contact-form-7 id="a5aed19" title="Contact form for seller"]'); ?>
                        <!-- <form class="contactForm"> -->
                        <!-- <div class="row" style="display: none;">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="ca_response"></div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="ca_name"><?php esc_html_e('Name', 'realeswp'); ?> <span class="text-red">*</span></label>
                                        <input type="text" id="ca_name" name="ca_name" placeholder="<?php esc_html_e('Enter your name', 'realeswp'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="ca_email"><?php esc_html_e('Email', 'realeswp'); ?> <span class="text-red">*</span></label>
                                        <input type="text" id="ca_email" name="ca_email" placeholder="<?php esc_html_e('Enter your email', 'realeswp'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="ca_email"><?php esc_html_e('Phone', 'realeswp'); ?> <span class="text-red">*</span></label>
                                        <input type="text" id="ca_phone" name="ca_phone" placeholder="<?php esc_html_e('Enter your phone number', 'realeswp'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="ca_subject"><?php esc_html_e('Subject', 'realeswp'); ?> <span class="text-red">*</span></label>
                                        <input type="text" id="ca_subject" name="ca_subject" placeholder="<?php esc_html_e('Enter the subject', 'realeswp'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="ca_message"><?php esc_html_e('Message', 'realeswp'); ?> <span class="text-red">*</span></label>
                                        <textarea id="ca_message" name="ca_message" placeholder="<?php esc_html_e('Type your message', 'realeswp'); ?>" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <?php
                                // $reales_captcha_settings = get_option('reales_captcha_settings');
                                // $show_captcha = isset($reales_captcha_settings['reales_captcha_contact_field']) ? $reales_captcha_settings['reales_captcha_contact_field'] : false;
                                // $site_key = isset($reales_captcha_settings['reales_captcha_site_key_field']) ? $reales_captcha_settings['reales_captcha_site_key_field'] : '';
                                // $secret_key = isset($reales_captcha_settings['reales_captcha_secret_key_field']) ? $reales_captcha_settings['reales_captcha_secret_key_field'] : '';

                                // if ($show_captcha && $site_key != '' && $secret_key != '') {
                                ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($site_key); ?>"></div>
                                        </div>
                                    </div>
                                <?php //} 
                                ?>
                            </div> 
                            <input type="hidden" id="agent_email" name="agent_email" value="<?php echo esc_attr($agent_email); ?>" />
                            <input type="hidden" id="p_info_title" name="p_info_title" value="<?php echo esc_attr($p_info_title); ?>" />
                            <input type="hidden" id="p_info_link" name="p_info_link" value="<?php echo esc_attr($p_info_link); ?>" />
                            <?php //wp_nonce_field('agent_message_ajax_nonce', 'securityAgentMessage', true); 
                            ?>
                            -->
                        <!-- </form> -->
                    </div>
                    <div class="modal-footer" style="display: none;">
                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-gray"><?php esc_html_e('Close', 'realeswp'); ?></a>
                        <a href="javascript:void(0);" class="btn btn-green" style="display: none;" id="sendMessageBtn"><?php esc_html_e('Send Message', 'realeswp'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="reportProperty" role="dialog" aria-labelledby="reportLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-close"></span></button>
                        <h4 class="modal-title" id="reportLabel"><?php esc_html_e('Report Property Listing', 'realeswp'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <form class="contactForm">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="rp_response"></div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="report_reason"><?php esc_html_e('Reason', 'realeswp'); ?> <span class="text-red">*</span></label>
                                        <textarea id="report_reason" name="report_reason" placeholder="<?php esc_html_e('Please describe a reason', 'realeswp'); ?>" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="report_title" name="report_title" value="<?php echo esc_attr($p_info_title); ?>" />
                            <input type="hidden" id="report_link" name="report_link" value="<?php echo esc_attr($p_info_link); ?>" />
                            <?php wp_nonce_field('report_property_ajax_nonce', 'securityReport', true); ?>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-gray"><?php esc_html_e('Close', 'realeswp'); ?></a>
                        <a href="javascript:void(0);" class="btn btn-green" id="reportBtn"><?php esc_html_e('Submit', 'realeswp'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="sallerDetails" role="dialog" aria-labelledby="SallerDetailsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-close"></span></button>
                        <h4 class="modal-title" id="SallerDetailsLabel"><?php esc_html_e('Seller Details', 'realeswp'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="saller-details" id="saller-details">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-gray"><?php esc_html_e('Close', 'realeswp'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($calc == '1') {
            if (function_exists('reales_get_modal_calculator')) {
                reales_get_modal_calculator($calc_info);
            }
        }

        if ($nomap != '1') {
            get_template_part('templates/app_footer');
        } else {
            get_footer();
        }
        ?>