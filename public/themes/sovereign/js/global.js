var global = new global()

function global()
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
		action_match_height();
		action_product_carousel();
		event_show_product();
		event_nav_dropdown();
		event_mobile_sidenav();
		product_mobile_dropdown();
		action_says_carousel();
		action_product_image_carousel();
		event_scroll_up();
	}

	function event_scroll_up()
	{
		/*scroll up*/
		$(window).scroll(function () {
		    if ($(this).scrollTop() > 700) {
		        $('.scroll-up').fadeIn();
		    } else {
		        $('.scroll-up').fadeOut();
		    }
		});

		$('.scroll-up').click(function () {
		    $("html, body").animate({
		        scrollTop: 0
		    }, 700);
		    return false;
		});
	}

	function action_says_carousel()
	{
		if ($(window).width() < 769) 
		{
    		$('.says-container').slick({
    			infinite: true,
    			slidesToShow: 1,
    			slidesToScroll: 1,
          		autoplay: true,
    			autoplaySpeed: 4000,
    		});
		}
		
		else if($(window).width() > 768)
		{
			$('.says-container').slick({
				infinite: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/sovereign/img/carousel-left.png'>",
	      		nextArrow:"<img class='a-right control-c next slick-next' src='/themes/sovereign/img/carousel-right.png'>",
	      		autoplay: true,
				autoplaySpeed: 4000,
			});
		}
	}

	function action_product_image_carousel()
	{
		$('.product-image-carousel').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/sovereign/img/carousel-left.png'>",
      		nextArrow:"<img class='a-right control-c next slick-next' src='/themes/sovereign/img/carousel-right.png'>",
      		autoplay: true,
			autoplaySpeed: 4000,
		});
	}

	function product_mobile_dropdown()
	{
		$(".product-mobile-dropdown").on("click", function (e) 
		{
		    $(e.currentTarget).siblings(".product-mobile-dropdown-list").slideToggle();
		});
	}

	function event_mobile_sidenav()
	{
		$menuLeft = $('.pushmenu-left');
		$nav_list = $('#nav_list');
		
		$nav_list.on("click", function() 
		{
		    $(this).toggleClass('active');
		   /* $('.pushmenu-push').toggleClass('pushmenu-push-toright');*/
		    $menuLeft.toggleClass('pushmenu-open');
		}); 
	}

	function action_match_height()
	{
		$(".match-height").matchHeight();

		$(window).resize(function()
		{
			$(".match-height").matchHeight();
		});
	}
	function event_show_product()
	{
		$(".show-product").unbind("click");
		$(".show-product").bind("click", function()
		{
			action_show_product();
		});
	}
	function action_show_product()
	{
		$('.product-container').toggleClass('show');

		if ($('.product-container').hasClass('show')) 
		{
			$('.show-product').parent().addClass('active');
		}
		else
		{
			$('.show-product').parent().removeClass('active');
		}
	}
	function action_product_carousel()
	{
		$('.product-container .list-product').slick({
			infinite: true,
			slidesToShow: 7,
			slidesToScroll: 1,
			prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/sovereign/img/carousel-left.png'>",
      		nextArrow:"<img class='a-right control-c next slick-next' src='/themes/sovereign/img/carousel-right.png'>",
      		autoplay: true,
			autoplaySpeed: 4000,
		})
	}
	function event_nav_dropdown()
	{
		$('.dropdown.mega-dropdown a').on('click', function (event) 
		{
			$('.dropdown.mega-dropdown').removeClass('open');
		    $(this).parent().toggleClass('open');
		});

		$('body').on('click', function (e) 
		{
		    if (!$('.dropdown.mega-dropdown').is(e.target) 
		        && $('.dropdown.mega-dropdown').has(e.target).length === 0 
		        && $('.open').has(e.target).length === 0
		    ) {
		        $('.dropdown.mega-dropdown').removeClass('open');
		    }
		});
	}
}

/*JAVASCRIPT for event_side_nav*/
function on()
{
    var $body = $(document.body);
    document.getElementById("overlay").style.display = "block";
    $body.css("overflow", "hidden");
}

function off()
{
    var $body = $(document.body);
    document.getElementById("overlay").style.display = "none";
    $('.pushmenu').removeClass("pushmenu-open");
    $body.css("overflow", "auto");
    /*$("body").css("overflow", "auto");*/
}