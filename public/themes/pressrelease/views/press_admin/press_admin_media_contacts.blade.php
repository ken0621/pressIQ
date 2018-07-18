@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
          @if (Session::has('success_industry'))
            <div class="alert alert-success">
              <center>{{ Session::get('success_industry') }}</center>
            </div>
          @endif

          @if (Session::has('success_industry_edit'))
            <div class="alert alert-success">
                <center>{{ Session::get('success_industry_edit') }}</center>
            </div>
          @endif

          @if (Session::has('delete_industry'))
            <div class="alert alert-danger">
              <center>{{ Session::get('delete_industry') }}</center>
            </div>
          @endif

          @if (Session::has('success_media_add'))
            <div class="alert alert-success">
              <center>{{ Session::get('success_media_add') }}</center>
            </div>
          @endif

          @if (Session::has('success_media_edit'))
            <div class="alert alert-success">
              <center>{{ Session::get('success_media_edit') }}</center>
            </div>
          @endif

          @if (Session::has('delete_media_name'))
            <div class="alert alert-danger">
              <center>{{ Session::get('delete_media_name') }}</center>
            </div>
          @endif
          
        <div class="media-container">
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'press_media')" id="defaultOpen">Press IQ Media Contacts</button>
            <button class="tablinks" onclick="openCity(event, 'add_media')" >Add Media Contacts</button>
            <button class="tablinks" onclick="openCity(event, 'add_media_type')" >Add Media Type</button>
            <button class="tablinks" onclick="openCity(event, 'add_industry')" >Add Industry</button>
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
                                   <i class="fa fa-wrench" name="" aria-hidden="true"></i> Edit</button>
                                   
                                   <a onclick="return confirm('Are you sure you want to Delete?');" href="/pressadmin/pressreleases_deleterecipient/{{$_media->recipient_id}}"><button type="button"  class="btn btn-danger center">
                                   <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i> Delete</button></a>
                                 </td>
                              </tr>
                              @endforeach
                          </table>
                     </div>
                   </div>    
                  </div>
              </div>

              <div id="add_media" class="tabcontent add-media-container">
                <div class="title-container">Insert Media Contacts</div> 
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
                          <select class="form-control" id="media_type" name="media_type" style="width: 700px;background-color: #f1f1f1;" required> 
                            @foreach($_media_name_add as $_media_filter)
                              <option value="{{$_media_filter->media_name}}">{{$_media_filter->media_name}}</option>
                            @endforeach
                          </select> 

                      <div class="title">Industry: *</div>
                          <select class="form-control" id="industry_type" name="industry_type" style="width: 700px;background-color: #f1f1f1;" required> 
                            @foreach($_industry_name_add as $_industry_name)
                              <option value="{{$_industry_name->industry_name}}">{{$_industry_name->industry_name}}</option>
                            @endforeach
                          </select> 

                      <div class="title">Title: *</div>
                      <input type="text" id="position" name="position" class="form-control" style="background-color: #f1f1f1;"  placeholder="Enter the title of the media contact" required>

                      <div class="title">Website: *</div>
                      <input type="text"  id="contact_website" name="contact_website" class="form-control">

                      {{-- <div class="title">Position: *</div> --}}
                      {{-- <input type="text"  id="position" name="position" class="form-control" style="background-color: #f1f1f1;"  placeholder="Enter the position of the media contact" required> --}}

                      <div class="title">Description: *</div>
                      <textarea id="description" name="description"></textarea>
                      <div class="button-container">
                          <button type="submit" id="submit_button" name="submit_button">Submit</button>
                      </div>
                  </form>
              </div>

              <div id="add_media_type" class="tabcontent insert-media-container">
                <div class="col-md-12">
                  <div class="press-holder-container"> 
                    <div class="title-container">Insert Media Type</div><br>
                      <form method="post" action="/pressadmin/add_media_type">
                        {{csrf_field()}}
                          <input type="text" id="media_name" name="media_name" class="form-control" style="background-color: #f1f1f1;width: 450px" placeholder="Enter the name of the media" required><br>
                          <div class="button-container">
                              <button type="submit" id="submit_button" name="submit_button">Submit</button>
                          </div><br>
                      </form> 
                       <div class="left-container" name="press_table" id="press_table1">
                          <table  class="table table-bordered" id="showHere_table1">
                              <tr>
                                <th style="width: 30%;">Media Name</th>
                                <th style="width: 30%;">Action</th>
                              </tr>
                              @foreach($_media_name as $media)
                              <tr>
                                <td>{{$media->media_name}}</td>
                                  <td>
                                    <button type="button"  class="btn btn-warning center pop_media_type_btn" data-id="{{$media->media_id}}">
                                    <i class="fa fa-wrench" name="" aria-hidden="true"></i> Edit</button> 

                                    <a onclick="return confirm('Are you sure you want to Delete?');" href="/pressadmin/delete_media_type/{{$media->media_id}}"><button type="button"  class="btn btn-danger center">
                                    <i class="fa fa-trash" name="industry_id" aria-hidden="true"></i> Delete</button></a>
                                  </td>
                              </tr>
                              @endforeach
                          </table>
                      </div>
                  </div>
                </div>
              </div>

              <div id="add_industry" class="tabcontent insert-media-container">
                <div class="col-md-12">
                  <div class="press-holder-container"> 
                    <div class="title-container">Insert Industry</div><br>
                      <form method="post" action="/pressadmin/add_industry">
                        {{csrf_field()}}
                          <input type="text" id="industry_name" name="industry_name" class="form-control" style="background-color: #f1f1f1;width: 450px" placeholder="Enter the name of the industry" required><br>
                          <div class="button-container">
                              <button type="submit" id="submit_button" name="submit_button">Submit</button>
                          </div><br>
                      </form> 
                       <div class="left-container" name="press_table" id="press_table1">
                        <table  class="table table-bordered" id="showHere_table1">
                          <tr>
                            <th style="width: 30%;">Industry Name</th>
                            <th style="width: 30%;">Action</th>
                          </tr>
                        @foreach($_industry as $industry_name)
                          <tr>
                            <td>{{$industry_name->industry_name}}</td>
                              <td>
                              <button type="button"  class="btn btn-warning center pop_industry_btn" data-id="{{$industry_name->industry_id}}">
                              <i class="fa fa-wrench" name="" aria-hidden="true"></i> Edit</button> 

                              <a onclick="return confirm('Are you sure you want to Delete?');" href="/pressadmin/delete_industry/{{$industry_name->industry_id}}"><button type="button"  class="btn btn-danger center">
                              <i class="fa fa-trash" name="industry_id" aria-hidden="true"></i> Delete</button></a>
                            </td>
                          </tr>
                        @endforeach
                        </table>
                      </div>
                  </div>
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

<div class="popup-view">
  <div class="modal" id="viewPopupIndustry" name="viewPopupIndustry" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressadmin/add_industry" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Industry</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="submit" id="submit_industry" class="btn btn-primary pull-right" name="submit_industry">Update Industry</button>
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupMedia" name="viewPopupMedia" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressadmin/add_media_type" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Media Type</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <button type="submit" id="submit_media" class="btn btn-primary pull-right" name="submit_media">Update Media Type</button>
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

<script>
  $('.pop_industry_btn').click(function()
  {
      var industry_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/edit_industry/'+industry_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupIndustry').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_media_type_btn').click(function()
  {
      var media_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/edit_media_type/'+media_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupMedia').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>


@endsection

