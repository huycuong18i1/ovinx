(function ($) {
    "use strict";

    // QA P3-03: non-blocking replacement for alert() (same helper as shop.js; jquery.toast is a dependency of this script).
    window.tfwcNotify = window.tfwcNotify || function (message, icon) {
        if ($.toast) {
            $.toast({ text: message, icon: icon || 'warning', position: 'top-center', showHideTransition: 'slide', hideAfter: 4000 });
        } else {
            console.warn(message);
        }
    };

    var loaded = false;
    var init = function () {
        peopleView();
        handleProgress();
        // addToCart();
        compareProduct();
        copyText();
        discountItems();
        addToCartWithPriceText();
        addToCartCheckAvailable();
        scrollBottomSticky();
        stickyAddToCart();
        productTogether();
        buyXGetY();
        gallery();
        // scrollGridProduct();
        writeReviewToggle();
        writeReviewRating();
        commentActive();
        loaded = true;
    };

    var handleProgress = function () {
        if ($(".product-info-progress-sale").length > 0) {
            var progressValue = $(".product-info-progress-sale .value").data("progress");
            setTimeout(function () {
                $(".product-info-progress-sale .value").css("width", progressValue + "%");
            }, 800);
        }
    };

    var peopleView = function () {
        if (typeof peopleViewData == 'undefined') {
            return;
        }
        let viewCount = $(".view-count"),
            randomFrom = parseInt(peopleViewData?.randomFrom),
            randomTo = parseInt(peopleViewData?.randomTo),
            interval = parseInt(peopleViewData?.interval);
        setInterval(function () {
            var count = Math.floor(Math.random() * (randomTo - randomFrom + 1)) + randomFrom;
            viewCount.text(count);
        }, interval);
    };

    var buyNow = function () {
        if (!tfWooParams?.buy_now) {
            return;
        }

        $(document).on('click', '.tf-buy-now-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');

            if ($(this).hasClass('disabled')) {
                return;
            }

            if ($form.hasClass('variations_form') && !($('.variation_id', $form).val() > 0)) {
                window.tfwcNotify('Please select some product options before buy this product.');
                return;
            }
            $('.button.single_add_to_cart_button', $form).trigger('click', true);
        });

    };

    var showMiniCart = function () {
        if ($(".popup-shopping-cart").length > 0) {
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('shoppingCart'));
            $('.modal-compare')?.modal('hide');
            $('.modal-quick-view')?.modal('hide');
            $('.modal-quick-add')?.modal('hide');
            offcanvas.show();
        }
    };

    var wishlist = function () {

        $(document).on('click', '.tf-wishlist-btn', function (e) {
            if (typeof wcboost_wishlist_params == 'undefined') {
                return;
            }
            e.preventDefault();
            let $btn = $(this);
            if ($btn.hasClass('added-wishlist')) {
                let removeUrl = $(this).data('remove-url');
                if (removeUrl) {
                    e.preventDefault();
                    removeUrl = new URLSearchParams(removeUrl);
                    var data = {
                        item_key: removeUrl.get("remove-wishlist-item"),
                        _wpnonce: removeUrl.get("_wpnonce")
                    };
                    if (!data.item_key) {
                        return
                    }
                    $.ajax({
                        url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "remove_wishlist_item"),
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            if (response.error) {
                                // console.error(response.error_message);
                            } else {
                                if (response?.success) {
                                    if ('yes' === wcboost_wishlist_params.allow_adding_variations) {

                                        var variations = $btn.data('variations');
                                        if (variations) {
                                            var found = variations.find(function (variation) {
                                                return variation.variation_id === $btn.data("product-id");
                                            });

                                            if (found) {
                                                found.added = 'no';
                                            }
                                        }
                                    }
                                    $btn.removeClass('added-wishlist');
                                    $btn.data('remove-url', '');
                                    $btn.attr('href', response?.data?.add_url ? response.data.add_url : `?add-to-wishlist=${$btn.data("product-id")}`);
                                    $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_add_to_wishlist);
                                    $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_normal);
                                    $(document.body)
                                        .trigger('removed_from_wishlist', [$btn, response?.data?.fragments])
                                        .trigger('wishlist_item_removed', [response?.data]);
                                }
                            }
                        },
                        complete: function () {
                        }
                    });
                }
            } else {
                e.preventDefault();
                let data = {
                    product_id: $btn.data("product-id"),
                    quantity: $btn.data("quantity")
                };

                if (!data.product_id) {

                    return;
                }
                $.ajax({
                    url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "add_to_wishlist"),
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        if (response?.success) {
                            if ('yes' === wcboost_wishlist_params.allow_adding_variations) {

                                var variations = $btn.data('variations');
                                if (variations) {
                                    var found = variations.find(function (variation) {
                                        return variation.variation_id === $btn.data("product-id");
                                    });

                                    if (found) {
                                        found.added = 'yes';
                                    }
                                }
                            }
                            $btn.addClass('added-wishlist');
                            switch (wcboost_wishlist_params.exists_item_behavior) {
                                case 'view_wishlist':
                                    $btn.attr('href', response?.data?.wishlist_url ? response.data.wishlist_url : wcboost_wishlist_params.wishlist_url);
                                    $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_view_wishlist);
                                    $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_filled);
                                    break;

                                case 'remove':
                                    $btn.attr('href', $btn.data("remove-url"));
                                    $btn.data('remove-url', response?.data?.remove_url);
                                    $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_remove_from_wishlist);
                                    $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_filled);
                                    break;

                                case 'hide':
                                    $btn.hide();
                                    break;
                            }
                            $(document.body)
                                .trigger('added_to_wishlist', [$btn, response?.data?.fragments])
                                .trigger('wishlist_item_added', [response?.data]);
                        }
                    },
                });
            }
        });

        if ('yes' === wcboost_wishlist_params.allow_adding_variations) {
            $('.tf-single-product .variations_form')
                .on('found_variation', function (event, data) {
                    var $btn = $(event.target).closest('.product').find('.tf-wishlist-btn');
                    var variations = $btn.data('variations');
                    $btn.data('product-id', data.variation_id);

                    if (variations) {
                        var found = variations.find(function (variation) {
                            return variation.variation_id === data.variation_id;
                        });

                        if (found) {
                            $btn.attr('href', found.add_url);
                            if (found.added === 'yes') {
                                $btn.addClass('added-wishlist');
                                switch (wcboost_wishlist_params.exists_item_behavior) {
                                    case 'view_wishlist':
                                        $btn.data('remove-url', '');
                                        $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_view_wishlist);
                                        $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_filled);
                                        break;

                                    case 'remove':
                                        $btn.data('remove-url', found.remove_url);
                                        $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_remove_from_wishlist);
                                        $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_filled);
                                        break;

                                    case 'hide':
                                        $btn.hide();
                                        break;
                                }
                            } else {
                                $btn.removeClass('added-wishlist');
                                $btn.data('remove-url', '');
                                $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_add_to_wishlist);
                                $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_normal);
                            }
                        }
                    }
                })
                .on('reset_data', function (event) {
                    var $btn = $(event.target).closest('.product').find('.tf-wishlist-btn');
                    var variations = $btn.data('variations');

                    if (variations) {
                        var parent = variations.find(function (variation) {
                            return variation.is_parent;
                        });

                        if (parent) {
                            $btn.data('product-id', parent.variation_id);
                            $btn.attr('href', parent.add_url);
                            if (parent.added === 'yes') {
                                $btn.addClass('added-wishlist');
                                switch (wcboost_wishlist_params.exists_item_behavior) {
                                    case 'view_wishlist':
                                        $btn.data('remove-url', '');
                                        $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_view_wishlist);
                                        $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_filled);
                                        break;

                                    case 'remove':
                                        $btn.data('remove-url', parent.remove_url);
                                        $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_remove_from_wishlist);
                                        $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_filled);
                                        break;

                                    case 'hide':
                                        $btn.hide();
                                        break;
                                }
                            } else {
                                $btn.removeClass('added-wishlist');
                                $btn.data('remove-url', '');
                                $('.tooltip', $btn).text(wcboost_wishlist_params.i18n_add_to_wishlist);
                                $('.wcboost-wishlist-button__icon', $btn).html(wcboost_wishlist_params.icon_normal);
                            }
                        }
                    }
                });
        }

        //Update status from storage

        $(document.body).on('wishlist_fragments_loaded', function () {
            if ($('.tf-wishlist-btn').data('remove-url')) {
                $('.wcboost-wishlist-button__icon', $('.tf-wishlist-btn')).html(wcboost_wishlist_params.icon_filled);
            };
        });

    };

    var compareProduct = function () {
        if (typeof wcboost_products_compare_params == 'undefined') {
            return;
        }
        $(document).on('click', '.tf-compare-btn', function (e) {
            e.preventDefault();
            let productID = $(this).data('product-id');
            if (productID) {
                $.ajax({
                    url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "add_to_compare"),
                    type: 'POST',
                    data: {
                        product_id: productID
                    },
                    beforeSend: function () {
                    },
                    success: function (response) {
                        if (response.error) {
                            // console.error(response.error_message);
                        } else {
                            if (response?.success) {
                                $(document.body)
                                    .trigger("wcboost_compare_item_added", [response.data])

                                if (response?.data?.compare_items?.length) {
                                    $('.modal-compare .count-item-compare').text(`(${response?.data?.compare_items?.length})`);
                                } else {
                                    $('.modal-compare .count-item-compare').text('');
                                }
                            } else {
                                $('.modal-compare').load(location.href + ' .modal-compare .modal-dialog', function () {
                                    if (response?.data?.compare_items?.length) {
                                        $('.modal-compare .count-item-compare').text(`(${response?.data?.compare_items?.length})`);
                                    } else {
                                        $('.modal-compare .count-item-compare').text('');
                                    }
                                    $('.modal-compare').last().modal('show');
                                });
                            }
                        }
                    },
                    complete: function () {
                    }
                });
            }
        });

        return;

        $('.modal-compare').on('click', '.tf-remove-compare', function (e) {
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
                    success: function (response) {
                        if (response.error) {
                            console.error(response.error_message);
                        } else {

                        }
                    },
                    complete: function () {
                        $('.modal-compare').load(location.href + ' .modal-compare .modal-dialog');
                    }
                });
            }
        });

        $('.modal-compare').on('click', '.tf-clear-compare', function (e) {
            e.preventDefault();
            let clearUrl = $(this).data('clear-url'),
                list_items = $('.tf-compare-item', $(this).closest('.modal-compare'));
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
                            // console.error(response.error_message);
                        } else {

                        }
                    },
                    complete: function () {
                        list_items.remove();
                    }
                });
            }
        });
    };

    var numberFormat = function (amount) {
        if (!tfWooParams?.currency_settings) {
            return amount;
        }

        const {
            currency_symbol: symbol,
            currency_position: position,
            thousand_separator: thousandSep,
            decimal_separator: decimalSep,
            decimal_count: decimals
        } = tfWooParams.currency_settings;

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

    var addToCartWithPriceText = function ($container = null) {

        if (!$container) {
            $container = $(document);
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
                        $badges.text("In Stock");
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

    var addToCartCheckAvailable = function () {
        $(document)
            .on('found_variation', '.tf-main-product .variations_form', function (event, data) {
                // $(event.target);

                const $form = $(this);
                const $btn = $form.find('.single_add_to_cart_button, .tf-buy-now-btn');
                const $qty = $form.find('input.qty');

                const realMax = parseInt(data.real_max_qty ?? data.max_qty ?? 0);
                const minQty = parseInt(data.min_qty ?? 1);

                let currentQty = parseInt($qty.val() || minQty);

                // $qty.attr('max', realMax);

                // if (!data.is_purchasable || !data.is_in_stock || realMax <= 0) {
                //     $btn.prop('disabled', true).addClass('disabled');

                //     $qty.val(minQty);

                //     return;
                // }

                // if (currentQty > realMax) {
                //     currentQty = realMax;
                //     $qty.val(realMax);
                // }

                // $btn.prop('disabled', false).removeClass('disabled');
            })
    };

    var stickyAddToCart = function () {
        var $form = $(".tf-sticky-atc-form"),
            $options = $(".tf-sticky-atc-options", $form),
            $btnOpenOptions = $(".open-options", $form),
            $variationForm = $(".tf-variable-form"),
            variationData = $variationForm.data('product_variations'),
            currentVariation = 0,
            dataAttribute = {};

        if ($form.length == 0) {
            return;
        }

        $btnOpenOptions.on('click', function () {
            $(this).toggleClass('active');
            $options.toggleClass('opened');
        });

        var findMatchingVariations = function (variations, attributes) {
            var matching = [];
            for (var i = 0; i < variations.length; i++) {
                var variation = variations[i];

                if (isMatch(variation.attributes, attributes)) {
                    matching.push(variation);
                }
            }
            return matching;
        };

        var isMatch = function (variation_attributes, attributes) {
            var match = true;
            for (var attr_name in variation_attributes) {
                if (variation_attributes.hasOwnProperty(attr_name)) {
                    var val1 = variation_attributes[attr_name];
                    var val2 = attributes[attr_name];
                    if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
                        match = false;
                    }
                }
            }
            return match;
        };

        var $select = $('select', $form),
            $btnAddToCart = $('.tf-sticky-atc-ajax', $form);

        $select.on('change', function () {
            let $optionSelected = $(this).find('option:selected'),
                $image = $('.tf-sticky-atc-img img', $(this).closest('.tf-sticky-atc-wrapper')),
                image_url = $optionSelected.data('image'),
                count = 0,
                chosen = 0;

            if (image_url) {
                $image.attr('src', image_url);
            }

            if ($options.length > 0) {
                currentVariation = 0;
                dataAttribute = {};
                $select.each(function () {
                    var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
                    var value = $(this).val() || '';
                    if (value.length > 0) {
                        chosen++;
                    }

                    count++;
                    dataAttribute[attribute_name] = value;
                });

                if (count && count === chosen) {
                    var matching_variations = findMatchingVariations(variationData, dataAttribute),
                        variation = matching_variations.shift();
                    if (variation) {
                        currentVariation = variation.variation_id;
                    }
                }

                if (currentVariation) {
                    $btnAddToCart.removeClass('disabled');
                } else {
                    $btnAddToCart.addClass('disabled');
                }
            }

        });

        $btnAddToCart.on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass("disabled") || $(this).hasClass("loading")) {
                return;
            }
            let $optionSelected = $select.find('option:selected'),
                variation_id = $optionSelected.val(),
                attributes = $optionSelected.data('attributes') || {},
                quantity = parseInt($form.find('input[name="quantity"]').val()) || 1,
                product_id = $form.data('product_id'),
                data = {};

            if ($options.length > 0) {
                variation_id = currentVariation;
            }

            if ($select.length > 0) {
                if (!variation_id) {
                    window.tfwcNotify("Please select a variation.");
                    return;
                }

                data = {
                    'product_id': product_id,
                    'add-to-cart': product_id,
                    'variation_id': variation_id,
                    'quantity': quantity,
                };

                if ($options.length > 0) {
                    Object.assign(data, dataAttribute);
                } else {
                    $.each(attributes, function (key, value) {
                        data[key] = value;
                    });
                }
            } else {
                data = {
                    'add-to-cart': product_id,
                    'quantity': quantity,
                };
            }

            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: data,
                beforeSend: function () {
                    $btnAddToCart.addClass('disabled loading');
                    $('.tf-add-to-cart-loading', $btnAddToCart).removeClass('d-none');
                },
                success: function (response) {
                    if (response.error) {
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
                            )
                        } else {
                            if ($('.popup-shopping-cart', $response).length > 0) {
                                $('.popup-shopping-cart').html($('.popup-shopping-cart', $response).html());
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
                },
                complete: function () {
                    $btnAddToCart.removeClass('disabled loading');
                    $('.tf-add-to-cart-loading', $btnAddToCart).addClass('d-none');
                },
                error: function (err) {
                    console.log('Add to cart failed:', err);
                }
            });
        });
        $select.first().trigger('change');
    };

    var productTogether = function () {
        let $form = $(".tf-product-together-form"),
            $variationForm = $(".tf-variable-form"),
            $inputVariationMain = $(".tf-fbt-item.main-item .fbt_variation_id", $form),
            $inputVariations = $(".tf-fbt-item .fbt_variation_id", $form);
        if ($form.length == 0) {
            return;
        }

        let $select = $('select', $form),
            $checkbox = $('.tf-check', $form),
            $btnAddToCart = $('.tf-fbt-btn', $form);

        var updateButton = function () {
            let disabled = false;
            $select.each(function () {
                if (!$(this).val()) {
                    disabled = true;
                    return false;
                }
            });
            if (disabled) {
                $btnAddToCart.addClass('disabled');
            } else {
                $btnAddToCart.removeClass('disabled');
            }
        }

        var calcTotal = function () {
            let $prices = $('.tf-price', $form),
                $totalPrice = $('.total-price', $form),
                total = 0;
            $prices.each(function () {
                let $item = $(this).closest('.tf-fbt-item'),
                    price = $(this).data('price');
                if (price && $item.hasClass('check')) {
                    total += parseFloat(price);
                }
            });
            $totalPrice.html(numberFormat(total));
            updateButton();
        }

        $checkbox.on('change', function (e) {
            e.preventDefault();
            if ($(this).prop("checked")) {
                $(this).closest('.tf-fbt-item').addClass('check');
                $('.fbt-image', $form).eq($(this).closest('.tf-fbt-item').index()).addClass('check');
            } else {
                $(this).closest('.tf-fbt-item').removeClass('check');
                $('.fbt-image', $form).eq($(this).closest('.tf-fbt-item').index()).removeClass('check');
            }
            calcTotal();
        });

        $select.on('change', function () {
            let $optionSelected = $(this).find('option:selected'),
                $image = $('img', $(this).closest('.tf-fbt-item')),
                $price = $('.tf-price', $(this).closest('.tf-fbt-item')),
                image_url = $optionSelected.data('image'),
                price = $optionSelected.data('price'),
                price_html = $optionSelected.data('price-html');
            if (image_url) {
                if ($image.length) {
                    $image.attr('src', image_url);
                } else {
                    $('.fbt-image img', $form).eq($(this).closest('.tf-fbt-item').index()).attr('src', image_url);
                }
            }
            if (price) {
                $price.data('price', price);
            }
            if (price_html) {
                $price.html(price_html);
            }
            calcTotal();
        });

        if ($inputVariationMain.length > 0) {
            let $image = $('img', $inputVariationMain.closest('.tf-fbt-item')),
                $price = $('.tf-price', $inputVariationMain.closest('.tf-fbt-item')),
                originImage,
                priceHTMlOrigin;

            if ($image.length) {
                originImage = $image.attr('src');
            } else {
                originImage = $('.fbt-image img', $form).first().attr('src');
            }
            priceHTMlOrigin = $price.html();

            $variationForm.on("show_variation", function (e, variation) {
                let image_url = variation?.image?.full_src,
                    price = variation.display_price,
                    price_html = variation.price_html;

                if (image_url) {
                    if ($image.length) {
                        $image.attr('src', image_url);
                    } else {
                        $('.fbt-image img', $form).first().attr('src', image_url);
                    }
                }
                if (price) {
                    $price.data('price', price);
                }
                if (price_html) {
                    $price.html(price_html);
                }
                $inputVariationMain.val(variation.variation_id);
                calcTotal();
            })
                .on("hide_variation", function () {
                    if ($image.length) {
                        $image.attr('src', originImage);
                    } else {
                        $('.fbt-image img', $form).first().attr('src', originImage);
                    }
                    $price.data('price', 0);
                    $price.html(priceHTMlOrigin);
                    $inputVariationMain.val('');
                    calcTotal();
                });
        }

        $btnAddToCart.on('click', function (e) {
            e.preventDefault();
            let $items = $('.tf-fbt-item.check', $form),
                productsData = [];

            if ($inputVariations.length) {
                let hasEmpty = false;
                $inputVariations.each(function () {
                    if (!$(this).val()) {
                        hasEmpty = true;
                        return false;
                    }
                });
                if (hasEmpty) {
                    window.tfwcNotify('Please select options');
                    return;
                }
            }

            $items.each(function () {
                let $optionSelected = $('option:selected', $(this)),
                    variation_id = $optionSelected.val(),
                    attributes = $optionSelected.data('attributes') || {};

                if ($inputVariationMain.length && $(this).hasClass('main-item')) {
                    let $select = $('select', $variationForm);
                    variation_id = $inputVariationMain.val();
                    attributes = {};
                    $select.each(function () {
                        var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
                        var value = $(this).val() || '';
                        attributes[attribute_name] = value;
                    });
                }

                let data = {
                    product_id: $(this).data('product_id'),
                    variation_id: variation_id ?? '',
                    quantity: 1,
                    attributes: attributes
                };
                productsData.push(data);
            });

            $.ajax({
                url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "tf_product_fbt"),
                type: 'POST',
                data: {
                    security: tfWooParams.tf_product_fbt_nonce,
                    data: productsData
                },
                beforeSend: function () {
                    $btnAddToCart.addClass('disabled loading');
                    $('.tf-add-to-cart-loading', $btnAddToCart).removeClass('d-none');
                },
                success: function (response) {
                    if (response.success) {
                        let $response = $(response);
                        if ($('.popup-shopping-cart', $response).length > 0) {
                            $('.popup-shopping-cart').html($('.popup-shopping-cart', $response).html());
                            showMiniCart();
                        } else {
                            $(document.body).trigger('wc_fragment_refresh');
                            showMiniCart();
                        }
                        if ($('.nav-icon .nav-cart', $response).length > 0) {
                            $('.nav-icon .nav-cart').html($('.nav-icon .nav-cart', $response).html());
                        } else {
                            $('.nav-icon .nav-cart').load((location.href) + ' .nav-icon .nav-cart .nav-icon-item');
                        }
                    }
                },
                complete: function () {
                    $btnAddToCart.removeClass('disabled loading');
                    $('.tf-add-to-cart-loading', $btnAddToCart).addClass('d-none');
                },
                error: function (err) {
                    console.log('Add to cart failed:', err);
                }
            });
        });

        $select.trigger('change');
        $checkbox.first().prop("checked", true).prop("disabled", true).change();
    };

    var buyXGetY = function () {
        let $form = $('.tf-buyX-getY-form'),
            $btnBuy = $('.tf-buyx-gety-btn', $form),
            $select = $('select', $form),
            $mainProductID = $('.tf-main-product-id', $form),
            $discountProductID = $('.tf-discount-product-id', $form);

        $form.on('submit', function (e) {
            e.preventDefault();
            return false;
        });

        $btnBuy.on('click', function (e) {
            e.preventDefault();
            let productsData = {
                product_id_x: $mainProductID.val(),
                variation_id_x: $mainProductID.data('variation_id'),
                variation_x: $mainProductID.data('attributes'),
                product_id_y: $discountProductID.val(),
                variation_id_y: $discountProductID.data('variation_id'),
                variation_y: $discountProductID.data('attributes'),
            }
            $.ajax({
                url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "tf_add_buyx_gety_bundle"),
                type: 'POST',
                data: {
                    action: 'tf_add_buyx_gety_bundle',
                    security: tfWooParams.tf_add_buyx_gety_bundle_nonce,
                    // data: productsData
                    ...productsData
                },
                beforeSend: function () {
                    $btnBuy.addClass('disabled loading');
                    $('.tf-add-to-cart-loading', $btnBuy).removeClass('d-none');
                },
                success: function (response) {
                    if (response.success) {
                        let $response = $(response);
                        if ($('.popup-shopping-cart', $response).length > 0) {
                            $('.popup-shopping-cart').html($('.popup-shopping-cart', $response).html());
                            showMiniCart();
                        } else {
                            $(document.body).trigger('wc_fragment_refresh');
                            showMiniCart();
                        }
                        if ($('.nav-icon .nav-cart', $response).length > 0) {
                            $('.nav-icon .nav-cart').html($('.nav-icon .nav-cart', $response).html());
                        } else {
                            $('.nav-icon .nav-cart').load((location.href) + ' .nav-icon .nav-cart .nav-icon-item');
                        }
                    } else {
                        if (response?.data?.message) {
                            $.toast(
                                {
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
                                }
                            )
                        }
                    }
                },
                complete: function () {
                    $btnBuy.removeClass('disabled loading');
                    $('.tf-add-to-cart-loading', $btnBuy).addClass('d-none');
                },
                error: function (err) {
                    console.log('Add to cart failed:', err);
                }
            });
        });

        $select.on('change', function () {
            let $optionSelected = $(this).find('option:selected'),
                $image = $('.img-product img', $(this).closest('.item-product')),
                $price = $('.tf-price', $(this).closest('.item-product')),
                $inputData = $('.tf-buyx-gety-data', $(this).closest('.item-product')),
                image_url = $optionSelected.data('image'),
                price = $optionSelected.data('price'),
                price_html = $optionSelected.data('price-html'),
                variation_id = $optionSelected.val(),
                attributes = $optionSelected.data('attributes') || {};
            if (image_url) {
                if ($image.length) {
                    $image.attr('src', image_url);
                }
            }
            if (price) {
                $price.data('price', price);
            }
            if (price_html) {
                $price.html(price_html);
            }
            if ($inputData.length) {
                $inputData.data('variation_id', variation_id);
                $inputData.data('attributes', attributes);
            }
        });

        $select.trigger('change');
    };

    var quickShop = function () {
        let $modalQuickAdd = $('.tf-quick-add-modal'),
            $modalQuickView = $('.modal-quick-view');

        // Quick View
        $(document).on('ajaxComplete.quick_view', function (event, xhr, settings) {
            if (settings.data && settings.data.indexOf('action=load_quickview_product') !== -1) {
                let $container = $('.tf-product-info-wrap', $modalQuickView),
                    $variationForm = $('.variations_form', $modalQuickView),
                    $image = $('.item img', $modalQuickView).first(),
                    $price = $('.tf-price', $modalQuickView),
                    imageOrigin = $image.attr('src') ? $image.attr('src') : $image.attr('data-src'),
                    priceHTMlOrigin = $price.html();

                if ($container.length) {
                    $container.addClass('tf-main-product');
                }
                if ($variationForm.length) {
                    if (typeof $.fn.wc_variation_form !== 'undefined') {
                        $variationForm.wc_variation_form();
                    }
                    if (typeof $.fn.wcboost_variation_swatches !== 'undefined') {
                        $variationForm.wcboost_variation_swatches().trigger('init_variation_swatches.wcboost-variation-swatches');
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

                    $variationForm
                        .on('found_variation', function (e, data) {
                            if (data?.image?.full_src) {
                                $image.attr('src', data.image.full_src);
                            }
                            if (data?.price_html) {
                                $price.html($(data.price_html).html());
                            }
                        })
                        .on('hide_variation', function () {
                            $(".tf-variation-dropdown-wrapper .select-item", $variationForm).removeClass("active");
                            $image.attr('src', imageOrigin);
                            $price.html(priceHTMlOrigin);
                        });
                }
            }
        });

        // Quick Add
        $(document).on("click", ".tf-main-product .tf_quick_add_btn, .tf_add_to_cart.product_type_variable", function (e) {
            e.preventDefault();
            let id = $(this).data('product_id');
            $.ajax({
                url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "tf_get_quick_add"),
                type: 'POST',
                data: {
                    'quick_add_id': id
                },
                beforeSend: function () { },
                success: function (response) {
                    if (response?.success) {
                        let $response = $(response.data?.content);
                        if (!$response.length) {
                            return;
                        }
                        $modalQuickAdd.find('.card-product')
                            .empty()
                            .html($response)
                            .addClass('tf-main-product');
                        let $variationForm = $modalQuickAdd.find('.variations_form'),
                            $price = $('.tf-price', $modalQuickAdd),
                            $image = $('.product-img img', $modalQuickAdd),
                            priceHTMlOrigin = $price.html(),
                            imageOrigin = $image.attr('src') ? $image.attr('src') : $image.attr('data-src');
                        $('.screen-reader-text', $variationForm).removeClass('screen-reader-text');
                        if (typeof $.fn.wc_variation_form !== 'undefined') {
                            $variationForm.wc_variation_form();
                        }

                        if (typeof $.fn.wcboost_variation_swatches !== 'undefined') {
                            $variationForm.wcboost_variation_swatches();
                            $modalQuickAdd.trigger('init_variation_swatches.wcboost-variation-swatches');
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

                        $variationForm
                            .on('found_variation', function (e, data) {
                                if (data?.image?.full_src) {
                                    $image.attr('src', data.image.full_src);
                                }
                                if (data?.price_html) {
                                    $price.html($(data.price_html).html());
                                }
                            })
                            .on('hide_variation', function () {
                                $(".tf-variation-dropdown-wrapper .select-item", $variationForm).removeClass("active");
                                $image.attr('src', imageOrigin);
                                $price.html(priceHTMlOrigin);
                            });
                        $modalQuickAdd.modal('show');
                    }
                },
                complete: function () { }
            });
        });

    };

    var discountItems = function () {

        if (!tfWooParams?.volume_discount) {
            return;
        }

        $(".volume-discount-item").on('click', function (e) {
            e.preventDefault();
            $(".volume-discount-item").removeClass("active");
            $(this).addClass("active");
            $(".tf-single-product input.qty").val($(this).data('from')).change();
        });

        $(".tf-single-product input.qty").change(function () {
            let quantity = $(this).val();
            let highestDiscount = 0;
            $(".volume-discount-item").each(function () {
                if (quantity >= parseInt($(this).data('from')) && (quantity <= parseInt($(this).data('to')) || parseInt($(this).data('to')) == 0)) {
                    if (parseInt($(this).data('discount')) > highestDiscount) {
                        highestDiscount = parseInt($(this).data('discount'));
                        $(".volume-discount-item").removeClass("active");
                        $(this).addClass("active");
                    }
                } else {
                    $(this).removeClass("active");
                }
            });
            $('.tf-main-product form.cart:not(.tf-external-form,.tf-grouped-form) button.single_add_to_cart_button .dynamic-price').data('discount', highestDiscount);
        });

        $('.tf-single-product .variations_form')
            .on('found_variation', function (event, data) {
                setTimeout(() => {
                    $(".volume-discount-item", $(event.target).closest('.tf-single-product')).each(function () {
                        let item = $(this),
                            from = item.data('from'),
                            price = data?.display_price ? data.display_price : 0,
                            total = parseInt(from) * price,
                            variations = item.data('variations'),
                            freeShippingAmount = $('.tf-free-shipping-tag', item).data('free-shipping');
                        if (variations) {
                            if (variations[data.variation_id]) {
                                $('.tf-total-new', item).html(variations[data.variation_id]?.total_new_html);
                                $('.tf-total-old', item).html(variations[data.variation_id]?.total_html);
                                if (item.hasClass('volume-discount-list-item')) {
                                    $('.tf-save-volume', item).html(variations[data.variation_id]?.save_volume_html);
                                    $('.tf-save-volume', item).closest('.text').show();
                                    if (freeShippingAmount && (variations[data.variation_id]?.total_new) >= parseFloat(freeShippingAmount)) {
                                        $('.tf-free-shipping-tag', item).show();
                                    } else {
                                        $('.tf-free-shipping-tag', item).hide();
                                    }
                                }
                            }
                        }
                    });
                }, 1);
            })
            .on('reset_data', function (event) {
                $('.tf-total-new', $(event.target).closest('.tf-single-product')).html('');
                $('.tf-total-old', $(event.target).closest('.tf-single-product')).html('');
                $('.volume-discount-list-item .tf-save-volume', $(event.target).closest('.tf-single-product')).html('');
                $('.volume-discount-list-item .tf-save-volume', $(event.target).closest('.tf-single-product')).closest('.text').hide();
                $('.volume-discount-list-item .tf-free-shipping-tag', $(event.target).closest('.tf-single-product')).hide();
            });

        $(".tf-single-product input.qty").change();
    };

    var copyText = function () {
        $('#btn-coppy-text').on('click', function (e) {
            e.stopPropagation();
            var textToCopy = $('#coppyText').text();

            if (navigator.clipboard && window.isSecureContext) {

                navigator.clipboard.writeText(textToCopy).then(function () {
                    $.toast({
                        heading: tfWooParams?.trans_text?.success || 'Success',
                        text: tfWooParams?.trans_text?.copy_success || 'Link copied to clipboard',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 1000
                    });
                }).catch(function (err) {
                    console.error("Failed to copy text: " + err);
                });

            } else {
                fallbackCopy(textToCopy);
            }

        });

        function fallbackCopy(text) {

            try {

                const textarea = $('#coppyText').get(0);
                textarea.contentEditable = 'true';
                textarea.textContent = text;

                const range = document.createRange();
                range.selectNodeContents(textarea);
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);

                document.execCommand('copy');

                $.toast({
                    heading: tfWooParams?.trans_text?.success || 'Success',
                    text: tfWooParams?.trans_text?.copy_success || 'Link copied to clipboard',
                    showHideTransition: 'slide',
                    icon: 'success',
                    hideAfter: 1000
                });

            } catch (err) {
                // copy fail
                console.log('Copy failed', err);
            }
        }
    };

    var scrollBottomSticky = function () {
        $(window).on("scroll resize load", function () {
            var $btn1 = $(".tf-main-product form.cart:not(.tf-external-form,.tf-grouped-form) button.single_add_to_cart_button");
            var $stickyBtn = $(".tf-sticky-btn-atc");

            if ($btn1.length === 0 || $stickyBtn.length === 0) return;

            var rect = $btn1[0].getBoundingClientRect();

            // if (rect.bottom < 0 || rect.top > $(window).height()) {
            if (rect.bottom < 0) {
                $stickyBtn.addClass("show");
                $('#goTop').addClass("sticky-btn-atc-show");
            } else {
                $stickyBtn.removeClass("show");
                $('#goTop').removeClass("sticky-btn-atc-show");
            }
        });

    };

    var gallery = function () {

        var externalZoom = function () {

            $(".tf-image-zoom").on("mouseover", function () {
                $(this).closest(".section-image-zoom").addClass("zoom-active");
            });

            $(".tf-image-zoom").on("mouseleave", function () {
                $(this).closest(".section-image-zoom").removeClass("zoom-active");
            });

            var driftAll = document.querySelectorAll('.tf-image-zoom');
            var pane = document.querySelector('.tf-zoom-main');

            if (matchMedia("only screen and (min-width: 1200px)").matches) {
                $(driftAll).each(function (i, el) {
                    if (!el._drift) {
                        el._drift = new Drift(
                            el, {
                            zoomFactor: 2,
                            paneContainer: pane,
                            inlinePane: false,
                            handleTouch: false,
                            hoverBoundingBox: true,
                            containInline: true,
                        }
                        );
                    }
                });
            } else {
                $(driftAll).each(function (i, el) {
                    if (el._drift) {
                        el._drift.destroy();
                        el._drift = null;
                    }
                });
            }

            if (typeof $.fn.magnificPopup !== "undefined") {
                $(driftAll).magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true
                    }
                });
            }
        };

        var innerZoom = function () {
            var driftAll = document.querySelectorAll('.tf-image-zoom');
            $(driftAll).each(function (i, el) {
                var pane = $(this).closest('.tf-inner-zoom-box').get(0);
                new Drift(
                    el, {
                    paneContainer: pane,
                    zoomFactor: 2,
                    inlinePane: false,
                    containInline: false,
                }
                );
            });
        }

        var magnifierZoom = function () {
            var driftAll = document.querySelectorAll('.tf-image-zoom');
            $(driftAll).each(function (i, el) {
                new Drift(
                    el, {
                    zoomFactor: 2,
                    inlinePane: true,
                    containInline: false,
                }
                );
            });
        }

        var staggerWrap = function () {
            if ($(".stagger-wrap").length) {

                var count = $(".stagger-item").length;

                for (var i = 1, time = 0.2; i <= count; i++) {
                    $(".stagger-item:nth-child(" + i + ")")
                        .css("transition-delay", time * i + "s")
                        .addClass("stagger-finished");
                }
            }
        };

        var thumbSwiper = function () {

            // Grid gallery layout (.flat-single-grid) is a static CSS grid on every
            // breakpoint. It must never be turned into a Swiper: the "thumbs-bottom"
            // SCSS rule sets width:auto !important on .tf-product-media-thumbs, so with
            // observer/observeParents enabled Swiper keeps recomputing slide width from
            // its own auto-grown container width, growing without bound on mobile.
            if ($(".flat-single-grid").length) {
                return;
            }

            // if ($(".thumbs-slider").length == 0) {
            //     return;
            // }

            if ($(".flat-wrap-media-product .item").length < 2) {
                $(".flat-wrap-media-product .nav-swiper-group").hide();
                $(".tf-product-media-thumbs").hide();
            }

            $(".flat-wrap-media-product .item").each(function () {
                let $image = $('img', $(this)),
                    $video = $('video', $(this)),
                    $iframe = $('iframe', $(this)),
                    $modelViewer = $('.tf-model-viewer', $(this)),
                    url = '';

                if ($image.length) {
                    url = $image.attr('data-src');
                    $(".stagger-wrap").append(`
                        <div class="swiper-slide stagger-item">
                            <div class="item">`
                        + (url ? `<img class="lazyload" data-src="${url}" src="${url}" alt="">` : '') +
                        `</div>
                        </div> 
                    `);
                } else if ($video.length || $iframe.length) {
                    url = $(this).attr('data-video-thumb');
                    $(".stagger-wrap").append(`
                        <div class="swiper-slide stagger-item stagger-item-video position-relative">
                            <div class="item position-relative">      
                                <div class="wrap-btn-viewer style-video">
                                    <i class="icon icon-Video"></i>
                                </div>`
                        + (url ? `<img class="lazyload" data-src="${url}" src="${url}" alt="">` : '') +
                        `</div>
                        </div>
                    `);
                } else if ($modelViewer.length) {
                    url = $(this).attr('data-model-viewer-thumb');
                    $(".stagger-wrap").append(`
                        <div class="swiper-slide stagger-item stagger-item-video position-relative">
                            <div class="item position-relative">      
                                <div class="wrap-btn-viewer">
                                    <i class="icon icon-btn3d"></i>
                                </div>`
                        + (url ? `<img class="" data-src="${url}" src="${url}" alt="">` : '') +
                        `</div>
                        </div>
                    `);
                }
            });

            var direction = $(".tf-product-media-thumbs").data("direction");
            var preview = $(".tf-product-media-thumbs").data("preview");

            let thumbsConfigs = {
                initialSlide: 0,
                spaceBetween: 12,
                slidesPerView: preview,
                // slidesPerView: "auto",
                autoHeight: false,
                freeMode: false,
                direction: "vertical",
                watchSlidesProgress: true,
                observer: true,
                observeParents: true,
                mousewheel: {
                    forceToAxis: true,
                    sensitivity: 1,
                    releaseOnEdges: false,
                },
                breakpoints: {
                    0: {
                        direction: "horizontal",
                        slidesPerView: 4,
                        spaceBetween: 12,
                        autoHeight: false,
                    },
                    768: {
                        direction: "horizontal",
                        slidesPerView: 5,
                        spaceBetween: 12,
                        autoHeight: false,
                    },
                    1200: {
                        direction: direction,
                        slidesPerView: tfWooParams?.thumb_swiper == "bottom_thumb" ? 5 : "auto",
                        spaceBetween: tfWooParams?.thumb_swiper == "bottom_thumb" ? 12 : 16,
                        autoHeight: true,
                    },
                }
            };

            let thumbs = new Swiper(".tf-product-media-thumbs", thumbsConfigs);

            let configs = {
                initialSlide: 0,
                spaceBetween: 5,
                observer: true,
                observeParents: true,
                speed: 800,
                autoHeight: true,
                navigation: {
                    nextEl: ".thumbs-next",
                    prevEl: ".thumbs-prev",
                },
                thumbs: {
                    swiper: thumbs,
                },
            };

            let mobileConfigs = {
                initialSlide: 0,
                spaceBetween: 0,
                observer: true,
                observeParents: true,
                speed: 800,
                autoHeight: true,
                navigation: {
                    nextEl: ".thumbs-next",
                    prevEl: ".thumbs-prev",
                },
                thumbs: {
                    swiper: thumbs,
                },
            };

            // if ($(".wrapper-gallery .swiper-slide").length < 2) {
            //     $(".wrapper-gallery .nav-swiper-group").hide();
            // }

            if ($(".tf-product-swiper-mobile").length) {

                let main = null;

                var updateSwiperState = function () {
                    const isMobile = window.innerWidth < 992;
                    if (isMobile) {
                        if (main) return;
                        thumbs = new Swiper(".tf-product-media-thumbs", thumbsConfigs);
                        configs = {
                            initialSlide: 0,
                            spaceBetween: 5,
                            observer: true,
                            observeParents: true,
                            speed: 800,
                            autoHeight: true,
                            thumbs: {
                                swiper: thumbs,
                            },
                        };
                        $(".tf-product-swiper-mobile").addClass("thumbs-slider");
                        $(".tf-swiper-wrapper-mobile").addClass("swiper-wrapper");
                        $(".wrapper-gallery").addClass("swiper");
                        main = new Swiper(".wrapper-gallery", configs);
                        $(".tf-product-media-thumbs").show();
                        $(".nav-swiper", ".tf-product-swiper-mobile").show();
                        window['tf_main_swiper'] = main;
                        window['tf_thumb_swiper'] = thumbs;
                    } else {
                        if (!main) return;
                        main?.detachEvents();
                        main?.destroy(true, true);
                        main = null;
                        if (window['tf_thumb_swiper'] && typeof window['tf_thumb_swiper'].destroy === 'function') {
                            window['tf_thumb_swiper'].detachEvents();
                            window['tf_thumb_swiper'].destroy(true, true);
                            window['tf_thumb_swiper'] = null;
                        }
                        $(".tf-product-swiper-mobile").removeClass("thumbs-slider");
                        $(".wrapper-gallery").removeClass("swiper");
                        $(".tf-swiper-wrapper-mobile").removeClass("swiper-wrapper");
                        $(".tf-product-media-thumbs").hide();
                        $(".nav-swiper", ".tf-product-swiper-mobile").hide();
                    }
                };
                window.addEventListener("resize", updateSwiperState);
                updateSwiperState();
            } else {
                let main = new Swiper(".wrapper-gallery", configs);
                window['tf_main_swiper'] = main;
                window['tf_thumb_swiper'] = thumbs;
            }

            if (!tfWooParams?.variation_gallery) {
                $('.tf-single-product .variations_form')
                    .on("show_variation", function (e, variation) {
                        if (variation?.image?.full_src) {
                            $(".stagger-item img").first().attr('src', variation.image.full_src);
                            $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-zoom", $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-src"));
                            $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().closest("a").attr("data-pswp-width", $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-large_image_width"));
                            $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().closest("a").attr("data-pswp-height", $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-large_image_height"));
                        }
                    })
                    .on('hide_variation', function () {
                        $(".stagger-item img").first().attr('src', $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-src"));
                        $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-zoom", $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-src"));
                        $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().closest("a").attr("data-pswp-width", $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-large_image_width"));
                        $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().closest("a").attr("data-pswp-height", $(".flat-wrap-media-product .woocommerce-product-gallery__image img").first().attr("data-large_image_height"));
                    });
            }
        }

var lightbox = function () {
    $(".wrapper-gallery a").each(function () {
        const $image = $("img", this);

        if ($image.length) {
            $(this).attr(
                "data-pswp-width",
                $image.attr("data-large_image_width")
            );

            $(this).attr(
                "data-pswp-height",
                $image.attr("data-large_image_height")
            );
        }
    });

    const lb = new PhotoSwipeLightbox({
        gallery: ".wrapper-gallery",
        children: "div a",
        pswpModule: PhotoSwipe,
        bgOpacity: 1,
        secondaryZoomLevel: 2,
        maxZoomLevel: 3,
    });

    let autoplayWasRunning = false;

    lb.on("change", () => {
        const swiper = window["tf_main_swiper"];
        const pswp = lb.pswp;

        if (
            swiper &&
            pswp &&
            typeof swiper.slideTo === "function"
        ) {
            swiper.slideTo(pswp.currIndex, 0, false);
        }
    });

    lb.on("afterInit", () => {
        const swiper = window["tf_main_swiper"];

        autoplayWasRunning = Boolean(
            swiper?.autoplay?.running
        );

        if (
            autoplayWasRunning &&
            typeof swiper.autoplay.stop === "function"
        ) {
            swiper.autoplay.stop();
        }
    });

    lb.on("closingAnimationStart", () => {
        const swiper = window["tf_main_swiper"];
        const pswp = lb.pswp;

        if (
            swiper &&
            pswp &&
            typeof swiper.slideTo === "function"
        ) {
            swiper.slideTo(pswp.currIndex, 0, false);
        }

        if (
            autoplayWasRunning &&
            typeof swiper?.autoplay?.start === "function"
        ) {
            swiper.autoplay.start();
        }

        autoplayWasRunning = false;
    });

    lb.init();

    window["tf_lightbox"] = lb;
};

        var modelViewer = function () {
            const modelViewer = document.querySelector('.slide-3d');
            if (modelViewer && window['tf_main_swiper']) {
                modelViewer.addEventListener('mouseenter', () => {
                    window['tf_main_swiper'].allowTouchMove = false;
                });

                modelViewer.addEventListener('mouseleave', () => {
                    window['tf_main_swiper'].allowTouchMove = true;
                });
            }

            if ($(".tf-model-viewer").length) {
                $(".tf-model-viewer-ui-button").on("click", function (e) {
                    $(this).closest(".tf-model-viewer").find("model-viewer").removeClass("disabled");
                    $(this).closest(".tf-model-viewer").toggleClass("active");
                });

                $(".tf-model-viewer-ui").on("dblclick", function (e) {
                    const modelViewer = $(this).closest(".tf-model-viewer").find("model-viewer")[0];

                    $(this).closest(".tf-model-viewer").find("model-viewer").addClass("disabled");
                    $(this).closest(".tf-model-viewer").toggleClass("active");

                    if (modelViewer) {
                        modelViewer.cameraOrbit = "0deg 90deg auto";
                        modelViewer.updateFraming();
                    }
                });
            }
        }

        var destroyGallery = function () {
            if (window['tf_main_swiper'] && typeof window['tf_main_swiper'].destroy === 'function') {
                window['tf_main_swiper'].destroy(true, true);
                window['tf_main_swiper'] = null;
            }

            if (window['tf_thumb_swiper'] && typeof window['tf_thumb_swiper'].destroy === 'function') {
                window['tf_thumb_swiper'].destroy(true, true);
                window['tf_thumb_swiper'] = null;
            }

            if (window['tf_lightbox'] && typeof window['tf_lightbox'].destroy === 'function') {
                window['tf_lightbox'].destroy();
                window['tf_lightbox'] = null;
            }
        }

        var updateGallery = function () {
            if (window['tf_main_swiper'] && typeof window['tf_main_swiper'].update === 'function') {
                window['tf_main_swiper'].update();
            }
            if (window['tf_thumb_swiper'] && typeof window['tf_thumb_swiper'].update === 'function') {
                window['tf_thumb_swiper'].update();
            }
            if (window['tf_lightbox'] && typeof window['tf_lightbox'].update === 'function') {
                window['tf_lightbox'].update();
            }
        }

        var variationGallery = function () {
            var galleryLoading = false,
                isGalleryChanged = false,
                currentVariation = null;
            $('.tf-single-product .woocommerce-product-gallery .wp-post-image').removeClass('wp-post-image');
            $('.tf-single-product .variations_form')
                .on("show_variation", function (e, variation) {
                    let variation_id = null;
                    if ((currentVariation && currentVariation == variation?.variation_id) || galleryLoading) {
                        return;
                    }
                    if (variation?.available_gallery) {
                        variation_id = variation['variation_id'];
                    } else {
                        if (isGalleryChanged) {
                            isGalleryChanged = false;
                        } else {
                            return;
                        }
                    }
                    currentVariation = variation?.variation_id;
                    $.ajax({
                        url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "tf_get_variation_gallery"),
                        type: 'POST',
                        data: {
                            security: tfWooParams.tf_get_variation_gallery_nonce,
                            product_id: $(".tf-single-product .variations_form input[name='product_id']").val(),
                            variation_id: variation_id,
                        },
                        beforeSend: function () {
                            galleryLoading = true;
                            $('.tf-single-product .woocommerce-product-gallery .tf-overlay-container').removeClass('hidden');
                        },
                        success: function (response) {
                            if (response?.success) {
                                let $response = $(response.data?.content);
                                if (!$response.length) {
                                    return;
                                }
                                let $gallery = $('.tf-single-product .woocommerce-product-gallery .flat-wrap-media-product'),
                                    $thumbs = $('.tf-single-product .woocommerce-product-gallery .tf-product-media-thumbs');

                                $gallery.removeClass('swiper-backface-hidden swiper-initialized swiper-horizontal swiper-vertical');
                                $thumbs.removeClass('swiper-backface-hidden swiper-initialized swiper-horizontal swiper-vertical');
                                $gallery.find('.swiper-wrapper').empty().html($response);
                                $gallery.find('.wp-post-image').removeClass('wp-post-image');
                                $thumbs.find('.swiper-wrapper').empty();
                                $gallery
                                    .closest('.swiper')
                                    .replaceWith($gallery.closest('.swiper').clone(false));
                                $thumbs
                                    .closest('.swiper')
                                    .replaceWith($thumbs.closest('.swiper').clone(false));
                                initGallery();
                                isGalleryChanged = true;
                            }
                        },
                        complete: function () {
                            galleryLoading = false;
                            setTimeout(() => {
                                $('.tf-single-product .woocommerce-product-gallery .tf-overlay-container').addClass('hidden');
                            }, 200);
                        }
                    });
                })
                .on('hide_variation', function () {
                    if (currentVariation && isGalleryChanged) {
                        $.ajax({
                            url: woocommerce_params.wc_ajax_url.toString().replace("%%endpoint%%", "tf_get_variation_gallery"),
                            type: 'POST',
                            data: {
                                security: tfWooParams.tf_get_variation_gallery_nonce,
                                product_id: $(".tf-single-product .variations_form input[name='product_id']").val(),
                            },
                            beforeSend: function () {
                                galleryLoading = true;
                                $('.tf-single-product .woocommerce-product-gallery .tf-overlay-container').removeClass('hidden');
                            },
                            success: function (response) {
                                if (response?.success) {
                                    let $response = $(response.data?.content);
                                    if (!$response.length) {
                                        return;
                                    }

                                    let $gallery = $('.tf-single-product .woocommerce-product-gallery .flat-wrap-media-product'),
                                        $thumbs = $('.tf-single-product .woocommerce-product-gallery .tf-product-media-thumbs');

                                    $gallery.removeClass('swiper-backface-hidden swiper-initialized swiper-horizontal swiper-vertical');
                                    $thumbs.removeClass('swiper-backface-hidden swiper-initialized swiper-horizontal swiper-vertical');
                                    $gallery.find('.swiper-wrapper').empty().html($response);
                                    $thumbs.find('.swiper-wrapper').empty();
                                    $gallery
                                        .closest('.swiper')
                                        .replaceWith($gallery.closest('.swiper').clone(false));
                                    $thumbs
                                        .closest('.swiper')
                                        .replaceWith($thumbs.closest('.swiper').clone(false));
                                    initGallery();
                                    isGalleryChanged = false;
                                }
                            },
                            complete: function () {
                                galleryLoading = false;
                                setTimeout(() => {
                                    $('.tf-single-product .woocommerce-product-gallery .tf-overlay-container').addClass('hidden');
                                }, 200);
                            }
                        });
                    }
                    currentVariation = null;
                });
        }

        var initGallery = function () {
            destroyGallery();

            if (tfWooParams?.thumb_swiper) {
                thumbSwiper();
            }

            if (tfWooParams?.lightbox) {
                lightbox();
            }

            if (tfWooParams?.zoom == 'external') {
                window.addEventListener('resize', externalZoom);
                externalZoom();
            }

            if (tfWooParams?.zoom == 'inner') {
                innerZoom();
            }

            if (tfWooParams?.zoom == 'inner_circle') {
                magnifierZoom();
            }

            if (tfWooParams?.model_viewer) {
                modelViewer();
            }

            if (tfWooParams?.variation_gallery && !loaded) {
                variationGallery();
            }

            updateGallery();

            if (loaded) {
                staggerWrap();
            } else {
                setTimeout(function () {
                    staggerWrap();
                }, 800);
            }
        }

        initGallery();
    };

    // Write-a-review star rating is WooCommerce core's own accessible `#rating` widget
    // (`p.stars a`, auto-inserted and wired up by the WooCommerce plugin's own
    // assets/js/frontend/single-product.js) — reused as-is for the click-to-rate + validation
    // behavior. That core handler only ever flags the ONE clicked star with `.active` (see
    // wc-single-product.js: `$star.siblings('a').removeClass('active'); $star.addClass('active')`)
    // — it does not fill in the stars before it. Left alone, a click on "4 stars" would only light
    // up a single star instead of the expected 4-in-a-row. This adds a `.selected` class (styled in
    // css/styles.css) to the clicked star and every star to its left, matching the DOM's natural
    // left-to-right 1→5 order (no CSS row-reversal needed/trusted for this).
    var writeReviewRating = function () {
        // WooCommerce core's own handler for this same selector is bound to `body` and ends
        // with `return false` (preventDefault + stopPropagation) — binding this one to `document`
        // would never see the click, since stopPropagation stops it from bubbling past `body`.
        // Binding to the same `body` element still lets both handlers run (stopPropagation only
        // blocks bubbling further up, not sibling handlers already on this element).
        $('body').on('click', '#respond p.stars a', function () {
            var $stars = $(this).closest('p.stars').find('a');
            var index = $stars.index(this);
            $stars.removeClass('selected').slice(0, index + 1).addClass('selected');
        });
    };

    var writeReviewToggle = function () {
        $('.write-cancel-review-wrap').on('click', '.btn-write-review', function () {
            var $wrap = $(this).closest('.write-cancel-review-wrap').addClass('write-review');
            $('html, body').animate({
                scrollTop: $wrap.find('.write-review-wrap').offset().top - 120
            }, 400);
        });

        $('.write-cancel-review-wrap').on('click', '.btn-cancel-review', function () {
            $(this).closest('.write-cancel-review-wrap').removeClass('write-review');
        });
    };

    var commentActive = function () {
        if (window.location.hash.indexOf('#comment-') !== -1) {

            // Default
            $('.tf-product-tabs .wc-tabs a').removeClass('active');
            $('.tf-product-tabs a[href="#tab-reviews"]').addClass('active show');

            $('.tf-product-tabs .tab-pane').removeClass('active show');
            $('.tf-product-tabs #tab-reviews').addClass('active show');

            // Accordion

            setTimeout(() => {
                $(".widget-accordion .accordion-title")
                    .addClass("collapsed")
                    .next("div")
                    .addClass("collapse")
                    .removeClass("collapse show");

                $(".widget-accordion .widget-review")
                    .addClass("collapse show")
                    .removeClass("collapse")
                    .prev("div")
                    .removeClass("collapsed");
            }, 2000);
            $()
        }
    };

    /* Scroll Grid Product
    ------------------------------------------------------------------------------------- */
    var scrollGridProduct = function () {
        var scrollContainer = $(".wrapper-gallery-scroll");
        var activescrollBtn = null;
        var offsetTolerance = 20;

        function isHorizontalMode() {
            return window.innerWidth <= 767;
        }

        function getTargetScroll(target, isHorizontal) {
            if (isHorizontal) {
                return (
                    target.offset().left -
                    scrollContainer.offset().left +
                    scrollContainer.scrollLeft()
                );
            } else {
                return (
                    target.offset().top -
                    scrollContainer.offset().top +
                    scrollContainer.scrollTop()
                );
            }
        }

        $(".btn-scroll-target").on("click", function () {
            var scroll = $(this).data("scroll");
            var target = $(".item-scroll-target[data-scroll='" + scroll + "']");

            if (target.length > 0) {
                var isHorizontal = isHorizontalMode();
                var targetScroll = getTargetScroll(target, isHorizontal);

                if (isHorizontal) {
                    scrollContainer.animate({ scrollLeft: targetScroll }, 600);
                } else {
                    $("html, body").animate({ scrollTop: targetScroll }, 100);
                }

                $(".btn-scroll-target").removeClass("active");
                $(this).addClass("active");
                activescrollBtn = $(this);
            }
        });

        $(window).on("scroll", function () {
            var isHorizontal = isHorizontalMode();
            $(".item-scroll-target").each(function () {
                var target = $(this);
                var targetScroll = getTargetScroll(target, isHorizontal);

                if (isHorizontal) {
                    if (
                        $(window).scrollLeft() >= targetScroll - offsetTolerance &&
                        $(window).scrollLeft() <= targetScroll + target.outerWidth()
                    ) {
                        $(".btn-scroll-target").removeClass("active");
                        $(
                            ".btn-scroll-target[data-scroll='" + target.data("scroll") + "']"
                        ).addClass("active");
                    }
                } else {
                    if (
                        $(window).scrollTop() >= targetScroll - offsetTolerance &&
                        $(window).scrollTop() <= targetScroll + target.outerHeight()
                    ) {
                        $(".btn-scroll-target").removeClass("active");
                        $(
                            ".btn-scroll-target[data-scroll='" + target.data("scroll") + "']"
                        ).addClass("active");
                    }
                }
            });
        });
    };

    init();
})(jQuery);