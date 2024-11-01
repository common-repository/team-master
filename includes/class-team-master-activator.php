<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    Team_Master
 * @subpackage Team_Master/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Team_Master
 * @subpackage Team_Master/includes
 * @author     Adnan Moqsood <adnanmoqsood@gmail.com>
 */
class Team_Master_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {

        add_option('tm_default_template', 1, '', 'yes');
        add_option('tm_default_column', 3, '', 'yes');
        add_option('tm_default_perpage', -1, '', 'yes');
        add_option('tm_default_background_color', '#f1f1f1', '', 'yes');
        add_option('tm_default_color', '#000000', '', 'yes');
        add_option('tm_default_load_more', 'no', '', 'yes');

        /*         * *********** Button default options *************** */
        add_option('tm_default_btn_color', '#ddd', '', 'yes');
        add_option('tm_default_btn_font_color', '#000', '', 'yes');

        /*         * ********** Carousel default options *************** */
        add_option('tm_default_activate_carousel', 'no', '', 'yes');
        add_option('tm_default_auto_play_carousel', 'no', '', 'yes');

        /*         * ********* Template default color options *************** */
        add_option('tm_default_title_color', '#000000', '', 'yes');
        add_option('tm_default_designation_color', '#000000', '', 'yes');
    }

}
