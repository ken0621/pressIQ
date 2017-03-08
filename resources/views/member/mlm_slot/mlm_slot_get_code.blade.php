<label>Membership Code</label>
<select class="form-control chosen-membership_code_id input-sm pull-left" name="membership_code_id" data-placeholder="Select a membership code" >
    <option value=""></option>
	@if(count($membership_code) != 0)
		@foreach($membership_code as $membership)
			<option value="{{$membership->membership_code_id}}">{{$membership->membership_activation_code}} ({{$membership->membership_type}})</option>
		@endforeach
	@endif
</select>