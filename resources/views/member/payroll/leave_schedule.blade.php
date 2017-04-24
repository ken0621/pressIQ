@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-calendar"></i>
			<h1>
			<span class="page-title">Leave Scheduling</span>
			<small>
			Manage Leaves
			</small>
			</h1>
			<button class="btn btn-custom-primary panel-buttons pull-right popup" link="/member/payroll/leave_schedule/modal_create_leave_schedule">Create Schedule</button>
			<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
		</div>
	</div>
</div>
<div class="panel panel-default panel-block">
	<div class="panel body">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#upcoming-leave">Upcoming Leave</a></li>
			<li><a data-toggle="tab" href="#used-leave">Used Leave</a></li>
		</ul>
		<div class="tab-content padding-5">
			<div id="upcoming-leave" class="tab-pane fade in active">
				
			</div>
			<div id="used-leave" class="tab-pane fade">
				
			</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
@endsection