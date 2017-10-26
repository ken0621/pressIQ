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
    <link rel="icon" href="/themes/{{ $shop_theme }}/img/unity-wealth-icon.png" type="image/png" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500" rel="stylesheet">
    <!-- GLOBAL CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/push_sidenav.css">
    <!-- <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/new_sidenav.css"> -->
    <!-- COUNTDOWN TIMER -->
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/css/animate.css">
    {{-- <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/css/form-elements.css"> --}}
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/css/style.css">
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/css/media-queries.css">
    
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
<body class="pushmenu-push">
    
    <div class="loader hide">
        <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>
    <!-- HEADER -->
    <!-- <ul class="navigation">
        <li class="nav-item"><a href="#">Home</a></li>
        <li class="nav-item"><a href="#">Portfolio</a></li>
        <li class="nav-item"><a href="#">About</a></li>
        <li class="nav-item"><a href="#">Blog</a></li>
        <li class="nav-item"><a href="#">Contact</a></li>
    </ul>
    
    <input type="checkbox" id="nav-trigger" class="nav-trigger" />
    <label for="nav-trigger"></label> -->
    <div id="home" class="subheader-container">
        <div class="container">
            @if($customer)
            <!-- <div class="left-container"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span><span>company-email.here</span></div> -->
            <div class="right-container"><span style="cursor: pointer;" onClick="location.href='/members/logout'">LOGOUT</span><span style="cursor: pointer;" onClick="location.href='/members'">MY ACCOUNT</span></div>
            @else
            <!-- <div class="left-container">
                <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <span>company-email.here</span>
            </div> -->
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
                    @if(request()->segment(1) != "replicated")
                    <div id="nav_list"><i class="fa fa-bars hamburger"></i></div>
                    @endif
                    <nav class="pushmenu pushmenu-left">

                        @if($customer)
                        <div class="space1"></div>
                        <span>BROWSE</span>
                        <ul class="links">
                            <li> <a href="/">Home</a> </li>
                            <li> <a href="javascript:">Company</a> </li>
                            <li> <a href="javascript:">Mission & Vision</a> </li>
                            <li> <a href="javascript:">Contact Us</a> </li>
                        </ul>
                        
                        <div class="space2"></div>
                        <span>MEMBERS AREA</span>
                        <ul class="links">
                            <li> <a href="/members">Dashboard</a> </li>
                            <li> <a href="/members/profile">Profile</a> </li>
                            @if($mlm_member)
                            <li> <a href="javascript:">Videos</a> </li>
                            <li> <a href="javascript:">Ebooks</a> </li>
                            <li> <a href="/members/products">Products</a> </li>
                            <li> <a href="/members/certificate">Certificate</a> </li>
                            <li> <a href="/members/genealogy?mode=sponsor">Genealogy</a> </li>
                            <li> <a href="/members/report">Reports</a> </li>
                            <li> <a href="/members/wallet-encashment">Wallet</a> </li>
                                @if($customer)
                                    <li class="user-logout"> <a href="/members/logout">Logout &nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> </li>
                                @endif
                            @else
                            @endif
                        </ul>
                        @else
                            <div class="space1"></div>
                            <span>BROWSE</span>
                            <ul class="links">
                                <li> <a href="/">Home</a> </li>
                                <li> <a href="javascript:">Company</a> </li>
                                <li> <a href="javascript:">Mission & Vision</a> </li>
                                <li> <a href="javascript:">Contact Us</a> </li>
                            </ul>
                        @endif

                    </nav>
                    <div class="image-logo-holder">
                        <a class="clearfix" href="/">
                            <img src="/themes/{{ $shop_theme }}/img/header-logo.png">
                        </a>
                    </div>
                    @if(request()->segment(1) != "replicated")
                    <!-- <div class="menu-nav">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div> -->
                    @endif
                </div>
                <div class="col-md-9">
                    <!-- NAVIGATION -->
                    <nav class="navirino">
                        <ul>
                            @if(Request::segment(1)=="members")
                            <li><a class="smoth-scroll" href="/#home">HOME</a></li>
                            <li><a class="smoth-scroll" href="/#company">COMPANY</a></li>
                            <li><a class="smoth-scroll" href="/#mission-vision">MISSION & VISION</a></li>
                            <li><a class="smoth-scroll" href="/#contact">CONTACT US</a></li>
                            @else
                            <li><a class="smoth-scroll" href="#home">HOME</a></li>
                            <li><a class="smoth-scroll" href="#company">COMPANY</a></li>
                            <li><a class="smoth-scroll" href="#mission-vision">MISSION & VISION</a></li>
                            <li><a class="smoth-scroll" href="#contact">CONTACT US</a></li>
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
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    <!-- COUNTDOWN TIMER -->
    <script src="/themes/{{ $shop_theme }}/assets/countdown/jquery.backstretch.min.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/countdown/jquery.countdown.min.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/countdown/wow.min.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/countdown/scripts.js?version=1"></script>
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