<?php
get_header();
global $post;
$memberid = $post->ID;
$member = get_post($memberid);
if ($member) {
    $designation = get_post_meta($memberid, 'member_designation', true);
    $member_email = get_post_meta($memberid, 'member_email', true);
    $member_tel = get_post_meta($memberid, 'member_tel', true);
    $featured_img_url = get_the_post_thumbnail_url($memberid, 'tm-thumbnail-image-size');
    $member_social_media = maybe_unserialize(get_post_meta($memberid, 'member_social_media', true));
    $member_short_description = get_post_meta($memberid, 'member_short_description', true);
    $background = get_option('tm_default_background_color');
    $color = get_option('tm_default_color');
    $url = get_the_permalink($memberid);
    $titlecolor = get_option('tm_default_title_color');
    $designationcolor = get_option('tm_default_designation_color');
    $color = get_option('tm_default_color');
    ob_start();
    ?>
    <div class="row single_member_header text-center" style="padding: 40px 0px 0px;">
        <div class="image_container" style="margin: auto;padding-bottom: 10px;">
            <?php if (!empty($featured_img_url)) { ?>
                <img src="<?php echo esc_url($featured_img_url); ?>" style="border-radius: 50%;"/>
            <?php } else { ?>
                <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . '../img/avatar-250x250.png'); ?>" style="border-radius: 50%;border:5px solid #f2f2f2;box-shadow: 1px 1px 5px #888;"/>
            <?php } ?>
        </div>
        <div class="col-sm-12 text-center">
            <span class="tm_full_name" style="text-align: center;color:<?php echo $titlecolor; ?>"><?php echo esc_html($member->post_title); ?></span>
            <?php if (!empty($designation)) { ?>
                <span class="tm_full_designation" style="text-align: center;color:<?php echo $designationcolor; ?>"><?php echo esc_html($designation); ?></span>
            <?php } ?>
        </div>
    </div>

    <div class="container" style="padding: 0px 20px 20px">
        <div class="row">
            <div class="col-sm-12 text-center" style="padding: 20px">
                <p style="color: inherit;font-family: inherit;"><?php echo $member->post_content; ?></p>
                <?php if (!empty($member_email)) { ?>
                    <div class="tm_full_email" style="margin-top: 20px">
                        <span><strong><a href="mailto:<?php echo sanitize_email($member_email); ?>"><?php echo sanitize_email($member_email); ?></a></strong></span>
                    </div>
                <?php } ?>
                <?php if (!empty($member_tel)) { ?>
                    <div class="tm_full_phone">
                        <span><strong><?php echo '+' . $member_tel; ?></strong></span>
                    </div>
                <?php } ?>

                <?php if (is_array($member_social_media)) { ?>
                    <div class="tm_full_social">
                        <?php
                        foreach ($member_social_media as $key => $social_media) {
                            ?>
                            <a href="<?php echo esc_url($social_media['link']); ?>"><i class="fa <?php echo sanitize_html_class($social_media['icon']); ?>"></i></a>
                                <?php
                            }
                            ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
}
echo $output;

get_footer();
