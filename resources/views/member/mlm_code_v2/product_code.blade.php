@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
	            <span class="page-title">Product Codes</span>
	            <small>
	            You can see product codes from here
	            </small>
            </h1>
            <div class="dropdown pull-right">
                <button class="btn btn-def-white btn-custom-white popup" link="/member/mlm/print_codes?type=product_code" size='md'><i class="fa fa-print"></i> Print Membership Codes</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active change-tab unused-tab cursor-pointer" onClick="click_status('unused');" mode="pending"><a class="cursor-pointer"><i class="fa fa-check"></i> Unused</a></li>
        <li class="cursor-pointer change-tab reserved-tab" onClick="click_status('reserved');" mode="approved"><a class="cursor-pointer"><i class="fa fa-anchor"></i> Reserved</a></li>
        <li class="cursor-pointer change-tab sold-tab" onClick="click_status('sold');" mode="approved"><a class="cursor-pointer"><i class="fa fa-money"></i> Sold</a></li>
        <li class="cursor-pointer change-tab used-tab" onClick="click_status('used');" mode="approved"><a class="cursor-pointer"><i class="fa fa-star"></i> Used</a></li>
        <li class="cursor-pointer change-tab block-tab" onClick="click_status('block');" mode="approved"><a class="cursor-pointer"><i class="fa fa-warning"></i> Blocked</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
        
        </div>
        <div class="col-md-3" style="padding: 10px">
       
        </div>
        <div class="col-md-2" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-keyword" placeholder="Search..." aria-describedby="basic-addon1">
            </div>
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12 load-item-table">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/membership_code/product_code.js"></script>
@endsection