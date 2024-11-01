<?php
get_header();

$role = !empty($atts['role']) ? $atts['role'] : array();
$exclude_members = !empty($atts['exclude_members']) ? $atts['exclude_members'] : array();
$template = !empty($atts['template']) ? $atts['template'] : get_option('tm_default_template');
$columns = !empty($atts['columns']) ? $atts['columns'] : get_option('tm_default_column');
$per_page = !empty($atts['per_page']) ? $atts['per_page'] : get_option('tm_default_perpage');
$background = !empty($atts['background_color']) ? $atts['background_color'] : get_option('tm_default_background_color');
$color = !empty($atts['color']) ? $atts['color'] : get_option('tm_default_color');

/* * **************** Button default options *************** */
$buttonBg = !empty($atts['btnbg']) ? $atts['btnbg'] : get_option('tm_default_btn_color');
$buttonColor = !empty($atts['btncolor']) ? $atts['btncolor'] : get_option('tm_default_btn_font_color');
$loadMore = !empty($atts['load_more']) ? $atts['load_more'] : get_option('tm_default_load_more');

/* * **************** Carousel default options *************** */
$carousel = !empty($atts['carousel']) ? $atts['carousel'] : get_option('tm_default_activate_carousel');
$autoplay = !empty($atts['autoplay']) ? $atts['autoplay'] : get_option('tm_default_auto_play_carousel');
/* * **************** Color default options *************** */
$titlecolor = !empty($atts['titlecolor']) ? $atts['titlecolor'] : get_option('tm_default_title_color');
$designationcolor = !empty($atts['designationcolor']) ? $atts['designationcolor'] : get_option('tm_default_designation_color');

$postType = 'tm_members';
$taxonomy = 'tm_members_role';
if ($columns == 1) {
    $columnsLg = 'col-lg-12';
    $columnsMd = 'col-md-12';
    $columnsSm = 'col-sm-12';
    $classes = $columnsSm . ' ' . $columnsMd . ' ' . $columnsLg;
    $postsPerpage = $per_page;
}else if ($columns == 2) {
    $columnsLg = 'col-lg-6';
    $columnsMd = 'col-md-6';
    $columnsSm = 'col-sm-6';
    $classes = $columnsSm . ' ' . $columnsMd . ' ' . $columnsLg;
    $postsPerpage = $per_page;
} else if ($columns == 3) {
    $columnsLg = 'col-lg-4';
    $columnsMd = 'col-md-6';
    $columnsSm = 'col-sm-6';
    $classes = $columnsSm . ' ' . $columnsMd . ' ' . $columnsLg;
    $postsPerpage = $per_page;
} else if ($columns == 4) {
    $columnsLg = 'col-lg-3';
    $columnsMd = 'col-md-4';
    $columnsSm = 'col-sm-6';
    $classes = $columnsSm . ' ' . $columnsMd . ' ' . $columnsLg;
    $postsPerpage = $per_page;
} else {
    $columnsLg = 'col-lg-4';
    $columnsMd = 'col-md-6';
    $columnsSm = 'col-sm-6';
    $classes = $columnsSm . ' ' . $columnsMd . ' ' . $columnsLg;
    $postsPerpage = $per_page;
    $columns = 3;
}
$carouselClass = '';
$sliderData = '';
if ($autoplay == 'yes') {
    $autoplay = true;
} else {
    $autoplay = false;
}
if ($carousel == 'yes') {
    $carouselClass = "tm_carousel";
    $sliderData = 'data-slidesToShow="' . $columns . '" data-autoPlay="' . $autoplay . '"';
}
$term_ids = array();
$terms = get_terms($taxonomy, array('hide_empty' => false,));
foreach ($terms as $term) {
    $term_ids[] = $term->term_id;
}
if (empty($role)) {
    $role = $term_ids;
} else {
    $role = explode(',', $role);
}
if (empty($exclude_members)) {
    $exclude_members = array();
} else {
    $exclude_members = explode(',', $exclude_members);
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$postsPerPage = $postsPerpage;
$totalMembers = wp_count_posts($postType)->publish;
$num_of_pages = ceil($totalMembers / $postsPerPage);

$tmposts = get_posts(array(
    'posts_per_page' => $postsPerPage,
    'post_type' => $postType,
    'post__not_in' => $exclude_members,
    'paged' => $paged,
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => $role
        )
    )
        )
);

echo '<div class="container" style="padding:40px 0px">';
if ($template == 1) {
    if ($tmposts) {
        echo '<div id="storiesloader" style="border-color:' . $background . ';border-top-color:' . $color . '"></div>';
        echo '<div class="default_shortcode tm_template_' . $template . '">';
        echo '<div id="tm_template_' . $template . '" class="row loadmoremembersrow ' . $carouselClass . '" ' . $sliderData . '>';
        foreach ($tmposts as $key => $tmpost) {
            $designation = get_post_meta($tmpost->ID, 'member_designation', true);
            $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-modal-image-size');
            $url = get_the_permalink($tmpost->ID);
            require plugin_dir_path(dirname(__FILE__)) . 'templates/tm_template_1.php';
        }
        echo '</div>';
        if ($num_of_pages > 1 && $loadMore == 'yes' && $carousel == 'no') {
            ?>
            <div class="tm_full_readmore col-xs-12 text-center">
                <button class="tm_full_readmore_btn load_members" style="background-color:<?php echo $background; ?> !important;color:<?php echo $color; ?> !important;border:1px solid <?php echo $background; ?> !important" id="load_members_<?php echo $template; ?>" data-template="<?php echo $template; ?>" data-color="<?php echo $color; ?>" data-titlecolor="<?php echo $titlecolor; ?>" data-designationcolor="<?php echo $designationcolor; ?>" data-bg="<?php echo $background; ?>" data-btncolor="<?php echo $buttonColor; ?>" data-btnbg="<?php echo $buttonBg; ?>" data-role="<?php echo maybe_serialize($role); ?>" data-excludedMember="<?php echo maybe_serialize($exclude_members); ?>" data-postsperpage="<?php echo $postsPerPage; ?>" data-pagenumber="<?php echo ++$paged; ?>" data-classes="<?php echo $classes; ?>"><?php echo __('Load More', 'team-master') ?> <i class="fa fa-angle-right"></i></button>
            </div>
            <?php
        }
        echo '</div>';
    }
}
if ($template == 2) {
    if ($tmposts) {
        echo '<div id="storiesloader" style="border-color:' . $background . ';border-top-color:' . $color . '"></div>';
        echo '<div class="default_shortcode tm_template_' . $template . '">';
        echo '<div id="tm_template_' . $template . '" class="row loadmoremembersrow ' . $carouselClass . '" ' . $sliderData . '>';
        foreach ($tmposts as $tmpost) {
            $designation = get_post_meta($tmpost->ID, 'member_designation', true);
            $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-thumbnail-image-size');
            $url = get_the_permalink($tmpost->ID);
            $member_email = get_post_meta($tmpost->ID, 'member_email', true);
            $member_tel = get_post_meta($tmpost->ID, 'member_tel', true);
            $member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
            $member_short_description = get_post_meta($tmpost->ID, 'member_short_description', true);

            require plugin_dir_path(dirname(__FILE__)) . 'templates/tm_template_2.php';
        }
        echo '</div>';
        if ($num_of_pages > 1 && $loadMore == 'yes' && $carousel == 'no') {
            ?>
            <div class="tm_full_readmore col-xs-12 text-center">
                <button class="tm_full_readmore_btn load_members" style="background-color:<?php echo $background; ?> !important;color:<?php echo $color; ?> !important;border:1px solid <?php echo $background; ?> !important" id="load_members_<?php echo $template; ?>" data-template="<?php echo $template; ?>" data-color="<?php echo $color; ?>" data-titlecolor="<?php echo $titlecolor; ?>" data-designationcolor="<?php echo $designationcolor; ?>" data-bg="<?php echo $background; ?>" data-btncolor="<?php echo $buttonColor; ?>" data-btnbg="<?php echo $buttonBg; ?>" data-role="<?php echo maybe_serialize($role); ?>" data-excludedMember="<?php echo maybe_serialize($exclude_members); ?>" data-postsperpage="<?php echo $postsPerPage; ?>" data-pagenumber="<?php echo ++$paged; ?>" data-classes="<?php echo $classes; ?>"><?php echo __('Load More', 'team-master') ?> <i class="fa fa-angle-right"></i></button>
            </div>
            <?php
        }
        echo '</div>';
    }
}
if ($template == 3) {
    if ($tmposts) {
        echo '<div id="storiesloader" style="border-color:' . $background . ';border-top-color:' . $color . '"></div>';
        echo '<div class="default_shortcode tm_template_' . $template . '">';
        echo '<div id="tm_template_' . $template . '" class="row loadmoremembersrow ' . $carouselClass . '" ' . $sliderData . '>';
        foreach ($tmposts as $tmpost) {
            $designation = get_post_meta($tmpost->ID, 'member_designation', true);
            $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-thumbnail-image-size');
            $url = get_the_permalink($tmpost->ID);
            $member_email = get_post_meta($tmpost->ID, 'member_email', true);
            $member_tel = get_post_meta($tmpost->ID, 'member_tel', true);
            $member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
            $member_short_description = get_post_meta($tmpost->ID, 'member_short_description', true);

            require plugin_dir_path(dirname(__FILE__)) . 'templates/tm_template_3.php';
        }
        echo '</div>';
        if ($num_of_pages > 1 && $loadMore == 'yes' && $carousel == 'no') {
            ?>
            <div class="tm_full_readmore col-xs-12 text-center">
                <button class="tm_full_readmore_btn load_members" style="background-color:<?php echo $background; ?> !important;color:<?php echo $color; ?> !important;border:1px solid <?php echo $background; ?> !important" id="load_members_<?php echo $template; ?>" data-template="<?php echo $template; ?>" data-color="<?php echo $color; ?>" data-titlecolor="<?php echo $titlecolor; ?>" data-designationcolor="<?php echo $designationcolor; ?>" data-bg="<?php echo $background; ?>" data-btncolor="<?php echo $buttonColor; ?>" data-btnbg="<?php echo $buttonBg; ?>" data-role="<?php echo maybe_serialize($role); ?>" data-excludedMember="<?php echo maybe_serialize($exclude_members); ?>" data-postsperpage="<?php echo $postsPerPage; ?>" data-pagenumber="<?php echo ++$paged; ?>" data-classes="<?php echo $classes; ?>"><?php echo __('Load More', 'team-master') ?> <i class="fa fa-angle-right"></i></button>
            </div>
            <?php
        }
        echo '</div>';
    }
}
if ($template == 4) {
    if ($tmposts) {
        echo '<div id="storiesloader" style="border-color:' . $background . ';border-top-color:' . $color . '"></div>';
        echo '<div class="default_shortcode tm_template_' . $template . '">';
        echo '<div id="tm_template_' . $template . '" class="row loadmoremembersrow ' . $carouselClass . '" ' . $sliderData . '>';
        foreach ($tmposts as $key => $tmpost) {
            $designation = get_post_meta($tmpost->ID, 'member_designation', true);
            $featured_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-modal-image-size');
            $member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
            $url = get_the_permalink($tmpost->ID);
            require plugin_dir_path(dirname(__FILE__)) . 'templates/tm_template_4.php';
        }
        echo '</div>';
        if ($num_of_pages > 1 && $loadMore == 'yes' && $carousel == 'no') {
            ?>
            <div class="tm_full_readmore col-xs-12 text-center">
                <button class="tm_full_readmore_btn load_members" style="background-color:<?php echo $background; ?> !important;color:<?php echo $color; ?> !important;border:1px solid <?php echo $background; ?> !important" id="load_members_<?php echo $template; ?>" data-template="<?php echo $template; ?>" data-color="<?php echo $color; ?>" data-titlecolor="<?php echo $titlecolor; ?>" data-designationcolor="<?php echo $designationcolor; ?>" data-bg="<?php echo $background; ?>" data-btncolor="<?php echo $buttonColor; ?>" data-btnbg="<?php echo $buttonBg; ?>" data-role="<?php echo maybe_serialize($role); ?>" data-excludedMember="<?php echo maybe_serialize($exclude_members); ?>" data-postsperpage="<?php echo $postsPerPage; ?>" data-pagenumber="<?php echo ++$paged; ?>" data-classes="<?php echo $classes; ?>"><?php echo __('Load More', 'team-master') ?> <i class="fa fa-angle-right"></i></button>
            </div>
            <?php
        }
        echo '</div>';
    }
}
if ($template == 'custom') {
    if ($tmposts) {
        echo '<div id="storiesloader" style="border-color:' . $background . ';border-top-color:' . $color . '"></div>';
        echo '<div class="default_shortcode tm_template_' . $template . '">';
        echo '<div id="tm_template_' . $template . '" class="row loadmoremembersrow ' . $carouselClass . '" ' . $sliderData . '>';
        foreach ($tmposts as $key => $tmpost) {
            require plugin_dir_path(dirname(__FILE__)) . 'templates/tm_template_custom.php';
        }
        echo '</div>';
        if ($num_of_pages > 1 && $loadMore == 'yes' && $carousel == 'no') {
            ?>
            <div class="tm_full_readmore col-xs-12 text-center">
                <button class="tm_full_readmore_btn load_members" style="background-color:<?php echo $background; ?> !important;color:<?php echo $color; ?> !important;border:1px solid <?php echo $background; ?> !important" id="load_members_<?php echo $template; ?>" data-template="<?php echo $template; ?>" data-color="<?php echo $color; ?>" data-titlecolor="<?php echo $titlecolor; ?>" data-designationcolor="<?php echo $designationcolor; ?>" data-bg="<?php echo $background; ?>" data-btncolor="<?php echo $buttonColor; ?>" data-btnbg="<?php echo $buttonBg; ?>" data-role="<?php echo maybe_serialize($role); ?>" data-excludedMember="<?php echo maybe_serialize($exclude_members); ?>" data-postsperpage="<?php echo $postsPerPage; ?>" data-pagenumber="<?php echo ++$paged; ?>" data-classes="<?php echo $classes; ?>"><?php echo __('Load More', 'team-master') ?> <i class="fa fa-angle-right"></i></button>
            </div>
            <?php
        }
        echo '</div>';
    }
}
if ($template == -1) {
    echo __('No Template', 'team-master');
}
echo '</div>';

get_footer();
