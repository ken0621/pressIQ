@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">Testing Menu for MLM</span>
            <small style="font-size: 14px; color: gray;">
                You can use this page to perform actions that can't be performaned even by <b>SUPER ADMINS</b>
            </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="form-group col-md-12" style="margin-top: 15px;">
        <button class="btn btn-primary pull-right" onclick="action_load_link_to_modal('/member/mlm/developer/create_slot')"><i class="fa fa-plus"></i> CREATE TEST SLOT</button>
        <button class="btn btn-def-white btn-custom-white pull-right" style="margin-right: 10px;"><i class="fa fa-arrow-circle-up"></i> IMPORT SLOTS</button>
        <button class="btn btn-def-white btn-custom-white pull-right" style="margin-right: 10px;"><i class="fa fa-recycle"></i> RESET MLM DATA</button>
    </div>
    <div class="form-group panel-body employee-container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive load-test-slots">
            </div>
        </div>
    </div> 
</div>

<script type="text/javascript" src="/assets/member/js/mlm/mlm_developer.js"></script>
<style type="text/css">
    .paginat .pagination
    {
        margin-bottom: 0;
    }
</style>
@endsection