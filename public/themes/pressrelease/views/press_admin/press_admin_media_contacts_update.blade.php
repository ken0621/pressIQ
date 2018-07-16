
    <form method="post" action="/pressadmin/pressreleases_addrecipient" enctype="multipart/form-data">
        {{csrf_field()}}

        <input type="hidden" id="name" name="action" class="form-control" value="edit">
        <input type="hidden" id="name" name="recipient_id" class="form-control" value="{{$recipient_details->recipient_id}}">

        <div class="title">Contact Name: *</div>
        <input type="text" id="name" name="name" class="form-control" value="{{$recipient_details->name}}" required><br>

        <div class="title">Company Name: *</div>
        <input type="text" id="company_name" name="company_name" class="form-control" value="{{$recipient_details->company_name}}" required><br>

        <div class="title">Email: *</div>
        <input type="email" id="contact_email" name="contact_email" class="form-control" value="{{$recipient_details->research_email_address}}" required><br>

        <div class="title">Country: *</div>
        <input type="text" id="country" name="country" class="form-control" value="{{$recipient_details->country}}" required><br>

        <div class="title">Language: *</div>
        <input type="text" id="language" name="language" class="form-control" value="{{$recipient_details->language}}" required><br>

        <div class="title">Media Type: *</div>
        <input type="text" id="media_type" name="media_type" class="form-control" value="{{$recipient_details->media_type}}"><br>

        <div class="title">Industry: *</div>
        <input type="text" id="industry_type" name="industry_type" class="form-control" value="{{$recipient_details->industry_type}}"><br>

        <div class="title">Title: *</div>
        <input type="text" id="position" name="position" class="form-control" value="{{$recipient_details->position}}"><br>

        <div class="title">Website: *</div>
        <input type="text"  id="contact_website" name="contact_website" class="form-control" value="{{$recipient_details->website}}"><br>

        {{-- <div class="title">Position: *</div> --}}
        {{-- <input type="text"  id="position" name="position" class="form-control" value="{{$recipient_details->position}}" ><br> --}}

        <div class="title">Description: *</div>
        <textarea id="description" class="form-control" name="description">{{$recipient_details->description}}</textarea><br>

