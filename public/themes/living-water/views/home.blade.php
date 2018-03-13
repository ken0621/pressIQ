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

    <div id="product" class="wrapper-3">
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
                            <ul>
                                <li>Testing and analyzing of clients in-house water supplies for the presence of bacteria, fungi, organic and inorganic compounds, taste and odor.</li>
                                <li>Installation of the optimal water treatment and purification systems based on the client’s informed, educated and affordable choice.</li>
                                <li>Routine monitoring of installed components to minimize equipment failure and ensure timely replacement of expired filters and components.</li>
                            </ul>
                        </div>
                        <div class="button-container">
                            <a href="/product"><button>READ MORE &raquo;</button></a>
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
                    @foreach($_product as $product)
                    <div class="col-md-3">
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
                    <div class="col-md-3">
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
                    </div>
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
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15440.112259220126!2d121.02096329822486!3d14.65434838967788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b6faf1ed4163%3A0xa543aa75a00c2da5!2sVeterans+Village%2C+Project+7%2C+Quezon+City%2C+Metro+Manila!5e0!3m2!1sen!2sph!4v1520982546353" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
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