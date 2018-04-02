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
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/assets/member/plugin/toaster/toastr.css">
        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/push_sidenav.css">

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
        {{-- <div class="loader-container">
          <div class="loader">
            <img src="/themes/{{ $shop_theme }}/img/loader.gif">
          </div>
        </div> --}}
        {{-- BLURED WHEN SIDENAV WAS CLICKED --}}
        <div class="blur-me">
            <div class="subheader-container">
                <div class="container">
                    @if($customer)
                    <span class="left-container">
                        <span>Welcome to TF Wellness</span>
                        <span>|</span>
                        <span>Follow Us On</span>
                        <span><i class="fab fa-facebook-square"></i></span>
                    </span>
                    <span class="right-container">
                        @if(Request::segment(1)=="members")
                        <span><a class="right-button smoth-scroll" href="/#aboutus">About Us</a></span>
                        <span></i></span>
                        <span><a class="right-button" href="/">Gallery</a></span>
                        <span></i></span>
                        <span><a class="right-button smoth-scroll" href="/#contactus">Contact Us</a></span>
                        <span></i></span>
                        @else
                        <span><a class="right-button smoth-scroll" href="#aboutus">About Us</a></span>
                        <span></i></span>
                        <span><a class="right-button" href="#">Gallery</a></span>
                        <span></i></span>
                        <span><a class="right-button smoth-scroll" href="#contactus">Contact Us</a></span>
                        <span></i></span>
                        @endif
                        <span><a class="right-button" href="/members/logout">LOGOUT</a></span>
                        <span>|</i></span>
                        <span><a href="/members">MY ACCOUNT</a></i></span>
                    </span>
                    @else
                    <span class="left-container">
                        <span>Welcome to TF Wellness</span>
                        <span>|</span>
                        <span>Follow Us On</span>
                        <span><i class="fab fa-facebook-square"></i></span>
                    </span>
                    <span class="right-container">
                        @if(Request::segment(1)=="members")
                        <span><a class="right-button smoth-scroll" href="/#aboutus">About Us</a></span>
                        <span></i></span>
                        <span><a class="right-button" href="/">Gallery</a></span>
                        <span></i></span>
                        <span><a class="right-button smoth-scroll" href="/#contactus">Contact Us</a></span>
                        <span></i></span>
                        @else
                        <span><a class="right-button smoth-scroll" href="#aboutus">About Us</a></span>
                        <span></i></span>
                        <span><a class="right-button" href="#">Gallery</a></span>
                        <span></i></span>
                        <span><a class="right-button smoth-scroll" href="#contactus">Contact Us</a></span>
                        <span></i></span>
                        @endif
                        <span><a class="right-button" href="/members/register">SIGN UP</a></span>
                        <span>|</i></span>
                        <span><a href="/members/login">LOGIN</a></i></span>
                    </span>
                    @endif
                </div>
            </div>

            <div class="header-container">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="image-logo-holder">
                                <a href="/#home">
                                    <img src="/themes/{{ $shop_theme }}/img/header-logo.png">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="search-container">
                                <div class="categories-container">
                                    <a href="#">All Categories</a>
                                </div>
                                <input type="text" class="form-control" placeholder="Search items here...">
                                <div class="btn-search">
                                    <a href="#">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="cart-container">
                                <div class="btn-cart">
                                    <a class="popup" link="/cartv2" size="lg" href="javascript:">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="items-container">
                                    <div>My Cart</div>
                                    <span>0 Item(s)</span>
                                    <span>-</span>
                                    <span>PHP 0.00</span>
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
                    <span class="ftr-title-1">
                        © 2018 TFWellness. All Rights Reserved
                    </span>
                    <div class="ftr-title-2">
                      <span><a href="#">Terms and Agreement</a></span>
                      <span>|</span>
                      <span><a href="#">Privacy Policy</a></span>
                      <span>|</span>
                      <span><a href="#">Return Policy</a></span>
                      <span>Powered By: Digima Web Solutions, Inc.</span>  
                    </div>
                </div>
            </footer>

         </div>

        @include("frontend.gfoot")
        <!-- FB WIDGET -->
        <div id="fb-root"></div>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>
        <script type="text/javascript" src="/assets/member/plugin/toaster/toastr.min.js"></script>
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
        @yield("js")
    </body>
</html>