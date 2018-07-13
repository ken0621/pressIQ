@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
        <div class="media-container">
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'press_media')" id="defaultOpen">Press IQ Media Contacts</button>
            <button class="tablinks" onclick="openCity(event, 'add_media')" >Add Media Contacts</button>
          </div>
                                    
            <div class="press-release-content">
            <div id="press_media" class="tabcontent press-media-container">
                  @if (Session::has('success_merchant'))
                  <div class="alert alert-success">
                     <center>{{ Session::get('success_merchant') }}</center>
                  </div>
                  @endif 
                  @if (Session::has('delete'))
                  <div class="alert alert-danger">
                     <center>{{ Session::get('delete') }}</center>
                  </div>
                  @endif

                <div class="col-md-12">
                 <div class="press-holder-container">
                    <div class="search-container pull-right">
                        <input placeholder="Search" type="text"  name="search_media" id="search_media">
                        <button  type="button" name="search_button" id="search_button" class="btn btn-success">Search</button>
                    </div>  
                    <div class="title-container">Media Contacts</div> 
                    <div class="left-container" name="press_table" id="press_table1">
                        <table  class="table table-bordered" id="showHere_table1">
                                <tr>
                                    <th style="width: 25%;">Contact Name</th>
                                    <th style="width: 25%;">Company</th>
                                    <th style="width: 25%;">Country</th>
                                    <th style="width: 25%;">Action</th>
                                </tr>
                            @foreach($_media_contacts as $_media)
                                <tr>
                                   <td>{{$_media->name}}</td>
                                   <td>{{$_media->company_name}}</td>
                                   <td>{{$_media->country}}</td>
                                   <td>
                                     <button type="button"  class="btn btn-warning center pop_chosen_recipient_btn" data-id="{{$_media->recipient_id}}">
                                     <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>
                                     
                                     <a onclick="return confirm('Are you sure you want to Delete?');" href="/pressadmin/pressreleases_deleterecipient/{{$_media->recipient_id}}"><button type="button"  class="btn btn-danger center">
                                     <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>Delete</button></a>
                                   </td>
                                </tr>
                            @endforeach
                        </table>
                   </div>
                 </div>    
                </div>
            </div>

            <div id="add_media" class="tabcontent add-media-container">
                <form method="post" action="/pressadmin/pressreleases_addrecipient" enctype="multipart/form-data">
                    {{csrf_field()}}
                   
                    <input type="hidden" id="name" name="action" class="form-control" value="add">

                    <div class="title">Contact Name: *</div>
                    <input type="text" id="name" name="name" class="form-control" style="background-color: #f1f1f1;" placeholder="Enter the name of the media contact" required>

                    <div class="title">Company Name: *</div>
                    <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Enter the company name of the media contact" style="background-color: #f1f1f1;" required>

                     <div class="title">Email: *</div>
                    <input type="email" id="contact_email" name="contact_email" class="form-control" style="background-color: #f1f1f1;" placeholder="Enter one email address only" required>

                    <div class="title">Country: *</div>
                        <select class="form-control" id="country" name="country" data-placeholder="Select Country for User" style="width: 700px;background-color: #f1f1f1;"> 
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Singapore">Singapore</option> 
                            <option value="China">China</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="India">India</option>
                            <option value="Canada">Canada</option>
                        </select> 

                    <div class="title">Language: *</div>
                        <select class="form-control" id="language" name="language" style="width: 700px;background-color: #f1f1f1;"> 
                            <option value="English">English</option>
                            <option value="Chinese">Chinese</option>
                        </select> 

                    <div class="title">Media Type: *</div>
                        <select class="form-control" id="media_type" name="media_type" style="width: 700px;background-color: #f1f1f1;"> 
                            <option value="Newspaper">Newspaper</option>
                            <option value="Online Newspaper">Online Newspaper</option>
                            <option value="Magazine">Magazine</option>
                            <option value="Online Magazine">Online Magazine</option>
                            <option value="Blog">Blog</option>
                            <option value="Trade Publication">Trade Publication</option>
                        </select> 

                    <div class="title">Industry: *</div>
                        <select class="form-control" id="industry_type" name="industry_type" style="width: 700px;background-color: #f1f1f1;"> 
                            <option value="Beauty">Beauty</option>
                            <option value="Business">Business</option>
                            <option value="Computers">Computers</option>
                            <option value="Culture and Art">Culture and Art</option>
                            <option value="Education">Education</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Enviroment">Enviroment</option>
                            <option value="Family">Family</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Financial Services">Financial Services</option>
                            <option value="Food and Beverage">Food and Beverage</option>
                            <option value="Health">Health</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Luxury">Luxury</option>
                            <option value="Music and Entertainment">Music and Entertainment</option>
                            <option value="Real Estate">Real Estate</option>
                            <option value="Sports">Sports</option>
                            <option value="Technology">Technology</option>
                            <option value="Watches and Jewellery">Watches and Jewellery</option>
                            <option value="Wine and Beer">Wine and Beer</option>
                        </select> 

                    <div class="title">Title Journalist: *</div>
                    <input type="text" id="title_journalist" name="title_journalist" class="form-control">

                    <div class="title">Website: *</div>
                    <input type="text"  id="contact_website" name="contact_website" class="form-control">

                    <div class="title">Position: *</div>
                    <input type="text"  id="position" name="position" class="form-control" style="background-color: #f1f1f1;"  placeholder="Enter the position of the media contact" required>

                    <div class="title">Description: *</div>
                    <textarea id="description" name="description"></textarea>
                    <div class="button-container">
                        <button type="submit" id="submit_button" name="submit_button">Submit</button>
                    </div>
                </form>
       
            </div>
            </div>
        </div>
    </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopup" name="viewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressadmin/pressreleases_addrecipient" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Media Contacts</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="submit" id="submit_button" class="btn btn-primary pull-right" name="submit_button">Update Contacts</button>
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_media_contacts.css">
@endsection

@section("script")
<script  src="/assets/js/media_contacts.js"></script>
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

<script>
  $('.pop_chosen_recipient_btn').click(function()
  {
      var recipient_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/pressreleases_edit_recipient/'+recipient_id,
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


@endsection

