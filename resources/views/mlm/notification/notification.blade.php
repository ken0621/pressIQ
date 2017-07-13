
@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Notification';
$data['sub'] = 'All income notification are shown here.';
$data['icon'] = 'fa fa-star-half-o';
?>
@include('mlm.header.index', $data)
<div class="table_body_get">              
  @if(isset($report))
      @if(count($report) != 0)
          @foreach($report as $key => $value)
          <div class="col-md-12">
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">
                  <img class="img-circle" src="{{mlm_profile_link($value)}}" alt="User Image">
                  <span class="username">{{name_format_from_customer_info($value)}}</span>
                  <span class="description">{{$value->wallet_log_date_created}}</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
                    <i class="fa fa-circle-o" @if($value->wallet_log_notified == 1) style="color: green" @endif ></i></button>
                  <button type="button" class="btn btn-box-tool hide" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool hide" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- post text -->
                {{$value->wallet_log_details}}
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          @endforeach 
      
      @else
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-header with-border">
            <div class="user-block" style="text-align: center">
              ---No notification found---
            </div>
          </div>
        </div>    
      </div>
      @endif  
      <div class="col-md-12"><center>{!!$report->appends(['search_slot' => $search_slot])->render()!!}</center></div>
  @endif 
</div>  
@endsection
@section('js')
<script type="text/javascript">
  function search_notification(ito)
  {
    var link = '/mlm/notification?page=1&search_slot='+$(ito).val();
    $('.table_body_get').html('<center>Loading...</center>');
    $('.table_body_get').load( link + ' .table_body_get');
  }
</script>
@endsection