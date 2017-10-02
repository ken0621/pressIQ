
(function($) 
{
    'use strict'; // Start of use strict

    /*------------------------------------------------------------------
    Navigation Hover effect
    ------------------------------------------------------------------*/
    // jQuery for page scrolling feature - requires jQuery Easing plugin

    $('.smoth-scroll').on('click', function(event) 
    {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1000, 'easeInOutExpo'); //1250
        event.preventDefault();
    });
    // Highlight the top nav as scrolling occurs

    $('body').scrollspy(
    {
        target: '.navbar-default',
        offset: 70
    });

    /*------------------------------------------------------------------
   	 Scrollup opacity downarrow 
	 ------------------------------------------------------------------*/
    var bottom_arrow = $('.bottom_row, .banner-content');
    $(window).on('scroll', function()
    {
        var st = $(this).scrollTop();
        bottom_arrow.css({
            'opacity': (1 - (st / 350))
        });
    });

})(jQuery);