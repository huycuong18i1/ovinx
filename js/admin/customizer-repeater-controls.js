(function($){
    'use strict';

    function debug() {
        if (window.console && console.log) {
            console.log.apply(console, arguments);
        }
    }

    function initRepeater($container) {
        if (!$container || !$container.length) return;
        if ($container.data('repeater-inited')) return; // tránh init lại
        $container.data('repeater-inited', true);
        debug('initRepeater for', $container);

        var $hidden = $container.find('.repeater-hidden-field');
        var $list   = $container.find('.repeater-list');
        var tplHtml = $container.find('.tmpl-repeater-item').html() || '';

        function updateValue(){
            var items = [];
            $container.find('.repeater-item').each(function(){
                var text = $(this).find('.repeater-textarea').val();
                var link = $(this).find('.repeater-link').val();
                items.push({ text: text, link: link });
            });
            $hidden.val(JSON.stringify(items)).trigger('change');
            debug('updateValue ->', items);
        }

        // delegate events inside container
        $container.on('click', '.add-repeater-field', function(e){
            e.preventDefault();
            if (!tplHtml) {
                debug('Template missing for', $container);
                return;
            }
            var $item = $(tplHtml);
            $list.append($item);
            updateValue();
        });

        $container.on('click', '.remove-repeater-item', function(e){
            e.preventDefault();
            $(this).closest('.repeater-item').remove();
            updateValue();
        });

        $container.on('input change', '.repeater-textarea, .repeater-link', updateValue);

        // initial sync
        updateValue();

        // if sortable needed in future: init here (jquery-ui)
    }

    // scan existing containers
    function scanAndInit() {
        $('.repeater-items-<?php /* placeholder removed - handled below */ ?>').each(function(){});
    }

    // Instead of hardcoding an id part, initialize for any control structure
    function initAll() {
        // find all controls that match our pattern
        $('[class*="repeater-items-"]').each(function(){
            var $containerWrap = $(this);
            // only initialize the wrapper that directly contains list & hidden
            initRepeater($containerWrap);
        });
    }

    // On document ready
    $(function(){
        debug('customizer-repeater-controls.js loaded');
        initAll();

        // Watch DOM additions (Customizer may inject controls)
        var target = document.body;
        if (window.MutationObserver) {
            var mo = new MutationObserver(function(muts){
                muts.forEach(function(m){
                    if (!m.addedNodes) return;
                    m.addedNodes.forEach(function(node){
                        if (node.nodeType !== 1) return;
                        var $node = $(node);
                        // if the added node contains our repeater
                        $node.find('[class*="repeater-items-"]').addBack('[class*="repeater-items-"]').each(function(){
                            initRepeater($(this));
                        });
                    });
                });
            });
            mo.observe(target, { childList: true, subtree: true });
            debug('MutationObserver attached');
        } else {
            // fallback: re-run init periodically (only as fallback)
            setInterval(initAll, 1500);
        }
    });

    // Expose helper for manual debug in console
    window.themesflatRepeaterDebug = {
        initAll: initAll
    };

})(jQuery);