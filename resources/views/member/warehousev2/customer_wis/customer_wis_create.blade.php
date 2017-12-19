@extends('member.layout')
@section('content')

<form class="global-submit form-to-submit-add" action="/member/customer/wis/create-submit" method="post">
        <input type="hidden" class="button-action" name="button_action" value="">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-archive"></i>
            <h1>
                <span class="page-title">CREATE - Customer Warehouse Issuance Slip</span>
            </h1>
            <div class="dropdown pull-right">
                <div>
                    <a class="btn btn-custom-white" href="/member/transaction/estimate_quotation">Cancel</a>
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

<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-4">
                <label>WIS Number</label>
                <input type="text" name="cust_wis_number" class="form-control" required value="WIS20171219-0002">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label>Customer Name</label>
                <select class="form-control droplist-customer input-sm pull-left" name="customer_id" data-placeholder="Select a Customer" required>
                    @include('member.load_ajax_data.load_customer', ['customer_id' => isset($est) ? $est->customer_id : (isset($c_id) ? $c_id : '') ]);
                </select>
            </div>
            <div class="col-md-4">
                <label>Delivery Date</label>
                <input type="text" name="delivery_date" class="form-control" value="{{ date('m/d/Y') }}">
            </div>
            <div class="col-md-6">
                <label>Ship to</label>
                <div>
                    <textarea required class="form-control" name="customer_address"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <label>Remarks</label>
                <div>
                    <textarea required class="form-control" name="cust_wis_remarks"></textarea>
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
                                <th class="text-center" >#</th>
                                <th class="text-left" >ITEM</th>
                                <th class="text-left" >ITEM DESCRIPTION</th>
                                <th class="text-center" width="180px">REMAINING QTY</th>
                                <th class="text-center" width="180px">ISSUED QUANTITY</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody class="draggable tbody-item">
                            <tr class="tr-draggable">
                                <td class="invoice-number-td text-center">1</td>
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
                                <td class="invoice-number-td text-center">2</td>
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
            <td class="invoice-number-td text-center">3</td>
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