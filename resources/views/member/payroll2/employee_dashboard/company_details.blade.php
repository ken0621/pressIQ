@extends('member.payroll2.employee_dashboard.layout')
@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
  </ol>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $company->payroll_company_logo }}" class="rounded float-right" alt="{{ $company->payroll_company_name }}" height="200" width="200">
            <h3 class="text-center">{{ $company->payroll_company_name }}</h3>
            <hr>
            <ul class="list-unstyled text-center">
                <li><p><i class="fa fa-map-marker" style="font-size:18px;color:#ff1a1a"></i> {{ $company->payroll_company_address }}</p></li>
                <li><p><i class="fa fa-phone-square" style="font-size:18px"></i> {{ $company->payroll_company_contact}} </p></li>
                <li><p><i class="fa fa-envelope m-r-xs" style="color:#4db8ff"></i><a href="#"> {{ $company->payroll_company_email }} </a></p></li>
            </ul>
        </div>
        <div class="col-md-9 m-t-lg">
            <div class="row">
                <div class="col-md-12">
                    <small>Company Name</small>
                    <input type="text" placeholder="Company Name" class="form-control view-form" required value="{{$company->payroll_company_name}}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <small>Company Code</small>
                    <input type="text" placeholder="Company Code" class="form-control view-form" required value="{{$company->payroll_company_code}}" disabled>
                </div>
                <div class="col-md-6">
                    <small>Company RDO</small>
                    <select class="form-control view-form" name="payroll_company_rdo" disabled>
                        <option value=""></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit"  class="btn btn-primary btn-md">Edit</button>
</div>


@endsection
