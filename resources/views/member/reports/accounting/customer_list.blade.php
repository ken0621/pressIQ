@extends('member.layout')
@section('css')
<style type="text/css">
	.table
	{
		width: inherit;
		margin: auto;
	}
	
	.report-container
	{
		text-align: -webkit-center;
	}

	.panel-report
	{
		display: inline-block;
	}
</style>

@endsection
@section('content')
{!! $head !!}
@include('member.reports.filter.filter1');
@include('member.reports.output.customer_list');
@endsection

@section('script')
<script type="text/javascript">

	var customer_list_report = new customer_list_report();

	function customer_list_report()
	{
		init();

		function init()
		{
			event_run_report_click();
		}
	}

	function event_run_report_click()
	{
		$(document).on("click", ".run-report", function()
		{
			var serialize_data = $("form.filter").serialize()
			
			$(".load-data").load("/member/report/accounting/customer_list?"+serialize_data+"&load_content=true .load-content");
		});
	}

	function submit_done(data)
	{
		if(data.status == 'success')
		{
			toastr.success(data.message);
		}
	}

</script>
@endsection