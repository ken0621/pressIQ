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
        {{-- <link rel="apple-touch-icon" href="apple-touch-icon.png"> --}}
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/unity-wealth-icon.png"" type="image/png" />

        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500" rel="stylesheet">    
        
        @include("frontend.ghead")

        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">

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
            <div class="left-container"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span><span>company-email.here</span></div>
            <div class="right-container"><span style="cursor: pointer;" onClick="location.href='/members/logout'">LOGOUT</span><span style="cursor: pointer;" onClick="location.href='/members'">MY ACCOUNT</span></div>
            @else
            <div class="left-container">
                <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <span>company-email.here</span>
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
                <div class="col-md-3">
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
                <div class="col-md-9">
                <!-- NAVIGATION -->
                    <nav class="navirino">
                        <ul>
                            @if(Request::segment(1)=="members")
                                <li><a class="smoth-scroll" href="/#home">HOME</a></li>
                                <li><a class="smoth-scroll" href="/#aboutus">COMPANY</a></li>
                                <li><a class="smoth-scroll" href="/#mission-vision">MISSION & VISION</a></li>
                                <li><a class="smoth-scroll" href="/#products">CONTACT US</a></li>
                            @else
                                <li><a class="smoth-scroll" href="#home">HOME</a></li>
                                <li><a class="smoth-scroll" href="#aboutus">COMPANY</a></li>
                                <li><a class="smoth-scroll" href="#mission-vision">MISSION & VISION</a></li>
                                <li><a class="smoth-scroll" href="#products">CONTACT US</a></li>
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
                                <p class="footer-details">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                            </div>
                            <div class="jca-footer-details-container">
                                <div class="icon-holder">
                                    <img class="jca-footer-icon" src="/themes/{{ $shop_theme }}/img/telephone-logo.png">
                                </div>
                                <p class="footer-details">(02)000-0000 | 0917-000-0000</p>
                            </div>
                            <div class="jca-footer-details-container">
                                <div class="icon-holder">
                                    <img class="jca-footer-icon" src="/themes/{{ $shop_theme }}/img/mail-logo.png">
                                </div>
                                <p class="footer-details">unitywealth@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                </div>
            </div>
        </div>
    </footer>
    <div class="container">
        <div class="bottom">                           
            <div class="ftr-title">© UnityWealth. All Right Reserved</div>
            <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
        </div>
    </div>
    
    @include("frontend.gfoot")
    {{-- GLOBALS --}}
    <script src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    <!-- FB WIDGET -->
    <div id="fb-root"></div>
    @yield("script")
    </body>
</html>
