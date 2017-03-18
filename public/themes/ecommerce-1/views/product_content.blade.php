@extends('layout')
@section('content')

<div class="content">
    <div class="container">
        <div class="row clearfix">
            <!-- SIDE CONTAINER -->
            <div class="col-md-3">
                <div class="hot-deals-container">
                    <div class="left-container-title">
                        <span>DAILY HOT DEALS</span>
                        <span class="scroll-button"><a class="left" href="#"><img src="/themes/{{ $shop_theme }}/img/left-button-scroll.png"></a><a class="right" href="#"><img src="/themes/{{ $shop_theme }}/img/right-button-scroll.png"></a></span>
                    </div>
                    <div class="daily-container">
                        @foreach(get_collection(get_content($shop_theme_info, "home", "daily_hot_deals"), $shop_id) as $collection)
                            <div class="holder">
                                <div class="hot-deals-item-container">
                                    <img class="4-3-ratio" src="{{ get_collection_first_image($collection) }}">
                                    <div class="item-details">
                                        <div class="item-title">{{ $collection['product']['eprod_name'] }}</div>
                                        <div class="item-price">{{ get_collection_first_price($collection) }}</div>
                                    </div>
                                    <button class="new-add-to-cart-button btn" style="margin-top: 25px;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
                                                    <td class="text">Add to cart</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- ITEM CONTENT -->
            <div class="col-md-9">
                <?php $ctr = 0; ?>
                @foreach($product['variant'] as $key => $product_variant)
                <div class="featured-container item-content {{ $ctr != 0 ? 'hide' : '' }}" variant-id="{{ $product_variant['evariant_id'] }}">
                    <div class="row clearfix">
                        <div class="col-md-5 product">
                            <div>
                                @foreach($product_variant['image'] as $key => $image)
                                <img id="yellow-bag-image" class="item-image-large {{ $key == 0 ? '' : 'hide' }}" key="{{ $key }}" style="width: 100%;" src="{{ $image['image_path'] }}" data-zoom-image="{{ $image['image_path'] }}">
                                @endforeach
                            </div>
                            <!-- <table style="table-layout: fixed; width: 100%;">
                                <tr>
                                    @foreach($product_variant['image'] as $key => $image)
                                    <td><img style="width: 100%; object-fit: cover;" class="item-image-small small-yellow-bag match-height" src="{{ $image['image_path'] }}"></td>
                                    @endforeach
                                </tr>
                            </table> -->
                        </div>
                        <div class="col-md-7 item-selected-content">
                            <div class="item-and-description">
                                <div class="item-title">{{ $product["eprod_name"] }}</div>
                                <!-- <div class="rating">
                                   <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                   <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                   <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                   <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                   <img src="/themes/{{ $shop_theme }}/img/star-disable.png">
                                </div> -->
                                <div class="availability">Availability : <span id="stock">In-stock</span></div>
                                <div class="item-description">{!! $product_variant['evariant_description'] !!}</div>
                            </div>
                            <div class="variant-holder">
                                @foreach($_variant as $variant)
                                <div class="holder">
                                    <div class="s-label">{{ $variant['option_name'] }}</div>
                                    <div class="select">
                                        <select name="attr[{{ $variant['option_name_id'] }}]" style="text-transform: capitalize;" class="form-control select-variation" variant-label="{{ $variant['option_name'] }}" product-id="{{ $product['eprod_id'] }}" variant-id="{{ $product_variant['evariant_id'] }}">
                                            <option value="0" style="text-transform: capitalize;">Select {{ $variant['option_name'] }}</option>
                                            @foreach(explode(",", $variant['variant_value']) as $option)
                                            <option value="{{ $option }}" style="text-transform: capitalize;">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="container-quantity-price">
                                <div class="row clearfix">
                                    <div class="col-md-5 price-old-new">
                                       <!-- if($product_variant['discounted'] == "true") -->
                                       <!-- <div class="present-item-price">PHP {{ number_format($product_variant['item_discount_value'], 2) }}</div>
                                       <div class="item-old-price">PHP {{ number_format($product_variant['evariant_price'], 2) }}</div> -->
                                       <!-- else -->
                                       <div class="present-item-price">PHP {{ number_format($product_variant['evariant_price'], 2) }}</div>
                                       <!-- endif -->
                                    </div>
                                    <div class="col-md-7 item-quantity">
                                        <div class="quantity-input">
                                           <form>QTY: <input type="number" name="quantity" min="0" max="100"></form>
                                        </div>
                                       
                                         <div>
                                            <button data-toggle="modal" data-target="#shopping_cart" type="button"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</button>
                                         </div>
                                    </div>
                                </div>
                            </div>
                            @if(count($product_variant['mlm_discount']) > 0)
                            <div style="margin-top: 15px;">
                                <table class="table table-bordered table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>Discount Value</th>
                                            <th>Product Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product_variant['mlm_discount'] as $key => $mlm_discount)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>PHP. {{ number_format($mlm_discount, 2) }}</td>
                                            <td>PHP. 0.00</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            <!-- <div class="facebook-share">
                                <img class="item-image-small" src="/themes/{{ $shop_theme }}/img/facebook-logo.jpg">
                                <a class="tooltips" href="#">Share<span>20</span></a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <?php $ctr++; ?>
                @endforeach
                <!-- <div class="featured-container description-reviews">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
                        <li><a data-toggle="tab" href="#reviews">REVIEWS</a></li>
                    </ul>
                    <div class="tab-content">
                    <div id="description" class="tab-pane fade in active">
                        <div class="description-content">
                            <div class="description-par">{!! $product_variant['evariant_description'] !!}</div>
                        </div>
                    </div>
                    <div id="reviews" class="tab-pane fade">
                        <div class="container-review">
                            <div class="review-title">Customer Reviews</div>
                            <div class="row clearfix">
                                <div class="review-content">        
                                    <div class="col-md-2 col-xs-12">
                                        <div class="summary-details">
                                            <div class="item-name">Alpha 12345</div>
                                            <div class="rating">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-disable.png">
                                            </div>
                                            <div class="item-date">Dec 5, 2016</div>
                                        </div>
                                        <div class="summary-details">
                                            <div class="item-name">Alpha 12345</div>
                                            <div class="rating">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-disable.png">
                                            </div>
                                            <div class="item-date">Dec 5, 2016</div>
                                        </div>
                                        <div class="summary-details">
                                            <div class="item-name">Alpha 12345</div>
                                            <div class="rating">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-active.png">
                                                <img src="/themes/{{ $shop_theme }}/img/star-disable.png">
                                            </div>
                                            <div class="item-date">Dec 5, 2016</div>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-xs-12">
                                        <div class="summary-tab">
                                            <div class="summary-title">Summary Lorem ipsum</div>
                                            <div class="summary-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                        </div>
                                        <div class="summary-tab">
                                            <div class="summary-title">Summary Lorem ipsum</div>
                                            <div class="summary-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                        </div>
                                        <div class="summary-tab">
                                            <div class="summary-title">Summary Lorem ipsum</div>
                                            <div class="summary-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="bottom-container">
                        <div class="input-name-summary-review">
                            <div class="row clearfix">
                                
                                    <div class="write-your-own-title">Write your own review</div>
                                <div class="col-md-2"></div>

                                <div class="col-md-10 input-summary-review">
                                    <div class="col-md-6 form-name-summary">
                                        <div class="input-name">Your Name <span class="star">*</span></div>
                                        <input type="text" class="form-control">
                                        <div class="input-name">Summary <span class="star">*</span></div>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-review">
                                        <div class="input-name">Review <span class="star">*</span></div>
                                        <textarea class="form-control" style="height: 110px; border-radius: 0;"></textarea>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-12 col-xs-6 stars-count">
                                            <div class="stars-number">
                                                <li>1 Star</li>
                                                <li>2 Stars</li>
                                                <li>3 Stars</li>
                                                <li>4 Stars</li>
                                                <li>5 Stars</li>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-12 col-xs-6 product-rate">
                                            <div class="rate-title">Rate this product</div>
                                            <div class="rays">
                                                <li><input type="radio"></li>
                                                <li><input type="radio"></li>
                                                <li><input type="radio"></li>
                                                <li><input type="radio"></li>
                                                <li><input type="radio"></li>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button>SUBMIT REVIEW</button>

                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="featured-container clearfix">
                    <div class="other-related"><strong>Other Related Products</strong></div>
                    <div class="other-related-items row clearfix">
                        @foreach(limit_foreach($_related, 4) as $related)
                        <div class="col-md-3">
                            <div class="per-item-container">
                                <div class="image-content-1">
                                    <img class="4-3-ratio item-image-large other-related-images" src="{{ get_product_first_image($related) }}">
                                    <button class="new-add-to-cart-button btn" >
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
                                                    <td class="text">Add to cart</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </button>
                                </div>
                                <div class="item-details">
                                    <div class="item-name">{{ get_product_first_name($related) }}</div>
                                    <div class="item-price">{{ get_product_first_price($related) }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="shopping_cart" class="modal fade global-modal shopping-cart-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="success">
            <img src="/themes/{{ $shop_theme }}/img/mini-check.png">
            <span>Item was successfully added to your cart.</span>
        </div>
        <h4 class="modal-title">
            <img src="/themes/{{ $shop_theme }}/img/shopping-cart-icon.png">
            <span>SHOPPING <span>CART</span></span>
        </h4>
      </div>
      <div class="modal-body">
        <table class="table table-scroll">
            <thead>
                <tr>
                    <th class="text-left">ITEM</th>
                    <th>QTY</th>
                    <th>UNIT PRICE</th>
                    <th>TOTAL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">
                        <div class="img">
                            <img src="/themes/{{ $shop_theme }}/img/yellow-bag.jpg">
                        </div>
                        <div class="name">Lorem Ipsum Loret</div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">-</span>
                        </div>
                    </td>
                    <td class="upc">P 300.00</td>
                    <td class="ttl">P 300.00</td>
                    <td class="rmv"><a href="javascript:">Remove</a></td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="img">
                            <img src="/themes/{{ $shop_theme }}/img/yellow-bag.jpg">
                        </div>
                        <div class="name">Lorem Ipsum Loret</div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">-</span>
                        </div>
                    </td>
                    <td class="upc">P 300.00</td>
                    <td class="ttl">P 300.00</td>
                    <td class="rmv"><a href="javascript:">Remove</a></td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="img">
                            <img src="/themes/{{ $shop_theme }}/img/yellow-bag.jpg">
                        </div>
                        <div class="name">Lorem Ipsum Loret</div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">-</span>
                        </div>
                    </td>
                    <td class="upc">P 300.00</td>
                    <td class="ttl">P 300.00</td>
                    <td class="rmv"><a href="javascript:">Remove</a></td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="img">
                            <img src="/themes/{{ $shop_theme }}/img/yellow-bag.jpg">
                        </div>
                        <div class="name">Lorem Ipsum Loret</div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">-</span>
                        </div>
                    </td>
                    <td class="upc">P 300.00</td>
                    <td class="ttl">P 300.00</td>
                    <td class="rmv"><a href="javascript:">Remove</a></td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="img">
                            <img src="/themes/{{ $shop_theme }}/img/yellow-bag.jpg">
                        </div>
                        <div class="name">Lorem Ipsum Loret</div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">-</span>
                        </div>
                    </td>
                    <td class="upc">P 300.00</td>
                    <td class="ttl">P 300.00</td>
                    <td class="rmv"><a href="javascript:">Remove</a></td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <div class="text-right">
            <div class="subtotal-label">Subtotal:</div>
            <div class="subtotal-value">P 3,350.00</div>
        </div>
        <div style="margin-top: 10px;">
            <button type="button" class="btn btn-primary" data-dismiss="modal">CHECK OUT</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section("js")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/product_content.js"></script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product_content.css">
@endsection
