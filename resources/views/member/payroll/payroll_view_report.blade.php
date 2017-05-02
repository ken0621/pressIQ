@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-bar-chart" aria-hidden="true"></i>
			<h1>
			<span class="page-title">{{$report->payroll_reports_name}}</span>
			<small>
			Manage Payroll Reports
			</small>
			</h1>
			<button class="btn btn-custom-danger pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download as PDF</button>

		</div>
	</div>
</div>
<div class="panel panel-default panel-block">
	<div class="panel-body form-horizontal">
		<div class="form-group">
			<div class="col-md-4 pull-right">
				<div class="col-md-6">
					<small>From</small>
					<input type="text" name="" value="{{$start}}" class="form-control datepicker">
				</div>
				<div class="col-md-6">
					<small>To</small>
					<input type="text" name="" value="{{$end}}" class="form-control datepicker">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12 over-flow">
				<table class="table table-condensed table-bordered column-fit">
					<thead>
						<tr>
							<th></th>
							@foreach($_columns as $column)
							<th class="block">{{$column}}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($_emp as $emp)
						<tr>
							<td>{{$emp['payroll_employee_title_name'].' '.$emp['payroll_employee_first_name'].' '.$emp['payroll_employee_middle_name'].' '.$emp['payroll_employee_last_name'].' '.$emp['payroll_employee_suffix_name']}}</td>
							@foreach($emp['_record'] as $record)
							<td class="text-right">
								{{number_format($record, 2)}}
							</td>
							@endforeach
						</tr>
						
						@endforeach
						<tr>
							<td><b>Total</b></td>
							@foreach($_total as $total)
							<td class="text-right">
								<b>{{number_format($total, 2)}}</b>
							</td>
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
@endsection