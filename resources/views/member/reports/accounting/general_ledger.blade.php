@extends('member.layout')

@section('css')
<link rel="stylesheet" href="/assets/member/css/customBTN.css" type="text/css" />
@endsection

@section('content')
{!! $head !!}
@include('member.reports.filter.filter1');
<div class="append_report_a"></div>

@endsection

@section('script')
<script type="text/javascript" src="/assets/mlm/jquery.aCollapTable.min.js"></script>  		
<script type="text/javascript">
function submit_done (data) {
	// body...
	switch(data.status)
	{
		case 'success_plain' :
		$('.append_report_a').html(data.view);
		$('.collaptable').aCollapTable({ 
		    startCollapsed: true,
		    addColumn: false, 
		    plusButton: '<span class="i">[Expand] </span>', 
		    minusButton: '<span class="i">[Contract] </span>' 
		  });
		break
	}
}
</script>
@endsection