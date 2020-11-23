(function ($) {
    // USE STRICT
    "use strict";

    // Global variables
    var html_body = $('html, body');

    //-------------------------------------------------------
    // Config Library
    //-------------------------------------------------------

    // Config Slick
    var slickClass = $('.js-slick');
    slickClass.each(function () {
        var option = {
            accessibility: true,
            adaptiveheight: false,
            autoplay: false,
            autoplayspeed: 5000,
            arrows: false,
            asnavfor: null,
            appendarrows: $(this),
            appenddots: $(this),
            prevarrow: '<button type="button" class="slick-prev">Previous</button>',
            nextarrow: '<button type="button" class="slick-next">Next</button>',
            centermode: false,
            centerpadding: '50px',
            cssease: 'ease',
            dots: false,
            dotsclass: 'slick-dots',
            draggable: true,
            fade: false,
            speed: 500,
            pauseonhover: false,
            lg: 1, md: this.lg, sm: this.md, xs: this.sm,
            vertical: false,
            loop: true,
            thumb: false

        };

        for (var k in option) {
            if (option.hasOwnProperty(k)) {
                if ($(this).attr('data-slick-' + k) != null) {
                    option[k] = $(this).data('slick-' + k);
                }
            }
        }

        if (option.thumb)
            $(this).slick({
                accessibility: option.accessibility,
                adaptiveHeight: option.adaptiveheight,
                autoplay: option.autoplay,
                autoplaySpeed: option.autoplayspeed,
                arrows: option.arrows,
                asNavFor: option.asnavfor,
                appendArrows: option.appendarrows,
                appendDots: option.appenddots,
                prevArrow: option.prevarrow,
                nextArrow: option.nextarrow,
                centerMode: option.centermode,
                centerPadding: option.centerpadding,
                cssease: option.cssease,
                dots: option.dots,
                dotsClass: option.dotsclass,
                draggable: option.draggable,
                pauseOnHover: option.pauseonhover,
                fade: option.fade,
                vertical: option.vertical,
                slidesToShow: option.lg,
                infinite: option.loop,
                swipeToSlide: true,
                customPaging: function(slick, index) {
                    var portrait = $(slick.$slides[index]).data('thumb');
                    return '<img src=" ' + portrait + ' "/><div class="bg-overlay"></div>';
                },

                responsive: [
                    {
                        breakpoint: 1600,
                        settings: {
                            slidesToShow: option.lg
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: option.md
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: option.md
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: option.sm
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: option.xs
                        }
                    }
                ]
            });
        else
            $(this).slick({
                accessibility: option.accessibility,
                adaptiveHeight: option.adaptiveheight,
                autoplay: option.autoplay,
                autoplaySpeed: option.autoplayspeed,
                arrows: option.arrows,
                asNavFor: option.asnavfor,
                appendArrows: option.appendarrows,
                appendDots: option.appenddots,
                prevArrow: option.prevarrow,
                nextArrow: option.nextarrow,
                centerMode: option.centermode,
                centerPadding: option.centerpadding,
                cssease: option.cssease,
                dots: option.dots,
                dotsClass: option.dotsclass,
                draggable: option.draggable,
                pauseOnHover: option.pauseonhover,
                fade: option.fade,
                vertical: option.vertical,
                slidesToShow: option.lg,
                infinite: option.loop,
                swipeToSlide: true,

                responsive: [
                    {
                        breakpoint: 1600,
                        settings: {
                            slidesToShow: option.lg
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: option.md
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: option.md
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: option.sm
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: option.xs
                        }
                    }
                ]
            });

        $(this).on('init', function() {
            var $firstAnimatingElements = $('div.hero-slide:first-child').find('[data-animation]');
            doAnimations($firstAnimatingElements);
        });
        $(this).on('beforeChange', function(e, slick, currentSlide, nextSlide) {
            var $animatingElements = $(this).find('[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            doAnimations($animatingElements);
        });


        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elements.each(function() {
                var $this = $(this);
                var $animationDelay = $this.data('animation-delay');
                var $animationType = 'animated ' + $this.data('animation');
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay
                });
                $this.addClass($animationType).one(animationEndEvents, function() {
                    $this.removeClass($animationType);
                });
            });
        }
    });


    // Config Couter up
    var counterUp = $(".counterUp");
    if (counterUp) {
        counterUp.counterUp({
            delay: 10,
            time: 1000
        });
    }

    // Progress bar
    var executed = false;
    var waypointSelector = $('.js-waypoint');
    if (waypointSelector) {
        waypointSelector.waypoint(function () {
            if (!executed) {
                executed = true;
                /*progress bar*/
                $('.au-progress .au-progress-bar').progressbar({
                    update: function (current_percentage, $this) {
                        $this.find(".value").html(current_percentage + '%');
                    }
                });
            }
        }, {offset: 'bottom-in-view'});
    }

    // init Isotope
    var grid_isotope = $('.isotope').each(function () {
        $(this).isotope({
            itemSelector: '.isotope-item',
            percentPosition: true,
            animationEngine : 'best-available',
            masonry: {
                columnWidth: '.isotope-item'
            }
        });
    });
    var filter = $('.filter-bar');
    filter.on( 'click', 'li', function() {
        var filterValue = $(this).attr('data-filter');
        grid_isotope.isotope({ filter: filterValue });
    });
    filter.on('click', 'li', function () {
        filter.find('.active').removeClass('active');
        $(this).addClass('active');
    });
    $(window).on('load', function () {
        grid_isotope.isotope();
    });


    //-------------------------------------------------------
    // Theme JS
    //-------------------------------------------------------

    // Header
    var header_pri_fix = $('.header-primary');
    var header_mob_fix = $('.header-mobile, .header.header-push');
    var header_fix = $('.header-fixed');

    $(window).on('load', function () {
        header_pri_fix.after(function () {
            return "<div class='holder-d' style='height:" + $(this).height() + "px;'></div>";
        });
        header_mob_fix.after(function () {
            return "<div class='holder-m' style='height:" + $(this).height() + "px;'></div>";
        });

        $(this).on('resize', function () {
            $('.holder-d').css('height', header_pri_fix.height());
            $('.holder-m').css('height', header_mob_fix.height());
        });
    });

    var header_fix_top = header_fix.offset().top;

    // $(window).on("scroll", function () {
    //     if ($(this).scrollTop() > header_fix_top) {
    //         header_fix.addClass("sticky");
    //     } else {
    //         header_fix.removeClass("sticky");
    //     }
    // });

    // Navbar
    // Navbar vertial and Navbar mobile
    var handler_slidebar = $('.handler-slidebar');
    var sliderbar = $('.header-slidebar');

    function toggleSlideBar() {
        if (sliderbar.hasClass('closed'))
            sliderbar.addClass('opened').removeClass('closed');
        else
            sliderbar.addClass('closed').removeClass('opened');
    }


    handler_slidebar.on('click', function () {
        toggleSlideBar();
    });

    $(window).on('click', function (e) {
        if (!$(e.target).closest(sliderbar).length && !$(event.target).closest(handler_slidebar).length) {
            sliderbar.addClass('closed').removeClass('opened');
        }
    });

    $('.navbar-vertical .has-drop .nav-link').on('click', function (e) {
        $(this).siblings('.drop-menu').slideToggle(200, 'linear');
        $(this).toggleClass('active');
        e.preventDefault();
    });

    // Bind to scroll
    $(window).on('load', function () {
        var topMenu = $('.header-one-page'),
            menuItems = topMenu.find(".nav-link[href^='#']"),
            scrollItems = menuItems.map(function() {
                var item = $($(this).attr("href"));
                if (item.length) { return item; }
            });

        menuItems.on("click", function (e) {
            html_body.animate({scrollTop: $($(this).attr("href")).offset().top - header_fix.outerHeight()}, 800).queue(function () {
                sliderbar.addClass('closed').removeClass('opened');
                $(this).dequeue();
            });
        });

        $(this).on('scroll', function(){
            var fromTop = $(this).scrollTop() + topMenu.outerHeight() + 250;
            var cur = scrollItems.map(function(){
                if ($(this).offset().top < fromTop)
                    return this;
            });
            cur = cur[cur.length-1];
            var id = cur && cur.length ? cur[0].id : "";
            menuItems
                .parent().removeClass("active")
                .end().filter("[href='#"+id+"']").parent().addClass("active");
        });
    });

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();


    // Back To Top
    var offset = 450;
    var duration = 500;
    var upToTop = $("#up-to-top");
    upToTop.hide();
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > offset) {
            upToTop.fadeIn(duration);
        } else {
            upToTop.fadeOut(duration);
        }
    });

    upToTop.on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, duration);
        return false;
    });


    // Load more portfolio item
    $('.po-list').find('.load-item').hide();
    $('.po-btn .load-btn').on('click', function (e) {
        $(this).html("<div class='loader-icon-2'></div>").delay(2000).queue(function (next) {
            next();
            $(this).hide();
            $('.po-list').find(".load-item").fadeToggle(0, 'swing', function () {
                grid_isotope.isotope('layout');
            });

        });
        e.preventDefault();
    });

    // Arrow Blog

    function posArrow() {
        $('.slick-arrow-style-1').each(function () {
            var arrow_top_value = ($(this).find('.box-figure').outerHeight()/2 - 20);
            $(this).find('.slick-arrow').css({
                top: arrow_top_value
            });
        });
    }

    $(window).on('load', function () {
        posArrow();
    });

    $(window).on('resize', function () {
        posArrow();
    });

    // Video player plugin
    $('.js-play-youtube').on('click', function(ev) {
        var videoWrapper = $(this).siblings('.js-video-youtube');
        videoWrapper.children('iframe')[0].src += "rel=0&autoplay=1";
        videoWrapper.css('opacity', '1');
        $(this).fadeOut('fast');
        ev.preventDefault();
    });

    $('.js-set-bg-blog-thumb').each(function(){
        var imagesURLs = $(this).find('.video-photo').attr('src');
        $(this).css('background-image', 'url('+ imagesURLs + ')');
    });

    // Fix slidebar page boxed
    if ($(window).width() > 991 && $('.page-boxed').length !== 0) {
        var left_slidebar = 0;
        var obj_page_boxed_slidebar = $('.page-boxed .header-slidebar-300');
        var top_slidebar = 0;
        var top_slidebar = obj_page_boxed_slidebar.offset().top;
        left_slidebar = $('.page-boxed .page-inner').offset().left;
        $(window).on('resize', function () {
            left_slidebar = $('.page-boxed .page-inner').offset().left;
            if (obj_page_boxed_slidebar.hasClass('fixed')) {
                obj_page_boxed_slidebar.css('left', left_slidebar);
            }
        });
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > top_slidebar) {
                obj_page_boxed_slidebar.addClass('fixed');
                obj_page_boxed_slidebar.css('left', left_slidebar);
            } else {
                obj_page_boxed_slidebar.removeClass('fixed');
                obj_page_boxed_slidebar.css('left', 0);
            }
        });
    }

    // Config Animsition
    $(".animsition").animsition({
        inClass: 'fade-in',
        outClass: 'fade-out',
        inDuration: 500,
        outDuration: 500,
        linkElement: 'a:not([target="_blank"]):not([href^="#"]):not([class^="chosen-single"])',
        loading: true,
        loadingParentElement: 'html',
        loadingClass: 'loader-wrapper',
        loadingInner: '<div class="loader"></div>',
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: [ 'animation-duration', '-webkit-animation-duration'],
        overlay : false,
        overlayClass : 'animsition-overlay-slide',
        overlayParentElement : 'html',
        transition: function(url){ window.location.href = url; }
    });

    $(window).on('load', function () {
        // WOW JS
        function afterReveal (el) {
            el.addEventListener('animationend', function () {
                $(this).css({
                    'animation-name': 'none'
                });
            });
        }
        var wow = new WOW({
            mobile:  false,
            callback: afterReveal
        });
        wow.init();
    });



})(jQuery);
