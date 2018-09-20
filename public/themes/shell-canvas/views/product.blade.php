@extends("layout")
@section("content")
<div class="content">
	   <div class="main-container">
        
        </div>
        <div class="top-1-container">
            <div class="container">
                <div class="prod-container">
                    <div class="row clearfix">
                        <div class="product-list-holder col-md-12 col-sm-12 col-xs-12">
                            <div class="prod-list-container">
                                <div class="title-container">All Products<div class="line-bot"></div></div>
                                <div class="prod-list">
                                    <div class="row-no-padding clearfix">
                                        @if(count($_product) > 0)
                                            @foreach($_product as $product)
                                            <div class="col-md-2 col-sm-4 col-xs-6 prod-border">
                                                @if($mlm_member)
                                                    <div class="prod-holder match-height" style="cursor: pointer;" onClick="location.href='/product/view2/{{ $product['eprod_id'] }}'">
                                                        <div class="prod-image prod-holder-member">
                                                            <div class="prod-overlay">
                                                                <div class="border">
                                                                    <div class="top">
                                                                        <div class="label"><i class="fa fa-tag"></i> Member’s Price</div>
                                                                        <div class="price">{{ $product['variant'][0]['item_price'] }}</div>
                                                                    </div>
                                                                    <div class="bottom">
                                                                        <div class="label"><i class="fa fa-star"></i> Point Value</div>
                                                                        @if(isset($product['pv']))
                                                                        <div class="point">{{$product['pv']['UNILEVEL_TW']}}</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="{{ get_product_first_image($product) }}">
                                                        </div>
                                                        <div class="details-container">
                                                            <div class="prod-name">{{ get_product_first_name($product) }}</div>
                                                            <div class="prod-price">{{ get_product_first_price($product) }}</div>
                                                        </div>
                                                        <div class="btn-container">
                                                            <button class="btn-red" onClick="location.href='/product/view2/{{ $product['eprod_id'] }}'">SHOP NOW</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="prod-holder match-height" style="cursor: pointer;" onClick="location.href='/product/view2/{{ $product['eprod_id'] }}'">
                                                        <div class="prod-image">
                                                            <img src="{{ get_product_first_image($product) }}">
                                                        </div>
                                                        <div class="details-container">
                                                            <div class="prod-name">{{ get_product_first_name($product) }}</div>
                                                            <div class="prod-price">{{ get_product_first_price($product) }}</div>
                                                        </div>
                                                        <div class="btn-container">
                                                            <button class="btn-red" onClick="location.href='/product/view2/{{ $product['eprod_id'] }}'">SHOP NOW</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        @else
                                           <div class="col-md-3" >
                                                <strong>"NO ITEMS FOUND"</strong>
                                           </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css">

@endsection

@section("script")
<script type="text/javascript">
    $(function()
    {
        $('#close-menu').on('click',function()
        {
            $(this).closest('#menu').toggle(500,function(){
            $('.mini-submenu').fadeIn();
            $('#cat-title').fadeIn();
        });
    });
        $('.mini-submenu').on('click',function()
        {
            $(this).next('#menu').toggle(500);
            $('.mini-submenu').hide();
            $('#cat-title').hide();
        })
    })
</script>
@endsection



