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
        <div class="accordion">
            <h3>Category <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span></h3>
            <div class="ac">
                <?php foreach ($cat_terms as $cat_term) { ?>
                    <label>
                        <input type="checkbox" value="<?php echo esc_html($cat_term->name); ?>>" name="meta[<?php echo METABOX_PREFIX; ?>category][]" /><?php echo esc_html($cat_term->name); ?>
                    </label>
                <?php } ?>
            </div>
            <h3>Type <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></h3>
            <div class="ac">
                <?php foreach ($type_terms as $type_term) { ?>
                    <label>
                        <input type="checkbox" value="<?php echo esc_html($type_term->name); ?>" name="meta[<?php echo METABOX_PREFIX; ?>type][]" /><?php echo esc_html($type_term->name); ?>
                    </label>
                <?php } ?>
            </div>
            <h3><?php esc_html_e('Bedrooms', 'realeswp'); ?> <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></h3>
            <div class="ac">
                <?php
                $bedrooms = array(
                    "0" => 'Studio',
                    "1" => '1+',
                    "2" => '2+',
                    "3" => '3+',
                    "4" => '4+',
                    "5" => '5+');
                ?>
                <?php foreach ($bedrooms as $key => $value) { ?>
                    <label>
                        <input type="checkbox" value="<?php echo $key; ?>" name="meta[<?php echo METABOX_PREFIX; ?>bedrooms][]" /><?php echo $value; ?>
                    </label>
                <?php } ?>
            </div>
            <h3><?php esc_html_e('Bathrooms', 'realeswp'); ?> <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></h3>
            <div class="ac">
                <?php
                $bathrooms = array(
                    "1" => '1+',
                    "2" => '2+',
                    "3" => '3+',
                    "4" => '4+',
                    "5" => '5+');
                ?>
                <?php foreach ($bathrooms as $key => $value) { ?>
                    <label>
                        <input type="checkbox" value="<?php echo $key; ?>" name="meta[<?php echo METABOX_PREFIX; ?>bathrooms][]" /><?php echo $value; ?>
                    </label>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="accordion">
            <h3>Section 1 <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span></h3>
            <div class="ac">
                <p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
            </div>
            <h3>Section 2 <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></h3>
            <div class="ac">
                <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
            </div>
            <h3>Section 3 <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></h3>
            <div class="ac">
                <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
                <ul>
                    <li>List item one</li>
                    <li>List item two</li>
                    <li>List item three</li>
                </ul>
            </div>
            <h3>Section 4 <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></h3>
            <div class="ac">
                <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group range">
            <label><?php esc_html_e('Price Range', 'realeswp'); ?></label>
            <div class="formField">
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>price_form]" id="search_min_price" value="0" />
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>price_to]" id="search_max_price" value="15000000" />
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
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>area_from]" id="search_min_area" value="0" />
                <input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>area_to]" id="search_max_area" value="5000" />
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
            <?php
            $bedrooms = array(
                "0" => 'Studio',
                "1" => '1+',
                "2" => '2+',
                "3" => '3+',
                "4" => '4+',
                "5" => '5+');
            ?>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php esc_html_e('Bedrooms', 'realeswp'); ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu filter-menus">
                    <?php foreach ($bedrooms as $key => $value) { ?>
                        <li>
                            <label>
                                <input type="checkbox" value="<?php echo $key; ?>" name="meta[<?php echo METABOX_PREFIX; ?>bedrooms][]" /><?php echo $value; ?>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filter-wrapper">
        <div class="form-group">
            <?php
            $bathrooms = array(
                "1" => '1+',
                "2" => '2+',
                "3" => '3+',
                "4" => '4+',
                "5" => '5+');
            ?>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php esc_html_e('Bathrooms', 'realeswp'); ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu filter-menus">
                    <?php foreach ($bathrooms as $key => $value) { ?>
                        <li>
                            <label>
                                <input type="checkbox" value="<?php echo $key; ?>" name="meta[<?php echo METABOX_PREFIX; ?>bathrooms][]" /><?php echo $value; ?>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div>
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
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $field['name']; ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu filter-menus">
                        <?php foreach ($list as $item) { ?>
                            <?php if ($item): ?>
                                <li>
                                    <label>
                                        <input type="checkbox" value="<?php echo $item; ?>" name="meta[<?php echo METABOX_PREFIX; ?><?php echo str_replace(' ', "_", strtolower($field['label'])); ?>][]" /><?php echo $item; ?>
                                    </label>
                                </li>
                            <?php endif; ?>
                        <?php } ?>
                    </ul>
                </div>
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
                                <input type="checkbox" name="meta[<?php echo METABOX_PREFIX; ?>amenities][]" value="<?php echo $item['label']; ?>">
                                <?php echo $item['label']; ?>
                            </label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
