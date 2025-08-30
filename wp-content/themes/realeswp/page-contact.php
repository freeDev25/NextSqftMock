<?php
/*
Template Name: Leads Generation Template
*/

/**
 * @package WordPress
 * @subpackage Reales
 */

global $post;
get_header();
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
                <?php while (have_posts()) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php if ($show_bc != '') {
                            reales_breadcrumbs();
                        } ?>
                        <div class="entry-content">
                            Search & get a Property as you want to buy rent or invest within your budget & amenities choices, get only relative results as you want.
                            <h2>Set Your Own Property Search Alerts</h2>
                            Fill up Buyers search requirements form:

                            <?php // the_content(); 
                            ?>
                            <?php get_template_part('contact-form/contact-form'); ?>
                            <div class="clearfix"></div>
                            <?php wp_link_pages(array(
                                'before'      => '<div class="page-links">',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '%',
                                'separator'   => '',
                            )); ?>
                        </div>
                    </div>

                <?php if (comments_open() || get_comments_number()) {
                        comments_template();
                    }

                endwhile; ?>
                <p>
                    So using nextsqft property alert notification will be the exact match property options with sellers contacts. Find a property as you want to buy or lease. You will get exact matched seller offers only.
                </p>
                <img src="https://nextsqft.com/wp-content/uploads/2022/06/Untitled.png">
                <p>

                    Say goodbey to the junk emails. Now a day’s max online company sending bulk & junk emails without matching properties. Get property alerts on your own property choices only.
                </p>
                <h2>Try nextsqft property alerts</h2>
            </div>
            <?php if ($sidebar_position == 'right') { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>