@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/front-img2.jpg')">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-9 col-xs-12 media-wrapper">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/sy655Z-7TZE?autoplay=1" allowfullscreen="" frameborder="0">              </iframe>
                    </div>
                    <div class="btn-container animated fadeInDown">GET FREE ACCESS</div>
                </div>
            </div>
        </div>
    </div>
    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/replicated.css">
@endsection

@section("script")

<script type="text/javascript">
$(document).ready(function($) {
    
        /*TEXT FADEOUT*/
        $(window).scroll(function(){
                $(".caption-container, .caption-logo-container").css("opacity", 1 - $(window).scrollTop() / 250);
        });

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
});
</script>

@endsection