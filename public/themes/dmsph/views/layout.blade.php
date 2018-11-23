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
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/dms-logo.png" type="image/jpg" />
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/assets/member/plugin/toaster/toastr.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css?version=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/jquery.fancybox.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/jquery.fancybox.min.css">

        <link rel="stylesheet" href="path/to/swiper.min.css">


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
            <div class="side-nav">
                <nav class="pushmenu pushmenu-left">
                    <div class="mob-banner">
                        <img src="/themes/{{ $shop_theme }}/img/bg-mob.jpg" alt="">
                    </div>
                    <div class="space1"></div>
                    <span>BROWSE</span>
                    <ul class="links">
                        <li> 
                            <a onclick="off()" href="/#home"><i class="fa fa-home" aria-hidden="true"></i> HOME</a>
                        </li>
                        <li>
                            <a onclick="off()" href="/#about"><i class="fa fa-info" aria-hidden="true"></i> ABOUT US</a>
                        </li>
                        <li> 
                            <a onclick="off()" href="/#gallery"><i class="fa fa-picture-o" aria-hidden="true"></i> PRODUCT</a>
                        </li>
                        <li> 
                            <a onclick="off()" href="/#gallery"><i class="fa fa-picture-o" aria-hidden="true"></i> SERVICES</a>
                        </li>
                        <li> 
                            <a onclick="off()" href="/#contact"><i class="fa fa-phone" aria-hidden="true"></i> CONTACT</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="blur-me">
                <header class="header-container">
                    <div class="nav-holder">
                        <div class="container">
                            <div class="row-clearfix">
                                <div class="col-md-4">
                                    <div id="nav_list" onclick="on()"><i class="fa fa-bars hamburger"></i></div>
                                    <div class="image-logo-holder">
                                        <a class="clearfix" href="/">
                                            <a href="/" class="w-logo"><img src="/themes/{{ $shop_theme }}/img/dms-logo.png"></a>
                                            <a href="/" class="b-logo"><img src="/themes/{{ $shop_theme }}/img/dms-logo.png"></a>
                                        </a>                       
                                    </div>
                                    <div class="image-logo-mob">
                                        <a class="clearfix" href="/"><img src="/themes/{{ $shop_theme }}/img/dms-logo.png"></a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                    <!-- NAVIGATION -->
                        <nav class="navigation">
                            <ul>
                                @if(Request::segment(1)=="product")
                                    <li><a class="smoth-scroll" href="/#home">HOME</a></li>
                                    <li><a class="smoth-scroll" href="/#about">ABOUT US</a></li>
                                    <li><a class="smoth-scroll" href="/#about">PRODUCTS</a></li>
                                    <li><a class="smoth-scroll" href="/#gallery">SERVICES</a></li>
                                    <li><a class="smoth-scroll" href="/#contact">CONTACT</a></li>
                                @else
                                    <li><a class="smoth-scroll" href="#home">HOME</a></li>
                                    <li><a class="smoth-scroll" href="#about">ABOUT US</a></li>
                                    <li><a class="smoth-scroll" href="/#about">PRODUCTS</a></li>
                                    <li><a class="smoth-scroll" href="#gallery">SERVICES</a></li>
                                    <li><a class="smoth-scroll" href="#contact">CONTACT</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
           

            <!-- CONTENT -->
            <div id="scroll-to" class="clearfix">
        	   @yield("content")
            </div>

            <!-- FOOTER -->
            <footer id="bottom-footer">
                <div class="container">
                    <div class="footer-container">
                        <div class="footer-logo">
                            <img src="/themes/{{ $shop_theme }}/img/dms-white-logo.png">
                        </div>

                        <nav class="footer-navigation">
                            <ul>
                                    <li><a class="smoth-scroll" href="#home">HOME</a></li>
                                    <li><a class="smoth-scroll" href="#about">ABOUT US</a></li>
                                    <li><a class="smoth-scroll" href="#about">PRODUCTS</a></li>
                                    <li><a class="smoth-scroll" href="#gallery">SERVICES</a></li>
                                    <li><a class="smoth-scroll" href="#contact">CONTACT</a></li>
                            </ul>
                        </nav>

                        <div class="social-nav">
                            <ul>
                                <li><a><i class="fa fa-facebook"></i></a></li>
                                <li><a><i class="fab fa-twitter"></i></a></li>
                                <li><a><i class="fab fa-google-plus-g"></i></a></li>
                                {{-- <li><a href="https://www.instagram.com/foreversale.ph" target="_blank"><i class="fab fa-instagram"></i></a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="container">
                        <div class="ftr-title">©2018 Digital & Marketing Solutions PH Inc. All Rights Reserved</div>
                        <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
                    </div>                       
                </div>
            </footer>

        @include("frontend.gfoot")
        <!-- FB WIDGET -->
        <div id="fb-root"></div>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
        <script type="text/javascript" src="/assets/member/plugin/toaster/toastr.min.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.esm.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.esm.bundle.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/jquery.fancybox.min.js"></script>

        <script src="path/to/swiper.min.js"></script>

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
        <script>
            $(document).ready(function(){
              $('.dropdown-submenu a.test').on("click", function(e){
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
              });
            });
        </script>
        @yield("script")
    </body>
</html>