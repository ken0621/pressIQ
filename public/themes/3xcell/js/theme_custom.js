var theme_custom = new theme_custom();

function theme_custom()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}

	function document_ready()
	{
		action_facebook_widget();
		event_header_fix();
		event_action_click();
        event_mobile_sidenav()
	}

	function action_facebook_widget()
	{
		(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
	}

	function event_header_fix()
	{
        $window = $(window);
        $window.scroll(function()
        {
            $scroll_position = $window.scrollTop();
            if ($scroll_position > 32.2167)
            {
                $('.header-container').addClass('header-fixed');
                $('.subheader-container').addClass('header-fixed');

                header_height = $('.your-header').innerHeight();
                $('body').css('padding-top', header_height);
            }
            else
            {
                $('body').css('padding-top', '0');
                $('.header-container').removeClass('header-fixed');
                $('.subheader-container').removeClass('header-fixed');
            }
        });
	}

	function event_action_click()
	{
        $('.slider3').diyslider(
        {
            width: "580px", // width of the slider
            height: "120px", // height of the slider
            display: 5, // number of slides you want it to display at once
            loop: false // disable looping on slides
        }); // this is all you need!

        // use buttons to change slide
        $('#gotoleft').bind("click", function()
        {
            // Go to the previous slide
            $('.slider3').diyslider("move", "back");
        });
        $('#gotoright').unbind("click")
        $('#gotoright').bind("click", function()
        {
            // Go to the previous slide
            $('.slider3').diyslider("move", "forth");
        });

        /*PRODUCT HOVER TOGGLE*/

        $('.product-hover').hover(function()
            {
                $('.product-dropdown').stop();
                $('.product-dropdown').fadeIn(400);
            },
            function()
            {
                $('.product-dropdown').stop();
                $('.product-dropdown').fadeOut(400);
            });

        $('.company-hover').hover(function()
            {
                $('.company-dropdown').stop();
                $('.company-dropdown').fadeIn(400);
            },
            function()
            {
                $('.company-dropdown').stop();
                $('.company-dropdown').fadeOut(400);
            });

        $('.cart-hover').hover(function()
            {
                $('.cart-dropdown').stop();
                $('.cart-dropdown').fadeIn(400);
            },
            function()
            {
                $('.cart-dropdown').stop();
                $('.cart-dropdown').fadeOut(400);
            });


        // NAVIRINO CLICK TOGGLE
        $(".menu-nav").click(function()
        {
            $(".navirino").toggle("slow");
        });


        // COMPANY CLICK TOGGLE
        $(".company-hover").click(function()
        {
            $(".minimize-cat-holder").toggle("slow");
        });

        // PRODUCT CLICK TOGGLE
        $(".product-hover").click(function()
        {
            $(".minimize-product-holder").toggle("slow");
        });
	}

    function event_mobile_sidenav()
    {
        $menuLeft = $('.pushmenu-left');
        $nav_list = $('#nav_list');
        
        $nav_list.click(function() {
            $(this).toggleClass('active');
            $('.pushmenu-push').toggleClass('pushmenu-push-toright');
            $menuLeft.toggleClass('pushmenu-open');
        });
    }
}