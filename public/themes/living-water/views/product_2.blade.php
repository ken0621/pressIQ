@extends("layout")
@section("content")
<div class="content">
    <div class="product-container">
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
                    </div>
                </div>
            </div>
            <div class="bottom-container">
                <div class="header">WATER TREATMENT PARTS & SUPPLIES</div>
                <div class="info-container">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="details-container">
                                {!! get_content($shop_theme_info, "product_and_services", "water_supplies_list") !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row clearfix">
                                <div class="col-md-6 col-xs-6">
                                    <div class="img-holder">
                                        <img src="{{ get_content($shop_theme_info, "product_and_services", "water_supplies_image_1") }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="img-holder">
                                        <img src="{{ get_content($shop_theme_info, "product_and_services", "water_supplies_image_2") }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="img-holder">
                                        <img src="{{ get_content($shop_theme_info, "product_and_services", "water_supplies_image_3") }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="img-holder">
                                        <img src="{{ get_content($shop_theme_info, "product_and_services", "water_supplies_image_4") }}">
                                    </div>
                                </div>
                            </div>
                            <div class="img-holder">
                                <img src="{{ get_content($shop_theme_info, "product_and_services", "water_supplies_image_5") }}">
                            </div>
                            <div class="header">QUALITY POLICY</div>
                            <div class="quality-container">
                                {!! get_content($shop_theme_info, "product_and_services", "quality_list") !!}
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product_2.css">
@endsection

@section("script")

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>

@endsection