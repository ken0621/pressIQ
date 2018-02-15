@extends('member.layout')
@section('content')
<form class="global-submit" action="{{$action or ''}}" method="post">
    <div class="panel panel-default panel-block panel-title-block">
        <input type="hidden" class="button-action" name="button_action" value="">
        <input type="hidden" name="estimate_quotation_id" value="{{Request::input('id')}}">
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

    <div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
        <div class="data-container" >
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-12" style="padding: 30px;">
                        <!-- START CONTENT -->
                        <div style="padding-bottom: 10px; margin-bottom: 10px;">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <label>Reference Number</label>
                                    <input type="text" class="form-control" name="transaction_refnumber" value="{{isset($estimate_quotation) ? $estimate_quotation->transaction_refnum : $transaction_refnum}}">
                                </div>
                            </div>
                        </div>
                        <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <select class="form-control droplist-customer input-sm pull-left" name="customer_id" data-placeholder="Select a Customer" required>
                                        @include('member.load_ajax_data.load_customer', ['customer_id' => isset($estimate_quotation) ? $estimate_quotation->est_customer_id : (isset($c_id) ? $c_id : '') ]);
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm customer-email" name="customer_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$estimate_quotation->est_customer_email or ''}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <label>Billing Address</label>
                                <textarea class="form-control input-sm textarea-expand customer-billing-address" name="customer_address" placeholder="">{{$estimate_quotation->est_customer_billing_address or ''}}</textarea>
                            </div>
                            <div class="col-sm-2">
                                <label>Estimate Date</label>
                                <input type="text" class="datepicker form-control input-sm" name="transaction_date" value="{{$estimate_quotation->est_date or date('m/d/y')}}"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Expiration Date</label>
                                <input type="text" class="datepicker form-control input-sm" name="transaction_duedate" value="{{$estimate_quotation->est_exp_date or date('m/d/y')}}" />
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
                                        <tbody class="draggable tbody-item">   
                                            @if(isset($estimate_quotation))
                                                @foreach($estimate_quotation_item as $eq_item)
                                                <tr class="tr-draggable">
                                                    <td class="invoice-number-td text-right">1</td>
                                                    <td><input type="text" class="for-datepicker" name="item_servicedate[]"value="{{($eq_item->estline_service_date != '1970-01-01' ?  $eq_item->estline_service_date != '0000-00-00' ? dateFormat($eq_item->estline_service_date) : '' :'' )}}"/></td>
                                                    <td>
                                                        <select class="form-control droplist-item select-item input-sm pull-left" name="item_id[]" >
                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $eq_item->estline_item_id])
                                                            <option class="hidden" value="" />
                                                        </select>
                                                    </td>
                                                    <td><textarea class="textarea-expand txt-desc" name="item_description[]">{{$eq_item->estline_description}}</textarea></td>
                                                    <td>
                                                        <select class="droplist-um select-um {{isset($eq_item->multi_id) ? 'has-value' : ''}}" name="item_um[]">
                                                          @if($eq_item->invline_um)
                                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $eq_item->multi_um_id, 'selected_um_id' => $eq_item->estline_um])
                                                            @else
                                                                <option class="hidden" value="" />
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]" value="{{$eq_item->estline_qty}}" /></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]" value="{{$eq_item->estline_rate}}"/></td>
                                                    <td><input class="text-right txt-discount compute" type="text" name="item_discount[]" value="{{$eq_item->estline_discount}}{{$eq_item->estline_discount_type != 'fixed' ? '%' : ''}}"/></td>
                                                    <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea> {{$eq_item->estline_discount_remark}}</td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$eq_item->estline_amount}}"/></td>
                                                    <td class="text-center">
                                                        <input type="checkbox"  name="item_taxable[]" class="taxable-check compute" value="1" {{$eq_item->taxable == 1 ? 'checked' : ''}}>
                                                    </td>
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">1</td>
                                                <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
                                                <td>
                                                    <select class="form-control droplist-item select-item input-sm pull-left" name="item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
                                                <td><select class="droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
                                                <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="item_taxable[]" class="taxable-check compute" value="1">
                                                </td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                                
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">2</td>
                                                <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
                                                <td>
                                                    <select class="form-control droplist-item select-item input-sm pull-left" name="item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
                                                <td><select class="droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
                                                <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                <td class="text-center">
                                                   <input type="checkbox" name="item_taxable[]" class="taxable-check compute" value="1">
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
                                <label>Message Displayed on Estimate</label>
                                <textarea class="form-control input-sm textarea-expand" name="customer_message" placeholder="">{{$estimate_quotation->est_message or ''}}</textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Statement Memo</label>
                                <textarea class="form-control input-sm textarea-expand" name="customer_memo" placeholder="">{{$estimate_quotation->est_memo or ''}}</textarea>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-right">1</td>
            <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
            <td>
                <select class="form-control select-item input-sm pull-left" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
            <td><select class=" select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
            <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
            <td><textarea class="textarea-expand" type="text" name="item_remarks[]" ></textarea></td>
            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
            <td class="text-center">
               <input type="checkbox" name="item_taxable[]" class="taxable-check compute" value="1">
            </td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>                                            
    </table>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/accounting_transaction/customer/estimate_quotation.js"></script>
@endsection