<table class="table">
	<tr style="color: yellow;">
	@foreach($headers as $key => $value)
		<th>{{$value}}</th>
	@endforeach
	</tr>
	
	@foreach($order as $key => $value)
		<tr>
		@foreach($headers as $key2 => $value2)
			<td>{{$value->$key2}}</td>
		@endforeach
		</tr>
	@endforeach
	
</table>