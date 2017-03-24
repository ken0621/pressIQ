<div class="text-center">
	<h3>{{$slip->shop_key}}</h3>
	<small>{{$slip->shop_street_address." ".$slip->shop_city}}</small><br>
	<small>Tel : {{$slip->shop_contact}} </small>
</div>
<br>
<div class="text-center">
	<h3>STOCK INPUT</h3>
</div>

<div class="form-group">
	<div class="col-md-6 text-right">
		<strong>SI# : {{$slip->inventory_slip_id}}</strong>
	</div>
	<div class="col-md-6">
		Warehouse: <strong>{{$slip->warehouse_name}}</strong>
	</div>
</div>
<br>
<div>
	<div>Supplier: {{$slip->vendor_company != null ? strtoupper($slip->vendor_company) : strtoupper($slip->vendor_first_name." ".$slip->vendor_middle_name." ".$slip->vendor_last_name)}}</div>
	<div>Date: {{dateFormat($slip->inventory_slip_date)}}</div>
</div>
<br>
<div>
	<table class="table">
		<thead>
			<tr>
				<th class="text-center">Item ID</th>
				<th class="text-center">Item Name</th>
				<th class="text-center">QTY</th>
				<th class="text-center">UNIT</th>
				<th class="text-center">Cost</th>
				<th class="text-center">Total Price</th>
			</tr>
		</thead>
		<tbody class="{{$total_price = 0}}">
			@foreach($slip_item as $item)
				<tr {{$total_price += $item->item_cost * $item->inventory_count}}>
					<td>{{$item->item_id}}</td>
					<td>{{$item->item_name}}</td>
					<td>{{$item->inventory_count}}</td>
					<td>{{$item->multi_abbrev}}</td>
					<td>{{currency("P",$item->item_cost)}}</td>
					<td>{{currency("P",($item->item_cost * $item->inventory_count))}}</td>
				</tr>
				@if($item->serial_number_list != null)
				<tr class="{{$num = 1}}">
					<td colspan="6">
						<div style="padding: 20px">		
							@foreach($item->serial_number_list as $serial)
								<small style="margin-right: 100px;" {{$num++}}> S/N - {{$serial->serial_number}} -</small>
								@if($num == 5)
								<br class="{{$num == 1}}">
								@endif
							@endforeach				
						</div>
					</td>			
				</tr>
				@endif	
			@endforeach		
		</tbody>
	</table>
	<table style="width: 100%">
		<tbody>
			<tr>
				<td colspan="3" class="text-left">
					<strong>TOTAL</strong>
				</td>
				<td colspan="3" class="text-right">	
					<strong>{{currency('P',$total_price)}}</strong>
				</td>
			</tr>	
			<tr>
				<td colspan="2">
					<div>Prepared By:</div><br><br>
					<div style="border-bottom: 1px solid #000;width: 50%">{{$slip->user_first_name." ".$slip->user_last_name}}</div>
				</td>
				<td colspan="4">
					<div>Checked By:</div><br><br>
					<div style="border-bottom: 1px solid #000;width: 50%;color: #fff">INVISIBLE NAME</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div>
	
</div>


