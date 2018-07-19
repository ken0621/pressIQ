
<input type="hidden" id="name" name="action" class="form-control" value="force">
<input type="hidden" id="name" name="user_id" class="form-control" value="{{$_force_login_id->user_id}}">

<div class="modal-body">
	<div class="title" style="font-size: 20px">{{$_force_login_id->user_first_name}} {{$_force_login_id->user_last_name}}</div>	
	<div class="title" style="font-size: 20px">{{$_force_login_id->user_company_name}}</div>		
</div>

<div class="modal-footer">
	<button type="submit" id="submit" class="btn btn-success" name="submit">Force Login</button>
</div>