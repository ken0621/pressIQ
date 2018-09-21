<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	@if($_slot)
	    <table>
	        <thead>
	            <tr>
	                @foreach($_slot[0] as $column)
	                <th class="text-center">{{ $column["label"] }}</th>
	                @endforeach
	            </tr>
	        </thead>
	        <tbody> 
	                @foreach($_slot as $slot)
	                    <tr>
	                        @foreach($slot as $column)
	                        <td class="text-center">{!! $column["data"] !!}</td>
	                        @endforeach
	                    </tr>
	                @endforeach
	                <tr>
	                	<td colspan="{{ count($_slot[0]) - 2 }}"></td>
	                	<td>TOTAL EARNINGS</td>
	                	<td>{{ $total_slot_earnings }}</td>
	                </tr>
	                <tr>
	                	<td colspan="{{ count($_slot[0]) - 2 }}"></td>
	                	<td>TOTAL WALLET</td>
	                	<td>{{ $total_slot_wallet }}</td>
	                </tr>
	                <tr>
	                	<td colspan="{{ count($_slot[0]) - 2 }}"></td>
	                	<td>TOTAL PAYOUT</td>
	                	<td>{{ $total_payout }}</td>
	                </tr>
	        </tbody>
	    </table>s
	@else
	    <table>
	    	<tbody>
	    		<tr>
	    			<td colspan="{{ count($_slot[0]) }}">NO RESULT FOUND</td>
	    		</tr>
	    	</tbody>
	    </table>
	@endif
</body>
</html>