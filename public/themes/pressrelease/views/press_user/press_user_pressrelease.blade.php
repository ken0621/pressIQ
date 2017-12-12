@extends("press_user.member")
@section("pressview")
<script  src="/assets/js/ajax_offline.js"></script>
<script  src="/assets/js/press_realease.js"></script>
<div class="background-container">
   <div class="pressview">
      <div class="dashboard-container">
         <div class="press-release-container">
            <div class="tab"  style="border-style: none;">
               <button class="tablinks" onclick="openCity(event, 'create_release')" id="defaultOpen">Create New Release</button>
               <button class="tablinks" onclick="openCity(event, 'choose_recipient')" id="">Choose Recipients</button>
               <button class="tablinks" onclick="openCity(event, 'send_release')" id="">Send Release</button>
            </div>
            <div class="press-release-content">
               <div id="create_release" class="tabcontent create-release-container">
                  <div class="title-container">New Release</div>
                  <div class="title">Headline:</div>
                  <input type="text" name="pr_headline" class="form-control">
                  <div class="title">Content:</div>
                  <textarea name="pr_content" id="tinymce"></textarea>
                  <div class="title">Boilerplate:</div>
                  <textarea name="bolier_content" id="tinymce"></textarea>
                  <div class="button-container">
                     <span class="save-button"><a href="#">Save as draft</a></span>
                     <span class="preview-button"><a href="#">Preview</a></span>
                  </div>
               </div>

               <div id="choose_recipient" class="tabcontent choose-recipient-container">
                  <div class="title-container">Choose Recipient</div>

                  <div class="title">Country:</div>
                  <select data-placeholder="--Choose a country--" multiple class="chosen-select" id="choose_country" name="choose_country">
                     @foreach($_country as $country_name)
                     <option value="{{$country_name->country}}">{{$country_name->country}}</option>
                     @endforeach
                  </select>

                  <div class="title">Industry Type:</div>
                  <select data-placeholder="--Choose a industry type--" multiple  class="chosen-select" id="industry_type" name="industry_type">
                      @foreach($_industry_type as $industry)
                      <option value="{{$industry->industry_type}}">{{$industry->industry_type}}</option>
                      @endforeach
                  </select>
                  <div class="title">Media Type:</div>
                  <select data-placeholder="--Choose a media type--" multiple class="chosen-select">
                      @foreach($_media_type as $media)
                      <option value="{{$media->media_type}}">{{$media->media_type}}</option>
                      @endforeach
                    
                  </select>
                  <div class="title">Title of Journalist:</div>
                  <select data-placeholder="--Choose a title of journalist--" multiple class="chosen-select" id="title_journalist" name="title_journalist">
                      @foreach($_title_of_journalist as $title)
                      <option value="{{$title->title_of_journalist}}">{{$title->title_of_journalist}}</option>
                      @endforeach
                  </select>

                  <div class="title">Send To:</div>
                  <input type="text" name="pr_receiver_name" multiple class="form-control" id="recipient_name" readonly>
                  <span class="choose-button" readonly>  

                  {{-- POPUP CHOOSE RECIPIENT --}}
                  <a href="javascript:" onclick="action_load_link_to_modal('/pressuser/choose_recipient', 'md');">Choose Recipient</a></span><span class="result-container">2154 results found</span>

                  {{-- POPUP CHOOSE RECIPIENT --}}
                  <input type="hidden" name="pr_to" id="recipient_email" class="form-control" readonly >
                  <div class="button-container">
                  </div>

               </div>

               <div id="send_release" class="tabcontent send-release-container">
                  <div class="title-container">New Release Summary</div>
                  <div class="title">Publisher:</div>
                  <div class="content">Digima Web Solution</div>
                  <div class="title">Title:</div>
                  <div class="content">Press Release</div>
                  <div class="button-container">
                     <div class="send-button"><a href="#">Send</a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
   .modal-content
   {
   width: 900px;
   position: fixed;
   left: 50%;
   top: 50%;
   transform: translate(-50%);
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
   .left-container
   {
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
   
   $(".chosen-select").chosen({disable_search_threshold: 10});
</script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
   tinymce.init({ 
   selector:'textarea', 
   branding: false,
   image_description: false,
   image_title: true,
   height: 500,
   plugins: ["autolink lists image charmap print preview anchor","visualblocks code","insertdatetime table contextmenu paste imagetools", "wordcount"],
   toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview',
   
   
     // we override default upload handler to simulate successful upload
     images_upload_handler: function (blobInfo, success, failure) 
     {
       var xhr, formData;
       xhr = new XMLHttpRequest();
       xhr.withCredentials = false;
       xhr.open('POST', '/pressuser/image_upload');
       xhr.onload = function() {
         var json;
   
         if (xhr.status != 200) {
           failure('HTTP Error: ' + xhr.status);
           return;
         }
         json = JSON.parse(xhr.responseText);
   
         if (!json || typeof json.location != 'string') {
           failure('Invalid JSON: ' + xhr.responseText);
           return;
         }
         success(json.location);
       };
       formData = new FormData();
   
       if( typeof(blobInfo.blob().name) !== undefined )
           fileName = blobInfo.blob().name;
       else
           fileName = blobInfo.filename();
       formData.append('file', blobInfo.blob(), fileName);
       formData.append('_token', "{{ csrf_token() }}");
   
       // formData.append('file', blobInfo.blob(), fileName(blobInfo));
       xhr.send(formData);
   
       // setTimeout(function() 
       // {
       //   // no matter what you upload, we will turn it into TinyMCE logo :)
       //   success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
       // }, 2000);
     },
   
     // init_instance_callback: function (ed) 
     // {
     //   ed.execCommand('mceImage');
     // }
   });
</script>
@endsection