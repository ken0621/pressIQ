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

              <form class="recipient_form" onsubmit="add_event_global_submit()" action="/pressuser/choose_recipient" method="POST" style="">
                {{csrf_field()}}
                @if(session()->has("pr_edit"))
                @foreach($edit as $edits)
                <div id="create_release" class="tabcontent create-release-container">
                  <div class="title-container">New Release</div>
                  <div class="title">Headline:</div>
                  <input type="text" id="pr_headline" name="pr_headline" class="form-control" autofocus value="{{$edits->pr_headline}}">
                  <div class="title">Content:</div>
                  <textarea name="pr_content" id="pr_content">{!!$edits->pr_content!!}</textarea>
                  <div class="title">Boilerplate:</div>
                  <textarea name="pr_boiler_content" id="pr_boiler_content">{!!$edits->pr_boiler_content!!}</textarea>
                  <div class="button-container">
                  <span class="save-button"><button type="submit" name="draft" value="draft" formaction="/pressuser/pressrelease/draft"><a>Save as draft</a></button></span>
                  <span class="preview-button"><button onclick="preview()">Preview</button></span>
                  </div>
                </div>

                <div id="choose_recipient" class="tabcontent choose-recipient-container">
                    <div class="title-container">Choose Recipient</div>

                    <div class="title">Country:</div>
                    <select data-placeholder="--Choose a country--" multiple class="chosen-select" id="choose_country" name="choose_country[]">
                         @foreach($_country as $country_name)
                         <option value="{{$country_name->country}}">{{$country_name->country}}</option>
                         @endforeach
                    </select>

                    <div class="title">Industry Type:</div>
                    <select data-placeholder="--Choose a industry type--" multiple  class="chosen-select" id="industry_type" name="industry_type[]">
                          @foreach($_industry_type as $industry)
                        <option value="{{$industry->industry_type}}">{{$industry->industry_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Media Type:</div>
                    <select data-placeholder="--Choose a media type--" multiple class="chosen-select" id="media_type" name="media_type[]">
                          @foreach($_media_type as $media)
                        <option value="{{$media->media_type}}">{{$media->media_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Title of Journalist:</div>
                    <select data-placeholder="--Choose a title of journalist--" multiple class="chosen-select" id="title_of_journalist" name="title_of_journalist[]">
                          @foreach($_title_of_journalist as $title)
                        <option value="{{$title->title_of_journalist}}">{{$title->title_of_journalist}}</option>
                          @endforeach
                    </select>

                    <div class="title">Send To:</div>
                    <input type="hidden"  id="recipient_name" name="pr_receiver_name"  class="form-control" value="{{$edits->pr_receiver_name}}" multiple readonly>
                    
                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <span class="choose-button" readon><a href="javascript:" class="pop_recipient_btn">Choose Recipient</a></span><span class="result-container">2154 results found</span>
                      {{-- POPUP CHOOSE RECIPIENT --}}

                    <input type="hidden" name="pr_to" id="recipient_email" class="form-control" value="{{$edits->pr_to}}" readonly >
                    <div class="button-container"></div>
                </div>
                @endforeach

                @else
                <div id="create_release" class="tabcontent create-release-container">
                  <div class="title-container">New Release</div>
                  <div class="title">Headline:</div>
                  <input type="text" name="pr_headline" class="form-control" id="pr_headline"  onclick="showMessage()" autofocus>
                  <div class="title">Content:</div>
                  <textarea name="pr_content" id="pr_content"></textarea>
                  <div class="title">Boilerplate:</div>
                  <textarea name="pr_boiler_content" id="pr_boiler_content"></textarea>
                  <div class="button-container">
                  <span class="save-button"><button type="submit" name="draft" value="draft" formaction="/pressuser/pressrelease/draft">Save as draft</button></span>
                  <span class="preview-button"><button type="button" onclick="preview()">Preview</button></span>
                  </div>
                </div>

                <div id="choose_recipient" class="tabcontent choose-recipient-container">
                    <div class="title-container">Choose Recipient</div>

                    <div class="title">Country:</div>
                    <select data-placeholder="--Choose a country--" multiple class="chosen-select" id="choose_country" name="choose_country[]">
                         @foreach($_country as $country_name)
                         <option value="{{$country_name->country}}">{{$country_name->country}}</option>
                         @endforeach
                    </select>

                    <div class="title">Industry Type:</div>
                    <select data-placeholder="--Choose a industry type--" multiple  class="chosen-select" id="industry_type" name="industry_type[]">
                          @foreach($_industry_type as $industry)
                        <option value="{{$industry->industry_type}}">{{$industry->industry_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Media Type:</div>
                    <select data-placeholder="--Choose a media type--" multiple class="chosen-select" id="media_type" name="media_type[]">
                          @foreach($_media_type as $media)
                        <option value="{{$media->media_type}}">{{$media->media_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Title of Journalist:</div>
                    <select data-placeholder="--Choose a title of journalist--" multiple class="chosen-select" id="title_of_journalist" name="title_of_journalist[]">
                          @foreach($_title_of_journalist as $title)
                        <option value="{{$title->title_of_journalist}}">{{$title->title_of_journalist}}</option>
                          @endforeach
                    </select>

                    <div class="title">Send To:</div>
                    <input type="hidden"  id="recipient_name" name="pr_receiver_name"  class="form-control" multiple readonly>
                    
                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <span class="choose-button"><a href="javascript:" class="pop_recipient_btn">Choose Recipient</a></span>
                    <span class="result-container" style="font-size:15px"><span id="results_number" style="font-size:15px"></span></span>

                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <input type="hidden" name="pr_to" id="recipient_email" class="form-control" readonly >
                    <div class="button-container"></div>
                </div>
                @endif

                <div id="send_release" class="tabcontent send-release-container">
                  <div class="title-container">Send Release</div>
                  <div class="title">Publisher:</div>
                  <div class="content">{{session('user_first_name')}} {{session('user_last_name')}}</div>
                  <div class="title">Title:</div>
                  <div class="content" id = "display_message"></div>
                  <div class="title">Send To:</div>
                  <span class="result-container" style="font-size:15px"><span id="results_number_sendto" style="font-size:15px"></span></span>


                  <div class="button-container">
                    <button type="submit" formaction="/pressuser/pressrelease/pr">Send</button>
                  </div>

                </div>
              </form>
            </div>
         </div>
      </div>
   </div>
</div>

  <!-- Preview Popup -->
  <div class="modal fade" id="previewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body" id="preview_content">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<script src="/email_assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/email_assets/tinymce/js/tinymce/tinymce.js"></script>
<script src="/email_assets/tinymce/js/tinymce/jquery.tinymce.min.js"></script>

<script>
tinymce.init({ 
selector:'textarea', 
branding: false,
image_description: false,
image_title: true,
height: 500,
plugins: ["autolink lists image charmap print preview anchor","visualblocks code","insertdatetime table contextmenu paste imagetools", "wordcount"],
toolbar: 'undo redo | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview',
   
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
       //   // no matter what you upload, we will turn it into TinyMCE logo (smiley)
       //   success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
       // }, 2000);
     },
   
     // init_instance_callback: function (ed) 
     // {
     //   ed.execCommand('mceImage');
     // }
   });
</script>

<script type="text/JavaScript">
    function showMessage(){
        var pr_headline = document.getElementById("pr_headline").value;
        display_message.innerHTML= pr_headline;
    }
</script>

<script type="text/javascript">
  $('.pop_recipient_btn').click(function()
  {
    var data = $('.recipient_form').serialize();
    action_load_link_to_modal('/pressuser/choose_recipient?'+data, 'md');
});
  function preview()
  {
    var headline = document.getElementById('pr_headline').value;
    var content = tinymce.get('pr_content').getContent();
    var boiler_content = tinymce.get('pr_boiler_content').getContent();
    document.getElementById('preview_content').innerHTML =headline+ "<br>" + content + "<br>About the Publisher" + boiler_content;
    $('#previewPopup').modal('show'); 
  }
</script>
@endsection