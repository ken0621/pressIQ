@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Slots';
$data['sub'] = '';
$data['icon'] = 'icon-sitemap';
?>
@include('mlm.header.index', $data)

<style type="text/css">
  .align_tr_center
  {
    text-align:center;
  }
  .small_gray
  {
    font-size: 10px; 
    color:gray;
  }
</style>
<div class="col-md-12 table-responsive get_body_a" style="background-color: white;">
  <table class="table table-bordered table-hover table-striped">
    <thead style="font-weight: bold !important;font-size: 18px; text-transform: uppercase;" class="text-center">
        <tr>
          <th class="align_tr_center" data-toggle="tooltip" title="This will be id of each slot you have." >
            Slot <br> 
            <span class="small_gray"><small>Hover to view details</small></span>
          </th>
          <th class="align_tr_center" data-toggle="tooltip" title="Date of creation of the slot"  >
            Date Created <br> 
            <span class="small_gray"><small>Hover to view details</small></th>
          <th class="align_tr_center" data-toggle="tooltip" title="The current income/wallet of the slot" >
            Current Wallet <br> 
            <span class="small_gray"><small>Hover to view details</small>
          </th>
          <th class="align_tr_center" data-toggle="tooltip" title="Current slots on your tree" >
            TREE MATRIX <br> 
            <span class="small_gray"><small>Hover to view details</small>
          </th>
          <!--<th class="align_tr_center" data-toggle="tooltip" title="EON account no" >-->
          <!--  EON <br> -->
          <!--  <span class="small_gray"><small>Hover to view details</small>-->
          <!--</th>-->
          <!--<th class="align_tr_center" data-toggle="tooltip" title="EON account no" >-->
          <!--  Middle Name <br> -->
          <!--  <span class="small_gray"><small>Hover to view details</small>-->
          <!--</th>-->
          <th class="align_tr_center" data-toggle="tooltip" title="Upon clicking the enter button, you will be redirected to the dashboard of the slots." >
            USE SLOT <br> 
            <span class="small_gray"><small>Hover to view details</small>
          </th>
          <th class="align_tr_center" data-toggle="tooltip" title="Upon clicking the star button, all referral using your username will put on the selected slot. Orange means active."  >
            DEFAULT SLOT <br> 
            <span class="small_gray"><small>Hover to view details</small>
          </th>
        </tr>
    </thead>
    <tbody>
        @if(count($all_slots_p) >= 1)
          @foreach($all_slots_p as $key => $value)
            <tr>
              <td>
                {{$value->slot_no}}
              </td>
              <td>
                {{$value->slot_created_date}}
              </td>
              <td>
                {{currency('PHP', $sum_wallet[$key])}}
              </td>
              <td class="width_tr_a" percentage="@if(isset($tree_count[$key])){{($tree_count[$key]/$count_per_level_sum) * 100}}@else{{0}}@endif">
                @if(isset($tree_count[$key])){{$tree_count[$key]}} / {{$count_per_level_sum}} ({{($tree_count[$key]/$count_per_level_sum) * 100}}%)@else{{0}}@endif
              </td>
              <!--<td>-->
              <!--    <form class="global-submit" method="post" action="/mlm/set_eon">-->
              <!--    {!! csrf_field() !!}-->
              <!--    <input type="hidden" name="slot_id" value="{{$value->slot_id}}">-->
              <!--      <div class="col-md-12">-->
              <!--        <div class="col-md-9">-->
              <!--          <input type="number" class="form-control" name="slot_eon" value="{{$value->slot_eon}}">-->
              <!--        </div>-->
              <!--        <div class="col-md-3">-->
              <!--          @if($value->slot_eon)-->
              <!--          <button class="btn btn-primary">-->
              <!--           <i class="fa fa-check" aria-hidden="true"></i>-->
              <!--          </button>-->
              <!--          @else-->
              <!--          <button class="btn btn-success">-->
              <!--           <i class="fa fa-check" aria-hidden="true"></i>-->
              <!--          </button>-->
              <!--          @endif-->
              <!--        </div>-->
              <!--      </div>-->
              <!--    </form>-->
              <!--</td>-->
              
              <td>
                  <form class="global_submit" action="/mlm/changeslot" method="post" >
                    {!! csrf_field() !!}
                    <input type="hidden" name="slot_id" value="{{$value->slot_id}}">
                    @if($slot_now_active == $value->slot_id)
                    <button class="btn btn-warning" readonly="readonly">
                      <i class="fa fa-sign-in" aria-hidden="true"></i>
                    </button>
                    @else
                    <button class="btn btn-default" onClick="if(!confirm('Upon clicking OK, you will be redirected to the dashboard of the selected slot.')){return false;}">
                      <i class="fa fa-sign-in" aria-hidden="true"></i>
                    </button>
                    @endif
                  </form>
              </td>
              <td>
                @if($value->slot_defaul == 1)
                <center>
                  <button class="btn btn-warning" readonly="readonly">
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                  </button>
                </center>
                @else
                <center>
                  <form class="global-submit" method="post" action="/mlm/slots/set_nickname" >
                    {!! csrf_field() !!}
                    
                    <input type="hidden" class="form-control" name="active_slot" value="{{ isset($value->slot_no) ? $value->slot_no : ''}}">
                    <input type="hidden" class="form-control" name="slot_nickname" value="{{ isset($active->slot_nick_name) ? $active->slot_nick_name : ''}}" readonly>

      <hr>
      <button class="btn btn-primary pull-right">Set Default</button>
    </div>
    </form>
  </div>
  <div class="box clearfix" style="overflow: hidden !important;">
    <div class="box-header with-border">
      <h3 class="box-title">Code Vault</h3>
    </div>
    <!-- /.box-header -->
    <form class="global-submit" method="post" action="/mlm/slot/check_add">
    {!! csrf_field() !!}
    <div class="box-body">
      <label>Create Slot</label>
      <select name="membership_code_id" class="form-control membership_code_id">
        @if(count($_code) != 0)
          @foreach($_code as $code)
            <option value="{{$code->membership_code_id}}">{{$code->membership_activation_code}} {{$code->membership_type}} ({{$code->membership_name}})</option>
          @endforeach
        @else
        <tr>
            <td colspan="40"><center>---No Record Found---</center></td>
        </tr>
        @endif
      </select>
      <hr>
      @if(count($_code) != 0)
        <button class="btn btn-primary pull-right use_code_mem" style="margin-left:20px;">Use Code</button>
        <button class="btn btn-primary pull-right trans_mem_code" type="button">Transfer code</button>
      @endif
    </div>
    </form>
  </div>



  {{--
  <div class="box clearfix" style="overflow: hidden !important;">
    <div class="box-header with-border">
      <h3 class="box-title">Slot Transfer</h3>
    </div>
    <!-- /.box-header -->
    <form class="global-submit" method="POST" action="/mlm/slots/before_transfer_slot">
    {!! csrf_field() !!}
    <div class="box-body">
        <label>Slot</label>
        <select name="slot_id" class="form-control">
            @foreach($all_slots_show as $slot_show)
                <option value="{{$slot_show->slot_id}}">{{$slot_show->slot_no}} ({{$slot_show->membership_name}})</option>
            @endforeach
        </select>
      <hr>
      <button class="btn btn-primary pull-right">Transfer</button>
    </div>
    </form>
  </div>
  --}}




  @if(count($_item_code) >= 1)
    <div class="box clearfix" style="overflow: hidden !important;">
      <div class="box-header with-border">
        <h3 class="box-title">Product Codes</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <label>Code</label>
          <select name="item_code_id" class="form-control item_code_id">
              @foreach($_item_code as $item_code)
                  <option value="{{$item_code->item_code_id}}">{{$item_code->item_activation_code}}</option>
              @endforeach
          </select>
        <hr>
        <button class="btn btn-primary pull-right use_prod_code" style="margin-left:20px;">Use code</button>
        <button class="btn btn-primary pull-right trans_prod_code">Transfer code</button>
      </div>
    </div>
  @endif
</div>  
<div class="col-md-6">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">SLOT LIST </h3>
      <button class="btn btn-primary pull-right popup" link="/mlm/slots/manual_add_slot">Add new slot</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <thead>
            <th>Slot</th>
            <th>Date Created</th>
            <th>Current Wallet</th>
            <th>Membership</th>
            <th></th>
            @if($enabled_upgrade_slot == 1)
            <th></th>
            @endif
        </thead>
        <tbody>
            @if(count($all_slots_p) >= 1)
              @foreach($all_slots_p as $key => $value)
                <tr>
                  <td>{{$value->slot_no}}</td>
                  <td>{{$value->slot_created_date}}</td>
                  <td>{{$value->slot_wallet_current}}</td>
                  <td class="membership_{{$value->slot_id}}">{{$value->membership_name}}</td>
                  <td><form class="global_submit" action="/mlm/changeslot" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="slot_id" value="{{$value->slot_id}}">
                        <button class="btn btn-primary">Use Slot</button>
                      </form>
                  </td>
                  @if($enabled_upgrade_slot == 1)
                  <td><button class="btn btn-primary popup" link="/mlm/slots/upgrade_slot/{{$value->slot_id}}" type="button" size="lg" data-toggle="modal" data-target="#global_modal">Upgrade Slot</button></td>
                  @endif
                </tr>
              @endforeach
            @else
            <tr>
                <td colspan="40"><center>---No Record Found---</center></td>
            </tr>
            @endif
            <tr>
              <td colspan="40"><center>{!! $all_slots_p->render() !!}</center></td>
            </tr>
        </tbody>

<div class="hidden">
  <button class="check_slot_button popup" link=""> 
</div>
@endsection
@section('js')
<script type="text/javascript">
on_click();

function get_body_a()
{
  $('.get_body_a').html('<center>Loading..</center>');
  $('.get_body_a').load('/mlm/slots .get_body_a');
}
function submit_done(data)
{
  if(data.status == 'success')
  {
    toastr.success(data.message);
  } 
  else if(data.status == 'success_change_slot')
  {
    get_body_a();
  }
  else if(data.status == 'success_change_slot_v2')
  {
    location.reload();
  }
  else if(data.status == "sucess-slot")
  { 
    var link = "/mlm/slot/manual_add?membership_id="+data.encrypted;
    action_load_main_modal(link,"");
  }
  else if(data.status == 'success-upgrade')
  {
    toastr.success(data.message);
    $('#global_modal').modal('toggle');
    $('.membership_'+data.slot_id).text(data.membership_name);
  }
  else if(data.status == 'success-manual')
  {
    var link = "/mlm/slot/manual_add?membership_id="+data.encrypted;
    action_load_main_modal(link,"");
  }
  else if(data.response_status == "warning_1")
  {
    var erross = data.warning_validator;
    $.each(erross, function(index, value) 
    {
        toastr.warning(value);
    }); 
  }
  else if(data.response_status == 'warning_2')
  {
    toastr.warning(data.error);
  }
  else if(data.response_status == 'success_add_slot')
  {
    toastr.success('Congratulations, Your slot is created.');
    window.location = "/mlm";
  }
  else if(data.status == 'success_before_transfer_slot')
  {
    var link = "/mlm/slots/transfer_slot?slot_id="+data.encrypted;
    action_load_main_modal(link,"");
  }
  else if(data.status == 'success_transfer_slot')
  {
    toastr.success('Transfer done.');
    window.location = "/mlm";
  }
  else if(data.status == 'success-check-prod-code')
  {
    var link = "/mlm/slots/item_code?item_code_id="+data.item_code_id;
    action_load_main_modal(link,"");
  }
  else if(data.status == 'success-prod-code')
  {
    toastr.success('Done.');
    window.location = "/mlm/slots";
  }
  else if(data.status == 'success-transfer-prod-code')
  {
    toastr.success('Done.');
    window.location = "/mlm/slots";
  }
  else if(data.status == 'success-transfer-mem-code')
  {
    toastr.success('Done.');
    window.location = "/mlm/slots";
  }
  else
  {
    toastr.warning(data.message);
  }
}
function on_click()
{
  $(".use_prod_code").click(function()
  {
    var link = "/mlm/slots/item_code?item_code_id="+$(".item_code_id").val();
    action_load_main_modal(link,"");
  });
  $(".trans_prod_code").click(function()
  {
    var link = "/mlm/slots/transfer_item_code?item_code_id="+$(".item_code_id").val();
    action_load_main_modal(link,"");
  });
  $(".trans_mem_code").click(function()
  {
    // alert($(".membership_code_id").val());
    var link = "/mlm/slots/transfer_mem_code?mem_code_id="+$(".membership_code_id").val();
    action_load_main_modal(link,"");
  });
}

$('.width_tr_a').each(function () {
    var percentage = $(this).attr('percentage');
    var col1="#B8CDD3";
    var col2="#EDEDED";
    var t = $(this);
    $(this).css('background', "-webkit-gradient(linear, left top,right top, color-stop("+percentage+"%,"+col1+"), color-stop("+percentage+"%,"+col2+"))");
    $(this).css('background',  "-moz-linear-gradient(left center,"+col1+" "+percentage+"%, "+col2+" "+percentage+"%)");
    $(this).css('background',  "-o-linear-gradient(left,"+col1+" "+percentage+"%, "+col2+" "+percentage+"%)");
    $(this).css('background',  "linear-gradient(to right,"+col1+" "+percentage+"%, "+col2+" "+percentage+"%)");
});
</script>
@endsection