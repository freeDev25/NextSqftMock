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
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group range">
            <label><?php esc_html_e('Price Range', 'realeswp'); ?></label>
            <div class="formField">
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX;  ?>price_form]" id="search_min_price" value="0" />
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX;  ?>price_to]" id="search_max_price" value="15000000" />
                <div class="slider priceSlider">
                    <div class="sliderTooltip">
                        <div class="stArrow"></div>
                        <div class="stLabel"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <label><?php esc_html_e('Area Range', 'realeswp'); ?></label>
            <div class="formField range">
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX;  ?>area_from]" id="search_min_area" value="0" />
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX;  ?>area_to]" id="search_max_area" value="5000" />
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
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control multiselect" multiple id="languages" name="meta[<?php echo METABOX_PREFIX;  ?>category][]">
                <!--<option value="">Select</option>-->
                <?php foreach ($cat_terms as $cat_term) { ?>
                    <option value="<?php echo esc_attr($cat_term->term_id); ?>"><?php echo esc_html($cat_term->name); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control multiselect" multiple name="meta[<?php echo METABOX_PREFIX;  ?>type][]">
                <!--<option value="">Select</option>-->
                <?php foreach ($type_terms as $type_term) { ?>
                    <option value="<?php echo esc_attr($type_term->term_id); ?>"><?php echo esc_html($type_term->name); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <label for="bedrooms"><?php esc_html_e('Bedrooms', 'realeswp'); ?></label>
            <?php
            $bedrooms = array(
                "0" => 'Studio',
                "1" => '1+',
                "2" => '2+',
                "3" => '3+',
                "4" => '4+',
                "5" => '5+');
            ?>
            <select class="form-control multiselect" multiple name="meta[<?php echo METABOX_PREFIX;  ?>bedrooms][]">
                <!--<option value="">Select</option>-->
                <?php foreach ($bedrooms as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <label for="name"><?php esc_html_e('Bathrooms', 'realeswp'); ?></label>
            <?php
            $bathrooms = array(
                "1" => '1+',
                "2" => '2+',
                "3" => '3+',
                "4" => '4+',
                "5" => '5+');
            ?>
            <select class="form-control multiselect" multiple name="meta[<?php echo METABOX_PREFIX;  ?>bathrooms][]">
                <!--<option value="">Select</option>-->
                <?php foreach ($bathrooms as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <?php
    $reales_fields_settings = get_option('reales_fields_settings');
    $count = 0;
    foreach ($reales_fields_settings as $field) {
        $list = explode(',', $field['list']);
        ?>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
            <div class="form-group">
                <label for="type"><?php echo $field['name']; ?></label>
                <select class="form-control multiselect" multiple name="meta[<?php echo METABOX_PREFIX;  ?><?php echo str_replace(' ', "_", strtolower($field['label'])); ?>][]">
                    <!--<option value="">Select</option>-->
                    <?php foreach ($list as $item) { ?>
                        <?php if ($item): ?>
                            <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php endif; ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php
        $count++;
        if ($count % 2 === 0) {
            ?>
        </div>
        <div class="row">
            <?php
        }
    }
    ?>
</div>
<?php
$reales_amenity_settings = get_option('reales_amenity_settings');
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label><?php esc_html_e('Amenities', 'realeswp'); ?></label>
            <div class="row">
                <?php foreach ($reales_amenity_settings as $item) { ?>
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 filter-wrapper">
                        <div class="amenities-checkbox">
                            <label class="multi-select-menuitem">
                                <input type="checkbox" name="meta[<?php echo METABOX_PREFIX;  ?>amenities][]" value="<?php echo $item['label']; ?>">
                                <?php echo $item['label']; ?>
                            </label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
