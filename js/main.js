/**
 * isMobile
 * headerFix
 * responsiveMenu
 * themesflatSearch
 * detectViewport
 * blogLoadMore
 * commingsoon
 * goTop
 * retinaLogos
 * customizable_carousel
 * parallax
 * iziModal
 * bg_particles
 * pagetitleVideo
 * toggleExtramenu
 * removePreloader
 */

(function ($) {
    "use strict";

    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (
                isMobile.Android() ||
                isMobile.BlackBerry() ||
                isMobile.iOS() ||
                isMobile.Opera() ||
                isMobile.Windows()
            );
        },
    };

    var topBarSwiper = function () {
        var $topBarSwipers = $(".swiper-topbar").not(".tf-slider-promo .swiper-topbar");
        if ($topBarSwipers.length) {
            $topBarSwipers.each(function () {
                var $slider = $(this);

                var direction = $slider.data("direction") || "horizontal";
                var auto = $slider.data("auto") === true || $slider.data("auto") === "true";
                var loop = $slider.data("loop") === true || $slider.data("loop") === "true";
                var speed = parseInt($slider.data("speed")) || 1000;

                new Swiper(this, {
                    direction: direction,
                    loop: loop,
                    speed: speed,

                    autoplay: auto
                        ? {
                            delay: 3000,
                            disableOnInteraction: false,
                        }
                        : false,

                    slidesPerView: 1,
                    spaceBetween: 0,
                });
            });
        }
    };


    var selectImages = function () {
        if ($(".setting-curreny-language").length > 0) {
            const selectIMG = $(".setting-curreny-language");
            const selectCRR = $(".setting-curreny-language.type-currencies");
            const selectLGG = $(".setting-curreny-language.type-languages");

            selectIMG.find("option").each((idx, elem) => {
                const selectOption = $(elem);
                const imgURL = selectOption.attr("data-thumbnail");
                if (imgURL) {
                    // The flag is decorative: the option text right next to it already names the country (WCAG 1.1.1 / axe image-redundant-alt).
                    selectOption.attr(
                        "data-content",
                        `<img src="${imgURL}" alt="" /> ${selectOption.text()}`
                    );
                }
            });
            selectIMG.selectpicker();
            selectCRR.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                const currency = $(this).val();
                if (currency) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('currency', currency);
                    window.location.href = url.toString();
                }
            });
            selectLGG.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                const language = $(this).val();
                if (language) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('lang', language);
                    window.location.href = url.toString();
                }
            });

        } else {
            $(".tf-dropdown-select").selectpicker();
        }

    };

    var openSearch = function () {
        if ($(".ajax-search-input-header").length > 0) {
            $(document).on('click', '.ajax-search-input-header', function (e) {
                e.preventDefault();
                var offcanvasEl = document.getElementById('tfsearch');
                var offcanvas = new bootstrap.Offcanvas(offcanvasEl);
                offcanvas.show();
            });
        }
    }

    /* Header search popup (#tfsearch): click outside the white panel closes it.
       .offcanvas-content (z-index 2, full-screen) sits ABOVE .custom-search-backdrop (z-index 1), so a click on the
       dimmed area lands on .offcanvas-content / the backdrop, never on the data-bs-dismiss target. Only close when the
       press AND the release are on that empty area, so dragging a text selection out of the input doesn't close it.
    -------------------------------------------------------------------------*/
    var closeSearchOnBackdrop = function () {
        var pressedOnBackdrop = false;
        var isBackdrop = function (el) {
            return el && (el.classList.contains('offcanvas-content') || el.classList.contains('custom-search-backdrop'));
        };

        $(document).on('mousedown touchstart', '#tfsearch', function (e) {
            pressedOnBackdrop = isBackdrop(e.target);
        });

        $(document).on('click', '#tfsearch', function (e) {
            if (!pressedOnBackdrop || !isBackdrop(e.target)) {
                return;
            }
            pressedOnBackdrop = false;
            var instance = bootstrap.Offcanvas.getInstance(this);
            if (instance) {
                instance.hide();
            }
        });
    };

    var goTop = function () {
        var $goTop = $("#goTop");
        var $borderProgress = $(".border-progress");

        $(window).on("scroll", function () {
            var scrollTop = $(window).scrollTop();
            var docHeight = $(document).height() - $(window).height();
            var scrollPercent = (scrollTop / docHeight) * 100;
            var progressAngle = (scrollPercent / 100) * 360;

            $borderProgress.css("--progress-angle", progressAngle + "deg");

            if (scrollTop > 100) {
                $goTop.addClass("show");
            } else {
                $goTop.removeClass("show");
            }
        });

        $goTop.on("click", function () {
            $("html, body").animate({ scrollTop: 0 }, 0);
        });
    };

    var headerFix = function () {
        if (!$("body").hasClass("header_sticky")) {
            return;
        }

        const $header = $("header").first();

        if (!$header.length) {
            return;
        }

        function getAdminBarHeight() {
            if (window.innerWidth < 600) return 0;
            return $("#wpadminbar").length ? $("#wpadminbar").outerHeight() : 0;
        }

        let navbarHeight = $header.outerHeight();
        let didScroll = false;

        const headerOriginalOffset = $header.offset().top;
        const stickyOffset = 150;

        const $stickyTop = $(
            ".sticky-top,.sticky-xl-top, .sticky-lg-top, .sticky-md-top"
        );

        $(window).on("scroll.tfHeaderFix", function () {
            didScroll = true;
        });

        function handleHeader() {
            const st = $(window).scrollTop();
            const adminBarHeight = getAdminBarHeight();
            navbarHeight = $header.outerHeight();

            const isFixed = st > headerOriginalOffset + stickyOffset;

            $header
                .toggleClass("header-fixed", isFixed)
                .css("top", isFixed ? `${adminBarHeight}px` : `-${navbarHeight}px`);

            $stickyTop.each(function () {
                const $el = $(this);
                const offset = $el.hasClass("no-offset") ? 0 : 15;

                $el.css(
                    "top",
                    isFixed
                        ? `${navbarHeight + adminBarHeight + offset}px`
                        : `${offset}px`
                );
            });
        }

        handleHeader();

        setInterval(function () {
            if (didScroll) {
                handleHeader();
                didScroll = false;
            }
        }, 250);
    }

    function stickyTopHeader() {
	const $window = $(window);
	const $header = $('.tf-header').first();
	const $adminBar = $('#wpadminbar');
	const $stickyElement = $('.sticky-top-header');

	if (!$stickyElement.length) {
		return;
	}

	let animationFrame = null;

	function updateStickyTop() {
		let headerHeight = 0;
		let adminBarHeight = 0;


		if ($header.length && $header.is(':visible')) {
			headerHeight = $header.outerHeight() || 0;
		}


		if ($adminBar.length && $adminBar.is(':visible')) {
			const adminBarPosition = window
				.getComputedStyle($adminBar[0])
				.getPropertyValue('position');

			if (
				adminBarPosition === 'fixed' ||
				adminBarPosition === 'sticky'
			) {
				adminBarHeight = $adminBar.outerHeight() || 0;
			}
		}

		const stickyTop = Math.max(
			0,
			Math.round(headerHeight + adminBarHeight)
		);

		document.documentElement.style.setProperty(
			'--sticky-top-header-offset',
			`${stickyTop}px`
		);
	}

	function requestUpdateStickyTop() {
		if (animationFrame) {
			cancelAnimationFrame(animationFrame);
		}

		animationFrame = requestAnimationFrame(updateStickyTop);
	}

	requestUpdateStickyTop();

	$window.on(
		'load resize orientationchange scroll',
		requestUpdateStickyTop
	);

	if ('ResizeObserver' in window) {
		const resizeObserver = new ResizeObserver(
			requestUpdateStickyTop
		);

		if ($header.length) {
			resizeObserver.observe($header[0]);
		}

		if ($adminBar.length) {
			resizeObserver.observe($adminBar[0]);
		}
	}

	if ('MutationObserver' in window && $header.length) {
		const mutationObserver = new MutationObserver(
			requestUpdateStickyTop
		);

		mutationObserver.observe($header[0], {
			attributes: true,
			attributeFilter: ['class', 'style']
		});
	}
}



    var menu_mobile = function () {
        $('.mobile-off-modal').on('click', function () {
            var offcanvasEl = $('#mobileMenu')[0];
            var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);

            if (!bsOffcanvas) {
                bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
            }

            bsOffcanvas.hide();
        });
    }

    var swiper_slider = function () {
        var swiperInstances = {}
        if ($(".tfwc-slider").length > 0) {
            $(".tfwc-slider").each(function (index) {
                const config = $(this).data("swiper");
                if (swiperInstances[index]) {
                    swiperInstances[index].destroy(true, true);
                }
                swiperInstances[index] = new Swiper(this, config);

            });
        }
    }

    var fix_search = function () {
        jQuery(document).ready(function ($) {
            $('form.wp-block-search').on('submit', function (e) {
                e.preventDefault();
                const keyword = $.trim($(this).find('input[name="s"]').val());
                if (keyword !== '') {
                    const baseUrl = $(this).attr('action');
                    window.location.href = baseUrl + '?s=' + encodeURIComponent(keyword);
                }
            });
        });
    }

    var handleFooter = function () {

        var footerAccordion = function () {

            var args = { duration: 250 };

            $(".widget_nav_menu .widget-title, .footer-heading-mobile, .site-footer .wg-nav-menu .nav-menu-title").on("click", function () {

                // Widget menu
                if ($(this).closest(".widget_nav_menu").length) {

                    var widget = $(this).closest(".widget_nav_menu");

                    widget.toggleClass("open");

                    widget.find('> [class^="menu-"]').stop(true, true)[
                        widget.hasClass("open") ? "slideDown" : "slideUp"
                    ](args);

                }

                // Footer block
                else if ($(this).closest(".footer-col-block").length) {

                    var footer = $(this).closest(".footer-col-block");

                    footer.toggleClass("open");

                    footer.find(".tf-collapse-content").stop(true, true)[
                        footer.hasClass("open") ? "slideDown" : "slideUp"
                    ](args);

                }

                // WG Nav Menu
                else if ($(this).closest(".site-footer .wg-nav-menu").length) {

                    var nav = $(this).closest(".site-footer .wg-nav-menu");

                    nav.toggleClass("open");

                    nav.find("> .list-menu").stop(true, true)[
                        nav.hasClass("open") ? "slideDown" : "slideUp"
                    ](args);

                }

            });

        };

        function handleAccordion() {

            if (matchMedia("(max-width: 767px)").matches) {

                if (!$(".widget_nav_menu .widget-title, .footer-heading-mobile, .site-footer .wg-nav-menu .nav-menu-title").data("accordion-initialized")) {

                    footerAccordion();

                    $(".widget_nav_menu .widget-title, .footer-heading-mobile, .site-footer .wg-nav-menu .nav-menu-title")
                        .data("accordion-initialized", true);
                }

            } else {

                $(".widget_nav_menu .widget-title, .footer-heading-mobile, .site-footer .wg-nav-menu .nav-menu-title").off("click");

                $(".widget_nav_menu")
                    .removeClass("open")
                    .find('> [class^="menu-"]')
                    .removeAttr("style");

                $(".footer-col-block")
                    .removeClass("open")
                    .find(".tf-collapse-content")
                    .removeAttr("style");

                $(".site-footer .wg-nav-menu")
                    .removeClass("open")
                    .find("> .list-menu")
                    .removeAttr("style");

                $(".widget_nav_menu .widget-title, .footer-heading-mobile, .site-footer .wg-nav-menu .nav-menu-title")
                    .data("accordion-initialized", false);
            }

        }

        handleAccordion();

        window.addEventListener("resize", handleAccordion);

    };

    /* Infinite Slide 
    -------------------------------------------------------------------------*/
    var infiniteSlide = function () {
        if ($(".infiniteSlide").length > 0) {
            $(".infiniteSlide").each(function () {
                var $this = $(this);
                var style = $this.data("style") || "left";
                var clone = $this.data("clone") || 2;
                var speed = $this.data("speed") || 50;
                $this.infiniteslide({
                    speed: speed,
                    direction: style,
                    clone: clone,
                });
            });
        }
    };

    var styleSelect = function () {
        if ($(".st-select").length > 0) {
            $('select.st-select').niceSelect();
        }
    }

    var ovinxSwiper = function ($container = null) {
        if (!$container) {
            $container = document;
        }
        $(".ovinx-swiper").each(function (index, element) {
            var $this = $(element);
            if ($this.children('.swiper-wrapper').length === 0) {
                return;
            }
            var preview = $this.data("preview") || 1;
            var tablet = $this.data("tablet") || 1;
            var mobile = $this.data("mobile") || 1;
            var mobileSm = $this.data("mobile-sm") !== undefined ? $this.data("mobile-sm") : mobile;

            // Spacing
            var spacing = $this.data("space");
            var spacingMd = $this.data("space-md");
            var spacingLg = $this.data("space-lg");
            if (spacing !== undefined && spacingMd === undefined && spacingLg === undefined) {
                spacingMd = spacing;
                spacingLg = spacing;
            } else if (spacing === undefined && spacingMd !== undefined && spacingLg === undefined) {
                spacing = 0;
                spacingLg = spacingMd;
            }
            spacing = spacing || 0;
            spacingMd = spacingMd || 0;
            spacingLg = spacingLg || 0;

            var perGroup = $this.data("pagination") || 1;
            var perGroupSm = $this.data("pagination-sm") || 1;
            var perGroupMd = $this.data("pagination-md") || 1;
            var perGroupLg = $this.data("pagination-lg") || 1;
            var gridRows = $this.data("grid") || 1;
            var cursorType = $this.data("cursor") ?? false;
            var loop = $this.data("loop") ?? false;
            var loopMd = $this.data("loop-md") ?? false;
            var effect = $this.data("effect") || "slide";
            var atPlay = $this.data("auto"); // True || False
            var speed = $this.data("speed") || 800;
            var delay = $this.data("delay") || 1000;
            var direction = $this.data("direction") || "horizontal";

            var swiperT = new Swiper($this[0], {
                direction: direction,
                speed: speed,
                slidesPerView: mobileSm,
                spaceBetween: spacing,
                slidesPerGroup: perGroup,
                grabCursor: cursorType,
                loop: loop,
                effect: effect,
                autoplay: atPlay
                    ? {
                        delay: delay,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    }
                    : false,
                grid: {
                    rows: gridRows,
                    fill: "row",
                },
                pagination: {
                    el: [$this.find(".tf-sw-pagination")[0], $this.closest(".tf-pag-swiper").find(".tf-sw-pagination")[0]],
                    clickable: true,
                },
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: [
                        $this.closest(".tf-btn-swiper-item").find(".nav-next-swiper")[0],
                        $this.closest(".container").find(".group-btn-slider .nav-next-swiper")[0],
                    ],
                    prevEl: [
                        $this.closest(".tf-btn-swiper-item").find(".nav-prev-swiper")[0],
                        $this.closest(".container").find(".group-btn-slider .nav-prev-swiper")[0],
                    ],
                },
                breakpoints: {
                    575: {
                        slidesPerView: mobile,
                        spaceBetween: spacing,
                        slidesPerGroup: perGroupSm,
                        grid: {
                            rows: gridRows,
                            fill: "row",
                        },
                    },
                    768: {
                        slidesPerView: tablet,
                        spaceBetween: spacingMd,
                        slidesPerGroup: perGroupMd,
                        grid: {
                            rows: gridRows,
                            fill: "row",
                        },
                    },
                    1200: {
                        slidesPerView: preview,
                        spaceBetween: spacingLg,
                        slidesPerGroup: perGroupLg,
                        grid: {
                            rows: gridRows,
                            fill: "row",
                        },
                    },
                },
            });
            $(".swiper-button")
                .on("mouseenter", function () {
                    var slideIndex = $(this).data("slide");
                    swiperT.slideTo(slideIndex, 500, false);

                    $(".tf-swiper .card_product--V01.style_2").removeClass("active");
                    $(".tf-swiper .card_product--V01.style_2").eq(slideIndex).addClass("active");
                })
                .on("mouseleave", function () {
                    $(".tf-swiper .card_product--V01.style_2").removeClass("active");
                })
                .on("click", function () {
                    var slideIndex = $(this).data("slide");
                    $(".tf-swiper .card_product--V01.style_2").eq(slideIndex).toggleClass("clicked");
                });
        });
    }

    var initPromoBarSwiper = function () {
        var $promoBars = $(".tf-slider-promo");

        if (!$promoBars.length || typeof Swiper === "undefined") {
            return;
        }

        $promoBars.each(function () {
            var $promoBar = $(this);
            var $swiper = $promoBar.find(".tf-swiper");

            if (!$swiper.length || $swiper.hasClass("swiper-initialized")) {
                return;
            }

            var auto = $swiper.data("auto") === true || $swiper.data("auto") === "true";
            var loop = $swiper.data("loop") === true || $swiper.data("loop") === "true";
            var speed = parseInt($swiper.data("speed"), 10) || 800;
            var delay = parseInt($swiper.data("delay"), 10) || 3000;

            new Swiper($swiper[0], {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: loop,
                speed: speed,
                watchOverflow: true,

                autoplay: auto
                    ? {
                          delay: delay,
                          disableOnInteraction: false,
                          pauseOnMouseEnter: true,
                      }
                    : false,

                navigation: {
                    nextEl: $promoBar.find(".nav-next-swiper")[0],
                    prevEl: $promoBar.find(".nav-prev-swiper")[0],
                },
            });
        });
    };

    var customSelectCate = function () {
        $("select#product_cat").each(function () {
            var $this = $(this),
                selectOptions = $(this).children("option").length;
            $this.addClass("hide-select");
            $this.after('<div class="tf-select-custom"></div>');
            var $customSelect = $this.next("div.tf-select-custom");
            $customSelect.text($this.children("option").eq(0).text());
            var $optionlist = $(
                '<ul class="select-options" /><div class="header-select-option"><span>Select Categories</span><span class="close-option"><i class="icon-close"></i></div>'
            ).insertAfter($customSelect);
            for (var i = 0; i < selectOptions; i++) {
                $("<li />", {
                    text: $this.children("option").eq(i).text(),
                    rel: $this.children("option").eq(i).val(),
                }).appendTo($optionlist);
            }
            var $optionlistItems = $optionlist.children("li");
            $customSelect.on('click', function (e) {
                e.stopPropagation();
                $("div.tf-select-custom.active")
                    .not(this)
                    .each(function () {
                        $(this).removeClass("active").next("ul.select-options").hide();
                    });
                $(this).toggleClass("active").next("ul.select-options").slideToggle();
            });
            $optionlistItems.on('click', function (e) {
                e.stopPropagation();
                $customSelect.text($(this).text()).removeClass("active");
                $this.val($(this).attr("rel")).change();
                $optionlist.hide();
            });
            $(document).on('click', function () {
                $customSelect.removeClass("active");
                $optionlist.hide();
            });
            $(".close-option").on('click', function () {
                $customSelect.removeClass("active");
                $optionlist.hide();
            });
        });
    };

    var clickActive = function () {
        function isAllowed($container) {
            return !$container.hasClass("active-1600") || window.innerWidth < 1600;
        }

        let previousWidth = window.innerWidth;

        $(window).on("resize", function () {
            const currentWidth = window.innerWidth;

            const crossedBreakpoint = (previousWidth < 1600 && currentWidth >= 1600) || (previousWidth >= 1600 && currentWidth < 1600);

            if (crossedBreakpoint) {
                $(".main-action-active").each(function () {
                    $(this).find(".btn-active, .active-item").removeClass("active");
                });

                if (previousWidth < 1600 && currentWidth >= 1600) {
                    $(".main-action-active.active-1600").each(function () {
                        const $container = $(this);
                        const $btn = $container.find(".btn-active");
                        const $item = $container.find(".active-item");

                        $btn.addClass("active");
                        $item.addClass("active");
                    });
                }
            }

            previousWidth = currentWidth;
        });

        $(".btn-active").on("click", function (event) {
            const $container = $(this).closest(".main-action-active");

            if (!isAllowed($container)) return;

            event.stopPropagation();

            const $activeItem = $container.find(".active-item");
            const isResponsive = $container.hasClass("active-1600") && window.innerWidth < 1600;

            if (isResponsive) {
                $(".main-action-active").each(function () {
                    if (this !== $container[0]) {
                        $(this).find(".btn-active, .active-item").removeClass("active");
                    }
                });
            } else {
                $(".main-action-active").each(function () {
                    const $other = $(this);
                    if (this !== $container[0] && (!$other.hasClass("active-1600") || window.innerWidth < 1600)) {
                        $other.find(".btn-active, .active-item").removeClass("active");
                    }
                });
            }

            $(this).toggleClass("active");
            $activeItem.toggleClass("active");
        });

        $(document).on("click", function (event) {
            const isMobile = window.innerWidth < 1600;

            $(".main-action-active").each(function () {
                const $container = $(this);
                const is1600 = $container.hasClass("active-1600");

                if ((is1600 && isMobile) || !is1600) {
                    if (!$(event.target).closest($container).length) {
                        $container.find(".btn-active, .active-item").removeClass("active");
                    }
                }
            });
        });

        $(".choose-option-item").on("click", function () {
            const $container = $(this).closest(".main-action-active");
            if (!isAllowed($container)) return;

            $(this).closest(".choose-option-list").find(".select-option").removeClass("select-option");
            $(this).addClass("select-option");
        });
    };

    const ClosePromoBar = function () {
        // if (localStorage.getItem('tf_promo_bar_closed') === '1') {
        //     $('.tf-promo-bar').hide();
        // }

        $(document).on('click', '.promo-bar-close', function (e) {
            e.preventDefault();

            // localStorage.setItem('tf_promo_bar_closed', '1');

            $(this).closest('.tf-promo-bar').slideUp(300);
        });
    };

    /* Preloader (Customizer > General > Preload). Only exists in the HTML when the option is ON.
       It stays until the page has finished loading (window "load") — previously it vanished as soon as this script ran,
       a few milliseconds after first paint, so switching the option ON looked like nothing happened.
       css/styles.css still hides it after 4 s no matter what (animation failsafe), so a slow asset can't trap the visitor. */
    const preloader = function () {
        var $preload = $(".preload");
        if (!$preload.length) {
            return;
        }

        var hide = function () {
            setTimeout(function () {
                $preload.fadeOut(300, function () {
                    $(this).remove();
                });
            }, 100);
        };

        if (document.readyState === "complete") {
            hide();
        } else {
            $(window).one("load", hide);
        }
    };

    function tfSetAdminTop() {
        let top = 0;

        if ($(window).width() >= 600) {
            const $adminBar = $('#wpadminbar');
            top = $adminBar.length ? $adminBar.outerHeight() : 0;
        }

        document.documentElement.style.setProperty('--admin-top', top + 'px');
    }

        document.addEventListener('DOMContentLoaded', function () {
            const header = document.querySelector('.main-header-absolute .tf-header');

            if (!header) return;

            const headerHeight = header.offsetHeight;

            function handleHeaderFixed() {
                if (window.scrollY > headerHeight) {
                header.classList.add('header-fix');
                } else {
                header.classList.remove('header-fix');
                }
            }

            window.addEventListener('scroll', handleHeaderFixed);
            handleHeaderFixed();
        });

    /* My Account guest card (woocommerce/myaccount/form-login.php): Sign In / Create Account / Forgot Password panels.
       [data-auth-show="login|register|forgot"] links swap the visible panel; #register / #forgot in the URL opens it directly.
    -------------------------------------------------------------------------*/
    var accountAuthPanels = function () {
        var show = function ($wrap, name) {
            var $target = $wrap.find('[data-auth-panel="' + name + '"]');
            if (!$target.length) {
                return;
            }
            $wrap.find('[data-auth-panel]').each(function () {
                var on = this === $target.get(0);
                $(this).toggleClass('is-active', on).prop('hidden', !on);
            });
            $target.find('input:visible').not('[type=hidden],[type=checkbox]').first().trigger('focus');
        };

        $(document).on('click', '[data-auth-show]', function (e) {
            e.preventDefault();
            show($(this).closest('[data-account-auth]'), $(this).data('auth-show'));
        });

        var $wrap = $('[data-account-auth]').first();
        var hash = window.location.hash.replace('#', '');
        if ($wrap.length && (hash === 'register' || hash === 'forgot')) {
            show($wrap, hash);
        }
    };
    /* Rate Click (blog comment form — writes the chosen value into #rating)
    -------------------------------------------------------------------------*/
    var rateClick = function () {
        $('.wg-leave-comment .rate-click').each(function () {
            var $stars = $(this).find('.icon'),
                $input = $(this).closest('.wg-leave-comment').find('input[name="rating"]');

            $stars.on('mouseenter', function () {
                $stars.removeClass('hover').slice(0, $stars.index(this) + 1).addClass('hover');
            }).on('mouseleave', function () {
                $stars.removeClass('hover');
            }).on('click', function () {
                var rating = $stars.index(this) + 1;
                $stars.removeClass('active').slice(0, rating).addClass('active');
                $input.val(rating);
            });
        });
    };

    /* QA UX-002 / UX-004 / UX-014 / UX-019 / UX-026: keyboard access for controls the templates render as non-native
       elements (div/li/i with role=button, <a role=tab>), and for dialogs. Mouse behaviour is untouched. */
    var a11yKeyboard = function () {
        // Bootstrap's focus trap / Esc handling need a focusable dialog element; without tabindex the focus stayed on the trigger.
        $('.offcanvas, .modal').each(function () {
            if (!this.hasAttribute('tabindex')) {
                this.setAttribute('tabindex', '-1');
            }
        });

        // Elements that behave like buttons but are div/li/span/i: make them tabbable and name their role.
        $('[role="button"][data-bs-toggle], [role="button"][data-bs-dismiss], .tf-dropdown-sort, .tf-view-layout-switch, .dropdown-menu .select-item').each(function () {
            var tag = this.tagName;
            if (tag === 'A' || tag === 'BUTTON' || tag === 'INPUT') {
                return;
            }
            if (!this.hasAttribute('role')) {
                this.setAttribute('role', $(this).hasClass('select-item') ? 'menuitem' : 'button');
            }
            if (!this.hasAttribute('tabindex') || this.getAttribute('tabindex') === '-1') {
                this.setAttribute('tabindex', '0');
            }
        });

        // Mobile menu trigger: expose its state (the panel itself is labelled in menu-mobile.php).
        var $trigger = $('a[href="#mobileMenu"]');
        $trigger.attr({ 'aria-controls': 'mobileMenu', 'aria-expanded': 'false' });
        $('#mobileMenu').on('shown.bs.offcanvas', function () {
            $trigger.attr('aria-expanded', 'true');
        }).on('hidden.bs.offcanvas', function () {
            $trigger.attr('aria-expanded', 'false');
        });

        // Enter / Space on the pseudo-buttons above; Space on links that act as buttons/tabs (Enter already works natively).
        $(document).on('keydown', function (e) {
            if (e.key !== 'Enter' && e.key !== ' ') {
                return;
            }
            var t = e.target;
            if (!t || t.isContentEditable || /^(INPUT|TEXTAREA|SELECT|BUTTON|SUMMARY)$/.test(t.tagName) || $(t).closest('.nice-select').length) {
                return;
            }
            var $t = $(t);
            var isLink = t.tagName === 'A' && t.hasAttribute('href');

            if (!isLink && $t.is('[role="button"], [role="menuitem"], .tf-view-layout-switch, .tf-dropdown-sort, .select-item')) {
                e.preventDefault();
                t.click();
            } else if (isLink && e.key === ' ' && $t.is('[role="tab"], [role="button"], [data-bs-toggle]')) {
                e.preventDefault();
                t.click();
            }
        });

        mainMenuKeyboard();
    };

    // Desktop main menu. The sub-menus open from CSS (:hover / :focus-visible) so they had no way to be closed from the keyboard
    // (WCAG 2.1.2 No Keyboard Trap, 1.4.13 Dismissible, 4.1.2 State): Esc closes the open level and returns focus to its parent,
    // ArrowDown opens it again, and the parent link exposes aria-haspopup / aria-expanded. `.is-dismissed` is what hides it (CSS).
    var mainMenuKeyboard = function () {
        var $nav = $('#mainnav');
        if (!$nav.length) {
            return;
        }
        var $tops = $nav.find('.box-nav-menu > li').filter(function () {
            return $(this).children('.sub-menu').length > 0;
        });
        if (!$tops.length) {
            return;
        }
        $tops.children('.item-link').attr({ 'aria-haspopup': 'true', 'aria-expanded': 'false' });

        var isOpen = function ($panel) {
            return $panel.length > 0 && $panel.css('visibility') === 'visible' && parseFloat($panel.css('opacity')) > 0;
        };
        var syncTimer;
        // The panels fade for 300ms (CSS), so read their state after the transition, debounced.
        var syncExpanded = function () {
            clearTimeout(syncTimer);
            syncTimer = setTimeout(function () {
                $tops.each(function () {
                    $(this).children('.item-link').attr('aria-expanded', isOpen($(this).children('.sub-menu')) ? 'true' : 'false');
                });
            }, 350);
        };

        $nav.on('keydown', function (e) {
            var t = e.target;
            var $t = $(t);
            var $top = $t.closest('.box-nav-menu > li');
            if (!$top.length || !$top.children('.sub-menu').length) {
                return;
            }

            if (e.key === 'Escape' || e.key === 'Esc') {
                // Deepest level first: Esc inside a flyout (.sub-menu-lv2) closes only that flyout.
                var $lv2 = $t.closest('.has-menu-lv2');
                if ($lv2.length && !$lv2.hasClass('is-dismissed') && isOpen($lv2.children('.sub-menu-lv2'))) {
                    $lv2.addClass('is-dismissed');
                    $lv2.children('.sub-menu_link').trigger('focus');
                } else if (isOpen($top.children('.sub-menu'))) {
                    $top.addClass('is-dismissed');
                    $top.children('.item-link').trigger('focus');
                } else {
                    return;
                }
                e.preventDefault();
                e.stopPropagation();
                syncExpanded();
                return;
            }

            if ((e.key === 'ArrowDown' || e.key === 'Down') && $t.is($top.children('.item-link'))) {
                e.preventDefault();
                $top.removeClass('is-dismissed');
                setTimeout(function () {
                    $top.children('.sub-menu').find('a[href]').first().trigger('focus');
                }, 30);
                syncExpanded();
            }
        });

        // Re-arm the menu once the pointer / focus has left it, so the next hover or Tab opens it normally again.
        $tops.on('mouseleave', function () {
            var $li = $(this);
            if (!$li[0].contains(document.activeElement)) {
                $li.removeClass('is-dismissed').find('.is-dismissed').removeClass('is-dismissed');
            }
        });
        $tops.on('focusout', function (e) {
            var next = e.relatedTarget;
            var li = this;
            if (next && !li.contains(next)) {
                $(li).removeClass('is-dismissed').find('.is-dismissed').removeClass('is-dismissed');
            }
        });
        $nav.on('focusin focusout mouseover mouseout', syncExpanded);
        $nav.find('.has-menu-lv2').on('mouseleave', function () {
            if (!this.contains(document.activeElement)) {
                $(this).removeClass('is-dismissed');
            }
        });
    };

    // Dom Ready
    $(function () {
        rateClick();
        accountAuthPanels();
        closeSearchOnBackdrop();
        topBarSwiper();
        goTop();
        headerFix();
        menu_mobile();
        a11yKeyboard();
        stickyTopHeader();
        styleSelect();
        swiper_slider();
        fix_search();
        ovinxSwiper();
        openSearch();
        selectImages();
        infiniteSlide();
        handleFooter();
        customSelectCate();
        clickActive();
        initPromoBarSwiper();
        tfSetAdminTop();
        ClosePromoBar();
        preloader();
    });
    $(window).on('resize', function () {
        tfSetAdminTop();
    });

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/amerce_category_marquee.default', infiniteSlide );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/amerce_partner.default', infiniteSlide );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/amerce_text_marquee.default', infiniteSlide );
    });

})(jQuery);
