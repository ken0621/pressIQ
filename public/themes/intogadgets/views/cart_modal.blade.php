<form method="post" action="checkout" id="cart-form">
  <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
  <div class="cart">
    @if(isset($get_cart['cart']) && $get_cart['cart'])
    <div class="cart-header"><img src="/resources/assets/rutsen/img/icon/bag.png"><span>My Shopping Cart</span></div>
    <div class="cart-content">
      <div class="cart-content-header">
        <div class="cart-header-text">Image</div>
        <div class="cart-header-text">Product Name</div>
        <div class="cart-header-text">Unit Price</div>
        <div class="cart-header-text">Quantity</div>
        <div class="cart-header-text text-right">Total</div>
      </div>
      <!-- FOREACH -->
      @foreach($get_cart['cart'] as $cart)
      <div class="cart-content-item" vid="{{ $cart["cart_product_information"]["variant_id"] }}" rawprice="{{ $cart["cart_product_information"]["product_price"] }}">
        <div class="cart-item-text"><img style="width: 100%;" src="{{ $cart['cart_product_information']['image_path'] ? $cart['cart_product_information']['image_path'] : '/assets/mlm/img/placeholder.jpg' }}"></div>
        <div class="cart-item-text">
          <div>
            {{ $cart["cart_product_information"]["product_name"] }} 
            @if($cart["cart_product_information"]["product_name"] != $cart["cart_product_information"]["variant_name"])
            ({{ $cart["cart_product_information"]["variant_name"] }})
            @endif
          </div>
          <div><a class="remove-item-from-cart" vid="{{ $cart["cart_product_information"]["variant_id"] }}" href="javascript:">REMOVE</a></div>
        </div>
        <div class="cart-item-text">&#8369; {{ number_format($cart["cart_product_information"]["product_price"], 2) }}</div>
        <div class="cart-item-text"><button class="compute-cart" compute="-1">-</button><input name="qty[{{ $cart["cart_product_information"]["variant_id"] }}]" class="text-center product-qty" type="number" style="    width: 30px;
    border: 1px solid #ddd;
    border-left: none;
    border-right: none;   
    width: 60px;
    padding: 3px;
    font-size: 14px;
    border: 1px solid #DDDDDD;" min="1" value="{{ $cart['quantity'] }}"><button class="compute-cart" compute="1">+</button></div>
        <div class="cart-item-text text-right">&#8369; <span class="total-price"></span></div>
      </div>
      @endforeach
      <!-- ENDFOREACH -->
    </div>
    <div class="cart-content-items">
      <a class="cart-content-back"><img src="/resources/assets/rutsen/img/arrow-left.png">Continue Shopping</a>
      @if($customer_info_a)
      <button style="margin-right: 10px;" onclick="location.href='/account/wishlist'; return false;" class="cart-content-go text-center">Wishlist</button>
      @endif
      <button onclick="location.href='/checkout/login'; return false;" class="cart-content-go text-center">Checkout</button>
      <div class="super-holder">
        <span>Total</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="cart-content-price text-right">&#8369;&nbsp;
          <div class="super-total">{{ $get_cart["sale_information"]["total_product_price"] }}</div>
        </span>
      </div>
    </div>

    <div class="feature-items">
      <div class="title">Featured Products</div>
      <div class="containers">
        <!-- FOREACH -->
        <a href="javascript:">
        <div class="holder">
          <div class="img"><img src="/assets/mlm/img/placeholder.jpg"></div>
          <div class="name">Product Name</div>
        </div>
        </a>
        <!-- ENDFOREACH -->
      </div>
    </div>
    @else
    <div class="empty-cart">
      <div class="title">There is no items in this cart</div>
      <div class="sub">Try to search or find something from one of our categories</div>
      <a id="backbutton" href="javascript:">Continue Shopping</a>
    </div>
    @endif
  </div>
</form>
<script type="text/javascript">
$(".cart-content-back").click(function()
{
var url = window.location.href.split('#')[0];
window.location.href = url + "#";
});
$("#backbutton").click(function()
{
var url = window.location.href.split('#')[0];
window.location.href = url + "#";
});
$('.product-qty').keypress(function(e)
{
var key_codes = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 0, 8];
if (!($.inArray(e.which, key_codes) >= 0)) {
e.preventDefault();
return false;
}

});
</script>