(function () {
    'use strict';

    // STICKY MENU
    // =========================================================================
    // var sticky = function() {
    //     // var num = 68; //number of pixels before modifying styles
    //     var num = 68;
    //
    //     if( $(window).width() > 1024 ) {
    //         $(window).bind('scroll', function () {
    //             if ($(window).scrollTop() > num) {
    //                 $('#nav').addClass('fixed');
    //                 $('.nav_fixed').addClass( 'static' );
    //             } else {
    //                 $('#nav').removeClass('fixed');
    //                 $('.nav_fixed').removeClass( 'static' );
    //             }
    //         });
    //     }
    //
    // }

    // SEARCH NAV
    // =========================================================================
    var search_nav = function() {
        $('.search_tringger').click( function(event) {
            $(this).toggleClass( 'active' );
            $('#cd_search').toggleClass('visible');
            $( '.header_search .SearchField' ).focus();
            event.preventDefault();
        });

        // $( '.header_search .SearchField' ).attr("placeholder", "Search...");
        $( '.widget_core_coll_search_form .SearchField' ).attr("placeholder", "Search...");

    }


    // DOCUMENT ON LOAD
    // =========================================================================
    $(function() {
    });

    $(window).load(function() {
        // sticky();
        search_nav();
    });


}(jQuery));
