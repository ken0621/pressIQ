@extends('member.layout')
@section('content')

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <div>
            <i class="fa fa-user-secret"></i>
            <h1>
                <span class="page-title">Utilities &raquo; Admin User</span>
                <small>
                Add a user
                </small>
            </h1>
            <button type="button" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/utilities/modal-add-user" size="sm">Create User</button>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block clearfix">
    <div class="col-md-6">
        <span class="counter">0</span>
        <div class="progress">
            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}" >
            </div>
            <div id="inputs" class="custom-upload">
                <input type="file" id="files" name="files[]" class="form-control" style="width: 100%; height: 100%;" />
            </div>
            <div>   
                <output id="list"></output>
            </div>
            <div class="form-group">
                <button class="form-control btn btn-primary btn-submit" disabled="disabled">Generate Accounts</button>
            </div>
        </form>
        </br>
    </div>
    <div class="col-md-6">
    </div>
    <div class="col-md-12">
    </div>
</div>
@endsection
@section('css')
<style>
    .custom-upload
    {
        width: 100%;
        height: 100px;
        border: black dashed 2px;
        background-color: white;
    }
</style>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/plugin/jquery-csv-master/src/jquery.csv.js"></script>
<script type="text/javascript" src="/assets/member/js/import_csv.js"></script>
@endsection