<div class="wrap tm_usage">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div id="member-information" class="postbox ">
                        <h2 class="hndle ui-sortable-handle usage_heading"><span><?php echo __('Team Master Settings', 'team-master'); ?></span></h2>
                        <div class="inside">
                            <form method="post" action="options.php">
                                <?php settings_errors(); ?>
                                <?php settings_fields('tm-plugin-settings-group'); ?>
                                <?php do_settings_sections('tm-plugin-settings-group'); ?>
                                <div id="accordion" class="accordion">
                                    <h3 class="accordion__title"><?php echo __('Select Templates', 'team-master'); ?></h3>
                                    <div class="accordion__content-inner">
                                        <div class="ts-members-template">
                                            <label>
                                                <input type="radio" name="tm_default_template" class="tm_template" value="1" <?php checked(esc_attr(get_option('tm_default_template')), 1); ?> />
                                                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../img/default.png'); ?>">
                                            </label>
                                            <label>
                                                <input type="radio" name="tm_default_template" class="tm_template" value="2" <?php checked(esc_attr(get_option('tm_default_template')), 2); ?> />
                                                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../img/style2.png'); ?>">
                                            </label>
                                            <label>
                                                <input type="radio" name="tm_default_template" class="tm_template" value="3" <?php checked(esc_attr(get_option('tm_default_template')), 3); ?> />
                                                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../img/style3.png'); ?>">
                                            </label>
                                            <label>
                                                <input type="radio" name="tm_default_template" class="tm_template" value="4" <?php checked(esc_attr(get_option('tm_default_template')), 4); ?> />
                                                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../img/style4.png'); ?>">
                                            </label>

                                            <?php
                                            /**
                                             * Filter for adding the custom template thumbnail admin settings
                                             *
                                             * @since    1.0.6
                                             * $arg $custom_img_url
                                             * return $custom_img_url
                                             */
                                            $custom_img_url = '';
                                            $img_url = apply_filters('add_template_thumbnail_admin', $custom_img_url);
                                            if (!empty($img_url)) {
                                                ?>
                                                <label>
                                                    <input type="radio" name="tm_default_template" class="tm_template" value="custom" <?php checked(esc_attr(get_option('tm_default_template')), 'custom'); ?> />
                                                    <img src="<?php echo esc_url($img_url); ?>">
                                                </label>

                                            <?php } ?>

                                        </div>
                                    </div>
                                    <h3 class="accordion__title"><?php echo __('Template Styling', 'team-master'); ?></h3>
                                    <div class="accordion__content-inner">
                                        <div class="ts-default-styling">
                                            <div class="tm_default_background_color_col">
                                                <label><?php echo __('Background', 'team-master'); ?></label><br/><br/>
                                                <?php $tm_default_background_color = (!empty(get_option('tm_default_background_color')) ) ? get_option('tm_default_background_color') : '#000'; ?>
                                                <input type="text" name="tm_default_background_color" value="<?php echo $tm_default_background_color; ?>" class="tm_default_styling" >
                                            </div>
                                            <div class="tm_default_color_col">
                                                <label><?php echo __('Title Color', 'team-master'); ?></label><br/><br/>
                                                <?php $tm_default_title_color = (!empty(get_option('tm_default_title_color')) ) ? get_option('tm_default_title_color') : '#fff'; ?>
                                                <input type="text" name="tm_default_title_color" value="<?php echo $tm_default_title_color; ?>" class="tm_default_styling" >
                                            </div>
                                            <div class="tm_default_color_col">
                                                <label><?php echo __('Designation Color', 'team-master'); ?></label><br/><br/>
                                                <?php $tm_default_designation_color = (!empty(get_option('tm_default_designation_color')) ) ? get_option('tm_default_designation_color') : '#fff'; ?>
                                                <input type="text" name="tm_default_designation_color" value="<?php echo $tm_default_designation_color; ?>" class="tm_default_styling" >
                                            </div>
                                            <div class="tm_default_color_col">
                                                <label><?php echo __('Description Color', 'team-master'); ?></label><br/><br/>
                                                <?php $tm_default_color = (!empty(get_option('tm_default_color')) ) ? get_option('tm_default_color') : '#fff'; ?>
                                                <input type="text" name="tm_default_color" value="<?php echo $tm_default_color; ?>" class="tm_default_styling" >
                                            </div>
                                            <div class="tm_default_color_col">
                                                <label><?php echo __('Button Bg Color', 'team-master'); ?></label><br/><br/>
                                                <?php $tm_default_btn_color = (!empty(get_option('tm_default_btn_color')) ) ? get_option('tm_default_btn_color') : '#ddd'; ?>
                                                <input type="text" name="tm_default_btn_color" value="<?php echo $tm_default_btn_color; ?>" class="tm_default_styling tm_default_btn_color" >
                                            </div>
                                            <div class="tm_default_color_col">
                                                <label><?php echo __('Button Color', 'team-master'); ?></label><br/><br/>
                                                <?php $tm_default_btn_font_color = (!empty(get_option('tm_default_btn_font_color')) ) ? get_option('tm_default_btn_font_color') : '#000'; ?>
                                                <input type="text" name="tm_default_btn_font_color" value="<?php echo $tm_default_btn_font_color; ?>" class="tm_default_styling tm_default_btn_font_color" >
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="accordion__title"><?php echo __('Display Settings', 'team-master'); ?></h3>
                                    <div class="accordion__content-inner">
                                        <div class="ts-default-load-mores">
                                            <div class="tm_default_per_page_cols">
                                                <div class="ts-members-column">
                                                    <label><?php echo __('Columns/Slides to Show?', 'team-master'); ?></label>
                                                    <select class="ts-display-members-per-page" name="tm_default_column">
                                                        <option value="1" <?php selected(esc_attr(get_option('tm_default_column')), 1); ?>>1</option>
                                                        <option value="2" <?php selected(esc_attr(get_option('tm_default_column')), 2); ?>>2</option>
                                                        <option value="3" <?php selected(esc_attr(get_option('tm_default_column')), 3); ?>>3</option>
                                                        <option value="4" <?php selected(esc_attr(get_option('tm_default_column')), 4); ?>>4</option>
                                                    </select>

                                                </div>
                                                <br/>
                                                <label><?php echo __('Members to Show/Scroll?', 'team-master'); ?></label><br/><br/>
                                                <select class="ts-members-per-page" name="tm_default_perpage">
                                                    <option value="-1" <?php selected(esc_attr(get_option('tm_default_perpage')), -1); ?>>All</option>
                                                    <option value="1" <?php selected(esc_attr(get_option('tm_default_perpage')), 1); ?>>1</option>
                                                    <option value="2" <?php selected(esc_attr(get_option('tm_default_perpage')), 2); ?>>2</option>
                                                    <option value="3" <?php selected(esc_attr(get_option('tm_default_perpage')), 3); ?>>3</option>
                                                    <option value="4" <?php selected(esc_attr(get_option('tm_default_perpage')), 4); ?>>4</option>
                                                    <option value="5" <?php selected(esc_attr(get_option('tm_default_perpage')), 5); ?>>5</option>
                                                    <option value="6" <?php selected(esc_attr(get_option('tm_default_perpage')), 6); ?>>6</option>
                                                    <option value="7" <?php selected(esc_attr(get_option('tm_default_perpage')), 7); ?>>7</option>
                                                    <option value="8" <?php selected(esc_attr(get_option('tm_default_perpage')), 8); ?>>8</option>
                                                    <option value="9" <?php selected(esc_attr(get_option('tm_default_perpage')), 9); ?>>9</option>
                                                    <option value="10" <?php selected(esc_attr(get_option('tm_default_perpage')), 10); ?>>10</option>
                                                    <option value="11" <?php selected(esc_attr(get_option('tm_default_perpage')), 11); ?>>11</option>
                                                    <option value="12" <?php selected(esc_attr(get_option('tm_default_perpage')), 12); ?>>12</option>
                                                    <option value="13" <?php selected(esc_attr(get_option('tm_default_perpage')), 13); ?>>13</option>
                                                    <option value="14" <?php selected(esc_attr(get_option('tm_default_perpage')), 14); ?>>14</option>
                                                    <option value="15" <?php selected(esc_attr(get_option('tm_default_perpage')), 15); ?>>15</option>
                                                    <option value="16" <?php selected(esc_attr(get_option('tm_default_perpage')), 16); ?>>16</option>
                                                    <option value="17" <?php selected(esc_attr(get_option('tm_default_perpage')), 17); ?>>17</option>
                                                    <option value="18" <?php selected(esc_attr(get_option('tm_default_perpage')), 18); ?>>18</option>
                                                    <option value="19" <?php selected(esc_attr(get_option('tm_default_perpage')), 19); ?>>19</option>
                                                    <option value="20" <?php selected(esc_attr(get_option('tm_default_perpage')), 20); ?>>20</option>
                                                </select>
                                                <br/><br/>
                                                <div class="tm_default_load_more_cols">
                                                    <label><?php echo __('Display Load More Button?', 'team-master'); ?></label><br/><br/>
                                                    <label class="tm_label_container">
                                                        Yes
                                                        <input type="radio" name="tm_default_load_more" class="tm_default_load_more" value="yes" <?php checked(esc_attr(get_option('tm_default_load_more')), 'yes'); ?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="tm_label_container">
                                                        No
                                                        <input type="radio" name="tm_default_load_more" class="tm_default_load_more" value="no" <?php checked(esc_attr(get_option('tm_default_load_more')), 'no'); ?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--***** Carousel default options *******-->
                                    <h3 class="accordion__title"><?php echo __('Carousel Settings', 'team-master'); ?></h3>
                                    <div class="accordion__content-inner">
                                        <div class="ts-default-carousels">
                                            <div class="tm_default_per_page_cols">
                                                <label><?php echo __('Activate?', 'team-master'); ?></label><br/><br/>
                                                <label class="tm_label_container">
                                                    Yes
                                                    <input type="radio" name="tm_default_activate_carousel" class="tm_default_activate_carousel" value="yes" <?php checked(esc_attr(get_option('tm_default_activate_carousel')), 'yes'); ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="tm_label_container">
                                                    No
                                                    <input type="radio" name="tm_default_activate_carousel" class="tm_default_activate_carousel" value="no" <?php checked(esc_attr(get_option('tm_default_activate_carousel')), 'no'); ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br/><br/>
                                            <div class="tm_default_per_page_cols">
                                                <label><?php echo __('Auto Play?', 'team-master'); ?></label><br/><br/>
                                                <label class="tm_label_container">
                                                    Yes
                                                    <input type="radio" name="tm_default_auto_play_carousel" class="tm_default_auto_play_carousel" value="yes" <?php checked(esc_attr(get_option('tm_default_auto_play_carousel')), 'yes'); ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="tm_label_container">
                                                    No
                                                    <input type="radio" name="tm_default_auto_play_carousel" class="tm_default_auto_play_carousel" value="no" <?php checked(esc_attr(get_option('tm_default_auto_play_carousel')), 'no'); ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br/><br/>
                                        </div>
                                    </div>

                                </div>
                                <input type="submit" name="submit" id="submit" class="button button-primary button-large generate" value="<?php echo __('Save Changes', 'team-master'); ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="postbox-container-1" class="postbox-container settings_containers">
                <div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
                    <div id="postimagediv" class="postbox ">
                        <h2 class="hndle ui-sortable-handle usage_heading"><span><?php echo __('Support', 'team-master'); ?></span></h2>
                        <div class="inside">
                            <div class="rate_us">
                                <p><?php echo __('We have some resources available to help you in the right direction.', 'team-master'); ?></p>
                                <p><a href="https://wordpress.org/plugins/team-master/#faq" class="rate_icons_link" target="_blank"><strong><?php echo __('Frequently Asked Questions', 'team-master'); ?></strong></a></p>
                                <p><?php echo __('If your answer can not be found in the resources listed above, please use the', 'team-master'); ?> <a target="_blank" href="https://wordpress.org/support/plugin/team-master/"><strong><?php echo __('support forums on WordPress.org', 'team-master'); ?></strong></a>.</p>
                                <p><strong><?php echo __('Contact Us', 'team-master'); ?></strong></p>
                                <p><?php echo __('Please send us your queries', 'team-master'); ?> <a target="_blank" href="mailto:adnanmughal70@gmail.com"><strong><?php echo __('Email Us', 'team-master'); ?></strong></a></p>
                            </div>
                        </div>
                    </div>
                    <div id="postimagediv" class="postbox ">
                        <h2 class="hndle ui-sortable-handle usage_heading"><span><?php echo __('Rate Us', 'team-master'); ?></span></h2>
                        <div class="inside">
                            <div class="rate_us text-center">
                                <p><?php echo __('Please take a moment to rate our efforts for further improvement in this plugin', 'team-master'); ?></p>
                                <a href="https://wordpress.org/plugins/team-master/" class="rate_icons_link" target="_blank">
                                    <span class="dashicons dashicons-star-filled"></span>
                                    <span class="dashicons dashicons-star-filled"></span>
                                    <span class="dashicons dashicons-star-filled"></span>
                                    <span class="dashicons dashicons-star-filled"></span>
                                    <span class="dashicons dashicons-star-filled"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /post-body -->
    </div><!-- /poststuff -->
</div>