@extends("layout")
@section("content")
<div class="content">

    <!-- Media Slider -->
    <div id="home" class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/cover-photo.jpg')">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="caption-container">
                        <div class="text-1 wow fadeInDown" data-wow-delay=".2s" data-wow-duration="2s">Where your future digital currencies begin</div>
                        <div class="text-2 wow fadeInDown" data-wow-delay=".4s" data-wow-duration="2s">Join the community of ICOinssop.com to educate on different ICO’s  and be updated on crypto market trends! </div>
                    </div>
                    <div class="button-container">
                        <button class="btn-explore wow fadeInDown" data-wow-delay=".6s" data-wow-duration="2s">JOIN US TODAY</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card wow fadeInRight" data-wow-duration="2s">
                        <div class="card-content">
                            <div class="title">
                                <span><u>Cu</u>rrent Exchange</span>
                            </div>
                            <div class="card-holder">
                                <div class="icon-text-container">
                                    <img src="/themes/{{ $shop_theme }}/img/card-img.png">
                                    <span>
                                        <div class="text-1">KROPS</div>
                                        <div class="text-2">1 KRO = $0.88</div>
                                    </span>
                                </div>
                                <div class="border"></div>
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
    </div>

    <!-- ABOUT US -->
    <section class="wrapper-1" style="background-image: url('/themes/{{ $shop_theme }}/img/networkbg.png')">
        <div class="container">
            <div class="wrapper-title"><span>About</span> Us</div>
            <div class="img-holder">
                <img src="/themes/{{ $shop_theme }}/img/aboutus-img-1.png">
            </div>
            <div class="wrapper-texts">ICOins Shop is a privately owned marketing company, introducing and educating the people on different ICO’s to start an opportunity for everyone on the future generation of digital currencies.</div>
        </div>
    </section>

    <!-- MISSION VISION -->
    <section class="wrapper-2">
        <div class="unskew" style="background-image: url('/themes/{{ $shop_theme }}/img/missionvision-bg.png')">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/mission.png">
                        </div>
                        <div class="title">MISSION</div>
                        <div class="texts">To help our clients successfully launch their ICO through market intelligence, creativity and strategic vision, and to build an organization that attracts, develops, and retains outstanding people worldwide as we grow our business.</div>
                    </div>
                    <div class="col-md-6">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/vision.png">
                        </div>
                        <div class="title">VISION</div>
                        <div class="texts">ICOins Shop is dedicated in providing our clients with results-oriented advertising, public relations, and total be marketing support to be the top ICO marketing company.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="wrapper-3" style="background-image: url('/themes/{{ $shop_theme }}/img/networkbg.png')">
        <div class="container">
            <div class="wrapper-title"><span>How</span> It Works</div>
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left">
                        <div class="text-header">How ICOinsshop Works</div>
                        <div class="text-content">Icoins shop is an e-commerce site for ICO with  marketing program that provides digital currency education and services to help people understand the essence of ICO to digital currency world and teach them how can they make these as an opportunity.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/howitworks-img.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="wrapper-4">
        <div class="container unskew">
            <div class="wrapper-title"><span>ICO</span> Token Products</div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="product-holder">
                        <div class="top">
                            <img src="/themes/{{ $shop_theme }}/img/krops.jpg">
                        </div>
                        <div class="bottom">
                            <div class="texts"> KROPS is offering tokenized shares of the company through an offering of 16,000,000 or sixteen million KROPS tokens of KropCoins.</div>
                            <div class="btn-container">
                                <button class="btn-more-info">MORE INFO</button>
                                <button class="btn-buy-tokens">BUY TOKENS</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-holder">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/logo-2.png">
                        </div>
                        <div class="text">Other tokens are coming soon!</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-holder">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/logo-2.png">
                        </div>
                        <div class="text">Other tokens are coming soon!</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWS AND ANNOUNCEMENTS -->
    <section class="wrapper-5">
        <div class="container">
            <div class="wrapper-title"><span>News</span> an Announcements</div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="news-holder">
                        <div class="row-no-padding clearfix">
                            <div class="col-md-6 col-xs-6">
                                <div class="img-holder">
                                    <img src="/themes/{{ $shop_theme }}/img/news-img-1.jpg">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="caption-holder">
                                    <div class="caption">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                                    <div class="date">January 15, 2018</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-holder">
                        <div class="row-no-padding clearfix">
                            <div class="col-md-6 col-xs-6">
                                <div class="img-holder">
                                    <img src="/themes/{{ $shop_theme }}/img/news-img-2.jpg">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="caption-holder">
                                    <div class="caption">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                                    <div class="date">January 05, 2018</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-holder">
                        <div class="row-no-padding clearfix">
                            <div class="col-md-6 col-xs-6">
                                <div class="img-holder">
                                    <img src="/themes/{{ $shop_theme }}/img/news-img-3.jpg">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="caption-holder">
                                    <div class="caption">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                                    <div class="date">January 07, 2018</div>
                                </div>
                            </div>
                        </div>
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