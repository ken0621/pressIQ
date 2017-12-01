@extends("press_admin.admin")
@section("pressview")

<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
        <div class="media-container">
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'press_media')" id="defaultOpen">Press IQ Media Contacts</button>
            <button class="tablinks" onclick="openCity(event, 'add_media')">Add Media Contacts</button>
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
                            <tr>
                                <td>Contact 1</td>
                                <td>UK</td>
                                <td>contact1@mail.com</td>
                                <td>contact1.uk</td>
                                <td>food media</td>
                                <td><a href="#">Edit</a></td>
                                <td><a href="#">Delete</a></td>
                            </tr>
                            <tr>
                                <td>Contact 2</td>
                                <td>Philippines</td>
                                <td>contact2@mail.com</td>
                                <td>contact2.uk</td>
                                <td>tech media</td>
                                <td><a href="#">Edit</a></td>
                                <td><a href="#">Delete</a></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div id="add_media" class="tabcontent add-media-container">
                    <div class="title">Contact Name: </div>
                    <input type="text" class="form-control">
                    <div class="title">Country: </div>
                    <input type="text" class="form-control">
                    <div class="title">Email: </div>
                    <input type="text" class="form-control">
                    <div class="title">Website: </div>
                    <input type="text" class="form-control">
                    <div class="title">Description: </div>
                    <textarea></textarea>
                    <div class="button-container">
                        <span class="add-button"><a href="#">Add Contacts</a></span>
                    </div>
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