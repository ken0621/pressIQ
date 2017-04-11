<style type="text/css">

</style>
<link rel="stylesheet" type="text/css" href="/assets/custom_plugin/myDropList/css/myDropList.css">
	<form class="global-submit" role="form" action="/member/page/content/submit-maintenance/-1" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="key" value="{{ $key }}">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	    <h4 class="modal-title layout-modallarge-title item_title">Add</h4>
	</div>
	<div class="modal-body modallarge-body-layout background-white">
		<div class="text-right">
			<button class="btn btn-primary" button="submit">Submit</button>
		</div>
		@if(isset($field) && count($field) > 0)
		<div style="margin-top: 15px;">
			@foreach($field as $fields)
			<div class="form-group">
				<label class="{{ $fields->type == "hidden" ? "hide" : "" }}">{{ ucwords(str_replace(' ', '_', $fields->name)) }}</label>
				@if($fields->type == "textarea")
					<textarea class="form-control mce" name="{{ $fields->name }}"></textarea>
				@elseif($fields->type == "image")
					<input type="hidden" name="{{ $fields->name }}" class="maintenance-image-input" key="{{ $key }}-{{ $fields->type }}">
					<div class="maintenance-image-holder" key="{{ $key }}-{{ $fields->type }}"></div>
					<div><button class="image-gallery image-gallery-single btn btn-primary" key="{{ $key }}-{{ $fields->type }}"> Upload Image</button></div>
				@elseif($fields->type == "map")
					<div id="map" style="height: 300px;"></div>
				    <script>
				      function initMap() {
				        // Create a map object and specify the DOM element for display.
				        var map = new google.maps.Map(document.getElementById('map'), {
				          center: {lat: -34.397, lng: 150.644},
				          scrollwheel: false,
				          zoom: 8
				        });
				      }

				    </script>
				    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDntbTzqtnwMA7hdMBAeX37YwTjRJi6cDY&callback=initMap"
				    async defer></script>
				@else
					<input class="form-control" type="{{ $fields->type }}" name="{{ $fields->name }}">
				@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</form>
@include("member.page.page_assets")