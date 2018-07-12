<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <form class="global-submit filter" method="post" action="{{$action}}" >
        {!! csrf_field() !!}
        <input type="hidden" name="report_type" value="plain" class="report_type_i">
        <div class="row clearfix">
            <div class="col-md-2">
                <select class="form-control input-sm report_period" name="report_period">
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
            <div class="col-md-2"><input type="text" class="form-control from_report_a datepicker" name="from" placeholder="Start Date"></div>
            <div class="col-md-2"><input type="text" class="form-control form_report_b datepicker" name="to" placeholder="End Date"></div>
            <div class="col-md-3"><button class="btn btn-primary run-report" type="button" onclick="$('.report_type_i').val('plain')" >Run Report</button></div>
            
            <button class="btn btn-custom-green-white margin-right-10 btn-pdf pull-right" onclick="report_file('per_sheet_in_excel')"><i class="fa fa-file-excel-o"></i>&nbsp;Export to Excel</button>
        </div>
        <div  style="margin-top: 15px" class=" row clearfix form-group">
            <div class="col-md-5 " style="padding: 5px"> 
                <select class="form-control input-sm warehouse_id" name="warehouse_id" required="true">
                    @foreach($_warehouse as $warehouse)
                    <option value="{{$warehouse->warehouse_id}}">{{$warehouse->warehouse_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">

    var new_report = new new_report();
    function new_report()
    {
        init();

        function init()
        {
            event_run_report_click();
        }
        function event_run_report_click()
        {
            $(document).on("click", ".run-report", function()
            {
                $.ajax({
                url: '/member/report/accounting/date_period',
                dataType: 'json',
                data: $("form.filter").serialize(),
                })
                .done(function(data) {
                    if(data.period != 'all')
                    {
                        $(".from_report_a").val(data.start_date);
                        $(".form_report_b").val(data.end_date);
                        
                    }
                    else
                    {
                        $(".from_report_a").val("");
                        $(".form_report_b").val("");
                        
                    }
                    if(data.warehouse_id != null)
                    {
                        $(".warehouse_id").val(data.warehouse_id);
                    }
                })
                .fail(function() {
                    console.log("error");
                })
            });
        }
    }

    function report_file(type)
    {
        var link        = $("form.filter").attr("action");
        var serialize   = $("form.filter").serialize();
        var link        = link + '?' + serialize + '&report_type=' + type;
        console.log(link);
        window.open(link);
    }
</script>