@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Slots';
$data['sub'] = 'The nickname of the slot will be used as reference for the registration page';
$data['icon'] = 'fa fa-linode';
?>
@include('mlm.header.index', $data)

<div class="col-md-6">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Choose Default Slot</h3>
    </div>
    <!-- /.box-header -->
    <form class="global-submit" method="post" action="/mlm/slots/set_nickname">
    <div class="box-body">
    	<label>Slot</label>
    	<input type="text" class="form-control" name="active_slot" value="{{ isset($active->slot_no) ? $active->slot_no : ''}}">

      <label>Slot Nickname</label>
      <input type="text" class="form-control" name="slot_nickname" value="{{ isset($active->slot_nick_name) ? $active->slot_nick_name : ''}}">

      <hr>
      <button class="btn btn-primary pull-right">Set Default</button>
    </div>
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
        </thead>
        <tbody>
            @if(count($all_slots_p) >= 1)
              @foreach($all_slots_p as $key => $value)
                <tr>
                  <td>{{$value->slot_no}}</td>
                  <td>{{$value->slot_created_date}}</td>
                  <td>{{$value->slot_wallet_current}}</td>
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
@endsection
@section('js')
<script type="text/javascript">
function submit_done(data)
{
  if(data.status == 'success')
  {
    toastr.success(data.message);
  }
  else
  {
    toastr.warning(data.message);
  }
}
</script>
@endsection