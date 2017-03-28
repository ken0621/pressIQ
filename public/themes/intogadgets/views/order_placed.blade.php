@extends("layout")
@section("content")
<div class="clearfix">
	<div class="container" style="background-color: #fff; margin-bottom: 50px; margin-top: 50px;">
		<div class="text-center">
			<img src="/themes/{{ $shop_theme }}/img/check.png">
			<span style="font-size: 20px;">&nbsp;&nbsp;<strong>CHECK</strong> OUT</span>
		</div>
		<div class="sub" style="text-align: center;
    font-size: 16px;
    margin: 25px 0;">Your <strong>order</strong> # {{ isset($order_id) ? $order_id : 0 }} is being processed.</div>
		<div class="text-center">
			<button class="btn btn-primary">BACK TO SHOP</button>
		</div>
		<div style="margin-bottom: 100px;"></div>
	</div>
</div>
@endsection

@section("css")

@endsection

