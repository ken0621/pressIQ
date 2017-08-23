@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="title-container">My Shopping Cart</div>
		</div>
	</div>
	<div class="top-2-container">
		<div class="container">
			<div class="content-container row clearfix">
				<div class="col-md-8">
					<div class="title-container" style="color: #6e6e6e !important;">Item Summary</div>
					<div class="cart-item-container">
						<!-- PER ITEM -->
						<div class="per-item-container row clearfix">
							<div class="col-md-3">
								<!-- ITEM IMAGE -->
								<div class="image-container">
									<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
								</div>
							</div>
							<div class="col-md-9">
								<!-- ITEM DETAILS -->
								<div class="item-detail-container">
									<div class="item-name text-overflow">Item Name Testing</div>
									<div class="bottom-detail row clearfix">
										<div class="col-md-4">
											<div class="price-container">
												<div class="title-price">Price:</div>
												<div class="price">PHP 200.00</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="quantity-container">
												<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1">
											</div>
										</div>
										<div class="col-md-4">
											<div class="total-container">
												<div class="title-price">Total:</div>
												<div class="price">PHP 200.00</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- REMOVE BUTTON -->
							<div class="remove-container"><i class="fa fa-times" aria-hidden="true"></i></div>
						</div>
						<!-- PER ITEM -->
						<div class="per-item-container row clearfix">
							<div class="col-md-3">
								<!-- ITEM IMAGE -->
								<div class="image-container">
									<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
								</div>
							</div>
							<div class="col-md-9">
								<!-- ITEM DETAILS -->
								<div class="item-detail-container">
									<div class="item-name text-overflow">Item Name Testing</div>
									<div class="bottom-detail row clearfix">
										<div class="col-md-4">
											<div class="price-container">
												<div class="title-price">Price:</div>
												<div class="price">PHP 200.00</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="quantity-container">
												<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1">
											</div>
										</div>
										<div class="col-md-4">
											<div class="total-container">
												<div class="title-price">Total:</div>
												<div class="price">PHP 200.00</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- REMOVE BUTTON -->
							<div class="remove-container"><i class="fa fa-times" aria-hidden="true"></i></div>
						</div>
						<!-- PER ITEM -->
						<div class="per-item-container row clearfix">
							<div class="col-md-3">
								<!-- ITEM IMAGE -->
								<div class="image-container">
									<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
								</div>
							</div>
							<div class="col-md-9">
								<!-- ITEM DETAILS -->
								<div class="item-detail-container">
									<div class="item-name text-overflow">Item Name Testing</div>
									<div class="bottom-detail row clearfix">
										<div class="col-md-4">
											<div class="price-container">
												<div class="title-price">Price:</div>
												<div class="price">PHP 200.00</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="quantity-container">
												<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1">
											</div>
										</div>
										<div class="col-md-4">
											<div class="total-container">
												<div class="title-price">Total:</div>
												<div class="price">PHP 200.00</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- REMOVE BUTTON -->
							<div class="remove-container"><i class="fa fa-times" aria-hidden="true"></i></div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="title-container">Cart Summary</div>
					<div class="cart-summary-container">
						<div class="subtotal-container">
							<div class="title-container">Subtotal:</div>
							<div class="subtotal">PHP 8,400.00</div>
						</div>
						<div class="total-container">
							<div class="title-container">Total:</div>
							<div class="subtotal">PHP 8,400.00</div>
						</div>
					</div>
					<a href="/item_checkout" style="text-decoration: none;"><div class="button-checkout">PROCEED TO CHECKOUT</div></a>
					<div class="shipping-fee"><span>Note:</span><br>Shipping fee is not included in the checkout price.</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/MyCart.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 700) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 700);
        return false;
    });
});
</script>
@endsection