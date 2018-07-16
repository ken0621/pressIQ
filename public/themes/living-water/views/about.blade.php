@extends("layout")
@section("content")
<div class="content">
    <div class="about-container">
        <div class="container">
            <div class="about-living-water-container">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="left-container">
                            <div class="title-container">
                                <span class="icon-container"><img src="/themes/living-water/img/water-drops.png"></span><span class="title">ABOUT US</span>
                            </div>
                            <div class="description-container-1">
                                {!! get_content($shop_theme_info, "about", "about_context") !!}
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
                {{-- <div class="description-container-2">
                    <p>Holding on its firm belief to continuously innovate and improve, LIVINGWATER has been able to anticipate market demands, explore and introduce new products to meet the needs of its broad clientele, and become a trendsetter in this industry.</p>

                    <p>With increasing global needs for reliable sources in water treatment systems and components, our research and development has focused on developing innovative systems for residential, commercial and industrial applications. LIVINGWATER has added new products and services which include design, distribution, installation, commissioning and maintenance of Water Bottling Systems, Bottle Blow Molding Equipment, Industrial Ice Maker System, Waste Water Treatment Facilities, and the supply of other related industrial equipments.</p>

                    <p>LWSI continually innovates to lead in the water treatment industry because we believed that in business, for us to grow, and remain on top, we should always have something new and that’s what LIVINGWATER is all about.</p>
                </div> --}}
            </div>
        </div>
        <div class="mission-vision-container" style="background-image: url('/themes/living-water/img/about-banner.jpg')">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/mission.png"></span><span class="title">MISSION</span> 
                        </div>
                        <div class="info-container">
                            {!! get_content($shop_theme_info, "about", "about_mission") !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/quality.png"></span><span class="title">QUALITY OBJECTIVE</span> 
                        </div>
                        <div class="info-container">
                            {!! get_content($shop_theme_info, "about", "about_quality_objective") !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/vision.png"></span><span class="title">VISION</span> 
                        </div>
                        <div class="info-container">
                            {!! get_content($shop_theme_info, "about", "about_vision") !!}
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/about.css">
@endsection

@section("script")

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>

@endsection