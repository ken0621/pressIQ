
  <input type="hidden" id="name" name="action" class="form-control"  value="edited_admin">
  <input type="hidden" id="name" name="admin_id" class="form-control" value="{{$_admin_edits->user_id}}">

  <div class="title">First Name:</div>
  <input type="text" id="first_name" name="first_name" class="form-control" value="{{$_admin_edits->user_first_name}}" autofocus><br>

   <div class="title">Last Name:</div>
   <input type="text"  id="last_name" name="last_name" class="form-control" value="{{$_admin_edits->user_last_name}}"><br>

   <div class="title">Email:</div>
   <input type="text" id="email" name="email" class="form-control" value="{{$_admin_edits->user_email}}" readonly><br>

  