<?php
/**
 * @package WordPress
 * @subpackage Reales
 */

$reales_appearance_settings = get_option('reales_appearance_settings','');
$home_spotlight_title       = isset($reales_appearance_settings['reales_home_spotlight_title_field']) ? $reales_appearance_settings['reales_home_spotlight_title_field']: '';
$home_spotlight_text        = isset($reales_appearance_settings['reales_home_spotlight_text_field']) ? $reales_appearance_settings['reales_home_spotlight_text_field'] : '';
$search_design              = isset($reales_appearance_settings['reales_home_search_design_field']) ? $reales_appearance_settings['reales_home_search_design_field'] : 'd1';

$search_class = '';
if($search_design == 'd2' || $search_design == 'd3') {
    $search_class = 'has-search';
}
?>

<div class="spotlight <?php echo esc_attr($search_class); ?>">
    <div class="s-title osLight"><?php echo esc_html($home_spotlight_title); ?></div>
    <div class="s-text osLight"><?php echo esc_html($home_spotlight_text); ?></div>
</div>