<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    Team_Master
 * @subpackage Team_Master/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Team_Master
 * @subpackage Team_Master/public
 * @author     Adnan Moqsood <adnanmoqsood@gmail.com>
 */
class Team_Master_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/team-master-public.css', array(), $this->version, 'all');

        /* Carousel styling */
        wp_enqueue_style($this->plugin_name . 'slick_css', plugin_dir_url(__FILE__) . 'css/slick.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'slick_theme_css', plugin_dir_url(__FILE__) . 'css/slick-theme.css', array(), $this->version, 'all');

        wp_enqueue_style($this->plugin_name . 'bootstrap-css', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'font-awesome-css', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

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
        wp_enqueue_script($this->plugin_name . 'bootstrap-proper-js', plugin_dir_url(__FILE__) . 'js/popper.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name . 'bootstrap-js', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name . 'slick_js', plugin_dir_url(__FILE__) . 'js/slick.min.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/team-master-public.js', array('jquery'), $this->version, true);
        $shortcode = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'ajaxnonce' => wp_create_nonce("tm_members_nonce")
        );
        wp_localize_script($this->plugin_name, 'usageObj', $shortcode);
    }

    /**
     * Template for displaying the shortcode
     *
     * @since    1.0.0
     */
    public function team_master_shortcode_func($atts) {

        ob_start();
        require plugin_dir_path(dirname(__FILE__)) . 'public/partials/team-master-public-shortcode.php';
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * Template for displaying the shortcode modal
     *
     * @since    1.0.0
     */
    public function tm_add_modal() {
        ob_start();
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/team-master-member-modal.php';
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }

    /**
     * function for displaying the shortcode modal content into modal
     *
     * @since    1.0.0
     */
    public function tm_retrive_modal() {
        $result = '';
        if (!wp_verify_nonce($_REQUEST['nonce'], "tm_members_nonce")) {
            echo json_encode(array('message' => 'Authentication Error, Please try again', 'status' => false, 'result' => $result));
            die();
        }
        $memberid = isset($_POST['memberid']) ? intval($_POST['memberid']) : '';
        $member = get_post($memberid);
        if ($member) {
            $designation = get_post_meta($memberid, 'member_designation', true);
            $member_email = get_post_meta($memberid, 'member_email', true);
            $member_tel = get_post_meta($memberid, 'member_tel', true);
            $featured_img_url = get_the_post_thumbnail_url($memberid, 'tm-modal-image-size');
            $member_social_media = maybe_unserialize(get_post_meta($memberid, 'member_social_media', true));
            $member_short_description = get_post_meta($memberid, 'member_short_description', true);
            $url = get_the_permalink($memberid);
            $background = get_option('tm_default_background_color');
            $titlecolor = get_option('tm_default_title_color');
            $designationcolor = get_option('tm_default_designation_color');
            $color = get_option('tm_default_color');
            $buttonBg = get_option('tm_default_btn_color');
            $buttonColor = get_option('tm_default_btn_font_color');
            ob_start();
            ?>
            <?php if (!empty($featured_img_url)) { ?>
                <div class="tm_popup__photo" style="background: url('<?php echo esc_url($featured_img_url); ?>');background-size:cover;background-position:center center;">
                </div>
            <?php } else { ?>
                <div class="tm_popup__photo" style="background: url('<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '/public/img/avatar-360x490.png') ?>');background-size:cover;background-position:center center;">
                </div>
            <?php } ?>
            <div class="tm_popup__text" style="background-color:<?php echo $background; ?>">
                <?php if (!empty($featured_img_url)) { ?>
                    <img src="<?php echo esc_url($featured_img_url); ?>" class="showMobile" style="display: none" />
                <?php } else { ?>
                    <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '/public/img/avatar-360x490.png') ?>" class="showMobile" style="display: none" />
                <?php } ?>

                <span class="tm_full_name" style="color:<?php echo $titlecolor; ?>"><?php echo esc_html($member->post_title); ?></span>
                <?php if (!empty($designation)) { ?>
                    <span class="tm_full_designation" style="color:<?php echo $designationcolor; ?>"><?php echo esc_html($designation); ?></span>
                <?php } ?>
                <?php if (!empty($member_short_description)) { ?>
                    <div class="tm_short_content">
                        <p style="color:<?php echo $color; ?>"><?php echo esc_html($member_short_description); ?></p>
                    </div>
                <?php } ?>
                <?php if (!empty($member_email)) { ?>
                    <div class="tm_full_email" style="color:<?php echo $color; ?>">
                        <span><strong>Email : <a style="color:<?php echo $color; ?>" href="mailto:<?php echo sanitize_email($member_email); ?>"><?php echo sanitize_email($member_email); ?></a></strong></span>
                    </div>
                <?php } ?>
                <?php if (!empty($member_tel)) { ?>
                    <div class="tm_full_phone" style="color:<?php echo $color; ?>">
                        <span><strong>Phone : <?php echo '+' . $member_tel; ?></strong></span>
                    </div>
                <?php } ?>

                <?php if (is_array($member_social_media)) { ?>
                    <div class="tm_full_social">
                        <?php
                        foreach ($member_social_media as $key => $social_media) {
                            if ($key < 3) {
                                ?>
                                <a href="<?php echo esc_url($social_media['link']); ?>"><i class="fa <?php echo sanitize_key($social_media['icon']); ?>"></i></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                <?php } ?>
                <div class="tm_full_readmore">
                    <a class="tm_full_readmore_btn" style="font-size:12px;padding:10px 15px;letter-spacing: 2px;background-color: <?php echo $buttonBg; ?>;border-color: <?php echo $buttonBg; ?>;color: <?php echo $buttonColor; ?>" href="<?php echo esc_url($url); ?>"><?php echo __('Read More', 'team-master'); ?> <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
            <span class="tm_popup__close">X</span>
            <?php
            $output = ob_get_contents();
            ob_end_clean();
        }
        $result = $output;
        echo json_encode(array('message' => __('Members Retrived!', 'team-master'), 'status' => true, 'result' => $result));
        die();
    }

    function tm_sanitize_html_classes($classes, $return_format = 'input') {

        if ('input' === $return_format) {
            $return_format = is_array($classes) ? 'array' : 'string';
        }

        $classes = is_array($classes) ? $classes : explode(' ', $classes);

        $sanitized_classes = array_map('sanitize_html_class', $classes);

        if ('array' === $return_format) {
            return $sanitized_classes;
        } else {
            return implode(' ', $sanitized_classes);
        }
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
     * function for loading more members
     *
     * @since    1.0.0
     */
    public function tm_ajax_members_loadmore() {

        $paged = isset($_POST['page']) ? intval($_POST['page']) : '';
        $template = isset($_POST['template']) ? intval($_POST['template']) : '';
        $postType = sanitize_title('tm_members');
        $classes = isset($_POST['classes']) ? $this->tm_sanitize_html_classes($_POST['classes']) : '';
        $postsPerpage = isset($_POST['postsperpage']) ? intval($_POST['postsperpage']) : '';
        $roles = isset($_POST['role']) ? $this->tm_recursive_sanitize_text_field(maybe_unserialize($_POST['role'])) : '';
        $members = isset($_POST['excludedMember']) ? $this->tm_recursive_sanitize_text_field(maybe_unserialize($_POST['excludedMember'])) : '';
        $background = isset($_POST['bg']) ? sanitize_hex_color($_POST['bg']) : '';
        $color = isset($_POST['color']) ? sanitize_hex_color($_POST['color']) : '';
        $titlecolor = isset($_POST['titlecolor']) ? sanitize_hex_color($_POST['titlecolor']) : '';
        $designationcolor = isset($_POST['designationcolor']) ? sanitize_hex_color($_POST['designationcolor']) : '';

        $buttonBg = isset($_POST['btnbg']) ? sanitize_hex_color($_POST['btnbg']) : '';
        $buttonColor = isset($_POST['btncolor']) ? sanitize_hex_color($_POST['btncolor']) : '';

        if (is_array($roles)) {
            $role = $roles;
        } else {
            $role = array();
        }
        if (is_array($members)) {
            $exclude_members = $members;
        } else {
            $exclude_members = array();
        }

        $tmposts = get_posts(array(
            'posts_per_page' => $postsPerpage,
            'post_type' => $postType,
            'post__not_in' => $exclude_members,
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => 'tm_members_role',
                    'field' => 'term_id',
                    'terms' => $role
                )
            )
                )
        );
        ob_start();
        if ($tmposts) {
            foreach ($tmposts as $key => $tmpost) {
                $designation = get_post_meta($tmpost->ID, 'member_designation', true);
                $url = get_the_permalink($tmpost->ID);
                if ($template == 1) {
                    $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-modal-image-size');
                    require plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/tm_template_1.php';
                } else if ($template == 2) {
                    $member_email = get_post_meta($tmpost->ID, 'member_email', true);
                    $member_tel = get_post_meta($tmpost->ID, 'member_tel', true);
                    $member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
                    $member_short_description = get_post_meta($tmpost->ID, 'member_short_description', true);
                    $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-thumbnail-image-size');
                    require plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/tm_template_2.php';
                } else if ($template == 3) {
                    $member_email = get_post_meta($tmpost->ID, 'member_email', true);
                    $member_tel = get_post_meta($tmpost->ID, 'member_tel', true);
                    $member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
                    $member_short_description = get_post_meta($tmpost->ID, 'member_short_description', true);
                    $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-thumbnail-image-size');
                    require plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/tm_template_3.php';
                } else if ($template == 4) {
                    $member_email = get_post_meta($tmpost->ID, 'member_email', true);
                    $member_tel = get_post_meta($tmpost->ID, 'member_tel', true);
                    $member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
                    $member_short_description = get_post_meta($tmpost->ID, 'member_short_description', true);
                    $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-modal-image-size');
                    require plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/tm_template_4.php';
                } else if ($template == 'custom') {
                    require plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/tm_template_custom.php';
                } else {
                    echo 'There is no template';
                    $status = 0;
                }
            }
            $status = 1;
        } else {
            $status = 0;
            ?>
            <div class="col-xs-12 error_message default_shortcode_col">
                <?php echo __('Nothing Found!', 'team-master') ?>
            </div>    
            <?php
        }
        $output = ob_get_clean();
        echo json_encode(array('status' => $status, 'html' => $output));
        wp_die();
    }

    /**
     * Load the Members archive template
     *
     * @since    1.0.0
     */
    public function get_tm_member_post_type_template($archive_template) {
        global $post;
        if (is_post_type_archive('tm_members')) {
            $archive_template = plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/archive-tm-members.php';
        }
        return $archive_template;
    }

    /**
     * Filter the single_template with our custom function
     *
     * @since    1.0.0
     */
    function get_tm_member_single_template($single) {

        global $post;
        /* Checks for single template by post type */
        if ($post->post_type == 'tm_members') {
            if (file_exists(plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/single-tm-members.php')) {
                $single = plugin_dir_path(dirname(__FILE__)) . 'public/partials/templates/single-tm-members.php';
            }
        }
        return $single;
    }

}
