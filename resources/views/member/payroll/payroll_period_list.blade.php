@extends('member.layout')
@section('css')
@endsection

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
    <div>
      <i class="fa fa-calendar"></i>
      <h1>
      <span class="page-title">Payroll Period</span>
      <small>
      	Manage your paryoll period
      </small>
      </h1>
      <button class="btn btn-custom-primary panel-buttons pull-right popup" link="/member/payroll/payroll_period_list/modal_create_payroll_period">Create Period</button>
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/payorll_period_list.js"></script>
@endsection