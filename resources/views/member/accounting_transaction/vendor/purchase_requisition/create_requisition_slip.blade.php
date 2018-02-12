@extends('member.layout')
@section('content')

<form class="global-submit" role="form" action="{{$action}}" method="POST">
<input type="hidden" class="button-action" name="button_action" value="">
<input type="hidden" name="pr_id" value="{{$pr->requisition_slip_id or ''}}">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-archive"></i>
            <h1>
                <span class="page-title">CREATE - Requisition Slip</span>
            </h1>
            <div class="dropdown pull-right">
                <div>
                    <a class="btn btn-custom-white" href="/member/transaction/purchase_requisition">Cancel</a>
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

<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <label>Requisition Slip Number</label>
                <div>
                   <input type="text" class="form-control" name="requisition_slip_number" value="{{ isset($pr->transaction_refnum)? $pr->transaction_refnum : $transaction_refnum}}">
                </div>
            </div>
            <div class="col-sm-3 text-right"></div>
            <div class="col-sm-3 text-right">
                <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/purchase_requisition/load-transaction"><i class="fa fa-handshake-o"></i> {{$count_transaction or ''}} Open Transaction</a></h4>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Remarks</label>
                <div>
                    <textarea class="form-control" name="requisition_slip_remarks">{{isset($pr->requisition_slip_remarks) ? $pr->requisition_slip_remarks : ''}}</textarea>
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
                    <table class="digima-table">
                        <thead>
                            <tr>
                                <th style="width: 15px;">#</th>
                                <th class="text-left" width="250px">ITEM SKU</th>
                                <th class="text-left" >ITEM DESCRIPTION</th>
                                <th class="text-center" width="100px">QTY</th>
                                <th class="text-center" width="100px">U/M</th>
                                <th class="text-center" width="150px">Rate</th>
                                <th class="text-center" width="150px">Amount</th>
                                <th class="text-center" width="300px">Vendor</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody class="applied-transaction-list">
                        </tbody>
                        <tbody class="draggable tbody-item">
                            @if(isset($_prline))
                                @foreach($_prline as $prline)
                                <tr class="tr-draggable">
                                    <input type="hidden" name="item_ref_name[]" value="{{$prline->rs_item_refname}}"></td>
                                            <input type="hidden" name="item_ref_id[]" value="{{$prline->rs_item_refid}}"></td>
                                    <td class="invoice-number-td text-center">1</td>
                                    <td>
                                        <select class="form-control droplist-item input-sm select-item" name="rs_item_id[]" >
                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $prline->rs_item_id])
                                            <option class="hidden" value="" />
                                        </select>
                                    </td>
                                    <td><textarea class="textarea-expand txt-desc" name="rs_item_description[]" readonly="true">{{$prline->rs_item_description}}</textarea></td>
                                    <td><input class="text-center number-input txt-qty compute" type="text" name="rs_item_qty[]" value="{{$prline->rs_item_qty}}" /></td>
                                    <td><select class="droplist-item-um select-um {{isset($poline->rs_item_um) ? 'has-value' : ''}}" name="rs_item_um[]">
                                            @if($prline->rs_item_um)
                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $prline->multi_um_id, 'selected_um_id' => $prline->rs_item_um])
                                            @else
                                                <option class="hidden" value="" />
                                            @endif
                                        </select>
                                    </td>
                                    <td><input class="text-right number-input txt-rate compute" type="text" name="rs_item_rate[]" value="{{$prline->rs_item_rate}}" /></td>
                                    <td><input class="text-right number-input txt-amount" type="text" name="rs_item_amount[]" value="{{$prline->rs_item_amount}}"/></td>
                                    <td>
                                        <select class="droplist-vendor select-vendor" name="rs_vendor_id[]">
                                            @include('member.load_ajax_data.load_vendor', ['vendor_id' => $prline->vendor_id])
                                        </select>
                                    </td>
                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                </tr>
                                @endforeach
                            @endif
                            <tr class="tr-draggable">
                                <input type="hidden" name="item_ref_name[]"></td>
                                        <input type="hidden" name="item_ref_id[]"></td>
                                <td class="invoice-number-td text-center">1</td>
                                <td>
                                    <select class="form-control droplist-item input-sm select-item" name="rs_item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="textarea-expand txt-desc" name="rs_item_description[]" readonly="true"></textarea></td>
                                <td><input class="text-center number-input txt-qty compute" type="text" name="rs_item_qty[]" /></td>
                                <td><select class="droplist-item-um select-um" name="rs_item_um[]"></select></td>
                                <td><input class="text-right number-input txt-rate compute" type="text" name="rs_item_rate[]" /></td>
                                <td><input class="text-right number-input txt-amount" type="text" name="rs_item_amount[]"/></td>
                                <td>
                                    <select class="droplist-vendor select-vendor" name="rs_vendor_id[]">
                                        @include('member.load_ajax_data.load_vendor')
                                    </select>
                                </td>
                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                            </tr>
                            <tr class="tr-draggable">
                                <input type="hidden" name="item_ref_name[]"></td>
                                        <input type="hidden" name="item_ref_id[]"></td>
                                <td class="invoice-number-td text-center">2</td>
                                <td>
                                    <select class="form-control droplist-item input-sm select-item" name="rs_item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="textarea-expand txt-desc" name="rs_item_description[]" readonly="true"></textarea></td>
                                <td><input class="text-center number-input txt-qty compute" type="text" name="rs_item_qty[]" /></td>
                                <td><select class="droplist-item-um select-um" name="rs_item_um[]"></select></td>
                                <td><input class="text-right number-input txt-rate compute" type="text" name="rs_item_rate[]" /></td>
                                <td><input class="text-right number-input txt-amount" type="text" name="rs_item_amount[]"/></td>
                                <td>
                                    <select class="droplist-vendor select-vendor" name="rs_vendor_id[]">
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
        <div class="row clearfix">
            <div class="col-sm-6">
                <label>Remarks</label>
                <textarea class="form-control input-sm textarea-expand remarks-pr" name="vendor_memo" >{{isset($pr->requisition_slip_memo)? $pr->requisition_slip_memo : ''}}</textarea>
            </div>
            <div class="col-sm-6">                      
                <div class="row">
                    <div class="col-md-7 text-right digima-table-label">
                        Total
                    </div>
                    <div class="col-md-5 text-right digima-table-value total">
                       <input type="hidden" name="bill_total_amount" class="total-amount-input" />
                            PHP&nbsp;<span class="total-amount">0.00</span>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
</form>



<div class="div-script">
    <table class="div-item-row-script-item hide">
       <tr class="tr-draggable">
            <input type="hidden" name="item_ref_name[]"></td>
                    <input type="hidden" name="item_ref_id[]"></td>
            <td class="invoice-number-td text-center">2</td>
            <td>
                <select class="form-control droplist-item input-sm select-item" name="rs_item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="textarea-expand txt-desc" name="rs_item_description[]" readonly="true"></textarea></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="rs_item_qty[]" /></td>
            <td><select class="droplist-item-um select-um" name="rs_item_um[]"></select></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="rs_item_rate[]" /></td>
            <td><input class="text-right number-input txt-amount" type="text" name="rs_item_amount[]"/></td>
            <td>
                <select class="droplist-vendor select-vendor" name="rs_vendor_id[]">
                    @include('member.load_ajax_data.load_vendor')
                </select>
            </td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection

@section('script')
<!-- <script type="text/javascript" src="/assets/member/js/accounting_transaction/vendor/purchase_requisition.js"></script> -->
<script type="text/javascript" src="/assets/member/js/accounting_transaction/vendor/vendor_requisition_slip.js"></script>
@endsection