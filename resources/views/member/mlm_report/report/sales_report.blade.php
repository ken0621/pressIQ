@if(count($sales)>0)
<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Date : </th>
            <td class="text-center">{{$from." - ".$to}}</td>
            <th class="text-center">Sales Amount</th>
            <td class="text-center">{{$sales_total}}</td>
        </tr>
        <tr>
            <th class="text-center">Sales Person : </th>
            <td class="text-center">{{$sales_person}}</td>
            <th class="text-center">Sales Tax</th>
            <td class="text-center">0</td>
        </tr>
        <tr>
            <th class="text-center">Warehouse Name :</th>
            <td class="text-center">{{$warehouse_name}}</td>
            <th class="text-center">Sales Total : </th>
            <td class="text-center">{{$sales_total}}</td>
        </tr>
        <tr>
            <th class="text-center">Date From :</th>
            <td class="text-center">{{$from}}</td>
            <th class="text-center">Date To : </th>
            <td class="text-center">{{$to}}</td>
        </tr>
    </thead>
    
</table>
<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Order #</th>
            <th class="text-center">Customer Name</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Payment Method</th>
            <th class="text-center">Remarks</th>
            <th class="text-center">Price</th>
            <th class="text-right">Qty</th>
            <th class="text-right">Amount</th>
            <th class="text-right">Tax Rate</th>
            <th class="text-right">Tax</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sale)
        <tr>
            <td class="text-center">{{ $sale->transaction_number }}</td>
            <td class="text-center">{{ $sale->first_name." ".$sale->last_name }}</td>
            <td class="text-center">{{ $sale->item_sku }}</td>
            <td class="text-center" style="text-transform:uppercase;">
                {{$sale->transaction_payment_type}}
            </td>
            
            <td class="text-center">{{ $sale->transaction_remark }}</td>
            <td class="text-center">{{ currency('Php',$sale->item_price) }}</td>
            <td class="text-center">{{ $sale->quantity }}</td>
            <td class="text-center">{{ currency('Php',$sale->subtotal) }}</td>
            <td class="text-center">{{ $sale->transaction_tax }}</td>
            <td class="text-center">{{ $sale->transaction_tax }}</td>
            <td class="text-center">{{  currency('Php',$sale->subtotal) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr></tr>
        <tr>
            <td class="text-center">Prepared By:</td>
            <td class="text-center">Approved By:</td>
            <td class="text-center">Checked By:</td>
        </tr>
        <tr>
            <td class="text-center">__________________</td>
            <td class="text-center">__________________</td>
            <td class="text-center">__________________</td>
        </tr>
    </tfoot>
</table>
@else
<div class="text-center" style="padding: 100px 0;"><b>NO DATA</b></div>
@endif