@extends("layout")
@section("content")
<div class="content">

    <!-- Media Slider -->
    <div id="home" class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/slider-img.jpg')">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="caption-container">
                        <div class="text-1">Getting Started with icoinsshop</div>
                        <div class="text-2">Where your future digital currencies begin</div>
                    </div>
                    <div class="button-container">
                        <button class="btn-explore">EXPLORE</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="title">Current Exchange</div>
                            <div class="icon-text-container">
                                <img src="/themes/{{ $shop_theme }}/img/card-img.png">
                                <span>
                                    <div class="text-1">Krops</div>
                                    <div class="text-2">1KRO = $10.00</div>
                                </span>
                            </div>
                            <div class="details">
                                Krops has the potential of becoming the largest food hub in the world without even owning a single farm.
                            </div>
                            <div class="button-container">
                                <button class="btn-buy-tokens">BUY TOKENS</button>
                            </div>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection

@section("script")
<script type="text/javascript">
$(document).ready(function($) 
{
    /*TEXT FADEOUT*/
    // $(window).scroll(function(){
    //     $(".caption-container, .caption-logo-container").css("opacity", 1 - $(window).scrollTop() / 250);
    // });
});
</script>

@endsection