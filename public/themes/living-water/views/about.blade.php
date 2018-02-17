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
                                <p>LIVINGWATER SYSTEM, INC., formerly known as the Livingwater Filtration and Water Refilling Station, a sole proprietorship company established in October 2004, engaged in the sale, franchising and management of water refilling stations. The Company has been known as a competent and trustworthy supplier and distributor of Ion-Exchange equipment, R.O. Dialysis, Ultraviolet Disinfection System, Ozone Generator System, Reverse Osmosis System, Alkaline Ionizers, Water Oxygenators, Water filtration, and Alkaline Systems in the market.</p>

                                <p>The company started its operation as a water refilling station that carries a 3-in-1 system, Purified water, Mineral water and Alkaline water - the first of its kind in the market, catering a vast number of consumers covering the areas of Manila, Makati, Taguig, Quezon, Las Pinas and Paranaque City with an average of 1,650 Gallons of drinking water everyday.</p>

                                <p>Water refilling station franchising started in January of 2005 in order to meet the growing demand of its services and expand into the market through low cost business franchising particularly specialized in water refilling station filtration and purification. As of November, 2010, the Company was able to build and develop 1,834 franchisees nationwide. The idea is not just giving people safe and clean drinking water but giving them the option based on what to buy and based on their preferences.</p>
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
                <div class="description-container-2">
                    <p>Holding on its firm belief to continuously innovate and improve, LIVINGWATER has been able to anticipate market demands, explore and introduce new products to meet the needs of its broad clientele, and become a trendsetter in this industry.</p>

                    <p>With increasing global needs for reliable sources in water treatment systems and components, our research and development has focused on developing innovative systems for residential, commercial and industrial applications. LIVINGWATER has added new products and services which include design, distribution, installation, commissioning and maintenance of Water Bottling Systems, Bottle Blow Molding Equipment, Industrial Ice Maker System, Waste Water Treatment Facilities, and the supply of other related industrial equipments.</p>

                    <p>LWSI continually innovates to lead in the water treatment industry because we believed that in business, for us to grow, and remain on top, we should always have something new and that’s what LIVINGWATER is all about.</p>
                </div>
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
                            <p>To contribute to the operational excellence of our customers through quality, efficient and most advanced products and services in the market that meet their water treatment requirements.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/quality.png"></span><span class="title">QUALITY OBJECTIVE</span> 
                        </div>
                        <div class="info-container">
                            <p>The company ensures that Quality objectives, including those needed to meet requirements for product is established at relevant functions and level within the organization. These objectives are measurable and consistent with the established Quality Policy.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="title-container">
                            <span class="icon-container"><img src="/themes/living-water/img/vision.png"></span><span class="title">VISION</span> 
                        </div>
                        <div class="info-container">
                            <p>LWSI vision is to become an international total water treatment player serving commercial, industrial and residential requirements using the latest and best technology that promotes sustainable environment with dynamic and proactive corporate management and staffs that are customer-focused, environmentally conscious, and technically competent.</p>
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