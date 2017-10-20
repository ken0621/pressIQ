@extends("layout")
@section("content")
<div class="content">
<!-- Media Slider -->
    <div class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/top-image.png')">
        <div class="container">
            <div class="caption-logo-container"><img src="/themes/{{ $shop_theme }}/img/logo-caption2.png"></div>
            <div class="caption-container animated fadeInDown">
                <p class="head-text">Your road to financial wellness</p>
                <p class="head-text">Lifestyle at it’s finest!</p>
            </div>
        </div>
    </div>
    <!-- WHO WE ARE -->
    <div id="aboutus" class="wrapper-1">
        <div class="container">
            <div class="wow fadeInDown title-container">
                <span>Who</span>
                <span>Are We</span>
            </div>
            <div class="content-container row clearfix">
                <div class="col-md-6">
                    <div class="content-title wow fadeInUp">JCA WELLNESS INTERNATIONAL CORP</div>
                    <div class="context">
                        <p class="wow fadeInLeft">
                            JCA Wellness International Corporation is a company that’s founded by group
                            of entrepreneurs that’s driven to build a global community that will bring
                            various business opportunities to aspiring entrepreneurs, to provide products
                            and services that will enhance one’s beauty and wellness and to teach every
                            aspiring entrepreneurs the various ways of earning.<br><br>

                            JCA Wellness International Corporation is currently building its network in
                            Raffles Corporate Center in Emerald Ave. Ortigas Pasig City and is starting to
                            grow its market in the Philippines and to other countries.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="image-container wow fadeInRight">
                        <img src="/themes/{{ $shop_theme }}/img/who-we-are-pic.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- WHY JCA -->
    <div class="wrapper-2">
        <div class="container">
            <div class="title-container">
                <div class="wow fadeInDown title-container">
                    <span>Why</span>
                    <span>JCA Wellness</span>
                </div>
            </div>
            <div class="content-container row clearfix">
                <!-- WE BELIEVE -->
                <div class="col-md-4">
                    <div class="per-image-container">
                        <img src="/themes/{{ $shop_theme }}/img/we-believe.png">
                        <div class="content-text-container">
                            <h1 class="wow fadeInLeft" data-wow-delay=".1s">We Believe</h1>
                            <div class="title-line"></div>
                            <p class="wow fadeInLeft" data-wow-delay=".3s">
                                JCA International Corporation believes that natural health and wellness has the ability to change the lives of humanity. This inspired its founders to introduce a product that will provide opportunities to aspiring entrepreneurs ways.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- WE ARE SAFE -->
                <div class="col-md-4">
                    <div class="per-image-container">
                        <img src="/themes/{{ $shop_theme }}/img/we-are-safe.png">
                        <div class="content-text-container">
                            <h1 class="wow fadeInLeft" data-wow-delay=".2s">We Are Safe</h1>
                            <div class="title-line"></div>
                            <p class="wow fadeInLeft" data-wow-delay=".4s">
                                Instead of the usual chemical-based beauty and wellness products, JCA International Corporation’s products are 100% safe and organic that will definitely have an everlasting benefits to its buyers and users.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- WE AIM -->
                <div class="col-md-4">
                    <div class="per-image-container">
                        <img src="/themes/{{ $shop_theme }}/img/we-aim.png">
                        <div class="content-text-container">
                            <h1 class="wow fadeInLeft" data-wow-delay=".3s">We Aim</h1>
                            <div class="title-line"></div>
                            <p class="wow fadeInLeft" data-wow-delay=".5s">
                                Lastly, JCA Wellness International Corporation aims to deliver these broad selection of safe and organic products that will showcase its commitment to innovate today’s beauty and wellness.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jca-title-container">
                <p class="main-title wow fadeInDown" data-wow-delay=".2s"><font class="shade-green">Benefits In</font> JCA Wellness</p>
                <p class="sub-title wow fadeInDown" data-wow-delay=".4s"><font class="shade-black">BENEFITS</font> of becoming a Member of JCA Wellness</p>
            </div>
            <div class="bulleted-list-container">
                <div class="content-container row clearfix">
                    <div class="col-md-4">
                        <li class="wow fadeInLeft bulleted-list" data-wow-delay=".2s">
                            <p class="list-content">Membership ID which entitles the distributor up to 40% Lifetime Discount on all JCA Wellness Products upon repeat purchase</p>
                        </li>
                    </div>
                    <div class="col-md-4">
                        <li class="wow fadeInLeft bulleted-list" data-wow-delay=".3s">
                            <p class="list-content">Opportunity to earn 15,000 a day, 90,000 a week, 360,000 a month for Override Sales Commission</p>
                        </li>
                    </div>
                    <div class="col-md-4">
                        <li class="wow fadeInLeft bulleted-list" data-wow-delay=".5s">
                            <p class="list-content">Product Gift Certificates for JCA Wellness Product Purchases</p>
                        </li>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <a href="/themes/{{ $shop_theme }}/img/legalities-file.jpg" class="lsb-preview">
                    <button class="legalities-button wow fadeInUp">
                        <img class="button-img" src="/themes/{{ $shop_theme }}/img/legalities-icon-button.png">
                        <p class="button-name">LEGALITIES</p>
                    </button>
                </a>
            </div>
        </div>
    </div>
    <!-- VISION MISION -->
    <div id="mission-vision" class="wrapper-3" style="background-image: url('/themes/{{ $shop_theme }}/img/mission-vision-background.png');">
        <div class="container">
                <div class="content-container row clearfix">    
                    <div class="col-md-8">
                        <div class="content-container row clearfix">
                            <div class="col-md-12">
                                <div class="jca-title-container">
                                    <p class="wow fadeInLeft title-company" data-wow-delay=".2s">COMPANY</p>
                                    <div class="wow fadeInLeft title-mission highlighted" data-wow-duration="1s" data-wow-delay=".3s">MISSION</div>
                                    <div class="wow fadeInLeft title-vision" data-wow-delay=".3s">VISION</div>
                                </div>
                            </div>
                        </div>
                        <div id="mission" class="mission-vision-container">
                            <div class="content-container row clearfix">
                                <div class="col-md-6">
                                    <p class="wow animated fadeInLeft sub-title" data-wow-delay=".2s">Bring innovation in the beauty and wellness market.</p>
                                    <p class="wow animated fadeInLeft content" data-wow-delay=".2s">In this world full of chemical-based beauty and wellness product, JCA Wellness International Corp., aims to divert the market’s attention to change their usual beauty and wellness product to safe and organic products that will guarantee them a life-long benefits.</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="wow animated fadeInLeft sub-title" data-wow-delay=".3s">To build business opportunities that will start in the Philippines and provide financial freedom.</p>
                                    <p class="wow animated fadeInLeft content" data-wow-delay=".3s">JCA Wellness International Corporation will start its initial market in the Philippines and it aims to help fellow aspiring Filipino entrepreneurs to start their business venture with the right products and the right investment.</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="wow animated fadeInLeft sub-title" data-wow-delay=".4s">To build a continuous brand and consumer loyalty.</p>
                                    <p class="wow animated fadeInLeft content" data-wow-delay=".4s">As JCA Wellness International Corporation marks it image in the market as a company that focuses on using and promoting organic and safe products, it also aims to maintain the brand positioning and the consumer loyalty by continuously providing its product and taking care of its consumers as well.</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="wow animated fadeInLeft sub-title" data-wow-delay=".5s">To expand the network globally.</p>
                                    <p class="wow animated fadeInLeft content" data-wow-delay=".5s">As this company will start its market in the Philippines, it also aims to go globally. It aims to build network, promote the products globally and give a higher opportunity to its future potential business partners.</p>
                                </div>
                            </div>
                        </div>
                        <div id="vision" class="mission-vision-container hide">
                            <div class="content-container row clearfix">
                                <div class="col-md-6">
                                    <li class="wow animated fadeInLeft bulleted-list" data-wow-duration="1s" data-wow-delay=".2s">
                                        <p class="content">JCA Wellness International Corporation is working towards seeing itself grow into one of the most well-known network market that will expand globally.</p>
                                    </li>
                                </div>
                                <div class="col-md-6">

                                    <li class="wow animated fadeInLeft bulleted-list" data-wow-duration="1s" data-wow-delay=".3s">
                                        <p class="content">As this corporation will be build up by various entrepreneurs that focuses on building network, planning strategic ways to keep up with the market trends, innovating their organic products and to keep on building the trust and loyalty of its consumers and network.</p>
                                    </li>
                                </div>
                                <div class="col-md-6">
                                    <li class="wow animated fadeInLeft bulleted-list" data-wow-duration="1s" data-wow-delay=".4s">
                                        <p class="content">Through this work and strategies that will be applied, JCA Wellness International Corporation guarantees to fulfill its mission in the near future.</p>
                                    </li>
                                </div>
                            </div>
                        </div>
                        </div>
                    <!-- <div class="col-md-4">
                        <img class="img-background" src="/themes/{{ $shop_theme }}/img/mission-vision-background.png">
                    </div> -->
                </div>
        </div>
    </div>
    <!-- COMPANY PRODUCT -->
    <!-- <div id="products" class="wrapper-4">
        <div class="container">
            <div class="jca-title-container wow fadeInDown">
                <p class="main-title"><font class="shade-green">Products &</font> Services</p>
            </div>
            <div class="products-services-container">
                <div class="content-container row clearfix">
                    <div class="col-md-4">
                        <img class="products-services-img" src="/themes/{{ $shop_theme }}/img/product&services-001.png">
                        <p class="animated fadeInLeft img-title">Swiss Apple Stem Cell Soap with Glutathione and Collagen</p>
                    </div>
                    <div class="col-md-4">
                        <img class="products-services-img" src="/themes/{{ $shop_theme }}/img/product&services-002.png">
                        <p class="animated fadeInLeft img-title">Swiss Apple Stem Cell Serum</p>
                    </div>
                    <div class="col-md-4">
                        <img class="products-services-img" src="/themes/{{ $shop_theme }}/img/product&services-003.png">
                        <p class="animated fadeInLeft img-title">Stem Cell Anti-Aging Injectable</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div id="products" class="wrapper-4" style="overflow: hidden;">
        <div class="container">
            <div class="jca-title-container wow animated fadeInDown">
                <p class="main-title"><font class="shade-green">Products &</font> Services</p>
            </div>
            <div class="products-services-container">
                <div class="wow animated fadeInLeft img-container" data-wow-delay=".2s">
                    <img src="/themes/{{ $shop_theme }}/img/products-img.png">
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper-5">
        <div class="container">
            
            <div class="row clearfix">
                <div class="col-md-6 mobile-view">
                    <div class="wow animated fadeInLeft img-container" data-wow-delay=".2s">
                        <img src="/themes/{{ $shop_theme }}/img/serum.png">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="details-container">
                        <div class="wow animated fadeInRight header" data-wow-delay=".3s">Swiss Apple&nbsp;<span>Stem Cell Serum</span></div>
                        <div class="wow animated fadeInRight sub-header" data-wow-delay=".4s">
                            <span>Contents:</span>&nbsp;5% pure Swiss Apple Stem Cell Serum
                        </div>
                        <div class="benefits">
                            <div class="wow animated fadeInRight header" data-wow-delay=".5s">Benefits: </div>
                            <ul class="wow animated fadeInRight" data-wow-delay=".6s">
                                <li>It enhances UV protection and helps in fighting skin radicals that causes skin damage.</li>
                                <li>Fights all unwanted signs of aging.</li>
                                <li>Reduces wrinkles and fine-lines.</li>
                                <li>Reveals younger and glowing, youthful skin.</li>
                                <li>Improves skin firmness.</li>
                                <li>Gives your skin soft and better feeling after every use.</li>
                                <li>The kind of serum without the sticky feel PLUS it can be absorbed by the skin easily.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mobile-view-2">
                    <div class="wow animated fadeInLeft img-container" data-wow-delay=".2s">
                        <img src="/themes/{{ $shop_theme }}/img/serum.png">
                    </div>
                </div>
            </div>


            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="wow animated fadeInLeft img-container" data-wow-delay=".2s">
                        <img src="/themes/{{ $shop_theme }}/img/stem-img.png">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="details-container">
                        <div class="wow animated fadeInRight header" data-wow-delay=".3s">Swiss Apple Stem Cell Soap with <span>Glutathione and Collagen</span></div>
                        <div class="wow animated fadeInRight sub-header" data-wow-delay=".4s">
                            <span>Contents:</span> Swiss Apple Stem Cell, Glutathione and Collagen
                        </div>
                        <div class="benefits">
                            <div class="wow animated fadeInRight header" data-wow-delay=".5s">Benefits: </div>
                            <ul class="wow animated fadeInRight" data-wow-delay=".6s">
                                <li>Increases skin stem cell vitality and longevity</li>
                                <li>Helps treat skin problems like hyperpigmentation, acne or pimple scars, uneven skin tone</li>
                                <li>Fights all unwanted signs of aging</li>
                                <li>Reduces wrinkles and fine-lines</li>
                                <li>Reveals younger and glowing, youthful skin</li>
                                <li>Maintains the health and elasticity of the skin</li>
                                <li>Provides freshness and gives your skin soft and clean feeling</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper-6" style="overflow: hidden;">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="details-container">
                        <div class="wow animated fadeInLeft header">Stem Cell Therapy-&nbsp;<span>The Anti-Aging and Rejuvenation Therapy</span></div>
                        <div class="benefits">
                            <div class="wow animated fadeInRight header" data-wow-delay=".5s" style="font-size: 15px;">Benefits: </div>
                            <ul class="wow animated fadeInRight" data-wow-delay=".6s">
                                <li>Solves skin problems and eliminate wrinkles, acne, eye bags, moisturize dry skin, stimulate skin cell renewal, promote blood circulation.</li>
                                <li>Helps to improve the aging problem, high blood pressure, diabetes, stomach ulcers, migraine headaches and arthritis</li>
                                <li>Invigorates the body, improves sexual desire and prevents impotence</li>
                                <li>Helps to improve lack of vitality, fatigue and poor physical symptoms</li>
                                <li>Premature aging and wear of the organs, such as brain, heart, lungs, kidneys and digestive system.</li>
                                <li>Reduces the effect of anemia</li>
                                <li>After surgery to promote wound healing and reduce recovery time</li>
                                <li>Restores the normal function for hormone secretion</li>
                                <li>Regulating the autonomic nervous system, enhance the immune system</li>
                                <li>Stimulate he muscles, skin, collagen, bone and cartilage and nerve tissue for normal growth regeneration and repair</li>
                                <li>Recuperation from labour, eases menopause syndrome and regulates menstruation</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wow animated fadeInRight img-container" data-wow-delay=".3s">
                        <img src="/themes/{{ $shop_theme }}/img/product&services-003.png">
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css?updated2">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/responsive.css">
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