@extends("layout")
@section("content")
<div class="content">

    <!-- Media Slider -->
    <div id="home" class="page-section slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/cover-photo.jpg')">
        <div class="container">
            <div class="holder fadeMe">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="caption-container">
                            <div class="text-1 wow fadeInDown" data-wow-delay=".2s" data-wow-duration="2s">Where your future digital currencies begin</div>
                            <div class="text-2 wow fadeInDown" data-wow-delay=".4s" data-wow-duration="2s">Join the community of ICOinssop.com to educate on different ICO’s  and be updated on crypto market trends! </div>
                        </div>
                        <div class="button-container">
                            <a href="/members/register"><button class="btn-join wow fadeInDown" data-wow-delay=".6s" data-wow-duration="2s">JOIN US TODAY</button></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card wow fadeInRight" data-wow-duration="2s">
                            <div class="card-content">
                                <div class="title">
                                    <span>Current Exchange<div class="underline"></div></span>
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
            <div class="scroll-down wow fadeInDown" data-wow-delay=".8s" data-wow-duration="2s"><a class="navigation__link" href="#about"><img src="/themes/{{ $shop_theme }}/img/arrow-down.png"></a></div>
        </div>
    </div>

    <!-- ABOUT -->
    <section id="about" class="page-section wrapper-1" style="background-image: url('/themes/{{ $shop_theme }}/img/networkbg.png')">
        <div class="container">
            <div class="wrapper-title wow fadeIn" data-wow-duration="3s"><span>About</span> Us</div>
            <div class="img-holder wow fadeInDown" data-wow-delay=".4s" data-wow-duration="2s">
                <img src="/themes/{{ $shop_theme }}/img/aboutus-img-1.png">
            </div>
            <div class="wrapper-texts wow fadeInDown" data-wow-delay=".6s" data-wow-duration="1s">ICOins Shop is a privately owned marketing company, introducing and educating the people on different ICO’s to start an opportunity for everyone on the future generation of digital currencies.</div>
        </div>
    </section>

    <!-- MISSION VISION -->
    <section class="page-section wrapper-2">
        <div id="missionvision" class="unskew" style="background-image: url('/themes/{{ $shop_theme }}/img/missionvision-bg.png')">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="img-holder wow fadeIn" data-wow-delay=".2s" data-wow-duration="2s">
                            <img src="/themes/{{ $shop_theme }}/img/mission.png">
                        </div>
                        <div class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="2s">MISSION<div class="underline"></div>
                        </div>
                        <div class="texts wow fadeInDown" data-wow-delay=".4s" data-wow-duration="2s">To help our clients successfully launch their ICO through market intelligence, creativity and strategic vision, and to build an organization that attracts, develops, and retains outstanding people worldwide as we grow our business.</div>
                    </div>
                    <div class="col-md-6">
                        <div class="img-holder wow fadeIn" data-wow-delay=".5s" data-wow-duration="2s">
                            <img src="/themes/{{ $shop_theme }}/img/vision.png">
                        </div>
                        <div class="title wow fadeInDown" data-wow-delay=".6s" data-wow-duration="2s">VISION<div class="underline"></div>
                        </div>
                        <div class="texts wow fadeInDown" data-wow-delay=".8s" data-wow-duration="2s">ICOins Shop is dedicated in providing our clients with results-oriented advertising, public relations, and total be marketing support to be the top ICO marketing company.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="howitworks" class="page-section wrapper-3" style="background-image: url('/themes/{{ $shop_theme }}/img/networkbg.png')">
        <div class="container">
            <div class="wrapper-title wow fadeInDown" data-wow-duration="3s"><span>How</span> It Works</div>
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left">
                        <div class="text-header wow fadeInLeft" data-wow-delay=".2s" data-wow-duration="2s">How ICOinsshop Works</div>
                        <div class="text-content wow fadeInLeft" data-wow-delay=".4s" data-wow-duration="2s">Icoins shop is an e-commerce site for ICO with  marketing program that provides digital currency education and services to help people understand the essence of ICO to digital currency world and teach them how can they make these as an opportunity.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right">
                        <div class="img-holder wow fadeIn" data-wow-delay=".8s" data-wow-duration="2s">
                            <img src="/themes/{{ $shop_theme }}/img/howitworks-img.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="page-section wrapper-4">
        <div id="products" class="container unskew">
            <div class="wrapper-title wow fadeInDown" data-wow-duration="3s"><span>ICO</span> Token Products <div class="underline"></div></div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="product-holder wow fadeIn" data-wow-delay=".2s" data-wow-duration="2s">
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
                    <div class="product-holder wow fadeIn" data-wow-delay=".4s" data-wow-duration="2s">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/logo-2.png">
                        </div>
                        <div class="text">Other tokens are coming soon!</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-holder wow fadeIn" data-wow-delay=".6s" data-wow-duration="2s">
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
    <section id="news" class="page-section wrapper-5">
        <div class="container">
            <div class="wrapper-title wow fadeInDown" data-wow-duration="3s"><span>News</span> an Announcement</div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="news-holder wow fadeInLeft" data-wow-delay=".2s" data-wow-duration="2s">
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
                    <div class="news-holder wow fadeInLeft" data-wow-delay=".4s" data-wow-duration="2s">
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
                    <div class="news-holder wow fadeInLeft" data-wow-delay=".6s" data-wow-duration="2s">
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
    $(window).scroll(function(){
        $(".fadeMe, .scroll-down").css("opacity", 1 - $(window).scrollTop() / 250);
    });
});
</script>

@endsection