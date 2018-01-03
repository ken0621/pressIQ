@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
<div class="main-wrapper">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-8">
                <div class="title-container">Get In Touch With Us</div>
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
                            <a href="#Read More">SEND</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="background-border">
            		<div class="background-container">
		        		<div class="title-info-container">Email Address</div>
		        		<div class="contact-info"><i class="fa fa-envelope" aria-hidden="true"></i><span>pressiq@gmail.com</span></div>
		        		<div class="title-info-container">Contact Number</div>
		        		<div class="contact-info"><i class="fa fa-phone" aria-hidden="true"></i><span>+4736 - 9806 - 890</span></div>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/contact.css">
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