@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div id="home" class="slider-wrapper single-item">
        <img src="/themes/{{ $shop_theme }}/img/home-banner.jpg">
        <img src="/themes/{{ $shop_theme }}/img/home-banner-2.jpg">
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
                            <p>{!! get_content($shop_theme_info, "home", "home_about_description") !!}</p>
                        </div>
                        <div class="button-container">
                            <a href="/about"><button>READ MORE &raquo;</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-container">
                        <a class="lsb-preview" href="{{ get_content($shop_theme_info, "home", "home_about_image") }}">
                            <div class="image-holder">
                                <img src="{{ get_content($shop_theme_info, "home", "home_about_image") }}">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="process" class="wrapper-2">
        <div class="container">
            <div class="title-container">
                <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">OUR PROCESS</span>
            </div>
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="process-container">
                        <div class="process-holder">
                            <a class="lsb-preview" href="{{ get_content($shop_theme_info, "home", "home_process_image_1") }}">
                                <div class="process-image">
                                    <img src="{{ get_content($shop_theme_info, "home", "home_process_image_1") }}">
                                </div>
                            </a>
                        </div>
                        <div class="details-container">
                            <div class="title">{!! get_content($shop_theme_info, "home", "home_process_title_1") !!}</div>
                            <div class="description">{!! get_content($shop_theme_info, "home", "home_process_description_1") !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="process-container">
                        <div class="process-holder">
                            <a class="lsb-preview" href="{{ get_content($shop_theme_info, "home", "home_process_image_2") }}">
                                <div class="process-image">
                                    <img src="{{ get_content($shop_theme_info, "home", "home_process_image_2") }}">
                                </div>
                            </a>
                        </div>
                        <div class="details-container">
                            <div class="title">{!! get_content($shop_theme_info, "home", "home_process_title_2") !!}</div>
                            <div class="description">{!! get_content($shop_theme_info, "home", "home_process_description_2") !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="service" class="wrapper-3">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left-container">
                        <a class="lsb-preview" href="{{ get_content($shop_theme_info, "home", "home_product_image") }}">
                            <div class="image-holder">
                                <img src="{{ get_content($shop_theme_info, "home", "home_product_image") }}">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-container">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">PRODUCT AND SERVICES</span>
                        </div>
                        <div class="description-container">
                            {!! get_content($shop_theme_info, "home", "home_product_description") !!}
                        </div>
                        <div class="button-container">
                            <a href="/product2"><button>READ MORE &raquo;</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="gallery" class="wrapper-4">
        <div class="container">
            <div class="title-container">
                <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">PRODUCT GALLERY</span>
            </div>
            <div class="row clearfix">
                @if(count($_product) > 0)
                    @foreach(limit_foreach($_product, 8) as $product)
                    <div class="col-md-3 col-sm-4 col-xs-4">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="{{ get_product_first_image($product) }}">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    {{-- <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/alkaline.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/APC.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/bottled-water.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/CAP.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/caps.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/dispensers.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/filter-housing.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="per-album-container">
                            <div class="img-container">
                                <a href="/product/view2/{{ $product['eprod_id'] }}">
                                    <img src="/themes/{{ $shop_theme }}/img/gallons.jpg">
                                </a>
                            </div>
                        </div>
                    </div> --}}
                @endif
            </div>
            <div class="button-container">
                <a href="/product"><button>SHOW MORE &raquo;</button></a>
            </div>
        </div>
    </div>

    <div id="contact" class="wrapper-5">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">
                        <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">GET IN TOUCH WITH US</span>
                    </div>
                     <form action="Post"> 
                        @if (session('message_concern_p4ward'))
                            <div class="alert alert-success">
                                {{ session('message_concern_p4ward') }}
                            </div>
                        @endif
                         <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="contactus_first_name" name="contactus_first_name" placeholder="First Name*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="contactus_last_name" name="contactus_last_name" placeholder="Last Name*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <input type="phone" class="form-control" id="contactus_phone_number" name="contactus_phone_number" placeholder="Phone Number*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="contactus_email" name="contactus_email" placeholder="Email Address*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text area" class="form-control" id="contactus_subject" name="contactus_subject" placeholder="Subject*" required> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea type="text" class="form-control text-message" id="contactus_message" name="contactus_message" placeholder="Message*" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="button-container">
                                    <button type="submit" formaction="/contact_us/send">SEND</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="info-container">
                        <div class="map-container">
                            <iframe src="{{ get_content($shop_theme_info, "contact_details", "contact_google_map_link") }}" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                        <div class="title">Main Office: </div>
                        <div class="details-container">
                            <span class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span><span class="details">{!! get_content($shop_theme_info, "contact_details", "contact_company_address") !!}</span>
                        </div>
                        <div class="title">Email Address: </div>
                        <div class="details-container">
                            <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span><span class="details">{!! get_content($shop_theme_info, "contact_details", "contact_company_email_address") !!}</span>
                        </div>
                        <div class="title">Contact Number: </div>
                        <div class="details-container">
                            <span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span><span class="details">{!! get_content($shop_theme_info, "contact_details", "contact_company_contact_number") !!}</span>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css?version=1.3">
@endsection

@section("script")

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