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
		var swiper = new Swiper('.swiper2', {
			autoplay: true,
			loop: true,
      		loopFillGroupWithBlank: true,
			slidesPerView: 3,
			pagination: {
			el: '.swiper-pagination2',
			clickable: true,
			},
			breakpoints: {
				425: {
					slidesPerView: 1,
				}
			}
		});
	}
}