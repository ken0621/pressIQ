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
                             <th style="width: 20%;">Username</th>
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
                                <a href=""><button type="button"  class="">
                                <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>Force Login</button>
                                
                               </td>
                            </tr>
                            @endforeach
                      </table>
                    <label>UPDATE USER ACCOUNT</label>
                      <form method="post" action="">
                        {{csrf_field()}}
                        <div class="title">First Name: *</div>
                        <input type="text" id="name" name="name" class="form-control" required>

                        <div class="title">Last Name: *</div>
                        <input type="text"  id="position" name="position" class="form-control" required>

                        <div class="title">Username: *</div>
                        <input type="text" id="company_name" name="company_name" class="form-control" required>


                        <div class="title">Company Name: *</div>
                        <input type="text" id="country" name="country" class="form-control" required>

                    
                        <div class="button-container">
                            <button type="submit" id="submit_button" name="submit_button">Submit</button>
                        </div>
                    </form>
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
                            <a href=""><button type="button"  class="">
                            <i class="fa fa-wrench" name="recipient_id" aria-hidden="true"></i>Edit</button>
                            <a href=""><button type="button"  class="">
                            <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>Delete</button>
                           </td>
                        </tr>
                        @endforeach
                     
                  </table>
                <label>ADD ADMIN ACCOUNT</label>
                  <form method="post" action="">
                    {{csrf_field()}}
                    <div class="title">First Name: *</div>
                    <input type="text" id="" name="" class="form-control" required>

                    <div class="title">Last Name: *</div>
                    <input type="text"  id="" name="" class="form-control" required>

                    <div class="title">Username: *</div>
                    <input type="text" id="" name="" class="form-control" required>


                    <div class="title">Password: *</div>
                    <input type="Password" id="" name="" class="form-control" required>

                
                    <div class="button-container">
                        <button type="submit" id="submit_button" name="submit_button">Submit</button>
                    </div>
                </form>
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

