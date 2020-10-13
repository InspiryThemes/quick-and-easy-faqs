(function ($) {
    'use strict';

    /**
     * WordPress color picker for options page
     */
    if (jQuery().wpColorPicker) {
        $(function () {
            $('.color-picker').wpColorPicker();
        });
    }

    if (jQuery().sortable){
        $(".faqs-reorder-list .fieldset-wrapper").sortable();
        $(".faqs-reorder-list .fieldset-wrapper").disableSelection();
    }

    if ($(".faqs-reorder-list .fieldset-wrapper input:checked").length > 0) {} else {
        $(".faqs-reorder-list .fieldset-wrapper input").attr('checked', 'checked');
    }

    var fixHelper = function (e, ui) {
        ui.children().children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };
    
    $('table.posts #the-list, table.pages #the-list').sortable({
        'items': 'tr',
        'axis': 'y',
        'helper': fixHelper,
        'update': function (e, ui) {
            $.post(ajaxurl, {
                action: 'update-menu-order',
                order: $('#the-list').sortable('serialize'),
            });
        }
    });
})(jQuery);