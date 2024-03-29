@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
        <div class="media-container">
           @if (Session::has('success_admin'))
              <div class="alert alert-success success_green">
                 <center>{{ Session::get('success_admin') }}</center>
              </div>
            @endif  
            @if (Session::has('success_user'))
              <div class="alert alert-success success_green">
                 <center>{{ Session::get('success_user') }}</center>
              </div>
            @endif  
            @if (Session::has('delete_admin'))
              <div class="alert alert-danger delete_red">
                 <center>{{ Session::get('delete_admin') }}</center>
              </div>
            @endif
            @if (Session::has('delete_user'))
              <div class="alert alert-danger delete_red">
                 <center>{{ Session::get('delete_user') }}</center>
              </div>
            @endif 
             @if (Session::has('success_new_registered'))
              <div class="alert alert-success success_green">
                 <center>{{ Session::get('success_new_registered') }}</center>
              </div>
            @endif   
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'new_user_account')" id="defaultOpen">Add Customer Account</button>
            <button class="tablinks"  onclick="openCity(event, 'user_account')" >Customer Account</button>
            <button class="tablinks"  onclick="openCity(event, 'admin_account')" >Admin Account</button>
          </div>    

        <div class="press-release-content">
           <div id="new_user_account" class="tabcontent user-media-container">
               <div class="title-container">Registration for New Customer</div>
               @if(session()->has('message'))
                  <div class="details">
                  <span style="color: red;">
                    <strong>Error!</strong> {{ session('message') }}<br>
                  </span>
                  </div>
                @endif<br>
               <form method="post" action="/pressadmin/add_user" enctype="multipart/form-data" >
                {{csrf_field()}}
                <div class="register-form" >
                  <select class="form-control" name="user_membership" id="user_membership" style="width: 740px">
                     <option selected>--Costing Option--</option>
                     <option value="1">1 Time sending</option>
                     <option value="3">3 Times sending</option>
                     <option value="5">5 Times sending</option>
                     <option value="30">6 Months Contract / maximum 30 campaigns within 6 months / 15,000 emails</option>
                     <option value="60">12 Months Contract / maximum 60 Campaigns within 6 months / 30,000 emails</option>
                  </select> 
                </div><br>

                <div class="register-form ">
                  <select class="chosen-select" id="user_country" name="user_country[]" data-placeholder="Select Country for User"  style="width: 740px" multiple="multiple"> 
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Singapore">Singapore</option> 
                    <option value="Philippines">Philippines</option> 
                    <option value="China">China</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="India">India</option>
                    <option value="Canada">Canada</option>
                  </select> 
                </div>
             
                <div class="register-form">
                <input class="form-control" type="text" name="user_first_name" id="user_first_name" placeholder="First Name" >
                </div>
                <div class="register-form">
                  <input class="form-control" type="text" name="user_last_name" id="user_last_name" placeholder="Last Name" >
                </div>
                <div class="register-form">
                  <input class="form-control" type="email" name="user_email" id="user_email" placeholder="Email" >
                </div>
                <div class="register-form">
                  <input class="form-control" type="password" name="user_password" id="user_password" placeholder="Password" >
                </div>
                <div class="register-form">
                  <input class="form-control" type="password" name="user_password_confirmation" id="user_password_confirmation" placeholder="Confirm Password">
                </div>
                <div class="register-form">
                  <input class="form-control" type="text" name="user_company_name" id="user_company_name" placeholder="Company" >
                </div>

                <div class="register-form">
                 <input type="file" name="user_company_image" id="user_company_image" accept=".png, .jpg, .jpeg">
                </div>

                <div class="button-container">
                    <button type="submit">Submit</button>
                </div>
                </form>  
            </div>

            <div id="user_account" class="tabcontent press-media-container">
              <div class="user-container"><br>
                  <div class="search-container pull-right">
                      <input placeholder="Search" type="text"  name="search_user" id="search_user">
                      <button  type="button" name="search_button_user" id="search_button_user" class="btn btn-success">Search</button>
                  </div>
                  <div class="title">Customer Account</div>
                  <table  class="table table-bordered" id="showHere_table_search">
                     <tr>
                         <th style="width: 15%;">Name</th>
                         <th style="width: 15%;">Email</th>
                         <th style="width: 15%;">Company Name</th>
                         <th style="width: 15%;">Membership Plan</th>
                         <th style="width: 15%;">Date Started</th>
                         <th style="width: 20%;">Action</th>
                     </tr>
                        @foreach($_user as $_user_account)
                        <tr>
                           <td>{{$_user_account->user_first_name}} {{$_user_account->user_last_name}}</td>
                           <td>{{$_user_account->user_email}}</td>
                           <td>{{$_user_account->user_company_name}}</td> 
                           <td>
                            {{($_user_account['user_membership']=="1") ? '1 Time Sending' : ''}}
                            {{($_user_account['user_membership']=="3") ? '3 Times Sending' : ''}}
                            {{($_user_account['user_membership']=="5") ? '5 Times Sending' : ''}}
                            {{($_user_account['user_membership']=="30") ? '6 Months Contract' : ''}}
                            {{($_user_account['user_membership']=="60") ? '12 Months Contract' : ''}}
                           </td>
                           <td>{{date("F d, Y - H:i:s", strtotime($_user_account->user_date_created))}}</td>
                           <td>
                            <button type="button"  class="btn btn-warning center pop_user_btn" data-id="{{$_user_account->user_id}}">
                            <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>

                            {{-- <a id="edit" href="/pressadmin/edit_user/{{$_user_account->user_id}}"> --}}
                            {{-- <button type="button"  class="btn btn-warning center "><i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>  Edit</button></a> --}}

                            <button type="button" class="btn btn-danger center pop_user_delete" data-id="{{$_user_account->user_id}}">
                            <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>  Delete</button></a>

                            {{-- <a onclick="return confirm('Force to Login?');" href="/pressadmin/manage_force_login/{{$_user_account->user_id}}"> --}}
                            <button type="button" class="btn btn-success center pop_force_login" data-id="{{$_user_account->user_id}}">
                            <i class="fa fa-vcard-o" name="recipient_id" aria-hidden="true"></i>  Force Login</button></a>
                           </td>
                        </tr>
                        @endforeach
                  </table>
              </div>    
            </div>

            <div id="admin_account" class="tabcontent add-media-container"><br>
                  <table  class="table table-bordered" id="showHere_table">
                     <tr>
                         <th style="width: 20%;">First Name</th>
                         <th style="width: 20%;">Last Name</th>
                         <th style="width: 20%;">Username</th>
                         <th style="width: 20%;">Action</th>
                            
                     </tr>       
                      @foreach($_admin as $_admin_account)
                        <tr>
                           <td>{{$_admin_account->user_first_name}}</td>
                           <td>{{$_admin_account->user_last_name}}</td>
                           <td>{{$_admin_account->user_email}}</td>
                           <td>

                            <button type="button"  class="btn btn-warning center pop_admin_btn" data-id="{{$_admin_account->user_id}}">
                            <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>

                           {{--  <a href="/pressadmin/edit_admin/{{$_admin_account->user_id}}"><button type="button"  class="btn btn-warning center">
                            <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>  Edit</button> --}}

                            {{-- <a onclick="return confirm('Are you sure you want to Delete?');" href="/pressadmin/manage_user/delete_admin/{{$_admin_account->user_id}}"> --}}
                            <button type="button"  class="btn btn-danger center pop_admin_delete" data-id="{{$_admin_account->user_id}}">
                            <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>  Delete</button>
                           </td>
                        </tr>
                        @endforeach
                  </table>
                  
                  <div class="title-container">Add Admin Account</div>
                  <form method="post" action="">
                   {{csrf_field()}}
                  <div class="title"></div>
                   <input type="text" id="user_first_name" name="user_first_name" class="form-control" placeholder="First Name" required>

                   <div class="title"></div>
                   <input type="text"  id="user_last_name" name="user_last_name" class="form-control" placeholder="Last Name" required>

                   <div class="title"> </div>
                   <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Email" required>

                   <div class="title"></div>
                   <input type="Password" id="user_password" name="user_password" class="form-control" placeholder="Password" required>

                   <div class="button-container">
                       <button type="submit" id="admin_submit_button" name="admin_submit_button" formaction="/pressadmin/manage_user/add_admin">Submit</button>
                   </div>
                  </form>
            </div>
        </div>
    </div>
</div>  

<div class="popup-view">
  <div class="modal" id="viewPopup" name="viewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressadmin/manage_user_edit" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Update User</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <button type="submit" id="submit_button" class="btn btn-primary pull-right" name="submit_button">Update User</button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupDeleteUser" name="viewPopupDeleteUser" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/delete_user_account" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Are you sure you want to Delete?</h4>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewAdminPopup" name="viewAdminPopup" role="dialog">
    <div class="modal-dialog modal-lg">
      <form method="post" action="/pressadmin/manage_admin_edit" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Update Admin</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <button type="submit" id="submit_button" class="btn btn-primary pull-right" name="submit_button">Update Admin</button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form> 
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupDeleteAdmin" name="viewPopupDeleteAdmin" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/manage_user/delete_admin_user" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Are you sure you want to Delete?</h4>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupForceLogin" name="viewPopupForceLogin" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/force_login" >
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Force to Login?</h4>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section("css") 
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_manage_user.css">
@endsection

@section("script")
<script  src="/assets/js/manage_user.js"></script>

<script>
function openCity(evt, cityName) 
{
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>

<script>
   document.getElementById("user_country").click();
   $(".chosen-select").chosen({disable_search_threshold: 10});
</script>

<script>
  $('.pop_user_btn').click(function()
  {
      var user_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/edit_user/'+user_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopup').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_user_delete').click(function()
  {
      var user_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/delete_user/'+user_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupDeleteUser').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_admin_btn').click(function()
  {
      var admin_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/edit_admin/'+admin_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewAdminPopup').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_admin_delete').click(function()
  {
      var admin_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/manage_user/delete_admin/'+admin_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupDeleteAdmin').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_force_login').click(function()
  {
      var user_id_force = $(this).data('id');

      $.ajax({
        url: '/pressadmin/manage_force_login/'+user_id_force,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupForceLogin').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  setTimeout(function() 
  {
    $('.success_green').fadeOut('fast');
  }, 2000); 
</script>

<script>
  setTimeout(function() 
  {
    $('.delete_red').fadeOut('fast');
  }, 2000); 
</script>


@endsection

