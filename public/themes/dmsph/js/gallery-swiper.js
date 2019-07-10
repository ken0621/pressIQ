var swiper3 = new swiper3();

function swiper3()
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
			swiper_multiple_row();
		});
	}

	function swiper_multiple_row()
	{
		var swiper = new Swiper('.swiper3', {
			autoplay: true,
			slidesPerView: 4,
			slidesPerColumn: 2,
			spaceBetween: 30,
			pagination: {
			el: '.swiper-pagination3',
			clickable: true,
			},
			breakpoints: {
				768: {
					slidesPerView: 3,
					slidesPerColumn: 2
				},
				425: {
					slidesPerView: 2,
					slidesPerColumn: 2
				},
				375: {
					slidesPerView: 2,
					slidesPerColumn: 2
				}
			}
		});
	}
}