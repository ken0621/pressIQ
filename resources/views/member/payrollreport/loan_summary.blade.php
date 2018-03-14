@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll Reports &raquo; Loan Summary</span>
                <small>
                Select employee to view loan summary
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">

    <div class="col-md-12">

        <div class="col-md-3">
                <select class="select-company-name pull-right form-control">    
                    <option value="0">All Company</option>
                      @foreach($_company as $company)
                      <option value="{{$company['company']->payroll_company_id}}">{{$company['company']->payroll_company_name}}</option> 
                        @foreach($company['branch'] as $branch)
                            <option value="{{$branch->payroll_company_id}}">&nbsp;&nbsp;• {{$branch->payroll_company_name}}</option>
                        @endforeach
                      @endforeach
                </select>
        </div>

        <div class="col-md-3">
                <select class="form-control filter-by-branch" name="branch_location_id">
                  <option value="0">Select Branch</option>
                  @foreach($_branch as $branch)
                  <option value="{{$branch->branch_location_id}}">{{$branch->branch_location_name}}</option>
                  @endforeach
                </select>
        </div>

        <div class="col-md-3">
            <select class="select-deduction-type pull-right form-control" name="deduction_type">    
                <option value="novalue">Select Deduction Type</option>
                <option value="SSS_Loan">SSS Loan</option>
                <option value="HDMF_Loan">HDMF Loan</option>
                <option value="Cash_Bond">Cash Bond</option>
                <option value="Others">Others...</option>
            </select>
        </div>

        <div class="col-md-3">
            <a href="/member/payroll/reports/loan_summary/loan_summary_report_excel/0/noval/0" class="excel_tag"><button type="button" class="btn btn-success pull-right" style="margin-right:20px;"><i class="fa fa-file-excel-o" ></i> &nbsp;EXPORT TO EXCEL</button></a>
        </div>


    </div>


        <div class="form-group tab-content panel-body employee-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive loan-summary-table-load">
                    
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/payroll/js/loan_summary.js"></script>
<script>
    $(".select-company-name").unbind("change");
    $(".select-company-name").bind("change", function()
    {
        var branch = $('.filter-by-branch').val();
        var link = "/member/payroll/reports/loan_summary/loan_summary_report_excel/" + $(this).val() +"/noval" +"/"+ branch;
         $(".excel_tag").attr('href',link);
    });

    $('select[name=deduction_type]').change(function() 
    {
        var company = $('.select-company-name').val();
        var branch = $('.filter-by-branch').val();
        var link = "/member/payroll/reports/loan_summary/loan_summary_report_excel/"+ company +"/" + $(this).val() + "/" + branch;
         $(".excel_tag").attr('href',link);
    });

    $('.filter-by-branch').on("change",function(e) 
    {
        var company = $('.select-company-name').val();
        var deduc = $('.select-deduction-type').val();
        var link = "/member/payroll/reports/loan_summary/loan_summary_report_excel/"+ company +"/noval" + "/" + $(this).val();
         $(".excel_tag").attr('href',link);

    });

    </script>
@endsection