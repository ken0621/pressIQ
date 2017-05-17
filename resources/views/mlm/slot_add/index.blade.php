<link rel="stylesheet" href="/assets/external/chosen/chosen/chosen.css" media="screen"/>
<center>
<div>
	<form class="global-submit" method="post" action="/mlm/claim/slot">
	{!! csrf_field() !!}
	<div>
		<table class="table">
			<tr>
				<td>
					<div class="col-md-12">
						<label>PIN</label>
						<input type="number" class="form-control" name="membership_code_id" style="border-radius: 7px; width: 100%" >
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-12">
						<label>MEMBERSHIP CODE</label>
						<input type="text" class="form-control" name="membership_activation_code" style="border-radius: 7px; width: 100%">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<!-- Binary Placing Settings -->
					<div class="col-md-12">
						@if($lead == null)
						<label for="">Sponsor</label>
                            <select class="form-control chosen-slot_sponsor input-sm pull-left" name="slot_sponsor" data-placeholder="Select Slot Sponsor" >
                            	@if(count($_slots) != 0)
                            		@foreach($_slots as $slot)
                            			<option value="{{$slot->slot_id}}">{{$slot->first_name}} {{$slot->middle_name}} {{$slot->last_name}} ({{$slot->slot_no}})</option>
                            		@endforeach
                            	@endif
                            </select>
						@else
						<input type="hidden" name="lead_id" value="{{$lead->lead_id}}">
						<input type="hidden" name="slot_sponsor" value="{{$lead->lead_slot_id_sponsor}}">
						<input type="text" class="form-control" name="sponsor" value="{{$lead->mlm_username}} (Slot - {{$lead->slot_no}}) {{$lead->membership_activation_code}}" readonly>
						@endif
					</div>
	                @if(isset($binary_settings->marketing_plan_enable))
	                    @if($binary_settings->marketing_plan_enable == 1)
	                        @if(isset($binary_advance->binary_settings_placement))
	                            @if($binary_advance->binary_settings_placement == 0)
	                                <div class="col-md-12">
	                                    <label for="">Slot Placement (Binary)</label>
	                                    <!-- <input type="text" class="form-control" name="slot_placement"> -->
	                                    <select class="form-control chosen-slot_sponsor input-sm pull-left" name="slot_placement" data-placeholder="Select Slot Placement" >
			                            	@if(count($_slots) != 0)
			                            		@foreach($_slots as $slot)
			                            			<option value="{{$slot->slot_id}}" @if($placement == $slot->slot_id) selected @endif >{{$slot->first_name}} {{$slot->middle_name}} {{$slot->last_name}} ({{$slot->slot_no}})</option>
			                            		@endforeach
			                            	@endif
			                            </select>
	                                </div>
	                                <div class="col-md-12">
	                                <!-- placement -->
	                                    <label for="">Slot Position</label>
	                                    {!! mlm_slot_postion('left', $position) !!}
	                                </div>
	                            @elseif($binary_advance->binary_settings_placement == 1)

	                                <div class="col-md-12">
	                                    <label for="">Slot Placement (Binary) <span style="color: red;">Auto Placement</span></label>
	                                    <input type="text" class="form-control" name="slot_placement" disabled="disabled">
	                                </div>

	                                <div class="col-md-12">
	                                    <label for="">Slot Position <span style="color: red;">Auto Placement</span></label>
	                                    <select class="form-control chosen-slot_position" name="slot_position" disabled="disabled">
	                                        <option value="left">left</option>
	                                        <option value="right">right</option>
	                                    </select>
	                                </div>
	                            @endif
	                        @else
	                            <center></center>
	                        @endif
	                    @else

	                    @endif
	                @else
	                    <center></center>
	                @endif
				</td>
			</tr>
			<tr>
				<td>
					<button class="btn btn-primary pull-right" id="rcorners3">SUBMIT</button>
				</td>
			</tr>
			<tr>
				<td class="append_error"></td>
			</tr>
		</table>
	</div>
	</form>
</div>
</center>
<script type="text/javascript" src="/assets/external/chosen/chosen/chosen.jquery.js"></script>
<script>
	function submit_done(data)
	{
		if(data.response_status == "warning")
    	{
    		var erross = data.warning_validator;
    		$.each(erross, function(index, value) 
    		{
    		    toastr.warning(value);
    		}); 
    	}
    	else if(data.response_status == 'warning_2')
    	{
    		toastr.warning(data.error);
    	}
    	else if(data.response_status == 'success_add_slot')
    	{
    		toastr.success('Congratulations, Your slot is created.');
    		toastr.success('Please, Login again for the changes to take effect');
    		window.location = "/mlm/login";
    	}
	}

</script>
<script type="text/javascript">

	$(".chosen-slot_sponsor").chosen({no_results_text: "The slot doesn't exist.", width: '100%'});
	$(".chosen-slot_position").chosen({no_results_text: "Invalid Position", width: '100%'});
</script>