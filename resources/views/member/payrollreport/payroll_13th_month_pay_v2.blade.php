@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll Reports &raquo; Payroll 13th Month Pay</span>
                <small>
               	select employee
                </small>
            </h1>
            <button class="btn btn-primary pull-right modal-13th-pay-basis-button">Compute 13th Month Pay</button>
        </div>
    </div>
</div>
<div class="form-group order-tags load-data" target="value-id-1"></div>
    <div class="clearfix">
        <div class="col-md-12">
            <div class="table-responsive employees-13th-month-pay" id="value-id-1">
				
      		</div>
        </div>
    </div>

@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<script type="text/javascript" src="/assets/member/payroll/js/payroll_employees_13th_month_pay.js"></script>
@endsection
