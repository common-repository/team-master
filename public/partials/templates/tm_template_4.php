<div class="<?php echo $classes; ?> default_shortcode_col">
    <div class="tm_container" style="background-color:<?php echo $background; ?>;">
        <a href="<?php echo esc_url($url); ?>">
            <div class="tm_media_4">
                <?php if (!empty($featured_img_url)) { ?>
                    <img src="<?php echo esc_url($featured_img_url); ?>" alt="Avatar" class="tm_image">
                <?php } else { ?>
                    <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '../img/avatar-360x490.png'); ?>" alt="Avatar" class="tm_image">
                <?php } ?>
            </div>
        </a>
        <div class = "tm_overlay_4" style="background-color:<?php echo $background; ?>;">
            <div class = "tm_text_4">
                <div class="tm_left_4">
                    <span class="tm_name_4" style="color:<?php echo $titlecolor; ?>"><?php echo esc_html($tmpost->post_title); ?></span>
                    <span class="tm_designation_4" style="color:<?php echo $designationcolor; ?>"><?php echo esc_html($designation); ?></span>
                </div>
            </div>
            <?php if (is_array($member_social_media)) { ?>
                <div class="tm_social_4">
                    <?php
                    foreach ($member_social_media as $key => $social_media) {
                        if ($key < 3) {
                            ?>
                            <div class="tm_social"><a style="color:<?php echo $color; ?>" href="<?php echo esc_url($social_media['link']); ?>"><i class="fa <?php echo sanitize_html_class($social_media['icon']); ?>"></i></a></div>
                                    <?php
                                }
                            }
                            ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
