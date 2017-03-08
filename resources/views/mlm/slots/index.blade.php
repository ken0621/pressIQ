@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Slots';
$data['sub'] = '';
$data['icon'] = 'fa fa-linode';
?>
@include('mlm.header.index', $data)

<div class="col-md-6">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Choose Default Slot</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	<label>Slot</label>
    	<select class="form-control">
       @foreach($all_slots as $key => $value)
       <option value="{{$value->slot_id}}">{{$value->slot_no}}</option>
       @endforeach 
      </select>

      <label>Slot Nickname</label>
      <input type="text" class="form-control">

      <hr>
      <button class="btn btn-primary pull-right">Set Default</button>
    </div>
  </div>
</div>  

@endsection
@section('js')
<script type="text/javascript">

</script>
@endsection