	

<input type="hidden" id="name" name="action" class="form-control"  value="delete">
<input type="hidden" id="name" name="admin_id" class="form-control" value="{{$_admin_deletes->user_id}}">

<div class="modal-body">
	<div class="title" style="font-size: 20px">{{$_admin_deletes->user_first_name}} {{$_admin_deletes->user_last_name}}</div>			
</div>

<div class="modal-footer">
	<button type="submit" id="submit" class="btn btn-danger" name="submit">Delete</button>
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
</div>