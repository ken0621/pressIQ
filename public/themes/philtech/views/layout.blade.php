<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ ucfirst($shop_info->shop_key) }} |  {{ isset($page) ? $page : 'Home' }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name='B-verify' content='8b63efb2920a681d6f877a59a414659d09831140' />
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">
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
        <!-- Brown Custom Icon -->
        <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/brown-icon/styles.css">
        <!-- THEME COLOR -->
        <link href="/themes/{{ $shop_theme }}/css/{{ $shop_theme_color }}.css" rel="stylesheet" type="text/css">
        <!-- OTHER CSS -->
        @yield("css")
        <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
    <div class="loader" style="display: none;">
      <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- HEADER -->
    <div class="header-nav clearfix">
        <div class="header-nav-top">
            <div class="container">
                <div class="holder"><a href="javascript:">COMPANY</a></div>
                <div class="holder"><a href="javascript:">BUSINESS PRESENTATION</a></div>
                <div class="holder"><a href="javascript:">NEWS</a></div>

                @if($customer)
                <div class="holder"><a href="/members">MY ACCOUNT</a></div>
                <div class="holder"><div class="linya"></div></div>
                <div class="holder"><a href="/members/logout">LOGOUT</a></div>
                @else
                <div class="holder"><a href="/members/login">LOGIN</a></div>
                <div class="holder"><div class="linya"></div></div>
                <div class="holder"><a href="/members/register">REGISTER</a></div>
                @endif

            </div>
        </div>
        <div class="header-nav-middle">
            <div class="container">
                <div class="clearfix">
                    <div class="logo-holder">
                        <img onClick="location.href='/'" style="cursor: pointer;" class="img-responsive logo" src="/themes/{{ $shop_theme }}/img/logo.png">            
                    </div>
                    <div class="search-bar-holder">

                        {{-- Search Bar --}}                          
                        <div class="search-bar">
                            <form action="/product_search" method="get" id="form-search">
                                <div class="input-group">
                                     <input type="text" class="form-control" name="keyword" id="keyword" aria-describedby="sizing-addon1" placeholder="Type the item you're looking for...">
                                     <span class="input-group-addon search-button" id="sizing-addon1">
                                        <a href="" onclick="onSearch();" id="submit_link"><img src="/themes/{{ $shop_theme }}/img/search-icon.png"></a>                          
                                     </span>
                                </div>
                            </form>
                        </div>
                        {{-- End Search Bar --}}

                    </div>
                    <div class="woaw">
                        <div class="holder">
                            <img src="/themes/{{ $shop_theme }}/img/header/cashback.png">
                        </div>
                        <div class="holder">
                            <img src="/themes/{{ $shop_theme }}/img/header/delivery.png">
                        </div>
                        <div class="holder">
                            <img src="/themes/{{ $shop_theme }}/img/header/card.png">
                        </div>
                        <div class="shopping-cart-container">
                            <div class="shopping-cart"><img src="/themes/{{ $shop_theme }}/img/header/cart-icon.png"> <span class="badge mini-cart-quantity">{{ $global_cart['sale_information']['total_quantity'] }}</span> <span>P </span> <span class="mini-cart-total-price">{{ number_format($global_cart['sale_information']['total_product_price'], 2) }}</span></div>
                            <div class="container-cart mini-cart">
                                <div class="text-center"><span class="cart-loader text-center"><img style="height: 50px; margin: auto;" src="/assets/front/img/loader.gif"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- NAVIGATION -->
    <nav class="navbar navbar-default">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <style type="text/css">
        @media screen and (min-width: 991px)
        {
            .navbar-nav a
            {
                font-size: 12px !important;
            }
        }
        </style>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="nav-border {{ Request::segment(1) == '' ? 'active' : '' }}"><a href="/">HOME</a></li>
            <li class="nav-border {{ Request::segment(1) == 'partners' ? 'active' : '' }}"><a href="/partners">OUR PARTNERS</a></li>
            <li class="nav-border"><a href="https://loadcentral.net">ELOADING BUSINESS</a></li>
            <li class="nav-border"><a href="http://tour.philtechglobalinc.com">AIRLINE TICKETING</a></li>
            <li class="nav-border"><a href="http://202.54.157.7/PhilTechInc/BKWLTOlogin.aspx">TRAVEL AND TOURS</a></li> 
            <li class="nav-border"><a href="https://philtechglobalinc.vmoney.com">E-MONEY</a></li>
            <li class="nav-border"><a href="javascript:" onClick="alert('Under Development');">CAREER</a></li>
            <li class="nav-border"><a href="javascript:" onClick="alert('Under Development');">EVENTS</a></li>
            <li class="nav-border {{ Request::segment(1) == 'legalities' ? 'active' : '' }}"><a href="/legalities">LEGALITIES</a></li>
            <li class="nav-border {{ Request::segment(1) == 'contact' ? 'active' : '' }}"><a href="/contact">CONTACT US</a></li> 
            
            {{-- @if(isset($_categories))
                @foreach($_categories as $category)     
                <li class="nav-border {{ Request::input('type') == $category['type_id'] ? 'active' : '' }}"><a href="/product?type={{ $category['type_id'] }}" style="text-transform: uppercase;">{{ $category['type_name'] }}</a></li>
                @endforeach
            @endif --}}
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <div id="scroll-to" class="clearfix">
       @yield("content")
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container ftr">
            <div class="row clearfix">
                <div class="col-md-4 col-sm-6">
                    <div class="img-footer">
                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/philtech.jpg">
                    </div>
                    <p>PHILTECH, INC. “We provide Business” Is a subsidiary company of ZENAR TELECOMS, INC. with highly experienced both in retail and distribution of technology industry for almost 20years. PHILTE... <a style="color: #fff" href="/about">See more</a></p>
                </div> 
                <div class="col-md-2 col-sm-6">
                    <div class="btm-title">INFORMATION</div>
                    <ul>
                        <li class="{{ Request::segment(1) == 'partners' ? 'active' : '' }}"><a href="/partners">Our Partners</a></li>
                        <li><a href="https://loadcentral.net">E-loading Business</a></li>
                        <li><a href="http://tour.philtechglobalinc.com">Airline Ticketing</a></li>
                        <li><a href="http://202.54.157.7/PhilTechInc/BKWLTOlogin.aspx">Travel and Tours</a></li>
                        <li><a href="https://philtechglobalinc.vmoney.com/">E-money</a></li>
                        <li><a href="javascript:" onClick="alert('Under Development');">Career</a></li>
                        <li><a href="javascript:" onClick="alert('Under Development');">Events</a></li>
                        <li class="{{ Request::segment(1) == 'legalities' ? 'active' : '' }}"><a href="/legalities">Legalities</a></li>
                        <li><a href="https://drive.google.com/file/d/0B9C_Tfe9UZCmemJFeXA3dWRyYjVKOVY1MlVkUlNiWlVDang4/view">Business Presentation</a></li>
                        <li><a href="javascript:" onClick="alert('Under Development');">News</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="btm-title">SHOP</div>
                    <ul>
                        <li><a href="javascript:">DTH Products</a></li>
                        <li><a href="javascript:">Prepaid Cards</a></li>
                        <li><a href="javascript:">Gadgets</a></li>
                        <li><a href="javascript:">Electronics</a></li>
                        <li><a href="javascript:">Services</a></li>
                        <li><a href="javascript:">Entertainment</a></li>
                        <li><a href="javascript:">Apparel</a></li>
                        <li><a href="javascript:">Accessories</a></li>
                        <li><a href="javascript:">Health & Wellness</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="btm-title">CONTACT US</div>
                    <table>
                        <tr>
                            <td><img src="/themes/{{ $shop_theme }}/img/icon/location.png"></td>
                            <td>PhilTECH Building, Gallera Road, Paseo de</br>Putik, Guiwan, Zamboanga City, Philippines</td>
                        </tr>
                        <tr>
                            <td><img src="/themes/{{ $shop_theme }}/img/icon/phone.png"></td>
                            <td>Tel No. (062) 310-2256, Cel No. 0917-542- 2614</br>Tel No. (062) 310-2256, Cel No. 0917-542- 2614</td>
                        </tr>
                        <tr>
                            <td><img src="/themes/{{ $shop_theme }}/img/icon/email.png"></td>
                            <td>philtechglobal@yahoo.com</br>philtechglobalmainoffice@gmail.com</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </footer>

    <footer id="bottom-footer">
        <div class="container bottom">
            <div class="clearfix">                
                <div class="ftr-title pull-left">© {{ isset($company_info['company_name']) ? $company_info['company_name']->value : 'Your Name' }} {{ date('Y') }}</div>
                <div class="ftr-title pull-right">Powered By: Digima Web Solutions, Inc.</div>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div id="shopping_cart" class="modal fade global-modal shopping-cart-modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          
        </div>
      </div>
    </div>

    <div id="global_modal" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content modal-content-global clearfix">
            </div>
        </div>
    </div>
    <div class="multiple_global_modal_container"></div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/fit-text.js"></script>
    <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/jquery.keep-ratio.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/global.js"></script>
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/assets/front/js/global_function.js"></script>
    @yield("js")
    </body>

<script type="text/javascript">
    
    function onSearch()
    {
        var keyword = $('#keyword').val();
        $("#submit_link").attr("href", "/product_search?keyword="+$('#keyword').val());
    }

</script>
    
</html>
