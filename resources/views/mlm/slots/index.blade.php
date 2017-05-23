@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Slots';
$data['sub'] = 'The nickname of the slot will be used as reference for the registration page';
$data['icon'] = 'icon-sitemap';
?>
@include('mlm.header.index', $data)

<div class="col-md-6">
  <div class="box clearfix" style="overflow: hidden !important;">
    <div class="box-header with-border">
      <h3 class="box-title">Choose Default Slot</h3>
    </div>
    <!-- /.box-header -->
    <form class="global-submit" method="post" action="/mlm/slots/set_nickname">
    {!! csrf_field() !!}
    <div class="box-body">
      <label>Slot</label>
      <input type="text" class="form-control" name="active_slot" value="{{ isset($active->slot_no) ? $active->slot_no : ''}}">

      <label>Slot Nickname</label>
      <input type="text" class="form-control" name="slot_nickname" value="{{ isset($active->slot_nick_name) ? $active->slot_nick_name : ''}}" readonly>

      <hr>
      <button class="btn btn-primary pull-right">Set Default</button>
    </div>
    </form>
  </div>
  <div class="box clearfix" style="overflow: hidden !important;">
    <div class="box-header with-border">
      <h3 class="box-title">Membership Codes</h3>
    </div>
    <!-- /.box-header -->
    <form class="global-submit" method="post" action="/mlm/slot/check_add">
    {!! csrf_field() !!}
    <div class="box-body">
    	<label>Membership Code</label>
    	<select name="membership_code_id" class="form-control">
        @foreach($_code as $code)
          <option value="{{$code->membership_code_id}}">{{$code->membership_activation_code}}</option>
        @endforeach
      </select>
      <hr>
      <button class="btn btn-primary pull-right">Use Code</button>
    </div>
    </form>
  </div>
</div>  
<div class="col-md-6">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">SLOT LIST</h3>
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

      </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      
    </div>
  </div>
  <!-- /.box -->
</div>  
<div class="hidden">
  <button class="check_slot_button popup" link=""> 
</div>
@endsection
@section('js')
<script type="text/javascript">
function submit_done(data)
{
  if(data.status == 'success')
  {
    toastr.success(data.message);
  }  
  else if(data.status == "sucess-slot")
  { 
    var link = "/mlm/membership_active_code/"+data.encrypted;
    window.location.href = link;
  }
  else if(data.status == 'success-upgrade')
  {
    toastr.success(data.message);
    $('#global_modal').modal('toggle');
    $('.membership_'+data.slot_id).text(data.membership_name);
  }
  else
  {
    toastr.warning(data.message);
  }
}
</script>
@endsection