@extends('layout')
@section('content')
<!-- home product -->
<div class="container-fluid home-product nopadding">
    <div style="display: table;
    width: 100%; table-layout: fixed;">
    <div class="left nopadding ratio-fix">
        <ul id="slippry">
            @if(is_serialized(get_content($shop_theme_info, "home", "home_slider")))
                @foreach(unserialize(get_content($shop_theme_info, "home", "home_slider")) as $slider)
                <li>
                    <a href="javascript:"><img src="{{ $slider }}" alt=""></a>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="right nopadding category-ratio">
        <div class="container-fluid nopadding">
            <a href="" class="holder nopadding">
                <img class="1" src="{{ get_content($shop_theme_info, 'home', 'home_category_sale') }}">
                <div class="text"></div>
                <div class="hover"></div>
            </a>
            <a href="" class="holder nopadding">
                <img class="2" src="{{ get_content($shop_theme_info, 'home', 'home_category_featured') }}">
                <div class="text" style="left: 15px !important;"></div>
                <div class="hover"></div>
            </a>
        </div>
        <div class="container-fluid nopadding">
            <a href="" class="holder nopadding">
                <img class="3" src="{{ get_content($shop_theme_info, 'home', 'home_category_tablet') }}">
                <div class="text x"></div>
                <div class="hover"></div>
            </a>
            <a href="" class="holder nopadding">
                <img class="4" src="{{ get_content($shop_theme_info, 'home', 'home_category_accessories') }}">
                <div class="text x"></div>
                <div class="hover"></div>
            </a>
            <a href="" class="holder nopadding">
                <img class="5" src="{{ get_content($shop_theme_info, 'home', 'home_category_smartphone') }}">
                <div class="text x"></div>
                <div class="hover"></div>
            </a>
        </div>

<!-- 
         <div class="right nopadding">
        <div class="container-fluid nopadding">
            <a href="javascript:" class="holder nopadding">
                <img src="/resources/assets/frontend/img/tablet.jpg">
                <div class="text">TABLETS</div>
                <div class="hover"></div>
            </a>
            <a href="javascript:" class="holder nopadding">
                <img src="/resources/assets/frontend/img/feature.jpg">
                <div class="text" style="left: 15px !important;">FEATURED</div>
                <div class="hover"></div>
            </a>
        </div>
        <div class="container-fluid nopadding">
            <a href="javascript:" class="holder nopadding">
                <img src="/resources/assets/frontend/img/nw.jpg">
                <div class="text x">NEW MODELS</div>
                <div class="hover"></div>
            </a>
            <a href="javascript:" class="holder nopadding">
                <img src="/resources/assets/frontend/img/accessories.jpg">
                <div class="text x">ACCESSORIES</div>
                <div class="hover"></div>
            </a>
            <a href="javascript:" class="holder nopadding">
                <img src="/resources/assets/frontend/img/onsale.jpg">
                <div class="text x">ON SALE</div>
                <div class="hover"></div>
            </a>
        </div> -->

    </div>
    </div>
    <!-- service -->
    <div class="service">
        <div class="holder">
            <img src="{{ get_content($shop_theme_info, 'home', 'home_first_service', '/resources/assets/frontend/img/shipping.jpg') }}">
        </div>
        <div class="holder">
            <img src="{{ get_content($shop_theme_info, 'home', 'home_second_service', '/resources/assets/frontend/img/business.jpg') }}">
        </div>
        <div class="holder">
            <img src="{{ get_content($shop_theme_info, 'home', 'home_third_service', '/resources/assets/frontend/img/garentee.jpg') }}">
        </div>
    </div>
</div>
<!-- brand -->
<div class="brand">
    <div class="header-brand">
        <div class="line"></div>
        <div class="text">{{ get_content($shop_theme_info, 'home', 'home_brand_title', 'BRANDS') }}</div>
    </div>
    <!-- Place somewhere in the <body> of your page -->
    <div class="flexslider">
      <ul class="slides">
        @if(is_serialized(get_content($shop_theme_info, 'home', 'home_brand_image', '')))
            @foreach(unserialize(get_content($shop_theme_info, 'home', 'home_brand_image', '')) as $brand)
            <li>
              <img src="{{ $brand }}">
            </li>
            @endforeach
        @endif
        <!-- items mirrored twice, total of 12 -->
      </ul>
    </div>
</div>
<!-- feature -->
<div class="feature">
    <div class="feature-header">FEATURED ITEMS</div>
    <div class="feature-content container">

    </div>
</div>
<!-- arrival -->
<div class="arrival">
    <div class="arrival-header">
        <div class="line"></div>
        <div class="text">{{ get_content($shop_theme_info, 'home', 'home_new_arrival_title', 'FEATURED') }}</div>
    </div>
    <div class="arrival-content container">

    </div>
</div>
<!-- best seller -->
<div class="best">
    <div class="best-header">
        <div class="line"></div>
        <div class="text">{{ get_content($shop_theme_info, 'home', 'home_best_seller_title', 'BEST SELLER') }}</div>
    </div>
    <div class="best-content container">

    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="resources/assets/frontend/css/home.css">
    
    <link rel="stylesheet" href="/resources/assets/flexslider/css/flexslider.css">
@endsection

@section('script')
    <script type="text/javascript" src="resources/assets/frontend/js/home.js"></script>
    
    <!-- SUBSCRIBER-MODAL -->
    <div class="remodal subscribe" data-remodal-id="subscribe">
        <div class="holder">
            <form method = "POST" id="subform" action="//intogadgets.us10.list-manage.com/subscribe/post?u=cd02508127b42de13d02bb528&id=74973f9e9e">
                <img src="/resources/assets/frontend/img/popup-signup.jpg">
                <div class="mobil">Sign up for exclusive promo and sales</div>
                <div class="input">
                    <input type="text" placeholder="Name" name="FNAME">
                    <input type="text" name="EMAIL" placeholder="Email">
                    <button type="submit">Sign up Now!</button>
                </div>
            </form>
        </div>
    </div>

 @if(Session::has('message'))
    <div class="reservemessage remodal" data-remodal-id="reserve">
        <div class="reserve">
           <div class="logo"><img style="height: 50px;" src="/resources/assets/frontend/img/intogadgets-logo.png"></div>
           <div class="text">Items in your cart was successfully reserved.</div>
           <div class="sub">This reservation is only valid for 24 hours.</br>wait for the confirmation SMS before you go. Thank you!</div>
        </div>
    </div>
 @endif

    <script type="text/javascript" src="resources/assets/flexslider/js/jquery.flexslider-min.js"></script>
@endsection

