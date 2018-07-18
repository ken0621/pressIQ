	


	<input type="hidden" id="name" name="action" class="form-control" value="edit">
	<input type="hidden" id="name" name="industry_id" class="form-control" value="{{$_industry_edits->industry_id}}">

	<div class="title">Industry Name: </div><br>
	<input type="text" id="industry_name" name="industry_name" class="form-control" value="{{$_industry_edits->industry_name}}" required><br>