<form class="global-submit" method="post" action="{{$action}}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="event_id" value="{{ $event->event_id or '' }}">
	<div class="modal-body clearfix">
		<div class="top-head row clearfix">
			<div class="col-md-4">
				<div class="header-logo">
					<img class="h-logo" src="/themes/{{ $shop_theme }}/img/header-logo.png">
				</div>
			</div>
			<div class="col-md-8">
				<div class="head-title">
					<h1>BROWN&PROUD ACADEMY</h1>
					<h2>{{$event->event_title}}</h2>
					<h3>OFFICIAL APPLICATION FORM</h3>
					<h2>{{strtoupper(date('M d, Y', strtotime($event->event_date)))}}</h2>
				</div>
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-4">
				<input type="text" class="form-control primary-fill" placeholder="FAMILY NAME" name="reservee_lname" value="{{$customer_details->last_name or ''}}">
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control primary-fill" placeholder="FIRST NAME" name="reservee_fname" value="{{$customer_details->first_name or ''}}">
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control primary-fill" placeholder="MIDDLE NAME" name="reservee_mname" value="{{$customer_details->middle_name or ''}}">
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-12">
				<textarea class="form-control" placeholder="ADDRESS" name="reservee_address" style="height: 150px">{{$customer_address->customer_street or '' }} {{$customer_address->customer_city or '' }} {{$customer_address->customer_state or ''}}</textarea>
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-12">
				<input type="text" class="form-control" name="reservee_contact" placeholder="CONTACT INFO (Email/Mobile Number)" value="{{$customer_details->email or ''}}">
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-12">
				<input type="text" class="form-control" name="reservee_enrollers_code" placeholder="ENROLLERS CODE">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div  ><button class="reg-button" type="submit">SUBMIT</button> </div>
	</div>
</form>
<div class="mob-close" style="display: none;" data-dismiss="modal">
	<img src="/themes/{{ $shop_theme }}/img/mob-close.png">
</div>

<style type="text/css">
	.modal-content-global
	{
		border-radius: 0 !important;
	}
	.modal-body
	{
		padding-top: 0 !important;
	}
	.top-head
	{
		background-color: #593620 !important;
		margin-bottom: 15px;
	}
	.header-logo
	{
		text-align: center;
	}
	.head-title
	{
		text-align: center;
		margin-top: 20px;
	}
	h1
	{
		font-size: 24px;
		font-weight: 500;
		color: #fff;
		margin: 0;
		padding-bottom: 10px;
	}
	h2
	{
		font-size: 13px;
		font-weight: 400;
		color: #fff;
		margin: 0;
		padding-bottom: 10px;
	}
	h3
	{
		font-size: 15px;
		font-weight: 400;
		color: #e5d8b5;
		margin: 0;
		padding-bottom: 10px;
	}
	.form-control
	{
		border-radius: 0 !important;
		border: 1px solid #b5a195 !important;
		font-weight: 300;
	}
	.h-logo
	{
		width: 100%;
	}
	.reg-button
	{
		background-color: #593620;
		padding: 10px 0;
		text-align: center;
		width: 100%;
		color: #fff;
		font-weight: 400;
		border: none;
	}
	.reg-button:hover
	{
		cursor: pointer;
		background-color: #603a23 !important;
	}
	@media screen and (max-width: 991px)
	{
		.primary-fill
		{
			margin-bottom: 12px;
		}
		.mob-close
		{
			display: block !important;
			position: absolute;
			top: 5px;
			right: 3px;
		}
		.h-logo
		{
			width: 50% !important;
		}
		.head-title
		{
			padding-bottom: 20px !important;
		}
	}	
</style>

<script type="text/javascript">
	function success_reserve(data)
	{
		if(data.status == 'success')
		{
		    toastr.success('Success');
		    setInterval(function()
		    {
		    	location.reload();
		    },2000);
		}
	}
</script>


















