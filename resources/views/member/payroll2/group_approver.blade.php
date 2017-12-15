@extends('member.layout')
<link href="/assets/select2/css/select2.min.css" rel="stylesheet" />
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
           <button class="btn btn-primary pull-right popup" link='/member/payroll/payroll_admin_dashboard/modal_create_group_approver' size='md'>Create Approver Group</button>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block load-data">
  <div class="table">
    <table class="table table-bordered table-condensed table-hover">
      <thead>
         <th class="text-center">Approver Group Name</th>
         <th class="text-center">Approver Group Type</th>
         <th class="text-center">Approver Group Level</th>
         <th class="text-center">Action</th>
      </thead>
      <tbody>
         @foreach($_group_approver as $group_approver)
         <tr>
           <td class="text-center">{{  $group_approver->payroll_approver_group_name  }}</td>
           <td class="text-center">{{  $group_approver->payroll_approver_group_type  }}</td>
           <td class="text-center">{{  $group_approver->payroll_approver_group_level  }}</td>
           <td class="text-center">
             <div class="dropdown">
               <button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
               <span class="caret"></span></button>
               <ul class="dropdown-menu dropdown-menu-custom">
                 <li>
                   <a href="#" class="popup" link="/member/payroll/payroll_admin_dashboard/modal_edit_group_approver/{{$group_approver->payroll_approver_group_id}}" size='md'><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                 </li>
                 <li>
                   <a href="#" class="popup" link="#" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archive</a>
                 </li>
               </ul>
             </div>
           </td>
         </tr>
         @endforeach
      </tbody>
    </table>
  </div>
</div>
<script src="/assets/select2/js/select2.min.js"></script>

@endsection('content')


