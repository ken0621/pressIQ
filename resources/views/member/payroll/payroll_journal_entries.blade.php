@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-building-o"></i>
			<h1>
			<span class="page-title">Journal Entry</span>
			<small>
			Payroll
			</small>
			</h1>
			<div class="pull-right">
				<input type="text" class="datepicker form-control start-date" name="start_date" placeholder="End Date" />
			</div>
			<div class="pull-right margin-right-10">
				<input type="text" class="datepicker form-control end-date" name="end_date" placeholder="Start Date" />
			</div>
		</div>
	</div>
</div>
<div class="">
	<div class="table-responsive load-data">
		<table class="table table-striped table-condensed">
			<thead>
				<tr>
					<th>Account Number</th>
					<th>Account Name</th>
					<th>Accoutn Type</th>
					<th>Debit</th>
					<th>Credit</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<script>
var payroll_journal_entry = new payroll_journal_entry();

function payroll_journal_entry()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		event_date_change();
	}

	function event_date_change()
	{
		$(document).on('change', '.start-date, .end-date', function(event) {
			event.preventDefault();
			$(".load-data").load("/member/payroll/payroll_summary .load-data table", function()
			{
				toastr.success("Generated");
			})
			/* Act on the event */
		});
	}
}

</script>
@endsection