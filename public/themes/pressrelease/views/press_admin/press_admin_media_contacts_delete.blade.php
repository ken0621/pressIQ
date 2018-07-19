
	
	<input type="hidden" id="name" name="action" class="form-control" value="delete">
    <input type="hidden" id="name" name="recipient_id" class="form-control" value="{{$recipient_details_delete->recipient_id}}">

	<div class="modal-body">
	    <div class="title" style="font-size: 20px">{{$recipient_details_delete->name}}</div>	
		<div class="title" style="font-size: 20px">{{$recipient_details_delete->company_name}}</div>	
	</div>

	<div class="modal-footer">
		<button type="submit" id="submit_media_delete" class="btn btn-danger" name="submit_media_delete">Delete</button>
		<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
	</div>