(function ($) {
    "use strict";

    var init = function () {
        variationSwatches();

        $(document).on('tf_apply_variation_form', function (e, $variationForm) {
            variationSwatches($variationForm);
        });

    };

    var variationSwatches = function ($variationForm = null) {

        if ($(".wcboost-variation-swatches") == 0) {
            return;
        }

        let variationForm = $variationForm || $(".variations_form ").first(),
            mainProduct = $(variationForm).closest('.tf-main-product'),
            productPrice = $(".product-infor-price", mainProduct),
            // badgeSale = $(".badge-sale", productPrice),
            variation_id = $(".variation_id", variationForm),
            origin_price_html = productPrice.html();

        var onChange = function (item) {
            return;
            let select = $("select", item.closest(".wcboost-variation-swatches"));
            select.change();
        }

        var updatePrice = function () {
            if (variation_id.val()) {
                productPrice.html($(".woocommerce-variation-price .price").html());
            } else {
                productPrice.html(origin_price_html);
            }
        }

        var updateBadgeSale = function (variation) {
            let price = variation.display_price,
                regularPrice = variation.display_regular_price,
                discount = Math.round(((regularPrice - price) / regularPrice) * 100);
            if (discount > 0) {
                let badge = $(".badge-sale", productPrice);
                if (badge.length == 0) {
                    $(`<span class="badge-sale text-label fw-semibold">-${discount}%</span>`)
                        .appendTo(productPrice);
                } else {
                    badge.text(`-${discount}%`);
                }
            }
        }

        var resetOptions = function () {
            $(".wcboost-variation-swatches__item", variationForm).removeClass("selected");
            $(".tf-variation-dropdown-wrapper .select-item", variationForm).removeClass("active");
            $(".wcboost-variation-swatches__item", variationForm).removeClass("disabled");
            $(".tf-variation-dropdown-wrapper .select-item", variationForm).removeClass("disabled");
        }

        var updateOptions = function () {
            return;
            $(".wcboost-variation-swatches__item", variationForm).each(function () {
                let $self = $(this);
                let select = $("select", $self.closest(".wcboost-variation-swatches"));

                var optionValues = select.find('option').map(function () {
                    return $(this).val();
                }).get();

                if ($.inArray($self.data('value'), optionValues) === -1) {
                    $self.addClass('disabled');
                    $self.removeClass('selected');
                } else {
                    $self.removeClass('disabled');
                }
            });

            $(".tf-variation-dropdown-wrapper .select-item", variationForm).each(function () {

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

            // $(".tf-variation-dropdown-wrapper select", variationForm).each(function () {
            //     let $self = $(this),
            //         $dropdownWrapper = $self.closest('.tf-variation-dropdown-wrapper');
            //     $('.current-value', $dropdownWrapper).text($self.find('option:selected').text());
            // });
        }

        // Fills the "Colors: BEIGE" / "Size: M" current-value badge (`.variant-picker-label-value`,
        // `woocommerce/single-product/add-to-cart/variable.php`) next to each attribute's label —
        // matches ground truth's `.variant-picker-label-value.value-currentColor`. Was previously
        // disabled (short-circuited by an early `return`) from back when nothing rendered that span.
        var appendSelectedLabel = function (t) {
            var $valueLabel = $(t).closest(".value").siblings(".label").find(".variant-picker-label-value");
            if (!$valueLabel.length) {
                return;
            }
            $valueLabel.text(t.value ? t.options[t.selectedIndex].text : "");
        }

        variationForm.find(".value select").each(function () {
            appendSelectedLabel(this);
        });

        variationForm.on("click.wcboost-variation-swatches", ".wcboost-variation-swatches__item", function () {
            let $self = $(this);
            setTimeout(() => {
                onChange($self);
            }, 1);
        });

        variationForm.on("woocommerce_variation_has_changed", function () {
        });

        // Bound directly to each select's native `change` (fired by wcboost's own swatch-click
        // handler via `$select.val(value).trigger('change')`, and by the native dropdown too)
        // instead of WC's higher-level `show_variation`/`hide_variation` events — those only cover
        // the "a full valid combination was found / lost" cases, not every single attribute pick.
        variationForm.on("change", ".value select", function () {
            appendSelectedLabel(this);
        });

        variationForm.on("show_variation", function (e, variation) {
            updateOptions();
            updatePrice();
            updateBadgeSale(variation);
        }).on('hide_variation', function () {
            updateOptions();
            updatePrice();
            $(".tf-variation-dropdown-wrapper .select-item", variationForm).removeClass("active");
            // resetOptions();
        });

        variationForm.on("reset_focus", function () {
            resetOptions();
            variationForm.find(".value select").each(function () {
                appendSelectedLabel(this);
            });
        });

        $(".tf-variation-dropdown-wrapper .select-item", variationForm).on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass('disabled')) {
                return false;
            }
            $('.select-item', $(this).closest('.tf-variant-dropdown')).removeClass('active');
            $('.current-value', $(this).closest('.tf-variant-dropdown')).text($(this).text());
            $('select', $(this).closest('.tf-variation-items')).val($(this).data('value')).change();
            $(this).addClass('active');
        });

    }

    init();
})(jQuery);