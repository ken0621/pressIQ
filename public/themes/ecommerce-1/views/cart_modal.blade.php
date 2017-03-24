<form method="post" action="checkout" id="cart-form">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <!-- <div class="success">
         <img src="/themes/{{ $shop_theme }}/img/mini-check.png">
         <span>Item was successfully added to your cart.</span>
         </div> -->
      <h4 class="modal-title">
         <img src="/themes/{{ $shop_theme }}/img/shopping-cart-icon.png">
         <span>SHOPPING <span>CART</span></span>
      </h4>
   </div>
   @if(isset($get_cart['cart']) && $get_cart['cart'])
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
            @foreach($get_cart['cart'] as $cart)
            <tr>
               <td class="text-left">
                  <div class="img">
                     <img src="{{ $cart['cart_product_information']['image_path'] }}">
                  </div>
                  <div class="name" style="width: 100px;">{{ $cart['cart_product_information']['product_name'] }}</div>
               </td>
               <td>
                  <div class="input-group">
                     <span key="{{ $cart['product_id'] }}" style="cursor: pointer;" class="input-group-addon qty-control-add" variation-id="{{ $cart['product_id'] }}">+</span>
                     <input type="text" class="form-control qty-control" variation-id="{{ $cart['product_id'] }}" value="{{ $cart['quantity'] }}">
                     <span key="{{ $cart['product_id'] }}" style="cursor: pointer;" class="input-group-addon qty-control-minus" variation-id="{{ $cart['product_id'] }}">-</span>
                  </div>
               </td>
               <td class="upc">&#8369; <span key="{{ $cart['product_id'] }}" raw-price="{{ $cart['cart_product_information']['product_current_price'] }}">{{ number_format($cart['cart_product_information']['product_current_price'], 2) }}</span></td>
               <td class="ttl">&#8369; <span key="{{ $cart['product_id'] }}">{{ number_format($cart['cart_product_information']['product_current_price'] * $cart['quantity'], 2) }}</span></td>
               <td class="rmv"><a class="remove-cart" variation-id="{{ $cart['product_id'] }}" href="javascript:">Remove</a></td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
   <div class="modal-footer">
      <div class="text-right">
         <div class="subtotal-label">Subtotal:</div>
         <div class="subtotal-value">P <span>{{ number_format($get_cart['sale_information']['total_product_price'], 2) }}</span></div>
      </div>
      <div style="margin-top: 10px;">
         <span class="cart-loader hide"><img style="height: 37px; margin-right: 7.5px;" src="/assets/front/img/loader.gif"></span>
         <button type="button" class="checkout-modal-button btn btn-primary" onClick="location.href='/checkout'">CHECK OUT</button>
      </div>
   </div>
   @else
   <div class="empty-cart">
      <div class="title">There is no items in this cart</div>
      <div class="sub">Try to search or find something from one of our categories</div>
      <a href="javascript:" data-dismiss="modal">Continue Shopping</a>
   </div>
   @endif
</form>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/cart.js"></script>