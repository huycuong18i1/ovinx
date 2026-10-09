/**
 * isMobile
 * headerFixed
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

  const tfwcTranslate = function (key, fallback = '') {
  return tfwc_woo_params?.trans_text?.[key] || fallback;
};

const tfwcFormatTranslate = function (key, fallback, ...values) {
  let text = tfwcTranslate(key, fallback);

  values.forEach(function (value) {
    text = text.replace('%s', value);
  });

  // The strings are PHP sprintf() formats ("%s%% Off"): once the %s is filled, "%%" must become a single "%".
  return text.replace(/%%/g, '%');
};

  // QA P3-03: non-blocking replacement for alert() (jquery.toast is always enqueued as a dependency of this script).
  window.tfwcNotify = window.tfwcNotify || function (message, icon) {
    if ($.toast) {
      $.toast({ text: message, icon: icon || 'warning', position: 'top-center', showHideTransition: 'slide', hideAfter: 4000 });
    } else {
      console.warn(message);
    }
  };

  // QA P5-02: a fast double click on a card's ajax add-to-cart link queued two requests (cart +2). WooCommerce marks the
  // link `.loading` while its request runs but its own handler never checks for it, so swallow further clicks in the
  // capture phase (before WooCommerce's delegated handler) until the request has finished (or 10s, as a safety net).
  document.addEventListener('click', function (e) {
    var link = e.target && e.target.closest ? e.target.closest('.ajax_add_to_cart') : null;
    if (!link) {
      return;
    }
    var busy = link.classList.contains('loading') || link.hasAttribute('disabled');
    var started = parseInt(link.getAttribute('data-ovinx-click-ts') || '0', 10);
    if (busy && Date.now() - started < 10000) {
      e.preventDefault();
      e.stopImmediatePropagation();
      return;
    }
    link.setAttribute('data-ovinx-click-ts', String(Date.now()));
  }, true);

  var tfInitialized = false;

  var swatchColor = function () {

    if ($(".card-product").length > 0) {

      if (tfInitialized) {
        $(".color-swatch.active").trigger("mouseover");
        return;
      }

      $(document).on("click mouseover", ".card-product .color-swatch", function () {

        var swatchColor = $(this).find("img").data("src");
        var imgProduct = $(this).closest(".card-product").find(".img-product");

        var isLoaded = imgProduct.hasClass("lazyloaded") || imgProduct.attr("src") === imgProduct.attr("data-src");

        if (swatchColor && imgProduct.length > 0) {

          if (isLoaded) {
            imgProduct.attr("src", swatchColor);
          } else {
            imgProduct.attr("data-src", swatchColor);
          }
        }
        $(this)
          .closest(".card-product")
          .find(".color-swatch.active")
          .removeClass("active");

        $(this).addClass("active");

      });

      $(document).on("click mouseover", ".wcboost-variation-swatches--color .color-swatch", function () {

        var swatchColor = $(this).find("img").data("src");
        var imgProduct = $(this).closest(".card-product").find(".img-product");
        if (swatchColor && imgProduct.length > 0) {
          imgProduct.attr("src", swatchColor);
        }
        $(this)
          .closest(".card-product")
          .find(".color-swatch.active")
          .removeClass("active");

        $(this).addClass("active");
      });

      $(document).on("click mouseover", ".wcboost-variation-swatches--image .color-swatch", function () {
        var swatchColor = $(this).find("img").data("src");
        var imgProduct = $(this).closest(".card-product").find(".img-product");
        if (swatchColor && imgProduct.length > 0) {
          imgProduct.attr("src", swatchColor);
        }
        $(this)
          .closest(".card-product")
          .find(".color-swatch.active")
          .removeClass("active");

        $(this).addClass("active");
      });

      $(".color-swatch.active").trigger("mouseover");

    }

    tfInitialized = true;

  };

  var compare = function () {
    if (typeof wcboost_products_compare_params == 'undefined') {
      return;
    }

    $(document.body).on("added_to_compare", function (event, $button) {

      return;

      switch (wcboost_products_compare_params?.exists_item_behavior) {
        case 'view':
          $button.find('.tooltip').text(wcboost_products_compare_params.i18n_button_view);
          break;

        case 'remove':
          $button.find('.tooltip').text(wcboost_products_compare_params.i18n_button_remove);
          break;

        case 'popup':
          $button.find('.tooltip').text(wcboost_products_compare_params.i18n_button_view);
          break;
      }

    });

    $(document.body).on("removed_from_compare", function (event, $button) {
      return;
      $button.find('.tooltip').text(wcboost_products_compare_params.i18n_button_add);
    });

    $(document.body).on("added_to_compare removed_to_compare", function (event, $button, frgments, count = 0) {

      if (count > 0) {
        if (!$('#compare').hasClass('show')) {
          $('#compare').load(location.href + ' #compare .canvas-wrapper', function () {

            const offcanvasSearch = bootstrap.Offcanvas.getOrCreateInstance($(".offcanvas-search").get(0));
            offcanvasSearch.hide();

            var offcanvas = bootstrap.Offcanvas.getOrCreateInstance($('#compare').get(0));
            offcanvas.show();
          });
        }
      }

      if ($(".wcboost-products-compare").length) {
        $('.wcboost-products-compare .tf-compare-table').load(location.href + ' .wcboost-products-compare .tf-compare-table .tf-compare-row');
        return;
      }

    });

    $('.canvas-compare').on('click', '.tf-remove-compare', function (e) {
      e.preventDefault();
      let removeUrl = $(this).data('remove-url'),
        item = $(this).closest('.tf-compare-item');
      if (removeUrl) {
        removeUrl = new URLSearchParams(removeUrl);
        var data = {
          item_key: removeUrl.get("remove_compare_item"),
          _wpnonce: removeUrl.get("_wpnonce")
        };
        if (!data.item_key) {
          return
        }

        $.ajax({
          url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "remove_compare_item"),
          type: 'POST',
          data: data,
          beforeSend: function () {
            item.addClass('loading-content');
          },
          success: function (response) {
            if (response.error) {
            } else {
              if (response?.success) {

                item.remove();

                $(document.body).trigger("wcboost_compare_item_removed", [response.data]);

                let compareList = $('.tf-compare-list');
                if (compareList.find('.tf-compare-item').length === 0) {
                  compareList.html(
  '<p class="no-compare-message">' +
  tfwcTranslate(
    'no_compare_products',
    'No products added in the compare table.'
  ) +
  '</p>'
);
                  $('.canvas-compare .count-item-compare').text('');
                } else {
                  $('.canvas-compare .count-item-compare').text(`(${compareList.find('.tf-compare-item').length})`);
                }
              }
            }
          },
          complete: function () {
          }
        });
      }
    });

    $('.canvas-compare').on('click', '.tf-clear-compare', function (e) {
      e.preventDefault();
      let clearUrl = $(this).data('clear-url'),
        list_items = $('.tf-compare-item', $(this).closest('.canvas-compare'));
      if (clearUrl) {
        $.ajax({
          url: clearUrl,
          type: 'POST',
          data: {
            _wp_http_referer: wcboost_products_compare_params.page_url,
            time: (new Date).getTime()
          },
          dataType: "json",
          success: function (response) {
            if (response.error) {
            } else {

            }
          },
          complete: function () {
            list_items.remove();
            $(document.body).trigger("products_compare_list_emptied");
            $(document.body).trigger("products_compare_fragments_refresh", [true]);
            $('.canvas-compare').modal('hide');
          }
        });
      }
    });
  };

  var wishlist = function () {

    $(document.body).on('added_to_wishlist removed_from_wishlist', function (event, $button, fragments) {

      let $originButton = $button;

      // QA P5-09: WCBoost keeps the "Add “X” to the wishlist" aria-label after the click; keep it in sync with the state.
      if ($originButton && $originButton.length) {
        let name = $originButton.data('ovinxWishlistName');
        if (name === undefined) {
          const match = ($originButton.attr('aria-label') || '').match(/[“"](.+)[”"]/);
          name = match ? match[1] : '';
          $originButton.data('ovinxWishlistName', name);
        }
        const isAdded = $originButton.hasClass('added');
        // Card buttons carry the two labels as data attributes; the single-page link (extra-links row) has its visible text instead.
        const base = (isAdded ? $originButton.data('tooltip_added') : $originButton.data('tooltip')) ||
          $.trim($originButton.find('.wcboost-wishlist-button__text').text());
        if (base) {
          $originButton.attr('aria-label', name ? base + ' - ' + name : base);
        }
      }

      $originButton.trigger('mouseenter');

      return;

      if ($originButton.hasClass('wcboost-wishlist-single-button')) {
        let productID = $originButton.data('product_id');
        $button = $(`a.wcboost-wishlist-button[data-product_id="${productID}"]:not(.wcboost-wishlist-single-button)`)
      }

      let tooltip = $button.find(".tooltip");
      var tooltip_added = $button.data("tooltip_added");
      var tooltip_default = $button.data("tooltip");

      if ($originButton.hasClass("added")) {
        tooltip.text(tooltip_added);
      } else {
        tooltip.text(tooltip_default);
      }

      // $(document.body).trigger('ovinx.set_tooltip', tooltip.first().text());
      $originButton.trigger('mouseenter');

    });

    var refreshWishlist = (url = null) => {

      if (!url) {
        url = window.location.href;
      }

      const $container = $('.wcboost-wishlist');

      if ($container.length === 0) {
        return;
      }

      $container.addClass('loading-wishlist');
      scrollToElementWithOffset($('.page-title'), ($('.tf-header:visible').height() || 0) + ($('#wpadminbar:visible').height() || 32));

      let $tempDiv = $('<div style="display: none;"></div>');

      // $tempDiv.load(url + ' .wcboost-wishlist .wrapper-wishlist, .wcboost-wishlist .ovinx-shop-pagination, .wcboost-wishlist .wishlist-empty', function () {

      //   if ($(".wrapper-wishlist", $tempDiv).length) {
      //     $(".wishlist-empty", $container).children().remove();
      //     if ($(".wrapper-wishlist", $container).length) {
      //       $(".wrapper-wishlist", $container).html($(".wrapper-wishlist", $tempDiv).html());
      //     } else {
      //       $container.prepend($(".wrapper-wishlist", $tempDiv).clone());
      //     }
      //     ovinxSaleMarquee();
      //     countDown();
      //     swatchColor();
      //   }

      //   if ($(".ovinx-shop-pagination", $tempDiv).length) {
      //     if ($(".ovinx-shop-pagination", $container).length) {
      //       $(".ovinx-shop-pagination", $container).html($(".ovinx-shop-pagination", $tempDiv).html());
      //     } else {
      //       $container.append($(".ovinx-shop-pagination", $tempDiv).clone());
      //     }
      //   }

      //   if ($(".wishlist-empty", $tempDiv).length) {
      //     $(".wrapper-wishlist", $container).children().remove();
      //     $(".ovinx-shop-pagination", $container).children().remove();
      //     if ($(".wishlist-empty", $container).length) {
      //       $(".wishlist-empty", $container).html($(".wishlist-empty", $tempDiv).html());
      //     } else {
      //       $container.prepend($(".wishlist-empty", $tempDiv).clone());
      //     }
      //   }

      //   $tempDiv.remove();

      //   $container.removeClass('loading-wishlist');

      // });

      $tempDiv.load(url + ' .wcboost-wishlist', function () {

        $container.replaceWith($tempDiv.clone().html());

        ovinxSaleMarquee();
        countDown();
        swatchColor();
        ovinxSwiper($('.wcboost-wishlist'));

        // WCAG 2.4.3 / 4.1.3: the list was swapped out, so keyboard focus was lost and nothing told screen-reader users what changed.
        var $next = $('.wcboost-wishlist .wishlist-clear-all').first();
        if (!$next.length) {
          $next = $('.wcboost-wishlist .emp_title').first().attr('tabindex', '-1');
        }
        $next.trigger('focus');
        var status = $('.wcboost-wishlist .wishlist-toolbar').data('status') || $.trim($('.wcboost-wishlist .emp_title').text());
        var $live = $('#ovinx-sr-status');
        if (status && $live.length) {
          $live.text('');
          setTimeout(function () { $live.text(status); }, 100);
        }

        $tempDiv.remove();

        $container.removeClass('loading-wishlist');

      });

    };

    $(document.body).on('added_to_wishlist removed_from_wishlist', function () {
      refreshWishlist();
    });

    $(document.body).on('click', '.ovinx-wishlist-pagination a.page-numbers:not(.current)', function (e) {
      e.preventDefault();
      var href = $(this).attr('href');
      if (href) {
        refreshWishlist(href);
      } else {
        refreshWishlist();
      }
    });

    return;

    $(document.body).on('click', '.icon-wishlist-header', function (e) {
      return;
      e.preventDefault();

      const $container = $('.wcboost-wishlist');

      if ($container.length === 0) {

        let $wishlistCanvas = $('#wishList');

        if ($wishlistCanvas.length === 0) {
          return;
        }

        e.stopPropagation();


        var offcanvas = new bootstrap.Offcanvas($wishlistCanvas.get(0));
        $('.modal-compare')?.modal('hide');

        offcanvas.show();

        return;
      }
    });

    $(document.body).on('added_to_wishlist removed_from_wishlist', function () {
      return;

      const $container = $('.wcboost-wishlist');

      if ($container.length === 0) {

        let $wishlistCanvas = $('#wishList');

        if ($wishlistCanvas.length === 0) {
          return;
        }

        var offcanvas = new bootstrap.Offcanvas($wishlistCanvas.get(0));
        $('.modal-compare')?.modal('hide');
        // $('.modal-quick-view')?.modal('hide');
        // $('.modal-quick-add')?.modal('hide');

        offcanvas.show();

        return;
      }

      $container.addClass('loading-wishlist');

      let $tempDiv = $('<div style="display: none;"></div>');

      $tempDiv.load(window.location.href + ' .wcboost-wishlist .wrapper-wishlist, .wcboost-wishlist .wishlist-empty', function () {

        if ($(".wrapper-wishlist", $tempDiv).length) {
          $(".wishlist-empty", $container).children().remove();
          if ($(".wrapper-wishlist", $container).length) {
            $(".wrapper-wishlist", $container).html($(".wrapper-wishlist", $tempDiv).html());
          } else {
            $container.prepend($(".wrapper-wishlist", $tempDiv).clone());
          }
        }

        if ($(".wishlist-empty", $tempDiv).length) {
          $(".wrapper-wishlist", $container).children().remove();
          if ($(".wishlist-empty", $container).length) {
            $(".wishlist-empty", $container).html($(".wishlist-empty", $tempDiv).html());
          } else {
            $container.prepend($(".wishlist-empty", $tempDiv).clone());
          }
        }

        $tempDiv.remove();

        $container.removeClass('loading-wishlist');

      });

    });

    $(document.body).on('wishlist_item_removed', function (e, data) {
      return;
      $(`.wcboost-wishlist-button[data-product_id="${data?.product_id || 0}"] .tooltip`).text(wcboost_wishlist_params?.i18n_add_to_wishlist || 'Add to wishlist');

    });

    $(document.body).on('wishlist_item_added', function (e, data) {

      return;

      if (wcboost_wishlist_params?.exists_item_behavior == 'remove') {
        $(`.wcboost-wishlist-button[data-product_id="${data?.product_id || 0}"] .tooltip`).text(wcboost_wishlist_params?.i18n_remove_from_wishlist || 'Remove from wishlist');

      }

      if (wcboost_wishlist_params?.exists_item_behavior == 'view_wishlist') {
        $(`.wcboost-wishlist-button[data-product_id="${data?.product_id || 0}"] .tooltip`).text(wcboost_wishlist_params?.i18n_view_wishlist || 'View wishlist');
      }

      const lengthItems = Object.keys(data?.wishlist_items).length;

      if ($('.wishlist-btn-fragment .count-box').text() == 0 && lengthItems) {
        $('.wishlist-btn-fragment .count-box').text(lengthItems);
      }
    });

    // wishlist_updated

  };

  var countDown = function () {
    var countDown = document.getElementsByClassName("js-countdown");
    if (countDown.length > 0) {
      for (var i = 0; i < countDown.length; i++) {
        (function (i) {
          if (!countDown[i].classList.contains('countdown-initialized')) {
            CountDown(countDown[i]);
            countDown[i].classList.add('countdown-initialized');
          }
        })(i);
      }
    }
  }

  var add_to_cart = function () {
    $(document).on('added_to_cart', function () {
      tf_swiper_slider();
      setTimeout(function () {
        // var myModal = new bootstrap.Modal(document.getElementById('shoppingCart'));
        // myModal.show();
        // $('.modal-compare')?.modal('hide');
        $('.modal-quick-view')?.modal('hide');
        $('.modal-quick-add')?.modal('hide');

        const offcanvasqv = bootstrap.Offcanvas.getOrCreateInstance($("#quickView").get(0));
        const offcanvascompare = bootstrap.Offcanvas.getOrCreateInstance($("#compare").get(0));
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('shoppingCart'));

        offcanvasqv.hide();
        offcanvascompare.hide();

        offcanvas.show();
      }, 200);
    });
  }

  var remove_wishlist = function () {
    $(document).on('wishlist_fragments_refreshed', function () {
      countDown();
      tf_swiper_slider();
    });
  }

  var quantity_input = function () {
    var ajax_in_progress = false;
    var debounce_timeout;
    var last_value = null;

    $(document).on('click', '.qty_button', function (e) {
      e.preventDefault();

      var $this = $(this),
        $input_qty = $this.siblings('.qty'),
        min = parseFloat($input_qty.attr('min')),
        max = parseFloat($input_qty.attr('max')),
        step = parseFloat($input_qty.attr('step')),
        current = parseFloat($input_qty.val());

      if ($this.hasClass('plus') && max !== 'NaN' && max <= $input_qty.val()) {
        return;
      }

      if ($this.hasClass('minus') && min !== 'NaN' && min >= $input_qty.val()) {
        return;
      }

      max = !isNaN(max) ? max : current + 1;

      if ($this.hasClass('minus') && current > min) {
        $input_qty.val(current - step);
      }
      if ($this.hasClass('plus') && current < max) {
        $input_qty.val(current + step);
      }

      $input_qty.trigger('change');
    });

    $(document).on('change', '.mini-cart-item-quantity .qty', function (e) {

      var $this = $(this);
      var input_qty = parseFloat($(this).val());

      if (ajax_in_progress) return;

      last_value = input_qty;

      var max = parseFloat($(this).attr('max'));

      if (max !== 'NaN' && max < input_qty) {
        input_qty = max;
        $(this).val(max);
      }
      var that = this;

      clearTimeout(debounce_timeout);

      debounce_timeout = setTimeout(function () {
        var cart_item_key = $(that).closest('.tf-mini-cart-item').data('cart_item_key');
        var data = {
          action: 'tfwc_update_cart_item',
          // action: 'tfwc_store_update_item',
          quantity: input_qty,
          cart_item_key: cart_item_key,
          nonce: tfwc_woo_params.nonce,
        };

        $(that).closest('.tf-mini-cart-item').addClass('loading-content');

        $.ajax({
          // url: tfwc_woo_params?.has_store_api ? tfwc_woo_params?.store_update_item_endpoint || tfwc_woo_params.ajax_url : tfwc_woo_params.ajax_url,
          url: tfwc_woo_params.ajax_url,
          data: data,
          dataType: 'json',
          method: 'POST',
          success: function (response) {
            ajax_in_progress = false;

            $(that).closest('.tf-mini-cart-item').removeClass('loading-content');

            if (!response) {
              return;
            }

            if (response?.data?.message) {
              $.toast({
                text: response?.data?.message,
                showHideTransition: 'fade',
                icon: 'info',
                position: {
                  top: 50,
                  right: 20,
                },
                "type": "info",
                "closeBtn": true,
                "dismissible": true,
                "append": true,
                "shadow": true,
                "duration": null,
                "maxWidth": "400",
                "animateOut": 100,
                "animateIn": 100,
                "actions": [],
                "bgColor": "#21503f"
              });
              $(this).val(max);
              return
            }

            if (response.fragments) {
              $.each(response.fragments, function (fragment, content) {
                $(fragment).replaceWith(content);
              });
            }
            $(document.body).trigger('wc_fragments_refreshed');
            tf_swiper_slider();
          },
          error: function (e) {
            ajax_in_progress = false;
            $.toast(
              {
                text: e?.getMessage() || '',
                showHideTransition: 'fade',
                icon: 'info',
                position: {
                  top: 50,
                  right: 20,
                },
                "type": "info",
                "closeBtn": true,
                "dismissible": true,
                "append": true,
                "shadow": true,
                "duration": null,
                "maxWidth": "400",
                "animateOut": 100,
                "animateIn": 100,
                "actions": [],
                "bgColor": "#21503f"
              }
            );
            $(that).closest('.tf-mini-cart-item').removeClass('loading');
          },
          complete: function () {
            ajax_in_progress = false;
          }
        });
      }, 500);
    });
  };

  /**
   * List-style card's `.card-product_button` panel (Quantity +/- next to the desktop Quick Add
   * button) — ground truth's own JS (ovinx-html assets/js/main.js `btnQuantity()`) only wires this
   * up for its static demo markup; nothing in this theme's JS handled `.minus-btn`/`.plus-btn`
   * anywhere before, so the buttons were dead. Mirrors ground truth's min-1/no-max behavior, and
   * additionally keeps the adjacent `.tf_add_to_cart` link's `data-quantity` attribute in sync so
   * the real AJAX add-to-cart request (see btnAddToCart.js core) sends the selected quantity.
   */
  var listCardButtonQuantity = function () {
    $(document).on('click', '.card-product_button .minus-btn', function (e) {
      e.preventDefault();

      var $wrap = $(this).closest('.wg-quantity');
      var $input = $wrap.find('.quantity-product');
      var value = parseInt($input.val(), 10) || 1;

      if (value > 1) {
        value -= 1;
      }

      $input.val(value);
      $wrap.siblings('.tf_add_to_cart').attr('data-quantity', value);
    });

    $(document).on('click', '.card-product_button .plus-btn', function (e) {
      e.preventDefault();

      var $wrap = $(this).closest('.wg-quantity');
      var $input = $wrap.find('.quantity-product');
      var value = parseInt($input.val(), 10) || 1;

      value += 1;

      $input.val(value);
      $wrap.siblings('.tf_add_to_cart').attr('data-quantity', value);
    });

    $(document).on('change', '.card-product_button .quantity-product', function () {
      var value = parseInt($(this).val(), 10) || 1;

      if (value < 1) {
        value = 1;
      }

      $(this).val(value);
      $(this).closest('.wg-quantity').siblings('.tf_add_to_cart').attr('data-quantity', value);
    });
  };

  var quickview_product = function () {
    $(document).on("click", ".tf_quickview_btn", function (e) {
      e.preventDefault();

      var productID = $(this).data("product_id");

      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: "POST",
        data: {
          action: "load_quickview_product",
          product_id: productID,
          nonce: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          $(".canvas-quickview").html("");
          $(".canvas-quickview").addClass("loading-content");
        },
        success: function (response) {
          if (response.success) {
            $(".canvas-quickview").html(response.data.content);
          } else {
            $(".canvas-quickview").html(
  '<p>' +
  tfwcTranslate('quick_view_error', 'Error Quick View') +
  '</p>'
);
          }
          // swiper_slider();
          countDown();
          swatchColor();
          // compare();
        },
        complete: function () {
          $(".canvas-quickview").removeClass("loading-content");
        }
      });
    });
  }

  var quickShop = function () {
    let $modalQuickAdd = $('.tf-quick-add-modal'),
      $modalQuickView = $('.canvas-quickview');

    var addToCartWithPriceText = function ($container = null) {

      if (!$container) {
        $container = document;
      }

      let $buttonText = $('.tf-single-product .variations_form .single_add_to_cart_button .single-add-to-cart-text'),
        buttonTextOrigin = $buttonText.text();

      let $badges = $('.tf-single-product .on-sale-wrap .on-sale-item'),
        $badgesTextOrigin = $badges.text();

      $container.on('change', '.tf-main-product form.cart:not(.tf-external-form, .tf-grouped-form) input.qty', function () {
        let $input = $(this);
        setTimeout(() => {
          let quantity = $input.val(),
            btnAddToCart = $('form.cart:not(.tf-external-form,.tf-grouped-form) button.single_add_to_cart_button', $input.closest('.tf-main-product')),
            discount = btnAddToCart.find('.dynamic-price').data('discount'),
            price = btnAddToCart.find('.dynamic-price').data('price');

          if (price) {
            let total = parseInt(quantity) * parseFloat(price);
            if (discount) {
              total = total - (total * discount / 100);
            }
            btnAddToCart.find('.dynamic-price-se').removeClass('d-none');
            btnAddToCart.find('.dynamic-price').html(numberFormat(total));
          }
        }, 1);
      });

      $container
        .on('found_variation', '.tf-main-product .variations_form', function (event, data) {
          $(event.target).find('.dynamic-price').data('price', data.display_price);
          if (data?.add_to_cart_text) {
            $buttonText.text(data.add_to_cart_text);
            if (data.add_to_cart_text.toLowerCase() === "add to cart") {
              $badges.text(
  tfwcTranslate('in_stock', 'In stock')
);
            } else {
              $badges.text(data.add_to_cart_text);
            }
          }
          $('.tf-main-product form.cart:not(.tf-external-form,.tf-grouped-form) input.qty').change();
        })
        .on('reset_data', '.tf-main-product .variations_form', function (event) {
          $(event.target).find('.dynamic-price').data('discount', 0);
          $(event.target).find('.dynamic-price').data('price', 0);
          $(event.target).find('.dynamic-price').html('');
          $(event.target).find('.dynamic-price-se').addClass('d-none');
          $buttonText.text(buttonTextOrigin);
          $badges.text($badgesTextOrigin);
        });

      $('.tf-main-product form.cart:not(.tf-external-form,.tf-grouped-form) input.qty').change();
    };

    // Quick View
    $(document).on('ajaxComplete.quick_view', function (event, xhr, settings) {
      if (settings.data && settings.data.indexOf('action=load_quickview_product') !== -1) {
        let $container = $('.tf-product-info-wrap', $modalQuickView),
          $variationForm = $('.variations_form', $modalQuickView),
          $image = $('.item img', $modalQuickView).first(),
          $price = $('.tf-price .price-wrap', $modalQuickView),
          $buttonText = $('.single_add_to_cart_button .single-add-to-cart-text', $modalQuickView),
          imageOrigin = $image.attr('src') ? $image.attr('src') : $image.attr('data-src'),
          priceHTMlOrigin = $price.html(),
          buttonTextOrigin = $buttonText.text();

        if ($container.length) {
          $container.addClass('tf-main-product');
        }

        addToCartWithPriceText($modalQuickView);

        if ($variationForm.length) {
          if (typeof $.fn.wc_variation_form !== 'undefined') {
            $variationForm.wc_variation_form();
            // $(document).trigger('tf_apply_variation_form', [$variationForm]);
          }
          if (typeof $.fn.wcboost_variation_swatches !== 'undefined') {
            $variationForm.wcboost_variation_swatches().trigger('init_variation_swatches.wcboost-variation-swatches');
          }

          if (typeof lazySizes !== 'undefined') {
            lazySizes?.loader?.checkElems();
          }

          $(".tf-variation-dropdown-wrapper .select-item", $variationForm).on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass('disabled')) {
              return false;
            }
            $('.select-item', $(this).closest('.tf-variant-dropdown')).removeClass('active');
            $('.current-value', $(this).closest('.tf-variant-dropdown')).text($(this).text());
            $('select', $(this).closest('.tf-variation-items')).val($(this).data('value')).change();
            $(this).addClass('active');
          });

          // setTimeout(function () {
          //   $(".tf-variation-dropdown-wrapper .select-item[data-is-active=\"1\"]", $variationForm).addClass('active').data('is-active', false);
          // }, 100);

          var updateBadgeSale = function (variation) {
            let price = variation.display_price,
              regularPrice = variation.display_regular_price,
              discount = Math.round(((regularPrice - price) / regularPrice) * 100);
            if (discount > 0) {
              if ($(".badge-sale", $price).length == 0) {
                $(`
                        <p class="badge-sale text-white fw-semibold text-caption-02">
                            <span class="number-sale">
                                ${tfwcFormatTranslate(
  'discount_off',
  '%s%% Off',
  discount
)}
                            </span>
                        </p>`
                )
                  .appendTo($price);
              } else {
$(".number-sale", $price).text(
  tfwcFormatTranslate(
    'discount_off',
    '%s%% Off',
    discount
  )
);
              }
            }
          }

          var updateOptions = function () {

            $(".tf-variation-dropdown-wrapper .select-item", $variationForm).each(function () {

              let $self = $(this);
              let select = $("select", $self.closest(".tf-variation-dropdown-wrapper"));

              var optionValues = select.find('option').map(function () {
                return $(this).val();
              }).get();

              if ($.inArray($self.data('value'), optionValues) === -1) {
                $self.addClass('disabled');
                $self.removeClass('active');
              } else {
                $self.removeClass('disabled');
              }
            });

          };

          var appendSelectedLabel = function (t) {
            var a = $(t).closest(".value").siblings(".label").find("label")
              , e = a.find(".wcboost-variation-swatches__selected-label");
            if (!e.length) {
              e = $('<span class="wcboost-variation-swatches__selected-label" />');
              a.append(e);
            }
            if (t.value) {
              e.text(t.options[t.selectedIndex].text).show();
            } else {
              e.text("").hide();
            }
          };

          var resetOptions = function () {
            $(".wcboost-variation-swatches__item", $variationForm).removeClass("selected active disabled");
            $(".tf-variation-dropdown-wrapper .select-item", $variationForm).removeClass("selected active disabled");
            $(".tf-variation-dropdown-wrapper .current-value", $variationForm).text(
  tfwcTranslate('choose_option', 'Choose an option')
);
          }

          $variationForm.on("reset_focus", function () {
            resetOptions();
          });

          $variationForm.on("show_variation", function (e, variation) {
            updateBadgeSale(variation);
            updateOptions();
          });

          $variationForm
            .on('found_variation', function (e, data) {
              if (data?.image?.full_src) {
                $image.attr('src', data.image.full_src);
              }
              if (data?.price_html) {
                $price.html($(data.price_html).html());
              }
              if (data?.add_to_cart_text) {
                $buttonText.text(data.add_to_cart_text);
              }
            })
            .on('hide_variation', function () {
              // $(".tf-variation-dropdown-wrapper .select-item", $variationForm).removeClass("active");
              updateOptions();
              $image.attr('src', imageOrigin);
              $price.html(priceHTMlOrigin);
              $buttonText.text(buttonTextOrigin);
            });

          var mainQV = new Swiper(".modal-quick-view .tf-single-slide", {
            slidesPerView: 1,
            spaceBetween: 0,
            observer: true,
            observeParents: true,
            speed: 800,
            navigation: {
              nextEl: ".modal-quick-view .single-slide-next",
              prevEl: ".modal-quick-view .single-slide-prev",
            },
          });
        }

      }
    });

    // Quick Add
    $(document).on("click", ".tf-main-product .tf_quick_add_btn, .card-product .tf_quick_add_btn, .tf_add_to_cart.product_type_variable", function (e) {
      e.preventDefault();
      let $btn = $(this);
      let id = $(this).data('product_id');
      $.ajax({
        url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "tf_get_quick_add"),
        type: 'POST',
        data: {
          quick_add_id: id,
          security: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          $btn.addClass('loading');
        },
        success: function (response) {
          if (response?.success) {
            let $response = $(response.data?.content);
            if (!$response.length) {
              return;
            }
            $modalQuickAdd.find('.qs-card-product')
              .empty()
              .html($response)
              .addClass('tf-main-product');

            addToCartWithPriceText($modalQuickAdd);

            let $variationForm = $modalQuickAdd.find('.variations_form'),
              $price = $('.tf-price .price-wrap', $modalQuickAdd),
              $image = $('.product-img img', $modalQuickAdd),
              $buttonText = $('.single_add_to_cart_button .single-add-to-cart-text', $modalQuickAdd),
              priceHTMlOrigin = $price.html(),
              imageOrigin = $image.attr('src') ? $image.attr('src') : $image.attr('data-src'),
              buttonTextOrigin = $buttonText.text();
            $('.screen-reader-text', $variationForm).removeClass('screen-reader-text');
            if (typeof $.fn.wc_variation_form !== 'undefined') {
              $variationForm.wc_variation_form();
              // $(document).trigger('tf_apply_variation_form', [$variationForm]);
            }

            if (typeof $.fn.wcboost_variation_swatches !== 'undefined') {
              $variationForm.wcboost_variation_swatches();
              $modalQuickAdd.trigger('init_variation_swatches.wcboost-variation-swatches');
            }
            if (typeof lazySizes !== 'undefined') {
              lazySizes?.loader?.checkElems();
            }

            $(".tf-variation-dropdown-wrapper .select-item", $variationForm).on('click', function (e) {
              e.preventDefault();
              if ($(this).hasClass('disabled')) {
                return false;
              }
              $('.select-item', $(this).closest('.tf-variant-dropdown')).removeClass('active');
              $('.current-value', $(this).closest('.tf-variant-dropdown')).text($(this).text());
              $('select', $(this).closest('.tf-variation-items')).val($(this).data('value')).change();
              $(this).addClass('active');
            });

            // setTimeout(function () {
            //   $(".tf-variation-dropdown-wrapper .select-item[data-is-active=\"1\"]", $variationForm).addClass('active').data('is-active', false);
            // }, 100);

            var updateOptions = function () {

              $(".tf-variation-dropdown-wrapper .select-item", $variationForm).each(function () {

                let $self = $(this);
                let select = $("select", $self.closest(".tf-variation-dropdown-wrapper"));

                var optionValues = select.find('option').map(function () {
                  return $(this).val();
                }).get();

                if ($.inArray($self.data('value'), optionValues) === -1) {
                  $self.addClass('disabled');
                  $self.removeClass('active');
                } else {
                  $self.removeClass('disabled');
                }
              });
            };

            var resetOptions = function () {
              $(".wcboost-variation-swatches__item", $variationForm).removeClass("selected active disabled");
              $(".tf-variation-dropdown-wrapper .select-item", $variationForm).removeClass("selected active disabled");
              $(".tf-variation-dropdown-wrapper .current-value", $variationForm).text(
  tfwcTranslate('choose_option', 'Choose an option')
);
            }

            $variationForm.on("reset_focus", function () {
              resetOptions();
            });

            $variationForm.on("show_variation", function (e, variation) {
              updateOptions();
            })

            $variationForm
              .on('found_variation', function (e, data) {
                if (data?.image?.full_src) {
                  $image.attr('src', data.image.full_src);
                }
                if (data?.price_html) {
                  $price.html($(data.price_html).html());
                }
                if (data?.add_to_cart_text) {
                  $buttonText.text(data.add_to_cart_text);
                }
              })
              .on('hide_variation', function () {
                // $(".tf-variation-dropdown-wrapper .select-item", $variationForm).removeClass("active");
                updateOptions();
                $image.attr('src', imageOrigin);
                $price.html(priceHTMlOrigin);
                $buttonText.text(buttonTextOrigin);
              });
            $modalQuickAdd.modal('show');

          }

        },
        complete: function () {
          $btn.removeClass('loading');
        }
      });
    });

    var buyNow = function () {
      if (!tfwc_woo_params?.buy_now) {
        return;
      }

      $(document).on('click', '.tf-buy-now-btn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form');

        if ($(this).hasClass('disabled')) {
          return;
        }

        if ($form.hasClass('variations_form') && !($('.variation_id', $form).val() > 0)) {
          window.tfwcNotify(
            tfwcTranslate(
              'select_product_options',
              'Please select some product options before buying this product.'
            )
          );
          return;
        }
        $('.button.single_add_to_cart_button', $form).trigger('click', true);
      });

    };

    var addToCart = function () {
      $(document).on('click', '.tf-main-product form.cart:not(.tf-external-form) button.single_add_to_cart_button', function (e, buyNow = false) {
        e.preventDefault();

        var $form = $(this).closest('form');
        var formData = $form.serialize();

        if ($(this).hasClass('disabled') || $(this).prop('disabled')) {
          return;
        }

        var productID = $(this).val();
        if (productID) {
          formData += '&add-to-cart=' + productID;
        }

        if (buyNow) {
          var formParams = new URLSearchParams(formData);
          formData += `&${tfwc_woo_params?.buy_now}=` + formParams.get('add-to-cart');
        }

        $.ajax({
          url: $form.attr('action'),
          type: 'POST',
          data: formData,
          beforeSend: function () {

            if (buyNow) {
              $('.tf-buy-now-btn', $form).addClass('disabled loading');
              $('.tf-buy-now-btn .tf-add-to-cart-loading', $form).removeClass('d-none');
              return;
            }
            $('button.single_add_to_cart_button', $form).addClass('disabled loading');
            $('button.single_add_to_cart_button', $form).prop('disabled', true);
            $('button.single_add_to_cart_button .tf-add-to-cart-loading', $form).removeClass('d-none');
          },
          success: function (response) {

            if (response.error) {
              // console.error(response.error_message);
            } else {

              let $response = $(response);
              if ($('.woocommerce-error li', $response).length > 0) {

                $.toast(
                  {
                    text: $('.woocommerce-error li', $response).first().html(),
                    showHideTransition: 'fade',
                    icon: 'info',
                    position: {
                      top: 50,
                      right: 20,
                    },
                    "type": "info",
                    "closeBtn": true,
                    "dismissible": true,
                    "append": true,
                    "shadow": true,
                    "duration": null,
                    "maxWidth": "400",
                    "animateOut": 100,
                    "animateIn": 100,
                    "actions": [],
                    "bgColor": "#21503f"
                  }
                );
              } else {
                if (buyNow) {
                  // window.location.href = tfwc_woo_params?.checkout_url;
                  window.location.href = `${tfwc_woo_params?.checkout_url}${tfwc_woo_params?.checkout_url.includes('?') ? '&' : '?'}${tfwc_woo_params?.buy_now}=1`;
                  return;
                }

                $('.tf-mini-cart-items').addClass('loading-items');

                if ($('.popup-shopping-cart', $response).length > 0) {
                  $('.popup-shopping-cart').html($('.popup-shopping-cart', $response).html());
                  $('.tf-mini-cart-items').removeClass('loading-items');
                  showMiniCart();
                } else {
                  $(document.body).trigger('wc_fragment_refresh');
                  showMiniCart();
                }
                if ($('.nav-cart', $response).length > 0) {
                  $('.shopping-cart-items-count').html($('.shopping-cart-items-count', $response).html());
                }

              };
            }
            tf_swiper_slider();
          },
          complete: function () {
            if (buyNow) {
              $('.tf-buy-now-btn', $form).removeClass('disabled loading');
              $('.tf-buy-now-btn .tf-add-to-cart-loading', $form).addClass('d-none');
              return;
            }
            $('button.single_add_to_cart_button', $form).removeClass('disabled loading');
            $('button.single_add_to_cart_button', $form).prop('disabled', false);
            $('button.single_add_to_cart_button .tf-add-to-cart-loading', $form).addClass('d-none');
          }
        });
      });

    };

    $(document.body).on("wc_fragments_refreshed", function () {
      $('.tf-mini-cart-items').removeClass('loading-items');
    });

    addToCart();
    buyNow();

  }

  var showMiniCart = function () {

    if ($(".popup-shopping-cart").length > 0) {
      // $('.modal-compare')?.modal('hide');
      $('.modal-quick-view')?.modal('hide');
      $('.modal-quick-add')?.modal('hide');
      const offcanvasqv = bootstrap.Offcanvas.getOrCreateInstance($("#quickView").get(0));
      const offcanvasCompare = bootstrap.Offcanvas.getOrCreateInstance($("#compare").get(0));
      const offcanvasSearch = bootstrap.Offcanvas.getOrCreateInstance($(".offcanvas-search").get(0));
      const offcanvasMinicart = bootstrap.Offcanvas.getOrCreateInstance($("#shoppingCart").get(0));

      offcanvasqv.hide();
      offcanvasCompare.hide();
      offcanvasSearch.hide();

      offcanvasMinicart.show();
    }

    if ($(".tf-page-cart-main").length > 0) {

      // $('.modal-compare')?.modal('hide');
      $('.modal-quick-view')?.modal('hide');
      $('.modal-quick-add')?.modal('hide');
      const offcanvasqv = bootstrap.Offcanvas.getOrCreateInstance($("#quickView").get(0));
      const offcanvasCompare = bootstrap.Offcanvas.getOrCreateInstance($("#compare").get(0));
      offcanvasqv.hide();
      offcanvasCompare.hide();

      $(document).trigger("wc_update_cart");

    }
  };

  var refreshMinicart = function () {
    $(document.body).on('wc_fragments_loaded', function () {
      $(document.body).trigger('wc_fragment_refresh');
    });
  }

  var shopAddedToCart = function () {
    $(document).on('added_to_cart', function () {
      if ($(".popup-shopping-cart").length > 0 && $(".popup-shopping-cart").is(':visible')) {
        // var offcanvas = new bootstrap.Offcanvas(document.getElementById('shoppingCart'));
        // $('.modal-compare')?.modal('hide');
        $('.modal-quick-view')?.modal('hide');
        $('.modal-quick-add')?.modal('hide');
        const offcanvasqv = bootstrap.Offcanvas.getOrCreateInstance($("#quickView").get(0));
        const offcanvasCompare = bootstrap.Offcanvas.getOrCreateInstance($("#compare").get(0));
        var offcanvasMinicart = bootstrap.Offcanvas.getOrCreateInstance($("#shoppingCart").get(0));

        offcanvasqv.hide();
        offcanvasCompare.hide();
        offcanvasMinicart.show();
      }
    });
  };

  /**
   * List-style card's `.tf-list` Share button (`.tf_share_btn`, product-base/card-button.php)
   * opens the shared `#shareSocial` modal (shell rendered for Shop pages by
   * Woo_Hook::tfwc_shop_share_popup()) — since that one modal is reused by every card in the loop,
   * it can't hold real per-product hrefs server-side. Fill in the clicked product's permalink/title
   * (from its `data-permalink`/`data-title`) right before Bootstrap opens it.
   */
  var productShare = function () {
    $(document).on('click', '.tf_share_btn', function () {
      var permalink = $(this).data('permalink') || '';
      var title = $(this).data('title') || '';
      var $modal = $('#shareSocial');

      if (!$modal.length) {
        return;
      }

      $modal.find('#coppyText').text(permalink);
      $modal.find('li.facebook a.social-item').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(permalink));
      $modal.find('li.instagram a.social-item').attr('href', 'https://www.instagram.com/?url=' + encodeURIComponent(permalink));
      $modal.find('li.twitter a.social-item').attr('href', 'https://x.com/intent/tweet?url=' + encodeURIComponent(permalink) + '&text=' + encodeURIComponent(title));
      $modal.find('li.email a.social-item').attr('href', 'mailto:?subject=' + encodeURIComponent(title) + '&body=' + encodeURIComponent(permalink));
    });

    $(document).on('click', '#btn-coppy-text', function (e) {
      e.stopPropagation();
      var textToCopy = $('#coppyText').text();

      if (!textToCopy) {
        return;
      }

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(textToCopy).then(function () {
          $.toast({
            heading: 'Success',
            text: 'Link copied to clipboard',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000
          });
        }).catch(function (err) {
          console.error("Failed to copy text: " + err);
        });
      } else {
        try {
          const textarea = $('#coppyText').get(0);
          textarea.contentEditable = 'true';
          textarea.textContent = textToCopy;

          const range = document.createRange();
          range.selectNodeContents(textarea);
          const sel = window.getSelection();
          sel.removeAllRanges();
          sel.addRange(range);

          document.execCommand('copy');

          $.toast({
            heading: 'Success',
            text: 'Link copied to clipboard',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000
          });
        } catch (err) {
          console.log('Copy failed', err);
        }
      }
    });
  };

  var swiper_slider = function () {

  }

  var swLayoutShop = function () {
    let isListActive = $(".sw-layout-list").hasClass("active");
    let userSelectedLayout = null;

    function hasValidLayout() {
      return (
        $("#gridLayout").hasClass("tf-col-2") ||
        $("#gridLayout").hasClass("tf-col-3") ||
        $("#gridLayout").hasClass("tf-col-4") ||
        $("#gridLayout").hasClass("tf-col-5") ||
        $("#gridLayout").hasClass("tf-col-6") ||
        $("#gridLayout").hasClass("tf-col-7")
      );
    }

    function updateLayoutDisplay() {
      const windowWidth = $(window).width();
      const currentLayout = $("#gridLayout").attr("class") || "";

      if (!hasValidLayout()) return;

      if (isListActive) {
        $(".wrapper-control-shop")
          .addClass("listLayout-wrapper")
          .removeClass("gridLayout-wrapper");
        return;
      }

      if (userSelectedLayout) {
        if (windowWidth <= 767) {
          setGridLayout("tf-col-2");
        } else if (windowWidth <= 1200 && userSelectedLayout !== "tf-col-2") {
          setGridLayout("tf-col-3");
        } else if (
          windowWidth <= 1400 &&
          (userSelectedLayout === "tf-col-5" ||
            userSelectedLayout === "tf-col-6" ||
            userSelectedLayout === "tf-col-7")
        ) {
          setGridLayout("tf-col-4");
        } else {
          setGridLayout(userSelectedLayout);
        }
        return;
      }

      if (windowWidth <= 767) {
        if (!currentLayout.includes("tf-col-2")) setGridLayout("tf-col-2");
      } else if (windowWidth <= 1200) {
        if (!currentLayout.includes("tf-col-3")) setGridLayout("tf-col-3");
      } else if (windowWidth <= 1400) {
        if (
          currentLayout.includes("tf-col-5") ||
          currentLayout.includes("tf-col-6") ||
          currentLayout.includes("tf-col-7")
        ) {
          setGridLayout("tf-col-4");
        }
      } else {
        // #gridLayout is never actually display:none'd anywhere (no CSS rule, no .hide() call), so
        // .show() here was a no-op at best — and a bug source at worst, see setGridLayout() below.
        $(".wrapper-control-shop")
          .addClass("gridLayout-wrapper")
          .removeClass("listLayout-wrapper");
      }
    }

    function setGridLayout(layoutClass) {
      // .show() used to run here, between the bare .removeClass() (strips ALL classes) and
      // .addClass() below — on a momentarily class-less element with no matching CSS, jQuery's
      // .show() falls back to setting an inline `display:block`, which then permanently overrides
      // the `.tf-grid-layout` class's real `display:grid` (inline styles always win), breaking the
      // grid layout on every later grid-view switch. Removed — nothing here is ever hidden.
      $("#gridLayout")
        .removeClass()
        .addClass(`wrapper-shop tf-grid-layout ${layoutClass}`);

      $(".tf-view-layout-switch").removeClass("active");
      $(`.tf-view-layout-switch[data-value-layout="${layoutClass}"]`).addClass("active");

      // This function also handles switching INTO list view (layoutClass === "tf-list-layout",
      // the list icon's real data-value-layout) — #gridLayout still needs its tf-col-N class
      // swapped for tf-list-layout here (that's what makes the CSS grid single-column instead of
      // N columns), so list mode can't just skip this function; only the resulting isListActive
      // flag and wrapper class differ.
      const isList = layoutClass === "tf-list-layout";

      $(".wrapper-control-shop")
        .toggleClass("gridLayout-wrapper", !isList)
        .toggleClass("listLayout-wrapper", isList);

      isListActive = isList;
    }

    if (isListActive) {
      $("#listLayout").show();
      $(".wrapper-control-shop")
        .addClass("listLayout-wrapper")
        .removeClass("gridLayout-wrapper");
    } else {
      updateLayoutDisplay();
    }

    $(window).on("resize", updateLayoutDisplay);

    $(".tf-view-layout-switch").on("click", function () {
      const layout = $(this).data("value-layout");

      $(".tf-view-layout-switch").removeClass("active");
      $(this).addClass("active");

      $(".wrapper-control-shop").addClass("loading-shop");
      setTimeout(() => {
        $(".wrapper-control-shop").removeClass("loading-shop");
      }, 500);

      // The list-view icon's real markup is `data-value-layout="tf-list-layout"` — setGridLayout()
      // now handles both grid AND list (it sets isListActive/the wrapper class based on the
      // layoutClass value itself, see comment there), so every click routes through it the same
      // way instead of a separate isListActive branch that used to skip #gridLayout's own class
      // swap (tf-col-N → tf-list-layout), which is what actually makes the CSS grid single-column.
      userSelectedLayout = ( layout === "tf-list-layout" ) ? null : layout;
      setGridLayout(layout);
    });
  };

  var toogle_categry = function () {
    $(".toggle-icon").on("click", function () {
      var subMenu = $(this).next(".sub-menu");
      if (subMenu.is(":visible")) {
        subMenu.slideUp();
        $(this).addClass("active");
      } else {
        subMenu.slideDown();
        $(this).removeClass("active");
      }
    });
  }

  var rangeTwoPrice = function () {
    const sliders = document.querySelectorAll(".price-val-range");

    sliders.forEach(function (skipSlider) {

      // if ($(skipSlider).closest('.widget-facet')) {
      //   return;
      // }

      const min = parseInt(skipSlider.getAttribute("data-min")) || 0;
      const max = parseInt(skipSlider.getAttribute("data-max")) || 500;

      const startMin = parseInt(skipSlider.getAttribute("data-start-min")) || min;
      const startMax = parseInt(skipSlider.getAttribute("data-start-max")) || max;


      if (!skipSlider.noUiSlider) {
        noUiSlider.create(skipSlider, {
          start: [startMin, startMax],
          connect: true,
          step: 1,
          range: { min, max },
          format: {
            from: value => parseInt(value),
            to: value => parseInt(value),
          },
        });

        // QA P3-09: the two handles are empty <div>s; give them an accessible name.
        const priceHandles = skipSlider.querySelectorAll('.noUi-handle');
        if (priceHandles[0]) {
          priceHandles[0].setAttribute('aria-label', tfwcTranslate('min_price', 'Minimum price'));
        }
        if (priceHandles[1]) {
          priceHandles[1].setAttribute('aria-label', tfwcTranslate('max_price', 'Maximum price'));
        }

        skipSlider.noUiSlider.on("update", function (val) {
          const currencyMin = document.querySelectorAll(".price-min-value");
          const currencyMax = document.querySelectorAll(".price-max-value");

          currencyMin.forEach(el => {
            el.innerText = parseInt(val[0]);
          });
          currencyMax.forEach(el => {
            el.innerText = parseInt(val[1]);
          });
        });

        skipSlider.noUiSlider.on("change", function (val) {
          sliders.forEach(otherSlider => {
            if (otherSlider !== skipSlider) {
              otherSlider.noUiSlider.set(val);
            }
          });
        });

        skipSlider.noUiSlider.on('change', function (values) {

          let [min, max] = values.map(parseFloat);

          // trigger custom event
          $(skipSlider).trigger('priceSlider:change', {
            min: min,
            max: max
          });

        });
      }
    });
  };

  var changeValueDropdown = function () {
    if ($(".tf-dropdown-sort").length > 0) {
      $(".select-item").on("click", function (event) {
        $(this)
          .closest(".tf-dropdown")
          .find(".text-sort-value")
          .text($(this).find(".text-value-item").text());

        $(this)
          .closest(".dropdown-menu")
          .find(".select-item.active")
          .removeClass("active");

        $(this).addClass("active");
      });
    }
  };

  function getSearchKeyword() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('s') || '';
  }

  var updateTotalCount = function () {

    if ($('#applied-filters').children().length) {
      $('.count-text-total').hide();
      $('.woocommerce-shop .count-text').show();
    } else {
      $('.count-text-total').show();
      $('.woocommerce-shop .count-text').hide();
    }

  };

  var filter_product = function () {
    /**
     * `dynamic_sidebar('shop-sidebar')` renders the Price Slider widget more than once per page (the
     * always-present mobile offcanvas filter panel + the desktop sidebar/filter-top dropdown), so
     * `.price-val-range` matches 2+ independent noUiSlider instances. Blindly using `.get(0)` always
     * reads/resets whichever one happens first in DOM order (the offcanvas copy) regardless of which
     * one the user actually dragged — this picks the slider that's NOT sitting inside a currently
     * closed offcanvas instead, matching what's actually visible/interactable.
     */
    function getActivePriceSlider() {
      var sliders = $('.price-val-range').toArray();
      return sliders.find(function (el) {
        return !$(el).closest('.offcanvas:not(.show)').length;
      }) || sliders[0];
    }

    function fetchFilteredProducts(page = 1, getCount = false, scrollTop = true) {

      var sortValue = $('.tf-dropdown-sort .select-item.active').data('sort-value');
      let selectedFilters = [];
      let selectedAttributes = {};
      let selectedCategories = [];
      let selectedBrand = [];
      let selectedAvailability = [];

      let $priceInput = $('.ovinx-price-input:checked');
      let dataPrice = $priceInput.data('price'),
        dataOperator = $priceInput.data('operator');

      var productStyle = getUrlParameter('product_style');
      if ($('.tf-view-layout-switch').hasClass('active')) {
        productStyle = $('.tf-view-layout-switch.active').data('style');
      }

      let seen_attr = new Set();
      $('.tf-attribute-filter.active').each(function () {
        let $input = $(this).find('input[name^="pa_"]');
        let attr = $input.attr('name');
        let attrValue = $input.data('value');
        let attrName = $input.data('name');

        let key = `${attr}:${attrValue}`;

        if (!seen_attr.has(key)) {
          seen_attr.add(key);

          if (!selectedAttributes[attr]) {
            selectedAttributes[attr] = [];
          }
          selectedAttributes[attr].push(attrValue);

          selectedFilters.push({
            label: attr.replace('pa_', ''),
            value: attrName,
            type: attr
          });
        }
      });

      $('input[name="brand"]:checked').each(function () {
        selectedBrand.push($(this).data('brand'));
        selectedFilters.push({ label: tfwcTranslate('brand', 'Brand'), value: $(this).data('brand'), type: 'brand' });
      });

      let seen = new Set();
      $('input[name="product_status"]:checked').each(function () {
        let checkboxValue = $(this).attr('data-available');

        if (!seen.has(checkboxValue)) {
          seen.add(checkboxValue);
          selectedAvailability.push(checkboxValue);
          selectedFilters.push({
            label: tfwcTranslate('availability', 'Availability'),
            value: checkboxValue,
            type: 'product_status'
          });
        }
      });

      $('.tf_filter_category').each(function () {
        if ($(this).hasClass('active')) {
          let category = $(this).data('category');

          if (!selectedCategories.includes(category)) {
            selectedCategories.push(category);
            selectedFilters.push({
              label: tfwcTranslate('category', 'Category'),
              value: category,
              type: 'category'
            });
          }
        }
      });

      $('.ovinx-price-input:checked').each(function () {

        let price = $(this).data('price');
        let operator = $(this).data('operator');
        let label = $(this).next('label').text();

        selectedFilters.push({
          label: label,
          value: price,
          operator: operator,
          type: 'price'
        });

      });

      let keywords = getSearchKeyword('s');

      var pagination_type = new URLSearchParams(window.location.search).get('pagination');
      var products_per_page = new URLSearchParams(window.location.search).get('products_per_page');

      let filterData = {
        action: 'filter_products',
        sortValue: sortValue,
        attributes: selectedAttributes,
        categories: selectedCategories,
        brand: selectedBrand,
        availability: selectedAvailability,
        page: page,
        pagination_type: pagination_type,
        products_per_page: products_per_page,
        product_style: productStyle,
        nonce: tfwc_woo_params.nonce,
        s: keywords
      };

      if (dataPrice && dataOperator) {
        filterData.price = dataPrice;
        filterData.operator = dataOperator;
      }

      let slider = getActivePriceSlider();

      if (slider && slider.noUiSlider) {
        let values = slider.noUiSlider.get();

        let priceMin = parseFloat(values[0]);
        let priceMax = parseFloat(values[1]);

        selectedFilters.push({ label: tfwcTranslate('price', 'Price'), value: `${numberFormat(priceMin)} - ${numberFormat(priceMax)}`, type: 'price-range', dataMin: priceMin, dataMax: priceMax });

        filterData.min_price = priceMin;
        filterData.max_price = priceMax;
      }

      let rating = $('.input-rating-filter:checked').val();

      if (rating) {
        selectedFilters.push({ label: tfwcTranslate('rating', 'Rating'), value: tfwcFormatTranslate(
  'stars_and_up',
  '%s stars & up',
  rating
), type: 'rating' });

        filterData.rating = rating;
      }

      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: 'POST',
        data: filterData,
        beforeSend: function () {

          if (getCount) {
            return;
          }

          if (scrollTop) {
            scrollToElementWithOffset($('.tf-shop-control-static'), ($('.tf-header:visible').height() || 0) + ($('#wpadminbar:visible').height() || 32));
          }

          $('.wrapper-control-shop').addClass('loading-shop');
        },
        success: function (response) {

          $('.apply-filter-count').text(` [${response.data.product_count}]`);

          if (getCount) {
            return;
          }

          if (response.data.product_count > 0) {
            $('.products-content .wrapper-control-shop .wrapper-shop ').addClass('tf-grid-layout').html(response.data.products);
          } else {
            $('.products-content .wrapper-control-shop .wrapper-shop ').removeClass('tf-grid-layout').html(response.data.products);
          }

          let productCount = response.data.product_count;
          if (productCount == 0 || !response.data.next_page) {
            $('.woocommerce-pagination')
              .removeClass('ajax-pagination')
              // .attr('style', 'display: none !important;');
              .hide();
          } else {
            $('.woocommerce-pagination')
              .addClass('ajax-pagination')
              // .attr('style', 'display: flex !important;');
              .show();
          }

          let productText = productCount === 1
  ? tfwcFormatTranslate(
      'product_found',
      '%s Product found',
      productCount
    )
  : tfwcFormatTranslate(
      'products_found',
      '%s Products found',
      productCount
    );
          $('.woocommerce-shop .count-text').text(productText);

          $('.count-text-total .count-number').text(productCount);

          updateFilterDisplay(selectedFilters);

          setTimeout(() => {
            ovinxSaleMarquee();
            if (scrollTop) {
              scrollToElementWithOffset($('.tf-shop-control-static'), ($('.tf-header:visible').height() || 0) + ($('#wpadminbar:visible').height() || 32));
            }
          }, 100);

          countDown();

          swatchColor();

          if (response.data.next_page) {
            $('#autoload-btn').show().data('page', page + 1);
          } else {
            $('#autoload-btn').hide();
          }

          $('.woocommerce-pagination .ovinx-pagi-wrapper').html(response.data.pagination);
          $('.products-content').removeClass('loading-content');
        },
        complete: function () {
          if (getCount) {
            return;
          }
          $('.wrapper-control-shop').removeClass('loading-shop');
        }
      });
    }

    $(document).on('change', '.meta-dropdown-filter .dropdown-filter', function (e) {
      $(this).find('.dropdown-toggle').removeClass('show');
      $(this).find('.dropdown-menu').removeClass('show');
    });

    $('.tf-attribute-filter').on('change', function (e) {
      e.preventDefault();

      const $this = $(this);

      const checked = $(this).find('input').prop('checked');
      let $groupCheck = $(this).closest('.filter-group-check');

      if (checked) {
        if (!$groupCheck.hasClass('multiple-selection')) {
          $('.tf-attribute-filter', $groupCheck).removeClass('active').find('input').prop('checked', false);
        }
        $this.addClass('active').find('input').prop('checked', true);
      } else {
        $this.removeClass('active').find('input').prop('checked', false);
      }

      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }
      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $('.tf_filter_category').on('change', function (e) {
      e.preventDefault();

      let $groupCheck = $(this).closest('.filter-group-check');

      if ($(this).prop('checked')) {
        if (!$groupCheck.hasClass('multiple-selection')) {
          $('.tf_filter_category', $groupCheck).not(this).prop('checked', false).removeClass('active');
        }
        $(this).addClass('active');
      } else {
        $(this).removeClass('active');
      }
      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }
      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $('.tf_filter_brand').on('change', function (e) {
      e.preventDefault();

      let $groupCheck = $(this).closest('.filter-group-check');

      if ($(this).prop('checked')) {
        if (!$groupCheck.hasClass('multiple-selection')) {
          $('.tf_filter_brand', $groupCheck).not(this).prop('checked', false).removeClass('active');
        }
        $(this).addClass('active');
      } else {
        $(this).removeClass('active');
      }
      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }
      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $('#availability .tf-check').on('change', function (e) {
      // e.preventDefault();

      if ($(this).prop('checked')) {
        $('#availability .tf-check').not(this)
          .prop('checked', false)
          .removeClass('active');

        $(this).addClass('active');
      } else {
        $(this).removeClass('active');
      }
      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }
      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $(document).on('change', '.ovinx-price-input', function (e) {
      e.preventDefault();

      if ($(this).prop('checked')) {
        $('.ovinx-price-input').not(this).prop('checked', false);
      }

      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }

      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $(document).on('change', '.input-rating-filter', function (e, data) {
      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }

      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $(document).on('priceSlider:change', '.price-val-range', function (e, data) {
      if ($('.tf-apply-filters-btn:visible', $(e.target).closest('.canvas-filter')).length && tfwc_woo_params?.filter_sidebar_button) {
        updateApplyButtonCount();
        return;
      }

      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    $(document).on('click', '.tf-dropdown-sort .select-item', function (e) {
      $('.text-sort-value').text($(this).find('.text-value-item').text());
      closeFilterOffcanvas();
      fetchFilteredProducts();
    })

    // Tracks the product_style the currently-rendered card HTML actually matches (set once here from
    // whichever layout-switch button starts active, then kept in sync by the click handler below) —
    // see the handler's own comment for why this can't just read `.tf-view-layout-switch.active` at
    // click time.
    if (!$('#gridLayout').attr('data-current-style')) {
      $('#gridLayout').attr('data-current-style', $('.tf-view-layout-switch.active').data('style') || 'style-1');
    }

    $(document).on('click', '.tf-view-layout-switch', function (e) {
      e.preventDefault();

      var $grid = $('#gridLayout');
      var newStyle = $(this).data('style');
      var currentStyle = $grid.attr('data-current-style');

      $('.tf-view-layout-switch').removeClass('active');
      $(this).addClass('active');

      /**
       * swLayoutShop()'s setGridLayout() is bound directly on each `.tf-view-layout-switch` <li>
       * (this handler here is delegated on `document`, so per DOM event bubbling it always runs
       * AFTER that direct one for the same click) — it already updates #gridLayout's CSS instantly
       * and correctly for grid-2/3/4 column-count switches, since those all share the same
       * server-rendered card markup (`data-style="style-1"`). Re-fetching via AJAX here too on every
       * click raced with that instant update and caused a visible flash/flicker (reported by user:
       * "nháy layout 1 phát xong mới xuất hiện đúng layout"). Only switching to/from List genuinely
       * needs new HTML from the server (different card markup, e.g. List's `.card-product_button`
       * panel) — only re-fetch when the style actually changes, comparing against `data-current-style`
       * (not `.tf-view-layout-switch.active`, which the direct handler above already updated to the
       * NEW button by the time this runs).
       */
      if (newStyle !== currentStyle) {
        $grid.attr('data-current-style', newStyle);
        fetchFilteredProducts();
      }
    })

    $(document).on('click', '.remove-all-filters, .tf-clear-filters-btn', function () {
      closeFilterOffcanvas();
      clearAllFilters();
    });

    $(document).on('click', '.tf-apply-filters-btn', function () {
      closeFilterOffcanvas();
      fetchFilteredProducts();
    });

    var updateApplyButtonCount = function () {
      fetchFilteredProducts(1, true);
    };

    function updateFilterDisplay(selectedFilters) {
      let filterContainer = $('.selected-filters');
      filterContainer.empty();
      if (selectedFilters.length > 0) {
        selectedFilters.forEach(filter => {
          let filterItem;
          if (filter?.type == 'price') {
            filterItem = $(
              `<span class="filter-tag" data-type="${filter.type}" data-value="${filter.value}" data-operator="${filter.operator}">
                      <span class="remove-tag icon icon-close"></span> ${filter.label}
                </span>`
            );

            filterItem.on('click', function () {
              removeFilter($(this).data('type'), $(this).data('value'), $(this).data('operator'));
            });

          } else if (filter?.type == 'price-range') {

            let slider = getActivePriceSlider();

            if (slider && slider.noUiSlider) {
              let defaultMin = parseFloat(slider.dataset.min);
              let defaultMax = parseFloat(slider.dataset.max);

              if (defaultMin == filter?.dataMin && defaultMax == filter?.dataMax) {
                return;
              }
            }

            filterItem = $(
              `<span class="filter-tag" data-type="${filter.type}" data-value="${filter.value}">
                <span class="remove-tag icon icon-close"></span> ${filter.label}: ${filter.value}
              </span>`
            );

            filterItem.on('click', function () {
              removeFilter($(this).data('type'), $(this).data('value'));
            });

          } else {
            filterItem = $(
              `<span class="filter-tag" data-type="${filter.type}" data-value="${filter.value}">
                <span class="remove-tag icon icon-close"></span> ${filter.label}: ${filter.value}
              </span>`
            );

            filterItem.on('click', function () {
              removeFilter($(this).data('type'), $(this).data('value'));
            });
          }
          filterContainer.append(filterItem);
        });

        // let clearAll = $('<span class="remove-all-filters"><span class="icon icon-close"></span> Clear All Filter</span>');
        // filterContainer.append(clearAll);

        if ($('.filter-tag', filterContainer).length < 2) {
          $('.remove-all-filters').hide();
        } else {
          $('.remove-all-filters').show();
        }

        $(".apply-filter-wrap", ".canvas-filter.left").slideDown(300).fadeIn(300);
        $(".apply-filter-wrap", ".canvas-filter.right").slideDown(300).fadeIn(300);
      } else {
        $('.woocommerce-shop .count-text').text('');
        $('.remove-all-filters').hide();
        $(".apply-filter-wrap", ".canvas-filter.left").slideUp(300).fadeOut(300);
        $(".apply-filter-wrap", ".canvas-filter.right").slideUp(300).fadeOut(300);
      }
      updateTotalCount();
    }

    function removeFilter(type, value, operator = '') {
      switch (type) {
        case 'price':
          $('input.ovinx-price-input[data-price="' + value + '"][data-operator="' + operator + '"]').prop('checked', false);
          break;
        case 'price-range':
          let slider = getActivePriceSlider();

          if (slider && slider.noUiSlider) {
            let defaultMin = parseFloat(slider.dataset.min);
            let defaultMax = parseFloat(slider.dataset.max);

            // reset slider handles
            slider.noUiSlider.set([defaultMin, defaultMax]);

            // update text UI
            $('.price-min-value').text(defaultMin);
            $('.price-max-value').text(defaultMax);
          }

          break;
        case 'rating':
          $('input.input-rating-filter').prop('checked', false);
        case 'category':
          $('.tf_filter_category[data-category="' + value + '"]').prop('checked', false).removeClass('active');
          break;
        case 'brand':
          $('input[data-brand="' + value + '"]').prop('checked', false);
          break;
        case 'product_status':
          $('input[data-available="' + value + '"]').each(function () {
            $(this).prop('checked', false);
            $(this).closest('li').removeClass('active');
          });
          break;
        default:
          $('input[data-name="' + value + '"]').each(function () {
            if ($(this).data('name') === value) {
              $(this).prop('checked', false);
              $(this).closest('.tf-attribute-filter').removeClass('active');
            }
          });
          break;
      }

      fetchFilteredProducts();
    }

    $('.reset-price').on('click', function (e) {
      e.preventDefault();
      fetchFilteredProducts();
    })

    function clearAllFilters() {

      /**
       * `dynamic_sidebar('shop-sidebar')` renders more than once per page (the always-present mobile
       * offcanvas filter panel `#filterShop` + the desktop sidebar column / filter-top dropdown), so
       * the same filter checkboxes exist twice in the DOM with different wrapper classes
       * (`.tf-control-filter` / `.sidebar-filter` / the offcanvas's own `.canvas-filter`). Only
       * targeting the first two left whichever copy the user actually interacted with un-reset —
       * `.canvas-filter` is the one class common to every render pass, so add it here too.
       */
      $('.tf-control-filter input, .sidebar-filter input, .canvas-filter input')
        .prop('checked', false);

      $('.tf-control-filter input, .sidebar-filter input, .canvas-filter input').not('.input-rating-filter').val('');

      $('.tf-control-filter .list-item, .sidebar-filter .list-item, .canvas-filter .list-item').removeClass('active');

      $('.tf-control-filter .tf-check, .sidebar-filter .tf-check, .canvas-filter .tf-check').removeClass('active');

      $('.tf-control-filter .check-item, .sidebar-filter .check-item, .canvas-filter .check-item').removeClass('active');

      /**
       * Same duplicate-render story as above: the Price Slider widget also renders once per
       * `dynamic_sidebar('shop-sidebar')` pass, so `.price-val-range` matches 2+ sliders on the page.
       * `.get(0)` only ever reset the FIRST one (the offcanvas's, usually not the one the user actually
       * dragged) — reset every instance found.
       */
      $('.price-val-range').each(function () {
        let slider = this;

        if (!slider.noUiSlider) {
          return;
        }

        let defaultMin = parseFloat(slider.dataset.min);
        let defaultMax = parseFloat(slider.dataset.max);

        // reset slider handles
        slider.noUiSlider.set([defaultMin, defaultMax]);
      });

      // update text UI (class-based, already reaches every render pass)
      let $firstSlider = $('.price-val-range').filter(function () { return !!this.noUiSlider; }).first();
      if ($firstSlider.length) {
        $('.price-min-value').text(parseFloat($firstSlider[0].dataset.min));
        $('.price-max-value').text(parseFloat($firstSlider[0].dataset.max));
      }

      fetchFilteredProducts();
    }

    $(document).on('click', '.woocommerce-pagination.ajax-pagination a.page-numbers', function (e) {
      e.preventDefault();
      // scrollToElementWithOffset($('.tf-shop-control'), ($('.header-default:visible').height() || 0) + 32);
      var href = $(this).attr('href');
      var page = 1;

      var match = href.match(/(?:paged=|page\/)(\d+)/);

      if (match && match[1]) {
        page = match[1];
      }

      fetchFilteredProducts(page);
    });

    $(document).on('click', '#load-more-btn', function (e) {
      e.preventDefault();

      let currentPage = $(this).data('page');

      appendFilteredProducts(currentPage);
      let nextPage = currentPage + 1;

      $(this).data('page', nextPage);
    });

    function appendFilteredProducts(page = 1) {
      let selectedFilters = [];
      let selectedAttributes = {};
      let selectedCategories = [];
      let selectedBrand = [];
      let selectedAvailability = [];
      var sortValue = $('.tf-dropdown-sort .select-item.active').data('sort-value');

      let $priceInput = $('.ovinx-price-input:checked');
      let dataPrice = $priceInput.data('price'),
        dataOperator = $priceInput.data('operator');

      var productStyle = getUrlParameter('product_style');
      if ($('.tf-view-layout-switch').hasClass('active')) {
        productStyle = $('.tf-view-layout-switch.active').data('style');
      }

      $('.tf-attribute-filter.active').each(function () {
        let attr = $(this).find('input[name^="pa_"]').attr('name');
        let attrValue = $(this).find('input[name^="pa_"]').data('value');
        let attrName = $(this).find('input[name^="pa_"]').data('name');

        if (!selectedAttributes[attr]) {
          selectedAttributes[attr] = [];
        }

        selectedAttributes[attr].push(attrValue);

        selectedFilters.push({ label: attr.replace('pa_', ''), value: attrName, type: attr });
      });

      $('input[name="brand"]:checked').each(function () {
        selectedBrand.push($(this).data('brand'));
        selectedFilters.push({ label: tfwcTranslate('brand', 'Brand'), value: $(this).data('brandname'), type: 'brand' });

      });

      let seen = new Set();
      $('input[name="product_status"]:checked').each(function () {
        let checkboxValue = $(this).attr('data-available');

        if (!seen.has(checkboxValue)) {
          seen.add(checkboxValue);
          selectedAvailability.push(checkboxValue);
          selectedFilters.push({
            label: tfwcTranslate('availability', 'Availability'),
            value: checkboxValue,
            type: 'product_status'
          });
        }
      });

      $('.tf_filter_category').each(function () {
        if ($(this).hasClass('active')) {
          selectedCategories.push($(this).data('category'));
          selectedFilters.push({ label: tfwcTranslate('category', 'Category'), value: $(this).data('category'), type: 'category' });
        }
      });

      var pagination_type = new URLSearchParams(window.location.search).get('pagination');
      var products_per_page = new URLSearchParams(window.location.search).get('products_per_page');

      let keywords = getSearchKeyword('s');

      let filterData = {
        action: 'filter_products',
        attributes: selectedAttributes,
        categories: selectedCategories,
        brand: selectedBrand,
        availability: selectedAvailability,
        page: page,
        pagination_type: pagination_type,
        products_per_page: products_per_page,
        sortValue: sortValue,
        product_style: productStyle,
        nonce: tfwc_woo_params.nonce,
        s: keywords,
      };

      if (dataPrice && dataOperator) {
        filterData.price = dataPrice;
        filterData.operator = dataOperator;
      }

      let slider = getActivePriceSlider();

      if (slider && slider.noUiSlider) {
        let values = slider.noUiSlider.get();

        let priceMin = parseFloat(values[0]);
        let priceMax = parseFloat(values[1]);

        selectedFilters.push({ label: tfwcTranslate('price', 'Price'), value: `${numberFormat(priceMin)} - ${numberFormat(priceMax)}`, type: 'price-range', dataMin: priceMin, dataMax: priceMax });

        filterData.min_price = priceMin;
        filterData.max_price = priceMax;
      }

      let rating = $('.input-rating-filter:checked').val();

      if (rating) {
        selectedFilters.push({ label: tfwcTranslate('rating', 'Rating'), value: tfwcFormatTranslate(
  'stars_and_up',
  '%s stars & up',
  rating
), type: 'rating' });

        filterData.rating = rating;
      }

      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: 'POST',
        data: filterData,
        beforeSend: function () {
          $('#load-more-btn').addClass('loading');
        },
        success: function (response) {
          // $('.woocommerce-pagination .ovinx-pagi-wrapper').replaceWith(response.data.pagination);
          $('.woocommerce-pagination .ovinx-pagi-wrapper').html(response.data.pagination);

          if (response.data.product_count > 0) {
            var productsHtml = '';
            response.data.products.forEach(function (productHtml) {

              productsHtml += '<div class="tf-new-product-fadein" style="display:none;">' + productHtml + '</div>';
            });

            var $wrapper = $('.products-content .wrapper-control-shop .wrapper-shop');

            $wrapper.append(productsHtml);

            $wrapper.find('.tf-new-product-fadein').each(function (index) {
              $(this).delay(150 * index)
                .fadeIn(500, function () {
                  $(this).removeClass('tf-new-product-fadein');

                  if (index === 0) {
                    let offsetScroll = $(this).offset().top - ($('.header-default:visible').height() || 0);
                    offsetScroll = offsetScroll - 32 // Padding;

                    if ($("#wpadminbar:visible").length) {
                      offsetScroll = offsetScroll - $("#wpadminbar:visible").height();
                    }

                    window.scrollTo({
                      top: offsetScroll,
                      behavior: 'smooth'
                    });
                  }

                });
            });

          }

          let productCount = response.data.product_count;
          if (productCount == 0 || !response.data.next_page) {
            $('.woocommerce-pagination')
              .removeClass('ajax-pagination')
            // .hide();
          } else {
            $('.woocommerce-pagination')
              .addClass('ajax-pagination')
            // .attr('style', 'display: flex !important;');
            // .show();
          }

          let productText = productCount === 1
  ? tfwcFormatTranslate(
      'product_found',
      '%s Product found',
      productCount
    )
  : tfwcFormatTranslate(
      'products_found',
      '%s Products found',
      productCount
    );
          $('.woocommerce-shop .count-text').text(productText);
          setTimeout(() => {
            ovinxSaleMarquee();
          }, 100);
          countDown();
          swatchColor();

        },
        complete: function () {
          $('#load-more-btn').removeClass('loading');
        }
      });
    }

    let loading = false;

    var isFading = false;
    var fadeQueue = [];

    checkAutoLoad();

    $(window).scroll(function () {
      checkAutoLoad();
    });

    function checkAutoLoad() {
      if ($('#autoload-btn:visible').length == 0 || $('.wrapper-control-shop').hasClass('loading-shop')) {
        return;
      }
      var footerTop = $('#autoload-btn').offset().top;
      var scrollBottom = $(window).scrollTop() + $(window).height();

      if (scrollBottom >= footerTop) {
        autoFilteredProducts();
      }
    }

    function addFadeItems($items) {
      fadeQueue.push($items);
      runFadeQueue();
    }

    function runFadeQueue() {
      if (isFading) return;
      if (fadeQueue.length === 0) {
        checkAutoLoad();
        return;
      }

      var $items = fadeQueue.shift();
      isFading = true;

      $items.each(function (index) {
        $(this)
          .delay(150 * index)
          .fadeIn(500, function () {
            $(this).removeClass('tf-new-product-fadein');

            if (index === $items.length - 1) {
              isFading = false;
              runFadeQueue();
            }
          });
      });
    }

    function autoFilteredProducts() {
      if (loading) return;
      loading = true;
      let page = $('#autoload-btn').data('page');
      var pagination_type = new URLSearchParams(window.location.search).get('pagination');
      var products_per_page = new URLSearchParams(window.location.search).get('products_per_page');

      let $priceInput = $('.ovinx-price-input:checked');
      let dataPrice = $priceInput.data('price'),
        dataOperator = $priceInput.data('operator');

      var sortValue = $('.tf-dropdown-sort .select-item.active').data('sort-value');
      let selectedFilters = [];
      let selectedAttributes = {};
      let selectedCategories = [];
      let selectedBrand = [];
      let selectedAvailability = [];

      var productStyle = getUrlParameter('product_style');
      if ($('.tf-view-layout-switch').hasClass('active')) {
        productStyle = $('.tf-view-layout-switch.active').data('style');
      }

      let seen_attr = new Set();
      $('.tf-attribute-filter.active').each(function () {
        let $input = $(this).find('input[name^="pa_"]');
        let attr = $input.attr('name');
        let attrValue = $input.data('value');
        let attrName = $input.data('name');

        let key = `${attr}:${attrValue}`;

        if (!seen_attr.has(key)) {
          seen_attr.add(key);

          if (!selectedAttributes[attr]) {
            selectedAttributes[attr] = [];
          }
          selectedAttributes[attr].push(attrValue);

          selectedFilters.push({
            label: attr.replace('pa_', ''),
            value: attrName,
            type: attr
          });
        }
      });

      $('input[name="brand"]:checked').each(function () {
        selectedBrand.push($(this).data('brand'));
        selectedFilters.push({ label: tfwcTranslate('brand', 'Brand'), value: $(this).data('brandname'), type: 'brand' });
      });

      let seen = new Set();
      $('input[name="product_status"]:checked').each(function () {
        let checkboxValue = $(this).attr('data-available');

        if (!seen.has(checkboxValue)) {
          seen.add(checkboxValue);
          selectedAvailability.push(checkboxValue);
          selectedFilters.push({
            label: tfwcTranslate('availability', 'Availability'),
            value: checkboxValue,
            type: 'product_status'
          });
        }
      });

      $('.tf_filter_category').each(function () {
        if ($(this).hasClass('active')) {
          let category = $(this).data('category');

          if (!selectedCategories.includes(category)) {
            selectedCategories.push(category);
            selectedFilters.push({
              label: tfwcTranslate('category', 'Category'),
              value: category,
              type: 'category'
            });
          }
        }
      });

      let keywords = getSearchKeyword('s');

      let filterData = {
        action: 'filter_products',
        attributes: selectedAttributes,
        categories: selectedCategories,
        brand: selectedBrand,
        availability: selectedAvailability,
        page: page,
        pagination_type: pagination_type,
        products_per_page: products_per_page,
        sortValue: sortValue,
        product_style: productStyle,
        nonce: tfwc_woo_params.nonce,
        s: keywords,
      };

      if (dataPrice && dataOperator) {
        filterData.price = dataPrice;
        filterData.operator = dataOperator;
      }

      let slider = getActivePriceSlider();

      if (slider && slider.noUiSlider) {
        let values = slider.noUiSlider.get();

        let priceMin = parseFloat(values[0]);
        let priceMax = parseFloat(values[1]);

        selectedFilters.push({ label: tfwcTranslate('price', 'Price'), value: `${numberFormat(priceMin)} - ${numberFormat(priceMax)}`, type: 'price-range', dataMin: priceMin, dataMax: priceMax });

        filterData.min_price = priceMin;
        filterData.max_price = priceMax;
      }

      let rating = $('.input-rating-filter:checked').val();

      if (rating) {
        selectedFilters.push({ label: tfwcTranslate('rating', 'Rating'), value: tfwcFormatTranslate(
  'stars_and_up',
  '%s stars & up',
  rating
), type: 'rating' });

        filterData.rating = rating;
      }

      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: 'POST',
        data: filterData,
        beforeSend: function () {
        },
        success: function (response) {
          if (response.data.product_count > 0) {
            var productsHtml = '';
            response.data.products.forEach(function (productHtml) {

              productsHtml += '<div class="tf-new-product-fadein" style="display:none;">' + productHtml + '</div>';
            });

            var $newItems = $(productsHtml).appendTo($('.products-content .wrapper-control-shop .wrapper-shop'));
            addFadeItems($newItems);
            checkAutoLoad();
          }
          let productCount = response.data.product_count;
          if (productCount == 0 || !response.data.next_page) {
            $('.woocommerce-pagination')
              .removeClass('ajax-pagination')
            // .attr('style', 'display: none !important;');
            // .hide();
          } else {
            $('.woocommerce-pagination')
              .addClass('ajax-pagination')
            // .attr('style', 'display: flex !important;');
            // .show();
          }

          let productText = productCount === 1
  ? tfwcFormatTranslate(
      'product_found',
      '%s Product found',
      productCount
    )
  : tfwcFormatTranslate(
      'products_found',
      '%s Products found',
      productCount
    );
          $('.woocommerce-shop .count-text').text(productText);
          // updateFilterDisplay(selectedFilters);
          // quickview_product();
          setTimeout(() => {
            ovinxSaleMarquee();
          }, 100);
          countDown();
          swatchColor();
          // compare();
          if (response.data.next_page) {
            $('#autoload-btn').show().data('page', page + 1);
          } else {
            $('#autoload-btn').hide();
          }
          loading = false;
          $('.woocommerce-pagination .ovinx-pagi-wrapper').html(response.data.pagination);
        }
      });
    }

    function getUrlParameter(name) {
      var url = window.location.href;
      var regex = new RegExp('[?&]' + name + '=([^&#]*)', 'i');
      var results = regex.exec(url);
      return results === null ? null : decodeURIComponent(results[1]);
    }

    function closeFilterOffcanvas() {

      var offcanvasElement = document.getElementById('filterShop');
      if (offcanvasElement) {
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement) || new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.hide();
      }
      $(".sidebar-filter, .overlay-filter").removeClass("show");
    }

    $('input.tf-check:checked').trigger('change');
  }

  var ajax_search = function () {
    // Search popup
    let typingTimer;

    const $offcanvasSearchEl = $('#tfsearch');

    // let resultsContainer = $(".offcanvas-search .result-product .swiper-wrapper");

    let popupContent = $(".offcanvas-search .popup-content");

    let resultsContainer = $(".offcanvas-search .result-products-wrap");

    let searchedContainer = $(".offcanvas-search .most-search-products-wrap");

    // let result_show = $(".offcanvas-search .result-product");
    // let featured_show = $(".offcanvas-search .featured-product");

    // result_show.hide();
    // featured_show.show();
    let searchButton = $(".form-search button i");
    let searchCache = JSON.parse(sessionStorage.getItem("searchCache")) || {};

    let doneTypingInterval = 800;

    $(document).on("input", ".ajax-search-input:visible", function () {

      if (!$offcanvasSearchEl.hasClass('show')) {
        // new bootstrap.Offcanvas($offcanvasSearchEl.get(0)).show();
        bootstrap.Offcanvas.getOrCreateInstance($offcanvasSearchEl.get(0)).hide();
      }

      clearTimeout(typingTimer);
      let query = $(this).val().trim();
      let cat = $(".form_search-product .dropdown_product_cat");

      if (query.length) {
        $(".tf-search-btn")
          .removeClass('is-search')
          .addClass('is-clear');
      } else {
        $(".tf-search-btn")
          .addClass('is-search')
          .removeClass('is-clear');
      }

      if (query.length >= 2) {

        typingTimer = setTimeout(function () {

          let current_cat = cat.val();

          if (!current_cat) {
            if (searchCache[query] !== undefined) {

              resultsContainer.show();
              searchedContainer.hide();

              if (searchCache[query]?.products) {
                $(".swiper-wrapper", resultsContainer).html(searchCache[query]?.products || '');
                ovinxSwiper(resultsContainer);
                countDown();
                swatchColor();
                resultsContainer.show();
                searchedContainer.hide();
                console.log('from cache');
              }

              if (searchCache[query]?.view_all_html) {
                $(".tfwc-view-all", resultsContainer).html(searchCache[query]?.view_all_html).show();
              } else {
                $(".tfwc-view-all", resultsContainer).hide();
              }

              if (!searchCache[query]?.products) {
                $(".quick-link-content").show();
                const noResultsText = tfwcFormatTranslate(
  'no_search_results',
  'No results found for "%s".',
  `<span class="current-keyword">${query}</span>`
);

$(".result-products-title", resultsContainer).html(noResultsText);
                $(".swiper-wrapper", resultsContainer).html(
  '<div class="no-results">' +
  tfwcTranslate(
    'search_suggestion',
    'Check the spelling or use a different word or phrase.'
  ) +
  '</div>'
);

              } else {
                $(".quick-link-content").hide();
                $(".result-products-title", resultsContainer).html(tfwc_woo_params.related_product_text);
              }

              return;
            }
          }

          $.ajax({
            type: "POST",
            url: tfwc_woo_params.ajax_url,
            data: {
              action: "tfwc_search_products",
              query: query,
              cat: current_cat,
              nonce: tfwc_woo_params.nonce,
            },
            beforeSend: function () {
              $(".swiper-wrapper", resultsContainer).addClass('loading-content');
              popupContent.addClass("loading-items");
            },
            success: function (response) {
              if (response.success) {
                if (response.data?.products) {
                  $(".swiper-wrapper", resultsContainer).html(response.data?.products || '');
                  ovinxSwiper(resultsContainer);
                  // swiper_slider();
                  // quickview_product();
                  countDown();
                  swatchColor();
                  // compare();
                }
                // else if (response.data?.categories) {
                // resultsContainer.hide();
                // } else {
                // resultsContainer.show();
                // }

                if (response.data?.view_all_html) {
                  $(".tfwc-view-all", resultsContainer).html(response.data?.view_all_html).show();
                } else {
                  $(".tfwc-view-all", resultsContainer).hide();
                }

                if (!response.data?.products) {
                  $(".quick-link-content").show();
                  const noResultsText = tfwcFormatTranslate(
  'no_search_results',
  'No results found for "%s".',
  `<span class="current-keyword">${query}</span>`
);

$(".result-products-title", resultsContainer).html(noResultsText);
                  $(".swiper-wrapper", resultsContainer).html(
  '<div class="no-results">' +
  tfwcTranslate(
    'search_suggestion',
    'Check the spelling or use a different word or phrase.'
  ) +
  '</div>'
);

                } else {
                  $(".quick-link-content").hide();
                  $(".result-products-title", resultsContainer).html(tfwc_woo_params.related_product_text);
                }

                if (!current_cat) {
                  searchCache[query] = response.data || {};
                  sessionStorage.setItem("searchCache", JSON.stringify(searchCache));
                }

              } else {
                $(".quick-link-content").show();
                const noResultsText = tfwcFormatTranslate(
  'no_search_results',
  'No results found for "%s".',
  `<span class="current-keyword">${query}</span>`
);

$(".result-products-title", resultsContainer).html(noResultsText);
                $(".swiper-wrapper", resultsContainer).html(
  '<div class="no-results">' +
  tfwcTranslate(
    'search_suggestion',
    'Check the spelling or use a different word or phrase.'
  ) +
  '</div>'
);
              }
            },
            error: function () {
              $(".quick-link-content").show();
              $(".swiper-wrapper", resultsContainer).html(
  '<div class="error">' +
  tfwcTranslate(
    'search_error',
    'An error occurred while searching.'
  ) +
  '</div>'
);
            },
            complete: function () {
              $(".swiper-wrapper", resultsContainer).removeClass('loading-content');
              popupContent.removeClass("loading-items");
              resultsContainer.show();
              searchedContainer.hide();
            }
          });

        }, doneTypingInterval);

      } else if (query.length == 0) {

        resultsContainer.hide();
        searchedContainer.show();

      }
    });

    $(document).on("click", ".tf-text-clear", function (e) {
      e.preventDefault();
      $(".ajax-search-input:visible").val("").trigger("input");
    });

    $(document).on("blur input change", ".ajax-search-input:visible", function (e) {
      e.preventDefault();
      $(".ajax-search-input:hidden").val($(this).val());
      if ($(this).val()) {
        $(".clear-search-text").show();
      } else {
        $(".clear-search-text").hide();
      }
    });

    $(document).on('change', '.form_search-product:visible .dropdown_product_cat', function () {

      $(".form_search-product:hidden .select-options li[rel='" + $(this).val() + "']").trigger("click");
      $(".form_search-product:hidden .dropdown_product_cat").val($(this).val()).change();

      $(".ajax-search-input:visible").trigger('input');
    });

    $(".form-search").on("submit", function (e) {
      e.preventDefault();

      let query = $(".ajax-search-input:visible").val().trim();

      if (query.length >= 2) {

        let currentPath = window.location.pathname;
        let subFolder = currentPath.split('/')[1] || '';

        let searchUrl = (subFolder ? "/" + subFolder : "") + "/?s=" + encodeURIComponent(query);

        if (subFolder === '') {
          searchUrl = window.location.origin + searchUrl;
        }

        window.location.href = searchUrl;
      }
    });

    $(document).on('click', 'header .ajax-search-input, .tf-mobile-search-btn', function (e) {
      e.preventDefault();

      if (!$offcanvasSearchEl.hasClass('show')) {
        // new bootstrap.Offcanvas($offcanvasSearchEl.get(0)).show();
        bootstrap.Offcanvas.getOrCreateInstance($offcanvasSearchEl.get(0)).show();
      }

    });

    $(document).on('click', '.tf-close-search-popup', function (e) {
      e.preventDefault();

      if ($offcanvasSearchEl.hasClass('show')) {
        bootstrap.Offcanvas.getOrCreateInstance($offcanvasSearchEl.get(0)).hide();
      }

    });

    var scrollPosition = 0;

    $offcanvasSearchEl.on('show.bs.offcanvas', function () {
      $('html,body').addClass('tf-scroll-lock');
      $('.tf-close-search-popup').addClass('show-close');
    });

    $offcanvasSearchEl.on('hide.bs.offcanvas', function () {
      $('html,body').removeClass('tf-scroll-lock');
      $('.tf-close-search-popup').removeClass('show-close');
    });

    return;

    // Search header
    let searchInputHeader = $(".ajax-search-input-header");
    let resultsHeaderContainer = $(".search-suggests-results .search-suggests-results-inner ul");
    let searchHeaderButton = searchInputHeader.closest(".form-search").find(".btn-search i");
    let searchformButton = searchInputHeader.closest(".tf-form-search");

    let searchCacheHeader = JSON.parse(sessionStorage.getItem("searchCacheHeader")) || {};
    let doneTypingIntervalHeader = 500;

    searchInputHeader.on("input", function () {
      clearTimeout(typingTimer);
      let query = $(this).val().trim();

      if (query.length >= 2) {
        searchformButton.addClass('active');
        let category = $(".search-category-select").val();
        typingTimer = setTimeout(function () {
          if (searchCacheHeader[query]) {
            resultsHeaderContainer.html(searchCacheHeader[query]);
            return;
          }

          $.ajax({
            type: "POST",
            url: tfwc_woo_params.ajax_url,
            data: {
              action: "tfwc_search_products_header",
              query: query,
              category: category,
              nonce: tfwc_woo_params.nonce,
            },
            beforeSend: function () {
              resultsHeaderContainer.addClass('loading-content');
            },
            success: function (response) {
              if (response.success) {
                resultsHeaderContainer.html(response.data);
                searchCacheHeader[query] = response.data;
                sessionStorage.setItem("searchCacheHeader", JSON.stringify(searchCacheHeader));
                swiper_slider();
                // quickview_product();
                // countDown();
                swatchColor();
                // compare();
                resultsHeaderContainer.removeClass('loading-content');
              } else {
                resultsHeaderContainer.html('<div class="no-results">No product found</div>');
                resultsHeaderContainer.removeClass('loading-content');
              }

            },
            error: function () {
              resultsHeaderContainer.html('<div class="error">Error!</div>');
              resultsHeaderContainer.removeClass('loading-content');
            }
          });
        }, doneTypingIntervalHeader);
      } else {
        // resultsContainer.html("");
      }
    });

    $(document).on("click", function (e) {
      if (!$(e.target).closest(".tf-form-search").length) {
        searchformButton.removeClass('active');
      }
    });

    $(".tf-form-search").on("submit", function (e) {
      e.preventDefault();

      let query = $(".ajax-search-input-header").val().trim();
      let category = $(".search-category-select").val();

      if (query.length >= 2) {

        let currentPath = window.location.pathname;
        let subFolder = currentPath.split('/')[1] || '';

        let searchUrl = (subFolder ? "/" + subFolder : "") + "/?s=" + encodeURIComponent(query) + "&post_type=product";

        if (category) {
          searchUrl += "&product_cat=" + encodeURIComponent(category);
        }

        if (subFolder === '') {
          searchUrl = window.location.origin + searchUrl;
        }

        window.location.href = searchUrl;
      }
    });
  };

  var remove_item = function () {
    $(document).on('click', '.remove_from_cart_button', function (e) {
      e.preventDefault();

      var $this = $(this),
        cart_item_key = $this.data('cart_item_key');
      var $cart_item = $this.closest('.mini_cart_item');

      $cart_item.addClass('loading-content');

      var data = {
        action: 'remove_cart_item',
        cart_item_key: cart_item_key,
        nonce: tfwc_woo_params.nonce,
      };
      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: 'POST',
        data: data,
        success: function (response) {
          if (response.fragments) {
            $.each(response.fragments, function (fragment, content) {
              $(fragment).replaceWith(content);
            });

            $(document.body).trigger('wc_fragments_refreshed');
            tf_swiper_slider();
          }

          $cart_item.removeClass('loading-content');
        },
        error: function () {
          $cart_item.removeClass('loading-content');
        }
      });
    })
  }

  var update_cart = function () {
    $(document.body).on('updated_wc_div', function () {
      $.ajax({
        url: wc_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
        type: 'POST',
        success: function (response) {
          if (response.fragments) {
            $.each(response.fragments, function (fragment, content) {
              $(fragment).replaceWith(content);
            });
          }
          tf_swiper_slider();
        }
      });
    });
  }

  var handleProgress = function () {
    function handleProgressBar(showEvent, hideEvent, target) {
      $(".tf-progress-bar .value").css("width", "0%");
      $(target).on(hideEvent, function () {
        $(".tf-progress-bar .value").css("width", "0%");
      });

      $(target).on(showEvent, function () {
        setTimeout(function () {
          var progressValue = $(".tf-progress-bar .value").data("progress");
          $(".tf-progress-bar .value").css("width", progressValue + "%");
        }, 600);
      });
    }

    if ($(".popup-shopping-cart").length > 0) {
      handleProgressBar("show.bs.offcanvas", "hidden.bs.offcanvas", ".popup-shopping-cart");
    }

    if ($(".modal-shopping-cart").length > 0) {
      handleProgressBar("show.bs.modal", "hidden.bs.modal", ".modal-shopping-cart");
    }
  };

  var clickMinicartPopup = function () {
    // $(document).on("click", ".btn-quickview", function () {
    //   $("#quickView").modal("show");
    // });

    $(document).on("click", ".btn-addtocart,.nav-cart a", function () {
      // tf_swiper_slider();
    });

    $(document).on("click", ".btn-add-gift", function () {
      $('.tf-mini-cart-tool-openable').removeClass('open');
      $(".add-gift").addClass("open");
    });

    $(document).on("click", ".btn-add-note", function () {
      $('.tf-mini-cart-tool-openable').removeClass('open');
      $(".add-note").addClass("open");
    });

    $(document).on("click", ".btn-coupon", function () {
      $('.tf-mini-cart-tool-openable').removeClass('open');
      $(".coupon").addClass("open");
    });

    $(document).on("click", ".btn-estimate-shipping", function () {
      $('.tf-mini-cart-tool-openable').removeClass('open');
      $(".estimate-shipping").addClass("open");
    });

    $(document).on("click", ".tf-mini-cart-tool-close", function () {
      $(".tf-mini-cart-tool-openable").removeClass("open");
      $('.shipping-calculator-form').hide().removeClass('open');
    });
  };

  var save_order_note = function () {
    let noteForm = $(".add-note .tf-mini-cart-tool-content");

    if (noteForm.length == 0) {
      return;
    }

    $(document).on("submit", '.add-note .tf-mini-cart-tool-content', function (e) {
      e.preventDefault();

      let notice = $('.notice-order-note');
      notice.html('');
      let noteTextarea = $("#Cart-note");
      var note = noteTextarea.val();

      if (note != '') {
        $.ajax({
          url: tfwc_woo_params.ajax_url,
          type: "POST",
          data: {
            action: "save_order_note",
            order_comments: noteTextarea.val(),
            nonce: tfwc_woo_params.nonce,
          },
          beforeSend: function () {
            // notice.html('');
            $('.add-note .subscribe-button').addClass('loading');
          },
          success: function (response) {
            if (response.success) {
              $('.add-note .subscribe-button').removeClass('loading');
              notice.html(
  tfwcTranslate('note_saved', 'Saved successfully!')
);

              setTimeout(() => {
                $(".tf-mini-cart-tool-openable").removeClass("open");
              }, 300);

            }
          },
        });
      } else {
       notice.html(
  tfwcTranslate('note_required', 'Please enter a note.')
);
      }

    });

  };

  var ovinxSwiper = function ($container = null) {

    if (!$container) {
      $container = document;
    }

    $(".ovinx-swiper", $container).each(function (index, element) {

      var $this = $(element);

      // if ($this.find('.swiper-wrapper').children().length < 2) {
      //   return;
      // }

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

      let configs = {
        direction: direction,
        speed: speed,
        slidesPerView: mobile,
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
            slidesPerView: mobileSm,
            spaceBetween: spacing,
            slidesPerGroup: perGroupSm,
          },
          768: {
            slidesPerView: tablet,
            spaceBetween: spacingMd,
            slidesPerGroup: perGroupMd,
          },
          1200: {
            slidesPerView: preview,
            spaceBetween: spacingLg,
            slidesPerGroup: perGroupLg,
          },
        },
      };

      var swiperT = new Swiper($this[0], configs);

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

  var updateCart = function () {
    let isLoading = false;

    $(document).on('change', '.woocommerce-cart-form .tf-add-gift, .woocommerce-cart-form .order-comments', function () {
      $('.tf-update-cart-btn').prop('disabled', false);
    });

    $(document).on('click', '.tf-update-cart-btn', function () {
      return;

      if (isLoading) {
        return;
      }

      let isAdding = $('.woocommerce-cart-form .tf-add-gift').prop('checked');

      let noteContent = $('.woocommerce-cart-form .order-comments').val();

      // Gift
      $.ajax({
        type: 'POST',
        url: tfwc_woo_params.ajax_url,
        data: {
          action: isAdding ? 'tfwc_apply_gift' : 'tfwc_remove_gift',
          nonce: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          isLoading = true;
        },
        success: function (response) {

        },
        error: function (xhr, status, error) {
          console.error("Error AJAX:", error);
        }
        ,
        complete: function () {
          isLoading = false;
        }
      });

      // Note
      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: "POST",
        data: {
          action: "save_order_note",
          order_comments: noteContent,
          nonce: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          isLoading = true;
        },
        success: function (response) {
        },
        complete: function () {
          isLoading = false;
        }
      });

    });
  };

  var save_coupon = function () {
    $(document).on('submit', '.coupon .tf-mini-cart-tool-content', function (e) {
      e.preventDefault();

      var coupon_code = $('input[name="tfwc_coupon_code"]').val();
      $('.notice-coupon').html("");
      if (coupon_code != '') {
        $.ajax({
          url: tfwc_woo_params.ajax_url,
          method: 'POST',
          data: {
            action: 'apply_coupon',
            coupon_code: coupon_code,
            nonce: tfwc_woo_params.nonce,
          },
          beforeSend: function () {
            $('.coupon .subscribe-button').addClass('loading');
          },
          success: function (response) {

            if (response.success) {
              $('.notice-coupon').html(response.data.message);
              if (!response.data.minicart_totals || response.data.minicart_totals.trim() !== "") {
                $('.tfwc-minicart-totals').html(response.data.minicart_totals);
              }
              setTimeout(() => {
                $(".tf-mini-cart-tool-openable").removeClass("open");
              }, 300);

            } else {
              $('.notice-coupon').html(response.data.message);
            }

            $('.coupon .subscribe-button').removeClass('loading');
          },
          error: function () {
            $('.notice-coupon').html(
  tfwcTranslate(
    'coupon_error',
    'An error occurred. Please try again.'
  )
);
            $('.coupon .subscribe-button').removeClass('loading');
          }
        });
      } else {
        $('.notice-coupon').html(
  tfwcTranslate(
    'coupon_required',
    'Please enter a coupon code.'
  )
);
      }
    });

  }

  var delete_coupon = function () {
    $(document).on('click', '.woocommerce-remove-coupon', function (e) {
      e.preventDefault();

      var coupon_code = $(this).data('coupon');

      $.ajax({
        url: tfwc_woo_params.ajax_url,
        method: 'POST',
        data: {
          action: 'tfwc_remove_coupon',
          coupon_code: coupon_code,
          nonce: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          $('.tfwc-minicart-totals').addClass('loading-content');
        },
        success: function (response) {
          if (response.success) {
            if (!response.data.minicart_totals || response.data.minicart_totals.trim() !== "") {
              $('.tfwc-minicart-totals').html(response.data.minicart_totals);
            }
            $('.tfwc-minicart-totals').removeClass('loading-content');
          }
        },
        error: function () {
          console.log('Error.');
        }
      });
    });
  }

  var save_shipping = function () {

    $(document).on('click', '.tf-mini-cart-wrap .shipping-calculator-button', function (e) {
      if ($('.tf-mini-cart-wrap .shipping-calculator-form').is('visible')) {
        $('.tf-mini-cart-wrap .shipping-calculator-form').hide().removeClass('open');
      } else {
        $('.tf-mini-cart-wrap .shipping-calculator-form').show().addClass('open');
      }
    });

    $(document).on('change', '#calc_shipping_state, #billing_state, #shipping_state', function (e) {
      $(document.body).trigger('country_to_state_changed');
    });

    $(document).on('click', '#shipping-form .subscribe-button, .shipping-est-btn', function (e) {
      e.preventDefault();
      var $button = $(this);
      var country = $('#calc_shipping_country').val();
      var state = $('#calc_shipping_state').val();
      var city = $('#calc_shipping_city').val();
      var postcode = $('#calc_shipping_postcode').val();
      $('.notice-shipping').html('');

      $.ajax({
        url: tfwc_woo_params.ajax_url,
        type: 'POST',
        data: {
          action: 'tfwc_save_shipping',
          country: country,
          state: state,
          city: city,
          postcode: postcode,
          nonce: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          $button.addClass('loading');
        },
        success: function (response) {
          if (response.success) {
            $button.removeClass('loading');
            $('.notice-shipping').html(
  tfwcTranslate(
    'shipping_updated',
    'Shipping information has been updated successfully.'
  )
);

            setTimeout(() => {
              $(".tf-mini-cart-tool-openable").removeClass("open");
              $(document.body).trigger('wc_fragment_refresh');
            }, 300);

          } else {
            $button.removeClass('loading');
            $('.notice-shipping').html(
  tfwcTranslate(
    'shipping_update_error',
    'There was an error updating the shipping information.'
  )
);

          }
        },
        error: function () {
         $('.notice-shipping').html(
  tfwcTranslate(
    'shipping_process_error',
    'An error occurred while processing the shipping information.'
  )
);
        }
      });
    });

  }

  var save_gift = function () {
    $(document).on('submit', '.add-gift .tf-mini-cart-tool-content', function (e) {
      e.preventDefault();

      let $form = $(this);
      let $button = $form.find('button[type="submit"]');
      let $notice = $('.notice-gift');
      let isAdding = $button.data('action') === 'add';
      $notice.text('').hide();

      $.ajax({
        type: 'POST',
        url: tfwc_woo_params.ajax_url,
        data: {
          action: 'tfwc_apply_gift',
          nonce: tfwc_woo_params.nonce,
        },
        beforeSend: function () {
          $button.addClass('loading');
        },
        success: function (response) {
          if (isAdding) {
            $button.removeClass('loading');
            $button
  .text(tfwcTranslate('remove', 'Remove'))
  .data('action', 'remove');
           $notice.text(
  tfwcTranslate(
    'gift_added',
    'Gift saved successfully! Please view the cart or checkout to check.'
  )
).show();

          } else {
            $button.removeClass('loading');
            $button
  .text(tfwcTranslate('add_gift_wrap', 'Add a Gift Wrap'))
  .data('action', 'add');
$notice.text(
  tfwcTranslate(
    'gift_removed',
    'Gift removed successfully! Please view the cart or checkout to check.'
  )
).show();
          }

          $(document.body).trigger('wc_fragment_refresh');
        },
        error: function (xhr, status, error) {
          console.error("Error AJAX:", error);
          $notice.text(
  tfwcTranslate(
    'coupon_error',
    'An error occurred. Please try again.'
  )
).show();
        }
      });
    });
  };

  var tf_swiper_slider = function () {
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



  var checkoutTerms = function () {
    $(document).on('click', '.checkout-btn', function (e) {
      if ($('#minicart-agree-term').length && !$('#minicart-agree-term').prop('checked')) {
        e.preventDefault();
        window.tfwcNotify(tfwc_woo_params?.trans_text?.term_required || 'Please agree to the Terms and Conditions before continuing');
        return false;
      }

      if ($('.checkout-cart-box #agree-term').length && !$('.checkout-cart-box #agree-term').prop('checked')) {
        e.preventDefault();
        window.tfwcNotify(tfwc_woo_params?.trans_text?.term_required || 'Please agree to the Terms and Conditions before continuing');
        return false;
      }

    });
  };

function fetchLiveSales() {
  if (
    typeof tfwc_woo_params === 'undefined' ||
    Number(tfwc_woo_params.live_notification) !== 1
  ) {
    return;
  }

  const $container = $('#live-sales-container');

  if (!$container.length) {
    return;
  }

  const namespace = '.tfwcLiveSales';

  const visibleTime = Math.max(
    parseInt(tfwc_woo_params.live_timeout, 10) || 5000,
    500
  );

  const intervalTime = Math.max(
    parseInt(tfwc_woo_params.live_interval, 10) || 10000,
    1000
  );

  /*
   * live_interval là khoảng cách giữa hai lần bắt đầu hiển thị.
   * Ví dụ:
   * live_interval = 10000
   * live_timeout  = 6000
   * => popup ẩn 4000ms trước khi hiện sản phẩm tiếp theo.
   */
  const hiddenTime = Math.max(intervalTime - visibleTime, 0);
  const transitionTime = 400;

  let products = [];
  let currentIndex = 0;
  let showTimer = null;
  let hideTimer = null;
  let removeTimer = null;
  let request = null;
  let stopped = false;
  let hovering = false;

  /*
   * Nếu function bị gọi lại thì hủy instance trước,
   * tránh AJAX, timer và event bị đăng ký nhiều lần.
   */
  const oldInstance = $container.data('tfwcLiveSalesInstance');

  if (oldInstance && typeof oldInstance.destroy === 'function') {
    oldInstance.destroy();
  }

  function clearTimers() {
    clearTimeout(showTimer);
    clearTimeout(hideTimer);
    clearTimeout(removeTimer);

    showTimer = null;
    hideTimer = null;
    removeTimer = null;
  }

  function scheduleNext(delay) {
    if (stopped || !products.length) {
      return;
    }

    clearTimeout(showTimer);

    showTimer = setTimeout(function () {
      showNextProduct();
    }, Math.max(delay, 0));
  }

  function hideCurrentPopup() {
    if (stopped || hovering) {
      return;
    }

    const $popup = $container.find('.pop-notice-sale');

    if (!$popup.length) {
      scheduleNext(hiddenTime);
      return;
    }

    $popup
      .removeClass('active')
      .attr('aria-hidden', 'true');

    removeTimer = setTimeout(function () {
      if (stopped || hovering) {
        return;
      }

      $container.empty();
      scheduleNext(hiddenTime);
    }, transitionTime);
  }

  function scheduleHide() {
    clearTimeout(hideTimer);

    hideTimer = setTimeout(function () {
      hideCurrentPopup();
    }, visibleTime);
  }

  function showNextProduct() {
    if (stopped || !products.length) {
      return;
    }

    clearTimers();

    const product = products[currentIndex];

    currentIndex = (currentIndex + 1) % products.length;

    if (!product || !product.product_html) {
      scheduleNext(hiddenTime);
      return;
    }

    $container.html(product.product_html);

    const $popup = $container.find('.pop-notice-sale');

    if (!$popup.length) {
      scheduleNext(hiddenTime);
      return;
    }

    /*
     * Buộc trình duyệt nhận trạng thái chưa active,
     * sau đó mới thêm active để transition chạy.
     */
    $popup[0].offsetWidth;

    requestAnimationFrame(function () {
      if (stopped) {
        return;
      }

      $popup
        .addClass('active')
        .attr('aria-hidden', 'false');

      scheduleHide();
    });
  }

  function stopNotifications() {
    stopped = true;
    hovering = false;

    clearTimers();

    if (request && request.readyState !== 4) {
      request.abort();
    }

    $(document).off(namespace);

    const $popup = $container.find('.pop-notice-sale');

    $popup
      .removeClass('active')
      .attr('aria-hidden', 'true');

    setTimeout(function () {
      $container.empty();
    }, transitionTime);
  }

  $container.data('tfwcLiveSalesInstance', {
    destroy: function () {
      stopNotifications();
      $container.removeData('tfwcLiveSalesInstance');
    },
  });

  $(document)
    .off(namespace)

    /*
     * Đóng popup và ngừng toàn bộ notification
     * cho đến khi tải lại trang.
     */
    .on('click' + namespace, '.btn-cl-pop', function (event) {
      event.preventDefault();
      stopNotifications();
    })

    /*
     * Hover vào popup sẽ tạm ngừng tự động ẩn.
     */
    .on('mouseenter' + namespace, '.pop-notice-sale', function () {
      hovering = true;

      clearTimeout(hideTimer);
      hideTimer = null;
    })

    /*
     * Rời chuột thì bắt đầu đếm lại thời gian hiển thị.
     */
    .on('mouseleave' + namespace, '.pop-notice-sale', function () {
      hovering = false;

      if (!stopped && $(this).hasClass('active')) {
        scheduleHide();
      }
    });

  request = $.ajax({
    url: tfwc_woo_params.ajax_url,
    type: 'POST',
    dataType: 'json',
    data: {
      action: 'tfwc_live_notification',
      nonce: tfwc_woo_params.nonce,
    },
  })
    .done(function (response) {
      if (
        !response.success ||
        !Array.isArray(response.data) ||
        !response.data.length
      ) {
        console.log('No live notification data returned.');
        return;
      }

      products = response.data.filter(function (item) {
        return item && item.product_html;
      });

      if (!products.length) {
        return;
      }

      /*
       * Giữ cách hoạt động cũ:
       * popup đầu tiên xuất hiện sau live_interval.
       */
      scheduleNext(intervalTime);
    })
    .fail(function (xhr, status, error) {
      if (status !== 'abort') {
        console.log('AJAX Error: ' + error);
      }
    });
}

  /* Auto Popup
  ------------------------------------------------------------------------------------- */
  var autoPopup = function () {
    $(".auto-popup").each(function (index) {
      let $popup = $(this);
      let timeout = parseInt($popup.data("timeout")) || 3000;

      let popupId = $popup.attr("id") || "popup_" + index;
      let pageKey = "showPopup_" + popupId + "_" + window.location.pathname;
      let showPopup = sessionStorage.getItem(pageKey);

      if (!JSON.parse(showPopup)) {
        setTimeout(function () {
          $(".auto-popup").modal("hide");
          $popup.modal("show");
        }, timeout);
      }

      $popup.find(".btn-hide-popup").on("click", function () {
        sessionStorage.setItem(pageKey, true);
      });
    });
  };

  var cookieSetting = function () {

    $(".cookie-banner .overplay").on("click", function () {
      $(".cookie-banner").hide();
    });

    function setCookie(name, value, days) {
      const date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
    }

    function getCookie(name) {
      const nameEQ = name + "=";
      const cookies = document.cookie.split(";");

      for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.indexOf(nameEQ) === 0) {
          return cookie.substring(nameEQ.length);
        }
      }
      return null;
    }

    function checkCookie() {
      const $cookieBanner = $("#cookie-banner");
      const accepted = getCookie("cookieAccepted");

      if (accepted) {
        $cookieBanner.hide();
      } else {
        $cookieBanner.show();
      }
    }

    $("#accept-cookie").on("click", function () {
      setCookie("cookieAccepted", "true", 30);
      $("#cookie-banner").hide();
    });

    checkCookie();
  };

  var posNavSwiper = function () {
    $(".wrap-pos-nav").each(function () {
      var imageBlog = $(this).find(".blog-item-v2 .entry-image");
      if (imageBlog.length) {
        var contentHeight = $(this).find(".blog-item-v2 .entry-content").outerHeight();
        var newTop = `calc(50% - ${contentHeight / 2}px)`;
        $(this).find(".nav-swiper").css("top", newTop);
      }
      var imageProduct = $(this).find(".card-product .card-product-wrapper");
      if (imageProduct.length) {
        var contentHeight = $(this).find(".card-product .product-img").outerHeight();
        var newTop = `calc(${contentHeight / 2}px)`;
        $(this).find(".nav-swiper").css("top", newTop);
      }
    });
  }

  function scrollToTopWithOffset(elementId, offset) {
    const element = document.getElementById(elementId);

    if (element) {
      const rect = element.getBoundingClientRect();
      const scrollTop = window.scrollY + rect.top - offset;

      window.scrollTo({
        top: scrollTop,
        behavior: 'smooth'
      });
    }
  }

  function scrollToElementWithOffset($element, offset) {

    if (!$element?.length) {
      return;
    }

    const element = $element.get(0);

    if (element) {
      const rect = element.getBoundingClientRect();
      const scrollTop = window.scrollY + rect.top - offset;

      window.scrollTo({
        top: scrollTop,
        behavior: 'smooth'
      });
    }
  }

  var minicart = function () {
    if (typeof wc_cart_fragments_params !== 'undefined') {
      $(document.body).trigger('wc_fragment_refresh');
    }
  };

  var handleSidebarFilter = function () {
    /**
     * `.tf-btn-filter` (the real "Show Filters" toolbar button, `data-bs-toggle="offcanvas"
     * href="#filterShop"`) already opens `#filterShop` natively via Bootstrap — no JS needed. This
     * handler used to ALSO add `.show` to `.sidebar-filter`/`.overlay-filter` (the sidebar-left/right
     * layout's separate desktop-column filter panel, `.filters-content .canvas-sidebar` in
     * archive-product.php) on every `.tf-btn-filter` click, opening BOTH panels stacked at once —
     * reported by user. That panel has no real trigger of its own otherwise (confirmed: no
     * `.close-filter` button is ever rendered, and below 1200px it's `.filters-content`'s only job
     * to be hidden off-screen, with `#filterShop` as the real mobile filter drawer) — removed
     * rather than re-targeted, since `#filterShop` already covers the exact same content/job.
     */
    $(".close-filter,.overlay-filter").on("click", function () {
      $(".sidebar-filter,.overlay-filter").removeClass("show");
    });

    var metaSticky = function () {

      if ($(".meta-wrap-sticky").length == 0) {
        return;
      }

      let $header = $(".tf-header.header-default:visible");

      let adminbarHeight = $("#wpadminbar:visible").outerHeight() || 0;
      let headerHeight = $header.outerHeight() || 0;
      let headerRect = $header[0]?.getBoundingClientRect();
      let headerTop = headerRect ? headerRect.top : 0;
      let offsetFix = Math.min(headerTop, 0);

      let realHeaderOffset = headerHeight;

      if ($header.hasClass('header-sticky')) {
        realHeaderOffset += offsetFix;
      }

      if ($(window).width() <= 600) {
        $(".content-woocommerce").css({
          // '--meta-wrap-sticky-top': `${realHeaderOffset - 5}px`
          '--meta-wrap-sticky-top': `${realHeaderOffset}px`
        });
      } else {
        $(".content-woocommerce").css({
          // '--meta-wrap-sticky-top': `${adminbarHeight + realHeaderOffset - 5}px`
          '--meta-wrap-sticky-top': `${adminbarHeight + realHeaderOffset}px`
        });
      }

    }

    $(window).on('load resize scroll', function () {
      metaSticky();
    });

    // $(window).on('load resize', function () {
    //   metaSticky();
    // });

    $(document).on("header:sticky_applied", function () {
      metaSticky();
    });

    metaSticky();
  };

  var commentform_product = function () {
    $('#commentform').on('submit', function (e) {
      e.preventDefault();
      HTMLFormElement.prototype.submit.call(this);
    });
  };

  var ovinxSaleMarquee = function () {
    if ($(".ovinx-marquee-sale").length > 0) {

      $(".ovinx-marquee-sale").each(function () {
        var $this = $(this);

        var style = $this.data("style") || "left";
        var clone = $this.data("clone") || 2;
        var speed = $this.data("speed") || 50;

        if ($this.hasClass("marquee-initialized")) {
          return;
        }

        $this.infiniteslide({
          speed: speed,
          direction: style,
          clone: clone,
        });

        $this.addClass("marquee-initialized");

      });
    }
  };

  var clearMiniCart = function () {
    $(document).on('click', '.tf-clear-cart-btn', function (e) {
      e.preventDefault();

      $.ajax({
        url: tfwc_woo_params.ajax_url || '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
          action: 'tfwc_clear_cart',
          nonce: tfwc_woo_params.nonce
        },
        success: function (response) {
          $(document.body).trigger('wc_fragment_refresh');
        },
        error: function (e) {
          console.log(e?.getMessage());
        }
      });
    });
  };

  var shippingSlider = function () {
    $(document.body).on("wc_fragments_refreshed", function () {
      var progressValue = $(".tf-progress-bar .value").data("progress");
      setTimeout(function () {
        $(".tf-progress-bar .value").css("width", progressValue + "%");
      }, 100)
    });

    var progressValue = $(".tf-progress-bar .value").data("progress");
    setTimeout(function () {
      $(".tf-progress-bar .value").css("width", progressValue + "%");
    }, 100)
  };

  var ovinxTooltip = function () {

    let $tooltip = null;

    function showTooltip($item, pos = 'bottom') {
      const $origin = $item.find('.tooltip');
      if (!$origin.length) return;

      if ($tooltip) {
        $tooltip.remove();
        $tooltip = null;
      }

      $tooltip = $origin.clone().appendTo('body');

      const rect = $item[0].getBoundingClientRect();

      if (pos == 'bottom') {
        $tooltip.addClass('ovinx-tooltip-fixed pos-bottom tooltip-bottom');

        $tooltip.css({
          top: rect.bottom + 8 + 'px',
          left: rect.left + rect.width / 2 + 'px',
          pointerEvents: 'none'
        });

      }

      if (pos == 'top') {
        $tooltip.addClass('ovinx-tooltip-fixed pos-top');

        $tooltip.css({
          top: rect.top - 10 + 'px',
          left: rect.left + rect.width / 2 + 'px',
          pointerEvents: 'none'

        });

      }
    }

    function setTooltip(text) {
      if ($tooltip) {
        $tooltip.text(text);
      }
    }

    function hideTooltip() {
      if ($tooltip) {
        $tooltip.remove();
        $tooltip = null;
      }
    }

    $(document.body)
      .on('mouseenter click', '.ovinx-swiper .product-color_list > .hover-tooltip, .ovinx-has-fixed-tooltip .product-color_list > .hover-tooltip', function (e) {
        if (!e.originalEvent) return;
        showTooltip($(this));
      })
      .on('mouseenter click', '.nav-post-list .hover-tooltip', function () {
        showTooltip($(this), 'top');
      })
      .on('mouseenter', '.tf-single-product .wcboost-wishlist-button.hover-tooltip', function () {
        showTooltip($(this), 'top');
      })
      .on('mouseleave', '.ovinx-swiper .product-color_list > .hover-tooltip, .ovinx-has-fixed-tooltip .product-color_list > .hover-tooltip, .nav-post-list .hover-tooltip,.tf-single-product .wcboost-wishlist-button.hover-tooltip', function () {
        hideTooltip();
      });

    $(window).on('scroll', function () {
      hideTooltip();
    });

    $(document.body).on('ovinx.show_tooltip', function (e, $button, pos = 'bottom') {
      showTooltip($button, pos);
    });

    $(document.body).on('ovinx.set_tooltip', function (e, text) {
      setTooltip(text);
    });

    $(document.body).on('ovinx.hide_tooltip', function () {
      hideTooltip();
    });

  };

  var numberFormat = function (amount) {
    if (!tfwc_woo_params?.currency_settings) {
      return amount;
    }

    const {
      currency_symbol: symbol,
      currency_position: position,
      thousand_separator: thousandSep,
      decimal_separator: decimalSep,
      decimal_count: decimals
    } = tfwc_woo_params?.currency_settings;

    let [intPart, decPart] = Number(amount).toFixed(decimals).split(".");
    intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSep);
    const formatted = decPart ? `${intPart}${decimalSep}${decPart}` : intPart;

    switch (position) {
      case "left": return symbol + formatted;
      case "right": return formatted + symbol;
      case "left_space": return symbol + " " + formatted;
      case "right_space": return formatted + " " + symbol;
      default: return formatted;
    }
  };

  var openCartFromToast = function () {
    $(document).on('click', 'a.button', function (e) {

      const href = $(this).attr('href') || '';

      if (href.includes('/cart')) {
        e.preventDefault();
        if (!$(".popup-shopping-cart.show:visible").length) showMiniCart();
        return false;
      }
    });

  };

  var buttonLoading = () => {
    $(document).on('click', 'tf-btn.has-loading', function () {
      if (!$(this).hasClass('loading')) {
        $(this).addClass('loading');
      }
    });
  };

  // Dom Ready
  $(function () {
    swatchColor();
    refreshMinicart();
    wishlist();
    compare();
    countDown();
    quantity_input();
    listCardButtonQuantity();
    quickview_product();
    quickShop();
    swLayoutShop();
    changeValueDropdown();
    toogle_categry();
    rangeTwoPrice();
    filter_product();
    ajax_search();
    remove_item();
    handleProgress();
    // update_cart();
    clickMinicartPopup();
    openCartFromToast();
    save_order_note();
    save_coupon();
    save_shipping();
    save_gift();
    fetchLiveSales();
    checkoutTerms();
    autoPopup();
    cookieSetting();
    posNavSwiper();
    delete_coupon();
    remove_wishlist();
    minicart();
    shopAddedToCart();
    productShare();
    updateCart();
    clearMiniCart();
    shippingSlider();
    handleSidebarFilter();
    commentform_product();
    ovinxSaleMarquee();
    updateTotalCount();
    ovinxTooltip();
  })
})(jQuery);
