@extends("layout")
@section("content")
<div class="content">{{-- {{ get_content($shop_theme_info, "home", "home_banner") }} --}}
    <!-- Media Slider -->
    <section class="slider-wrapper">
        <div class="top-banner" style="background-image: url('/themes/paptsi-v2/img/home-banner.jpg');">
            <div class="container">
                <div class="c-container">
                    <div class="top-info">
                        <span>We Aim For The Best</span><span> Services</span>
                    </div>
                    <div class="mid-info">
                        In the Industry of Ports and Terminal Services
                    </div>
                    <div class="bottom-info">
                        {!! get_content($shop_theme_info, "home", "home_banner_description") !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="wrapper-1">
        <div class="container">
            <div class="service-container services-carousel">
                <div class="holder match-height">
                    <div image-holder>
                        <img src="/themes/paptsi-v2/img/wrapper-image-1.png">
                    </div>
                    {{-- <div class="title">
                        Services 1
                    </div> --}}
                    <div class="details">
                        Operation and management of passenger terminal building
                    </div>
                </div>
                <div class="holder match-height">
                    <div image-holder>
                        <img src="/themes/paptsi-v2/img/wrapper-image-2.png">
                    </div>
                    {{-- <div class="title">
                        Services 1
                    </div> --}}
                    <div class="details">
                        Cargo Handling operation
                    </div>
                </div>
                <div class="holder match-height">
                    <div image-holder>
                        <img src="/themes/paptsi-v2/img/wrapper-image-3.png">
                    </div>
                    {{-- <div class="title">
                        Services 1
                    </div> --}}
                    <div class="details">
                        Management and operation of other port facilities such as but not limited to arrastre, stevedoring and weighbridge
                    </div>
                </div>
                <div class="holder match-height">
                    <div image-holder>
                        <img src="/themes/paptsi-v2/img/wrapper-image-4.png">
                    </div>
                    {{-- <div class="title">
                        Services 1
                    </div> --}}
                    <div class="details">
                        Rentals of concessionaires
                    </div>
                </div>
                <div class="holder match-height">
                    <div image-holder>
                        <img src="/themes/paptsi-v2/img/wrapper-image-5.png">
                    </div>
                    {{-- <div class="title">
                        Services 1
                    </div> --}}
                    <div class="details">
                        Leasing out of office spaces
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="aboutus" class="wrapper-2">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="left-container">
                        <div class="title-container"><span class="border">|</span><span class="title"> OUR COMPANY</span></div>
                        <div class="description-container">
                            {!! get_content($shop_theme_info, "home", "home_company_description") !!}
                        </div>
                         {{-- <div class="button-container">
                            <a href="#Read More">READ MORE</a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-container">
                        <div class="image-holder">
                            <img src="{{ get_content($shop_theme_info, "home", "home_company_image") }}">
                        </div>
                        <div class="description-container">
                            {!! get_content($shop_theme_info, "home", "home_company_description_2") !!}
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
                            <div class="title-container"><span class="border">|</span><span class="title"> NEWS AND ANNOUNCEMENT</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-container">
                <div class="news-carousel">
                    @if(count(get_front_news($shop_id)) > 0)
                        @foreach(limit_foreach(get_front_news($shop_id), 8) as $news)
                            <div class="holder-container">
                                <a href="/news?id={{ $news->post_id }}" style="text-decoration: none;">
                                    <div class="image-holder">
                                        <img src="{{ $news->post_image }}">
                                    </div>
                                    <div class="title-container">{{ $news->post_title }}</div>
                                    <div class="description-container match-height">{{ $news->post_excerpt }}</div>
                                    <div class="read-container">
                                        <a href="/news?id={{ $news->post_id }}">Read More</a>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <span class="coming-soon">News and Announcements are coming soon!</span>
                    @endif   
                </div>
                    {{-- <div class="holder-container">
                        <div class="image-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wrapper3-image1.jpg">
                        </div>
                        <div class="title-container">LOREM IPSUM DOLOR</div>
                        <div class="description-container match-height">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
                        <div class="read-container">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="holder-container">
                        <div class="image-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wrapper3-image2.jpg">
                        </div>
                        <div class="title-container">LOREM IPSUM DOLOR</div>
                        <div class="description-container match-height">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
                        <div class="read-container">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="holder-container">
                        <div class="image-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wrapper3-image3.jpg">
                        </div>
                        <div class="title-container">LOREM IPSUM DOLOR</div>
                        <div class="description-container match-height">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
                        <div class="read-container">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="holder-container">
                        <div class="image-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wrapper3-image4.jpg">
                        </div>
                        <div class="title-container">LOREM IPSUM DOLOR</div>
                        <div class="description-container match-height">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
                        <div class="read-container">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="holder-container">
                        <div class="image-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wrapper3-image3.jpg">
                        </div>
                        <div class="title-container">LOREM IPSUM DOLOR</div>
                        <div class="description-container match-height">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
                        <div class="read-container">
                            <a href="#">Read More</a>
                        </div>
                    </div> --}}
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
                    <div class="contact-info"><i class="fa fa-map-marker" aria-hidden="true"></i><span>{!! get_content($shop_theme_info, "contact_details", "contact_company_address") !!}</span></div>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css?version=1.3">
@endsection

@section("script")

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js?version=1"></script>

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