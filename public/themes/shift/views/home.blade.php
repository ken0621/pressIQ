@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div class="fullscreen background parallax top-container" style="background-image: url('/themes/{{ $shop_theme }}/img/front-banner.jpg');" data-img-width="1600" data-img-height="1139" data-diff="100">
        <div class="container">
            <div class="caption-logo-container"><img src="/themes/{{ $shop_theme }}/img/top-logo.png"></div>
            <div class="caption-container animated fadeInDown">
                <h1>SCENTS.HEALTH.INFORMATION.FASHION.TECHNOLOGY</h1>
            </div>
        </div>
    </div>
    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<!-- <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css"> -->
@endsection

@section("js")

<script type="text/javascript">
</script>
@endsection