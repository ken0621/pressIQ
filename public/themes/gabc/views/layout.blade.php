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
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/fav.svg" type="image/svg" />
    
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">   

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
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
                    <div id="nav_list" style="display: none;"><i class="fa fa-bars hamburger" onclick="on()"></i></div>
                    <div class="image-logo-holder">
                        <a class="clearfix" href="/">
                            <img src="/themes/{{ $shop_theme }}/img/header-logo.svg">
                        </a>                       
                    </div>
                    <div class="menu-nav">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="menu-mobile-nav">
                        <div class="border-container"></div>
                        <span><a class="smoth-scroll" href="#home">HOME</a></span>
                        <div class="border-container"></div>
                        <span><a class="smoth-scroll" href="#about">ABOUT</a></span>
                        <div class="border-container"></div>
                        <span><a class="smoth-scroll" href="#founders">FOUNDERS</a></span>
                        <div class="border-container"></div>
                        <span><a class="smoth-scroll" href="#partners">PARTNERS</a></span>
                        <div class="border-container"></div>
                        <span><a class="smoth-scroll" href="#candidates">CANDIDATES</a></span>
                        <div class="border-container"></div>
                        <span><a class="smoth-scroll" href="#advisory">ADVISORY</a></span>
                        <div class="border-container"></div>
                    </div>
                </div>
                <div class="col-md-10">
                <!-- NAVIGATION -->
                    <nav class="navirino">
                        <ul>
                            <li><a class="smoth-scroll" href="#home">HOME</a></li>
                            <li><a class="smoth-scroll" href="#about">ABOUT</a></li>
                            <li><a class="smoth-scroll" href="#founders">FOUNDERS</a></li>
                            <li><a class="smoth-scroll" href="#partners">PARTNERS</a></li>
                            <li><a class="smoth-scroll" href="#candidates">CANDIDATES</a></li>
                            <li><a class="smoth-scroll" href="#advisory">ADVISORY</a></li>
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
    <footer>
        <div class="container">
            <div class="footer__upper">
                <div class="row clearfix">
                    <div class="col-md-3">
                        <div class="footer__upper__title">DOCUMENTS</div>
                        <div class="footer__upper__content">
                            <a class="footer__upper__content__link" href=""><div>GABC ICO Verification</div></a>
                            <a class="footer__upper__content__link" href=""><div>GABC Terms Partnership and Support</div></a>
                            <a class="footer__upper__content__link" href=""><div>GABC Advisory Board Concept</div></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer__upper__title">FOLLOW US</div>
                        <div class="footer__upper__content">
                            <div class="grid-container">
                                <a target="_blank" href="https://t.me/GABC_Global"><div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_tele.png"></div></a>
                                <a target="_blank" href="fb.me/GABC.Global"><div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_fb.png"></div></a>
                                <a target="_blank" href="https://twitter.com/GABC_Global"><div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_twitter.png"></div></a>
                                <a target="_blank" href="https://www.linkedin.com/groups/10400076/"><div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_in.png"></div></a>
             
                                {{-- <div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_ig.png"></div>
                                <div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_ytube.png"></div>
                                <div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_skype.png"></div>
                                <div class="grid-container__item"><img src="/themes/{{ $shop_theme }}/img/f_icon_gplus.png"></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer__upper__title">CONTACT US</div>
                        <div class="footer__upper__content">
                            <div class="footer__upper__content__link">
                                <div>
                                    <span><i class="fa fa-envelope-open"></i>&nbsp;&nbsp;</span>
                                    <span>support@gabc.com</span>
                                </div>
                            </div>
                            {{-- <div class="footer__upper__content__link">
                                <div>
                                    <span><i class="fa fa-phone"></i>&nbsp;&nbsp;</span>
                                    <span>+63 912 345 6789</span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer__upper__title">STRATEGIC PARTNERS</div>
                        <div class="footer__upper__content">
                            <div class="footer__upper__content__icon"><img src="/themes/{{ $shop_theme }}/img/digima_icon.png"></div>
                            <div class="footer__upper__content__icon"><img src="/themes/{{ $shop_theme }}/img/dmsph_icon.png"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__lower">
            <div class="container">
                <div class="footer__lower__left">Copyright © 2018</div>
                <div class="footer__lower__right">
                    <a href="">Terms of Use</a>
                    <a href="">Privacy Policy</a>
                    <a href="">Disclaimers</a>
                    <a href="">Risk Factor</a>
                </div>
            </div>
        </div>
    </footer>
    
    @include("frontend.gfoot")
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
    
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
