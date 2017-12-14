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
                                <label>Reference Number</label>
                                <input type="text" class="form-control" name="reference_number" value="CM20171214-0002">
                            </div>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select class="form-control droplist-customer input-sm pull-left" name="est_customer_id" data-placeholder="Select a Customer" required>
                                    @include('member.load_ajax_data.load_customer', ['customer_id' => isset($est) ? $est->est_customer_id : (isset($c_id) ? $c_id : '') ]);
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-sm customer-email" name="est_customer_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$est->est_customer_email or ''}}"/>
                            </div>
                        </div>
                    </div>                          
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Billing Address</label>
                            <textarea class="form-control input-sm textarea-expand" name="est_customer_billing_address" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-2">
                            <label>Estimate Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="est_date" value="{{date('m/d/y')}}"/>
                        </div>
                        <div class="col-sm-2">
                            <label>Expiration Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="est_exp_date" value="{{date('m/d/y')}}" />
                        </div>
                    </div>
                    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead>
                                        <tr>
                                            <th style="" ></th>
                                            <th style="" class="text-right">#</th>
                                            <th style="width: 200px">Product/Service</th>
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
                                                <td class="text-center cursor-move move"><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
                                                <td class="invoice-number-td text-right">1</td>
                                                <td>
                                                    <select class="form-control select-item droplist-item input-sm pull-left" name="estline_item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td><textarea class="textarea-expand txt-desc" name="estline_description[]"></textarea></td>
                                                <td><select class="droplist-um select-um" name="estline_um[]"><option class="hidden" value="" /></select></td>
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="estline_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="estline_rate[]"/></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="estline_amount[]"/></td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                                
                                            <tr class="tr-draggable">
                                                <td class="text-center cursor-move move" ><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
                                                <td class="invoice-number-td text-right">2</td>
                                                <td>
                                                    <select class="form-control select-item droplist-item input-sm pull-left" name="estline_item_id[]" >
                                                        @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                        <option class="hidden" value="" />
                                                    </select>
                                                </td>
                                                <td><textarea class="textarea-expand txt-desc" name="estline_description[]"></textarea></td>
                                                <td><select class="droplist-um select-um" name="estline_um[]"><option class="hidden" value="" /></select></td>
                                                <td><input class="text-center number-input txt-qty compute" type="text" name="estline_qty[]"/></td>
                                                <td><input class="text-right number-input txt-rate compute" type="text" name="estline_rate[]"/></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="estline_amount[]"/></td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Message Displayed on Credit Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="est_message" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="est_memo" placeholder=""></textarea>
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
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/accounting_transaction/customer/credit_memo.js"></script>
@endsection