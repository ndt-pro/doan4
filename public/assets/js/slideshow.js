// slide sử dụng thư viện olw carousel

$(document).ready(function() {
    $('#slideshow').owlCarousel({
        loop: true, // vòng lặp
        animateOut: 'slideOutDown', // hiệu trượt xuống
        animateIn: 'flipInX', // hiệu ứng lật
        margin: 20,
        items: 1, // số lượng item trên màn hình
        smartSpeed: 450, // tốc độ chuyển
        autoplay: true, // tự động chuyển
        autoplayTimeout: 3000 // thời gian chuyển
    });

    $('#hot-products').owlCarousel({
        margin: 10,
        loop: true,
        items: 4,
        autoplay: true,
        autoplayTimeout: 2000,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    $('#brands').owlCarousel({
        margin: 20,
        loop: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 2000,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });
});