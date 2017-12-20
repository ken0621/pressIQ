@extends('member.layout')
@section('content')
<form class="global-submit form-to-submit-transfer load-po-container" role="form" action="" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" class="button-action" name="button_action" value="">
    <input type="hidden" name="po_id" value="{{$po->po_id or ''}}" >
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
                    <select class="form-control">
                        <option>Save & Close</option>
                        <option>Save & Edit</option>
                        <option>Save & Print</option>
                        <option>Save & New</option>
                    </select>
                </div>
                <button class="panel-buttons btn btn-custom-white pull-right" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
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
                                <input type="text" class="form-control" name="reference_number" value="IA20171214-0002">
                            </div>
                        </div>
                    </div>    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
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
                                        @if(isset($po))
                                            @foreach($_poline as $poline)
                                                <tr class="tr-draggable">
                                                    <td class="invoice-number-td text-right">1</td>
                                                    <td>
                                                        <select class="form-control select-item droplist-item input-sm pull-left {{$poline->poline_item_id}}" name="poline_item_id[]" required>
                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $poline->poline_item_id])
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if($pis)
                                                            <label class="textarea-expand txt-desc" name="poline_description[]" value="{{$poline->poline_description}}"></label>
                                                        @else
                                                            <textarea class="textarea-expand txt-desc" name="poline_description[]" value="{{$poline->poline_description}}"></textarea>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select class="1111 droplist-um select-um {{isset($poline->poline_um) ? 'has-value' : ''}}" name="poline_um[]">
                                                            @if($poline->poline_um)
                                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $poline->multi_um_id, 'selected_um_id' => $poline->poline_um])
                                                            @else
                                                                <option class="hidden" value="" />
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><label class="text-center number-input txt-qty compute" type="text" name="actual_quantity" value="{{$poline->poline_qty}}"></label></td>
                                                    <td><input class="text-right txt-new-quantity compute" type="text" name="new_quantity[]" value="{{$poline->poline_discount}}" /></td>
                                                    <td><input class="text-right number-input txt-difference" type="text" name="difference[]"/></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" name="poline_rate[]" value="{{$poline->poline_rate}}" /></td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="poline_amount[]" value="{{$poline->poline_amount}}" /></td>
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                            @endforeach
                                        @else                                
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">1</td>                                                <td>
                                                    <select class="1111 form-control select-item droplist-item input-sm pull-left" name="poline_item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td>
                                                    @if($pis)
                                                        <label class="textarea-expand txt-desc" name="poline_description[]"></label>
                                                    @else
                                                        <textarea class="textarea-expand txt-desc" name="poline_description[]"></textarea>
                                                    @endif
                                                </td>

                                                <td><select class="2222 droplist-um select-um" name="poline_um[]"><option class="hidden" value="" /></select></td>
                                                <td><label class="text-center number-input txt-qty compute" type="text" name="actual_quantity"></label></td>
                                                <td><input class="text-right txt-new-quantity compute" type="text" name="new_quantity[]"/></td>
                                                <td><input class="text-right number-input txt-difference" type="text" name="difference[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="poline_rate[]"/></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="poline_amount[]"/></td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                                
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">2</td>
                                                <td>
                                                    <select class="22222 form-control select-item droplist-item input-sm pull-left" name="poline_item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td>
                                                    @if($pis)
                                                        <label class="textarea-expand txt-desc" name="poline_description[]"></label>
                                                    @else
                                                        <textarea class="textarea-expand txt-desc" name="poline_description[]"></textarea>
                                                    @endif
                                                </td>
                                                <td><select class="3333 droplist-um select-um" name="poline_um[]"><option class="hidden" value="" /></select></td>
                                                <td><label class="text-center number-input txt-qty compute" type="text" name="actual_quantity"></label></td>
                                                <td><input class="text-right txt-new-quantity compute" type="text" name="new_quantity[]"/></td>
                                                <td><input class="text-right number-input txt-difference" type="text" name="difference[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="poline_rate[]"/></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="poline_amount[]"/></td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Remarks</label>
                            <textarea class="form-control input-sm textarea-expand" name="po_message" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="po_memo" placeholder=""></textarea>
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
            <td class="invoice-number-td text-right">2</td>
            <td>
                <select class="form-control select-item input-sm pull-left" name="poline_item_id[]">
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td>
                @if($pis)
                    <label class="textarea-expand txt-desc" name="poline_description[]"></label>
                @else
                    <textarea class="textarea-expand txt-desc" name="poline_description[]"></textarea>
                @endif
            </td>

            <td><select class="select-um" name="poline_um[]"><option class="hidden" value="" /></select></td>
            <td><label class="text-center number-input txt-qty compute" type="text" name="actual_quantity"></label></td>
            <td><input class="text-right txt-new-quantity compute" type="text" name="new_quantity[]"/></td>
            <td><input class="text-right number-input txt-difference" type="text" name="difference[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="poline_rate[]"/></td>
            <td><input class="text-right number-input txt-amount" type="text" name="poline_amount[]"/></td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection


@section('script')
<script type="text/javascript" src="/assets/member/js/warehouse/inventory_adjustment.js"></script>
@endsection