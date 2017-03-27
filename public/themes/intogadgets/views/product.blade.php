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
            <div class="title">SHOWING {{ $current_count }} OF {{ $total_product }} ITEMS</div>
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
                    <option value="" {{ Request::input('sort') == '' ? 'selected' : '' }}>Relevance</option>
                    <option value="name_asc" {{ Request::input('sort') == 'name_asc' ? 'selected' : '' }}>Sort by Name: A - Z</option>
                    <option value="name_desc" {{ Request::input('sort') == 'name_desc' ? 'selected' : '' }}>Sort by Name: Z - A</option>
                    <option value="price_desc" {{ Request::input('sort') == 'price_desc' ? 'selected' : '' }}>Sort by Price: High - Low</option>
                    <option value="price_asc" {{ Request::input('sort') == 'price_asc' ? 'selected' : '' }}>Sort by Price: Low - High</option>
                    <option value="newest" {{ Request::input('sort') == 'newest' ? 'selected' : '' }}>Sort by: Newest</option>
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
            @foreach(get_collection(get_content($shop_theme_info, "product", "top_rated_products"), $shop_id) as $collection)
                <a href="/product/view/{{ $collection['eprod_id'] }}" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">{{ get_collection_first_name($collection) }}</div>
                            <div class="price">{{ get_collection_first_price($collection) }}</div>
                        </div>
                        <div class="img"><img class="4-3-ratio" src="{{ get_collection_first_image($collection) }}"></div>
                    </div>
                </a>    
            @endforeach
        </div>
        <div class="holder sshide">
            <div class="title text-left">Most Viewed</div>
            @foreach(get_collection(get_content($shop_theme_info, "product", "top_rated_products"), $shop_id) as $collection)
                <a href="/product/view/{{ $collection['eprod_id'] }}" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">{{ get_collection_first_name($collection) }}</div>
                            <div class="price">{{ get_collection_first_price($collection) }}</div>
                        </div>
                        <div class="img"><img class="4-3-ratio" src="{{ get_collection_first_image($collection) }}"></div>
                    </div>
                </a>    
            @endforeach 
        </div>
    </form>
</div>

<!-- PRODUCT CONTAINER -->
<div class="product-content">
    <div class="product-title">
        <div class="text" onclick="location.href='/'">Home</div> 
        @foreach($breadcrumbs as $breadcrumb)
          <i class="fa fa-circle aktibo"></i>
          @if(end($breadcrumbs) == $breadcrumb)
            <div class="text aktibo">{{ $breadcrumb['type_name'] }}</div>
          @else
            <div class="text" onclick="location.href='/{{ $breadcrumb['type_id'] }}'">{{ $breadcrumb['type_name'] }}</div> 
          @endif
        @endforeach
    </div>
    <div class="page">
        {!! $_product->appends(Request::input())->render() !!}
    </div>
    <div class="product-sub text-left"></div>
    <div class="product-contentie">
        <div class="grid-view">
        	@foreach($_product as $product)
        		@if(count($product['variant']) > 0)
                <a href="/product/view/1">
                    <div class="holder">
                        <div class="border">
                            <div class="img"><img class="4-3-ratio" src="{{ get_product_first_image($product) }}"></div>
                            <div class="name">{{ get_product_first_name($product) }}</div>
                            <!-- <div class="price-left">P34,000</div> -->
                            <div class="price-right">{{ get_product_first_price($product) }}</div>
                            <div class="hover">
                                <a href="/product/view/{{ $product['eprod_id'] }}" class="text">ADD TO CART</a>
                                <a href="/product/view/{{ $product['eprod_id'] }}" class="text">VIEW MORE</a>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
        <div class="list-view hide">
            @foreach($_product as $product)
                <div class="holder">
                    <div class="img"><img src="{{ get_product_first_image($product) }}"></div>
                    <div class="text">
                        <div class="name">{{ get_product_first_name($product) }}</div>
                        <!--<div class="sprice">from: <span>P34,990</span></div>-->
                        <div class="price">{{ get_product_first_price($product) }}</div>
                        <div class="description">{!! get_product_first_description($product) !!}</div>
                    </div>
                    <div class="cart">
                        <div class="info"><span>Delivery:</span>&nbsp;1 - 5 Business Days</div>
                        <div class="info"><span>Shipping Fee:</span>&nbsp;123.00</div>
                        <button class="button" onclick="location.href='product/'">View Info</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        {!! $_product->appends(Request::input())->render() !!}
    </div>
</div>

<div class="sidebar shide">
    <form class="form-filter">
        <div class="holder">
            <div class="title text-left">Top Rated Products</div>
            @foreach(get_collection(get_content($shop_theme_info, "product", "top_rated_products"), $shop_id) as $collection)
                <a href="/product/view/{{ $collection['eprod_id'] }}" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">{{ get_collection_first_name($collection) }}</div>
                            <div class="price">{{ get_collection_first_price($collection) }}</div>
                        </div>
                        <div class="img"><img class="4-3-ratio" src="{{ get_collection_first_image($collection) }}"></div>
                    </div>
                </a>    
            @endforeach
        </div>
        <div class="holder">
            <div class="title text-left">Most Viewed</div>
            @foreach(get_collection(get_content($shop_theme_info, "product", "top_rated_products"), $shop_id) as $collection)
                <a href="/product/view/{{ $collection['eprod_id'] }}" class="text">
                    <div class="product-top">
                        <div class="text">
                            <div class="name">{{ get_collection_first_name($collection) }}</div>
                            <div class="price">{{ get_collection_first_price($collection) }}</div>
                        </div>
                        <div class="img"><img class="4-3-ratio" src="{{ get_collection_first_image($collection) }}"></div>
                    </div>
                </a>    
            @endforeach
        </div>
    </form>
</div>

    <script type="text/javascript">
            var $filter_min = {{ $min_price }}; 
            var $filter_max = {{ $max_price }};
            var $filter_val = 0;
     </script>
    @endsection
    
    @section('css')
    <link rel="stylesheet" href="resources/assets/frontend/css/product.css">
    <link rel="stylesheet" href="resources/assets/rutsen/css/jquery-ui.css">
    @endsection

    @section('script')
    <script type="text/javascript">
        var min_range = {{ Request::input("min") ? Request::input("min") : $min_price }};
        var max_range = {{ Request::input("max") ? Request::input("max") : $max_price }};
    </script>
    <script type="text/javascript" src="resources/assets/external/jquery-ui.js"></script>
    <script type="text/javascript" src="resources/assets/frontend/js/product.js"></script>
    @endsection

