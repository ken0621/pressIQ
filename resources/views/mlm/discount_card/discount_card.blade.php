<form class="global-submit form-horizontal" id="submit_discount_card" role="form" action="/mlm/report/discount_add/use/submit" method="post">
	{!! csrf_field() !!}
	<input type="hidden" name="discount_card_log_id_a" value="{{Request::input('discount_card_log_id')}}">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Give Discount Card</h4>
	</div>
	<div class="modal-body clearfix">
		<div class="col-md-12">
		@if($discount_card_log_id != null)
		
			<label>Search username</label>
			<select name="customer_id" class="form-control search_customers" name="customer_id" onChange="customer_change(this)">
				@foreach($customers as $key => $value)
					<option value="{{$value->customer_id}}" @if($key == 0) selected @endif>{{$value->mlm_username}}</option>
				@endforeach
			</select>
 		</div>
 		<div class="col-md-12 custom_profile"></div>
 		@else
 		<center>Invalid Discount Card</center>
 		@endif
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button" onclick="submit_form_a()">Submit</button>
	</div>
</form>
<script type="text/javascript">
	$(".search_customers").chosen({no_results_text: "The customer doesn't exist."});
function customer_change (ito) {
    $('.custom_profile').html('<div style="margin: 100px auto;" class="loader-16-gray"></div>');
    $('.custom_profile').load('/mlm/report/discount_card/use/get/customer/' + ito.value);
}
function submit_form_a()
{
	$('#submit_discount_card').submit();
}

function submit_done (data) 
{
	console.log(data);
	if(data.response_status == 'success')
	{
	  toastr.success(data.message);
	  location.reload();
	}
	if(data.response_status === 'warning')
	{
	  toastr.warning(data.message);
	}
	else if(data.response_status == "warning_2")
	{
	  var erross = data.warning_validator;
	  $.each(erross, function(index, value) 
	  {
	      toastr.error(value);
	  }); 
	}
}
</script>
