<div class="<?php echo esc_attr($classes); ?>">
    <div class="tm_container" style="background-color:<?php echo $background; ?>;">
        <div class="tm_media">
            <a href="<?php echo esc_url($url); ?>">
                <?php if (!empty($featured_img_url)) { ?>
                    <img src="<?php echo esc_url($featured_img_url); ?>" />
                <?php } else { ?>
                    <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '../img/avatar-250x250.png'); ?>" />
                <?php } ?>
            </a>
        </div>
        <div class="tm_desc">
            <a href="<?php echo esc_url($url); ?>"><span class="tm_name tm_name_color text-center" style="color:<?php echo $titlecolor; ?>"><?php echo esc_html($tmpost->post_title); ?></span></a>
            <?php if (!empty($designation)) { ?>
                <span class="tm_full_designation tm_designation_color text-center" style="color:<?php echo $designationcolor; ?>"><?php echo esc_html($designation); ?></span>
            <?php } ?>
            <?php if (!empty($member_short_description)) { ?>
                <div class="team-content text-center">
                    <p style="color:<?php echo $color; ?>"><?php echo esc_html($member_short_description); ?></p>
                </div>
            <?php } ?>
            <?php if (is_array($member_social_media)) { ?>
                <div class="tm_full_social">
                    <?php
                    foreach ($member_social_media as $key => $social_media) {
                        if ($key < 3) {
                            ?>
                            <a href="<?php echo esc_url($social_media['link']); ?>"><i class="fa <?php echo sanitize_html_class($social_media['icon']); ?>"></i></a>
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
