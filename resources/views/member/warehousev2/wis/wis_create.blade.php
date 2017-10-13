@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-archive"></i>
            <h1>
                <span class="page-title">CREATE - Warehouse Issuance Slip</span>
            </h1>
            <div class="text-right">
                <a class="btn btn-custom-white panel-buttons">Cancel</a>
                <button class="btn btn-primary panel-buttons save-button" type="button">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-12">
                <div class="input-group pos-search">
                  <span style="background-color: #eee" class="input-group-addon button-scan" id="basic-addon1">
                    <i class="fa fa-shopping-cart scan-icon"></i>
                    <i style="display: none;" class="fa fa-spinner fa-pulse fa-fw scan-load"></i>
                  </span>
                  <input type="text" class="form-control event_search_item" placeholder="Enter item name or scan barcode" aria-describedby="basic-addon1">
                  <div class="pos-search-container"></div>
                </div>
            </div>
        </div>
       
    </div>
</div>

<form class="global-submit form-to-submit-add" action="/member/item/warehouse/wis/create-submit" method="post">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-12">
                <label>Remarks</label>
                <div>
                    <textarea class="form-control" name="wis_remarks"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="load-item-table-pos"></div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/warehouse/wis_create.js"></script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/pos.css">
@endsection