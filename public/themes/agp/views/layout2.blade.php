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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global2.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/push_sidenav.css">
    
    @include("frontend.ghead")
    <!-- OTHER CSS -->
    @yield("css")

    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body class="pushmenu-push">
    {{-- LOADER --}}
    <div class="loader hide">
        <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>

    {{-- HEADER --}}
    <div class="top-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left">
                    <div class="text">CALL US NOW: 09999999999</div> 
                    <div class="text">EMAIL US: sample@email.com</div>
                </div>
                <div class="pull-right">
                    <div class="text"><a href="/member/register">LOG IN</a></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CONTENT -->
    <div id="scroll-to" class="clearfix">
        @yield("content")
    </div>
    
    @include("frontend.gfoot")

    {{-- GLOBALS --}}
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    
    <!-- FB WIDGET -->
    <div id="fb-root"></div>

    @yield("script")
</body>
</html>