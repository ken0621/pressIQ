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
    <link rel="icon"  type="image/png" href="http://alpha-globalprestige.com/assets/front/img/agp.png">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300i,400,700,900" rel="stylesheet">

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global2.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/push_sidenav.css">
    
    @include("frontend.ghead")
    <!-- OTHER CSS -->
    @yield("css")

    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body>
    <div id="overlay" onclick="off()"></div>
    {{-- LOADER --}}
    <div class="loader hide">
        <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>

    {{-- HEADER --}}
    <div class="top-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left remove-mobile">
                    <div class="text">{{ get_content($shop_theme_info, "header", "header_call_label") }}: {{ get_content($shop_theme_info, "header", "header_call_number") }}</div> 
                    <div class="text">{{ get_content($shop_theme_info, "header", "header_email_label") }}: {{ get_content($shop_theme_info, "header", "header_email_address") }}</div>
                </div>
                <div class="pull-right">
                    @if($customer)
                        <div class="text"><a href="/members/logout">LOGOUT</a></div>
                        <div class="text"><a href="/members">MY ACCOUNT</a></div>
                    @else
                        <div class="text"><a href="/members/login">LOGIN</a></div>
                        <div class="text"><a href="/members/register">REGISTER</a></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar">
        <div class="container">
            
            <div id="nav_list" onclick="on()"><i class="fa fa-bars hamburger"></i></div>
            <nav class="pushmenu pushmenu-left">

                @if($customer)
                <div class="space1"></div>
                <span>BROWSE</span>
                <ul class="links">
                    <li class="{{ Request::segment(2) == "" ? "active" : "" }}"> <a href="/">HOME</a> </li>
                    <li class="nav-ext"> <a href="/product">PRODUCTS</a> </li>
                    <li class="nav-ext"> <a href="/about">COMPANY</a> </li>
                    <li class="nav-ext"> <a href="/testimony">TESTIMONIALS</a> </li>
                    <li class="nav-ext"> <a href="/policy">POLICIES</a> </li>
                    <li class="nav-ext"> <a href="/contact">CONTACT US</a> </li>
                </ul>
                
                <div class="space2"></div>
                <span>MEMBERS AREA</span>
                <ul class="links">
                    <li class="{{ Request::segment(1) == "members" ? "active" : "" }}" > <a href="/members">DASHBOARD</a> </li>
                    <li> <a href="/members/profile">PROFILE</a> </li>
                    @if($mlm_member)
                    <li class="{{ Request::segment(2) == "genealogy" ? "active" : "" }}"> <a href="/members/genealogy?mode=binary">GENEALOGY</a> </li>
                    <li class="{{ Request::segment(2) == "report" ? "active" : "" }}"> <a href="/members/report">REPORTS</a> </li>
                    <li class="{{ Request::segment(2) == "report" ? "active" : "" }}"> <a href="/members/lead-list">LEAD LIST</a> </li>
                    <li class="{{ Request::segment(2) == "wallet-encashment" ? "active" : "" }}"> <a href="/members/wallet-encashment">WALLET</a> </li>
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
                        <li class="{{ Request::segment(2) == "" ? "active" : "" }}"> <a href="/">HOME</a> </li>
                        <li class="nav-ext"> <a href="/product">PRODUCTS</a> </li>
                        <li class="nav-ext"> <a href="/about">COMPANY</a> </li>
                        <li class="nav-ext"> <a href="/testimony">TESTIMONIALS</a> </li>
                        <li class="nav-ext"> <a href="/policy">POLICIES</a> </li>
                        <li class="nav-ext"> <a href="/contact">CONTACT US</a> </li>
                    </ul>
                @endif
            </nav>

            <a class="navbar-brand" href="#">
                <img style="max-width: 150px;" src="{{ $company_info["company_logo"]->value ? $company_info["company_logo"]->value : '/themes/' . $shop_theme . '/assets/front/img/small-logo.png' }}">
            </a>
            <!-- Brand and toggle get grouped for better mobile display -->
            <!-- <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="{{ $company_info["company_logo"]->value ? $company_info["company_logo"]->value : '/themes/' . $shop_theme . '/assets/front/img/small-logo.png' }}">
                </a>
            </div> -->
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="{{ Request::segment(1) == '' ? 'active' : '' }}"><a href="/">HOME</a></li>
                    <li class="{{ Request::segment(1) == 'product' ? 'active' : '' }}"><a href="/product">PRODUCTS</a></li>
                    <li class="{{ Request::segment(1) == 'about' ? 'active' : '' }}"><a href="/about">COMPANY</a></li>
                    <li class="{{ Request::segment(1) == 'testimony' ? 'active' : '' }}"><a href="/testimony">TESTIMONIALS</a></li>
                    <li class="{{ Request::segment(1) == 'policy' ? 'active' : '' }}"><a href="/policy">POLICIES</a></li>
                    <li class="{{ Request::segment(1) == 'contact' ? 'active' : '' }}"><a href="/contact">CONTACT US</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    
    <!-- CONTENT -->
    <div id="scroll-to" class="clearfix">
        @yield("content")
    </div>

    <footer>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="title">INFORMATION</div>
                    <ul>
                        <li><a href="/">HOME</a></li>
                        <li><a href="/product">PRODUCT</a></li>
                        <li><a href="/about">ABOUT US</a></li>
                        <li><a href="/contact">CONTACT</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="title">CONTACT US</div>
                    <ul>
                        <li><a href="javascript:">{{ get_content($shop_theme_info, "footer", "footer_contact_number") }}</a></li>
                        <li><a href="javascript:">{{ get_content($shop_theme_info, "footer", "footer_contact_email") }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="title">FOLLOW US ON</div>
                    <div class="social-holder">
                        <div class="holder" onclick="location.href='{{ get_content($shop_theme_info, "footer", "footer_facebook_link") }}''"><img src="/themes/{{ $shop_theme }}/resources/assets/front/img/fb.png"></div>
                        <div class="holder" onclick="location.href='{{ get_content($shop_theme_info, "footer", "footer_twitter_link") }}'"><img src="/themes/{{ $shop_theme }}/resources/assets/front/img/tt.png"></div>
                        <div class="holder" onclick="location.href='{{ get_content($shop_theme_info, "footer", "footer_pinterest_link") }}'"><img src="/themes/{{ $shop_theme }}/resources/assets/front/img/pp.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    @include("frontend.gfoot")
    {{-- GLOBALS --}}
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>
    
    <!-- FB WIDGET -->
    <div id="fb-root"></div>

    @yield("script")
</body>
</html>