@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Admin Dashboard &raquo; Employee Approver</span>
                <small>
                select employee.
                </small>
            </h1>
           <button class="btn btn-primary pull-right" onclick="action_load_link_to_modal('/member/payroll/payroll_admin_dashboard/modal_create_approver', 'md')">Create Approver</button>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
   
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#leave-approver"><i class="fa fa-calendar" aria-hidden="true" style="font-size: 19px; vertical-align: middle;"></i>    Leave Approver</a></li>
        <li><a data-toggle="tab" href="#ot-approver"><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 23px; vertical-align: middle;"></i>    Over Time Approver</a></li>
        <li><a data-toggle="tab" href="#rfp-approver"><i class="fa fa-money" aria-hidden="true" style="font-size: 23px; vertical-align: middle;"></i>    RFP Approver</a></li>
      </ul>

      <div class="tab-content tab-pane-div padding-top-10">
         <div id="leave-approver" class="tab-pane fade in active">
           <h3>HOME</h3>
           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
         </div>
         <div id="ot-approver" class="tab-pane fade">
           <h3>Menu 1</h3>
           <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
         </div>
         <div id="rfp-approver" class="tab-pane fade">
           <h3>Menu 2</h3>
           <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
         </div>
      </div>
</div>
@endsection('content')
@section('script')
<script type="text/javascript"></script>
<script type="text/javascript" src="/assets/js/payroll_employee_approver.js"></script>
@endsection('script')