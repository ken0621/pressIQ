@extends("layout")
@section("content")

<div class="content">
	<div class="parallax background not-fullscreen" style="background-image: url('/themes/{{ $shop_theme }}/img/img-product-bg.png');" data-img-width="1500" data-img-height="904" data-diff="100">
		
		<div class="container">
			<div class="banner-text col-md-6">A Real Product Need</div>
			<div class="col-md-6">
				<a class="banner-product-name" href="#">Products > Product Name 1</a>
			</div>
		</div>

	</div>

	{{-- PRODUCTS --}}
	<div class="container">
		<div class="products-container row clearfix">

			<div class="col-md-6">

				<div class="arrow">
					<div class="arrow-left col-md-6">
						<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-arrow-left.png"></a>
						{{-- <button><img src="/themes/{{ $shop_theme }}/img/img-arrow-left.png"></button> --}}
					</div>
					<div class="arrow-right col-md-6">
						<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-arrow-right.png"></a>
						{{-- <button><img src="/themes/{{ $shop_theme }}/img/img-arrow-right.png"></button> --}}
					</div>
				</div>

				<div class="product-image">
					<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-prod-1.png"></a>
				</div>

				<div class="row clearfix">
					<div class="col-md-3">
						<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-prod-2.png"></a>
					</div>

					<div class="col-md-3">
						<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-prod-3.png"></a>
					</div>

					<div class="col-md-3">
						<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-prod-2.png"></a>
					</div>

					<div class="col-md-3">
						<a href="#"><img src="/themes/{{ $shop_theme }}/img/img-prod-3.png"></a>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="product-name">Gluta Colla E - Glutathione</div>
				<div class="product-details">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>

					<p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
				</div>

				<div class="product-price">Price
					<p>PHP 299.99</p>
				</div>

			</div>

		</div>
	</div>
</div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/products.css">
@endsection

@section("js")

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/parallax.js"></script>

<script type="text/javascript">
$(document).on("click", '.nav-per-button', function()
{
	var id = $(this).attr("id");

	$(".nav-per-button").removeClass("active");
	$(".body-content .content").removeClass("active");
	$(".body-content .content").fadeOut();

	$(this).addClass("active");
	$(".body-content .content."+id).addClass("active");
	$(".body-content .content."+id).fadeIn();


});
</script>

<script type="text/javascript">

$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    $(".per-img-container").click(function()
	{
		var source = $(this).find("img").attr("src");
		$(".lightbox-target").find("img").attr("src", source);
	})


});	

</script>
@endsection
