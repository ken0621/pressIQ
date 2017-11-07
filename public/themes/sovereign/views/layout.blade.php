<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ ucfirst($shop_info->shop_key) }} | {{ $page or '' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600|Source+Sans+Pro:400,600,700" rel="stylesheet">
    <!-- GLOBAL CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/global.css">
    @include("frontend.ghead")
    <!-- OTHER CSS -->
    @yield("css")
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body>
    <div class="loader hide">
        <span><img src="/resources/assets/frontend/img/loader.gif"></span>
    </div>
    
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- HEADER -->
    <div class="header-nav">
        <div class="header-nav-top">
            <div class="container clearfix">
                <div class="pull-left">
                    <div class="nav-holder {{ Request::segment(1) == "" ? "active" : "" }}"><a href="/">HOME</a></div>
                    <div class="nav-holder">
                        <a class="show-product" href="javascript:">PRODUCTS</a>
                        <div class="product-container">
                            <div class="title">A Real Product Need</div>
                            <div class="list-product">
                                @foreach($global_product as $product)
                                <div style="cursor: pointer;" onClick="location.href='/product/view/{{ $product['eprod_id'] }}'">
                                    <div class="holder">
                                        <img class="img-responsive 4-3-ratio" src="{{ get_product_first_image($product) }}">
                                        <div class="name">{{ get_product_first_name($product) }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="nav-holder {{ Request::segment(1) == "about" ? "active" : "" }}"><a href="/about">COMPANY</a></div>
                    <div class="nav-holder {{ Request::segment(1) == "contact" ? "active" : "" }}"><a href="/contact">CONTACT US</a></div>
                </div>
                <div class="pull-right">
                    <div class="color-overlay"></div>
                    <div class="menu-container">
                        @if($customer)
                            <div class="menu-holder">
                                <a class="" href="/members/logout"><img src="/themes/{{ $shop_theme }}/img/key.png"> LOGOUT</a>
                            </div>
                            <div class="menu-holder">
                                <a class="" href="/members"><img src="/themes/{{ $shop_theme }}/img/link.png"> MY ACCOUNT</a></a>
                            </div>
                        @else
                            <div class="menu-holder">
                                <a class="" href="/members/login"><img src="/themes/{{ $shop_theme }}/img/key.png"> LOGIN</a>
                            </div>
                            <div class="menu-holder">
                                <a class="" href="/members/register"><img src="/themes/{{ $shop_theme }}/img/link.png"> JOIN US TODAY</a></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="header-nav-middle">
            <div class="container clearfix">
                <div class="pull-left">
                    <div class="logo">
                        <img class="img-responsive" src="/themes/{{ $shop_theme }}/img/logo.jpg">
                    </div>
                </div>
                <div class="pull-right">
                    <div class="info">
                        <div class="holder">
                            <div class="icon">
                                <img src="/themes/{{ $shop_theme }}/img/phone-icon.png">
                            </div>
                            <div class="text">
                                <div class="text-label">CALL US TODAY</div>
                                <div class="text-value">+852 9472 6184</div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="holder">
                            <div class="icon">
                                <img src="/themes/{{ $shop_theme }}/img/mail-icon.png">
                            </div>
                            <div class="text">
                                <div class="text-label">EMAIL US TODAY</div>
                                <div class="text-value">{{ $company_info["company_email"]->value }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="scroll-to" class="clearfix">
        @yield("content")
    </div>
    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="col-md-4">
                <h2>INFORMATION</h2>
                <ul>
                    <li><a href="javascript:">HOME</a></li>
                    <li><a href="javascript:">PRODUCTS</a></li>
                    <li><a href="javascript:">MARKETING PLAN</a></li>
                    <li><a href="javascript:">ABOUT US</a></li>
                    <li><a href="javascript:">CONTACT US</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2>CONTACT US</h2>
                <ul>
                    <li>Tel No. (+852) 9472 6184 (+852) 9145 7698</li>
                    <li>EMAIL: {{ $company_info["company_email"]->value }}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="text-center">FOLLOW US ON</h2>
                <div class="social-icon">
                    <div class="holder">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </div>
                    <div class="holder">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </div>
                    <div class="holder">
                        <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="sub-footer">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="nav">Terms & Condition</div>
                    <div class="nav">API Use Policy</div>
                    <div class="nav">Privacy Policy</div>
                    <div class="nav">Cookies</div>
                </div>
                <div class="col-md-6">
                    <div class="copyright">© 2015 - 2016 Sovereign World Corporation. All Rights Reserved</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="shopping_cart" class="modal fade global-modal shopping-cart-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                
            </div>
        </div>
    </div>

    @include("frontend.gfoot")
    <script type="text/javascript" src="/assets/slick/slick.min.js"></script>
    <script type="text/javascript" src="/assets/front/js/global.js"></script>
    <script src="/themes/{{ $shop_theme }}/js/global.js"></script>
    <script type="text/javascript" src="/assets/member/global.js"></script>

    <script type="text/javascript">
    function submit_done(data)
    {
        if (data.from == "login") 
        {
            if(data.type == 'error')
            {
                toastr.error(data.message);
            }
            else
            {
                toastr.success(data.message);
                location.href = '/mlm';
            }
        }
        else
        {
            $('.butonn_register').prop("disabled", false);
            if(data.type == 'error')
            {
                toastr.error(data.message);
                $('.butonn_register').attr("disabled", false);
                $('.butonn_register').removeAttr("disabled");
            }
            else
            {
                $('.butonn_register').attr("disabled", true);
                toastr.success(data.message);
                location.href = '/mlm';
            }
        }
    }
    function click_submit_button(ito)
    {
        $('.global-submit').submit();
        $('.butonn_register').attr("disabled", true);
    }
    function get_sponsor_info_via_membership_code(ito)
    {
        var membership_code = $(ito).val();
        get_customer_view(membership_code);
    }
    function get_customer_view(membership_code)
    {
        $('#sponsor_info_get').load('/mlm/register/get/membership_code/' + membership_code);
    }
    </script>
    @yield("script")
    </body>
</html>
