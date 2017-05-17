@extends('member.layout')

@section('css')
<link rel="stylesheet" href="/assets/member/css/customBTN.css" type="text/css" />
@endsection

@section('content')
{!! $head !!}
@include('member.reports.filter.filter1')
{!! $field_checker !!}
<div class="append_report_a"></div>

@endsection

@section('script')
<script type="text/javascript" src="/assets/mlm/jquery.aCollapTable.min.js"></script>  		
<script type="text/javascript">
var link = '/member/report/accounting/sale/get/report';

function submit_done (data) {
	// body...
	switch(data.status)
	{
		case 'success_plain' :
		$('.append_report_a').html(data.view);
		$('.collaptable').aCollapTable({ 
		    startCollapsed: true,
		    addColumn: false, 
		    plusButton: '<span class="i" style="color: white;">[Expand] </span>', 
		    minusButton: '<span class="i" style="color: white;">[Contract] </span>' 
		});

		break
	}
		
}
function report_file(type)
{
	var from = $('.from_report_a').val();
    var to = $('.form_report_b').val();
    var report_field_type = $('.report_field_type').val();

	window.open( link + '?report_type=' + type + '&from=' + from + '&to=' + to + '&report_field_type=' + report_field_type);
}
</script>
@endsection