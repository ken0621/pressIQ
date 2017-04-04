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
      <div class="custom-panel-header cursor-pointer">{{date('M d, Y',strtotime($period['period']->payroll_period_start))}} to {{date('M d, Y',strtotime($period['period']->payroll_period_end))}} ({{$period['period']->payroll_period_category}})</div>
      <div class="width-100 display-table">
        <div class="triangle-top-right"></div>
        <div class="custom-panel-body">
          <div class="custom-panel-child display-none">
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th class="text-center">Employee name</th>
                  <th class="text-center">Gross Salary</th>
                  <th class="text-center">Deductions</th>
                  <th class="text-center">Net Salary</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($period['_list'] as $list)
                <tr>
                  <td>
                    {{$list['payroll_employee_display_name']}}
                  </td>
                  <td class="text-right">
                    {{number_format($list['total_gross'], 2)}}
                  </td>
                  <td class="text-right">
                    {{number_format($list['total_deduction'], 2)}}
                  </td>
                  <td class="text-right">
                    {{number_format($list['total_net'], 2)}}
                  </td>
                  <td class="text-center">
                    <button class="btn btn-custom-white btn-xs popup" link="/member/payroll/payroll_process/payroll_compute_brk_unsaved/{{$list['payroll_employee_id']}}/{{$period['period']->payroll_period_company_id}}" size="lg" type="button"><i class="fa fa-search"></i>&nbsp;View</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody>
                <tr>
                  <td class="text-right">
                    <b>Total</b>
                  </td>
                  <td class="text-right">
                    <b>{{number_format($period['total_gross'], 2)}}</b>
                  </td>
                  <td class="text-right">
                    <b>{{number_format($period['total_deduction'], 2)}}</b>
                  </td>
                  <td class="text-right">
                    <b>{{number_format($period['total_net'], 2)}}</b>
                  </td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>
    @endforeach
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/payroll_process.js"></script>
@endsection