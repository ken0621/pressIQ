<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
    	<form class="global-submit" method="post" action="/member/report/accounting/sale/get/report" >
    	{!! csrf_field() !!}
    	<input type="hidden" name="report_type" value="plain" class="report_type_i">
        <input type="hidden" name="report_field_type" class="report_field_type" value="accounting_sales_report_item">
        <div>
            <div class="col-md-3"><input type="date" class="form-control from_report_a" name="from" class=""></div>
            <div class="col-md-3"><input type="date" class="form-control form_report_b" name="to" class=""></div>
            <div class="col-md-3"><button class="btn btn-primary" onclick="$('.report_type_i').val('plain')" >View Report</button></div>
            <button class="btn btn-custom-red-white margin-right-10 btn-pdf pull-right" onclick="report_file('pdf')"><i class="fa fa-file-pdf-o"></i>&nbsp;Export to PDF</button>
            <button class="btn btn-custom-green-white margin-right-10 btn-pdf pull-right" onclick="report_file('excel')"><i class="fa fa-file-excel-o"></i>&nbsp;Export to Excel</button>
        </div>
        </form>
    </div>
</div>