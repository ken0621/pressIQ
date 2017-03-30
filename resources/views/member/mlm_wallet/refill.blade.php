@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">E-Wallet Refill Request</span>
            </h1>
        </div>
        <a class="pull-right btn btn-success" href="/member/mlm/wallet">Back</a>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-6">
    <div class="tab-content">
    <form class="global-submit" method="post" action="/member/mlm/wallet/refill/change/settings">
    {!! csrf_field() !!}
        <div id="all-orders" class="tab-pane fade in active">
            <div class="panel-heading">
            <center>Refill Settings</center>
            <div class="col-md-12">
                <label>Processing Fee</label>
                <input type="number" class="form-control" name="wallet_log_refill_settings_processings_fee" value="{{$settings->wallet_log_refill_settings_processings_fee}}">
                <label>Max Request Per Day</label>
                <input type="number" class="form-control" name="wallet_log_refill_settings_processings_max_request" value="{{$settings->wallet_log_refill_settings_processings_max_request}}">
                <hr>
                <button class="btn btn-primary pull-right">Save</button>
            </div>
            </div>
        </div>
    </form>    
    </div>
</div>
<div class="col-md-12">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Refill Logs</h3>
      <div class="col-md-3">
        <select class="form-control">
          <option value="">Pending</option>
          <option value="">Requested</option>
          <option value="">Denied</option>
        </select>
      </div>
      <div class="col-md-3">
        <div class="input-group">
            <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control search_name input-md" onchange="search_name_function(this)" placeholder="Search by Slot" aria-describedby="basic-addon1">
        </div>
      </div>
      <hr>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="load-data" target="paginate_request">
      <div id="paginate_request">
        <table class="table table-bordered">
        <thead>
            <th>Date Request</th>
            <th>Amount Paid</th>
            <th>Amount Accepted</th>
            <th>Processing Fee</th>
            <th>Aprroved</th>
            <th>Remarks</th>
            <th>Attachment</th>
            <th>Date Approved</th>
            <th></th>
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
                  <td class="alert alert-success">Denied</td>
                  @endif
                  <td>{{$value->wallet_log_refill_remarks}}</td>
                  <td>
                  <a href="/{{$value->wallet_log_refill_attachment}}" target="_blank">View</a>
                  </td>
                  <td>{{$value->wallet_log_refill_date_approved}}</td>
                  <td><a href="/member/mlm/wallet/refill/{{$value->wallet_log_refill_id}}">Process</a></td>
                </tr>
              @endforeach
            @else
            <tr>
                <td colspan="40"><center>---No Record Found---</center></td>
            </tr>
            @endif
        </tbody>
      </table>
      <center>{!! $request->render() !!}</center>
      </div> 
    </div>

      
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      
    </div>
  </div>
  <!-- /.box -->
</div>  
@endsection

@section('script')

<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection
