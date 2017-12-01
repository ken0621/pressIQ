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
                    <div class="press-holder-container">
                        <table>
                            <tr>
                                <th>Contact Name</th>
                                <th>Country</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th>Description</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{$contact->contact_name}}</td>
                                <td>{{$contact->country}}</td>
                                <td>{{$contact->contact_email}}</td>
                                <td>{{$contact->contact_website}}</td>
                                <td>{{$contact->contact_description}}</td>
                                <td><a href="#">Edit</a></td>
                                <td><a href="#">Delete</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <div id="add_media" class="tabcontent add-media-container">
                    <form method="post">
                        {{csrf_field()}}
                        @if(session()->has('message'))
                            <span class="member" style="color: red;">
                                 <strong>Error!</strong> {{ session('message') }}<br>
                            </span>
                        @endif
                        <div class="title">Contact Name: *</div>
                        <input type="text" name="contact_name" class="form-control">
                        <div class="title">Country: *</div>
                        <input type="text" name="country" class="form-control">
                        <div class="title">Email: *</div>
                        <input type="email" name="contact_email" class="form-control">
                        <div class="title">Website: *</div>
                        <input type="text" name="contact_website" class="form-control">
                        <div class="title">Description: *</div>
                        <textarea name="contact_description"></textarea>
                        <div class="button-container">
                            <button class="add-button" type="submit">Add Contacts</button>
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