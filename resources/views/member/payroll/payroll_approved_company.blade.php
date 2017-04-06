@extends('member.layout')
@section('css')
@endsection

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
    <div>
      <i class="fa fa-calculator"></i>
      <h1>
      <span class="page-title">Payroll Approved ({{$period->payroll_company_name}})</span>
      <small>
      {{$period->payroll_period_category}}&nbsp;({{date('F d, Y', strtotime($period->payroll_period_start))}} to {{date('F d, Y', strtotime($period->payroll_period_end))}})
      </small>
      </h1>
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
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