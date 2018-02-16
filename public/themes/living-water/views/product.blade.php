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
                            <ul>
                                <li>Testing and analyzing of clients in-house water supplies for the presence of bacteria, fungi, organic and inorganic compounds, taste and odor.</li>
                                <li>Installation of the optimal water treatment and purification systems based on the client’s informed, educated and affordable choice.</li>
                                <li>Routine monitoring of installed components to minimize equipment failure and ensure timely replacement of expired filters and components.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="other-info-container">
                <div class="header">"WATER TREATMENT PARTS AND SUPPLIES"</div>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="title">MULTI-PORT VALVES</div>
                        <div class="list-container">
                            <ul>
                                <li>Pentair – Fleck</li>
                                <li>G.E. Autotrol Valves</li>
                                <li>Manual Valves</li>
                                <li>Programmable Head</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">PUMPS</div>
                        <div class="list-container">
                            <ul>
                                <li>Booster Pump & Bladder Tanks</li>
                                <li>Rotary Vane Pumps and Motors</li>
                                <li>Multi-Stage Centrifugal Vertical Pumps</li>
                                <li>Multi-Stage Centrifugal Horizontal Pumps</li>
                                <li>Metering Pumps/Chemical Dosing Pumps</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">METERS, STERILIZER, & VALVES</div>
                        <div class="list-container">
                            <ul>
                                <li>Water Meters</li>
                                <li>Flowmeters</li>
                                <li>Clear Housing</li>
                                <li>Ultraviolet Sterilizer</li>
                                <li>Ozone Generator</li>
                                <li>ORP / Energizer</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">SWITCHES & CONTROLS</div>
                        <div class="list-container">
                            <ul>
                                <li>Pressure Switch</li>
                                <li>Magnetic Float Switch</li>
                                <li>Liquid Level Controls</li>
                                <li>RO Computer Controller</li>
                                <li>pH/ORP Controllers</li>
                                <li>Automatic Pump Control</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">FILTER HOUSING</div>
                        <div class="list-container">
                            <ul>
                                <li>Big Blue Housing</li>
                                <li>Slim Blue Housing</li>
                                <li>Clear Housing</li>
                                <li>Stainless Steel Housing</li>
                                <li>Bag Filters</li>
                                <li>Rapid Filters</li>
                                <li>Stainless Steel Tanks</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">MEMBRANE VESSEL</div>
                        <div class="list-container">
                            <ul>
                                <li>Stainless Steel Vessel</li>
                                <li>FRP Membrane VesselMEMBRANE & FILTERS</li>
                                <li>Reverse Osmosis Membranes</li>
                                <li>Ultrafiltration Membrane</li>
                                <li>Sediment Filters</li>
                                <li>Pleated & Wound Cartridge</li>
                                <li>Carbon Block Filter</li>
                                <li>Pleated Membrane Filter</li>
                                <li>Ceramic Filter</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">WATER REFILLING STATION SUPPORT PRODUCTS</div>
                        <div class="list-container">
                            <ul>
                                <li>PET Bottles</li>
                                <li>5 Gallon Round Container</li>
                                <li>5 Gallon Slim Containers</li>
                                <li>Hot & Cold Dispensers</li>
                                <li>Bottle Caps/ Non-spill Caps</li>
                                <li>Generic Seals</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">RESIDENTIAL WATER TREATMENT</div>
                        <div class="list-container">
                            <ul>
                                <li>Filtration System</li>
                                <li>100-400GPD RO. Systems</li>
                                <li>Ultrafiltration System</li>
                                <li>50GPD RO. System</li>
                                <li>ET-PURE RO. System</li>
                                <li>Alkaline Ionizers</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">COMMERCIAL WATER TREATMENT</div>
                        <div class="list-container">
                            <ul>
                                <li>Reverse Osmosis System</li>
                                <li>Filtration System</li>
                                <li>Ultrafiltration System</li>
                                <li>Alkaline Ionizer</li>
                                <li>Oxygenated Water</li>
                                <li>Ozonation</li>
                                <li>Water Sterilization</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">INDUSTRIAL WATER TREATMENT</div>
                        <div class="list-container">
                            <ul>
                                <li>Carbon Steel Filter</li>
                                <li>Stainless Steel Filter</li>
                                <li>Fiber Glass Filter</li>
                                <li>PP Filter</li>
                                <li>FRP Filter</li>
                                <li>R.O. Type Desalination</li>
                                <li>Vapor Type Desalination</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">FRP TANKS, MEDIA FILTERS, BRINETANK & CHEMICAL TANK,DISTRIBUTORS, PIPES & FITTINGS</div>
                        <div class="list-container">
                            <ul>
                                <li>Calcite</li>
                                <li>Activated Carbon</li>
                                <li>Ion Exchange Resin</li>
                                <li>Anthracite Carbon</li>
                                <li>Silica Sand</li>
                                <li>Manganese Green Sand</li>
                                <li>PPR Pipes & Fittings</li>
                                <li>U-PVC Pipes & Fittings</li>
                                <li>Stainless Steel Needle Valve</li>
                                <li>Solenoid Valve</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="title">WASTE WATER TREATMENT</div>
                        <div class="list-container">
                            <ul>
                                <li>Pressure Filter</li>
                                <li>Twist Filter</li>
                                <li>Continuous Sand Filter</li>
                                <li>Micro Drum Filter</li>
                                <li>Trickling Filters</li>
                                <li>Aeration Systems</li>
                                <li>Membrane Bio-Reacto</li>
                                <li>SBR & derivatives of Activated Sludge Treatment</li>
                                <li>Filter Press & Sludge Dehydrator</li>
                                <li>Blower</li>
                                <li>Agitator</li>
                                <li>Polymer Automatic Melting Machine</li>
                            </ul>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product.css">
@endsection

@section("script")

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>

@endsection