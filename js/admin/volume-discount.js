(function($) {
    "use strict";

    var initVolumeDiscount = function(){
        searchProducts();
        choiceMedia();
        newItem();
        removeItem();
        changeLayout();
        updateTag();
        updateItem();
        updateData();
        $('.volume-discount-items').removeClass('loading');
    }

    var searchProducts = function(){
        let $select = $(this);
        $('.volume-discount-products').select2({
            placeholder: $select.attr('data-placeholder') || 'Search...',
            minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        action: 'tf_search_products',
                        security: tfWooParams.tf_search_products_nonce,
                        search: params.term,
                    };
                },
                processResults: function (data) {
                    return {    
                        results: data.data.items
                    };
                },
                cache: true,
                // data: data
            }
        });
    }

    var choiceMedia = function(){
        var mediaUploader;
        var $currentBtn;

        $('.volume-discount-items').on('click' , '.volume-discount-image-button', function(e) {
            e.preventDefault();
            $currentBtn = $(this);

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

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('.volume-discount-image' , $currentBtn.closest('.volume-discount-item-thumbnails') ).val(attachment.url);
                $('.image-preview-container' , $currentBtn.closest('.volume-discount-item-thumbnails') ).show();
                $('.image-preview > img' , $currentBtn.closest('.volume-discount-item-thumbnails') ).attr('src', attachment.url);
            });

            mediaUploader.open();
        });

        $('.volume-discount-items').on('click' , '.remove-image', function(e) {
            e.preventDefault();
            $('.volume-discount-image' , $(this).closest('.volume-discount-item-thumbnails') ).val('');
            $('.image-preview-container' , $(this).closest('.volume-discount-item-thumbnails') ).hide();
        });

        $('.volume-discount-image').each( function(){
            if( $(this).val() != '' ){
                $('.image-preview-container', $(this).closest('.volume-discount-item-thumbnails') ).show();        
            }
        });
    };

    var newItem = function(){
        $('.volume-discount-items').on('click' , '.new-item-btn', function(e) {
            e.preventDefault();
            let newItem = $('.volume-discount-item').last().clone();
            let newFrom = isNaN($('input[name="to"]', newItem).val()) ? 0 : parseInt($('input[name="to"]', newItem).val()) + 1;
            $('input, select' , newItem)
                .val('')
                .prop('checked', false);
            $('input[name="from"]', newItem).val(newFrom);
            $('.tag-label, .tag-style, .tag-color, .tag-icon' , newItem ).hide();
            $('.image-preview-container' , newItem).hide();
            $('img' , newItem).attr('src', '');
            $(this).before(newItem);
            updateItem();
        });
    };

    var removeItem = function(){
        $('.volume-discount-items').on('click' , '.remove-item-btn', function(e) {
            e.preventDefault();
            if( $('.remove-item-btn').length > 1 ){
                $(this).closest('.volume-discount-item').remove();
            }
            updateItem();
        });
    };

    var changeLayout = function(){
        $(".volume-discount-style").change( function(){
            updateItem();
        });
    };

    var updateTag =  function(){
        $('.volume-discount-items').on('change' , '.tag-enable', function(){
            if( $(this).prop("checked") ){
                $('.tag-label, .tag-style, .tag-color, .tag-icon' , $(this).closest('.volume-discount-item-options') ).show();
            }else{
                $('.tag-label, .tag-style, .tag-color, .tag-icon' , $(this).closest('.volume-discount-item-options') ).hide();
            }
        });

        $('.tag-enable').each(function(){
            if( $(this).prop("checked") ){
                $('.tag-label, .tag-style, .tag-color, .tag-icon' , $(this).closest('.volume-discount-item-options') ).show();
            }else{
                $('.tag-label, .tag-style, .tag-color, .tag-icon' , $(this).closest('.volume-discount-item-options') ).hide();
            }
        });
    };

    var updateItem = function(){
        if( $('.remove-item-btn').length > 1 ){
            $('.remove-item-btn').show();
        }else{
            $('.remove-item-btn').hide();
        }

        if( $(".volume-discount-style").val() == "thumbnail" ){
            $('.volume-discount-item-thumbnails').show();
        }else{
            $('.volume-discount-item-thumbnails').hide();
        }
    };

    var updateData = function(){
        $('form').on('submit', function(e) {
            let data = [];
            $(".volume-discount-item").each( function(index){
                
                let volume = {};
                $("input:not([type='checkbox']),select", $(this)).each( function(){
                    volume[$(this).attr('name')] = $(this).val();
                });
                $("input[type='checkbox']", $(this)).each( function(){
                    if( $(this).prop("checked") ){
                        volume[$(this).attr('name')] = true;
                    }else{
                        volume[$(this).attr('name')] = '';
                    }
                });
                data[index] = volume;
            });
            $('.volume-discount-data').val(JSON.stringify(data));
        });
    }

    initVolumeDiscount();

})(jQuery);