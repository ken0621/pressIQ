@extends("press_user.member")
@section("pressview")
<div class="background-container" style="height: 1000px;">
    <div class="pressview" >
       <div class="manage-user-container" style="height: 900px;">
         <div class="title-container">Profile Account</div>
              @if(session()->has('message'))
              <div class="details">
              <span style="color: red;">
                <strong>Error!</strong> {{ session('message') }}<br>
              </span>
              </div><br>
              @endif
              
              <img src="{{$manage_user->user_company_image}}" style="object-fit:contain; width:300px; height: 300px" class="img-thumbnail" alt="">

              <div class="title">First Name:</div>
              <input type="text" id="user_first_name" name="user_first_name" class="form-control" value="{{$manage_user->user_first_name}}" readonly>
              
              <div class="title">Last Name:</div>
              <input type="text" id="user_last_name" name="user_last_name" class="form-control"  value="{{$manage_user->user_last_name}}" readonly>

              <div class="title">Email:</div>  
              <input type="text" id="user_email" name="user_email" class="form-control"  value="{{$manage_user->user_email}}" readonly>

              <div class="title">Company Name:</div>
              <input type="text" id="user_company_name" name="user_company_name" class="form-control"  value="{{$manage_user->user_company_name}}" readonly><br><br>

              {{--<div class="title">New Password:</div>
              <input type="Password" id="user_password" name="user_password" class="form-control"  >

              <div class="title">Confirm Password:</div>
              <input type="Password" id="user_password_confirmation" name="user_password_confirmation" class="form-control" >

              <div class="title">Change Company Logo:</div>
              <input type="file" name="user_company_image" id="user_company_image" accept=".png, .jpg, .jpeg" style="margin-top: 10px; background-color: inherit;"><br>--}}
            
              {{-- <button type="Submit" formaction="/pressuser/manage_user/update">Update Account</button> --}}
              <button type="button" class="btn btn-primary center pop_up_profile" data-id="{{$manage_user->user_id}}" >Edit Profile Account</button>

        </div>
    </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupProfile" name="viewPopupProfile" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressuser/manage_user/profile_update" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Profile</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit_button" class="btn btn-primary pull-right" name="submit_button">Update</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>

<style>
.Title {
 
  color: white;
  padding: 100px;
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

<script>
  $('.pop_up_profile').click(function()
  {
      var profile_id = $(this).data('id');

      $.ajax({
        url: '/pressuser/manage_user/update/'+profile_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupProfile').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

@endsection