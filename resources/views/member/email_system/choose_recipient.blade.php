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
    <h4 style="margin-left: 10px;margin-bottom: 20px;">Search By:</h4>

  <div class="form-group row">
  <label  class="label-name">Country</label>
  <br>
  <select class="form-control input col-md-6" id="country" id="filter">
   <option value="1">Select All</option>
   @foreach($_recipient_country as $recipient_country)
    <option value="{{$recipient_country->country}}">{{$recipient_country->country}}</option>
    @endforeach
  </select>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="label-name ">Position</label>
    <div class="">
        <select class="form-control input col-md-6"  id="position" name="position" placeholder="Position">
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
    <label  class="label-name">Industry Type</label>
    <div class="multi">

          <select data-placeholder="Choose Industry" class="chosen-select" id="industry_type" name="industry_type" multiple tabindex="4">
            <option value=""></option>
            <option value="United States">United States</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Afghanistan">Afghanistan</option>
            <option value="Aland Islands">Aland Islands</option>
          </select>
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
            <h3 class="text-center recipient_text">Recipient Lists</h3>
            <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
            <div class="well box" style="max-height: ;: 300px;overflow: auto;">
              <button type="button" class="check-all btn btn-primary" onClick="selectall(this)">Check All</button>
                <ul class="list-group check_list" id="wa">
                  @foreach($_recipient_list as $recipient_list)
                  <li class="list-group-item tocheck" name="foo" id="em" value="{{$recipient_list->recipient_id}}">
                    <div class="checkbox">
                    <input type = "checkbox" id="to_check" class="to_check">
                    {{$recipient_list->company_name}},{{$recipient_list->name}},{{$recipient_list->position}},{{$recipient_list->industry_type}}
                  </div>
                </li>
                  @endforeach
                </ul>
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

            // if(document.getElementById("to_check").checked == true){
            //             var myArr = [];
            //              $('#wa li').each(function (i) {

            //                 var texts = $(this).text();
            //                 // var array = texts.split(",");
            //                 myArr.push($(this).attr('value'));

            //             })

                            var recipient_value =  $('.input_chose_recipient').val(string);;
                            var recipient_link = "/member/page/press_release_email/view_send_email_press_release?sent_email="+recipient_value;

                            window.location.href = recipient_link;
              // }
              // else{
              //   alert("Please select email_recipient");
              // }



    });


  // //get position 
  //   $(document).ready(function() {
  //       $('#country').on('change', function() {
  //           var country = this.value;
  //           if(country){
  //               $.ajax({
  //                   url: '/member/page/press_release_email/choose_recipient_press_release/ajax',
  //                   type: "GET",
  //                   data:{country:country},
  //                   dataType: "json",
  //                   success:function(data) {
                       

  //                       $('select[name="position"]').empty();
  //                       $.each(data, function(key, value) {
  //                              $('select[name="position"]').append(
  //                                   $('<option>', { value : value.position, text : value.position })
  //                               );
                                                            
  //                       });

  //                   }
  //               });
  //           }else{
  
  //           }
  //       });
  //   });

    // $('#country').click(function(event) {
    // var wa = $(".chosen-select").val();
    // alert(wa);
    // });
</script>

<!-- <script>

  selectAll();

$('#filter').change(function()
{

  if($("#filter option[value='1']").is(':selected'))
  {
     selectAll();
  }

})

function selectAll()
{
  /*$('#filter > option').attr("selected", "selected");*/
   $('#filter option').prop('selected', true);
   $("#filter option[value='1']").prop('selected', false);
}
</script> -->
@endsection

