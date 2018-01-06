@extends('member.layout')
@section('content')
<form class="global-submit" action="{{$action or ''}}" method="post">
    <div class="panel panel-default panel-block panel-title-block">
        <input type="hidden" class="button-action" name="button_action" value="">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
        <div class="panel-heading">
            <div>
                <i class="fa fa-calendar"></i>
                <h1>
                <span class="page-title">{{$page or ''}}</span>
                <small>
                Insert Description Here
                </small>
                </h1>
                <div class="dropdown pull-right">
                    <div>
                        <a class="btn btn-custom-white" href="/member/transaction/sales_invoice">Cancel</a>
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

    <div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
        <div class="data-container" >
            <div class="tab-content">
                <div class="row">      
                    <div class="col-md-12" style="padding: 30px;">
                        <!-- START CONTENT -->
                        <div style="padding-bottom: 10px; margin-bottom: 10px;">
                            <div class="row clearfix">                        
                                <div class="col-sm-4">    
                                    <label >Reference Number</label>
                                    <input type="text" class="form-control input-sm" name="transaction_refnumber" value="{{isset($sales_invoice) ? $sales_invoice->transaction_refnum : $transaction_refnum}}">
                                </div>
                            </div>
                        </div>
                        <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <select class="form-control droplist-customer input-sm pull-left" name="customer_id" data-placeholder="Select a Customer" required>
                                        @include('member.load_ajax_data.load_customer', ['customer_id' => isset($sales_invoice) ? $sales_invoice->inv_customer_id : (isset($c_id) ? $c_id : '') ])
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm customer-email" name="customer_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$sales_invoice->inv_customer_email or ''}}"/>
                                </div>
                                <div class="col-sm-4 text-right open-transaction" style="display: none;">
                                    <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/sales_invoice/load_transaction?customer_id="><i class="fa fa-handshake-o"></i> <span class="count-open-transaction">0</span> Open Transaction</a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <label>Billing Address</label>
                                <textarea class="form-control input-sm textarea-expand customer-billing-address" name="customer_billing_address" placeholder="">{{$sales_invoice->inv_customer_billing_address or ''}}</textarea>
                            </div>
                            <div class="col-sm-2">  
                                <label>Terms</label>
                                <select class="form-control input-sm new droplist-terms" name="customer_terms">
                                    @include("member.load_ajax_data.load_terms", ['terms_id' => isset($sales_invoice) ? $sales_invoice->inv_terms_id : ''])
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Invoice Date</label>
                                <input type="text" class="datepicker form-control input-sm" name="transaction_date" value="{{isset($sales_invoice) ? dateFormat($sales_invoice->inv_date) : date('m/d/Y')}}"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Due Date</label>
                                <input type="text" class="datepicker form-control input-sm" name="transaction_duedate" value="{{isset($sales_invoice) ? dateFormat($sales_invoice->inv_due_date) : date('m/d/Y')}}" />
                            </div>
                        </div>
                        
                        <div class="row clearfix draggable-container">
                            <div class="table-responsive">
                                <div class="col-sm-12">
                                    <table class="digima-table">
                                        <thead>
                                            <tr>
                                                <th style="" class="text-right">#</th>
                                                <th style="">Service Date</th>
                                                <th style="width: 200px">Product/Service</th>
                                                <th style="">Description</th>
                                                <th style="">U/M</th>
                                                <th style="">Qty</th>
                                                <th style="">Rate</th>
                                                <th style="">Discount</th>
                                                <th style="">Remark</th>
                                                <th style="">Amount</th>
                                                <th style="">Tax</th>
                                                <th width="10"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="draggable tbody-item estimate-tbl">
                                            @if(isset($sales_invoice))
                                                @foreach($sales_invoice_item as $si_item)
                                                <tr class="tr-draggable">
                                                    <td class="invoice-number-td text-right">
                                                        1
                                                    </td>
                                                    <td><input type="text" class="for-datepicker" name="item_servicedate[]"/>{{$si_item->invline_service_date != '1970-01-01' ? $si_item->invline_service_date : ''}}</td>
                                                    <td>
                                                        <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $si_item->invline_item_id])
                                                            <option class="hidden" value="" />
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea class="textarea-expand txt-desc" name="item_description[]">{{$si_item->invline_description}}</textarea>
                                                    </td>
                                                    <td><select class="2222 droplist-um select-um {{isset($si_item->multi_id) ? 'has-value' : ''}}" name="item_um[]">
                                                            @if($si_item->invline_um)
                                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $si_item->multi_um_id, 'selected_um_id' => $si_item->invline_um])
                                                            @else
                                                                <option class="hidden" value="" />
                                                            @endif
                                                            <option class="hidden" value="" />
                                                        </select>
                                                    </td>
                                                    <td><input class="text-center number-input txt-qty compute" value="{{$si_item->invline_qty}}" type="text" name="item_qty[]"/></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" value="{{$si_item->invline_rate}}" name="item_rate[]"/></td>
                                                    <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"  value="{{$si_item->invline_discount}}"/></td>
                                                    <td><textarea class="textarea-expand" type="text" name="item_remarks[]">{{$si_item->invline_discount_remark}}</textarea></td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$si_item->invline_amount}}" /></td>
                                                    <td class="text-center">
                                                        <input type="hidden" class="invline_taxable" name="item_taxable[]" value="" >
                                                        <input type="checkbox" name="" class="taxable-check compute" {{$si_item->taxable == 1 ? 'checked' : ''}} value="checked">
                                                    </td>
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">
                                                    1
                                                </td>
                                                <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
                                                <td>
                                                    <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                                </td>
                                                <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
                                                <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                <td class="text-center">
                                                    <input type="hidden" class="invline_taxable" name="item_taxable[]" value="" >
                                                    <input type="checkbox" name="" class="taxable-check compute" value="checked">
                                                </td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">
                                                    2
                                                </td>
                                                <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
                                                <td>
                                                    <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                                </td>
                                                <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
                                                <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                <td class="text-center">
                                                    <input type="hidden" class="invline_taxable" name="item_taxable[]" value="" >
                                                    <input type="checkbox" name="" class="taxable-check compute" value="checked">
                                                </td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <label>Message Displayed on Invoice</label>
                                <textarea class="form-control input-sm textarea-expand" name="customer_message" placeholder="">{{isset($sales_invoice) ? $sales_invoice->inv_message : ''}}</textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Statement Memo</label>
                                <textarea class="form-control input-sm textarea-expand" name="customer_memo" placeholder="">{{isset($sales_invoice) ? $sales_invoice->inv_memo : ''}}</textarea>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-7 text-right digima-table-label">
                                        Sub Total
                                    </div>
                                    <div class="col-md-5 text-right digima-table-value">
                                        <input type="hidden" name="subtotal_price" class="subtotal-amount-input" />
                                        PHP&nbsp;<span class="sub-total">0.00</span>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-7 text-right digima-table-label">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3  padding-lr-1">
                                                <label>EWT</label>
                                            </div>
                                            <div class="col-sm-3  padding-lr-1">
                                                <!-- <input class="form-control input-sm text-right ewt_value number-input" type="text" name="ewt"> -->
                                                <select class="form-control input-sm ewt-value compute" name="customer_ewt">  
                                                    <option value="0" {{isset($sales_invoice) ? $sales_invoice->ewt == 0 ? 'selected' : '' : ''}}></option>
                                                    <option value="0.01" {{isset($sales_invoice) ? $sales_invoice->ewt == 0.01 ? 'selected' : '' : ''}}>1%</option>
                                                    <option value="0.02" {{isset($sales_invoice) ? $sales_invoice->ewt == 0.02 ? 'selected' : '' : ''}}>2%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-right digima-table-value">
                                        PHP&nbsp;<span class="ewt-total">0.00</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 text-right digima-table-label">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-4  padding-lr-1">
                                                <select class="form-control input-sm compute discount_selection" name="customer_discount">  
                                                    <option value="percent" {{isset($sales_invoice) ? $sales_invoice->inv_discount_type == 'percent' ? 'selected' : '' : ''}}>Discount percentage</option>
                                                    <option value="value" {{isset($sales_invoice) ? $sales_invoice->inv_discount_type == 'value' ? 'selected' : '' : ''}}>Discount value</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2  padding-lr-1">
                                                <input class="form-control input-sm text-right number-input discount_txt compute" type="text" name="customer_discounttype" value="{{$sales_invoice->inv_discount_value or ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-right digima-table-value">
                                        PHP&nbsp;<span class="discount-total">0.00</span>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-7 text-right digima-table-label">
                                        <div class="row">
                                            <div class="col-sm-4 col-sm-offset-8  padding-lr-1">
                                                <select class="form-control input-sm tax_selection compute" name="customer_tax">  
                                                    <option value="0" {{isset($sales_invoice) ? $sales_invoice->taxable == 0 ? 'selected' : '' : ''}}>No Tax</option>
                                                    <option value="1" {{isset($sales_invoice) ? $sales_invoice->taxable == 1 ? 'selected' : '' : ''}}>Vat (12%)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-right digima-table-value">
                                        PHP&nbsp;<span class="tax-total">0.00</span>
                                    </div>
                                </div> 
                                    <div class="row">
                                        <div class="col-md-7 text-right digima-table-label">
                                          Total
                                        </div>
                                        <div class="col-md-5 text-right digima-table-value total">
                                            <input type="hidden" name="overall_price" class="total-amount-input" />
                                            PHP&nbsp;<span class="total-amount">0.00</span>
                                        </div>
                                    </div>
                                @if(isset($sales_invoice))
                                    <div class="row">
                                        <div class="col-md-7 text-right digima-table-label">
                                            Payment Appplied
                                        </div>
                                        <div class="col-md-5 text-right digima-table-value">
                                            <input type="hidden" name="payment-receive" class="payment-receive-input" />
                                            PHP&nbsp;<span class="payment-applied">{{currency('',$sales_invoice->inv_payment_applied)}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 text-right digima-table-label total">
                                            Balance Due
                                        </div>
                                        <div class="col-md-5 text-right digima-table-value total">
                                            <input type="hidden" name="balance-due" class="balance-due-input" />
                                            PHP&nbsp;<span class="balance-due">0.00</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-right">
                1
            </td>
            <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
            <td>
                <select class="1111 form-control select-item input-sm pull-left" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td>
                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
            </td>
            <td><select class="2222 select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
            <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
            <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea></td>
            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
            <td class="text-center">
                <input type="hidden" class="invline_taxable" name="item_taxable[]" value="" >
                <input type="checkbox" name="" class="taxable-check compute" value="checked">
            </td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>     
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/accounting_transaction/customer/sales_invoice.js"></script>
@endsection