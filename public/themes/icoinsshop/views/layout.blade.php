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
    <link rel="icon" href="/themes/{{ $shop_theme }}/img/favicon.png" type="image/png"/>
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500" rel="stylesheet">
    <!-- GLOBAL CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/push_sidenav.css?version=2">
    <!-- VIDEO LIGHTBOX -->
    <link rel="stylesheet" type="text/css" media="all" href="/themes/{{ $shop_theme }}/assets/lity/assets/prism.css">
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/lity/dist/lity.css">
    
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
<body>
    
    <div class="blur-me">

        <div class="loader hide">
            <span><img src="/resources/assets/frontend/img/loader.gif"></span>
        </div>

        <!-- HEADER -->
        <header class="header-container">
            <div class="nav-holder">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="image-logo-holder">
                                <a class="clearfix logo-1" href="/"><img src="/themes/{{ $shop_theme }}/img/logo-1.png"></a>
                                <a class="clearfix logo-2" href="/"><img src="/themes/{{ $shop_theme }}/img/logo-2.png"></a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <nav>
                                <ul>
                                    <li><a style="padding-left: 0;" href="javascript:">Home</a></li>
                                    <li><a href="javascript:">About Us</a></li>
                                    <li><a href="javascript:">Mission & Vision</a></li>
                                    <li><a href="javascript:">Now Releases</a></li>
                                    <li class="pull-right"><a href="/member/login"><button class="btn-signin">SIGN IN</button></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div id="scroll-to" class="clearfix">
            @yield("content")
        </div>

        <!-- FOOTER -->
        <footer>
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="text-header">INFORMATION</div>
                        <div class="holder">
                            <div class="link"><a href="javascript:">HOME</a></div>
                            <div class="link"><a href="javascript:">ABOUT US</a></div>
                            <div class="link"><a href="javascript:">CONTACT US</a></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-header">NEWS LETTER</div>
                        <div class="holder">
                            <div class="parag">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus adipisci, architecto qui iusto. A, ea.</div>
                        </div>
                        <form action="">
                            <div class="form-group">
                                <input type="text" placeholder="Enter your email here"><a href="javascript:"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="text-header">FOLLOW US ON</div>
                        <div class="holder">
                            <div class="social-icons">
                                <a class="icon" href="javascript:"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                {{-- <span class="space"></span> --}}
                                <a class="icon" href="javascript:"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                {{-- <span class="space"></span> --}}
                                <a class="icon" href="javascript:"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="left">
                                <span><a href="javascript:">Terms & Conditions</a></span>
                                <span class="space">|</span>
                                <span><a href="javascript:">API Use Policy</a></span>
                                <span class="space">|</span>
                                <span><a href="javascript:">Privacy Policy</a></span>
                                <span class="space">|</span>
                                <span><a href="javascript:">Cookies</a></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="right">
                                <span>Powered by: DIGIMA WEB SOLUTIONS INC.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    @include("frontend.gfoot")
    {{-- GLOBALS --}}
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js?version=2"></script>
    <!-- COUNTDOWN TIMER -->
    {{-- <script src="/themes/{{ $shop_theme }}/assets/countdown/jquery.backstretch.min.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/countdown/jquery.countdown.min.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/countdown/wow.min.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/countdown/scripts.js?version=1"></script> --}}

    <!-- LITY -->
    {{-- <script src="/themes/{{ $shop_theme }}/assets/lity/vendor/jquery.js"></script> --}}
    <script src="/themes/{{ $shop_theme }}/assets/lity/dist/lity.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/lity/assets/prism.js"></script>
    
    <!-- FB WIDGET -->
    <div id="fb-root"></div>
    @yield("script")
</body>
</html>