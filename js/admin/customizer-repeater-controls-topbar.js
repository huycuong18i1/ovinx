(function ($) {
function buildItem($container) {
    var choices = $container.data("choices") || {};  
    var $select = $('<select class="repeater-select"></select>');

    $.each(choices, function (key, label) {
        $select.append(
            $('<option></option>').val(key).text(label)
        );
    });

    var $item = $('<div class="repeater-item"></div>');
    $item.append('<span class="dashicons dashicons-move handle"></span>');
    $item.append($select);
    $item.append('<button type="button" class="button remove-item"><i class="dashicons dashicons-no-alt"></i></button>');
    return $item;
}

  function updateValue($container) {
    var data = [];
    $container.find(".repeater-select").each(function () {
      data.push($(this).val());
    });
    $container.find(".repeater-hidden").val(JSON.stringify(data)).trigger("change");
  }

  function initRepeaterContainer($container) {
    if (!$container || !$container.length) return;

    var $list = $container.find(".sortable-list");

    // sortable chỉ init 1 lần
    if ($.fn.sortable && !$list.data("sortable-inited")) {
      $list.sortable({
        handle: ".handle",
        update: function () {
          updateValue($container);
        },
      });
      $list.data("sortable-inited", true);
    }

    // sync initial
    updateValue($container);
  }

  // init khi DOM ready (nếu control đã có sẵn)
  $(function () {
    $(".themesflat-repeater-select").each(function () {
      initRepeaterContainer($(this));
    });
  });

  // delegate events
  $(document)
    .on("change", ".themesflat-repeater-select .repeater-select", function () {
      updateValue($(this).closest(".themesflat-repeater-select"));
    })

    .on("click", ".themesflat-repeater-select .add-item", function (e) {
      e.preventDefault();
      var $container = $(this).closest(".themesflat-repeater-select");
      var $list = $container.find(".sortable-list");

      // thêm item mới (không cần template)
      $list.append(buildItem($container));

      // refresh sortable nếu đã init
      if ($.fn.sortable && $list.data("sortable-inited")) {
        $list.sortable("refresh");
      }

      initRepeaterContainer($container);
    })

    .on("click", ".themesflat-repeater-select .remove-item", function (e) {
      e.preventDefault();
      var $container = $(this).closest(".themesflat-repeater-select");
      $(this).closest(".repeater-item").remove();
      updateValue($container);
    });

  // init thêm lần nữa khi customizer ready (nhiều case control render trễ)
  if (typeof wp !== "undefined" && wp.customize) {
    wp.customize.bind("ready", function () {
      $(".themesflat-repeater-select").each(function () {
        initRepeaterContainer($(this));
      });
    });

    // nếu control render sau (selective refresh) thì init lại
    if (wp.customize.control && wp.customize.control.bind) {
      wp.customize.control.bind("add", function (control) {
        if (control && control.container) {
          control.container.find(".themesflat-repeater-select").each(function () {
            initRepeaterContainer($(this));
          });
        }
      });
    }
  }
})(jQuery);