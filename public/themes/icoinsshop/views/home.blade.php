@extends("layout")
@section("content")
<div class="content">

    <!-- Media Slider -->
    <div id="home" class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/slider-img.jpg')">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="caption-container">
                        <div class="text-1 wow fadeInDown" data-wow-delay=".2s" data-wow-duration="2s">Getting Started with icoinsshop</div>
                        <div class="text-2 wow fadeInDown" data-wow-delay=".4s" data-wow-duration="2s">Where your future digital currencies begin</div>
                    </div>
                    <div class="button-container">
                        <button class="btn-explore wow fadeInDown" data-wow-delay=".6s" data-wow-duration="2s">EXPLORE</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card wow fadeInRight" data-wow-duration="2s">
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

    <!--ABOUT US-->
    <section class="wrapper-1">
        <div class="container unskew">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="wrapper-title wow fadeInLeft" data-wow-delay=".2s" data-wow-duration="2s">
                        <span><u>Abo</u>ut Us</span>
                    </div>
                    <div class="wrapper-details wow fadeInLeft" data-wow-delay=".4s" data-wow-duration="2s">
                        icoinsshop is a privately owned marketing company, introducing and educating the people on different ICO’s to start an opportunity for everyone on the future generation of digital currencies.
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wr1-img-container wow rollIn" data-wow-delay=".8s" data-wow-duration="2s">
                        <img src="/themes/{{ $shop_theme }}/img/aboutus-img.png">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--HOW IT WORKS-->
    <section class="wrapper-2">
        <div class="container unskew">
            <div class="wrapper-title wow fadeInDown" data-wow-delay=".2s" data-wow-duration="2s">
                <span>How <u>it W</u>orks</span>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="img-text-holder wow pulse" data-wow-delay=".4s" data-wow-duration="2s">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/account.png">
                        </div>
                        <div class="text-holder">
                            Create Payments
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="img-text-holder wow pulse" data-wow-delay=".6s" data-wow-duration="2s">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/pay.png">
                        </div>
                        <div class="text-holder">
                            Make Payments
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="img-text-holder wow pulse" data-wow-delay=".8s" data-wow-duration="2s">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/buy.png">
                        </div>
                        <div class="text-holder">
                            Buy Product
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--MISSION AND VISION-->
    <section class="wrapper-3">
        <div class="container">
            <div class="mission-vision-container">
                <section>
                    <div class="title wow fadeInDown" data-wow-delay=".2s" data-wow-duration="2s">M<u>issio</u>n</div>
                    <div class="details wow fadeInLeft" data-wow-delay=".4s">To help our clients successfully launch their ICO through market intelligence, creativity and strategic vision, and to build an organization that attracts, develops, and retains outstanding people worldwide as we grow our business.</div>
                </section>
                <section>
                    <div class="title wow fadeInDown" data-wow-delay=".6s" data-wow-duration="2s">V<u>isio</u>n</div>
                    <div class="details wow fadeInRight" data-wow-delay=".8s">icoinsshop is dedicated in providing our clients with results-oriented advertising, public relations, and total be marketing support to be the top ICO marketing company.</div>
                </section>
            </div>
            <div class="border"></div>
        </div>
    </section>

    <!--NEWS-->
    <section class="wrapper-4">
        <div class="container">
            <div class="wrapper-title"><u>New</u>s and Announcement</div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="news-holder">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/news-img.png">
                        </div>
                        <div class="title">Lorem Ipsum</div>
                        <div class="details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia non recusandae incidunt impedit, voluptate veniam.</div>
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="news-holder">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/news-img.png">
                        </div>
                        <div class="title">Lorem Ipsum</div>
                        <div class="details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, maiores voluptas quidem similique expedita, doloribus?</div>
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="news-holder">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/news-img.png">
                        </div>
                        <div class="title">Lorem Ipsum</div>
                        <div class="details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam, incidunt at delectus et porro ducimus.</div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
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