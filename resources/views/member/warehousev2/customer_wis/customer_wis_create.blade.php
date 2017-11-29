@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-archive"></i>
            <h1>
                <span class="page-title">CREATE - Customer Warehouse Issuance Slip</span>
            </h1>
            <div class="text-right">
                <a class="btn btn-custom-white panel-buttons" href="/member/item/warehouse/wis">Cancel</a>
                <button class="btn btn-primary panel-buttons save-button" type="button">Save</button>
            </div>
        </div>
    </div>
</div>

<form class="global-submit form-to-submit-add" action="/member/item/warehouse/wis/create-submit" method="post">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-4">
                <label>Customer Name</label>
                <select required class="form-control select-warehouse" name="destination_customer_warehouse_id">
                    @foreach ($_customer as $customer)
                            <option value="{{ $customer->customer_id}}">{{$customer->first_name." ".$customer->middle_name." ".$customer->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>WIS Number</label>
                <input type="text" name="wis_number" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Ship to</label>
                <div>
                    <textarea class="form-control txt-warehouse-address" name="destination_customer_address"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <label>Remarks</label>
                <div>
                    <textarea class="form-control" name="wis_remarks"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group hide">
            <div class="col-md-12">
                <div class="load-item-table-pos-s"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="table">
                    <table class="digima-table table table-bordered table-condensed pos-table">
                        <thead>
                            <tr>
                                <th class="text-left" >ITEM SKU</th>
                                <th class="text-left" >ITEM DESCRIPTION</th>
                                <th class="text-center" width="180px">REMAINING QTY</th>
                                <th class="text-center" width="180px">ISSUED QUANTITY</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody class="draggable tbody-item">
                            <tr class="tr-draggable">
                                <td>
                                    <select class="form-control droplist-item input-sm" name="item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="form-control txt-desc" name="item_remarks[]"></textarea></td>
                                <td class="text-center"><label class="txt-remaining-qty"></label> </td>
                                <td><input class="form-control number-input" type="text" name="item_quantity[]"/></td>
                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                            </tr>
                            <tr class="tr-draggable">
                                <td>
                                    <select class="form-control droplist-item input-sm" name="item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="form-control txt-desc" name="item_remarks[]"></textarea></td>
                                <td class="text-center"><label class="txt-remaining-qty"></label> </td>
                                <td><input class="form-control number-input" type="text" name="item_quantity[]"/></td>
                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                            </tr>
                        </tbody>
                    </table>                    
                </div>                
            </div>            
        </div>
    </div>
</div>
</form>



<div class="div-script">
    <table class="div-item-row-script-item hide">
        <tr class="tr-draggable">
            <td>
                <select class="form-control select-item input-sm pull-left" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="textarea-expand txt-desc" name="item_remarks[]"></textarea></td>
            <td class="text-center"><label class="txt-remaining-qty"></label> </td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_quantity[]"/></td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/warehouse/customer_wis_create.js"></script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/pos.css">
@endsection