@extends('mlm.layout')
@section('content')
@section('content')
<?php 
$data['title'] = 'Tours Wallet';
$data['sub'] = '';
$data['icon'] = 'fa fa-plane';

?>
@include('mlm.header.index', $data)
<div class="panel panel-default panel-block panel-title-block col-md-6" id="top">
    <div class="panel-heading">
        <div class="clearfix">
        	<form class="global-submit" action="/mlm/wallet/tours/update">
        	{!! csrf_field() !!}
            	<label>Trip Option Account Id:</label>
            	<input type="text" class="form-control" name="tour_Wallet_a_account_id">

            	<label>Trip Option Username:</label>
            	<input type="text" class="form-control" name="tour_wallet_a_username">

            	<label>Trip Option Password:</label>
            	<input type="password" class="form-control" name="tour_wallet_a_base_password">

				<hr>
            	<button class="btn btn-primary pull-right">Submit</button>
            </form>	
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
function submit_done(data)
{
	if(data.status == 1)
	{
		toastr.success(data.message + ' : ' + data.result);
	}
	else
	{
		toastr.warning(data.message);
	}
}
</script>
@endsection