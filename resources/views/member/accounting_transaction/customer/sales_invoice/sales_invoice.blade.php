@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
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
                <select class="form-control">
                    <option>Save & Close</option>
                    <option>Save & Edit</option>
                    <option>Save & Print</option>
                    <option>Save & New</option>
                </select>
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
                                <input type="text" class="form-control input-sm" name="new_invoice_id" value="SI20171214-0002">
                            </div>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select class="form-control droplist-customer input-sm pull-left" name="inv_customer_id" data-placeholder="Select a Customer" required>
                                    @include('member.load_ajax_data.load_customer', ['customer_id' => isset($inv) ? $inv->inv_customer_id : (isset($c_id) ? $c_id : '') ])
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-sm customer-email" name="inv_customer_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$inv->inv_customer_email or ''}}"/>
                            </div>
                        </div>
                    </div>                          
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Billing Address</label>
                            <textarea class="form-control input-sm textarea-expand customer-billing-address" name="inv_customer_billing_address" placeholder="">{{$inv->inv_customer_billing_address or ''}}</textarea>
                        </div>
                        <div class="col-sm-2">  
                            <label>Terms</label>
                            <select class="form-control input-sm droplist-terms" name="inv_terms_id">
                                @include("member.load_ajax_data.load_terms", ['terms_id' => isset($inv) ? $inv->inv_terms_id : ''])
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Invoice Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="inv_date" value="{{isset($inv) ? dateFormat($inv->inv_date) : date('m/d/y')}}"/>
                        </div>
                        <div class="col-sm-2">
                            <label>Due Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="inv_due_date" value="{{isset($inv) ? dateFormat($inv->inv_due_date) : date('m/d/y')}}" />
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
                                        <tr class="tr-draggable">
                                            <td class="invoice-number-td text-right">
                                                1
                                            </td>
                                            <td><input type="text" class="for-datepicker" name="invline_service_date[]"/></td>
                                            <td>
                                                <input type="hidden" name="invline_ref_name[]" value="">
                                                <input type="hidden" name="invline_ref_id[]" value="0">
                                                <select class="1111 form-control select-item droplist-item input-sm pull-left" name="invline_item_id[]" >
                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                    <option class="hidden" value="" />
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" name="invline_description[]"></textarea>
                                            </td>
                                            <td><select class="2222 droplist-um select-um" name="invline_um[]"><option class="hidden" value="" /></select></td>
                                            <td><input class="text-center number-input txt-qty compute" type="text" name="invline_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate compute" type="text" name="invline_rate[]"/></td>
                                            <td><input class="text-right txt-discount compute" type="text" name="invline_discount[]"/></td>
                                            <td><textarea class="textarea-expand" type="text" name="invline_discount_remark[]" ></textarea></td>
                                            <td><input class="text-right number-input txt-amount" type="text" name="invline_amount[]"/></td>
                                            <td class="text-center">
                                                <input type="hidden" class="invline_taxable" name="invline_taxable[]" value="" >
                                                <input type="checkbox" name="" class="taxable-check compute" value="checked">
                                            </td>
                                            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                        </tr>
                                        <tr class="tr-draggable">
                                            <td class="invoice-number-td text-right">
                                                2
                                            </td>
                                            <td><input type="text" class="for-datepicker" name="invline_service_date[]"/></td>
                                            <td>
                                                <input type="hidden" name="invline_ref_name[]" value="">
                                                <input type="hidden" name="invline_ref_id[]" value="0">
                                                <select class="1111 form-control select-item droplist-item input-sm pull-left" name="invline_item_id[]" >
                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                    <option class="hidden" value="" />
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" name="invline_description[]"></textarea>
                                            </td>
                                            <td><select class="2222 droplist-um select-um" name="invline_um[]"><option class="hidden" value="" /></select></td>
                                            <td><input class="text-center number-input txt-qty compute" type="text" name="invline_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate compute" type="text" name="invline_rate[]"/></td>
                                            <td><input class="text-right txt-discount compute" type="text" name="invline_discount[]"/></td>
                                            <td><textarea class="textarea-expand" type="text" name="invline_discount_remark[]" ></textarea></td>
                                            <td><input class="text-right number-input txt-amount" type="text" name="invline_amount[]"/></td>
                                            <td class="text-center">
                                                <input type="hidden" class="invline_taxable" name="invline_taxable[]" value="" >
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
                            <textarea class="form-control input-sm textarea-expand" name="inv_message" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="inv_memo" placeholder=""></textarea>
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
                                            <select class="form-control input-sm ewt-value compute" name="ewt">  
                                                <option value="0" {{isset($inv) ? $inv->ewt == 0 ? 'selected' : '' : ''}}></option>
                                                <option value="0.01" {{isset($inv) ? $inv->ewt == 0.01 ? 'selected' : '' : ''}}>1%</option>
                                                <option value="0.02" {{isset($inv) ? $inv->ewt == 0.02 ? 'selected' : '' : ''}}>2%</option>
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
                                            <select class="form-control input-sm compute discount_selection" name="inv_discount_type">  
                                                <option value="percent" {{isset($inv) ? $inv->inv_discount_type == 'percent' ? 'selected' : '' : ''}}>Discount percentage</option>
                                                <option value="value" {{isset($inv) ? $inv->inv_discount_type == 'value' ? 'selected' : '' : ''}}>Discount value</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2  padding-lr-1">
                                            <input class="form-control input-sm text-right number-input discount_txt compute" type="text" name="inv_discount_value" value="{{$inv->inv_discount_value or ''}}">
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
                                            <select class="form-control input-sm tax_selection compute" name="taxable">  
                                                <option value="0" {{isset($inv) ? $inv->taxable == 0 ? 'selected' : '' : ''}}>No Tax</option>
                                                <option value="1" {{isset($inv) ? $inv->taxable == 1 ? 'selected' : '' : ''}}>Vat (12%)</option>
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
                            @if(isset($inv))
                                <div class="row">
                                    <div class="col-md-7 text-right digima-table-label">
                                        Payment Appplied
                                    </div>
                                    <div class="col-md-5 text-right digima-table-value">
                                        <input type="hidden" name="payment-receive" class="payment-receive-input" />
                                        PHP&nbsp;<span class="payment-applied">{{$inv->inv_payment_applied}}</span>
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
<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-right">
                1
            </td>
            <td><input type="text" class="for-datepicker" name="invline_service_date[]"/></td>
            <td>
                <input type="hidden" name="invline_ref_name[]" value="">
                <input type="hidden" name="invline_ref_id[]" value="0">
                <select class="1111 form-control select-item input-sm pull-left" name="invline_item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td>
                <textarea class="textarea-expand txt-desc" name="invline_description[]"></textarea>
            </td>
            <td><select class="2222 select-um" name="invline_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="invline_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="invline_rate[]"/></td>
            <td><input class="text-right txt-discount compute" type="text" name="invline_discount[]"/></td>
            <td><textarea class="textarea-expand" type="text" name="invline_discount_remark[]" ></textarea></td>
            <td><input class="text-right number-input txt-amount" type="text" name="invline_amount[]"/></td>
            <td class="text-center">
                <input type="hidden" class="invline_taxable" name="invline_taxable[]" value="" >
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