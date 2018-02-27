@extends("layout")
@section("content")
<div class="content">{{-- {{ get_content($shop_theme_info, "home", "home_banner") }} --}}
    <!-- Media Slider -->
    <section class="slider-wrapper">
        <div class="top-banner" style="background-image: url('/themes/paptsi-v2/img/home-banner.jpg');">
            <div class="container">
                <div class="c-container">
                    <div>
                        <span>We Aim For The Best</span><span> Services</span>
                    </div>
                    <div>
                        In the Industry of Ports and Terminal Services
                    </div>
                    <div>
                        {!! get_content($shop_theme_info, "home", "home_banner_description") !!}
                    </div>
                    <button class="t-button">Read More</button>
                </div>
            </div>
        </div>
    </section>

    <div id="services" class="wrapper-1">
        <div class="row-no-padding clearfix">
            <div class="col-md-3">
                <div class="service-1-3-container match-height">
                    <div class="image-holder"><img src="{{ get_content($shop_theme_info, "home", "home_services_image1") }}"></div>
                    <div class="service-title">{!! get_content($shop_theme_info, "home", "home_services_title1") !!}</div>
                    <div class="service-details">{!! get_content($shop_theme_info, "home", "home_services_description1") !!}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="service-2-4-container match-height">
                    <div class="image-holder"><img src="{{ get_content($shop_theme_info, "home", "home_services_image2") }}"></div>
                    <div class="service-title">{!! get_content($shop_theme_info, "home", "home_services_title2") !!}</div>
                    <div class="service-details">{!! get_content($shop_theme_info, "home", "home_services_description2") !!}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="service-1-3-container match-height">
                    <div class="image-holder"><img src="{{ get_content($shop_theme_info, "home", "home_services_image3") }}"></div>
                    <div class="service-title">{!! get_content($shop_theme_info, "home", "home_services_title3") !!}</div>
                    <div class="service-details">{!! get_content($shop_theme_info, "home", "home_services_description3") !!}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="service-2-4-container match-height">
                    <div class="image-holder"><img src="{{ get_content($shop_theme_info, "home", "home_services_image4") }}"></div>
                    <div class="service-title">{!! get_content($shop_theme_info, "home", "home_services_title4") !!}</div>
                    <div class="service-details">{!! get_content($shop_theme_info, "home", "home_services_description4") !!}</div>
                </div>
            </div> 
        </div>
    </div>

    <div id="aboutus" class="wrapper-2">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left-container">
                        <div class="title-container"><span class="border">|</span><span class="title"> OUR COMPANY</span></div>
                        <div class="description-container">{!! get_content($shop_theme_info, "home", "home_company_description") !!}</div>
                         <div class="button-container">
                            <a href="#Read More">READ MORE</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-container">
                        <div class="image-holder">
                            <img src="{{ get_content($shop_theme_info, "home", "home_company_image") }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="expertise" class="wrapper-3">
        <div class="container">
            <div class="top-container">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="left-container">
                            <div class="title-container"><span class="border">|</span><span class="title"> OUR EXPERTISE</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="right-container">
                            <div class="description-container">{!! get_content($shop_theme_info, "home", "home_expertise_description") !!}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-container">
                <div class="row clearfix">
                    <div class="col-md-3">
                        <div class="holder-container">
                            <div class="image-holder">
                                <img src="{{ get_content($shop_theme_info, "home", "home_expertise_image1") }}">
                            </div>
                            <div class="title-container">{!! get_content($shop_theme_info, "home", "home_expertise_title1") !!}</div>
                            <div class="description-container match-height">{!! get_content($shop_theme_info, "home", "home_expertise_description1") !!}</div>
                            <div class="read-container">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="holder-container">
                            <div class="image-holder">
                                <img src="{{ get_content($shop_theme_info, "home", "home_expertise_image2") }}">
                            </div>
                            <div class="title-container">{!! get_content($shop_theme_info, "home", "home_expertise_title2") !!}</div>
                            <div class="description-container match-height">{!! get_content($shop_theme_info, "home", "home_expertise_description2") !!}</div>
                            <div class="read-container">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="holder-container">
                            <div class="image-holder">
                                <img src="{{ get_content($shop_theme_info, "home", "home_expertise_image3") }}">
                            </div>
                            <div class="title-container">{!! get_content($shop_theme_info, "home", "home_expertise_title3") !!}</div>
                            <div class="description-container match-height">{!! get_content($shop_theme_info, "home", "home_expertise_description3") !!}</div>
                            <div class="read-container">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="holder-container">
                            <div class="image-holder">
                                <img src="{{ get_content($shop_theme_info, "home", "home_expertise_image4") }}">
                            </div>
                            <div class="title-container">{!! get_content($shop_theme_info, "home", "home_expertise_title4") !!}</div>
                            <div class="description-container match-height">{!! get_content($shop_theme_info, "home", "home_expertise_description4") !!}</div>
                            <div class="read-container">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="careers" class="wrapper-4" style="background-image: url('{{ get_content($shop_theme_info, "home", "home_banner_paptsi-carrers") }}')">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left-container">
                        <div class="title-container"><span class="border">|</span><span class="title"> PAPTSI CAREERS</span></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-container">
                        <div class="description-container">{!! get_content($shop_theme_info, "home", "home_paptsi-career_description") !!}</div>
                         <div class="button-container">
                            <a href="#Read More">SEE MORE</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div id="contactus" class="wrapper-5">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">Get In Touch With Us</div>
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
                    <div class="title-container">Location:</div>
                    <div class="contact-info"><i class="fa fa-map-marker" aria-hidden="true"></i><span>{!! get_content($shop_theme_info, "home", "home_company_address") !!}</span></div>
                    <div class="title-container">Email Address:</div>
                    <div class="contact-info"><i class="fa fa-envelope" aria-hidden="true"></i><span>{!! get_content($shop_theme_info, "home", "home_company_email-address") !!}</span></div>
                    <div class="title-container">Contact Number:</div>
                    <div class="contact-info"><i class="fa fa-phone" aria-hidden="true"></i><span>{!! get_content($shop_theme_info, "home", "home_company_contact-number") !!}</span></div>
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

@endsection