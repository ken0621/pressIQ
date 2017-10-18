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
				<small>Date</small>
				<input class="form-control" type="text" class="form-control" required>
			</div>
			<div class="col-md-3">
				<small>Time in</small>
				<input class="form-control" type="text" class="form-control">
			</div>
			<div class="col-md-3">
				<small>Time out</small>
				<input class="form-control" type="text" class="form-control">
			</div>
		</div>
		<div class="form-group">
            <div class="col-sm-12">
            <small>Remarks</small>
            	<textarea class="form-control" name="other_info" rows="4" required></textarea>
            </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="button"  class="btn btn-primary btn-md">Cancel</button>
		<button type="submit"  class="btn btn-primary btn-md">Submit</button>
	</div>
</form>
@endsection