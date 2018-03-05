@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll Reports &raquo; CERTIFICATE OF EMPLOYMENT (COE)</span>
                <small>
               	select employee
                </small>
            </h1>

                <a href="/member/payroll/reports/coe_export_pdf/download?xls=1" class="export-xls-button"><button type="button" class="btn btn-primary pull-right" style="margin-right:20px;margin-bottom: 20px"><i class="fa fa-file-pdf-o" ></i> &nbsp;EXPORT TO PDF</button></a>
        </div>
    </div>
</div>
<div class="form-group order-tags load-data" target="value-id-1"></div>
    <div class="clearfix">
        <div class="col-md-12">
            <div class="table-responsive" id="value-id-1">
				<table class="table table-bordered table-striped table-condensed">
				        <thead style="text-transform: uppercase">
				            <tr>
				                <th class="text-center" width="50px"><input type="checkbox" id="select-all" name=""></th>
				                <th class="text-center" width="100px">NO.</th>
				                <th class="text-center">Employee Name</th>
				                <th class="text-center" width="150px">Company</th>
				            </tr>
				        </thead>
				        <tbody>
				           	@foreach($_employee as $employee)
				           		<tr>
				           			<td class="text-center"><input onChange="action_employee_checkbox();" class="employee-checkbox" value="{{ $employee->payroll_employee_id }}" type="checkbox" name="employee[]"></td>
				           			<td class="text-center">{{ $employee->payroll_employee_number }}</td>
				           			<td class="text-center">{{$employee->payroll_employee_first_name}} {{$employee->payroll_employee_last_name}}</td>
				           			<td class="text-center">{{ $employee->payroll_company_name }}</td>
				           		</tr>
				           	@endforeach
				        </tbody>
				</table>
      		</div>
        </div>
    </div>

@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<script type="text/javascript">
var default_xls = $(".export-xls-button").attr("href");
function action_employee_checkbox()
{
	var param = [];

	$('.employee-checkbox:checked').each(function(index, el) 
	{
		param.push($(el).val());
	});

	var employee = JSON.stringify(param);

	$(".export-xls-button").attr("href", default_xls + '&employee=' + employee);
}

$('#select-all').click(function(event) {   
    if(this.checked) {

    	var param = [];
        $(':checkbox').each(function(index, el) {
               this.checked = true;    
				param.push($(el).val());

        });
		var employee = JSON.stringify(param);

		$(".export-xls-button").attr("href", default_xls + '&employee=' + employee);
    }
});
</script>
@endsection
