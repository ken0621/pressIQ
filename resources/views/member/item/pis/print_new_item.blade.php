<body>
<div  class="text-center">
	<h2>{{strtoupper($owner->shop_key)}}</h2>
	<div>{{date('M d, Y')}}</div>
</div>
<br>
<div class="form-group">
	<table class="" style="width: 100%">
		<thead>
            <tr>
                <th style="width: 20px">#</th>
                <th style="width: 300px">ITEM DETAILS</th>
                <th  class="text-center" style="width: 300px">ITEM SALES PRICE</th>
                <th  class="text-center" style="width: 300px">ITEM COST</th>
                <th class="text-center">Added By</th>
            </tr>
        </thead>
        <tbody class="draggable">
        	@foreach($_new_item as $key => $item)
        	<tr>
        		<td>{{$key+1}}</td>
        		<td>
        			Item Name : {{$item->item_name}}<br>
        			Item SKU : {{$item->item_sku}}<br>
        			@if($item->conversion)
                    U/M : {{$item->conversion}}<br>
                    @endif
                    Category : {{$item->type_name}}<br>
                    Item Type :{{$item->item_type_name}}</small>
        		</td>
        		<td class="text-center">
        			Unit Price : {{currency('PHP ',$item->item_price)}} <br>
        			@if($item->um_whole != "")
                    Whole Price : {{currency("PHP", $item->item_whole_price)}} / {{$item->um_whole or 'pc'}}
                    @endif
        		</td>
        		<td class="text-center">
        			{{currency('PHP ',$item->item_cost)}}
        		</td>
        		<td>
        			{{$item->user_first_name}} <br>
        			{{$item->user_last_name}} <br>
        		</td>
        	</tr>
        	@endforeach
        </tbody>
     </table>
</div>
</body>
<style type="text/css">
	tr 
	{
        page-break-inside: avoid; 
		border:1px #000 solid;
	}
	tr td
	{
		padding: 5px;
	}
	tr th
	{
		padding: 5px;
	}
</style>