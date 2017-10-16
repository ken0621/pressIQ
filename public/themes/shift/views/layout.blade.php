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
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
        @include("frontend.ghead")
        <!-- GLOBAL CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
        <!-- OTHER CSS -->
        @yield("css")
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
            <div class="left-container"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span><span>yourcompany.email</span></div>
            <div class="right-container"><span style="cursor: pointer;" onClick="location.href='/members/logout'">LOGOUT</span><span style="cursor: pointer;" onClick="location.href='/members'">MY ACCOUNT</span></div>
            @else
            <div class="left-container">
                <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <span>yourcompany.email</span>
            </div>
            <div class="right-container">
                <span class="smoth-scroll" style="cursor: pointer;" onClick="location.href='/members/register'">REGISTER</span>
                <span class="smoth-scroll sign" style="cursor: pointer;" onClick="location.href='/members/login'">SIGN IN</span>
            </div>
            @endif
        </div>
    </div>
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
                    <div class="image-logo-holder">
                        <a class="clearfix" href="/"><img src="/themes/{{ $shop_theme }}/img/shift-logo.png"></a>                       
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
                            <li class="{{ Request::segment(1) == "" ? "active" : "" }}"><a class="smoth-scroll" href="/">HOME</a></li>
                            <li class="{{ Request::segment(1) == "about" ? "active" : "" }}"><a class="smoth-scroll" href="/about">COMPANY</a></li>
                            <li class="{{ Request::segment(1) == "product" ? "active" : "" }}"><a class="smoth-scroll" href="#mission-vision">PRODUCTS</a></li>
                            <li class="{{ Request::segment(1) == "contact" ? "active" : "" }}"><a class="smoth-scroll" href="#products">GET INTOUCH</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- CONTENT -->
    <div id="scroll-to" class="clearfix">
        <div class="content">
            @yield("content")
        </div>
    </div>

    <!-- FOOTER -->
    <footer id="bottom-footer">
        <div class="container">
            <div class="footer-container">
                <div class="upper row clearfix">
                    <div class="col-md-4">
                        <div class="inner-content">
                            <img src="/themes/{{ $shop_theme }}/img/footer-banner.jpg">
                        </div>
                    </div>
                     <div class="col-md-4">
                         <div class="inner-content">
                             <div class="inner-content-title">Information</div>
                             <p>FAQ</p>
                             <p>Downloadables</p>
                             <p>Get In Touch</p>
                             <p>Company</p>
                         </div>
                     </div> 
                     <div class="col-md-4">
                         <div class="inner-content">
                             <div class="inner-content-title">Contact Information</div>
                             <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. </p>
                             <p>042 0000</p>
                             <p>youremailhere@gmail.com</p>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </footer>
    
    <div class="bottom clearfix">      
        <div class="container">                     
            <div class="ftr-title">© {{ date("Y") }} SHIFT Business Corporation. All Right Reserved</div>
            <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
        </div>
    </div>

    @include("frontend.gfoot")

    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>

    <!-- FB WIDGET -->
    <div id="fb-root"></div>

    @yield("script")
    </body>
</html>
