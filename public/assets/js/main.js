/*
  [JS Index]
*/


/*
  1. preloader
  2. navigation
  3. animate elements
  4. magnificPopup
  5. owl carousel
  6. clone function
  7. facts counter
  8. toggle blog panels
  9. swiper slider
  10. contact form
*/


$(function() {
    "use strict";
	
	
    $(window).on("load", function() {
        // 1. preloader
        $("#preloader").fadeOut(600);
        $(".preloader-bg").delay(400).fadeOut(600);
    });
	
    // 2. navigation
    $('a[href*="#"]').not('[href="#"]').not('[href="#collapseOne"]').not('[href="#collapseTwo"]').not('[href="#collapseThree"]').not('[href="#collapseFour"]').not('[href="#collapseFive"]').not(
        '[href="#collapseSix"]').on("click", function() {
        console.log("click");
        if (location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=" + this.hash.slice(1) + "]');
            if (target.length) {
                if ($(window).width() < 768) {
                    $("html, body").animate({
                        scrollTop: target.offset().top - 0
                    }, 1000);
                } else {
                    $("html, body").animate({
                        scrollTop: target.offset().top - 0
                    }, 1000);
                }
                return false;
            }
        }
    });
    // navigation active links
    $("a.navigation-state").on("click", function() {
        $("a.navigation-state").removeClass("active");
        $(this).addClass("active");
    });
    // navigation fire
    $(".navigation-fire").on("click", function() {
        if ($(".panel-from-left, .panel-from-right, .panel-overlay-from-left, .panel-overlay-from-right").hasClass("open")) {
            $(".panel-from-left, .panel-from-right, .panel-overlay-from-left, .panel-overlay-from-right").removeClass("open");
        } else {
            $(".panel-from-left, .panel-from-right, .panel-overlay-from-left, .panel-overlay-from-right").addClass("open");
        }
    });
    $("nav.navigation-menu a").on("click", function() {
        $(".panel-from-left, .panel-from-right, .panel-overlay-from-left, .panel-overlay-from-right").removeClass("open");
    });
	
    $(window).on("scroll", function() {
        // 3. animate elements
        if ($(this).scrollTop() > 100) {
            $(".round-menu").addClass("direction");
            $(".to-top-arrow").addClass("show");
            $(".hero-heading").addClass("hero-heading-hide").removeClass("hero-heading-show");
            $(".testimonials-signature-home").addClass("testimonials-signature-home-hide").removeClass("testimonials-signature-home-show");
            $(".scroll-indicator-wrapper").addClass("scroll-indicator-wrapper-position-secondary");
            $(".more-wraper-center-home").addClass("more-wraper-center-home-position-secondary");
        } else {
            $(".round-menu").removeClass("direction");
            $(".to-top-arrow").removeClass("show");
            $(".hero-heading").removeClass("hero-heading-hide").addClass("hero-heading-show");
            $(".testimonials-signature-home").removeClass("testimonials-signature-home-hide").addClass("testimonials-signature-home-show");
            $(".scroll-indicator-wrapper").removeClass("scroll-indicator-wrapper-position-secondary");
            $(".more-wraper-center-home").removeClass("more-wraper-center-home-position-secondary");
        }
    });
	
    // 4. magnificPopup
    $(".popup-photo").magnificPopup({
        type: "image",
        gallery: {
            enabled: false,
            tPrev: "",
            tNext: "",
            tCounter: "%curr% / %total%"
        },
        removalDelay: 100,
        mainClass: "mfp-fade",
        fixedContentPos: false
    });
    $(".popup-photo-gallery").each(function() {
        $(this).magnificPopup({
            delegate: ".popup-photo-gallery-open",
            type: "image",
            gallery: {
                enabled: true
            },
            removalDelay: 100,
            mainClass: "mfp-fade",
            fixedContentPos: false
        });
    });
	
    // 5. owl carousel
    $(".owl-carousel-all").owlCarousel({
        loop: false,
        center: false,
        autoplay: false,
        autoplaySpeed: 1000,
        autoplayTimeout: 5000,
        smartSpeed: 450,
        nav: false,
        nav: true,
        navText: ["<i class='fa ion-chevron-left'></i>", "<i class='fa ion-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1,
                margin: 30
            },
            768: {
                items: 2,
                margin: 30
            },
            980: {
                items: 2,
                margin: 50
            },
            1240: {
                items: 3,
                margin: 50
            }
        }
    });
	
    // 6. clone function
    $.fn.duplicate = function(count, cloneEvents, callback) {
        var stack = [],
            el;
        while (count--) {
            el = this.clone(cloneEvents);
            callback && callback.call(el);
            stack.push(el.get()[0]);
        }
        return this.pushStack(stack);
    };
    $("<div class='vertical-lines-wrapper'></div>").appendTo(".vertical-lines");
    $("<div class='vertical-effect'></div>").duplicate(3).appendTo(".vertical-lines-wrapper");
    $("<div class='vertical-lines-wrapper'></div>").appendTo(".vertical-lines");
    $("<div class='vertical-effect-2'></div>").duplicate(3).appendTo(".vertical-lines-wrapper");
    $("<div class='vertical-lines-wrapper-e'></div>").appendTo(".vertical-lines-e");
    $("<div class='vertical-effect-e'></div>").duplicate(3).appendTo(".vertical-lines-wrapper-e");
    $("<div class='vertical-lines-wrapper-e-2'></div>").appendTo(".vertical-lines-e");
    $("<div class='vertical-effect-2-e'></div>").duplicate(3).appendTo(".vertical-lines-wrapper-e-2");
    
	// 7. facts counter
    $(".facts-counter-number").appear(function() {
        var count = $(this);
        count.countTo({
            from: 0,
            to: count.html(),
            speed: 1200,
            refreshInterval: 60
        });
    });
	
    //
    document.querySelectorAll(".more-wraper-center").forEach(wrapper => {
        const btn = wrapper.querySelector("#submit");
        if (btn) {
            wrapper.addEventListener("click", () => {
                btn.click();
            });
        }
    });
	
    // 8. toggle blog panels
    $(".blog-side-launcher").on("click", function() {
        var divClass = $(this).attr("data-id");
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $("." + divClass).addClass("open");
        } else {
            $(this).addClass("open");
            $("." + divClass).addClass("open");
        }
    });
    $(".blog-side-launch, .blog-side-text").on("click", function() {
        $(".panel-from-left-blog, .panel-overlay-from-right-blog").removeClass("open");
    });
	
    // 9. swiper slider
    var swiper1 = new Swiper(".swiper-container-wrapper .swiper-container.swiper1", {
        preloadImages: false,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        init: true,
        loop: false,
        speed: 1200,
        grabCursor: true,
        mousewheel: false,
        keyboard: true,
        simulateTouch: true,
        parallax: true,
        effect: "slide",
        pagination: false,
        navigation: {
            nextEl: ".slide-next",
            prevEl: ".slide-prev"
        },
        scrollbar: false
    });
	swiper1.autoplay.stop();
    swiper1.on("slideChangeTransitionStart", function() {
        $(".hero-bg").find("video").each(function() {
            this.pause();
        });
    });
    swiper1.on("slideChangeTransitionEnd", function() {
        $(".hero-bg").find("video").each(function() {
            this.play();
        });
    });
    swiper1.on("slideChangeTransitionStart", function() {
        $(".slider-progress-bar").removeClass("slider-active");
    });
    swiper1.on("slideChangeTransitionEnd", function() {
        $(".slider-progress-bar").addClass("slider-active");
    });
    var playButton = $(".swiper-slide-controls-play-pause-wrapper");
    function autoEnd() {
        playButton.removeClass("slider-on-off");
        swiper1.autoplay.stop();
    }
    function autoStart() {
        playButton.addClass("slider-on-off");
        swiper1.autoplay.start();
    }
    playButton.on("click", function() {
        if (playButton.hasClass("slider-on-off")) autoEnd();
        else autoStart();
        return false;
    });
	
    // 10. contact form
    $("form#form").on("submit", function() {
        $("form#form .error").remove();
        var s = !1;
        if ($(".requiredField").each(function() {
                if ("" === jQuery.trim($(this).val())) $(this).prev("label").text(), $(this).parent().append('<span class="error">This field is required</span>'), $(this).addClass(
                    "inputError"), s = !0;
                else if ($(this).hasClass("email")) {
                    var r = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    r.test(jQuery.trim($(this).val())) || ($(this).prev("label").text(), $(this).parent().append('<span class="error">Invalid email address</span>'), $(this).addClass(
                        "inputError"), s = !0);
                }
            }), !s) {
            $("form#form input.submit").fadeOut("normal", function() {
                $(this).parent().append("");
            });
            var r = $(this).serialize();
            $.post($(this).attr("action"), r, function() {
                $("form#form").slideUp("fast", function() {
                    $(this).before('<div class="success">Your email was sent successfully.</div>');
                });
            });
        }
        return !1;
    });
	
	
});