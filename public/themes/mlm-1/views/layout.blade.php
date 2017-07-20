<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ ucfirst($shop_info->shop_key) }} | {{ $page }}</title>
    <meta name="description" content="Parallax backgrounds with centered content">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700" rel="stylesheet">
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
    <!-- LOGIN -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/login.css">
    <!-- REGISTER -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/register.css">
    {{-- Parallax --}}
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/parallax.css">
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
        <!-- HEADER -->
        <div class="header-container">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-2">
                        <div class="image-logo-holder stay-header">
                            <a class="clearfix" href="/"><img src="/themes/{{ $shop_theme }}/img/default-logo.png"></a>
                            <div class="menu-nav">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">

                        <!-- NAVIGATION -->
                        <nav class="navirino row clearfix">

                            <a href="/" class="head-button {{-- link-nav --}} {{ Request::segment(1) == '' ? 'active' : '' }}" id="home">HOME</a>

                            <a href="/products" class="head-button {{-- link-nav --}} {{ Request::segment(1) == 'products' ? 'active' : '' }}" id="products">PRODUCTS</a>

                            <a href="/company" class="head-button {{-- link-nav --}} {{ Request::segment(1) == 'company' ? 'active' : '' }}" id="company">COMPANY</a>

                            <a href="/contact" class="head-button {{-- link-nav --}} {{ Request::segment(1) == 'contact' ? 'active' : '' }}" id="contact-us">CONTACT</a>
                            
                            <a href="javascript:" class="head-button join-us-today {{-- link-nav --}} {{ Request::segment(1) == 'joinus' ? 'active' : '' }}" id="joinus">JOIN US TODAY</a>


                        </nav>{{-- END OF NAVIGATION --}}
                    </div>
                </div>
            </div>


           {{-- <div class="dropdown">
                <a class="head-button prodbtn{{ Request::segment(1) == 'products' ? 'active' : '' }}">PRODUCTS</a>
                 <div class="dropdown-content">
                    <a href="/products"><img src="/themes/{{ $shop_theme }}/img/img-prod-2.png"></a>
                </div>
            </div> --}}

            {{-- LOGIN --}}
            <div class="login" style="display: none;">
                <div class="row clearfix">
                    <div class="login-form-content">
                        <div class="text-header">Member Login</div>
                        <input type="text" class="form-control username-input" placeholder="Username" style="padding: 5px 0px 5px 5px;">
                        <input type="text" class="form-control password-input" placeholder="Password" style="padding: 5px 0px 5px 5px;">
                        <button id="login-button">Login</button>
                        <p>-Dont have an account yet?-</p>
                        <a><button id="create-an-account-btn">Create an account</button></a>
                    </div>
                </div>
            </div>{{-- END OF LOGIN --}}

        </div>{{-- END OF HEADER --}}
        
        <!-- REGISTER -->
        {{-- <div class="container">
            <div class="row clearfix">
                <div class="register">
                    <div class="row clearfix">
                        <div class="register-form-content">
                            
                            <div class="text-header1">New to digimahouse.com?</div>
                            <div class="text-header2">JOIN US TODAY!</div>
                            <input type="text" class="placeholder-caption form-control username-input" placeholder="User Name" style="padding: 5px 0px 5px 5px;">
                            <input type="text" class="placeholder-caption form-control email-input" placeholder="Email Address" style="padding: 5px 0px 5px 5px;">
                            <input type="date" id="birthdate" class="placeholder-caption form-control birthdate-input" placeholder="Birthdate" style="padding: 5px 0px 5px 5px;">
                            <textarea class="placeholder-caption form-control address-input" placeholder="Address" style="padding: 5px 0px 5px 5px;"></textarea>
                            
                            <input type="text" class="placeholder-caption form-control contact-input" placeholder="Contact Number" style="padding: 5px 0px 5px 5px;">
                            
                            <input type="password" class="placeholder-caption form-control password-input" placeholder="Password" style="padding: 5px 0px 5px 5px;">
                            
                            <input type="password" class="placeholder-caption form-control repeat-password-input" placeholder="Repeat Password" style="padding: 5px 0px 5px 5px; resize: none;">
                            <button id="create-button">Create</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- CONTENT -->
        <div id="scroll-to" class="clearfix">
            @yield("content")
        </div>

        {{-- FOOTER --}}
        <footer>
            <div style="background-image: url('/themes/{{ $shop_theme }}/img/img-footer.png');">
                <div class="container">
                    <div class="ftr-readmore-container row clearfix">
                        <div class="col-md-6">
                            <div class="paragraph">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
                        </div>
                        <div class="col-md-6">
                            <div class="ftr-btn-container">
                                <button class="read-more-btn">READ MORE</button>
                            </div>
                        </div>
                    </div>
                    <div class="ftr-content row clearfix">
                        <div class="col-md-3">
                            <div class="ftr-title">INFORMATION</div>
                            <br>
                            <a class="sub-title" href="/">HOME</a><br>
                            <a class="sub-title" href="/products">PRODUCTS</a><br>
                            <a class="sub-title" href="/company">COMPANY</a><br>
                            <a class="sub-title" href="/contact">CONTACT</a><br>
                        </div>
                        <div class="col-md-3">
                            <div class="ftr-title">CONTACT US</div>
                            <br>
                            <a class="sub-title" href="#">TEL NO.</a><br>
                            <a class="sub-title" href="#">MOBILE NO.</a><br>
                            <a class="sub-title" href="#">EMAIL</a><br>
                            <a class="sub-title" href="#">FAX</a><br>
                        </div>
                        <div class="col-md-3">
                            <div class="ftr-title">NEWS LETTER</div>
                            <br>
                            <div class="sub-title">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </div>
                            <br>
                            <form>
                                <input type="text" name="email" placeholder="Enter your email here">
                                <button class="submit-btn" type="submit">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <div class="ftr-title">FOLLOW US ON</div>
                            <br>
                            <div>
                                <a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                &nbsp
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                &nbsp
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>{{-- END OF FOOTER --}}

        {{-- BOTTOM FOOTER --}}
        <footer id="bottom-footer">
            <div class="container bottom">
                <div class="row clearfix border">
                    <div class="col-md-6">
                        <div class="ftr-title1">Terms & Conditions &nbsp|&nbsp API Use Policy &nbsp|&nbsp Privacy Policy &nbsp|&nbsp Cookies.</div>
                    </div>
                    <div class="col-md-6">
                        <div class="ftr-title2">© 2015 - 2016 Digima Web Solutions. All Rights Reserved.</div>
                    </div>
                </div>
            </div>
        </footer>{{-- END OF BOTTOM FOOTER --}}

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
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

{{-- LOGIN--}}
<script type="text/javascript">

$(document).ready(function(){

    $("#joinus").click(function(){
        $(".register").hide();
        $(".login").fadeToggle();
    });

});

</script>

{{-- REGISTER--}}
{{-- <script type="text/javascript">

$(document).ready(function(){

    $("#create-an-account-btn").click(function(){
        $(".login").hide();
        $(".register").fadeToggle();
    });

});

</script> --}}

{{-- HIDING--}}
{{-- <script type="text/javascript">
    
$(document).mouseup(function(e) 
{
    var login_container = $(".login");
    var register_container = $('.register');

    // if the target of the click isn't the container nor a descendant of the container
    if (!login_container.is(e.target) && login_container.has(e.target).length === 0) 
    {
        login_container.fadeOut();
    }

    if (!register_container.is(e.target) && register_container.has(e.target).length === 0) 
    {
        register_container.fadeOut();
    }

});

</script> --}}

{{-- <script type="text/javascript">

    var join_us_today = new join_us_today();

    function join_us_today()
    {
        function init()
        {
            event_join_us_today_click();
            event_join_us_today_click_outside();
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

        function event_join_us_today_click()
        {
            $(document).on("click", "#joinus", function(e)
            {
                e.preventDefault();
                if(!$(this).hasClass("active"))
                {
                    $(this).addClass("active");
                    $(".login").fadeIn(200);
                    e.stopPropagation();
                }
                else
                {
                    $(this).removeClass("active");
                    $(".login").fadeOut(200);
                }
            })
        }

        function event_join_us_today_click_outside()
        {
            $(document).on("click", "body", function(e)
            {
                $(".login").fadeOut(200);
                $("#joinus").removeClass("active");
            });

            $(document).on("click", ".login", function(e)
            {
                e.stopPropagation();
            });
        }
    }
</script> --}}

{{-- <script type="text/javascript">
    var news_dropdown = new news_dropdown();

    function news_dropdown()
    {
        init();

        function init()
        {
            event_news_click();
            event_news_click_outside();
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

        function event_news_click()
        {
            $(document).on("click", "#news", function(e)
            {
                e.preventDefault();
                if(!$(this).hasClass("active"))
                {
                    $(this).addClass("active");
                    $(".slider3-wrapper").fadeIn(200);
                    e.stopPropagation();
                }
                else
                {
                    $(this).removeClass("active");
                    $(".slider3-wrapper").fadeOut(200);
                }
            })
        }

        function event_news_click_outside()
        {
            $(document).on("click", "body", function(e)
            {
                $(".slider3-wrapper").fadeOut(200);
                $("#news").removeClass("active");
            });

            $(document).on("click", ".slider3-wrapper", function(e)
            {
                e.stopPropagation();
            });
        }
    }
</script> --}}

<script type="text/javascript">
    $window = $(window);
    $window.scroll(function() {
      $scroll_position = $window.scrollTop();
        if ($scroll_position > 100) { 
            $('.header-container').addClass('header-fixed');

            header_height = $('.your-header').innerHeight();
            $('body').css('padding-top' , header_height);
        } else {
            $('body').css('padding-top' , '0');
            $('.header-container').removeClass('header-fixed');
        }

     });

</script>

<script type="text/javascript">
        
    $('.slider3').diyslider({
        width: "463px", // width of the slider
        height: "115px", // height of the slider
        display: 4, // number of slides you want it to display at once
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

</script>

@yield("js")
</body>
</html>
