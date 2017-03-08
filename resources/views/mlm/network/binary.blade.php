@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Network List binary';
$data['sub'] = '';
$data['icon'] = 'fa fa-retweet';
?>  
@include('mlm.header.index', $data) 
<div class="col-md-6">
  <center>LEFT</center>
  <ul class="timeline">
  @foreach($tree_left as $key => $value)
    <li class="time-label">
              <span class="bg-aqua">
                LEVEL {{$key}}
              </span>
        </li>
        @foreach($value as $key => $value)
        <li>
          
          <div class="timeline-item">
            <h3 class="timeline-header"><a href="javascript:">{{name_format_from_customer_info($value)}}</a> </h3>
            <div class="timeline-body">
                    <span style="color: gray;">Slot: </span> {{$value->slot_no}}
                    <br>
                    <span style="color: gray;">Membership: </span> {{$value->membership_name}}
                    <br>
                    <span style="color: gray;">Membership Code: </span> {{$value->membership_activation_code}}
                    <br>
            </div>
            <div class="timeline-footer">

            </div>
          </div>
        </li>
        @endforeach

  @endforeach
  </ul>
</div>   

<div class="col-md-6">
  <center>RIGHT</center>
  <ul class="timeline">
  @foreach($tree_right as $key => $value)
    <li class="time-label">
              <span class="bg-aqua">
                LEVEL {{$key}}
              </span>
        </li>
        @foreach($value as $key => $value)
        <li>
          
          <div class="timeline-item">
            <h3 class="timeline-header"><a href="javascript:">{{name_format_from_customer_info($value)}}</a> </h3>
            <div class="timeline-body">
                    <span style="color: gray;">Slot: </span> {{$value->slot_no}}
                    <br>
                    <span style="color: gray;">Membership: </span> {{$value->membership_name}}
                    <br>
                    <span style="color: gray;">Membership Code: </span> {{$value->membership_activation_code}}
                    <br>
            </div>
            <div class="timeline-footer">

            </div>
          </div>
        </li>
        @endforeach

  @endforeach
  </ul>
</div>   
@endsection
@section('script')

@endsection