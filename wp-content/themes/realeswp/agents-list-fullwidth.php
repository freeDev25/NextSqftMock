<?php
/*
Template Name: Agents List
*/

/**
 * @package WordPress
 * @subpackage Reales
 */

global $post;
get_header();
$reales_general_settings    = get_option('reales_general_settings','');
$reales_appearance_settings = get_option('reales_appearance_settings','');
$show_rating                = isset($reales_general_settings['reales_agents_rating_field']) ? $reales_general_settings['reales_agents_rating_field'] : '';
$sidebar_position           = isset($reales_appearance_settings['reales_sidebar_field']) ?  $reales_appearance_settings['reales_sidebar_field'] : '';
$show_bc                    = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';
$agents_per_page_setting    = isset($reales_appearance_settings['reales_agents_per_page_field']) ? $reales_appearance_settings['reales_agents_per_page_field'] : '';
$agents_per_page            = $agents_per_page_setting != '' ? $agents_per_page_setting : 10;
$has_rating                 = $show_rating != '' ? ' hasRating' : '';

$cards_design_settings = get_option('reales_agent_cards_design_settings', '');
$card_type             = isset($cards_design_settings['card_type']) ? $cards_design_settings['card_type'] : '';

$keywords = isset($_GET['keywords']) ? sanitize_text_field($_GET['keywords']) : '';
?>

<div id="" class="page-wrapper">
    <div class="page-content">
        <?php while(have_posts()) : the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if($show_bc != '') {
                    reales_breadcrumbs();
                } ?>

                <form id="search-agent-form" class="is-full">
                    <h2 class="centered osLight"><?php esc_html_e('Find an Agent', 'realeswp'); ?></h2>

                    <div class="form-group">
                        <input type="text" class="form-control input-lg" name="keywords" id="keywords" value="<?php echo esc_attr($keywords); ?>" placeholder="<?php echo esc_attr('Search for...', 'realeswp'); ?>">
                        <span class="fa fa-search"></span>
                    </div>
                </form>

                <div class="entry-content">
                    <?php the_content(); ?>
                    <div class="clearfix"></div>
                </div>
            </div>

        <?php endwhile; ?>

        <div class="row">
            <?php global $paged;
            $paged    = get_query_var('paged') ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page' => 9,
                'paged'          => $paged,
                'post_type'      => 'agent',
                'orderby'        => 'title',
                'order'          => 'ASC',
                's'              => $keywords,
                'post_status'    => array('publish')
            );

            $agents = new WP_Query($args);

            while ($agents->have_posts()): $agents->the_post();
                $agent_id = get_the_ID();
                $title    = get_the_title();
                $link     = get_the_permalink();
                $avatar   = get_post_meta($agent_id, 'agent_avatar', true);
                $phone    = get_post_meta($agent_id, 'agent_phone', true);
                $mobile   = get_post_meta($agent_id, 'agent_mobile', true);
                $email    = get_post_meta($agent_id, 'agent_email', true);
                $skype    = get_post_meta($agent_id, 'agent_skype', true);
                $facebook = get_post_meta($agent_id, 'agent_facebook', true);
                $twitter  = get_post_meta($agent_id, 'agent_twitter', true);
                $google   = get_post_meta($agent_id, 'agent_google', true);
                $linkedin = get_post_meta($agent_id, 'agent_linkedin', true);
                $agency   = get_post_meta($agent_id, 'agent_agency', true);
                $specs    = get_post_meta($agent_id, 'agent_specs', true);

                if($avatar != '') {
                    $avatar_src = $avatar;
                } else {
                    $avatar_src = get_template_directory_uri().'/images/avatar.png';
                } ?>

                <?php if($card_type == 'd2') { ?>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="agentsItem-2">
                            <a class="agentsItem-2-fig" href="<?php echo esc_url($link); ?>" style="background-image: url(<?php echo esc_url($avatar_src); ?>)"></a>
                            <a class="agentsItem-2-name" href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
                            <div class="agentsItem-2-specs"><?php echo esc_html($specs); ?></div>
                            <div class="agentsItem-2-contact">
                                <div class="agentsItem-2-email"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></div>
                                <div class="agentsItem-2-phone"><a href="tel:<?php echo esc_attr($mobile); ?>"><?php echo esc_html($mobile); ?></a></div>
                            </div>
                            <ul class="agentsItem-2-social">
                                <?php if($facebook && $facebook != '') { ?>
                                    <li><a href="<?php echo esc_url($facebook); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-facebook" target="_blank"><span class="fa fa-facebook"></span></a></li>
                                <?php } ?>
                                <?php if($twitter && $twitter != '') { ?>
                                    <li><a href="<?php echo esc_url($twitter); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-twitter" target="_blank"><span class="fa fa-twitter"></span></a></li>
                                <?php } ?>
                                <?php if($google && $google != '') { ?>
                                    <li><a href="<?php echo esc_url($google); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-google" target="_blank"><span class="fa fa-google-plus"></span></a></li>
                                <?php } ?>
                                <?php if($linkedin && $linkedin != '') { ?>
                                    <li><a href="<?php echo esc_url($linkedin); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a></li>
                                <?php } ?>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="agentsItem<?php echo esc_attr($has_rating); ?>">
                            <div class="agentsItemPhoto" style="background-image: url(<?php echo esc_url($avatar_src); ?>)">
                                <div class="agentsItemBg"></div>
                                <a class="agentsItemAvatar" href="<?php echo esc_url($link); ?>">
                                    <img src="<?php echo esc_url($avatar_src); ?>" alt="<?php echo esc_attr($title); ?>">
                                </a>
                            </div>
                            <div class="agentsItemName">
                                <a href="<?php echo esc_url($link); ?>"><?php echo esc_attr($title); ?></a>
                            </div>
                            <?php if($show_rating != '') {
                                print reales_display_agent_rating(reales_get_agent_ratings($agent_id), false);
                            } ?>
                            <div class="agentsItemContact">
                                <?php if($agency && $agency != '') { ?>
                                    <div class="agentsItemContactItem">
                                        <span class="fa fa-building-o"></span> <?php echo esc_html($agency); ?>
                                    </div>
                                <?php } ?>
                                <?php if($phone && $phone != '') { ?>
                                    <div class="agentsItemContactItem">
                                        <span class="fa fa-phone"></span> <?php echo esc_html($phone); ?>
                                    </div>
                                <?php } ?>
                                <?php if($mobile && $mobile != '') { ?>
                                    <div class="agentsItemContactItem">
                                        <span class="fa fa-mobile"></span> <?php echo esc_html($mobile); ?>
                                    </div>
                                <?php } ?>
                                <?php if($email && $email != '') { ?>
                                    <div class="agentsItemContactItem">
                                        <span class="fa fa-envelope"></span> <?php echo esc_html($email); ?>
                                    </div>
                                <?php } ?>
                                <?php if($skype && $skype != '') { ?>
                                    <div class="agentsItemContactItem">
                                        <span class="fa fa-skype"></span> <?php echo esc_html($skype); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="agentsItemSocial">
                                <?php if($facebook && $facebook != '') { ?>
                                    <a href="<?php echo esc_url($facebook); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-facebook" target="_blank"><span class="fa fa-facebook"></span></a>
                                <?php } ?>
                                <?php if($twitter && $twitter != '') { ?>
                                    <a href="<?php echo esc_url($twitter); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-twitter" target="_blank"><span class="fa fa-twitter"></span></a>
                                <?php } ?>
                                <?php if($google && $google != '') { ?>
                                    <a href="<?php echo esc_url($google); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-google" target="_blank"><span class="fa fa-google-plus"></span></a>
                                <?php } ?>
                                <?php if($linkedin && $linkedin != '') { ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" class="btn btn-sm btn-icon btn-round btn-o btn-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            <?php endwhile;

            wp_reset_query();
            wp_reset_postdata();
            ?>
        </div>

        <div class="blog-pagination">
            <div class="pull-right"><?php next_posts_link( __('Next Page', 'realeswp') . ' <span class="fa fa-angle-right"></span>', esc_html($agents->max_num_pages) ); ?></div>
            <div class="pull-left"><?php previous_posts_link( '<span class="fa fa-angle-left"></span> ' . __('Previous Page', 'realeswp') ); ?></div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php get_footer(); ?>