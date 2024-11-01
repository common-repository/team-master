<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    Team_Master
 * @subpackage Team_Master/admin/team
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the team post type and meta related to team
 *
 * @package    Team_Master
 * @subpackage Team_Master/admin/team
 * @author     Adnan Moqsood <adnanmoqsood@gmail.com>
 */
class Team_Master_Post_Type_Admin {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        
    }

    /**
     * Register the team cusom post type
     *
     * @since    1.0.0
     */
    public function register_team_master_post_type() {

        /**
         * 
         * Members Custom Posttype
         * 
         */
        $cap_type = 'post';
        $plural = 'Members';
        $single = 'Member';
        $cpt_name = 'tm_members';
        $opts['can_export'] = TRUE;
        $opts['capability_type'] = $cap_type;
        $opts['description'] = '';
        $opts['exclude_from_search'] = FALSE;
        $opts['has_archive'] = TRUE;
        $opts['hierarchical'] = FALSE;
        $opts['map_meta_cap'] = TRUE;
        $opts['menu_icon'] = 'dashicons-businessman';
        $opts['menu_position'] = 25;
        $opts['public'] = true;
        $opts['publicly_querable'] = TRUE;
        $opts['query_var'] = TRUE;
        $opts['register_meta_box_cb'] = '';
        $opts['rewrite'] = TRUE;
        $opts['show_in_admin_bar'] = TRUE;
        $opts['show_in_menu'] = TRUE;
        $opts['show_in_nav_menu'] = TRUE;
        $opts['supports'] = array('title', 'editor', 'thumbnail');

        $opts['labels']['add_new'] = esc_html__("Add New", 'team-master');
        $opts['labels']['add_new_item'] = esc_html__("Add New {$single}", 'team-master');
        $opts['labels']['all_items'] = esc_html__("All " . $plural, 'team-master');
        $opts['labels']['edit_item'] = esc_html__("Edit {$single}", 'team-master');
        $opts['labels']['menu_name'] = esc_html__('Team', 'team-master');
        $opts['labels']['name'] = esc_html__($plural, 'team-master');
        $opts['labels']['name_admin_bar'] = esc_html__($single, 'team-master');
        $opts['labels']['new_item'] = esc_html__("New {$single}", 'team-master');
        $opts['labels']['not_found'] = esc_html__("No {$plural} Found", 'team-master');
        $opts['labels']['not_found_in_trash'] = esc_html__("No {$plural} Found in Trash", 'team-master');
        $opts['labels']['parent_item_colon'] = esc_html__("Parent {$plural} :", 'team-master');
        $opts['labels']['search_items'] = esc_html__("Search {$plural}", 'team-master');
        $opts['labels']['singular_name'] = esc_html__($single, 'team-master');
        $opts['labels']['view_item'] = esc_html__("View {$single}", 'team-master');

        $opts['labels']['featured_image'] = esc_html__("Member Image (Resolution : 500 * 500 - for better presentation)", 'team-master');
        $opts['labels']['set_featured_image'] = esc_html__("Set Member Image", 'team-master');
        $opts['labels']['remove_featured_image'] = esc_html__("Remove Member Image", 'team-master');
        $opts['labels']['use_featured_image'] = esc_html__("Use as Member Image", 'team-master');
        $opts['labels']['insert_into_item'] = esc_html__("Insert into item", 'team-master');
        $opts['labels']['uploaded_to_this_item'] = esc_html__("Upload to this item", 'team-master');

        register_post_type(strtolower($cpt_name), apply_filters('team_master_post_type_labels', $opts));
        /**
         * 
         * Members Taxonomy
         * 
         */
        $labels = array(
            'name' => _x('Roles', 'Roles', 'team-master'),
            'singular_name' => _x('Role', 'Role', 'team-master'),
            'search_items' => __('Search Role', 'team-master'),
            'all_items' => __('All Roles', 'team-master'),
            'parent_item' => __('Parent Role', 'team-master'),
            'parent_item_colon' => __('Parent Role:', 'team-master'),
            'edit_item' => __('Edit Role', 'team-master'),
            'update_item' => __('Update Role', 'team-master'),
            'add_new_item' => __('Add New Role', 'team-master'),
            'new_item_name' => __('New Role Name', 'team-master'),
            'menu_name' => __('Roles', 'team-master'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'tm_members_role'),
        );

        register_taxonomy('tm_members_role', array('tm_members'), apply_filters('team_master_post_type_taxonomy_labels', $args));

        flush_rewrite_rules();

        add_image_size('tm-grid-image-size', 300, 320, array('center', 'center'));
        add_image_size('tm-modal-image-size', 360, 490, array('center', 'center'));
        add_image_size('tm-thumbnail-image-size', 250, 250, array('center', 'center'));
    }

    /**
     * Register for members post type meta box(es).
     *
     * @since    1.0.0
     */
    function register_team_master_post_type_meta() {
        add_meta_box('member-information', __('Member Information', 'team-master'), array($this, 'team_master_meta_display_callback'), 'tm_members', 'advanced', 'high');
    }

    /**
     * Member Information meta box display
     *
     * @since    1.0.0
     */
    function team_master_meta_display_callback() {

        global $post;
        $member_social_media = get_post_meta($post->ID, 'member_social_media', true);
        $translation_array = array(
            'member_social_media' => maybe_unserialize($member_social_media),
        );

        wp_nonce_field('team_master_meta_nonce', 'team_master_meta_nonce');

        // Designation Meta
        $metas = '<label for="member_designation" style="display:block;margin-top:15px;margin-bottom:5px">' . esc_html__('Designation', 'team-master') . '</label>';
        $member_designation = get_post_meta($post->ID, 'member_designation', true);
        $metas .= '<input type="text" name="member_designation" id="member_designation" required placeholder="Please enter member designation" class="member_designation" value="' . esc_attr($member_designation) . '" style="width:100%;margin-bottom:15px;height:30px"/>';

        // Email Meta
        $metas .= '<label for="member_email" style="display:block;margin-top:15px;margin-bottom:5px">' . esc_html__('Email', 'team-master') . '</label>';
        $member_email = get_post_meta($post->ID, 'member_email', true);
        $metas .= '<input type="email" name="member_email" id="member_email" required placeholder="Please enter member email" class="member_email" value="' . esc_attr($member_email) . '" style="width:100%;margin-bottom:15px;height:30px"/>';

        // Phone Meta
        $metas .= '<label for="member_tel" style="display:block;margin-top:15px;margin-bottom:5px">' . esc_html__('Phone', 'team-master') . '</label>';
        $member_tel = get_post_meta($post->ID, 'member_tel', true);
        $metas .= '<input type="tel" name="member_tel" id="member_tel" required placeholder="Please enter your phone number" class="member_tel" value="' . esc_attr($member_tel) . '" style="width:100%;margin-bottom:15px;height:30px"/>';


        // Short Description Meta
        $metas .= '<label for="member_short_description" style="display:block;margin-bottom:5px">' . esc_html__('Short Description (In 150 characters or less)', 'team-master') . '</label>';
        $member_short_description = get_post_meta($post->ID, 'member_short_description', true);
        $metas .= '<textarea name="member_short_description" required id="member_short_description" class="member_short_description" style="width:100%;margin-bottom:15px;" size="150" maxlength="150">' . esc_attr($member_short_description) . '</textarea>';

        // Social Media Meta
        $metas .= '<label for="member_social_media" style="display:block;margin-bottom:5px">' . esc_html__('Social Media', 'team-master') . '</label>';
        wp_localize_script('team-master', 'social_media_items', $translation_array);
        $metas .= '<div class="social_meta_container" id="social_meta_container"></div>';
        $metas .= '<span class="dashicons dashicons-plus createSocialMedia" id="createSocialMedia"></span>';

        echo $metas;
    }

    /**
     * When the post is saved
     *
     * @param int $post_id The ID of the post being saved.
     * @since    1.0.0
     */
    function team_master_post_type_meta_save($post_id) {

        global $post;

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */
        /* Check if our nonce is set. */
        if (!isset($_POST['team_master_meta_nonce'])) {
            return;
        }
        /* Verify that the nonce is valid. */
        if (!wp_verify_nonce($_POST['team_master_meta_nonce'], 'team_master_meta_nonce')) {
            return;
        }

        /* If this is an autosave, our form has not been submitted, so we don't want to do anything. */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($post->post_type == 'tm_members') {

            // Member Designation Update
            if (isset($_POST['member_designation'])) {
                $designation = sanitize_text_field($_POST['member_designation']);
                update_post_meta($post_id, 'member_designation', $designation);
            }


            // Member Email Update
            if (isset($_POST['member_email'])) {
                $member_email = sanitize_email($_POST['member_email']);
                update_post_meta($post_id, 'member_email', $member_email);
            }


            // Member tel Update
            if (isset($_POST['member_tel'])) {
                $member_tel = sanitize_text_field($_POST['member_tel']);
                update_post_meta($post_id, 'member_tel', $member_tel);
            }

            // Member Short Description Update
            if (isset($_POST['member_short_description'])) {
                $description = wp_kses_post($_POST['member_short_description']);
                update_post_meta($post_id, 'member_short_description', $description);
            }
            // Member Social Media Update
            if (isset($_POST['member_social_media'])) {
                $finalMedial = array();
                foreach ($_POST['member_social_media'] as $key => $media) {
                    if ($media['icon'] != '-1' && $media['link'] != '') {
                        array_push($finalMedial, $media);
                    }
                }
                $finalMedial = esc_sql(maybe_serialize($finalMedial));
                update_post_meta($post_id, 'member_social_media', $finalMedial);
            }
        }
    }

    /**
     * Member post type admin column altering
     *
     * @since    1.0.0
     */
    function team_master_filter_posts_columns($columns) {
        unset($columns['date']);
        $columns['title'] = __('Name');
        $columns['member_designation'] = __('Designation');
        $columns['member_image'] = __('Image');
        $columns['date'] = __('Date');
        return $columns;
    }

    /**
     * Member post type admin altered column values
     *
     * @since    1.0.0
     */
    function team_master_members_column($column, $post_id) {
        if ('member_image' === $column) {
            if (get_the_post_thumbnail($post_id, array(80, 80))) {
                echo get_the_post_thumbnail($post_id, array(80, 80));
            } else {
                echo '<img src="' . esc_url(plugin_dir_url(dirname(__FILE__)) . '/img/avatar-150x150.png') . '" class="attachment-80x80 size-80x80 wp-post-image" alt="" width="80" height="80">';
            }
        }
        if ('member_designation' === $column) {
            echo __(get_post_meta($post_id, 'member_designation', true), 'team-master');
        }
    }

    /**
     * Member post type admin shortcode menu
     *
     * @since    1.0.0
     */
    function team_master_usage_page() {
        add_submenu_page('edit.php?post_type=tm_members', __('Shortcode', 'team-master'), __('Shortcode', 'team-master'), 'manage_options', 'team-master-shortcode-builder', array($this, 'team_master_usage_page_callback'));
    }

    /**
     * Member post type admin shortcode menu page
     *
     * @since    1.0.0
     */
    function team_master_usage_page_callback() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'team/team-master-usage.php';
    }

    /**
     * Member post type admin usage menu
     *
     * @since    1.0.0
     */
    function team_master_settings_page() {
        add_submenu_page('edit.php?post_type=tm_members', __('Settings', 'team-master'), __('Settings', 'team-master'), 'manage_options', 'team-master-settings', array($this, 'team_master_settings_page_callback'));
    }

    /**
     * Member post type admin register settings
     *
     * @since    1.0.0
     */
    function tm_register_plugin_settings() {
        register_setting('tm-plugin-settings-group', 'tm_default_template');
        register_setting('tm-plugin-settings-group', 'tm_default_column');
        register_setting('tm-plugin-settings-group', 'tm_default_perpage');
        register_setting('tm-plugin-settings-group', 'tm_default_background_color');
        register_setting('tm-plugin-settings-group', 'tm_default_color');
        register_setting('tm-plugin-settings-group', 'tm_default_btn_color');
        register_setting('tm-plugin-settings-group', 'tm_default_btn_font_color');
        register_setting('tm-plugin-settings-group', 'tm_default_load_more');
        /*         * **************** Carousel default options *************** */
        register_setting('tm-plugin-settings-group', 'tm_default_activate_carousel');
        register_setting('tm-plugin-settings-group', 'tm_default_auto_play_carousel');

        /*         * **************** Carousel default options *************** */
        register_setting('tm-plugin-settings-group', 'tm_default_title_color');
        register_setting('tm-plugin-settings-group', 'tm_default_designation_color');

    }

    /**
     * Member post type admin usage menu page
     *
     * @since    1.0.0
     */
    function team_master_settings_page_callback() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'team/team-master-settings.php';
    }

    /**
     * Recursive sanitation for an array
     * 
     * @param $array
     * @since    1.0.0
     * @return mixed
     */
    function tm_recursive_sanitize_text_field($array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = tm_recursive_sanitize_text_field($value);
            } else {
                $value = sanitize_text_field($value);
            }
        }

        return $array;
    }

    /**
     * Options HTML creation on the basis of selected terms
     *
     * @since    1.0.0
     */
    function tm_retrive_members_callback() {

        $result = '';
        if (!wp_verify_nonce($_REQUEST['nonce'], "tm_members_nonce")) {
            echo json_encode(array('message' => __('Authentication Error, Please try again', 'team-master'), 'status' => false, 'result' => $result));
            die();
        }
        $termRoleIds = is_array($_POST['roles']) ? $this->tm_recursive_sanitize_text_field($_POST['roles']) : array('');
        $tmposts = get_posts(array(
            'showposts' => -1,
            'post_type' => 'tm_members',
            'tax_query' => array(
                array(
                    'taxonomy' => 'tm_members_role',
                    'field' => 'term_id',
                    'terms' => $termRoleIds
                )
            )
                )
        );
        if ($tmposts) {
            $responseArray = array();
            foreach ($tmposts as $tmpost) {
                $id = $tmpost->ID;
                $text = $tmpost->post_title;
                array_push($responseArray, array('id' => $id, 'text' => $text));
            }
        }
        $result = $responseArray;
        echo json_encode(array('message' => 'Members Retrived!', 'status' => true, 'result' => $result));
        die();
    }

}
