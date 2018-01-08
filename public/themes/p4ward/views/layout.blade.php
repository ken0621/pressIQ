<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>{{ ucfirst($shop_info->shop_key) }} | {{ isset($page) ? $page : "" }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="apple-touch-icon" href="apple-touch-icon.png"> -->
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/header-logo.png" type="image/jpg" />
    
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Cantarell:400,700i" rel="stylesheet">

        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">

        @include("frontend.ghead")

        <!-- OTHER CSS -->
        @yield("css")
        <style type="text/css">
        .content
        {
            background-color: transparent;
        }
        .navbar.sticky
        {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }
        </style>
        <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
    <div class="loader hide">
      <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>

    <!-- HEADER -->
    <div id="home" class="subheader-container">
        <div class="container">
            @if($customer)
            <div class="left-container">
                <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <span>admin@p4ward.com</span>
                <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                <span>Call us 028995519</span>
            </div>
            <div class="right-container">
                <span><a href="/members">MY ACCOUNT</a></span>
                <span>|</i></span>
                <span><a href="/members/logout">LOGOUT</a></i></span>
            </div>
            @else
            <div class="left-container">
                <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <span>admin@p4ward.com</span>
                <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                <span>Call us 028995519</span>
            </div>
            <div class="right-container">
                <span><a href="/members/register">REGISTER</a></span>
                <span>|</i></span>
                <span><a href="/members/login">LOGIN</a></i></span>
            </div>
            @endif
        </div>
    </div>
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">

                    <div id="nav_list" style="display: none;"><i class="fa fa-bars hamburger" onclick="on()"></i></div>

                    <div class="image-logo-holder">
                        <a class="clearfix" href="/">
                            <img src="/themes/{{ $shop_theme }}/img/header-logo.png">
                        </a>                       
                    </div>
                    <div class="menu-nav">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="col-md-10">
                <!-- NAVIGATION -->
                    <nav class="navirino">
                        <ul>
                            @if(Request::segment(1)=="members")
                                <li><a class="smoth-scroll" href="/#home">HOME</a></li>
                                <li><a class="smoth-scroll" href="/#aboutus">ABOUT US</a></li>
                                <li><a class="smoth-scroll" href="/#product">PRODUCT</a></li>
                                <li><a class="smoth-scroll" href="/#testimonials">TESTIMONIALS</a></li>
                                <li><a class="smoth-scroll" href="/#contactus">CONTACT</a></li>
                            @else
                                <li><a class="smoth-scroll" href="#home">HOME</a></li>
                                <li><a class="smoth-scroll" href="#aboutus">ABOUT US</a></li>
                                <li><a class="smoth-scroll" href="#product">PRODUCT</a></li>
                                <li><a class="smoth-scroll" href="#testimonials">TESTIMONIALS</a></li>
                                <li><a class="smoth-scroll" href="#contactus">CONTACT</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CONTENT -->
    <div id="scroll-to" class="clearfix">
       @yield("content")
    </div>

    <!-- FOOTER -->
    <footer id="bottom-footer">
        <div class="container">
            <div class="footer-container">
                <div class="upper row clearfix">
                    <div class="col-md-4">
                        <div class="footer-icon-container">
                            <img src="\themes\p4ward\img\p4ward-icon-footer.png">
                        </div>
                        <div><p>P4ward Global Marketing started through the concept of giving. On December 22, 2016, a tragedy hit our family. An accident happened in the apartment of my brother which started a fire that engulfed the entire flat including his body...</div>
                        <div class="button-container"><a href="#">READ MORE</a></div>
                    </div>
                    <div class="col-md-4">
                         <div class="footer-title-container">
                            <p class="footer-title">NAVIGATION</p>
                        </div>

                        @if(Request::segment(1)=="members")
                            <div class="nav-list"><a class="smoth-scroll" href="/#home">HOME</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="/#aboutus">ABOUT US</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="/#product">PRODUCT</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="/#testimonials">TESTIMONIALS</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="/#contactus">CONTACT</a></div>
                        @else
                            <div class="nav-list"><a class="smoth-scroll" href="#home">HOME</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="#aboutus">ABOUT US</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="#product">PRODUCT</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="#testimonials">TESTIMONIALS</a></div>
                            <div class="nav-list"><a class="smoth-scroll" href="#contactus">CONTACT</a></div>
                        @endif

                    </div>
                    <div class="col-md-4">
                        <div class="footer-title-container">
                            <p class="footer-title">PRODUCT PORTFOLIO</p>
                        </div>
                        <div class="product-list"><a href="#">DON ORGANICS COFFEE SCRUB</a></div>
                        <div class="product-list"><a href="#">DON ORGANICS RED RICE SCRUB</a></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="container">
        <div class="bottom">                           
            <div class="ftr-title">© P4ward. All Rights Reserved</div>
            <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
        </div>
    </div>
    
    @include("frontend.gfoot")
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    
    <!-- FB WIDGET -->
    <div id="fb-root"></div>

     @yield("script")
    </body>
</html>
