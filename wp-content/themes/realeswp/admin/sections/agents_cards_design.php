<?php
/**
 * @package WordPress
 * @subpackage Reales
 */

if( !function_exists('reales_admin_agent_cards_design') ): 
    function reales_admin_agent_cards_design() {
        add_settings_section( 'reales_agent_cards_design_section', __( 'Agent Cards Design', 'realeswp' ), 'reales_agent_cards_design_section_callback', 'reales_agent_cards_design_settings' );
    }
endif;

if( !function_exists('reales_agent_cards_design_section_callback') ): 
    function reales_agent_cards_design_section_callback() { 
        wp_nonce_field('agent_cards_ajax_nonce', 'securityAgentCards', true);

        $options = get_option('reales_agent_cards_design_settings');

        $card_types = array(
            'd1' => __('Design 1 (default)', 'realeswp'),
            'd2' => __('Design 2', 'realeswp'),
        ); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php esc_html_e('Card type', 'realeswp'); ?></th>
                    <td>
                        <select name="agent_card_type" id="agent_card_type">
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
            <div class="col-xs-12 col-sm-4">
                <h4><?php esc_html_e('Preview','realeswp'); ?></h4>

                <div class="agent-sample-card agent-sample-card-1" id="agent-card-design-1">
                    <div class="agentsItemPhoto" style="background-image:url(<?php echo get_template_directory_uri() . '/images/avatar.png'; ?>);">
                        <div class="agentsItemBg"></div>
                        <a class="agentsItemAvatar" href="#">
                            <img src="<?php echo get_template_directory_uri() . '/images/avatar.png'; ?>">
                        </a>
                    </div>
                    <div class="agentsItemName">
                        <a href="#">Melvin Blackwell</a>
                    </div>
                    <div class="reviewRating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></div>
                    <div class="agentsItemContact">
                        <div class="agentsItemContactItem">
                            <span class="fa fa-building-o"></span> Reales WP
                        </div>
                        <div class="agentsItemContactItem">
                            <span class="fa fa-phone"></span> (123) 456-7890
                        </div>
                        <div class="agentsItemContactItem">
                            <span class="fa fa-mobile"></span> (123) 456-7890
                        </div>
                        <div class="agentsItemContactItem">
                            <span class="fa fa-envelope"></span> melvin.blackwell@realeswp.com
                        </div>
                        <div class="agentsItemContactItem">
                            <span class="fa fa-skype"></span> melvin.blackwell
                        </div>
                    </div>
                    <div class="agentsItemSocial">
                        <a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-facebook" target="_blank"><span class="fa fa-facebook"></span></a>
                        <a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-twitter" target="_blank"><span class="fa fa-twitter"></span></a>
                        <a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>
                    </div>
                </div>

                <div class="agent-sample-card agent-sample-card-2" id="agent-card-design-2">
                    <a class="agentsItem-2-fig" href="#" style="background-image: url(<?php echo get_template_directory_uri() . '/images/avatar.png'; ?>)"></a>
                    <a class="agentsItem-2-name" href="#">Melvin Blackwell</a>
                    <div class="agentsItem-2-specs">House Sales and Rentals</div>
                    <div class="agentsItem-2-contact">
                        <div class="agentsItem-2-email"><a href="#">melvin.blackwell@realeswp.com</a></div>
                        <div class="agentsItem-2-phone"><a href="#">(123) 456-7890</a></div>
                    </div>
                    <ul class="agentsItem-2-social">
                        <li><a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-facebook" target="_blank"><span class="fa fa-facebook"></span></a></li>
                        <li><a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-twitter" target="_blank"><span class="fa fa-twitter"></span></a></li>
                        <li><a href="#" class="btn btn-sm btn-icon btn-round btn-o btn-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <p class="submit"><input type="button" name="save_agent_cards_design" id="save_agent_cards_design" class="button button-primary" value="<?php esc_html_e('Save Changes', 'realeswp'); ?>">&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner preloader"></span></p>
    <?php }
endif;

if( !function_exists('reales_save_agent_cards_design') ): 
    function reales_save_agent_cards_design () {
        check_ajax_referer('agent_cards_ajax_nonce', 'security');

        $card_type = isset($_POST['card_type']) ? sanitize_text_field($_POST['card_type']) : '';

        $reales_agent_cards_design_settings = get_option('reales_agent_cards_design_settings');

        if(!is_array($reales_agent_cards_design_settings)) {
            $reales_agent_cards_design_settings = array();
        }

        $reales_agent_cards_design_settings['card_type'] = $card_type;

        update_option('reales_agent_cards_design_settings', $reales_agent_cards_design_settings);

        echo json_encode(array('add'=>true));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_reales_save_agent_cards_design', 'reales_save_agent_cards_design' );
add_action( 'wp_ajax_reales_save_agent_cards_design', 'reales_save_agent_cards_design' );
?>