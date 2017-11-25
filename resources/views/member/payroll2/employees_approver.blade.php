@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll Reports &raquo; Register Report</span>
                <small>
                select payroll period.
                </small>
            </h1>
           <button class="btn btn-primary pull-right" onclick="action_load_link_to_modal('/member/payroll/payroll_admin_dashboard/modal_create_approver', 'sm')">Create Approver</button>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
                <thead style="text-transform: uppercase">
                    <tr>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Period Type</th>
                        <th class="text-center">Covered Month</th>
                        <th class="text-center">Period Order</th>
                        <th class="text-center">Period Type</th>
                        <th class="text-center">Covered Month</th>
                        <th class="text-center">Period Order</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection('content')
@section('script')
<script type="text/javascript"></script>
@endsection('script')