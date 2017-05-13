@extends('member.layout')

@section('css')
<link rel="stylesheet" href="/assets/member/css/customBTN.css" type="text/css" />
@endsection

@section('content')
{!! $head !!}
{!! $filter !!}
<div class="append_report_a"></div>
@endsection

@section('script')
<script type="text/javascript">
var link = '/member/report/accounting/profit/loss/get';
function  submit_done (data) {
	// body...
	if(data.status == 'success_plain')
	{
		$('.append_report_a').html(data.view);
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