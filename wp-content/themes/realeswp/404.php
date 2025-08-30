<?php

/**
 * @package WordPress
 * @subpackage Reales
 */


get_header();
?>

<div id="" class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h2 class="pageHeader"><?php esc_html_e('Sorry, we have a broken link!', 'realeswp'); ?></h2>
                <p><?php esc_html_e('The page you are looking for was moved, removed, renamed, or might never existed.', 'realeswp'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-green"><?php esc_html_e('Go Home', 'realeswp'); ?></a></p>
            </div>
            <?php if (is_active_sidebar('recent_property_sidebar_manual')) : ?>
                <div class="col-lg-6">
                    <ul class="footer-nav pb20">
                        <?php dynamic_sidebar('recent_property_sidebar_manual'); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>