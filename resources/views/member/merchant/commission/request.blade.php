<h3>Request Collect Commission</h3>
@if($user)
	<form class="global-submit" method="post" action="/member/merchant/commission/request/submit">
	{!! csrf_field() !!}	
		<div class="col-md-12" style="text-transform: uppercase;">
			<h4>{{$user->user_first_name}} {{$user->user_last_name}}</h4>
		</div>
		<div class="col-md-4">
			<label style="color:gray"><small>From</small></label>
			<input type="date" class="form-control request_from" name="request_from">
		</div>
		<div class="col-md-4">
		<label style="color:gray"><small>To</small></label>
			<input type="date" class="form-control request_to" name="request_to">
		</div>
		<div class="col-md-4">
			<label style="color:gray"><small>Checking</small></label><br>
			<a id="check_income" onClick="check_commission_range({{$user->user_id}})" class="btn btn-primary col-md-12">Verify</a>
		</div>
		<div class="col-md-12 verify_commision_div"></div>
	</form>

@else
	<center>-Invalid User-</center>
@endif	