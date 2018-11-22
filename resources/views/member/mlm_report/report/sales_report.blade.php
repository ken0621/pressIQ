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
            <td class="text-center">{{$sales_total}}</td>
        </tr>
        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center">Sales Total : </th>
            <td class="text-center">{{$sales_total}}</td>
        </tr>
    </thead>
    
</table>
<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Item No</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Item Description</th>
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
            <td class="text-center">{{ $sale->item_id }}</td>
            <td class="text-center">{{ $sale->item_sku }}</td>
            <td class="text-center">{{ $sale->item_sales_information }}</td>
            <td class="text-center">{{ currency('Php',$sale->item_price) }}</td>
            <td class="text-center">{{ $sale->quantity }}</td>
            <td class="text-center">{{ currency('Php',$sale->subtotal) }}</td>
            <td class="text-center">{{ $sale->transaction_tax }}</td>
            <td class="text-center">{{ $sale->transaction_tax }}</td>
            <td class="text-center">{{  currency('Php',$sale->subtotal) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="text-center" style="padding: 100px 0;"><b>NO DATA</b></div>
@endif