(function ($) {
    const { useEffect, createElement } = wp.element;
    const { render } = wp.element;

    function PickupFieldInjector() {
        useEffect(() => {
            const target = document.body;
            const observer = new MutationObserver((mutations, obs) => {
                const modal = document.querySelector('.components-modal__frame');
                if (!modal) return;

                if (!modal.querySelector('input[name="pickup_phone"]')) {
                    const detailsGroup = modal.querySelector('input[name="details"]')
                        ?.closest('.components-base-control');
                    if (detailsGroup) {
                        detailsGroup.insertAdjacentHTML('afterend', `
                            <div class="components-base-control">
                                <label class="components-base-control__label">Pickup Phone</label>
                                <input type="text" class="components-text-control__input" name="pickup_phone" />
                            </div>
                            <div class="components-base-control">
                                <label class="components-base-control__label">Google Map URL</label>
                                <input type="text" class="components-text-control__input" name="pickup_map_url" />
                            </div>
                        `);
                    }
                }
            });

            observer.observe(target, { childList: true, subtree: true });
            return () => observer.disconnect();
        }, []);

        return null;
    }

    // Mount component vào body
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.createElement('div');
        document.body.appendChild(container);
        render(createElement(PickupFieldInjector), container);
    });
})(jQuery);