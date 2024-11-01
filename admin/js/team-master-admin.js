var app = {
    socialMedias: social_media_items.member_social_media,
    socialMediaIcons: {
        "Select Icon": "-1",
        "Facebook": "fa-facebook-f",
        "Twitter": "fa-twitter",
        "Linkedin": "fa-linkedin",
        "Instagram": "fa-instagram",
        "Google Plus": "fa-google-plus",
        "YouTube": "fa-youtube",
        "WordPress": "fa-wordpress",
        "Blogger": "fa-blogger-b",
        "Dropbox": "fa-dropbox",
        "Stack overflow": "fa-stack-overflow",
        "Pinterest": "fa-pinterest-p",
        "Github": "fa-github",
        "Reddit": "fa-reddit-alien",
        "Soundcloud": "fa-soundcloud",
        "Yahoo": "fa-yahoo",
        "Tumblr": "fa-tumblr",
        "Behance": "fa-behance",
        "Dribble": "fa-dribbble",
        "Flickr": "fa-flickr",
        "Vimeo": "fa-vimeo-v",
        "Google Drive": "fa-google-drive",
        "Website": "fa-link"
    },
    init: function () {
        app.renderMedia();
        app.createMedia();
        app.removeMedia();
        app.changeMediaIcon();
        app.changeMediaLink();
    },
    renderMedia: function () {
        if (app.socialMedias === undefined || app.socialMedias.length == 0) {
            app.socialMedias = [{'icon': '-1', 'link': ''}];
        }
        app.socialMedias.forEach(function (item, j) {
            var html = '<div class="social_meta ui-state-default" id="social_meta_' + j + '" style="width:98%;display:flex">';
            html += '<select data-id="' + j + '" name="member_social_media[' + j + '][icon]" style="width:50%;margin-bottom:15px;height:30px">';
            for (var key in app.socialMediaIcons) {
                var selected = "";
                if (item['icon'] == app.socialMediaIcons[key]) {
                    selected = "selected";
                }
                html += '<option ' + selected + ' value="' + app.socialMediaIcons[key] + '">' + key + '</option>';
            }
            html += '</select>';
            html += '<input data-id="' + j + '" value="' + item['link'] + '" type="url" name="member_social_media[' + j + '][link]" placeholder="Please add a link against the selected icon" style="width:50%;margin-bottom:15px;height:30px" />';
            if (j != '0') {
                html += '<span class="dashicons dashicons-trash removeSocialMedia" data-id="' + j + '"></span>';
            }
            html += '</div>';
            jQuery(html).appendTo("#social_meta_container");
        });
        jQuery("#social_meta_container").sortable({
            placeholder: "ui-state-highlight"
        });
        jQuery("#social_meta_container").disableSelection();
    },
    createMedia: function () {
        jQuery(document).on('click', '#createSocialMedia', function () {
            var num = jQuery('.social_meta').length;
            var html = '<div class="social_meta ui-state-default" id="social_meta_' + num + '" style="width:98%;display:flex">';
            html += '<select data-id="' + num + '" name="member_social_media[' + num + '][icon]" style="width:50%;margin-bottom:15px;height:30px">';
            for (var key in app.socialMediaIcons) {
                html += '<option value="' + app.socialMediaIcons[key] + '">' + key + '</option>';
            }
            html += '</select>';
            html += '<input data-id="' + num + '" value="" type="url" name="member_social_media[' + num + '][link]" placeholder="Please add a link against the selected icon" style="width:50%;margin-bottom:15px;height:30px" />';
            html += '<span class="dashicons dashicons-trash removeSocialMedia" data-id="' + num + '"></span>';
            html += '</div>';
            jQuery(html).appendTo("#social_meta_container");
            var newElement = {'icon': '-1', 'link': ''};
            app.socialMedias.push(newElement);

        });
    },
    removeMedia: function () {
        jQuery(document).on('click', '.removeSocialMedia', function () {
            var id = parseInt(jQuery(this).attr('data-id'));
            jQuery('#social_meta_' + id).remove();
            app.socialMedias.splice(id, 1);
            jQuery('#social_meta_container').html('');
            app.renderMedia();
        });
    },
    changeMediaIcon: function () {
        jQuery(document).on('change', '#social_meta_container > div > select', function () {
            var id = jQuery(this).attr('data-id');
            var value = jQuery(this).val();
            app.socialMedias[id]['icon'] = value;
        });
    },
    changeMediaLink: function () {
        jQuery(document).on('change', '#social_meta_container > div > input', function () {
            var id = jQuery(this).attr('data-id');
            var value = jQuery(this).val();
            app.socialMedias[id]['link'] = value;
        });
    }
};

(function ($) {
    app.init();
})(jQuery);