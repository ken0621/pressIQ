@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-building"></i>
            <h1>
                <span class="page-title">Warehouse</span>
                <small>
                    List of warehouse.
                </small>
            </h1>
            <div class="text-right">
                <a class="btn btn-custom-white panel-buttons popup" link="/member/item/transferinventory" size="md" data-toggle="modal" data-target="#global_modal">Transfer Inventory</a>
                <a class="btn btn-primary panel-buttons popup" link="/member/item/warehouse/add" size="lg" data-toggle="modal" data-target="#global_modal">Add Warehouse</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                  <li id="all-list" class="active"><a data-toggle="tab" href="#all"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Active Warehouse</a></li>
                  <li id="archived-list"><a data-toggle="tab" href="#archived"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Archived Warehouse</a></li>
                </ul>
            </div>
            <div class="col-md-4 pull-right">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="search" name="" class="form-control srch-warehouse-txt" placeholder="Start typing warehouse">
                </div>
            </div>
        </div>

        <div class="form-group tab-content panel-body warehouse-container">
            <div class="form-group">
                <div class="col-md-12">
                    @if($count_no_serial != 0)
                    <div class="text-right" style="margin-top: 10px">
                        <a href="/member/item/inventory_log">{{$count_no_serial}} Item has No Serial Number</a>
                    </div>
                    @endif
                </div>
            </div>
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Warehouse Name</th>
                                <th class="text-center">Total Holding Items</th>
                                <th>Total Selling Price</th>
                                <th>Total Cost Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-warehouse">
                        @if($_warehouse != null)
                            @foreach($_warehouse as $warehouse)
                            <tr>
                                <td>{{$warehouse->warehouse_name}}</td>
                                <td class="text-center">{{number_format($warehouse->total_qty)}} item(s)</td>
                                <td>{{currency("PHP",$warehouse->total_selling_price)}}</td>
                                <td>{{currency("PHP",$warehouse->total_cost_price)}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-custom">
                                        <li><a size="lg" link="/member/item/warehouse/view/{{$warehouse->warehouse_id}}" href="javascript:" class="popup">View Warehouse</a></li>
                                        <li><a size="lg" link="/member/item/warehouse/refill?warehouse_id={{$warehouse->warehouse_id}}" href="javascript:" class="popup">Refill  Warehouse</a></li>
                                        <li><a href="javascript:" class="popup" link="/member/item/warehouse/edit/{{$warehouse->warehouse_id}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit</a></li>
                                        <li><a link="/member/item/warehouse/archived/{{$warehouse->warehouse_id}}" href="javascript:" class="popup">Archived</a></li>
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="archived" class="tab-pane fade in">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Warehouse Name</th>
                                <th class="text-center">Total Holding Items</th>
                                <th>Total Selling Price</th>
                                <th>Total Cost Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-warehouse">
                        @if($_warehouse_archived != null)
                            @foreach($_warehouse_archived as $warehouse_archived)
                            <tr>
                                <td>{{$warehouse_archived->warehouse_name}}</td>
                                <td class="text-center">{{number_format($warehouse_archived->total_qty)}}</td>
                                <td>{{currency("PHP",$warehouse_archived->total_selling_price)}}</td>
                                <td>{{currency("PHP",$warehouse_archived->total_cost_price)}}</td>
                                <td class="text-center">
                                    <a href="javascript:" link="/member/item/warehouse/restore/{{$warehouse_archived->warehouse_id}}" href="javascript:" class="popup">RESTORE</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
@section("script")
<!-- <script type="text/javascript" src="/assets/member/js/transfer_warehouse.js"></script> -->
<script type="text/javascript" src="/assets/member/js/warehouse.js"></script>
@endsection