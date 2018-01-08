@extends("layout")
@section("content")
<div class="content">

    <!-- Media Slider -->
    <div id="home" class="slider-wrapper single-item">
        <img src="/themes/{{ $shop_theme }}/img/home-banner.jpg">
        <img src="/themes/{{ $shop_theme }}/img/home-slide-1.jpg">
    </div>

    <!-- About P4ward -->
    <div id="aboutus" class="wrapper-1">
        <div class="container">
            <div class="row clearfix">
                <div class="wow fadeInLeft col-md-8">
                    <!-- History of P4ward -->
                    <div class="title-container">
                        <span class="icon-container"><img src="/themes/{{ $shop_theme }}/img/p4ward-icon-blue.png"></span><span class="title-blue">Our </span><span class="title-orange">History</span>
                    </div>
                    <div class="details-container">
                        <p>P4ward Global Marketing started through the concept of giving.</p>
                        <p>On December 22, 2016, a tragedy hit our family. An accident happened in the apartment of my brother which started a fire that engulfed the entire flat including his body. He suffered 60% body burn up to the 3rd degrees.</p>
                        <p>The nearest hospital he can be rushed to was a big private hospital. He will stay in the ICU for almost 2 weeks and will stay in the hospital for the next 3 months until he will fully recover.</p>
                        <p>During the first 3 days in the ICU, his bill already reached 6 digits just for the hospital and medicine bills alone. That bill was already bigger than our entire family’s savings combined and with the rate of his medical expenses, it’ll reach 7 figures within the next few days.</p>
                    </div>
                    <div class="button-container"><a href="#">Read More &raquo;</a></div>
                </div>
                <div class="wow fadeInRight col-md-4">
                    <div class="right-container">
                        <!-- Purpose of P4ward -->
                        <div class="title-container">
                            <span class="title-white">Our </span><span class="title-orange">Purpose</span>
                        </div>
                        <p>To create and promote a good image of Network Marketing in the Philippines.</p>
                        <!-- Mission -->
                        <div class="subtitle-container">
                            <span class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-mission.png"></span><span class="title">Mission</span>
                        </div>
                        <p>Uplift Lives</p>
                        <!-- Vision -->
                        <div class="subtitle-container">
                            <span class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-vision.png"></span><span class="title">Vision</span>
                        </div>
                        <p>100,000 successful P4wards Partners</p>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <!-- Why P4ward -->
    <div class="wrapper-2">
        <div class="container">
            <div class="wow fadeInDown title-container">
                <span class="icon-container"><img src="/themes/{{ $shop_theme }}/img/p4ward-icon-white.png"></span><span class="title-white">Why </span><span class="title-orange">P4ward</span>
            </div>
            <div class="bottom-container">
                <di class="row clearfix">
                    <div class="wow fadeInLeft col-md-5">
                        <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper2-image.jpg"></div>
                    </div>
                    <div class="wow fadeInRight col-md-7">
                        <div class="title">Why Join P4ward</div>
                        <div class="details-container">
                            <p>Our goal is not just to help you succeed but to make you significant to others. It’s a bigger
    responsibility but it’s a life worth living. Imagine someone approached you and with tears in his eyes hugged and thanked you from the bottom of his heart because of the impact you made in his life. That is being significant.</p>
                            <p>SUCCESS is achieving your dreams.</p>
                            <p>SIGNIFICANCE is helping someone achieve their dreams.</p>
                            <p>I invite you to help us create a deeper meaning of Network Marketing. We will define it as not only the source of great products and opportunities, but also the source of camaraderie, respect and love for others. Because it’s not just about you, it’s about others.</p>
                        </div>
                    </div>
                </di>
            </div>
        </div>
    </div>

    <!-- Product of P4ward -->
    <div id="product" class="wrapper-3">
        <div class="container">
            <div class="wow fadeInDown title-container">
                <span class="icon-container"><img src="/themes/{{ $shop_theme }}/img/p4ward-icon-blue.png"></span><span class="title-blue">Our </span><span class="title-orange">Products</span>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="wow fadeInLeft product-container" data-wow-delay=".6s">
                            <div class="percent-container">100% Organic</div>
                            <div class="product-title-container">Don Organics Coffee Scrub</div>
                            <div class="product-image"><img src="/themes/{{ $shop_theme }}/img/wrapper3-image1.png"></div>
                            <div class="button-container"><a href="/product">See Benefits</a></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="wow fadeInRight product-container" data-wow-delay=".6s">
                            <div class="percent-container">100% Organic</div>
                            <div class="product-title-container">Don Organics Red Rice Scrub</div>
                            <div class="product-image"><img src="/themes/{{ $shop_theme }}/img/wrapper3-image2.png"></div>
                            <div class="button-container"><a href="#">See Benefits</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits of their Product -->
    <div class="wrapper-4" style="background-image: url('/themes/{{ $shop_theme }}/img/wrapper4-banner.jpg')">
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="wow fadeInLeft benefits-container">
                    <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper4-image1.png"></div>
                    <div class="title-container">100 % Ogranic</div>
                    <div class="details-container">Organically produced ingredients. Processed without the use of any chemicals.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wow fadeInDown benefits-container">
                    <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper4-image2.png"></div>
                    <div class="title-container">Rich Source of Antioxidants</div>
                    <div class="details-container">Choosing organic food can lead to increased intake of nutritionally desirable antioxidants.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wow fadeInRight benefits-container">
                    <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper4-image3.png"></div><div class="title-container">2x More Caffeine</div>
                    <div class="details-container">Don Organics Robusta coffee scrub caffeine content twice as potent as other coffee scrub.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Don Organics -->
    <div class="wrapper-5">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-7">
                    <div class="wow fadeInLeft title-container">What makes Don Organics Different from Other Coffee Scrubs?</div>
                    <div class="wow fadeInLeft details-container">
                        <p>One of the important factors of a coffee scrub is its caffeine content.</p>
                        <p>Some coffee scrubs will only use brewed coffee grounds which has less benefits to the skin due to the depletion of caffeine. Others use Arabica coffee beans, which almost all coffee that you drink are made of.</p>
                        <p>The higher the caffeine content of the scrub, the more it is beneficial to the skin.</p>
                        <p>Don Organics uses Robusta coffee beans. Robusta beans have 2x more caffeine than Arabica beans do. This makes Don Organics coffee scrub caffeine content twice as potent as other coffee scrub.</p>
                        <p>Since caffeine is the key ingredient to a very effective scrub, Don Organics spend more on Robusta beans so our customers get the best coffee scrub they deserve.</p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="wow fadeInRight image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper5-image.jpg"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials of P4ward -->
    <div id="testimonials" class="wrapper-6">
        <div class="container">
            <div class="wow fadeInDown title-container">
                <span class="icon-container"><img src="/themes/{{ $shop_theme }}/img/p4ward-icon-white.png"></span><span class="title-white">What </span><span class="title-orange">They </span><span class="title-orange">Say</span>
            </div>
            <div class="says-container">
                <div>
                    <div class="holder wow fadeInDown" data-wow-delay=".2s">
                        <div class="feedback-container match-height">
                            <div class="top-container">
                                <div class="row-no-padding clearfix">
                                    <div class="col-md-3">
                                        <div class="image-holder">
                                            <img src="/themes/{{ $shop_theme }}/img/wrapper6-image1.png">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="name">Mumai Vitangcol Nidea</div>
                                        <div class="date">January 10</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-container">
                                <div class="description">Another must haves! I rarely use skin essentials but this one's on top of my list now! You can use it on your face and body and see/feel the result right after using it. One of the best products I've used and I just love that freshly brewed coffee smell. Two thumbs up!</div>
                                <div class="star"><img src="/themes/{{ $shop_theme }}/img/wrapper6-star.png"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="holder wow fadeInDown" data-wow-delay=".3s">
                        <div class="feedback-container match-height">
                            <div class="top-container">
                                <div class="row-no-padding clearfix">
                                    <div class="col-md-3">
                                        <div class="image-holder">
                                            <img src="/themes/{{ $shop_theme }}/img/wrapper6-image2.png">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="name">Maricar-Anthony Sierra</div>
                                        <div class="date">February 7</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-container">
                                <div class="description">Wow! I usually don't write reviews, but I read tons of reviews before trying out something, and I just had to add another good one. I have tried hundreds of products and this is probably the best scrub I have ever come across! Cleared up my excema and makes my skin soo soft! Worth the money!! Will Def repurchase when this bag runs out.</div>
                                <div class="star"><img src="/themes/{{ $shop_theme }}/img/wrapper6-star.png"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="holder wow fadeInDown" data-wow-delay=".4s">
                        <div class="feedback-container match-height">
                            <div class="top-container">
                                <div class="row-no-padding clearfix">
                                    <div class="col-md-3">
                                        <div class="image-holder">
                                            <img src="/themes/{{ $shop_theme }}/img/wrapper6-image3.png">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="name">Shiela Mae San Diego</div>
                                        <div class="date">January 8</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-container">
                                <div class="description">Makes my skin soft and smooth after using it. It's a bit messy to use but rinses easily with (a lot of) water.</div>
                                <div class="star"><img src="/themes/{{ $shop_theme }}/img/wrapper6-star.png"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="holder wow fadeInDown" data-wow-delay=".5s">
                        <div class="feedback-container match-height">
                            <div class="top-container">
                                <div class="row-no-padding clearfix">
                                    <div class="col-md-3">
                                        <div class="image-holder">
                                            <img src="/themes/{{ $shop_theme }}/img/wrapper6-image1.png">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="name">Mumai Vitangcol Nidea</div>
                                        <div class="date">January 10</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-container">
                                <div class="description">Another must haves! I rarely use skin essentials but this one's on top of my list now! You can use it on your face and body and see/feel the result right after using it. One of the best products I've used and I just love that freshly brewed coffee smell. Two thumbs up!</div>
                                <div class="star"><img src="/themes/{{ $shop_theme }}/img/wrapper6-star.png"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div id="contactus" class="wrapper-7">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">Get Intouch With Us</div>
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
                                <a href="#Read More">SEND</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-address.png"></span><span class="title">Business Address</span>
                    <div class="details-container"><p>0261 BE (STALL 1) M.A. Fernando St. Santa Cruz Angat Bulacan 3012</p></div>
                    <span class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-envelope.png"></span><span class="title">Email Address</span>
                    <div class="details-container"><p>admin@p4ward.com</p></div>
                    <span class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-mobile.png"></span><span class="title">Contact Number</span>
                    <div class="number-container"><p>Phone: 028995519</p><p>Mobile: 0947-985-5602 / 09988627466</p></div>
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
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.single-item').slick
        ({
            prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left.png'>",
            nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right.png'>",
            dots: false,
            autoplay: true,
            autoplaySpeed: 3000,
        });

        lightbox.option({
          'disableScrolling': true,
          'wrapAround': true
        });

    });
</script>

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>


@endsection