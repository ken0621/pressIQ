@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
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
                <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                <button onclick="location.href=''" class="btn btn-primary"><i class="fa fa-truck"></i> Process Shipping</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray"  style="margin-bottom: -10px;">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-check"></i> Paid</a></li>
        <li class="change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-truck"></i> Pending for Delivery</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-clock-o"></i> Pending / Failed Orders</a></li>
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead style="text-transform: uppercase">
                                <tr>
                                    <th class="text-center">RECEIPT NO.</th>
                                    <th class="text-center">CUSTOMER</th>
                                    <th class="text-center">DATE ORDERED</th>
                                    <th class="text-center">DATE PAID</th>
                                    <th class="text-center">DATE SHIPPED</th>
                                    <th class="text-center" width="120px">E-MAIL</th>
                                    <th class="text-center" width="120px">CONTACT NO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($_order as $order)
                                <tr>
                                  
                                    <td class="text-center">{{ $order->transaction_number }}</td>
                                    <td class="text-center">{{ $order->first_name }}</td>
                                    <td class="text-center">{{ $order->display_date_order }}</td>
                                    <td class="text-center">{{ $order->display_date_paid }}</td>
                                    <td class="text-center">{{ $order->display_date_deliver }}</td>
                                    <td class="text-center">{{ $order->email }}</td>
                                    <td class="text-center">{{ $order->phone_number }}</td>
                                    <td class="text-center"><a href="javascript:">DETAILS</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $_order->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection