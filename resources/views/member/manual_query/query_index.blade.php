@extends('member.layout')
@section('content')

<form class="global-submit" action="/member/report/query-submit">
	<div class="panel panel-default panel-block panel-title-block">
	    <div class="panel-body form-horizontal">
	    	<div class="form-group draggable-container">
	    		<table class="digima-table">
	    			<thead>
	    				<tr>
		    				<td class="text-center">SLOT NO</td>
		    				<td class="text-center">EZ BONUS</td>
		    				<td class="text-center">TOTAL PAYOUT</td>
		    				<td class="text-center">PAYOUT</td>
		    			</tr>
	    			</thead>

	    			<tbody class="draggable tbody-item">
	    				@if(count($_payout) > 0)
	    					@foreach($_payout as $payout)
		    				<tr class="tr-draggable">
			    				<td class="text-center">{{$payout['slot_no']}}</td>
			    				<td class="text-center">{{currency('',$payout['ez_bonus'])}}</td>
			    				<td class="text-center">{{currency('',$payout['total_payout'])}}</td>
			    				<td class="text-center">{{currency('',$payout['payout'])}}</td>
			    			</tr>
			    			@endforeach
		    			@endif
	    			</tbody>
	    		</table>
	    	</div>
	    	<div class="form-group text-center">
	    		<button class="btn btn-primary" type="submit">Submit</button>
	    	</div>
	    </div>
	</div>
</form>
@endsection