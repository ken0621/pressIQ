
@foreach($_name as $key=>$name)
	<option value="{{$name->id}}" reference="{{$name->reference}}" email="{{$name->email}}" {{ isset($name_id) ?  ($name_id == $name->id && $ref_name == $name->reference ? 'selected' : '') : '' }}>{{substr($name->reference,0,1)}} : {{$name->first_name or ''}} {{$name->middle_name or ''}} {{$name->last_name or ''}}</option>
	@if(sizeOf($_name)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach