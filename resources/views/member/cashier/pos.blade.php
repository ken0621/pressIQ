@extends('member.layout')
@section('content')
<input class="token" type="hidden" name="_token" value="{{ csrf_token() }}">
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
                <a class="btn btn-primary panel-buttons"><i class="fa fa-star"></i> Process Sale</a>
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
        <div class="panel panel-default panel-block panel-title-block">
            <div class="panel-body form-horizontal">
                @if(!isset($exist))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                              <span style="background-color: #eee" class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                              <input type="text" class="form-control" placeholder="Enter Customer Name" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row" style="padding-bottom: 15px;">
                        <div class="col-md-4 avatar-container">
                            <img class="cashier-avatar" src="/assets/member/images/user.png">
                        </div>
                        <div class="col-md-8">
                            <div class="customer-name text-bold">EL CHARRO FOOD, INC.</div>
                            <div class="customer-name">
                                <div class="row">
                                    <div class="col-md-5">Customer</div>
                                    <div class="col-md-7">1235</div>
                                </div>
                                <div class="customer-name">
                                    <div class="row">
                                        <div class="col-md-5">Phone</div>
                                        <div class="col-md-7">(63) 916 0456</div>
                                    </div>
                                </div>
                                <div class="customer-name">
                                    <div class="row">
                                        <div class="col-md-5">Balance</div>
                                        <div class="col-md-7">PHP 1,250.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pos-customer-action-button text-center">
                        <div class="col-md-6">
                            <a class="btn btn-custom-white full-width"><i class="fa fa-edit"></i> Update Customer</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-custom-white full-width"><i class="fa fa-close"></i> Detach</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

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
                                    <option>Guillermo Tabligan</option>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/pos/pos.js"></script>
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/pos.css">
@endsection