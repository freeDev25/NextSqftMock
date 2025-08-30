<?php
/**
 * @package WordPress
 * @subpackage Reales
 */

if( !function_exists('reales_admin_appearance') ): 
    function reales_admin_appearance() {
        add_settings_section( 'reales_appearance_section', __( 'Appearance', 'realeswp' ), 'reales_appearance_section_callback', 'reales_appearance_settings' );
        add_settings_field( 'reales_user_menu_field', __( 'Show user menu in header', 'realeswp' ), 'reales_user_menu_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_header_field', __( 'Homepage header type', 'realeswp' ), 'reales_home_header_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_autoslide_field', __( 'Custom slider autoslide', 'realeswp' ), 'reales_autoslide_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_rev_alias_field', __( 'Slider Revolution alias', 'realeswp' ), 'reales_home_rev_alias_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_header_video_field', __( 'Homepage header video (mp4)', 'realeswp' ), 'reales_home_header_video_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_header_video_cover_field', __( 'Homepage header video cover', 'realeswp' ), 'reales_home_header_video_cover_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_shadow_opacity_field', __( 'Header image shadow opacity', 'realeswp' ), 'reales_shadow_opacity_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_caption_field', __( 'Show homepage caption', 'realeswp' ), 'reales_home_caption_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_caption_title_field', __( 'Homepage caption title', 'realeswp' ), 'reales_home_caption_title_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_caption_subtitle_field', __( 'Homepage caption subtitle', 'realeswp' ), 'reales_home_caption_subtitle_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_caption_cta_field', __( 'Show homepage caption cta button', 'realeswp' ), 'reales_home_caption_cta_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_caption_cta_text_field', __( 'Homepage caption cta button text', 'realeswp' ), 'reales_home_caption_cta_text_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_caption_cta_link_field', __( 'Homepage caption cta button link', 'realeswp' ), 'reales_home_caption_cta_link_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_spotlight_field', __( 'Show homepage spotlight section', 'realeswp' ), 'reales_home_spotlight_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_spotlight_title_field', __( 'Homepage spotlight section title', 'realeswp' ), 'reales_home_spotlight_title_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_spotlight_text_field', __( 'Homepage spotlight section text', 'realeswp' ), 'reales_home_spotlight_text_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_home_search_design_field', __( 'Homepage search form design', 'realeswp' ), 'reales_home_search_design_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_sidebar_field', __( 'Sidebar position', 'realeswp' ), 'reales_sidebar_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_map_position_field', __( 'Map position', 'realeswp' ), 'reales_map_position_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_map_marker_field', __( 'Map marker type', 'realeswp' ), 'reales_map_marker_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_mobile_first_field', __( 'Mobile display first', 'realeswp' ), 'reales_mobile_first_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_filter_display_field', __( 'Filter form default display', 'realeswp' ), 'reales_filter_display_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_nomap_field', __( 'Disable side map on properties pages', 'realeswp' ), 'reales_nomap_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_related_field', __( 'Show related articles on blog post', 'realeswp' ), 'reales_related_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_leftside_menu_field', __( 'Show left side menu in app view', 'realeswp' ), 'reales_leftside_menu_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_properties_per_page_field', __( 'Number of properties per page', 'realeswp' ), 'reales_properties_per_page_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_agents_per_page_field', __( 'Number of agents per page', 'realeswp' ), 'reales_agents_per_page_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_similar_field', __( 'Show similar properties on property page', 'realeswp' ), 'reales_similar_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_breadcrumbs_field', __( 'Show breadcrumbs on pages', 'realeswp' ), 'reales_breadcrumbs_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
        add_settings_field( 'reales_copyright_field', __( 'Copyright text', 'realeswp' ), 'reales_copyright_field_render', 'reales_appearance_settings', 'reales_appearance_section' );
    }
endif;

if( !function_exists('reales_appearance_section_callback') ): 
    function reales_appearance_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('reales_user_menu_field_render') ): 
    function reales_user_menu_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_user_menu_field]" <?php if(isset($options['reales_user_menu_field'])) { checked( $options['reales_user_menu_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_home_header_field_render') ): 
    function reales_home_header_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        $headers = array("slideshow", "custom slider", "slider revolution", "video", "google map");
        $header_select = '<select id="reales_appearance_settings[reales_home_header_field]" name="reales_appearance_settings[reales_home_header_field]">';

        foreach($headers as $header) {
            $header_select .= '<option value="' . esc_attr($header) . '"';
            if(isset($options['reales_home_header_field']) && $options['reales_home_header_field'] == $header) {
                $header_select .= 'selected="selected"';
            }
            $header_select .= '>' . esc_html($header) . '</option>';
        }

        $header_select .= '</select>';
        $header_select .= '<p class="help">For Slider Revolution option you need to have the plugin (the theme doesn\'t inlcude the plugin).</p>';

        print $header_select;
    }
endif;

if( !function_exists('reales_autoslide_field_render') ): 
    function reales_autoslide_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[autoslide_delay]" style="margin-right: 20px;" <?php if(isset($options['autoslide_delay'])) { checked( $options['autoslide_delay'], 1 ); } ?>  value="1">
        <label class="sliderLabel">
            <?php esc_html_e('Delay time', 'realeswp');?>:&nbsp;
            <input type="text" size="6" name="reales_appearance_settings[autoslide_delay_time]" value="<?php if(isset($options['autoslide_delay_time'])) { echo esc_attr($options['autoslide_delay_time']); } ?>">
            <i><?php esc_html_e('miliseconds', 'realeswp'); ?></i>
        </label>
        <?php
    }
endif;

if( !function_exists('reales_home_rev_alias_field_render') ): 
    function reales_home_rev_alias_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="40" name="reales_appearance_settings[reales_home_rev_alias_field]" value="<?php if(isset($options['reales_home_rev_alias_field'])) { echo esc_attr($options['reales_home_rev_alias_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_header_video_field_render') ): 
    function reales_home_header_video_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input id="homeVideo" type="text" size="40" name="reales_appearance_settings[reales_home_header_video_field]" value="<?php if(isset($options['reales_home_header_video_field'])) { echo esc_attr($options['reales_home_header_video_field']); } ?>" />
        <input id="homeVideoBtn" type="button"  class="button" value="<?php esc_html_e('Browse...','realeswp') ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_header_video_cover_field_render') ): 
    function reales_home_header_video_cover_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input id="homeVideoCover" type="text" size="40" name="reales_appearance_settings[reales_home_header_video_cover_field]" value="<?php if(isset($options['reales_home_header_video_cover_field'])) { echo esc_attr($options['reales_home_header_video_cover_field']); } ?>" />
        <input id="homeVideoCoverBtn" type="button"  class="button" value="<?php esc_html_e('Browse...','realeswp') ?>" />
        <p class="help">Set video cover for devices that doesn't spport video backgrounds.</p>
        <?php
    }
endif;

if( !function_exists('reales_shadow_opacity_field_render') ): 
    function reales_shadow_opacity_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        $opacities = array("0", "10", "20", "30", "40", "50", "60", "70", "80", "90");
        $opacity_select = '<select id="reales_appearance_settings[reales_shadow_opacity_field]" name="reales_appearance_settings[reales_shadow_opacity_field]">';

        foreach($opacities as $opacity) {
            $opacity_select .= '<option value="' . esc_attr($opacity) . '"';
            if(isset($options['reales_shadow_opacity_field']) && $options['reales_shadow_opacity_field'] == $opacity) {
                $opacity_select .= 'selected="selected"';
            }
            $opacity_select .= '>' . esc_html($opacity) . '</option>';
        }

        $opacity_select .= '</select> %';

        print $opacity_select;
    }
endif;

if( !function_exists('reales_home_caption_field_render') ): 
    function reales_home_caption_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_home_caption_field]" <?php if(isset($options['reales_home_caption_field'])) { checked( $options['reales_home_caption_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_home_caption_title_field_render') ): 
    function reales_home_caption_title_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="40" name="reales_appearance_settings[reales_home_caption_title_field]" value="<?php if(isset($options['reales_home_caption_title_field'])) { echo esc_attr($options['reales_home_caption_title_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_caption_subtitle_field_render') ): 
    function reales_home_caption_subtitle_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="40" name="reales_appearance_settings[reales_home_caption_subtitle_field]" value="<?php if(isset($options['reales_home_caption_subtitle_field'])) { echo esc_attr($options['reales_home_caption_subtitle_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_caption_cta_field_render') ): 
    function reales_home_caption_cta_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_home_caption_cta_field]" <?php if(isset($options['reales_home_caption_cta_field'])) { checked( $options['reales_home_caption_cta_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_home_caption_cta_text_field_render') ): 
    function reales_home_caption_cta_text_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="40" name="reales_appearance_settings[reales_home_caption_cta_text_field]" value="<?php if(isset($options['reales_home_caption_cta_text_field'])) { echo esc_attr($options['reales_home_caption_cta_text_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_caption_cta_link_field_render') ): 
    function reales_home_caption_cta_link_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="40" name="reales_appearance_settings[reales_home_caption_cta_link_field]" value="<?php if(isset($options['reales_home_caption_cta_link_field'])) { echo esc_attr($options['reales_home_caption_cta_link_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_spotlight_field_render') ): 
    function reales_home_spotlight_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_home_spotlight_field]" <?php if(isset($options['reales_home_spotlight_field'])) { checked( $options['reales_home_spotlight_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_home_spotlight_title_field_render') ): 
    function reales_home_spotlight_title_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="40" name="reales_appearance_settings[reales_home_spotlight_title_field]" value="<?php if(isset($options['reales_home_spotlight_title_field'])) { echo esc_attr($options['reales_home_spotlight_title_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_home_spotlight_text_field_render') ): 
    function reales_home_spotlight_text_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <textarea cols='40' rows='5' name='reales_appearance_settings[reales_home_spotlight_text_field]'><?php if(isset($options['reales_home_spotlight_text_field'])) { echo esc_html($options['reales_home_spotlight_text_field']); } ?></textarea>
        <?php
    }
endif;

if( !function_exists('reales_home_search_design_field_render') ): 
    function reales_home_search_design_field_render() { 
        $options = get_option('reales_appearance_settings');
        $designs = array(
            'd1' => __('Header bottom (default)', 'realeswp'),
            'd2' => __('Header bottom floating', 'realeswp'),
            'd3' => __('Header bottom floating with tabs', 'realeswp'),
        );

        $design_select = '<select id="reales_appearance_settings[reales_home_search_design_field]" name="reales_appearance_settings[reales_home_search_design_field]">';

        foreach($designs as $key => $value) {
            $design_select .= '<option value="' . esc_attr($key) . '"';

            if(isset($options['reales_home_search_design_field']) && $options['reales_home_search_design_field'] == $key) {
                $design_select .= 'selected="selected"';
            }

            $design_select .= '>' . esc_html($value) . '</option>';
        }

        $design_select .= '</select>';

        print $design_select;
    }
endif;

if( !function_exists('reales_sidebar_field_render') ): 
    function reales_sidebar_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        $sidebars = array("left", "right");
        $sidebar_select = '<select id="reales_appearance_settings[reales_sidebar_field]" name="reales_appearance_settings[reales_sidebar_field]">';

        foreach($sidebars as $sidebar) {
            $sidebar_select .= '<option value="' . esc_attr($sidebar) . '"';
            if(isset($options['reales_sidebar_field']) && $options['reales_sidebar_field'] == $sidebar) {
                $sidebar_select .= 'selected="selected"';
            }
            $sidebar_select .= '>' . esc_html($sidebar) . '</option>';
        }

        $sidebar_select .= '</select>';

        print $sidebar_select;
    }
endif;

if( !function_exists('reales_map_position_field_render') ): 
    function reales_map_position_field_render() { 
        $options = get_option('reales_appearance_settings');
        $positions = array(
            'left'  => __('left', 'realeswp'),
            'right' => __('right', 'realeswp'),
        );

        $position_select = '<select id="reales_appearance_settings[reales_map_position_field]" name="reales_appearance_settings[reales_map_position_field]">';

        foreach($positions as $key => $value) {
            $position_select .= '<option value="' . esc_attr($key) . '"';

            if(isset($options['reales_map_position_field']) && $options['reales_map_position_field'] == $key) {
                $position_select .= 'selected="selected"';
            }

            $position_select .= '>' . esc_html($value) . '</option>';
        }

        $position_select .= '</select>';

        print $position_select;
    }
endif;

if( !function_exists('reales_map_marker_field_render') ): 
    function reales_map_marker_field_render() { 
        $options = get_option('reales_appearance_settings');
        $markers = array(
            'pin'   => __('pin', 'realeswp'),
            'price' => __('price', 'realeswp'),
        );

        $marker_select = '<select id="reales_appearance_settings[reales_map_marker_field]" name="reales_appearance_settings[reales_map_marker_field]">';

        foreach($markers as $key => $value) {
            $marker_select .= '<option value="' . esc_attr($key) . '"';

            if(isset($options['reales_map_marker_field']) && $options['reales_map_marker_field'] == $key) {
                $marker_select .= 'selected="selected"';
            }

            $marker_select .= '>' . esc_html($value) . '</option>';
        }

        $marker_select .= '</select>';

        print $marker_select;
    }
endif;

if( !function_exists('reales_mobile_first_field_render') ): 
    function reales_mobile_first_field_render() { 
        $options = get_option('reales_appearance_settings');
        $views = array(
            'map'  => __('map', 'realeswp'),
            'list' => __('list', 'realeswp'),
        );

        $view_select = '<select id="reales_appearance_settings[reales_mobile_first_field]" name="reales_appearance_settings[reales_mobile_first_field]">';

        foreach($views as $key => $value) {
            $view_select .= '<option value="' . esc_attr($key) . '"';

            if(isset($options['reales_mobile_first_field']) && $options['reales_mobile_first_field'] == $key) {
                $view_select .= 'selected="selected"';
            }

            $view_select .= '>' . esc_html($value) . '</option>';
        }

        $view_select .= '</select>';

        print $view_select;
    }
endif;

if( !function_exists('reales_filter_display_field_render') ): 
    function reales_filter_display_field_render() { 
        $options = get_option('reales_appearance_settings');
        $displays = array(
            'expanded'  => __('expanded', 'realeswp'),
            'collapsed' => __('collapsed', 'realeswp'),
        );

        $display_select = '<select id="reales_appearance_settings[reales_filter_display_field]" name="reales_appearance_settings[reales_filter_display_field]">';

        foreach($displays as $key => $value) {
            $display_select .= '<option value="' . esc_attr($key) . '"';

            if(isset($options['reales_filter_display_field']) && $options['reales_filter_display_field'] == $key) {
                $display_select .= 'selected="selected"';
            }

            $display_select .= '>' . esc_html($value) . '</option>';
        }

        $display_select .= '</select>';

        print $display_select;
    }
endif;


if( !function_exists('reales_nomap_field_render') ): 
    function reales_nomap_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_nomap_field]" <?php if(isset($options['reales_nomap_field'])) { checked( $options['reales_nomap_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_related_field_render') ): 
    function reales_related_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_related_field]" <?php if(isset($options['reales_related_field'])) { checked( $options['reales_related_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_leftside_menu_field_render') ): 
    function reales_leftside_menu_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_leftside_menu_field]" <?php if(isset($options['reales_leftside_menu_field'])) { checked( $options['reales_leftside_menu_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_properties_per_page_field_render') ): 
    function reales_properties_per_page_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="5" name="reales_appearance_settings[reales_properties_per_page_field]" value="<?php if(isset($options['reales_properties_per_page_field'])) { echo esc_attr($options['reales_properties_per_page_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_agents_per_page_field_render') ): 
    function reales_agents_per_page_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="text" size="5" name="reales_appearance_settings[reales_agents_per_page_field]" value="<?php if(isset($options['reales_agents_per_page_field'])) { echo esc_attr($options['reales_agents_per_page_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('reales_similar_field_render') ): 
    function reales_similar_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_similar_field]" <?php if(isset($options['reales_similar_field'])) { checked( $options['reales_similar_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_breadcrumbs_field_render') ): 
    function reales_breadcrumbs_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <input type="checkbox" name="reales_appearance_settings[reales_breadcrumbs_field]" <?php if(isset($options['reales_breadcrumbs_field'])) { checked( $options['reales_breadcrumbs_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('reales_copyright_field_render') ): 
    function reales_copyright_field_render() { 
        $options = get_option( 'reales_appearance_settings' );
        ?>
        <textarea cols='40' rows='5' name='reales_appearance_settings[reales_copyright_field]'><?php if(isset($options['reales_copyright_field'])) { echo esc_html($options['reales_copyright_field']); } ?></textarea>
        <?php
    }
endif;

?>