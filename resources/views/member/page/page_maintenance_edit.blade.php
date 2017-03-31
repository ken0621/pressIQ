<style type="text/css">

</style>
<link rel="stylesheet" type="text/css" href="/assets/custom_plugin/myDropList/css/myDropList.css">
	<form class="global-submit" role="form" action="/member/page/content/submit-maintenance/{{ $id }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="key" value="{{ $key }}">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	    <h4 class="modal-title layout-modallarge-title item_title">Edit</h4>
	</div>
	<div class="modal-body modallarge-body-layout background-white">
		<div class="text-right">
			<button class="btn btn-primary" button="submit">Submit</button>
		</div>
		@if(isset($field) && count($field) > 0)
		<div style="margin-top: 15px;">
			@foreach($field as $fields)
			<div class="form-group">
				<label>{{ ucwords(str_replace(' ', '_', $fields->name)) }}</label>
				@if($fields->type == "textarea")
				<textarea class="form-control mce" name="{{ $fields->name }}">{{ $edit[$fields->name] }}</textarea>
				@else
				<input class="form-control" type="{{ $fields->type }}" name="{{ $fields->name }}" value="{{ $edit[$fields->name] }}">
				@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</form>
@include("member.page.page_assets")