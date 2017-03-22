@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
    <div>
      <i class="fa fa-group"></i>
      <h1>
      <span class="page-title">Employee List</span>
      <small>
      Employee 201 files
      </small>
      </h1>
      <div class="dropdown pull-right">
        <button class="btn btn-custom-primary dropdown-toggle " type="button" data-toggle="dropdown"><i class="fa fa-gears"></i>&nbsp;Operation
        <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-custom">
          <li><a href="#" class="popup" link="/member/payroll/employee_list/modal_create_employee" size="lg"><i class="fa fa-plus"></i>&nbsp;Create Employee</a></li>
          <li><a href="#" class="popup" link="/member/payroll/employee_list/modal_import_employee"><i class="fa fa-upload"></i>&nbsp;Import From Excel</a></li>
        </ul>
      </div>
      
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
    </div>
  </div>
</div>
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#active-employee-tab"><i class="fa fa-star"></i>&nbsp;Active Employee</a></li>
  <li><a data-toggle="tab" href="#separated-employee-tab"><i class="fa fa-scissors"></i>&nbsp;Separated Employee</a></li>
</ul>
<div class="tab-content tab-pane-div padding-top-10">
  <div id="active-employee-tab" class="tab-pane fade in active">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="col-md-12 filter-div">
          <div class="col-md-2 padding-lr-1">
            <small>Filter by Company</small>
            <select class="form-control filter-change filter-change-company" data-target="#active-employee">
              <option value="0">Select Company</option>
              @foreach($_company as $company)
              <option value="{{$company->payroll_company_id}}">{{$company->payroll_company_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 padding-lr-1">
            <small>Filter by Status</small>
            <select class="form-control filter-change filter-change-status" data-target="#active-employee">
              <option value="0">Select Status</option>
              @foreach($_status_active as $stat_act)
              <option value="{{$stat_act->payroll_employment_status_id}}">{{$stat_act->employment_status}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 pull-right padding-lr-1">
            <small>Search Employee</small>
            <i class="fa fa-search calendar-icon pos-absolute" aria-hidden="true" style="margin-left:-76px"></i>
            <input type="search" name="" class="form-control indent-18" placeholder="Search employee here">

          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12" id="active-employee">
          <div class="load-data" target="value-id-1">
            <div id="value-id-1">
              <table class="table table-condensed table-bordered">
                <thead>
                  <tr>
                    <th>Employee No</th>
                    <th>Employee Name</th>
                    <th>Employee Company</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                @foreach($_active as $active)
                <tr>
                  <td>
                    {{$active->payroll_employee_number}}
                  </td>
                  <td>
                    {{$active->payroll_employee_display_name}}
                  </td>
                  <td>
                    {{$active->payroll_company_name}}
                  </td>
                  <td>
                    {{$active->payroll_department_name}}
                  </td>
                  <td>
                    {{$active->payroll_jobtitle_name}}
                  </td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                          <a href="#" class="popup" link="/member/payroll/employee_list/modal_employee_view/{{$active->payroll_employee_id}}" size="lg"><i class="fa fa-search"></i>&nbsp;View</a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </table>
              <div class="pagination"> {!! $_active->render() !!} </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <div id="separated-employee-tab" class="tab-pane fade">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="col-md-12 filter-div">
          <div class="col-md-2 padding-lr-1">
            <small>Filter by Company</small>
            <select class="form-control filter-change-company filter-change" data-target="#separated-employee">
              <option value="0">Select Company</option>
              @foreach($_company as $company)
              <option value="{{$company->payroll_company_id}}">{{$company->payroll_company_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 padding-lr-1">
            <small>Filter by Status</small>
            <select class="form-control filter-change-status filter-change" data-target="#separated-employee">
              <option value="0">Select Status</option>
              @foreach($_status_separated as $stat_sep)
              <option value="{{$stat_sep->payroll_employment_status_id}}">{{$stat_sep->employment_status}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12" id="separated-employee">
          <div class="load-data" target="value-id-2">
            <div id="value-id-2">
              <table class="table table-condensed table-bordered">
                <thead>
                  <tr>
                    <th>Employee No</th>
                    <th>Employee Name</th>
                    <th>Employee Company</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                @foreach($_separated as $separated)
                <tr>
                  <td>
                    {{$separated->payroll_employee_number}}
                  </td>
                  <td>
                    {{$separated->payroll_employee_display_name}}
                  </td>
                  <td>
                    {{$separated->payroll_company_name}}
                  </td>
                  <td>
                    {{$separated->payroll_department_name}}
                  </td>
                  <td>
                    {{$separated->payroll_jobtitle_name}}
                  </td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                          <a href="#" class="popup" link="/member/payroll/employee_list/modal_employee_view/{{$separated->payroll_employee_id}}" size="lg"><i class="fa fa-search"></i>&nbsp;View</a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </table>
              <div class="pagination"> {!! $_separated->render() !!} </div>
            </div>
          </div>
        </div>
      </div>
    </div>    
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/employeelist.js"></script>
<script type="text/javascript">
  function loading_done_paginate (data)
  {
    console.log(data);
  }
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection