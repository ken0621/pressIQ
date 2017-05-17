 <div class="load-data" target="value-id-1" s_status="{{$s_status}}"
s_search_by="{{$s_search_by}}"
s_input="{{$s_input}}">
	<div id="value-id-1">
            <table class="table table-bordered table-condensed">
                <tr>
                	<th>Date</th>
                	<th>Item Name</th>
                	<th>Order #</th>
                	<th>Customer</th>
                	<th>Pin</th>
                	<th>Code</th>
                	<th>Student ID</th>
                	<th>Student Name</th>
                	<th>Status</th>
                	<th></th>
                </tr>
                @if(count($items_s) == 0)
				<tr>
					<td colspan="20"><center>No Data Found.</center></td>
				</tr>
                @endif
                @foreach($items_s as $key => $value)
					<tr>
	                	<td>{{$value->merchant_item_date}}</td>
	                	<td>{{$value->item_name}}</td>
	                	<td><a href="/member/ecommerce/product_order/create_order?id={{$value->merchant_item_ec_order_id}}" target="_blank"> {{$value->merchant_item_ec_order_id}}</a></td>
	                	<td>{{name_format_from_customer_info($value)}}</td>
	                	<td>{{$value->merchant_item_pin}}</td>
	                	<td>{{$value->merchant_item_code}}</td>
	                	<td>{{$value->merchant_school_s_id}}</td>
	                	<td>{{$value->merchant_school_s_name}}</td>
	                	<td>
							@if($value->merchant_item_status == 0)
								Pending (E-commerce order not completed)
							@elseif($value->merchant_item_status == 1)
								Active
							@elseif($value->merchant_item_status == 2)
								Used
							@endif
	                	</td>
	                	<td>
	                		@if($value->merchant_item_status == 0)
								-- Can't be use yet. 
							@elseif($value->merchant_item_status == 1)
								<form class="global-submit" method="post" action="/member/mlm/merchant_school/mark/used">
								{!! csrf_field() !!}
								<input type="hidden" name="merchant_school_item_id" value="{{$value->merchant_school_item_id}}">
									<button class="btn btn-primary">Mark as used</button>
								
								</form>
							@elseif($value->merchant_item_status == 2)
								-- Used
							@endif

	                	</td>
	                </tr>
                @endforeach
            </table>
            <div class="col-md-12 text-center">
                {!!$items_s->render()!!}
            </div>
	</div> 
</div>