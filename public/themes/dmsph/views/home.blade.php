@extends("layout")
@section("content")
<div class="content">

	<section class="wrapper-1" id="home" style="background-image: url('{!! get_content($shop_theme_info, "home", "home_dms_banner") !!}')" data-img-width="1600" data-img-height="835" data-diff="100">
		<div class="title-container">
			<p class="anim-typewriter">
				Welcome to the <span>Digital Marketing Solutions</span>
			</p>
		</div>
		<div class="home-container">
			<div class="home-content">
				<div class="row">
					<div class="col-md-8 col-sm-6 col-xs-12">
						<div class="home-content-1">
							<div class="title-1">
								GROW YOUR BUSINESS WITH US!
							</div>
							<div class="title-2">
								We Offer Excellent Systems in Improving Your Business.
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6">
						<div class="home-content-2">
							<div class="title-1">
								We are QuickBooks
							</div>
							<div class="title-2">
								Certified <i class="far fa-check-square"></i>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6">
						<div class="home-content-3">
							<div class="image-holder">
								<img src="/themes/{{ $shop_theme }}/img/QB-Badges.png">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-2" id="about">
		<div class="container">
			<div class="about-container-company">
				<div class="title-holder">
					<div class="header-title">
					“Choose the provider who Cares. Choose DMS”
					</div>
					<div class="subheader-title">
						A company that serves as your whole package business integration 
						<br> from technology to marketing!
					</div>
				</div>
				<div class="about-company">
					<div class="about-company-1">
						<div class="company-overview">
							<div class="about-title">
								Who We Are
							</div>
							<div class="about-content">
								{!! get_content($shop_theme_info, "home", "home_dms_about_whoweare") !!}
							</div>
						</div>
						<div class="company-vision">
							<div class="about-title">
								Vision
							</div>
							<div class="about-content">
								{!! get_content($shop_theme_info, "home", "home_dms_about_vision") !!}
							</div>
						</div>
						<div class="company-mission">
							<div class="about-title">
								Mission
							</div>
							<div class="about-content">
								{!! get_content($shop_theme_info, "home", "home_dms_about_mission") !!}
							</div>
						</div>
					</div>
					<div class="about-company-2">
						<div class="image-holder">
							<img src="/themes/{{ $shop_theme }}/img/about-banner.jpg">
						</div>
						<div class="company-work">
							<div class="about-title">
								What We Do
							</div>
							<div class="about-content">
								{!! get_content($shop_theme_info, "home", "home_dms_about_whatwedo") !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-3">
		<div class="container">
			<div class="about-container-values">
				<div class="about-title">
					VALUES & CULTURE
				</div>
				<div class="about-values-container">
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-1.png">
						</div>
						<div class="values-name">
							Consistency
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-2.png">
						</div>
						<div class="values-name">
							Focus
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-3.png">
						</div>
						<div class="values-name">
							Preparedness
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-4.png">
						</div>
						<div class="values-name">
							Prompt and Attentive
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-5.png">
						</div>
						<div class="values-name">
							Professionalism
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-6.png">
						</div>
						<div class="values-name">
							Nurture Relationship
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-4" id="product">
		<div class="container">
			<div class="product-container">
				<div class="product-title">
					QUICKBOOKS PRODUCTS
				</div>
				 <div class="product-tabs" id="myTabs">
					<a data-toggle="tab" href="#product1" class="product-btn active">QuickBooks Enterprise</a>
					<a data-toggle="tab" href="#product2" class="product-btn">QuickBooks Premier</a>
					<a data-toggle="tab" href="#product3" class="product-btn">QuickBooks Pro</a>
				 </div>
				 <div class="tab-content">
				    <div id="product1" class="tab-pane fade in active">
					    <div class="product-desc-container">
					    	<div class="product-desc-container-1">
					    		<div class="product-header">Product Description</div>
					    		{!! get_content($shop_theme_info, "home", "home_dms_productdesc_enterprise") !!}
						    </div>
						    <div class="product-desc-container-2">
						    	<table class="product-table">
						    		<tr>
						    			<th>QuickBooks Enterprise 2019</th>
						    			<th>Silver</th>
						    			<th>Platinum</th>
						    		</tr>
						    		<tr>
						    			<td>QuickBooks Desktop Enterprise Software</td>
						    			<td class="text-center">x</td>
						    			<td class="text-center">x</td>
						    		</tr>
						    		<tr>
						    			<td>DMSPH QuickBooks Enterprise Priority Response Program</td>
						    			<td class="text-center">x</td>
						    			<td class="text-center">x</td>
						    		</tr>
						    		<tr>
						    			<td>Automatic QuickBooks Product Upgrades</td>
						    			<td class="text-center">x</td>
						    			<td class="text-center">x</td>
						    		</tr>
						    		<tr>
						    			<td>Anytime, Anywhere, Any Device</td>
						    			<td class="text-center"></td>
						    			<td class="text-center"></td>
						    		</tr>
						    		<tr>
						    			<td>Advanced Reporting</td>
						    			<td class="text-center">x</td>
						    			<td class="text-center">x</td>
						    		</tr>
						    		<tr>
						    			<td>Advanced Inventory</td>
						    			<td class="text-center"></td>
						    			<td class="text-center">x</td>
						    		</tr>
						    		<tr>
						    			<td>Advanced Pricing</td>
						    			<td class="text-center"></td>
						    			<td class="text-center">x</td>
						    		</tr>
						    	</table>
						    </div>
					    </div>
					    <div class="button-container">
					    	<a class="btn-feature" role="button" href='/product'>SEE FULL FEATURES</a>
					    	<button type="button" class="btn-inquire" data-toggle="modal" data-target="#myModal">INQUIRE NOW</button>
					    </div>
				    </div>
				    <div id="product2" class="tab-pane fade">
					    <div class="product-desc-container">
					    	<div class="product-desc-container-1">
					    		<div class="product-header">Product Description</div>
					    		{!! get_content($shop_theme_info, "home", "home_dms_productdesc_premier") !!}
						    </div>
					    </div>
					    <div class="button-container">
					    	<a class="btn-feature" role="button" href='/product_1'>SEE FULL FEATURES</a>
					    	<button type="button" class="btn-inquire" data-toggle="modal" data-target="#myModal">INQUIRE NOW</button>
					    </div>
				    </div>
				    <div id="product3" class="tab-pane fade">
					    <div class="product-desc-container">
					    	<div class="product-desc-container-1">
					    		<div class="product-header">Product Description</div>
					    		{!! get_content($shop_theme_info, "home", "home_dms_productdesc_pro") !!}
						    </div>
					    </div>
					    <div class="button-container">
					    	<a class="btn-feature" role="button" href='/product_2'>SEE FULL FEATURES</a>
					    	<button type="button" class="btn-inquire" data-toggle="modal" data-target="#myModal">INQUIRE NOW</button>
					    </div>
				    </div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-5" id="services">
		<div class="container">
			<div class="service-container">
				<div class="service-title">
					QUICKBOOKS SERVICES
				</div>
				<div class="service-holder">
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-1.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Training & Implementation
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-2.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Migration
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-3.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Auditing
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-4.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Support and Onsite Visit
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-5.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Forms Customization
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-6.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Reports Customization
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-7.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Special Reports and Special Forms Customization thru Crystal Report
							</div>
						</div>
					</div>
					<div class="service-content">
						<img src="/themes/{{ $shop_theme }}/img/img-8.jpg">
						<div class="title-holder">
							<div class="title-1">
							QuickBooks
							</div>
							<div class="title-2">
								Anywhere Access Setup
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-6" id="expertise">
		<div class="container">
			<div class="expertise-container">
				<div class="expertise-title">
					OUR EXPERTISE
				</div>
				<div class="expertise-holder">
					<div class="expertise-header">
						List of our Expertise
					</div>
					<div class="expertise-show" id="morecontent">
						<div class="expertise-list-container">
							<div class="expertise-list">
								{!! get_content($shop_theme_info, "home", "home_dms_expertise_1") !!}
							</div>
							<div class="expertise-list">
								{!! get_content($shop_theme_info, "home", "home_dms_expertise_2") !!}
							</div>
						</div>
					</div>
					<div class="expertise-hide" id="hidecontent">
						<div class="expertise-list-container">
							<div class="expertise-list">
								{!! get_content($shop_theme_info, "home", "home_dms_expertise_3") !!}
							</div>
							<div class="expertise-list">
								{!! get_content($shop_theme_info, "home", "home_dms_expertise_4") !!}
							</div>
						</div>
					</div>
					<div class="button-holder">
						<button class="btn-more">SEE MORE</button>
						<button class="btn-less">SEE LESS</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-7" id="partnership">
		<div class="container">
			<div class="partner-container">
				<div class="partner-title">
					OUR RELATIONSHIPS
				</div>
				<div class="swiper-container swiper">
					<div class="swiper-wrapper">
						@if(loop_content_condition($shop_theme_info, "home", "home_dms_relationship"))
							@foreach(loop_content_get($shop_theme_info, "home", "home_dms_relationship") as $slider)
								<div class="swiper-slide">
									<img src="{{ $slider }}">
								</div>
							@endforeach
						@else
						{{-- <a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-1.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-2.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-3.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-4.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-5.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-6.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-7.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-8.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-9.png">
						</a>
						<a href="_blank" class="swiper-slide">
							<img src="/themes/{{ $shop_theme }}/img/logo-10.png">
						</a> --}}
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-8" id="contact">
		<div class="container">
			<div class="contact-container">
				<div class="contact-title">
					CONNECT WITH US
				</div>
				<div class="map-container">
					<iframe class="map-dms" src="{!! get_content($shop_theme_info, "home", "home_dms_contact_map") !!}" width="1200" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<div class="contact-content">
					<div class="contact-content-1">
						<div class="content-title">
							KEEP IN TOUCH
						</div>
						<div class="content-body">
							<form action="Post"> 
								{{-- @if (session('message_concern_shell'))
								   <div class="alert alert-success">
								       {{ session('message_concern_shell') }}
								   </div>
								@endif --}}
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
								       	<div class="btn-holder">
								        	<button class="btn-send" type="submit" formaction="/contact_us/shell/send">SEND</button>
								       	</div>
								   	</div>
								</div>
							</form>
						</div>
					</div>

					<div class="contact-content-2">
						<div class="content-title">
							CONTACT INFORMATION
						</div>
						<div class="contact-info-holder">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/contact-1.png">
							</div>
							<div class="info-holder">
								{!! get_content($shop_theme_info, "home", "home_dms_contact_businesshour") !!}
							</div>
						</div>
						<div class="contact-info-holder">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/contact-2.png">
							</div>
							<div class="info-holder">
								{!! get_content($shop_theme_info, "home", "home_dms_contact_email") !!}
							</div>
						</div>
						<div class="contact-info-holder">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/contact-3.png">
							</div>
							<div class="info-holder">
								{!! get_content($shop_theme_info, "home", "home_dms_contact_landline") !!}
							</div>
						</div>
						<div class="contact-info-holder">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/contact-4.png">
							</div>
							<div class="info-holder">
								{!! get_content($shop_theme_info, "home", "home_dms_contact_phonenumber") !!}
							</div>
						</div>
						<div class="contact-info-holder">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/contact-5.png">
							</div>
							<div class="info-holder">
								{!! get_content($shop_theme_info, "home", "home_dms_contact_address") !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="title-header">
						<div class="title-content">
							INQUIRE NOW!
						</div>
						<div class="close-container">
							<button type="button" class="btn-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="title-header">
						Send us a Message
					</div>
					<form action="Post"> 
						{{-- @if (session('message_concern_shell'))
						   <div class="alert alert-success">
						       {{ session('message_concern_shell') }}
						   </div>
						@endif --}}
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
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<div class="btn-holder">
			        	<button class="btn-send" type="submit" formaction="">SEND</button>
			       	</div>
				</div>
			</div>
		</div>
	</div>

	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css?version=1.2">

@endsection

@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/scroll_spy.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/jam-swiper.js"></script>
{{-- <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script> --}}
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.single-item').slick({
			prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left.png'>",
	      	nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right.png'>",
	      	dots: false,
	      	autoplay: true,
	  		autoplaySpeed: 3000,
		});

		function event_slick()
		{
			$('.prod-image-thumb-container').slick({
				prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left1.png'>",
		      	nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right1.png'>",
				infinite: false,
				slidesToShow: 4,
				slidesToScroll: 1,
				arrows: false
			});
		}

	    lightbox.option({
	      'disableScrolling': true,
	      'wrapAround': true
	    });
	});
</script>
<script>
	var btnContainer = document.getElementById("myTabs");
	var btns = btnContainer.getElementsByClassName("product-btn");
	for (var i = 0; i < btns.length; i++) {
  		btns[i].addEventListener("click", function() {
	    var current = document.getElementsByClassName("active");
	    current[0].className = current[0].className.replace(" active", "");
	    this.className += " active";
	  });
	}
</script>
<script>
	$('.btn-more').click(function() {
	    $('#morecontent, #hidecontent').slideDown(1000);
	    $('.btn-more').hide(0);
	    $('.btn-less').show(0);
	});

	$('.btn-less').click(function() {
		    $('#morecontact, #hidecontent').slideUp(1000);
		    $('.btn-more').show(0);
		    $('.btn-less').hide(0);
		});
</script>

@endsection


