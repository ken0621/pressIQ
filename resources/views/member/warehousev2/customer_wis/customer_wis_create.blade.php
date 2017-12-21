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
                <select class="form-control droplist-customer input-sm pull-left" name="customer_id" data-placeholder="Select a Customer" required>
                    @include('member.load_ajax_data.load_customer', ['customer_id' => isset($est) ? $est->customer_id : (isset($c_id) ? $c_id : '') ]);
                </select>
            </div>
            <div class="col-md-4">
                 <input type="text" class="form-control input-sm customer-email" name="customer_email" placeholder="E-Mail (Separate E-Mails with comma)"/>
            </div>
            <div class="col-sm-4 text-right open-transaction" style="display: none;">
                <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/sales_invoice/load_transaction?customer_id="><i class="fa fa-handshake-o"></i> <span class="count-open-transaction">0</span> Open Transaction</a></h4>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label>Ship to</label>
                <div>
                    <textarea required class="form-control customer-billing-address" name="customer_address"></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <label>Delivery Date</label>
                <input type="text" name="delivery_date" class="form-control" value="{{ date('m/d/Y') }}">
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
                                <th style="" class="text-right">#</th>
                                <th style="width: 200px">Product</th>
                                <th style="">Description</th>
                                <th style="">U/M</th>
                                <th style="">Qty</th>
                                <th style="">Rate</th>
                                <th style="">Amount</th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        <tbody class="draggable tbody-item">
                            <tr class="tr-draggable">
                                <td class="invoice-number-td text-center">1</td>
                                <td>
                                    <select class="form-control droplist-item select-item input-sm" name="item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="form-control txt-desc" name="item_description[]"></textarea></td>
                                <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                <td><input class="form-control number-input txt-qty text-center compute" type="text" name="item_qty[]"/></td>
                                <td><input class="text-right number-input txt-rate" type="text" name="item_rate[]"/></td>
                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                            </tr>
                            <tr class="tr-draggable">
                                <td class="invoice-number-td text-center">2</td>
                                <td>
                                    <select class="form-control droplist-item select-item input-sm" name="item_id[]" >
                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                        <option class="hidden" value="" />
                                    </select>
                                </td>
                                <td><textarea class="form-control txt-desc" name="item_remarks[]"></textarea></td>
                                <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                <td><input class="form-control number-input txt-qty text-center compute" type="text" name="item_quantity[]"/></td>
                                <td><input class="text-right number-input txt-rate" type="text" name="item_rate[]"/></td>
                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                            </tr>
                        </tbody>
                    </table>                    
                </div>                
            </div>            
        </div>

        <div class="row clearfix">
            <div class="col-md-6">
                <label>Remarks</label>
                <div>
                    <textarea required class="form-control" name="cust_wis_remarks"></textarea>
                </div>
            </div>
            <div class="col-md-6">
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
    </div>
</div>
</form>



<div class="div-script">
    <table class="div-item-row-script-item hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-center">2</td>
            <td>
                <select class="form-control select-item input-sm" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="form-control txt-desc" name="item_remarks[]"></textarea></td>
            <td><select class="2222 select-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="form-control number-input txt-qty text-center compute" type="text" name="item_quantity[]"/></td>
            <td><input class="text-right number-input txt-rate" type="text" name="item_rate[]"/></td>
            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/warehouse/customer_wis_create.js"></script>
@endsection