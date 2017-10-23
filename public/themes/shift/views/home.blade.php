@extends("layout")
@section("content")
<!-- Media Slider -->
<div class="fullscreen background parallax top-container" style="background-image: url('/themes/{{ $shop_theme }}/img/front-banner.jpg');" data-img-width="1600" data-img-height="1139" data-diff="100">
    <div class="container">
        <div class="caption-logo-container"><img src="/themes/{{ $shop_theme }}/img/top-logo.png"></div>
        <div class="caption-container animated fadeInDown">
            <h1>SCENTS.HEALTH.INFORMATION.FASHION.TECHNOLOGY</h1>
        </div>
    </div>
    <div class="scroll-down"><img src="/themes/{{ $shop_theme }}/img/scroll-down.png"></div>
</div>
<!-- SCROLL TO TOP -->
<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
<section class="brand-container">
    <div class="container">
        <div class="title">Our <span>Brand</span></div>
        <div class="sub">Our brand is a call to action for everyone that an alternative, more superior option is available for you. And it is just a click away. Try everything that we offer and you will see that SHIFTing to our brand is the best decision for you.</div>
        <div class="brand-row">
            <div class="brand-holder">
                <div class="img"><img src="/themes/{{ $shop_theme }}/img/icon/scent.png"></div>
                <div class="name a">SCENT</div>
            </div>
            <div class="brand-holder">
                <div class="img"><img src="/themes/{{ $shop_theme }}/img/icon/health.png"></div>
                <div class="name b">HEALTH</div>
            </div>
            <div class="brand-holder">
                <div class="img"><img src="/themes/{{ $shop_theme }}/img/icon/info.png"></div>
                <div class="name c">INFORMATION</div>
            </div>
            <div class="brand-holder">
                <div class="img"><img src="/themes/{{ $shop_theme }}/img/icon/fashion.png"></div>
                <div class="name d">FASHION</div>
            </div>
            <div class="brand-holder">
                <div class="img"><img src="/themes/{{ $shop_theme }}/img/icon/technology.png"></div>
                <div class="name e">TECHNOLOGY</div>
            </div>
        </div>
    </div>
</section>
<section class="opportunity-container" style="background-image: url('/themes/{{ $shop_theme }}/img/center-bg.jpg');">
    <div class="container">
        <div class="title">Your Opportunity</div>
        <div class="sub">If you like the brands we have, we would like to ask you to join our ever increasing team of distributors and become our partner in promoting S.H.I.F.T.! A very good and competitive compensation package comes with it. A perfect way to add an extra flow of cash in your basket. To find out more, contact any of our TEAM LEADERS or DIRECTORS.</div>
        <div class="row clearfix">
            <div class="col-md-4 col-sm-6">
                <div class="opportunity-holder">
                    <div class="title"><img src="/themes/{{ $shop_theme }}/img/icon/cloud.png"> Downloadable Forms</div>
                    <ul>
                        <li><a href="javascript:">SHIFT Distributor Application Form</a></li>
                        <li><a href="javascript:">ID Application Form</a></li>
                        <li><a href="javascript:">Password Reset / Retreival Form</a></li>
                        <li><a href="javascript:">Spelling Correction Form</a></li>
                        <li><a href="javascript:">SHIFT Cares Claim Form</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="opportunity-holder">
                    <div class="title"><img src="/themes/{{ $shop_theme }}/img/icon/powerpoint.png"> Shift Business Presentation</div>
                    <ul>
                        <li><a href="javascript:">SHIFT Business Presentation</a></li>
                    </ul>
                    <div class="title" style="margin-top: 60px;">Shift Cellcare Presentation</div>
                    <ul>
                        <li><a href="javascript:">CELLCARE Complete Presentation</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="opportunity-holder">
                    <div class="title">
                        {{-- <img src="/themes/{{ $shop_theme }}/img/icon/cup.png"> --}}
                        Leadership Bonus Withdrawal Form
                    </div>
                    <div class="sub">Steps to withdraw your leadership bonus:</div>
                    <ol>
                        <li>Please download this form Payout Request Form.</li>
                        <li>Fill up the information required.</li>
                        <li>Submit to management@myshiftbusiness.com</li>
                        <li>Cut-off is every Sunday and releasing of checks is on Friday.</li>
                    </ol>
                    <div class="sub">Please take note that Business Centers outside of Cebu will receive payout deliveries on Monday via LBC or AP Cargo.</div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="belief-container">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="title">Our Belief</div>
                <div class="desc">We believe that we will make a difference in every consumers chopice. We will make it very convenient for our patrons to shop for what they need at a very affordable price. We also believe that every SHIFT partner will have a huge change in lifestyle as more and more people will SHIFT! So what are you waiting for, SHIFT to our products and become a SHIFT partner now! It's EASY... It's SIMPLE!</div>
                <div class="btn-container">
                    <button class="btn btn-primary">Join Us Today</button>
                </div>
            </div>
            <div class="col-md-6">
                <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/belief-bg.jpg">
            </div>
        </div>
    </div>
</section>
<section class="brand2-container">
    <div class="container">
        <div class="title">Our <span>Brand</span></div>
        <div class="row clearfix">
            <div class="col-md-6">
                <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/brand.jpg">
            </div>
            <div class="col-md-6">
                <div class="info">
                    <div class="title">Cellcare Health Supplement</div>
                    <div class="desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. </div>
                    <div class="btn-container">
                        <div class="btn btn-primary">Shop Now</div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection

@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
@endsection