var swiper2 = new swiper2();

function swiper2()
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
			swiper_multiple_slide();
		});
	}

	function swiper_multiple_slide()
	{
		var swiper = new Swiper('.swiper', {
			autoplay: true,
			loop: true,
      		loopFillGroupWithBlank: true,
			slidesPerView: 5,
			spaceBetween: 30,
			pagination: {
			el: '.swiper-pagination2',
			clickable: true,
			},
			breakpoints: {
				768: {
					slidesPerView: 4,
				},
				425: {
					slidesPerView: 3,
				},
				375: {
					slidesPerView: 2,
				}
			}
		});
	}
}