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
<script type="text/javascript">
var link = '/member/report/accounting/profit/loss/get';
function  submit_done (data) {
	// body...
	if(data.status == 'success_plain')
	{
		$('.append_report_a').html(data.view);
	}
}
</script>
@endsection