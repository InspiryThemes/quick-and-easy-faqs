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

    $(".faqs-reorder-list .fieldset-wrapper").sortable();
    $(".faqs-reorder-list .fieldset-wrapper").disableSelection();

    if ($(".faqs-reorder-list .fieldset-wrapper input:checked").length > 0) {} else {
        $(".faqs-reorder-list .fieldset-wrapper input").attr('checked', 'checked');
    }
})(jQuery);