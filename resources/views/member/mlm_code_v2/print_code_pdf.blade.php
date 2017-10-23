<table width="100%" class="{{$ctr = 0}}">
	<tr >
	@foreach($_item_product_code as $item_code)
		<td {!! $ctr == 4 ? $ctr = 0 : '' !!} width="25%" style="border:1px #000 solid;padding:5px;padding-top: 20px;padding-bottom: 20px;" class="{{$ctr++}}">
			<img src="{{URL::to('/')}}/barcode?text={{ $item_code->mlm_pin.'@'.$item_code->mlm_activation }}&size=50">
			<div class="mlm_pin {{$on_show['pin_num']}}" style="float:left;width: 50%;padding-left:5px">{{$item_code->mlm_pin}}</div>
			<div class="mlm_activation {{$on_show['activation']}}" style="text-align:right;float:right;width: 50%;padding-right:5px">{{$item_code->mlm_activation}}</div>		
			<div class="item_name {{$on_show['membership_kit']}}" style="text-align:center;">{{ucwords($item_code->item_name)}}</div>	
			<div class="membership_name {{$on_show['membership']}}" style="text-align:center;">{{ucwords($item_code->membership_name)}}</div>			
		</td>
		{!! $ctr == 4 ? "</tr><tr>" : '' !!}
	@endforeach
	</tr>
</table>
<style type="text/css">
	tr { page-break-inside: avoid; }
</style>