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
@include('member.reports.output.account_list');
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
			action_collaptible();
		}

		function event_run_report_click()
		{
			$(document).on("click", ".run-report", function()
			{
				var serialize_data = $("form.filter").serialize()
				
				$(".load-data").load("/member/report/accounting/account_list?"+serialize_data+"&load_view=true .load-content", function()
					{
						action_collaptible();
					});
			});
		}
	}

	function submit_done(data)
	{
		if(data.status == 'success_plain')
		{
			toastr.success('Success');
		}
	}

</script>
@endsection