@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
       <div class="drafts-holder-container">
        @if (Session::has('success_update_user'))
              <div class="alert alert-success">
                 <center>{{ Session::get('success_update_user') }}</center>
              </div>
            @endif  
         <div class="title-container">User Details</div>
            <div class="title-container">


            <form method="post" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="col-md-2">First Name:</div>
              <div class="col-md-4">
              <input type="text" id="user_first_name" name="user_first_name" class="form-control" value="{{$manage_user->user_first_name}}" >
              </div>
              
              <div class="col-md-2">Last Name:</div>
              <div class="col-md-4">
              <input type="text" id="user_last_name" name="user_last_name" class="form-control"  value="{{$manage_user->user_last_name}}" >
              </div>

              <div class="col-md-2">Email:</div>
              <div class="col-md-4">
              <input type="text" id="user_email" name="user_email" class="form-control"  value="{{$manage_user->user_email}}" readonly>
              </div>

              <div class="col-md-2">Company Name:</div>
              <div class="col-md-4">
              <input type="text" id="user_company_name" name="user_company_name" class="form-control"  value="{{$manage_user->user_company_name}}" >
              </div>

              <div class="col-md-2">New Password:</div>
              <div class="col-md-4">
                 <input type="Password" id="user_password" name="user_password" class="form-control"  >
              </div>

              <div class="col-md-2">Confirm Password:</div>
              <div class="col-md-4">
                 <input type="Password" id="user_password_confirmation" name="user_password_confirmation" class="form-control"  v>
              </div>
              <div class="col-md-4">
                  <input type="file" name="user_company_image" id="user_company_image" accept=".png, .jpg, .jpeg">
              </div>

              <div class="col-md-8">
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
</div>
<style>
.Title {
 
  color: white;
  padding: 10px;
} 
</style>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_drafts.css">
@endsection

@section("script")

@endsection