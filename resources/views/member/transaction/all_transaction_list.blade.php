@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="" class="view-receipt" value="{{Request::input('receipt_id')}}">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">All Transaction List</span>
            <small>
                This are the list of TRANSACTIONS that happened in the system.
            </small>
            </h1>
            <div class="dropdown pull-right">
                <a href="javascript:" class="btn btn-def-white btn-custom-white"><i class="fa fa-check"></i> Secondary Command</a>
                <a href="javascript:" target="_blank" class="btn btn-primary"><i class="fa fa-star"></i> Primary Command</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-check"></i> Active</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-trash"></i> Archived</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            <select class="form-control filter-type">
                <option value=''>Select Type</option>
                @foreach($_type as $type)
                <option value='{{$type}}'>{{ucwords($type)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3" style="padding: 10px">
        </div>
        <div class="col-md-2" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-keyword" placeholder="Search by Transaction number" aria-describedby="basic-addon1">
            </div>
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="table-responsive load-item-table">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/transaction/transaction_list.js"></script>
@endsection