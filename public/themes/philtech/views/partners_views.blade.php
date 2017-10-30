@extends("layout")
@section("content")
<div class="content">
   <div class="container">
        <div class="merchant-wrapper">
            <div class="controls-container">
                <p>MERCHANT COMPANY NAME</p>
                <div class="prev"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></div>
                <div class="next"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
            </div>
            <div class="merchant-img-container">
                <img src="/themes/{{ $shop_theme }}/img/lamesa.jpg">
            </div>
            <div class="map-container">
                <iframe src="" frameborder="0"></iframe>
            </div>
        </div>
    </div>    
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/partners_views.css">
@endsection

