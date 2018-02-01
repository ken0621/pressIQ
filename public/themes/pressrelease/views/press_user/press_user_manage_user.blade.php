@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
       <div class="manage-user-container">
        @if (Session::has('success_update_user'))
              <div class="alert alert-success">
                 <center>{{ Session::get('success_update_user') }}</center>
              </div>
            @endif  
         <div class="title-container">User Details</div>

            <form method="post" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="title">First Name:</div>
              <input type="text" id="user_first_name" name="user_first_name" class="form-control" value="{{$manage_user->user_first_name}}" >
              
              <div class="title">Last Name:</div>
              <input type="text" id="user_last_name" name="user_last_name" class="form-control"  value="{{$manage_user->user_last_name}}" >

              <div class="title">Email:</div>  
              <input type="text" id="user_email" name="user_email" class="form-control"  value="{{$manage_user->user_email}}" readonly>

              <div class="title">Company Name:</div>
              <input type="text" id="user_company_name" name="user_company_name" class="form-control"  value="{{$manage_user->user_company_name}}" >

              <div class="title">New Password:</div>
              <input type="Password" id="user_password" name="user_password" class="form-control"  >

              <div class="title">Confirm Password:</div>
              <input type="Password" id="user_password_confirmation" name="user_password_confirmation" class="form-control"  v>
              
              <input type="file" name="user_company_image" id="user_company_image" accept=".png, .jpg, .jpeg" style="margin-top: 10px; background-color: inherit;">

              <div class="button-container">
                <button type="Submit" formaction="/pressuser/manage_user/update">Update</button>
              </div>
            
            </form>

              @if(session()->has('message'))
              <div class="details">
              <span style="color: red;">
                <strong>Error!</strong> {{ session('message') }}<br>
              </span>
              </div>
              @endif
        </div>
    </div>
</div>
<style>
.Title {
 
  color: white;
  padding: 10px;
} 
</style>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/pressuser_manage_user.css">
@endsection

@section("script")

@endsection