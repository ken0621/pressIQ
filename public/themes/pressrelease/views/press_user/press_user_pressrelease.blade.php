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
            <button class="tablinks" onclick="openCity(event, 'send_release')" id="send_release">Send Release</button>
          </div>
                                    
            <div class="press-release-content">     <div id="create_release"
            class="tabcontent create-release-container">       <div
            class="title">Headline:</div>       <input type="text"
            name="pr_headline" class="form-control">       <div
            class="title">Content:</div>       <textarea
            name="pr_content"></textarea>       <div class="button-container">
            <div class="import-button"><a href="#">Import Image</a></div>
            </div>       <div class="title">Boilerplate:</div>       <textarea
            name="bolier_content"></textarea>       <div class="button-
            container">       <span class="save-button"><a href="#">Save as
            draft</a></span>       <span class="preview-button"><a
            href="#">Preview</a></span>       </div>     </div>

                <div id="choose_recipient" class="tabcontent choose-recipient-container">
                  <div class="title-container">Choose Recipient</div>
                  <div class="title">Country:</div>
                  <input type="text" class="form-control">
                  <div class="title">Industry Type:</div>
                  <input type="text" class="form-control">
                  <div class="title">Media Type:</div>
                  <input type="text" class="form-control">
                  <div class="title">Title of Journalist:</div>
                  <input type="text" class="form-control">
                  <div class="title">Send To:</div>
                  <input type="text"  class="form-control" id="pr_receiver_name" name="pr_receiver_name"  readonly>
                  <span class="choose-button" readon>  
                   {{-- POPUP CHOOSE RECIPIENT --}}
                  <a href="javascript:" onclick="action_load_link_to_modal('/pressuser/choose_recipient', 'md');">Choose Recipient</a></span>
                  {{-- POPUP CHOOSE RECIPIENT --}}
                  <input type="hidden" name="pr_to" id="recipient_email" class="form-control" readonly >
                  <div class="button-container">
                  </div>

                <div id="create_pr" class="tabcontent create-pr-container">
                      @if (Session::has('message'))
                      <div class="alert alert-success">
                         <center>{{ Session::get('message') }}</center>
                      </div>
                      @endif 

                      @if (Session::has('delete'))
                      <div class="alert alert-danger ">
                         <center>{{ Session::get('delete') }}</center>
                      </div>
                      @endif

                    <form method="post">
                        {{csrf_field()}}
                        <div class="title-container">PRESS RELEASE</div>
                        <div class="title">Send To:</div>

                        @if (Session::has('pr_edit'))
                        @foreach($edit as $edits)
                        <input type="text" name="pr_receiver_name" value="{{$edits->pr_receiver_name}}" class="form-control" id="recipient_name" readonly>

                        <span class="choose-button" readon>   
                        <a data-toggle="modal" data-target="#recipient-modal" href="#">Choose Recipient</a></span>

                        <input type="hidden" name="pr_to" id="recipient_email" value="{{$edits->pr_to}}" class="form-control" readonly >
                        <div class="title">Headline:</div>
                        <input type="text" name="pr_headline" value="{{$edits->pr_headline}}" class="form-control" style="text-transform: capitalize;">
                        <div class="title">Subheading:</div>
                        <input type="text" name="pr_subheading" value="{{$edits->pr_subheading}}" class="form-control">
                        <div class="title">Content:</div>
                        <textarea name="pr_content">{{$edits->pr_content}}</textarea>
                        @endforeach
                        @else

                        <span class="choose-button" readon>   
                        <a data-toggle="modal" data-target="#recipient-modal" href="#">Choose Recipient</a></span>

                        <input type="text" name="pr_to" id="recipient_email" class="form-control" >
                        <div class="title">Headline:</div>
                        <input type="text" name="pr_headline" class="form-control" style="text-transform: capitalize;">
                        <div class="title">Subheading:</div>
                        <input type="text" name="pr_subheading" class="form-control">
                        <div class="title">Content:</div>
                        <textarea name="pr_content"></textarea>
                        @endif
                        <div class="button-container">
                        <span class="save-button"><button type="submit"  name="draft" value="draft" formaction="/pressuser/pressrelease/draft"><a>Save as draft</a></button></span>
                        <span class="send-button"><button type="submit"  name="send" value="send"><a>Send</a></button></span>
                        </div>
                    </form>

                </div>

                <div id="manage_pr" class="tabcontent manage-pr-container">
                    <div class="manage-holder-container">
                        <table>
                            <tr>    
                                <th>Press Release Title</th>
                                <th>Recipient</th>
                                <th>Status</th>
                                <th>Send</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach($drafts as $draft)
                            <tr>
                                <td>{{$draft->pr_headline}}</td>
                                <td>{{$draft->pr_receiver_name}}</td>
                                <td>Draft</td>
                                <td><a href="/pressuser/pressrelease/send_draft/{{$draft->pr_id}}">Send</a></td>
                                <td><a href="/pressuser/pressrelease/edit_draft/{{$draft->pr_id}}">Edit</a></td>
                                <td><a href="/pressuser/pressrelease/delete_draft/{{$draft->pr_id}}">Delete</a></td>
                            </tr>
                            @endforeach
                        </table>
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

<div class="popup-choose">
<!-- Modal -->
  <div class="modal fade" id="recipient-modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="title-container">RECIPIENT</div>
        </div>
        <div class="modal-body">
          <div class="row clearfix">
            <div class="col-md-3">
                <div class="title-container">Choose Country</div>
                 <form method="post">
                <select type="text" class="col-md-12 " id="choose_country" name="choose_country">
                    <option value="">--Select Country--</option>
                    @foreach($country as $country_name)
                    <option value="{{$country_name->country}}">{{$country_name->country}}</option>
                    @endforeach
                </select><br>
                </form>
            </div>
            <div class="col-md-9">
                <div class="left-container" id="country_table" name="country_table">
                    <table  class="display table table-bordered" style="background-color: #FFFFFF;width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">NAME</th>
                                <th style="text-align: center;">COMPANY NAME</th>
                                 <th style="text-align: center;">INDUSTRY TYPE</th>
                                <th style="text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($add_recipient as $addrecipients)
                            <tr>  
                                <td style="text-align: center;">  
                                <input type="checkbox"  class="btn btn-success" data-name="{{$addrecipients->name}}" data-name1="{{$addrecipients->research_email_address}}"></input>
                               <!--  <a href="/pressadmin/pressreleases_deleterecipient/{{$addrecipients->recipient_id}}" style="background-color: transparent; color: transparent;" ><button type="button" class="btn btn-danger center" id="delete_recipients" name="delete_recipients"> Delete</button> -->
                                </td>
                                <td style="text-align: center;">{{$addrecipients->name}}</td>
                                <td style="text-align: center;">{{$addrecipients->company_name}}</td>
                                <td style="text-align: center;">{{$addrecipients->industry_type}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $add_recipient->render() !!}    
                </div><br>
                <div class="pull right">
                      <button  type="button" id="choose_recipient" class="btn btn-success" data-name="{{$addrecipients->name}}" data-name1="{{$addrecipients->research_email_address}}">Select Recipient</button>
                </div>
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
</script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script type="text/javascript">
   $(document).on('click','#btn_add_recipient',function()
    {
        toastr.success("Recipient Already Added!",{ fadeAway: 1000 }, { timeOut: 1000 });
    });

    $(document).on('click','#delete_recipients',function()
    {
        toastr.error("Recipient Deleted!",{ fadeAway: 1000 }, { timeOut: 1000 });
    });
</script>

@endsection
