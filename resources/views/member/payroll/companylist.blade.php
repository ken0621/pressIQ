@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-building-o"></i>
			<h1>
			<span class="page-title">Company List</span>
			<small>
			List of Company
			</small>
			</h1>
			<button class="btn btn-custom-primary panel-buttons pull-right popup" link="/member/payroll/company_list/modal_create_company">Create Company</button>
			<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
		</div>
	</div>
</div>
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#active-company"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Active Company</a></li>
	<li><a data-toggle="tab" href="#archived-company"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Archived Company</a></li>
</ul>
<div class="tab-content tab-pane-div">
	<div id="active-company" class="tab-pane fade in active">
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center">Company Name</th>
					<th class="text-center">Company Code</th>
					<th class="text-center">Company RDO</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($_active as $active)
				<tr>
					<td>
						{{$active->payroll_company_name}}
					</td>
					<td class="text-center">
						{{$active->payroll_company_code}}
					</td>
					<td class="text-center">
						{{$active->rdo_code}}
					</td>
					<td class="text-center">
						<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="/member/payroll/company_list/view_company_modal/{{$active->payroll_company_id}}" ><i class="fa fa-search"></i>&nbsp;View</a>
								</li>
								<li>
									<a href="#" class="popup" link="/member/payroll/company_list/edit_company_modal/{{$active->payroll_company_id}}" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" data-content="{{$active->payroll_company_id}}" data-archived="1" class="btn-archived"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div id="archived-company" class="tab-pane fade">
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center">Company Name</th>
					<th class="text-center">Company Code</th>
					<th class="text-center">Company RDO</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($_archived as $archived)
				<tr>
					<td>
						{{$archived->payroll_company_name}}
					</td>
					<td class="text-center">
						{{$archived->payroll_company_code}}
					</td>
					<td class="text-center">
						{{$archived->rdo_code}}
					</td>
					<td class="text-center">
						<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="/member/payroll/company_list/view_company_modal/{{$archived->payroll_company_id}}" ><i class="fa fa-search"></i>&nbsp;View</a>
								</li>
								<li>
									<a href="#" class="popup" link="/member/payroll/company_list/edit_company_modal/{{$archived->payroll_company_id}}" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" data-content="{{$archived->payroll_company_id}}" data-archived="0" class="btn-archived"><i class="fa fa-recycle"></i>&nbsp;Re-use</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/companylist.js"></script>
@endsection