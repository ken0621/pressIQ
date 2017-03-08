<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ ucfirst($shop_info->shop_key) }} | {{ $page }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap.min.css">
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap-theme.min.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/font-awesome/css/font-awesome.min.css">
        <!-- SLICK CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick-theme.css">
        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
        <!-- THEME COLOR -->
        <link href="/themes/{{ $shop_theme }}/css/{{ $shop_theme_color }}.css" rel="stylesheet" type="text/css">
        <!-- OTHER CSS -->
        @yield("css")

        <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>

        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- HEADER -->
    <div class="header-nav">
    	<div class="header-nav-top">
    		<div class="container">
                <div class="holder"><a href="/mlm/login"><i class="fa fa-lock" aria-hidden="true"></i> Login</a></div>
                <div class="holder"><div class="linya"></div></div>
                <div class="holder"><a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Cart</a></div>
                <div class="holder"><div class="linya"></div></div>
    			<div class="holder"><a href="/checkout"><i class="fa fa-check" aria-hidden="true"></i> Checkout</a></div>
	    		<div class="holder"><div class="linya"></div></div>
	    		<div class="holder"><a href="/about">About Us</a></div>
	    		<div class="holder"><div class="linya"></div></div>
	    		<div class="holder"><a href="/contact">Contact Us</a></div>
    		</div>
    	</div>
    	<div class="header-nav-middle">
    		<div class="container">
    			<div class="row clearfix">
	    			<div class="col-md-3">
                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/philtech-official-logo.png">            
                    </div>
	    			<div class="col-md-6">
	    				<div class="search-bar">
	    					<div class="input-group input-group-lg">
							  <!-- <span class="input-group-addon search-category" id="sizing-addon1">Categories <span class="caret"></span></span> -->
							  <input type="text" class="form-control search-input" aria-describedby="sizing-addon1">
							  <span class="input-group-addon search-button" id="sizing-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
							</div>
	    				</div>
	    			</div>
	    			<div class="col-md-3 woaw">
	    				<div class="shopping-cart-container">
	    					<div class="shopping-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge">1</span> <span>CART PHP. 000.00</span></div>
	    				    <div class="container-cart">
                                <table>
                                    <tbody>
                                        <!-- <tr>
                                            <td class="img"><img src="/themes/{{ $shop_theme }}/img/item-1.jpg"></td>
                                            <td class="info">
                                                <div class="name">Item Name 1</div>
                                                <div class="quantity">x2</div>
                                                <div class="price">P 600.00</div>
                                            </td>
                                            <td class="remove">
                                                <a href="javascript:"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="img"><img src="/themes/{{ $shop_theme }}/img/item-1.jpg"></td>
                                            <td class="info">
                                                <div class="name">Item Name 1</div>
                                                <div class="quantity">x2</div>
                                                <div class="price">P 600.00</div>
                                            </td>
                                            <td class="remove">
                                                <a href="javascript:"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="img"><img src="/themes/{{ $shop_theme }}/img/item-1.jpg"></td>
                                            <td class="info">
                                                <div class="name">Item Name 1</div>
                                                <div class="quantity">x2</div>
                                                <div class="price">P 600.00</div>
                                            </td>
                                            <td class="remove">
                                                <a href="javascript:"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="img"><img src="/themes/{{ $shop_theme }}/img/item-1.jpg"></td>
                                            <td class="info">
                                                <div class="name">Item Name 1</div>
                                                <div class="quantity">x2</div>
                                                <div class="price">P 600.00</div>
                                            </td>
                                            <td class="remove">
                                                <a href="javascript:"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr> -->
                                        <tr style="border: 0;">
                                            <td class="sub-title">Subtotal:</td>
                                            <td class="sub-price">P 00.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="2"><button class="btn btn-checkout" type="button" onClick="location.href='/checkout'">Checkout</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
	    			</div>
	    		</div>
    		</div>
    	</div>
        <div class="container">
            <marquee style="color: #fff; font-size: 18px;">Empowering consumers to experience the VIP Life... Convenience. Benefits. Rewards. Unlimited Income.</marquee>
        </div>
    </div>
    <!-- NAVIGATION -->
    <nav class="navbar navbar-default">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="nav-border {{ Request::segment(1) == '' ? 'active' : '' }}"><a href="/">HOME <span class="sr-only">(current)</span></a></li>
	        @if(isset($_categories))
                @foreach($_categories as $category)     
                <li class="nav-border {{ Request::input('type') == $category['type_id'] ? 'active' : '' }}"><a href="/product?type={{ $category['type_id'] }}" style="text-transform: uppercase;">{{ $category['type_name'] }}</a></li>
    	        @endforeach
            @endif
          </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	@yield("content")
   
    <!-- FOOTER -->
  	<footer>
   	    <div class="container ftr">
            <div class="row clearfix">
                <div class="col-md-4 col-sm-6">
                    <div class="btm-title">SHOP</div>
                    <div class="row clearfix btm-link">
                        @if(isset($_categories))
                            @foreach($_categories as $category)     
                            <div class="btm-sub-title col-xs-6"><a href="/product?type={{ $category['type_id'] }}">{{ $category['type_name'] }}</a></div>
                            @endforeach
                        @endif
                    </div>
                </div> 
                <div class="col-md-3 col-sm-6">
                    <div class="btm-title">CONTACT US</div>
                    <table style="table-layout: fixed; width: 100%;">
                        <tr>
                            <td style="width: 35px;"><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                            <td class="contact-title">{{ isset($company_info['company_address']) ? $company_info['company_address']->value : '' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 35px;"><i class="fa fa-mobile" aria-hidden="true"></i></td>
                            <td class="contact-title">{{ isset($company_info['company_mobile']) ? $company_info['company_mobile']->value : '' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 35px;"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                            <td class="contact-title">{{ isset($company_info['company_email']) ? $company_info['company_email']->value : '' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btm-title">COMPANY</div>
                    <div class="btm-sub-title">{{ substr(get_content($shop_theme_info, "about", "about_content"), 0, 200) }}... &nbsp;<a style="color: #fff;" href="/about">See More</a></div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="btm-title">FOLLOW US ON</div>
                    <div>
                        <a href="#"><i class="fa fa-facebook site-icon" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-twitter site-icon" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-pinterest-p site-icon" aria-hidden="true"></i></i></a>
                    </div>
                </div>
            </div>
        </div>
 	</footer>

    <footer id="bottom-footer">
        <div class="container bottom">
            <div class="row clearfix">
                <div class="col-md-12">                            
                    <div class="ftr-title">© {{ isset($company_info['company_name']) ? $company_info['company_name']->value : 'Your Name' }} {{ date('Y') }}</div>
                    <div class="image-logo">
                    <img src="/themes/{{ $shop_theme }}/img/ftr-image1.jpg">
                    <img src="/themes/{{ $shop_theme }}/img/ftr-image2.jpg">
                    <img src="/themes/{{ $shop_theme }}/img/ftr-image3.jpg">
                    <img src="/themes/{{ $shop_theme }}/img/ftr-image4.jpg">
                    <img src="/themes/{{ $shop_theme }}/img/ftr-image5.jpg">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/global.js"></script>
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    @yield("js")
    </body>
</html>
