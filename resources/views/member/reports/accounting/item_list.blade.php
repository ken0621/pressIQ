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
@include('member.reports.output.item_list');
@endsection

@section('script')
<script type="text/javascript">

	var item_list_report = new item_list_report();

	function item_list_report()
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
			
			$(".load-data").load("/member/report/accounting/item_list?"+serialize_data+"&load_view=true .load-content");
		});
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