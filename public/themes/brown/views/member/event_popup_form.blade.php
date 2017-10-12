<form class="global-submit" method="post" action="{{$action}}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="event_id" value="{{ $event->event_id or '' }}">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">{{strtoupper($event->event_title)}}</h4>
	</div>
	<div class="modal-body clearfix">
		<div class="form-group clearfix">
			<div class="col-md-4">
				<input type="text" class="form-control" placeholder="FAMILY NAME" name="reservee_fname" value="{{$customer_details->last_name or ''}}">
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control" placeholder="FIRST NAME" name="reservee_mname" value="{{$customer_details->first_name or ''}}">
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control" placeholder="MIDDLE NAME" name="reservee_lname" value="{{$customer_details->middle_name or ''}}">
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
		<button class="btn btn-primary btn-custom-primary form-control" type="submit">SUBMIT</button>
	</div>
</form>
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

















