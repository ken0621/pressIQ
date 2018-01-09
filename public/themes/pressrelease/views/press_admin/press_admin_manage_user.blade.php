@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
        <div class="media-container">
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'user_account')" id="defaultOpen">Users Account</button>
            <button class="tablinks" onclick="openCity(event, 'admin_account')" >Admin Account</button>
          </div>
                                    
            <div class="press-release-content">

            <div id="user_account" class="tabcontent press-media-container">
                    <label>USER ACCOUNT</label>
                      <table  class="table table-bordered" id="showHere_table">
                         <tr>
                             <th style="width: 20%;">First Name</th>
                             <th style="width: 20%;">Last Name</th>
                             <th style="width: 20%;">Email</th>
                              <th style="width: 20%;">Company Name</th>
                              <th style="width: 20%;">Action</th>
                         </tr>
                          @foreach($_user as $_user_account)
                            <tr>
                               <td> <a href="">{{$_user_account->user_first_name}}</td>
                               <td>{{$_user_account->user_last_name}}</td>
                               <td>{{$_user_account->user_email}}</td>
                                <td>{{$_user_account->user_company_name}}</td>
                               <td>
                                <a href="/pressadmin/edit_user/{{$_user_account->user_id}}'"><button type="button"  class="">
                                <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>Edit</button>
                                <a href=""><button type="button"  class="">
                                <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>Force Login</button>
                                
                               </td>
                            </tr>
                            @endforeach
                      </table>
            </div>
            <div id="admin_account" class="tabcontent add-media-container">
                <label>ADMIN ACCOUNT</label>
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
                            <a href="/pressadmin/manage_user/edit_admin/{{$_admin_account->user_id}}"><button type="button"  class="">
                            <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>Edit</button>

                            <a href="/pressadmin/manage_user/delete_admin/{{$_admin_account->user_id}}"><button type="button"  class="">
                            <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>Delete</button>
                           </td>
                        </tr>
                        @endforeach
                     
                  </table>
                @if(session()->has("u_edit"))
                   @foreach($_edit as $_admin_edit)
                    <form method="post" >
                      {{csrf_field()}}
                      <div class="title">First Name: *</div>
                      <input type="text" id="user_first_name" name="user_first_name" value="{{$_admin_edit->user_first_name}}" class="form-control" required>

                      <div class="title">Last Name: *</div>
                      <input type="text"  id="user_last_name" name="user_last_name" value="{{$_admin_edit->user_last_name}}" class="form-control" required>

                      <div class="title">Username: *</div>
                      <input type="email" id="user_email" name="user_email" class="form-control" value="{{$_admin_edit->user_email}}" required>

                      <div class="title">Password: *</div>
                      <input type="Password" id="user_password" name="user_password" class="form-control" value="{{$_admin_edit->user_password}} required>

                      <div class="button-container">
                          <button type="submit" id="admin_submit_button" name="admin_submit_button" formaction="/pressadmin/manage_user/add_admin">Submit</button>
                      </div>
                  </form>
                  @endforeach
                 @else
                  <form method="post"  >
                    {{csrf_field()}}
                    <div class="title">First Name: </div>
                    <input type="text" id="user_first_name" name="user_first_name" class="form-control" required>

                    <div class="title">Last Name: </div>
                    <input type="text"  id="user_last_name" name="user_last_name" class="form-control" required>

                    <div class="title">Username: </div>
                    <input type="email" id="user_email" name="user_email" class="form-control" required>

                    <div class="title">Password: </div>
                    <input type="Password" id="user_password" name="user_password" class="form-control" required>

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

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

@endsection

