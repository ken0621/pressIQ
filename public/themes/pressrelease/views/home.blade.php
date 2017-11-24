@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/home-banner.jpg')">
        <div class="container">
                <div class="caption-container">
                    <span class="title-caption-red">Smart</span><span class="title-caption-black"> and</span><span class="title-caption-blue"> cost effective</span><span class="title-caption-black"> press release distribution platform</span>
                </div>
                <div class="subtitle-container">Get noticed. Write your story today!</div>
                 <div class="button-container">
                    <a href="#Read More">REQUEST A DEMO</a>
                </div>
            <div class="scroll-down-container">
                <a class="smoth-scroll" href="#aboutus"><span class="animated fadeInDown"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>           
            </div>
        </div>
    </div>

    <div class="wrapper-1">
        <div class="container">
            <div class="title-container">Create great Press Releases</div>
            <div class="subtitle-container">Distribute your content to the right people in the right place.</div>
            <div class="border-container"></div>
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper1-image.png"></div>
                </div>
                <div class="col-md-6">
                    <div class="caption-container">
                        <span class="caption-black">Distribute your News using</span><span class="caption-red"> Intelligent</span><span class="caption-black"> and up to date database</span>
                    </div>
                    <div class="details-container">
                        <span class="details-red">Contacts of media journalist and editors</span><span class="details-black"> across all regions including Asia, North America, Europe and the Middle East</span>
                    </div>
                    <div class="details-container">
                        <span class="details-red">Easy to use</span><span class="details-black"> media release builder with ability to add rich media images or videos to you release</span>
                    </div>
                    <div class="details-container">
                        <span class="details-red">Real-time</span><span class="details-black"> reporting and measurable reults</span>
                    </div>
                    <div class="details-container">
                        <span class="details-red">Advanced segmentation</span><span class="details-black"> by Audience, media, demographic, and Category</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper-2" style="background-image: url('/themes/{{ $shop_theme }}/img/wrapper2-image.jpg')">
        <div class="container">
            <div class="title-container">
                <span class="title">Request a free demo of Press IQ!</span><span class="icon"><img src="/themes/{{ $shop_theme }}/img/wrapper-2-icon.png"></span>
            </div>
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Name: *</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Company: *</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Email: *</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Phone Number: *</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="title">Message: *</div>
                        <textarea type="text" class="form-control text-message"></textarea>
                    </div>
                </div>
                <div class="button-container">
                    <a href="#">SEND</a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper-3">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-3">
                    <div class="image-holder">
                        <img src="/themes/{{ $shop_theme }}/img/wrapper3-image1.png">
                    </div>    
                </div>
                 <div class="col-md-3">
                    <div class="image-holder">
                        <img src="/themes/{{ $shop_theme }}/img/wrapper3-image2.png">
                    </div>    
                </div>
                 <div class="col-md-3">
                    <div class="image-holder">
                        <img src="/themes/{{ $shop_theme }}/img/wrapper3-image3.png">
                    </div>    
                </div>
                 <div class="col-md-3">
                    <div class="image-holder">
                        <img src="/themes/{{ $shop_theme }}/img/wrapper3-image4.png">
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