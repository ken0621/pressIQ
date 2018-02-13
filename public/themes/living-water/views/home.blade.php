@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div id="home" class="slider-wrapper" style="background-image: url('/themes/living-water/img/home-banner.jpg')">
        <div class="container">
            
        </div>
    </div>

    <div id="about" class="wrapper-1">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left-container">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">ABOUT US</span>
                        </div>
                        <div class="description-container">
                            <p>LIVINGWATER has been in the business of supplying healthy drinking water for almost three (3) years. Given its vast marketing experiences and a solid development foundation, our company has carved for itself a formidable position in the supply of healthy drinking water in the Philippines.</p>
                            <p>Being the first to launch in the market a unique marketing approach, LIVINGWATER popularize the 3-N-1 system – PURIFIED WATER, MINERAL WATER, ALKALINE WATER in just one refilling station. This technology attributes to the drastic growth of our practical Franchisees who want to give their customers the best option on what to buy on their budget, taste, health preferences, and the freedom to choose – that is all LIVINGWATER all about.</p>
                            <p>Holding on its firm belief to continuously innovate and improve, LIVINGWATER has been able to anticipate market demands, explore and introduce new products to meet the needs of its broad clientele, and has become a trendsetter in this industry.</p>
                        </div>
                        <div class="button-container">
                            <a href="#"><button>READ MORE</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-container">
                        <div class="image-holder">
                            <img src="/themes/living-water/img/about-image.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="prcess" class="wrapper-2">
        <div class="container">
            <div class="title-container">
                <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">OUR PROCESS</span>
            </div>
            <div class="process-carousel">
                <div class="holder">
                    <div class="process-container">
                        <div class="process-holder">
                            <div class="process-image"><img src="/themes/living-water/img/process-image-1.png"></div>
                        </div>
                        <div class="details-container">
                            <div class="title">Lorem Ipsum</div>
                            <div class="ratings"><img src="/themes/living-water/img/star.png"></div>
                        </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="process-container">
                        <div class="process-holder">
                            <div class="process-image"><img src="/themes/living-water/img/process-image-2.png"></div>
                        </div>
                        <div class="details-container">
                            <div class="title">Lorem Ipsum</div>
                            <div class="ratings"><img src="/themes/living-water/img/star.png"></div>
                        </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="process-container">
                        <div class="process-holder">
                            <div class="process-image"><img src="/themes/living-water/img/process-image-1.png"></div>
                        </div>
                        <div class="details-container">
                            <div class="title">Lorem Ipsum</div>
                            <div class="ratings"><img src="/themes/living-water/img/star.png"></div>
                        </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="process-container">
                        <div class="process-holder">
                            <div class="process-image"><img src="/themes/living-water/img/process-image-2.png"></div>
                        </div>
                        <div class="details-container">
                            <div class="title">Lorem Ipsum</div>
                            <div class="ratings"><img src="/themes/living-water/img/star.png"></div>
                        </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="process-container">
                        <div class="process-holder">
                            <div class="process-image"><img src="/themes/living-water/img/process-image-1.png"></div>
                        </div>
                        <div class="details-container">
                            <div class="title">Lorem Ipsum</div>
                            <div class="ratings"><img src="/themes/living-water/img/star.png"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contact" class="wrapper-3">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">
                        <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">GET IN TOUCH WITH US</span>
                    </div>
                     <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <input type="phone" class="form-control" placeholder="Phone Number*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text area" class="form-control" placeholder="Subject*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea type="text" class="form-control text-message" placeholder="Message*"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="button-container">
                                <button>SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-container">
                        <span class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-address.png"></span><span class="title">Business Address</span>
                        <div class="details-container"><p></p></div>
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

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>

@endsection