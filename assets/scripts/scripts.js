(function () {
    'use strict';

    // STICKY MENU
    // =========================================================================
    // var sticky = function() {
    //     // var num = 68; //number of pixels before modifying styles
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
    //     };
    // };


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
    };


    // BACK TO TOP
    // ======================================================================== /
    var back_top = function() {
        // browser window scroll ( in pixels ) after which the "back to top" link is show
        var offset = 500,
        // browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        // duration of the top scrolling animatiion (in ms)
        scroll_top_duration = 700,
        // grab the "back to top" link
        $back_to_top = $( '.cd_top' );

        // hide or show the "back to top" link
        $(window).scroll( function() {
            ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
            if( $(this).scrollTop() > offset_opacity ) {
                $back_to_top.addClass('cd-fade-out');
            }
        });

        // Smooth scroll to top
        $back_to_top.on( 'click', function(event) {
            event.preventDefault();
            $( 'body, html' ).animate({
                scrollTop: 0,
                }, scroll_top_duration
            );
        });
    };

    // FILTERIZD FUNCTION
    // ======================================================================== /
    var filterizd = function() {
        var id = $( '#filters-nav li' );
        var grid = $( '.grid' );

        $( id ).click( function(event) {
            $(id).removeClass('active');
            $(this).addClass('active');
            event.preventDefault();
        });

        //Default options
        var options = {
           animationDuration: 0.4, //in seconds
           filter: 'all', //Initial filter
           delay: 50, //Transition delay in ms
           delayMode: 'alternate', //'progressive' or 'alternate'
           easing: 'ease-out',
           filterOutCss: { //Filtering out animation
              opacity: 0,
              transform: 'scale(0.3)'
           },
           filterInCss: { //Filtering in animation
              opacity: 1,
              transform: 'scale(1)'
           },
           layout: 'sameWidth', //See layouts
           selector: '.grid',
           setupControls: true
        }

        if( grid != null ){
            var filterizd = $( grid ).filterizr(options);
        }
    };

    var post_masonry = function() {
        $('.grid').masonry({
            // options
            itemSelector: '.filtr-item',
            // columnWidth: 200
        });
    };


    // DOCUMENT ON LOAD
    // =========================================================================
    $(function() {

    });

    $(window).load(function() {
        // executes when complete page is fully loaded, including all frames, objects and images
        // sticky();
        search_nav();
        back_top();
        // filterizd();

        // post_masonry();
    });

    $(document).ready(function() {
        // executes when HTML-Document is loaded and DOM is ready
        // filterizd();
    });


}(jQuery));
