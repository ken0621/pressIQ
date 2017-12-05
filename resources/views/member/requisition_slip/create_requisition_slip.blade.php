@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-archive"></i>
            <h1>
                <span class="page-title">CREATE - Requisition Slip</span>
            </h1>
            <div class="text-right">
                <a class="btn btn-custom-white panel-buttons" href="/member/item/warehouse/wis">Cancel</a>
                <button class="btn btn-primary panel-buttons save-button" type="button">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- <div class="panel panel-default panel-block panel-title-block">
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
</div> -->

<form class="global-submit form-to-submit-add" action="/member/item/warehouse/wis/create-submit" method="post">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
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
        <div class="form-group draggable-container">
            <div class="col-md-12">
                <div class="table">
                    <table class="digima-table table table-bordered table-condensed pos-table">
                        <thead>
                            <tr>
                                <th class="text-left" >ITEM SKU</th>
                                <th class="text-left" >ITEM DESCRIPTION</th>
                                <th class="text-center" width="100px">QTY</th>
                                <th class="text-center" width="100px">U/M</th>
                                <th class="text-center" width="150px">Rate</th>
                                <th class="text-center" width="150px">Amount</th>
                                <th class="text-center" width="200px">Vendor</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody class="draggable tbody-item">
                            <tr class="tr-draggable">
                                <td>
                                    <select class="form-control droplist-item input-sm select-item" name="item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="form-control txt-desc" name="item_description[]"></textarea></td>
                                <td class="text-center">
                                    <input type="text" class="form-control text-center txt-qty" name="item_quantity[]">
                                </td>
                                <td class="text-center">
                                    <select class="form-control droplist-item-um select-um" name="item_um[]"></select>
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control text-right txt-rate" name="item_rate[]">
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control text-right txt-amount" name="item_amount[]" value="0.00">
                                </td>
                                <td class="text-center">
                                    <select class="form-control droplist-vendor select-vendor" name="item_vendor[]">
                                        @include('member.load_ajax_data.load_vendor')
                                    </select>
                                </td>
                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                            </tr>
                           <tr class="tr-draggable">
                                <td>
                                    <select class="form-control droplist-item select-item input-sm" name="item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="form-control txt-desc" name="item_remarks[]"></textarea></td>
                                <td class="text-center">
                                    <input type="text" class="form-control text-center txt-qty" name="item_quantity[]">
                                </td>
                                <td class="text-center">
                                    <select class="form-control droplist-item-um select-um" name="item_um[]"></select>
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control text-right txt-rate" name="item_rate[]">
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control text-right txt-amount" name="item_amount[]" value="0.00">
                                </td>
                                <td class="text-center">
                                    <select class="form-control droplist-vendor select-vendor" name="item_vendor[]">
                                        @include('member.load_ajax_data.load_vendor')
                                    </select>
                                </td>
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
                <select class="form-control droplist-item select-item input-sm" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="form-control txt-desc" name="item_remarks[]"></textarea></td>
            <td class="text-center">
                <input type="text" class="form-control text-center txt-qty" name="item_quantity[]">
            </td>
            <td class="text-center">
                <select class="form-control select-um" name="item_um[]"></select>
            </td>
            <td class="text-center">
                <input type="text" class="form-control text-right txt-rate" name="item_rate[]">
            </td>
            <td class="text-center">
                <input type="text" class="form-control text-right txt-amount" name="item_amount[]" value="0.00">
            </td>
            <td class="text-center">
                <select class="form-control select-vendor" name="item_vendor[]">
                    @include('member.load_ajax_data.load_vendor')
                </select>
            </td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/vendor_requisition_slip.js"></script>
@endsection