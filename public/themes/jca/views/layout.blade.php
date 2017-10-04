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
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">   
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
            <div class="left-container"><span><i class="fa fa-heart-o" aria-hidden="true"></i></span><span>BECOME A MEMBER</span></div>
            <div class="right-container"><span style="cursor: pointer;" onClick="location.href='/members/logout'">LOGOUT</span><span style="cursor: pointer;" onClick="location.href='/members'">MY ACCOUNT</span></div>
            @else
            <div class="left-container">
                <span><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                <span>BECOME A MEMBER</span>
            </div>
            <div class="right-container">
                <span class="smoth-scroll" style="cursor: pointer;" onClick="location.href='/members/login'">LOGIN</span>
                <span class="smoth-scroll" style="cursor: pointer;" onClick="location.href='/members/register'">REGISTER</span>
            </div>
            @endif
        </div>
    </div>
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
                    <div class="image-logo-holder">
                        <a class="clearfix" href="/"><img src="/themes/{{ $shop_theme }}/img/header-logo.png"></a>                       
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
                                <li><a class="smoth-scroll" href="/#mission-vision">MISSION & VISION</a></li>
                                <li><a class="smoth-scroll" href="/#products">PRODUCTS</a></li>
                            @else
                                <li><a class="smoth-scroll" href="#home">HOME</a></li>
                                <li><a class="smoth-scroll" href="#aboutus">ABOUT US</a></li>
                                <li><a class="smoth-scroll" href="#mission-vision">MISSION & VISION</a></li>
                                <li><a class="smoth-scroll" href="#products">PRODUCTS</a></li>
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
                        <div class="reach-us-holder">
                            <div class="jca-footer-title-container">
                                <p class="footer-title">Reach Us</p>
                            </div>
                            <div class="jca-footer-details-container">
                                <div class="icon-holder">
                                    <img class="jca-footer-icon" src="/themes/{{ $shop_theme }}/img/location-logo.png">
                                </div>
                                <p class="footer-details">Unit 810 8/F Raffles Corporate Center, F. Ortigas Ave., Ortigas Center, San Antonio, Pasig City</p>
                            </div>
                            <div class="jca-footer-details-container">
                                <div class="icon-holder">
                                    <img class="jca-footer-icon" src="/themes/{{ $shop_theme }}/img/telephone-logo.png">
                                </div>
                                <p class="footer-details">(02)631-6997 | 0917-5326968</p>
                            </div>
                            <div class="jca-footer-details-container">
                                <div class="icon-holder">
                                    <img class="jca-footer-icon" src="/themes/{{ $shop_theme }}/img/mail-logo.png">
                                </div>
                                <p class="footer-details">jcainternationalcorp@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="jca-footer-title-container">
                            <p class="footer-title">Quick Links</p>
                        </div>
                        <div class="jca-footer-details-container">
                            <p class="footer-detail-list">Company Policy</p>
                            <p class="footer-detail-list">Dealer’s Policy</p>
                            <p class="footer-detail-list">Disclaimer</p>
                            <p class="footer-detail-list">Terms & Condition</p>
                            <p class="footer-detail-list">Privacy Policy</p>
                            <p class="footer-detail-list">Product Policy</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="jca-footer-title-container">
                            <p class="footer-title">Overview</p>
                        </div>
                        <div class="jca-footer-details-container">
                            <p class="footer-detail-list">Marketing Plan</p>
                            <p class="footer-detail-list">Packages</p>
                            <p class="footer-detail-list">Product Packages</p>
                            <p class="footer-detail-list">Direct Selling</p>
                            <p class="footer-detail-list">Unilevel</p>
                            <p class="footer-detail-list">Sales Comission</p>
                            <p class="footer-detail-list">Overide Sales Comission</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="jca-footer-title-container">
                            <p class="footer-title">Product Portfolio</p>
                        </div>
                        <div class="jca-footer-details-container">
                            <p class="footer-detail-list">JCA Wellness Body Cream</p>
                            <p class="footer-detail-list">JCA Wellness Day Cream</p>
                            <p class="footer-detail-list">JCA Wellness Night Cream</p>
                            <p class="footer-detail-list">Swiss Apple Stemcell Cerum</p>
                            <p class="footer-detail-list">Swiss Apple Stemcell Soap with</p>
                            <p class="footer-detail-list">gulthathione and collagen</p>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </footer>
    <div class="container">
        <div class="bottom">                           
            <div class="ftr-title">© JCA International Corporation. All Right Reserved</div>
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
