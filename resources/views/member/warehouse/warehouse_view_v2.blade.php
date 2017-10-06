
@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="panel-heading">
        <div>
            <i class="fa fa-area-chart"></i>
            <h1>
                <span class="page-title">View Warehouse &raquo; {{ucwords($warehouse_name)}}</span>
                <small>
                    Warehouse Inventory
                </small>
            </h1>
            <div class="text-right">
                <a href="javascript:" class="btn btn-primary">Print Inventory</a>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                  <li id="all-list" class="active"><a data-toggle="tab" href="#bundle"><i class="fa fa-yelp" aria-hidden="true"></i>&nbsp;Bundle/Group</a></li>
                  <li id="archived-list"><a data-toggle="tab" href="#odd-inventory"><i class="fa fa-opencart" aria-hidden="true"></i>&nbsp;Odd Inventory</a></li>
                  <li id="archived-list"><a data-toggle="tab" href="#unused-empties"><i class="fa fa-slack" aria-hidden="true"></i>&nbsp;Unused Empties</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="input-group pos-search">
                  <span style="background-color: #eee" class="input-group-addon button-scan" id="basic-addon1">
                    <i class="fa fa-search scan-icon"></i>
                    <i style="display: none;" class="fa fa-spinner fa-pulse fa-fw scan-load"></i>
                  </span>
                  <input type="text" class="form-control event_search_item" placeholder="Enter item SKU or Manufaturer" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>

        <div class="form-group tab-content panel-body">
            <div id="bundle" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    @include("member.load_ajax_data.load_bundle_item")
                </div>
            </div>
            <div id="odd-inventory" class="tab-pane fade">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    @include("member.load_ajax_data.load_bundle_item_inventory")
                </div>
            </div>
            <div id="unused-empties" class="tab-pane fade">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    @include("member.load_ajax_data.load_bundle_item_inventory_empties")
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection