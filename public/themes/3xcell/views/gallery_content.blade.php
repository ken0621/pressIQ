@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="title-container">
				Gallery
			</div>
		</div>
	</div>
	<div class="content-container">
		<div class="container">
			<div class="title-container">
				<div class="album-title-container">Quezon City Main Office Opening and Blessing</div>
				<div class="album-date">Aug. 14 2017</div>
				<div class="line-bot">
				</div>
			</div>
			<div class="albums-content row clearfix">
				<!-- PER PICTURES -->
				<div class="col-md-3">
					<div class="per-album-container">
						<div class="img-container">
							<a href="/themes/{{ $shop_theme }}/img/gallery-sample2.png" data-title="" data-lightbox="company-gallery">
								<img src="/themes/{{ $shop_theme }}/img/gallery-sample2.png">
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="per-album-container">
						<div class="img-container">
							<a href="/themes/{{ $shop_theme }}/img/gallery-sample2.png" data-title="" data-lightbox="company-gallery">
								<img src="/themes/{{ $shop_theme }}/img/gallery-sample2.png">
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="per-album-container">
						<div class="img-container">
							<a href="/themes/{{ $shop_theme }}/img/gallery-sample2.png" data-title="" data-lightbox="company-gallery">
								<img src="/themes/{{ $shop_theme }}/img/gallery-sample2.png">
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="per-album-container">
						<div class="img-container">
							<a href="/themes/{{ $shop_theme }}/img/gallery-sample2.png" data-title="" data-lightbox="company-gallery">
								<img src="/themes/{{ $shop_theme }}/img/gallery-sample2.png">
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="per-album-container">
						<div class="img-container">
							<a href="/themes/{{ $shop_theme }}/img/gallery-sample2.png" data-title="" data-lightbox="company-gallery">
								<img src="/themes/{{ $shop_theme }}/img/gallery-sample2.png">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/gallery_content.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
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

    /*LIGHTBOX*/
    lightbox.option({
      'disableScrolling': true,
      'wrapAround': true
    });


});
</script>
@endsection