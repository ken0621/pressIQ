@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Admin Dashboard &raquo; Group Approver</span>
                <small>
                select group.
                </small>
            </h1>
           <button class="btn btn-primary pull-right popup" link='/member/payroll/payroll_admin_dashboard/modal_create_group_approver' size='md'>Create Approver</button>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block load-data">
   
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#leave-approver"><i class="fa fa-calendar" aria-hidden="true" style="font-size: 19px; vertical-align: middle;"></i>    Leave Approver</a></li>
        <li><a data-toggle="tab" href="#ot-approver"><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 23px; vertical-align: middle;"></i>    Over Time Approver</a></li>
        <li><a data-toggle="tab" href="#rfp-approver"><i class="fa fa-money" aria-hidden="true" style="font-size: 23px; vertical-align: middle;"></i>    RFP Approver</a></li>
      </ul>

      <div class="tab-content tab-pane-div padding-top-10">

         <div id="leave-approver" class="tab-pane fade in active">
           
         </div>

         <div id="ot-approver" class="tab-pane fade">
           
         </div>

         <div id="rfp-approver" class="tab-pane fade">
           
         </div>
      </div>
</div>
@endsection('content')
@section('script')
<script type="text/javascript"></script>

@endsection('script')