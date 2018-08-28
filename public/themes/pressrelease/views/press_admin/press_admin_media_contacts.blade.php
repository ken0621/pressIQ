@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
          @if (Session::has('success_industry'))
            <div class="alert alert-success success_green">
              <center>{{ Session::get('success_industry') }}</center>
            </div>
          @endif

          @if (Session::has('success_industry_edit'))
            <div class="alert alert-success success_green">
                <center>{{ Session::get('success_industry_edit') }}</center>
            </div>
          @endif

          @if (Session::has('delete_industry'))
            <div class="alert alert-danger delete_media_contact">
              <center>{{ Session::get('delete_industry') }}</center>
            </div>
          @endif

          @if (Session::has('success_media_add'))
            <div class="alert alert-success success_green">
              <center>{{ Session::get('success_media_add') }}</center>
            </div>
          @endif

          @if (Session::has('success_media_edit'))
            <div class="alert alert-success success_green">
              <center>{{ Session::get('success_media_edit') }}</center>
            </div>
          @endif

          @if (Session::has('delete_media_name'))
            <div class="alert alert-danger delete_media_contact">
              <center>{{ Session::get('delete_media_name') }}</center>
            </div>
          @endif
          
        <div class="media-container">
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'press_media')" id="defaultOpen">Press IQ Media Contacts</button>
            <button class="tablinks" onclick="openCity(event, 'add_media')" >Add Media Contacts</button>
            {{-- <button class="tablinks" onclick="openCity(event, 'add_media_type')" >Add Media Type</button> --}}
            <button class="tablinks" onclick="openCity(event, 'add_industry')" >Add Industry</button>
          </div>                        
            <div class="press-release-content">
              <div id="press_media" class="tabcontent press-media-container">
                    @if (Session::has('success_merchant'))
                    <div class="alert alert-success success_green">
                       <center>{{ Session::get('success_merchant') }}</center>
                    </div>
                    @endif 

                    @if (Session::has('delete'))
                    <div class="alert alert-danger delete_media_contact">
                       <center>{{ Session::get('delete') }}</center>
                    </div>
                    @endif
                  <div class="col-md-12">
                  <div class="press-holder-container">     

                      <div class="search-container pull-right">
                          <button type="button" name="search_button" id="search_button" class="btn btn-success" style="height: 40px;">Search</button>
                          <input type="text" class="form-control" placeholder="Search"   name="search_media" id="search_media">
                      </div><br><br><br>

                      <div class="row clearfix">
                          <div class="col-md-3">
                                <select class="form-control " id="country_filter" name="country_filter" style="width: 230px;background-color: #f1f1f1;" required> 
                                  <option value="">-- All Country --</option>
                                  <option value="Hong Kong">Hong Kong</option>
                                  <option value="Philippines">Philippines</option>
                                  <option value="Singapore">Singapore</option> 
                                  <option value="China">China</option>
                                  <option value="Indonesia">Indonesia</option>
                                  <option value="Malaysia">Malaysia</option>
                                  <option value="India">India</option>
                                  <option value="Canada">Canada</option>
                                </select>
                          </div>

                          <div class="col-md-3">
                                <select class="form-control " id="industry_type_filter" name="industry_type_filter" style="width: 230px;background-color: #f1f1f1;" required> 
                                  <option value="">-- All Industry Category --</option>
                                {{--   <option value="Beauty">Beauty</option>
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
                                  <option value="Wine and Beer">Wine and Beer</option> --}}
                                  @foreach($_industry_name_add as $_industry_name)
                                    <option value="{{$_industry_name->industry_name}}">{{$_industry_name->industry_name}}</option>
                                  @endforeach 
                                </select>
                          </div>

                          <div class="col-md-3">
                                <select class="form-control" id="media_type_filter" name="media_type_filter" style="width: 230px;background-color: #f1f1f1;" required> 
                                  <option value="">-- All Media Type --</option>
                                  <option value="Newspaper">Newspaper</option>
                                  <option value="Online Newspaper">Online Newspaper</option>
                                  <option value="Magazine">Magazine</option>
                                  <option value="Online Magazine">Online Magazine</option>
                                  <option value="Blog">Blog</option>
                                  <option value="Trade Publication">Trade Publication</option>
                                  {{-- @foreach($_media_name_add as $_media_filter)
                                    <option value="{{$_media_filter->media_name}}">{{$_media_filter->media_name}}</option>
                                  @endforeach --}}
                                </select>
                          </div>

                          <div class="col-md-3">
                              <div class="button-container">
                                <button type="button" name="filter_data" id="filter_data" class="btn btn-success" style="height: 35px; width: 100%">Filter Data</button><br>
                              </div>
                          </div>
                      </div><br>
                      <div class="right-container" style="text-align: center;">
                          <div class="col-md-4">
                              <div class="button-container">
                                <button type="button" class="btn btn-success center" id="select_all" name="select_all" style="width: 150px;">
                                <i class="" name="recipient_id" aria-hidden="true"></i> Select All</button></a>  
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="button-container">
                                <button type="button" class="btn btn-success center" id="unselect_all" name="unselect_all" style="width: 150px;">
                                <i class="" name="recipient_id" aria-hidden="true"></i> Unselect All</button></a>
                              </div>
                          </div>
                          <div class="col-md-1">
                              <div class="button-container">
                                <button type="button" class="btn btn-danger center pop_delete_all_confirm" style="width: 150px;">
                                <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i> Delete All</button></a>
                              </div>
                          </div> 
                    </div><br><br>
                    <form action="" class="choose_recipient_form" method="POST" id="choose_recipient_form">
                      <div class="left-container" name="press_table" id="press_table1">
                          <table  class="table table-bordered" id="showHere_table1">
                              <tr>
                                  <th style="width: 10%;">Select</th>
                                  <th style="width: 10%;">Contact Name</th>
                                  <th style="width: 5%;">Company</th>
                                  <th style="width: 5%;">Country</th>
                                  <th style="width: 5%;">Industry Type</th>
                                  <th style="width: 5%;">Media Type</th>
                                  <th style="width: 20%;">Action</th>
                              </tr> 
                              @foreach($_media_contacts as $_media)
                              <tr>
                                 <input type="hidden" id="recipient_id" name="recipient_id[]" value="{{$_media->recipient_id}}">
                                 <td style="text-align: center;"><input type="checkbox" class="checkbox"  name="checkboxs[]" value="{{$_media->recipient_id}}" style="width: 100%"></td>
                                 <td>{{$_media->name}}</td>
                                 <td>{{$_media->company_name}}</td>
                                 <td>{{$_media->country}}</td>
                                 <td>{{$_media->industry_type}}</td>
                                 <td>{{$_media->media_type}}</td>
                                 <td>
                                   <button type="button"  class="btn btn-warning center pop_chosen_recipient_btn" data-id="{{$_media->recipient_id}}">
                                   <i class="fa fa-wrench" name="" aria-hidden="true"></i> Edit</button>
                                   
                                   <button type="button"  class="btn btn-danger center pop_delete_media_btn" data-id="{{$_media->recipient_id}}">
                                   <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i> Delete</button></a>
                                 </td>
                              </tr>
                              @endforeach
                          </table>
                     </div>
                    </form> 
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
                          <select class="form-control" id="media_type" name="media_type" style="width: 700px;background-color: #f1f1f1;"> 
                              <option value="Newspaper">Newspaper</option>
                              <option value="Online Newspaper">Online Newspaper</option>
                              <option value="Magazine">Magazine</option>
                              <option value="Online Magazine">Online Magazine</option>
                              <option value="Blog">Blog</option>
                              <option value="Trade Publication">Trade Publication</option>
                          </select>
                          {{-- <select class="form-control" id="media_type" name="media_type" style="width: 700px;background-color: #f1f1f1;" required> 
                            @foreach($_media_name_add as $_media_filter)
                              <option value="{{$_media_filter->media_name}}">{{$_media_filter->media_name}}</option>
                            @endforeach
                          </select>  --}}

                      <div class="title">Industry: *</div>
                          <select class="form-control" id="industry_type" name="industry_type" style="width: 700px;background-color: #f1f1f1;" required> 
                            @foreach($_industry_name_add as $_industry_name)
                              <option value="{{$_industry_name->industry_name}}">{{$_industry_name->industry_name}}</option>
                            @endforeach
                          </select> 

                      <div class="title">Title: *</div>
                          <select class="form-control" id="position" name="position" style="width: 700px;background-color: #f1f1f1;"> 
                              <option value="Associate Editor">Associate Editor</option>
                              <option value="Blogger">Blogger</option>
                              <option value="Editor">Editor</option>
                              <option value="Editor-in-Chief">Editor-in-Chief</option>
                              <option value="Freelance Journalist">Freelance Journalist</option>
                              <option value="Journalist">Journalist</option>
                              <option value="News Desk">News Desk</option>
                              <option value="Online News Desk">Online News Desk</option>
                              <option value="Sub-Editor">Sub-Editor</option>
                          </select> 

                      <div class="title">Website: *</div>
                      <input type="text"  id="contact_website" name="contact_website" class="form-control">

                      <div class="title">Description: *</div>
                      <textarea id="description" name="description"></textarea>
                      <div class="button-container">
                          <button type="submit" id="submit_button" name="submit_button">Submit</button>
                      </div>
                  </form>
              </div>

           {{--    <div id="add_media_type" class="tabcontent insert-media-container">
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

                                    <button type="button"  class="btn btn-danger center pop_btn_delete_media_type" data-id="{{$media->media_id}}">
                                    <i class="fa fa-trash" name="industry_id" aria-hidden="true"></i> Delete</button></a>
                                  </td>
                              </tr>
                              @endforeach
                          </table>
                      </div>
                  </div>
                </div>
              </div> --}}

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

                              <button type="button"  class="btn btn-danger center pop_btn_delete_industry" data-id="{{$industry_name->industry_id}}">
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
  <div class="modal" id="viewPopupMediaDelete" name="viewPopupMediaDelete" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/pressreleases_deleterecipient/media" enctype="multipart/form-data">
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
  <div class="modal" id="viewPopupMediaDeleteAll" name="viewPopupMediaDeleteAll" role="dialog">
    <div class="modal-dialog modal-sm" >
      <div class="modal-content">
          <div class="modal-header" style="text-align: center;">
              <h4 class="modal-title"></h4>
          </div>
          {{-- <div class="modal-body" >
          </div> --}}
          <div class="modal-footer" style="text-align: center;">
              <button class="btn btn-danger pop_delete_all">YES</button>
              <button type="button" class="btn btn-default pop_no_del" data-dismiss="modal">NO</button>
          </div>
        </div>
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

<div class="popup-view">
  <div class="modal" id="viewPopupMediaTypeDelete" name="viewPopupMediaTypeDelete" role="dialog">
    <div class="modal-dialog modal-sm">
        <form method="post" action="/pressadmin/delete_media_type_contact" enctype="multipart/form-data">
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
  <div class="modal" id="viewPopupIndustryDelete" name="viewPopupIndustryDelete" role="dialog">
    <div class="modal-dialog modal-sm">
        <form method="post" action="/pressadmin/delete_industry_contact" enctype="multipart/form-data">
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
                $('#viewPopup').find('div.modal-body').html(data); 
                // $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_delete_media_btn').click(function()
  {
      var recipient_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/pressreleases_deleterecipient/'+recipient_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupMediaDelete').modal('show');
                $('#viewPopupMediaDelete').find('div.modal-body').html(data); 
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

<script>
  $('.pop_btn_delete_media_type').click(function()
  {
      var media_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/delete_media_type/'+media_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupMediaTypeDelete').modal('show');
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
  $('.pop_btn_delete_industry').click(function()
  {
      var industry_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/delete_industry/'+industry_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupIndustryDelete').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  setTimeout(function() {
    $('.delete_media_contact').fadeOut('fast');
}, 3000); 
</script>

<script>
  setTimeout(function() {
    $('.success_green').fadeOut('fast');
}, 3000); 
</script>

@endsection

