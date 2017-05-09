var home = new home();

function home()
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
		add_slider_script();
		add_loader_for_slide_image();
		show_modal();
		brand_slider();
		event_quick_add_cart();
	}
	function brand_slider()
	{
		// store the slider in a local variable
		  var $window = $(window),
		      flexslider;
		 
		  // tiny helper function to add breakpoints
		  function getGridSize() {
		    return (window.innerWidth < 600) ? 1 : 
		           (window.innerWidth < 1100) ? 3 : 
		           (window.innerWidth < 1400) ? 4 : 5;
		  }
		 
		  // $(function() {
		  //   SyntaxHighlighter.all();
		  // });
		 
		  $window.load(function() {
		    $('.flexslider').flexslider({
		      animation: "slide",
		      animationLoop: false,
		      itemWidth: 210,
		      itemMargin: 5,
		      minItems: getGridSize(), // use function to pull in initial value
		      maxItems: getGridSize() // use function to pull in initial value
		    });
		  });
		 
		  // check grid size on resize event
		  $window.resize(function() {
		    var gridSize = getGridSize();
		 
			    // flexslider.vars.minItems = gridSize;
		    	// flexslider.vars.maxItems = gridSize;
		  });
	}
	function add_slider_script()
	{
		jQuery(document).ready(function(){
		  jQuery('#slippry').slippry({
		  	transition: 'fade',
		  	easing: 'linear',
		  	onSlideAfter: function()
		  	{
		  		$('.ratio-fix img').keepRatio({ ratio: 396/241, calculate: 'height' });
		  	},
		  })
		});
	}
	function add_loader_for_slide_image()
	{
		$(".banner img").css("opacity", 0);
		$(".banner img").each(function()
		{
			$link = $(this).attr("load");
			$(this).attr("src", $link);
			$(this).css("opacity", 1);
		});

		$window_width = $(window).width();
		$banner_height = ($window_width / 1381) * 497;
		$(".banner ul li").height($banner_height);
		
		$(window).resize(function()
		{
			$window_width = $(window).width();
			$banner_height = ($window_width / 1381) * 497;
			$(".banner ul li").height($banner_height);
		})
	}
	function show_modal()
	{		
		if($(".reservemessage").length)
		{
			location.hash="reserve";	
		}
		else
		{
			location.hash="subscribe";	
		}
	}
	function event_quick_add_cart()
	{
		$(".quick-add-cart").unbind("click");
		$(".quick-add-cart").bind("click", function(e)
		{
			$('.loader').fadeIn();

			action_quick_add_cart(e.currentTarget);
		});
	}
	function action_quick_add_cart(x)
	{
		var product_id = $(x).attr('product-id');

		$(".quick-cart-content").load('/cart/quick?product_id='+product_id,
		function()
		{
			$('.loader').hide();
			$("#quick-add-cart").modal();
		});
	}
}