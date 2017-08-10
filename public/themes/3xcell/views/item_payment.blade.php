@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="title-container">Payment</div>
		</div>
	</div>
	<div class="top-2-container">
		<div class="container">
			<div class="content-container row clearfix">
				<div class="col-md-8">
					<div class="title-container">
						<span>Login</span><span><i class="fa fa-angle-right" aria-hidden="true"></i>
						</span><span>Shipping</span><span><i class="fa fa-angle-right" aria-hidden="true"></i>
						</span><span style="color: #2161c8;">Payment</span></div>
					<!-- SHIPPING DETAILS -->
					<div class="mid-title-container">
						Payment
					</div>
					<!-- BILLING ADDRESS -->
					<div class="address-container">
						<div class="title-container">Billing Adress:</div>
						<div class="detail-container">Raymond Marasigan</div>
						<div class="detail-container">Block 6 Lot 8 Sampaguita Homes </div>
						<div class="detail-container">Bacoor, Cavite</div>
						<div class="detail-container">Bacoor, CAV 4102</div>
						<div class="detail-container">Philippines</div>
					</div>
					<!-- SHIPPING ADDRESS -->
					<div class="address-container">
						<div class="title-container">Shipping Adress:</div>
						<div class="detail-container">Raymond Marasigan</div>
						<div class="detail-container">Block 6 Lot 8 Sampaguita Homes </div>
						<div class="detail-container">Bacoor, Cavite</div>
						<div class="detail-container">Bacoor, CAV 4102</div>
						<div class="detail-container">Philippines</div>
					</div>
					<div class="select-payment-container">
						<div class="title-container">Select A Payment Method</div>
						<select class="select">
							<option value="">Paypal</option>
							<option value="">Bank Deposit</option>
							<option value="">FastPay</option>
							<option value="">Palawan Express</option>
						</select>
						<a href="/payment_success" style="text-decoration: none;"><div class="button-checkout">SUBMIT ORDER</div></a>
					</div>
				</div>
				<!-- CART SUMMARY -->
				<div class="col-md-4">
					<div class="order-summary-container">
						<div class="title-container">
							Order Summary
							<div class="edit-cart">Edit Cart</div>
						</div>
						<div class="per-order-container">
							<!-- PER ITEM -->
							<div class="per-item-container row-no-padding clearfix">
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
													<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1" disabled="">
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
							</div>
							<!-- PER ITEM -->
							<div class="per-item-container row-no-padding clearfix">
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
													<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1" disabled="">
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
							</div>
							<!-- PER ITEM -->
							<div class="per-item-container row-no-padding clearfix">
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
													<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1" disabled="">
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
							</div>
						</div>
					</div>
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
				</div>
			</div>
		</div>
	</div>

	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/item_payment.css">
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