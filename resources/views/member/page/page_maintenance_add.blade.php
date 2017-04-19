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
			<div class="form-group {{ $fields->type == "hidden" ? "hide" : "" }}">
				<label>{{ ucwords(str_replace(' ', '_', $fields->name)) }}</label>
				@if($fields->type == "textarea")
				<textarea class="form-control mce" name="{{ $fields->name }}"></textarea>
				@elseif($fields->type == "image")
				<input type="hidden" name="{{ $fields->name }}" class="maintenance-image-input" key="{{ $key }}-{{ $fields->type }}">
				<div class="maintenance-image-holder" key="{{ $key }}-{{ $fields->type }}"></div>
				<div><button class="image-gallery image-gallery-single btn btn-primary" key="{{ $key }}-{{ $fields->type }}"> Upload Image</button></div>
				@elseif($fields->type == "map")
				<div id="map" style="height: 300px;"></div>
			    <script>
				  // In the following example, markers appear when the user clicks on the map.
				  // Each marker is labeled with a single alphabetical character.
				  var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				  var labelIndex = 0;

				  function initialize() 
				  {
				    var current_place = { lat: 12.97, lng: 77.59 };
				    var map = new google.maps.Map(document.getElementById('map'), 
				    {
				      zoom: 12,
				      center: current_place
				    });

				    // This event listener calls addMarker() when the map is clicked.
				    google.maps.event.addListener(map, 'click', function(event) 
				    {
				      addMarker(event.latLng, map);
				      // alert( 'Lat: ' + event.latLng.lat() + ' and Longitude is: ' + event.latLng.lng() );
				    });

				    // Add a marker at the center of the map.
				    addMarker(current_place, map);
				  }

				  // Adds a marker to the map.
				  function addMarker(location, map) 
				  {
				    // Add the marker at the clicked location, and add the next-available label
				    // from the array of alphabetical characters.
				    var marker = new google.maps.Marker({
				      position: location,
				      label: labels[labelIndex++ % labels.length],
				      map: map
				    });
				  }	

				  google.maps.event.addDomListener(window, 'load', initialize);
			    </script>
			    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDntbTzqtnwMA7hdMBAeX37YwTjRJi6cDY&callback=initMap" async defer></script>
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