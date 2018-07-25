@extends("press_user.member")
@section("pressview")
<script  src="/assets/js/ajax_offline.js"></script>
<script  src="/assets/js/press_realease.js"></script>
<div class="background-container">
   <div class="pressview">
      <div class="dashboard-container">
          @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
          @endif
         <div class="press-release-container">
            <div class="tab"  style="border-style: none;">
               <button class="tablinks" onclick="openCity(event, 'create_release')" id="defaultOpen">Create New Release</button>
               <button class="tablinks" onclick="openCity(event, 'create_release')" id="defaultOpen">Choose Recipients</button>
               <button class="tablinks" onclick="openCity(event, 'create_release')" id="defaultOpen">Send Release</button>
            </div>
           
            <div class="press-release-content">
              <form class="recipient_form" onsubmit="add_event_global_submit()" action="/pressuser/choose_recipient" method="POST" style="">
                {{csrf_field()}}
        
                <div id="create_release" class="tabcontent create-release-container">

                  <div class="title-container">New Release</div>
                    @if(session()->has("pr_edit"))
                      @foreach($edit as $edits)
                  <div class="title">Type:</div>
                   <select name="pr_type" id="pr_type" class="form-control" style="width: 80% !important;">
                     <option>--Select option--</option>
                     @if($edits->pr_type=="Media Release")
                     <option selected value="Media Release">Media Release</option>
                     <option value="Press Release">Press Release</option>
                     <option value="Invitation">Invitation</option>
                     @elseif($edits->pr_type=="Press Release")
                     <option value="Media Release">Media Release</option>
                     <option selected value="Press Release">Press Release</option>
                     <option value="Invitation">Invitation</option>
                     @elseif($edits->pr_type=="Invitation")
                     <option value="Media Release">Media Release</option>
                     <option value="Press Release">Press Release</option>
                     <option selected value="Invitation">Invitation</option>
                     @else
                     <option value="Media Release">Media Release</option>
                     <option value="Press Release">Press Release</option>
                     <option value="Invitation">Invitation</option>
                     @endif
                   </select> 
                  <div class="title">Title:</div>
                        <input type="text" id="pr_headline" name="pr_headline" class="form-control" value="{{$edits->pr_headline}}" autofocus>
                  <div class="title">Release Text Body:</div>
                        <textarea name="pr_content" id="pr_content">{!!$edits->pr_content!!}</textarea>
                  <div class="title">Boilerplate:</div>
                        <textarea name="pr_boiler_content" id="pr_boiler_content">{!!$edits->pr_boiler_content!!}</textarea><br>
                  <div class="button-container">
                    <span class="button"><button type="submit" name="draft" value="draft" formaction="/pressuser/pressrelease/draft"><a>Save as draft</a></button></span>
                    <span class="preview-button"><a href="#" id="prev_btn">Preview</a></span>
                    <span class="button"><button type="button" id="btnNext" class="tablinks" onclick="openCity(event, 'choose_recipient')"><a>Continue &raquo;</a></button></span>
                  </div>
                </div>

                <div id="choose_recipient" class="tabcontent choose-recipient-container">
                    <div class="title-container">Choose Recipient</div>

                    <div class="title">Country:</div>
                    <select data-placeholder="--Choose a country--" multiple class="chosen-select" id="choose_country" name="choose_country[]">
                         @foreach($country as $key => $value)
                         <option value="{{$value}}">{{ $value }}</option>
                         @endforeach
                    </select>
                    
                    <div class="title">Language:</div>
                    <select data-placeholder="--Choose a Language--" multiple class="chosen-select pop_language" id="language" name="language[]">
                        @foreach($_language as $language)
                        <option value="{{$language->language}}">{{$language->language}}</option>
                        @endforeach
                    </select>
                    
                    <div class="title">Industry Type:</div>
                    <select data-placeholder="--Choose a industry type--" multiple  class="chosen-select pop_industry" id="industry_type" name="industry_type[]">
                          @foreach($_industry_type as $industry)
                        <option value="{{$industry->industry_type}}">{{$industry->industry_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Media Type:</div>
                    <select data-placeholder="--Choose a media type--" multiple class="chosen-select pop_media" id="media_type" name="media_type[]">
                          @foreach($_media_type as $media)
                        <option value="{{$media->media_type}}">{{$media->media_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Title of Journalist:</div>
                    <select data-placeholder="--Choose a title of journalist--" multiple class="chosen-select pop_title" id="position" name="position[]">
                          @foreach($_position as $position)
                        <option value="{{$position->position}}">{{$position->position}}</option>
                          @endforeach
                    </select>

                    <div class="title">Send To:
                    <span class="result-container" style="font-size:15px"><span id="results_number" style="font-size:15px"></span></span>
                    </div>
                     
                    <input type="hidden" class="hidden_number" id="hidden_number" name="hidden_number" readonly>
                    <input type="hidden"  id="recipient_name" name="recipient_name"  class="form-control" value="{{$edits->pr_receiver_name}}" multiple readonly>
                    <input type="hidden"  id="recipient_name_only" name="recipient_name_only" class="form-control"  multiple readonly>
                    <input type="hidden" id="recipient_id" name="recipient_id"  class="form-control" multiple readonly> 
                    
                    <span class="button"><button class="tablinks" type="button" onclick="openCity(event, 'create_release')" id="defaultOpen"><a>&laquo; Back to Release</a></button></span>
                    
                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <span class="choose-button" readon><a href="javascript:" id="pop_recipient_btn">Choose Recipient</a></span>

                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <span class="button"><button type="button" id="btnNext" class="tablinks" onclick="openCity(event, 'send_release')"><a>Continue &raquo;</a></button></span>
                    <input type="hidden" name="pr_to" id="recipient_email" class="form-control" value="{{$edits->pr_to}}" readonly >
                    @endforeach
                      @else
                  <div class="title">Type:</div>
                   <select name="pr_type" id="pr_type" class="form-control" style="width: 80% !important;">
                     <option value="">--Select option--</option>
                     <option value="Media Release">Media Release</option>
                     <option value="Press Release">Press Release</option>
                     <option value="Invitation">Invitation</option>
                   </select> 
                  <div class="title">Title:</div>
                        <input type="text" id="pr_headline" name="pr_headline" class="form-control" autofocus>
                  <div class="title">Release Text Body:</div>
                        <textarea name="pr_content" id="pr_content"></textarea>
                  <div class="title">Boilerplate:</div>
                        <textarea name="pr_boiler_content" id="pr_boiler_content"></textarea><br>
                  <div class="button-container">
                    <span class="button"><button type="submit" name="draft" value="draft" formaction="/pressuser/pressrelease/draft"><a>Save as draft</a></button></span>
                    <span class="preview-button"><a href="#" id="prev_btn">Preview</a></span>

                    <span class="button"><button type="button" id="btnnextCreate" class="tablinks pop_please_fill"><a>Continue &raquo;</a></button></span>
                  </div>
                </div>

                <div id="choose_recipient" class="tabcontent choose-recipient-container">

                    <div class="title-container">Choose Recipient</div>
                    <div class="title">Country:</div>
                    <select data-placeholder="--Choose a country--" multiple class="chosen-select" id="choose_country" name="choose_country[]">
                         @foreach($country as $key => $value)
                         <option value="{{$value}}">{{ $value }}</option>
                         @endforeach
                    </select>

                    <div class="title">Language:</div>
                    <select data-placeholder="--Choose a Language--" multiple class="chosen-select pop_language" id="language" name="language[]">
                        @foreach($_language as $language)
                        <option value="{{$language->language}}">{{$language->language}}</option>
                        @endforeach
                    </select>

                    <div class="title">Industry Type:</div>
                    <select data-placeholder="--Choose a industry type--" multiple  class="chosen-select pop_industry" id="industry_type" name="industry_type[]" >
                          @foreach($_industry_type as $industry)
                        <option value="{{$industry->industry_type}}">{{$industry->industry_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Media Type:</div>
                    <select data-placeholder="--Choose a media type--" multiple class="chosen-select pop_media" id="media_type" name="media_type[]">
                          @foreach($_media_type as $media)
                        <option value="{{$media->media_type}}">{{$media->media_type}}</option>
                          @endforeach
                    </select>

                    <div class="title">Title:</div>
                    <select data-placeholder="--Choose a title of journalist--" multiple class="chosen-select pop_title" id="position" name="position[]">
                          @foreach($_position as $position)
                        <option value="{{$position->position}}">{{$position->position}}</option>
                          @endforeach
                    </select>

                    <div class="title">Send To:
                    <span class="result-container" style="font-size:15px"><span id="results_number" name="results_number" style="font-size:15px"></span></span>
                    </div>
                    <input type="hidden" id="hidden_number" name="hidden_number" class="hidden_number" readonly>
                    <input type="hidden" id="recipient_name" name="recipient_name"  class="form-control" multiple readonly> 
                    <input type="hidden" id="recipient_name_only" name="recipient_name_only"  class="form-control" multiple readonly> 
                    <input type="hidden" id="recipient_email" name="pr_to"  class="form-control" readonly>
                    <input type="hidden" id="recipient_id" name="recipient_id"  class="form-control" multiple readonly> 

                    <span class="button"><button class="tablinks" type="button" onclick="openCity(event, 'create_release')" id="defaultOpen"><a>&laquo; Back to Release</a></button></span>
                    
                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <span class="choose-button" readon><a href="javascript:" id="pop_recipient_btn">Choose Recipient</a></span>
                    {{-- POPUP CHOOSE RECIPIENT --}}
                    <span class="button"><button type="button" id="btnnextSend" class="tablinks pop_up_next"><a>Continue &raquo;</a></button></span>
                      @endif
                    <div class="button-container"></div>
                </div>

                <div id="send_release" class="tabcontent send-release-container">
                  <img class="pull-right" src="https://media.giphy.com/media/y1ZBcOGOOtlpC/200.gif" id="img_load" style="display:none;"/>
                  <div class="title-container">Send Release</div>
                  <div class="title">Publisher:</div>
                  <div class="content">{{session('user_first_name')}} {{session('user_last_name')}}</div>
                  <div class="title">Company:</div>
                  <div class="content">{{session('user_company_name')}}</div>
                  <div class="title">Title:</div>
                  <div class="content" id="headline_pr"></div>
                  <div class="title">Send To:</div>
                  <span class="result-container" style="font-size:15px"><span id="results_number_sendto" style="font-size:15px"></span></span>
                  <a href="javascript:" id="pop_chosen_recipient_btn">  VIEW</a>

                  <div class="button-container">
                    <button class="tablinks" type="button" onclick="openCity(event, 'choose_recipient')" id="defaultOpen">&laquo; Back</button>
                    <button class="preview-button" type="button"  id="prev_btn_send">Preview</button>
                    <button type="submit" id="button_load" formaction="/pressuser/pressrelease/pr">Send &raquo;</button>
                  </div>
                </div>
              </form>
            </div>
         </div>
      </div>
   </div>
</div>
  <!-- Preview Popup -->
<div class="popup-preview">
  <div class="modal" id="previewPopup" name="previewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preview</h4>
        </div>
           
        <div class="modal-body">
          <div class="row-no-padding clearfix">
            <div class="col-md-9">
              <div id="preview_headline"></div>
            </div>
            <div class="col-md-3">
              <div class="logo-holder">
                <img src="{{session('user_company_image')}}">
              </div>
            </div>
          </div>
          <div id="preview_content"></div>
          <div class="about-title">
            <div>About {{session('user_company_name')}}
              <input type="datetime"  value="<?php echo date("Y-m-d\ H:i:s",time()); ?>"/ style="border: none;" readonly></div>
              <div id="preview_type"></div>
          </div>
          <div id="preview_boiler_content"></div>
            <div>
              &nbsp;<span> <a href="https://twitter.com/Press_IQ?lang=en" class="twitter-share-button" data-url="" data-size="small">Tweet</a></span> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
              <iframe src="https://www.facebook.com/plugins/like.php?href=https://www.facebook.com/Press-IQ-153736705433100&width=74&layout=button_count&action=like&size=small&show_faces=false&share=false&height=21&appId" width="61" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
              <script src="//platform.linkedin.com/in.js" type="text/javascript" >lang: en_US</script>
              <script type="IN/Share" data-url="https://www.linkedin.com/company/press-iq"></script>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopup" name="viewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Chosen Recipients</h4>
          </div>
          <div class="table_recipient">
          </div>  
      </div>
    </div>
  </div>
</div>


<div class="popup-view">
  <div class="modal fade" id="viewPopupPleaseFill" name="viewPopupPleaseFill" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="height: 150px">
          <div class="modal-header" style="background-color:#C91F37;">
            <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            <h4 class="modal-title" style="color:white;">Warning!</h4>
          </div>
          <div class="modal-body" style="overflow-y: auto; text-align: center;">
            <label style="color:red;font-size: 20px;text-align: center;">Please fill the required fields!</label>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal fade" id="viewPopupNext" name="viewPopupNext" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="height: 150px">
          <div class="modal-header" style="background-color:#C91F37;">
            <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            <h4 class="modal-title" style="color:white;">Warning!</h4>
          </div>
          <div class="modal-body" style="overflow-y: auto; text-align: center;">
            <label style="color:red;font-size: 20px;">Choose Recipient First!</label>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal fade" id="viewPopupCountryFirst" name="viewPopupCountryFirst" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="height: 150px">
          <div class="modal-header" style="background-color:#C91F37;">
            <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            <h4 class="modal-title" style="color:white;">Warning!</h4>
          </div>
          <div class="modal-body" style="overflow-y: auto; text-align: center;">
            <label style="color:red;font-size: 20px;">Please Choose Country First!</label>
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
   
   document.getElementById("defaultOpen").click();
   
   $(".chosen-select").chosen({disable_search_threshold: 10});
   
</script> 
       
<script src="/email_assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/email_assets/tinymce/js/tinymce/tinymce.js"></script>
<script src="/email_assets/tinymce/js/tinymce/jquery.tinymce.min.js"></script>

<script>
  $('#pop_chosen_recipient_btn').click(function()
  {
    $('#viewPopup').modal('show');

      var id_recipients;
      $('#recipient_id').each(function()
      {
        id_recipients = $(this).text();
      });
      $.ajax({
        url: '/pressuser/choose_recipient_view',
        type: 'GET',
        data: {'id': id_recipients},
        success: function (data)
        {
            $('.table_recipient').html(data);
        }
      });
  });
</script>

<script> 
   $('.pop_language').change(function() 
   {
     if(choose_country.value =="")
        {
          $('#viewPopupCountryFirst').modal('show');
          $('#language').attr('disabled', 'disabled');
        }
    else
        {
          $('#language').attr('disabled', false)
        }
   });

   $('.pop_industry').change(function() 
   {
     if(choose_country.value =="")
        {
          $('#viewPopupCountryFirst').modal('show');
          $('#industry_type').attr('disabled', 'disabled');
        }
    else
        {
          $('#industry_type').attr('disabled', false)
        }
   });

   $('.pop_media').change(function() 
   {
     if(choose_country.value =="")
        {
          $('#viewPopupCountryFirst').modal('show');
          $('#media_type').attr('disabled', 'disabled');
        }
    else
        {
           $('#media_type').attr('disabled', false);
        }
   });

   $('.pop_title').change(function() 
   {
     if(choose_country.value =="")
        {
          $('#viewPopupCountryFirst').modal('show');
          $('#position').attr('disabled', 'disabled');
        }
    else
        {
           $('#position').attr('disabled', false);
        }
   });

  $('#button_load').click(function()
  {
    $('#img_load').show(); 
     $.ajax({})
  });

  $('#prev_btn').click(function()
  {
    var headline = document.getElementById('pr_headline').value;
    var type = document.getElementById('pr_type').value;
    var content = tinymce.get('pr_content').getContent();
    var boiler_content = tinymce.get('pr_boiler_content').getContent();
    document.getElementById('preview_headline').innerHTML =headline;
    document.getElementById('preview_content').innerHTML =content;
    document.getElementById('preview_type').innerHTML =type;
    document.getElementById('preview_boiler_content').innerHTML =boiler_content;
    $('#previewPopup').modal('show'); 
  });

  // $('#btnnextCreate').click(function()
  // {
  //  if(pr_type.value !="" && pr_headline.value !="" && tinymce.get('pr_content').getContent() != "" && tinymce.get('pr_boiler_content').getContent() != "")
  //       {
  //         openCity(event, 'choose_recipient');     
  //       }

  //   else
  //       {
  //         alert('Please fill the required fields!'); 
  //       }
  // });

  // $('#btnnextSend').click(function()
  // {
  //   if(recipient_email.value!="")
  //       {
  //         openCity(event, 'send_release');    
  //       }

  //   else
  //       {
  //         alert('Choose Recipient First!'); 
  //       }
  // });

  $('.pop_please_fill').click(function()
  {
   if(pr_type.value !="" && pr_headline.value !="" && tinymce.get('pr_content').getContent() != "" && tinymce.get('pr_boiler_content').getContent() != "")
        {
          openCity(event, 'choose_recipient');     
        }

    else
        {
          $('#viewPopupPleaseFill').modal('show');
        }
  });

  $('.pop_up_next').click(function()
  {
    if(recipient_email.value!="")
        {
          openCity(event, 'send_release');    
        }

    else
        {
           $('#viewPopupNext').modal('show');
        }
  });

  $('#prev_btn_send').click(function()
  {
    var headline = document.getElementById('pr_headline').value;
    var type = document.getElementById('pr_type').value;
    var content = tinymce.get('pr_content').getContent();
    var boiler_content = tinymce.get('pr_boiler_content').getContent();
    document.getElementById('preview_headline').innerHTML =headline;
    document.getElementById('preview_content').innerHTML =content;
    document.getElementById('preview_type').innerHTML =type;
    document.getElementById('preview_boiler_content').innerHTML =boiler_content;
    $('#previewPopup').modal('show'); 
  });
</script>

<script>
tinymce.init({ 
selector:'textarea', 
branding: false,
image_description: false,
image_title: true,
height: 500,
default_link_target: "_blank",
media_live_embeds: true,
plugins: ["autolink lists image charmap print preview anchor","visualblocks code","insertdatetime table contextmenu paste imagetools", "wordcount", "media", "link"],
toolbar: 'undo redo | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | image link | preview',

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
       xhr.send(formData);
     },
   });
</script>

<script type="text/JavaScript">
    $('#pr_headline').on("input", function() {
      var dInput = this.value;
      console.log(dInput);
      $('#headline_pr').text(dInput);
    });
</script>

<script>
  $('#pop_recipient_btn').click(function()
  {
    var data = $('.recipient_form').serialize();
    action_load_link_to_modal('/pressuser/choose_recipient?'+data, 'md');
});
</script>
@endsection