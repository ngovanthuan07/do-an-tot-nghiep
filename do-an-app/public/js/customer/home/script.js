$(document).ready(function () {
    $(".team-slider-recent").owlCarousel({
        loop: false,
        nav: true,
        navText: [
            `<i class="fa-sharp fa-solid fa-chevron-left" style="font-size: 16px;"></i>`,
            `<i class="fa-sharp fa-solid fa-chevron-right" style="font-size: 16px;"></i>`,
        ],
        margin: 20,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            991: {
                items: 4,
            },
            1920: {
                items: 4,
            },
        },
    });

    $(".product-slider").owlCarousel({
        loop: false,
        nav: true,
        navText: [
            `<i class="fa-sharp fa-solid fa-chevron-left" style="font-size: 16px;"></i>`,
            `<i class="fa-sharp fa-solid fa-chevron-right" style="font-size: 16px;"></i>`,
        ],
        margin: 20,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            991: {
                items: 4,
            },
            1920: {
                items: 5,
            },
        },
    });
});
