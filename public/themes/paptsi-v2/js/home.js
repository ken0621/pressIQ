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
		news_announcement_carousel();
	}

	function action_featured_carousel()
	{
		$('.services-carousel').slick({
		  infinite: true,
		  speed: 300,
		  slidesToShow: 4,
		  slidesToScroll: 4,
		  arrows: true,
		  prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/paptsi-v2/img/arrow-left.png'>",
		  nextArrow:"<img class='a-right control-c next slick-next' src='/themes/paptsi-v2/img/arrow-right.png'>",
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
	function news_announcement_carousel()
	{
		$('.news-carousel').slick({
		  infinite: true,
		  speed: 300,
		  slidesToShow: 4,
		  slidesToScroll: 4,
		  arrows: true,
		  prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/paptsi-v2/img/arrow-left.png'>",
		  nextArrow:"<img class='a-right control-c next slick-next' src='/themes/paptsi-v2/img/arrow-right.png'>",
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