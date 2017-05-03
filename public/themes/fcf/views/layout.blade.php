<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ ucfirst($shop_info->shop_key) }} | {{ $page }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet"> 
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
        <!-- OTHER CSS -->
        @yield("css")
        <style type="text/css">
        body
        {
            background-image: url('/themes/{{ $shop_theme  }}/img/final.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-attachment: fixed;
        }
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
    <div class="loader">
      <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>

    <!-- HEADER -->
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
                    <div class="image-logo-holder">
                        <img src="/themes/{{ $shop_theme }}/img/company-logo.png">                       
                    </div>
                </div>
                <div class="col-md-10">
                <!-- NAVIGATION -->
                    <nav>
                        <a href="/" class="head-button link-nav">HOME</a>
                        <a href="/about" class="head-button link-nav">COMPANY PROFILE</a>
                        <a href="/runruno" class="head-button link-nav">RUNRUNO</a>
                        <a href="/news" class="head-button link-nav">NEWS</a>
                        <a href="/contactus" class="head-button link-nav">CONTACT US</a>
                    </nav>
                </div>
                
            </div>
        </div>

    </div>
    <!-- NEWS DROPDOWN -->
<!--     <div class="news-dropdown">
        <div class="row clearfix">
            <div class="col-md-3">
                <div class="news-per-container">
                    <div class="dropdown-img-container"><img src="/themes/{{ $shop_theme }}/img/d1.png"></div>
                    <div class="news-title-container">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="news-per-container">
                    <div class="dropdown-img-container"><img src="/themes/{{ $shop_theme }}/img/d2.png"></div>
                    <div class="news-title-container">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="news-per-container">
                    <div class="dropdown-img-container"><img src="/themes/{{ $shop_theme }}/img/d3.png"></div>
                    <div class="news-title-container">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="news-per-container">
                    <div class="dropdown-img-container"><img src="/themes/{{ $shop_theme }}/img/d4.png"></div>
                    <div class="news-title-container">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </div>
                </div>
            </div>
        </div>
    </div>     -->
    <!-- CONTENT -->
    <div id="scroll-to" class="clearfix">
	   @yield("content")
    </div>

    <!-- FOOTER -->
  	<footer>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="footer-img-container">
                        <img src="/themes/{{ $shop_theme }}/img/footer-img.png">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="navigation-container">
                        <div class="navigation-title-container">
                            NAVIGATION
                        </div>
                        <div class="navigation-btn-container">
                            <p><span>HOME</span></p>
                            <p><span>COMPANY PROFILE</span></p>
                            <p><span>RUNRUNO</span></p>
                            <p><span>NEWS</span></p>
                            <p><span>CONTACT US</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="navigation-container">
                        <div class="navigation-title-container">
                            CONTACT INFORMATION
                        </div>
                        <div class="ftr-contact-container">
                            <p>Address: 22nd Floor, Salcedo Towers, 169 H.V. Dela Costa Street, Salcedo Village, Makati City, Metro Manila, Philippines<br><br>
    
Phone: +63 (0) 2 659 5662<br> 
Fax: +63 (0) 2 846 8507
</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 	</footer>

    <footer id="bottom-footer">
        <div class="container bottom">
            <div class="row clearfix">
                <div class="col-md-12">                            
                    <div class="ftr-title">Copyright 2017 FCF Minerals | Powered By : DIGIMA Web Solutions, Inc.</div>
                </div>
            </div>
        </div>
    </footer>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/global.js"></script>
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    @yield("js")
    </body>
</html>
