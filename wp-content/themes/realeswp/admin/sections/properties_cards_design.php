<?php
/**
 * @package WordPress
 * @subpackage Reales
 */

if( !function_exists('reales_admin_prop_cards_design') ): 
    function reales_admin_prop_cards_design() {
        add_settings_section( 'reales_prop_cards_design_section', __( 'Property Cards Design', 'realeswp' ), 'reales_prop_cards_design_section_callback', 'reales_prop_cards_design_settings' );
    }
endif;

if( !function_exists('reales_prop_cards_design_section_callback') ): 
    function reales_prop_cards_design_section_callback() { 
        wp_nonce_field('prop_cards_ajax_nonce', 'securityPropCards', true); 

        $options = get_option('reales_prop_cards_design_settings');

        $card_types = array(
            'd1' => __('Design 1 (default)', 'realeswp'),
            'd2' => __('Design 2', 'realeswp'),
        ); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php esc_html_e('Card type', 'realeswp'); ?></th>
                    <td>
                        <select name="card_type" id="card_type">
                            <?php foreach($card_types as $key => $value) { ?>
                                <option value="<?php echo esc_attr($key);?>"
                                    <?php if(isset($options['card_type']) && $options['card_type'] == $key) {
                                        echo esc_attr(' selected="selected"');
                                    } ?>>
                                <?php echo esc_html($value); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h4><?php esc_html_e('Preview','realeswp'); ?></h4>

                <a href="#" class="sample-card sample-card-1" id="card-design-1">
                    <div class="figure">
                        <div class="img" style="background-image:url(<?php echo get_template_directory_uri() . '/images/default-image-600x400.jpg'; ?>);"></div>
                        <div class="figCaption">
                            <div>$2,430,000</div>
                            <span><span class="icon-eye"></span> 1514</span>
                            <span><span class="icon-heart"></span> 230</span>
                            <span><span class="icon-bubble"></span> 120</span>
                        </div>
                        <div class="figView"><span class="icon-eye"></span></div>
                        <div class="figType" style="background-color: #eab134">For Sale</div>
                    </div>
                    <h2>Luxury Mansion</h2>
                    <div class="cardAddress">320 Sea Cliff Avenue, Sea Cliff, San Francisco<br />CA 94121</div>
                    <ul class="cardFeat">
                        <li><span class="fa fa-moon-o"></span> 3</li>
                        <li><span class="icon-drop"></span> 2</li>
                        <li><span class="icon-frame"></span> 3400 sq ft</li>
                    </ul>
                    <div class="clearfix"></div>
                </a>

                <a href="#" class="sample-card sample-card-2" id="card-design-2">
                    <div id="sample-card-2-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#sample-card-2-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#sample-card-2-carousel" data-slide-to="1"></li>
                            <li data-target="#sample-card-2-carousel" data-slide-to="2"></li>
                            <li data-target="#sample-card-2-carousel" data-slide-to="3"></li>
                            <li data-target="#sample-card-2-carousel" data-slide-to="4"></li>
                        </ol>

                        <div class="carousel-inner" role="listbox">
                            <div class="item active" style="background-image: url(<?php echo get_template_directory_uri() . '/images/default-image-600x400.jpg'; ?>)"></div>
                            <div class="item" style="background-image: url(<?php echo get_template_directory_uri() . '/images/default-image-600x400.jpg'; ?>)"></div>
                            <div class="item" style="background-image: url(<?php echo get_template_directory_uri() . '/images/default-image-600x400.jpg'; ?>)"></div>
                            <div class="item" style="background-image: url(<?php echo get_template_directory_uri() . '/images/default-image-600x400.jpg'; ?>)"></div>
                            <div class="item" style="background-image: url(<?php echo get_template_directory_uri() . '/images/default-image-600x400.jpg'; ?>)"></div>
                        </div>

                        <span class="left carousel-control" href="#sample-card-2-carousel" role="button" data-slide="prev">
                            <span class="fa fa-angle-left" aria-hidden="true"></span>
                        </span>
                        <span class="right carousel-control" href="#sample-card-2-carousel" role="button" data-slide="next">
                            <span class="fa fa-angle-right" aria-hidden="true"></span>
                        </span>

                        <div class="featured-label"><?php esc_html_e('Featured', 'realeswp'); ?></div>
                    </div>

                    <div class="property-labels">
                        <div class="property-labels-type">For Sale</div>
                        <div class="property-labels-category">House</div>
                    </div>
                    <h3>Luxury Mansion</h3>
                    <div class="property-address">320 Sea Cliff Avenue, Sea Cliff, San Francisco</div>
                    <div class="property-price">$2,430,000</div>
                    <ul class="property-features">
                        <li><span class="fa fa-bed"></span> 3</li>
                        <li><span class="fa fa-bath"></span> 2</li>
                        <li><span class="fa fa-th"></span> 3400 sq ft</li>
                    </ul>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>

        <p class="submit"><input type="button" name="save_cards_design" id="save_cards_design" class="button button-primary" value="<?php esc_html_e('Save Changes', 'realeswp'); ?>">&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner preloader"></span></p>
    <?php }
endif;

if( !function_exists('reales_save_cards_design') ): 
    function reales_save_cards_design () {
        check_ajax_referer('prop_cards_ajax_nonce', 'security');

        $card_type = isset($_POST['card_type']) ? sanitize_text_field($_POST['card_type']) : '';

        $reales_prop_cards_design_settings = get_option('reales_prop_cards_design_settings');

        if(!is_array($reales_prop_cards_design_settings)) {
            $reales_prop_cards_design_settings = array();
        }

        $reales_prop_cards_design_settings['card_type'] = $card_type;

        update_option('reales_prop_cards_design_settings', $reales_prop_cards_design_settings);

        echo json_encode(array('add'=>true));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_reales_save_cards_design', 'reales_save_cards_design' );
add_action( 'wp_ajax_reales_save_cards_design', 'reales_save_cards_design' );
?>