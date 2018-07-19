	

	<input type="hidden" id="name" name="action" class="form-control" value="delete">
	<input type="hidden" id="name" name="industry_id" class="form-control" value="{{$_industry_deletes->industry_id}}">

	<div class="modal-body">
	<div class="title" style="font-size: 20px">{{$_industry_deletes->industry_name}}</div>		
	</div>

	<div class="modal-footer">
	<button type="submit" id="submit_media_type_delete" class="btn btn-danger" name="submit_media_type_delete">Delete</button>
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
	</div>