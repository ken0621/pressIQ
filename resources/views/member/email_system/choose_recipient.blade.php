@extends('member.layout')
@section('content')
<link rel="stylesheet" type="text/css" href="/email_assets/email_css/create_email.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="container">
           <ul class="list-inline inline">
            <li class=""><a href="#"><big>Create</big><small> New Release</small></a></li>
            <li class="choose"><a href="#"><big>Choose</big><small> recipients</small></a></li>
            <li><a href="#"><big>Send</big><small> Release </small></a></li>
          </ul>
        </div>
        </div>     
    </div>
    </header>
</head>
    <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>

<div class="thumbnail background">                                          
  <form method="post" action="/member/page/press_release_email/search_recipient_press_release">
    <h4>Search By:</h4>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control input" id= "recipient_name" name = "recipient_name" placeholder="Name">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Email Address</label>
    <div class="col-sm-10">
      <input type="text" class="form-control input" id= "recipient_email_address" placeholder="Email Address">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Position</label>
    <div class="col-sm-10">
      <input type="text" class="form-control input" id= "recipient_position"  placeholder="Position">
    </div>
  </div>
  <div class="form-group row">
    <label  class="col-sm-2 col-form-label">Group</label>
    <div class="col-sm-10">
      <input type="text" class="form-control input" id="recipient_group" placeholder="Name">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <input type="button" value ="search" class="form-control input inputsubmit" id="inputsubmit" name="search">
    </div>
  </div>
</form>
<div class="form-group chosen_recipient">
    <label for="inputPassword" class="col-sm-2 col-form-label">Chosen Recipient</label>
    <div class="">
      <input type="text" class="form-control input_chose_recipient" id="inputPassword" placeholder="Email Address">
    </div>
</div>
<div class="row recipient_container">
<div class="col-xs-6 list">
            <h3 class="text-center">Recipient Lists</h3>
            <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
            @foreach($_recipient_list as $recipient_list)
            <div class="well" style="max-height: ;: 300px;overflow: auto;">
                <ul class="list-group checked-list-box">
                  <li class="list-group-item" type="checkbox" value="{{$recipient_list->recipient_id}}">{{$recipient_list->recipient_email_address}}</li>
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>
<button class="btn-primary"><a href ="/member/page/press_release_email/view_send_email_press_release" class="con"> Continue</a></button>
</div>
<script src="/email_assets/js/create_press_release.js"></script>
<script>
    $(".input_chose_email").click(function() {
        $('#email_databaseModal').modal('show');
            
    });
</script>

@endsection
