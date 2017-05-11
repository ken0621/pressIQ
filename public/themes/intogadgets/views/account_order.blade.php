@extends('account_layout')
@section('account_content')
<div class="profile-container col-md-12">            
	<div class="profile">
		<div class="detail col-md-12">
			<div class="info col-md-12">
				<div class="row clearfix">
					<div class="image col-md-4">
						<img src="">
					</div>
					<div class="info-holder col-md-8">
						<div class="name">Customer Name</div>
						<div class="email">Customer Email</div>
					</div>
				</div>
			</div>
			<div class="clear edit col-md-4"><a href="account/settings"><i class="fa fa-edit"></i> Edit Profile</a></div>
		</div>
		<div class="counts col-md-12 nopadding">
			<div class="box col-md-4 nopadding">
				<div class="num">
					<div class="num-holder">
						<div class="num-text">0</div>
					</div>
				</div>
				<div class="labels">
					<i class="fa fa-shopping-cart"></i>
					<div class="labels-text">Orders</div>
				</div>
			</div>
			<div class="box col-md-4 nopadding">
				<div class="num">
					<div class="num-holder">
						<div class="num-text">0</div>
					</div>
				</div>
				<div class="labels">
					<i class="fa fa-comment"></i>
					<div class="labels-text">Comments</div>
				</div>
			</div>
			<div class="box col-md-4 nopadding">
				<div class="num">
					<div class="num-holder">
						<div class="num-text">0</div>
					</div>
				</div>
				<div class="labels"><i class="fa fa-tag"></i>
					<div class="labels-text">Coupons</div>
				</div>
			</div>
		</div>
	</div>

	<div class="profile-information">
	<div class="header"><span>Account</span> Information</div>
		<div class="info">
			<div class="labels">Birthday</div>
			<div class="value"></div>
		</div>
		<div class="info">
			<div class="labels">Gender</div>
			<div class="value"></div>
		</div>
		<div class="info">
			<div class="labels">Contact Number</div>
			<div class="value"></div>
		</div>
		<div class="info">
			<div class="labels">Default Address</div>
			<div class="value"></div>
		</div>
	</div>
	<div class="profile-information text-center">
	<div class="header text-left">
		<span>
			Recently Viewed
		</span> 
		Products
	</div>
	
	{{-- <a href="product/{{$product->slug}}">
		<div class="img-holder-holder">
			<div class="img-holder">
				<img src="{{$product->img_src}}">
			</div>
			<div class="img-text">
				{{$product->product_name}}
			</div>
		</div>
	</a> --}}

	<p>No recently viewed products</p>
	
	</div>
</div>
@endsection



@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/profile.css">
@endsection