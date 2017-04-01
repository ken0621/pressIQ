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

<div class="panel panel-default panel-block panel-title-block">
    <div class="search-filter-box">
        <div class="col-md-3">

        </div> 
        <div class="col-md-4 col-md-offset-5" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search by User Name" aria-describedby="basic-addon1">
            </div>
        </div>  
    </div>

    <form method="post" class="col-md-6" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}" >
        </div>
        <div id="inputs" class="clearfix form-group">
            <input type="file" id="files" name="files[]" multiple />
        </div>
        <div>   
            <output id="list"></output>
        </div>
        <div class="form-group">
            <button class="form-control btn btn-primary btn-submit" disabled="disabled">Generate Accounts</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/plugin/jquery-csv-master/src/jquery.csv.js"></script>
<script type="text/javascript" src="/assets/member/js/import_csv.js"></script>
@endsection