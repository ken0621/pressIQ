@extends('member.layout')
@section('content')
<form class="global-submit form-to-submit-transfer" role="form" action="{{$action}}" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" name="ec_order_id" value="{{$ec_order_id or ''}}" >
    <input type="hidden" name="invoice_id" class="invoice_id_container" value="{{Request::input('id')}}" >
    <input type="hidden" class="check_if_view" value="{{isset($inv) ? '1' : ''}}" >
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">{{isset($inv) ? 'View Order #'.$inv->ec_order_id : 'Create Order'}}</span>
                    <small>
                    
                    </small>
                </h1>
                <button type="submit" class="panel-buttons btn btn-custom-primary pull-right">Save and Send</button>
                <a href="/member/ecommerce/product_order" class="panel-buttons btn btn-default pull-right btn-custom-white">&laquo; Back</a>
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
                <div class="col-md-12" style="padding: 10px 30px;">
                    <div class="row" style="margin-bottom: 10px">
                        
                        <div class="col-sm-12">
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                <label class="btn order_status_btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'Pending' ? 'active' : '' : 'active'}}">
                                <input type="radio" name="order_status" id="option1" value="Pending" {{isset($inv) ? $inv->order_status == 'Pending' ? 'checked' : '' : 'checked'}}> Pending Payment
                                </label>
                                <label class="btn order_status_btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'Failed' ? 'active' : '' : ''}}">
                                <input type="radio" name="order_status" id="option2" value="Failed" {{isset($inv) ? $inv->order_status == 'Failed' ? 'checked' : '' : ''}}> Failed
                                </label>
                                <label class="btn order_status_btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'Processing' ? 'active' : '' : ''}}">
                                <input type="radio" name="order_status" id="option3" value="Processing" {{isset($inv) ? $inv->order_status == 'Processing' ? 'checked' : '' : ''}}"> Processing
                                </label>
                                <label class="btn order_status_btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'Completed' ? 'active' : '' : ''}}">
                                <input type="radio" name="order_status" id="option4" value="Completed" {{isset($inv) ? $inv->order_status == 'Completed' ? 'checked' : '' : ''}}"> Completed
                                </label>
                                <label class="btn order_status_btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'On-Hold' ? 'active' : '' : ''}}">
                                <input type="radio" name="order_status" id="option5" value="On-hold" {{isset($inv) ? $inv->order_status == 'On-Hold' ? 'checked' : '' : ''}}"> On-Hold
                                </label>
                                <label class="btn order_status_btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'Cancelled' ? 'active' : '' : ''}}">
                                <input type="radio" name="order_status" id="option6" value="Cancelled" {{isset($inv) ? $inv->order_status == 'Cancelled' ? 'checked' : '' : ''}}"> Cancelled
                                </label>
                                <!-- <label class="btn btn-custom-white btn-large {{isset($inv) ? $inv->order_status == 'Refunded' ? 'active' : '' : ''}}">
                                <input type="radio" name="order_status" id="option3" value="Void"> Refunded
                                </label> -->
                            </div> 
                        </div>
                        
                    </div>  

                    <!-- START CONTENT -->
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select {{isset($inv) ? 'disabled' : ''}} class="form-control {{isset($inv) ? '' : 'droplist-customer'}}  input-sm pull-left" name="inv_customer_id" data-placeholder="Select a Customer" required>
                                    @include('member.load_ajax_data.load_customer', ['customer_id' => isset($inv->customer_id) ? $inv->customer_id : '']);
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input {{isset($inv) ? 'disabled' : ''}} type="text" class="form-control input-sm customer-email" name="inv_customer_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$inv->customer_email or ''}}"/>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row clearfix">
                        <div class="col-sm-4">  
                            <label>Order Status</label>
                            <select class="form-control" name="order_status">
                            <option value="Unpaid" {{isset($inv) ? $inv->order_status == "Unpaid" ? 'selected' : '' : ''}}> Unpaid </option>
                            <option value="Paid" {{isset($inv) ? $inv->order_status == "Paid" ? 'selected' : '' : ''}}> Paid </option>
                            <option value="Void" {{isset($inv) ? $inv->order_status == "Void" ? 'selected' : '' : ''}}> Void </option>
                            </select>
                        </div>
                    </div>` -->
                    
                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <label>Billing Address</label>
                            <textarea {{isset($inv) ? 'disabled' : ''}} class="form-control input-sm textarea-expand" name="inv_customer_billing_address" placeholder="">{{$inv->billing_address or ''}}</textarea>
                        </div>
                        <div class="col-sm-1">  
                            <label>Terms</label>
                            <select {{isset($inv) ? 'disabled' : ''}} class="form-control input-sm" name="inv_terms_id">
                                <option value="1" {{isset($inv) ? $inv->term_id == 1 ? 'selected' : '' : ''}}>Net 10</option>
                                <option value="2" {{isset($inv) ? $inv->term_id == 2 ? 'selected' : '' : ''}}>Net 30</option>
                            </select>
                        </div>
                        <div class="col-sm-2">  
                            <label>Payment Method</label>
                            <select class="form-control input-sm drop-down-payment" name="payment_method_id">
                                @include("member.load_ajax_data.load_payment_method", ['payment_method_id' => isset($inv) ? $inv->payment_method_id : ''])
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Invoice Date</label>
                            <input {{isset($inv) ? 'disabled' : ''}} type="text" class="datepicker form-control input-sm" name="inv_date" value="{{isset($inv) ? date('m/d/Y',strtotime($inv->invoice_date)) : ''}}"/>
                        </div>
                        <div class="col-sm-2">
                            <label>Due Date</label>
                            <input {{isset($inv) ? 'disabled' : ''}} type="text" class="datepicker form-control input-sm" name="inv_due_date" value="{{isset($inv) ? date('m/d/Y',strtotime($inv->due_date)) : ''}}" />
                        </div>
                    </div>
                    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 10px;" ></th>
                                            <th style="width: 120px;">Service Date</th>
                                            <th style="width: 15px;" class="text-right">#</th>
                                            <th>Product/Service</th>
                                            <th>Description</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 100px;">Rate</th>
                                            <th style="width: 100px;">Discount</th>
                                            <th style="width: 100px;">Remark</th>
                                            <th style="width: 100px;">Amount</th>
                                            <th style="width: 10px;">Tax</th>
                                            <th width="10"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="draggable tbody-item">     
                                        @if(isset($inv))
                                            @foreach($_invline as $invline)
                                                <tr class="tr-draggable">
                                                    <td class="text-center cursor-move move"><i class="fa fa-th-large colo-mid-dark-gray"></i></td>

                                                    <td><input disabled type="text" class="for-datepicker" name="invline_service_date[]" value="{{date('m/d/Y',strtotime($invline->service_date))}}" /></td>

                                                    <td class="invoice-number-td text-right">1</td>
                                                    <td>
                                                        <select disabled class="form-control select-item input-sm pull-left {{$invline->item_id}}" name="invline_item_id[]" required>
                                                            @include("member.load_ajax_data.load_product_category", ['add_search' => "", 'variant_id' => $invline->item_id])
                                                        </select>
                                                    </td>
                                                    <td><textarea disabled class="textarea-expand txt-desc" name="invline_description[]">{{$invline->description}}</textarea></td>
                                                    <td><input disabled class="text-center number-input txt-qty compute" type="text" name="invline_qty[]" value="{{$invline->quantity}}" /></td>
                                                    <td><input disabled class="text-right number-input txt-rate compute" type="text" name="invline_rate[]" value="{{$invline->price}}" /></td>
                                                    <td><input disabled class="text-right txt-discount compute" type="text" name="invline_discount[]" value="{{$invline->discount_amount}}" /></td>
                                                    <td><textarea disabled class="textarea-expand" type="text" name="invline_discount_remark[]" value="{{$invline->remark}}"></textarea></td>
                                                    <td><input disabled class="text-right number-input txt-amount" type="text" name="invline_amount[]" value="{{$invline->total}}" /></td>
                                                    <td class="text-center">
                                                        <input disabled type="hidden" class="invline_taxable" name="invline_taxable[]" value="{{$invline->tax}}" >
                                                        <input disabled type="checkbox" name="" class="taxable-check compute" {{$invline->tax == 1 ? 'checked' : ''}}>
                                                    </td>
                                                    <td class="text-center cursor-pointer"></td>
                                                </tr>
                                            @endforeach
                                        @else                                
                                            <tr class="tr-draggable">
                                                <td class="text-center cursor-move move"><i class="fa fa-th-large colo-mid-dark-gray"></i></td>

                                                <td><input type="text" class="for-datepicker" name="invline_service_date[]"/></td>

                                                <td class="invoice-number-td text-right">1</td>
                                                <td>
                                                    <select class="1111 form-control select-item droplist-item input-sm pull-left" name="invline_item_id[]" >
                                                        @include("member.load_ajax_data.load_product_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td><textarea class="textarea-expand txt-desc" name="invline_description[]"></textarea></td>
                                                <!-- <td><select class="2222 droplist-um select-um" name="invline_um[]"><option class="hidden" value="" /></select></td> -->
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
                                                <td class="text-center cursor-move move" ><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
                                                <td><input type="text" class="datepicker" name="invline_service_date[]"/></td>
                                                <td class="invoice-number-td text-right">2</td>
                                                <td>
                                                    <select class="22222 form-control select-item droplist-item input-sm pull-left" name="invline_item_id[]" >
                                                        @include("member.load_ajax_data.load_product_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td><textarea class="textarea-expand txt-desc" name="invline_description[]"></textarea></td>
                                                <!-- <td><select class="3333 droplist-um select-um" name="invline_um[]"><option class="hidden" value="" /></select></td> -->
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="invline_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="invline_rate[]"/></td>
                                                <td><input class="text-right txt-discount compute" type="text" name="invline_discount[]"/></td>
                                                <td><input class="text-right number-input" type="text" name="invline_discount_remark[]"/></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="invline_amount[]"/></td>
                                                <td class="text-center">
                                                    <input type="hidden" class="invline_taxable" name="invline_taxable[]" value="" >
                                                    <input type="checkbox" name="" class="taxable-check compute" value="checked">
                                                </td>
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
                            <label>Message Displayed on Invoice</label>
                            <textarea {{isset($inv) ? 'disabled' : ''}} class="form-control input-sm textarea-expand" name="inv_message" placeholder="">{{$inv->invoice_message or ''}}</textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea {{isset($inv) ? 'disabled' : ''}} class="form-control input-sm textarea-expand" name="inv_memo" placeholder="">{{$inv->statement_memo or ''}}</textarea>
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
                                            <select class="form-control input-sm ewt-value compute" name="ewt" {{isset($inv) ? 'disabled' : ''}}>  
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
                                            <select class="form-control input-sm compute discount_selection" name="inv_discount_type" {{isset($inv) ? 'disabled' : ''}}>  
                                                <option value="percent" {{isset($inv) ? $inv->discount_type == 'percent' ? 'selected' : '' : ''}}>Discount percentage</option>
                                                <option value="value" {{isset($inv) ? $inv->discount_type == 'fixed' ? 'selected' : '' : ''}}>Discount value</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2  padding-lr-1">
                                            <input {{isset($inv) ? 'disabled' : ''}} class="form-control input-sm text-right number-input discount_txt compute" type="text" name="inv_discount_value" value="{{$inv->discount_amount or ''}}">
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
                                            <select class="form-control input-sm tax_selection compute" name="taxable" {{isset($inv) ? 'disabled' : ''}}>  
                                                <option value="0" {{isset($inv) ? $inv->tax == 0 ? 'selected' : '' : ''}}>No Tax</option>
                                                <option value="1" {{isset($inv) ? $inv->tax == 1 ? 'selected' : '' : ''}}>Vat (12%)</option>
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
                                    <div class="row">
                                        <div class="col-sm-3 col-sm-offset-3  padding-lr-1">
                                            <label>Coupon</label>
                                        </div>
                                        @if(isset($inv))
                                            <div class="col-sm-6  padding-lr-1">
                                                <input type="text" class="form-control input-sm input_coupon" name="coupon_code" value="{{isset($coupon_code) ? $coupon_code : ''}}" disabled>
                                                <input type="hidden" class="form-control input-sm input_coupon_amount" value="{{isset($coupon_amount) ? $coupon_amount : ''}}">
                                                <input type="hidden" class="form-control input-sm input_coupon_type" value="{{isset($coupon_type) ? $coupon_type : ''}}">
                                            </div>
                                        @else
                                            <div class="col-sm-3  padding-lr-1">
                                                <input type="text" class="form-control input-sm input_coupon" name="coupon_code">
                                                <input type="hidden" class="form-control input-sm input_coupon_amount">
                                                <input type="hidden" class="form-control input-sm input_coupon_type">
                                            </div>
                                        @endif
                                        @if(!isset($inv))
                                            <div class="col-sm-3  padding-lr-1">
                                                <button class="check_coupon" type="button">Check</button>
                                                <button class="check_coupon_remove" type="button" style="display:none;">Remove</button>
                                                <div style="max-width: 20px; max-height:20px; display:none;" class="loader-16-gray load_coupon"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="coupon-total">0.00</span>
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
            <td class="text-center cursor-move move" ><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
            <td><input type="text" class="datepicker" name="invline_service_date[]"/></td>
            <td class="invoice-number-td text-right">2</td>
            <td>
                <select class="form-control select-item input-sm pull-left" name="invline_item_id[]" >
                    @include("member.load_ajax_data.load_product_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="textarea-expand txt-desc" name="invline_description[]"></textarea></td>
            <!-- <td><select class="3333 droplist-um select-um" name="invline_um[]"><option class="hidden" value="" /></select></td> -->
            <td><input class="text-center number-input txt-qty compute" type="text" name="invline_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="invline_rate[]"/></td>
            <td><input class="text-right txt-discount compute" type="text" name="invline_discount[]"/></td>
            <td><input class="text-right number-input" type="text" name="invline_discount_remark[]"/></td>
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

@section('css')
<style>
    .btn-custom-white.active, .btn-custom-white.active:hover
    {
        background-color: #106189!important;
        color: white!important;
    }
</style>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
@if(!isset($inv))
<script type="text/javascript" src="/assets/member/js/draggable_row.js"></script>
@endif
<script type="text/javascript" src="/assets/member/js/product_create_order.js"></script>
@endsection