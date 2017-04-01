@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Wallet Refill';
$data['sub'] = 'In this tab you can send a wallet refill request';
$data['icon'] = 'fa fa-retweet';
$data['button'][0] = '<a href="/mlm/refill/request" class="small-box-footer pull-right">Request Refill<i class="fa fa-arrow-circle-right"></i></a>';

?>
@include('mlm.header.index', $data)

@if(isset($status))
<div class="col-md-6">
  <div class="box box-{{$status}}">
    <div class="box-header with-border">
      <h3 class="box-title">Message</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      {{$message}}
    </div>
  </div>
</div>
@endif

<div class="col-md-12">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Refill Logs</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <thead>
            <th>Date Request</th>
            <th>Amount Paid</th>
            <th>Amount Accepted</th>
            <th>Processing Fee</th>
            <th>Aprroved</th>
            <th>Remarks</th>
            <th>Attachment</th>
            <th>Date Approved/Deniedc      </th>
        </thead>
        <tbody>
            @if(count($request) >= 1)
              @foreach($request as $key => $value)
                <tr>
                  <td>{{$value->wallet_log_refill_date}}</td>
                  <td>{{$value->wallet_log_refill_amount_paid}}</td>
                  <td>{{$value->wallet_log_refill_amount}}</td>
                  <td>{{$value->wallet_log_refill_processing_fee}}</td>
                  @if($value->wallet_log_refill_approved == 0)
                  <td class="alert alert-warning">Pending</td>
                  @elseif($value->wallet_log_refill_approved == 1)
                  <td class="alert alert-success">Approved</td>
                  @else
                  <td class="alert alert-danger">Denied</td>
                  @endif
                  <td>{{$value->wallet_log_refill_remarks}}</td>
                  <td>
                  @if($value->wallet_log_refill_attachment != null)
                  <center><a href="{{$value->wallet_log_refill_attachment}}" target="_blank">Download</a></center>
                  @else
                  <center>No Attachment</center>
                  @endif
                  </td>
                  <td>{{$value->wallet_log_refill_date_approved}}</td>
                </tr>
              @endforeach
            @else
            <tr>
                <td colspan="40"><center>---No Record Found---</center></td>
            </tr>
            @endif
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