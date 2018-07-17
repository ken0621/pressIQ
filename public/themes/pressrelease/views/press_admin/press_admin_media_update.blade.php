
	<input type="hidden" id="name" name="action" class="form-control" value="edit">
	<input type="hidden" id="name" name="media_id" class="form-control" value="{{$_media_edits->media_id}}">

	<div class="title">Media Type: </div><br>
	<input type="text" id="media_name" name="media_name" class="form-control" value="{{$_media_edits->media_name}}" required><br>