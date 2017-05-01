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
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,600|Source+Sans+Pro:400,600,700" rel="stylesheet"> 
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap.min.css">
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap-theme.min.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/font-awesome/css/font-awesome.min.css">
        <!-- SLICK CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick-theme.css">
        <!-- TOASTR CSS -->
        <link rel="stylesheet" type="text/css" href="/assets/member/plugin/toaster/toastr.css">
        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
        <link rel="stylesheet" type="text/css" href="/assets/front/css/loader.css">
        <!-- THEME COLOR -->
        <link href="/themes/{{ $shop_theme }}/css/{{ $shop_theme_color }}.css" rel="stylesheet" type="text/css">
        <!-- OTHER CSS -->
        @yield("css")
        <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
    <div class="loader">
      <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- HEADER -->
    <div class="header-nav">
    	<div class="header-nav-top">
    		<div class="container clearfix">
                <div class="pull-left">
                    <div class="nav-holder {{ Request::segment(1) == "" ? "active" : "" }}"><a href="/">HOME</a></div>
                    <div class="nav-holder">
                        <a class="show-product" href="javascript:">PRODUCTS</a>
                        <div class="product-container">
                            <div class="title">A Real Product Need</div>
                            <div class="list-product">
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="holder">
                                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-product-1.jpg">
                                        <div class="name">Barley Grass Capsule</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-holder {{ Request::segment(1) == "about" ? "active" : "" }}"><a href="/about">COMPANY</a></div>
                    <div class="nav-holder {{ Request::segment(1) == "contact" ? "active" : "" }}"><a href="/contact">CONTACT US</a></div>
                </div>      
                <div class="pull-right">
                    <div class="color-overlay"></div>
                    <div class="menu-container">
                        <div class="menu-holder dropdown mega-dropdown">
                            <a class="dropdown-toggle" href="javascript:"><img src="/themes/{{ $shop_theme }}/img/key.png"> LOGIN</a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <h2>Member Login</h2>
                                    <form method="post" action="/mlm/login" class="global-submit" autocomplete="on">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="user" placeholder="User Name">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="password" name="pass" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn" type="submit">Login <span class="caret"></span></button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="menu-holder dropdown mega-dropdown">
                            <a class="dropdown-toggle" href="javascript:"><img src="/themes/{{ $shop_theme }}/img/link.png"> JOIN US TODAY</a></a>
                            <ul class="dropdown-menu dropdown-menu-right orange">
                                <li>
                                    <h2>New to Sovereign World Corporation?</h2>
                                    <div class="title">JOIN US TODAY!</div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="first_name" placeholder="Your First Name">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="last_name" placeholder="Your Last Name">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="company" placeholder="Company (Optional)">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="email" name="email" placeholder="Your Email">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="customer_mobile" value="639">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="tinnumber" placeholder="Your TIN">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="username" placeholder="Your Username">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="pass" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="pass2" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="customer_street" placeholder="Street">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="customer_city" placeholder="City">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="customer_state" placeholder="Province">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="customer_zipcode" placeholder="Zip Code">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="username" placeholder="User Name">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control select_country" name="country" style="">
                                            @foreach($country as $value)
                                                <option value="{{$value->country_id}}" @if($value->country_id == 420) selected @endif >{{$value->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    	<div class="header-nav-middle">
    		<div class="container clearfix">
                <div class="pull-left">
                    <div class="logo">
                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/logo.jpg">
                    </div>
                </div>      
                <div class="pull-right">
                    <div class="info">
                        <div class="holder">
                            <div class="icon">
                                <img src="/themes/{{ $shop_theme }}/img/phone-icon.png">
                            </div>
                            <div class="text">
                                <div class="text-label">CALL US TODAY</div>
                                <div class="text-value">+852 9472 6184</div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="holder">
                            <div class="icon">
                                <img src="/themes/{{ $shop_theme }}/img/mail-icon.png">
                            </div>
                            <div class="text">
                                <div class="text-label">EMAIL US TODAY</div>
                                <div class="text-value">info@youremail.com</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>

    <div id="scroll-to" class="clearfix">
	   @yield("content")
    </div>

    <!-- FOOTER -->
  	<footer>
        <div class="container">
            <div class="col-md-4">
                <h2>INFORMATION</h2>
                <ul>
                    <li><a href="javascript:">HOME</a></li>
                    <li><a href="javascript:">PRODUCTS</a></li>
                    <li><a href="javascript:">MARKETING PLAN</a></li>
                    <li><a href="javascript:">ABOUT US</a></li>
                    <li><a href="javascript:">CONTACT US</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2>CONTACT US</h2>
                <ul>
                    <li>Tel No. (+852) 9472 6184 (+852) 9145 7698</li>
                    <li>EMAIL: youremailhere@company.com</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="text-center">FOLLOW US ON</h2>
                <div class="social-icon">
                    <div class="holder">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </div>
                    <div class="holder">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </div>
                    <div class="holder">
                        <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
 	</footer>
    <div class="sub-footer">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="nav">Terms & Condition</div>
                    <div class="nav">API Use Policy</div>
                    <div class="nav">Privacy Policy</div>
                    <div class="nav">Cookies</div>
                </div>
                <div class="col-md-6">
                    <div class="copyright">© 2015 - 2016 Sovereign World Corporation. All Rights Reserved</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="shopping_cart" class="modal fade global-modal shopping-cart-modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          
        </div>
      </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/global.js"></script>
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/assets/member/global.js"></script>
    <script type="text/javascript" src="/assets/member/plugin/toaster/toastr.min.js"></script>
    <script type="text/javascript">
    function submit_done(data)
    {
        console.log(data);
        if(data.type == 'error')
        {
            toastr.error(data.message);
        }
        else
        {
            toastr.success(data.message);
            location.href = '/mlm';
        }
    }
    </script>
    @yield("js")
    </body>
</html>
