<?php
/**
 * @package WordPress
 * @subpackage Reales
 */
global $post;
get_header('leads');
$reales_appearance_settings = get_option('reales_appearance_settings', '');
$sidebar_position = isset($reales_appearance_settings['reales_sidebar_field']) ? $reales_appearance_settings['reales_sidebar_field'] : '';
$show_bc = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';
?>

<div id="" class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <?php if ($sidebar_position == 'left') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <?php
                while (have_posts()) : the_post();
                    $author = get_the_author();
                    $author_avatar = get_the_author_meta('avatar');
                    if ($author_avatar != '') {
                        $author_avatar_src = $author_avatar;
                    } else {
                        $author_avatar_src = get_template_directory_uri() . '/images/avatar.png';
                    }
                    $post_date = get_the_date();
                    $post_id = $p_id = get_the_ID();
                    $post_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
                    $post_excerpt = get_the_excerpt();
                    $metas = get_post_meta($post_id);
                    ?>

                    <?php
                    if ($show_bc != '') {
                        reales_breadcrumbs();
                    }
                    ?>

                    <div class="post-top">
                        <div class="post-author">
                            <img src="<?php echo esc_url($author_avatar_src); ?>" alt="<?php echo esc_attr($author); ?>">
                            <div class="pa-user">
                                <div class="pa-name"><?php // echo esc_html(get_tf_meta_data($metas, METABOX_PREFIX . 'name'));           ?>Anonymous</div>
                                <div class="pa-title"><?php echo esc_html($post_date); ?></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php // the_title("<h1 class='lead-title'>", "</h1>"); ?>
                            <p class="content">
                                <label><strong>Requirement:</strong> </label> 
                                <?php the_title(); ?>
                            </p>
                            <div class="content">
                                <label><strong>Specific:</strong></label>
                                <?php echo strip_tags(the_content()); ?>
                            </div>
                            <div class="clearfix"></div>
                            <?php
                            get_template_part('contact-form/lead-meta', 'content', array(
                                'metas' => $metas
                            ));
                            ?>
                            <?php get_template_part('contact-form/lead', 'actions'); ?>
                            <!--                            <div class="footer lead-footer">
                                                                <span class="date">
                                                                Requested on <?php echo esc_html($p_date); ?>
                                                            </span>
                                                            <button type="button" data-post_id="<?php echo $p_id; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myCRModal">
                                                                Send Offer
                                                            </button>
                                                            <button type="button" title="Copy link to share" data-post_id="<?php echo $p_id; ?>" data-share="<?php echo get_permalink(); ?>" class="btn btn-primary btn-sm copy-to-clip">
                                                                Copy
                                                            </button> 
                                                            <a class="btn btn-primary btn-sm" target="_blank" href="https://nextsqft.com/request-a-query/">
                                                                Set an Alert
                                                            </a> 
                                                        </div>-->
                            <?php
//                            wp_link_pages( array(
//                                'before'      => '<div class="page-links">',
//                                'after'       => '</div>',
//                                'link_before' => '<span>',
//                                'link_after'  => '</span>',
//                                'pagelink'    => '%',
//                                'separator'   => '',
//                            ) ); 
                            ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
            <?php if ($sidebar_position == 'right') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_template_part('contact-form/seller-form-modal'); ?>

<?php get_footer(); ?>