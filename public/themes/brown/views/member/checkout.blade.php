@extends("layout")
@section("content")
<div class="content">
	<div class="top-container">
		<div class="container">
			<div class="top-container-content">Payment Summary</div>
		</div>
	</div>
	<div class="bottom-container">
		<div class="container">
			<div class="bottom-container-content">
				<div class="row clearfix">
					<!-- DELIVERY INFORMATION -->
					<div class="col-md-8">
						<div class="delivery-information">
							<div class="title-container">
								Fill Up Delivery Information
							</div>
							<div class="form-container">
								<div class="form-label">Province</div>
								<div class="form-input">
									<select >
										<option value="" hidden>Select Province</option>
										<option value="volvo">Abra</option>
										<option value="saab">Bulacan</option>
										<option value="opel">Cagayan Province</option>
										<option value="audi">Davao</option>
									</select>
								</div>
							</div>
							<div class="form-container">
								<div class="form-label">Complete Shipping Address</div>
								<div class="form-input">
										<textarea placeholder="Type your complete address here"></textarea>
								</div>
							</div>
						</div>
					</div>
					<!-- CART SUMMARY -->
					<div class="col-md-4">
						<div class="cart-summary">
							<div class="top-title row-no-padding clearfix">
								<div class="col-md-4">
									<div class="per-title" style="border-bottom: 3px solid #63b944;">Product</div>									
								</div>
								<div class="col-md-4">
									<div class="per-title" style="border-bottom: 3px solid #ef5525;">Quantity</div>
								</div>
								<div class="col-md-4">
									<div class="per-title" style="border-bottom: 3px solid #6075f7;">Price</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")

@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/checkout.css">
@endsection