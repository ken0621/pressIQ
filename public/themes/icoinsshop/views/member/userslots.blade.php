<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">{{$page}}</h4>
</div>
<div class="modal-body clearfix">
	@foreach($slots as $slot)
		<div class="slot-holder">
			<div class="slot-no-style"><span>{{$slot->slot_no}}</span></div>
		</div>
	@endforeach
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
</div>