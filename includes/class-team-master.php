<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    Team_Master
 * @subpackage Team_Master/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Team_Master
 * @subpackage Team_Master/includes
 * @author     Adnan Moqsood <adnanmoqsood@gmail.com>
 */
class Team_Master {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Team_Master_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('TEAM_MASTER_VERSION')) {
            $this->version = TEAM_MASTER_VERSION;
        } else {
            $this->version = '1.1.1';
        }
        $this->plugin_name = 'team-master';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Team_Master_Loader. Orchestrates the hooks of the plugin.
     * - Team_Master_i18n. Defines internationalization functionality.
     * - Team_Master_Admin. Defines all hooks for the admin area.
     * - Team_Master_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-team-master-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-team-master-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-team-master-admin.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/team/class-team-master-post-type-admin.php';

        /**
         * The class responsible for adding the visual composer shortcode
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/team/team-master-vc-shortcode.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-team-master-public.php';

        $this->loader = new Team_Master_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Team_Master_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Team_Master_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Team_Master_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $plugin_admin_post_type = new Team_Master_Post_Type_Admin();
        $this->loader->add_action('init', $plugin_admin_post_type, 'register_team_master_post_type');
        $this->loader->add_action('add_meta_boxes', $plugin_admin_post_type, 'register_team_master_post_type_meta');
        $this->loader->add_action('save_post', $plugin_admin_post_type, 'team_master_post_type_meta_save');
        $this->loader->add_filter('manage_tm_members_posts_columns', $plugin_admin_post_type, 'team_master_filter_posts_columns');
        $this->loader->add_action('manage_tm_members_posts_custom_column', $plugin_admin_post_type, 'team_master_members_column', 10, 2);
        $this->loader->add_action('admin_menu', $plugin_admin_post_type, 'team_master_usage_page');
        $this->loader->add_action('admin_menu', $plugin_admin_post_type, 'team_master_settings_page');
        $this->loader->add_action("wp_ajax_tm_retrive_members", $plugin_admin_post_type, "tm_retrive_members_callback");
        $this->loader->add_action("wp_ajax_nopriv_tm_retrive_members", $plugin_admin_post_type, "tm_retrive_members_callback");
        $this->loader->add_action('admin_init', $plugin_admin_post_type, 'tm_register_plugin_settings');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Team_Master_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_shortcode('team_master', $plugin_public, 'team_master_shortcode_func');
        $this->loader->add_action('wp_footer', $plugin_public, 'tm_add_modal');
        $this->loader->add_action("wp_ajax_tm_retrive_modal", $plugin_public, "tm_retrive_modal");
        $this->loader->add_action("wp_ajax_nopriv_tm_retrive_modal", $plugin_public, "tm_retrive_modal");
        $this->loader->add_action("wp_ajax_tm_ajax_members_loadmore", $plugin_public, "tm_ajax_members_loadmore");
        $this->loader->add_action("wp_ajax_nopriv_tm_ajax_members_loadmore", $plugin_public, "tm_ajax_members_loadmore");
        $this->loader->add_filter('archive_template', $plugin_public, 'get_tm_member_post_type_template');
        $this->loader->add_filter('single_template', $plugin_public, 'get_tm_member_single_template');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Team_Master_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
