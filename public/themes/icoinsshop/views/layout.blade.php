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
    {{-- <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/smooth-scroll.css"> --}}
    
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
                    <div class="row-no-padding clearfix">
                        <div class="col-md-2">
                            <div class="image-logo-holder">
                                <a class="clearfix logo-1" href="/"><img src="/themes/{{ $shop_theme }}/img/icoins-logo.png"></a>
                                <a class="clearfix logo-2" href="/"><img src="/themes/{{ $shop_theme }}/img/logo-2.png"></a>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <nav class="navigation">
                                <ul>
                                    @if(Request::segment(1) == "members")
                                        <li><a class="navigation__link" href="/#home">HOME</a></li>
                                        <li><a class="navigation__link" href="/#about">ABOUT</a></li>
                                        <li><a class="navigation__link" href="/#missionvision">MISSION AND VISION</a></li>
                                        <li><a class="navigation__link" href="/#howitworks">HOW IT WORKS</a></li>
                                        <li><a class="navigation__link" href="/#products">PRODUCTS</a></li>
                                        <li><a class="navigation__link" href="/#news">NEWS</a></li>
                                    @else
                                        <li><a class="navigation__link" href="#home">HOME</a></li>
                                        <li><a class="navigation__link" href="#about">ABOUT</a></li>
                                        <li><a class="navigation__link" href="#missionvision">MISSION AND VISION</a></li>
                                        <li><a class="navigation__link" href="#howitworks">HOW IT WORKS</a></li>
                                        <li><a class="navigation__link" href="#products">PRODUCTS</a></li>
                                        <li><a class="navigation__link" href="#news">NEWS</a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-3">
                            <div class="nav">
                                <ul>
                                    @if($customer)
                                        <li><a class="{{ Request::segment(1) == "members" ? "active" : "" }}" href="/members">MY ACCOUNT</a></li>
                                        <li><a href="/members/logout"><button class="btn-signin">LOGOUT</button></a></li>
                                    @else
                                        <li><a href="/members/login"><button class="btn-signin">SIGNIN</button></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
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
                <div class="bottom-text">Copyright © 2018 Icoinsshop. All Rights Reserved </div>
            </div>
        </footer>
    </div>
    
    @include("frontend.gfoot")
    {{-- GLOBALS --}}
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js?version=2"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/smooth-scroll.js"></script>
    
    <!-- FB WIDGET -->
    <div id="fb-root"></div>
    @yield("script")
</body>
</html>