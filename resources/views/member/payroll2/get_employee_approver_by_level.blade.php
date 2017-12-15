@foreach($approver_by_level as $key => $_approver)
	<div class="form-group">
	  <label for="multiple-select-2{{$key}}">Select Level {{$key}} Approver:</label><br>
	  <select id="multiple-select-2{{$key}}" class="multiple-select-2 form-control" name="approver_level[{{$key}}][]" multiple="multiple" style="width: 50%" required>
	    @foreach($_approver as $key2 => $approver)
	    	<option value="{{$approver->payroll_approver_employee_id}}"> {{$approver->payroll_employee_first_name}} {{$approver->payroll_employee_last_name}}</option>
	    @endforeach
	  </select>
	</div>
@endforeach




