
<div style="page-break-after: always;">
    <div class="text-center" style="top: 450px">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <span style="font-size: 50px;font-weight: bold">SALES REPORT</span>
        <br>
        <span style="font-size: 25px;font-weight: bold">SIR# {{sprintf("%'.05d\n", $sir->sir_id)}}</span>
        <br>
        <br>
        <br>
        <h2>{{strtoupper($sir->first_name)}} {{strtoupper($sir->middle_name)}} {{strtoupper($sir->last_name)}}</h2>
        <span>AGENT NAME</span>
        <br>
        <br>
        <h2>{{$sir->plate_number}}</h2>
        <span>Plate Number</span>
        <br>
        <br>
        <h2>{{date('m/d/Y',strtotime($sir->sir_created))}}</h2>
        <span>DATE</span>
        <br>
        <br>
        <h2>
            @if($total_discrepancy == 0)
            <span style="color: green;font-weight: bold"> CLOSED TRANSACTION</span>
            @else
            <span style="color: green;font-weight: bold">{{currency('PHP',$total_dicrepancy)}}</span>
            @endif
        </h2>
        <span>STATUS</span>

    </div>
</div>

<html>
<head>
	<style type="text/css">
		body
		{
			font-size: 13px;
			font-family: 'Titillium Web',sans-serif;
		}
	</style>
</head>
<body>
<table width="100%">
	<tr>
		<td width="60%" style="text-align: left">
        <h2>Incoming Load Report</h2></td>
	</tr>
</table>
 <div class="form-group">
    <div class="col-md-12">
        <div class="row clearfix draggable-container ilr-container">
            <div class="col-sm-12">
                <table class="digima-table">
                    <thead >
                        <tr>
                            <th style="width: 30px;" class="text-center">#</th>
                            <th style="width: 200px;">Product Name</th>
                            <th style="width: 200px;">Issued QTY</th>
                            <th style="width: 200px;">Sold QTY</th>
                            <th style="width: 200px;">Remaining QTY</th>
                            <th style="width: 200px;">Physical Count</th>
                            <th style="width: 200px;">Status</th>
                            <th style="width: 200px;">Info</th>
                        </tr>
                    </thead>
                    <tbody class="{{$loss = 0}} {{$over = 0}} {{$total_sold = 0}} {{$total_issued = 0}}">
                    @if($_sir_item)
                        @foreach($_sir_item as $key => $sir_item)                                
                        <tr class="tr-draggable tr-draggable-html">
                            <td class="invoice-number-td text-center">{{$key+1}}</td>
                            <td>{{$sir_item->item_name}}</td>                                            
                            <td>{{$sir_item->item_qty}} {{$sir_item->um_abbrev}}</td>
                            <td>{{$sir_item->sold_qty}}</td>
                            <td class="total_issued {{$total_issued += (($sir_item->item_qty * $sir_item->um_qty) * $sir_item->sir_item_price)}}">
                            	{{$sir_item->remaining_qty}}
                            </td>
                            <td class="total_sold {{$total_sold += ($sir_item->quantity_sold * $sir_item->sir_item_price)}}">
                                {{$sir->ilr_status == 1 ? '' : $sir_item->physical_count}}
                            </td>
                            <td class="loss {{$loss += $sir_item->infos < 0 ? $sir_item->infos : 0}}">
                                {{$sir_item->status}}
                            </td>
                            <td class="over {{$over += $sir_item->infos > 0 ? $sir_item->infos : 0}} text-right">
                                {{$sir_item->is_updated == 1 ? number_format($sir_item->infos,2) : ''}}
                            </td>
                        </tr>
                        @endforeach
                        <tr>                        	
                        	<td colspan="6"></td>
                        	<td><strong>TOTAL ISSUED</strong></td>
                        	<td>{{currency('PHP',$total_issued)}}</td>
                        </tr>
                        <tr>                        	
                        	<td colspan="6"></td>
                        	<td><strong>TOTAL SOLD</strong></td>
                        	<td>{{currency('PHP',$total_sold)}}</td>
                        </tr>
                        <tr>
                        	<td colspan="6"></td>
                        	<td><strong>LOSS AMOUNT</strong></td>
                        	<td>{{currency('PHP',$loss)}}</td>
                        </tr>
                        <tr>
                        	<td colspan="6"></td>
                        	<td><strong>OVER AMOUNT</strong></td>
                        	<td>{{currency('PHP',$over)}}</td>
                        </tr>
                    @endif
                    </tbody>                                   
                </table>
            </div>
        </div>
    </div>                
</div>

@if($ctr_returns != 0)
<div class="form-group">
    <div class="col-md-12">
        <label>EMPTIES</label>
    </div>
</div>
 <div class="form-group">
    <div class="col-md-12">
        <div class="row clearfix draggable-container empties-container">
            <div class="col-sm-12">
                <table class="digima-table">
                    <thead >
                        <tr>
                            <th style="width: 30px;" class="text-center">#</th>
                            <th style="width: 200px;">Product Name</th>
                            <th style="width: 200px;">RETURNS QTY</th>
                            <th style="width: 200px;">Physical Count</th>
                            <th style="width: 200px;">Status</th>
                            <th style="width: 200px;">Info</th>
                        </tr>
                    </thead>
                    <tbody class="{{$empties_loss = 0}} {{$empties_over = 0}} {{$total_return = 0}}">
                    @if($_returns)
                        @foreach($_returns as $keys => $return)                                
                        <tr class="tr-draggable tr-draggable-html">
                            <td class="invoice-number-td text-center">{{$keys+1}}</td>
                            <td>{{$return->item_name}}</td>                                            
                            <td>{{$return->item_count}}</td>
                            <td class="total_sold {{$total_return += ($return->sc_item_qty * $return->sc_item_price)}}">
                                {{$sir->ilr_status == 1 ? '' : $return->sc_physical_count}}
                            </td>
                            <td class="loss {{$empties_loss += $return->sc_infos < 0 ? $return->sc_infos : 0}}">
                                {{$return->status}}
                            </td>
                            <td class="over {{$empties_over += $return->sc_infos > 0 ? $return->sc_infos : 0}} text-right">
                                {{$return->sc_is_updated == 1 ? number_format($return->sc_infos,2) : ''}}
                            </td>
                        </tr>
                        @endforeach
                        <tr>                            
                            <td colspan="4"></td>
                            <td><strong>TOTAL RETURN</strong></td>
                            <td>{{currency('PHP',$total_return)}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><strong>LOSS AMOUNT</strong></td>
                            <td>{{currency('PHP',$empties_loss)}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><strong>OVER AMOUNT</strong></td>
                            <td>{{currency('PHP',$empties_over)}}</td>
                        </tr>
                    @endif
                    </tbody>                                   
                </table>
            </div>
        </div>
    </div>                
</div>
@endif

<div>
    <div class="form-group">
        <h2>Agent Transaction</h2>      
    </div>
    @if($ctr_tr > 0)
    <div>
        <table class="table table-hover table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <!-- <td class="col-md-2"></td> -->
                    <th>ID</th>
                    <th>Type</th>
                    <th>No</th>
                    <th>Customer Name</th>
                    <th>Due Date</th>
                    <th>Balance</th>
                    <th>Total</th>
                    <!-- <th>Status</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($_transaction as $transaction)
                    <tr class="cursor-pointer">
                        <td>{{ $transaction['date'] }}</td>
                        <td>{{ $transaction['type'] }}</td>
                        <td>{{ $transaction['no'] }}</td>
                        <td>{{ $transaction['customer_name'] }}</td>
                        <td>{{ $transaction['due_date'] }}</td>
                        <td class="text-right">{{ currency("PHP",$transaction['balance']) }}</td>
                        <td class="text-right">{{ currency("PHP", $transaction['total']) }}</td>
                        <!-- <td>
                            @if($transaction['reference_name'] == "receive_payment")
                            <a class="btn btn-default form-control">Closed</a>
                            @elseif($transaction['status'] == 0)
                                @if($transaction['reference_name'] == "invoice")    
                                    <a class="btn btn-warning form-control">Open</a>
                                @endif
                            @elseif($transaction['reference_name'] == "invoice")
                                @if($transaction['status'] == 1)
                                    <a class="btn form-control" style="background-color: #78C500;color: #fff">Paid</a>
                                @endif
                            @endif
                        </td> -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="container text-center">
        <div class="row vcenter">
            <div class="col-md-12">
                <div class="error-template">
                    <h2 class="message">No Trasaction Found</h2>
                    <div class="error-details">
                    There is no existing transaction for this SIR.
                    </div>      
                </div>
            </div>
        </div>
    </div>                                              
    @endif

    <div class="form-group">
        <div class="pull-right">
            <h4><strong>Sales :</strong> {{currency("Php",$total)}}</h4>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="form-group" {{$agent_descrepancy = $total == $rem_amount ? '0' : ($rem_amount - $total) }}>
        @if(isset($rem_amount))
            <div class="col-md-12">
                <h3>Amount Remitted : {{currency("Php",$rem_amount)}}</h3>
                <h4>Remittance Remarks :</h4>
                <span style="padding: 20px">{!! $rem_remarks !!}</span>
            </div>
        @endif
    </div>
</div>
<br>
<br>
<br>
<br>

    <div class="form-group text-center" {{$total_loss = $loss + $empties_loss}} {{$total_over = $over + $empties_over}}>
        <table class="text-center" style="width: 50%;font-size: 15px;">
            <tr>
                <td>{{currency('PHP', $agent_descrepancy)}}</td>
                <td>{{currency('PHP', $total_loss)}}</td>
                <td>{{currency('PHP', $total_over)}}</td>
            </tr>
            <tr>
                <td><div style="border-bottom: 1px solid #000;width: 100%"></div></td>
                <td><div style="border-bottom: 1px solid #000;width: 100%"></div></td>
                <td><div style="border-bottom: 1px solid #000;width: 100%"></div></td>
            </tr>
            <tr>
                <td>Agent Discrepancy</td>
                <td>TOTAL LOSS</td>
                <td>TOTAL OVER</td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <table class="text-center" style="width: 100%;font-size: 25px;">
            <tr>
                <td>{{currency('PHP',$total)}}</td>
                <td>{{currency('PHP',$total_ar)}}</td>
                <td>{{currency('PHP',$total_cm)}}</td>
            </tr>
            <tr>
                <td><div style="border-bottom: 1px solid #000;width: 100%"></div></td>
                <td><div style="border-bottom: 1px solid #000;width: 100%"></div></td>
                <td><div style="border-bottom: 1px solid #000;width: 100%"></div></td>
            </tr>
            <tr>
                <td>Total Sales</td>
                <td>Total Receivable</td>
                <td>Total Credit Memo</td>
            </tr>
        </table>
    </div>
</body>
<style type="text/css">
	table
	{
		border-collapse: collapse;
	}
	tr th
	{
		padding: 5px;
		border: 1px solid #000;
	}
	tr td
	{
		padding: 5px;
	}
</style>
</html>