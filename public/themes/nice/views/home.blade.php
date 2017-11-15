@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/front-img2.jpg')">
        <div class="container">
            <div class="caption-logo-container"><img src="/themes/{{ $shop_theme }}/img/logo-caption.png"></div>
            <div class="scroll-down-container">
                <span class="animated fadeInDown"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>           
            </div>
        </div>
    </div>
    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection

@section("script")

<script type="text/javascript">
/*$(document).ready(function($) {

        //START MISSION AND VISION
        $(".title-vision").click(function()
        {
            $("#vision").removeClass("hide");
            $("#mission").addClass("hide");
            $(".title-vision").addClass("highlighted");
            $(".title-mission").removeClass("highlighted");
            
        });
        $(".title-mission").click(function()
        {
            $("#vision").addClass("hide");
            $("#mission").removeClass("hide");
            $(".title-mission").addClass("highlighted");
            $(".title-vision").removeClass("highlighted");
        });
        //END MISSION ANF VISION
});*/
</script>

@endsection