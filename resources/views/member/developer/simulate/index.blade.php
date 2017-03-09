@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Simulate</span>
                <small>
                    Simulation of Slots
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12"><center>Memberships</center><hr></div>
            @foreach($membership as $key => $value)
            <div class="col-md-3">
                <label class="checkbox-inline"><input type="checkbox" name="membership_id[{{$value->membership_id}}]" value="{{$value->membership_id}}">{{$value->membership_name}}</label>
            </div>
            @endforeach
            <div  class="col-md-12"><hr /></div>
            <div class="col-md-6">
                <label>No. of Customer</label>
                <input type="number"  class="form-control" name="no_of_customer">
            </div>
            <div class="col-md-6">
                <label>No. of Slots / Customer</label>
                <input type="number"  class="form-control" name="no_of_slots_customer">
            </div>
            <div class="col-md-6">
                <label>No. of Slots</label>
                <input type="number"  class="form-control" name="no_of_slots">
            </div>
            <div class="col-md-6">
                <label>No. of Downline /slots</label>
                <input type="number"  class="form-control" name="no_of_downlines">
            </div>
            <div  class="col-md-12"><hr /></div>
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">Simulate</button>
            </div>
        </div>
    </div>
</div>
@endsection
<style type="text/css">

</style>
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection