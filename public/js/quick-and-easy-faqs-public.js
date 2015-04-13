(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */


    /**
     * FAQs Toggles
     */
    $(function() {

        $('.qe-toggle-title').click(function () {

            var parent_toggle = $(this).closest('.qe-faq-toggle');

            if ( parent_toggle.hasClass( 'active' ) ) {

                $(this).find('i.fa').removeClass( 'fa-minus-circle' ).addClass( 'fa-plus-circle' );
                parent_toggle.removeClass( 'active' ).find( '.qe-toggle-content' ).slideUp( 'fast' );

            } else {

                $(this).find('i.fa').removeClass( 'fa-plus-circle' ).addClass( 'fa-minus-circle' );
                parent_toggle.addClass( 'active' ).find( '.qe-toggle-content' ).slideDown( 'fast' );

            }

        });

    });

    /**
     * FAQs Filter
     */
    $(function() {

        $('.qe-faqs-filter').click( function ( event ) {
            event.preventDefault();
            $(this).parents('li').addClass('active').siblings().removeClass('active');
            var filterSelector = $(this).attr( 'data-filter' );
            var allFAQs = $( '.qe-faq-toggle' );
            if ( filterSelector == '*' ) {
                allFAQs.show();
            } else {
                allFAQs.not( filterSelector ).hide().end().filter( filterSelector ).show();
            }
        });

    });

})( jQuery );
