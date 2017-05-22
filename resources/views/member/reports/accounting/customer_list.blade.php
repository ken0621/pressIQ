@extends('member.layout')

@section('css')
<link rel="stylesheet" href="/assets/member/css/customBTN.css" type="text/css" />
@endsection

@section('content')
{!! $head !!}
@include('member.reports.filter.filter1');

<div class="panel panel-default panel-block panel-title-block load-data">
    <div class="panel-heading load-content">
       <h3 class="text-center">Customer List</h3>
       <div class="table-reponsive">
       		<table class="table table-bordered table-condensed collaptable">
       		<tr>
       			<th>Date</th>
       			<th>Type</th>
       			<th>Num</th>
       			<th>Account</th>
       			<th>Amount</th>
       			<th>Balance</th>
       		</tr>
       		<tbody>
       			
   				@foreach($_customer as $key=>$customer)
   				<tr data-id="" data-parent="" >
       				<td colspan="20">{{}}</td>
       			</tr>
       				<?php $balance = 0;?>
   					@foreach($cust as $key3 => $value3)
   						<?php $amount = debit_credit($value3->jline_type, $value3->jline_amount); ?>
						<tr data-id="{{$key3 }}" data-parent="{{$key2}}">
							<td>{{$value3->date_a}}</td>
							<td>{{$value3->je_reference_module}}</td>
							<td>{{$value3->je_reference_id}}</td>

							@if($value3->jline_name_reference == 'customer')
							<td>{{$value3->c_full_name}}</td>
							@else
							<td>{{$value3->v_full_name}}</td>
							@endif
							<td>{{$value3->jline_description}}</td>
							<td>{{currency('PHP', $amount)}}</td>
							<?php $balance += $amount; ?>
							<td>{{currency('PHP', $balance)}}</td>
						</tr>
					@endforeach
				<tr>
					<td colspan="6"><b>Total {{$chart_of_account[$key2]}}</b></td>
					<td>{{currency('PHP', $balance)}}</td>
				</tr>	
   				@endforeach
       		</tbody>
       		</table>
       	</div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

	var customer_list_report = new customer_list_report();

	function customer_list_report()
	{
		init();

		function init()
		{

		}
	}

</script>
@endsection