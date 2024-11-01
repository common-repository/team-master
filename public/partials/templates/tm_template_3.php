<div class="<?php echo esc_attr($classes); ?>">
    <div class="tm_container" style="background-color:<?php echo $background; ?>;">
        <div class="tm_media_3">
            <a href="<?php echo esc_url($url); ?>">
                <?php if (!empty($featured_img_url)) { ?>
                    <img src="<?php echo esc_url($featured_img_url); ?>" />
                <?php } else { ?>
                    <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '../img/avatar-250x250.png'); ?>" />
                <?php } ?>
            </a>
        </div>
        <div class="tm_desc_3">
            <a href="<?php echo esc_url($url); ?>"><span class="tm_name_3 tm_name_color_3 text-center" style="color:<?php echo $titlecolor; ?>"><?php echo esc_html($tmpost->post_title); ?></span></a>
            <?php if (!empty($designation)) { ?>
                <span class="tm_full_designation_3 tm_designation_color_3 text-center" style="color:<?php echo $designationcolor; ?>"><?php echo esc_html($designation); ?></span>
            <?php } ?>
            <?php if (!empty($member_short_description)) { ?>
                <div class="team-content_3 text-center">
                    <p style="color:<?php echo $color; ?>"><?php echo esc_html($member_short_description); ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="tm_full_readmore_3">
            <a class="tm_full_readmore_link_3" style="color:<?php echo $buttonColor; ?>;background-color:<?php echo $buttonBg; ?>" href="<?php echo esc_url($url); ?>">Read More <i class="fa fa-angle-right"></i></a>
        </div>
    </div>
</div>
