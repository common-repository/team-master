<?php

$member_email = get_post_meta($tmpost->ID, 'member_email', true);
$member_tel = get_post_meta($tmpost->ID, 'member_tel', true);
$member_social_media = maybe_unserialize(get_post_meta($tmpost->ID, 'member_social_media', true));
$member_short_description = get_post_meta($tmpost->ID, 'member_short_description', true);
$featured_modal_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-modal-image-size');
$featured_thumnail_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-thumbnail-image-size');
$featured_grid_img_url = get_the_post_thumbnail_url($tmpost->ID, 'tm-grid-image-size');
$title = get_the_title($tmpost->ID);
$content = $tmpost->post_content;
$designation = get_post_meta($tmpost->ID, 'member_designation', true);
$url = get_the_permalink($tmpost->ID);


$args = array(
    'member_name' => $title,
    'member_designation' => $designation,
    'member_email' => $member_email,
    'member_phone' => $member_tel,
    'member_short_description' => $member_short_description,
    'member_description' => $content,
    'member_image_url_360_490' => $featured_modal_img_url,
    'member_image_url_250_250' => $featured_thumnail_img_url,
    'member_image_url_300_320' => $featured_grid_img_url,
    'member_social_media' => $member_social_media,
    'member_url' => $url,
    'template_styling_options' => array(
        'template_bg_color' => $background,
        'template_description_font_color' => $color,
        'template_button_bg_color' => $buttonColor,
        'template_button_font_color' => $buttonColor,
        'template_name_font_color' => $titlecolor,
        'template_designation_font_color' => $designationcolor,
        'template_grid_classes' => $classes,
    )
);


/**
 * Action for defining the template markup
 *
 * @since    1.0.6
 * $arg $args
 * return $templatehtml
 */
do_action('add_template_markup_frontend', $args);
?>