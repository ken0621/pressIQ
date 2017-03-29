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
	<div class="panel-body">
   @foreach($_period as $period)
   <div class="custom-panel">
     <div class="custom-panel-header">{{date('M d, Y',strtotime($period->payroll_period_start))}} to {{date('M d, Y',strtotime($period->payroll_period_end))}} ({{$period->payroll_period_category}})</div>
     <div class="triangle-top-right"></div>
     <div class="custom-panel-body"></div>
   </div>
   @endforeach
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/payroll_process.js"></script>
@endsection