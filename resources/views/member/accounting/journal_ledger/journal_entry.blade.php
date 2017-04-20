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

			</small>
			</h1>
			<!-- <div class="pull-right">
				<input type="text" class="datepicker form-control end-date" name="end_date" placeholder="End Date" value="" />
			</div> -->
			<!-- <div class="pull-right margin-right-10">
				<input type="text" class="datepicker form-control start-date" name="start_date" placeholder="Start Date" value=""/>
			</div> -->
		</div>
	</div>
</div>
<div class="">
	<div class="table-responsive load-data">
		<table class="table table-striped table-condensed">
			<thead>
				<tr>
					<th>Date</th>
					<th>Transaction Type</th>
					<th>Num</th> 
					<th>Name</th>
					<th>Item Name</th>
					<th>Account Name</th>
					<th>Account Type</th>
					<th>Debit</th>
					<th>Credit</th>
				</tr>
			</thead>
			<tbody>
				@foreach($_journal as $key=>$journal)
					@foreach($journal->entries as $key2=>$entry)
					<tr>
						<td>{{$key2 == 0 ? $journal->je_entry_date : ''}}</td>
						<td>{{$key2 == 0 ? $journal->je_reference_module : ''}}</td>
						<td>
							<a href="{{$journal->txn_link}}">
								{{$key2 == 0 ? $journal->je_reference_id : ''}}
							</a>
						</td>
						<td>{{$key2 == 0 ? $journal->first_name.' '.$journal->last_name : ''}}</td>
						<td>{{$entry->item_name or ''}}</td>
						<td>{{$entry->account_name}}</td>
						<td>{{$entry->chart_type_name}}</td>
						<td>{{$entry->jline_type == 'Debit' ? currency('PHP', $entry->jline_amount) : ''}}</td>
						<td>{{$entry->jline_type == 'Credit' ? currency('PHP', $entry->jline_amount) : ''}}</td>
					</tr>
					@endforeach
					<tr>
						<td colspan="7"></td>
						<td>{{currency('PHP', collect($journal->entries)->where("jline_type", 'Debit')->sum('jline_amount'))}}</td>
						<td>{{currency('PHP', collect($journal->entries)->where("jline_type", 'Credit')->sum('jline_amount'))}}</td>
					</tr>
				@endforeach
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