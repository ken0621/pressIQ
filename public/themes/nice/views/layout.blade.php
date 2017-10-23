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
    
        <link rel="stylesheet" type="text/css" href="/assets/member/plugin/toaster/toastr.css">
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">    
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
        <link rel="stylesheet" type="text/css" href="/assets/front/css/loader.css">
        <!-- THEME COLOR -->
        <link href="/themes/{{ $shop_theme }}/css/{{ $shop_theme_color }}.css" rel="stylesheet" type="text/css">
        <!-- PARALLAX -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/parallax.css">
        <!-- Brown Custom Icon -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/brown-icon/styles.css">
        <!-- LIGHTBOX -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/lightbox/css/lightbox.css">
        <!-- WOW JS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/wow/css/animate.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">

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
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    {{-- GLOBALS --}}
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/globalv2.js"></script>
    {{-- GLOBALS --}}
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/figuesslider.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/parallax.js"></script>

    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/lightbox/js/lightbox.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/scrollspy.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/easing/jquery.easing.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/wow/js/wow.min.js"></script>
        <script type="text/javascript" src="/assets/member/plugin/toaster/toastr.min.js"></script>

    <script>
          new WOW().init();
    </script>

    <!-- FROM HOME.BLADE -->
    <!-- <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css"> -->

    <!-- FB WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script type="text/javascript">
        $window = $(window);
        $window.scroll(function() {
          $scroll_position = $window.scrollTop();
            if ($scroll_position > 32.2167) { 
                $('.header-container').addClass('header-fixed');
                $('.subheader-container').addClass('header-fixed');

                header_height = $('.your-header').innerHeight();
                $('body').css('padding-top' , header_height);
            } else {
                $('body').css('padding-top' , '0');
                $('.header-container').removeClass('header-fixed');
                $('.subheader-container').removeClass('header-fixed');
            }
         });

    </script>

    <script type="text/javascript">
            
        $('.slider3').diyslider({
            width: "580px", // width of the slider
            height: "120px", // height of the slider
            display: 5, // number of slides you want it to display at once
            loop: false // disable looping on slides
            }); // this is all you need!

        // use buttons to change slide
        $('#gotoleft').bind("click", function(){
            // Go to the previous slide
            $('.slider3').diyslider("move", "back");
        });
        $('#gotoright').unbind("click")
        $('#gotoright').bind("click", function(){
            // Go to the previous slide
            $('.slider3').diyslider("move", "forth");
        });


        // NAVIRINO CLICK TOGGLE
        $(".menu-nav").click(function()
        {
            $(".navirino").toggle("slow");
        });


        /*PRODUCT HOVER TOGGLE*/
        $('.product-hover').hover(function()
        {
            $('.product-dropdown').stop();
            $('.product-dropdown').fadeIn(400);
        },
        function()
        {
            $('.product-dropdown').stop();
            $('.product-dropdown').fadeOut(400);
        });

        $('.company-hover').hover(function()
        {
            $('.company-dropdown').stop();
            $('.company-dropdown').fadeIn(400);
        },
        function()
        {
            $('.company-dropdown').stop();
            $('.company-dropdown').fadeOut(400);
        });

        $('.cart-hover').hover(function()
        {
            $('.cart-dropdown').stop();
            $('.cart-dropdown').fadeIn(400);
        },
        function()
        {
            $('.cart-dropdown').stop();
            $('.cart-dropdown').fadeOut(400);
        });

        /*scroll up*/
        $(window).scroll(function () {
            if ($(this).scrollTop() > 700) {
                $('.scroll-up').fadeIn();
            } else {
                $('.scroll-up').fadeOut();
            }
        });

        $('.scroll-up').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 700);
            return false;
        });

    </script>

    {{-- START GLOBAL MODAL --}}
    <div id="global_modal" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content modal-content-global clearfix">
            </div>
        </div>
    </div>
    {{-- END GLOBAL MODAL --}}
    {{-- GLOBAL MULTIPLE MODAL --}}
    <div class="multiple_global_modal_container"></div>
    {{-- END GLOBAL MULTIPLE MODAL --}}

    <script type="text/javascript" src="/assets/front/js/global_function.js"></script>
    @yield("script")
    </body>
</html>
