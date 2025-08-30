<?php
/**
 * @package WordPress
 * @subpackage Reales
 */
get_header();
$reales_appearance_settings = get_option('reales_appearance_settings', '');
$sidebar_position = isset($reales_appearance_settings['reales_sidebar_field']) ? $reales_appearance_settings['reales_sidebar_field'] : '';
$show_bc = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';

function filter_form() {
    ?>
    <form class="leads-filters custom-form-checkbox" action="https://nextsqft.com/current-leads/" method="get" id="leads-filters">
        <?php get_template_part('contact-form/properties_form_template'); ?>
        <input type="hidden" value="1" name="_leads_filter" />
        <button type="submit">Apply</button>
        <button type="button" onclick="window.location.href = 'https://nextsqft.com/current-leads/'">Reset</button>
    </form>
<?php } ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myCRModal">
    Launch demo modal
</button>


<div id="leads" class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <?php if ($sidebar_position == 'left') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php filter_form(); ?>
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <?php
                if ($show_bc != '') {
//                    reales_breadcrumbs();
                }
                ?>
                <?php // the_archive_title( '<h2 class="pageHeader">', '</h2>' );     ?>
                <div class="row">
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'posts_per_page' => get_option('posts_per_page'),
                        'paged' => $paged,
                        'post_type' => 'leads'
                    );

                    if (isset($_GET['_leads_filter'])) {
                        $metas = $_GET['meta'];
                        $meta_query = array(
                            'relation' => 'AND',
                        );
                        $args['meta_query'] = array(
                            'relation' => 'AND'
                        );
                        foreach ($metas as $key => $value) {
                            if ($value) {
                                $compare = is_array($value) ? 'REGEXP' : '=';

                                if ($key === '_next_price_form')
                                    $compare = '>=';
                                if ($key === '_next_price_to')
                                    $compare = '<=';
                                if ($key === '_next_area_from')
                                    $compare = '>=';
                                if ($key === '_next_area_to')
                                    $compare = '<=';

                                array_push($meta_query, array(
                                    'key' => $key,
                                    'compare' => $compare,
                                    // With dynamic values, be sure to properly escape the "IS" or whatever
                                    // is the actual value. E.g. '(^|,)' . preg_quote( $value ) . '(,|$)'
                                    'value' => is_array($value) ? '"(' . implode('|', $value) . ')"' : $value,
                                ));
                            }
                        }
                        $args['meta_query'] = $meta_query;
                    }
                    _p($args);
                    $postslist = new WP_Query($args);
                    if ($postslist->have_posts()) :

                        while ($postslist->have_posts()) : $postslist->the_post();
                            $post_class = 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
                            $show_excerpt = false;

                            $p_id = get_the_ID();
                            $metas = get_post_meta($p_id);
                            $p_link = get_permalink($p_id);
                            $p_title = get_the_title($p_id);
                            $p_excerpt = get_the_excerpt();
                            $p_author = get_the_author();
                            $p_date = get_the_date();
                            $p_content = get_the_content();

                            $p_image = wp_get_attachment_image_src(get_post_thumbnail_id($p_id), 'single-post-thumbnail');

                            $no_image_class = '';
                            if ($p_image === false) {
                                $no_image_class = 'has-no-image';
                            }
                            ?>

                            <div class="lead-wrapper <?php echo esc_attr($post_class); ?>">
                                <div class="article bg-w">

                                    <h4 class="title"> <a href="<?php echo $p_link; ?>"><?php echo esc_html($p_title); ?></a></h4>
                                    <div class="content">
                                        <p><?php echo esc_html($p_content); ?></p>
                                        <p>
                                            <label>Area: </label> 
                                            <?php echo $metas[METABOX_PREFIX . 'price_form'][0]; ?> to <?php echo $metas[METABOX_PREFIX . 'price_to'][0]; ?>
                                        </p>
                                        <p>
                                            <label>Budget: </label> 
                                            <?php echo $metas[METABOX_PREFIX . 'area_from'][0]; ?> to <?php echo $metas[METABOX_PREFIX . 'area_to'][0]; ?>
                                        </p>
                                        <p>
                                            <label>Location: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'local_location'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Category: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'category'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Type: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'type'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Status: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'status'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Facing: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'facing'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Floor No: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'floor_no'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Bedrooms: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'bedrooms'][0])); ?>
                                        </p>
                                        <p>
                                            <label>Bathrooms: </label> 
                                            <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'bathrooms'][0])); ?>
                                        </p>
                                    </div>
                                    <div class="footer lead-footer">
                                        <span>
                                            Requested on <?php echo esc_html($p_date); ?>
                                        </span>
                                        <button type="button" data-post_id="<?php echo $p_id; ?>" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myCRModal">
                                            Contact
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <?php
                        endwhile;
                    else :
                        esc_html_e('No leads found.', 'realeswp');
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="blog-pagination">
                    <div class="pull-left"><?php next_posts_link('<span class="fa fa-angle-left"></span> ' . __('Older Articles', 'realeswp'), esc_html($postslist->max_num_pages)); ?></div>
                    <div class="pull-right"><?php previous_posts_link(__('Newer Articles', 'realeswp') . ' <span class="fa fa-angle-right"></span>'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <?php
                $postslist = null;
                $postslist = $temp;
                ?>
            </div>
            <?php if ($sidebar_position == 'right') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php filter_form(); ?>
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myCRModal" tabindex="-1" role="dialog" aria-labelledby="myCRModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myCRModalLabel">Request contact Form</h4>
            </div>
            <div class="modal-body">
                <?php get_template_part('contact-form/request-contact-form'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>