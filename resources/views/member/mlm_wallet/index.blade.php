@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">E-Wallet</span>
                <small>
                   This is for viewing and adjusting wallet of customer/slots.
                </small>
            </h1>
        </div>
        <a class="pull-right btn btn-warning" href="/member/mlm/wallet/transfer">Wallet Transfer</a>
        <a class="pull-right btn btn-success" href="/member/mlm/wallet/adjust">Adjust Wallet</a>
        <a class="pull-right btn btn-primary" href="/member/mlm/wallet/refill">Wallet Refill Request</a>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-6">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
            <div class="panel-heading">
                <center>Wallet Logs</center>

                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <th>NAME</th>
                            <th>USERNAME</th>
                            <th>SLOT</th>
                            <th>CURRENT WALLET</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if(count($wallet_log) >= 1)
                                @foreach($wallet_log as $key => $value)
                                <tr>
                                    <td>{{name_format_from_customer_info($value)}}</td>
                                    <td>{{$value->mlm_username}}</td>
                                    <td>{{$value->slot_no}}</td>
                                    <td>{{$value->sum_wallet}}</td>
                                    <td><a class="btn btn-primary" href="javascript:" onClick="show_breakdown({{$value->wallet_log_slot}})">Break Down</a></td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="3"><center>No Wallet Log Available.</center></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <center>{!! $wallet_log->render() !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-6">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
            <div class="panel-heading">
                <center>Breakdown</center>

                <div class="table-responsive load_breakdown">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function show_breakdown (slot_id) {
        $('.load_breakdown').html('<center><div class="loader-16-gray"></div></center>');
        $('.load_breakdown').load('/member/mlm/wallet/breakdown/' +slot_id);
    }
</script>

@endsection
