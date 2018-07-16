@extends("layout")
@section("content")
<div class="content">
    <div class="top-1-container">
        <div class="container">
            <div class="prod-container">
                <div class="row clearfix">
                    <div class="product-list-holder col-md-12 col-sm-12 col-xs-12">
                        <div class="prod-list-container">
                            <div class="title-container">All Products<div class="line-bot"></div></div>
                            <div class="prod-list">
                                <div class="row no-gutters clearfix gutters">
                                    <!-- PER ITEM -->
                                    @if(count($_product) > 0)
                                        @foreach($_product as $product)
                                        <div class="col-md-3">
                                            <div class="per-album-container">
                                                <a  href="/product/view2/{{ $product['eprod_id'] }}" style="text-decoration: none;">
                                                    <div class="img-container">
                                                        <img src="{{ get_product_first_image($product) }}">
                                                    </div>
                                                </a>
                                            </div>
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
            {!! $_product->appends(Request::input())->render() !!}
        </div>
    </div>
    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product.css">
@endsection

@section("script")
<script type="text/javascript">

</script>
@endsection



