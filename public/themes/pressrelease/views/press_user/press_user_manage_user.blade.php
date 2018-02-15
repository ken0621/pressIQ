@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
       <div class="manage-user-container">
         <div class="title-container">Profile Account</div>
         @if(session()->has('message'))
              <div class="details">
              <span style="color: red;">
                <strong>Error!</strong> {{ session('message') }}<br>
              </span>
              </div>
              @endif
            <form method="post" enctype="multipart/form-data">
              {{csrf_field()}}     
              <div class="title">Company Logo:</div>
              <img src="{{$manage_user->user_company_image}}" style="object-fit:contain; width:300px; height: 300px" class="img-thumbnail" alt="">

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
              <input type="Password" id="user_password_confirmation" name="user_password_confirmation" class="form-control" >

              
              <div class="title">Change Company Logo:</div>
              <input type="file" name="user_company_image" id="user_company_image" accept=".png, .jpg, .jpeg" style="margin-top: 10px; background-color: inherit;">

              <div class="button-container">
                <button type="Submit" formaction="/pressuser/manage_user/update">Update Account</button>
              </div>
            </form>
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
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:780031,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
@endsection