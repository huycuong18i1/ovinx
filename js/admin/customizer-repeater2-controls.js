(function($){
    'use strict';

    function initRepeater($container) {
        if (!$container.length || $container.data('inited')) return;
        $container.data('inited', true);

        var $hidden = $container.find('.repeater-hidden-field');
        var $list   = $container.find('.repeater-list');
        var tplHtml = $container.closest('li').find('.tmpl-repeater-item').html();

        function updateValue() {
            var items = [];
            $list.find('.repeater-item').each(function(){
                var text = $(this).find('.repeater-textarea').val();
                var link = $(this).find('.repeater-link').val();
                var btn_text = $(this).find('.repeater-btn-text').val();
                items.push({ text, link, btn_text });
            });
            $hidden.val(JSON.stringify(items)).trigger('change');
        }

        $container.on('click', '.add-repeater-field', function(e){
            e.preventDefault();
            var $item = $(tplHtml);
            $list.append($item);
            updateValue();
        });

        $container.on('click', '.remove-repeater-item', function(e){
            e.preventDefault();
            $(this).closest('.repeater-item').remove();
            updateValue();
        });

        $container.on('input change', '.repeater-textarea, .repeater-link, .repeater-btn-text', updateValue);

        updateValue();
    }

    function initAllRepeaters() {
        $('[class*="repeater-items-"]').each(function(){
            initRepeater($(this));
        });
    }

    $(document).ready(function(){
        initAllRepeaters();

        // Customizer dynamic load
        if (window.MutationObserver) {
            new MutationObserver(function(mutations){
                mutations.forEach(function(m){
                    $(m.addedNodes).each(function(){
                        var $node = $(this);
                        if ($node.find('[class*="repeater-items-"]').length) {
                            initAllRepeaters();
                        }
                    });
                });
            }).observe(document.body, { childList: true, subtree: true });
        }
    });
})(jQuery);
