<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
    	<form class="global-submit" method="post" action="{{$action}}" >
    	{!! csrf_field() !!}
    	<input type="hidden" name="report_type" value="plain" class="report_type_i">
    	<input type="hidden" name="report_field_type" class="report_field_type" value="accounting_sales_report">
        <div>
            <div class="col-md-2">
                <select class="form-control input-sm" name="report_period">
                    <option value="all">All Dates</option>
                    <option value="custom">Custom</option>
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_week_to_date">This Week to Date</option>
                    <option value="this_month">This Month</option>
                    <option value="this_month_to_date">This Month to Date</option>
                    <option value="this_quarter">This Quarter</option>
                    <option value="this_quarter_to_date">This Quarter to Date</option>
                    <option value="this_year">This Year</option>
                </select>
            </div>
            <div class="col-md-2"><input type="date" class="form-control from_report_a" name="from" class=""></div>
            <div class="col-md-2"><input type="date" class="form-control form_report_b" name="to" class=""></div>
            <div class="col-md-3"><button class="btn btn-primary" onclick="$('.report_type_i').val('plain')" >View Report</button></div>
            <button class="btn btn-custom-red-white margin-right-10 btn-pdf pull-right" onclick="report_file('pdf')"><i class="fa fa-file-pdf-o"></i>&nbsp;Export to PDF</button>
            <button class="btn btn-custom-green-white margin-right-10 btn-pdf pull-right" onclick="report_file('excel')"><i class="fa fa-file-excel-o"></i>&nbsp;Export to Excel</button>
        </div>
        </form>
    </div>
</div>