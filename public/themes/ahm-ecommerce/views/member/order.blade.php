@extends("member.member_layout")
@section("member_content")
<div class="member-order">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<div class="brown-icon-orders"></div>
			</div>
			<div class="text">
				<div class="name">My Orders</div>
			</div>
		</div>
		<div class="right">
			
		</div>
	</div>
	<div class="order-content">
		@foreach($_orders as $key => $orders)
		<div class="holder">
			<table>
				<tr>
					<td class="img">
						<img src="{{$orders->item_img}}">
					</td>
					<td class="info">
						<div class="first-row clearfix">
							<div class="name">Order #{{$key + 1}}</div>
							<div class="button">
								<a onclick="action_load_link_to_modal('/member/cashier/transactions/view_item/{{$orders->transaction_list_id}}', 'md')"><button class="btn btn-orange" style="background-color: #d84d4c" >Acknowledgement Receipt</button></a>
							</div>
						</div>
						<table>
							<tr>
								<td class="detail-label">Order Status:</td>
								<td class="detail-value">{{$orders->order_status}}</td>
							</tr>
							<tr>
								<td class="detail-label">Customer Email:</td>
								<td class="detail-value">{{$orders->email}}</td>
							</tr>
							<tr>
								<td class="detail-label">Payment Status:</td>
								<td class="detail-value">{{$orders->payment_status}}</td>
							</tr>
							<tr>
								<td class="detail-label">Billing Address:</td>
								<td class="detail-value">{{$orders->customer_street}}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		@endforeach
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_order.css">
@endsection