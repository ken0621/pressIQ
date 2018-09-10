@extends("layout")
@section("content")
<div class="content">

	<div class="swiper-container swiper1" id="home">
		<div class="swiper-wrapper">
			@if(loop_content_condition($shop_theme_info, "home", "home_gallery"))
				@foreach(loop_content_get($shop_theme_info, "home", "home_gallery") as $slider)
					<div class="swiper-slide">
						<div class="image-holder">
							<img src="{{ $slider }}">
						</div>
					</div>
				@endforeach
			@else
				<div class="swiper-slide">
					<div class="image-holder">
						<img src="/themes/shell-canvas/img/shell-canvas-banner.jpg">
					</div>
				</div>
				<div class="swiper-slide">
					<div class="image-holder">
						<img src="/themes/shell-canvas/img/shell-canvas-banner-1.jpg">
					</div>
				</div>
				<div class="swiper-slide">
					<div class="image-holder">
						<img src="/themes/shell-canvas/img/shell-canvas-banner-2.jpg">
					</div>
				</div>
			@endif
		</div>
		<div class="slider-next">
			<img src="/themes/shell-canvas/img/icon-right-arrow.png">
		</div>
    	<div class="slider-prev">
    		<img src="/themes/shell-canvas/img/icon-left-arrow.png">
    	</div>
	</div>

	<div class="swiper-container swiper2" id="product">
		<div class="swiper-wrapper">
				<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-1.jpg');">
					<div class="product-content">
						<div class="product-header">
							Home Furnishings
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-2.jpg');">
					<div class="product-content">
						<div class="product-header">
							Sofas
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-3.jpg');">
					<div class="product-content">
						<div class="product-header">
							Chairs
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-4.jpg');">
					<div class="product-content">
						<div class="product-header">
							Tables
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-9.jpg');">
					<div class="product-content">
						<div class="product-header">
							Beds
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-6.jpg');">
					<div class="product-content">
						<div class="product-header">
							Lumiere Lights
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-7.jpg');">
					<div class="product-content">
						<div class="product-header">
							Awning with Mechanisms
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-8.jpg');">
					<div class="product-content">
						<div class="product-header">
							Accessories
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-5.jpg');">
					<div class="product-content">
						<div class="product-header">
							Garden
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-10.jpg');">
					<div class="product-content">
						<div class="product-header">
							Antique Furnitures
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			<div class="swiper-slide">
				<div class="product-holder" style="background-image: url('/themes/shell-canvas/img/product-11.jpg');">
					<div class="product-content">
						<div class="product-header">
							Clearance
						</div>
						<div class="product-body">
							Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet,ocurreret pertinacia pri an. No mei nibh consectetuer
						</div>
						<button>SEE MORE</button>
					</div>
				</div>
			</div>
			</div>
		<div class="swiper-pagination swiper-pagination2"></div>
    </div>

	<div class="wrapper-1" id="about">
		<div class="container">
			<div class="title-holder">
				<div class="title-header">
					{!! get_content($shop_theme_info, "about", "about_title_header") !!}
				</div>
				<div class="title-subheader">
					{!! get_content($shop_theme_info, "about", "about_title_subheader") !!}
				</div>
			</div>
			<div class="about-content">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="about-paragraph">
							{!! get_content($shop_theme_info, "about", "about_content_paragraph") !!}
						</div>
						<div class="button-holder">
							<button>READ MORE</button>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="image-holder">
							<img src="{!! get_content($shop_theme_info, "about", "about_content_image_1") !!}">
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<div class="image-container">
							<div class="image-holder-1">
								<img src="{!! get_content($shop_theme_info, "about", "about_content_image_2") !!}">
							</div>
							<div class="image-holder-2">
								<img src="{!! get_content($shop_theme_info, "about", "about_content_image_3") !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="wrapper-2 not-fullscreen background parallax" style="background-image: url('/themes/shell-canvas/img/bg-blur.jpg');" data-img-width="1600" data-img-height="835" data-diff="100">
		<div class="container">
			<div class="title-header">
				{!! get_content($shop_theme_info, "about", "about_features_title_header") !!}
			</div>
			<div class="features-content-1">
				<div class="row">
					<div class="col-md-1 col-sm-1 col-xs-4">
						<div class="icon-holder">
							<img src="/themes/shell-canvas/img/icon-1.png">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<div class="content-container">
							<div class="content-header">
								{!! get_content($shop_theme_info, "about", "about_features_header_1") !!}
							</div>
							<div class="content-body">
								{!! get_content($shop_theme_info, "about", "about_features_body_1") !!}
							</div>
						</div>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-4">
						<div class="icon-holder">
							<img src="/themes/shell-canvas/img/icon-2.png">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<div class="content-container">
							<div class="content-header">
								{!! get_content($shop_theme_info, "about", "about_features_header_2") !!}
							</div>
							<div class="content-body">
								{!! get_content($shop_theme_info, "about", "about_features_body_2") !!}
							</div>
						</div>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-4">
						<div class="icon-holder">
							<img src="/themes/shell-canvas/img/icon-3.png">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<div class="content-container">
							<div class="content-header">
								{!! get_content($shop_theme_info, "about", "about_features_header_3") !!}
							</div>
							<div class="content-body">
								{!! get_content($shop_theme_info, "about", "about_features_body_3") !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="features-content-2">
				<div class="row">
					<div class="col-md-1 col-sm-1 col-xs-4">
						<div class="icon-holder">
							<img src="/themes/shell-canvas/img/icon-4.png">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<div class="content-container">
							<div class="content-header">
								{!! get_content($shop_theme_info, "about", "about_features_header_4") !!}
							</div>
							<div class="content-body">
								{!! get_content($shop_theme_info, "about", "about_features_body_4") !!}
							</div>
						</div>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-4">
						<div class="icon-holder">
							<img src="/themes/shell-canvas/img/icon-5.png">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<div class="content-container">
							<div class="content-header">
								{!! get_content($shop_theme_info, "about", "about_features_header_5") !!}
							</div>
							<div class="content-body">
								{!! get_content($shop_theme_info, "about", "about_features_body_5") !!}
							</div>
						</div>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-4">
						<div class="icon-holder">
							<img src="/themes/shell-canvas/img/icon-6.png">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<div class="content-container">
							<div class="content-header">
								{!! get_content($shop_theme_info, "about", "about_features_header_6") !!}
							</div>
							<div class="content-body">
								{!! get_content($shop_theme_info, "about", "about_features_body_6") !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="wrapper-3" id="gallery">
		<div class="container">
			<div class="title-holder">
				<div class="title-header">
					{!! get_content($shop_theme_info, "gallery", "gallery_title_header") !!}
				</div>
				<div class="title-subheader">
					{!! get_content($shop_theme_info, "gallery", "gallery_title_subheader") !!}
				</div>
			</div>
			<div class="swiper-container swiper3">
			    <div class="swiper-wrapper">
					<a href="/themes/shell-canvas/img/shell-canvas-1.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-1.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-2.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-2.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-3.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-3.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-4.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-4.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-5.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-5.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-6.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-6.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-7.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-7.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-8.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-8.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-9.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-9.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-10.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-10.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-11.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-11.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-12.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-12.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-13.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-13.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-14.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-14.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-15.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-15.jpg" alt="">
						</div>
					</a>
					<a href="/themes/shell-canvas/img/shell-canvas-16.jpg" class="swiper-slide" data-fancybox="images">
						<div class="image-holder">
							<img src="/themes/shell-canvas/img/shell-canvas-16.jpg" alt="">
						</div>
					</a>
			    </div>
			    <div class="swiper-pagination swiper-pagination3"></div>
			</div>
		</div>
	</div>

	<div id="contact" class="wrapper-4">
	    <div class="container">
	    	<div class="title-holder-1">
	    		<div class="title-header">
	    			{!! get_content($shop_theme_info, "contact", "contact_title_header") !!}
	    		</div>
	    		<div class="title-subheader">
	    			{!! get_content($shop_theme_info, "contact", "contact_title_subheader") !!}
	    		</div>
	    	</div>
	    	<div class="map-container">
	    		<iframe class="shellcanvas-map" src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d15447.103061996984!2d120.9979633916792!3d14.554811672121508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s+1999+Sen.+Gil+Puyat+Avenue%2C+(Buendia+Avenue)Pasay+City%2C+Philippines+1300!5e0!3m2!1sen!2sph!4v1536118919269" width="1200" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
	    	</div>
	        <div class="row clearfix">
	        	<div class="col-md-6 col-sm-6 col-xs-12">
	        		<div class="title-holder-2">
	    				<div class="content-header">
	    					CONTACT INFO
	    				</div>
	    				<div class="border-holder"></div>
			    	</div>
	                <div class="info-container">
	                    <div class="info-title">
	                    	<strong>Main Branch: {!! get_content($shop_theme_info, "contact", "contact_shellcanvas_mainbranch") !!}</strong>
	                    </div>
	                    <div class="content-container">
	                    	<div class="row">
	                    		<div class="col-md-1 col-sm-1 col-xs-1">
	                    			<div class="content-body-1">
	                    				<i class="fas fa-map-marker-alt"></i>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-4 col-sm-4 col-xs-4">
	                    			<div class="content-body-2">
	                    				<strong>Main Address</strong>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-7 col-sm-7 col-xs-7">
	                    			<div class="content-body-3">
	                    				{!! get_content($shop_theme_info, "contact", "contact_shellcanvas_address") !!}
	                    			</div>
	                    		</div>
	                    	</div>
	                    	<div class="row">
	                    		<div class="col-md-1 col-sm-1 col-xs-1">
	                    			<div class="content-body-1">
	                    				<i class="fas fa-mobile-alt"></i>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-4 col-sm-4 col-xs-4">
	                    			<div class="content-body-2">
	                    				<strong>Mobile Number</strong>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-7 col-sm-7 col-xs-7">
	                    			<div class="content-body-3">
	                    				{!! get_content($shop_theme_info, "contact", "contact_shellcanvas_mobile") !!}
	                    			</div>
	                    		</div>
	                    	</div>
	                    	<div class="row">
	                    		<div class="col-md-1 col-sm-1 col-xs-1">
	                    			<div class="content-body-1">
	                    				<i class="far fa-clock"></i>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-4 col-sm-4 col-xs-4">
	                    			<div class="content-body-2">
	                    				<strong>Store Office Hours</strong>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-7 col-sm-7 col-xs-7">
	                    			<div class="content-body-3">
	                    				{!! get_content($shop_theme_info, "contact", "contact_shellcanvas_storeoffice") !!}
	                    			</div>
	                    		</div>
	                    	</div>
	                    	<div class="row">
	                    		<div class="col-md-1 col-sm-1 col-xs-1">
	                    			<div class="content-body-1">
	                    				{{-- <i class="far fa-clock"></i> --}}&nbsp;&nbsp;
	                    			</div>
	                    		</div>
	                    		<div class="col-md-4 col-sm-4 col-xs-4">
	                    			<div class="content-body-2">
	                    				<strong>Mall Office Hours</strong>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-7 col-sm-7 col-xs-7">
	                    			<div class="content-body-3">
	                    				{!! get_content($shop_theme_info, "contact", "contact_shellcanvas_malloffice") !!}
	                    			</div>
	                    		</div>
	                    	</div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	            	<div class="title-holder-2">
	    				<div class="content-header">
	    					LEAVE A MESSAGE
	    				</div>
	    				<div class="border-holder"></div>
			    	</div>
	            	<form method="Post">
	                 	<div class="row clearfix">
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <div class="form-group">
	                                <input type="text" class="form-control" placeholder="Firstname*" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <div class="form-group">
	                                <input type="text" class="form-control" placeholder="Lastname*" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <div class="form-group">
	                                    <input type="phone" class="form-control"  placeholder="Contact Number*" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <div class="form-group">
	                                <input type="email" class="form-control" placeholder="Email*" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <div class="form-group">
	                                <input type="text area" class="form-control"  placeholder="Subject*" required> 
	                            </div>
	                        </div>
	                        <div class="col-md-12 col-sm-12 col-xs-12">
	                            <div class="form-group">
	                                <textarea type="text" class="form-control text-message" placeholder="Message*" required></textarea>
	                            </div>
	                        </div>
	                        <div class="col-md-12 col-sm-12 col-xs-12">
	                            <div class="btn-holder">
	                                <button class="btn-send" type="submit">SEND</button>
	                            </div>
	                        </div>
	                	</div>
	            	</form>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="wrapper-5" id="morecontact">
		<div class="container">
			<div class="title-holder">
				<div class="title-header">
					MORE INFO
				</div>
				<div class="border-holder"></div>
			</div>
			<div class="info-container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="content-header">
							<strong>
								OTHER CONTACTS
							</strong>
						</div>
						<div class="contact-container">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									{!! get_content($shop_theme_info, "contact", "contact_shellcanvas_othercontact") !!}
									{{-- <div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-1">
												<strong>SM North Edsa Branch:</strong>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-1">
												(632) 782-0588
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-2">
												<strong>Glorietta Branch:</strong>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-2">
												(632) 845-0129
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-3">
												<strong>Libis Ortigas Branch:</strong>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-3">
												(632) 911-7162
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-4">
												<strong>SM Southmall Branch:</strong>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-4">
												(632) 703-7456
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-5">
												<strong>Shangrila Branch:</strong>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<div class="other-contact-5">
												(632) 910-3228
											</div>
										</div>
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="content-header">
							<strong>
								OUR BRANCHES
							</strong>
						</div>
						<div class="branch-container">
							{!! get_content($shop_theme_info, "contact", "contact_shellcanvas_otherbranch") !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="more-info-holder">
    	<button class="btn-more" type="button">SHOW MORE<br>
    		<i class="fas fa-angle-down"></i>
    	</button>
    	<button class="btn-less" type="button">SHOW LESS<br>
    		<i class="fas fa-angle-up"></i>
    	</button>
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
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home-swiper.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/product-swiper.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/gallery-swiper.js"></script>
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
	$('.btn-more').click(function() {
	    $('#morecontact').slideDown(1000);
	    $('.btn-more').hide(0);
	    $('.btn-less').show(0);
	});

$('.btn-less').click(function() {
	    $('#morecontact').slideUp(1000);
	    $('.btn-more').show(0);
	    $('.btn-less').hide(0);
	});
</script>

@endsection


