@extends('member.layout')

@section('css')
@endsection

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-group"></i>
			<h1>
			<span class="page-title">Employee List</span>
			<small>
			Employee 201 files
			</small>
			</h1>
			<button class="btn btn-custom-primary panel-buttons pull-right popup" link="/member/payroll/employee_list/modal_create_employee" size="lg">Create Employee</button>
			<input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
		</div>
	</div>
</div>
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#active-employee"><i class="fa fa-star"></i>&nbsp;Active Employee</a></li>
  <li><a data-toggle="tab" href="#separated-employee"><i class="fa fa-scissors"></i>&nbsp;Separated Employee</a></li>

</ul>

<div class="tab-content tab-pane-div">
  <div id="active-employee" class="tab-pane fade in active">

  </div>
  <div id="separated-employee" class="tab-pane fade">
 
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/employeelist.js"></script>
@endsection