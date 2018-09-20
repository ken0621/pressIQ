var swiper = new swiper();

function swiper()
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
			swiper_fade_effect();
		});
	}

	function swiper_fade_effect()
	{
		var swiper = new Swiper('.swiper1', {
		autoplay: true,
      	slidesPerView: 1,
      	effect: 'fade',
        loop: true,
        pagination: {
        el: '.swiper-pagination1',
        clickable: true,
        },
        navigation: {
        	nextEl: '.slider-next',
        	prevEl: '.slider-prev',
      		},
    	});
	}
}