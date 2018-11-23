@extends("layout")
@section("content")
<div class="content">
	<div class="main-container">

	</div>
	<div class="legalities-container">
		<div class="container">
			<div class="title-container">Legalities<div class="line-bot"></div></div>
			<div class="row clearfix">
				<div class="col-md-4 col-sm-4 col-xs-6">
					<a href="/themes/{{ $shop_theme }}/img/legalities-2.jpg" class="lsb-preview">
						<div class="img-holder match-height">
							<img src="/themes/{{ $shop_theme }}/img/legalities-2.jpg">
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<a href="/themes/{{ $shop_theme }}/img/legalities-3.jpg" class="lsb-preview">
						<div class="img-holder match-height">
							<img src="/themes/{{ $shop_theme }}/img/legalities-3.jpg">
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<a href="/themes/{{ $shop_theme }}/img/legalities-1.jpg" class="lsb-preview">
						<div class="img-holder match-height">
							<img src="/themes/{{ $shop_theme }}/img/legalities-1.jpg">
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<a href="/themes/{{ $shop_theme }}/img/legalities-6.jpg" class="lsb-preview">
						<div class="img-holder match-height">
							<img src="/themes/{{ $shop_theme }}/img/legalities-6.jpg">
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<a href="/themes/{{ $shop_theme }}/img/legalities-4.jpg" class="lsb-preview">
						<div class="img-holder match-height">
							<img src="/themes/{{ $shop_theme }}/img/legalities-4.jpg">
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<a href="/themes/{{ $shop_theme }}/img/legalities-5.jpg" class="lsb-preview">
						<div class="img-holder match-height">
							<img src="/themes/{{ $shop_theme }}/img/legalities-5.jpg">
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("css")
<!-- LIGHTBOX -->
{{-- <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/lightbox/css/lightbox.css"> --}}
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css">
@endsection

@section("script")
<script type="text/javascript">
/*LIGHTBOX*/
lightbox.option({
  'disableScrolling': true,
  'wrapAround': true
});
</script>
@endsection