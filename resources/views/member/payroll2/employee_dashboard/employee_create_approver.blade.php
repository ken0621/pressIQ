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
	    	<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<small>Approver Group Name</small>
				<input class="form-control"  placeholder="" required>
			</div>
			<div class="col-md-3">
			</div>
	    </div>
	    <div class="form-group">
	    	<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<small>Name of Employee</small>
				<input class="form-control"  placeholder="" required>
			</div>
			<div class="col-md-3">
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