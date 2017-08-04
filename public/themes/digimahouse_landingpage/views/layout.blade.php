<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Parallax backgrounds with centered content">
        <title>{{ ucfirst($shop_info->shop_key) }} | {{ $page }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700" rel="stylesheet">
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
        {{-- Parallax --}}
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/parallax.css">
        <!-- THEME COLOR -->
        <link href="/themes/{{ $shop_theme }}/css/{{ $shop_theme_color }}.css" rel="stylesheet" type="text/css">
        <!-- OTHER CSS -->
        @yield("css")
        <style type="text/css">
        body
        {
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
    <div class="loader hide">
      <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>

    <!-- HEADER -->
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
                    <div class="image-logo-holder">
                        <a class="clearfix" href="/"><img src="/themes/{{ $shop_theme }}/img/digimahouse-logo.png"></a>    
                        <div class="menu-nav">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                    </div>
                </div>
                <div class="col-md-10">
                <!-- NAVIGATION -->
                    <nav class="navirino">
                        <a href="/" class="head-button {{ Request::segment(1) == '' ? '' : '' }}" id="business-plan">Business Plan</a>
                        <a href="/#" class="head-button {{ Request::segment(1) == 'support' ? 'active' : '' }}" id="support">Support</a>
                        <a href="#" role="button" class="head-button btn-signin" id="signin">Sign In</a>
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
    <footer>
        <div class="container">

            <div class="row clearfix">

                <div class="col-md-3">
                    <div class="text-header">Featured Corporate Products</div>
                    <div><a href="#">MLM Systems</a></div>
                    <div><a href="#">E-Commerce Website</a></div>
                    <div><a href="#">Inventory Solutions</a></div>
                    <div><a href="#">Accounting Solutions</a></div>
                    <div><a href="#">POS Solutions</a></div>
                    <div><a href="#">Payroll Solutions</a></div>
                    <div><a href="#">Email Solutions</a></div>
                    <div><a href="#">SMS Solutions</a></div>
                    <div><a href="#">Logo Branding</a></div>
                    <div><a href="#">Loyalty and Rewards System</a></div>
                    <div><a href="#">Mobile App Development</a></div>
                </div>

                <div class="col-md-3">
                    <div class="text-header">Contact Us</div>
                    <div><a href="#">Phone: 215-0757</a></div>
                    <div><a href="#">Mobile: 0917-813-0244<br><span style="padding-left: 45px;">0929-198-1948</span></a></div>

                    <div><a href="#">Email: sales@digimaweb.solutions</a></div>
                </div>

                <div class="col-md-3">
                    <div class="text-header">Newsletter</div>
                    <div><a href="#">Receive special offers and be the<br>first to know when the new products<br>are to be released.</a></div>
                    <input type="text">
                </div>

                <div class="col-md-3">
                    <div class="text-header">Newsletter</div>
                    <div><a href="#">Like us on our official<br>Facebook Page and<br>follow for our trends</a></div>
                    <a href="#" class="like-us"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                </div>

            </div>
        </div>
    </footer>

    <div id="bottom">
        <div class="container" style="border-top: 1px solid #c6c6c6; padding-top: 10px;">
            <div class="row clearfix">

                <div class="col-md-6">
                    © 2017 Digima Web Solutions. All rights reserved. Terms and conditions,<br>features, support, pricing, and service options subject to change without notice.
                </div>

                <div class="col-md-6 right">
                    
                    <div>Powered by:</div>
                    <div class="row clearfix">
                        <div class="col-md-2"><img src="/themes/{{ $shop_theme }}/img/adobe-logo.png"></div>
                        <div class="col-md-2"><img src="/themes/{{ $shop_theme }}/img/bootstrap-logo.png"></div>
                        <div class="col-md-2"><img src="/themes/{{ $shop_theme }}/img/jquery-logo.png"></div>
                        <div class="col-md-2"><img src="/themes/{{ $shop_theme }}/img/laravel-logo.png"></div>
                        <div class="col-md-2"><img src="/themes/{{ $shop_theme }}/img/php-logo.png"></div>
                        <div class="col-md-2"><img src="/themes/{{ $shop_theme }}/img/mysql-logo.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/global.js"></script>
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/figuesslider.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/parallax.js"></script>

    <script type="text/javascript">

        var dropdown = new dropdown();

        function dropdown()
        {
            init();

            function init()
            {
                event_toggle_nav();
            }

            function event_toggle_nav()
            {
                $(".menu-nav").bind("click", function()
                {
                    action_toggle_nav();
                });
            }

            function action_toggle_nav()
            {
                $(".menu-nav").unbind("click");
                $(".navirino").slideToggle(400, function()
                {
                    event_toggle_nav();
                });
            }
        }
    </script>

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

    @yield("js")
    </body>
</html>
