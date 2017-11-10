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
    <div class="top-header">
        <div class="container">
            <!-- TOP HEADER INFO -->
            <div class="left-container">
                <div class="top-info-container">
                    <div class="icon-container">
                        <i class="fa fa-mobile"></i>
                    </div>
                    <div class="detail-container">
                        0123-456-789
                    </div>
                </div>
                <div class="top-info-container">
                    <div class="icon-container">
                        <i class="fa fa-envelope-o"></i>
                    </div>
                    <div class="detail-container">
                        username@gmail.com
                    </div>
                </div>
                <div class="top-info-container">
                    <div class="icon-container">
                        <i class="fa fa-facebook"></i>
                    </div>
                    <div class="detail-container">
                        username/facebook.com
                    </div>
                </div>
            </div>
            <!-- LOGIN REGISTER -->
            <div class="right-container">
                <div class="reg-btn">
                    Register
                </div>
                <button>
                    Sign In
                </button>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="logo-container">
                <img src="/themes/{{ $shop_theme }}/img/header-logo.png">
            </div>
            <nav>
                <ul>

                    <li>Home</li>
                    <li>About Us</li>
                    <li>Contact Us</li>
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- CONTENT -->
    <div id="scroll-to" class="clearfix">
       @yield("content")
    </div>

    <!-- FOOTER -->
    
    <footer>
        <div class="container">
            <div class="top-footer row clearfix"> 
                <div class="col-md-4">
                    <div class="ftr-info-title">
                        INFORMATION
                    </div>
                    <div class="ftr-info">
                        <ul>
                            <li>HOME</li>
                            <li>ABOUT</li>
                            <li>CONTACT</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftr-info-title">
                        NEWS LETTER
                    </div>
                    <div class="ftr-info">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur<br> adipisicing elit. 
                            Quae explicabo iure nulla, 
                        </p>
                        <div class="newsletter-txtbox">
                            <input type="text" placeholder="Enter your Email here">
                            <i class="fa fa-send"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftr-info-title">
                        FOLLOW US ON
                    </div>
                    <div class="ftr-info">
                        <div class="media-icon">
                            <i class="fa fa-facebook"></i>
                        </div>
                        <div class="media-icon">
                            <i class="fa fa-twitter"></i>
                        </div>
                        <div class="media-icon">
                            <i class="fa fa-pinterest-p"></i>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="bottom-footer">
                <div class="left-container">
                    <span>Terms & Conditions</span>
                    <span>API Use Policy</span>
                    <span>Privacy Policy</span>
                    <span>Cookies</span>
                </div>
                <div class="right-container">
                    <span>© 2015 - 2016 DIGIMA HOUSE. All Rights Reserved</span>
                </div>
            </div>
        </div>
    </footer>
    
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
