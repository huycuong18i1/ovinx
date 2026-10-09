(function ($) {
    "use strict";

    var initSizeGuide = function () {
        tableActions();
        // choiceMedia();
    }

    var choiceMedia = function () {
        var mediaUploader;

        $('#size-guide-image-button').on('click', function (e) {
            e.preventDefault();

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
                $('#size-guide-table-image').val(attachment.url);
                $('#image-preview-container').show();
                $('#image-preview > img').attr('src', attachment.url);
            });

            mediaUploader.open();
        });

        $('#remove-image').on('click', function (e) {
            e.preventDefault();
            $('#size_guide_image_url').val('');
            $('#image-preview-container').hide();
        });

        if ($('#size_guide_image_url').val() != '') {
            $('#image-preview-container').show();
        }
    }

    var tableActions = function () {
        let table = $("#dynamic-table");

        $(table).on("click", ".add-column", function () {
            let position = $(this).closest("th").index();
            table = $(this).closest("table");
            addColumn(table, position);
            updateButtonStatus();
        });

        $(table).on("click", ".remove-column", function () {
            let position = $(this).closest("th").index();
            table = $(this).closest("table");
            removeColumn(table, position);
            updateButtonStatus();
        });

        $(table).on("click", ".add-row", function () {
            let position = $(this).closest("tr.row-input").index();
            table = $(this).closest("table");
            addRow(table, position);
            updateButtonStatus();
        });

        $(table).on("click", ".remove-row", function () {
            let position = $(this).closest("tr.row-input").index();
            table = $(this).closest("table");
            removeRow(table, position);
            updateButtonStatus();
        });

        $('form').on('submit', function () {
            let data = [];
            $("tr.row-input", table).each(function (index) {
                data[index] = [];
                $("input", $(this)).each(function () {
                    data[index].push($(this).val());
                });
            });
            $('#size-guide-table-data').val(JSON.stringify(data));
        });
    }

    var updateButtonStatus = function (table) {
        if ($(".row-input", table).length > 1) {
            $(".remove-row.btn-disabled", table).removeClass('btn-disabled');
        } else {
            $(".remove-row", table).addClass('btn-disabled');
        }

        if ($("#header-row", table).children().length > 2) {
            $(".remove-column.btn-disabled", table).removeClass('btn-disabled');
        } else {
            $(".remove-column", table).addClass('btn-disabled');
        }

    }

    var addRow = function (table, position) {
        // tbody.append(newRow);
        $("tr.row-input", table).eq(position).after(
            getNewRow(table)
        );
    }

    var removeRow = function (table, position) {
        if ($("tr.row-input", table).length > 1) {
            $("tr.row-input", table).eq(position).remove();
        }
    }

    var addColumn = function (table, position) {
        // let $columnOrigin = $(`<td><input type="text"></td>`);
        // let $head = $(`<td><input type="text"></td>`);
        table.find("tr").each(function (index) {
            let cell;
            if (index === 0) {
                cell = `<th><span class='add-column icon-button'>+</span> <span class='remove-column icon-button'>-</span></th>`;
            } else {
                cell = "<td><input type='text'></td>";
            }
            $(this).children().eq(position).after(cell);
        });
    }

    var removeColumn = function (table, position) {
        table.find("tr").each(function () {
            if ($(this).children().length > 2) {
                $(this).children().eq(position).remove();
            }
        });
    }

    var getNewRow = function (table) {
        let $row_origin = $("tr", table).last().clone();
        $("input", $row_origin).val("");
        return $row_origin;
    }

    initSizeGuide();

})(jQuery);