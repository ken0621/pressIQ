@extends("press_admin.admin")
@section("pressview")
<style >
.table 
{
   width: 100%;
   display:block;
   height: 500px;
   overflow-y: scroll;
   text-align: center;
}
</style>
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
                  <div class="left-container" id="press_table" name="press_table">
                    <table  class="table table-bordered" style="background-color: #FFFFFF;" id="showHere_table">
                        <tr>
                            <th style="text-align: center;">Contact Name</th>
                            <th style="text-align: center;">Country</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                        @foreach($_media_contacts as $contact)
                        <tr>
                            <td style="text-align: center;">{{$contact->name}}</td>
                            <td style="text-align: center;">{{$contact->country}}</td>
                            <td style="text-align: center;">
                               

                                <a href="/pressadmin/pressreleases_deleterecipient/{{$contact->recipient_id }}"><button type="button"  class="btn btn-danger center">
                                <i class="fa fa-trash" name="" aria-hidden="true"></i>Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                  </div>
                </div>
            </div>

            <div id="add_media" class="tabcontent add-media-container">
                
                <form method="post" action="/pressadmin/pressreleases_addrecipient">
                    {{csrf_field()}}
                    <div class="title">Contact Name: *</div>
                    <input type="text" id="contact_name" name="contact_name" class="form-control" required>

                    <div class="title">Position: *</div>
                    <input type="text"  id="position" name="position" class="form-control" required>

                    <div class="title">Company Name: *</div>
                    <input type="text" id="company_name" name="company_name" class="form-control" required>


                    <div class="title">Country: *</div>
                    <input type="text" id="country" name="country" class="form-control" required>

                    <div class="title">Email: *</div>
                    <input type="email" id="contact_email" name="contact_email" class="form-control" required>

                    <div class="title">Website: *</div>
                    <input type="text"  id="contact_website" name="contact_website" class="form-control" required>

                    <div class="title">Media Type: *</div>
                    <input type="text" id="media_type" name="media_type" class="form-control" required>

                    <div class="title">Industry Type: *</div>
                    <input type="text" id="industry_type" name="industry_type" class="form-control" required>

                    <div class="title">Title Journalist: *</div>
                    <input type="text" id="title_journalist" name="title_journalist" class="form-control" required>


                    <div class="title">Description: *</div>
                    <textarea id="description" name="description"></textarea>
                    <div class="button-container">
                        <button type="submit" id="submit_button" name="submit_button">Add Contacts</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_media_contacts.css">
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