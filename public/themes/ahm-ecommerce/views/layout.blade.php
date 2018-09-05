<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ ucfirst($shop_info->shop_key) }} | {{ $page or '' }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="apple-touch-icon" href="apple-touch-icon.png"> -->
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/favicon.png" type="image/jpg" />
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/assets/member/plugin/toaster/toastr.css">
        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css?version=1">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/swiper.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/swiper.min.css">

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
            <div id="overlay" onclick="off()"></div>
            <div class="subheader-container">
                <div class="container">
                    <span class="right-container">
                        <span><a href="#">About Us</a></span>
                        <span>|</span>
                        <span><a href="#">Support</a></span>
                        <span>|</span>
                        <span><a href="/members/login">Contact Us</a></span>
                        <span><a class="sign-btn" href="/members/register">Sign Up</a></span>
                        <span>|</span>
                        <span><a class="log-btn" href="/members/login">Login</a></span>
                    </span>
                </div>
            </div>

            <div class="header-container">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-3">
                           <div class="image-logo-holder">
                               <a href="/#home">
                                   <img src="/themes/{{ $shop_theme }}/img/logo-header.png">
                               </a>
                           </div>
                        </div>
                        <div class="col-md-5">
                            <div class="search-container">
                                <div class="input-group">
                                  <div class="input-group-btn">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Categories<span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#">Games</a></li>
                                      <li><a href="#">General Consultancy</a></li>
                                      <li><a href="#">General Supply Services</a></li>
                                      <li><a href="#">Holding Services</a></li>
                                      <li><a href="#">I.T. Services</a></li>
                                      <li><a href="#">Import & Export Services</a></li>
                                      <li><a href="#">Man Power Services</a></li>
                                      <li><a href="#">Marketing</a></li>
                                      <li><a href="#">Real Estate</a></li>
                                    </ul>
                                  </div>
                                  <input type="text" class="form-control" aria-label="..." placeholder="Search product or services here...">
                                  <a class="btn-search" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="features-container">
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <div class="per-container">
                                            <div class="row-no-padding">
                                                <div class="col-md-4">
                                                    <div class="icon">
                                                        <img src="/themes/{{ $shop_theme }}/img/online-supp.png">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="info">24/7 Online Support</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="per-container">
                                            <div class="row-no-padding">
                                                <div class="col-md-4">
                                                    <div class="icon">
                                                        <img src="/themes/{{ $shop_theme }}/img/safe-payment.png">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="info">Safe Payment</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="per-container">
                                            <div class="row-no-padding">
                                                <div class="col-md-4">
                                                    <div class="icon">
                                                        <img src="/themes/{{ $shop_theme }}/img/trusted.png">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="info">We are trusted</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="title">SHOP</div>
                                <ul>
                                    <li><a href="#">Games</a></li>
                                    <li><a href="#">General Consulting</a></li>
                                    <li><a href="#">General Supply Services</a></li>
                                    <li><a href="#">Holding Services</a></li>
                                    <li><a href="#">I.T. Services</a></li>
                                    <li><a href="#">Import & Export Services</a></li>
                                    <li><a href="#">Man Power Services</a></li>
                                    <li><a href="#">Marketing</a></li>
                                    <li><a href="#">Real Estate</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="title">PAYMENT METHOD</div>
                            </div>
                            <div class="col-md-4">
                                <div class="title">FOLLOW US ON</div>
                                <div class="social-container">
                                    <span><img src="/themes/{{ $shop_theme }}/img/fb-icon.png"></span>
                                    <span><img src="/themes/{{ $shop_theme }}/img/twitter-icon.png"></span>
                                    <span><img src="/themes/{{ $shop_theme }}/img/linkedin-icon.png"></span>
                                    <span><img src="/themes/{{ $shop_theme }}/img/google-icon.png"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="bottom">
                <div class="container">                        
                    <div class="ftr-title">© 2018 AHM. All Rights Reserved</div>
                    <div class="ftr-title-2">
                        <span>Terms and Agreement</span>
                        <span>|</span>
                        <span>Privacy Policy</span>
                        <span>|</span>
                        <span>Powered By: Digima Web Solutions, Inc.</span>
                    </div>
                </div>
            </div>

        @include("frontend.gfoot")
        <!-- FB WIDGET -->
        <div id="fb-root"></div>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
        <script type="text/javascript" src="/assets/member/plugin/toaster/toastr.min.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/swiper.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/swiper.min.js"></script>

        <script type="text/javascript">
            $window = $(window);
            $window.scroll(function() 
            {
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
        <script>
            $('.smoth-scroll').on('click', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top -180)
                }, 1250, 'easeInOutExpo');
                event.preventDefault();
            });
        </script>
        <script> 
          $(window).load(function() { 
            $.fn.lightspeedBox(); 
          }); 
        </script> 
        @yield("script")
    </body>
</html>