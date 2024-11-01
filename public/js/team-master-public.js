var app = {
    ajaxUrl: usageObj.ajaxurl,
    ajaxNonce: usageObj.ajaxnonce,
    slidesTOShow: 3,
    autoPlay: true,
    slickSlider: jQuery('.tm_carousel'),
    init: function () {
        app.showModal();
        app.closeModal();
        app.loadMore();
        app.Carousel();
    },
    Carousel: function () {
        jQuery(document).on('ready', function () {

            app.slickSlider.each(function () {

                app.slidesTOShow = parseInt(jQuery(this).attr('data-slidesToShow'));
                app.autoPlay = jQuery(this).attr('data-autoPlay');
                var templateId = jQuery(this).attr('id');
                jQuery('#' + templateId).slick({
                    slidesToShow: app.slidesTOShow,
                    speed: 600,
                    autoplay: app.autoPlay,
                    autoplaySpeed: 1500,
                    pauseOnHover: true,
                    adaptiveHeight: true,
                    easing: 'linear',
                    responsive: [
                        {
                            breakpoint: 769,
                            settings: {
                                arrows: true,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: true,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });


            });

        });
    },
    showModal: function () {
        jQuery(document).on('click', '.showContent', function () {

            var memberid = jQuery(this).attr('data-memberid');
            var modal = jQuery(this).attr('data-modal');
            jQuery('.tm_popup').css({visibility: 'visible', opacity: 1});
            jQuery.ajax({
                url: app.ajaxUrl,
                type: 'POST',
                data: {
                    action: "tm_retrive_modal",
                    memberid: memberid,
                    nonce: app.ajaxNonce
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status == false) {
                        alert(res.message);
                    } else {
                        var results = res.result;
                        jQuery('.tm_popup-inner').html(results);
                        jQuery('.tm_popup-inner').css({bottom: 0, right: 0, transform: 'rotate(0)'});
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });
        });
    },
    closeModal: function () {
        jQuery(document).on('click', '.tm_popup__close', function () {
            jQuery('.tm_popup').css({visibility: 'hidden', opacity: 0});
            jQuery('.tm_popup-inner').css({bottom: '-100vw', right: '-100vh', transform: 'rotate(32deg)'});
        });
    },
    loadMore: function () {
        jQuery(document).on('click', '.load_members', function (event) {
            event.preventDefault();
            jQuery(this).text('Loading..');
            var pagenumber = jQuery(this).attr('data-pagenumber');
            var classes = jQuery(this).attr('data-classes');
            var postsperpage = jQuery(this).attr('data-postsperpage');
            var excludedMember = jQuery(this).attr('data-excludedMember');
            var bg = jQuery(this).attr('data-bg');
            var color = jQuery(this).attr('data-color');
            var titlecolor = jQuery(this).attr('data-titlecolor');
            var designationcolor = jQuery(this).attr('data-designationcolor');
            var btnbg = jQuery(this).attr('data-btnbg');
            var btncolor = jQuery(this).attr('data-btncolor');
            var role = jQuery(this).attr('data-role');
            var template = jQuery(this).attr('data-template');
            jQuery.ajax({
                url: app.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'tm_ajax_members_loadmore',
                    page: pagenumber,
                    classes: classes,
                    postsperpage: postsperpage,
                    role: role,
                    excludedMember: excludedMember,
                    bg: bg,
                    color: color,
                    titlecolor: titlecolor,
                    designationcolor: designationcolor,
                    btnbg: btnbg,
                    btncolor: btncolor,
                    template: template
                },
                success: function (results) {
                    var res = JSON.parse(results);
                    if (res.status == 1) {
                        pagenumber++;
                        jQuery(res.html).hide().appendTo(".tm_template_" + template + " .loadmoremembersrow").fadeIn(2000);
                        jQuery("#load_members_" + template + "").attr('data-pagenumber', pagenumber);
                        jQuery("#load_members_" + template + "").html('Load More <i class="fa fa-angle-right"></i>');
                    } else {
                        jQuery(res.html).appendTo(".tm_template_" + template + " .loadmoremembersrow");
                        jQuery("#load_members_" + template + "").fadeOut().remove();
                        setTimeout(function () {
                            jQuery('.error_message').fadeOut().remove();
                        }, 3000);
                    }
                }
            });
        });
    }
};

(function () {
    app.init();
})(jQuery);
