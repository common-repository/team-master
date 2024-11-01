var accord = {
    ajaxUrl: usageObj.ajaxurl,
    ajaxNonce: usageObj.ajaxnonce,
    membersrole: jQuery(".ts-members-basic-multiple"),
    members: jQuery(".ts-members-multiple"),
    membersperPage: jQuery(".ts-members-per-page"),
    displayinColumns: jQuery(".ts-display-members-per-page"),
    init: function () {
        accord.renderRoleMembers();
        accord.shortcodeBuilder();
        accord.initColorPicker();
        accord.initCustomTemplate();
    },
    initCustomTemplate: function () {
         
    },
    renderRoleMembers: function () {
        accord.membersrole.select2({
            placeholder: "Select a Member Role",
            allowClear: true
        });
        accord.membersrole.on("change", function (e) {
            var OptionsData = accord.membersrole.select2('val');
            jQuery('.tmloader').fadeIn();
            jQuery.ajax({
                url: accord.ajaxUrl,
                type: 'POST',
                data: {
                    action: "tm_retrive_members",
                    roles: OptionsData,
                    nonce: accord.ajaxNonce
                },
                success: function (response) {
                    jQuery('.tmloader').fadeOut();
                    var res = JSON.parse(response);
                    if (res.status == false) {
                        alert(res.message);
                    } else {
                        var results = res.result;
                        var options = [];
                        jQuery.each(results, function (key, option) {
                            var newOption = new Option(option.text, option.id, false, false);
                            options.push(newOption);
                        });
                        accord.members.html(options);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('.tmloader').fadeOut();
                    console.log(thrownError);
                }
            });
        });
        accord.members.select2({
            placeholder: "Select a Member to Exclude",
        });
        accord.membersperPage.select2({
            placeholder: "Select Members That you want to display",
        });
        accord.displayinColumns.select2({
            placeholder: "Select Columns",
        });
    },
    shortcodeBuilder: function () {
        jQuery(document).on('click', '#generate_shortcode', function (e) {

            e.preventDefault();
            var $membersRole = accord.membersrole.select2('val');
            var $excludedMembers = accord.members.select2('val');
            var $memPerPage = accord.membersperPage.select2('val');
            var $tm_column = accord.displayinColumns.select2('val');
            var $tm_template = jQuery('.tm_template:checked').val();
            var $tm_background_color = jQuery('.tm_default_background_color').val();
            var $tm_color = jQuery('.tm_default_color').val();
            var $tm_btn_color = jQuery('.tm_default_btn_color').val();
            var $tm_btn_font_color = jQuery('.tm_default_btn_font_color').val();

            var $tm_default_title_color = jQuery('.tm_default_title_color').val();
            var $tm_default_designation_color = jQuery('.tm_default_designation_color').val();

            var $tm_btn_color = jQuery('.tm_default_btn_color').val();
            var $tm_btn_font_color = jQuery('.tm_default_btn_font_color').val();

            var $tm_default_load_more = jQuery('.tm_default_load_more:checked').val();

            var $tm_default_activate_carousel = jQuery('.tm_default_activate_carousel:checked').val();
            var $tm_default_auto_play_carousel = jQuery('.tm_default_auto_play_carousel:checked').val();

            var $shortcode = '';
            var role = '';
            var exlMembers = '';
            var perPage = '';
            var template = '';
            var columns = '';
            var background = '';
            var color = '';
            var btncolor = '';
            var btnfontcolor = '';
            var titlecolor = '';
            var designationfontcolor = '';
            var load_more = '';

            var carousel = '';
            var auto_play = '';

            if ($membersRole) {
                role = $membersRole.join();
            }
            if ($excludedMembers) {
                exlMembers = $excludedMembers.join();
            }
            if ($memPerPage) {
                perPage = $memPerPage;
            }
            if ($tm_template) {
                template = $tm_template;
            }
            if ($tm_column) {
                columns = $tm_column;
            }
            if ($tm_background_color) {
                background = $tm_background_color;
            }
            if ($tm_color) {
                color = $tm_color;
            }
            if ($tm_btn_color) {
                btncolor = $tm_btn_color;
            }
            if ($tm_btn_font_color) {
                btnfontcolor = $tm_btn_font_color;
            }
            if ($tm_default_title_color) {
                titlecolor = $tm_default_title_color;
            }
            if ($tm_default_designation_color) {
                designationfontcolor = $tm_default_designation_color;
            }

            if ($tm_default_load_more) {
                load_more = $tm_default_load_more;
            }
            if ($tm_default_activate_carousel) {
                carousel = $tm_default_activate_carousel;
            }
            if ($tm_default_auto_play_carousel) {
                auto_play = $tm_default_auto_play_carousel;
            }

            $shortcode = '[team_master role="' + role + '" exclude_members="' + exlMembers + '" template="' + template + '" background="' + background + '" color="' + color + '" titlecolor="' + titlecolor + '" designationcolor="' + designationfontcolor + '" btnbg="' + btncolor + '" btncolor="' + btnfontcolor + '" columns="' + columns + '" per_page="' + perPage + '" load_more="' + load_more + '" carousel="' + carousel + '" autoplay="' + auto_play + '"]';
            jQuery('#shortcode_container').text($shortcode);
            jQuery('#shortcode_container').css({'border': '3px solid #44BBA4', 'color': '#44BBA4', 'font-weight': 'bold', 'height': '200px'});
            jQuery('html, body').animate({
                scrollTop: jQuery(".shortcode_containers").offset().top
            }, 500);
        });
    },
    initColorPicker: function () {
        jQuery('.tm_default_styling').wpColorPicker();
        jQuery(function () {
            jQuery("#accordion").accordion({
                collapsible: true
            });
        });
    }
};
(function () {
    accord.init();
})(jQuery);