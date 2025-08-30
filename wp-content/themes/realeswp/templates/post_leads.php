<?php
/**
 * @package WordPress
 * @subpackage Reales
 */

$page_hero = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

if($page_hero === false) {
    //$page_hero = array(get_template_directory_uri() . '/images/default-image.jpg');
}

$post_title = get_the_title($post->ID);
$prev_post = get_previous_post();
$next_post = get_next_post(); ?>
<div id="carouselBlog" class="carousel slide featured" style="height: 300px;" data-ride="carousel">
    <div class="carousel-inner">
        <div class="item active" style="background-image: url(<?php echo esc_url($page_hero[0]); ?>)">
            <div class="container">
                <div class="carousel-caption">
                    <div class="caption-title"><?php echo esc_html($post_title); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>