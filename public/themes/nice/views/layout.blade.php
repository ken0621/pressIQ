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
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/nice-icon.png" type="image/png" />
    
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">    

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
                <span><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <span>012-345-6789</span>
                <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <span>company-email.here</span>
                <span><i class="fa fa-facebook" aria-hidden="true"></i></span>
                <span>Facebook</span>
            </div>
            <div class="right-container"><span style="cursor: pointer;" onClick="location.href='/members/logout'">LOGOUT</span><span style="cursor: pointer;" onClick="location.href='/members'">MY ACCOUNT</span></div>
            @else
            <div class="left-container">
                <span><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <span>012-345-6789</span>
                <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <span>company-email.here</span>
                <span><i class="fa fa-facebook" aria-hidden="true"></i></span>
                <span>Facebook</span>
            </div>
            <div class="right-container">
                <span class="smoth-scroll" style="cursor: pointer;" onClick="location.href='/members/register'">REGISTER</span>
                <span class="smoth-scroll" style="cursor: pointer;" onClick="location.href='/members/login'">
                    <div class="subhead-btn">SIGN IN</div>
                </span>
            </div>
            @endif
        </div>
    </div>
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
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
                                <li><a class="smoth-scroll" href="/#home">Home</a></li>
                                <li><a class="smoth-scroll" href="/#aboutus">About Us</a></li>
                                <li><a class="smoth-scroll" href="/#mission-vision">Packages</a></li>
                                <li><a class="smoth-scroll" href="/#products">Contact Us</a></li>
                            @else
                                <li><a class="smoth-scroll" href="#home">Home</a></li>
                                <li><a class="smoth-scroll" href="#aboutus">About Us</a></li>
                                <li><a class="smoth-scroll" href="#mission-vision">Packages</a></li>
                                <li><a class="smoth-scroll" href="#products">Contact Us</a></li>
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
                        <div class="footer-title-container">
                            <p class="footer-title">INFORMATION</p>
                        </div>
                        <a href=""><p>HOME</p></a>
                        <a href=""><p>ABOUT US</p></a>
                        <a href=""><p>PACKAGES</p></a>
                        <a href=""><p>CONTACT US</p></a>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-title-container">
                            <p class="footer-title">NEWS LETTER</p>
                        </div>
                        <p style="text-transform: uppercase; letter-spacing: 0.5px;">
                            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
                        </p>
                        <input type="text" placeholder="Enter Your Email Here">
                        <span style="padding-left: 10px;">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="col-md-4" style="padding-left: 150px !important;">
                        <div class="footer-title-container">
                            <p class="footer-title">FOLLOW US ON</p>
                        </div>
                        <span><i class="fa fa-facebook-square" aria-hidden="true"></i></span>
                        <span><i class="fa fa-twitter-square" aria-hidden="true"></i></span>
                        <span><i class="fa fa-pinterest-square" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="container">
        <div class="bottom">                           
            <div class="ftr-title">© Nicenterprises All Right Reserved</div>
            <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
        </div>
    </div>
    
    @include("frontend.gfoot")
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    
    <!-- HEADER FIXED -->
    <script type="text/javascript">
        $window = $(window);
        $window.scroll(function() {
          $scroll_position = $window.scrollTop();
            if ($scroll_position > 100) { 
                $('.header-container').addClass('header-fixed');

                header_height = $('.your-header').innerHeight();
                $('body').css('padding-top' , header_height);
            } else {
                $('.header-container').removeClass('header-fixed');
                $('body').css('padding-top' , '0');
            }
         });
    </script>

    <!-- FB WIDGET -->
    <div id="fb-root"></div>

     @yield("script")
    </body>
</html>
