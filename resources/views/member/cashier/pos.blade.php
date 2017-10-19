@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-calculator"></i>
            <h1>
                <span class="page-title">Cashier</span>
                <small>
                    Process live purchases from your customers
                </small>
            </h1>
            <div class="text-right">
                <a class="btn btn-custom-white"><i class="fa fa-search"></i> Lookup Receipt</a>
                <a class="btn btn-custom-white"><i class="fa fa-calendar"></i> Today's Transactions</a>
                <button class="btn btn-primary panel-buttons btn-process-sale" type="button"><i class="fa fa-star"></i> Process Sale</button>
            </div>
        </div>
    </div>
</div>

<div class="row cashier">
    <div class="col-md-8">
        <!-- PRODUCT SCAN / SEARCH -->
        <div class="panel panel-default panel-block panel-title-block">
            <div class="panel-body form-horizontal">
                <div class="row">
                    <div class="col-md-12 clearfix">
                        <div class="input-group pos-search">
                          <span style="background-color: #eee" class="input-group-addon button-scan" id="basic-addon1">
                            <i class="fa fa-shopping-cart scan-icon"></i>
                            <i style="display: none;" class="fa fa-spinner fa-pulse fa-fw scan-load"></i>
                          </span>
                          <input type="text" class="form-control event_search_item" placeholder="Enter item name or scan barcode" aria-describedby="basic-addon1">
                        </div>
                        <div class="pos-search-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CART LIST -->
        <div class="panel panel-default panel-block panel-title-block">
            <div class="panel-body form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="load-item-table-pos"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <!-- CUSTOMER NAME -->
        <div class="panel panel-default panel-block panel-title-block ">
            <div class="panel-body form-horizontal">
                <div class="customer-container">
                    @include('member.cashier.pos_customer_info')
                </div>
            </div>
        </div>


        <form class="global-submit form-process-sale" action="/member/cashier/pos/process_sale" method="post">
        <input class="token" type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <!-- TOTAL -->
            <div class="panel panel-default panel-block panel-title-block big-total">
                <div class="panel-body form-horizontal">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="labels text-bold">TOTAL</div>
                            <div class="values grand-total">PHP 0.00</div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="labels text-bold">AMOUNT DUE</div>
                            <div class="values amount-due">PHP 0.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SALE SETTINGS -->
            <div class="panel panel-default panel-block panel-title-block">
                <div class="panel-body form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">Price Level</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm price-level-select">
                                        <option {{ $current_level == 0 ? "selected" : "" }} value="0">No Price Level</option>
                                        @foreach($_price_level as $price_level)
                                        <option {{ $current_level == $price_level->price_level_id ? "selected" : "" }} value="{{ $price_level->price_level_id }}">{{ $price_level->price_level_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">Sales Person</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm">
                                        @if(count($_salesperson) > 0)
                                            @foreach($_salesperson as $sp)
                                            <option>{{ucwords($sp->user_first_name.' '.$sp->user_last_name)}}</option>
                                            @endforeach
                                        @else
                                        <option>No Sales Person Yet</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">Discount</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm cart-global-discount" type="text" placeholder="0.00" value="{{ isset($cart['info']->global_discount) ? $cart['info']->global_discount : '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">Shipping Fee</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm cart-shipping-fee" type="text" placeholder="0.00">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">VAT</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm">
                                        <option>NO-VAT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">Consume Item</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline"><input type="radio" onclick="toggle_destination('.warehouse-destination')"  name="consume_inventory" checked value="instant">Instant</label>
                                    <label class="radio-inline"><input type="radio" class="wis-click" onclick="toggle_destination('.warehouse-destination')"  name="consume_inventory" value="wis">WIS</label>
                                </div>
                            </div>
                            <div class="form-group warehouse-destination" style="display: none">
                                <label class="control-label col-sm-4 text-right" for="email">Warehouse Destination</label>
                                <div class="col-sm-8"> 
                                    <select class="form-control select-warehouse" name="destination_warehouse_id">
                                        @foreach($_warehouse as $warehouse)
                                            <option warehouse-address="{{$warehouse->warehouse_address}}" value="{{$warehouse->warehouse_id}}">{{$warehouse->warehouse_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 text-right" for="email">Payment Method</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/pos/pos.js"></script>
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/pos.css">
@endsection