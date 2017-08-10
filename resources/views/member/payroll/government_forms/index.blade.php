@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-paperclip"></i>
			<h1>
			<span class="page-title">Government Forms</span>
			<small>
			SSS, Pagibig, BIR
			</small>
			</h1>
			<!-- <button class="btn btn-custom-white panel-buttons pull-right popup" link="/member/payroll/company_list/modal_create_company?is_sub=true">Create Sub-Company/Branch</button> -->
			<!-- <button class="btn btn-custom-primary panel-buttons pull-right popup" link="/member/payroll/company_list/modal_create_company">Create Company</button> -->
			<!-- <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"> -->
		</div>
	</div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
        <div class="row clearfix">
        	<div class="col-md-4">
        		<button onClick="location.href='/member/payroll/report/government_forms_sample/sss'" class="btn btn-primary" type="button" style="width: 100%;">SSS</button>
        	</div>
        	<div class="col-md-4">
        		<button onClick="location.href='/member/payroll/report/government_forms_sample/pagibig'" class="btn btn-primary" type="button" style="width: 100%;">Pagibig</button>
        	</div>
        	<div class="col-md-4">
        		<button onClick="location.href='/member/payroll/report/government_forms_sample/bir'" class="btn btn-primary" type="button" style="width: 100%;">BIR</button>
        	</div>
        </div>
    </div>
</div>
@endsection
@section('css')

@endsection
@section('script')

@endsection
