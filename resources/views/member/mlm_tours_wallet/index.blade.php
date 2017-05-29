@extends('member.layout')
@section('content')

<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Tours Wallet</span>
                <small>
                    Settings
                </small>
            </h1>
        </div>
    </div> 
</div>
<div class="panel panel-default panel-block panel-title-block col-md-6" id="top">
    <div class="panel-heading">
        <div>
            <form class="global-submit" action="/member/mlm/tours_wallet/update/settings">
            {!! csrf_field() !!}
                <center>Trip Option Account</center>
                <div class="pull-right"><span class="current_balance" style="color: green">Account Balance: {{number_format(isset($account_tours->tour_wallet_a_current_balance) ? $account_tours->tour_wallet_a_current_balance : 0 )}}</span></div>
                <br>
                <label>Url</label>
                <input type="text" class="form-control" value="{{$shop_information->shop_wallet_tours_uri}}" readonly="readonly">
                <label>Account ID</label>
                <input type="text" class="form-control" name="tour_Wallet_a_account_id" value="{{isset($account_tours->tour_Wallet_a_account_id) ? $account_tours->tour_Wallet_a_account_id : '' }}">
                <label>Username</label>
                <input type="text" class="form-control" name="tour_wallet_a_username" value="{{isset($account_tours->tour_wallet_a_username) ? $account_tours->tour_wallet_a_username : '' }}">
                <label>Password</label>
                <input type="password" class="form-control" name="tour_wallet_a_base_password" value="{{isset($account_tours->tour_wallet_a_base_password) ? $account_tours->tour_wallet_a_base_password : '' }}">
                <hr>
                <button class="btn btn-primary pull-right">Update</button>
            </form>    
        </div>
    </div>
</div>        
@endsection

@section('script')
<script type="text/javascript">
 function  submit_done (data) {
     // body...
    if(data.status == 1)
    {
        toastr.success(data.message + ' : ' + data.result);
        $('.current_balance').html("Account Balance: " + data.result);
    }
    else
    {
        toastr.warning(data.message);
    }
 }
</script>
@endsection