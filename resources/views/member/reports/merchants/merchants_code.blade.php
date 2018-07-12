@extends('member.layout')

@section('content')
{!! $head !!}
@include('member.reports.filter.sort_by_warehouse')
@include('member.reports.output.merchants_code')
@endsection

@section('script')
<script type="text/javascript">

	var merchants_code_report = new merchants_code_report();

	function merchants_code_report()
	{
		init();

		function init()
		{
			event_run_report_click();
			action_collaptible(true);
		}
	}

	function event_run_report_click()
	{
		$(document).on("click", ".run-report", function()
		{
			var serialize_data = $("form.filter").serialize()
			
			$(".load-data").load("/member/report/merchants/code?"+serialize_data+"&load_view=true .load-content", function()
				{
					action_collaptible(true);
				});
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