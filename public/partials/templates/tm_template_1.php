<div class="<?php echo $classes; ?> default_shortcode_col">
    <div class="tm_container"><a href="<?php echo esc_url($url); ?>">
            <?php if (!empty($featured_img_url)) { ?>
                <img src="<?php echo esc_url($featured_img_url); ?>" alt="Avatar" class="tm_image">
            <?php } else { ?>
                <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '../img/avatar-360x490.png'); ?>" alt="Avatar" class="tm_image">
            <?php } ?>
        </a>
        <div class = "tm_overlay" style="background-color:<?php echo $background; ?>;">
            <div class = "tm_text">
                <div class="tm_left"><span class="tm_name" style="color:<?php echo $titlecolor; ?>"><?php echo esc_html($tmpost->post_title); ?></span>
                    <span class="tm_designation" style="color:<?php echo $designationcolor; ?>"><?php echo esc_html($designation); ?></span></div>
                <div class="tm_right"><span class="tm_icon"><i style="color:<?php echo $color; ?>;font-size:35px" data-modal="popup" data-memberid="<?php echo (int) $tmpost->ID ?>" class="fas fa-angle-down showContent"></i></span></div>
            </div>
        </div>
    </div>
</div>