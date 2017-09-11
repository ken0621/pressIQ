<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Brown</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap.min.css">
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/main.css">
        <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <!-- EXTERNAL CSS -->  
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick-theme.css">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        @yield("css")
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    {{-- HEADER --}}
    <header>
        <div class="header-top">
            <div class="container">
                <a class="holder">GET THE APP</a>
                <a class="holder">COMPANY</a>
                <a class="holder" href="/members">JOIN THE MOVEMENT</a>
                <a class="holder" href="/members">LOGIN</a>
            </div>
        </div>
        <div class="header-middle clearfix">
            <div class="container">
                <div class="logo">
                    <img src="/themes/{{ $shop_theme }}/img/logo.png">
                </div>
                <div class="search">
                    <div class="holder">
                        <input class="form-control" type="text" name="">
                        <img class="search-icon" src="/themes/{{ $shop_theme }}/img/search.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <nav class="navbar">
              <div class="container">
                <ul class="nav navbar-nav">
                  <li class="active"><a href="#">Brown</a></li>
                  <li><a href="#">Phone Accessories</a></li>
                  <li><a href="#">Internet Of Things</a></li>
                  <li><a href="#">Health Technology</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a class="cart-holder" href="#"><img src="/themes/{{ $shop_theme }}/img/cart.png"> <span>Cart (0 items)</span></a></li>
                </ul>
              </div>
            </nav>
        </div>
    </header>
    {{-- END HEADER --}}

    @yield("content")

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-3 col-sm-6">
                    <div class="holder">
                        <div class="title">Exclusive Offer</div>
                        <div class="desc">Subscribe to brown&proud Newsletter</div>
                        <input class="form-control" type="form-control" name="" placeholder="Your Email Address">
                        <div class="app">
                            <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/download-app.png">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="holder">
                        <div class="title">Customer Care</div>
                        <ul>
                            <li><a href="javascript:">Help Center</a></li>
                            <li><a href="javascript:">Payment</a></li>
                            <li><a href="javascript:">How to Buy</a></li>
                            <li><a href="javascript:">Shipping and Delivery</a></li>
                            <li><a href="javascript:">Questions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="holder">
                        <div class="title">Brown&Proud</div>
                        <ul>
                            <li><a href="javascript:">About Us</a></li>
                            <li><a href="javascript:">Contact Us</a></li>
                            <li><a href="javascript:">Terms and Conditions</a></li>
                            <li><a href="javascript:">Privacy Policy</a></li>
                            <li><a href="javascript:">Store Directory</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="holder">
                        <div class="title">Get Intouch With Us</div>
                        <div class="social-logo">
                            <a class="holder"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a class="holder"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a class="holder"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-bottom">
        <div class="container">
            <div class="clearfix">
                <div class="payment-method">
                    <div class="title">Payment Methods</div>
                    <div class="payment-container">
                        <div class="holder"><img src="/themes/{{ $shop_theme }}/img/cod.png"></div>
                        <div class="holder"><img src="/themes/{{ $shop_theme }}/img/paymaya.png"></div>
                    </div>
                </div>
                <div class="delivery-services">
                    <div class="title">Delivery Services</div>
                    <div class="payment-container">
                        <div class="holder"><img src="/themes/{{ $shop_theme }}/img/delivery-services.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="clearfix">
                <div class="copy">&copy; 2017 BROWN&PROUD. All Right Reserved.</div>
                <div class="power">Powered By: DIGIMA WEB SOLUTIONS, Inc.</div>
            </div>
        </div>
    </div>
    {{-- END FOOTER --}}

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/main.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/front/js/match-height.js"></script>
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/global.js"></script>

    <script type="text/javascript">
      $(".date-picker").datepicker({
        dateFormat:"yy-mm-dd"
      });
    </script>
    @yield("script")
    </body>
</html>
