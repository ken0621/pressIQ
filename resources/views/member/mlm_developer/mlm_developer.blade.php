@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">Testing Menu for MLM Slot Creation</span>
            <small style="font-size: 14px; color: gray;">
                You can use this page to perform actions that can't be performaned even by <b>SUPER ADMINS</b>
            </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="form-group col-md-12" style="margin-top: 15px;">
        <button class="btn btn-primary pull-right" onclick="action_load_link_to_modal('/member/mlm/developer/create_slot')"><i class="fa fa-plus"></i> CREATE SLOT</button>
        <button class="btn btn-def-white btn-custom-white pull-right" onclick="action_load_link_to_modal('/member/mlm/developer/repurchase')" style="margin-right: 10px;"><i class="fa fa-cart-plus"></i> REPURCHASE</button>
        <button class="btn btn-def-white btn-custom-white pull-right customize-column" style="margin-right: 10px;"><i class="fa fa-gear"></i> COLUMNS</button>
        <button class="btn btn-def-white btn-custom-white pull-right" onclick="action_load_link_to_modal('/member/mlm/developer/import', 'lg')" style="margin-right: 10px;"><i class="fa fa-arrow-circle-up"></i> IMPORT SLOTS</button>
        <a href="/downloadables/mlm-template.xlsx"><button class="btn btn-def-white btn-custom-white pull-right" style="margin-right: 10px;"><i class="fa fa-arrow-circle-down"></i> TEMPLATE</button></a>
        <a href="/member/mlm/developer/reset" onclick="return (prompt('WARNING! All MLM SLOT and CUSTOMER related to MLM will be deleted. Please write RESET if you are sure.') == 'RESET' ? true : false)"><button class="btn btn-def-white btn-custom-white pull-right" style="margin-right: 10px;"><i class="fa fa-recycle"></i> RESET MLM DATA</button></a>
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
<script type="text/javascript" src="/assets/member/js/column.js"></script>
<style type="text/css">
    .paginat .pagination
    {
        margin-bottom: 0;
    }
</style>
@endsection