@extends('layout')
@section('content')

@if(isset($image))
<div class="aadd">
    <a href="{{$image->ads_link}}" target="_blank">
        <img src="{{$image->url}}" style="" >
    </a>
</div>
@endif
<div class="product-contents clear">
<!-- LEFT SIDEBAR -->
<div class="sidebar">
    <form class="form-filter" method="get">
        <div class="holder">
            <div class="title"></div>
        </div>

        @if(Input::get("featured") != 0)
            <input name="featured" type="hidden" value="{{ Input::get('featured') }}">
        @endif

        @if(Input::get("type") != 0)
            <input name="type" type="hidden" value="{{ Input::get('type') }}">
        @endif

        @if(Input::get("brand") != 0)
            <input name="brand" type="hidden" value="{{ Input::get('brand') }}">
        @endif

        <input type="hidden" class="min-price" value="" name="min">
        <input type="hidden" class="max-price" value="" name="max">
 
        <div class="holder">
            <div class="title text-left">View Type</div>
            <div class="icon-holder">
                <div class="icon" id="grid">
                    <img class="grid-active" src="/resources/assets/frontend/img/grid-active.png">
                    <img class="grid-non hide" src="/resources/assets/frontend/img/grid-non.png">
                </div>
                <div class="icon" id="list">
                    <img class="list-non" src="/resources/assets/frontend/img/list-non.png">
                    <img class="list-active hide" src="/resources/assets/frontend/img/list-active.png">
                </div>
            </div>
        </div>
        <div class="holder">
            <div class="select">
                <select class="sidebar-order" name="sort">
                    <option {{ Request::input('sort') == 'alphabet' ? 'selected="selected"' : '' }} value="alphabet">Sort By Name: A-Z</option>
                    <option {{ Request::input('sort') == 'popularity' ? 'selected="selected"' : '' }} value="popularity">Sort By Popularity</option>
                    <option {{ Request::input('sort') == 'newest' ? 'selected="selected"' : '' }} value="newest">Sort By Newest</option>
                    <option {{ Request::input('sort') == 'l2h' ? 'selected="selected"' : '' }} value="l2h">Sort By Price: Low to High</option>
                    <option {{ Request::input('sort') == 'h2l' ? 'selected="selected"' : '' }} value="h2l">Sort By Price: High to Low</option>
                </select>
            </div>
        </div>
        <div class="holder">
            <div class="title text-left">Filter By Price</div>
            <div class="slider-range"></div>
            <div class='filter'>
                <input type="text" id="amount" readonly style="border:0;">
                <button id="test-submit">Filter</button>
            </div>
        </div>
        <div class="holder sshide">
            <div class="title text-left">Top Rated Products</div>
      
                <a href="/product/view/1" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">Test</div>
                            <div class="price">₱&nbsp;123.00</div>
                        </div>
                        <div class="img"><img src=""></div>
                    </div>
                </a>    
    
        </div>
        <div class="holder sshide">
            <div class="title text-left">Most Viewed</div>
      
                <a href="/product/view/1" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">Test</div>
                            <div class="price">₱&nbsp;123.00</div>
                        </div>
                        <div class="img"><img src=""></div>
                    </div>
                </a>  

        </div>
        
    </form>
</div>

<!-- PRODUCT CONTAINER -->
<div class="product-content">
    <div class="product-title">
        <div class="text" onclick="location.href='/'">Home</div> 
    </div>
    <div class="page">
 
    </div>
    <div class="product-sub text-left"></div>
    <div class="product-contentie">
        <div class="grid-view">
        	@foreach($_product as $product)
        		@if(isset($product['variant'][0]))
                <a href="/product/view/1">
                    <div class="holder">
                        <div class="border">
                            <div class="img"><img class="4-3-ratio" src="{{ $product['variant'][0]['image'] ? $product['variant'][0]['image'][0]['image_path'] : '/themes/'.$shop_theme.'/img/item-1.jpg' }}"></div>
                            <div class="name">{{ $product['eprod_name'] }}</div>
                            <!-- <div class="price-left">P34,000</div> -->
                            <div class="price-right">P&nbsp;{{ number_format($product['variant'][0]['evariant_price'], 2) }}</div>
                            <div class="hover"><a href="/product/view/{{ $product['eprod_id'] }}" class="text">VIEW MORE</a></div>
                        </div>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
        <div class="list-view hide">

                <div class="holder">
                    <div class="img"><img src=""></div>
                    <div class="text">
                        <div class="name">Test</div>
                        <!--<div class="sprice">from: <span>P34,990</span></div>-->
                        <div class="price">P&nbsp;123.00</div>
                        <div class="description">
                        
                        </div>
                    </div>
                    <div class="cart">
                        <div class="info"><span>Delivery:</span>&nbsp;1 - 5 Business Days</div>
                        <div class="info"><span>Shipping Fee:</span>&nbsp;123.00</div>
                        <button class="button" onclick="location.href='product/'">View Info</button>
                    </div>
                </div>
 
        </div>
    </div>

</div>

<div class="sidebar shide">
    <form class="form-filter">
        <div class="holder">
            <div class="title text-left">Top Rated Products</div>
 
                <a href="/product/view/1" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">Test</div>
                            <div class="price">₱&nbsp;123.00</div>
                        </div>
                        <div class="img"><img src=""></div>
                    </div>
                </a>    
     
        </div>
        <div class="holder">
            <div class="title text-left">Most Viewed</div>

                <a href="/product/view/1" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">Test</div>
                            <div class="price">₱&nbsp;123.00</div>
                        </div>
                        <div class="img"><img src=""></div>
                    </div>
                </a>  

        </div>
    </form>
</div>

    <script type="text/javascript">
            var $filter_min = 0; 
            var $filter_max = 100;
            var $filter_val = 50;
     </script>
    @endsection
    
    @section('css')
    <link rel="stylesheet" href="resources/assets/frontend/css/product.css">
    <link rel="stylesheet" href="resources/assets/rutsen/css/jquery-ui.css">
    @endsection

    @section('script')
    <script type="text/javascript">
        var min_range = 0;
        var max_range = 100;
    </script>
    <script type="text/javascript" src="resources/assets/external/jquery-ui.js"></script>
    <script type="text/javascript" src="resources/assets/frontend/js/product.js"></script>
    @endsection

