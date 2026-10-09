jQuery(document).ready(function ($) {

    function waitForModalAndInsertFields() {
        const observer = new MutationObserver((mutations, obs) => {
            const modal = $('.components-modal__frame');
            if (modal?.length) {
                obs.disconnect();
                const $modal = $(modal);
                addCustomFields($modal);
                modal.addClass('frame-loaded');
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    function addCustomFields(modal) {
        const mapUrlField = `
            <div class="components-base-control">
                <label class="components-base-control__label">Google Map URL</label>
                <input type="text" class="components-text-control__input" name="pickup_map_url" />
            </div>`;
        const phoneField = `
            <div class="components-base-control">
                <label class="components-base-control__label">Pickup Phone</label>
                <input type="text" class="components-text-control__input" name="pickup_phone" />
            </div>`;

        const detailsInput = modal.find('input[name="pickup_details"]').closest('.components-base-control');
        if (detailsInput.length && modal.find('input[name="pickup_map_url"]').length === 0) {
            $(phoneField).insertAfter(detailsInput);
            $(mapUrlField).insertAfter(detailsInput);
        }
    }

    $(document).on('click', '.pickup-locations .button-link-edit, .pickup-locations tfoot button.components-button', function () {
        setTimeout(function () {
            const modal = $('.components-modal__frame');
            addCustomFields(modal);

            const dataField = $(this).attr('data-pickup_location');
            console.log(dataField);
            if (dataField) {
                try {
                    const data = JSON.parse(dataField);
                    if (data.pickup_map_url) {
                        modal.find('input[name="pickup_map_url"]').val(data.pickup_map_url);
                    }
                    if (data.pickup_phone) {
                        modal.find('input[name="pickup_phone"]').val(data.pickup_phone);
                    }
                } catch (e) {
                    console.warn("Cannot parse pickup_location data.");
                }
            }

            modal.addClass('frame-loaded');
        }, 300);
    });

});