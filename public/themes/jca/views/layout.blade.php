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
        <link rel="icon" href="/themes/{{ $shop_theme }}/img/jca-icon.png"" type="image/png"/>

        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">   
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
    <div id="home" class="subheader-container">
        <div class="container">
            @if($customer)
            <div class="left-container"><span><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                @if(!$mlm_member)
                    <span>BECOME A MEMBER</span>
                @endif
            </div>
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
                            @elseif(Request::segment(1)=="terms_and_conditions")
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
                    <!-- <div class="col-md-2">
                        <div class="jca-footer-title-container">
                            <p class="footer-title">Quick Links</p>
                        </div>
                        <div class="jca-footer-details-container">
                            <a href="javascript:">
                                <p class="footer-detail-list">Dealer’s Policy</p>
                            </a>
                            <a href="javascript:">
                                <p class="footer-detail-list">Disclaimer</p>
                            </a>
                            <a href="javascript:">
                               <p class="footer-detail-list">Terms & Condition</p> 
                            </a>
                            <a href="javascript:">
                                <p class="footer-detail-list">Privacy Policy</p>
                            </a>
                            <a href="javascript:">
                                <p class="footer-detail-list">Product Policy</p>
                            </a>
                        </div>
                    </div> -->
                    <div class="col-md-4">
                        <div class="jca-footer-title-container">
                            <p class="footer-title">Overview</p>
                        </div>
                        <div class="jca-footer-details-container">

                            <a href="/themes/{{ $shop_theme }}/img/overview/marketing-plan.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Marketing Plan</p>
                            </a>
                            
                            <a href="/themes/{{ $shop_theme }}/img/overview/packages.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Packages</p>
                            </a>
                            
                            <a href="/themes/{{ $shop_theme }}/img/overview/product-packages.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Product Packages</p>
                            </a>

                            <a href="/themes/{{ $shop_theme }}/img/overview/product-packages-2.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Product Packages (8,000 Standard Package)</p>
                            </a>

                            <a href="/themes/{{ $shop_theme }}/img/overview/direct-selling.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Direct Selling</p>
                            </a>
                            
                            <a href="/themes/{{ $shop_theme }}/img/overview/sales-commission.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Sales Commission</p>
                            </a>

                            <a href="/themes/{{ $shop_theme }}/img/overview/overide-sales-comission.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Overide Sales Commission</p>
                            </a>

                            <a href="/terms_and_conditions"> 
                                <p class="footer-detail-list">General Terms and Conditions</p>
                            </a>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="jca-footer-title-container">
                            <p class="footer-title">Product Portfolio</p>
                        </div>
                        <div class="jca-footer-details-container">
                            <a href="/themes/{{ $shop_theme }}/img/product-portfolio/p-serum.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Swiss Apple Stem Cell Serum</p>
                            </a>
                            <a href="/themes/{{ $shop_theme }}/img/product-portfolio/p-soap.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Swiss Apple Stem Cell Soap with Glutathione and Collagen</p>
                            </a>
                            <a href="/themes/{{ $shop_theme }}/img/product-portfolio/p-services.jpg" class="lsb-preview"> 
                                <p class="footer-detail-list">Stem Cell Therapy- The Anti-Aging and Rejuvenation Therapy</p>
                            </a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </footer>
    <div class="container">
        <div class="bottom">                           
            <div class="ftr-title">© JCA Wellness International Corp. All Right Reserved</div>
            <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
        </div>
    </div>
    
    @include("frontend.gfoot")
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script>

    @yield("script")
    <script> 
      $(window).load(function() { 
        $.fn.lightspeedBox(); 
      }); 
    </script> 
    </body>
</html>
