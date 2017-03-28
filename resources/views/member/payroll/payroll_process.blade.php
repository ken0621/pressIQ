@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
    <div>
      <i class="fa fa-calculator"></i>
      <h1>
      <span class="page-title">Payroll Process</span>
      <small>
      Payroll Computation
      </small>
      </h1>
      <button class="btn btn-custom-primary pull-right popup" link="/member/payroll/payroll_process/modal_create_process">Create Process</button>
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
    </div>
  </div>
</div>
<div class="panel panel-default panel-block">
	<div class="panel-body"></div>
</div>
@endsection
@section('script')
@endsection