// NDTPRO Script
const loading = '<i class="fa fa-spinner fa-spin"></i>';
const csrf_token = $("meta[name='_token']").attr("content");

$(document).ready(function() {
    $(".col-menu").click(function() {
        $(".sidenav").css({
            "width": "100%",
            "height": "100%"
        });
        $(".side-menu").css({
            "margin-left": "0"
        });
    });

    $(".sidenav .close").click(function() {
        $(".sidenav").css({
            "width": "0",
            "height": "0"
        });
        $(".side-menu").css({
            "margin-left": "-100%"
        });
    });

    // dropdown menu in desktop device
    // $(".dropdown").hover(function() {
    //     if (!window.matchMedia("only screen and (max-width: 768px)").matches) {
    //         let content = $(".dropdown-menu");
    //         content.show();
    //         content.animate({
    //             'opacity': '1',
    //             'top': '100%'
    //         });
    //     }
    // }, function() {
    //     if (!window.matchMedia("only screen and (max-width: 768px)").matches) {
    //         let content = $(".dropdown-menu");
    //         content.hide();
    //         content.css({
    //             'opacity': '0',
    //             'top': '150%'
    //         });
    //     }
    // });

    // dropdown menu in mobile device
    $(".dropdown>a").click(function(e) {
        if (window.matchMedia("only screen and (max-width: 768px)").matches) {
            e.preventDefault();
            let content = $(".dropdown-menu");
            content.slideToggle();
            $(".sub-arrow").toggleClass("sub-arrow-up");
        }
    });

    // cart animation
    // $(".cart-info").hover(function() {
    //     let content = $(".cart-products");
    //     content.show();
    //     content.animate({
    //         'opacity': '1',
    //         'min-width': '400px'
    //     });
    // }, function() {
    //     let content = $(".cart-products");
    //     content.hide();
    //     content.css({
    //         'opacity': '0',
    //         'min-width': '350px'
    //     });
    // });
    // $(".cart-info").hover(function() {
    //     let content = $(".cart-products");
    //     content.slideToggle();
    // });

    $("#uptop").click(function() {
        let target = $("#top");
        $('html,body').stop().animate({
            scrollTop: $(target).offset().top
        }, 1000);
        event.preventDefault();
    });

    var ontop = $("#ontop");
    var y_pos = ontop.offset().top;
    var height = ontop.height();

    $(window).scroll(function() {
        var scrollTop = $(document).scrollTop();
        if (scrollTop > y_pos + height) {
            ontop.addClass("sticky");
        } else if (scrollTop <= y_pos) {
            ontop.removeClass("sticky");
        }
        let scroll = (document.documentElement.scrollHeight - document.documentElement.clientHeight) / 2;
        if (scrollTop > scroll) {
            // đã kéo xuống 1 nửa trang web
            $(".scroll_top").css({
                'bottom': '50px'
            });
        } else {
            $(".scroll_top").css({
                'bottom': '-50%'
            });
        }
    });

    $('.modal .close').click(function() {
        $('.modal').hide();
    });

    $(window).on('click', function(e) {
        if ($(e.target).is('.modal')) {
            $('.modal').hide();
        }
    });

    $('.notifications .close').click(function() {
        $('.notifications').hide();
    });
});

function openNotifications(type, text, time = 3000) {
    let alert = $(".notifications>[data-alert='notifications']");
    let notifications = $('.notifications');
    alert.attr("class", "");
    alert.addClass("alert alert-" + type);
    alert.html(text);
    notifications.show();

    setTimeout(function() {
        notifications.hide();
    }, time);
}