@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Rematrix Single (BROWN)</span>
                <small>
                    Rearrange the tree
                </small>
            </h1>
        </div>
    </div>
</div>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if (session('status_error'))
    <div class="alert alert-warning">
        {{ session('status_error') }}
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <form action="/member/developer/rematrix_single/submit" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="col-md-6">
                    <label for="slot_id">Slot Id</label>
                    <input class="form-control" id="slot_id" value="" name="slot_id">
                </div>                
                <div class="col-md-6">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" value="" name="password">
                </div>
                <!--<div class="col-md-6">-->
                <!--    <label for="rematrix_status">Rematrix Status</label>-->
                <!--    <input class="form-control" id="rematrix_status" value="----" disabled>-->
                <!--</div>-->
                <div class="col-md-12" style="padding-top:10px;"></div>
                <div class="col-md-3 pull-right">
                    <button class="submit form-control btn-custom-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<style type="text/css">

alert(123);
</style>
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script type="text/javascript">
var numItems = $('.item').length;
</script> -->
@endsection