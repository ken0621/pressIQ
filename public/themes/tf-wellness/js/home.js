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
		action_featured_carousel();
		ads_carousel();
	}

	function action_featured_carousel()
	{
		$('.product-carousel').slick({
		  infinite: true,
		  speed: 300,
		  slidesToShow: 6,
		  slidesToScroll: 4,
		  arrows: true,
		  prevArrow:"<img style='width: 10px; height: 15px;' class='a-left control-c prev slick-prev' src='/themes/tf-wellness/img/arrow-left.png'>",
		  nextArrow:"<img style='width: 10px; height: 15px;' class='a-right control-c next slick-next' src='/themes/tf-wellness/img/arrow-right.png'>",
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
}