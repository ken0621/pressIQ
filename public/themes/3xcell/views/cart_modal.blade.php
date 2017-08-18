@if(isset($get_cart['cart']) && $get_cart['cart'])
    <div class="title-container">
        Cart Summary
    </div>
    <div class="scroll-container">
        <div class="per-order-container">
            @foreach($get_cart['cart'] as $cart)
                <!-- PER ITEM -->
                <div class="per-item-container row-no-padding clearfix" vid="{{ $cart["cart_product_information"]["variant_id"] }}">
                    <div class="col-md-3">
                        <!-- ITEM IMAGE -->
                        <div class="image-container">
                            <img class="4-3-ratio" src="{{ $cart['cart_product_information']['image_path'] ? $cart['cart_product_information']['image_path'] : '/assets/mlm/img/placeholder.jpg' }}">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <!-- ITEM DETAILS -->
                        <div class="item-detail-container">
                            <div class="item-name text-overflow">
                                {{ $cart["cart_product_information"]["product_name"] }} 
                                @if($cart["cart_product_information"]["product_name"] != $cart["cart_product_information"]["variant_name"])
                                ({{ $cart["cart_product_information"]["variant_name"] }})
                                @endif
                            </div>
                            <div class="bottom-detail row clearfix">
                                <div class="col-md-4">
                                    <div class="price-container">
                                        <div class="title-price">Price:</div>
                                        <div class="price">PHP. <span vid="{{ $cart["cart_product_information"]["variant_id"] }}" class="raw-price">{{ number_format($cart["cart_product_information"]["product_price"], 2) }}</span></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="quantity-container">
                                        <input class="input-quantity" vid="{{ $cart["cart_product_information"]["variant_id"] }}" type="number" name="quantity" min="1" step="1" value="{{ $cart['quantity'] }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="total-container">
                                        <div class="title-price">Total:</div>
                                        <div class="price">PHP. <span vid="{{ $cart["cart_product_information"]["variant_id"] }}" class="sub-total">{{ number_format($cart["cart_product_information"]["product_price"] * $cart["quantity"], 2) }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- REMOVE BUTTON -->
                    <div class="remove-container remove-item-from-cart" vid="{{ $cart["cart_product_information"]["variant_id"] }}"><i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="subtotal-container">
        <div class="title-container">
            TOTAL
            <div class="subtotal">PHP <span class="total">{{ number_format($get_cart["sale_information"]["total_product_price"], 2) }}</span></div>
        </div>
        <form method="get" action="{{ $customer_info_a ? '/checkout' : '/mlm/login' }}">
            <input type="hidden" name="checkout" value="1">
            <button style="border: 0;" type="submit" class="button-checkout">CHECKOUT</button>
        </form>
        <div class="view-cart"><a href="/MyCart"><span><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;View Cart</span></a></div>
    </div>
@else
    <div class="empty-cart">
      <div class="title">There is no items in this cart</div>
      <div class="sub">Try to search or find something from one of our categories</div>
    </div>
@endif