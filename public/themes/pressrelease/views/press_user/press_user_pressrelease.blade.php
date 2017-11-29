@extends("press_user.member")
@section("pressview")

<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
            <div class="press-release-container">
                  <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'create_pr')" id="defaultOpen">Create Press Release</button>
                    <button class="tablinks" onclick="openCity(event, 'manage_pr')">Manage Press Release</button>
                    <button class="tablinks" onclick="openCity(event, 'add_recipient')">Add Recipient</button>
                  </div>
                                            
                    <div class="press-release-content">

                        <div id="create_pr" class="tabcontent create-pr-container">
                            <div class="title-container">PRESS RELEASE</div>
                            <div class="title">Send To:</div>
                            <input type="text" class="form-control"><span class="choose-button"><a data-toggle="modal" data-target="#recipient-modal" href="#">Choose Recipient</a></span>
                            <div class="title">Headline:</div>
                            <input type="text" class="form-control">
                            <div class="title">Subheading:</div>
                            <input type="text" class="form-control">
                            <div class="title">Content:</div>
                            <textarea></textarea>
                            <div class="button-container">
                                <span class="save-button"><a href="#">Save as draft</a></span><span class="send-button"><a href="#">Send</a></span>
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

                        <div id="add_recipient" class="tabcontent manage-pr-container">
                          

                            
                          
                          
                           
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
              <div class="title-container">Add Recipient</div>
            </div>
            <div class="modal-body">
              <div class="row clearfix">
                <div class="col-md-4">
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
                <div class="col-md-8">
                    <div class="left-container">
                        <input type="checkbox">Contact 1<br>
                        <input type="checkbox">Contact 2<br>
                        <input type="checkbox">Contact 3<br>
                        <input type="checkbox">Contact 4<br>
                        <input type="checkbox">Contact 5<br>
                        <input type="checkbox">Contact 6<br>
                        <input type="checkbox">Contact 7
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

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_pressrelease.css">
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