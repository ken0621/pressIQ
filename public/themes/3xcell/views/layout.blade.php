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
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">  
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
        <!-- PARALLAX -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/parallax.css">
        
        <!-- LIGHTBOX -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/lightbox/css/lightbox.css">

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
    <div class="subheader-container">
        <div class="container" style="position: relative;">
           <div class="button-container">
                <div class="social-media-container">
                    <span>
                        <i class="fa fa-facebook-square" aria-hidden="true"></i>
                    </span>
                    <span>
                        <i class="fa fa-twitter-square" aria-hidden="true"></i>
                    </span>
                    <span>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </span>
                    <span>
                        <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                    </span>
                </div> 
                @if($customer_info_a)
               <div class="login-container">
                   <div class="login-button">
                       <span>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i></span><span>&nbsp;<a href="/mlm">MY ACCOUNT</a></span>
                   </div>
               </div>
               @else
                <div class="login-container">
                   <div class="login-button">
                       <span>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i></span><span>&nbsp;<a href="/mlm/login">LOGIN</a></span>
                   </div>
               </div>
               @endif
               <div class="join-us-container">
                   <a href="/mlm/register">
                       <div class="join-us-button">
                           <img src="/themes/{{ $shop_theme }}/img/button-icon1.png"><span>&nbsp;&nbsp;JOIN US TODAY</span>
                       </div>
                   </a>
               </div>
           </div>
        </div>
    </div>
    <div class="header-container">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-2">
                    <div class="image-logo-holder">
                        <a class="clearfix" href="/"><img src="/themes/{{ $shop_theme }}/img/company-logo.png"></a>    
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
                        <ul>
                            <li><a href="/" class="head-button link-nav {{ Request::segment(1) == '' ? 'active' : '' }}" id="home">HOME</a></li>
                            <li class="product-hover">
                                <a class="head-button link-nav">PRODUCTS</a>
                                <!-- PRODUCT DROPDOWN -->
                                <div class="product-dropdown" style="display: none;">
                                    @if(count($_categories) > 0)
                                        @foreach($_categories as $categories)
                                        <div class="cat-container">
                                            <a href="/product">
                                                <div class="per-cat">
                                                    <div class="cat-img-container"><img style="width: 124px; height: 100px; object-fit: cover;" src="{{ $categories["type_image"] }}"></div>
                                                    <div class="cat-name">{{ $categories["type_name"] }}</div>
                                                </div>
                                            </a>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="cat-container">
                                            <a href="/product">
                                                <div class="per-cat">
                                                    <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/beauty-prod.png"></div>
                                                    <div class="cat-name">BEAUTY SKIN CARE</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="cat-container">
                                            <a href="/product">
                                                <div class="per-cat">
                                                    <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/supplement.png"></div>
                                                    <div class="cat-name">FOOD SUPPLEMENT</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="cat-container">
                                            <a href="/product">
                                                <div class="per-cat">
                                                    <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/healthy-drinks.png"></div>
                                                    <div class="cat-name">HEALTHY DRINKS</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="cat-container">
                                            <a href="/product">
                                                <div class="per-cat">
                                                    <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/p-a.png"></div>
                                                    <div class="cat-name">HEALTHY PACKAGES</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="cat-container">
                                            <a href="/product">
                                                <div class="per-cat">
                                                    <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/p-b.png"></div>
                                                    <div class="cat-name">RETAIL PACKAGES</div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </li>
                            <li><a href="/promos" class="head-button link-nav">PROMOS</a></li>
                            <li class="company-hover">
                                <a class="head-button link-nav">COMPANY</a>
                                <!-- COMPANY DROPDOWN -->
                                <div class="company-dropdown" style="display: none;">
                                    <a href="/history">
                                        <div class="cat-container">
                                            <div class="per-cat">
                                                <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/history-thumb.png"></div>
                                                <div class="cat-name">OUR HISTORY</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/how_to_join">
                                        <div class="cat-container">
                                            <div class="per-cat">
                                                <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/how-to-join-thumb.png"></div>
                                                <div class="cat-name">HOW TO JOIN</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/company_events">
                                        <div class="cat-container">
                                            <div class="per-cat">
                                                <div class="cat-img-container"><img src="/themes/{{ $shop_theme }}/img/events-calendar-thumb.png"></div>
                                                <div class="cat-name">COMPANY EVENTS</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li><a href="/gallery" class="head-button link-nav">GALLERY</a></li>
                            <li><a href="/contact" class="head-button link-nav">CONTACT US</a></li>
                            <li class="cart-hover">
                                <a class="link-nav"><span><img class="cart-header" src="/themes/{{ $shop_theme }}/img/cart-header.png"></span></a>
                                <!-- CART DROPDOWN -->
                                <div class="cart-dropdown" style="display: none;">
                                    
                                </div>
                            </li>
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
            <div class="upper row clearfix">
                <div class="col-md-4">
                    <div class="footer-img-container">
                        <img src="/themes/{{ $shop_theme }}/img/footer-img.png">
                        <p>
                            3xcell-E Sales & Marketing Inc. is composed of five dynamic individuals who share the same motivation and common values strengthened and lead by their principal incorporator.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="upper-mid">
                        <div class="upper-mid-title">INFORMATION</div>
                        <div class="upper-mid-link-container">
                            <div class="upper-mid-link">HOME</div>
                            <div class="upper-mid-link">PRODUCTS</div>
                            <div class="upper-mid-link">OPPORTUNITY</div>
                            <div class="upper-mid-link">GALLERY</div>
                            <div class="upper-mid-link">CONTACT US</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="upper-right">
                        <div class="upper-mid-title">CONTACT US TODAY</div>
                        <div class="upper-mid-title-2">PRINCIPAL OFFICE 2</div>
                        <div class="upper-mid-link">
                            <p>
                                Vicar's Bldg. #31 Visayas Avenue Corner Road 1 Vasra, 
                                Quezon City
                            </p>
                        </div>
                        <div class="upper-mid-title-2">GENSAN BRANCH OFFICE</div>
                        <div class="upper-mid-link">
                            <p>
                                Door #2 Perla Compania de Seguros Bldg.
                                Jp. Laurel East, Corner Sampaguita Street,
                                General Santos City 
                            </p>
                        </div>
                        <div class="upper-mid-title-2"><span><img src="/themes/{{ $shop_theme }}/img/footer-mail.png"></span><span>sales@3xcell.com</span></div>
                        <div class="upper-mid-title-2"><span><img src="/themes/{{ $shop_theme }}/img/footer-phone.png"></span><span>+63 2 518 8637</span></div>
                    </div>
                </div>
            </div>
            <div class="bottom">                           
                <div class="ftr-title">© 2017 3XCELL E-SALES & MARKETING, INC. All Rights Reserved.</div>
                <div class="ftr-title-2">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
            </div>
        </div>
    </footer>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    {{-- GLOBALS --}}
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript">
    var cart_load = ".cart-dropdown";
    var input_qty = ".input-quantity";
    var rawprice = ".raw-price";
    var subtotal = ".sub-total";
    var total = ".total";
    var button_checkout = ".button-checkout";
    var remove_product = ".remove-item-from-cart";
    var product_container = ".per-item-container";
    </script>
    <script type="text/javascript" src="/assets/front/js/globalv2.js"></script>
    {{-- GLOBALS --}}
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/figuesslider.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/parallax.js"></script>

    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/lightbox/js/lightbox.js"></script>

    <!-- FB WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script type="text/javascript">
        $window = $(window);
        $window.scroll(function() {
          $scroll_position = $window.scrollTop();
            if ($scroll_position > 32.2167) { 
                $('.header-container').addClass('header-fixed');
                $('.subheader-container').addClass('header-fixed');

                header_height = $('.your-header').innerHeight();
                $('body').css('padding-top' , header_height);
            } else {
                $('body').css('padding-top' , '0');
                $('.header-container').removeClass('header-fixed');
                $('.subheader-container').removeClass('header-fixed');
            }
         });

    </script>

    <script type="text/javascript">
            
            $('.slider3').diyslider({
                width: "580px", // width of the slider
                height: "120px", // height of the slider
                display: 5, // number of slides you want it to display at once
                loop: false // disable looping on slides
                }); // this is all you need!

        // use buttons to change slide
        $('#gotoleft').bind("click", function(){
            // Go to the previous slide
            $('.slider3').diyslider("move", "back");
        });
        $('#gotoright').unbind("click")
        $('#gotoright').bind("click", function(){
            // Go to the previous slide
            $('.slider3').diyslider("move", "forth");
        });

        /*PRODUCT HOVER TOGGLE*/

        $('.product-hover').hover(function()
        {
            $('.product-dropdown').stop();
            $('.product-dropdown').fadeIn(400);
        },
        function()
        {
            $('.product-dropdown').stop();
            $('.product-dropdown').fadeOut(400);
        });

        $('.company-hover').hover(function()
        {
            $('.company-dropdown').stop();
            $('.company-dropdown').fadeIn(400);
        },
        function()
        {
            $('.company-dropdown').stop();
            $('.company-dropdown').fadeOut(400);
        });

        $('.cart-hover').hover(function()
        {
            $('.cart-dropdown').stop();
            $('.cart-dropdown').fadeIn(400);
        },
        function()
        {
            $('.cart-dropdown').stop();
            $('.cart-dropdown').fadeOut(400);
        });

    </script>

    @yield("js")
    </body>
</html>
