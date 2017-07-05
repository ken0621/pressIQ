@extends('mlm.layout')
@section('content')
@section('content')
<?php 
$data['title'] = 'V-Money Wallet';
$data['sub'] = '';
$data['icon'] = 'fa fa-money';
?>
<style type="text/css">
.panel-heading
{
    background-color: white !important;
}  
</style>
@include('mlm.header.index', $data)
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading" style="padding-left: 0; padding-right: 0;">
        <div class="clearfix">
            <form class="global-submit" method="post" action="/mlm/wallet/vmoney/transfer">
                {!! csrf_field() !!}
                <h3 style="margin-top: 0; margin-bottom: 20px; width: 100%; background-color: #367fa9; color: #fff; margin-top: -10px; padding: 7.5px 15px;" class="text-left">Transfer Wallet to Airline Wallet</h3>
                <div style="padding: 0 15px;">
                    <div class="form-group">
                      <label>V-Money Email Address</label>
                      <input type="email" class="form-control" name="vmoney_email">
                    </div>
                    <div class="form-group">
                      <label>Amount to convert</label>
                      <input type="number" class="form-control" value="0" name="wallet_amount">
                    </div>
                    <button class="btn btn-primary pull-right" type="submit">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>    
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div class="clearfix">
            <table style="margin: 0;" class="table table-bordered table-condensed">
                <thead>
                    <th>Amount</th>
                    <th>Account ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </thead>
                  <tr>
                      <td>PHP 500</td>
                      <td>1</td>
                      <td>Paid</td>
                      <td>Today</td>
                  </tr>
            </table>
        </div>
    </div>
</div>        
@endsection
@section('js')
@endsection