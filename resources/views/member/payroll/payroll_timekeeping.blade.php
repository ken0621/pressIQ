@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-calendar"></i>
			<h1>
			<span class="page-title">Time Keeping</span>
			<small>
			Manage your Time Keeping
			</small>
			</h1>
			<div class="dropdown pull-right">
				<button class="btn btn-custom-primary dropdown-toggle " type="button" data-toggle="dropdown"><i class="fa fa-gears"></i>&nbsp;Operation
				<span class="caret"></span></button>
				<ul class="dropdown-menu dropdown-menu-custom">
					<li><a href="#" class="popup" link="/member/payroll/time_keeping/modal_generate_period"><i class="fa fa-plus"></i>&nbsp;Generate Period</a></li>
					<li><a href="#" class="popup" link="/member/payroll/import_bio/modal_biometrics"><i class="fa fa-upload"></i>&nbsp;Import Time Sheet</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default panel-block">
	<div class="panel-body">
		
	</div>
</div>
@endsection
@section('script')
@endsection