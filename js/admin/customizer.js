(function ($) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var themesflat_box_control = function () {
		$(".themesflat-options-control-box-controls input[type=text]").on("change", function () {
			var parent = $(this).parents(".themesflat-options-control-box-controls"),
				input_hidden = parent.find("input[type=hidden]"),
				settinglink = input_hidden.data('customize-setting-link');
			var data_position = {};
			parent.find('input[type=text]').each(function () {
				var $this = $(this);
				data_position[$this.data('position')] = $this.val();
			});
			input_hidden.val(JSON.stringify(data_position));
			if (api(settinglink))
				api.instance(settinglink).set(JSON.stringify(data_position));
		})

	}


	var SocialIcons = function () {
		var list = $('.themesflat_icons');
		var $document = $(document);
		var properties = list.find('.item-properties'),
			hiddenInput = list.parent().find('input[type="hidden"]'),
			settinglink = hiddenInput.data('customize-setting-link');

		if ($().sortable) {
			$document.find('.themesflat_icons').sortable({
				stop: function (event, ui) {
					list = ui.item.parent();
					hiddenInput = list.parent().find('input[type="hidden"]');
					updateOption();
				}
			});
		}

		var columnIndex = function (li) {
			var index = li.prevAll('.item').length + 1;
			while (index > 7) index = index - 7;
			return index;
		};

		var updateOption = function () {

			var ordering = [],
				icons = {};

			list.find('> li[data-id]').each(function () {

				ordering.push($(this).attr('data-id'));

				if ($(this).attr('data-link') !== undefined)
					icons[$(this).attr('data-id')] = $(this).attr('data-link');
			});

			icons['__ordering__'] = ordering;


			hiddenInput.val(JSON.stringify(icons));

			if (api(settinglink)) {
				api.instance(settinglink).set(JSON.stringify(icons));
			}
		};

		var toggleEdit = function () {
			var li = $(this),
				liIndex = columnIndex(li),
				liNextItems = li.nextAll('.item'),
				liIndexRemain = 7 - liIndex,
				rightItems = $.makeArray(liNextItems).slice(0, liIndexRemain);
			list = li.parent();
			hiddenInput = list.parent().find('input[type="hidden"]'),
				settinglink = hiddenInput.data('customize-setting-link');
			properties = list.find('.item-properties');
			if ($().sortable) {
				list.sortable();
			}

			if (li.hasClass('active')) {
				confirmChange();
				return;
			}

			properties.addClass('property_active');
			list.children().removeClass('active');
			li.addClass('active');

			if (rightItems.length == 0) li.after(properties);
			else $(rightItems.pop()).after(properties);

			properties.find('.input-title').text(li.attr('data-title'));
			properties.find('.input-field').val(li.attr('data-link'));
			properties.find('.input-field').get(0).focus();
		};

		var cancelEdit = function () {
			properties.removeClass('property_active');
			list.children().removeClass('active');
		};

		var confirmChange = function () {
			properties = list.find('.item-properties').first();
			properties.removeClass('property_active');
			if (properties.find('.input-field').val().trim() != '')
				list.find('li.active').attr('data-link', properties.find('.input-field').val());
			else
				list.find('li.active').removeAttr('data-link');

			updateOption(list);
			cancelEdit();
		};

		$document.on("click", 'button.cancel', cancelEdit);
		$document.on("click", 'button.confirm', confirmChange);

		$document.on('keydown', 'input.input-field', function (e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				confirmChange();
			}

			if (e.keyCode == 27) {
				e.preventDefault();
				cancelEdit();
			}
		});

		$document.on("click", '.themesflat_icons .item', toggleEdit);
	}

	var themesflat_Slide_Control = function () {
		$('.slider-custom-control').each(function () {
			var sliderValue = $(this).find('.customize-control-slider-value').val();
			var newSlider = $(this).find('.slider-control');
			var sliderMinValue = parseInt(newSlider.attr('slider-min-value'));
			var sliderMaxValue = parseInt(newSlider.attr('slider-max-value'));
			var sliderStepValue = parseInt(newSlider.attr('slider-step-value'));

			newSlider.slider({
				value: sliderValue,
				min: sliderMinValue,
				max: sliderMaxValue,
				step: sliderStepValue,
				change: function (e, ui) {
					$(this).parent().find('.customize-control-slider-value').trigger('change');
				}
			});
		});

		$('.slider-control').on('slide', function (event, ui) {
			$(this).parent().find('.customize-control-slider-value').val(ui.value);
		});

		$('.slider-reset').on('click', function () {
			var resetValue = $(this).attr('slider-reset-value');
			$(this).parent().find('.customize-control-slider-value').val(resetValue);
			$(this).parent().find('.slider-control').slider('value', resetValue);
		});

		$('.customize-control-slider-value').blur(function () {
			var resetValue = $(this).val();
			var slider = $(this).parent().find('.slider-control');
			var sliderMinValue = parseInt(slider.attr('slider-min-value'));
			var sliderMaxValue = parseInt(slider.attr('slider-max-value'));

			if (resetValue < sliderMinValue) {
				resetValue = sliderMinValue;
				$(this).val(resetValue);
			}
			if (resetValue > sliderMaxValue) {
				resetValue = sliderMaxValue;
				$(this).val(resetValue);
			}
			$(this).parent().find('.slider-control').slider('value', resetValue);
		});
	}

	var Typography = (function () {
		function Typography(element, options) {
			if ($(element).length != 0) {
				if ($().choosen) {
					$(".select-choosen").chosen();
				}
				var root = $(element),
					settingLink = root.find("#typography-value").attr('data-customize-setting-link');
				var data_variants = JSON.parse(root.find("#datas").attr('data_variants')),
					data_subsets = JSON.parse(root.find("#datas").attr('data_subsets'));
				root.find('.typography-font select').on('change', function () {
					var variants = $(this).find('option:selected').attr('data_variants'),
						fontWeight = $(this).closest(element).find('.typography-style select'),
						currentVariant = fontWeight.val();
					fontWeight.empty();

					if (variants !== undefined) {
						$.each(JSON.parse(variants), function (index, value) {
							value = value.trim();
							fontWeight.append($('<option />', {
								value: value
							}).text(
								data_variants[value] !== undefined ? data_variants[value] : value
							));
						});
					}

					fontWeight.val(currentVariant);

					var subsets = $(this).find('option:selected').attr('data_subsets'),
						subset = $(this).closest(element).find('.typography-subsets .themesflat-options-control-inputs');

					subset.empty();
					var switcher_subset;

					if (subsets !== undefined) {
						$.each(JSON.parse(subsets), function (index, value) {
							value = value.trim();
							var _value = data_subsets[value] !== undefined ? data_subsets[value] : value;
							switcher_subset = '\
                                                <label class="_options-switcher-subsets">\
                                                        <span class="themesflat-options-control-title">' + _value + '</span>\
                                                        <input type="checkbox" value="' + value + '" name="_themesflat-options-control-typography-' + settingLink + '[subsets]">\
                                                        <span class="themesflat-options-control-indicator">\
                                                                <span></span>\
                                                        </span>\
                                                </label>';
							subset.append(switcher_subset);
						});
					}

				});

				var save_customize = function (a) {
					settingLink = a.find("#typography-value").attr('data-customize-setting-link');
					if (wp.customize && settingLink) {
						var __subsets = [];
						root.find('._options-switcher-subsets input[type="checkbox"]:checked').each(function () {
							__subsets.push($(this).val());
						});

						wp.customize.instance(settingLink).set(JSON.stringify({
							family: a.find('.typography-font select').val(),
							size: a.find('.typography-size input').val(),
							line_height: a.find('.typography-line_height input').val(),
							letter_spacing: a.find('.typography-letter_spacing input').val(),
							style: a.find('.typography-style select').val(),
							color: a.find('.typography-color .themesflat-color-picker').val(),
							subsets: __subsets
						}));
					}
				}

				root.on('change', 'select, input', function () {
					save_customize($(this).closest('.themesflat-options-control-typography'));
				});

			};

		};
		return Typography;
	})();

	$(document).on('widget-updated', function (e, widget) {
		SocialIcons();
	});

	var category_image = function () {
		var file_frame;

		$('.upload-image-button').on('click', function (event) {
			event.preventDefault();
			if (file_frame) {
				file_frame.open();
				return;
			}
			file_frame = wp.media({
				title: 'Select or Upload an Image',
				button: {
					text: 'Use this image'
				},
				multiple: false
			});

			file_frame.on('select', function () {
				var attachment = file_frame.state().get('selection').first().toJSON();
				$('#category-image').val(attachment.id);
				$('#category-image-preview').html('<img src="' + attachment.url + '" style="max-width:100px;"/>');
			});

			file_frame.open();
		});
	}

	var wishlist = function () {
		$("#tf_wishlist").change(function () {
			if ($(this).prop('checked')) {
				$("#customize-control-wcboost_wishlist_single_button_position").hide();
				$("#customize-control-wcboost_wishlist_loop_button_position").hide();
			} else {
				$("#customize-control-wcboost_wishlist_single_button_position").show();
				$("#customize-control-wcboost_wishlist_loop_button_position").show();
			}
		});
		$("#tf_wishlist").change();
	};

	var extraDesciption = function () {
		if (!wp?.customize?.control) {
			return;
		}
		wp.customize.control('tf_trust_seal_items', function (control) {

			var previewImages = function () {
				var imageUrls = control.container.find('input').val();
				var previewBox = control.container.find('.selected-images-preview');
				if (imageUrls) {
					var urls = imageUrls.split(',');
					var html = '';
					urls.forEach(function (url) {
						html += `
								<div class="img-item">
									<img src="${url}"/>
									<span class="remove-image">×</span>
								</div>
							`;
					});
					previewBox.html(html);
				}
			};

			var sortImages = function () {
				const imageInput = control.container.find('input').get(0);
				const previewBox = control.container.find('.selected-images-preview').get(0);

				if (previewBox && imageInput) {
					Sortable.create(previewBox, {
						animation: 150,
						filter: '.remove-image',
						preventOnFilter: false,
						onFilter: function (evt) {
							var $element = $(evt.target);
							if (!$element.hasClass('remove-image')) {
								return;
							}
							var $imageInput = control.container.find('input'),
								imageUrls = $imageInput.val(),
								urls = imageUrls.split(','),
								index = $element.index();

							if (index > -1) {
								urls.splice(index, 1);
							}

							$element.closest('.img-item').remove();
							$imageInput.val(urls.join(',')).change();
						},
						onStart: () => {
							previewBox.classList.add('is-sorting');
						},
						onEnd: function () {
							previewBox.classList.remove('is-sorting');
							const imageUrls = Array.from(previewBox.querySelectorAll('img'))
								.map(img => img.src)
								.join(',');

							imageInput.value = imageUrls;
							imageInput.dispatchEvent(new Event('input', { bubbles: true }));
						}
					});
				}
			}

			control.container.find('.tf-btn').on('click', function (e) {
				e.preventDefault();

				// var imageUrls = control.container.find('input').val();

				var frame = wp.media({
					title: 'Select Images',
					button: {
						text: 'Select'
					},
					multiple: true
				});

				frame.on('select', function () {
					var selected = frame.state().get('selection').toJSON();
					var urls = [];

					selected.forEach(function (image) {
						urls.push(image.url);
					});

					control.container.find('input').val(urls.join(',')).change();
					previewImages();
				});

				frame.open();
			});

			control.container.find('.remove-image-hidden').on('click', function (e) {
				e.preventDefault();
				var $imageInput = control.container.find('input'),
					imageUrls = $imageInput.val(),
					urls = imageUrls.split(','),
					index = $(this).closest('.img-item').index();
				if (index > -1) {
					urls.splice(index, 1);
				}
				$(this).closest('.img-item').remove();
				$imageInput.val(urls.join(',')).change();
			});
			// previewImages();
			sortImages();
		});
	};

	var singleProduct = function () {
		wishlist();
		extraDesciption();
	};

	var themesflatResponsiveColumnsSwitch = function () {

		if (!wp || !wp.customize) return;

		wp.customize.control.each(function (control) {

			if (control.params.type !== 'responsive-columns-switch') {
				return;
			}

			var wrapper = control.container;

			function setDevice(device) {
				wrapper.find('.tf-tab').removeClass('active');
				wrapper.find('.tf-tab[data-device="' + device + '"]').addClass('active');

				wrapper.find('.tf-input').addClass('hidden');
				wrapper.find('.tf-' + device).removeClass('hidden');
			}

			// Click tab
			wrapper.on('click', '.tf-tab', function () {

				var selected = $(this).data('device');
				setDevice(selected);

				if (wp.customize.previewedDevice) {
					wp.customize.previewedDevice.set(selected);
				}
			});

			// Input change -> update setting
			wrapper.on('input change', '.tf-input', function () {

				var data = {};

				wrapper.find('.tf-input').each(function () {
					data[$(this).data('device')] =
						parseInt($(this).val(), 10) || 1;
				});

				control.setting.set(JSON.stringify(data));
			});

			// Sync when switching preview device
			if (wp.customize.previewedDevice) {
				wp.customize.previewedDevice.bind(function (device) {
					setDevice(device);
				});
			}

		});
	};

	var themesflatDragAndDropControl = function () {

		$('.themesflat-sortable').each(function () {
		var $wrapper   = $(this);
		var $sortable  = $wrapper.find('ul');
		var inputId    = $sortable.data('input');
		var $input     = $('#' + inputId);

		if (!$sortable.length || !$input.length) return;

		$sortable.sortable({
			stop: function () {
				updateValue();
			}
		});

		$sortable.disableSelection();

		$sortable.on('click', '.themesflat-hide-sortee', function () {
			$(this)
				.toggleClass('icon-EyeOpen icon-EyeSlash')
				.closest('li')
				.toggleClass('themesflat-hide');

			updateValue();
		});

		function updateValue() {
			var values = [];

			$sortable.find('li').each(function () {
				if (!$(this).hasClass('themesflat-hide')) {
					values.push($(this).data('value'));
				}
			});

			$input.val(values.join(',')).trigger('change');
		}
	});
	};
	
	var themesflatResponsiveSliderControl = function () {
	if (!window.wp || !wp.customize) return;

	function initWrapper($wrap) {
		if (!$wrap || !$wrap.length) return;
		if ($wrap.data("tf-inited")) return;
		$wrap.data("tf-inited", true);

		// lấy setting link từ hidden input do $this->link() tạo
		var $hidden = $wrap.find('input[type="hidden"][data-customize-setting-link]').first();
		var settingLink = $hidden.data("customize-setting-link");

		function setDevice(device) {
		$wrap.find(".tf-tab").removeClass("active");
		$wrap.find('.tf-tab[data-device="' + device + '"]').addClass("active");

		$wrap.find(".tf-slider, .tf-slider-value").addClass("hidden");
		$wrap.find(".tf-" + device).removeClass("hidden");
		$wrap.find(".tf-" + device + "-val").removeClass("hidden");
		}

		function collect() {
		var data = {};
		$wrap.find(".tf-slider").each(function () {
			var d = $(this).data("device");
			data[d] = parseInt($(this).val(), 10) || 0;
		});
		return data;
		}

		function setSetting(json) {
		// update hidden cho đúng UI
		if ($hidden.length) $hidden.val(json);

		// set thẳng setting (không trigger change để tránh loop)
		if (settingLink && wp.customize.instance(settingLink)) {
			wp.customize.instance(settingLink).set(json);
		}
		}

		// click tab
		$wrap.on("click", ".tf-tab", function () {
		var device = $(this).data("device");
		setDevice(device);

		if (wp.customize.previewedDevice) {
			wp.customize.previewedDevice.set(device);
		}
		});

		// slider change
		$wrap.on("input change", ".tf-slider", function () {
		var device = $(this).data("device");
		var val = $(this).val();

		$wrap.find(".tf-" + device + "-val").text(val);
		setSetting(JSON.stringify(collect()));
		});

		// sync theo device của customizer
		if (wp.customize.previewedDevice) {
		wp.customize.previewedDevice.bind(function (device) {
			setDevice(device);
		});
		setDevice(wp.customize.previewedDevice.get() || "desktop");
		} else {
		setDevice("desktop");
		}

		// sync initial
		setSetting(JSON.stringify(collect()));
	}

	function initAll() {
		$(".tf-responsive-slider-wrapper").each(function () {
		initWrapper($(this));
		});
	}

	// init khi ready
	wp.customize.bind("ready", function () {
		initAll();

		// nếu control render lại sau đó, init lại
		setTimeout(initAll, 0);
	});

	// nếu có selective refresh / add control
	if (wp.customize.control && wp.customize.control.bind) {
		wp.customize.control.bind("add", function () {
		initAll();
		});
	}
	};

	var themesflatRepeaterControls = function () {
	if (!window.wp || !wp.customize) return;

	function buildItem(index) {
		var $li = $('<li class="repeater-item"></li>');
		$li.append('<label>Item ' + (index + 1) + "</label>");
		$li.append('<textarea class="repeater-textarea" placeholder="Enter text..."></textarea>');
		$li.append('<input type="text" class="repeater-link" placeholder="Enter link..." />');
		$li.append('<button type="button" class="button-secondary remove-repeater-item">Remove</button>');
		return $li;
	}

	function renumber($wrap) {
		$wrap.find(".repeater-item > label").each(function (i) {
		$(this).text("Item " + (i + 1));
		});
	}

	function sync($wrap) {
		var $hidden = $wrap.find(".repeater-hidden-field").first();
		var settingLink = $hidden.data("customize-setting-link");

		var data = [];
		$wrap.find(".repeater-item").each(function () {
		var $it = $(this);
		data.push({
			text: $it.find(".repeater-textarea").val() || "",
			link: $it.find(".repeater-link").val() || "",
		});
		});

		var json = JSON.stringify(data);

		// update hidden for UI
		$hidden.val(json);

		// set thẳng setting để customizer nhận (tránh trigger change loop)
		if (settingLink && wp.customize.instance(settingLink)) {
		wp.customize.instance(settingLink).set(json);
		}
	}

	function init($root) {
		if (!$root.length) return;
		if ($root.data("tf-inited")) return;
		$root.data("tf-inited", true);

		// add
		$root.on("click", ".add-repeater-field", function (e) {
		e.preventDefault();
		var $list = $root.find(".repeater-list").first();
		$list.append(buildItem($list.find(".repeater-item").length));
		renumber($root);
		sync($root);
		});

		// remove
		$root.on("click", ".remove-repeater-item", function (e) {
		e.preventDefault();
		$(this).closest(".repeater-item").remove();
		renumber($root);
		sync($root);
		});

		// change
		$root.on("input change", ".repeater-textarea, .repeater-link", function () {
		sync($root);
		});

		// initial
		renumber($root);
		sync($root);
	}

	function initAll() {
		// control này nằm trong <li> themesflat-options-control-repeater-controls
		$(".themesflat-options-control-repeater-controls").each(function () {
		init($(this));
		});
	}

	wp.customize.bind("ready", function () {
		initAll();
		setTimeout(initAll, 0);
	});

	if (wp.customize.control && wp.customize.control.bind) {
		wp.customize.control.bind("add", function () {
		initAll();
		});
	}
	};

	var themesflatRepeaterControlsV2 = function () {
	if (!window.wp || !wp.customize) return;

	function getWrap($control) {
		// wrapper của repeater (nơi chứa data-has-btn-text + list + hidden)
		return $control.find("[data-has-btn-text]").first();
	}

	function getHasBtnText($control) {
		var $wrap = getWrap($control);
		return $wrap.length && String($wrap.data("has-btn-text")) === "1";
	}

	function getHidden($control) {
		return $control.find(".repeater-hidden-field").first();
	}

	function buildItem(index, hasBtnText) {
		var $li = $('<li class="repeater-item"></li>');

		$li.append('<label>Item ' + (index + 1) + "</label>");
		$li.append('<textarea class="repeater-textarea" placeholder="Enter text..."></textarea>');
		$li.append('<input type="text" class="repeater-link" placeholder="Enter link..." />');

		if (hasBtnText) {
		$li.append('<input type="text" class="repeater-btn-text" placeholder="Enter button text..." />');
		}

		$li.append('<button type="button" class="button-secondary remove-repeater-item">Remove</button>');
		return $li;
	}

	function renumber($control) {
		$control.find(".repeater-item > label").each(function (i) {
		$(this).text("Item " + (i + 1));
		});
	}

	function sync($control) {
		var $hidden = getHidden($control);
		if (!$hidden.length) return;

		var settingLink = $hidden.data("customize-setting-link");
		var hasBtnText = getHasBtnText($control);

		var data = [];
		$control.find(".repeater-item").each(function () {
		var $it = $(this);
		var obj = {
			text: $it.find(".repeater-textarea").val() || "",
			link: $it.find(".repeater-link").val() || "",
		};
		if (hasBtnText) {
			obj.btn_text = $it.find(".repeater-btn-text").val() || "";
		}
		data.push(obj);
		});

		var json = JSON.stringify(data);
		$hidden.val(json);

		if (settingLink && wp.customize.instance(settingLink)) {
		wp.customize.instance(settingLink).set(json);
		}
	}

	function init($control) {
		if (!$control.length) return;
		if ($control.data("tf-inited")) return;
		$control.data("tf-inited", true);

		// determine once per control
		var hasBtnText = getHasBtnText($control);

		$control.on("click", ".add-repeater-field", function (e) {
		e.preventDefault();

		var $wrap = getWrap($control);
		var $list = $wrap.find(".repeater-list").first();

		$list.append(buildItem($list.find(".repeater-item").length, hasBtnText));
		renumber($control);
		sync($control);
		});

		$control.on("click", ".remove-repeater-item", function (e) {
		e.preventDefault();
		$(this).closest(".repeater-item").remove();
		renumber($control);
		sync($control);
		});

		$control.on("input change", ".repeater-textarea, .repeater-link, .repeater-btn-text", function () {
		sync($control);
		});

		renumber($control);
		sync($control);
	}

	function initAll() {
		$(".themesflat-options-control-repeater-controls").each(function () {
		var $c = $(this);
		if ($c.find(".repeater-list").length && $c.find(".repeater-hidden-field").length) {
			init($c);
		}
		});
	}

	wp.customize.bind("ready", function () {
		initAll();
		setTimeout(initAll, 0);
	});

	if (wp.customize.control && wp.customize.control.bind) {
		wp.customize.control.bind("add", function () {
		initAll();
		});
	}
	};

	$(function () {
		SocialIcons();
		themesflat_box_control();
		themesflat_Slide_Control();
		Typography('.themesflat-options-control-typography');
		category_image();
		singleProduct();
		$('.short-input').wpColorPicker();
		themesflatResponsiveColumnsSwitch();
		themesflatDragAndDropControl();
		themesflatResponsiveSliderControl();
		// themesflatRepeaterControls();
		themesflatRepeaterControlsV2();
	})

})(jQuery);
