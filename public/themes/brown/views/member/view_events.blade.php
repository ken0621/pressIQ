<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">{{strtoupper($event->event_title)}}</h4>
</div>
<div class="modal-body clearfix">
	<div class="form-group">
		<div class="col-md-12 text-center">
			<img class="match-height img-responsive" src="{{$event->event_banner_image}}" style="height: 250px;width:250px; object-fit: cover; border: 1px solid #ddd;margin:auto">
		</div>
	</div>
	<div class="col-md-12"  style="margin-top: 20px">
		<h4>{{ $event->event_title }}</h4>
	</div>
	<div class="col-md-12"  style="margin-top: 20px">
		{{ $event->event_sub_title }}
	</div>
	<div class="col-md-12"  style="margin-top: 20px">
		{!! $event->event_description !!}
	</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
</div>