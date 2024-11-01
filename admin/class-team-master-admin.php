<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    Team_Master
 * @subpackage Team_Master/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Team_Master
 * @subpackage Team_Master/admin
 * @author     Adnan Moqsood <adnanmoqsood@gmail.com>
 */
class Team_Master_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Team_Master_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Team_Master_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if ($hook == 'tm_members_page_team-master-shortcode-builder' || $hook == 'tm_members_page_team-master-settings') {
            wp_enqueue_style($this->plugin_name . '_font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_style($this->plugin_name . '_select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
        }
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/team-master-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {
        global $post;
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Team_Master_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Team_Master_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if (isset($post->post_type)) {
            if ($post->post_type == 'tm_members' && ( $hook == 'post.php' || $hook == 'post-new.php' )) {
                wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/team-master-admin.js', array('jquery'), $this->version, true);
            }
        }
        if ($hook == 'tm_members_page_team-master-shortcode-builder' || $hook == 'tm_members_page_team-master-settings') {
            wp_enqueue_script($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name . 'accordion', plugin_dir_url(__FILE__) . 'js/team-master-admin-accordion.js', array('jquery', 'wp-color-picker','jquery-ui-core','jquery-ui-accordion'), $this->version, true);

            $shortcode = array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'ajaxnonce' => wp_create_nonce("tm_members_nonce")
            );
            wp_localize_script($this->plugin_name . 'accordion', 'usageObj', $shortcode);
        }
    }

}
