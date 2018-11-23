var home = new home();

function home()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		$(document).ready(function()
		{
			action_featured_carousel();
			ads_carousel();
			thumb_featured_carousel();
		});
	}

	function action_featured_carousel()
	{
		$('.product-carousel').slick({
		  infinite: true,
		  speed: 300,
		  slidesToShow: 5,
		  slidesToScroll: 1,
		  arrows: true,
		  prevArrow:"<img style='width: 10px; height: 15px;' class='a-left control-c prev slick-prev' src='/themes/heartzone/img/arrow-left.png'>",
		  nextArrow:"<img style='width: 10px; height: 15px;' class='a-right control-c next slick-next' src='/themes/heartzone/img/arrow-right.png'>",
		  responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		        infinite: true,
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
		});
	}
	function ads_carousel()
	{
		$('.ads-carousel').slick({
		  infinite: true,
		  autoplay: true,
	  	  autoplaySpeed: 3000,
		  fade: true,
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  cssEase: 'linear',
		  responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        infinite: true,
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
		});
	}
	function thumb_featured_carousel()
	{
		$('.thumb-carousel').slick({
		  dots: true,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 4,
		  slidesToScroll: 1,
		  arrows: true,
		  prevArrow:"<img style='width: 40px; height: 45px; z-index: 29;' class='a-left control-c prev slick-prev' src='/themes/kolorete/img/arrow-left.png'>",
		  nextArrow:"<img style='width: 40px; height: 45px; z-index: 29;' class='a-right control-c next slick-next' src='/themes/kolorete/img/arrow-right.png'>",
		  responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		        infinite: true,
		        dots: true
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
		});

	}
}