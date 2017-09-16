<table width="100%" class="{{$ctr = 0}}">
	<tr >
	@foreach($_item_product_code as $item_code)
		<td {!! $ctr == 4 ? $ctr = 0 : '' !!} width="25%" style="border:1px #000 solid;padding:5px;padding-top: 20px;padding-bottom: 20px;" class="{{$ctr++}}">
			<img src="{{URL::to('/')}}/barcode?text={{ $item_code->mlm_pin.'@'.$item_code->mlm_activation }}&size=50">
			<div style="float:left;width: 50%;padding-left:5px">{{$item_code->mlm_pin}}</div>
			<div style="text-align:right;float:right;width: 50%;padding-right:5px">{{$item_code->mlm_activation}}</div>		
			<div style="text-align:center;">{{ucwords($item_code->item_name)}}</div>	
			<div style="text-align:center;">{{ucwords($item_code->membership_name)}}</div>			
		</td>
		{!! $ctr == 4 ? "</tr><tr>" : '' !!}
	@endforeach
	</tr>
</table>