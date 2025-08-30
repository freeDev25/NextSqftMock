<?php
/*
  Template Name: Leads Page
 */

/**
 * @package WordPress
 * @subpackage Reales
 */
get_header();
$reales_appearance_settings = get_option('reales_appearance_settings', '');
$sidebar_position = isset($reales_appearance_settings['reales_sidebar_field']) ? $reales_appearance_settings['reales_sidebar_field'] : '';
$show_bc = isset($reales_appearance_settings['reales_breadcrumbs_field']) ? $reales_appearance_settings['reales_breadcrumbs_field'] : '';

function getFaq()
{
?>

<?php
}

function filter_form()
{
?>
    <form class="leads-filters custom-form-checkbox" action="https://nextsqft.com/current-leads/" method="get" id="leads-filters">
        <h3><strong>Filter Leads</strong></h3>
        <?php
        get_template_part('contact-form/properties_form_template', '', array(
            'is_filter' => true
        ));
        ?>
        <input type="hidden" value="1" name="_leads_filter" />
        <button type="button" class="btn btn-green" onclick="window.location.href = 'https://nextsqft.com/current-leads/'">Reset</button>
        <button type="submit" class="btn btn-green">Apply</button>
    </form>
<?php } ?>
<div id="leads" class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <?php if ($sidebar_position == 'left') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php get_sidebar(); ?>
                    <?php getFaq(); ?>
                    <?php filter_form(); ?>
                </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 leads-page-contents" id="leads-page-contents-wrapper">
                <div class="lead-backdrop">
                    <div class="rq-loader" id="rq-loader"></div>
                </div>
                <div class="" id="leads-page-contents">
                    <div id="leads-ajax-contents">
                        <?php
                        if ($show_bc != '') {
                            //                    reales_breadcrumbs();
                        }
                        ?>
                        <?php // the_archive_title( '<h2 class="pageHeader">', '</h2>' );     
                        ?>
                        <div class="" id="page-content">
                            <?php the_content(); ?>
                        </div>
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
                                $meta_query = array();

                                $price_range = '';
                                if (isset($metas[METABOX_PREFIX . 'price_range']) && $metas[METABOX_PREFIX . 'price_range']) {

                                    $price_range = explode('-', $metas[METABOX_PREFIX . 'price_range']);

                                    $metas[METABOX_PREFIX . 'price_form'] = $price_range[0];
                                    $metas[METABOX_PREFIX . 'price_to'] = $price_range[1];
                                    $price_range = $metas[METABOX_PREFIX . 'price_range'];

                                    if ($metas[METABOX_PREFIX . 'price_range'] === '95-') {
                                        $metas[METABOX_PREFIX . 'price_form'];
                                        unset($metas[METABOX_PREFIX . 'price_to']);
                                    }
                                    unset($metas[METABOX_PREFIX . 'price_range']);
                                }
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
                                if (count($meta_query) > 0) {
                                    $meta_query['relation'] = "AND";
                                    $args['meta_query'] = $meta_query;
                                }
                            }
                            //                            _p($args);
                            $postslist = new WP_Query($args);
                            if ($postslist->have_posts()) :

                                while ($postslist->have_posts()) : $postslist->the_post();
                                    $post_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
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
                                            <div class="lead-article-content">
                                                <h4 class="title">
                                                    <a href="<?php echo $p_link; ?>"><?php echo esc_html($p_title); ?></a>
                                                    <br />
                                                    <span class="date">
                                                        Requested on <?php echo esc_html($p_date); ?>
                                                    </span>
                                                </h4>

                                                <?php
                                                get_template_part('contact-form/lead-meta', 'content', array(
                                                    'metas' => $metas,
                                                    'price_range' => $price_range,
                                                    'p_content' => $p_author
                                                ));
                                                ?>
                                            </div>
                                            <?php get_template_part('contact-form/lead', 'actions'); ?>
                                            <!--                                            <div class="footer lead-footer">
                                                                                                    <span class="date">
                                                                                                Requested on <?php echo esc_html($p_date); ?>
                                                                                            </span>
                                                                                            <div class="actions">
                                                                                                <button type="button" data-post_id="<?php echo $p_id; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myCRModal">
                                                                                                    Send Offer
                                                                                                </button>
                                                                                                <button type="button" data-post_id="<?php echo $p_id; ?>" data-share="<?php echo $p_link; ?>" class="btn btn-primary btn-sm copy-to-clip">
                                                                                                    Copy
                                                                                                </button> 
                                                                                                <a class="btn btn-primary btn-sm" target="_blank" href="https://nextsqft.com/request-a-query/">
                                                                                                    Set an Alert
                                                                                                </a> 
                                                                                            </div>
                                                                                        </div>-->
                                        </div>

                                    </div>

                                <?php
                                endwhile;
                            else :
                                ?>
                                <div class="leads-container">
                                    <div class="icon">🚫</div>
                                    <h2>No Leads Found</h2>
                                    <p>Looks like there are no leads available at the moment.</p>
                                    <a href="<?php bloginfo('home'); ?>" class="btn btn-green">Go Homepage</a>
                                </div>
                                <!-- <style type="text/css">
                                    .leads-container {
                                        text-align: center;
                                        background: #ffffff;
                                        padding: 40px;
                                        border-radius: 12px;
                                    }

                                    .leads-container .icon {
                                        font-size: 50px;
                                        color: #C4C4C4;
                                    }

                                    .leads-container h2 {
                                        font-weight: 600;
                                        font-size: 24px;
                                        margin: 20px 0 10px;
                                    }

                                    .leads-container p {
                                        font-size: 16px;
                                        color: #666;
                                    }

                                    .leads-container .btn {
                                        display: inline-block;
                                        margin-top: 20px;
                                        padding: 10px 20px;
                                        background-color: #0052CC;
                                        color: #fff;
                                        text-decoration: none;
                                        font-weight: 600;
                                        border-radius: 6px;
                                        transition: background 0.3s ease;
                                    }

                                    .leads-container .btn:hover {
                                        background-color: #003E99;
                                    }
                                </style> -->
                            <?php
                            endif;
                            wp_reset_postdata();
                            ?>
                        </div>
                        <div class="blog-pagination" id="paginate">
                            <div class="pull-left"><?php next_posts_link('<span class="fa fa-angle-left"></span> ' . __('Older Leads', 'realeswp'), esc_html($postslist->max_num_pages)); ?></div>
                            <div class="pull-right"><?php previous_posts_link(__('Newer Leads', 'realeswp') . ' <span class="fa fa-angle-right"></span>'); ?></div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        $postslist = null;
                        $postslist = $temp;
                        ?>
                    </div>
                </div>
            </div>
            <?php if ($sidebar_position == 'right') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php filter_form(); ?>
                    <?php getFaq(); ?>
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_template_part('contact-form/seller-form-modal'); ?>


<?php get_footer(); ?>