@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Auto Entry</span>
                <small>
                    Auto Entry of slot
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="col-md-6">
                <label for="number_of_sponsor">Number of slots</label>
                <input class="form-control" id="slot_count" value="{{$slot_count}}" disabled>
            </div>
            <div class="col-md-6">
                <label for="rematrix_status">Re_entry Status</label>
                <input class="form-control" id="re_entry_status" value="----" disabled>
            </div>
            <div class="col-md-6">
                <label for="rematrix_status">Slot Owner</label>
                <select class="form-control" name="slot_owner">
                    @foreach($_customer as $customer)
                        <option value="{{$customer->customer_id}}">{{$customer->first_name}} {{$customer->middle_name}} {{$customer->last_name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@endsection
<style type="text/css">

</style>
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    



</script>
@endsection