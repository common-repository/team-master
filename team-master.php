<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org
 * @since             1.1.1
 * @package           Team_Master
 *
 * @wordpress-plugin
 * Plugin Name:       Team Master
 * Plugin URI:        https://wordpress.org
 * Description:       Team Master is a most amazing plugin to create and manage your Team Pages and Boxes Just using a simple shortcode.Packed with different pre-defined templates and styles to choose from.
 * Version:           1.1.2
 * Author:            Adnan Moqsood
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       team-master
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TEAM_MASTER_VERSION', '1.1.2');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-team-master-activator.php
 */
function activate_team_master() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-team-master-activator.php';
    Team_Master_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-team-master-deactivator.php
 */
function deactivate_team_master() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-team-master-deactivator.php';
    Team_Master_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_team_master');
register_deactivation_hook(__FILE__, 'deactivate_team_master');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-team-master.php';

function tm_plugin_add_settings_link($links) {
    $settings_link = '<a href="edit.php?post_type=tm_members&page=team-master-settings">' . __('Settings', 'team-master') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'tm_plugin_add_settings_link');

/**
 * This function runs when WordPress completes its upgrade process
 * It iterates through each plugin updated to see if ours is included
 * @param $upgrader_object Array
 * @param $options Array
 */
function team_master_upgrade_completed($upgrader_object, $options) {
    // The path to our plugin's main file
    $team_master_plugin = plugin_basename(__FILE__);
    // If an update has taken place and the updated type is plugins and the plugins element exists
    if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset($options['plugins'])) {
        // Iterate through the plugins being updated and check if ours is there
        foreach ($options['plugins'] as $plugin) {
            if ($plugin == $team_master_plugin) {
                if (!get_option('tm_default_btn_color')) {
                    update_option('tm_default_btn_color', '#ddd');
                }
                if (!get_option('tm_default_btn_font_color')) {
                    update_option('tm_default_btn_font_color', '#000');
                }
                if (!get_option('tm_default_activate_carousel')) {
                    update_option('tm_default_activate_carousel', 'no');
                }
                if (!get_option('tm_default_auto_play_carousel')) {
                    update_option('tm_default_auto_play_carousel', 'no');
                }
                if (!get_option('tm_default_title_color')) {
                    update_option('tm_default_title_color', '#000000');
                }
                if (!get_option('tm_default_designation_color')) {
                    update_option('tm_default_designation_color', '#000000');
                }
            }
        }
    }
}

add_action('upgrader_process_complete', 'team_master_upgrade_completed', 10, 2);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_team_master() {

    $plugin = new Team_Master();
    $plugin->run();
}

run_team_master();
