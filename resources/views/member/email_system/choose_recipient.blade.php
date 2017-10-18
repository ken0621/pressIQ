@extends('member.layout')
@section('content')
<link rel="stylesheet" type="text/css" href="/email_assets/email_css/create_email.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="/email_assets/email_css/style.css">
<link rel="stylesheet" type="text/css" href="/email_assets/email_css/prism.css"> 
<link rel="stylesheet" type="text/css" href="/email_assets/email_css/chosen.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-envelope"></i>
            <h1>
                <span class="page-title">Press Release Email System</span>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <header class="header_email">
    <div class="panel-body form-horizontal tab_header">
        <div class="form-group">
           <ul class="nav nav-pills">
        <li class=""><a href="/member/page/press_release_email/create_press_release"><big class="big">Create</big><small class="small"> New Release</small></a></li>
        <li class="choose active"><a href="/member/page/press_release_email/choose_recipient_press_release"><big class="big">Choose</big><small class="small"> recipients</small></a></li>
        <li><a href="/member/page/press_release_email/view_send_email_press_release"><big class="big">Send</big><small class="small"> Release </small></a></li>
      </ul>     
    </div>
    </div>
    </header>
    <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
                                      
  <form name="myform" method="GET" action="/member/page/press_release_email/search_recipient_press_release" id="#pass_data">
    <h4 style="margin-left: 10px;">Search By:</h4>
  <div class="form-group row">
    <label class="label-name">Company Name</label>
    <div class="">
          <select data-placeholder="Country" class="chosen-select" multiple tabindex="4" id="company_name" name="company_name">
          @foreach($_list_country as $country_list)
            <option value="{{$country_list->country}}">{{$country_list->country}}</option>
          @endforeach
          </select>
    </div>

  </div>
  <div class="form-group row">
    <label for="inputPassword" class="label-name">Name</label>
    <div class="">
      <input type="text" class="form-control input col-md-6" id= "name" name="name" placeholder="Name">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="label-name ">Position</label>
    <div class="">
        <select class="form-control input col-md-6"  id="position" name="position" placeholder="Position">
<!--           @foreach($_list_country as $country_list)
            <option value="{{$country_list->country}}">{{$country_list->country}}</option>
          @endforeach -->
          <option >1</option>
              <option >1</option>
                  <option >1</option>
        </select>
    </div>
  </div>
  <div class="form-group row">
    <label  class="label-name">Title of Journalist</label>
    <div class="">
      <input type="text" class="form-control input col-md-6" id="title_of_journalist" placeholder="Title of Journalist" name="title_of_journalist">
    </div>
  </div>
  <div class="form-group row">
    <label  class="label-name">Country</label>
    <div class="">
      <input type="text" class="form-control input col-md-6" id="country" placeholder="country" name="country">
    </div>
  </div>
  <div class="form-group row">
    <label  class="label-name">Industry Type</label>
    <div class="">
      <input type="text" class="form-control input col-md-6" id="industry_type" placeholder="industry_type" name="industry_type">
    </div>
  </div>
  <div class="form-group chosen_recipient">
   <!--  <label for="inputPassword" class="label-choose-recipient">Chosen Recipient</label> -->
    <div class="">
      <input type="text" class="form-control col-md-6 input_chose_recipient col-md-6" id="inputPassword" placeholder="Email Address" name="recipient_to">
    </div>
</div>
  <div class="form-group row">
    <div class="">
      <button type="button" class="form-control inputsubmit btn btn-primary" id="inputsubmit" name="search">Search</button>
    </div>
  </div>
</form>
<button class="form-control btn-primary con" type="button" >Continue</button>
<br>
<br>
<br>
<div class="row recipient_container col-md-6">
<div class="recipient_container2">
            <h3 class="text-center">Recipient Lists</h3>
            <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
            <div class="well" style="max-height: ;: 300px;overflow: auto;">
                <ul class="list-group checked-list-box">
                  @foreach($_recipient_list as $recipient_list)
                  <li class="list-group-item" type="checkbox" value="{{$recipient_list->recipient_id}}">{{$recipient_list->company_name}},{{$recipient_list->name}},{{$recipient_list->position}},{{$recipient_list->industry_type}}</li>
                  @endforeach
                </ul>
            </div>
            <div class="pagination_container">
              <?php echo $_recipient_list->render(); ?>
           </div>
        </div>
    </div>
</div>
  
<script src="/email_assets/js/create_press_release.js"></script>
  <script src="/email_assets/js/chosen.jquery.js" type="text/javascript"></script>
  <script src="/email_assets/js/prism.js" type="text/javascript" charset="utf-8"></script>
  <script src="/email_assets/js/init.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(".input_chose_email").click(function() {
        $('#email_databaseModal').modal('show');
            
    });
</script>
<!-- <script>
    function dosubmit()
{
  document.myform.action = "member.email_system.view_send_email_press_release" +
  document.myform.recipient_to.value;
  window.event.returnValue = true;
}
</script> -->
<script>
    $('.con').click(function(event) {
    var recipient_value = $('.input_chose_recipient').val();
    var recipient_link = "/member/page/press_release_email/view_send_email_press_release?sent_email="+recipient_value;

    window.location.href = recipient_link;

    
    });


    $('#company_name').change(function(event) {
      $("#position").empty();
      var country = this.value;

        

    });
</script>
@endsection