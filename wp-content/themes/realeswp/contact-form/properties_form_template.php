<?php

/**
 * @package WordPress
 * @subpackage Reales
 */
$search_submit = reales_get_search_link();
$cat_taxonomies = array(
    'property_category'
);
$cat_args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false
);
$cat_terms = get_terms($cat_taxonomies, $cat_args);

$type_taxonomies = array(
    'property_type_category'
);
$type_args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false
);
$type_terms = get_terms($type_taxonomies, $type_args);

$reales_general_settings = get_option('reales_general_settings');
$reales_search_settings = get_option('reales_search_settings');
$reales_appearance_settings = get_option('reales_appearance_settings', '');
$currency_symbol = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
$area_unit = isset($reales_general_settings['reales_unit_field']) ? $reales_general_settings['reales_unit_field'] : '';
$s_id_field = isset($reales_search_settings['reales_s_id_field']) ? $reales_search_settings['reales_s_id_field'] : '';
$s_keywords_field = isset($reales_search_settings['reales_s_keywords_field']) ? $reales_search_settings['reales_s_keywords_field'] : '';
$s_country_field = isset($reales_search_settings['reales_s_country_field']) ? $reales_search_settings['reales_s_country_field'] : '';
$s_state_field = isset($reales_search_settings['reales_s_state_field']) ? $reales_search_settings['reales_s_state_field'] : '';
$s_city_field = isset($reales_search_settings['reales_s_city_field']) ? $reales_search_settings['reales_s_city_field'] : '';
$s_category_field = isset($reales_search_settings['reales_s_category_field']) ? $reales_search_settings['reales_s_category_field'] : '';
$s_type_field = isset($reales_search_settings['reales_s_type_field']) ? $reales_search_settings['reales_s_type_field'] : '';
$s_price_field = isset($reales_search_settings['reales_s_price_field']) ? $reales_search_settings['reales_s_price_field'] : '';
$s_neighborhood_field = isset($reales_search_settings['reales_s_neighborhood_field']) ? $reales_search_settings['reales_s_neighborhood_field'] : '';
$s_area_field = isset($reales_search_settings['reales_s_area_field']) ? $reales_search_settings['reales_s_area_field'] : '';
$s_bedrooms_field = isset($reales_search_settings['reales_s_bedrooms_field']) ? $reales_search_settings['reales_s_bedrooms_field'] : '';
$s_bathrooms_field = isset($reales_search_settings['reales_s_bathrooms_field']) ? $reales_search_settings['reales_s_bathrooms_field'] : '';
$design = isset($reales_appearance_settings['reales_home_search_design_field']) ? $reales_appearance_settings['reales_home_search_design_field'] : 'd1';

$meta_get = array();
if (isset($_GET['meta'])) {
    $meta_get = $_GET['meta'];
}
$is_filter = $args['is_filter'];
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="row">
            <div class="form-group range">
                <label><?php esc_html_e('Price Range', 'realeswp'); ?></label>
                <!--            <div class="formField">
                                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>price_form]" id="search_min_price" value="<?php echo $meta_get[METABOX_PREFIX . 'price_form']; ?>" />
                                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>price_to]" id="search_max_price" value="<?php echo $meta_get[METABOX_PREFIX . 'price_to']; ?>" />
                                <div class="slider priceSlider">
                                    <div class="sliderTooltip">
                                        <div class="stArrow"></div>
                                        <div class="stLabel"></div>
                                    </div>
                                </div>
                            </div>-->
                <?php
                $ranges = array(
                    '' => "Select",
                    '0-10' => "Within 10 Lakhs",
                    '10-15' => "10Lakh - 15Lakh",
                    '15-20' => "15Lakh - 20Lakh",
                    '20-25' => "20Lakh - 25Lakh",
                    '25-35' => "25Lakh - 35Lakh",
                    '35-45' => "35Lakh - 45Lakh",
                    '45-55' => "45Lakh - 55Lakh",
                    '55-65' => "55Lakh - 65Lakh",
                    '65-75' => "65Lakh - 75Lakh",
                    '75-95' => "75Lakh - 95Lakh",
                    '95-' => "Above 95Lakh"
                );
                ?>
                <select class="form-control" name="meta[<?php echo METABOX_PREFIX; ?>price_range]">
                    <?php foreach ($ranges as $key => $value) { ?>
                        <option <?php echo $meta_get[METABOX_PREFIX . 'price_range'] === $key ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <label><?php esc_html_e('Area Range', 'realeswp'); ?></label>
            <div class="formField range">
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>area_from]" id="search_min_area" value="<?php echo $meta_get[METABOX_PREFIX . 'area_from']; ?>" />
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>area_to]" id="search_max_area" value="<?php echo $meta_get[METABOX_PREFIX . 'area_to']; ?>" />
                <div class="slider areaSlider">
                    <div class="sliderTooltip">
                        <div class="stArrow"></div>
                        <div class="stLabel"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 filter-wrapper">
        <div class="accordion<?php echo $is_filter ? '-filter' : ''; ?>">
            <h3>Category <span class="caret"></span></span></h3>
            <div class="ac">
                <?php foreach ($cat_terms as $cat_term) { ?>
                    <label>
                        <input type="checkbox" value="<?php echo esc_html($cat_term->name); ?>"
                            <?php echo in_array(esc_html($cat_term->name), $meta_get[METABOX_PREFIX . 'category'] ?? []) ? 'checked' : ''; ?>
                            name="meta[<?php echo METABOX_PREFIX; ?>category][]" /><?php echo esc_html($cat_term->name); ?>
                    </label>
                <?php } ?>
            </div>
            <h3>Type <span class="caret"></span></h3>
            <div class="ac">
                <?php foreach ($type_terms as $type_term) { ?>
                    <?php if ($type_term->name !== 'Rented' && $type_term->name !== 'Sold out'): ?>
                        <label>
                            <input type="checkbox"
                                <?php echo in_array(esc_html($type_term->name), $meta_get[METABOX_PREFIX . 'type'] ?? []) ? 'checked' : ''; ?>
                                value="<?php echo esc_html($type_term->name); ?>" name="meta[<?php echo METABOX_PREFIX; ?>type][]" /><?php echo esc_html($type_term->name); ?>
                        </label>
                    <?php endif; ?>
                <?php } ?>
            </div>
            <h3><?php esc_html_e('Bedrooms', 'realeswp'); ?> <span class="caret"></span></h3>
            <div class="ac">
                <?php
                $bedrooms = array(
                    "0" => 'Studio',
                    "1" => '1+',
                    "2" => '2+',
                    "3" => '3+',
                    "4" => '4+',
                    "5" => '5+'
                );
                ?>
                <?php foreach ($bedrooms as $key => $value) { ?>
                    <label>
                        <input type="checkbox"
                            <?php echo in_array($key, $meta_get[METABOX_PREFIX . 'bedrooms'] ?? []) ? 'checked' : ''; ?>
                            value="<?php echo $key; ?>" name="meta[<?php echo METABOX_PREFIX; ?>bedrooms][]" /><?php echo $value; ?>
                    </label>
                <?php } ?>
            </div>
            <h3><?php esc_html_e('Bathrooms', 'realeswp'); ?> <span class="caret"></span></h3>
            <div class="ac">
                <?php
                $bathrooms = array(
                    "1" => '1+',
                    "2" => '2+',
                    "3" => '3+',
                    "4" => '4+',
                    "5" => '5+'
                );
                ?>
                <?php foreach ($bathrooms as $key => $value) { ?>
                    <label>
                        <input type="checkbox"
                            <?php echo in_array($key, $meta_get[METABOX_PREFIX . 'bathrooms'] ?? []) ? 'checked' : ''; ?>
                            value="<?php echo $key; ?>" name="meta[<?php echo METABOX_PREFIX; ?>bathrooms][]" /><?php echo $value; ?>
                    </label>
                <?php } ?>
            </div>

            <?php
            $reales_fields_settings = get_option('reales_fields_settings');
            $count = 0;
            //            _p($reales_fields_settings);
            foreach ($reales_fields_settings as $field) {
                $list = explode(',', $field['list']);
                if (strtolower($field['label']) === 'local_location') {
                    $list = sort($list);
                }
            ?>
                <h3><?php echo $field['name']; ?> <span class="caret"></span></h3>
                <div class="ac">
                    <?php foreach ($list as $item) { ?>
                        <?php if ($item): ?>
                            <?php $meta_name = METABOX_PREFIX . str_replace(' ', "_", strtolower($field['label'])); ?>
                            <label>
                                <input type="checkbox"
                                    <?php echo in_array($item, $meta_get[$meta_name] ?? []) ? 'checked' : ''; ?>
                                    value="<?php echo $item; ?>" name="meta[<?php echo $meta_name; ?>][]" /><?php echo $item; ?>
                            </label>
                        <?php endif; ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <h3><?php esc_html_e('Amenities', 'realeswp'); ?><span class="caret"></span></h3>
            <div class="ac amenities-checkbox">
                <?php
                $reales_amenity_settings = get_option('reales_amenity_settings');
                ?>
                <?php foreach ($reales_amenity_settings as $item) { ?>
                    <label class="multi-select-menuitem">
                        <input type="checkbox"
                            <?php echo in_array($item['label'], $meta_get[METABOX_PREFIX . 'amenities'] ?? []) ? 'checked' : ''; ?>
                            name="meta[<?php echo METABOX_PREFIX; ?>amenities][]" value="<?php echo $item['label']; ?>">
                        <?php echo $item['label']; ?>
                    </label>
                <?php } ?>
            </div>
        </div>
    </div>
</div>