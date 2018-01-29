@extends('member.layout')
@section('content')
<form class="global-submit form-to-submit-transfer load-po-container" role="form" action="{{$action or ''}}" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" class="button-action" name="button_action" value="">
    <input type="hidden" name="adj_id" value="{{Request::input('id')}}" >
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">{{ $page }}</span>
                    <small>
                    
                    </small>
                </h1>

                <div class="dropdown pull-right">
                    <div>
                        <a class="btn btn-custom-white" href="/member/item/warehouse/inventory_adjustment">Cancel</a>
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Action
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu  dropdown-menu-custom">
                          <li><a class="select-action" code="sclose">Save & Close</a></li>
                          <li><a class="select-action" code="sedit">Save & Edit</a></li>
                          <li><a class="select-action" code="sprint">Save & Print</a></li>
                          <li><a class="select-action" code="snew">Save & New</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-block panel-title-block panel-gray">
       <!--  <ul class="nav nav-tabs">
            <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#pending-codes"><i class="fa fa-star"></i> Invoice Information</a></li>
            <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#used-codes"><i class="fa fa-list"></i> Activities</a></li>
        </ul> -->
        <div class="tab-content">
            <div class="row">
                <div class="col-md-12" style="padding: 30px;">
                    <!-- START CONTENT -->
                    <div style="padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <label>Reference Number</label>
                                <input type="text" class="form-control" name="transaction_refnum" value="{{isset($adj->transaction_refnum) ? $adj->transaction_refnum : $transaction_refnum}}">
                            </div>
                        </div>
                         <div class="row clearfix">
                            <div class="col-sm-4">
                                <label>Warehouse</label>
                                <select class="form-control droplist-warehouse" name="adj_warehouse_id">
                                    @if(count($_warehouse) > 0)
                                        @foreach($_warehouse as $warehouse)
                                            <option indent="{{$warehouse->warehouse_level}}"  value="{{$warehouse->warehouse_id}}" {{isset($adj->adj_warehouse_id) ? ($adj->adj_warehouse_id == $warehouse->warehouse_id ? 'selected' : '') : '' }}>{{$warehouse->warehouse_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Date</label>
                                <input type="text" class="datepicker form-control" name="adj_created" value="{{date('m/d/Y')}}">
                            </div>
                        </div>
                    </div>    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 15px;">#</th>
                                            <th class="text-center" style="width: 180px;">Product/Service</th>
                                            <th>Description</th>
                                            <th class="text-center" style="width: 70px;">U/M</th>
                                            <th class="text-center" style="width: 100px;">Actual Qty</th>
                                            <th class="text-center" style="width: 100px;">New Qty</th>
                                            <th class="text-center" style="width: 100px;">Difference</th>
                                            <th class="text-center" style="width: 150px;">Rate</th>
                                            <th class="text-center" style="width: 200px;">Amount</th>
                                            <!-- <th style="width: 100px;">Discount</th>
                                            <th style="width: 100px;">Remark</th> 
                                            <th style="width: 100px;">Amount</th>
                                            <th style="width: 10px;">Tax</th>-->
                                            <th width="10"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="draggable tbody-item">
                                        @if(isset($adj))
                                            @foreach($_adj_line as $adjline)
                                                <tr class="tr-draggable">
                                                    <td class="invoice-number-td text-right">1</td><td>
                                                        <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $adjline->itemline_item_id])
                                                            <option class="hidden" value="" />
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea class="textarea-expand txt-desc" name="item_description[]">{{$adjline->itemline_item_description}}</textarea>
                                                    </td>

                                                    <td>
                                                        <select class="2222 droplist-um select-um {{isset($si_item->multi_id) ? 'has-value' : ''}}" name="item_um[]">
                                                            @if($adjline->invline_um)
                                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $adjline->multi_um_id, 'selected_um_id' => $adjline->itemline_item_um])
                                                            @else
                                                                <option class="hidden" value="" />
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input class="text-center number-input txt-qty compute" type="text" name="item_actual_qty[]" value="{{$adjline->itemline_actual_qty}}" /></td>
                                                    <td><input class="text-center txt-new-quantity compute" type="text" name="item_new_qty[]" value="{{$adjline->itemline_new_qty}}"/></td>
                                                    <td><input class="text-center number-input txt-difference" type="text" name="item_diff_qty[]"/></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]" value="{{$adjline->itemline_rate}}" /></td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$adjline->itemline_amount}}" /></td>
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr class="tr-draggable">
                                            <td class="invoice-number-td text-right">1</td><td>
                                                <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                    <option class="hidden" value="" />
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                            </td>

                                            <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                            <td><input class="text-center number-input txt-qty compute" type="text" name="item_actual_qty[]"/></td>
                                            <td><input class="text-center txt-new-quantity compute" type="text" name="item_new_qty[]"/></td>
                                            <td><input class="text-center number-input txt-difference" type="text" name="item_diff_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                        </tr>
                                        <tr class="tr-draggable">
                                            <td class="invoice-number-td text-right">2</td><td>
                                                <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                    <option class="hidden" value="" />
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                            </td>

                                            <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                            <td><input class="text-center number-input txt-qty compute" type="text" name="item_actual_qty[]"/></td>
                                            <td><input class="text-center txt-new-quantity compute" type="text" name="item_new_qty[]"/></td>
                                            <td><input class="text-center number-input txt-difference" type="text" name="item_diff_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Remarks</label>
                            <textarea class="form-control input-sm textarea-expand" name="adjustment_remarks" placeholder="">{{$adj->adjustment_remarks or ''}}</textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="adjustment_memo" placeholder="">{{$adj->adjustment_memo or ''}}</textarea>
                        </div>
                        <div class="col-sm-6">
                           <!--  <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    Sub Total
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    <input type="hidden" name="subtotal_price" class="subtotal-amount-input" />
                                    PHP&nbsp;<span class="sub-total">0.00</span>
                                </div>
                            </div>  -->
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                  Total
                                </div>
                                <div class="col-md-5 text-right digima-table-value total">
                                    <input type="hidden" name="overall_price" class="total-amount-input" />
                                    PHP&nbsp;<span class="total-amount">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT -->
                </div>
            </div>
        </div>
    </div>
</form>
<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-right">1</td><td>
                <select class="1111 form-control select-item input-sm pull-left" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td>
                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
            </td>
            <td><select class="2222 select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_actual_qty[]"/></td>
            <td><input class="text-center txt-new-quantity compute" type="text" name="item_new_qty[]"/></td>
            <td><input class="text-center number-input txt-difference" type="text" name="item_diff_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection


@section('script')
<script type="text/javascript" src="/assets/member/js/warehouse/inventory_adjustment.js"></script>
@endsection