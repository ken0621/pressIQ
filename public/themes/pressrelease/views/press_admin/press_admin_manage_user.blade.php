@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
        <div class="media-container">
           @if (Session::has('success_admin'))
              <div class="alert alert-success">
                 <center>{{ Session::get('success_admin') }}</center>
              </div>
            @endif  
            @if (Session::has('success_user'))
              <div class="alert alert-success">
                 <center>{{ Session::get('success_user') }}</center>
              </div>
            @endif  
            @if (Session::has('delete_admin'))
              <div class="alert alert-danger">
                 <center>{{ Session::get('delete_admin') }}</center>
              </div>
            @endif
            @if (Session::has('delete_user'))
              <div class="alert alert-danger">
                 <center>{{ Session::get('delete_user') }}</center>
              </div>
            @endif 
             @if (Session::has('success_new_registered'))
              <div class="alert alert-success">
                 <center>{{ Session::get('success_new_registered') }}</center>
              </div>
            @endif   
          <div class="tab">
             <button class="tablinks" onclick="openCity(event, 'new_user_account')" id="defaultOpen">Add User Account</button>
            <button class="tablinks"  onclick="openCity(event, 'user_account')" >Users Account</button>
            <button class="tablinks"  onclick="openCity(event, 'admin_account')" >Admin Account</button>
          </div>    

        <div class="press-release-content">
           <div id="new_user_account" class="tabcontent user-media-container">
               <div class="title-container">Registration for New User</div>
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
              <div class="user-update-container">
                @if(session::has('edit_user'))
                 @foreach($_user_edit as $_user_edits)
                  <div class="title-container">UPDATE USER ACCOUNT</div>
                    <form method="post" action="">
                      {{csrf_field()}}
                      <div class="title">First Name:</div>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{$_user_edits->user_first_name}}" autofocus>

                      <div class="title">Last Name:</div>
                      <input type="text"  id="last_name" name="last_name" class="form-control" value="{{$_user_edits->user_last_name}}">

                      <div class="title">Email:</div>
                      <input type="text" id="email" name="email" class="form-control" value="{{$_user_edits->user_email}}">

                      <div class="title">Company Name:</div>
                      <input type="text" id="company_name" name="company_name" class="form-control" value="{{$_user_edits->user_company_name}}">

                      <div class="button-container">
                          <button type="submit" id="submit_button" name="submit_button" formaction="/pressadmin/manage_user_edit">Submit</button>
                      </div>
                  </form>
                 @endforeach
                @endif
              </div>

              <div class="user-container">
                 <div class="title">User Account
                        <div class="search-container pull-right">
                         <input placeholder="Search" type="text"  name="search_user" id="search_user">
                         <button  type="button" name="search_button_user" id="search_button_user" class="btn btn-success">Search</button>
                        </div>
                  </div>
                  <table  class="table table-bordered" id="showHere_table_search">
                     <tr>
                         <th style="width: 15%;">First Name</th>
                         <th style="width: 15%;">Last Name</th>
                         <th style="width: 15%;">Email</th>
                         <th style="width: 15%;">Company Name</th>
                         <th style="width: 15%;">Date Started</th>
                         <th style="width: 20%;">Action</th>
                     </tr>
                      @foreach($_user as $_user_account)
                        <tr>
                           <td> <a href="">{{$_user_account->user_first_name}}</td>
                           <td>{{$_user_account->user_last_name}}</td>
                           <td>{{$_user_account->user_email}}</td>
                           <td>{{$_user_account->user_company_name}}</td>
                           <td>{{$_user_account->user_date_created}}</td>
                           <td>
                            <a id="edit" href="/pressadmin/edit_user/{{$_user_account->user_id}}"><button type="button"  class="btn btn-warning center"><i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>  Edit</button></a>

                            <a href="/pressadmin/delete_user/{{$_user_account->user_id}}"><button type="button" class="btn btn-danger center">
                            <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>  Delete</button></a>

                            <a href="/pressadmin/manage_force_login/{{$_user_account->user_id}}"><button type="button" class="btn btn-success center">
                            <i class="fa fa-vcard-o" name="recipient_id" aria-hidden="true"></i>  Force Login</button></a>
                           </td>
                        </tr>
                        @endforeach
                  </table>
              </div>    
            </div>

            <div id="admin_account" class="tabcontent add-media-container">
                <div class="title-container">Update Admin Account</div><br>
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
                            <a href="/pressadmin/edit_admin/{{$_admin_account->user_id}}"><button type="button"  class="btn btn-warning center">
                            <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>  Edit</button>

                            <a href="/pressadmin/manage_user/delete_admin/{{$_admin_account->user_id}}"><button type="button"  class="btn btn-danger center">
                            <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>  Delete</button>
                           </td>
                        </tr>
                        @endforeach
                  </table>
                @if(session::has('edit_admin'))
                 @foreach($_admin_edit as $_admin_edits)
                     <div class="title-container">Add Admin Account</div>
                       <form method="post" action="">
                         {{csrf_field()}}
                         <div class="title">First Name:</div>
                       <input type="text" id="first_name" name="first_name" class="form-control" value="{{$_admin_edits->user_first_name}}" autofocus>

                         <div class="title">Last Name:</div>
                         <input type="text"  id="last_name" name="last_name" class="form-control" value="{{$_admin_edits->user_last_name}}">

                         <div class="title">Email:</div>
                         <input type="text" id="email" name="email" class="form-control" value="{{$_admin_edits->user_email}}">


                         <div class="title">Company:</div>
                         <input type="text" id="company_name" name="company_name" class="form-control" value="{{$_admin_edits->user_company_name}}">

                         <div class="button-container">
                             <button type="submit" id="submit_button" name="submit_button" formaction="/pressadmin/manage_admin_edit">Submit</button>
                         </div>
                     </form>
                    @endforeach
                   @else
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
                   @endif
            </div>
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
  $('#edit').click(function()
  {
    //alert("123");
    $('#previewPopup').modal('show');
</script>

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

@endsection

