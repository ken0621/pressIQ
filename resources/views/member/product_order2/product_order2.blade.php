@extends('member.layout')
@section('content')
<form method="post" class="table-form-data">
    <div class="panel panel-default panel-block panel-title-block">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
        <input type="hidden" name="_active_tab" class="active-tab" />
        <div class="panel-heading">
            <div>
                <i class="fa fa-calendar"></i>
                <h1>
                <span class="page-title">Order List</span>
                <small>
                    List of Orders in the E-Commerce
                </small>
                </h1>
                <div class="dropdown pull-right">
                    <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-upload"></i> Import Shipping</button>
                    <div class="dropdown" style="display: inline-block;">
                        <button class="btn btn-def-white btn-custom-white dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-file-excel-o"></i> Export to Excel <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="/member/ecommerce/product_order2/payref" target="_blank">Paymaya</a></li>
                            <li><a href="/member/ecommerce/product_order2/draref" target="_blank">Dragonpay</a></li>
                        </ul>
                    </div>
                    <button onclick="location.href=''" class="btn btn-primary"><i class="fa fa-truck"></i> Process Shipping</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default panel-block panel-title-block panel-gray"  style="margin-bottom: -10px;">
        <ul class="nav nav-tabs">
            <li class="active change-tab pending-tab cursor-pointer" mode="paid"><a class="cursor-pointer"><i class="fa fa-check"></i> Paid</a></li>
            <li class="change-tab pending-tab cursor-pointer" mode="unconfirmed"><a class="cursor-pointer"><i class="fa fa-money"></i> Unconfirmed Payment</a></li>
            <li class="change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-truck"></i> Pending for Delivery</a></li>
            <li class="cursor-pointer change-tab approve-tab" mode="failed"><a class="cursor-pointer"><i class="fa fa-clock-o"></i> Failed Orders</a></li>
        </ul>
        <div class="search-filter-box hidden">
            <div class="col-md-3" style="padding: 10px">
                <select class="form-control">
                    <option value="0">Filter Sample 001</option>
                </select>
            </div>
            <div class="col-md-3" style="padding: 10px">
                <select class="form-control">
                    <option value="0">Filter Sample 002</option>
                </select>
            </div>
            <div class="col-md-2" style="padding: 10px">
            </div>
            <div class="col-md-4" style="padding: 10px">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control search-employee-name" placeholder="Search by employee name / number" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="tab-content codes_container" style="min-height: 300px;">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="clearfix">
                    <div class="col-md-12">
                        <div class="table-responsive load-table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="/assets/member/js/global_table.js"></script>
@endsection