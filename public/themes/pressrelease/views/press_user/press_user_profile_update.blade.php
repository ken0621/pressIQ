
<input type="hidden" id="name" name="action" class="form-control" value="edit">
<input type="hidden" id="name" name="user_id" class="form-control" value="{{$_profile->user_id}}">

<div class="title">First Name:</div>
<input type="text" id="user_first_name" name="user_first_name" class="form-control" value="{{$_profile->user_first_name}}" ><br>

<div class="title">Last Name:</div>
<input type="text" id="user_last_name" name="user_last_name" class="form-control" value="{{$_profile->user_last_name}}" ><br>

<div class="title">Company Name:</div>
<input type="text" id="user_company_name" name="user_company_name" class="form-control" value="{{$_profile->user_company_name}}" ><br>

<div class="title">New Password:</div>
<input type="Password" id="user_password" name="user_password" class="form-control"><br>

<div class="title">Confirm Password:</div>
<input type="Password" id="user_password_confirmation" name="user_password_confirmation" class="form-control" ><br>

<div class="title">Change Company Logo:</div>
<input type="file" name="user_company_image" id="user_company_image" accept=".png, .jpg, .jpeg" style="margin-top: 10px; background-color: inherit;"><br>
