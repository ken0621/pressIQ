
<input type="hidden" id="name" name="action" class="form-control"  value="delete">
<input type="hidden" id="name" name="pr_id" class="form-control" value="{{$_draft_release->pr_id}}">

<div class="modal-body">
	<div class="title" style="font-size: 20px">{{$_draft_release->pr_headline}}</div>			
</div>

<div class="modal-footer">
	<button type="submit" id="submit" class="btn btn-danger" name="submit">Delete</button>
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
</div>