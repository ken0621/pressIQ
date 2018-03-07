@extends('member.layout')
@section('content')
 <input type="hidden" class="_token" value="{{ csrf_token() }}" />
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <div class="col-md-4.5">
            <h1>
                <span class="page-title">Payroll Reports &raquo; Payroll Ledger&nbsp;</span>
                <small>
               	select employee
                </small>
            </h1>
            </div>

            <div class="col-md-2">
            <select class="form-control filter-by-month" name="month">
              <option value="none">Select Month</option>
              @foreach($_month as $month)
              <option value="{{$month['month_name']}}">{{$month['month_name']}}</option>
              @endforeach
            </select>
            </div>

            <div class="col-md-3">
              <select class="select-company-name pull-right form-control" style="width: 250px">    
                <option value="0">All Company</option>
                  @foreach($_company as $company)
                  <option value="{{$company['company']->payroll_company_id}}">{{$company['company']->payroll_company_name}}</option> 
                    @foreach($company['branch'] as $branch)
                        <option value="{{$branch->payroll_company_id}}">&nbsp;&nbsp;• {{$branch->payroll_company_name}}</option>
                    @endforeach
                  @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control filter-by-branch" name="branch_location_id">
              <option value="0">Select Branch</option>
              @foreach($_branch as $branch)
              <option value="{{$branch->branch_location_id}}">{{$branch->branch_location_name}}</option>
              @endforeach
            </select>
        </div>
        <div class="col-md-2">
              <a href="/member/payroll/reports/payroll_ledger/export_excel_ledgerv2/0/none/0" class="excel_tag"><button type="button" class="btn btn-success pull-right" style="margin-right:20px;margin-bottom: 20px"><i class="fa fa-file-excel-o" ></i> &nbsp;EXPORT TO EXCEL</button></a>
        </div>
        </div>
    </div>
</div>
<div class="form-group order-tags load-data" target="value-id-1"></div>
 <div class="text-center" id="spinningLoaders" style="display:none;">
    <img src="/assets/images/loader.gif">
</div>
<div class="load-filter-datas">
    <div class="clearfix">
        <div class="col-md-12">
            <div class="table-responsive" id="value-id-1">
				<table class="table table-bordered table-striped table-condensed">
				        <thead style="text-transform: uppercase">
				            <tr>
				                <th class="text-center" width="50px"><input type="checkbox" name=""></th>
				                <th class="text-center" width="100px">NO.</th>
				                <th class="text-center">Employee Name</th>
				                <th class="text-center" width="150px">Company</th>
				                <th class="text-center" ></th>
				            </tr>
				        </thead>
				        <tbody>
				           	@foreach($_employee as $employee)
				           		<tr>
				           			<td class="text-center"><input type="checkbox" name=""></td>
				           			<td class="text-center">{{ $employee->payroll_employee_number }}</td>
				           			<td class="text-center">{{$employee->payroll_employee_first_name}} {{$employee->payroll_employee_last_name}}</td>
				           			<td class="text-center">{{ $employee->payroll_company_name }}</td>
				           			<td class="text-center"><a href="/member/payroll/reports/payroll_ledger/{{$employee->payroll_employee_id}}/none">View Employee</a></td>
				           		</tr>
				           	@endforeach
				        </tbody>
				</table>
      		</div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<script>
	var ajaxdata = {};
	   $(".select-company-name").on("change", function(e)
        {
            var href = "/member/payroll/reports/payroll_ledger/export_excel_ledgerv2/" + $(this).val() +"/" + $(".filter-by-month").val() +"/" + $(".filter-by-branch").val();
             $(".excel_tag").attr('href',href);

            var company          = $(this).val();
            var month            = $(".filter-by-month").val();
            var branch           = $(".filter-by-branch").val();
            ajaxdata.month       = month;
            ajaxdata.company_id  = company;
            ajaxdata.branch_id   = branch;
            ajaxdata._token      = $("._token").val();
            $('#spinningLoaders').show();
            $(".load-filter-datas").hide();
            setTimeout(function(e){
            $.ajax(
            {
                url:"/member/payroll/reports/payroll_ledger_filter",
                type:"post",
                data: ajaxdata,
                
                success: function(data)
                {
                    $('#spinningLoaders').hide();
                    $(".load-filter-datas").show();
                    $(".load-filter-datas").html(data);
                }
            });
            }, 700);
        });

        $(".filter-by-branch").on("change", function(e)
        {
            var href = "/member/payroll/reports/payroll_ledger/export_excel_ledgerv2/" + $(".select-company-name").val() +"/" + $(".filter-by-month").val() +"/" + $(this).val();
             $(".excel_tag").attr('href',href);

            var branch          = $(this).val();
            var month           = $(".filter-by-month").val();
            var company         = $(".select-company-name").val();
            ajaxdata.company_id = company;
            ajaxdata.branch_id  = branch;
            ajaxdata.month      = month;
            ajaxdata._token     = $("._token").val();
            $('#spinningLoaders').show();
            $(".load-filter-datas").hide();
            setTimeout(function(e){
            $.ajax(
            {
                url:"/member/payroll/reports/payroll_ledger_filter",
                type:"post",
                data: ajaxdata,
                
                success: function(data)
                {
                    $('#spinningLoaders').hide();
                    $(".load-filter-datas").show();
                    $(".load-filter-datas").html(data);
                }
            });
            }, 700);
        });


        $(".filter-by-month").on("change", function(e)
        {
            var href = "/member/payroll/reports/payroll_ledger/export_excel_ledgerv2/" + $(".select-company-name").val() +"/" + $(this).val() +"/" + $(".filter-by-branch").val();
             $(".excel_tag").attr('href',href);

            var month           = $(this).val();
            var branch          = $(".filter-by-branch").val();
            var company         = $(".select-company-name").val();
            ajaxdata.company_id = company;
            ajaxdata.branch_id  = branch;
            ajaxdata.month      = month;
            ajaxdata._token     = $("._token").val();
            $('#spinningLoaders').show();
            $(".load-filter-datas").hide();
            setTimeout(function(e){
            $.ajax(
            {
                url:"/member/payroll/reports/payroll_ledger_filter",
                type:"post",
                data: ajaxdata,
                
                success: function(data)
                {
                    $('#spinningLoaders').hide();
                    $(".load-filter-datas").show();
                    $(".load-filter-datas").html(data);
                }
            });
            }, 700);
        });
    
</script>
</script>
@endsection
