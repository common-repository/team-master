<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Add-on Name: Team Master
 * Author: Adnan Moqsood
 * Since 1.0.7
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('js_composer/js_composer.php')) {
    if (!class_exists("team_master_vc_shortcode")) {

        /*
         * New Parameter for displaying the multiselect in Visual composer shortcode
         */
        vc_add_shortcode_param('dropdown_multi', 'dropdown_multi_settings_field');

        function dropdown_multi_settings_field($param, $value) {
            $param_line = '';
            $param_line .= '<select multiple name="' . esc_attr($param['param_name']) . '" class="wpb_vc_param_value wpb-input wpb-select ' . esc_attr($param['param_class']) . ' ' . esc_attr($param['type']) . '">';
            foreach ($param['value'] as $text_val => $val) {
                if (is_numeric($text_val) && (is_string($val) || is_numeric($val))) {
                    $text_val = $val;
                }
                $text_val = __($text_val, "js_composer");
                $selected = '';

                if (!is_array($value)) {
                    $param_value_arr = explode(',', $value);
                } else {
                    $param_value_arr = $value;
                }

                if ($value !== '' && in_array($val, $param_value_arr)) {
                    $selected = ' selected="selected"';
                }
                $param_line .= '<option class="' . $val . '" value="' . $val . '"' . $selected . '>' . $text_val . '</option>';
            }
            $param_line .= '</select>';

            return $param_line;
        }

        /**
         * 
         */
        class team_master_vc_shortcode {

            /**
             * @hook Shortcode
             * Init shortcode
             */
            function __construct() {
                add_action("admin_init", array($this, "team_master_vc_shortcode_init"));
            }

            /**
             * 
             * @global type $wpdb
             * @global type $post
             * @global type $wp_query
             * @since
             * 
             */
            public function team_master_vc_shortcode_init() {

                if (!defined('WPB_VC_VERSION')) {
                    return;
                }
                $terms = get_terms('tm_members_role', array(
                    'hide_empty' => false,
                ));
                $terms_list = array('Select Member Role' => '');
                if ($terms) {
                    foreach ($terms as $key => $term) {
                        $terms_list[$term->name] = $term->term_id;
                    }
                } else {
                    $terms_list[__('No term found', 'js_composer')] = 0;
                }
                $template_list = array();
                $templates = array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4
                );
                if ($templates) {
                    $custom_img_url = '';
                    $img_url = apply_filters('add_template_thumbnail_admin', $custom_img_url);
                    if (!empty($img_url)) {
                        array_push($templates, "custom");
                    }

                    foreach ($templates as $key => $template) {
                        $template_list[$key] = $template;
                    }
                } else {
                    $template_list[__('No template found', 'js_composer')] = 0;
                }

                $tmposts = get_posts(array(
                    'posts_per_page' => -1,
                    'post_type' => 'tm_members',
                        )
                );
                $members_list = array('Select Members' => '');
                if ($tmposts) {
                    foreach ($tmposts as $key => $member) {
                        $members_list[$member->post_title] = $member->ID;
                    }
                } else {
                    $terms_list[__('No Member found', 'js_composer')] = 0;
                }

                vc_map(
                        array(
                            'name' => __('Team Master', 'team-mater'),
                            'base' => 'team_master',
                            "icon" => "",
                            'description' => __('Team Master is a most amazing plugin to create and manage your Teams', 'team-master'),
                            'params' => array(
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __("Templates", "team-master"),
                                    'param_name' => 'template',
                                    'value' => $template_list,
                                    'std' => get_option('tm_default_template'),
                                    'description' => __('Select the template to display at frontend')
                                ),
                                array(
                                    "type" => "dropdown_multi",
                                    "heading" => esc_html__("Choose Members Group", 'team-master'),
                                    "param_name" => "role",
                                    "param_class" => 'ts-members-basic-multiple',
                                    "value" => $terms_list,
                                ),
                                array(
                                    "type" => "dropdown_multi",
                                    "heading" => esc_html__("Exclude Members", 'team-master'),
                                    "param_name" => "exclude_members",
                                    "param_class" => 'ts-members-basic-multiple',
                                    "value" => $members_list,
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => __("Background", "team-master"),
                                    "param_name" => "background",
                                    "value" => get_option('tm_default_background_color'),
                                    "description" => __("Choose template background color", "team-master")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => __("Title Color", "team-master"),
                                    "param_name" => "titlecolor",
                                    "value" => get_option('tm_default_title_color'),
                                    "description" => __("Choose template title color", "team-master")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => __("Designation Color", "team-master"),
                                    "param_name" => "designationcolor",
                                    "value" => get_option('tm_default_designation_color'),
                                    "description" => __("Choose template designation color", "team-master")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => __("Description Color", "team-master"),
                                    "param_name" => "color",
                                    "value" => get_option('tm_default_color'),
                                    "description" => __("Choose template description color", "team-master")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => __("Button Background Color", "team-master"),
                                    "param_name" => "btnbg",
                                    "value" => get_option('tm_default_btn_color'),
                                    "description" => __("Choose template button background color", "team-master")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => __("Button Color", "team-master"),
                                    "param_name" => "btncolor",
                                    "value" => get_option('tm_default_btn_font_color'),
                                    "description" => __("Choose template button color", "team-master")
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __("Columns/Slides to Display?", "team-master"),
                                    'param_name' => 'columns',
                                    'value' => array(
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4'
                                    ),
                                    'std' => get_option('tm_default_column'), // Your default value
                                    'description' => __('Select the total number of columns/slides to display at frontend')
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __("Members to Show/Scroll?", "team-master"),
                                    'param_name' => 'per_page',
                                    'value' => array(
                                        '-1' => '-1',
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '5' => '5',
                                        '6' => '6',
                                        '7' => '7',
                                        '8' => '8',
                                        '9' => '9',
                                        '10' => '10',
                                        '11' => '11',
                                        '12' => '12',
                                        '13' => '13',
                                        '14' => '14',
                                        '15' => '15',
                                        '16' => '16',
                                        '17' => '17',
                                        '18' => '18',
                                        '19' => '19',
                                        '20' => '20'
                                    ),
                                    'std' => get_option('tm_default_perpage'), // Your default value
                                    'description' => __('Select the total number of members to show/scroll at frontend')
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __("Display Load More Button?", "team-master"),
                                    'param_name' => 'load_more',
                                    'value' => array(
                                        'yes' => 'yes',
                                        'no' => 'no',
                                    ),
                                    'std' => get_option('tm_default_load_more'),
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __("Activate Carousel?", "team-master"),
                                    'param_name' => 'carousel',
                                    'value' => array(
                                        'yes' => 'yes',
                                        'no' => 'no',
                                    ),
                                    'std' => get_option('tm_default_activate_carousel'),
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __("Auto Play Carousel?", "team-master"),
                                    'param_name' => 'autoplay',
                                    'value' => array(
                                        'yes' => 'yes',
                                        'no' => 'no',
                                    ),
                                    'std' => get_option('tm_default_auto_play_carousel'),
                                )
                            )
                        )
                );
            }

        }

        new team_master_vc_shortcode;
        if (class_exists('WPBakeryShortCode')) {

            class WPBakeryShortCode_team_master_vc_shortcode extends WPBakeryShortCode {
                
            }

        }
    }
}