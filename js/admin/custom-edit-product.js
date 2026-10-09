
jQuery(document).ready(function ($) {

});

(function ($) {
    "use strict";

    var init = function () {
        sizeGuide();
        productVideo();
        productModelViewer();
        variationImages();
    };

    var sizeGuide = function () {
        var updateSizeGuideFields = function () {
            if ($("#_tf_size_guide_display").val() == 'button') {
                $("._tf_size_guide_button_position_field").show();
                if ($("#_tf_size_guide_button_position").val() == 'attribute') {
                    $("._tf_size_guide_attribute_field").show();
                } else {
                    $("._tf_size_guide_attribute_field").hide();
                }
            } else {
                $("._tf_size_guide_button_position_field").hide();
                $("._tf_size_guide_attribute_field").hide();
            }
        }

        updateSizeGuideFields();

        $('select', $('#tf_size_guide_product_data')).on('change', function () {
            updateSizeGuideFields();
        });
    }

    var productVideo = function () {
        let mediaUploader;

        $('#tf_video_product_data .tf-select-thumb-btn').on('click', function (e) {
            e.preventDefault();
            let $currentBtn = $(this);

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#_tf_video_thumb', $currentBtn.closest('#tf_video_product_data')).val(attachment.url);
                $('.image-preview-container', $currentBtn.closest('#tf_video_product_data')).show();
                $('.image-preview > img', $currentBtn.closest('#tf_video_product_data'))
                    .attr('src', attachment.url)
                    .attr('data-src', attachment.url);
            });

            mediaUploader.open();
        });

        $('#tf_video_product_data .tf-remove-thumb-btn').on('click', function (e) {
            e.preventDefault();
            $('#_tf_video_thumb', $(this).closest('#tf_video_product_data')).val('');
            $('.image-preview-container', $(this).closest('#tf_video_product_data')).hide();
        });

        if ($('#_tf_video_thumb').val() != '') {
            $('.image-preview-container', $('#_tf_video_thumb').closest('#tf_video_product_data')).show();
        }
    };

    var productModelViewer = function () {
        let mediaUploader;

        $('#tf_3d_viewer_product_data .tf-select-thumb-btn').on('click', function (e) {
            e.preventDefault();
            let $currentBtn = $(this);

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#_tf_3d_viewer_thumb', $currentBtn.closest('#tf_3d_viewer_product_data')).val(attachment.url);
                $('.image-preview-container', $currentBtn.closest('#tf_3d_viewer_product_data')).show();
                $('.image-preview > img', $currentBtn.closest('#tf_3d_viewer_product_data'))
                    .attr('src', attachment.url)
                    .attr('data-src', attachment.url);
            });

            mediaUploader.open();
        });

        $('#tf_3d_viewer_product_data .tf-remove-thumb-btn').on('click', function (e) {
            e.preventDefault();
            $('#_tf_3d_viewer_thumb', $(this).closest('#tf_3d_viewer_product_data')).val('');
            $('.image-preview-container', $(this).closest('#tf_3d_viewer_product_data')).hide();
        });

        if ($('#_tf_3d_viewer_thumb').val() != '') {
            $('.image-preview-container', $('#_tf_3d_viewer_thumb').closest('#tf_3d_viewer_product_data')).show();
        }
    };

    var variationImages = function () {

        var imagePreview = function (inputElement, urls) {
            var boxImg = $(".image-preview-container", $(inputElement).closest('.tf-variation-gallery-options_group')),
                imagePreview = $('.image-preview-el', $(inputElement).closest('.tf-variation-gallery-options_group'));

            // boxImg.empty();

            urls.forEach(function (id) {
                if (!id) {
                    return true;
                }
                var imagePreviewTag = imagePreview.clone();
                imagePreviewTag
                    .removeClass()
                    .addClass('image-preview');
                var attachment = wp.media.attachment(id);
                attachment.fetch().then(function () {
                    var url = attachment.get('url');
                    $('img', imagePreviewTag)
                        .attr('src', url)
                        .attr('data-src', url);
                });
                boxImg.append(imagePreviewTag);
            });
        }

        $(document).on('click', '.variation-gallery-box .tf-remove-image-btn', function (e) {
            e.preventDefault();
            var hidden_input = $('.tf-input-gallery', $(this).closest('.tf-variation-gallery-options_group')),
                urls = [];
            if (hidden_input.val()) {
                try {
                    urls = JSON.parse(hidden_input.val());
                } catch (e) {
                    urls = [];
                }
                urls.splice($(this).closest('.image-preview').index(), 1);
                hidden_input.val(JSON.stringify(urls)).change();
                $(this).closest('.image-preview').remove();
            }
        });

        $(document).on('input_gallery_updated', '.tf-input-gallery', function (e, urls) {
            imagePreview(this, urls);
        });

        $(document).on('click', '.variation-gallery-box .tf-select-image-btn', function (e) {
            e.preventDefault();

            var button = $(this),
                hidden_input = $('.tf-input-gallery', button.closest('.tf-variation-gallery-options_group'));

            var media_frame = wp.media({
                title: 'Select Images',
                button: {
                    text: 'Use selected images'
                },
                multiple: true
            });

            media_frame.on('select', function () {
                var selected = media_frame.state().get('selection');
                var urls = [],
                    current_urls = [];

                selected.each(function (attachment) {
                    // urls.push(attachment.attributes.url);
                    urls.push(attachment.id);
                });

                if (hidden_input.val()) {
                    try {
                        current_urls = JSON.parse(hidden_input.val());
                    } catch (e) {
                        current_urls = [];
                    }
                }

                current_urls = current_urls.concat(urls);

                hidden_input.val(JSON.stringify(current_urls))
                    .change()
                    .trigger('input_gallery_updated', [urls]);
            });

            media_frame.open();
        });
    }

    init();

})(jQuery);