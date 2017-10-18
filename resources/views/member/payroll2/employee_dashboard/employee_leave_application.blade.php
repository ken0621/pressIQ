@extends('member.payroll2.employee_dashboard.employee_layout')
@section('content')
<div class="page-title">
    <h3>{{ $page }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="/employee">Home</a></li>
            <li class="active">{{ $page }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-default">
	<div class="modal-body form-horizontal">
		<div class="form-group">
	    	<div class="col-md-6">
				<small>Name of Employee</small>
				<select class="form-control" required>
					<option value="">Select Employee</option>
				</select>
			</div>
			<div class="col-sm-6">
				<small>Department</small>
				<select class="form-control" required>
					<option value="">Select Department</option>
				</select>
			</div>
	    </div>
	    <div class="form-group">
	    	<div class="col-md-6">
				<small>Group of Approver</small>
				<select class="form-control" required>
					<option value="">Select Approver</option>
				</select>
			</div>
			<div class="col-sm-6">
				<small>Reliever</small>
				<select class="form-control" required>
					<option value="">Select Reliever</option>
				</select>
			</div>
	    </div>
	    <div class="form-group">
			<div class="col-sm-6">
				<input id="checkBox" type="checkbox">
				<small>Create your own Approver?</small>
			</div>
	    </div>
	    <div class="form-group">
	        <div class="col-sm-2">
				<small>Total hours of leave</small>
				<input class="form-control" type="number" placeholder="1.0" step="0.01" min="0" max="10" value='96' disabled>
			</div>
			<div class="col-md-2">
				<small>Used</small>
				<input class="form-control" type="number" placeholder="1.0" step="0.01" min="0" max="10" value='8.5' disabled>
			</div>
			<div class="col-md-2">
				<small>Unused</small>
				<input class="form-control" type="number" placeholder="1.0" step="0.01" min="0" max="10" value='87.5' disabled>
			</div>
	    </div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Type of Leave</small>
				<select class="form-control" required>
					<option value="">Select Type of Leave</option>
				</select>
			</div>
			<div class="col-md-3">
				<small>Number of Days</small>
				<input class="form-control" type="number"  placeholder="0" required>
			</div>
			<div class="col-md-3">
				<small>Number of Hour/s</small>
				<input class="form-control" type="number" placeholder="1.0" step="0.01" min="0" max="10">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Date: From</small>
				<input class="form-control" id="date" type="date" placeholder="mm/dd/yyyy" required>
			</div>
			<div class="col-md-6">
				<small>To</small>
				<input class="form-control" id="date" type="date" placeholder="mm/dd/yyyy" disabled>
			</div>
		</div>
		<div class="form-group">
	        <div class="col-sm-12">
	        <small>Reason for Leave</small>
	        	<textarea class="form-control" name="other_info" rows="4" required></textarea>
	        </div>
	    </div>
	    <div class="form-group">
	        <div class="col-sm-6">
	        <small>Location while on leave</small>
	        	<input type="text" class="form-control">
	        </div>
			<div class="col-md-6">
				<small>Contact No.</small>
				<input class="form-control" type="text" class="form-control">
			</div>
	    </div>
	</div>
</div>
<div class="modal-footer">
	<button type="button"  class="btn btn-primary btn-md">Cancel</button>
	<button type="submit"  class="btn btn-primary btn-md">Submit</button>
</div>
</form>
@endsection