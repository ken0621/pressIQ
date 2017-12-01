@extends("press_user.member")
@section("pressview")

<div class="background-container">
    <div class="pressview">
    <div class="dashboard-container">
        <div class="press-release-container">
          <div class="tab"  style="border-style: none;">
            <button class="tablinks" onclick="openCity(event, 'create_pr')" id="defaultOpen">Create Press Release</button>
            <button class="tablinks" onclick="openCity(event, 'manage_pr')">Manage Press Release</button>
            <button class="tablinks" onclick="openCity(event, 'add_recipient')">Add Recipient</button>
          </div>
                                    
            <div class="press-release-content">

                <div id="create_pr" class="tabcontent create-pr-container">
                      @if (Session::has('message'))
                      <div class="alert alert-success">
                         <center>{{ Session::get('message') }}</center>
                      </div>
                      @endif 
                     @if (Session::has('delete'))
                      <div class="alert alert-danger ">
                         <center>{{ Session::get('delete') }}</center>
                      </div>
                      @endif
                    <div class="title-container">PRESS RELEASE</div>
                    <div class="title">Send To:</div>
                    <input type="text" class="form-control" id="sendto" name="sendto" placeholder="Choose Recipient">
                    <span class="choose-button"><a data-toggle="modal" data-target="#recipient-modal" href="#">Choose Recipient</a></span>

                    <div class="title">Headline:</div>
                    <input type="text" class="form-control" id="headline" name="headline">

                    <div class="title">Subheading:</div>
                    <input type="text" class="form-control" id="subheading" name="subheading">

                    <div class="title">Content:</div>
                    <textarea id="content" name="content"></textarea>
                    <div class="button-container">
                        <span class="save-button" id="btn_save" name="btn_save"><a href="#">Save & Draft </a></span>
                        <span class="send-button" id="btn_send" name="btn_send"><a href="#">Send</a></span>
                    </div>

                </div>

                <div id="manage_pr" class="tabcontent manage-pr-container">
                    <div class="manage-holder-container">
                        <table>
                            <tr>    
                                <th>Press Release Title</th>
                                <th>Publish Date</th>
                                <th>Status</th>
                                <th>Send</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            <tr>
                                <td>Sample 1</td>
                                <td>15/11/2017</td>
                                <td>Draft</td>
                                <td><a href="#">Send</a></td>
                                <td><a href="#">Edit</a></td>
                                <td><a href="#">Delete</a></td>
                            </tr>
                            <tr>
                                <td>Sample 2</td>
                                <td>16/11/2017</td>
                                <td>Draft</td>
                                <td><a href="#">Send</a></td>
                                <td><a href="#">Edit</a></td>
                                <td><a href="#">Delete</a></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div id="add_recipient" class="tabcontent create-pr-container">
                    <div class="manage-holder-container">

                    <div role="tabpanel" class="tab-pane fade active in" id="">
                     <form class="form-horizontal" method="post" action="/pressadmin/pressreleases_addrecipient">
                        {{csrf_field()}}
                        
                        <div class="title">Contact Name:</div>
                        <input type="text" class="form-control" id="name" name="name"> </input><br>

                        <div class="title">Email:</div>
                        <input type="text" class="form-control"  id="research_email_address" name="research_email_address"></input><br>

                        <div class="title">Website:</div>
                        <input type="text" class="form-control" id="website" name="website"> </input><br>

                        <div class="title">Description:</div>
                        <input type="text" class="form-control" id="description" name="description"> </input><br>

                        <div class="title">Country:</div>
                        <select type="text" class="form-control" name="country" placeholder="select Country">
                            <option value="">--Select Country--</option>
                            <option value="Philippines">Philippines</option>
                            <option value="USA">USA</option>
                            <option value="China">China</option>
                            <option value="Korea">Korea</option>
                        </select><br>

                        <div class="button-container-add">
                            <button type="submit" class="" id="btn_save" name="btn_save" style="background-color: #316df9;">Add Recipients</button>
                        </div>  

                     </form>
                    </div>

                     <table id="example" class="display table table-bordered" style="background-color: #FFFFFF;width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Contact Name</th>
                                        <th style="text-align: center;">Country</th>
                                        <th style="text-align: center;">Email</th>
                                        <th style="text-align: center;">Website</th>
                                        <th style="text-align: center;">Description</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($add_recipient as $addrecipients)
                                    <tr>
                                       
                                        <td style="text-align: center;">{{$addrecipients->name}}</td>
                                        <td style="text-align: center;">{{$addrecipients->country}}</td>
                                        <td style="text-align: center;">{{$addrecipients->research_email_address}}</td>
                                        <td style="text-align: center;">{{$addrecipients->website}}</td>
                                        <td style="text-align: center;">{{$addrecipients->description}}</td>
                                        <td bgcolor="transparent" style="text-align: center;">
                                        <a href="/pressadmin/pressreleases_deleterecipient/{{$addrecipients->recipient_id}}" style="background-color: transparent; color: transparent;" ><button type="submit" class="btn btn-danger center" id="delete_recipients" name="delete_recipients"> Delete</button>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                      
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="popup-choose">
<!-- Modal -->
  <div class="modal fade" id="recipient-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="title-container">RECIPIENT</div>
        </div>
        <div class="modal-body">
          <div class="row clearfix">
            <div class="col-md-3">
                <div class="title-container">Choose Country</div>
                <div class="right-container">
                    <input type="checkbox">Philippines<br>
                    <input type="checkbox">Hongkong<br>
                    <input type="checkbox">China<br>
                    <input type="checkbox">Korea<br>
                    <input type="checkbox">Malaysia<br>
                    <input type="checkbox">USA
                </div>
            </div>
            <div class="col-md-9">
                <div class="left-container">
                   <table id="example" class="display table table-bordered" style="background-color: #FFFFFF;width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;">Email</th>
                                        <th style="text-align: center;">Website</th>
                                        <th style="text-align: center;">Description</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($add_recipient as $addrecipients)
                                    <tr>
                                       
                                        <td style="text-align: center;"><a href="">{{$addrecipients->name}}</td>
                                        <td style="text-align: center;">{{$addrecipients->research_email_address}}</td>
                                        <td style="text-align: center;">{{$addrecipients->website}}</td>
                                        <td style="text-align: center;">{{$addrecipients->description}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="button-container">
            <a data-dismiss="modal" href="#">Continue</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<style>
.modal-content
{
  width: 800px;

}
.button-container-add
{
   margin-bottom:20px;
   background-color: #316df9;
   width: 150px;
}
.form-control
{
   
    width: 450px;

}

.form-text
   {
   text-align: center;
   width:350px;
   padding:10px 10px 10px 10px;
   }

</style>


@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_pressrelease.css">
<!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> -->
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

<script>tinymce.init({ selector:'textarea' });</script>

@endsection